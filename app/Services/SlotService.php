<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\HoldStatus;
use App\Http\Resources\HoldResource;
use App\Http\Resources\SlotResource;
use App\Models\Hold;
use App\Models\Slot;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

final class SlotService
{
    public const CACHE_KEY = 'available_slots';
    private const CACHE_LOCK_KEY = 'lock:available_slots';

    /**
     * @throws LockTimeoutException
     */
    public function getAvailableSlots(): AnonymousResourceCollection
    {
        $slots = Cache::get(self::CACHE_KEY);
        
        if(!$slots) {
            $lock = Cache::lock(self::CACHE_LOCK_KEY, 10);
            
            if ($lock->get()) {
                try {
                    $slots = SlotResource::collection(Slot::all());
                    Cache::put(self::CACHE_KEY, $slots, 15);
                } finally {
                    $lock->release();
                }
            } else {
                $lock->block(5);
                $slots = Cache::get(self::CACHE_KEY);
            }
        }
        
        return SlotResource::collection($slots);
    }

    public function invalidateCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    public function isSlotAvailable(Slot $slot): bool
    {
        return $slot->capacity - $slot->remaining > 1;
    }

    public function createHoldForSlot(Slot $slot): HoldResource
    {
        return new HoldResource(Hold::query()->create([
            'slot_id' => $slot->id,
            'status' => HoldStatus::HELD,
        ]));
    }

    public function confirmHold(Hold $hold): HoldResource
    {
        $hold->update([
            'status' => HoldStatus::CONFIRMED,
        ]);

        $hold->slot->update([
            'remaining' => $hold->slot->remaining > 1 ? $hold->slot->remaining - 1 : 1,
        ]);

        $this->invalidateCache();
        
        return new HoldResource($hold->refresh());
    }

    public function cancelHold(Hold $hold): HoldResource
    {
        $hold->update([
            'status' => HoldStatus::CANCELLED,
        ]);

        $hold->slot->update([
            'remaining' => $hold->slot->remaining < $hold->slot->capacity 
                ? $hold->slot->remaining + 1 
                : $hold->slot->remaining,
        ]);

        $this->invalidateCache();

        return new HoldResource($hold->refresh());
    }
}

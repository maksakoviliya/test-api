<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\HoldStatus;
use App\Http\Resources\HoldResource;
use App\Http\Resources\SlotResource;
use App\Models\Hold;
use App\Models\Slot;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class SlotService
{
    public function getAvailableSlots(): AnonymousResourceCollection
    {
        return SlotResource::collection(Slot::all());
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

        return new HoldResource($hold->refresh());
    }
}

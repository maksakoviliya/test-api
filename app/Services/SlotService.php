<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Resources\SlotResource;
use App\Models\Slot;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class SlotService
{
    public function getAvailableSlots(): AnonymousResourceCollection
    {
        return SlotResource::collection(Slot::all());
    }
}

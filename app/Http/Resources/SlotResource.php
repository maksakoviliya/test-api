<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class SlotResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'slot_id' => $this->resource->id,
            'capacity' => $this->resource->capacity,
            'remaining' => $this->resource->remaining,
        ];
    }
}

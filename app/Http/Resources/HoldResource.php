<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HoldResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'slot' => new SlotResource($this->resource->slot),
            'status' => $this->resource->status,
            'created_at' => $this->resource->created_at->format('d.m.Y H:i'),
        ];
    }
}

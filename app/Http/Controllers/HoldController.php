<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Hold;
use App\Models\Slot;
use App\Services\SlotService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class HoldController extends Controller
{
    public function __construct(
        private SlotService $slotService,
    ) {}

    public function store(Request $request, Slot $slot): JsonResponse
    {
        if (! $this->slotService->isSlotAvailable($slot)) {
            abort(409, 'Conflict');
        }

        return response()->json($this->slotService->createHoldForSlot($slot), 201);
    }

    public function confirm(Hold $hold)
    {
        return response()->json($hold);
    }

    public function delete(Hold $hold)
    {
        return response()->json($hold);
    }
}

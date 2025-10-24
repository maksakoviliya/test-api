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
        private readonly SlotService $slotService,
    ) {}

    public function store(Request $request, Slot $slot): JsonResponse
    {
        return response()->json($this->slotService->createHoldForSlot($request, $slot), 201);
    }

    public function confirm(Hold $hold): JsonResponse
    {
        if (! $this->slotService->isSlotAvailable($hold->slot)) {
            abort(409, 'Conflict');
        }

        return response()->json($this->slotService->confirmHold($hold));
    }

    public function delete(Hold $hold): JsonResponse
    {
        return response()->json($this->slotService->cancelHold($hold));
    }
}

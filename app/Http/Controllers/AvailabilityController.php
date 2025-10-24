<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\SlotService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class AvailabilityController extends Controller
{
    public function __construct(
        private readonly SlotService $slotService,
    ) {}

    public function __invoke(Request $request): AnonymousResourceCollection
    {
        return $this->slotService->getAvailableSlots();
    }
}

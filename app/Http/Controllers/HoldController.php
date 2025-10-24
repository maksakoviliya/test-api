<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Hold;
use App\Models\Slot;
use Illuminate\Http\Request;

final class HoldController extends Controller
{
    public function store(Request $request, Slot $slot)
    {
        return response()->json($slot, 201);
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

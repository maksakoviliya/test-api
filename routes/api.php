<?php

use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\HoldController;
use Illuminate\Support\Facades\Route;

Route::prefix('/slots')
    ->name('slots.')
    ->group(function () {
        Route::get('/availability', AvailabilityController::class)->name('availability');
        Route::post('{slot}/hold', [HoldController::class, 'store'])->name('holds.store');
    });

Route::prefix('/holds')
    ->name('holds.')
    ->group(function () {
        Route::post('/{hold}/confirm', [HoldController::class, 'confirm'])->name('confirm');
        Route::delete('/{hold}', [HoldController::class, 'delete'])->name('delete');
    });

<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\HoldStatus;
use App\Models\Hold;
use App\Models\Slot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Hold>
 */
final class HoldFactory extends Factory
{
    public function definition(): array
    {
        return [
            'slot_id' => Slot::factory(),
            'status' => HoldStatus::HELD,
        ];
    }
}

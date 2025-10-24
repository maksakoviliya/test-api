<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Slot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Slot>
 */
final class SlotFactory extends Factory
{
    public function definition(): array
    {
        return [
            'capacity' => $this->faker->numberBetween(0, 10),
            'remaining' => $this->faker->numberBetween(0, 10),
        ];
    }
}

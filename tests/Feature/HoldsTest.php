<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\HoldStatus;
use App\Models\Hold;
use App\Models\Slot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class HoldsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_confirm_hold(): void
    {
        $hold = Hold::factory()
            ->for(Slot::factory()->state([
                'capacity' => 10,
                'remaining' => 5,
            ]))
            ->create();
        $response = $this->post(route('holds.confirm', [
            'hold' => $hold->id,
        ]));
        $response->assertStatus(200);
        $hold->refresh();
        $this->assertEquals(HoldStatus::CONFIRMED, $hold->status);
        $slot = $hold->slot->refresh();
        $this->assertEquals(4, $slot->remaining);
    }

    public function test_can_not_create_if_unavailable()
    {
        $hold = Hold::factory()
            ->for(Slot::factory()->unavailable())
            ->create();
        $response = $this->post(route('holds.confirm', [
            'hold' => $hold->id,
        ]));
        $response->assertStatus(409);
    }
}

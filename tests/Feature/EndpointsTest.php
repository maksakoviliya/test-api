<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Hold;
use App\Models\Slot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class EndpointsTest extends TestCase
{
    use refreshDatabase;
    use WithFaker;

    public function test_slots_availability_endpoint(): void
    {
        $response = $this->get(route('slots.availability'));
        $response->assertStatus(200);
    }

    public function test_slots_store_hold_endpoint()
    {
        $slot = Slot::factory()->available()->create();
        $response = $this->post(route('slots.holds.store', [
            'slot' => $slot->id,
        ]), [], [
            'Idempotency-Key' => $this->faker->uuid(),
        ]);
        $response->assertStatus(201);
    }

    public function test_confirm_hold_endpoint()
    {
        $hold = Hold::factory()
            ->for(Slot::factory()->available())
            ->create();
        $response = $this->post(route('holds.confirm', [
            'hold' => $hold->id,
        ]));
        $response->assertStatus(200);
    }

    public function test_delete_hold_endpoint()
    {
        $hold = Hold::factory()->create();
        $response = $this->delete(route('holds.delete', [
            'hold' => $hold->id,
        ]));
        $response->assertStatus(200);
    }
}

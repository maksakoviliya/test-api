<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Slot;
use App\Services\SlotService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

final class SlotsTest extends TestCase
{
    use refreshDatabase;

    public function test_slots_availability(): void
    {
        Slot::factory(5)->create();
        $response = $this->get(route('slots.availability'));
        $response->assertStatus(200);
        $this->assertCount(5, $response->json());
    }

    public function test_slots_availability_cache(): void
    {
        $slots = Slot::factory(5)->create();
        Cache::expects('get')
            ->with(SlotService::CACHE_KEY)
            ->andReturn($slots);

        $this->get(route('slots.availability'));
    }

    public function test_can_create_hold(): void
    {
        $slot = Slot::factory()->create([
            'capacity' => 10,
            'remaining' => 0
        ]);
        $response = $this->post(route('slots.holds.store', [
            'slot' => $slot->id,
        ]));
        $response->assertStatus(201)->assertJsonStructure([
            "id",
            "slot" => [
                "id",
                "slot_id",
                "capacity",
                "remaining",
            ],
            "status",
            "created_at",
        ]);
    }
}

<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Slot;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}

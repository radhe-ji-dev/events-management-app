<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Event;
use App\Models\User;

class EventControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function testIndex()
    {
        $events = Event::factory(3)->create();

        $response = $this->actingAs($this->user)
            ->get('/api/events');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function testShow()
    {
        $event = Event::factory()->create();

        $response = $this->actingAs($this->user)
            ->get("/api/events/{$event->id}");

        $response->assertStatus(200)
            ->assertJson(['data' => []]);
    }

    public function testStore()
    {
        $data = [
            'name' => 'Test Event',
            'description' => 'Test description',
            'start_time' => now(),
            'end_time' => now()->addHour(),
        ];

        $response = $this->actingAs($this->user)
            ->post('/api/events', $data);

        $response->assertStatus(201)
            ->assertJson(['data' => []]);

        $this->assertDatabaseHas('events', $data);
    }

    public function testUpdate()
    {
        $event = Event::factory()->create();

        $data = [
            'name' => 'Updated Event Name',
            'description' => 'Updated description',
        ];

        $response = $this->actingAs($this->user)
            ->put("/api/events/{$event->id}", $data);

        $response->assertStatus(200)
            ->assertJson(['data' => []]);

        $this->assertDatabaseHas('events', $data);
    }

    public function testDestroy()
    {
        $event = Event::factory()->create();

        $response = $this->actingAs($this->user)
            ->delete("/api/events/{$event->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }
}

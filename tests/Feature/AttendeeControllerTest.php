<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Event;
use App\Models\Attendee;
use App\Models\User;

class AttendeeControllerTest extends TestCase
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
        $event = Event::factory()->create(['user_id' => $this->user->id]); // Associate the event with the user
        $attendees = Attendee::factory(3)->create(['event_id' => $event->id]);

        $response = $this->get("/api/events/{$event->id}/attendees");

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function testStore()
    {
        $event = Event::factory()->create(['user_id' => $this->user->id]); // Associate the event with the user

        $response = $this->actingAs($this->user)
            ->post("/api/events/{$event->id}/attendees");

        $response->assertStatus(201)
            ->assertJson(['data' => []]);
    }

    public function testShow()
    {
        $event = Event::factory()->create(['user_id' => $this->user->id]); // Associate the event with the user
        $attendee = Attendee::factory()->create(['event_id' => $event->id]);

        $response = $this->get("/api/events/{$event->id}/attendees/{$attendee->id}");

        $response->assertStatus(200)
            ->assertJson(['data' => []]);
    }

    public function testDestroy()
    {
        $event = Event::factory()->create(['user_id' => $this->user->id]); // Associate the event with the user
        $attendee = Attendee::factory()->create(['event_id' => $event->id]);

        $response = $this->actingAs($this->user)
            ->delete("/api/events/{$event->id}/attendees/{$attendee->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('attendees', ['id' => $attendee->id]);
    }
}

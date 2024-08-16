<?php

namespace Tests\Unit;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TripTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('TestToken')->plainTextToken;
    }

    protected function headers()
    {
        return [
            'Authorization' => "Bearer {$this->token}",
            'Accept' => 'application/json',
        ];
    }

    public function test_list_trip()
    {
        Trip::factory()->count(5)->create();
        $response = $this->getJson(route('api.v1.trips.index'), $this->headers());
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'origin',
                        'destination',
                        'start_date',
                        'end_date',
                        'type_of_trip',
                        'description',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
    }

    public function test_store_trip()
    {
        $data = [
            'title' => 'Test Trip',
            'origin' => 'Yogyakarta',
            'destination' => 'Jakarta',
            'start_date' => '2024-08-20',
            'end_date' => '2024-08-25',
            'type_of_trip' => 'multi_day',
            'description' => 'Test Trip Description',
        ];

        $response = $this->postJson(route('api.v1.trips.store'), $data, $this->headers());
        $response->assertStatus(200);
        $this->assertDatabaseHas('trips', $data);
    }

    public function test_show_trip()
    {
        $trip = Trip::factory()->create();
        $response = $this->getJson(route('api.v1.trips.show', $trip->id), $this->headers());
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'title' => $trip->title,
            'origin' => $trip->origin,
            'destination' => $trip->destination,
        ]);
    }

    public function test_update_trip()
    {
        $trip = Trip::factory()->create();
        $updatedData = [
            'title' => 'Test Trip Update',
            'origin' => 'Yogyakarta',
            'destination' => 'Jakarta',
            'start_date' => '2024-08-20',
            'end_date' => '2024-08-25',
            'type_of_trip' => 'multi_day',
            'description' => 'Test Trip Description Update',
        ];
        $response = $this->putJson(route('api.v1.trips.update', $trip->id), $updatedData, $this->headers());
        $response->assertStatus(200);
        $this->assertDatabaseHas('trips', $updatedData);
    }


    public function test_destroy_trip()
    {
        $trip = Trip::factory()->create();
        $response = $this->deleteJson(route('api.v1.trips.update', $trip->id), [], $this->headers());
        $response->assertStatus(200);
        $this->assertDatabaseMissing('trips', ['id' => $trip->id]);
    }
}

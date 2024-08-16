<?php

namespace Tests\Feature;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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


    public function test_full_trip_management_flow_for_authenticated_user()
    {
        $tripData = [
            'title' => 'Test Trip',
            'origin' => 'Yogyakarta',
            'destination' => 'Jakarta',
            'start_date' => '2024-08-20',
            'end_date' => '2024-08-25',
            'type_of_trip' => 'single_day',
            'description' => 'Test Trip Description',
        ];

        $storeResponse = $this->postJson(route('api.v1.trips.store'), $tripData, $this->headers());
        $storeResponse->assertStatus(200);
        $tripId = $storeResponse->json('data.id');

        $showResponse = $this->getJson(route('api.v1.trips.show', $tripId), $this->headers());
        $showResponse->assertStatus(200);
        $showResponse->assertJsonFragment($tripData);

        $updatedData = [
            'title' => 'Test Trip Update',
            'origin' => 'Yogyakarta',
            'destination' => 'Jakarta',
            'start_date' => '2024-08-20',
            'end_date' => '2024-08-25',
            'type_of_trip' => 'single_day',
            'description' => 'Test Trip Description Update',
        ];

        $updateResponse = $this->putJson(route('api.v1.trips.update', $tripId), $updatedData, $this->headers());
        $updateResponse->assertStatus(200);
        $updateResponse->assertJsonFragment($updatedData);

        $showUpdatedResponse = $this->getJson(route('api.v1.trips.show', $tripId), $this->headers());
        $showUpdatedResponse->assertStatus(200);
        $showUpdatedResponse->assertJsonFragment(['description' => 'Test Trip Description Update']);

        $deleteResponse = $this->deleteJson(route('api.v1.trips.destroy', $tripId), [], $this->headers());
        $deleteResponse->assertStatus(200);
        $this->assertDatabaseMissing('trips', ['id' => $tripId]);
    }

    public function test_full_trip_management_flow_for_unauthenticated_user()
    {
        $indexResponse = $this->getJson(route('api.v1.trips.index'));
        $indexResponse->assertStatus(401);

        $storeResponse = $this->postJson(route('api.v1.trips.store'), []);
        $storeResponse->assertStatus(401);

        $trip = Trip::factory()->create();
        $showResponse = $this->getJson(route('api.v1.trips.show', $trip->id));
        $showResponse->assertStatus(401);

        $updateResponse = $this->putJson(route('api.v1.trips.update', $trip->id), []);
        $updateResponse->assertStatus(401);

        $deleteResponse = $this->deleteJson(route('api.v1.trips.destroy', $trip->id));
        $deleteResponse->assertStatus(401);
    }

}

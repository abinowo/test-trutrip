<?php

namespace Database\Factories;

use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppModelsV1Trip>
 */
class TripFactory extends Factory
{
    protected $model = Trip::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'origin' => $this->faker->city,
            'destination' => $this->faker->city,
            'start_date' => $this->faker->dateTimeBetween('+0 days', '+1 week'),
            'end_date' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'type_of_trip' => $this->faker->randomElement(['single_day', 'multi_day']),
            'description' => $this->faker->paragraph,
        ];
    }
}

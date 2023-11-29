<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'detail' => fake()->text(),
            'address' => fake()->address(),
            'key_event' => fake()->randomNumber(3),
            'start_date' => date(today()) ,
            'start_time' => now(),
            'privacity' => random_int(1, 3),
            'user_id' => random_int(1, 5),
        ];
    }
}

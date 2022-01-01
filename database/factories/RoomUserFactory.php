<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoomUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'room_id' => rand(1, 3),
            'rank' => $this->faker->numberBetween(1, 4),
            'points' => $this->faker->randomNumber(4, true),
            'is_host' => $this->faker->boolean(),
            'total_correct' => rand(1, 10),
            'status' => $this->faker->randomElement(['waiting', 'ongoing', 'done']),
        ];
    }
}

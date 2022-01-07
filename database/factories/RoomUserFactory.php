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
            'rank' => $this->faker->numberBetween(1, 2),
            'points' => $this->faker->randomNumber(4, 10),
            'is_host' => $this->faker->boolean(),
            'total_correct' => rand(1, 10),
            'status' => $this->faker->randomElement(['waiting', 'ongoing', 'done']),
        ];
    }
}

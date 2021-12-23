<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserQuestionRoomFactory extends Factory
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
            'question_id' => rand(1, 20),
            'order' => rand(1, 10),
            'point' => $this->faker->randomNumber(4, true),
            'answer_option' => $this->faker->randomElement(['option_1', 'option_2', 'option_3', 'option_4']),
            'status' => $this->faker->randomElement(['waiting', 'ongoing', 'done']),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quiz_id' => rand(1, 3),
            'question' => $this->faker->sentence(15),
            'option_1' => $this->faker->sentence(5),
            'option_2' => $this->faker->sentence(5),
            'option_3' => $this->faker->sentence(5),
            'option_4' => $this->faker->sentence(5),
            'answer' => $this->faker->randomElement(['option_1', 'option_2', 'option_3', 'option_4']),
            'timer' => $this->faker->time('s')
        ];
    }
}

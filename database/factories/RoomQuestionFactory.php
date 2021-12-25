<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Question;
use App\Models\RoomQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'question_id' => rand(1, 10),
            'room_id' => rand(1, 3),
            'order' => rand(1, 10),
            'time_start' =>$this->faker->dateTime(),
            'time_end' => $this->faker->dateTime(),
        ];
    }    
}

<?php

namespace Database\Factories;

use App\Models\Quiz;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Cviebrock\EloquentSluggable\Services\SlugService;

class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->words(3, true);
        return [
            'title' => $title,
            'slug' => Str::slug($title, '-'),
            'image' => $this->faker->words(3, true) .'.jpg',
            'description' => $this->faker->sentence(25),
            'counter' => rand(5, 25),
        ];
    }
}

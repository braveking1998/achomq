<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'unique_id' => fake()->uuid(),
            'text' => fake()->sentence(),
            'status' => 1,
            'level_id' => 1,
            'category_id' => fake()->randomElement([4, 5]),
            'user_id' => 2,
        ];
    }
}

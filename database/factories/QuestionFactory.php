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

    protected static $qId = 51;

    public function definition(): array
    {
        return [
            'id' => self::$qId++,
            'unique_id' => fake()->uuid(),
            'text' => fake()->sentence(),
            'status' => 1,
            'level_id' => 3,
            'category_id' => fake()->randomElement([1, 3]),
            'user_id' => 2,
        ];
    }
}

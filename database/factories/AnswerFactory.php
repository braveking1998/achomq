<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Answer>
 */
class AnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected static $answerId = 481;

    public function definition(): array
    {
        return [
            'id' => self::$answerId++,
            'unique_id' => fake()->uuid(),
            'text' => fake()->sentence(),
        ];
    }
}

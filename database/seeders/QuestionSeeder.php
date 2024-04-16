<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Question::factory(30)
            ->hasAnswers(4, function (array $attributes) {
                return [
                    'is_correct' => ($attributes['id'] - 1) % 4 == 0 ?? false,
                ];
            })
            ->create();
    }
}

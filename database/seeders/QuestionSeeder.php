<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Question::factory(50)
            ->hasAnswers(4, function (array $attributes) {
                return [
                    'is_correct' => ($attributes['id'] - 1) % 4 == 0 ?? false,
                ];
            })
            ->create();
    }
}

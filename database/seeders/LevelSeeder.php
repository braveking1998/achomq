<?php

namespace Database\Seeders;

use App\Models\Level;
use App\Models\LevelPerk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LevelSeeder extends Seeder
{
    private $levels = array(
        ['id' => 1, 'name' => 'تازه وارد', 'slug' => 'fresh', 'max' => '150'],
        ['id' => 2, 'name' => 'نو آموز', 'slug' => 'newbie', 'max' => '500'],
        ['id' => 3, 'name' => 'دانش آموز', 'slug' => 'student', 'max' => '1000'],
        ['id' => 4, 'name' => 'دانشجو', 'slug' => 'trainee', 'max' => '2000'],
        ['id' => 5, 'name' => 'مربی', 'slug' => 'trainer', 'max' => '5000'],
        ['id' => 6, 'name' => 'حرفه ای', 'slug' => 'professional', 'max' => '50000'],
        ['id' => 7, 'name' => 'فوق حرفه ای', 'slug' => 'superstar', 'max' => '100000'],
    );

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->levels as $level) {
            DB::table('levels')->insert($level);

            if ($level['id'] != 7) {
                DB::table('level_perks')->insert([
                    'level_id' => $level['id'],
                    'action' => 'add_question_points',
                    'value' => $level['id'] * 5
                ]);
            }

            DB::table('level_perks')->insert([
                'level_id' => $level['id'],
                'action' => 'add_question_coins',
                'value' => $level['id'] * 5
            ]);
        }
    }
}

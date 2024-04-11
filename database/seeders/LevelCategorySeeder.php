<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelCategorySeeder extends Seeder
{
    protected $level = ['تازه وارد', 'نوآموز', 'دانش آموز', 'دانشجو', 'مربی', 'حرفه ای'];

    protected $level_slug = ['fresh', 'newbie', 'student', 'trainee', 'trainer', 'professional'];

    protected $max = [150, 500, 1000, 2000, 5000, 50000];

    protected $category = ['اطلاعات عمومی', 'ورزشی', 'هوش و ریاضی', 'تاریخ', 'ادبیات', 'بدون دسته بندی'];

    protected $category_slug = ['general_knowledge', 'sports', 'math', 'history', 'listerature', 'default'];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 6; $i++) {
            \App\Models\Level::factory()->create([
                'name' => $this->level[$i],
                'max' => $this->max[$i],
                'slug' => $this->level_slug[$i],
                'add_question' => 10,
            ]);

            \App\Models\Category::factory()->create([
                'name' => $this->category[$i],
                'slug' => $this->category_slug[$i]
            ]);
        }
    }
}

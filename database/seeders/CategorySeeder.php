<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    private $categories = [
        ['id' => 1, 'name' => 'بدون دسته بندی', 'slug' => 'default'],
        ['id' => 2, 'name' => 'اطلاعات عمومی', 'slug' => 'general_knowledge'],
        ['id' => 3, 'name' => 'ورزشی', 'slug' => 'sports'],
        ['id' => 4, 'name' => 'هوش و ریاضی', 'slug' => 'math'],
        ['id' => 5, 'name' => 'تاریخ', 'slug' => 'history'],
        ['id' => 6, 'name' => 'زبان و فرهنگ', 'slug' => 'literature'],
        ['id' => 7, 'name' => 'دینی', 'slug' => 'religion'],
        ['id' => 8, 'name' => 'جغراقیا', 'slug' => 'geography'],
        ['id' => 9, 'name' => 'فیلم شناسی', 'slug' => 'cinema-knowledge'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->categories as $category) {
            DB::table('categories')->insert($category);
        }
    }
}

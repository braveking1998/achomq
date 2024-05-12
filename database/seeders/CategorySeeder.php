<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{

    private $categories = array(
        ['id' => 1, 'name' => 'بدون دسته بندی', 'slug' => 'default'],
        ['id' => 2, 'name' => 'اطلاعات عمومی', 'slug' => 'general_knowledge'],
        ['id' => 3, 'name' => 'ورزشی', 'slug' => 'sports'],
        ['id' => 4, 'name' => 'هوش و ریاضی', 'slug' => 'math'],
        ['id' => 5, 'name' => 'تاریخ', 'slug' => 'history'],
        ['id' => 6, 'name' => 'زبان و فرهنگ', 'slug' => 'literature'],
        ['id' => 6, 'name' => 'دینی', 'slug' => 'religion'],
        ['id' => 6, 'name' => 'جغراقیا', 'slug' => 'geography'],
        ['id' => 6, 'name' => 'فیلم شناسی', 'slug' => 'geography'],
    );

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->categories as $category) {
            Category::factory()->create([
                'id' => $category['id'],
                'name' => $category['name'],
                'slug' => $category['slug']
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MultiTypeSeeder extends Seeder
{

    protected $types = array(
        ['id' => 1, 'name' => 'عادی', 'min_level' => 3, 'cost' => 75, 'coins' => 250, 'points' => 250, 'stars' => 0],
        ['id' => 2, 'name' => 'برنزی', 'min_level' => 5, 'cost' => 150, 'coins' => 500, 'points' => 500, 'stars' => 0],
        ['id' => 3, 'name' => 'نقره ای', 'min_level' => 5, 'cost' => 300, 'coins' => 1000, 'points' => 1000, 'stars' => 0],
        ['id' => 4, 'name' => 'طلایی', 'min_level' => 7, 'cost' => 600, 'coins' => 2000, 'points' => 0, 'stars' => 1],
    );

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->types as $type) {
            DB::table('multi_types')->insert($type);
        }
    }
}

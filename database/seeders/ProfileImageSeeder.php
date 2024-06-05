<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileImageSeeder extends Seeder
{
    public $images = [
        ['id' => 1, 'file_path' => 'images/profile.webp'],
        ['id' => 2, 'file_path' => 'images/man-profile.webp'],
        ['id' => 3, 'file_path' => 'images/woman-profile.webp'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->images as $image) {
            $image['type'] = 'public';
            DB::table('profile_images')->insert($image);
        }
    }
}

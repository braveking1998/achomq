<?php

namespace Database\Seeders;

use App\Models\ProfileImage;
use Illuminate\Database\Seeder;

class ProfileImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProfileImage::factory(1)->create([
            'id' => 1,
            'type' => 'public',
            'file_path' => 'images/profile.webp',
        ]);
    }
}

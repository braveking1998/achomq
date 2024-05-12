<?php

namespace Database\Seeders;

use App\Models\ProfileImage;
use Illuminate\Database\Seeder;

class ProfileImageSeeder extends Seeder
{

    public $images = array(
        ['id' => 1, 'file_path' => 'images/profile.webp'],
        ['id' => 2, 'file_path' => 'images/man-profile.webp'],
        ['id' => 3, 'file_path' => 'images/woman-profile.webp'],
    );
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->images as $image) {
            ProfileImage::factory()->create([
                'id' => $image['id'],
                'type' => 'public',
                'file_path' => $image['file_path'],
            ]);
        }
    }
}

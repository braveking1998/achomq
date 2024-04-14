<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'حریف نامشخص',
            'phone_number' => '09123456789',
            'email' => 'test@example.com',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Braveking',
            'phone_number' => '09370636563',
            'email' => 'bravekingah@gmail.com',
            'is_admin' => 1,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'id' => 1,
            'name' => 'احمد احمدپور',
            'email' => 'bravekingah@gmail.com',
            'phone_number' => '09027777657',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'is_admin' => 1,
        ]);
        \App\Models\User::factory(10)->create();
    }
}

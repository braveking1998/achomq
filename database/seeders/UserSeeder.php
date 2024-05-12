<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'id' => 1,
            'name' => 'حریف نامشخص',
            'email' => 'ahmad.ahmadpour1998@gmail.com',
            'phone_number' => '09370636563',
            'email_verified_at' => now(),
            'password' => Hash::make('ahmedkhonj2klk339023,n,wlkewewe'),
            'remember_token' => Str::random(10),
        ]);
        \App\Models\User::factory()->create([
            'id' => 1,
            'name' => 'احمد احمدپور',
            'email' => 'bravekingah@gmail.com',
            'phone_number' => '09027777657',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        \App\Models\User::factory(10)->create();
    }
}

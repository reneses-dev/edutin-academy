<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin TechCompany',
            'email' => 'test@gmail.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('Administrator');

        User::create([
            'name' => 'Author TechCompany',
            'email' => 'test2@gmail.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('Author');

        User::factory(3)->create();
    }
}

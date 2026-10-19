<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@matcha.com'],
            [
                'name' => 'Admin Matcha',
                'mobile' => '081234567890',
                'utype' => 'ADM',
                'password' => bcrypt('password'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@matcha.com'],
            [
                'name' => 'User Matcha',
                'mobile' => '081234567891',
                'utype' => 'USR',
                'password' => bcrypt('password'),
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'fenthalari@gmail.com'],
            [
                'name' => 'Fentha',
                'password' => \Illuminate\Support\Facades\Hash::make('fenthaq050292'),
                'email_verified_at' => now(),
            ]
        );
    }
}

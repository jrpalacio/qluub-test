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
        // User::factory(10)->create();

        // Usuario admin inicial
        \App\Models\User::create([
            'name' => 'José Reyes',
            'email' => 'jrpalacio.dev@gmail.com',
            'password' => bcrypt('@jRP1270157'),
            'role' => \App\Models\User::ROLE_ADMIN,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tryout;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@tryout.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        // User Dummy
        User::factory()->create([
            'name' => 'Peserta Ujian',
            'email' => 'peserta@tryout.com',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);

        $this->call(TryoutSeeder::class);
    }
}

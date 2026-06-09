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
        User::firstOrCreate(
            ['email' => 'admin@tryout.com'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        // User Dummy
        User::firstOrCreate(
            ['email' => 'peserta@tryout.com'],
            [
                'name' => 'Peserta Ujian',
                'password' => bcrypt('password'),
                'is_admin' => false,
                'email_verified_at' => now(),
            ]
        );

        $this->call(TryoutSeeder::class);
        $this->call(PppkSekolahRakyatSeeder::class);
        $this->call(GuruTeknisSeeder::class);
        $this->call(GuruBahasaIndonesiaSeeder::class);
    }
}

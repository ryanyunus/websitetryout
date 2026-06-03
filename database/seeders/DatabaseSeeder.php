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
        // User Dummy
        User::factory()->create([
            'name' => 'Peserta Ujian',
            'email' => 'peserta@tryout.com',
            'password' => bcrypt('password'),
        ]);

        // Tryout Dummy
        $tryout1 = Tryout::create([
            'title' => 'Tryout CPNS 2026 - Seleksi Kompetensi Dasar',
            'description' => 'Uji kemampuan dasar Anda meliputi Tes Wawasan Kebangsaan, Tes Intelegensia Umum, dan Tes Karakteristik Pribadi.',
            'duration_minutes' => 5,
            'is_active' => true,
        ]);

        $tryout2 = Tryout::create([
            'title' => 'Simulasi UTBK SNBT - Penalaran Umum',
            'description' => 'Latihan soal penalaran umum untuk mempersiapkan diri menghadapi ujian masuk perguruan tinggi negeri.',
            'duration_minutes' => 10,
            'is_active' => true,
        ]);

        // Soal untuk Tryout 1
        $q1 = Question::create([
            'tryout_id' => $tryout1->id,
            'question_text' => 'Berdasarkan UUD 1945 pasal 1 ayat 3, Negara Indonesia adalah negara...',
        ]);
        $q1->options()->createMany([
            ['option_text' => 'Kepulauan', 'is_correct' => false],
            ['option_text' => 'Hukum', 'is_correct' => true],
            ['option_text' => 'Republik', 'is_correct' => false],
            ['option_text' => 'Maritim', 'is_correct' => false],
        ]);

        $q2 = Question::create([
            'tryout_id' => $tryout1->id,
            'question_text' => 'Jika x = 12, dan y = 5, maka nilai dari x^2 - y^2 adalah?',
        ]);
        $q2->options()->createMany([
            ['option_text' => '119', 'is_correct' => true],
            ['option_text' => '144', 'is_correct' => false],
            ['option_text' => '169', 'is_correct' => false],
            ['option_text' => '60', 'is_correct' => false],
        ]);
        
        $q3 = Question::create([
            'tryout_id' => $tryout1->id,
            'question_text' => 'Siapakah presiden ketiga Republik Indonesia?',
        ]);
        $q3->options()->createMany([
            ['option_text' => 'Soeharto', 'is_correct' => false],
            ['option_text' => 'B.J. Habibie', 'is_correct' => true],
            ['option_text' => 'Abdurrahman Wahid', 'is_correct' => false],
            ['option_text' => 'Megawati', 'is_correct' => false],
        ]);
        
        // Soal untuk Tryout 2
        $q4 = Question::create([
            'tryout_id' => $tryout2->id,
            'question_text' => 'Semua mamalia bernapas dengan paru-paru. Paus adalah mamalia. Kesimpulannya?',
        ]);
        $q4->options()->createMany([
            ['option_text' => 'Paus bukan mamalia', 'is_correct' => false],
            ['option_text' => 'Paus bernapas dengan insang', 'is_correct' => false],
            ['option_text' => 'Paus bernapas dengan paru-paru', 'is_correct' => true],
            ['option_text' => 'Semua mamalia adalah paus', 'is_correct' => false],
        ]);
    }
}

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

        // Soal TWK (Tes Wawasan Kebangsaan) - Pancasila
        $q1 = Question::create([
            'tryout_id' => $tryout1->id,
            'question_text' => 'Pancasila sebagai dasar negara Republik Indonesia memiliki makna bahwa...',
        ]);
        $q1->options()->createMany([
            ['option_text' => 'Pancasila merupakan sumber dari segala sumber hukum negara', 'is_correct' => true],
            ['option_text' => 'Pancasila menjadi pedoman mutlak dalam hubungan luar negeri', 'is_correct' => false],
            ['option_text' => 'Pancasila adalah pandangan hidup yang bebas ditafsirkan', 'is_correct' => false],
            ['option_text' => 'Pancasila merupakan alat pemersatu bangsa yang bersifat sementara', 'is_correct' => false],
        ]);

        // Soal TIU (Tes Intelegensia Umum) - Deret Angka
        $q2 = Question::create([
            'tryout_id' => $tryout1->id,
            'question_text' => 'Berapakah angka selanjutnya dari deret berikut: 2, 6, 12, 20, 30, ...',
        ]);
        $q2->options()->createMany([
            ['option_text' => '40', 'is_correct' => false],
            ['option_text' => '42', 'is_correct' => true], // Pola: +4, +6, +8, +10, +12
            ['option_text' => '44', 'is_correct' => false],
            ['option_text' => '46', 'is_correct' => false],
        ]);
        
        // Soal TWK - Sejarah Ketatanegaraan
        $q3 = Question::create([
            'tryout_id' => $tryout1->id,
            'question_text' => 'Sistem pemerintahan yang pernah diterapkan di Indonesia pada kurun waktu 17 Agustus 1950 sampai 5 Juli 1959 adalah...',
        ]);
        $q3->options()->createMany([
            ['option_text' => 'Sistem Pemerintahan Presidensial', 'is_correct' => false],
            ['option_text' => 'Sistem Demokrasi Terpimpin', 'is_correct' => false],
            ['option_text' => 'Sistem Pemerintahan Parlementer', 'is_correct' => true],
            ['option_text' => 'Sistem Republik Serikat', 'is_correct' => false],
        ]);

        // Soal TIU - Hitungan Cepat & Aritmatika Sosial
        $q4 = Question::create([
            'tryout_id' => $tryout1->id,
            'question_text' => 'Sebuah proyek pembangunan jalan dikerjakan oleh 12 orang dan direncanakan selesai dalam waktu 20 hari. Jika proyek tersebut dipaksa harus selesai dalam waktu 15 hari, berapakah TAMBAHAN pekerja yang dibutuhkan?',
        ]);
        $q4->options()->createMany([
            ['option_text' => '3 orang', 'is_correct' => false],
            ['option_text' => '4 orang', 'is_correct' => true], // (12*20)/15 = 16 orang. Tambahan: 16-12 = 4
            ['option_text' => '16 orang', 'is_correct' => false],
            ['option_text' => '8 orang', 'is_correct' => false],
        ]);

        // Soal TIU - Analogi Verbal
        $q5 = Question::create([
            'tryout_id' => $tryout1->id,
            'question_text' => 'KAPAL : PELABUHAN = PESAWAT : ...',
        ]);
        $q5->options()->createMany([
            ['option_text' => 'Penerbangan', 'is_correct' => false],
            ['option_text' => 'Pilot', 'is_correct' => false],
            ['option_text' => 'Bandara', 'is_correct' => true],
            ['option_text' => 'Udara', 'is_correct' => false],
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

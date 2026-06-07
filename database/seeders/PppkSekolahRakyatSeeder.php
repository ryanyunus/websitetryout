<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tryout;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Support\Facades\File;

class PppkSekolahRakyatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('data/pppk_questions.json'));
        $questionsData = json_decode($json, true);

        Tryout::where('title', 'like', 'PPPK Tenaga Kependidikan Sekolah Rakyat 2026%')->delete();

        // 1. Paket Lengkap (Berbayar 50.000)
        $tryoutLengkap = Tryout::create([
            'title' => 'PPPK Tenaga Kependidikan Sekolah Rakyat 2026 (Paket Lengkap)',
            'description' => 'Simulasi Tes Kompetensi PPPK Tendik Sekolah Rakyat 2026. Terdiri dari 145 soal yang terbagi dalam Sesi 1 dan Sesi 2.',
            'duration_minutes' => 130, // 120 mnt Sesi 1 + 10 mnt Sesi 2
            'is_active' => true,
            'category' => 'pppk',
            'is_premium' => true,
            'price' => 50000,
        ]);

        // 2. Paket Terpisah (Gratis)
        $tryoutsTerpisah = [];

        foreach ($questionsData as $qData) {
            // Masukkan ke Paket Lengkap
            $questionLengkap = Question::create([
                'tryout_id' => $tryoutLengkap->id,
                'question_text' => $qData['soal'],
            ]);

            foreach ($qData['opsi'] as $key => $text) {
                $isCorrect = ($key === $qData['jawaban']);
                Option::create([
                    'question_id' => $questionLengkap->id,
                    'option_text' => $text,
                    'is_correct' => $isCorrect,
                    'points' => $isCorrect ? 5 : 0,
                ]);
            }

            // Buat Tryout Terpisah jika belum ada
            $subtes = $qData['subtes'];
            if (!isset($tryoutsTerpisah[$subtes])) {
                $duration = 120;
                if ($subtes === 'Teknis') $duration = 81;
                elseif ($subtes === 'Manajerial') $duration = 22;
                elseif ($subtes === 'Sosial Kultural') $duration = 18;
                elseif ($subtes === 'Wawancara') $duration = 9;
                
                $isPremium = false;
                $price = 0;
                if ($subtes === 'Teknis') {
                    $isPremium = true;
                    $price = 30000;
                } elseif ($subtes === 'Sosial Kultural') {
                    $isPremium = true;
                    $price = 20000;
                }
                
                $tryoutsTerpisah[$subtes] = Tryout::create([
                    'title' => "PPPK Tenaga Kependidikan Sekolah Rakyat 2026 - Subtes {$subtes}",
                    'description' => "Simulasi Tes Kompetensi PPPK Tendik Sekolah Rakyat 2026 untuk subtes {$subtes}." . (!$isPremium ? " (Gratis)" : ""),
                    'duration_minutes' => $duration,
                    'is_active' => true,
                    'category' => 'pppk',
                    'is_premium' => $isPremium,
                    'price' => $price,
                ]);
            }

            // Masukkan ke Paket Terpisah
            $tryoutTerpisah = $tryoutsTerpisah[$subtes];
            $questionTerpisah = Question::create([
                'tryout_id' => $tryoutTerpisah->id,
                'question_text' => $qData['soal'],
            ]);

            foreach ($qData['opsi'] as $key => $text) {
                $isCorrect = ($key === $qData['jawaban']);
                Option::create([
                    'question_id' => $questionTerpisah->id,
                    'option_text' => $text,
                    'is_correct' => $isCorrect,
                    'points' => $isCorrect ? 5 : 0,
                ]);
            }
        }
    }
}

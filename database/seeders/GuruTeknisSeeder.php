<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuruTeknisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus Tryout lama jika ada (agar tidak dobel saat dijalankan ulang)
        \App\Models\Tryout::where('title', 'Kompetensi Teknis Guru')->delete();

        // Buat Paket Tryout
        $tryout = \App\Models\Tryout::create([
            'title' => 'Kompetensi Teknis Guru',
            'description' => 'Simulasi Subtes Kompetensi Teknis Guru PPPK 2026. (Berisi 90 Soal Lengkap)',
            'duration_minutes' => 90, 
            'is_active' => true,
            'category' => 'pppk',
            'is_premium' => true,
            'price' => 30000,
        ]);

        $files = [
            'data/soal_guru_teknis_1_30.json',
            'data/soal_guru_teknis_31_60.json',
            'data/soal_guru_teknis_61_90.json',
        ];

        foreach ($files as $file) {
            $filePath = database_path($file);
            
            if (!\Illuminate\Support\Facades\File::exists($filePath)) {
                $this->command->error("File tidak ditemukan: {$filePath}");
                continue;
            }

            $json = \Illuminate\Support\Facades\File::get($filePath);
            $data = json_decode($json, true);

            // Menyesuaikan dengan nama array di JSON (bisa 'soal', 'soal_31_60', dll)
            $soalArray = $data['soal'] ?? $data['soal_31_60'] ?? $data['soal_61_90'] ?? [];

            foreach ($soalArray as $qData) {
                $question = \App\Models\Question::create([
                    'tryout_id' => $tryout->id,
                    'question_text' => $qData['stimulus'],
                ]);

                foreach ($qData['pilihan'] as $key => $text) {
                    $isCorrect = ($key === $qData['kunci_jawaban']);
                    \App\Models\Option::create([
                        'question_id' => $question->id,
                        'option_text' => $text,
                        'is_correct' => $isCorrect,
                        'points' => $isCorrect ? $qData['nilai'] : 0,
                    ]);
                }
            }
        }
        
        $this->command->info('Paket Kompetensi Teknis Guru (1-90) berhasil dibuat!');
    }
}

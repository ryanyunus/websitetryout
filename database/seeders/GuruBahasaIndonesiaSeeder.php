<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tryout;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Support\Facades\File;

class GuruBahasaIndonesiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = database_path('data/soal_guru_bahasa_indonesia.json');
        
        if (!File::exists($filePath)) {
            $this->command->error("File JSON tidak ditemukan: {$filePath}");
            return;
        }

        $json = File::get($filePath);
        $data = json_decode($json, true);

        // Hapus Tryout lama jika ada agar tidak duplikat
        Tryout::where('title', $data['paket'])->delete();

        // Buat Tryout Baru
        $tryout = Tryout::create([
            'title' => $data['paket'],
            'description' => "Simulasi Tes " . $data['paket'] . ". Terdiri dari " . $data['jumlah_soal'] . " soal pilihan ganda. Referensi: " . $data['referensi'],
            'duration_minutes' => 60, // Asumsi 60 menit untuk 30 soal
            'is_active' => true,
            'category' => 'pppk_guru',
            'is_premium' => false, // Set ke gratis dulu atau sesuaikan nanti
            'price' => 0,
        ]);

        foreach ($data['soal'] as $qData) {
            $question = Question::create([
                'tryout_id' => $tryout->id,
                'question_text' => $qData['soal'],
            ]);

            foreach ($qData['opsi'] as $key => $text) {
                $isCorrect = ($key === $qData['kunci']);
                
                // Menentukan poin berdasarkan bobot jika ada, atau 5 untuk jawaban benar
                $points = 0;
                if ($isCorrect) {
                    $points = isset($qData['bobot']) && $qData['bobot'] !== null ? $qData['bobot'] : 5;
                }

                Option::create([
                    'question_id' => $question->id,
                    'option_text' => $text,
                    'is_correct' => $isCorrect,
                    'points' => $points,
                ]);
            }
        }

        $this->command->info("Paket '{$data['paket']}' berhasil dibuat dengan {$data['jumlah_soal']} soal!");
    }
}

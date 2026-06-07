<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Question;
use App\Models\Tryout;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TryoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = database_path('seeders/soal_cpns.txt');
        if (!File::exists($filePath)) {
            $this->command->error("File tidak ditemukan: {$filePath}");
            return;
        }

        $content = File::get($filePath);

        // Paket 1: Full SKD (110 Soal)
        $tryoutFull = Tryout::updateOrCreate(
            ['title' => 'Paket 1: Full SKD CPNS 2026'],
            [
                'category' => 'full',
                'description' => 'Simulasi 110 Soal Lengkap • TWK – TIU – TKP',
                'duration_minutes' => 100,
                'is_active' => true,
            ]
        );

        // Paket 2: Khusus TWK (30 Soal)
        $tryoutTwk = Tryout::updateOrCreate(
            ['title' => 'Paket 2: Latihan Khusus TWK'],
            [
                'category' => 'topic',
                'description' => 'Latihan 30 Soal Khusus Tes Wawasan Kebangsaan (TWK) secara acak.',
                'duration_minutes' => 30,
                'is_active' => true,
            ]
        );

        // Paket 3: Khusus TIU (35 Soal)
        $tryoutTiu = Tryout::updateOrCreate(
            ['title' => 'Paket 3: Latihan Khusus TIU'],
            [
                'category' => 'topic',
                'description' => 'Latihan 35 Soal Khusus Tes Intelegensia Umum (TIU) secara acak.',
                'duration_minutes' => 35,
                'is_active' => true,
                'is_premium' => true,
                'price' => 20000,
            ]
        );

        // Paket 4: Khusus TKP (45 Soal)
        $tryoutTkp = Tryout::updateOrCreate(
            ['title' => 'Paket 4: Latihan Khusus TKP'],
            [
                'category' => 'topic',
                'description' => 'Latihan 45 Soal Khusus Tes Karakteristik Pribadi (TKP) secara acak.',
                'duration_minutes' => 45,
                'is_active' => true,
            ]
        );

        // Paket 5: Paket Premium
        $tryoutPremium = Tryout::updateOrCreate(
            ['title' => 'Paket 5: Paket Premium SKD CPNS'],
            [
                'category' => 'full',
                'description' => 'Paket Premium Simulasi 110 Soal Lengkap • TWK – TIU – TKP',
                'duration_minutes' => 100,
                'is_active' => true,
                'is_premium' => true,
                'price' => 20000,
            ]
        );

        // Regular expression to extract question number, text, options A-E, and correct key.
        $pattern = '/(\d+)\.\s+(.*?)\s+A\.\s+(.*?)\s+B\.\s+(.*?)\s+C\.\s+(.*?)\s+D\.\s+(.*?)\s+E\.\s+(.*?)\s+✔ Kunci:\s+([A-E])/s';

        preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

        $twkMatches = array_slice($matches, 0, 30);
        $tiuMatches = array_slice($matches, 30, 35);
        $tkpMatches = array_slice($matches, 65, 45);

        // 1. Insert Full SKD (No shuffle, exact order 1-110)
        $this->insertQuestions($tryoutFull, $matches, false);
        $this->command->info('Berhasil mengimport paket Full SKD.');

        // 2. Insert Khusus TWK (Shuffle)
        shuffle($twkMatches);
        $this->insertQuestions($tryoutTwk, $twkMatches, false);
        $this->command->info('Berhasil mengimport paket khusus TWK.');

        // 3. Insert Khusus TIU (Shuffle)
        shuffle($tiuMatches);
        $this->insertQuestions($tryoutTiu, $tiuMatches, false);
        $this->command->info('Berhasil mengimport paket khusus TIU.');

        // 4. Insert Khusus TKP (Shuffle, force TKP scoring)
        shuffle($tkpMatches);
        $this->insertQuestions($tryoutTkp, $tkpMatches, true);
        $this->command->info('Berhasil mengimport paket khusus TKP.');

        // 5. Insert Paket Premium (Shuffle all sections but keep order TWK->TIU->TKP)
        // Re-shuffle to get a different set of premium questions compared to full SKD
        shuffle($twkMatches);
        shuffle($tiuMatches);
        shuffle($tkpMatches);
        $premiumMatches = array_merge($twkMatches, $tiuMatches, $tkpMatches);
        $this->insertQuestions($tryoutPremium, $premiumMatches, false);
        $this->command->info('Berhasil mengimport paket Premium.');
    }

    private function insertQuestions($tryout, $matches, $forceTkp = false)
    {
        $qNumber = 1;
        foreach ($matches as $match) {
            $originalNumber = (int)$match[1];
            $questionText = trim($match[2]);
            $options = [
                'A' => trim($match[3]),
                'B' => trim($match[4]),
                'C' => trim($match[5]),
                'D' => trim($match[6]),
                'E' => trim($match[7]),
            ];
            $correctKey = trim($match[8]);

            $question = Question::create([
                'tryout_id' => $tryout->id,
                // Replace the original number with the new sequence number
                'question_text' => $qNumber . '. ' . $questionText,
            ]);

            $isTkp = $forceTkp || $originalNumber >= 66;

            foreach ($options as $key => $optionText) {
                $isCorrect = ($key === $correctKey);
                // For TKP, the best answer gets 5 points, others get 0 because we don't have the full points breakdown in the text.
                // For non-TKP, correct is 5 points, wrong is 0.
                $points = $isCorrect ? 5 : 0;

                Option::create([
                    'question_id' => $question->id,
                    'option_text' => $key . '. ' . $optionText,
                    'is_correct' => $isCorrect,
                    'points' => $points,
                ]);
            }
            $qNumber++;
        }
    }
}

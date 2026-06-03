<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tryout;
use App\Models\TryoutAttempt;
use App\Models\AttemptAnswer;
use Illuminate\Support\Facades\Auth;

class TryoutController extends Controller
{
    /**
     * Tampilkan daftar tryout yang tersedia
     */
    public function index()
    {
        $tryouts = Tryout::where('is_active', true)->get();
        return view('tryout.index', compact('tryouts'));
    }

    /**
     * Tampilkan detail tryout sebelum mulai
     */
    public function show(Tryout $tryout)
    {
        return view('tryout.show', compact('tryout'));
    }

    /**
     * Memulai sesi ujian
     */
    public function start(Request $request, Tryout $tryout)
    {
        // Buat sesi pengerjaan baru
        $attempt = TryoutAttempt::create([
            'user_id' => Auth::id(),
            'tryout_id' => $tryout->id,
            'started_at' => now(),
            'score' => null,
        ]);

        return redirect()->route('tryout.exam', ['tryout' => $tryout->id, 'attempt' => $attempt->id]);
    }

    /**
     * Halaman ujian berlangsung
     */
    public function exam(Tryout $tryout, TryoutAttempt $attempt)
    {
        // Pastikan attempt milik user dan belum selesai
        if ($attempt->user_id !== Auth::id() || $attempt->completed_at !== null) {
            return redirect()->route('tryout.index')->with('error', 'Sesi ujian tidak valid atau sudah selesai.');
        }

        // Ambil soal beserta pilihan gandanya
        $questions = $tryout->questions()->with('options')->get();
        
        return view('tryout.exam', compact('tryout', 'attempt', 'questions'));
    }

    /**
     * Menyimpan jawaban yang disubmit
     */
    public function submit(Request $request, Tryout $tryout, TryoutAttempt $attempt)
    {
        if ($attempt->user_id !== Auth::id() || $attempt->completed_at !== null) {
            return redirect()->route('tryout.index')->with('error', 'Sesi ujian tidak valid atau sudah selesai.');
        }

        $answers = $request->input('answers', []); // format: [question_id => option_id]
        
        $correctAnswers = 0;
        $totalQuestions = $tryout->questions()->count();

        foreach ($answers as $questionId => $optionId) {
            AttemptAnswer::create([
                'tryout_attempt_id' => $attempt->id,
                'question_id' => $questionId,
                'option_id' => $optionId,
            ]);

            // Cek apakah jawaban benar
            $isCorrect = \App\Models\Option::where('id', $optionId)->where('is_correct', true)->exists();
            if ($isCorrect) {
                $correctAnswers++;
            }
        }

        // Hitung skor akhir (skala 100)
        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;

        $attempt->update([
            'completed_at' => now(),
            'score' => $score
        ]);

        return redirect()->route('tryout.result', ['tryout' => $tryout->id, 'attempt' => $attempt->id]);
    }

    /**
     * Tampilkan hasil ujian
     */
    public function result(Tryout $tryout, TryoutAttempt $attempt)
    {
        if ($attempt->user_id !== Auth::id()) {
            abort(403);
        }

        return view('tryout.result', compact('tryout', 'attempt'));
    }
}

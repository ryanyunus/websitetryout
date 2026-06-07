<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tryout;
use App\Models\TryoutAttempt;
use App\Models\AttemptAnswer;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;

class TryoutController extends Controller
{
    /**
     * Tampilkan daftar tryout yang tersedia
     */
    public function index(Request $request)
    {
        $category = $request->query('category', 'full');
        $tryouts = Tryout::where('is_active', true)
                         ->where('category', $category)
                         ->get();
                         
        if ($category === 'topic') {
            $pageTitle = 'Latihan per Topik';
        } elseif ($category === 'pppk') {
            $pageTitle = 'PPPK Sekolah Rakyat 2026';
        } else {
            $pageTitle = 'Paket Full SKD';
        }

        return view('tryout.index', compact('tryouts', 'category', 'pageTitle'));
    }

    /**
     * Tampilkan detail tryout sebelum mulai
     */
    public function show(Tryout $tryout)
    {
        $hasAccess = true;
        if ($tryout->is_premium) {
            $hasAccess = Transaction::where('user_id', Auth::id())
                ->where('tryout_id', $tryout->id)
                ->where('status', 'success')
                ->exists();
        }

        return view('tryout.show', compact('tryout', 'hasAccess'));
    }

    /**
     * Halaman Checkout Dummy
     */
    public function checkout(Tryout $tryout)
    {
        if (!$tryout->is_premium) {
            return redirect()->route('tryout.show', $tryout);
        }

        $transaction = Transaction::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'tryout_id' => $tryout->id,
                'status' => 'pending',
            ],
            [
                'order_id' => 'TRX-' . time() . '-' . Str::random(5),
                'amount' => $tryout->price,
            ]
        );

        if (!$transaction->snap_token) {
            Config::$serverKey = config('services.midtrans.server_key');
            Config::$isProduction = config('services.midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            // Fix cURL SSL certificate issue for local Windows development
            if (!Config::$isProduction) {
                Config::$curlOptions = [
                    \CURLOPT_SSL_VERIFYPEER => false,
                    \CURLOPT_SSL_VERIFYHOST => 0,
                    \CURLOPT_HTTPHEADER => []
                ];
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $transaction->order_id,
                    'gross_amount' => $transaction->amount,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ],
            ];

            try {
                $snapToken = Snap::getSnapToken($params);
                $transaction->update(['snap_token' => $snapToken]);
            } catch (\Exception $e) {
                return redirect()->route('tryout.show', $tryout)->with('error', 'Gagal terhubung ke Midtrans. Periksa kunci API Anda. Error: ' . $e->getMessage());
            }
        }

        return view('tryout.checkout', compact('tryout', 'transaction'));
    }

    /**
     * Endpoint Webhook Midtrans
     */
    public function notification(Request $request)
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');

        try {
            $notif = new \Midtrans\Notification();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid notification'], 400);
        }

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        $trx = Transaction::where('order_id', $order_id)->first();
        if (!$trx) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $trx->update(['status' => 'pending']);
                } else {
                    $trx->update(['status' => 'success']);
                }
            }
        } else if ($transaction == 'settlement') {
            $trx->update(['status' => 'success']);
        } else if ($transaction == 'pending') {
            $trx->update(['status' => 'pending']);
        } else if ($transaction == 'deny') {
            $trx->update(['status' => 'failed']);
        } else if ($transaction == 'expire') {
            $trx->update(['status' => 'failed']);
        } else if ($transaction == 'cancel') {
            $trx->update(['status' => 'failed']);
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Memproses callback redirect setelah sukses bayar
     */
    public function processPayment(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        // We check the DB. If webhook hasn't arrived, status might still be pending.
        // Midtrans typically redirects here quickly, so webhook might be slightly delayed.
        // For good UX, we just redirect back to the tryout. The DB will update via webhook.
        return redirect()->route('tryout.show', $transaction->tryout_id)
            ->with('success', 'Silakan tunggu beberapa saat hingga pembayaran Anda terverifikasi.');
    }

    /**
     * Memulai sesi ujian
     */
    public function start(Request $request, Tryout $tryout)
    {
        // Pengecekan Akses Premium
        if ($tryout->is_premium) {
            $hasAccess = Transaction::where('user_id', Auth::id())
                ->where('tryout_id', $tryout->id)
                ->where('status', 'success')
                ->exists();
            
            if (!$hasAccess) {
                return redirect()->route('tryout.checkout', $tryout)->with('error', 'Silakan selesaikan pembayaran terlebih dahulu.');
            }
        }

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
        
        $totalScore = 0;

        foreach ($answers as $questionId => $optionId) {
            AttemptAnswer::create([
                'tryout_attempt_id' => $attempt->id,
                'question_id' => $questionId,
                'option_id' => $optionId,
            ]);

            // Ambil poin dari opsi yang dipilih
            $option = \App\Models\Option::find($optionId);
            if ($option) {
                $totalScore += $option->points;
            }
        }

        $attempt->update([
            'completed_at' => now(),
            'score' => $totalScore
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

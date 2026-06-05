<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Tryout;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::where('is_admin', false)->count();
        $totalTransactions = Transaction::where('status', 'success')->count();
        $totalRevenue = Transaction::where('status', 'success')->sum('amount');
        $totalTryouts = Tryout::count();

        return view('admin.dashboard', compact('totalUsers', 'totalTransactions', 'totalRevenue', 'totalTryouts'));
    }

    public function users()
    {
        $users = User::where('is_admin', false)->latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function transactions()
    {
        $transactions = Transaction::with(['user', 'tryout'])->latest()->paginate(10);
        return view('admin.transactions', compact('transactions'));
    }

    public function tryouts()
    {
        $tryouts = Tryout::withCount('questions')->latest()->paginate(10);
        return view('admin.tryouts', compact('tryouts'));
    }

    public function toggleTryout(Tryout $tryout)
    {
        $tryout->update(['is_active' => !$tryout->is_active]);
        return back()->with('success', 'Status Tryout berhasil diubah.');
    }

    public function updatePrice(Request $request, Tryout $tryout)
    {
        $request->validate(['price' => 'required|numeric|min:0']);
        $tryout->update(['price' => $request->price]);
        return back()->with('success', 'Harga Tryout berhasil diperbarui.');
    }
}

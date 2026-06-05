<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <!-- Total Users -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-medium uppercase">Total Peserta</div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalUsers }}</div>
                </div>

                <!-- Total Tryouts -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-medium uppercase">Total Paket Soal</div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalTryouts }}</div>
                </div>

                <!-- Total Transactions -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-medium uppercase">Transaksi Sukses</div>
                    <div class="text-3xl font-bold text-green-600 mt-2">{{ $totalTransactions }}</div>
                </div>

                <!-- Total Revenue -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-medium uppercase">Total Pendapatan</div>
                    <div class="text-3xl font-bold text-blue-600 mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6">
                <p class="text-gray-900 dark:text-gray-100">Selamat datang di Panel Admin! Gunakan navigasi di atas untuk mengelola peserta, riwayat transaksi, dan paket ujian.</p>
            </div>
        </div>
    </div>
</x-admin-layout>

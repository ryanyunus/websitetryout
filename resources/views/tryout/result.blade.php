<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Hasil Tryout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl rounded-3xl">
                <div class="p-8 sm:p-12 text-center">
                    
                    <div class="mb-8">
                        @if ($attempt->score >= 70)
                            <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">Luar Biasa!</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-2">Anda telah menyelesaikan {{ $tryout->title }} dengan sangat baik.</p>
                        @else
                            <div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-12 h-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">Tetap Semangat!</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-2">Jangan menyerah, terus berlatih untuk hasil yang lebih baik di {{ $tryout->title }}.</p>
                        @endif
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-900/50 rounded-3xl p-8 mb-8 inline-block min-w-[300px]">
                        <span class="block text-sm text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-2">Nilai Akhir Anda</span>
                        <div class="text-7xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-purple-600">
                            {{ $attempt->score }}
                        </div>
                        <span class="block text-sm text-gray-500 dark:text-gray-400 mt-2">Skala {{ $maxScore }}</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-md mx-auto mb-6 text-left">
                        <div class="bg-white dark:bg-gray-800 p-4 border border-gray-100 dark:border-gray-700 rounded-xl shadow-sm">
                            <span class="block text-sm text-gray-500 dark:text-gray-400">Waktu Mulai</span>
                            <span class="block font-semibold text-gray-900 dark:text-white">{{ $attempt->started_at->format('H:i, d M Y') }}</span>
                        </div>
                        <div class="bg-white dark:bg-gray-800 p-4 border border-gray-100 dark:border-gray-700 rounded-xl shadow-sm">
                            <span class="block text-sm text-gray-500 dark:text-gray-400">Waktu Selesai</span>
                            <span class="block font-semibold text-gray-900 dark:text-white">{{ $attempt->completed_at->format('H:i, d M Y') }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 max-w-lg mx-auto mb-8">
                        <div class="bg-green-50 border border-green-200 dark:bg-green-900/30 dark:border-green-800 p-4 rounded-xl shadow-sm text-center">
                            <span class="block text-3xl font-bold text-green-600 dark:text-green-400">{{ $correctAnswers }}</span>
                            <span class="block text-sm text-green-800 dark:text-green-300 font-medium">Benar</span>
                        </div>
                        <div class="bg-red-50 border border-red-200 dark:bg-red-900/30 dark:border-red-800 p-4 rounded-xl shadow-sm text-center">
                            <span class="block text-3xl font-bold text-red-600 dark:text-red-400">{{ $wrongAnswers }}</span>
                            <span class="block text-sm text-red-800 dark:text-red-300 font-medium">Salah</span>
                        </div>
                        <div class="bg-gray-50 border border-gray-200 dark:bg-gray-800 dark:border-gray-700 p-4 rounded-xl shadow-sm text-center">
                            <span class="block text-3xl font-bold text-gray-600 dark:text-gray-400">{{ $unanswered }}</span>
                            <span class="block text-sm text-gray-800 dark:text-gray-300 font-medium">Kosong</span>
                        </div>
                    </div>

                    <div>
                        <a href="{{ route('tryout.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-blue-900 dark:text-blue-200 dark:hover:bg-blue-800 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali ke Daftar Tryout
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Tryout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Error messages -->
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl rounded-3xl">
                <div class="p-8 sm:p-12 border-b border-gray-200 dark:border-gray-700 text-center">
                    <h1 class="text-3xl sm:text-5xl font-extrabold text-gray-900 dark:text-white mb-4">
                        {{ $tryout->title }}
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto">
                        {{ $tryout->description }}
                    </p>
                    
                    <div class="grid grid-cols-2 gap-4 max-w-md mx-auto mb-8">
                        <div class="bg-blue-50 dark:bg-blue-900/30 p-4 rounded-2xl">
                            <svg class="w-8 h-8 mx-auto text-blue-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="block text-sm text-gray-500 dark:text-gray-400">Durasi Waktu</span>
                            <span class="block text-xl font-bold text-gray-900 dark:text-white">{{ $tryout->duration_minutes }} Menit</span>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900/30 p-4 rounded-2xl">
                            <svg class="w-8 h-8 mx-auto text-purple-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            <span class="block text-sm text-gray-500 dark:text-gray-400">Total Soal</span>
                            <span class="block text-xl font-bold text-gray-900 dark:text-white">{{ $tryout->questions()->count() }} Soal</span>
                        </div>
                    </div>

                    @if($tryout->is_premium && !$hasAccess)
                        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 mb-8 text-center">
                            <h3 class="text-xl font-bold text-yellow-800 mb-2">Paket Premium Berbayar</h3>
                            <p class="text-yellow-700 mb-4">Anda perlu melakukan pembayaran sebesar <strong>Rp {{ number_format($tryout->price, 0, ',', '.') }}</strong> untuk mengakses paket ini.</p>
                            <a href="{{ route('tryout.checkout', $tryout->id) }}" class="inline-flex justify-center items-center px-8 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 border border-transparent rounded-full font-bold text-lg text-white uppercase tracking-widest hover:from-yellow-600 hover:to-yellow-700 focus:outline-none focus:ring-4 focus:ring-yellow-500/50 shadow-lg shadow-yellow-500/30 transform transition hover:-translate-y-1">
                                Beli Sekarang via QRIS
                                <svg class="ml-3 -mr-1 w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </a>
                        </div>
                    @else
                        <form action="{{ route('tryout.start', $tryout->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex justify-center items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-700 border border-transparent rounded-full font-bold text-lg text-white uppercase tracking-widest hover:from-blue-700 hover:to-indigo-800 focus:outline-none focus:ring-4 focus:ring-indigo-500/50 shadow-lg shadow-indigo-500/30 transform transition hover:-translate-y-1">
                                Mulai Kerjakan Sekarang
                                <svg class="ml-3 -mr-1 w-6 h-6 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

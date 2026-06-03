<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tryout Online') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 text-center">
                <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600">
                    Uji Kemampuanmu Sekarang!
                </h1>
                <p class="mt-4 text-gray-600 dark:text-gray-400">Pilih tryout yang tersedia dan lihat seberapa jauh persiapanmu.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($tryouts as $tryout)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 rounded-2xl border border-gray-100 dark:border-gray-700 transform hover:-translate-y-2">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-900">
                                    {{ $tryout->duration_minutes }} Menit
                                </span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $tryout->questions()->count() }} Soal
                                </span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $tryout->title }}</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-6 line-clamp-3">
                                {{ $tryout->description }}
                            </p>
                            
                            <a href="{{ route('tryout.show', $tryout->id) }}" class="inline-flex justify-center w-full items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:from-blue-600 hover:to-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Mulai Tryout
                                <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 bg-white dark:bg-gray-800 rounded-2xl shadow">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Belum ada Tryout</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Silakan kembali lagi nanti.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>

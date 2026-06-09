<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __($pageTitle) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10 text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-purple-600 mb-4">
                    {{ $pageTitle }}
                </h1>
                <p class="mt-2 text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Silakan pilih jalur formasi yang Anda tuju untuk melihat paket Tryout yang sesuai.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto px-4 sm:px-0">
                <!-- Card PPPK Guru -->
                <a href="{{ route('tryout.index', ['category' => 'pppk_guru']) }}" class="group relative flex flex-col h-full overflow-hidden rounded-3xl bg-white dark:bg-gray-800 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 dark:border-gray-700">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-purple-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="p-8 md:p-12 text-center relative z-10 flex flex-col items-center flex-grow w-full">
                        <div class="w-24 h-24 mb-6 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform duration-500">
                            <!-- Education/Teacher Icon -->
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                            </svg>
                        </div>
                        
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            PPPK GURU
                        </h3>
                        
                        <p class="text-gray-600 dark:text-gray-300 text-lg mb-8 flex-grow">
                            Paket Tryout khusus untuk formasi Guru. Materi mencakup Kompetensi Teknis, Manajerial, Sosial Kultural, dan Wawancara.
                        </p>
                        
                        <div class="mt-auto w-full">
                            <span class="inline-flex w-full justify-center items-center px-8 py-4 bg-blue-500 text-white font-bold text-lg rounded-full group-hover:bg-blue-600 transition-colors duration-300 shadow-md group-hover:shadow-lg">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                Lihat Tryout
                            </span>
                        </div>
                    </div>
                </a>

                <!-- Card PPPK Tenaga Kependidikan -->
                <a href="{{ route('tryout.index', ['category' => 'pppk_tendik']) }}" class="group relative flex flex-col h-full overflow-hidden rounded-3xl bg-white dark:bg-gray-800 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 dark:border-gray-700">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-purple-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="p-8 md:p-12 text-center relative z-10 flex flex-col items-center flex-grow w-full">
                        <div class="w-24 h-24 mb-6 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform duration-500">
                            <!-- Staff/Briefcase Icon -->
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            PPPK Tenaga Kependidikan
                        </h3>
                        
                        <p class="text-gray-600 dark:text-gray-300 text-lg mb-8 flex-grow">
                            Paket Tryout khusus untuk formasi Tenaga Kependidikan. Materi mencakup Kompetensi Teknis, Manajerial, Sosial Kultural, dan Wawancara.
                        </p>
                        
                        <div class="mt-auto w-full">
                            <span class="inline-flex w-full justify-center items-center px-8 py-4 bg-blue-500 text-white font-bold text-lg rounded-full group-hover:bg-blue-600 transition-colors duration-300 shadow-md group-hover:shadow-lg">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                Lihat Tryout
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

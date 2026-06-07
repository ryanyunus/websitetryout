<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __($pageTitle) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-col md:flex-row justify-between items-center">
                <div class="text-left mb-4 md:mb-0">
                    <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600">
                        {{ $pageTitle }}
                    </h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Pilih tryout yang tersedia dan lihat seberapa jauh persiapanmu.</p>
                </div>
                
                <div class="inline-flex shadow-sm rounded-md" role="group">
                    <button type="button" data-filter="all" class="filter-btn bg-blue-600 text-white border-blue-600 px-4 py-2 text-sm font-medium border rounded-l-lg transition-colors duration-200">
                        Semua
                    </button>
                    <button type="button" data-filter="free" class="filter-btn bg-white text-gray-700 border-t border-b border-gray-200 hover:bg-gray-50 hover:text-blue-600 px-4 py-2 text-sm font-medium transition-colors duration-200">
                        Gratis
                    </button>
                    <button type="button" data-filter="premium" class="filter-btn bg-white text-gray-700 border border-gray-200 hover:bg-gray-50 hover:text-blue-600 px-4 py-2 text-sm font-medium rounded-r-lg transition-colors duration-200">
                        Premium
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="tryout-container">
                @forelse ($tryouts as $tryout)
                    <div data-premium="{{ $tryout->is_premium ? 'true' : 'false' }}" class="tryout-card bg-white dark:bg-gray-800 overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 rounded-2xl border border-gray-100 dark:border-gray-700 transform hover:-translate-y-2">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-900">
                                    {{ $tryout->duration_minutes }} Menit
                                </span>
                                @if($tryout->is_premium)
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2.5 py-0.5 rounded flex items-center shadow-sm">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        Premium (Rp {{ number_format($tryout->price, 0, ',', '.') }})
                                    </span>
                                @else
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $tryout->questions()->count() }} Soal
                                    </span>
                                @endif
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $tryout->title }}</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-6 line-clamp-3">
                                {{ $tryout->description }}
                            </p>
                            
                            <a href="{{ route('tryout.show', $tryout->id) }}" class="inline-flex justify-center w-full items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:from-blue-600 hover:to-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 shadow">
                                @if($tryout->is_premium)
                                    Buka Paket Premium
                                @else
                                    Mulai Tryout
                                @endif
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterBtns = document.querySelectorAll('.filter-btn');
            const tryoutCards = document.querySelectorAll('.tryout-card');

            filterBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    // Update active state of buttons
                    filterBtns.forEach(b => {
                        b.classList.remove('bg-blue-600', 'text-white', 'border-blue-600');
                        b.classList.add('bg-white', 'text-gray-700', 'hover:bg-gray-50', 'hover:text-blue-600');
                    });
                    btn.classList.add('bg-blue-600', 'text-white', 'border-blue-600');
                    btn.classList.remove('bg-white', 'text-gray-700', 'hover:bg-gray-50', 'hover:text-blue-600');

                    const filter = btn.dataset.filter;

                    // Update cards
                    tryoutCards.forEach(card => {
                        const isPremium = card.dataset.premium === 'true';
                        if (filter === 'all') {
                            card.style.display = '';
                        } else if (filter === 'free' && !isPremium) {
                            card.style.display = '';
                        } else if (filter === 'premium' && isPremium) {
                            card.style.display = '';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>

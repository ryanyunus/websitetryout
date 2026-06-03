<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $tryout->title }}
            </h2>
            <div class="flex items-center space-x-2 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400 px-4 py-2 rounded-lg font-mono text-xl font-bold shadow-sm">
                <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span id="countdown">Loading...</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
            
            <!-- Area Soal -->
            <div class="md:w-3/4">
                <form id="examForm" action="{{ route('tryout.submit', ['tryout' => $tryout->id, 'attempt' => $attempt->id]) }}" method="POST">
                    @csrf
                    
                    @foreach ($questions as $index => $question)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl mb-6 border border-gray-100 dark:border-gray-700" id="question-{{ $index + 1 }}">
                            <div class="p-6 sm:p-8">
                                <div class="flex items-start mb-6">
                                    <span class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 text-blue-600 font-bold text-lg mr-4">
                                        {{ $index + 1 }}
                                    </span>
                                    <div class="text-lg font-medium text-gray-900 dark:text-white leading-relaxed">
                                        {{ $question->question_text }}
                                    </div>
                                </div>
                                
                                <div class="space-y-3 pl-14">
                                    @foreach ($question->options as $option)
                                        <label class="relative flex items-center p-4 cursor-pointer rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">
                                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600" onclick="markAnswered({{ $index + 1 }})">
                                            <span class="ml-3 text-gray-700 dark:text-gray-300 text-base">
                                                {{ $option->option_text }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="flex justify-end mb-10">
                        <button type="button" onclick="confirmSubmit()" class="px-8 py-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl shadow-lg transition transform hover:-translate-y-1">
                            Kumpulkan Jawaban
                        </button>
                    </div>
                </form>
            </div>

            <!-- Sidebar Navigasi Soal -->
            <div class="md:w-1/4">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 sticky top-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Navigasi Soal</h3>
                    <div class="grid grid-cols-5 gap-2">
                        @foreach ($questions as $index => $question)
                            <a href="#question-{{ $index + 1 }}" id="nav-btn-{{ $index + 1 }}" class="nav-btn flex items-center justify-center w-10 h-10 rounded-lg border-2 border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 font-semibold hover:border-blue-500 hover:text-blue-500 transition-colors">
                                {{ $index + 1 }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Script Timer dan Logika Interaktif -->
    <script>
        // Set waktu berakhir
        const durationMinutes = {{ $tryout->duration_minutes }};
        const startedAt = new Date("{{ $attempt->started_at->toIso8601String() }}").getTime();
        const endTime = startedAt + (durationMinutes * 60 * 1000);

        const countdownElement = document.getElementById('countdown');
        const examForm = document.getElementById('examForm');

        const timerInterval = setInterval(function() {
            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance < 0) {
                clearInterval(timerInterval);
                countdownElement.innerHTML = "Waktu Habis!";
                countdownElement.classList.add('text-red-600', 'animate-bounce');
                // Auto submit
                examForm.submit();
                return;
            }

            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            let timeStr = "";
            if (hours > 0) timeStr += (hours < 10 ? "0" : "") + hours + ":";
            timeStr += (minutes < 10 ? "0" : "") + minutes + ":";
            timeStr += (seconds < 10 ? "0" : "") + seconds;

            countdownElement.innerHTML = timeStr;
        }, 1000);

        function confirmSubmit() {
            if(confirm("Apakah Anda yakin ingin mengumpulkan jawaban sekarang?")) {
                examForm.submit();
            }
        }

        // Tandai nomor navigasi ketika dijawab
        function markAnswered(index) {
            const btn = document.getElementById('nav-btn-' + index);
            if(btn) {
                btn.classList.remove('border-gray-200', 'text-gray-600', 'dark:border-gray-700', 'dark:text-gray-400');
                btn.classList.add('bg-blue-600', 'text-white', 'border-blue-600', 'shadow-md');
            }
        }
    </script>
</x-app-layout>

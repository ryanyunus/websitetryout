<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $tryout->title }} - Simulasi CAT</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Sembunyikan scrollbar tapi tetap bisa scroll */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="bg-[#f0f2f5] font-sans text-gray-900 antialiased selection:bg-sky-500 selection:text-white flex flex-col h-screen overflow-hidden">

    <!-- Top Bar -->
    <header class="bg-sky-500 text-white flex items-center justify-between px-6 py-4 flex-shrink-0 z-10 border-b border-sky-600 shadow-sm">
        <div class="flex flex-col w-1/4">
            <h1 class="text-xl font-bold tracking-wider">Simulasi CAT SKD CPNS</h1>
            <span class="text-sm text-sky-100 mt-1">Peserta: {{ Auth::user()->name }}</span>
        </div>
        
        <div class="w-2/4 flex flex-col items-center">
            <div class="w-full max-w-xl bg-sky-700/40 rounded-full h-3.5 mt-1 overflow-hidden relative border border-sky-400/30">
                <div id="progressBar" class="bg-gradient-to-r from-sky-200 to-white h-full rounded-full transition-all duration-500" style="width: 0%"></div>
            </div>
            <span class="text-xs mt-2 text-sky-50 font-semibold tracking-widest" id="progressText">0 / {{ count($questions) }}</span>
        </div>

        <div class="w-1/4 flex justify-end">
            <div class="bg-sky-600/50 px-6 py-2.5 rounded-full flex items-center space-x-3 border border-sky-400/30 shadow-inner">
                <svg class="w-5 h-5 text-sky-100 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span id="countdown" class="font-mono text-xl font-bold tracking-widest text-white shadow-sm">--:--:--</span>
            </div>
        </div>
    </header>

    <!-- Main Workspace -->
    <div class="flex flex-1 overflow-hidden">
        
        <!-- Sidebar Navigation -->
        <aside class="w-80 bg-purple-500 border-r border-purple-600 flex flex-col z-0 shadow-lg flex-shrink-0">
            <div class="p-5 border-b border-purple-600 bg-purple-600/30">
                <button type="button" onclick="confirmSubmit()" class="w-full bg-[#c82333] hover:bg-red-800 text-white font-bold py-3.5 px-4 rounded shadow transition duration-200 flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Selesaikan Ujian</span>
                </button>
            </div>
            
            <div class="p-5 flex-1 overflow-y-auto no-scrollbar">
                <div class="flex items-center space-x-2 mb-5">
                    <svg class="w-5 h-5 text-purple-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    <h3 class="font-bold text-white tracking-wide text-sm uppercase">Navigasi Soal</h3>
                </div>
                
                <div class="grid grid-cols-5 gap-2.5">
                    @foreach ($questions as $index => $question)
                        <button type="button" id="nav-btn-{{ $index + 1 }}" onclick="goToQuestion({{ $index + 1 }})" class="nav-btn w-full aspect-square rounded shadow-sm border border-purple-300 text-sm font-bold flex items-center justify-center hover:bg-purple-50 transition-colors bg-white text-purple-800">
                            {{ $index + 1 }}
                        </button>
                    @endforeach
                </div>
                
                <!-- Legend -->
                <div class="mt-10 p-4 bg-purple-600/40 rounded-lg space-y-3 text-sm text-white border border-purple-400/30">
                    <div class="flex items-center font-medium"><div class="w-4 h-4 rounded-sm bg-purple-800 border border-purple-900 shadow-sm mr-3"></div> Sudah Dijawab</div>
                    <div class="flex items-center font-medium"><div class="w-4 h-4 rounded-sm bg-[#ffc107] border border-yellow-600 shadow-sm mr-3"></div> Soal Aktif</div>
                    <div class="flex items-center font-medium"><div class="w-4 h-4 rounded-sm bg-white border border-purple-300 mr-3"></div> Belum Dijawab</div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto relative no-scrollbar bg-[#f0f9ff]">
            <form id="examForm" action="{{ route('tryout.submit', ['tryout' => $tryout->id, 'attempt' => $attempt->id]) }}" method="POST" class="h-full flex flex-col pt-8 pb-12 px-10">
                @csrf
                
                <div class="max-w-4xl w-full mx-auto flex-1">
                    @foreach ($questions as $index => $question)
                        @php
                            $qNum = $index + 1;
                            $category = "";
                            $categoryColor = "";
                            if($qNum <= 30) { $category = "Tes Wawasan Kebangsaan (TWK)"; $categoryColor = "bg-sky-500"; }
                            elseif($qNum <= 65) { $category = "Tes Intelegensia Umum (TIU)"; $categoryColor = "bg-sky-500"; }
                            else { $category = "Tes Karakteristik Pribadi (TKP)"; $categoryColor = "bg-sky-500"; }
                        @endphp
                        
                        <div id="question-{{ $qNum }}" class="question-container hidden">
                            <div class="flex items-center mb-4">
                                <h2 class="text-2xl font-semibold text-gray-800">Soal {{ $qNum }} dari {{ count($questions) }}</h2>
                            </div>
                            <div class="mb-8">
                                <span class="inline-block {{ $categoryColor }} text-white text-xs font-bold px-3 py-1.5 rounded shadow-sm">
                                    {{ $category }}
                                </span>
                            </div>
                            
                            <!-- Box Soal -->
                            <div class="bg-white rounded-xl border border-sky-100 mb-8 flex overflow-hidden shadow-sm">
                                <div class="w-1.5 bg-sky-400 flex-shrink-0"></div>
                                <div class="p-8 text-gray-800 text-[1.1rem] leading-loose w-full font-medium" style="user-select: none;">
                                    {!! nl2br(e(preg_replace('/^\d+\.\s*/', '', $question->question_text))) !!}
                                </div>
                            </div>
                            
                            <!-- Box Opsi Jawaban -->
                            <div class="space-y-4">
                                @foreach ($question->options as $option)
                                    @php 
                                        $label = substr($option->option_text, 0, 1);
                                        $text = substr($option->option_text, 3);
                                    @endphp
                                    <label class="option-label-{{ $qNum }} relative flex items-center p-5 cursor-pointer rounded-lg border border-gray-200 bg-white hover:border-sky-300 transition-all group shadow-sm hover:shadow">
                                        <!-- Custom Radio Style -->
                                        <div class="flex items-center justify-center w-8 h-8 rounded-full border-2 border-gray-300 mr-5 flex-shrink-0 bg-white text-gray-600 font-bold radio-custom-indicator transition-colors">
                                            {{ $label }}
                                        </div>
                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" class="hidden peer" onchange="markAnswered({{ $qNum }})">
                                        <span class="text-gray-700 text-lg">
                                            {{ $text }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Bottom Action Bar -->
                <div class="max-w-4xl mx-auto w-full mt-12 flex justify-between items-center border-t border-sky-100 pt-6">
                    <div>
                        <button type="button" onclick="nextQuestion()" class="px-6 py-3 bg-sky-500 hover:bg-sky-600 text-white font-bold rounded flex items-center space-x-2 transition-colors shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            <span>Simpan dan Lanjutkan</span>
                        </button>
                    </div>
                    <div>
                        <button type="button" onclick="skipQuestion()" class="px-6 py-3 border border-red-400 text-red-500 hover:bg-red-50 hover:border-red-500 hover:text-red-600 font-bold rounded flex items-center space-x-2 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                            <span>Lewatkan</span>
                        </button>
                    </div>
                </div>

            </form>
        </main>
    </div>

    <!-- Script Logika Simulasi -->
    <script>
        const totalQuestions = {{ count($questions) }};
        let currentQuestion = 1;
        let answeredCount = 0;

        // Prevent Right Click
        document.addEventListener('contextmenu', event => event.preventDefault());

        // Init
        document.addEventListener('DOMContentLoaded', () => {
            // Cek jika ada state jawaban yang tersimpan (misal refresh)
            countAnswered();
            showQuestion(1);
        });

        function showQuestion(num) {
            // Hide all
            document.querySelectorAll('.question-container').forEach(el => el.classList.add('hidden'));
            
            // Show target
            const target = document.getElementById('question-' + num);
            if(target) {
                target.classList.remove('hidden');
            }

            // Update nav buttons
            for(let i = 1; i <= totalQuestions; i++) {
                const btn = document.getElementById('nav-btn-' + i);
                const isAnswered = document.querySelector(`.option-label-${i} input:checked`);
                
                // Reset styles
                btn.classList.remove('bg-[#ffc107]', 'border-[#ffc107]', 'bg-purple-800', 'border-purple-800', 'bg-white', 'text-white', 'text-purple-800', 'border-purple-300', 'border-yellow-600');
                
                if (i === num) {
                    // Active (Yellow)
                    btn.classList.add('bg-[#ffc107]', 'text-white', 'border-[#ffc107]');
                } else if (isAnswered) {
                    // Answered (Dark Purple)
                    btn.classList.add('bg-purple-800', 'text-white', 'border-purple-800');
                } else {
                    // Unanswered (White)
                    btn.classList.add('bg-white', 'text-purple-800', 'border-purple-300');
                }
            }

            currentQuestion = num;
            updateOptionStyles(num);
            
            // Scroll to top of main content
            document.querySelector('main').scrollTo({top: 0, behavior: 'smooth'});
        }

        function goToQuestion(num) {
            showQuestion(num);
        }

        function nextQuestion() {
            if(currentQuestion < totalQuestions) {
                showQuestion(currentQuestion + 1);
            } else {
                confirmSubmit();
            }
        }
        
        function skipQuestion() {
            if(currentQuestion < totalQuestions) {
                showQuestion(currentQuestion + 1);
            }
        }

        function markAnswered(num) {
            updateOptionStyles(num);
            countAnswered();
            updateProgress();
        }

        function updateOptionStyles(num) {
            // Reset all options for this question
            document.querySelectorAll(`.option-label-${num}`).forEach(label => {
                label.classList.remove('border-sky-400', 'bg-sky-50');
                label.classList.add('border-gray-200', 'bg-white');
                const indicator = label.querySelector('.radio-custom-indicator');
                indicator.classList.remove('bg-sky-500', 'text-white', 'border-sky-500');
                indicator.classList.add('bg-white', 'text-gray-600', 'border-gray-300');
            });

            // Highlight checked option
            const checkedInput = document.querySelector(`.option-label-${num} input:checked`);
            if(checkedInput) {
                const checkedLabel = checkedInput.closest('label');
                checkedLabel.classList.remove('border-gray-200', 'bg-white');
                checkedLabel.classList.add('border-sky-400', 'bg-sky-50');
                
                const indicator = checkedLabel.querySelector('.radio-custom-indicator');
                indicator.classList.remove('bg-white', 'text-gray-600', 'border-gray-300');
                indicator.classList.add('bg-sky-500', 'text-white', 'border-sky-500');
            }
        }

        function countAnswered() {
            let count = 0;
            for(let i = 1; i <= totalQuestions; i++) {
                if(document.querySelector(`.option-label-${i} input:checked`)) {
                    count++;
                }
            }
            answeredCount = count;
            updateProgress();
        }

        function updateProgress() {
            const percentage = (answeredCount / totalQuestions) * 100;
            document.getElementById('progressBar').style.width = percentage + '%';
            document.getElementById('progressText').innerText = answeredCount + ' / ' + totalQuestions;
        }

        function confirmSubmit() {
            let msg = "Apakah Anda yakin ingin menyelesaikan ujian sekarang?";
            if(answeredCount < totalQuestions) {
                msg = `Anda masih memiliki ${totalQuestions - answeredCount} soal yang belum dijawab. Yakin ingin mengakhiri ujian?`;
            }
            
            if(confirm(msg)) {
                document.getElementById('examForm').submit();
            }
        }

        // Timer Logic
        const durationMinutes = {{ $tryout->duration_minutes }};
        const startedAt = new Date("{{ $attempt->started_at->toIso8601String() }}").getTime();
        const endTime = startedAt + (durationMinutes * 60 * 1000);
        const countdownElement = document.getElementById('countdown');

        const timerInterval = setInterval(function() {
            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance < 0) {
                clearInterval(timerInterval);
                countdownElement.innerHTML = "00:00:00";
                countdownElement.classList.add('text-red-400');
                alert("Waktu ujian telah habis! Jawaban Anda akan disubmit secara otomatis.");
                document.getElementById('examForm').submit();
                return;
            }

            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            let timeStr = "";
            timeStr += (hours < 10 ? "0" : "") + hours + ":";
            timeStr += (minutes < 10 ? "0" : "") + minutes + ":";
            timeStr += (seconds < 10 ? "0" : "") + seconds;

            countdownElement.innerHTML = timeStr;
            
            // Warning if less than 5 minutes
            if (distance < 300000) { 
                countdownElement.classList.add('text-red-300');
            }
        }, 1000);
        
    </script>
</body>
</html>

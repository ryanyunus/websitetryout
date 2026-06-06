<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-white text-xl md:text-2xl font-extrabold tracking-wider drop-shadow-md mb-2" />
            <x-text-input id="email" class="block mt-2 w-full bg-white/10 border border-white/30 text-white font-bold placeholder-white/70 focus:border-white focus:ring-2 focus:ring-white/50 focus:bg-white/20 rounded-xl text-2xl md:text-3xl py-4 md:py-5 px-5 transition-all shadow-lg backdrop-blur-md" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="contoh@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300 font-bold text-lg" />
        </div>

        <!-- Password -->
        <div class="mt-6">
            <x-input-label for="password" :value="__('Password')" class="text-white text-xl md:text-2xl font-extrabold tracking-wider drop-shadow-md mb-2" />

            <x-text-input id="password" class="block mt-2 w-full bg-white/10 border border-white/30 text-white font-bold placeholder-white/70 focus:border-white focus:ring-2 focus:ring-white/50 focus:bg-white/20 rounded-xl text-2xl md:text-3xl py-4 md:py-5 px-5 transition-all shadow-lg backdrop-blur-md"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300 font-bold text-lg" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-5">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded bg-white/10 border-white/30 text-indigo-500 shadow-sm focus:ring-indigo-500 focus:ring-offset-0 w-5 h-5 transition-colors cursor-pointer" name="remember">
                <span class="ms-3 text-base text-gray-300 group-hover:text-white transition-colors">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex flex-col space-y-4 mt-8">
            <x-primary-button class="w-full justify-center py-3 text-base">
                {{ __('Log in') }}
            </x-primary-button>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="w-full inline-flex justify-center items-center px-4 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Belum punya akun? Daftar
                </a>
            @endif

            @if (Route::has('password.request'))
                <div class="text-center mt-2">
                    <a class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 focus:outline-none focus:underline transition duration-150 ease-in-out" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                </div>
            @endif
        </div>
    </form>
</x-guest-layout>

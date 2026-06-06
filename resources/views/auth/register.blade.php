<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-white text-xl md:text-2xl font-extrabold tracking-wider drop-shadow-md mb-2" />
            <x-text-input id="name" class="block mt-2 w-full bg-white/10 border border-white/30 text-white font-bold placeholder-white/70 focus:border-white focus:ring-2 focus:ring-white/50 focus:bg-white/20 rounded-xl text-2xl md:text-3xl py-4 md:py-5 px-5 transition-all shadow-lg backdrop-blur-md" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama Lengkap" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-300 font-bold text-lg" />
        </div>

        <!-- Email Address -->
        <div class="mt-6">
            <x-input-label for="email" :value="__('Email')" class="text-white text-xl md:text-2xl font-extrabold tracking-wider drop-shadow-md mb-2" />
            <x-text-input id="email" class="block mt-2 w-full bg-white/10 border border-white/30 text-white font-bold placeholder-white/70 focus:border-white focus:ring-2 focus:ring-white/50 focus:bg-white/20 rounded-xl text-2xl md:text-3xl py-4 md:py-5 px-5 transition-all shadow-lg backdrop-blur-md" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="contoh@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300 font-bold text-lg" />
        </div>

        <!-- Password -->
        <div class="mt-6">
            <x-input-label for="password" :value="__('Password')" class="text-white text-xl md:text-2xl font-extrabold tracking-wider drop-shadow-md mb-2" />

            <x-text-input id="password" class="block mt-2 w-full bg-white/10 border border-white/30 text-white font-bold placeholder-white/70 focus:border-white focus:ring-2 focus:ring-white/50 focus:bg-white/20 rounded-xl text-2xl md:text-3xl py-4 md:py-5 px-5 transition-all shadow-lg backdrop-blur-md"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300 font-bold text-lg" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-6">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-white text-xl md:text-2xl font-extrabold tracking-wider drop-shadow-md mb-2" />

            <x-text-input id="password_confirmation" class="block mt-2 w-full bg-white/10 border border-white/30 text-white font-bold placeholder-white/70 focus:border-white focus:ring-2 focus:ring-white/50 focus:bg-white/20 rounded-xl text-2xl md:text-3xl py-4 md:py-5 px-5 transition-all shadow-lg backdrop-blur-md"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-300 font-bold text-lg" />
        </div>

        <div class="flex flex-col space-y-4 mt-8">
            <x-primary-button class="w-full justify-center py-3 text-base">
                {{ __('Register') }}
            </x-primary-button>

            <a href="{{ route('login') }}" class="w-full inline-flex justify-center items-center px-4 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                Sudah punya akun? Log in
            </a>
        </div>
    </form>
</x-guest-layout>

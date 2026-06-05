<x-app-layout>
    @php
        $snapUrl = config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js';
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pembayaran Paket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl rounded-3xl">
                <div class="p-8 sm:p-12 text-center">
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2">
                        Pembayaran Tryout
                    </h1>
                    <p class="text-gray-500 mb-8">Selesaikan pembayaran Anda menggunakan QRIS, Transfer Bank, atau E-Wallet pilihan Anda.</p>
                    
                    <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-2xl p-8 max-w-sm mx-auto mb-8">
                        <h2 class="text-xl font-bold mb-2">{{ $tryout->title }}</h2>
                        <span class="block text-sm text-gray-500 mb-1">Total Tagihan</span>
                        <span class="block text-3xl font-extrabold text-gray-900">Rp {{ number_format($tryout->price, 0, ',', '.') }}</span>
                    </div>

                    <!-- Tombol Midtrans Snap -->
                    <div class="mt-8">
                        <button id="pay-button" class="inline-flex justify-center items-center px-8 py-3 bg-blue-600 border border-transparent rounded-full font-bold text-lg text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/50 shadow-lg shadow-blue-500/30 transform transition hover:-translate-y-1 w-full sm:w-auto">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Bayar Sekarang
                        </button>
                    </div>
                    
                    <div class="mt-6">
                        <a href="{{ route('tryout.show', $tryout->id) }}" class="text-gray-500 hover:text-gray-700 underline text-sm">Kembali ke detail paket</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Midtrans -->
    <script src="{{ $snapUrl }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script type="text/javascript">
      document.getElementById('pay-button').onclick = function(){
        // SnapToken acquired from previous step
        var snapToken = "{{ $transaction->snap_token }}";
        if (!snapToken) {
            alert('Gagal mendapatkan token pembayaran. Silakan refresh halaman.');
            return;
        }

        snap.pay(snapToken, {
          // Optional
          onSuccess: function(result){
            window.location.href = "{{ route('tryout.payment', $transaction->id) }}";
          },
          // Optional
          onPending: function(result){
            window.location.href = "{{ route('tryout.payment', $transaction->id) }}";
          },
          // Optional
          onError: function(result){
            alert('Pembayaran gagal!');
          }
        });
      };
    </script>
</x-app-layout>

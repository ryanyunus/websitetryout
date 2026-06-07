<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Tryout Saya') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body {
                margin: 0;
                min-height: 100vh;
                background-color: #0f172a; /* fallback */
            }
            .auth-container {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 2rem 1rem;
                gap: 0.25rem;
            }
            .auth-logo-wrapper {
                display: flex;
                justify-content: center;
                align-items: center;
                margin-bottom: 0;
            }
            .auth-logo-wrapper img {
                filter: drop-shadow(0 4px 12px rgba(0,0,0,0.3));
                transition: transform 0.4s ease;
            }
            .auth-logo-wrapper:hover img {
                transform: scale(1.05);
            }
            .auth-card {
                width: 100%;
                max-width: 420px;
                background: rgba(255, 255, 255, 0.05);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border-radius: 1.5rem;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
                padding: 2.5rem;
                border: 1px solid rgba(255, 255, 255, 0.08);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased relative">
        <!-- Vanta Background Container -->
        <div id="vanta-bg" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: -1;"></div>
        
        <div class="auth-container relative z-10">
            <div class="auth-logo-wrapper">
                <a href="/">
                    <img src="{{ asset('images/logo_transparent.png') }}"
                         alt="{{ config('app.name') }}"
                         style="width: 380px; height: auto; object-fit: contain; display: block;">
                </a>
            </div>

            <div class="auth-card">
                {{ $slot }}
            </div>
        </div>

        <!-- Vanta.js Scripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.waves.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                VANTA.WAVES({
                    el: "#vanta-bg",
                    mouseControls: true,
                    touchControls: true,
                    gyroControls: false,
                    minHeight: 200.00,
                    minWidth: 200.00,
                    scale: 1.00,
                    scaleMobile: 1.00,
                    color: 0x1e1b4b, /* Dark purple matching previous theme */
                    shininess: 45.00,
                    waveHeight: 15.00,
                    waveSpeed: 0.70,
                    zoom: 0.85
                })
            });
        </script>
    </body>
</html>

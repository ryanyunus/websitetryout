<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body {
                background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%);
                background-attachment: fixed;
                margin: 0;
                min-height: 100vh;
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
    <body class="font-sans text-gray-900 antialiased">
        <div class="auth-container">
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
    </body>
</html>

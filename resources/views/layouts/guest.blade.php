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
            /* Custom Premium Auth Design */
            body {
                background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
                background-attachment: fixed;
                margin: 0;
            }
            .auth-container {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 2rem 1rem;
            }
            .auth-card {
                width: 100%;
                max-width: 420px;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border-radius: 1.5rem;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
                padding: 2.5rem;
                margin-top: 2rem;
                border: 1px solid rgba(255, 255, 255, 0.4);
                transition: all 0.3s ease;
            }
            .auth-card:hover {
                box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
            }
            .auth-logo-wrapper svg {
                width: 90px;
                height: 90px;
                fill: white;
                filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
                transition: transform 0.5s ease;
            }
            .auth-logo-wrapper:hover svg {
                transform: scale(1.05) rotate(5deg);
            }
            /* Dark mode tweaks */
            @media (prefers-color-scheme: dark) {
                body {
                    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
                }
                .auth-card {
                    background: rgba(15, 23, 42, 0.85);
                    border: 1px solid rgba(255, 255, 255, 0.05);
                    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
                }
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="auth-container">
            <div class="auth-logo-wrapper">
                <a href="/">
                    <x-application-logo />
                </a>
            </div>

            <div class="auth-card">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>

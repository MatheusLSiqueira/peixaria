<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Peixaria') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800">
        <div class="flex flex-col items-center justify-center min-h-screen px-4">

            {{-- Logo --}}
            <div class="mb-8">
                <a href="/" class="flex items-center gap-3 text-white">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-2xl">
                        🐟
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">Peixaria</h1>
                        <p class="text-blue-200 text-sm">Frescos do Mar</p>
                    </div>
                </a>
            </div>

            {{-- Form Container --}}
            <div class="w-full max-w-md">
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    {{ $slot }}
                </div>

                {{-- Footer --}}
                <div class="text-center mt-6">
                    <p class="text-blue-200 text-sm">
                        © {{ date('Y') }} Peixaria - Todos os direitos reservados
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

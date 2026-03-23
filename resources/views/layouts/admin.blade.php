<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') – Peixaria do Litoral</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex">

{{-- Sidebar --}}
<aside class="w-64 bg-blue-950 text-white min-h-screen flex flex-col fixed top-0 left-0 z-50">
    <div class="p-6 border-b border-blue-800">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <span class="text-2xl">🐟</span>
            <div>
                <p class="font-display text-lg leading-tight">Peixaria</p>
                <p class="text-xs text-blue-300 tracking-widest">ADMIN PANEL</p>
            </div>
        </a>
    </div>

    <nav class="flex-1 p-4 space-y-1">
        @php
            $navItem = fn($route, $icon, $label) =>
                '<a href="' . route($route) . '" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition ' .
                (request()->routeIs($route . '*') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800 hover:text-white') .
                '">' . $icon . ' ' . $label . '</a>';
        @endphp

        {!! $navItem('admin.dashboard', '📊', 'Dashboard') !!}
        {!! $navItem('admin.orders', '📦', 'Pedidos') !!}
        {!! $navItem('admin.products.index', '🐟', 'Produtos') !!}
        {!! $navItem('admin.customers', '👥', 'Clientes') !!}
        {!! $navItem('admin.reports', '📈', 'Relatórios') !!}

        <div class="pt-4 border-t border-blue-800 mt-4">
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-blue-200 hover:bg-blue-800 hover:text-white transition">
                🌐 Ver Loja
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-blue-200 hover:bg-red-800 hover:text-white transition w-full text-left mt-1">
                    🚪 Sair
                </button>
            </form>
        </div>
    </nav>

    <div class="p-4 border-t border-blue-800">
        <p class="text-xs text-blue-400">Logado como</p>
        <p class="text-sm text-blue-200 font-medium">{{ auth()->user()->name }}</p>
    </div>
</aside>

{{-- Content --}}
<div class="ml-64 flex-1 flex flex-col min-h-screen">
    {{-- Top Bar --}}
    <header class="bg-white border-b border-slate-200 px-8 py-4 flex items-center justify-between">
        <h1 class="font-semibold text-slate-800 text-lg">@yield('page-title', 'Dashboard')</h1>
        <span class="text-sm text-slate-400">{{ now()->format('d/m/Y H:i') }}</span>
    </header>

    {{-- Flash --}}
    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 px-6 py-3 text-sm">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-6 py-3 text-sm">❌ {{ session('error') }}</div>
    @endif

    <main class="flex-1 p-8">
        @yield('content')
    </main>
</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>

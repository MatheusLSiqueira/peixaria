<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Peixaria do Litoral') – Frescos do Mar</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

{{-- ── NAVBAR ────────────────────────────────────────────── --}}
<header class="bg-blue-950 text-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <span class="text-3xl">🐟</span>
                <div>
                    <p class="font-display text-xl text-white leading-tight">Peixaria do Litoral</p>
                    <p class="text-xs text-blue-300 tracking-widest uppercase">Frescos do Mar</p>
                </div>
            </a>

            {{-- Nav Links --}}
            <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                <a href="{{ route('home') }}" class="text-blue-200 hover:text-white transition">Início</a>
                <a href="{{ route('products.index') }}" class="text-blue-200 hover:text-white transition">Catálogo</a>
                <a href="{{ route('products.index') }}?category=peixe" class="text-blue-200 hover:text-white transition">Peixes</a>
                <a href="{{ route('products.index') }}?category=fruto_do_mar" class="text-blue-200 hover:text-white transition">Frutos do Mar</a>
            </nav>

            {{-- Actions --}}
            <div class="flex items-center gap-3">
                {{-- Carrinho --}}
                <a href="{{ route('cart.index') }}" class="relative flex items-center gap-2 bg-blue-800 hover:bg-blue-700 px-3 py-2 rounded-lg text-sm font-medium transition">
                    🛒
                    @php $cartCount = array_sum(array_column(session('cart', []), 'quantity')) @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 bg-amber-400 text-blue-950 text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">
                            {{ $cartCount }}
                        </span>
                    @endif
                    <span class="hidden sm:inline">Carrinho</span>
                </a>

                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 bg-blue-800 hover:bg-blue-700 px-3 py-2 rounded-lg text-sm font-medium transition">
                            👤 {{ Str::limit(auth()->user()->name, 12) }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl py-2 text-slate-700 text-sm z-50">
                            <a href="{{ route('orders.index') }}" class="flex items-center gap-2 px-4 py-2 hover:bg-slate-50">📦 Meus Pedidos</a>
                            @if(auth()->user()->isAdmin())
                                <hr class="my-1">
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 hover:bg-slate-50 text-blue-700 font-semibold">⚙️ Painel Admin</a>
                            @endif
                            <hr class="my-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 px-4 py-2 hover:bg-slate-50 w-full text-left text-red-600">🚪 Sair</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-blue-200 hover:text-white text-sm font-medium transition">Entrar</a>
                    <a href="{{ route('register') }}" class="bg-amber-400 hover:bg-amber-300 text-blue-950 text-sm font-semibold px-4 py-2 rounded-lg transition">Cadastrar</a>
                @endauth
            </div>
        </div>
    </div>
</header>

{{-- ── FLASH MESSAGES ─────────────────────────────────────── --}}
@if(session('success'))
    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 px-4 py-3 text-sm flex items-center gap-2">
        ✅ {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 text-sm flex items-center gap-2">
        ❌ {{ session('error') }}
    </div>
@endif

{{-- ── MAIN CONTENT ──────────────────────────────────────── --}}
<main class="flex-1">
    @yield('content')
</main>

{{-- ── FOOTER ────────────────────────────────────────────── --}}
<footer class="bg-blue-950 text-blue-200 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="font-display text-white text-xl mb-3">🐟 Peixaria do Litoral</h3>
                <p class="text-sm leading-relaxed">Peixes e frutos do mar frescos, direto do litoral paranaense para a sua mesa.</p>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3">Links Rápidos</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('products.index') }}" class="hover:text-white transition">Catálogo</a></li>
                    <li><a href="{{ route('cart.index') }}" class="hover:text-white transition">Carrinho</a></li>
                    <li><a href="{{ route('orders.index') }}" class="hover:text-white transition">Meus Pedidos</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3">Contato</h4>
                <ul class="space-y-2 text-sm">
                    <li>📍 Matinhos - PR</li>
                    <li>📞 (41) 9999-0000</li>
                    <li>✉️ contato@peixaria.com</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-blue-800 mt-8 pt-6 text-center text-xs text-blue-400">
            © {{ date('Y') }} Peixaria do Litoral. Todos os direitos reservados.
        </div>
    </div>
</footer>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>

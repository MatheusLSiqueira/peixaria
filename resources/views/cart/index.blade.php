@extends('layouts.app')

@section('title', 'Meu Carrinho')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <h1 class="font-display text-3xl text-white mb-8">🛒 Meu Carrinho</h1>

    @if(empty($products))
        <div class="text-center py-24 bg-white rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-6xl mb-4">🛒</p>
            <p class="text-xl font-medium text-slate-600 mb-2">Seu carrinho está vazio</p>
            <p class="text-slate-400 mb-6">Explore nosso catálogo e adicione produtos frescos!</p>
            <a href="{{ route('products.index') }}" class="bg-blue-900 hover:bg-blue-800 text-white font-semibold px-6 py-3 rounded-xl transition">
                Ver Catálogo
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Items --}}
            <div class="lg:col-span-2 space-y-4">
                @foreach($products as $item)
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex gap-4 items-center">

                        {{-- Image --}}
                        <div class="w-20 h-20 rounded-xl overflow-hidden bg-blue-50 flex-none flex items-center justify-center">
                            @if($item['product']->image)
                                <img src="{{ asset('storage/' . $item['product']->image) }}" alt="{{ $item['product']->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-3xl">{{ $item['product']->category === 'peixe' ? '🐟' : '🦐' }}</span>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-slate-800 truncate">{{ $item['product']->name }}</p>
                            <p class="text-sm text-slate-500">{{ $item['product']->formatted_price }} / un.</p>
                        </div>

                        {{-- Quantity --}}
                        <form method="POST" action="{{ route('cart.update', $item['product']) }}" class="flex items-center gap-2">
                            @csrf @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                   min="1" max="{{ $item['product']->stock }}"
                                   class="w-16 text-center border border-slate-200 rounded-lg py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                                   onchange="this.form.submit()">
                        </form>

                        {{-- Subtotal --}}
                        <div class="text-right min-w-[80px]">
                            <p class="font-bold text-blue-900">R$ {{ number_format($item['subtotal'], 2, ',', '.') }}</p>
                        </div>

                        {{-- Remove --}}
                        <form method="POST" action="{{ route('cart.remove', $item['product']) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-600 transition text-lg" title="Remover">✕</button>
                        </form>
                    </div>
                @endforeach

                <div class="flex justify-end">
                    <form method="POST" action="{{ route('cart.clear') }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-sm text-slate-400 hover:text-red-500 transition">🗑 Esvaziar carrinho</button>
                    </form>
                </div>
            </div>

            {{-- Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sticky top-24">
                    <h2 class="font-semibold text-lg text-slate-800 mb-4">Resumo do Pedido</h2>

                    <div class="space-y-2 text-sm text-slate-600 mb-4">
                        @foreach($products as $item)
                            <div class="flex justify-between">
                                <span class="truncate pr-2">{{ $item['product']->name }} x{{ $item['quantity'] }}</span>
                                <span class="font-medium">R$ {{ number_format($item['subtotal'], 2, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-slate-100 pt-4 flex justify-between items-center mb-6">
                        <span class="font-bold text-slate-800">Total</span>
                        <span class="font-bold text-2xl text-blue-900">R$ {{ number_format($total, 2, ',', '.') }}</span>
                    </div>

                    @auth
                        <a href="{{ route('orders.checkout') }}"
                           class="block w-full bg-blue-900 hover:bg-blue-800 text-white font-semibold py-3 rounded-xl text-center transition">
                            Finalizar Compra →
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="block w-full bg-amber-400 hover:bg-amber-300 text-blue-950 font-semibold py-3 rounded-xl text-center transition">
                            Entrar para Finalizar
                        </a>
                        <p class="text-xs text-center text-slate-400 mt-2">
                            Ou <a href="{{ route('register') }}" class="text-blue-600 underline">criar uma conta</a>
                        </p>
                    @endauth
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

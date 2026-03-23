@extends('layouts.app')

@section('title', 'Catálogo de Produtos')

@section('content')

{{-- Hero Banner --}}
<section class="bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800 text-white py-16 px-4">
    <div class="max-w-4xl mx-auto text-center">
        <h1 class="font-display text-4xl sm:text-5xl mb-4">Frescos do Mar 🌊</h1>
        <p class="text-blue-200 text-lg mb-8">Peixes e frutos do mar pescados diariamente no litoral do Paraná</p>

        {{-- Search --}}
        <form method="GET" action="{{ route('products.index') }}" class="flex gap-2 max-w-xl mx-auto">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Buscar produto..."
                   class="flex-1 px-4 py-3 rounded-xl text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
            <button type="submit" class="bg-amber-400 hover:bg-amber-300 text-blue-950 font-semibold px-5 py-3 rounded-xl transition">
                🔍 Buscar
            </button>
        </form>
    </div>
</section>

{{-- Filters --}}
<div class="bg-white border-b shadow-sm sticky top-16 z-40">
    <div class="max-w-7xl mx-auto px-4 py-3 flex gap-3 overflow-x-auto">
        <a href="{{ route('products.index') }}"
           class="flex-none px-4 py-1.5 rounded-full text-sm font-medium transition
                  {{ !request('category') ? 'bg-blue-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            Todos
        </a>
        <a href="{{ route('products.index', ['category' => 'peixe']) }}"
           class="flex-none px-4 py-1.5 rounded-full text-sm font-medium transition
                  {{ request('category') === 'peixe' ? 'bg-blue-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            🐟 Peixes
        </a>
        <a href="{{ route('products.index', ['category' => 'fruto_do_mar']) }}"
           class="flex-none px-4 py-1.5 rounded-full text-sm font-medium transition
                  {{ request('category') === 'fruto_do_mar' ? 'bg-blue-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            🦐 Frutos do Mar
        </a>
    </div>
</div>

{{-- Products Grid --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @if($products->isEmpty())
        <div class="text-center py-24 text-slate-400">
            <p class="text-5xl mb-4">🐡</p>
            <p class="text-lg font-medium">Nenhum produto encontrado.</p>
        </div>
    @else
        <p class="text-sm text-slate-500 mb-6">{{ $products->total() }} produto(s) encontrado(s)</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md border border-slate-100 overflow-hidden group transition-all duration-200">

                    {{-- Image --}}
                    <a href="{{ route('products.show', $product) }}">
                        <div class="h-48 bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <span class="text-6xl">{{ $product->category === 'peixe' ? '🐟' : '🦐' }}</span>
                            @endif
                        </div>
                    </a>

                    {{-- Info --}}
                    <div class="p-4">
                        <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">
                            {{ $product->category_label }}
                        </span>
                        <h3 class="font-semibold text-slate-800 mt-2 leading-tight">
                            <a href="{{ route('products.show', $product) }}" class="hover:text-blue-700 transition">
                                {{ $product->name }}
                            </a>
                        </h3>
                        <p class="text-slate-500 text-xs mt-1 line-clamp-2">{{ $product->description }}</p>

                        <div class="flex items-center justify-between mt-3">
                            <span class="text-xl font-bold text-blue-900">{{ $product->formatted_price }}</span>
                            <span class="text-xs text-slate-400">Estoque: {{ $product->stock }}</span>
                        </div>

                        {{-- Add to Cart --}}
                        <form method="POST" action="{{ route('cart.add', $product) }}" class="mt-3">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit"
                                    class="w-full bg-blue-900 hover:bg-blue-800 text-white text-sm font-semibold py-2 rounded-xl transition flex items-center justify-center gap-2">
                                🛒 Adicionar ao Carrinho
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $products->withQueryString()->links() }}
        </div>
    @endif
</div>

@endsection

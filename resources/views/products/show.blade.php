@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <a href="{{ url()->previous() }}" class="text-slate-400 hover:text-slate-600 text-sm transition mb-6 inline-block">← Voltar</a>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2">

            {{-- Image --}}
            <div class="h-72 md:h-auto bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                         alt="{{ $product->name }}"
                         class="h-full w-full object-cover">
                @else
                    <span class="text-8xl">{{ $product->category === 'peixe' ? '🐟' : '🦐' }}</span>
                @endif
            </div>

            {{-- Details --}}
            <div class="p-8 flex flex-col justify-between">
                <div>
                    <span class="text-xs font-medium text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                        {{ $product->category_label }}
                    </span>
                    <h1 class="font-display text-3xl text-blue-950 mt-3 mb-3">{{ $product->name }}</h1>
                    <p class="text-slate-600 leading-relaxed">{{ $product->description }}</p>

                    <div class="flex items-center gap-4 mt-6">
                        <span class="text-3xl font-bold text-blue-900">{{ $product->formatted_price }}</span>
                        @if($product->isInStock())
                            <span class="text-sm text-green-600 font-medium bg-green-50 px-3 py-1 rounded-full">
                                ✓ Em estoque ({{ $product->stock }} un.)
                            </span>
                        @else
                            <span class="text-sm text-red-500 font-medium bg-red-50 px-3 py-1 rounded-full">
                                ✗ Esgotado
                            </span>
                        @endif
                    </div>
                </div>

                @if($product->isInStock())
                    <form method="POST" action="{{ route('cart.add', $product) }}" class="mt-6 flex gap-3">
                        @csrf
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                               class="w-20 text-center border border-slate-200 rounded-xl py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <button type="submit"
                                class="flex-1 bg-blue-900 hover:bg-blue-800 text-white font-semibold py-2.5 rounded-xl transition flex items-center justify-center gap-2">
                            🛒 Adicionar ao Carrinho
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

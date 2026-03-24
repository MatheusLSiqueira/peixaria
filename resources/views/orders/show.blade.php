@extends('layouts.app')

@section('title', 'Pedido #' . $order->id)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('orders.index') }}" class="text-slate-400 hover:text-slate-600 transition">← Voltar</a>
        <h1 class="font-display text-3xl text-blue-950">Pedido #{{ $order->id }}</h1>
    </div>

    {{-- Status & Meta --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-6">
        <div class="flex flex-wrap gap-4 justify-between items-center">
            <div>
                <x-order-status :order="$order" />
            </div>
            <div class="text-right">
                <p class="text-sm text-slate-500">Realizado em</p>
                <p class="font-medium text-slate-700">{{ $order->created_at->format('d/m/Y \à\s H:i') }}</p>
            </div>
        </div>

        @if($order->shipping_address)
            <div class="mt-4 pt-4 border-t border-slate-100">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Endereço de Entrega</p>
                <p class="text-sm text-slate-700">{{ $order->shipping_address }}</p>
            </div>
        @endif

        @if($order->notes)
            <div class="mt-3 pt-3 border-t border-slate-100">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Observações</p>
                <p class="text-sm text-slate-700">{{ $order->notes }}</p>
            </div>
        @endif
    </div>

    {{-- Items --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-6">
        <h2 class="font-semibold text-slate-800 mb-4">Itens do Pedido</h2>
        <div class="space-y-4">
            @foreach($order->items as $item)
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-2xl flex-none">
                        {{ $item->product->category === 'peixe' ? '🐟' : '🦐' }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-slate-800">{{ $item->product->name }}</p>
                        <p class="text-sm text-slate-500">{{ $item->quantity }} x R$ {{ number_format($item->unit_price, 2, ',', '.') }}</p>
                    </div>
                    <p class="font-semibold text-blue-900">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</p>
                </div>
            @endforeach
        </div>
        <div class="border-t border-slate-100 mt-4 pt-4 flex justify-between items-center">
            <span class="font-bold text-slate-800 text-lg">Total</span>
            <span class="font-bold text-2xl text-blue-900">{{ $order->formatted_total }}</span>
        </div>
    </div>

    <a href="{{ route('products.index') }}" class="bg-blue-900 hover:bg-blue-800 text-white font-semibold px-6 py-3 rounded-xl transition inline-block">
        Continuar Comprando
    </a>
</div>
@endsection

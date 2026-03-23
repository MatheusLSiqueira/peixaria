@extends('layouts.app')

@section('title', 'Meus Pedidos')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <h1 class="font-display text-3xl text-blue-950 mb-8">📦 Meus Pedidos</h1>

    @if($orders->isEmpty())
        <div class="text-center py-24 bg-white rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-6xl mb-4">📦</p>
            <p class="text-xl font-medium text-slate-600 mb-2">Você ainda não fez nenhum pedido</p>
            <a href="{{ route('products.index') }}" class="bg-blue-900 hover:bg-blue-800 text-white font-semibold px-6 py-3 rounded-xl transition inline-block mt-4">
                Ver Catálogo
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <span class="font-semibold text-slate-800">Pedido #{{ $order->id }}</span>
                                @php
                                    $colors = [
                                        'pendente'   => 'bg-yellow-100 text-yellow-700',
                                        'confirmado' => 'bg-blue-100 text-blue-700',
                                        'em_preparo' => 'bg-orange-100 text-orange-700',
                                        'enviado'    => 'bg-purple-100 text-purple-700',
                                        'entregue'   => 'bg-green-100 text-green-700',
                                        'cancelado'  => 'bg-red-100 text-red-700',
                                    ];
                                @endphp
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $colors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $order->status_label }}
                                </span>
                            </div>
                            <p class="text-sm text-slate-500">{{ $order->created_at->format('d/m/Y \à\s H:i') }}</p>
                            <p class="text-sm text-slate-500 mt-1">
                                {{ $order->items->count() }} item(ns) •
                                @foreach($order->items->take(2) as $item)
                                    {{ $item->product->name }}@if(!$loop->last), @endif
                                @endforeach
                                @if($order->items->count() > 2) e mais... @endif
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-xl text-blue-900">{{ $order->formatted_total }}</p>
                            <a href="{{ route('orders.show', $order) }}"
                               class="text-sm text-blue-600 hover:text-blue-800 font-medium mt-1 inline-block transition">
                                Ver detalhes →
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">{{ $orders->links() }}</div>
    @endif
</div>
@endsection

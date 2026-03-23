@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-5 mb-8">
    @php
        $cards = [
            ['label' => 'Total de Pedidos',  'value' => $stats['total_orders'],                                    'icon' => '📦', 'color' => 'blue'],
            ['label' => 'Pedidos Pendentes', 'value' => $stats['pending_orders'],                                  'icon' => '⏳', 'color' => 'yellow'],
            ['label' => 'Receita Total',     'value' => 'R$ ' . number_format($stats['total_revenue'], 2, ',', '.'), 'icon' => '💰', 'color' => 'green'],
            ['label' => 'Produtos',          'value' => $stats['total_products'],                                  'icon' => '🐟', 'color' => 'purple'],
            ['label' => 'Clientes',          'value' => $stats['total_customers'],                                 'icon' => '👥', 'color' => 'indigo'],
        ];
        $colorMap = [
            'blue'   => 'border-blue-400 bg-blue-50 text-blue-700',
            'yellow' => 'border-yellow-400 bg-yellow-50 text-yellow-700',
            'green'  => 'border-green-400 bg-green-50 text-green-700',
            'purple' => 'border-purple-400 bg-purple-50 text-purple-700',
            'indigo' => 'border-indigo-400 bg-indigo-50 text-indigo-700',
        ];
    @endphp

    @foreach($cards as $card)
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <div class="flex items-center gap-3 mb-2">
                <span class="text-2xl">{{ $card['icon'] }}</span>
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">{{ $card['label'] }}</span>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $card['value'] }}</p>
        </div>
    @endforeach
</div>

{{-- Recent Orders --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
    <div class="flex items-center justify-between mb-5">
        <h2 class="font-semibold text-slate-800 text-lg">Pedidos Recentes</h2>
        <a href="{{ route('admin.orders') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium transition">Ver todos →</a>
    </div>

    @if($recentOrders->isEmpty())
        <p class="text-slate-400 text-sm text-center py-8">Nenhum pedido ainda.</p>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="text-left pb-3 font-medium text-slate-500">Pedido</th>
                        <th class="text-left pb-3 font-medium text-slate-500">Cliente</th>
                        <th class="text-left pb-3 font-medium text-slate-500">Data</th>
                        <th class="text-left pb-3 font-medium text-slate-500">Total</th>
                        <th class="text-left pb-3 font-medium text-slate-500">Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($recentOrders as $order)
                        @php
                            $statusColors = [
                                'pendente'   => 'bg-yellow-100 text-yellow-700',
                                'confirmado' => 'bg-blue-100 text-blue-700',
                                'em_preparo' => 'bg-orange-100 text-orange-700',
                                'enviado'    => 'bg-purple-100 text-purple-700',
                                'entregue'   => 'bg-green-100 text-green-700',
                                'cancelado'  => 'bg-red-100 text-red-700',
                            ];
                        @endphp
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3 font-medium text-slate-800">#{{ $order->id }}</td>
                            <td class="py-3 text-slate-600">{{ $order->user->name }}</td>
                            <td class="py-3 text-slate-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-3 font-semibold text-blue-900">{{ $order->formatted_total }}</td>
                            <td class="py-3">
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td class="py-3 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-800 text-xs font-medium">Ver →</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

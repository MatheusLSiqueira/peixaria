@extends('layouts.admin')

@section('title', 'Pedidos')
@section('page-title', 'Gerenciar Pedidos')

@section('content')

{{-- Filter --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 mb-6">
    <form method="GET" action="{{ route('admin.orders') }}" class="flex flex-wrap gap-3">
        <select name="status" class="border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white">
            <option value="">Todos os status</option>
            @foreach(['pendente', 'confirmado', 'em_preparo', 'enviado', 'entregue', 'cancelado'] as $status)
                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white px-4 py-2 rounded-xl text-sm font-medium transition">
            Filtrar
        </button>
        @if(request('status'))
            <a href="{{ route('admin.orders') }}" class="text-slate-500 hover:text-slate-700 px-4 py-2 rounded-xl text-sm transition">
                Limpar
            </a>
        @endif
    </form>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="text-left px-6 py-4 font-medium text-slate-500">#</th>
                    <th class="text-left px-6 py-4 font-medium text-slate-500">Cliente</th>
                    <th class="text-left px-6 py-4 font-medium text-slate-500">Data</th>
                    <th class="text-left px-6 py-4 font-medium text-slate-500">Total</th>
                    <th class="text-left px-6 py-4 font-medium text-slate-500">Status</th>
                    <th class="text-right px-6 py-4 font-medium text-slate-500">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($orders as $order)
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
                        <td class="px-6 py-4 font-semibold text-slate-800">#{{ $order->id }}</td>
                        <td class="px-6 py-4 text-slate-700">{{ $order->user->name }}</td>
                        <td class="px-6 py-4 text-slate-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 font-semibold text-blue-900">{{ $order->formatted_total }}</td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $statusColors[$order->status] ?? '' }}">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="bg-blue-900 hover:bg-blue-800 text-white text-xs font-medium px-3 py-1.5 rounded-lg transition">
                                Ver
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-16 text-slate-400">Nenhum pedido encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $orders->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection

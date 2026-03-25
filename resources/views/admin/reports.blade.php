@extends('layouts.admin')

@section('title', 'Relatórios')
@section('page-title', 'Relatórios de Vendas')

@section('content')

{{-- Date Filter --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 mb-6">
    <form method="GET" action="{{ route('admin.reports') }}" class="flex flex-wrap gap-3 items-end">
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">Data Inicial</label>
            <input type="date" name="start_date" value="{{ $startDate }}"
                   class="border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">Data Final</label>
            <input type="date" name="end_date" value="{{ $endDate }}"
                   class="border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white font-semibold px-4 py-2 rounded-xl text-sm transition">
            📊 Gerar Relatório
        </button>
        <a href="{{ route('admin.reports.pdf', request()->query()) }}"
           class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-xl text-sm transition ml-2">
            📄 Baixar PDF
        </a>
    </form>
</div>

{{-- Summary Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wide mb-1">Total de Pedidos</p>
        <p class="text-3xl font-bold text-slate-800">{{ $summary['total_orders'] }}</p>
        <p class="text-xs text-slate-400 mt-1">{{ $startDate }} a {{ $endDate }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wide mb-1">Receita Total</p>
        <p class="text-3xl font-bold text-green-600">R$ {{ number_format($summary['total_revenue'], 2, ',', '.') }}</p>
        <p class="text-xs text-slate-400 mt-1">Excluindo pedidos cancelados</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Sales by Day --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h2 class="font-semibold text-slate-800 mb-4">Vendas por Dia</h2>
        @if($salesByDay->isEmpty())
            <p class="text-slate-400 text-sm text-center py-8">Sem dados no período selecionado.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-100">
                            <th class="text-left pb-3 font-medium text-slate-500">Data</th>
                            <th class="text-right pb-3 font-medium text-slate-500">Pedidos</th>
                            <th class="text-right pb-3 font-medium text-slate-500">Receita</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($salesByDay as $day)
                            <tr>
                                <td class="py-2.5 text-slate-700">{{ \Carbon\Carbon::parse($day->date)->format('d/m/Y') }}</td>
                                <td class="py-2.5 text-right font-medium text-slate-800">{{ $day->total_orders }}</td>
                                <td class="py-2.5 text-right font-semibold text-green-700">R$ {{ number_format($day->revenue, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Top Products --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h2 class="font-semibold text-slate-800 mb-4">🏆 Produtos Mais Vendidos</h2>
        @if($topProducts->isEmpty())
            <p class="text-slate-400 text-sm text-center py-8">Sem dados no período selecionado.</p>
        @else
            <div class="space-y-3">
                @foreach($topProducts as $i => $product)
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-bold text-slate-400 w-6 text-center">{{ $i + 1 }}</span>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-800 truncate">{{ $product->name }}</p>
                            <div class="mt-1 bg-slate-100 rounded-full h-1.5">
                                <div class="bg-blue-600 h-1.5 rounded-full"
                                     style="width: {{ min(100, ($product->total_sold / max($topProducts->max('total_sold'), 1)) * 100) }}%">
                                </div>
                            </div>
                        </div>
                        <div class="text-right flex-none">
                            <p class="text-sm font-semibold text-blue-900">{{ $product->total_sold }} un.</p>
                            <p class="text-xs text-slate-400">R$ {{ number_format($product->revenue, 2, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

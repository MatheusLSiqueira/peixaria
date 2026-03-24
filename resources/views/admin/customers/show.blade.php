@extends('layouts.admin')

@section('title', 'Cliente: ' . $user->name)
@section('page-title', 'Detalhes do Cliente')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Dados do cliente --}}
    <div class="lg:col-span-1 space-y-5">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            {{-- Avatar --}}
            <div class="flex flex-col items-center text-center mb-6">
                <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center text-3xl font-bold text-blue-900 mb-3">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h2 class="font-bold text-slate-800 text-lg">{{ $user->name }}</h2>
                <p class="text-sm text-slate-400">{{ $user->email }}</p>
            </div>

            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-slate-500">Telefone</dt>
                    <dd class="font-medium text-slate-800">{{ $user->phone ?? '—' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500">Cadastro</dt>
                    <dd class="font-medium text-slate-800">{{ $user->created_at->format('d/m/Y') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500">Total de pedidos</dt>
                    <dd class="font-semibold text-blue-900">{{ $user->orders->count() }}</dd>
                </div>
                @if($user->address)
                    <div class="pt-2 border-t border-slate-100">
                        <dt class="text-slate-500 mb-1">Endereço</dt>
                        <dd class="font-medium text-slate-800">{{ $user->address }}</dd>
                    </div>
                @endif
            </dl>

            <div class="flex flex-col gap-2 mt-6 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.customers.edit', $user) }}"
                   class="w-full text-center bg-blue-900 hover:bg-blue-800 text-white font-semibold px-4 py-2.5 rounded-xl transition text-sm">
                    Editar Cliente
                </a>
                <form method="POST" action="{{ route('admin.customers.destroy', $user) }}"
                      onsubmit="return confirm('Remover {{ $user->name }}? Esta ação não pode ser desfeita.')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="w-full bg-red-50 hover:bg-red-100 text-red-600 font-semibold px-4 py-2.5 rounded-xl transition text-sm">
                        Remover Cliente
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Pedidos recentes --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="font-semibold text-slate-800">Pedidos Recentes</h2>
            </div>

            @if($user->orders->isEmpty())
                <div class="py-16 text-center text-slate-400 text-sm">
                    Nenhum pedido realizado ainda.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="text-left px-6 py-3 font-medium text-slate-500">#</th>
                                <th class="text-left px-6 py-3 font-medium text-slate-500">Data</th>
                                <th class="text-left px-6 py-3 font-medium text-slate-500">Status</th>
                                <th class="text-right px-6 py-3 font-medium text-slate-500">Total</th>
                                <th class="text-right px-6 py-3 font-medium text-slate-500"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($user->orders as $order)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 font-medium text-slate-800">#{{ $order->id }}</td>
                                    <td class="px-6 py-4 text-slate-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4">
                                        <x-order-status :order="$order" />
                                    </td>
                                    <td class="px-6 py-4 text-right font-semibold text-blue-900">
                                        R$ {{ number_format($order->total, 2, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.orders.show', $order) }}"
                                           class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium px-3 py-1.5 rounded-lg transition">
                                            Ver pedido
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>

<div class="mt-4">
    <a href="{{ route('admin.customers') }}" class="text-slate-500 hover:text-slate-700 text-sm transition">← Voltar aos clientes</a>
</div>

@endsection

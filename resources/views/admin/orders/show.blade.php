@extends('layouts.admin')

@section('title', 'Pedido #' . $order->id)
@section('page-title', 'Pedido #' . $order->id)

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Items --}}
    <div class="lg:col-span-2 space-y-5">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h2 class="font-semibold text-slate-800 mb-4">Itens do Pedido</h2>
            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-2xl flex-none">
                            {{ $item->product->category === 'peixe' ? '🐟' : '🦐' }}
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-slate-800">{{ $item->product->name }}</p>
                            <p class="text-sm text-slate-500">{{ $item->quantity }} x R$ {{ number_format($item->unit_price, 2, ',', '.') }}</p>
                        </div>
                        <p class="font-semibold text-blue-900">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
            <div class="border-t border-slate-100 mt-4 pt-4 flex justify-between">
                <span class="font-bold text-slate-800 text-lg">Total</span>
                <span class="font-bold text-2xl text-blue-900">{{ $order->formatted_total }}</span>
            </div>
        </div>

        {{-- Client Info --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h2 class="font-semibold text-slate-800 mb-4">Dados do Cliente</h2>
            <dl class="grid grid-cols-2 gap-3 text-sm">
                <div>
                    <dt class="text-slate-500">Nome</dt>
                    <dd class="font-medium text-slate-800">{{ $order->user->name }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">E-mail</dt>
                    <dd class="font-medium text-slate-800">{{ $order->user->email }}</dd>
                </div>
                @if($order->user->phone)
                    <div>
                        <dt class="text-slate-500">Telefone</dt>
                        <dd class="font-medium text-slate-800">{{ $order->user->phone }}</dd>
                    </div>
                @endif
                @if($order->shipping_address)
                    <div class="col-span-2">
                        <dt class="text-slate-500">Endereço de Entrega</dt>
                        <dd class="font-medium text-slate-800">{{ $order->shipping_address }}</dd>
                    </div>
                @endif
                @if($order->notes)
                    <div class="col-span-2">
                        <dt class="text-slate-500">Observações</dt>
                        <dd class="font-medium text-slate-800">{{ $order->notes }}</dd>
                    </div>
                @endif
            </dl>
        </div>
    </div>

    {{-- Status Update --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sticky top-24">
            <h2 class="font-semibold text-slate-800 mb-4">Atualizar Status</h2>

            <p class="text-sm text-slate-500 mb-2">Status atual:</p>
            <x-order-status :order="$order" class="mb-4" />

            <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="mt-4">
                @csrf @method('PATCH')
                <label class="block text-sm font-medium text-slate-700 mb-1">Novo status</label>
                <select name="status" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm mb-3 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @foreach(['pendente' => 'Pendente', 'confirmado' => 'Confirmado', 'em_preparo' => 'Em Preparo', 'enviado' => 'Enviado', 'entregue' => 'Entregue', 'cancelado' => 'Cancelado'] as $value => $label)
                        <option value="{{ $value }}" {{ $order->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="w-full bg-blue-900 hover:bg-blue-800 text-white font-semibold py-2.5 rounded-xl transition text-sm">
                    Atualizar Status
                </button>
            </form>

            <div class="mt-4 pt-4 border-t border-slate-100 text-xs text-slate-400 space-y-1">
                <p>📅 Criado: {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p>🔄 Atualizado: {{ $order->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('admin.orders') }}" class="text-slate-500 hover:text-slate-700 text-sm transition">← Voltar aos pedidos</a>
</div>
@endsection

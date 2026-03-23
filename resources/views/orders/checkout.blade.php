@extends('layouts.app')

@section('title', 'Finalizar Compra')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <h1 class="font-display text-3xl text-blue-950 mb-8">Finalizar Compra ✅</h1>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

        {{-- Form --}}
        <div class="lg:col-span-3">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <h2 class="font-semibold text-lg text-slate-800 mb-4">Dados da Entrega</h2>

                <form method="POST" action="{{ route('orders.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Endereço de Entrega *</label>
                        <textarea name="shipping_address" rows="3" required
                                  placeholder="Rua, número, bairro, cidade, estado..."
                                  class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none">{{ old('shipping_address', auth()->user()->address) }}</textarea>
                        @error('shipping_address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Observações (opcional)</label>
                        <textarea name="notes" rows="2"
                                  placeholder="Ponto de referência, horário preferido..."
                                  class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none">{{ old('notes') }}</textarea>
                    </div>

                    {{-- Payment placeholder --}}
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
                        <p class="text-sm text-amber-800 font-medium">💳 Pagamento</p>
                        <p class="text-xs text-amber-700 mt-1">O pagamento será realizado na entrega (dinheiro, Pix ou cartão).</p>
                    </div>

                    <button type="submit"
                            class="w-full bg-blue-900 hover:bg-blue-800 text-white font-semibold py-3 rounded-xl transition text-base">
                        Confirmar Pedido →
                    </button>
                </form>
            </div>
        </div>

        {{-- Order Summary --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <h2 class="font-semibold text-lg text-slate-800 mb-4">Itens do Pedido</h2>

                <div class="space-y-3 mb-4">
                    @foreach($products as $item)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-xl flex-none">
                                {{ $item['product']->category === 'peixe' ? '🐟' : '🦐' }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-800 truncate">{{ $item['product']->name }}</p>
                                <p class="text-xs text-slate-500">{{ $item['quantity'] }} x {{ $item['product']->formatted_price }}</p>
                            </div>
                            <p class="text-sm font-semibold text-blue-900">R$ {{ number_format($item['subtotal'], 2, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-slate-100 pt-4 flex justify-between items-center">
                    <span class="font-bold text-slate-800">Total</span>
                    <span class="font-bold text-2xl text-blue-900">R$ {{ number_format($total, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

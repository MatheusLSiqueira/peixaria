@extends('layouts.admin')

@section('title', 'Produtos')
@section('page-title', 'Gerenciar Produtos')

@section('content')

<div class="flex justify-between items-center mb-6">
    <p class="text-sm text-slate-500">{{ $products->total() }} produto(s) cadastrado(s)</p>
    <a href="{{ route('admin.products.create') }}"
       class="bg-blue-900 hover:bg-blue-800 text-white font-semibold px-4 py-2 rounded-xl text-sm transition flex items-center gap-2">
        + Novo Produto
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="text-left px-6 py-4 font-medium text-slate-500">Produto</th>
                    <th class="text-left px-6 py-4 font-medium text-slate-500">Categoria</th>
                    <th class="text-left px-6 py-4 font-medium text-slate-500">Preço</th>
                    <th class="text-left px-6 py-4 font-medium text-slate-500">Estoque</th>
                    <th class="text-left px-6 py-4 font-medium text-slate-500">Status</th>
                    <th class="text-right px-6 py-4 font-medium text-slate-500">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($products as $product)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg overflow-hidden bg-blue-50 flex items-center justify-center flex-none">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover" alt="">
                                    @else
                                        <span class="text-xl">{{ $product->category === 'peixe' ? '🐟' : '🦐' }}</span>
                                    @endif
                                </div>
                                <span class="font-medium text-slate-800">{{ $product->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-500">{{ $product->category_label }}</td>
                        <td class="px-6 py-4 font-semibold text-blue-900">{{ $product->formatted_price }}</td>
                        <td class="px-6 py-4">
                            <span class="font-medium {{ $product->stock === 0 ? 'text-red-600' : ($product->stock < 5 ? 'text-yellow-600' : 'text-green-600') }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($product->active)
                                <span class="text-xs font-medium bg-green-100 text-green-700 px-2.5 py-1 rounded-full">Ativo</span>
                            @else
                                <span class="text-xs font-medium bg-slate-100 text-slate-500 px-2.5 py-1 rounded-full">Inativo</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium px-3 py-1.5 rounded-lg transition">
                                    Editar
                                </a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                      onsubmit="return confirm('Tem certeza que deseja remover {{ $product->name }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-50 hover:bg-red-100 text-red-600 text-xs font-medium px-3 py-1.5 rounded-lg transition">
                                        Remover
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-16 text-slate-400">Nenhum produto cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection

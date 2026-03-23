@extends('layouts.admin')

@section('title', isset($product) ? 'Editar Produto' : 'Novo Produto')
@section('page-title', isset($product) ? 'Editar: ' . $product->name : 'Novo Produto')

@section('content')

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">

        <form method="POST"
              action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}"
              enctype="multipart/form-data">
            @csrf
            @if(isset($product)) @method('PUT') @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                {{-- Name --}}
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nome *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required
                           class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Description --}}
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Descrição</label>
                    <textarea name="description" rows="3"
                              class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none">{{ old('description', $product->description ?? '') }}</textarea>
                </div>

                {{-- Price --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Preço (R$) *</label>
                    <input type="number" name="price" step="0.01" min="0.01"
                           value="{{ old('price', $product->price ?? '') }}" required
                           class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Stock --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Estoque *</label>
                    <input type="number" name="stock" min="0"
                           value="{{ old('stock', $product->stock ?? 0) }}" required
                           class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Category --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Categoria *</label>
                    <select name="category" required
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white">
                        <option value="">Selecione...</option>
                        <option value="peixe" {{ old('category', $product->category ?? '') === 'peixe' ? 'selected' : '' }}>🐟 Peixe</option>
                        <option value="fruto_do_mar" {{ old('category', $product->category ?? '') === 'fruto_do_mar' ? 'selected' : '' }}>🦐 Fruto do Mar</option>
                        <option value="outros" {{ old('category', $product->category ?? '') === 'outros' ? 'selected' : '' }}>Outros</option>
                    </select>
                    @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Active --}}
                <div class="flex items-center gap-3 pt-6">
                    <input type="hidden" name="active" value="0">
                    <input type="checkbox" name="active" value="1" id="active"
                           {{ old('active', $product->active ?? true) ? 'checked' : '' }}
                           class="w-4 h-4 rounded accent-blue-700">
                    <label for="active" class="text-sm font-medium text-slate-700">Produto ativo</label>
                </div>

                {{-- Image --}}
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Imagem</label>
                    @if(isset($product) && $product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-24 h-24 object-cover rounded-xl mb-2 border border-slate-200" alt="">
                        <p class="text-xs text-slate-400 mb-2">Selecione nova imagem para substituir.</p>
                    @endif
                    <input type="file" name="image" accept="image/*"
                           class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:text-xs file:font-medium file:py-1 file:px-3">
                    @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex gap-3 mt-6 pt-6 border-t border-slate-100">
                <button type="submit"
                        class="bg-blue-900 hover:bg-blue-800 text-white font-semibold px-6 py-2.5 rounded-xl transition text-sm">
                    {{ isset($product) ? 'Salvar Alterações' : 'Criar Produto' }}
                </button>
                <a href="{{ route('admin.products.index') }}"
                   class="text-slate-500 hover:text-slate-700 font-medium px-4 py-2.5 rounded-xl transition text-sm">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

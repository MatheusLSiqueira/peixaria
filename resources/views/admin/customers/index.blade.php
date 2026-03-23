@extends('layouts.admin')

@section('title', 'Clientes')
@section('page-title', 'Gerenciar Clientes')

@section('content')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="text-left px-6 py-4 font-medium text-slate-500">Cliente</th>
                    <th class="text-left px-6 py-4 font-medium text-slate-500">Telefone</th>
                    <th class="text-left px-6 py-4 font-medium text-slate-500">Pedidos</th>
                    <th class="text-left px-6 py-4 font-medium text-slate-500">Cadastro</th>
                    <th class="text-right px-6 py-4 font-medium text-slate-500">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($customers as $customer)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4">
                            <p class="font-medium text-slate-800">{{ $customer->name }}</p>
                            <p class="text-xs text-slate-400">{{ $customer->email }}</p>
                        </td>
                        <td class="px-6 py-4 text-slate-500">{{ $customer->phone ?? '—' }}</td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-blue-900">{{ $customer->orders_count }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-500">{{ $customer->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.customers.show', $customer) }}"
                                   class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium px-3 py-1.5 rounded-lg transition">
                                    Ver
                                </a>
                                <a href="{{ route('admin.customers.edit', $customer) }}"
                                   class="bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-medium px-3 py-1.5 rounded-lg transition">
                                    Editar
                                </a>
                                <form method="POST" action="{{ route('admin.customers.destroy', $customer) }}"
                                      onsubmit="return confirm('Remover {{ $customer->name }}?')">
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
                        <td colspan="5" class="text-center py-16 text-slate-400">Nenhum cliente cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($customers->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $customers->links() }}
        </div>
    @endif
</div>
@endsection

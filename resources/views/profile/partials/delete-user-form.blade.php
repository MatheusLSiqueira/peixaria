<section class="space-y-5">
    <header>
        <h2 class="text-lg font-medium text-slate-800 mb-1">Excluir Conta</h2>
        <p class="text-sm text-slate-600">Esta ação não pode ser desfeita. Todos os seus dados serão permanentemente removidos.</p>
    </header>

    <div class="bg-red-50 border border-red-200 rounded-xl p-4">
        <p class="text-sm text-red-800 font-medium mb-2">⚠️ Ação irreversível</p>
        <p class="text-xs text-red-700">Ao excluir sua conta, todos os seus pedidos, dados pessoais e histórico serão permanentemente removidos do sistema.</p>
    </div>

    <button type="button"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-xl transition text-sm">
        🗑️ Excluir Minha Conta
    </button>

    <div x-show="$wire.showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" x-on:click="$dispatch('close')" x-show="$wire.showDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" x-show="$wire.showDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                    @csrf
                    @method('delete')

                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                            <span class="text-red-600 text-xl">⚠️</span>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-slate-800">Confirmar Exclusão</h3>
                            <p class="text-sm text-slate-600">Tem certeza que deseja excluir sua conta?</p>
                        </div>
                    </div>

                    <p class="text-sm text-slate-600 mb-4">
                        Digite sua senha para confirmar a exclusão permanente da conta.
                    </p>

                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Senha *</label>
                        <input id="password" name="password" type="password" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-400" placeholder="Digite sua senha" required />
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 text-sm font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-xl transition">
                            Excluir Conta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section>
    <header>
        <h2 class="text-lg font-medium text-slate-800 mb-1">Alterar Senha</h2>
        <p class="text-sm text-slate-600">Mantenha sua conta segura com uma senha forte e única.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-slate-700 mb-1">Senha Atual *</label>
            <input id="update_password_current_password" name="current_password" type="password" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" autocomplete="current-password" />
            @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label for="update_password_password" class="block text-sm font-medium text-slate-700 mb-1">Nova Senha *</label>
                <input id="update_password_password" name="password" type="password" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" autocomplete="new-password" />
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="update_password_password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Confirmar Nova Senha *</label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" autocomplete="new-password" />
                @error('password_confirmation') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white font-semibold px-6 py-3 rounded-xl transition text-sm">
                🔒 Alterar Senha
            </button>

            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm text-green-600 font-medium">
                    ✅ Senha alterada com sucesso!
                </div>
            @endif
        </div>
    </form>
</section>

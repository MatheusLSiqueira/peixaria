<section>
    <header>
        <h2 class="text-lg font-medium text-slate-800 mb-1">Informações do Perfil</h2>
        <p class="text-sm text-slate-600">Atualize suas informações pessoais e dados de contato.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nome *</label>
                <input id="name" name="name" type="text" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">E-mail *</label>
                <input id="email" name="email" type="email" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label for="phone" class="block text-sm font-medium text-slate-700 mb-1">Telefone</label>
                <input id="phone" name="phone" type="text" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" value="{{ old('phone', $user->phone) }}" placeholder="(41) 99999-9999" autocomplete="tel" />
                @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="sm:col-span-1">
                <!-- Espaço reservado para futuras expansões -->
            </div>
        </div>

        <div>
            <label for="address" class="block text-sm font-medium text-slate-700 mb-1">Endereço</label>
            <textarea id="address" name="address" rows="3" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none" placeholder="Rua, número, bairro, cidade...">{{ old('address', $user->address) }}</textarea>
            @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                <p class="text-sm text-amber-800 font-medium">📧 E-mail não verificado</p>
                <p class="text-xs text-amber-700 mt-1">Seu endereço de e-mail não foi verificado.</p>
                <button form="send-verification" class="mt-2 text-sm text-blue-600 hover:text-blue-800 underline focus:outline-none">
                    Reenviar e-mail de verificação
                </button>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 text-sm text-green-600">Um novo link de verificação foi enviado para seu e-mail.</p>
                @endif
            </div>
        @endif

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white font-semibold px-6 py-3 rounded-xl transition text-sm">
                💾 Salvar Alterações
            </button>

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm text-green-600 font-medium">
                    ✅ Perfil atualizado com sucesso!
                </div>
            @endif
        </div>
    </form>
</section>

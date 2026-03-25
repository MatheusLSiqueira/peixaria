<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-slate-800 mb-2">Criar Conta 🐟</h2>
        <p class="text-slate-600 text-sm">Junte-se a nós e receba peixes frescos em casa</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Nome Completo *</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500 text-xs" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">E-mail *</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Senha *</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">Confirmar Senha *</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-xs" />
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium transition">
                Já tem conta? Entrar
            </a>

            <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white font-semibold px-6 py-3 rounded-xl transition text-sm ml-auto">
                🎣 Criar Conta
            </button>
        </div>
    </form>

    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-4">
        <div class="flex items-start gap-3">
            <span class="text-blue-600 text-lg">ℹ️</span>
            <div>
                <p class="text-sm font-medium text-blue-800 mb-1">Por que criar conta?</p>
                <p class="text-xs text-blue-700">Acesse seu histórico de pedidos, receba ofertas exclusivas e tenha uma experiência personalizada.</p>
            </div>
        </div>
    </div>
</x-guest-layout>

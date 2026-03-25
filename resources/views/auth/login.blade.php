<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-slate-800 mb-2">Bem-vindo de volta! 👋</h2>
        <p class="text-slate-600 text-sm">Entre na sua conta para continuar comprando</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">E-mail *</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Senha *</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500">
            <label for="remember_me" class="ml-2 block text-sm text-slate-700">
                Lembrar de mim
            </label>
        </div>

        <div class="flex items-center justify-between">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium transition">
                    Esqueceu a senha?
                </a>
            @endif

            <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white font-semibold px-6 py-3 rounded-xl transition text-sm ml-auto">
                🚀 Entrar
            </button>
        </div>
    </form>

    <div class="mt-8 text-center">
        <p class="text-slate-600 text-sm">
            Não tem uma conta?
            <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-medium transition">Cadastre-se</a>
        </p>
    </div>
</x-guest-layout>

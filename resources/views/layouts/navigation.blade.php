<nav x-data="{ open: false }" class="bg-[#0f172a] border-b border-blue-900 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center space-x-2 transition-transform hover:scale-105">
                        <span class="text-2xl">⚓</span>
                        <span class="font-black text-xl tracking-tighter text-white uppercase">
                            Santa <span class="text-amber-400">Mar</span>
                        </span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')" 
                        class="text-gray-300 hover:text-amber-400 border-amber-400 transition-colors">
                        {{ __('Início') }}
                    </x-nav-link>
                    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')"
                        class="text-gray-300 hover:text-amber-400 border-amber-400">
                        {{ __('Peixaria') }}
                    </x-nav-link>
                    <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')"
                        class="text-gray-300 hover:text-amber-400 border-amber-400">
                        <div class="flex items-center">
                            <span>{{ __('Carrinho') }}</span>
                            @php $cartCount = array_sum(array_column(session('cart', []), 'quantity')) @endphp
                            <span class="ms-2 bg-amber-500 text-[#0f172a] text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $cartCount }}</span>
                        </div>
                    </x-nav-link>
                    @auth
                        @if(Auth::user()->isAdmin())
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')"
                                class="text-gray-300 hover:text-amber-400 border-amber-400">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')"
                                class="text-gray-300 hover:text-amber-400 border-amber-400">
                                {{ __('Meus Pedidos') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-4 py-2 border border-blue-800 text-sm font-medium rounded-full text-gray-300 bg-[#1e293b] hover:border-amber-400 transition duration-150 focus:outline-none">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-green-500 rounded-full me-2 shadow-[0_0_8px_rgba(34,197,94,0.6)]"></div>
                                    {{ Auth::user()->name }}
                                </div>
                                <svg class="ms-2 h-4 w-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Editar Perfil') }}
                            </x-dropdown-link>

@if(Auth::user()->isAdmin())
                                <div class="border-t border-gray-100 dark:border-gray-700"></div>
                                <x-dropdown-link :href="route('admin.dashboard')" class="text-amber-600 font-bold">
                                    {{ __('Painel Admin') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-100 dark:border-gray-700"></div>
                            
                            <form method="POST" action="{{ route('logout') }}" id="logout-form-desktop">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();"
                                        class="text-red-600">
                                    {{ __('Sair') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-sm text-gray-400 hover:text-amber-400 font-semibold uppercase tracking-wider">Login</a>
                        <a href="{{ route('register') }}" class="bg-amber-500 hover:bg-amber-400 text-[#0f172a] px-5 py-2 rounded-full text-sm font-bold shadow-md transition-all active:scale-95">
                            Cadastrar
                        </a>
                    </div>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 rounded-md text-gray-400 hover:text-amber-400 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#1e293b]">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" class="text-gray-300">
                Início
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')" class="text-gray-300">
                Peixaria
            </x-responsive-nav-link>
        </div>
        
        <div class="pt-4 pb-1 border-t border-blue-900">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-300">Perfil</x-responsive-nav-link>
                    
                    <form method="POST" action="{{ route('logout') }}" id="logout-form-mobile">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" 
                            onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();" 
                            class="text-red-400">Sair</x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="px-4 py-2 space-y-2">
                    <a href="{{ route('login') }}" class="block text-amber-400 font-bold">Login</a>
                    <a href="{{ route('register') }}" class="block text-white">Cadastrar</a>
                </div>
            @endauth
        </div>
    </div>
</nav>
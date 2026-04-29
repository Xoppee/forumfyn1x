<header class="h-16 border-b border-slate-800 flex items-center justify-between px-8 bg-slate-900">
    <div class="flex items-center text-sm text-slate-500">
        <span class="font-bold text-slate-200">Dashboard</span>
    </div>

    <div class="flex items-center space-x-4">
        <div class="relative dropdown">
            <button
                class="flex items-center space-x-3 p-1.5 hover:bg-slate-800 rounded-2xl transition border border-transparent focus:border-slate-700">
                <div class="flex flex-col items-end px-2">
                    <span class="text-sm font-bold text-slate-200">{{ auth()->user()->username ?? 'Guest' }}</span>
                    <span class="text-[9px] text-emerald-400 font-black uppercase tracking-widest">{{ auth()->user()->current_level >= 100 ? 'Admin': 'Usuário' }}</span>
                </div>
                <div
                    class="w-9 h-9 rounded-xl bg-slate-700 flex items-center justify-center border border-slate-600 shadow-inner">
                    <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim(auth()->user()->email))) . '?s=200&d=identicon' }}"
                        alt="Avatar" class="w-full h-full object-cover rounded-xl">
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-slate-500 pr-1"></i>
            </button>

            <div
                class="dropdown-menu absolute right-0 mt-2 w-56 bg-slate-800 border border-slate-700 rounded-2xl shadow-2xl opacity-0 transform -translate-y-2 transition-all pointer-events-none z-50 overflow-hidden">
                <div class="px-4 py-3 border-b border-slate-700 bg-slate-800/50">
                    <p class="text-xs text-slate-500">Logado como:</p>
                    <p class="text-sm font-bold truncate">{{ auth()->user()->name }}</p>
                </div>
                <a href="#" class="flex items-center space-x-3 px-4 py-3 text-sm hover:bg-slate-700 transition">
                    <i data-lucide="settings" class="w-4 h-4 text-slate-400"></i>
                    <span>Configurações</span>
                </a>
                @if (auth()->user() && auth()->user()->role === 'admin')
                    <a href="{{ route('admin') }}" target="_blank"
                        class="flex items-center space-x-3 px-4 py-3 text-sm hover:bg-slate-700 transition border-t border-slate-700/50">
                        <i data-lucide="shield-check" class="w-4 h-4 text-emerald-500"></i>
                        <span>Painel Admin</span>
                    </a>
                @endif
                <div class="border-t border-slate-700"></div>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center space-x-3 px-4 py-4 text-sm text-red-400 hover:bg-red-500/10 transition">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                        <span class="font-bold">Sair do Sistema</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

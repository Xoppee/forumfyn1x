<aside class="fixed left-0 top-0 w-64 h-screen bg-slate-900/80 backdrop-blur-xl border-r border-slate-800 z-40 flex flex-col">
    <div class="h-16 flex items-center justify-center border-b border-slate-800/50">
        <h1 class="text-xl font-black tracking-tighter bg-gradient-to-r from-blue-400 via-emerald-400 to-cyan-400 bg-clip-text text-transparent italic">
            FYN1X FORUM
        </h1>
    </div>

    <nav class="flex-1 p-4 space-y-6 overflow-y-auto">
        <div>
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-3">Navegação</p>
            <div class="space-y-1">
                <a href="/" class="flex items-center space-x-3 p-3 rounded-xl bg-blue-600/10 text-blue-400 border border-blue-600/20">
                    <i data-lucide="layout-grid" class="w-5 h-5"></i>
                    <span class="font-bold text-sm">Feed Principal</span>
                </a>
                
                <a href="/topics" class="flex items-center space-x-3 p-3 rounded-xl text-slate-400 hover:bg-slate-800 transition group">
                    <i data-lucide="message-square" class="w-5 h-5 group-hover:text-white"></i>
                    <span class="text-sm font-medium group-hover:text-white">Tópicos</span>
                </a>
                
                @auth
                @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('topics.create') }}" class="flex items-center space-x-3 p-3 rounded-xl text-slate-400 hover:bg-slate-800 transition group">
                    <i data-lucide="plus-circle" class="w-5 h-5 group-hover:text-white"></i>
                    <span class="text-sm font-medium group-hover:text-white">Criar Tópico</span>
                </a>
                @endif
                @endauth
            </div>
        </div>

        <div>
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-3">Páginas</p>
            <div class="space-y-1">
                @foreach ($pages->where('is_published', true)->take(5) as $page)
                <a href="/p/{{ $page->slug }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-800/50 transition group">
                    <div class="flex items-center space-x-3 text-slate-400 group-hover:text-white">
                        <i data-lucide="{{ $page->icon ?? 'file-text' }}" class="w-5 h-5"></i>
                        <span class="text-sm font-medium">{{ $page->title }}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        @auth
        <div>
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-3">Meu Espaço</p>
            <div class="space-y-1">
                <a href="{{ route('profile', auth()->user()->username) }}" class="flex items-center space-x-3 p-3 rounded-xl text-slate-400 hover:bg-slate-800 transition group">
                    <i data-lucide="user" class="w-5 h-5 group-hover:text-white"></i>
                    <span class="text-sm font-medium group-hover:text-white">Meu Perfil</span>
                </a>
                
                <a href="/groups" class="flex items-center space-x-3 p-3 rounded-xl text-slate-400 hover:bg-slate-800 transition group">
                    <i data-lucide="users" class="w-5 h-5 group-hover:text-white"></i>
                    <span class="text-sm font-medium group-hover:text-white">Meus Grupos</span>
                </a>
                
                <a href="/verification" class="flex items-center space-x-3 p-3 rounded-xl text-slate-400 hover:bg-slate-800 transition group">
                    <i data-lucide="shield-check" class="w-5 h-5 group-hover:text-white"></i>
                    <span class="text-sm font-medium group-hover:text-white">Verificação</span>
                </a>
                
                <a href="/gallery" class="flex items-center space-x-3 p-3 rounded-xl text-slate-400 hover:bg-slate-800 transition group">
                    <i data-lucide="image" class="w-5 h-5 group-hover:text-white"></i>
                    <span class="text-sm font-medium group-hover:text-white">Galeria</span>
                </a>
                
                @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('admin') }}" class="flex items-center space-x-3 p-3 rounded-xl text-emerald-400 hover:bg-emerald-600/10 transition group">
                    <i data-lucide="shield" class="w-5 h-5 group-hover:text-emerald-300"></i>
                    <span class="text-sm font-bold group-hover:text-emerald-300">Painel Admin</span>
                </a>
                @endif
            </div>
        </div>
        @endauth
    </nav>

    <div class="p-4 border-t border-slate-800/50">
        @guest
        <a href="{{ route('login') }}" class="flex items-center justify-center space-x-2 w-full py-3 bg-blue-600 hover:bg-blue-500 rounded-xl font-bold transition">
            <i data-lucide="log-in" class="w-4 h-4"></i>
            <span>Entrar</span>
        </a>
        @else
        <div class="flex items-center space-x-3 p-3 rounded-xl bg-slate-800/50 mb-3">
            <div class="w-10 h-10 rounded-xl bg-slate-700 flex items-center justify-center overflow-hidden">
                @if(auth()->user()->avatar)
                <img src="{{ asset('storage/'.auth()->user()->avatar) }}" class="w-full h-full object-cover">
                @else
                <i data-lucide="user" class="w-5 h-5 text-slate-400"></i>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-white truncate flex items-center gap-1">
                    {{ auth()->user()->name }}
                    @if(auth()->user()->is_verified)
                    <i data-lucide="badge-check" class="w-3 h-3 text-blue-400"></i>
                    @endif
                </p>
                <p class="text-xs text-slate-500">{{ '@'.auth()->user()->username }}</p>
            </div>
        </div>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center justify-center space-x-2 w-full py-3 border border-slate-700 text-slate-400 hover:text-red-400 hover:border-red-500/50 rounded-xl font-medium transition">
                <i data-lucide="log-out" class="w-4 h-4"></i>
                <span>Sair</span>
            </button>
        </form>
        @endguest
    </div>
</aside>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
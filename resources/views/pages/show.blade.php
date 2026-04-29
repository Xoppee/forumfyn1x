<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title }} - Fyn1x Forum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        
        .glass-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(12px);
        }
    </style>
</head>

<body class="bg-slate-950 text-slate-100 min-h-screen">

    <aside class="fixed left-0 top-0 w-64 h-screen bg-slate-900/80 backdrop-blur-xl border-r border-slate-800 z-40 hidden lg:flex flex-col">
        <div class="h-16 flex items-center justify-center border-b border-slate-800/50">
            <h1 class="text-xl font-black tracking-tighter bg-gradient-to-r from-blue-400 to-emerald-400 bg-clip-text text-transparent italic">
                FYN1X FORUM
            </h1>
        </div>

        <nav class="flex-1 p-4 space-y-6 overflow-y-auto">
            <div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-3">Navegação</p>
                <div class="space-y-1">
                    <a href="/" class="flex items-center space-x-3 p-3 rounded-xl text-slate-400 hover:bg-slate-800 transition group">
                        <i data-lucide="layout-grid" class="w-5 h-5 group-hover:text-white"></i>
                        <span class="text-sm font-medium group-hover:text-white">Feed Principal</span>
                    </a>
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
            @endguest
        </div>
    </aside>

    <div class="lg:ml-64 min-h-screen">
        <header class="sticky top-0 z-30 h-16 glass-card flex items-center justify-between px-6 border-b border-slate-800">
            <div class="flex items-center space-x-4">
                <a href="/" class="p-2 hover:bg-slate-800 rounded-xl transition">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <h2 class="text-lg font-bold text-white">{{ $page->title }}</h2>
            </div>
        </header>

        <main class="p-6 pb-20">
            <div class="max-w-3xl mx-auto">
                <div class="glass-card rounded-2xl p-8">
                    <div class="flex items-center space-x-3 mb-6">
                        @if($page->icon)
                        <div class="w-12 h-12 rounded-xl bg-blue-600/20 flex items-center justify-center">
                            <i data-lucide="{{ $page->icon }}" class="w-6 h-6 text-blue-400"></i>
                        </div>
                        @endif
                        <h1 class="text-3xl font-black text-white">{{ $page->title }}</h1>
                    </div>
                    
                    <div class="prose prose-invert max-w-none">
                        <div class="text-slate-300 leading-relaxed whitespace-pre-wrap">{{ $page->content ?? 'Esta página ainda não tem conteúdo.' }}</div>
                    </div>

                    @auth
                    @if(auth()->user()->roles->contains('slug', 'admin') || auth()->user()->roles->contains('slug', 'founder'))
                    <div class="mt-8 pt-6 border-t border-slate-700">
                        <a href="{{ route('admin.pages.edit', $page->id) }}" class="inline-flex items-center space-x-2 px-4 py-2 bg-slate-700 hover:bg-slate-600 rounded-lg text-sm font-medium transition">
                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                            <span>Editar Página</span>
                        </a>
                    </div>
                    @endif
                    @endauth
                </div>
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>
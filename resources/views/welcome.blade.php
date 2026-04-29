<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fyn1x Forum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        [x-cloak] { display: none !important; }

        .glass-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(71, 85, 105, 0.4);
        }

        .glow-blue {
            box-shadow: 0 0 40px rgba(59, 130, 246, 0.15);
        }

        .topic-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
        }

        .category-tag {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(16, 185, 129, 0.2));
        }
    </style>
</head>

<body class="bg-slate-950 text-slate-100 min-h-screen" x-data="{ searchOpen: false }">

    @include('components.sidebar')
    <div class="lg:ml-64 min-h-screen">
        <header class="sticky top-0 z-30 h-16 glass-card flex items-center justify-between px-6">
            <div class="flex items-center space-x-4">
                <button class="lg:hidden p-2 hover:bg-slate-800 rounded-xl transition">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <h2 class="text-lg font-bold text-white hidden md:block">Fóruns</h2>
            </div>

            <div class="flex items-center space-x-3">
                <button @click="searchOpen = true" class="p-2.5 bg-slate-800/50 hover:bg-slate-700 rounded-xl transition border border-slate-700/50">
                    <i data-lucide="search" class="w-5 h-5 text-slate-400"></i>
                </button>
                
                @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 p-2 hover:bg-slate-800 rounded-xl transition">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-emerald-500 flex items-center justify-center font-bold text-white text-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400"></i>
                    </button>
                    
                    <div x-show="open" x-cloak @click.outside="open = false" class="absolute right-0 top-full mt-2 w-48 glass-card rounded-xl overflow-hidden shadow-xl">
                        <a href="{{ route('profile', auth()->user()->username) }}" class="flex items-center space-x-2 px-4 py-3 hover:bg-slate-700/50 transition">
                            <i data-lucide="user" class="w-4 h-4"></i>
                            <span>Meu Perfil</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center space-x-2 w-full px-4 py-3 hover:bg-red-500/10 text-red-400 transition">
                                <i data-lucide="log-out" class="w-4 h-4"></i>
                                <span>Sair</span>
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 rounded-xl font-bold text-sm transition">
                    Entrar
                </a>
                @endauth
            </div>
        </header>

        <main class="p-6 pb-20">
            <div class="max-w-4xl mx-auto space-y-8">
                
                @if(isset($topic) && $topic->is_sticky)
                <div class="relative">
                    <div class="absolute -left-3 top-0 bottom-0 w-1 bg-gradient-to-b from-blue-500 to-emerald-500 rounded-full"></div>
                    <div class="glass-card glow-blue rounded-2xl p-6 ml-3">
                        <div class="flex items-center space-x-2 mb-3">
                            <div class="bg-blue-500/20 p-1.5 rounded-lg">
                                <i data-lucide="pin" class="w-4 h-4 text-blue-400"></i>
                            </div>
                            <span class="text-[10px] font-bold text-blue-400 uppercase tracking-widest">Tópico Fixado</span>
                        </div>
                        <h2 class="text-2xl font-black text-white tracking-tight mb-2">{{ $topic->title }}</h2>
                        <p class="text-slate-400 leading-relaxed">{{ $topic->posts->first()?->body ?? 'Bem-vindo ao Fyn1x Forum!' }}</p>
                        <div class="flex items-center space-x-4 mt-4 text-sm text-slate-500">
                            <span>Por <span class="text-blue-400">{{ $topic->user->name ?? 'Admin' }}</span></span>
                            <span>•</span>
                            <span>{{ $topic->created_at->format('d M, Y') }}</span>
                        </div>
                    </div>
                </div>
                @endif

                <div>
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-white">Discussões Recentes</h3>
                        <div class="flex items-center space-x-2">
                            <select class="bg-slate-800 border border-slate-700 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:border-blue-500">
                                <option>Mais Recentes</option>
                                <option>Mais Vistos</option>
                                <option>Mais Respondidos</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-3">
                        @forelse($topics ?? [] as $topic)
                        <a href="{{ route('topics.show', $topic->slug) }}" 
                           class="topic-card block glass-card rounded-xl p-5 hover:border-blue-500/30 transition-all duration-300">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-4">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-700 to-slate-600 flex items-center justify-center text-slate-300 font-bold text-sm overflow-hidden">
                                        @if($topic->user?->avatar)
                                        <img src="{{ $topic->user->avatar }}" class="w-full h-full object-cover">
                                        @else
                                        {{ strtoupper(substr($topic->user->name ?? 'U', 0, 1)) }}
                                        @endif
                                    </div>
                                    
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <span class="font-semibold text-slate-200">{{ $topic->user->name ?? 'Usuário' }}</span>
                                            <span class="text-slate-600 text-xs">•</span>
                                            <span class="text-slate-500 text-xs">{{ $topic->created_at->diffForHumans() }}</span>
                                        </div>
                                        <h4 class="text-base font-bold text-white mb-1 truncate">{{ $topic->title }}</h4>
                                        <div class="flex items-center space-x-4 text-xs text-slate-500">
                                            <span class="flex items-center space-x-1">
                                                <i data-lucide="message-square" class="w-3.5 h-3.5"></i>
                                                <span>{{ $topic->posts_count ?? $topic->posts->count() }} respostas</span>
                                            </span>
                                            <span class="flex items-center space-x-1">
                                                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                                <span>{{ rand(50, 500) }} visualizações</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($topic->is_sticky)
                                <div class="bg-blue-500/10 p-1.5 rounded-lg">
                                    <i data-lucide="pin" class="w-4 h-4 text-blue-400"></i>
                                </div>
                                @endif
                            </div>
                        </a>
                        @empty
                        <div class="glass-card rounded-xl p-12 text-center">
                            <div class="w-16 h-16 mx-auto mb-4 bg-slate-800 rounded-full flex items-center justify-center">
                                <i data-lucide="message-square" class="w-8 h-8 text-slate-600"></i>
                            </div>
                            <h4 class="text-lg font-bold text-white mb-2">Nenhuma discussão ainda</h4>
                            <p class="text-slate-500 mb-6">Aguarde os administradores criarem novos temas de discussão.</p>
                            @auth
                            @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('topics.create') }}" class="inline-flex items-center space-x-2 px-6 py-3 bg-blue-600 hover:bg-blue-500 rounded-xl font-bold transition">
                                <i data-lucide="plus-circle" class="w-5 h-5"></i>
                                <span>Criar Tópico</span>
                            </a>
                            @endif
                            @else
                            <a href="{{ route('login') }}" class="inline-flex items-center space-x-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-500 rounded-xl font-bold transition">
                                <i data-lucide="log-in" class="w-5 h-5"></i>
                                <span>Entrar para Participar</span>
                            </a>
                            @endauth
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </main>
    </div>

    <div x-show="searchOpen" x-cloak class="fixed inset-0 z-50 flex items-start justify-center pt-20 px-4">
        <div x-show="searchOpen" @click="searchOpen = false" class="absolute inset-0 bg-slate-950/90 backdrop-blur-sm"></div>
        
        <div x-show="searchOpen" class="relative w-full max-w-2xl glass-card rounded-2xl p-4 shadow-2xl">
            <div class="flex items-center space-x-3">
                <i data-lucide="search" class="w-5 h-5 text-slate-400"></i>
                <input type="text" placeholder="Buscar tópicos..." class="flex-1 bg-transparent text-lg focus:outline-none" autofocus>
                <button @click="searchOpen = false" class="p-2 hover:bg-slate-700 rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>
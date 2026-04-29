<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca: {{ $query }} - Fyn1x Forum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        .glass-card { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(71, 85, 105, 0.4); }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen" x-data="{ searchOpen: false }">

    @include('components.sidebar')

    <div class="lg:ml-64 min-h-screen">
        <header class="sticky top-0 z-30 h-16 glass-card flex items-center justify-between px-6 border-b border-slate-800">
            <div class="flex items-center space-x-4">
                <a href="/" class="p-2 hover:bg-slate-800 rounded-xl transition">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <h2 class="text-lg font-bold text-white">Resultados da Busca</h2>
            </div>
        </header>

        <main class="p-6 pb-20">
            <div class="max-w-4xl mx-auto space-y-6">
                
                <div class="glass-card rounded-2xl p-6">
                    <form action="{{ route('search') }}" method="GET" class="relative">
                        <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500"></i>
                        <input type="text" name="q" value="{{ $query }}" 
                               placeholder="Buscar tópicos, posts, usuários..." 
                               class="w-full pl-12 pr-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition">
                    </form>
                </div>

                @if(strlen($query) < 2)
                    <div class="glass-card rounded-xl p-12 text-center">
                        <i data-lucide="search" class="w-12 h-12 text-slate-600 mx-auto mb-4"></i>
                        <p class="text-slate-500">Digite pelo menos 2 caracteres para buscar.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @if($topics->count() > 0)
                        <div>
                            <h3 class="text-lg font-bold text-white mb-3 flex items-center gap-2">
                                <i data-lucide="message-square" class="w-5 h-5 text-blue-400"></i>
                                Tópicos ({{ $topics->count() }})
                            </h3>
                            <div class="space-y-2">
                                @foreach($topics as $topic)
                                <a href="{{ route('topics.show', $topic->slug) }}" class="block glass-card rounded-xl p-4 hover:border-blue-500/30 transition">
                                    <h4 class="font-bold text-white">{{ $topic->title }}</h4>
                                    <p class="text-sm text-slate-400">Por {{ $topic->user->name ?? 'Usuário' }} • {{ $topic->created_at->diffForHumans() }}</p>
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($posts->count() > 0)
                        <div>
                            <h3 class="text-lg font-bold text-white mb-3 flex items-center gap-2">
                                <i data-lucide="message-circle" class="w-5 h-5 text-emerald-400"></i>
                                Posts ({{ $posts->count() }})
                            </h3>
                            <div class="space-y-2">
                                @foreach($posts as $post)
                                <a href="{{ route('topics.show', $post->topic->slug) }}#post-{{ $post->id }}" class="block glass-card rounded-xl p-4 hover:border-blue-500/30 transition">
                                    <p class="text-slate-300 line-clamp-2">{{ Str::limit(strip_tags($post->body), 150) }}</p>
                                    <p class="text-sm text-slate-500 mt-2">Por {{ $post->user->name ?? 'Usuário' }} • {{ $post->created_at->diffForHumans() }}</p>
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($users->count() > 0)
                        <div>
                            <h3 class="text-lg font-bold text-white mb-3 flex items-center gap-2">
                                <i data-lucide="users" class="w-5 h-5 text-amber-400"></i>
                                Usuários ({{ $users->count() }})
                            </h3>
                            <div class="space-y-2">
                                @foreach($users as $user)
                                <a href="{{ route('profile', $user->username) }}" class="flex items-center gap-3 glass-card rounded-xl p-4 hover:border-blue-500/30 transition">
                                    <div class="w-10 h-10 rounded-xl bg-slate-700 flex items-center justify-center overflow-hidden">
                                        @if($user->avatar)
                                        <img src="{{ asset('storage/'.$user->avatar) }}" class="w-full h-full object-cover">
                                        @else
                                        <i data-lucide="user" class="w-5 h-5 text-slate-400"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-white">{{ $user->name }}</p>
                                        <p class="text-sm text-slate-500">@{{ $user->username }}</p>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($topics->count() === 0 && $posts->count() === 0 && $users->count() === 0)
                        <div class="glass-card rounded-xl p-12 text-center">
                            <i data-lucide="search-x" class="w-12 h-12 text-slate-600 mx-auto mb-4"></i>
                            <h4 class="text-lg font-bold text-white mb-2">Nenhum resultado encontrado</h4>
                            <p class="text-slate-500">Tente buscar por outros termos.</p>
                        </div>
                        @endif
                    </div>
                @endif
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>

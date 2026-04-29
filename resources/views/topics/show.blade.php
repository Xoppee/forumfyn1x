<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $topic->title }} - Fyn1x Forum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        
        .glass-card { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(12px); }
        .markdown-body h1, .markdown-body h2, .markdown-body h3 { font-weight: bold; margin-top: 1rem; margin-bottom: 0.5rem; }
        .markdown-body code { background: #1e293b; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-family: monospace; }
        .markdown-body pre { background: #1e293b; padding: 1rem; border-radius: 0.5rem; overflow-x: auto; }
        .markdown-body pre code { background: transparent; padding: 0; }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen">

    @include('components.sidebar')

    <div class="lg:ml-64 min-h-screen">
        <header class="sticky top-0 z-30 h-16 glass-card flex items-center justify-between px-6 border-b border-slate-800">
            <div class="flex items-center space-x-4">
                <a href="/" class="p-2 hover:bg-slate-800 rounded-xl transition">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <span class="text-slate-500 hidden md:block">/</span>
                <h2 class="text-lg font-bold text-white hidden md:block truncate max-w-md">{{ $topic->title }}</h2>
            </div>
            
            <div class="flex items-center space-x-3">
                @auth
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-xl bg-slate-700 flex items-center justify-center overflow-hidden">
                        @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/'.auth()->user()->avatar) }}" class="w-full h-full object-cover">
                        @else
                        <i data-lucide="user" class="w-4 h-4 text-slate-400"></i>
                        @endif
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
            <div class="max-w-4xl mx-auto space-y-6">
                <div class="glass-card rounded-2xl p-6">
                    <div class="flex items-start space-x-4 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-slate-700 flex items-center justify-center overflow-hidden flex-shrink-0">
                            @if($topic->user?->avatar)
                            <img src="{{ asset('storage/'.$topic->user->avatar) }}" class="w-full h-full object-cover">
                            @else
                            <i data-lucide="user" class="w-6 h-6 text-slate-400"></i>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h1 class="text-2xl md:text-3xl font-black text-white mb-1 flex items-center gap-2">
                                {{ $topic->title }}
                                @if($topic->user?->is_verified)
                                <i data-lucide="badge-check" class="w-5 h-5 text-blue-400"></i>
                                @endif
                            </h1>
                            <div class="flex items-center space-x-3 text-sm text-slate-500">
                                <span class="font-medium text-blue-400 flex items-center gap-1">
                                    {{ $topic->user->name ?? 'Usuário' }}
                                    @if($topic->user?->is_verified)
                                    <i data-lucide="badge-check" class="w-3 h-3"></i>
                                    @endif
                                </span>
                                <span>•</span>
                                <span>{{ $topic->created_at->format('d M, Y') }}</span>
                                @if($topic->is_sticky)
                                <span class="flex items-center space-x-1 text-blue-400">
                                    <i data-lucide="pin" class="w-3 h-3"></i>
                                    <span class="text-xs font-bold">FIXADO</span>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white flex items-center space-x-2">
                        <i data-lucide="message-circle" class="w-5 h-5 text-blue-400"></i>
                        <span>Respostas</span>
                        <span class="text-slate-500 text-sm font-normal">({{ $topic->posts->count() }})</span>
                    </h3>
                </div>

                <div class="space-y-4">
                    @forelse($topic->posts as $index => $post)
                    <div class="glass-card rounded-xl p-5" id="post-{{ $post->id }}">
                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 rounded-xl bg-slate-700 flex items-center justify-center overflow-hidden flex-shrink-0">
                                @if($post->user?->avatar)
                                <img src="{{ asset('storage/'.$post->user->avatar) }}" class="w-full h-full object-cover">
                                @else
                                <i data-lucide="user" class="w-5 h-5 text-slate-400"></i>
                                @endif
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-2 mb-2">
                                    <span class="font-bold text-slate-200 flex items-center gap-1">
                                        {{ $post->user->name ?? 'Usuário' }}
                                        @if($post->user?->is_verified)
                                        <i data-lucide="badge-check" class="w-3 h-3 text-blue-400"></i>
                                        @endif
                                    </span>
                                    @forelse($post->user->roles->take(2) as $role)
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $role->slug === 'founder' ? 'bg-amber-500/20 text-amber-400' : ($role->slug === 'admin' ? 'bg-red-500/20 text-red-400' : 'bg-blue-500/20 text-blue-400') }}">
                                        {{ $role->name }}
                                    </span>
                                    @empty
                                    @endforelse
                                    <span class="text-slate-600 text-xs">•</span>
                                    <span class="text-slate-500 text-xs">{{ $post->created_at->diffForHumans() }}</span>
                                </div>
                                
                                <div class="markdown-body text-slate-300 leading-relaxed" id="post-body-{{ $post->id }}"></div>
                                <script>document.getElementById('post-body-{{ $post->id }}').innerHTML = marked.parse(@js($post->body));</script>
                                
                                <div class="flex items-center space-x-4 mt-4">
                                    <button class="flex items-center space-x-2 text-slate-500 hover:text-blue-400 transition">
                                        <i data-lucide="heart" class="w-4 h-4"></i>
                                        <span class="text-sm">Curtir</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="glass-card rounded-xl p-12 text-center">
                        <i data-lucide="message-circle" class="w-12 h-12 text-slate-600 mx-auto mb-4"></i>
                        <p class="text-slate-500">Nenhuma resposta ainda.</p>
                    </div>
                    @endforelse
                </div>

                @auth
                <div class="glass-card rounded-xl p-6">
                    <h4 class="font-bold text-white mb-4">Adicionar Resposta</h4>
                    <form action="{{ route('posts.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                        <textarea name="body" rows="4" placeholder="Escreva sua resposta (markdown suportado)..." 
                            class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition resize-none"></textarea>
                        <div class="flex items-center justify-between mt-4">
                            <span class="text-xs text-slate-500">Markdown suportado</span>
                            <button type="submit" class="flex items-center space-x-2 px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl transition">
                                <i data-lucide="send" class="w-4 h-4"></i>
                                <span>Enviar Resposta</span>
                            </button>
                        </div>
                    </form>
                </div>
                @else
                <div class="glass-card rounded-xl p-6 text-center">
                    <p class="text-slate-400 mb-4">Entre para participar da discussão!</p>
                    <a href="{{ route('login') }}" class="inline-flex items-center space-x-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-500 rounded-xl font-bold transition">
                        <i data-lucide="log-in" class="w-5 h-5"></i>
                        <span>Entrar</span>
                    </a>
                </div>
                @endauth
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
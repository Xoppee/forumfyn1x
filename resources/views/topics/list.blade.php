<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tópicos - Fyn1x Forum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .topic-card:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3); }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen">

    @include('components.sidebar')

    <div class="lg:ml-64 min-h-screen">
        <header class="sticky top-0 z-30 h-16 glass-card flex items-center justify-between px-6 border-b border-slate-800">
            <div class="flex items-center space-x-4">
                <h2 class="text-lg font-bold text-white">Tópicos</h2>
            </div>
        </header>

        <main class="p-6 pb-20">
            <div class="max-w-4xl mx-auto space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-black text-white">Tópicos</h3>
                        <p class="text-slate-500">Escolha um tópico para participar</p>
                    </div>
                    @auth
                    <a href="{{ route('topics.create') }}" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl font-bold flex items-center gap-2">
                        <i data-lucide="plus-circle" class="w-5 h-5"></i>
                        Criar Tópico
                    </a>
                    @endauth
                </div>

                <div class="space-y-3">
                    @forelse($topics as $topic)
                    <a href="/topics/{{ $topic->slug }}" class="topic-card block glass-card rounded-xl p-5 hover:border-blue-500/30 transition-all duration-300">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-700 flex items-center justify-center overflow-hidden">
                                    @if($topic->user?->avatar)
                                    <img src="{{ asset('storage/'.$topic->user->avatar) }}" class="w-full h-full object-cover">
                                    @else
                                    <i data-lucide="user" class="w-5 h-5 text-slate-400"></i>
                                    @endif
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <span class="font-semibold text-slate-200">{{ $topic->user->name ?? 'Usuário' }}</span>
                                        @if($topic->user?->is_verified)
                                        <i data-lucide="badge-check" class="w-3 h-3 text-blue-400"></i>
                                        @endif
                                        <span class="text-slate-600 text-xs">•</span>
                                        <span class="text-slate-500 text-xs">{{ $topic->created_at->diffForHumans() }}</span>
                                    </div>
                                    <h4 class="text-base font-bold text-white mb-1 truncate flex items-center gap-2">
                                        {{ $topic->title }}
                                        @if($topic->is_sticky)
                                        <i data-lucide="pin" class="w-3 h-3 text-amber-400"></i>
                                        @endif
                                    </h4>
                                    <div class="flex items-center space-x-4 text-xs text-slate-500">
                                        <span class="flex items-center space-x-1">
                                            <i data-lucide="message-square" class="w-3.5 h-3.5"></i>
                                            <span>{{ $topic->posts->count() }} respostas</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="glass-card rounded-xl p-12 text-center">
                        <i data-lucide="message-square" class="w-12 h-12 text-slate-600 mx-auto mb-4"></i>
                        <h4 class="text-lg font-bold text-white mb-2">Nenhum tópico ainda</h4>
                        <p class="text-slate-500 mb-6">Seja o primeiro a iniciar uma discussão!</p>
                        @auth
                        <a href="{{ route('topics.create') }}" class="inline-flex items-center space-x-2 px-6 py-3 bg-blue-600 hover:bg-blue-500 rounded-xl font-bold transition">
                            <i data-lucide="plus-circle" class="w-5 h-5"></i>
                            <span>Criar Tópico</span>
                        </a>
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
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
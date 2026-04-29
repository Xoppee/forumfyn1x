<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->username }} - Fyn1x Forum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        .glass-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(71, 85, 105, 0.4);
        }

        .glow-blue {
            box-shadow: 0 0 40px rgba(59, 130, 246, 0.15);
        }
    </style>
</head>

<body class="bg-slate-950 text-slate-100 min-h-screen" x-data="{ searchOpen: false, searchQuery: '' }">

    @include('components.sidebar')

    <div class="lg:ml-64 min-h-screen">
        <header
            class="sticky top-0 z-30 h-16 glass-card flex items-center justify-between px-6 border-b border-slate-800">
            <div class="flex items-center space-x-4">
                <a href="/" class="p-2 hover:bg-slate-800/50 rounded-xl transition">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
            </div>

            <div class="flex-1 max-w-xl mx-8" x-show="searchOpen" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95">
                <form action="/search" method="GET" class="relative">
                    <input type="text" name="q" x-model="searchQuery"
                        placeholder="Pesquisar tópicos, posts, usuários..."
                        class="w-full pl-12 pr-4 py-2.5 bg-slate-800/50 border border-slate-700 rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition">
                    <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500"></i>
                </form>
            </div>

            <div class="flex items-center space-x-2">
                <button @click="searchOpen = !searchOpen" class="p-2.5 hover:bg-slate-800/50 rounded-xl transition"
                    :class="searchOpen ? 'bg-slate-800/50 text-blue-400' : 'text-slate-400'">
                    <i data-lucide="search" class="w-5 h-5"></i>
                </button>

                @auth
                    <a href="{{ route('profile.edit') }}"
                        class="p-2.5 hover:bg-slate-800/50 rounded-xl transition text-slate-400 hover:text-white">
                        <i data-lucide="settings" class="w-5 h-5"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-500 rounded-xl font-medium text-sm transition">
                        Entrar
                    </a>
                @endauth
            </div>
        </header>

        <main class="p-6">
            <div class="max-w-4xl mx-auto">
                <div class="relative mb-8">
                    <div class="h-48 md:h-64 rounded-2xl overflow-hidden bg-slate-800">
                        <img src="{{ $user->cover ? asset('storage/' . $user->cover) : 'https://images.unsplash.com/photo-1614850523296-d8c1af93d400?q=80&w=1000' }}"
                            alt="Capa" class="w-full h-full object-cover opacity-60">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/50 to-transparent">
                        </div>
                    </div>

                    <div class="absolute -bottom-16 left-6 md:left-8 flex items-end gap-4">
                        <div class="relative">
                            <div
                                class="w-28 h-28 md:w-32 md:h-32 rounded-2xl border-4 border-slate-950 overflow-hidden bg-slate-800 shadow-2xl">
                                <img src="{{ asset('storage/' . $user->avatar) ?? 'https://www.gravatar.com/avatar/' . md5($user->email) . '?d=mp&s=200' }}"
                                    alt="Avatar" class="w-full h-full object-cover">
                            </div>
                            @if ($user->current_level)
                                <div
                                    class="absolute -bottom-2 -right-2 bg-gradient-to-r from-blue-500 to-emerald-500 text-white text-xs font-bold px-3 py-1 rounded-full border-2 border-slate-950 shadow-lg">
                                    LVL {{ $user->current_level }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-20 md:mt-24 mb-8">
                    <div class="flex flex-col md:flex-row md:items-start gap-4">
                        <div class="flex-1">
                            <h1 class="text-2xl md:text-3xl font-black text-white mb-1">{{ $user->name }}</h1>

                            <div class="flex flex-wrap items-center gap-3 mb-3">
                                <span class="text-slate-400 text-lg">&#64;{{ $user->username }}</span>

                                @forelse($user->roles as $role)
                                    <span
                                        class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide
                                    {{ $role->slug === 'founder'
                                        ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30'
                                        : ($role->slug === 'admin'
                                            ? 'bg-red-500/20 text-red-400 border border-red-500/30'
                                            : ($role->slug === 'moderator'
                                                ? 'bg-blue-500/20 text-blue-400 border border-blue-500/30'
                                                : 'bg-slate-700 text-slate-300 border border-slate-600')) }}">
                                        <i data-lucide="{{ $role->icon ?? 'user' }}" class="w-3 h-3"></i>
                                        <span>{{ $role->name }}</span>
                                    </span>
                                @empty
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold bg-slate-700 text-slate-400 border border-slate-600">
                                        <i data-lucide="user" class="w-3 h-3"></i>
                                        <span>Usuário</span>
                                    </span>
                                @endforelse
                            </div>

                            <p class="text-slate-400 max-w-xl">
                                {{ $user->bio ?? 'Este usuário ainda não definiu uma biografia.' }}
                            </p>
                        </div>

                        <div class="flex items-center space-x-4">
                            @if(auth()->check() && auth()->user()->id !== $user->id)
                            <div class="glass-card rounded-xl px-5 py-3 text-center">
                                @if(auth()->user()->isFollowing($user))
                                <form action="{{ route('users.unfollow', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-bold text-red-400 hover:text-red-300 transition">
                                        Deixar de Seguir
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('users.follow', $user) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-sm font-bold text-blue-400 hover:text-blue-300 transition">
                                        Seguir
                                    </button>
                                </form>
                                @endif
                                <div class="text-xs text-slate-500 uppercase tracking-wide mt-1">Ação</div>
                            </div>
                            @endif
                            
                            <div class="glass-card rounded-xl px-5 py-3 text-center">
                                <div class="text-2xl font-black text-white">{{ $followers ?? 0 }}</div>
                                <div class="text-xs text-slate-500 uppercase tracking-wide">Seguidores</div>
                            </div>
                            <div class="glass-card rounded-xl px-5 py-3 text-center">
                                <div class="text-2xl font-black text-white">{{ $following ?? 0 }}</div>
                                <div class="text-xs text-slate-500 uppercase tracking-wide">Seguindo</div>
                            </div>
                            <div class="glass-card rounded-xl px-5 py-3 text-center">
                                <div class="text-2xl font-black text-white">{{ $user->posts->count() ?? 0 }}</div>
                                <div class="text-xs text-slate-500 uppercase tracking-wide">Posts</div>
                            </div>

                            @if($user->hasBlog())
                                <a href="{{ route('blog.show', $user->blog->slug ?? $user->username) }}" 
                                   class="glass-card rounded-xl px-5 py-3 text-center hover:border-blue-500/30 transition">
                                    <div class="text-2xl font-black text-blue-400"><i data-lucide="pen-tool" class="w-6 h-6 mx-auto"></i></div>
                                    <div class="text-xs text-slate-500 uppercase tracking-wide">Blog</div>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2 space-y-6">
                        <h3 class="text-lg font-bold text-white flex items-center space-x-2">
                            <i data-lucide="message-square" class="w-5 h-5 text-blue-400"></i>
                            <span>Publicações</span>
                        </h3>

                        @forelse($user->posts->take(10) as $post)
                            <a href="{{ route('topics.show', $post->topic->slug ?? '#') }}"
                                class="block glass-card rounded-xl p-5 hover:border-blue-500/30 transition">
                                <div class="flex items-start justify-between mb-2">
                                    <span
                                        class="text-sm text-slate-500">{{ $post->created_at->diffForHumans() }}</span>
                                    <span class="text-emerald-400 text-xs font-bold">TOPIC</span>
                                </div>
                                <h4 class="font-bold text-white mb-1">{{ $post->topic->title ?? 'Post' }}</h4>
                                <p class="text-slate-400 text-sm line-clamp-2">{{ Str::limit($post->body, 150) }}</p>
                            </a>
                        @empty
                            <div class="glass-card rounded-xl p-8 text-center">
                                <i data-lucide="message-square" class="w-12 h-12 text-slate-600 mx-auto mb-4"></i>
                                <p class="text-slate-500">Nenhuma publicação ainda.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-white flex items-center space-x-2">
                            <i data-lucide="shield" class="w-5 h-5 text-emerald-400"></i>
                            <span>Cargos</span>
                        </h3>

                        <div class="glass-card rounded-xl p-4 space-y-3">
                            @forelse($user->roles as $role)
                                <div class="flex items-center space-x-3 p-3 rounded-lg bg-slate-800/50">
                                    <div
                                        class="w-10 h-10 rounded-lg flex items-center justify-center
                                    {{ $role->slug === 'founder'
                                        ? 'bg-amber-500/20'
                                        : ($role->slug === 'admin'
                                            ? 'bg-red-500/20'
                                            : ($role->slug === 'moderator'
                                                ? 'bg-blue-500/20'
                                                : 'bg-slate-700')) }}">
                                        <i data-lucide="{{ $role->icon ?? 'user' }}"
                                            class="w-5 h-5 
                                        {{ $role->slug === 'founder'
                                            ? 'text-amber-400'
                                            : ($role->slug === 'admin'
                                                ? 'text-red-400'
                                                : ($role->slug === 'moderator'
                                                    ? 'text-blue-400'
                                                    : 'text-slate-400')) }}"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-white text-sm">{{ $role->name }}</div>
                                        <div class="text-xs text-slate-500">
                                            @forelse($role->permissions ?? [] as $perm)
                                                <span class="mr-1">•</span>
                                            @empty
                                                <span>Sem permissões</span>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-center text-slate-500 text-sm">
                                    Nenhum cargo atribuído
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Posts - Fyn1x Forum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                <a href="{{ route('profile', auth()->user()->username) }}" class="p-2 hover:bg-slate-800 rounded-xl transition">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <h2 class="text-lg font-bold text-white">Meus Posts</h2>
            </div>
            <a href="{{ route('blog.create') }}" class="flex items-center space-x-2 px-4 py-2 bg-blue-600 hover:bg-blue-500 rounded-xl font-bold text-sm transition">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Novo Post</span>
            </a>
        </header>

        <main class="p-6 pb-20">
            <div class="max-w-4xl mx-auto space-y-6">
                
                @forelse($posts as $post)
                    <div class="glass-card rounded-xl p-6 hover:border-blue-500/30 transition">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <h3 class="text-xl font-bold text-white mb-2">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-blue-400 transition">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="text-slate-400 text-sm">{{ Str::limit($post->summary, 100) ?? Str::limit(strip_tags($post->content), 100) }}</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('blog.edit', $post->slug) }}" class="p-2 hover:bg-slate-700 rounded-lg text-slate-400 transition">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('blog.destroy', $post->slug) }}" method="POST" onsubmit="return confirm('Tem certeza?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 hover:bg-red-500/10 rounded-lg text-red-400 transition">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 text-sm text-slate-500">
                            <span class="px-2 py-1 rounded-full {{ $post->is_published ? 'bg-emerald-500/20 text-emerald-400' : 'bg-slate-700 text-slate-400' }}">
                                {{ $post->is_published ? 'Publicado' : 'Rascunho' }}
                            </span>
                            <span>{{ $post->created_at->format('d M, Y') }}</span>
                            <span>{{ $post->template_id }}</span>
                        </div>
                    </div>
                @empty
                    <div class="glass-card rounded-xl p-12 text-center">
                        <i data-lucide="edit-3" class="w-12 h-12 text-slate-600 mx-auto mb-4"></i>
                        <h4 class="text-lg font-bold text-white mb-2">Nenhum post ainda</h4>
                        <p class="text-slate-500 mb-6">Crie seu primeiro post de blog usando nossos templates!</p>
                        <a href="{{ route('blog.create') }}" class="inline-flex items-center space-x-2 px-6 py-3 bg-blue-600 hover:bg-blue-500 rounded-xl font-bold transition">
                            <i data-lucide="plus-circle" class="w-5 h-5"></i>
                            <span>Criar Post</span>
                        </a>
                    </div>
                @endforelse

                <div class="mt-6">
                    {{ $posts->links() }}
                </div>
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>

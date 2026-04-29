<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} - Fyn1x Forum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        .glass-card { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(71, 85, 105, 0.4); }
        .markdown-body h1, .markdown-body h2, .markdown-body h3 { font-weight: bold; margin-top: 1rem; margin-bottom: 0.5rem; color: white; }
        .markdown-body p { color: #cbd5e1; margin-bottom: 1rem; line-height: 1.625; }
        .markdown-body code { background: #1e293b; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-family: monospace; color: #e2e8f0; }
        .markdown-body pre { background: #1e293b; padding: 1rem; border-radius: 0.5rem; overflow-x: auto; }
        .markdown-body pre code { background: transparent; padding: 0; }
        .markdown-body ul, .markdown-body ol { color: #cbd5e1; margin-left: 1.5rem; margin-bottom: 1rem; }
        .markdown-body a { color: #60a5fa; text-decoration: underline; }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen">

    @include('components.sidebar')

    <div class="lg:ml-64 min-h-screen">
        <header class="sticky top-0 z-30 h-16 glass-card flex items-center justify-between px-6 border-b border-slate-800">
            <div class="flex items-center space-x-4">
                <a href="{{ route('blog.index') }}" class="p-2 hover:bg-slate-800 rounded-xl transition">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <h2 class="text-lg font-bold text-white truncate max-w-md">{{ $post->title }}</h2>
            </div>

            @if(auth()->check() && auth()->id() === $post->user_id)
            <div class="flex items-center space-x-2">
                <a href="{{ route('blog.edit', $post->slug) }}" class="p-2 hover:bg-slate-800 rounded-xl transition text-slate-400">
                    <i data-lucide="edit" class="w-5 h-5"></i>
                </a>
                <form action="{{ route('blog.destroy', $post->slug) }}" method="POST" onsubmit="return confirm('Tem certeza?')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 hover:bg-red-500/10 rounded-xl transition text-red-400">
                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                    </button>
                </form>
            </div>
            @endif
        </header>

        <main class="p-6 pb-20">
            <div class="max-w-4xl mx-auto">
                <div class="glass-card rounded-2xl p-8">
                    <div class="mb-6">
                        <div class="flex items-center space-x-2 mb-3">
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-500/20 text-blue-400">
                                {{ $post->template_id }}
                            </span>
                            @if($post->is_published)
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-400">
                                Publicado
                            </span>
                            @else
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-700 text-slate-400">
                                Rascunho
                            </span>
                            @endif
                        </div>
                        <h1 class="text-3xl md:text-4xl font-black text-white mb-4">{{ $post->title }}</h1>
                        
                        @if($post->summary)
                        <p class="text-slate-400 text-lg mb-4">{{ $post->summary }}</p>
                        @endif

                        <div class="flex items-center space-x-4 text-sm text-slate-500">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 rounded-lg bg-slate-700 flex items-center justify-center overflow-hidden">
                                    @if($post->user->avatar)
                                    <img src="{{ asset('storage/'.$post->user->avatar) }}" class="w-full h-full object-cover">
                                    @else
                                    <i data-lucide="user" class="w-4 h-4 text-slate-400"></i>
                                    @endif
                                </div>
                                <span class="text-slate-300">{{ $post->user->name }}</span>
                            </div>
                            <span>•</span>
                            <span>{{ $post->created_at->format('d M, Y') }}</span>
                        </div>
                    </div>

                    @if($post->meta_fields && count($post->meta_fields) > 0)
                    <div class="mb-8 p-4 rounded-xl bg-slate-800/50 border border-slate-700">
                        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-3">Informações do Template</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($post->meta_fields as $key => $value)
                            <div class="p-3 rounded-lg bg-slate-800">
                                <span class="text-xs text-slate-500 uppercase">{{ $key }}</span>
                                <p class="text-sm text-white mt-1">{{ is_array($value) ? implode(', ', $value) : $value }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="markdown-body">
                        <div id="post-content"></div>
                        <script>
                            document.getElementById('post-content').innerHTML = marked.parse(@js($post->content));
                        </script>
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

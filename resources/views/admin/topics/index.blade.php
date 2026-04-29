@php
use Illuminate\Support\Str;
@endphp
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Tópicos | Fyn1x Forum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-950 text-slate-200 flex h-screen overflow-hidden" x-data="{ openModal: false, selectedPost: null, activeTab: 'posts', createModal: false, selectedTopic: null }">

    <aside class="w-72 bg-slate-900 border-r border-slate-800 flex flex-col hidden md:flex">
        <div class="h-16 flex items-center justify-center border-b border-slate-800">
            <h1 class="text-xl font-black tracking-tighter bg-gradient-to-r from-blue-400 to-emerald-400 bg-clip-text text-transparent italic">
                FYN1X ENGINE
            </h1>
        </div>

        <nav class="flex-1 p-6 space-y-8 overflow-y-auto">
            <div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-4">Núcleo</p>
                <div class="space-y-1">
                    <a href="{{ route('admin') }}" class="flex items-center space-x-3 p-3 rounded-xl text-slate-400 hover:bg-slate-800 transition group">
                        <i data-lucide="layout-dashboard" class="w-5 h-5 group-hover:text-white"></i>
                        <span class="text-sm font-medium group-hover:text-white">Dashboard</span>
                    </a>
                    <a href="{{ route('admin') }}" class="flex items-center space-x-3 p-3 rounded-xl text-slate-400 hover:bg-slate-800 transition group">
                        <i data-lucide="layers" class="w-5 h-5 group-hover:text-white"></i>
                        <span class="text-sm font-medium group-hover:text-white">Gerenciar Páginas</span>
                    </a>
                </div>
            </div>

            <div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-4">Comunidade</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.users') }}" class="flex items-center space-x-3 p-3 rounded-xl text-slate-400 hover:bg-slate-800 transition group">
                        <i data-lucide="users" class="w-5 h-5 group-hover:text-white"></i>
                        <span class="text-sm font-medium group-hover:text-white">Usuários</span>
                    </a>
                    <a href="{{ route('admin.topics') }}" class="flex items-center space-x-3 p-3 rounded-xl bg-blue-600/10 text-blue-400 border border-blue-600/20">
                        <i data-lucide="message-square" class="w-5 h-5"></i>
                        <span class="font-bold text-sm">Tópicos & Posts</span>
                    </a>
                    <a href="{{ route('admin.roles') }}" class="flex items-center space-x-3 p-3 rounded-xl text-slate-400 hover:bg-slate-800 transition group">
                        <i data-lucide="shield" class="w-5 h-5 group-hover:text-white"></i>
                        <span class="text-sm font-medium group-hover:text-white">Roles / Permissões</span>
                    </a>
                </div>
            </div>

            <div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-4">Mídia</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.images') }}" class="flex items-center space-x-3 p-3 rounded-xl text-slate-400 hover:bg-slate-800 transition group">
                        <i data-lucide="image" class="w-5 h-5 group-hover:text-white"></i>
                        <span class="text-sm font-medium group-hover:text-white">Imagens</span>
                    </a>
                    <a href="{{ route('admin.archives') }}" class="flex items-center space-x-3 p-3 rounded-xl text-slate-400 hover:bg-slate-800 transition group">
                        <i data-lucide="folder-archive" class="w-5 h-5 group-hover:text-white"></i>
                        <span class="text-sm font-medium group-hover:text-white">Archives (PDF/Docs)</span>
                    </a>
                </div>
            </div>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col overflow-hidden">
        
        <header class="h-16 border-b border-slate-800 flex items-center justify-between px-8 bg-slate-950/50 backdrop-blur-md">
            <div class="flex items-center space-x-4">
                <h2 class="text-sm font-bold text-slate-400">ADMIN / <span class="text-white">TÓPICOS & POSTS</span></h2>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <p class="text-xs font-bold text-white">Fyn1x Admin</p>
                    <p class="text-[10px] text-emerald-400 font-black uppercase tracking-widest">Sessão Ativa</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center text-blue-400 font-black italic">
                    F
                </div>
            </div>
        </header>

        <section class="flex-1 overflow-y-auto p-8">
            <div class="max-w-6xl mx-auto">
                
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                    <div>
                        <h3 class="text-2xl font-black text-white">Gerenciador de Tópicos & Posts</h3>
                        <p class="text-slate-500 text-sm">Moderarize conteúdos da comunidade.</p>
                    </div>
                    <button @click="createModal = true" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-2xl font-bold flex items-center space-x-2 transition-all shadow-xl shadow-blue-600/20 active:scale-95">
                        <i data-lucide="plus-circle" class="w-5 h-5"></i>
                        <span>Criar Tópico</span>
                    </button>
                </div>

                <div class="flex space-x-1 mb-6 bg-slate-800/50 p-1 rounded-xl w-fit">
                    <button @click="activeTab = 'topics'" :class="activeTab === 'topics' ? 'bg-blue-600 text-white' : 'text-slate-400 hover:text-white'" class="px-4 py-2 rounded-lg font-bold text-sm transition">
                        Tópicos ({{ $topics->count() }})
                    </button>
                    <button @click="activeTab = 'posts'" :class="activeTab === 'posts' ? 'bg-blue-600 text-white' : 'text-slate-400 hover:text-white'" class="px-4 py-2 rounded-lg font-bold text-sm transition">
                        Posts ({{ $posts->count() }})
                    </button>
                </div>

                <div x-show="activeTab === 'topics'" class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl">
                    <table class="w-full text-left">
                        <thead class="bg-slate-800/50 border-b border-slate-800">
                            <tr>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Tópico</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Autor</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Posts</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Criado</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse($topics as $topic)
                            <tr class="hover:bg-slate-800/30 transition">
                                <td class="px-6 py-4">
                                    <span class="font-bold text-slate-200">{{ $topic->title }}</span>
                                    <span class="text-blue-400 text-xs ml-2 font-mono">{{ '/topics/'.$topic->slug }}</span>
                                </td>
                                <td class="px-6 py-4 text-slate-400 text-sm">{{ $topic->user->name ?? $topic->user->username ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-400 text-sm">{{ $topic->posts->count() }}</td>
                                <td class="px-6 py-4 text-slate-400 text-xs">{{ $topic->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 flex items-center space-x-3">
                                    <a href="{{ route('topics.show', $topic->slug) }}" target="_blank" class="p-2 hover:bg-slate-700 rounded-lg text-slate-400 transition" title="Ver">
                                        <i data-lucide="external-link" class="w-4 h-4"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-500">Nenhum tópico encontrado.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    <div class="mt-6 px-6 pb-6">
                        {{ $topics->links() }}
                    </div>
                </div>
                
                <div x-show="activeTab === 'posts'" class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl">
                    <table class="w-full text-left">
                        <thead class="bg-slate-800/50 border-b border-slate-800">
                            <tr>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Conteúdo</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Autor</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Status</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse($posts as $post)
                            <tr class="hover:bg-slate-800/30 transition">
                                <td class="px-6 py-4">
                                    <span class="text-slate-300 text-sm line-clamp-2">{{ Str::limit($post->content ?? $post->body ?? 'Sem conteudo', 100) }}</span>
                                </td>
                                <td class="px-6 py-4 text-slate-400 text-sm">{{ $post->user->name ?? $post->user->username ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    @if($post->is_hidden ?? false)
                                    <span class="flex items-center space-x-1.5 text-amber-400 text-[10px] font-black uppercase bg-amber-400/10 px-3 py-1 rounded-full border border-amber-400/20 w-fit">
                                        <span class="w-1.5 h-1.5 bg-amber-400 rounded-full"></span>
                                        <span>Oulto</span>
                                    </span>
                                    @else
                                    <span class="flex items-center space-x-1.5 text-emerald-400 text-[10px] font-black uppercase bg-emerald-400/10 px-3 py-1 rounded-full border border-emerald-400/20 w-fit">
                                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>
                                        <span>Visível</span>
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 flex items-center space-x-3">
                                    <button @click="selectedPost = {{ json_encode($post) }}; openModal = true" class="p-2 hover:bg-slate-700 rounded-lg text-slate-400 transition" title="Ocultar/Restaurar">
                                        <i data-lucide="eye-off" class="w-4 h-4"></i>
                                    </button>
                                    <button @click="selectedPost = {{ json_encode($post) }}; openModal = true" class="p-2 hover:bg-red-500/10 rounded-lg text-red-500 transition" title="Excluir">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-500">Nenhum post encontrado.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </section>
    </main>

    <div x-show="openModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-6">
        <div x-show="openModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm" @click="openModal = false"></div>

        <div x-show="openModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="bg-slate-900 border border-slate-700 w-full max-w-md rounded-[2rem] shadow-2xl relative overflow-hidden">
            
            <div class="p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-black text-white italic">AÇÃO NO POST</h3>
                    <button @click="openModal = false" class="text-slate-500 hover:text-white transition"><i data-lucide="x" class="w-6 h-6"></i></button>
                </div>

                <div class="mb-6 p-4 bg-slate-800 rounded-xl">
                    <p class="text-slate-400 text-sm mb-2">Post de: <span class="text-white font-bold" x-text="selectedPost?.user?.name || selectedPost?.user?.username || '-'"></span></p>
                    <p class="text-slate-300 text-sm line-clamp-3" x-text="selectedPost?.content || selectedPost?.body || 'Sem conteúdo'"></p>
                </div>

                <div class="space-y-3">
                    <form :action="'/admin/posts/' + selectedPost?.id + '/toggle'" method="POST">
                        @csrf
                        <input type="hidden" name="is_hidden" :value="selectedPost?.is_hidden ? 0 : 1">
                        <button type="submit" class="w-full px-6 py-4 bg-amber-600 text-white font-bold rounded-xl hover:bg-amber-500 transition">
                            <span x-text="selectedPost?.is_hidden ? 'RESTAURAR POST' : 'OCULTAR POST'"></span>
                        </button>
                    </form>
                    
                    <form :action="'/admin/posts/' + selectedPost?.id" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-6 py-4 bg-red-600 text-white font-bold rounded-xl hover:bg-red-500 transition">
                            EXCLUIR POST
                        </button>
                    </form>
                </div>

                <button @click="openModal = false" class="w-full mt-4 px-6 py-4 border border-slate-700 text-slate-400 font-bold rounded-xl hover:bg-slate-800 transition">Cancelar</button>
            </div>
        </div>
    </div>

    <div x-show="createModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-6">
        <div x-show="createModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm" @click="createModal = false"></div>

        <div x-show="createModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="bg-slate-900 border border-slate-700 w-full max-w-md rounded-[2rem] shadow-2xl relative overflow-hidden">
            
            <div class="p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-black text-white italic">CRIAR NOVO TÓPICO</h3>
                    <button @click="createModal = false" class="text-slate-500 hover:text-white transition"><i data-lucide="x" class="w-6 h-6"></i></button>
                </div>

                <form action="{{ route('admin.topics.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] block mb-2">Título do Tópico</label>
                        <input type="text" name="title" required placeholder="Ex: Como otimizar queries no Laravel?" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 transition">
                    </div>

                    <div class="flex items-center space-x-3 pt-4">
                        <button type="button" @click="createModal = false" class="flex-1 px-6 py-4 border border-slate-700 text-slate-400 font-bold rounded-xl hover:bg-slate-800 transition">Cancelar</button>
                        <button type="submit" class="flex-1 px-6 py-4 bg-emerald-600 text-white font-black rounded-xl hover:bg-emerald-500 transition shadow-lg shadow-emerald-900/20">CRIAR TÓPICO</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
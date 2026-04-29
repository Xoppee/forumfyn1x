<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Master | Fyn1x Forum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-950 text-slate-200 flex h-screen overflow-hidden" x-data="{ openModal: false }">

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
                    <a href="{{ route('admin') }}" class="flex items-center space-x-3 p-3 rounded-xl bg-blue-600/10 text-blue-400 border border-blue-600/20">
                        <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                        <span class="font-bold text-sm">Dashboard</span>
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
                    <a href="{{ route('admin.topics') }}" class="flex items-center space-x-3 p-3 rounded-xl text-slate-400 hover:bg-slate-800 transition group">
                        <i data-lucide="message-square" class="w-5 h-5 group-hover:text-white"></i>
                        <span class="text-sm font-medium group-hover:text-white">Tópicos & Posts</span>
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
                <h2 class="text-sm font-bold text-slate-400">ADMIN / <span class="text-white">PÁGINAS</span></h2>
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
                        <h3 class="text-2xl font-black text-white">Gerenciador de Páginas</h3>
                        <p class="text-slate-500 text-sm">Controle as rotas condicionais e páginas dinâmicas do fórum.</p>
                    </div>
                    <button @click="openModal = true" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-2xl font-bold flex items-center space-x-2 transition-all shadow-xl shadow-blue-600/20 active:scale-95">
                        <i data-lucide="plus-circle" class="w-5 h-5"></i>
                        <span>Criar Nova Página</span>
                    </button>
                </div>

                <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl">
                    <table class="w-full text-left">
                        <thead class="bg-slate-800/50 border-b border-slate-800">
                            <tr>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Título</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Slug / Rota</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Visibilidade</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @foreach($pages as $page)
                            <tr class="hover:bg-slate-800/30 transition">
                                <td class="px-6 py-4 font-bold text-slate-200">{{ $page->title }}</td>
                                <td class="px-6 py-4">
                                    <span class="text-blue-400 font-mono text-xs px-2 py-1 bg-blue-400/10 rounded-lg">{{ '/'.$page->slug }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="flex items-center space-x-1.5 text-emerald-400 text-[10px] font-black uppercase bg-emerald-400/10 px-3 py-1 rounded-full border border-emerald-400/20 w-fit">
                                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>
                                        <span>{{ $page->is_published ? 'Publicada' : 'Rascunho' }}</span>
                                    </span>
                                </td>
                                <td class="px-6 py-4 flex items-center space-x-3">
                                    <a href="{{ route('admin.pages.edit', $page) }}" class="p-2 hover:bg-slate-700 rounded-lg text-slate-400 transition" title="Editar"><i data-lucide="edit-3" class="w-4 h-4"></i></a>
                                    <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" onsubmit="return confirm('Tem certeza?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 hover:bg-red-500/10 rounded-lg text-red-500 transition" title="Excluir"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </section>
    </main>

    <div x-show="openModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-6">
        <div x-show="openModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm" @click="openModal = false"></div>

        <div x-show="openModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="bg-slate-900 border border-slate-700 w-full max-w-xl rounded-[2rem] shadow-2xl relative overflow-hidden">
            
            <div class="p-8">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xl font-black text-white italic">CONFIGURAR NOVA PÁGINA</h3>
                    <button @click="openModal = false" class="text-slate-500 hover:text-white transition"><i data-lucide="x" class="w-6 h-6"></i></button>
                </div>

                <form action="{{ route('admin.pages.create') }}" method="POST" class="space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] block mb-2">Título da Página</label>
                            <input type="text" name="title" required placeholder="Ex: Galeria de Projetos" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 transition">
                        </div>
                        
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] block mb-2">Slug (URL)</label>
                            <input type="text" name="slug" required placeholder="galeria-projetos" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 transition">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] block mb-2">Ícone</label>
                            <input type="text" name="icon" required placeholder="Ex: file-text" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 transition">
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] block mb-2">Visibilidade</label>
                            <select name="is_published" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 transition appearance-none">
                                <option value="0">Rascunho (Privado)</option>
                                <option value="1">Publicada (Público)</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 pt-4">
                        <button type="button" @click="openModal = false" class="flex-1 px-6 py-4 border border-slate-700 text-slate-400 font-bold rounded-xl hover:bg-slate-800 transition">Cancelar</button>
                        <button type="submit" class="flex-1 px-6 py-4 bg-emerald-600 text-white font-black rounded-xl hover:bg-emerald-500 transition shadow-lg shadow-emerald-900/20">SALVAR PÁGINA</button>
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
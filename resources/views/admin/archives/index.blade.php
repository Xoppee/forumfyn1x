<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Archives | Fyn1x Forum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-950 text-slate-200 flex h-screen overflow-hidden" x-data="{ openModal: false, selectedArchive: null }">

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
                    <a href="{{ route('admin.archives') }}" class="flex items-center space-x-3 p-3 rounded-xl bg-blue-600/10 text-blue-400 border border-blue-600/20">
                        <i data-lucide="folder-archive" class="w-5 h-5"></i>
                        <span class="font-bold text-sm">Archives (PDF/Docs)</span>
                    </a>
                </div>
            </div>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col overflow-hidden">
        
        <header class="h-16 border-b border-slate-800 flex items-center justify-between px-8 bg-slate-950/50 backdrop-blur-md">
            <div class="flex items-center space-x-4">
                <h2 class="text-sm font-bold text-slate-400">ADMIN / <span class="text-white">ARCHIVES (PDF/DOCS)</span></h2>
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
                        <h3 class="text-2xl font-black text-white">Gerenciador de Archives</h3>
                        <p class="text-slate-500 text-sm">Gerencie arquivos PDF e documentos enviados.</p>
                    </div>
                </div>

                <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl">
                    <table class="w-full text-left">
                        <thead class="bg-slate-800/50 border-b border-slate-800">
                            <tr>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Arquivo</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Tipo</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Tamanho</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Enviado por</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse($archives as $archive)
                            <tr class="hover:bg-slate-800/30 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-xl bg-red-500/10 border border-red-500/20 flex items-center justify-center">
                                            <i data-lucide="file-text" class="w-5 h-5 text-red-400"></i>
                                        </div>
                                        <span class="font-bold text-slate-200">{{ $archive->name ?? $archive->filename ?? 'Arquivo' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-slate-400 text-xs font-mono">{{ strtoupper($archive->extension ?? 'FILE') }}</span>
                                </td>
                                <td class="px-6 py-4 text-slate-400 text-sm">
                                    {{ isset($archive->size) ? round($archive->size / 1024, 1) . ' KB' : '-' }}
                                </td>
                                <td class="px-6 py-4 text-slate-400 text-sm">
                                    {{ $archive->user->name ?? $archive->user->username ?? '-' }}
                                </td>
                                <td class="px-6 py-4 flex items-center space-x-3">
                                    @if($archive->path ?? $archive->url ?? $archive->filename)
                                    <a href="{{ $archive->path ?? asset('storage/'.$archive->filename) }}" target="_blank" class="p-2 hover:bg-slate-700 rounded-lg text-slate-400 transition" title="Baixar">
                                        <i data-lucide="download" class="w-4 h-4"></i>
                                    </a>
                                    @endif
                                    <button @click="selectedArchive = {{ json_encode($archive) }}; openModal = true" class="p-2 hover:bg-red-500/10 rounded-lg text-red-500 transition" title="Excluir">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                    <i data-lucide="folder-archive" class="w-12 h-12 text-slate-600 mx-auto mb-4"></i>
                                    <p>Nenhum archive encontrado.</p>
                                </td>
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
                    <h3 class="text-xl font-black text-white italic">EXCLUIR ARQUIVO</h3>
                    <button @click="openModal = false" class="text-slate-500 hover:text-white transition"><i data-lucide="x" class="w-6 h-6"></i></button>
                </div>

                <div class="mb-6 p-4 bg-slate-800 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-xl bg-red-500/10 border border-red-500/20 flex items-center justify-center">
                            <i data-lucide="file-text" class="w-6 h-6 text-red-400"></i>
                        </div>
                        <div>
                            <p class="font-bold text-white" x-text="selectedArchive?.name || selectedArchive?.filename || 'Arquivo'"></p>
                            <p class="text-slate-500 text-sm" x-text="selectedArchive?.extension ? selectedArchive.extension.toUpperCase() : 'FILE'"></p>
                        </div>
                    </div>
                </div>

                <p class="text-red-400 text-sm text-center mb-4">Esta ação não pode ser desfeita. O arquivo será excluído permanentemente.</p>

                <form :action="'/admin/archives/' + selectedArchive?.id" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex items-center space-x-3 pt-2">
                        <button type="button" @click="openModal = false" class="flex-1 px-6 py-4 border border-slate-700 text-slate-400 font-bold rounded-xl hover:bg-slate-800 transition">Cancelar</button>
                        <button type="submit" class="flex-1 px-6 py-4 bg-red-600 text-white font-black rounded-xl hover:bg-red-500 transition shadow-lg shadow-red-900/20">EXCLUIR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

                    <div class="mt-6 px-6 pb-6">
                        {{ $archives->links() }}
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
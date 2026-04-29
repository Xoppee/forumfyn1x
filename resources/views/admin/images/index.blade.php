<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Imagens | Fyn1x Forum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-950 text-slate-200 flex h-screen overflow-hidden" x-data="{ openModal: false, selectedImage: null }">

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
                    <a href="{{ route('admin.images') }}" class="flex items-center space-x-3 p-3 rounded-xl bg-blue-600/10 text-blue-400 border border-blue-600/20">
                        <i data-lucide="image" class="w-5 h-5"></i>
                        <span class="font-bold text-sm">Imagens</span>
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
                <h2 class="text-sm font-bold text-slate-400">ADMIN / <span class="text-white">IMAGENS</span></h2>
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
                        <h3 class="text-2xl font-black text-white">Gerenciador de Imagens</h3>
                        <p class="text-slate-500 text-sm">Gerencie imagens enviadas pelos usuários.</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @forelse($images as $image)
                    <div class="group relative bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
                        <div class="aspect-square bg-slate-800 flex items-center justify-center">
                            @if($image->path ?? $image->url ?? $image->filename)
                            <img src="{{ $image->path ?? $image->url ?? asset('storage/'.$image->filename) }}" alt="{{ $image->name ?? 'Imagem' }}" class="w-full h-full object-cover">
                            @else
                            <i data-lucide="image" class="w-8 h-8 text-slate-600"></i>
                            @endif
                        </div>
                        <div class="p-3">
                            <p class="text-xs text-slate-400 truncate">{{ $image->name ?? $image->filename ?? 'Sem nome' }}</p>
                        </div>
                        <div class="absolute inset-0 bg-slate-950/80 opacity-0 group-hover:opacity-100 transition flex items-center justify-center space-x-2">
                            <button @click="selectedImage = {{ json_encode($image) }}; openModal = true" class="p-2 bg-red-600 hover:bg-red-500 rounded-lg text-white transition" title="Excluir">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full bg-slate-900 border border-slate-800 rounded-3xl p-12 text-center">
                        <i data-lucide="image-off" class="w-12 h-12 text-slate-600 mx-auto mb-4"></i>
                        <p class="text-slate-500">Nenhuma imagem encontrada.</p>
                    </div>
                    @endforelse
                </div>

            </div>
        </section>
    </main>

    <div x-show="openModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-6">
        <div x-show="openModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm" @click="openModal = false"></div>

        <div x-show="openModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="bg-slate-900 border border-slate-700 w-full max-w-md rounded-[2rem] shadow-2xl relative overflow-hidden">
            
            <div class="p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-black text-white italic">EXCLUIR IMAGEM</h3>
                    <button @click="openModal = false" class="text-slate-500 hover:text-white transition"><i data-lucide="x" class="w-6 h-6"></i></button>
                </div>

                <div class="mb-6 p-4 bg-slate-800 rounded-xl">
                    <div class="aspect-video bg-slate-700 rounded-lg flex items-center justify-center">
                        <i data-lucide="image" class="w-8 h-8 text-slate-500"></i>
                    </div>
                    <p class="mt-2 text-white font-bold" x-text="selectedImage?.name || selectedImage?.filename || 'Imagem'"></p>
                </div>

                <p class="text-red-400 text-sm text-center mb-4">Esta ação não pode ser desfeita. A imagem será excluída permanentemente.</p>

                <form :action="'/admin/images/' + selectedImage?.id" method="POST">
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
                        {{ $images->links() }}
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
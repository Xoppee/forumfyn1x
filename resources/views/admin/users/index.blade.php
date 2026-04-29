<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários | Fyn1x Forum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-950 text-slate-200 flex h-screen overflow-hidden" x-data="{ openModal: false, selectedUser: null }">

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
                    <a href="{{ route('admin.users') }}" class="flex items-center space-x-3 p-3 rounded-xl bg-blue-600/10 text-blue-400 border border-blue-600/20">
                        <i data-lucide="users" class="w-5 h-5"></i>
                        <span class="font-bold text-sm">Usuários</span>
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
                <h2 class="text-sm font-bold text-slate-400">ADMIN / <span class="text-white">USUÁRIOS</span></h2>
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
                
                <div class="mb-8">
                    <h3 class="text-2xl font-black text-white">Gerenciador de Usuários</h3>
                    <p class="text-slate-500 text-sm">Controle e modere os usuários do fórum.</p>
                </div>

                <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl">
                    <table class="w-full text-left">
                        <thead class="bg-slate-800/50 border-b border-slate-800">
                            <tr>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Usuário</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Email</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Função</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Status</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @foreach($users as $user)
                            <tr class="hover:bg-slate-800/30 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center overflow-hidden">
                                            @if($user->avatar)
                                            <img src="{{ asset('storage/'.$user->avatar) }}" class="w-full h-full object-cover">
                                            @else
                                            <i data-lucide="user" class="w-5 h-5 text-slate-400"></i>
                                            @endif
                                        </div>
                                        <span class="font-bold text-slate-200 flex items-center gap-1">
                                            {{ $user->name ?? $user->username ?? 'Sem nome' }}
                                            @if($user->is_verified)
                                            <i data-lucide="badge-check" class="w-3.5 h-3.5 text-blue-400"></i>
                                            @endif
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-400 text-sm">{{ $user->email ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="text-blue-400 text-xs font-bold px-2 py-1 bg-blue-400/10 rounded-lg">
                                        {{ $user->roles->first()?->name ?? 'Usuário' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->is_banned ?? false)
                                    <span class="flex items-center space-x-1.5 text-red-400 text-[10px] font-black uppercase bg-red-400/10 px-3 py-1 rounded-full border border-red-400/20 w-fit">
                                        <span class="w-1.5 h-1.5 bg-red-400 rounded-full"></span>
                                        <span>Banido</span>
                                    </span>
                                    @else
                                    <span class="flex items-center space-x-1.5 text-emerald-400 text-[10px] font-black uppercase bg-emerald-400/10 px-3 py-1 rounded-full border border-emerald-400/20 w-fit">
                                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>
                                        <span>Ativo</span>
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 flex items-center space-x-3">
                                    <button @click="selectedUser = {{ json_encode($user) }}; openModal = true" class="p-2 hover:bg-slate-700 rounded-lg text-slate-400 transition" title="Banir/Desbanir">
                                        <i data-lucide="ban" class="w-4 h-4"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="mt-6 px-6 pb-6">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </section>
    </main>

    <div x-show="openModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-6">
        <div x-show="openModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm" @click="openModal = false"></div>

        <div x-show="openModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="bg-slate-900 border border-slate-700 w-full max-w-md rounded-[2rem] shadow-2xl relative overflow-hidden">
            
            <div class="p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-black text-white italic">BANIR USUÁRIO</h3>
                    <button @click="openModal = false" class="text-slate-500 hover:text-white transition"><i data-lucide="x" class="w-6 h-6"></i></button>
                </div>

                <div class="mb-6 p-4 bg-slate-800 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-xl bg-slate-700 border border-slate-600 flex items-center justify-center text-blue-400 font-black italic text-lg">
                            <span x-text="selectedUser ? (selectedUser.name || selectedUser.username || 'U').charAt(0).toUpperCase() : ''"></span>
                        </div>
                        <div>
                            <p class="font-bold text-white" x-text="selectedUser?.name || selectedUser?.username || 'Usuário'"></p>
                            <p class="text-slate-400 text-sm" x-text="selectedUser?.email || '-'"></p>
                        </div>
                    </div>
                </div>

                <form :action="'/admin/users/' + selectedUser?.id + '/ban'" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="is_banned" :value="selectedUser?.is_banned ? 0 : 1">
                    
                    <p class="text-slate-400 text-sm text-center mb-4" x-text="selectedUser?.is_banned ? 'Este usuário será DESBANIDO e poderá acessar o fórum novamente.' : 'Este usuário será BANIDO e perderá acesso ao fórum.'"></p>

                    <div class="flex items-center space-x-3 pt-2">
                        <button type="button" @click="openModal = false" class="flex-1 px-6 py-4 border border-slate-700 text-slate-400 font-bold rounded-xl hover:bg-slate-800 transition">Cancelar</button>
                        <button type="submit" class="flex-1 px-6 py-4 bg-red-600 text-white font-black rounded-xl hover:bg-red-500 transition shadow-lg shadow-red-900/20" x-text="selectedUser?.is_banned ? 'DESBANIR' : 'BANIR'"></button>
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
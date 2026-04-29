<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Roles | Fyn1x Forum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-950 text-slate-200 flex h-screen overflow-hidden" x-data="{ openModal: false, selectedRole: null, createModal: false }">

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
                    <a href="{{ route('admin.roles') }}" class="flex items-center space-x-3 p-3 rounded-xl bg-blue-600/10 text-blue-400 border border-blue-600/20">
                        <i data-lucide="shield" class="w-5 h-5"></i>
                        <span class="font-bold text-sm">Roles / Permissões</span>
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
                <h2 class="text-sm font-bold text-slate-400">ADMIN / <span class="text-white">ROLES & PERMISSÕES</span></h2>
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
                        <h3 class="text-2xl font-black text-white">Gerenciador de Roles & Permissões</h3>
                        <p class="text-slate-500 text-sm">Controle permissões e níveis de acesso.</p>
                    </div>
                    <button @click="createModal = true" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-2xl font-bold flex items-center space-x-2 transition-all shadow-xl shadow-blue-600/20 active:scale-95">
                        <i data-lucide="plus-circle" class="w-5 h-5"></i>
                        <span>Criar Nova Role</span>
                    </button>
                </div>

                <div class="grid gap-6">
                    @forelse($roles as $role)
                    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-2xl">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 rounded-xl bg-blue-600/10 border border-blue-600/20 flex items-center justify-center">
                                    <i data-lucide="shield" class="w-6 h-6 text-blue-400"></i>
                                </div>
                                <div>
                                    <h4 class="font-black text-white text-lg">{{ $role->name }}</h4>
                                    <p class="text-slate-500 text-sm">{{ $role->users->count() }} usuário(s) com esta role</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                @if($role->is_active ?? true)
                                <span class="flex items-center space-x-1.5 text-emerald-400 text-[10px] font-black uppercase bg-emerald-400/10 px-3 py-1 rounded-full border border-emerald-400/20">
                                    <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>
                                    <span>Ativa</span>
                                </span>
                                @else
                                <span class="flex items-center space-x-1.5 text-red-400 text-[10px] font-black uppercase bg-red-400/10 px-3 py-1 rounded-full border border-red-400/20">
                                    <span class="w-1.5 h-1.5 bg-red-400 rounded-full"></span>
                                    <span>Inativa</span>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="bg-slate-800/50 rounded-xl p-4 mb-4">
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-2">Permissões</p>
                            <div class="flex flex-wrap gap-2">
                                @forelse($role->permissions ?? [] as $perm)
                                <span class="text-xs font-medium text-blue-400 bg-blue-400/10 px-2 py-1 rounded-lg">{{ $perm }}</span>
                                @empty
                                <span class="text-slate-500 text-sm">Nenhuma permissão definida.</span>
                                @endforelse
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="text-sm">
                                <span class="text-slate-500">Usuários: </span>
                                <span class="text-white font-bold">{{ $role->users->pluck('name')->join(', ') ?: 'Nenhum' }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button @click="selectedRole = {{ json_encode($role) }}; openModal = true" class="p-2 hover:bg-slate-700 rounded-lg text-slate-400 transition" title="Ativar/Inativar">
                                    <i data-lucide="toggle-left" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-12 text-center">
                        <i data-lucide="shield-off" class="w-12 h-12 text-slate-600 mx-auto mb-4"></i>
                        <p class="text-slate-500">Nenhuma role encontrada.</p>
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
                    <h3 class="text-xl font-black text-white italic">ALTERAR STATUS</h3>
                    <button @click="openModal = false" class="text-slate-500 hover:text-white transition"><i data-lucide="x" class="w-6 h-6"></i></button>
                </div>

                <div class="mb-6 p-4 bg-slate-800 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-xl bg-blue-600/10 border border-blue-600/20 flex items-center justify-center">
                            <i data-lucide="shield" class="w-6 h-6 text-blue-400"></i>
                        </div>
                        <div>
                            <p class="font-bold text-white text-lg" x-text="selectedRole?.name"></p>
                            <p class="text-slate-500 text-sm" x-text="selectedRole?.users?.length + ' usuário(s)'"></p>
                        </div>
                    </div>
                </div>

                <p class="text-slate-400 text-sm text-center mb-4" x-text="selectedRole?.is_active ? 'Esta role será INATIVADA e perderá acesso ao sistema.' : 'Esta role será ATIVADA e terá acesso ao sistema.'"></p>

                <form :action="'/admin/roles/' + selectedRole?.id + '/toggle'" method="POST" class="space-y-3">
                    @csrf
                    <input type="hidden" name="is_active" :value="selectedRole?.is_active ? 0 : 1">
                    
                    <div class="flex items-center space-x-3 pt-2">
                        <button type="button" @click="openModal = false" class="flex-1 px-6 py-4 border border-slate-700 text-slate-400 font-bold rounded-xl hover:bg-slate-800 transition">Cancelar</button>
                        <button type="submit" class="flex-1 px-6 py-4 bg-blue-600 text-white font-black rounded-xl hover:bg-blue-500 transition shadow-lg shadow-blue-900/20" x-text="selectedRole?.is_active ? 'INATIVAR' : 'ATIVAR'"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div x-show="createModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-6">
        <div x-show="createModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm" @click="createModal = false"></div>

        <div x-show="createModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="bg-slate-900 border border-slate-700 w-full max-w-2xl rounded-[2rem] shadow-2xl relative overflow-hidden max-h-[90vh] overflow-y-auto">
            
            <div class="p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-black text-white italic">CRIAR NOVA ROLE</h3>
                    <button @click="createModal = false" class="text-slate-500 hover:text-white transition"><i data-lucide="x" class="w-6 h-6"></i></button>
                </div>

                <form action="{{ route('admin.roles.store') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] block mb-2">Nome da Role</label>
                            <input type="text" name="name" required placeholder="Ex: Administrador" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 transition">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] block mb-2">Slug</label>
                            <input type="text" name="slug" required placeholder="Ex: admin" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 transition">
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] block mb-2">Ícone (Lucide)</label>
                        <input type="text" name="icon" placeholder="shield" value="shield" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 transition">
                    </div>

                    <div>
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] block mb-2">Permissões</label>
                        <div class="grid grid-cols-3 gap-2 max-h-40 overflow-y-auto p-3 bg-slate-800/50 rounded-xl border border-slate-700">
                            @php
                            $permissions = [
                                'manage_users' => 'Gerenciar Usuários',
                                'manage_posts' => 'Gerenciar Posts',
                                'manage_topics' => 'Gerenciar Tópicos',
                                'manage_roles' => 'Gerenciar Roles',
                                'manage_pages' => 'Gerenciar Páginas',
                                'manage_images' => 'Gerenciar Imagens',
                                'manage_archives' => 'Gerenciar Arquivos',
                                'ban_users' => 'Banir Usuários',
                                'delete_content' => 'Excluir Conteúdo',
                                'edit_content' => 'Editar Conteúdo',
                                'view_admin' => 'Acessar Admin',
                                'moderator' => 'Moderador'
                            ];
                            @endphp
                            @foreach($permissions as $perm => $label)
                            <label class="flex items-center space-x-2 p-2 rounded-lg hover:bg-slate-700 cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="{{ $perm }}" class="rounded bg-slate-700 border-slate-600 text-blue-500 focus:ring-blue-500">
                                <span class="text-xs text-slate-300">{{ $label }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] block mb-2">Atribuir a Usuários</label>
                        <div class="max-h-60 overflow-y-auto p-3 bg-slate-800/50 rounded-xl border border-slate-700 space-y-1">
                            @forelse($users as $user)
                            <label class="flex items-center space-x-3 p-2 rounded-lg hover:bg-slate-700 cursor-pointer transition">
                                <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="rounded bg-slate-700 border-slate-600 text-blue-500 focus:ring-blue-500">
                                <div class="w-8 h-8 rounded-lg bg-slate-700 border border-slate-600 flex items-center justify-center text-blue-400 font-black italic text-xs overflow-hidden">
                                    @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->username }}" class="w-full h-full object-cover">
                                    @else
                                    {{ strtoupper(substr($user->name ?? $user->username ?? 'U', 0, 1)) }}
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-slate-200 truncate">{{ $user->name ?? $user->username ?? 'Sem nome' }}</p>
                                    <p class="text-xs text-slate-500 truncate">{{ $user->email }}</p>
                                </div>
                            </label>
                            @empty
                            <p class="text-slate-500 text-sm p-2">Nenhum usuário encontrado.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 pt-4">
                        <button type="button" @click="createModal = false" class="flex-1 px-6 py-4 border border-slate-700 text-slate-400 font-bold rounded-xl hover:bg-slate-800 transition">Cancelar</button>
                        <button type="submit" class="flex-1 px-6 py-4 bg-emerald-600 text-white font-black rounded-xl hover:bg-emerald-500 transition shadow-lg shadow-emerald-900/20">CRIAR ROLE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

                    <div class="mt-6 px-6 pb-6">
                        {{ $users->links() }}
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
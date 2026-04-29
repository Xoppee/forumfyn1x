<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - Fyn1x Forum</title>
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
                <h2 class="text-lg font-bold text-white">Editar Perfil</h2>
            </div>
        </header>

        <main class="p-6 pb-20">
            <div class="max-w-3xl mx-auto">
                
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <div class="glass-card rounded-2xl p-6">
                        <div class="relative group">
                            <div class="h-48 w-full rounded-2xl bg-slate-800 border border-slate-700 overflow-hidden relative">
                                <img id="cover-preview" 
                                     src="{{ $user->cover ? asset('storage/'.$user->cover) : 'https://images.unsplash.com/photo-1614850523296-d8c1af93d400?q=80&w=1000' }}" 
                                     class="w-full h-full object-cover opacity-60">
                                
                                <button type="button" onclick="document.getElementById('cover-input').click()" 
                                        class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition">
                                    <span class="bg-slate-800 px-3 py-1 rounded text-xs uppercase font-bold tracking-wider border border-slate-700">Alterar Capa</span>
                                </button>
                                <input type="file" name="cover" id="cover-input" class="hidden" accept="image/*">
                            </div>

                            <div class="absolute -bottom-6 left-8 flex items-end">
                                <div class="relative group/avatar">
                                    <div class="w-24 h-24 rounded-2xl border-4 border-slate-950 bg-slate-800 overflow-hidden shadow-2xl">
                                        <img id="avatar-preview" 
                                             src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://www.gravatar.com/avatar/'.md5($user->email).'?d=mp' }}" 
                                             class="w-full h-full object-cover">
                                    </div>
                                    <button type="button" onclick="document.getElementById('avatar-input').click()" 
                                            class="absolute inset-0 bg-black/60 flex items-center justify-center rounded-2xl opacity-0 group-hover/avatar:opacity-100 transition">
                                        <i data-lucide="camera" class="w-6 h-6 text-white"></i>
                                    </button>
                                    <input type="file" name="avatar" id="avatar-input" class="hidden" accept="image/*">
                                </div>
                            </div>
                        </div>

                        <div class="mt-10 grid grid-cols-1 gap-6">
                            
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-400 uppercase tracking-wider">Nome Público</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                       class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition">
                                @error('name') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-400 uppercase tracking-wider">Endereço de E-mail</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                       class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition">
                                @error('email') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-400 uppercase tracking-wider">Biografia (Markdown disponível)</label>
                                <textarea name="bio" rows="5" 
                                          class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition">{{ old('bio', $user->bio) }}</textarea>
                                <div class="flex justify-between">
                                    @error('bio') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                                    <p class="text-slate-600 text-xs uppercase font-bold tracking-tighter">Max 1000 caracteres</p>
                                </div>
                            </div>

                            <div class="glass-card rounded-xl p-6">
                                <h3 class="text-lg font-bold text-white mb-4">Blog</h3>
                                <p class="text-slate-400 text-sm mb-4">Ative ou desative seu blog pessoal. Quando ativado, você poderá criar posts usando templates JSON.</p>
                                
                                @if(auth()->user()->hasBlog())
                                    <form action="{{ route('profile.blog.disable') }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="flex items-center space-x-2 bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded-lg font-medium transition">
                                            <i data-lucide="x-circle" class="w-4 h-4"></i>
                                            <span>Desativar Blog</span>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('profile.blog.enable') }}" method="POST" class="space-y-4">
                                        @csrf
                                        <div class="space-y-2">
                                            <label class="text-sm font-bold text-slate-400 uppercase tracking-wider">Descrição do Blog (opcional)</label>
                                            <textarea name="description" rows="3" 
                                                      class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition" 
                                                      placeholder="Conte um pouco sobre seu blog..."></textarea>
                                        </div>
                                        <button type="submit" class="flex items-center space-x-2 bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded-lg font-medium transition">
                                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                                            <span>Ativar Blog</span>
                                        </button>
                                    </form>
                                @endif
                            </div>

                        </div>

                        <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-slate-800">
                            <a href="{{ route('profile', auth()->user()->username) }}" class="text-slate-400 hover:text-white font-medium transition">
                                Cancelar
                            </a>
                            <button type="submit" class="flex items-center space-x-2 bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl font-bold transition shadow-lg shadow-blue-900/20">
                                <i data-lucide="save" class="w-4 h-4"></i>
                                <span>Salvar Alterações</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
        
        function setupPreview(inputId, previewId) {
            document.getElementById(inputId).onchange = evt => {
                const [file] = evt.target.files;
                if (file) {
                    document.getElementById(previewId).src = URL.createObjectURL(file);
                }
            }
        }
        setupPreview('avatar-input', 'avatar-preview');
        setupPreview('cover-input', 'cover-preview');
    </script>
</body>
</html>
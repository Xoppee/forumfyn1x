<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Grupos - Fyn1x Forum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-card { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(12px); }
    </style>
</head>
<body class="bg-slate-950 text-slate-200 min-h-screen">

    @include('components.sidebar')
    
    <div class="lg:ml-64 min-h-screen">
        <header class="h-16 glass-card border-b border-slate-800 flex items-center justify-between px-6">
            <h2 class="text-xl font-bold text-white">Meus Grupos</h2>
            <a href="/groups/create" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-xl font-bold flex items-center gap-2">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Criar
            </a>
        </header>

        <main class="p-6">
            <div class="max-w-4xl mx-auto space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-black text-white">Meus Grupos</h1>
                        <p class="text-slate-500">Grupos que você participa</p>
                    </div>
                </div>

                @if($userGroups->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($userGroups as $group)
                            <a href="/groups/{{ $group->slug }}" class="glass-card rounded-2xl p-6 hover:border-blue-500/30 transition">
                                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                    {{ $group->name }}
                                    @if($group->is_verified)
                                        <i data-lucide="badge-check" class="w-4 h-4 text-blue-400"></i>
                                    @endif
                                </h3>
                                <p class="text-slate-500 text-sm mt-1 line-clamp-2">{{ $group->description }}</p>
                                <div class="mt-4 flex items-center gap-4 text-xs text-slate-500">
                                    <span class="flex items-center gap-1">
                                        <i data-lucide="users" class="w-3 h-3"></i>
                                        {{ $group->members()->count() }} membros
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="glass-card rounded-2xl p-12 text-center">
                        <i data-lucide="users" class="w-12 h-12 text-slate-600 mx-auto mb-4"></i>
                        <p class="text-slate-500 mb-4">Você ainda não participa de nenhum grupo.</p>
                        <a href="/groups/discover" class="text-blue-400 hover:text-blue-300 font-bold">Descobrir Grupos →</a>
                    </div>
                @endif

                <div class="mt-8">
                    <a href="/groups/discover" class="text-blue-400 hover:text-blue-300 font-bold">Descobrir mais grupos →</a>
                </div>
            </div>
        </main>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descobrir Grupos - Fyn1x Forum</title>
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
            <div class="flex items-center gap-4">
                <a href="/groups" class="p-2 hover:bg-slate-800 rounded-xl">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <h2 class="text-xl font-bold text-white">Descobrir Grupos</h2>
            </div>
            <a href="/groups/create" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-xl font-bold">
                + Criar Grupo
            </a>
        </header>

        <main class="p-6">
            <div class="max-w-4xl mx-auto space-y-4">
                <p class="text-slate-500">Encontre novos grupos para participar</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($groups as $group)
                        <div class="glass-card rounded-2xl p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                        {{ $group->name }}
                                        @if($group->is_verified)
                                            <i data-lucide="badge-check" class="w-4 h-4 text-blue-400"></i>
                                        @endif
                                    </h3>
                                    <p class="text-slate-500 text-sm mt-1 line-clamp-2">{{ $group->description }}</p>
                                </div>
                                @auth
                                    @php
                                        $member = \App\Models\GroupMember::where('group_id', $group->id)->where('user_id', auth()->id())->first();
                                    @endphp
                                    @if(!$member)
                                        <form action="/api/groups/{{ $group->id }}/join" method="POST" class="ml-4">
                                            @csrf
                                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-2 rounded-lg font-bold text-sm">Entrar</button>
                                        </form>
                                    @elseif($member->status === 'pending')
                                        <span class="text-amber-400 text-sm font-bold">Pendente</span>
                                    @elseif($member->status === 'approved')
                                        <a href="/groups/{{ $group->slug }}" class="text-blue-400 text-sm font-bold">Ver →</a>
                                    @endif
                                @endauth
                            </div>
                            <div class="mt-4 flex items-center gap-4 text-xs text-slate-500">
                                <span class="flex items-center gap-1"><i data-lucide="users" class="w-3 h-3"></i> {{ $group->members()->count() }} membros</span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 text-center py-12">
                            <i data-lucide="users" class="w-12 h-12 text-slate-600 mx-auto mb-4"></i>
                            <p class="text-slate-500">Nenhum grupo público disponível.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>
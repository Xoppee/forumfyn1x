<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $group->name }} - Fyn1x Forum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-card { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(12px); }
        .markdown-body code { background: #1e293b; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-family: monospace; }
        .markdown-body pre { background: #1e293b; padding: 1rem; border-radius: 0.5rem; overflow-x: auto; }
    </style>
</head>
<body class="bg-slate-950 text-slate-200 min-h-screen">

    @include('components.sidebar')
    
    <div class="lg:ml-64 min-h-screen flex flex-col">
        <header class="h-16 glass-card border-b border-slate-800 flex items-center justify-between px-6">
            <div class="flex items-center gap-4">
                <a href="/groups" class="p-2 hover:bg-slate-800 rounded-xl">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <h1 class="text-xl font-black text-white flex items-center gap-2">
                    {{ $group->name }}
                    @if($group->is_verified)
                        <i data-lucide="badge-check" class="w-5 h-5 text-blue-400"></i>
                    @endif
                </h1>
            </div>
            @auth
            @php
                $myMember = \App\Models\GroupMember::where('group_id', $group->id)->where('user_id', auth()->id())->first();
            @endphp
            @if(!$myMember)
                <form action="/api/groups/{{ $group->id }}/join" method="POST">
                    @csrf
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-xl font-bold">Entrar</button>
                </form>
            @elseif($myMember->status === 'approved')
                <form action="/api/groups/{{ $group->id }}/leave" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded-xl font-bold">Sair</button>
                </form>
            @endif
            @endauth
        </header>

        <div class="flex-1 flex overflow-hidden">
            <main class="flex-1 p-6 overflow-y-auto">
                <div class="max-w-4xl mx-auto space-y-6">
                    <div class="glass-card rounded-2xl p-6">
                        <p class="text-slate-400">{{ $group->description }}</p>
                        <div class="mt-4 flex items-center gap-4 text-sm text-slate-500">
                            <span class="flex items-center gap-1"><i data-lucide="users" class="w-4 h-4"></i> {{ $members->count() }} membros</span>
                        </div>
                    </div>

                    <div class="glass-card rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                                <i data-lucide="message-circle" class="w-5 h-5 text-blue-400"></i>
                                Discussões do Grupo
                            </h2>
                            @auth
                            @if($myMember && $myMember->status === 'approved')
                            <a href="/groups/{{ $group->slug }}/topics/create" class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded-lg text-sm font-bold">
                                + Novo Tópico
                            </a>
                            @endif
                            @endauth
                        </div>
                        
                        @if($group->topics && $group->topics->count() > 0)
                            <div class="space-y-3">
                                @foreach($group->topics as $topic)
                                <a href="/topics/{{ $topic->slug }}" class="block p-4 rounded-xl bg-slate-800/50 hover:bg-slate-800 transition">
                                    <div class="flex items-center justify-between">
                                        <h3 class="font-bold text-white">{{ $topic->title }}</h3>
                                        @if($topic->is_sticky)
                                        <i data-lucide="pin" class="w-4 h-4 text-amber-400"></i>
                                        @endif
                                    </div>
                                    <p class="text-slate-500 text-sm mt-1">{{ $topic->posts->count() }} respostas</p>
                                </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-slate-500 text-center py-4">Nenhuma discussão neste grupo ainda.</p>
                        @endif
                    </div>

                    <div class="glass-card rounded-2xl p-6">
                        <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                            <i data-lucide="users" class="w-5 h-5 text-blue-400"></i>
                            Membros
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @forelse($members as $member)
                                <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-800/50">
                                    <div class="w-10 h-10 rounded-xl bg-slate-700 flex items-center justify-center overflow-hidden">
                                        @if($member->user->avatar)
                                        <img src="{{ asset('storage/'.$member->user->avatar) }}" class="w-full h-full object-cover">
                                        @else
                                        <i data-lucide="user" class="w-5 h-5 text-slate-400"></i>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-bold text-white truncate flex items-center gap-1">
                                            {{ $member->user->name }}
                                            @if($member->user->is_verified)
                                            <i data-lucide="badge-check" class="w-3 h-3 text-blue-400"></i>
                                            @endif
                                        </p>
                                        <p class="text-xs text-slate-500">@{{ $member->user->username }}</p>
                                    </div>
                                    @if($member->groupRole)
                                        <span class="text-xs px-2 py-1 rounded-full" style="background: {{ $member->groupRole->color }}/20; color: {{ $member->groupRole->color }}">
                                            {{ $member->groupRole->name }}
                                        </span>
                                    @endif
                                </div>
                            @empty
                                <p class="text-slate-500 col-span-2 text-center py-4">Nenhum membro ainda.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </main>

            <aside class="w-80 border-l border-slate-800 p-4 overflow-y-auto hidden xl:block">
                <h3 class="font-bold text-white mb-4 flex items-center gap-2">
                    <i data-lucide="send" class="w-4 h-4 text-emerald-400"></i>
                    Chat em Tempo Real
                </h3>
                
                <div id="chat-messages" class="space-y-2 mb-4 max-h-80 overflow-y-auto">
                    <p class="text-slate-500 text-xs text-center py-4">Carregando mensagens...</p>
                </div>

                @auth
                @if($myMember && $myMember->status === 'approved')
                <form id="chat-form" class="space-y-2">
                    <input type="text" id="chat-input" placeholder="Mensagem..." 
                           class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-2 rounded-xl text-sm">
                        Enviar
                    </button>
                </form>
                @else
                <p class="text-slate-500 text-xs text-center">Entre no grupo para chatting.</p>
                @endif
                @else
                <p class="text-slate-500 text-xs text-center">Entre para participar do chat.</p>
                @endauth
            </aside>
        </div>
    </div>

    <script>
        lucide.createIcons();
        
        const chatInput = document.getElementById('chat-input');
        const chatForm = document.getElementById('chat-form');
        const chatMessages = document.getElementById('chat-messages');
        const groupId = {{ $group->id }};
        
        function loadMessages() {
            fetch(`/api/groups/${groupId}/messages/latest?after=0`)
                .then(res => res.json())
                .then(data => {
                    if (data.messages && data.messages.length > 0) {
                        chatMessages.innerHTML = data.messages.map(msg => `
                            <div class="p-2 rounded-lg bg-slate-800/50">
                                <p class="text-xs font-bold text-white">${msg.user.name}</p>
                                <p class="text-sm text-slate-300">${msg.message}</p>
                            </div>
                        `).join('');
                    } else {
                        chatMessages.innerHTML = '<p class="text-slate-500 text-xs text-center py-4">Nenhuma mensagem ainda.</p>';
                    }
                });
        }
        
        if (chatForm) {
            chatForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const message = chatInput.value.trim();
                if (!message) return;
                
                await fetch(`/api/groups/${groupId}/messages`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ message })
                });
                
                chatInput.value = '';
                loadMessages();
            });
            
            loadMessages();
            setInterval(loadMessages, 10000);
        }
    </script>
</body>
</html>
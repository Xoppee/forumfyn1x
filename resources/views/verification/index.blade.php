<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação - Fyn1x Forum</title>
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
        <main class="p-8">
            <div class="max-w-xl mx-auto">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 rounded-full bg-blue-500/20 flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="badge-check" class="w-8 h-8 text-blue-400"></i>
                    </div>
                    <h1 class="text-3xl font-black text-white">Verificação</h1>
                    <p class="text-slate-500">Tenha o checksinho azul e mostre que é activo na comunidade</p>
                </div>

                @if(auth()->user()->is_verified)
                    <div class="glass-card rounded-2xl p-8 text-center">
                        <i data-lucide="badge-check" class="w-12 h-12 text-blue-400 mx-auto mb-4"></i>
                        <h2 class="text-xl font-bold text-blue-400">Você é Verificado!</h2>
                        <p class="text-slate-500 text-sm mt-2">O símbolo azul está ao lado do seu nome.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        <div class="glass-card rounded-2xl p-6">
                            <h3 class="font-bold text-white mb-4">Requisitos</h3>
                            <div class="space-y-4">
                                @foreach($progress as $key => $item)
                                    <div class="flex items-center justify-between">
                                        <span class="text-slate-400 capitalize">{{ $key }}</span>
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm {{ $item['met'] ? 'text-emerald-400' : 'text-slate-500' }}">
                                                {{ $item['current'] }} / {{ $item['required'] }}
                                            </span>
                                            @if($item['met'])
                                                <i data-lucide="check" class="w-4 h-4 text-emerald-400"></i>
                                            @else
                                                <i data-lucide="x" class="w-4 h-4 text-slate-600"></i>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="h-2 bg-slate-800 rounded-full overflow-hidden">
                                        <div class="h-full bg-{{ $item['met'] ? 'emerald' : 'blue' }}-500 rounded-full transition-all" 
                                             style="width: {{ min(($item['current'] / $item['required']) * 100, 100) }}%"></div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @if($progress['ready'])
                            <form action="/api/verification/request" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-4 rounded-xl">Solicitar Verificação</button>
                            </form>
                        @else
                            <div class="bg-amber-500/10 border border-amber-500/20 rounded-xl p-4 text-center">
                                <p class="text-amber-400 text-sm font-bold">Complete os requisitos para solicitar</p>
                            </div>
                        @endif

                        @if($verification && $verification->status === 'pending')
                            <div class="bg-amber-500/10 border border-amber-500/20 rounded-xl p-4 text-center">
                                <p class="text-amber-400 font-bold">Solicitação Pendente</p>
                                <p class="text-slate-500 text-sm">Aguarde aprovação de um administrador.</p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </main>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>
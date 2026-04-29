<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Grupo - Fyn1x Forum</title>
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
                <h2 class="text-xl font-bold text-white">Criar Grupo</h2>
            </div>
        </header>

        <main class="p-6">
            <div class="max-w-xl mx-auto">
                <div class="glass-card rounded-2xl p-6">
                    <p class="text-slate-500 mb-6">Crie um novo grupo para a comunidade</p>

                    <form action="/api/groups" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-bold text-slate-400 mb-2">Nome do Grupo</label>
                            <input type="text" name="name" required placeholder="Ex: Desenvolvedores PHP"
                                   class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-400 mb-2">Descrição</label>
                            <textarea name="description" rows="4" placeholder="Sobre o que é este grupo?"
                                     class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500"></textarea>
                        </div>

                        <div>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="is_private" value="1" class="rounded bg-slate-800 border-slate-600">
                                <span class="text-sm text-slate-400">Grupo privado (apenas com convite)</span>
                            </label>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 rounded-xl">
                            Criar Grupo
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>
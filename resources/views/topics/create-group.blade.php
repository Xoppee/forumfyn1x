<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Tópico - {{ $group->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-950 text-slate-200 min-h-screen">

    @include('components.sidebar')
    
    <div class="lg:ml-64 min-h-screen">
        <header class="h-16 glass-card border-b border-slate-800 flex items-center justify-between px-6">
            <div class="flex items-center gap-4">
                <a href="/groups/{{ $group->slug }}" class="p-2 hover:bg-slate-800 rounded-xl">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <h2 class="text-lg font-bold text-white">Criar Tópico em {{ $group->name }}</h2>
            </div>
        </header>

        <main class="p-6">
            <div class="max-w-3xl mx-auto">
                <div class="glass-card rounded-2xl p-6">
                    <form action="/groups/{{ $group->slug }}/topics" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-bold text-slate-400 mb-2">Título</label>
                            <input type="text" name="title" required
                                   class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500"
                                   placeholder="Título do tópico">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-400 mb-2">Conteúdo</label>
                            <textarea name="content" rows="10" required
                                      class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 resize-none"
                                      placeholder="Conteúdo do tópico (Markdown suportado)"></textarea>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="/groups/{{ $group->slug }}" class="text-slate-400 hover:text-white font-medium">Cancelar</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl font-bold">
                                Criar Tópico
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>
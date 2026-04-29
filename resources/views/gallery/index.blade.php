<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeria - Fyn1x Forum</title>
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
            <h2 class="text-xl font-bold text-white">Galeria de Imagens</h2>
            <button onclick="document.getElementById('new-folder').classList.toggle('hidden')" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-xl font-bold">
                + Nova Pasta
            </button>
        </header>

        <main class="p-6">
            <div class="max-w-6xl mx-auto">
                <div id="new-folder" class="hidden glass-card rounded-2xl p-6 mb-6">
                    <form action="/gallery/folders" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <input type="text" name="name" placeholder="Nome da pasta" required
                                   class="bg-slate-800 border border-slate-700 rounded-xl px-4 py-2 focus:outline-none focus:border-blue-500">
                            <input type="text" name="description" placeholder="Descrição" 
                                   class="bg-slate-800 border border-slate-700 rounded-xl px-4 py-2 focus:outline-none focus:border-blue-500">
                        </div>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="is_public" value="1" checked class="rounded">
                            <span class="text-sm">Pública</span>
                        </label>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white px-6 py-2 rounded-xl font-bold">
                            Criar Pasta
                        </button>
                    </form>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @forelse($folders as $folder)
                    <a href="/gallery/{{ $folder->slug }}" class="glass-card rounded-2xl p-4 hover:border-blue-500/30 transition">
                        <div class="w-full h-32 bg-slate-800 rounded-xl flex items-center justify-center mb-3">
                            <i data-lucide="folder" class="w-12 h-12 text-slate-500"></i>
                        </div>
                        <h3 class="font-bold text-white">{{ $folder->name }}</h3>
                        <p class="text-slate-500 text-sm">{{ $folder->images->count() }} imagens</p>
                    </a>
                    @empty
                    <p class="col-span-4 text-center text-slate-500 py-8">Nenhuma pasta ainda. Crie uma!</p>
                    @endforelse
                </div>
            </div>
        </main>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Tópico | Admin - Fyn1x Forum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen" x-data="{ searchOpen: false }">

    @include('components.sidebar')

    <div class="lg:ml-64 min-h-screen">
        <header class="sticky top-0 z-30 h-16 glass-card flex items-center justify-between px-6 border-b border-slate-800">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.topics') }}" class="p-2 hover:bg-slate-800 rounded-xl transition">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <h2 class="text-lg font-bold text-white">Criar Novo Tópico</h2>
            </div>
        </header>

        <main class="p-6 pb-20">
            <div class="max-w-3xl mx-auto">
                <div class="glass-card rounded-2xl p-6">
                    <form action="{{ route('topics.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="space-y-2">
                            <label for="title" class="text-sm font-bold text-slate-400 uppercase tracking-wider">Título do Tópico</label>
                            <input type="text" name="title" id="title" required
                                class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all placeholder:text-slate-500"
                                placeholder="Ex: Dúvidas sobre Laravel 13">
                        </div>

                        <div class="space-y-2">
                            <label for="content" class="text-sm font-bold text-slate-400 uppercase tracking-wider">Conteúdo (Primeiro Post)</label>
                            <textarea name="content" id="content" rows="10" required
                                class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-4 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all placeholder:text-slate-500 resize-none"
                                placeholder="Descreva o tópico em detalhes... (Markdown suportado)"></textarea>
                            <p class="text-xs text-slate-500">Markdown suportado</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-400 uppercase tracking-wider">Tópico Fixo (Sticky)</label>
                                <select name="is_sticky" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 transition">
                                    <option value="0">Não</option>
                                    <option value="1">Sim</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-400 uppercase tracking-wider">Publicado</label>
                                <select name="is_published" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 transition">
                                    <option value="1">Sim</option>
                                    <option value="0">Não (Rascunho)</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-4">
                            <a href="{{ route('admin.topics') }}" class="text-slate-400 hover:text-white font-medium transition">
                                Cancelar
                            </a>
                            <button type="submit" class="flex items-center space-x-2 bg-blue-600 hover:bg-blue-500 text-white px-8 py-3 rounded-xl font-bold transition-all shadow-lg shadow-blue-900/20">
                                <i data-lucide="send" class="w-4 h-4"></i>
                                <span>Publicar Tópico</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>

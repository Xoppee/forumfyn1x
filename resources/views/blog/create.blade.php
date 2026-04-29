<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Post - Fyn1x Forum</title>
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
<body class="bg-slate-950 text-slate-100 min-h-screen" x-data="{ 
    searchOpen: false,
    selectedTemplate: '{{ old('template_id', '') }}',
    templates: {{ json_encode($templates) }},
    get currentTemplate() {
        return this.templates.find(t => t.id === this.selectedTemplate) || null;
    }
}">

    @include('components.sidebar')

    <div class="lg:ml-64 min-h-screen">
        <header class="sticky top-0 z-30 h-16 glass-card flex items-center justify-between px-6 border-b border-slate-800">
            <div class="flex items-center space-x-4">
                <a href="{{ route('blog.index') }}" class="p-2 hover:bg-slate-800 rounded-xl transition">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <h2 class="text-lg font-bold text-white">Criar Novo Post</h2>
            </div>
        </header>

        <main class="p-6 pb-20">
            <div class="max-w-4xl mx-auto">
                <form action="{{ route('blog.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="glass-card rounded-2xl p-6">
                        <h3 class="text-lg font-bold text-white mb-4">1. Escolha um Template</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($templates as $template)
                                <label class="block cursor-pointer">
                                    <input type="radio" name="template_id" value="{{ $template['id'] }}" 
                                           x-model="selectedTemplate"
                                           class="hidden peer" required>
                                    <div class="p-4 rounded-xl border-2 border-slate-700 hover:border-blue-500 peer-checked:border-blue-500 peer-checked:bg-blue-500/10 transition">
                                        <i data-lucide="{{ $template['icon'] ?? 'file-text' }}" class="w-8 h-8 text-blue-400 mb-2"></i>
                                        <h4 class="font-bold text-white">{{ $template['name'] }}</h4>
                                        <p class="text-sm text-slate-400 mt-1">{{ $template['description'] }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="glass-card rounded-2xl p-6" x-show="selectedTemplate" x-transition>
                        <h3 class="text-lg font-bold text-white mb-4">2. Preencha os Dados</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="title" class="text-sm font-bold text-slate-400 uppercase tracking-wider">Título</label>
                                <input type="text" name="title" id="title" required
                                       class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition mt-1"
                                       placeholder="Título do seu post">
                            </div>

                            <template x-for="(field, name) in (currentTemplate?.fields || {})">
                                <div class="space-y-2">
                                    <label :for="name" class="text-sm font-bold text-slate-400 uppercase tracking-wider" x-text="field.label"></label>
                                    
                                    <template x-if="field.type === 'text' || field.type === 'url'">
                                        <input :type="field.type" :name="name" :id="name"
                                               class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition"
                                               :placeholder="field.placeholder" 
                                               :maxlength="field.maxLength"
                                               :required="field.required">
                                    </template>
                                    
                                    <template x-if="field.type === 'textarea'">
                                        <textarea :name="name" :id="name" rows="10"
                                                  class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-4 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition resize-none"
                                                  :placeholder="field.placeholder"
                                                  :minlength="field.minLength"
                                                  :required="field.required"></textarea>
                                    </template>
                                    
                                    <template x-if="field.type === 'select'">
                                        <select :name="name" :id="name"
                                                class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition">
                                            <option value="">Selecione...</option>
                                            <template x-for="option in (field.options || [])">
                                                <option :value="option" x-text="option" :selected="option === field.default"></option>
                                            </template>
                                        </select>
                                    </template>
                                </div>
                            </template>

                            <div>
                                <label for="content" class="text-sm font-bold text-slate-400 uppercase tracking-wider">Conteúdo Principal</label>
                                <textarea name="content" id="content" rows="15" required
                                          class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-4 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition resize-none mt-1"
                                          placeholder="Escreva seu post aqui... (Markdown suportado)"></textarea>
                                <p class="text-xs text-slate-500 mt-1">Markdown suportado</p>
                            </div>

                            <div>
                                <label for="summary" class="text-sm font-bold text-slate-400 uppercase tracking-wider">Resumo (opcional)</label>
                                <textarea name="summary" id="summary" rows="3" maxlength="300"
                                          class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition resize-none mt-1"
                                          placeholder="Breve resumo para exibição na listagem"></textarea>
                            </div>

                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name="is_published" id="is_published" value="1" class="rounded border-slate-700 bg-slate-800 text-blue-600 focus:ring-blue-500">
                                <label for="is_published" class="text-sm text-slate-300">Publicar imediatamente</label>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('blog.index') }}" class="text-slate-400 hover:text-white font-medium transition">Cancelar</a>
                        <button type="submit" class="flex items-center space-x-2 bg-blue-600 hover:bg-blue-500 text-white px-8 py-3 rounded-xl font-bold transition shadow-lg shadow-blue-900/20">
                            <i data-lucide="send" class="w-4 h-4"></i>
                            <span>Publicar Post</span>
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>

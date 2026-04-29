<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($page) ? 'Editar Página' : 'Criar Página' }} - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <div class="bg-white rounded-lg shadow p-6">
            <h1 class="text-2xl font-bold mb-6">
                {{ isset($page) ? 'Editar Página' : 'Criar Nova Página' }}
            </h1>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" 
                  action="{{ isset($page) ? route('admin.pages.update', $page) : route('admin.pages.store') }}">
                @csrf
                @if(isset($page))
                    @method('PUT')
                @endif

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Título</label>
                    <input type="text" name="title" 
                           value="{{ old('title', $page->title ?? '') }}"
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Slug</label>
                    <input type="text" name="slug" 
                           value="{{ old('slug', $page->slug ?? '') }}"
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    <p class="text-gray-500 text-sm mt-1">URL: /p/slug</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Ícone (nome do ícone)</label>
                    <input type="text" name="icon" 
                           value="{{ old('icon', $page->icon ?? '') }}"
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="home, info, settings...">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Conteúdo</label>
                    <textarea name="content" rows="10"
                              class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Conteúdo da página...">{{ old('content', $page->content ?? '') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Ordem (index)</label>
                    <input type="number" name="index" min="1"
                           value="{{ old('index', $page->index ?? 1) }}"
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_published" value="1"
                               {{ old('is_published', $page->is_published ?? true) ? 'checked' : '' }}
                               class="mr-2">
                        <span class="text-gray-700 font-bold">Publicada</span>
                    </label>
                </div>

                <div class="flex gap-4">
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg">
                        {{ isset($page) ? 'Atualizar' : 'Criar' }}
                    </button>
                    <a href="{{ route('admin') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
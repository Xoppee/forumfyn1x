<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Página - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <div class="bg-white rounded-lg shadow p-6">
            <h1 class="text-2xl font-bold mb-6">Editar Página: {{ $page->title }}</h1>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.pages.update', $page) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Título</label>
                    <input type="text" name="title" 
                           value="{{ old('title', $page->title) }}"
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Slug</label>
                    <input type="text" name="slug" 
                           value="{{ old('slug', $page->slug) }}"
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Ícone</label>
                    <input type="text" name="icon" 
                           value="{{ old('icon', $page->icon) }}"
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Conteúdo</label>
                    <textarea name="content" rows="10"
                              class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('content', $page->content) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Ordem</label>
                    <input type="number" name="index" min="1"
                           value="{{ old('index', $page->index) }}"
                           class="w-full px-3 py-2 border rounded-lg">
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_published" value="1"
                               {{ $page->is_published ? 'checked' : '' }}
                               class="mr-2">
                        <span class="text-gray-700 font-bold">Publicada</span>
                    </label>
                </div>

                <div class="flex gap-4">
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg">
                        Atualizar
                    </button>
                    <a href="{{ route('admin') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg">
                        Cancelar
                    </a>
                </div>
            </form>

            <hr class="my-6">

            <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" onsubmit="return confirm('Tem certeza?')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded-lg">
                    Excluir Página
                </button>
            </form>
        </div>
    </div>
</body>
</html>
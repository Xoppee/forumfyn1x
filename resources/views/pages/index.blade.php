<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Páginas - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Gerenciar Páginas</h1>
            <a href="{{ route('admin.pages.create.form') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg">
                + Nova Página
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ordem</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Título</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($pages as $page)
                        <tr>
                            <td class="px-6 py-4">{{ $page->index }}</td>
                            <td class="px-6 py-4 font-medium">{{ $page->title }}</td>
                            <td class="px-6 py-4 text-gray-500">/p/{{ $page->slug }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full {{ $page->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $page->is_published ? 'Publicada' : 'Rascunho' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.pages.edit', $page) }}" 
                                   class="text-blue-500 hover:text-blue-700 mr-3">
                                    Editar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Nenhuma página encontrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <a href="{{ route('admin') }}" 
               class="text-blue-500 hover:text-blue-700">
                ← Voltar ao Admin
            </a>
        </div>
    </div>
</body>
</html>
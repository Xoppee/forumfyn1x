<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $folder->name }} - Galeria</title>
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
                <a href="/gallery" class="p-2 hover:bg-slate-800 rounded-xl">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <h2 class="text-xl font-bold text-white">{{ $folder->name }}</h2>
            </div>
            @if($folder->user_id === auth()->id())
            <form action="/gallery/folders/{{ $folder->id }}" method="POST" onsubmit="return confirm('Deletar pasta?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded-xl font-bold">
                    Deletar
                </button>
            </form>
            @endif
        </header>

        <main class="p-6">
            <div class="max-w-6xl mx-auto">
                @if($folder->user_id === auth()->id())
                <form action="/gallery/{{ $folder->slug }}/upload" method="POST" enctype="multipart/form-data" class="glass-card rounded-2xl p-6 mb-6">
                    @csrf
                    <label class="block mb-4">
                        <span class="text-sm font-bold text-slate-400">Enviar Imagens</span>
                        <input type="file" name="images[]" multiple accept="image/*" required
                               class="w-full mt-2 bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500">
                    </label>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-2 rounded-xl font-bold">
                        Upload (WebP)
                    </button>
                </form>
                @endif

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @forelse($images as $image)
                    <div class="relative group">
                        <a href="{{ asset('storage/'.$image->path) }}" target="_blank">
                            <img src="{{ asset('storage/'.$image->path) }}" class="w-full h-48 object-cover rounded-xl">
                        </a>
                        @if($image->user_id === auth()->id())
                        <form action="/gallery/images/{{ $image->id }}" method="POST" onsubmit="return confirm('Deletar?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="absolute top-2 right-2 bg-red-600 hover:bg-red-500 p-2 rounded-lg opacity-0 group-hover:opacity-100 transition">
                                <i data-lucide="trash" class="w-4 h-4"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                    @empty
                    <p class="col-span-4 text-center text-slate-500 py-8">Nenhuma imagem ainda.</p>
                    @endforelse
                </div>
            </div>
        </main>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>
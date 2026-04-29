@props(['links' => []])

<nav class="flex px-5 py-3 text-zinc-400 bg-zinc-900/50 border border-zinc-800 rounded-xl mb-6 w-full" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="/" class="hover:text-indigo-400 transition-colors flex items-center">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                Início
            </a>
        </li>

        @foreach($links as $label => $url)
        <li>
            <div class="flex items-center">
                <svg class="w-6 h-6 text-zinc-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                @if(!$loop->last)
                    <a href="{{ $url }}" class="ml-1 md:ml-2 hover:text-indigo-400 transition-colors">{{ $label }}</a>
                @else
                    <span class="ml-1 md:ml-2 text-zinc-200 font-medium">{{ $label }}</span>
                @endif
            </div>
        </li>
        @endforeach
    </ol>
</nav>
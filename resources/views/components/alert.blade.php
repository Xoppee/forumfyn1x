@php
    $type = $type ?? 'info';
    $colors = [
        'success' => 'bg-emerald-500/20 border-emerald-500/30 text-emerald-400',
        'error' => 'bg-red-500/20 border-red-500/30 text-red-400',
        'warning' => 'bg-amber-500/20 border-amber-500/30 text-amber-400',
        'info' => 'bg-blue-500/20 border-blue-500/30 text-blue-400',
    ];
    $icons = [
        'success' => 'check-circle',
        'error' => 'x-circle',
        'warning' => 'alert-triangle',
        'info' => 'info',
    ];
@endphp

@if(session($type) || $slot->isNotEmpty())
    <div class="p-4 rounded-xl border {{ $colors[$type] ?? $colors['info'] }} flex items-center space-x-3 mb-6" role="alert">
        <i data-lucide="{{ $icons[$type] ?? 'info' }}" class="w-5 h-5 flex-shrink-0"></i>
        <span class="text-sm font-medium">{{ $slot ?? session($type) }}</span>
        @if(isset($dismissible) && $dismissible)
            <button onclick="this.parentElement.remove()" class="ml-auto hover:opacity-70 transition">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        @endif
    </div>
@endif

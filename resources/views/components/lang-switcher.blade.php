@php
    $current = session('locale', config('app.locale'));
    $labels = ['pt_BR' => 'PT', 'en' => 'EN', 'es' => 'ES'];
@endphp

<div x-data="{ open: false }" class="relative">
    <button @click="open = !open"
            class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-md text-xs font-semibold text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 transition border border-slate-200 dark:border-slate-600">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
        </svg>
        {{ $labels[$current] ?? 'PT' }}
    </button>

    <div x-show="open" @click.outside="open = false" x-transition
         class="absolute right-0 mt-2 w-36 bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-slate-200 dark:border-slate-700 py-1 z-50">
        @foreach (['pt_BR' => 'Português', 'en' => 'English', 'es' => 'Español'] as $code => $name)
            <a href="{{ route('locale.switch', $code) }}"
               class="flex items-center gap-2 px-3 py-2 text-sm transition
                      {{ $current === $code ? 'bg-slate-100 dark:bg-slate-700 text-slate-900 dark:text-white font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700' }}">
                <span class="text-xs font-bold w-5">{{ $labels[$code] }}</span>
                {{ $name }}
            </a>
        @endforeach
    </div>
</div>

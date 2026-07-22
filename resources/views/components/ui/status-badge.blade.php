@props(['status', 'label'])

@php
    $colors = match($status) {
        'disponivel', 'ativo' => 'bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-400',
        'em_uso' => 'bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-400',
        'manutencao', 'afastado' => 'bg-yellow-100 dark:bg-yellow-900/40 text-yellow-700 dark:text-yellow-400',
        'ocioso' => 'bg-orange-100 dark:bg-orange-900/40 text-orange-700 dark:text-orange-400',
        'devolvido', 'ferias' => 'bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-400',
        'obsoleto', 'desligado' => 'bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-400',
        'baixa' => 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300',
        'extraviado' => 'bg-pink-100 dark:bg-pink-900/40 text-pink-700 dark:text-pink-400',
        'transferido' => 'bg-cyan-100 dark:bg-cyan-900/40 text-cyan-700 dark:text-cyan-400',
        'alugado' => 'bg-violet-100 dark:bg-violet-900/40 text-violet-700 dark:text-violet-400',
        default => 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300',
    };
@endphp
<span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ $colors }}">
    {{ $label }}
</span>
@extends('layouts.app')

@section('title', $localizacao->nome)

@section('content')
<div class="mb-6">
    <a href="{{ route('localizacoes.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 inline-flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        {{ __('localizacao.back_to_list') }}
    </a>
</div>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div class="flex items-center gap-4">
        <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center">
            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $localizacao->nome }}</h1>
            <p class="text-gray-500 text-sm">{{ $localizacao->descricao_completa }}</p>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('localizacoes.edit', $localizacao) }}"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-amber-500 to-amber-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:from-amber-600 hover:to-amber-700 transition shadow-sm shadow-amber-500/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            {{ __('localizacao.edit_button') }}
        </a>
        <form action="{{ route('localizacoes.destroy', $localizacao) }}" method="POST" onsubmit="return confirm('{{ __('localizacao.delete_confirm') }}')" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center gap-2 bg-red-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-red-600 transition shadow-sm shadow-red-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                {{ __('localizacao.delete_button') }}
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">{{ __('localizacao.stats.title') }}</h2>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">{{ __('localizacao.stats.total_notebooks') }}</span>
                <span class="text-lg font-bold text-blue-600">{{ $stats['total_notebooks'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">{{ __('localizacao.stats.allocated') }}</span>
                <span class="text-lg font-bold text-indigo-600">{{ $stats['allocated'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">{{ __('localizacao.stats.available') }}</span>
                <span class="text-lg font-bold text-green-600">{{ $stats['available'] }}</span>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">{{ __('localizacao.info') }}</h2>
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
            <div>
                <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">{{ __('localizacao.field.name') }}</dt>
                <dd class="text-sm text-gray-800 dark:text-gray-200 font-medium mt-1">{{ $localizacao->nome }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">{{ __('localizacao.field.group') }}</dt>
                <dd class="text-sm text-gray-800 dark:text-gray-200 font-medium mt-1">
                    @if ($localizacao->grupo)
                        <span class="inline-flex items-center gap-1.5" style="color: {{ $localizacao->grupo->cor ?? '#6b7280' }}">
                            <span class="w-2 h-2 rounded-full shrink-0" style="background-color: {{ $localizacao->grupo->cor ?? '#6b7280' }}"></span>
                            {{ $localizacao->grupo->nome }}
                        </span>
                    @else
                        —
                    @endif
                </dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">{{ __('localizacao.field.building') }}</dt>
                <dd class="text-sm text-gray-800 dark:text-gray-200 font-medium mt-1">{{ $localizacao->predio ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">{{ __('localizacao.field.floor') }}</dt>
                <dd class="text-sm text-gray-800 dark:text-gray-200 font-medium mt-1">{{ $localizacao->andar ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">{{ __('localizacao.field.room') }}</dt>
                <dd class="text-sm text-gray-800 dark:text-gray-200 font-medium mt-1">{{ $localizacao->sala ?? '—' }}</dd>
            </div>
        </dl>
    </div>
</div>

@if ($localizacoes->notebooks->isNotEmpty())
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider">{{ __('localizacao.notebooks_title') }}</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-500 dark:text-gray-400 bg-gray-50/80 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-600">
                    <x-ui.table-heading :text="__('localizacao.notebooks.brand')" />
                    <x-ui.table-heading :text="__('localizacao.notebooks.serial')" class="hidden md:table-cell" />
                    <x-ui.table-heading :text="__('localizacao.notebooks.employee')" class="hidden md:table-cell" />
                    <x-ui.table-heading :text="__('localizacao.notebooks.status')" />
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100/60">
                @foreach ($localizacao->notebooks as $notebook)
                    <tr class="table-row-animate {{ $loop->even ? 'bg-gray-50/40 dark:bg-slate-700/30' : 'bg-white dark:bg-slate-800' }} hover:bg-blue-50/30 dark:hover:bg-slate-700/50 transition-colors duration-150">
                        <td class="px-6 py-4">
                            <a href="{{ route('notebooks.show', $notebook) }}" class="font-medium text-gray-900 hover:text-blue-600 transition">
                                {{ $notebook->marca }} {{ $notebook->modelo }}
                            </a>
                        </td>
                        <td class="px-6 py-4 hidden md:table-cell">
                            <code class="text-xs bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-400 px-2 py-1 rounded-lg">{{ $notebook->numero_serie }}</code>
                        </td>
                        <td class="px-6 py-4 hidden md:table-cell">
                            {{ $notebook->funcionario->nome ?? '—' }}
                        </td>
                        <td class="px-6 py-4">
                            <x-ui.status-badge :status="$notebook->status" :label="$notebook->status_label" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection

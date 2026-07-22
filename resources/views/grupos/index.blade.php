@extends('layouts.app')

@section('title', __('grupo.title'))

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('grupo.title') }}</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ __('grupo.subtitle') }}</p>
    </div>
    <a href="{{ route('grupos.create') }}"
       class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl text-sm font-semibold hover:from-blue-700 hover:to-blue-800 transition shadow-sm shadow-blue-500/20">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        {{ __('grupo.new') }}
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-6">
    <form method="GET" action="{{ route('grupos.index') }}" class="p-4 flex flex-col sm:flex-row gap-3">
        <div class="flex-1 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('grupo.search_placeholder') }}"
                   class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="flex-1 sm:flex-none bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300 px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-200 dark:hover:bg-slate-600 transition">
                {{ __('grupo.filter') }}
            </button>
            @if (request()->has('search'))
                <a href="{{ route('grupos.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 px-4 py-2.5 text-sm font-medium">
                    {{ __('grupo.clear') }}
                </a>
            @endif
        </div>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    @if ($grupos->isEmpty())
        <x-ui.empty-state
            icon="inventory"
            :title="__('grupo.no_results')"
            :hint="__('grupo.no_results_hint')"
            :actionLabel="__('grupo.register_first')"
            :actionRoute="route('grupos.create')"
        />
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 dark:text-gray-400 bg-gray-50/80 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-600">
                        <x-ui.table-heading :text="__('grupo.field.name')" class="min-w-[200px]" />
                        <x-ui.table-heading :text="__('grupo.field.description')" class="hidden md:table-cell" />
                        <x-ui.table-heading :text="__('grupo.stats.total_notebooks')" class="whitespace-nowrap text-center" />
                        <x-ui.table-heading :text="__('grupo.stats.total_employees')" class="whitespace-nowrap text-center" />
                        <x-ui.table-heading :text="__('grupo.actions')" class="text-right whitespace-nowrap" />
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/60">
                    @foreach ($grupos as $grupo)
                        <tr class="{{ $loop->even ? 'bg-gray-50/40 dark:bg-slate-700/30' : 'bg-white dark:bg-slate-800' }} hover:bg-blue-50/30 dark:hover:bg-slate-700/50 transition-colors duration-150">
                            <td class="px-5 sm:px-7 py-5">
                                <a href="{{ route('grupos.show', $grupo) }}" class="flex items-center gap-3 min-w-0 group">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 font-bold text-white text-xs"
                                         style="background-color: {{ $grupo->cor ?? '#6366f1' }}">
                                        {{ strtoupper(substr($grupo->nome, 0, 2)) }}
                                    </div>
                                    <span class="font-semibold text-gray-900 group-hover:text-blue-600 transition truncate text-[13px]">{{ $grupo->nome }}</span>
                                </a>
                            </td>
                            <td class="px-5 sm:px-7 py-5 hidden md:table-cell">
                                <span class="text-gray-500 text-[13px] truncate max-w-[300px] block">{{ $grupo->descricao ?? '—' }}</span>
                            </td>
                            <td class="px-5 sm:px-7 py-5 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 text-xs font-bold">{{ $grupo->notebooks_count }}</span>
                            </td>
                            <td class="px-5 sm:px-7 py-5 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 text-xs font-bold">{{ $grupo->employees_count }}</span>
                            </td>
                            <td class="px-5 sm:px-7 py-5 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('grupos.show', $grupo) }}" class="action-btn p-2 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:text-blue-400 dark:hover:bg-blue-500/10 transition" title="{{ __('grupo.view_button') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('grupos.edit', $grupo) }}" class="action-btn p-2 rounded-lg text-gray-400 hover:text-amber-600 hover:bg-amber-50 dark:hover:text-amber-400 dark:hover:bg-amber-500/10 transition" title="{{ __('grupo.edit_button') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('grupos.destroy', $grupo) }}" method="POST" onsubmit="return confirm('{{ __('grupo.delete_confirm') }}')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:text-red-400 dark:hover:bg-red-500/10 transition" title="{{ __('grupo.delete_button') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-5 sm:px-7 py-4 border-t border-gray-100 dark:border-slate-700">
            {{ $grupos->links() }}
        </div>
    @endif
</div>
@endsection

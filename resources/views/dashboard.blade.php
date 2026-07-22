@extends('layouts.app')

@section('title', __('nav.dashboard'))

@section('content')
@php
    $hora = (int) now()->format('H');
    $greeting = match(true) {
        $hora < 12 => __('dashboard.greeting_morning'),
        $hora < 18 => __('dashboard.greeting_afternoon'),
        default => __('dashboard.greeting_evening'),
    };
    $nome = auth()->user()->name;
@endphp

<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $greeting }}, {{ $nome }}</h1>
    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ __('dashboard.overview') }}</p>
</div>

<div class="flex gap-3 sm:gap-4 mb-8 overflow-x-auto pb-1">
    <x-ui.stat-card :value="$total" :label="__('dashboard.total_notebooks')" color="gray">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
    </x-ui.stat-card>
    <x-ui.stat-card :value="$disponiveis" :label="__('dashboard.available')" color="green">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    </x-ui.stat-card>
    <x-ui.stat-card :value="$emUso" :label="__('dashboard.in_use')" color="blue">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
    </x-ui.stat-card>
    <x-ui.stat-card :value="$manutencao" :label="__('dashboard.maintenance')" color="yellow">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
    </x-ui.stat-card>
    <x-ui.stat-card :value="$ociosos" :label="__('dashboard.idle')" color="orange">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    </x-ui.stat-card>
    <x-ui.stat-card :value="$totalFuncionarios" :label="__('dashboard.employees')" color="indigo">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
    </x-ui.stat-card>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border border-gray-100 dark:border-slate-700">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-blue-50 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('dashboard.by_brand') }}</h2>
        </div>
        @if ($porMarca->isEmpty())
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-300 dark:text-slate-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p class="text-gray-400 dark:text-gray-500 text-sm">{{ __('dashboard.no_data') }}</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($porMarca as $item)
                    @php $percent = $total > 0 ? ($item->total / $total * 100) : 0; @endphp
                    <div class="flex items-center gap-3">
                        <div class="w-24 text-sm text-gray-700 dark:text-gray-300 font-medium truncate">{{ $item->marca }}</div>
                        <div class="flex-1 bg-gray-100 dark:bg-slate-700 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                        </div>
                        <div class="text-sm font-semibold text-gray-700 dark:text-gray-300 w-12 text-right">{{ $item->total }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border border-gray-100 dark:border-slate-700">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-purple-50 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('dashboard.by_department') }}</h2>
        </div>
        @if ($porDepartamento->isEmpty())
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-300 dark:text-slate-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p class="text-gray-400 dark:text-gray-500 text-sm">{{ __('dashboard.no_data') }}</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($porDepartamento as $item)
                    @php $percent = $total > 0 ? ($item->total / $total * 100) : 0; @endphp
                    <div class="flex items-center gap-3">
                        <div class="w-24 text-sm text-gray-700 dark:text-gray-300 font-medium truncate">{{ $item->departamento }}</div>
                        <div class="flex-1 bg-gray-100 dark:bg-slate-700 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                        </div>
                        <div class="text-sm font-semibold text-gray-700 dark:text-gray-300 w-12 text-right">{{ $item->total }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border border-gray-100 dark:border-slate-700">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('dashboard.by_grupo') }}</h2>
        </div>
        @if ($porGrupo->isEmpty())
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-300 dark:text-slate-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p class="text-gray-400 dark:text-gray-500 text-sm">{{ __('dashboard.no_data') }}</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($porGrupo as $item)
                    @php $percent = $total > 0 ? ($item->notebooks_count / $total * 100) : 0; @endphp
                    <div class="flex items-center gap-3">
                        <div class="w-24 text-sm font-medium truncate dark:brightness-150" style="color: {{ $item->cor }}">{{ $item->nome }}</div>
                        <div class="flex-1 bg-gray-100 dark:bg-slate-700 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                        </div>
                        <div class="text-sm font-semibold text-gray-700 dark:text-gray-300 w-12 text-right">{{ $item->notebooks_count }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-50 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('dashboard.recent') }}</h2>
            </div>
            @if (auth()->user()->isAdmin() || auth()->user()->isEditor())
            <a href="{{ route('notebooks.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1">
                {{ __('dashboard.view_all') }}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
            @endif
        </div>
    </div>
    @if ($recentes->isEmpty())
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-300 dark:text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <p class="text-gray-400 dark:text-gray-500 text-sm">{{ __('dashboard.no_notebooks') }}</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 dark:text-gray-400 bg-gray-50/80 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-600">
                        <x-ui.table-heading :text="__('dashboard.notebook')" />
                        <x-ui.table-heading :text="__('dashboard.asset_number')" class="hidden md:table-cell whitespace-nowrap" />
                        <x-ui.table-heading :text="__('dashboard.responsible')" class="hidden lg:table-cell" />
                        <x-ui.table-heading :text="__('dashboard.status')" class="whitespace-nowrap" />
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/60">
                    @foreach ($recentes as $notebook)
                        <tr class="{{ $loop->even ? 'bg-gray-50/40 dark:bg-slate-700/30' : 'bg-white dark:bg-slate-800' }} hover:bg-blue-50/30 dark:hover:bg-slate-700/50 transition-colors duration-150">
                            <td class="px-5 sm:px-7 py-5">
                                <div>
                                    @if (auth()->user()->isAdmin() || auth()->user()->isEditor())
                                    <a href="{{ route('notebooks.show', $notebook) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">
                                        {{ $notebook->marca }} {{ $notebook->modelo }}
                                    </a>
                                    @else
                                    <span class="font-medium text-gray-800 dark:text-gray-200">{{ $notebook->marca }} {{ $notebook->modelo }}</span>
                                    @endif
                                    <div class="text-xs text-gray-400 dark:text-gray-500 md:hidden">{{ $notebook->patrimonio ?? '—' }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 lg:hidden mt-0.5">{{ $notebook->funcionario->nome ?? __('dashboard.no_responsible') }}</div>
                                </div>
                            </td>
                            <td class="px-5 sm:px-7 py-5 hidden md:table-cell text-gray-600 dark:text-gray-400 font-mono text-xs">
                                {{ $notebook->patrimonio ?? '—' }}
                            </td>
                            <td class="px-5 sm:px-7 py-5 hidden lg:table-cell">
                                @if ($notebook->funcionario)
                                <div class="flex items-center gap-3">
                                    <x-ui.avatar :name="$notebook->funcionario->nome" size="sm" />
                                    <span class="text-gray-700 dark:text-gray-300 text-[13px]">{{ $notebook->funcionario->nome }}</span>
                                </div>
                                @else
                                <span class="text-gray-300 dark:text-slate-600">—</span>
                                @endif
                            </td>
                            <td class="px-5 sm:px-7 py-5">
                                <x-ui.status-badge :status="$notebook->status" :label="$notebook->status_label" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

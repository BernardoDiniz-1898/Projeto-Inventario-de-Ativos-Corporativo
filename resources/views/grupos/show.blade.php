@extends('layouts.app')

@section('title', $grupo->nome)

@section('content')
<x-ui.back-link :route="route('grupos.index')" :label="__('grupo.back_to_list')" />

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div class="flex items-center gap-4">
        <div class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0 font-bold text-white text-xl"
             style="background-color: {{ $grupo->cor ?? '#6366f1' }}">
            {{ strtoupper(substr($grupo->nome, 0, 2)) }}
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $grupo->nome }}</h1>
            @if ($grupo->descricao)
                <p class="text-gray-500 text-sm">{{ $grupo->descricao }}</p>
            @endif
        </div>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('grupos.edit', $grupo) }}"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-amber-500 to-amber-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:from-amber-600 hover:to-amber-700 transition shadow-sm shadow-amber-500/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            {{ __('grupo.edit_button') }}
        </a>
    </div>
</div>

<div class="flex gap-3 sm:gap-4 mb-6 overflow-x-auto pb-1">
    <x-ui.stat-card :value="$stats['total_notebooks']" :label="__('grupo.stats.total_notebooks')" color="blue">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
    </x-ui.stat-card>
    <x-ui.stat-card :value="$stats['total_employees']" :label="__('grupo.stats.total_employees')" color="indigo">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
    </x-ui.stat-card>
    <x-ui.stat-card :value="$stats['allocated']" :label="__('grupo.stats.allocated')" color="green">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    </x-ui.stat-card>
    <x-ui.stat-card :value="$stats['available']" :label="__('grupo.stats.available')" color="gray">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
    </x-ui.stat-card>
    <x-ui.stat-card :value="$stats['maintenance']" :label="__('grupo.stats.maintenance')" color="yellow">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
    </x-ui.stat-card>
</div>

{{-- Notebooks do Grupo --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('grupo.notebooks_linked') }}</h2>
    </div>
    @if ($grupo->notebooks->isEmpty())
        <x-ui.empty-state
            icon="notebook"
            :title="__('grupo.no_notebooks')"
        />
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 dark:text-gray-400 bg-gray-50/80 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-600">
                        <x-ui.table-heading :text="__('grupo.notebook_table.patrimonio')" />
                        <x-ui.table-heading :text="__('grupo.notebook_table.marca_modelo')" />
                        <x-ui.table-heading :text="__('grupo.notebook_table.numero_serie')" class="hidden md:table-cell" />
                        <x-ui.table-heading :text="__('grupo.notebook_table.responsavel')" class="hidden lg:table-cell" />
                        <x-ui.table-heading :text="__('grupo.notebook_table.status')" />
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/60">
                    @foreach ($grupo->notebooks as $notebook)
                        <tr class="{{ $loop->even ? 'bg-gray-50/40 dark:bg-slate-700/30' : 'bg-white dark:bg-slate-800' }} hover:bg-blue-50/30 dark:hover:bg-slate-700/50 transition-colors duration-150">
                            <td class="px-5 sm:px-7 py-5">
                                <a href="{{ route('notebooks.show', $notebook) }}" class="font-semibold text-gray-900 hover:text-blue-600 transition">
                                    {{ $notebook->patrimonio ?? '—' }}
                                </a>
                            </td>
                            <td class="px-5 sm:px-7 py-5">
                                <span class="font-medium text-gray-900 text-[13px]">{{ $notebook->marca }} {{ $notebook->modelo }}</span>
                            </td>
                            <td class="px-5 sm:px-7 py-5 hidden md:table-cell">
                                <code class="text-xs bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-400 px-2.5 py-1 rounded-lg font-medium">{{ $notebook->numero_serie }}</code>
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

{{-- Funcionários do Grupo --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('grupo.employees_linked') }}</h2>
    </div>
    @if ($grupo->employees->isEmpty())
        <x-ui.empty-state
            icon="employee"
            :title="__('grupo.no_employees')"
        />
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 dark:text-gray-400 bg-gray-50/80 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-600">
                        <x-ui.table-heading :text="__('grupo.employee_table.nome')" />
                        <x-ui.table-heading :text="__('grupo.employee_table.matricula')" class="hidden md:table-cell" />
                        <x-ui.table-heading :text="__('grupo.employee_table.departamento')" class="hidden lg:table-cell" />
                        <x-ui.table-heading :text="__('grupo.employee_table.notebooks_count')" class="text-center whitespace-nowrap" />
                        <x-ui.table-heading :text="__('grupo.employee_table.status')" />
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/60">
                    @foreach ($grupo->employees as $employee)
                        <tr class="{{ $loop->even ? 'bg-gray-50/40 dark:bg-slate-700/30' : 'bg-white dark:bg-slate-800' }} hover:bg-blue-50/30 dark:hover:bg-slate-700/50 transition-colors duration-150">
                            <td class="px-5 sm:px-7 py-5">
                                <a href="{{ route('employees.show', $employee) }}" class="flex items-center gap-3 min-w-0 group">
                                    <x-ui.avatar :name="$employee->nome" size="sm" />
                                    <span class="font-medium text-gray-900 group-hover:text-blue-600 transition truncate text-[13px]">{{ $employee->nome }}</span>
                                </a>
                            </td>
                            <td class="px-5 sm:px-7 py-5 hidden md:table-cell">
                                <code class="text-xs bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-400 px-2.5 py-1 rounded-lg font-medium">{{ $employee->matricula ?? '—' }}</code>
                            </td>
                            <td class="px-5 sm:px-7 py-5 hidden lg:table-cell text-gray-600 text-[13px]">{{ $employee->departamento ?? '—' }}</td>
                            <td class="px-5 sm:px-7 py-5 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 text-xs font-bold">{{ $employee->notebooks_count }}</span>
                            </td>
                            <td class="px-5 sm:px-7 py-5">
                                <x-ui.status-badge :status="$employee->status" :label="$employee->status_label" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

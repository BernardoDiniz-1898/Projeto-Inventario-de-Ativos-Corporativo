@extends('layouts.app')

@section('title', $employee->nome)

@section('content')
<x-ui.back-link :route="route('employees.index')" :label="__('employee.back_to_list')" />

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <div class="flex items-center gap-4">
            <x-ui.avatar :name="$employee->nome" size="lg" />
            <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $employee->nome }}</h1>
            <p class="text-gray-500 text-sm">{{ $employee->departamento ?? __('employee.no_department') }} · {{ $employee->cargo ?? __('employee.no_position') }}</p>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('employees.edit', $employee) }}"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-amber-500 to-amber-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:from-amber-600 hover:to-amber-700 transition shadow-sm shadow-amber-500/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            {{ __('employee.edit') }}
        </a>
        <form action="{{ route('employees.destroy', $employee) }}" method="POST" onsubmit="return confirm('{{ __('employee.delete_confirm') }}')" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center gap-2 bg-red-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-red-600 transition shadow-sm shadow-red-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                {{ __('employee.delete') }}
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <h2 class="text-lg font-bold text-gray-900 mb-6">{{ __('employee.info') }}</h2>
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5">
            <div>
                <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">{{ __('employee.field.name') }}</dt>
                <dd class="text-sm text-gray-800 dark:text-gray-200 font-medium mt-1">{{ $employee->nome }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">{{ __('employee.field.matricula') }}</dt>
                <dd class="text-sm text-gray-800 dark:text-gray-200 font-mono mt-1">{{ $employee->matricula ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">{{ __('employee.field.email') }}</dt>
                <dd class="text-sm text-gray-800 dark:text-gray-200 font-medium mt-1">{{ $employee->email ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">{{ __('employee.field.telefone') }}</dt>
                <dd class="text-sm text-gray-800 dark:text-gray-200 font-medium mt-1">{{ $employee->telefone ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">{{ __('employee.field.departamento') }}</dt>
                <dd class="text-sm text-gray-800 dark:text-gray-200 font-medium mt-1">{{ $employee->departamento ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">{{ __('employee.field.centro_custo') }}</dt>
                <dd class="text-sm text-gray-800 dark:text-gray-200 font-medium mt-1">{{ $employee->centro_custo ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">{{ __('employee.field.projeto') }}</dt>
                <dd class="text-sm text-gray-800 dark:text-gray-200 font-medium mt-1">{{ $employee->projeto ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">{{ __('employee.field.setor') }}</dt>
                <dd class="text-sm text-gray-800 dark:text-gray-200 font-medium mt-1">{{ $employee->setor ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">{{ __('employee.field.cargo') }}</dt>
                <dd class="text-sm text-gray-800 dark:text-gray-200 font-medium mt-1">{{ $employee->cargo ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">{{ __('employee.field.status') }}</dt>
                <dd class="mt-1">
                    <x-ui.status-badge :status="$employee->status" :label="$employee->status_label" />
                </dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">{{ __('employee.field.data_admissao') }}</dt>
                <dd class="text-sm text-gray-800 dark:text-gray-200 font-medium mt-1">{{ $employee->data_admissao?->format('d/m/Y') ?? '—' }}</dd>
            </div>
        </dl>

        @if ($employee->observacoes)
            <div class="mt-6 pt-6 border-t border-gray-100 dark:border-slate-700">
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold mb-2">{{ __('employee.field.observacoes') }}</dt>
                <dd class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line bg-gray-50 dark:bg-slate-700/50 rounded-xl p-4">{{ $employee->observacoes }}</dd>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <h2 class="text-lg font-bold text-gray-900 mb-6">{{ __('employee.history') }}</h2>
        <dl class="space-y-4">
            <div class="flex justify-between items-center">
                <dt class="text-xs text-gray-500 font-medium">{{ __('employee.created_at') }}</dt>
                <dd class="text-xs text-gray-600 dark:text-gray-400 font-medium">{{ $employee->created_at->format('d/m/Y H:i') }}</dd>
            </div>
            <div class="flex justify-between items-center">
                <dt class="text-xs text-gray-500 font-medium">{{ __('employee.updated_at') }}</dt>
                <dd class="text-xs text-gray-600 dark:text-gray-400 font-medium">{{ $employee->updated_at->format('d/m/Y H:i') }}</dd>
            </div>
        </dl>
    </div>
</div>

<div class="mt-6 bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('employee.notebooks_linked') }}</h2>
        <span class="text-sm text-gray-500 font-medium">{{ $notebooks->count() }} notebook(s)</span>
    </div>

    @if ($notebooks->isEmpty())
        <x-ui.empty-state
            icon="notebook"
            :title="__('employee.no_notebooks')"
        />
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 dark:text-gray-400 bg-gray-50/80 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-600">
                        <x-ui.table-heading :text="__('employee.notebook_table.patrimonio')" padding="pb-3" />
                        <x-ui.table-heading :text="__('employee.notebook_table.marca_modelo')" padding="pb-3" />
                        <x-ui.table-heading :text="__('employee.notebook_table.numero_serie')" padding="pb-3" class="hidden md:table-cell" />
                        <x-ui.table-heading :text="__('employee.notebook_table.status')" padding="pb-3" class="hidden lg:table-cell" />
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/60">
                    @foreach ($notebooks as $notebook)
                        <tr class="{{ $loop->even ? 'bg-gray-50/40 dark:bg-slate-700/30' : 'bg-white dark:bg-slate-800' }} hover:bg-blue-50/30 dark:hover:bg-slate-700/50 transition-colors duration-150">
                            <td class="px-5 sm:px-7 py-5">
                                <a href="{{ route('notebooks.show', $notebook) }}" class="font-semibold text-gray-900 hover:text-blue-600 transition">
                                    {{ $notebook->patrimonio ?? '—' }}
                                </a>
                                <div class="text-xs text-gray-400 md:hidden mt-0.5">{{ $notebook->numero_serie }}</div>
                            </td>
                            <td class="px-5 sm:px-7 py-5">
                                <div class="font-medium text-gray-900 text-[13px]">{{ $notebook->marca }} {{ $notebook->modelo }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 lg:hidden mt-0.5">
                                    <x-ui.status-badge :status="$notebook->status" :label="$notebook->status_label" />
                                </div>
                            </td>
                            <td class="px-5 sm:px-7 py-5 hidden md:table-cell">
                                <code class="text-xs bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-400 px-2.5 py-1 rounded-lg font-medium">{{ $notebook->numero_serie }}</code>
                            </td>
                            <td class="px-5 sm:px-7 py-5 hidden lg:table-cell">
                                <x-ui.status-badge :status="$notebook->status" :label="$notebook->status_label" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<div class="mt-6">
    <x-activity-log :logs="$logs" />
</div>
@endsection

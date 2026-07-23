@extends('layouts.app')

@section('title', __('employee.title'))

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('employee.title') }}</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ __('employee.subtitle') }}</p>
    </div>
    <div class="flex flex-wrap items-center gap-2 sm:gap-3">
        <a href="{{ route('employees.export', request()->only('status')) }}"
           class="inline-flex items-center gap-2 bg-emerald-600 text-white px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl text-sm font-semibold hover:bg-emerald-700 transition shadow-sm shadow-emerald-500/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span class="hidden sm:inline">{{ __('employee.export_excel') }}</span>
        </a>
        <a href="{{ route('employees.create') }}"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl text-sm font-semibold hover:from-blue-700 hover:to-blue-800 transition shadow-sm shadow-blue-500/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            {{ __('employee.new') }}
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-6">
    <form method="GET" action="{{ route('employees.index') }}" class="p-4 flex flex-col sm:flex-row gap-3">
        <div class="flex-1 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('employee.search_placeholder') }}"
                   class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
        <select name="status" class="w-full sm:w-auto border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option value="">{{ __('employee.all_statuses') }}</option>
            <option value="ativo" {{ request('status') === 'ativo' ? 'selected' : '' }}>{{ __('employee.status_options.ativo') }}</option>
            <option value="afastado" {{ request('status') === 'afastado' ? 'selected' : '' }}>{{ __('employee.status_options.afastado') }}</option>
            <option value="desligado" {{ request('status') === 'desligado' ? 'selected' : '' }}>{{ __('employee.status_options.desligado') }}</option>
            <option value="ferias" {{ request('status') === 'ferias' ? 'selected' : '' }}>{{ __('employee.status_options.ferias') }}</option>
        </select>
        <select name="grupo_id" class="w-full sm:w-auto border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option value="">{{ __('grupo.all') }}</option>
            @foreach ($grupos as $grupo)
                <option value="{{ $grupo->id }}" {{ request('grupo_id') == $grupo->id ? 'selected' : '' }}>{{ $grupo->nome }}</option>
            @endforeach
        </select>
        <div class="flex gap-2">
            <button type="submit" class="flex-1 sm:flex-none bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300 px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-200 dark:hover:bg-slate-600 transition">
                {{ __('employee.filter') }}
            </button>
            @if (request()->hasAny(['search', 'status', 'grupo_id']))
                <a href="{{ route('employees.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 px-4 py-2.5 text-sm font-medium">
                    {{ __('employee.clear') }}
                </a>
            @endif
        </div>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    @if ($employees->isEmpty())
        <x-ui.empty-state
            icon="employee"
            :title="__('employee.no_results')"
            :hint="__('employee.no_results_hint')"
            :actionLabel="__('employee.register')"
            :actionRoute="route('employees.create')"
        />
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 dark:text-gray-400 bg-gray-50/80 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-600">
                        <x-ui.table-heading :text="__('employee.table.name')" class="min-w-[200px]" />
                        <x-ui.table-heading :text="__('employee.table.matricula')" class="hidden md:table-cell whitespace-nowrap" />
                        <x-ui.table-heading :text="__('employee.table.departamento')" class="hidden lg:table-cell" />
                        <x-ui.table-heading :text="__('grupo.title')" class="hidden xl:table-cell whitespace-nowrap" />
                        <x-ui.table-heading :text="__('employee.table.cargo')" class="hidden xl:table-cell" />
                        <x-ui.table-heading :text="__('employee.table.status')" class="whitespace-nowrap" />
                        <x-ui.table-heading :text="__('employee.table.actions')" class="text-right whitespace-nowrap" />
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/60">
                    @foreach ($employees as $employee)
                        <tr class="{{ $loop->even ? 'bg-gray-50/40 dark:bg-slate-700/30' : 'bg-white dark:bg-slate-800' }} hover:bg-blue-50/30 dark:hover:bg-slate-700/50 transition-colors duration-150">
                            <td class="px-5 sm:px-7 py-5">
                                <a href="{{ route('employees.show', $employee) }}" class="flex items-center gap-4 min-w-0 group">
                                    <x-ui.avatar :name="$employee->nome" size="md" />
                                    <div class="min-w-0 flex-1">
                                        <div class="font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition truncate max-w-[220px] text-[13px]">{{ $employee->nome }}</div>
                                        <div class="text-xs text-gray-400 dark:text-gray-500 md:hidden">{{ $employee->matricula ?? '—' }}</div>
                                        <div class="text-xs text-gray-500 lg:hidden mt-0.5 truncate">{{ $employee->departamento ?? '' }}{{ $employee->cargo ? ' · ' . $employee->cargo : '' }}</div>
                                    </div>
                                </a>
                            </td>
                            <td class="px-5 sm:px-7 py-5 hidden md:table-cell">
                                <code class="text-xs bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-400 px-2.5 py-1 rounded-lg font-medium">{{ $employee->matricula ?? '—' }}</code>
                            </td>
                            <td class="px-5 sm:px-7 py-5 hidden lg:table-cell text-gray-600 text-[13px]">{{ $employee->departamento ?? '—' }}</td>
                            <td class="px-5 sm:px-7 py-5 hidden xl:table-cell text-[13px]">
                                @if ($employee->grupo)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium" style="background-color: {{ $employee->grupo->cor }}20; color: {{ $employee->grupo->cor }}">{{ $employee->grupo->nome }}</span>
                                @else
                                    <span class="text-gray-300 dark:text-slate-600">—</span>
                                @endif
                            </td>
                            <td class="px-5 sm:px-7 py-5 hidden xl:table-cell text-gray-600 text-[13px]">{{ $employee->cargo ?? '—' }}</td>
                            <td class="px-5 sm:px-7 py-5">
                                <x-ui.status-badge :status="$employee->status" :label="$employee->status_label" />
                            </td>
                            <td class="px-5 sm:px-7 py-5 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('employees.show', $employee) }}" class="action-btn p-2 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:text-blue-400 dark:hover:bg-blue-500/10 transition" title="{{ __('employee.view') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('employees.edit', $employee) }}" class="action-btn p-2 rounded-lg text-gray-400 hover:text-amber-600 hover:bg-amber-50 dark:hover:text-amber-400 dark:hover:bg-amber-500/10 transition" title="{{ __('employee.edit') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('employees.destroy', $employee) }}" method="POST" onsubmit="return confirm('{{ __('employee.delete_confirm') }}')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:text-red-400 dark:hover:bg-red-500/10 transition" title="{{ __('employee.delete') }}">
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
            {{ $employees->links() }}
        </div>
    @endif
</div>
@endsection

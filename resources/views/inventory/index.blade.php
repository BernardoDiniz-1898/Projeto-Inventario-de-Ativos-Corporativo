@extends('layouts.app')

@section('title', __('inventory.title'))

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('inventory.title') }}</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ __('inventory.subtitle') }}</p>
    </div>
</div>

<div class="flex gap-3 sm:gap-4 mb-6 overflow-x-auto pb-1">
    <x-ui.stat-card :value="$totalNotebooks" :label="__('inventory.stats.total_notebooks')" color="gray">
        <svg class="w-4.5 h-4.5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
    </x-ui.stat-card>
    <x-ui.stat-card :value="$totalEmployees" :label="__('inventory.stats.total_employees')" color="indigo">
        <svg class="w-4.5 h-4.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
    </x-ui.stat-card>
    <x-ui.stat-card :value="$allocated" :label="__('inventory.stats.allocated')" color="green">
        <svg class="w-4.5 h-4.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    </x-ui.stat-card>
    <x-ui.stat-card :value="$inStock" :label="__('inventory.stats.in_stock')" color="yellow">
        <svg class="w-4.5 h-4.5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
    </x-ui.stat-card>
    <x-ui.stat-card :value="$withoutEquipment" :label="__('inventory.stats.without_equipment')" color="orange">
        <svg class="w-4.5 h-4.5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
    </x-ui.stat-card>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-6">
    <x-ui.search-bar
        action="{{ route('inventory.index') }}"
        :searchValue="$search"
        :filterOptions="['name' => 'filter', 'allLabel' => __('inventory.filters.all'), 'options' => ['allocated' => __('inventory.filters.allocated'), 'stock' => __('inventory.filters.stock'), 'unassigned_employee' => __('inventory.filters.unassigned_employee')]]"
        :filterValue="$filter"
    />
    <div class="px-4 pb-3">
        <select name="grupo_id" onchange="this.form.submit()" class="w-full sm:w-auto border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option value="">{{ __('grupo.all') }}</option>
            @foreach (\App\Models\Grupo::orderBy('nome')->get() as $grupo)
                <option value="{{ $grupo->id }}" {{ ($grupoId ?? '') == $grupo->id ? 'selected' : '' }}>{{ $grupo->nome }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    @if ($paginated->isEmpty())
        <x-ui.empty-state
            icon="inventory"
            :title="__('inventory.empty')"
            :hint="__('inventory.empty_hint')"
        />
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 dark:text-gray-400 bg-gray-50/80 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-600">
                        <x-ui.table-heading :text="__('inventory.table.employee')" class="min-w-[200px]" />
                        <x-ui.table-heading :text="__('grupo.title')" class="hidden md:table-cell whitespace-nowrap" />
                        <x-ui.table-heading :text="__('inventory.table.matricula')" class="hidden md:table-cell whitespace-nowrap" />
                        <x-ui.table-heading :text="__('inventory.table.centro_custo')" class="hidden lg:table-cell whitespace-nowrap" />
                        <x-ui.table-heading :text="__('inventory.table.projeto')" class="hidden lg:table-cell whitespace-nowrap" />
                        <x-ui.table-heading :text="__('inventory.table.notebook')" class="min-w-[180px]" />
                        <x-ui.table-heading :text="__('inventory.table.serial')" class="hidden lg:table-cell whitespace-nowrap" />
                        <x-ui.table-heading :text="__('inventory.table.patrimonio')" class="hidden xl:table-cell whitespace-nowrap" />
                        <x-ui.table-heading :text="__('inventory.table.status')" class="whitespace-nowrap" />
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/60">
                    @foreach ($paginated as $row)
                        <tr class="{{ $loop->even ? 'bg-gray-50/40 dark:bg-slate-700/30' : 'bg-white dark:bg-slate-800' }} hover:bg-blue-50/30 dark:hover:bg-slate-700/50 transition-colors duration-150">
                            {{-- Employee --}}
                            <td class="px-5 sm:px-7 py-5">
                                @if ($row['employee_id'])
                                    <a href="{{ route('employees.show', $row['employee_id']) }}" class="flex items-center gap-4 min-w-0 group">
                                        <x-ui.avatar :name="$row['employee_nome']" size="md" />
                                        <span class="font-medium text-gray-900 group-hover:text-blue-600 transition truncate text-[13px]">{{ $row['employee_nome'] }}</span>
                                    </a>
                                @else
                                    <div class="flex items-center gap-4">
                                        <x-ui.avatar name="" size="md" color="orange">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        </x-ui.avatar>
                                        <span class="text-gray-400 italic text-xs">{{ __('inventory.no_employee') }}</span>
                                    </div>
                                @endif
                            </td>

                            {{-- Grupo --}}
                            <td class="px-5 sm:px-7 py-5 hidden md:table-cell text-[13px]">
                                @if ($row['grupo_nome'])
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium" style="background-color: {{ $row['grupo_cor'] }}20; color: {{ $row['grupo_cor'] }}">{{ $row['grupo_nome'] }}</span>
                                @else
                                    <span class="text-gray-300">&mdash;</span>
                                @endif
                            </td>

                            {{-- Matricula --}}
                            <td class="px-5 sm:px-7 py-5 hidden md:table-cell">
                                @if ($row['employee_matricula'])
                                    <code class="text-xs bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-400 px-2.5 py-1 rounded-lg font-medium">{{ $row['employee_matricula'] }}</code>
                                @else
                                    <span class="text-gray-300">&mdash;</span>
                                @endif
                            </td>

                            {{-- Centro de Custo --}}
                            <td class="px-5 sm:px-7 py-5 hidden lg:table-cell">
                                @if ($row['employee_centro_custo'])
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-slate-100 text-slate-600">{{ $row['employee_centro_custo'] }}</span>
                                @else
                                    <span class="text-gray-300">&mdash;</span>
                                @endif
                            </td>

                            {{-- Projeto --}}
                            <td class="px-5 sm:px-7 py-5 hidden lg:table-cell">
                                @if ($row['employee_projeto'])
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-indigo-50 text-indigo-600">{{ $row['employee_projeto'] }}</span>
                                @else
                                    <span class="text-gray-300">&mdash;</span>
                                @endif
                            </td>

                            {{-- Notebook --}}
                            <td class="px-5 sm:px-7 py-5">
                                @if ($row['notebook_id'])
                                    <a href="{{ route('notebooks.show', $row['notebook_id']) }}" class="flex items-center gap-3 min-w-0 group">
                                        <div class="w-8 h-8 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center shrink-0 group-hover:bg-purple-200 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        </div>
                                        <span class="text-gray-900 group-hover:text-purple-600 transition truncate text-[13px]">{{ $row['notebook_marca'] }} {{ $row['notebook_modelo'] }}</span>
                                    </a>
                                @else
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-gray-100 text-gray-400 rounded-lg flex items-center justify-center shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                        </div>
                                        <span class="text-gray-400 italic text-xs">{{ __('inventory.no_notebook') }}</span>
                                    </div>
                                @endif
                            </td>

                            {{-- Serial --}}
                            <td class="px-5 sm:px-7 py-5 hidden lg:table-cell">
                                @if ($row['notebook_serial'])
                                    <code class="text-xs bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-400 px-2.5 py-1 rounded-lg font-medium">{{ $row['notebook_serial'] }}</code>
                                @else
                                    <span class="text-gray-300">&mdash;</span>
                                @endif
                            </td>

                            {{-- Patrimonio --}}
                            <td class="px-5 sm:px-7 py-5 hidden xl:table-cell text-gray-600 font-mono text-xs">{{ $row['notebook_patrimonio'] ?? '&mdash;' }}</td>

                            {{-- Status --}}
                            <td class="px-5 sm:px-7 py-5">
                                @if ($row['notebook_status'])
                                    <x-ui.status-badge :status="$row['notebook_status']" :label="$row['notebook_status_label']" />
                                @else
                                    <span class="text-gray-300 text-xs">&mdash;</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-5 sm:px-7 py-4 border-t border-gray-100 dark:border-slate-700">
            {{ $paginated->links() }}
        </div>
    @endif
</div>
@endsection
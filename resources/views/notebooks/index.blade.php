@extends('layouts.app')

@section('title', __('notebook.title'))

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">{{ __('notebook.title') }}</h1>
        <p class="text-gray-500 text-sm mt-1">{{ __('notebook.subtitle') }}</p>
    </div>
    <div class="flex flex-wrap items-center gap-2 sm:gap-3">
        <a href="{{ route('notebooks.export', request()->only('status')) }}"
           class="inline-flex items-center gap-2 bg-emerald-600 text-white px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl text-sm font-semibold hover:bg-emerald-700 transition shadow-sm shadow-emerald-500/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span class="hidden xs:inline">{{ __('notebook.export_excel') }}</span>
        </a>
        <a href="{{ route('notebooks.create') }}"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl text-sm font-semibold hover:from-blue-700 hover:to-blue-800 transition shadow-sm shadow-blue-500/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            {{ __('notebook.new') }}
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-6">
    <form method="GET" action="{{ route('notebooks.index') }}" class="p-4 flex flex-col sm:flex-row gap-3">
        <div class="flex-1 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('notebook.search_placeholder') }}"
                   class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
        <select name="status" class="w-full sm:w-auto border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option value="">{{ __('notebook.all_statuses') }}</option>
            <option value="disponivel" {{ request('status') === 'disponivel' ? 'selected' : '' }}>{{ __('notebook.status_options.disponivel') }}</option>
            <option value="em_uso" {{ request('status') === 'em_uso' ? 'selected' : '' }}>{{ __('notebook.status_options.em_uso') }}</option>
            <option value="manutencao" {{ request('status') === 'manutencao' ? 'selected' : '' }}>{{ __('notebook.status_options.manutencao') }}</option>
            <option value="ocioso" {{ request('status') === 'ocioso' ? 'selected' : '' }}>{{ __('notebook.status_options.ocioso') }}</option>
            <option value="devolvido" {{ request('status') === 'devolvido' ? 'selected' : '' }}>{{ __('notebook.status_options.devolvido') }}</option>
            <option value="obsoleto" {{ request('status') === 'obsoleto' ? 'selected' : '' }}>{{ __('notebook.status_options.obsoleto') }}</option>
            <option value="baixa" {{ request('status') === 'baixa' ? 'selected' : '' }}>{{ __('notebook.status_options.baixa') }}</option>
            <option value="extraviado" {{ request('status') === 'extraviado' ? 'selected' : '' }}>{{ __('notebook.status_options.extraviado') }}</option>
            <option value="transferido" {{ request('status') === 'transferido' ? 'selected' : '' }}>{{ __('notebook.status_options.transferido') }}</option>
            <option value="alugado" {{ request('status') === 'alugado' ? 'selected' : '' }}>{{ __('notebook.status_options.alugado') }}</option>
        </select>
        <div class="flex gap-2">
            <button type="submit" class="flex-1 sm:flex-none bg-gray-100 text-gray-700 px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-200 transition">
                {{ __('notebook.filter') }}
            </button>
            @if (request()->hasAny(['search', 'status']))
                <a href="{{ route('notebooks.index') }}" class="text-gray-500 hover:text-gray-700 px-4 py-2.5 text-sm font-medium">
                    {{ __('notebook.clear') }}
                </a>
            @endif
        </div>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    @if ($notebooks->isEmpty())
        <div class="p-16 text-center">
            <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <p class="text-gray-500 font-medium mb-2">{{ __('notebook.no_results') }}</p>
            <p class="text-gray-400 text-sm mb-5">{{ __('notebook.no_results_hint') }}</p>
            <a href="{{ route('notebooks.create') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('notebook.register_first') }}
            </a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 bg-gray-50 border-b border-gray-100">
                        <th class="px-4 sm:px-6 py-3 font-medium text-xs uppercase tracking-wider">{{ __('notebook.title') }}</th>
                        <th class="px-4 sm:px-6 py-3 font-medium text-xs uppercase tracking-wider hidden md:table-cell">{{ __('notebook.serial_number') }}</th>
                        <th class="px-4 sm:px-6 py-3 font-medium text-xs uppercase tracking-wider hidden lg:table-cell">{{ __('notebook.responsible_employee') }}</th>
                        <th class="px-4 sm:px-6 py-3 font-medium text-xs uppercase tracking-wider">{{ __('notebook.status_field') }}</th>
                        <th class="px-4 sm:px-6 py-3 font-medium text-xs uppercase tracking-wider text-right">{{ __('notebook.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($notebooks as $notebook)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 sm:px-6 py-4">
                                <div>
                                    <span class="font-semibold text-gray-900 text-sm">{{ $notebook->patrimonio ?? '—' }}</span>
                                    <div class="font-medium text-gray-800">{{ $notebook->marca }} {{ $notebook->modelo }}</div>
                                    <div class="text-xs text-gray-400 md:hidden">{{ $notebook->numero_serie }}</div>
                                    <div class="text-xs text-gray-500 lg:hidden mt-0.5">{{ $notebook->funcionario->nome ?? __('notebook.no_responsible') }}</div>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 hidden md:table-cell">
                                <code class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-lg">{{ $notebook->numero_serie }}</code>
                            </td>
                            <td class="px-4 sm:px-6 py-4 hidden lg:table-cell">
                                @if ($notebook->funcionario)
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center font-semibold text-xs">
                                        {{ strtoupper(substr($notebook->funcionario->nome, 0, 2)) }}
                                    </div>
                                    <span class="text-gray-700">{{ $notebook->funcionario->nome }}</span>
                                </div>
                                @else
                                <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold
                                    {{ match($notebook->status) {
                                        'disponivel' => 'bg-green-100 text-green-700',
                                        'em_uso' => 'bg-blue-100 text-blue-700',
                                        'manutencao' => 'bg-yellow-100 text-yellow-700',
                                        'ocioso' => 'bg-orange-100 text-orange-700',
                                        'devolvido' => 'bg-purple-100 text-purple-700',
                                        'obsoleto' => 'bg-red-100 text-red-700',
                                        'baixa' => 'bg-slate-100 text-slate-700',
                                        'extraviado' => 'bg-pink-100 text-pink-700',
                                        'transferido' => 'bg-cyan-100 text-cyan-700',
                                        'alugado' => 'bg-violet-100 text-violet-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    } }}">
                                    {{ $notebook->status_label }}
                                </span>
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('notebooks.show', $notebook) }}" class="p-2 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition" title="{{ __('notebook.view_button') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('notebooks.edit', $notebook) }}" class="p-2 rounded-lg text-gray-400 hover:text-amber-600 hover:bg-amber-50 transition" title="{{ __('notebook.edit_button') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('notebooks.destroy', $notebook) }}" method="POST" onsubmit="return confirm('{{ __('notebook.delete_confirm') }}')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition" title="{{ __('notebook.delete_button') }}">
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

        <div class="px-6 py-4 border-t border-gray-100">
            {{ $notebooks->links() }}
        </div>
    @endif
</div>
@endsection

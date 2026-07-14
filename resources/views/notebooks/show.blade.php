@extends('layouts.app')

@section('title', $notebook->marca . ' ' . $notebook->modelo)

@section('content')
<div class="mb-6">
    <a href="{{ route('notebooks.index') }}" class="text-sm text-gray-500 hover:text-gray-700 inline-flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        {{ __('notebook.back_to_list') }}
    </a>
</div>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div class="flex items-center gap-4">
        <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center">
            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $notebook->marca }} {{ $notebook->modelo }}</h1>
            <p class="text-gray-500 text-sm">            {{ $notebook->patrimonio ?? __('notebook.no_asset') }} · {{ $notebook->numero_serie }}</p>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('notebooks.edit', $notebook) }}"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-amber-500 to-amber-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:from-amber-600 hover:to-amber-700 transition shadow-sm shadow-amber-500/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            {{ __('notebook.edit_button') }}
        </a>
        <form action="{{ route('notebooks.destroy', $notebook) }}" method="POST" onsubmit="return confirm('{{ __('notebook.delete_confirm') }}')" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center gap-2 bg-red-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-red-600 transition shadow-sm shadow-red-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                {{ __('notebook.delete_button') }}
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <h2 class="text-lg font-bold text-gray-900 mb-6">{{ __('notebook.info') }}</h2>
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5">
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.brand') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->marca }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.model') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->modelo }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.serial_number') }}</dt>
                <dd class="text-sm text-gray-800 font-mono mt-1">{{ $notebook->numero_serie }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.asset_number_field') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->patrimonio ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.status_field') }}</dt>
                <dd class="mt-1">
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
                </dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.responsible_employee') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">
                    @if ($notebook->funcionario)
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center font-semibold text-xs">
                                {{ strtoupper(substr($notebook->funcionario->nome, 0, 2)) }}
                            </div>
                            <a href="{{ route('employees.show', $notebook->funcionario) }}" class="text-blue-600 hover:underline">
                                {{ $notebook->funcionario->nome }}
                            </a>
                        </div>
                    @else
                        <span class="text-gray-400">—</span>
                    @endif
                </dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.delivery_date') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->data_entrega?->format('d/m/Y') ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.os') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->sistema_operacional ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.processor') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->processador ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.ram') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->ram_gb ? $notebook->ram_gb . ' GB' : '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.storage') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->armazenamento ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.acquisition_date') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->data_aquisicao?->format('d/m/Y') ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.warranty_date') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->data_garantia?->format('d/m/Y') ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.supplier') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->fornecedor ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.price') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->preco ? 'R$ ' . number_format($notebook->preco, 2, ',', '.') : '—' }}</dd>
            </div>
        </dl>

        @if ($notebook->observacoes)
            <div class="mt-6 pt-6 border-t border-gray-100">
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold mb-2">{{ __('notebook.observations') }}</dt>
                <dd class="text-sm text-gray-700 whitespace-pre-line bg-gray-50 rounded-xl p-4">{{ $notebook->observacoes }}</dd>
            </div>
        @endif
    </div>

    {{-- ISO 27001 --}}
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <h2 class="text-lg font-bold text-gray-900 mb-6">{{ __('notebook.iso_title') }}</h2>
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5">
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.iso_classification') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->classificacao_label ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.iso_criticity') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->criticidade_label ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.iso_location') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->localizacao ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.iso_building_floor_room') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ trim($notebook->predio . ' ' . $notebook->andar . ' ' . $notebook->sala) ?: '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.iso_eol') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->data_vida_util?->format('d/m/Y') ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.iso_decommission_date') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->data_baixa?->format('d/m/Y') ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.iso_decommission_reason') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->motivo_baixa_label ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.iso_disposal_method') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->metodo_descarte_label ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.iso_encryption') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->criptografia ? __('notebook.enabled') : __('notebook.disabled') }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.iso_antivirus') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->antivirus ? __('notebook.enabled') : __('notebook.disabled') }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.iso_patches') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->patches_label ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.iso_backup') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->backup_configurado ? __('notebook.enabled') : __('notebook.disabled') }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.iso_maintenance_history') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->ultima_manutencao?->format('d/m/Y') ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.iso_next_maintenance') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->proxima_manutencao?->format('d/m/Y') ?? '—' }}</dd>
            </div>
        </dl>
        @if ($notebook->historico_manutencao)
            <div class="mt-6 pt-6 border-t border-gray-100">
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold mb-2">{{ __('notebook.iso_maintenance_history') }}</dt>
                <dd class="text-sm text-gray-700 whitespace-pre-line bg-gray-50 rounded-xl p-4">{{ $notebook->historico_manutencao }}</dd>
            </div>
        @endif
    </div>

    {{-- Aluguel --}}
    @if ($notebook->empresa_locataria || $notebook->valor_aluguel)
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <h2 class="text-lg font-bold text-gray-900 mb-6">{{ __('notebook.rental_title') }}</h2>
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5">
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.rental_company') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->empresa_locataria ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.rental_contract_number') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->numero_contrato ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.rental_value') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->valor_aluguel ? 'R$ ' . number_format($notebook->valor_aluguel, 2, ',', '.') : '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.rental_period') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->periodo_aluguel_label }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.rental_start') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->data_inicio_aluguel?->format('d/m/Y') ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ __('notebook.rental_end') }}</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $notebook->data_fim_aluguel?->format('d/m/Y') ?? '—' }}</dd>
            </div>
        </dl>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <h2 class="text-lg font-bold text-gray-900 mb-6">{{ __('notebook.history') }}</h2>
        <dl class="space-y-4">
            <div class="flex justify-between items-center">
                <dt class="text-xs text-gray-500 font-medium">{{ __('notebook.created_at') }}</dt>
                <dd class="text-xs text-gray-600 font-medium">{{ $notebook->created_at->format('d/m/Y H:i') }}</dd>
            </div>
            <div class="flex justify-between items-center">
                <dt class="text-xs text-gray-500 font-medium">{{ __('notebook.updated_at') }}</dt>
                <dd class="text-xs text-gray-600 font-medium">{{ $notebook->updated_at->format('d/m/Y H:i') }}</dd>
            </div>
        </dl>
    </div>
</div>

<div class="mt-6">
    <x-activity-log :logs="$logs" />
</div>
@endsection

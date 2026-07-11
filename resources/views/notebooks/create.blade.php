@extends('layouts.app')

@section('title', __('notebook.create_title'))

@section('content')
<div class="mb-6">
    <a href="{{ route('notebooks.index') }}" class="text-sm text-gray-500 hover:text-gray-700 inline-flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Voltar para {{ __('notebook.title') }}
    </a>
</div>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">{{ __('notebook.create_title') }}</h1>
    <p class="text-gray-500 text-sm mt-1">{{ __('notebook.create_subtitle') }}</p>
</div>

<form action="{{ route('notebooks.store') }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div>
            <label for="marca" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('notebook.brand') }} *</label>
            <input type="text" id="marca" name="marca" value="{{ old('marca') }}" required
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('marca') border-red-300 @enderror"
                   placeholder="{{ __('notebook.brand_placeholder') }}">
            @error('marca')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="modelo" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('notebook.model') }} *</label>
            <input type="text" id="modelo" name="modelo" value="{{ old('modelo') }}" required
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('modelo') border-red-300 @enderror"
                   placeholder="{{ __('notebook.model_placeholder') }}">
            @error('modelo')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="numero_serie" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('notebook.serial_number') }} *</label>
            <input type="text" id="numero_serie" name="numero_serie" value="{{ old('numero_serie') }}" required
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('numero_serie') border-red-300 @enderror"
                   placeholder="{{ __('notebook.serial_number_placeholder') }}">
            @error('numero_serie')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="patrimonio" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('notebook.asset_number_field') }}</label>
            <input type="text" id="patrimonio" name="patrimonio" value="{{ old('patrimonio') }}"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('patrimonio') border-red-300 @enderror"
                   placeholder="PAT-00000">
            @error('patrimonio')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('notebook.status_field') }} *</label>
            <select id="status" name="status" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('status') border-red-300 @enderror">
                <option value="disponivel" {{ old('status') === 'disponivel' ? 'selected' : '' }}>{{ __('notebook.status_options.disponivel') }}</option>
                <option value="em_uso" {{ old('status', 'em_uso') === 'em_uso' ? 'selected' : '' }}>{{ __('notebook.status_options.em_uso') }}</option>
                <option value="manutencao" {{ old('status') === 'manutencao' ? 'selected' : '' }}>{{ __('notebook.status_options.manutencao') }}</option>
                <option value="ocioso" {{ old('status') === 'ocioso' ? 'selected' : '' }}>{{ __('notebook.status_options.ocioso') }}</option>
                <option value="devolvido" {{ old('status') === 'devolvido' ? 'selected' : '' }}>{{ __('notebook.status_options.devolvido') }}</option>
                <option value="obsoleto" {{ old('status') === 'obsoleto' ? 'selected' : '' }}>{{ __('notebook.status_options.obsoleto') }}</option>
                <option value="baixa" {{ old('status') === 'baixa' ? 'selected' : '' }}>{{ __('notebook.status_options.baixa') }}</option>
                <option value="extraviado" {{ old('status') === 'extraviado' ? 'selected' : '' }}>{{ __('notebook.status_options.extraviado') }}</option>
                <option value="transferido" {{ old('status') === 'transferido' ? 'selected' : '' }}>{{ __('notebook.status_options.transferido') }}</option>
                <option value="alugado" {{ old('status') === 'alugado' ? 'selected' : '' }}>{{ __('notebook.status_options.alugado') }}</option>
            </select>
            @error('status')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div x-data="searchableSelect()" x-init="$nextTick(() => init())">
            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('notebook.responsible_employee') }}</label>
            <input type="hidden" name="funcionario_id" :value="selectedId">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" x-model="search" @input="filter()" @focus="open()" @click.outside="close()"
                       class="w-full border border-gray-200 rounded-xl pl-10 pr-10 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                       placeholder="Digite o nome do funcionário..." autocomplete="off">
                <button type="button" x-show="selectedId" @click="clear()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <div x-show="openDropdown" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                     class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-lg max-h-60 overflow-y-auto">
                    <template x-if="filtered.length === 0">
                        <div class="px-4 py-3 text-sm text-gray-500 text-center">Nenhum funcionário encontrado</div>
                    </template>
                    <template x-for="item in filtered" :key="item.id">
                        <div @click="select(item)" class="px-4 py-2.5 text-sm cursor-pointer hover:bg-blue-50 flex items-center gap-3 transition-colors">
                            <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center font-semibold text-xs" x-text="initials(item.nome)"></div>
                            <div class="flex-1 min-w-0">
                                <div class="font-medium text-gray-800 truncate" x-text="item.nome"></div>
                                <div class="text-xs text-gray-400 truncate" x-text="item.departamento || 'Sem departamento'"></div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <div>
            <label for="data_entrega" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('notebook.delivery_date') }}</label>
            <input type="date" id="data_entrega" name="data_entrega" value="{{ old('data_entrega') }}"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('data_entrega') border-red-300 @enderror">
            @error('data_entrega')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="sistema_operacional" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('notebook.os') }}</label>
            <input type="text" id="sistema_operacional" name="sistema_operacional" value="{{ old('sistema_operacional') }}"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('sistema_operacional') border-red-300 @enderror"
                   placeholder="{{ __('notebook.os_placeholder') }}">
            @error('sistema_operacional')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="processador" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('notebook.processor') }}</label>
            <input type="text" id="processador" name="processador" value="{{ old('processador') }}"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('processador') border-red-300 @enderror"
                   placeholder="{{ __('notebook.processor_placeholder') }}">
            @error('processador')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="ram_gb" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('notebook.ram') }}</label>
            <input type="number" id="ram_gb" name="ram_gb" value="{{ old('ram_gb') }}" min="1" step="0.1"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('ram_gb') border-red-300 @enderror"
                   placeholder="{{ __('notebook.ram_placeholder') }}">
            @error('ram_gb')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="armazenamento" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('notebook.storage') }}</label>
            <input type="text" id="armazenamento" name="armazenamento" value="{{ old('armazenamento') }}"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('armazenamento') border-red-300 @enderror"
                   placeholder="{{ __('notebook.storage_placeholder') }}">
            @error('armazenamento')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="data_aquisicao" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('notebook.acquisition_date') }}</label>
            <input type="date" id="data_aquisicao" name="data_aquisicao" value="{{ old('data_aquisicao') }}"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('data_aquisicao') border-red-300 @enderror">
            @error('data_aquisicao')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="data_garantia" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('notebook.warranty_date') }}</label>
            <input type="date" id="data_garantia" name="data_garantia" value="{{ old('data_garantia') }}"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('data_garantia') border-red-300 @enderror">
            @error('data_garantia')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="forncedor" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('notebook.supplier') }}</label>
            <input type="text" id="forncedor" name="forncedor" value="{{ old('forncedor') }}"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('forncedor') border-red-300 @enderror"
                   placeholder="{{ __('notebook.supplier_placeholder') }}">
            @error('forncedor')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="preco" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('notebook.price') }}</label>
            <input type="number" id="preco" name="preco" value="{{ old('preco') }}" min="0" step="0.01"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('preco') border-red-300 @enderror"
                   placeholder="0.00">
            @error('preco')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div class="md:col-span-2 lg:col-span-3">
            <label for="observacoes" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('notebook.observations') }}</label>
            <textarea id="observacoes" name="observacoes" rows="3"
                      class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('observacoes') border-red-300 @enderror"
                      placeholder="{{ __('notebook.observations_placeholder') }}">{{ old('observacoes') }}</textarea>
            @error('observacoes')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>
    </div>

    @include('notebooks._iso_fields')

    <div class="mt-8 pt-6 border-t border-gray-100 flex items-center gap-3">
        <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-3 rounded-xl text-sm font-semibold hover:from-blue-700 hover:to-blue-800 transition shadow-sm shadow-blue-500/20">
            {{ __('notebook.save') }}
        </button>
        <a href="{{ route('notebooks.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium px-4 py-3">
            Cancelar
        </a>
        <span class="text-xs text-gray-400 ml-auto">{{ __('notebook.required_fields') }}</span>
    </div>
</form>

<script>
    window._employeesData = @js($employees->map(fn($e) => ['id' => $e->id, 'nome' => $e->nome, 'departamento' => $e->departamento ?? '']));
    window._selectedEmployeeId = @js(old('funcionario_id'));
</script>
@endsection

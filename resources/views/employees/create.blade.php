@extends('layouts.app')

@section('title', 'Novo Funcionário')

@section('content')
<div class="mb-6">
    <a href="{{ route('employees.index') }}" class="text-sm text-gray-500 hover:text-gray-700 inline-flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Voltar para Funcionários
    </a>
</div>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Novo Funcionário</h1>
    <p class="text-gray-500 text-sm mt-1">Preencha os dados para cadastrar um novo funcionário</p>
</div>

<form action="{{ route('employees.store') }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div>
            <label for="nome" class="block text-sm font-semibold text-gray-700 mb-2">Nome *</label>
            <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('nome') border-red-300 @enderror"
                   placeholder="Nome completo">
            @error('nome')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="matricula" class="block text-sm font-semibold text-gray-700 mb-2">Matrícula</label>
            <input type="text" id="matricula" name="matricula" value="{{ old('matricula') }}"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('matricula') border-red-300 @enderror"
                   placeholder="MAT-00000">
            @error('matricula')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-300 @enderror"
                   placeholder="email@empresa.com">
            @error('email')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="telefone" class="block text-sm font-semibold text-gray-700 mb-2">Telefone</label>
            <input type="text" id="telefone" name="telefone" value="{{ old('telefone') }}"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('telefone') border-red-300 @enderror"
                   placeholder="(11) 99999-9999">
            @error('telefone')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="departamento" class="block text-sm font-semibold text-gray-700 mb-2">Departamento</label>
            <input type="text" id="departamento" name="departamento" value="{{ old('departamento') }}"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('departamento') border-red-300 @enderror"
                   placeholder="Ex: TI, Financeiro, RH...">
            @error('departamento')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="centro_custo" class="block text-sm font-semibold text-gray-700 mb-2">Centro de Custo</label>
            <input type="text" id="centro_custo" name="centro_custo" value="{{ old('centro_custo') }}"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('centro_custo') border-red-300 @enderror"
                   placeholder="Ex: CC-001, TI-SP...">
            @error('centro_custo')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="projeto" class="block text-sm font-semibold text-gray-700 mb-2">Projeto</label>
            <input type="text" id="projeto" name="projeto" value="{{ old('projeto') }}"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('projeto') border-red-300 @enderror"
                   placeholder="Ex: Projeto Alpha, Migração...">
            @error('projeto')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="setor" class="block text-sm font-semibold text-gray-700 mb-2">Setor</label>
            <input type="text" id="setor" name="setor" value="{{ old('setor') }}"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('setor') border-red-300 @enderror"
                   placeholder="Ex: Desenvolvimento, Suporte...">
            @error('setor')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="cargo" class="block text-sm font-semibold text-gray-700 mb-2">Cargo</label>
            <input type="text" id="cargo" name="cargo" value="{{ old('cargo') }}"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('cargo') border-red-300 @enderror"
                   placeholder="Ex: Analista, Gerente...">
            @error('cargo')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status *</label>
            <select id="status" name="status" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('status') border-red-300 @enderror">
                <option value="ativo" {{ old('status', 'ativo') === 'ativo' ? 'selected' : '' }}>Ativo</option>
                <option value="afastado" {{ old('status') === 'afastado' ? 'selected' : '' }}>Afastado</option>
                <option value="desligado" {{ old('status') === 'desligado' ? 'selected' : '' }}>Desligado</option>
                <option value="ferias" {{ old('status') === 'ferias' ? 'selected' : '' }}>Férias</option>
            </select>
            @error('status')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="data_admissao" class="block text-sm font-semibold text-gray-700 mb-2">Data de Admissão</label>
            <input type="date" id="data_admissao" name="data_admissao" value="{{ old('data_admissao') }}"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('data_admissao') border-red-300 @enderror">
            @error('data_admissao')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div class="md:col-span-2 lg:col-span-3">
            <label for="observacoes" class="block text-sm font-semibold text-gray-700 mb-2">Observações</label>
            <textarea id="observacoes" name="observacoes" rows="3"
                      class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('observacoes') border-red-300 @enderror"
                      placeholder="Observações adicionais...">{{ old('observacoes') }}</textarea>
            @error('observacoes')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="mt-8 pt-6 border-t border-gray-100 flex items-center gap-3">
        <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-3 rounded-xl text-sm font-semibold hover:from-blue-700 hover:to-blue-800 transition shadow-sm shadow-blue-500/20">
            Salvar Funcionário
        </button>
        <a href="{{ route('employees.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium px-4 py-3">
            Cancelar
        </a>
    </div>
</form>
@endsection

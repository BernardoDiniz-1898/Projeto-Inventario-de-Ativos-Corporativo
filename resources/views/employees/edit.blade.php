@extends('layouts.app')

@section('title', __('employee.edit_title'))

@section('content')
<div class="mb-6">
    <a href="{{ route('employees.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 inline-flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        {{ __('employee.back_to_list') }}
    </a>
</div>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('employee.edit_title') }}</h1>
    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ __('employee.edit_hint', ['name' => $employee->nome]) }}</p>
</div>

<form action="{{ route('employees.update', $employee) }}" method="POST" class="form-card bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 sm:p-8">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div>
            <label for="nome" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('employee.field.name') }} *</label>
            <input type="text" id="nome" name="nome" value="{{ old('nome', $employee->nome) }}" required
                   class="w-full border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('nome') border-red-300 @enderror">
            @error('nome')
                <p class="text-red-500 dark:text-red-400 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="matricula" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('employee.field.matricula') }}</label>
            <input type="text" id="matricula" name="matricula" value="{{ old('matricula', $employee->matricula) }}"
                   class="w-full border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('matricula') border-red-300 @enderror">
            @error('matricula')
                <p class="text-red-500 dark:text-red-400 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('employee.field.email') }}</label>
            <input type="email" id="email" name="email" value="{{ old('email', $employee->email) }}"
                   class="w-full border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-300 @enderror">
            @error('email')
                <p class="text-red-500 dark:text-red-400 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="telefone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('employee.field.telefone') }}</label>
            <input type="text" id="telefone" name="telefone" value="{{ old('telefone', $employee->telefone) }}"
                   class="w-full border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('telefone') border-red-300 @enderror">
            @error('telefone')
                <p class="text-red-500 dark:text-red-400 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="departamento" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('employee.field.departamento') }}</label>
            <input type="text" id="departamento" name="departamento" value="{{ old('departamento', $employee->departamento) }}"
                   class="w-full border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('departamento') border-red-300 @enderror">
            @error('departamento')
                <p class="text-red-500 dark:text-red-400 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="centro_custo" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('employee.field.centro_custo') }}</label>
            <input type="text" id="centro_custo" name="centro_custo" value="{{ old('centro_custo', $employee->centro_custo) }}"
                   class="w-full border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('centro_custo') border-red-300 @enderror">
            @error('centro_custo')
                <p class="text-red-500 dark:text-red-400 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="projeto" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('employee.field.projeto') }}</label>
            <input type="text" id="projeto" name="projeto" value="{{ old('projeto', $employee->projeto) }}"
                   class="w-full border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('projeto') border-red-300 @enderror">
            @error('projeto')
                <p class="text-red-500 dark:text-red-400 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="setor" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('employee.field.setor') }}</label>
            <input type="text" id="setor" name="setor" value="{{ old('setor', $employee->setor) }}"
                   class="w-full border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('setor') border-red-300 @enderror">
            @error('setor')
                <p class="text-red-500 dark:text-red-400 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="cargo" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('employee.field.cargo') }}</label>
            <input type="text" id="cargo" name="cargo" value="{{ old('cargo', $employee->cargo) }}"
                   class="w-full border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('cargo') border-red-300 @enderror">
            @error('cargo')
                <p class="text-red-500 dark:text-red-400 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('employee.field.status') }} *</label>
            <select id="status" name="status" required
                    class="w-full border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('status') border-red-300 @enderror">
                <option value="ativo" {{ old('status', $employee->status) === 'ativo' ? 'selected' : '' }}>{{ __('employee.status_options.ativo') }}</option>
                <option value="afastado" {{ old('status', $employee->status) === 'afastado' ? 'selected' : '' }}>{{ __('employee.status_options.afastado') }}</option>
                <option value="desligado" {{ old('status', $employee->status) === 'desligado' ? 'selected' : '' }}>{{ __('employee.status_options.desligado') }}</option>
                <option value="ferias" {{ old('status', $employee->status) === 'ferias' ? 'selected' : '' }}>{{ __('employee.status_options.ferias') }}</option>
            </select>
            @error('status')
                <p class="text-red-500 dark:text-red-400 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="grupo_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('grupo.title') }}</label>
            <select id="grupo_id" name="grupo_id"
                    class="w-full border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('grupo_id') border-red-300 @enderror">
                <option value="">—</option>
                @foreach ($grupos as $grupo)
                    <option value="{{ $grupo->id }}" {{ old('grupo_id', $employee->grupo_id) == $grupo->id ? 'selected' : '' }}>{{ $grupo->nome }}</option>
                @endforeach
            </select>
            @error('grupo_id')
                <p class="text-red-500 dark:text-red-400 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="data_admissao" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('employee.field.data_admissao') }}</label>
            <input type="date" id="data_admissao" name="data_admissao" value="{{ old('data_admissao', $employee->data_admissao?->format('Y-m-d')) }}"
                   class="w-full border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('data_admissao') border-red-300 @enderror">
            @error('data_admissao')
                <p class="text-red-500 dark:text-red-400 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div class="md:col-span-2 lg:col-span-3">
            <label for="observacoes" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('employee.field.observacoes') }}</label>
            <textarea id="observacoes" name="observacoes" rows="3"
                      class="w-full border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('observacoes') border-red-300 @enderror">{{ old('observacoes', $employee->observacoes) }}</textarea>
            @error('observacoes')
                <p class="text-red-500 dark:text-red-400 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-slate-700 flex items-center gap-3">
        <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-3 rounded-xl text-sm font-semibold hover:from-blue-700 hover:to-blue-800 transition shadow-sm shadow-blue-500/20">
            {{ __('employee.update') }}
        </button>
        <a href="{{ route('employees.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 text-sm font-medium px-4 py-3">
            {{ __('employee.cancel') }}
        </a>
    </div>
</form>
@endsection

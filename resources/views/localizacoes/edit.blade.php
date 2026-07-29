@extends('layouts.app')

@section('title', __('localizacao.edit_title'))

@section('content')
<div class="mb-6">
    <a href="{{ route('localizacoes.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 inline-flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        {{ __('localizacao.back_to') }} {{ __('localizacao.title') }}
    </a>
</div>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('localizacao.edit_title') }}</h1>
    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ __('localizacao.edit_subtitle') }} {{ $localizacao->nome }}</p>
</div>

<form action="{{ route('localizacoes.update', $localizacao) }}" method="POST" class="form-card bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 sm:p-8">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="md:col-span-2 lg:col-span-3">
            <label for="nome" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('localizacao.field.name') }} *</label>
            <input type="text" id="nome" name="nome" value="{{ old('nome', $localizacao->nome) }}" required
                   class="w-full border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('nome') border-red-300 @enderror"
                   placeholder="{{ __('localizacao.name_placeholder') }}">
            @error('nome')
                <p class="text-red-500 dark:text-red-400 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="grupo_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('localizacao.field.group') }}</label>
            <select id="grupo_id" name="grupo_id"
                    class="w-full border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('grupo_id') border-red-300 @enderror">
                <option value="">—</option>
                @foreach ($grupos as $grupo)
                    <option value="{{ $grupo->id }}" {{ old('grupo_id', $localizacao->grupo_id) == $grupo->id ? 'selected' : '' }}>{{ $grupo->nome }}</option>
                @endforeach
            </select>
            @error('grupo_id')
                <p class="text-red-500 dark:text-red-400 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="predio" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('localizacao.field.building') }}</label>
            <input type="text" id="predio" name="predio" value="{{ old('predio', $localizacao->predio) }}"
                   class="w-full border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('predio') border-red-300 @enderror"
                   placeholder="{{ __('localizacao.building_placeholder') }}">
            @error('predio')
                <p class="text-red-500 dark:text-red-400 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="andar" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('localizacao.field.floor') }}</label>
            <input type="text" id="andar" name="andar" value="{{ old('andar', $localizacao->andar) }}"
                   class="w-full border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('andar') border-red-300 @enderror"
                   placeholder="{{ __('localizacao.floor_placeholder') }}">
            @error('andar')
                <p class="text-red-500 dark:text-red-400 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="sala" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('localizacao.field.room') }}</label>
            <input type="text" id="sala" name="sala" value="{{ old('sala', $localizacao->sala) }}"
                   class="w-full border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('sala') border-red-300 @enderror"
                   placeholder="{{ __('localizacao.room_placeholder') }}">
            @error('sala')
                <p class="text-red-500 dark:text-red-400 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-slate-700 flex items-center gap-3">
        <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-3 rounded-xl text-sm font-semibold hover:from-blue-700 hover:to-blue-800 transition shadow-sm shadow-blue-500/20">
            {{ __('localizacao.update') }}
        </button>
        <a href="{{ route('localizacoes.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 text-sm font-medium px-4 py-3">
            {{ __('localizacao.cancel') }}
        </a>
    </div>
</form>
@endsection

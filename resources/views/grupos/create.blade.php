@extends('layouts.app')

@section('title', __('grupo.create_title'))

@section('content')
<x-ui.back-link :route="route('grupos.index')" :label="__('grupo.back_to_list')" />

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('grupo.create_title') }}</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ __('grupo.create_subtitle') }}</p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
    <form action="{{ route('grupos.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="sm:col-span-2">
                <label class="block text-xs text-gray-500 uppercase tracking-wide font-semibold mb-1.5">{{ __('grupo.name') }} *</label>
                <input type="text" name="nome" value="{{ old('nome') }}" placeholder="{{ __('grupo.name_placeholder') }}" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nome') border-red-300 @enderror">
                @error('nome')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-2">
                <label class="block text-xs text-gray-500 uppercase tracking-wide font-semibold mb-1.5">{{ __('grupo.description') }}</label>
                <textarea name="descricao" rows="3" placeholder="{{ __('grupo.description_placeholder') }}"
                          class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('descricao') }}</textarea>
            </div>

            <div>
                <label class="block text-xs text-gray-500 uppercase tracking-wide font-semibold mb-1.5">{{ __('grupo.color') }}</label>
                <div class="flex items-center gap-3">
                    <input type="color" name="cor" value="{{ old('cor', '#6366f1') }}"
                           class="w-10 h-10 rounded-lg border border-gray-200 cursor-pointer p-0.5">
                    <input type="text" name="cor" value="{{ old('cor', '#6366f1') }}" placeholder="{{ __('grupo.color_placeholder') }}"
                           class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono">
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-100">
            <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:from-blue-700 hover:to-blue-800 transition shadow-sm shadow-blue-500/20">
                {{ __('grupo.save') }}
            </button>
            <a href="{{ route('grupos.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 px-4 py-2.5 text-sm font-medium">
                {{ __('common.cancel') }}
            </a>
        </div>
    </form>
</div>
@endsection

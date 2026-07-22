@extends('layouts.app')

@section('title', __('user.new'))

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 inline-flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        {{ __('user.back') }}
    </a>
</div>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('user.new') }}</h1>
    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ __('user.create_hint') }}</p>
</div>

<form action="{{ route('admin.users.store') }}" method="POST" class="form-card bg-white rounded-lg shadow-sm border border-gray-100 p-6 sm:p-8">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('user.field.name') }} *</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                   class="w-full border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('name') border-red-300 @enderror"
                   placeholder="{{ __('user.field.name_placeholder') }}">
            @error('name')
                <p class="text-red-500 dark:text-red-400 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('user.field.email') }} *</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                   class="w-full border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-300 @enderror"
                   placeholder="{{ __('user.field.email_placeholder') }}">
            @error('email')
                <p class="text-red-500 dark:text-red-400 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('user.field.password') }} *</label>
            <input type="password" id="password" name="password" required
                   class="w-full border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('password') border-red-300 @enderror"
                   placeholder="{{ __('user.field.password_placeholder') }}">
            @error('password')
                <p class="text-red-500 dark:text-red-400 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('user.field.password_confirm') }} *</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required
                   class="w-full border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                   placeholder="{{ __('user.field.password_confirm_placeholder') }}">
        </div>

        <div>
            <label for="role" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('user.field.role') }} *</label>
            <select id="role" name="role" required
                    class="w-full border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('role') border-red-300 @enderror">
                <option value="viewer" {{ old('role') === 'viewer' ? 'selected' : '' }}>{{ __('user.role_options.viewer') }} — {{ __('user.role_descriptions.viewer') }}</option>
                <option value="editor" {{ old('role') === 'editor' ? 'selected' : '' }}>{{ __('user.role_options.editor') }} — {{ __('user.role_descriptions.editor') }}</option>
                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>{{ __('user.role_options.admin') }} — {{ __('user.role_descriptions.admin') }}</option>
            </select>
            @error('role')
                <p class="text-red-500 dark:text-red-400 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-slate-700 flex items-center gap-3">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700 transition">
            {{ __('user.create') }}
        </button>
        <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium px-4 py-2.5">
            {{ __('user.cancel') }}
        </a>
    </div>
</form>
@endsection

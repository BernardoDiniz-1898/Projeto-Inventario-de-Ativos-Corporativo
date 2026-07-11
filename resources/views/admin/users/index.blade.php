@extends('layouts.app')

@section('title', __('user.title'))

@section('content')
<div class="mb-6">
    <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700 inline-flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        {{ __('user.back') }}
    </a>
</div>

<h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('user.title') }}</h1>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-4 sm:px-6 py-3 font-medium text-gray-600">{{ __('user.table.name') }}</th>
                    <th class="text-left px-4 sm:px-6 py-3 font-medium text-gray-600 hidden md:table-cell">{{ __('user.table.email') }}</th>
                    <th class="text-left px-4 sm:px-6 py-3 font-medium text-gray-600">{{ __('user.table.role') }}</th>
                    <th class="text-left px-4 sm:px-6 py-3 font-medium text-gray-600 hidden lg:table-cell">{{ __('user.table.created_at') }}</th>
                    <th class="text-right px-4 sm:px-6 py-3 font-medium text-gray-600">{{ __('user.table.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach ($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 sm:px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-medium text-xs shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <span class="font-medium text-gray-800">{{ $user->name }}</span>
                                    <div class="text-xs text-gray-400 md:hidden">{{ $user->email }}</div>
                                </div>
                                @if ($user->id === auth()->id())
                                    <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full hidden sm:inline-block">{{ __('user.you') }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 sm:px-6 py-4 hidden md:table-cell text-gray-600">{{ $user->email }}</td>
                        <td class="px-4 sm:px-6 py-4">
                            <form action="{{ route('admin.users.role', $user) }}" method="POST" class="inline-flex">
                                @csrf
                                @method('PUT')
                                <select name="role" onchange="this.form.submit()"
                                        class="text-xs font-medium px-2 py-1 rounded-full border-0 focus:ring-2 focus:ring-blue-500
                                        {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : ($user->role === 'editor' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700') }}">
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>{{ __('user.role_options.admin') }}</option>
                                    <option value="editor" {{ $user->role === 'editor' ? 'selected' : '' }}>{{ __('user.role_options.editor') }}</option>
                                    <option value="viewer" {{ $user->role === 'viewer' ? 'selected' : '' }}>{{ __('user.role_options.viewer') }}</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-4 sm:px-6 py-4 hidden lg:table-cell text-gray-500 text-xs">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 sm:px-6 py-4 text-right">
                            @if ($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline"
                                      onsubmit="return confirm('{{ __('user.delete_confirm') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium">
                                        {{ __('user.delete') }}
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="px-4 sm:px-6 py-3 border-t border-gray-100">
        {{ $users->links() }}
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Gerenciar Usuários')

@section('content')
<div class="mb-6">
    <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700 inline-flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Voltar
    </a>
</div>

<h1 class="text-2xl font-bold text-gray-800 mb-6">Gerenciar Usuários</h1>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-6 py-3 font-medium text-gray-600">Nome</th>
                <th class="text-left px-6 py-3 font-medium text-gray-600">Email</th>
                <th class="text-left px-6 py-3 font-medium text-gray-600">Perfil</th>
                <th class="text-left px-6 py-3 font-medium text-gray-600">Criado em</th>
                <th class="text-right px-6 py-3 font-medium text-gray-600">Ações</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @foreach ($users as $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-medium text-xs">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <span class="font-medium text-gray-800">{{ $user->name }}</span>
                            @if ($user->id === auth()->id())
                                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">Você</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.users.role', $user) }}" method="POST" class="inline-flex">
                            @csrf
                            @method('PUT')
                            <select name="role" onchange="this.form.submit()"
                                    class="text-xs font-medium px-2 py-1 rounded-full border-0 focus:ring-2 focus:ring-blue-500
                                    {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : ($user->role === 'editor' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700') }}">
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrador</option>
                                <option value="editor" {{ $user->role === 'editor' ? 'selected' : '' }}>Editor</option>
                                <option value="viewer" {{ $user->role === 'viewer' ? 'selected' : '' }}>Visualizador</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-6 py-4 text-gray-500 text-xs">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-right">
                        @if ($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Tem certeza que deseja excluir este usuário?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium">
                                    Excluir
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="px-6 py-3 border-t border-gray-100">
        {{ $users->links() }}
    </div>
</div>
@endsection

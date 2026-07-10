@extends('layouts.app')

@section('title', 'Novo Usuário')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:text-gray-700 inline-flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Voltar
    </a>
</div>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Novo Usuário</h1>
    <p class="text-gray-500 text-sm mt-1">Crie uma nova conta de acesso ao sistema</p>
</div>

<form action="{{ route('admin.users.store') }}" method="POST" class="bg-white rounded-lg shadow-sm border border-gray-100 p-8">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nome completo *</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                   class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('name') border-red-300 @enderror"
                   placeholder="Nome do usuário">
            @error('name')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                   class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-300 @enderror"
                   placeholder="email@exemplo.com">
            @error('email')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Senha *</label>
            <input type="password" id="password" name="password" required
                   class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('password') border-red-300 @enderror"
                   placeholder="Mínimo 8 caracteres">
            @error('password')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirmar senha *</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required
                   class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                   placeholder="Repita a senha">
        </div>

        <div>
            <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">Perfil de acesso *</label>
            <select id="role" name="role" required
                    class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('role') border-red-300 @enderror">
                <option value="viewer" {{ old('role') === 'viewer' ? 'selected' : '' }}>Visualizador — apenas consulta</option>
                <option value="editor" {{ old('role') === 'editor' ? 'selected' : '' }}>Editor — consulta e edição</option>
                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrador — acesso total</option>
            </select>
            @error('role')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="mt-8 pt-6 border-t border-gray-100 flex items-center gap-3">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700 transition">
            Criar Usuário
        </button>
        <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium px-4 py-2.5">
            Cancelar
        </a>
    </div>
</form>
@endsection

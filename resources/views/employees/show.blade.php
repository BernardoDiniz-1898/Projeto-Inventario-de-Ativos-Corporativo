@extends('layouts.app')

@section('title', $employee->nome)

@section('content')
<div class="mb-6">
    <a href="{{ route('employees.index') }}" class="text-sm text-gray-500 hover:text-gray-700 inline-flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Voltar para Funcionários
    </a>
</div>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div class="flex items-center gap-4">
        <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center font-bold text-xl">
            {{ strtoupper(substr($employee->nome, 0, 2)) }}
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $employee->nome }}</h1>
            <p class="text-gray-500 text-sm">{{ $employee->departamento ?? 'Sem departamento' }} · {{ $employee->cargo ?? 'Sem cargo' }}</p>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('employees.edit', $employee) }}"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-amber-500 to-amber-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:from-amber-600 hover:to-amber-700 transition shadow-sm shadow-amber-500/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Editar
        </a>
        <form action="{{ route('employees.destroy', $employee) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?')" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center gap-2 bg-red-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-red-600 transition shadow-sm shadow-red-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Excluir
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <h2 class="text-lg font-bold text-gray-900 mb-6">Informações</h2>
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5">
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Nome</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $employee->nome }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Matrícula</dt>
                <dd class="text-sm text-gray-800 font-mono mt-1">{{ $employee->matricula ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Email</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $employee->email ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Telefone</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $employee->telefone ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Departamento</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $employee->departamento ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Centro de Custo</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $employee->centro_custo ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Projeto</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $employee->projeto ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Setor</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $employee->setor ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Cargo</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $employee->cargo ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Status</dt>
                <dd class="mt-1">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold
                        {{ match($employee->status) {
                            'ativo' => 'bg-green-100 text-green-700',
                            'afastado' => 'bg-yellow-100 text-yellow-700',
                            'desligado' => 'bg-red-100 text-red-700',
                            'ferias' => 'bg-blue-100 text-blue-700',
                            default => 'bg-gray-100 text-gray-700',
                        } }}">
                        {{ $employee->status_label }}
                    </span>
                </dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Data de Admissão</dt>
                <dd class="text-sm text-gray-800 font-medium mt-1">{{ $employee->data_admissao?->format('d/m/Y') ?? '—' }}</dd>
            </div>
        </dl>

        @if ($employee->observacoes)
            <div class="mt-6 pt-6 border-t border-gray-100">
                <dt class="text-xs text-gray-500 uppercase tracking-wide font-semibold mb-2">Observações</dt>
                <dd class="text-sm text-gray-700 whitespace-pre-line bg-gray-50 rounded-xl p-4">{{ $employee->observacoes }}</dd>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <h2 class="text-lg font-bold text-gray-900 mb-6">Histórico</h2>
        <dl class="space-y-4">
            <div class="flex justify-between items-center">
                <dt class="text-xs text-gray-500 font-medium">Criado em</dt>
                <dd class="text-xs text-gray-600 font-medium">{{ $employee->created_at->format('d/m/Y H:i') }}</dd>
            </div>
            <div class="flex justify-between items-center">
                <dt class="text-xs text-gray-500 font-medium">Última atualização</dt>
                <dd class="text-xs text-gray-600 font-medium">{{ $employee->updated_at->format('d/m/Y H:i') }}</dd>
            </div>
        </dl>
    </div>
</div>

<div class="mt-6 bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-bold text-gray-900">Notebooks Vinculados</h2>
        <span class="text-sm text-gray-500 font-medium">{{ $notebooks->count() }} notebook(s)</span>
    </div>

    @if ($notebooks->isEmpty())
        <div class="p-8 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <p class="text-gray-400 text-sm">Nenhum notebook vinculado a este funcionário</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b border-gray-100">
                        <th class="pb-3 font-medium text-xs uppercase tracking-wider">Patrimônio</th>
                        <th class="pb-3 font-medium text-xs uppercase tracking-wider">Marca / Modelo</th>
                        <th class="pb-3 font-medium text-xs uppercase tracking-wider">Nº Série</th>
                        <th class="pb-3 font-medium text-xs uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach ($notebooks as $notebook)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3">
                                <a href="{{ route('notebooks.show', $notebook) }}" class="font-semibold text-gray-900 hover:text-blue-600 transition">
                                    {{ $notebook->patrimonio ?? '—' }}
                                </a>
                            </td>
                            <td class="py-3">
                                <div class="font-medium text-gray-900">{{ $notebook->marca }} {{ $notebook->modelo }}</div>
                            </td>
                            <td class="py-3">
                                <code class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-lg">{{ $notebook->numero_serie }}</code>
                            </td>
                            <td class="py-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold
                                    {{ match($notebook->status) {
                                        'disponivel' => 'bg-green-100 text-green-700',
                                        'em_uso' => 'bg-blue-100 text-blue-700',
                                        'manutencao' => 'bg-yellow-100 text-yellow-700',
                                        'ocioso' => 'bg-orange-100 text-orange-700',
                                        'devolvido' => 'bg-purple-100 text-purple-700',
                                        'obsoleto' => 'bg-red-100 text-red-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    } }}">
                                    {{ $notebook->status_label }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<div class="mt-6">
    <x-activity-log :logs="$logs" />
</div>
@endsection

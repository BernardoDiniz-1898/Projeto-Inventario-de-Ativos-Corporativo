@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
    $hora = (int) now()->format('H');
    $greeting = match(true) {
        $hora < 12 => 'Bom dia',
        $hora < 18 => 'Boa tarde',
        default => 'Boa noite',
    };
    $nome = auth()->user()->name;
@endphp

<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">{{ $greeting }}, {{ $nome }}</h1>
    <p class="text-gray-500 text-sm mt-1">Panorama geral do parque de ativos de TI</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
    <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-900">{{ $total }}</p>
        <p class="text-xs text-gray-500 mt-1">Notebooks cadastrados</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-green-600">{{ $disponiveis }}</p>
        <p class="text-xs text-gray-500 mt-1">Disponíveis</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-blue-600">{{ $emUso }}</p>
        <p class="text-xs text-gray-500 mt-1">Em Uso</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-yellow-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-yellow-600">{{ $manutencao }}</p>
        <p class="text-xs text-gray-500 mt-1">Manutenção</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-orange-600">{{ $ociosos }}</p>
        <p class="text-xs text-gray-500 mt-1">Ociosos</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-indigo-600">{{ $totalFuncionarios }}</p>
        <p class="text-xs text-gray-500 mt-1">Funcionários</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <h2 class="text-lg font-semibold text-gray-900">Por Marca</h2>
        </div>
        @if ($porMarca->isEmpty())
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p class="text-gray-400 text-sm">Sem dados para exibir</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($porMarca as $item)
                    @php $percent = $total > 0 ? ($item->total / $total * 100) : 0; @endphp
                    <div class="flex items-center gap-3">
                        <div class="w-24 text-sm text-gray-700 font-medium truncate">{{ $item->marca }}</div>
                        <div class="flex-1 bg-gray-100 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                        </div>
                        <div class="text-sm font-semibold text-gray-700 w-12 text-right">{{ $item->total }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <h2 class="text-lg font-semibold text-gray-900">Por Departamento</h2>
        </div>
        @if ($porDepartamento->isEmpty())
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p class="text-gray-400 text-sm">Sem dados para exibir</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($porDepartamento as $item)
                    @php $percent = $total > 0 ? ($item->total / $total * 100) : 0; @endphp
                    <div class="flex items-center gap-3">
                        <div class="w-24 text-sm text-gray-700 font-medium truncate">{{ $item->departamento }}</div>
                        <div class="flex-1 bg-gray-100 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                        </div>
                        <div class="text-sm font-semibold text-gray-700 w-12 text-right">{{ $item->total }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-gray-900">Últimos Cadastros</h2>
            </div>
            @if (auth()->user()->isAdmin() || auth()->user()->isEditor())
            <a href="{{ route('notebooks.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1">
                Ver todos
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
            @endif
        </div>
    </div>
    @if ($recentes->isEmpty())
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <p class="text-gray-400 text-sm">Nenhum notebook cadastrado</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 bg-gray-50">
                        <th class="px-6 py-3 font-medium text-xs uppercase tracking-wider">Patrimônio</th>
                        <th class="px-6 py-3 font-medium text-xs uppercase tracking-wider">Marca / Modelo</th>
                        <th class="px-6 py-3 font-medium text-xs uppercase tracking-wider">Responsável</th>
                        <th class="px-6 py-3 font-medium text-xs uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($recentes as $notebook)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                @if (auth()->user()->isAdmin() || auth()->user()->isEditor())
                                <a href="{{ route('notebooks.show', $notebook) }}" class="text-blue-600 hover:text-blue-700 font-medium">
                                    {{ $notebook->patrimonio ?? '—' }}
                                </a>
                                @else
                                <span class="text-gray-700">{{ $notebook->patrimonio ?? '—' }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-800">{{ $notebook->marca }}</div>
                                        <div class="text-xs text-gray-500">{{ $notebook->modelo }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($notebook->funcionario)
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-medium text-xs">
                                        {{ strtoupper(substr($notebook->funcionario->nome, 0, 2)) }}
                                    </div>
                                    <span class="text-gray-700">{{ $notebook->funcionario->nome }}</span>
                                </div>
                                @else
                                <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
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
@endsection

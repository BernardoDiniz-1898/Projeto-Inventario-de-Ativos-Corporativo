@extends('layouts.app')

@section('title', __('nav.dashboard'))

@section('content')
@php
    $hora = (int) now()->format('H');
    $greeting = match(true) {
        $hora < 12 => __('dashboard.greeting_morning'),
        $hora < 18 => __('dashboard.greeting_afternoon'),
        default => __('dashboard.greeting_evening'),
    };
    $nome = auth()->user()->name;
@endphp

<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $greeting }}, {{ $nome }}</h1>
    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ __('dashboard.overview') }}</p>
</div>

{{-- ═══════════════════════════════════════════════════════
     STAT CARDS
     ═══════════════════════════════════════════════════════ --}}
<div class="flex gap-3 sm:gap-4 mb-8 overflow-x-auto pb-1">
    <x-ui.stat-card :value="$total" :label="__('dashboard.total_notebooks')" color="gray">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
    </x-ui.stat-card>
    <x-ui.stat-card :value="$disponiveis" :label="__('dashboard.available')" color="green">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    </x-ui.stat-card>
    <x-ui.stat-card :value="$emUso" :label="__('dashboard.in_use')" color="blue">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
    </x-ui.stat-card>
    <x-ui.stat-card :value="$manutencao" :label="__('dashboard.maintenance')" color="yellow">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
    </x-ui.stat-card>
    <x-ui.stat-card :value="$ociosos" :label="__('dashboard.idle')" color="orange">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    </x-ui.stat-card>
    <x-ui.stat-card :value="$totalFuncionarios" :label="__('dashboard.employees')" color="indigo">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
    </x-ui.stat-card>
    <x-ui.stat-card :value="'R$ ' . number_format($valorTotal, 0, ',', '.')" :label="__('dashboard.total_value')" color="emerald">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    </x-ui.stat-card>
    <x-ui.stat-card :value="$semFuncionario" :label="__('dashboard.unassigned')" color="red">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6"/></svg>
    </x-ui.stat-card>
</div>

{{-- ═══════════════════════════════════════════════════════
     AÇÕES RÁPIDAS + ALERTAS
     ═══════════════════════════════════════════════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    {{-- Quick Actions --}}
    @if (auth()->user()->isAdmin() || auth()->user()->isEditor())
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border border-gray-100 dark:border-slate-700">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-blue-50 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('dashboard.quick_actions') }}</h2>
        </div>
        <div class="grid grid-cols-3 gap-3">
            <a href="{{ route('notebooks.create') }}" class="flex flex-col items-center gap-2 p-3 rounded-xl bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/40 transition text-center">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-800/40 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </div>
                <span class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ __('dashboard.add_notebook') }}</span>
            </a>
            <a href="{{ route('employees.create') }}" class="flex flex-col items-center gap-2 p-3 rounded-xl bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/40 transition text-center">
                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-800/40 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <span class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ __('dashboard.add_employee') }}</span>
            </a>
            <a href="{{ route('inventory.index') }}" class="flex flex-col items-center gap-2 p-3 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 hover:bg-emerald-100 dark:hover:bg-emerald-900/40 transition text-center">
                <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-800/40 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <span class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ __('dashboard.view_inventory') }}</span>
            </a>
        </div>
    </div>
    @endif

    {{-- Warranty Alerts --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border border-gray-100 dark:border-slate-700">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-amber-50 dark:bg-amber-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('dashboard.warranty_expiring') }}</h2>
                <p class="text-xs text-gray-400 dark:text-gray-500">{{ __('dashboard.warranty_expiring_desc') }}</p>
            </div>
        </div>
        @if ($garantiasVencendo->isEmpty())
            <div class="text-center py-6">
                <svg class="w-10 h-10 text-gray-300 dark:text-slate-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-gray-400 dark:text-gray-500 text-sm">{{ __('dashboard.no_alerts') }}</p>
            </div>
        @else
            <div class="space-y-2.5 max-h-40 overflow-y-auto">
                @foreach ($garantiasVencendo as $nb)
                    <div class="flex items-center justify-between p-2.5 rounded-lg bg-amber-50/80 dark:bg-amber-900/15 border border-amber-100 dark:border-amber-800/30">
                        <div class="min-w-0">
                            <div class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate">{{ $nb->marca }} {{ $nb->modelo }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $nb->patrimonio ?? '—' }}</div>
                        </div>
                        <div class="text-xs font-medium text-amber-700 dark:text-amber-400 whitespace-nowrap ml-3">
                            {{ $nb->data_garantia->format('d/m/Y') }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Maintenance Alerts --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border border-gray-100 dark:border-slate-700">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-orange-50 dark:bg-orange-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.42 15.17l-5.384 3.18A1 1 0 014.82 17.4l3.18-5.384m0 0L17.6 4.6a2.121 2.121 0 113 3L11 16.42m-5.38 1.75l1.83-3.15"/></svg>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('dashboard.maintenance_upcoming') }}</h2>
                <p class="text-xs text-gray-400 dark:text-gray-500">{{ __('dashboard.maintenance_upcoming_desc') }}</p>
            </div>
        </div>
        @if ($manutencaoPendente->isEmpty())
            <div class="text-center py-6">
                <svg class="w-10 h-10 text-gray-300 dark:text-slate-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-gray-400 dark:text-gray-500 text-sm">{{ __('dashboard.no_alerts') }}</p>
            </div>
        @else
            <div class="space-y-2.5 max-h-40 overflow-y-auto">
                @foreach ($manutencaoPendente as $nb)
                    @php $dias = now()->diffInDays($nb->proxima_manutencao); @endphp
                    <div class="flex items-center justify-between p-2.5 rounded-lg {{ $dias <= 7 ? 'bg-red-50/80 dark:bg-red-900/15 border border-red-100 dark:border-red-800/30' : 'bg-orange-50/80 dark:bg-orange-900/15 border border-orange-100 dark:border-orange-800/30' }}">
                        <div class="min-w-0">
                            <div class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate">{{ $nb->marca }} {{ $nb->modelo }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $nb->patrimonio ?? '—' }}</div>
                        </div>
                        <div class="text-xs font-medium whitespace-nowrap ml-3 {{ $dias <= 7 ? 'text-red-700 dark:text-red-400' : 'text-orange-700 dark:text-orange-400' }}">
                            {{ $dias }}d
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     GRÁFICOS
     ═══════════════════════════════════════════════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    {{-- Donut de Status --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border border-gray-100 dark:border-slate-700">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-indigo-50 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
            </div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('dashboard.status_distribution') }}</h2>
        </div>
        @if ($distribuicaoStatus->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-400 dark:text-gray-500 text-sm">{{ __('dashboard.no_data') }}</p>
            </div>
        @else
            @php
                $colors = [
                    'disponivel' => ['#22c55e', '#16a34a'],
                    'em_uso' => ['#3b82f6', '#2563eb'],
                    'manutencao' => ['#eab308', '#ca8a04'],
                    'ocioso' => ['#f97316', '#ea580c'],
                    'devolvido' => ['#a855f7', '#9333ea'],
                    'obsoleto' => ['#ef4444', '#dc2626'],
                    'baixa' => ['#64748b', '#475569'],
                    'extraviado' => ['#ec4899', '#db2777'],
                    'transferido' => ['#06b6d4', '#0891b2'],
                ];
                $statusTotal = $distribuicaoStatus->sum('total');
                $cumulative = 0;
            @endphp
            <div class="flex items-center gap-6">
                <div class="relative w-36 h-36 flex-shrink-0">
                    <svg viewBox="0 0 36 36" class="w-full h-full -rotate-90">
                        @foreach ($distribuicaoStatus as $item)
                            @php
                                $percent = $statusTotal > 0 ? ($item->total / $statusTotal * 100) : 0;
                                $stroke = $colors[$item->status][0] ?? '#64748b';
                                $dasharray = round($percent, 2) . ' ' . round(100 - $percent, 2);
                                $dashoffset = 100 - $cumulative;
                                $cumulative += $percent;
                            @endphp
                            <circle cx="18" cy="18" r="15.915" fill="none" stroke="{{ $stroke }}" stroke-width="3.5" stroke-dasharray="{{ $dasharray }}" stroke-dashoffset="{{ $dashoffset }}" stroke-linecap="round" class="transition-all duration-700" />
                        @endforeach
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $statusTotal }}</span>
                        <span class="text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ __('dashboard.total_notebooks') }}</span>
                    </div>
                </div>
                <div class="flex-1 space-y-2">
                    @foreach ($distribuicaoStatus as $item)
                        @php $badge = new \App\Models\Notebook(); $badge->status = $item->status; @endphp
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-2.5 h-2.5 rounded-full" style="background: {{ $colors[$item->status][0] ?? '#64748b' }}"></div>
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $badge->status_label }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $item->total }}</span>
                                @php $pctStr = number_format($statusTotal > 0 ? $item->total / $statusTotal * 100, 0); @endphp
                                <span class="text-xs text-gray-400 dark:text-gray-500 w-12 text-right">{{ $pctStr }}%</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    {{-- Por Marca --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border border-gray-100 dark:border-slate-700">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-blue-50 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('dashboard.by_brand') }}</h2>
        </div>
        @if ($porMarca->isEmpty())
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-300 dark:text-slate-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                <p class="text-gray-400 dark:text-gray-500 text-sm">{{ __('dashboard.no_data') }}</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($porMarca as $item)
                    @php $percent = $total > 0 ? ($item->total / $total * 100) : 0; @endphp
                    <div class="flex items-center gap-3">
                        <div class="w-24 text-sm text-gray-700 dark:text-gray-300 font-medium truncate">{{ $item->marca }}</div>
                        <div class="flex-1 bg-gray-100 dark:bg-slate-700 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                        </div>
                        <div class="text-sm font-semibold text-gray-700 dark:text-gray-300 w-12 text-right">{{ $item->total }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Por Departamento --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border border-gray-100 dark:border-slate-700">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-purple-50 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('dashboard.by_department') }}</h2>
        </div>
        @if ($porDepartamento->isEmpty())
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-300 dark:text-slate-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                <p class="text-gray-400 dark:text-gray-500 text-sm">{{ __('dashboard.no_data') }}</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($porDepartamento as $item)
                    @php $percent = $total > 0 ? ($item->total / $total * 100) : 0; @endphp
                    <div class="flex items-center gap-3">
                        <div class="w-24 text-sm text-gray-700 dark:text-gray-300 font-medium truncate">{{ $item->departamento }}</div>
                        <div class="flex-1 bg-gray-100 dark:bg-slate-700 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                        </div>
                        <div class="text-sm font-semibold text-gray-700 dark:text-gray-300 w-12 text-right">{{ $item->total }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Por Grupo --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border border-gray-100 dark:border-slate-700">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('dashboard.by_grupo') }}</h2>
        </div>
        @if ($porGrupo->isEmpty())
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-300 dark:text-slate-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                <p class="text-gray-400 dark:text-gray-500 text-sm">{{ __('dashboard.no_data') }}</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($porGrupo as $item)
                    @php $percent = $total > 0 ? ($item->notebooks_count / $total * 100) : 0; @endphp
                    <div class="flex items-center gap-3">
                        <div class="w-24 text-sm font-medium truncate dark:brightness-150" style="color: {{ $item->cor }}">{{ $item->nome }}</div>
                        <div class="flex-1 bg-gray-100 dark:bg-slate-700 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                        </div>
                        <div class="text-sm font-semibold text-gray-700 dark:text-gray-300 w-12 text-right">{{ $item->notebooks_count }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     COMPLIANCE + ALUGUÉIS + ATIVIDADE
     ═══════════════════════════════════════════════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    {{-- Security Compliance --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border border-gray-100 dark:border-slate-700">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-red-50 dark:bg-red-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('dashboard.security_compliance') }}</h2>
        </div>
        @if ($compliance['total'] === 0)
            <div class="text-center py-6">
                <p class="text-gray-400 dark:text-gray-500 text-sm">{{ __('dashboard.no_data') }}</p>
            </div>
        @else
            <div class="space-y-4">
                @php
                    $items = [
                        ['key' => 'criptografia', 'label' => __('dashboard.encryption'), 'color' => 'blue'],
                        ['key' => 'antivirus', 'label' => __('dashboard.antivirus'), 'color' => 'emerald'],
                        ['key' => 'backup', 'label' => __('dashboard.backup'), 'color' => 'purple'],
                        ['key' => 'patches_atualizados', 'label' => __('dashboard.patches'), 'color' => 'amber'],
                    ];
                @endphp
                @foreach ($items as $item)
                    @php
                        $pct = $compliance['total'] > 0 ? ($compliance[$item['key']] / $compliance['total'] * 100) : 0;
                    @endphp
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $item['label'] }}</span>
                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">{{ $compliance[$item['key']] }}/{{ $compliance['total'] }}</span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-slate-700 rounded-full h-2 overflow-hidden">
                            <div class="bg-{{ $item['color'] }}-500 h-2 rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Aluguéis Ativos --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border border-gray-100 dark:border-slate-700">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-teal-50 dark:bg-teal-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('dashboard.active_rentals') }}</h2>
        </div>
        @if ($alugueisAtivos['count'] === 0)
            <div class="text-center py-6">
                <p class="text-gray-400 dark:text-gray-500 text-sm">{{ __('dashboard.no_data') }}</p>
            </div>
        @else
            <div class="text-center py-4">
                <div class="text-4xl font-bold text-gray-900 dark:text-white mb-1">
                    @php $rentalStr = number_format($alugueisAtivos['total_mensal'], 0, ',', '.'); @endphp
                    R$ {{ $rentalStr }}
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ __('dashboard.monthly_revenue') }}</p>
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-teal-50 dark:bg-teal-900/20 rounded-xl">
                    <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span class="text-sm font-medium text-teal-700 dark:text-teal-300">{{ $alugueisAtivos['count'] }} {{ __('dashboard.active_rentals') }}</span>
                </div>
            </div>
        @endif
    </div>

    {{-- Atividade Recente --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border border-gray-100 dark:border-slate-700">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-cyan-50 dark:bg-cyan-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('dashboard.recent_activity') }}</h2>
        </div>
        @if ($atividadeRecente->isEmpty())
            <div class="text-center py-6">
                <p class="text-gray-400 dark:text-gray-500 text-sm">{{ __('dashboard.no_activity') }}</p>
            </div>
        @else
            <div class="space-y-3 max-h-64 overflow-y-auto">
                @foreach ($atividadeRecente as $log)
                    @php
                        $actionColor = match($log->action) {
                            'created' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                            'updated' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                            'deleted' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                            default => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
                        };
                        $actionIcon = match($log->action) {
                            'created' => 'M12 4v16m8-8H4',
                            'updated' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
                            'deleted' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16',
                            default => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                        };
                    @endphp
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0 {{ $actionColor }}">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $actionIcon }}"/></svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="text-sm text-gray-700 dark:text-gray-300">
                                @if ($log->user)
                                    <span class="font-medium">{{ $log->user->name }}</span>
                                @endif
                                <span class="text-gray-500 dark:text-gray-400">{{ __('dashboard.' . $log->action . '_notebook') }}</span>
                            </div>
                            <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $log->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     ÚLTIMOS NOTEBOOKS
     ═══════════════════════════════════════════════════════ --}}
<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-50 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('dashboard.recent') }}</h2>
            </div>
            @if (auth()->user()->isAdmin() || auth()->user()->isEditor())
            <a href="{{ route('notebooks.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1">
                {{ __('dashboard.view_all') }}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
            @endif
        </div>
    </div>
    @if ($recentes->isEmpty())
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-300 dark:text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            <p class="text-gray-400 dark:text-gray-500 text-sm">{{ __('dashboard.no_notebooks') }}</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 dark:text-gray-400 bg-gray-50/80 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-600">
                        <x-ui.table-heading :text="__('dashboard.notebook')" />
                        <x-ui.table-heading :text="__('dashboard.asset_number')" class="hidden md:table-cell whitespace-nowrap" />
                        <x-ui.table-heading :text="__('dashboard.responsible')" class="hidden lg:table-cell" />
                        <x-ui.table-heading :text="__('dashboard.status')" class="whitespace-nowrap" />
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/60">
                    @foreach ($recentes as $notebook)
                        <tr class="{{ $loop->even ? 'bg-gray-50/40 dark:bg-slate-700/30' : 'bg-white dark:bg-slate-800' }} hover:bg-blue-50/30 dark:hover:bg-slate-700/50 transition-colors duration-150">
                            <td class="px-5 sm:px-7 py-5">
                                <div>
                                    @if (auth()->user()->isAdmin() || auth()->user()->isEditor())
                                    <a href="{{ route('notebooks.show', $notebook) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">
                                        {{ $notebook->marca }} {{ $notebook->modelo }}
                                    </a>
                                    @else
                                    <span class="font-medium text-gray-800 dark:text-gray-200">{{ $notebook->marca }} {{ $notebook->modelo }}</span>
                                    @endif
                                    <div class="text-xs text-gray-400 dark:text-gray-500 md:hidden">{{ $notebook->patrimonio ?? '—' }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 lg:hidden mt-0.5">{{ $notebook->funcionario->nome ?? __('dashboard.no_responsible') }}</div>
                                </div>
                            </td>
                            <td class="px-5 sm:px-7 py-5 hidden md:table-cell text-gray-600 dark:text-gray-400 font-mono text-xs">
                                {{ $notebook->patrimonio ?? '—' }}
                            </td>
                            <td class="px-5 sm:px-7 py-5 hidden lg:table-cell">
                                @if ($notebook->funcionario)
                                <div class="flex items-center gap-3">
                                    <x-ui.avatar :name="$notebook->funcionario->nome" size="sm" />
                                    <span class="text-gray-700 dark:text-gray-300 text-[13px]">{{ $notebook->funcionario->nome }}</span>
                                </div>
                                @else
                                <span class="text-gray-300 dark:text-slate-600">—</span>
                                @endif
                            </td>
                            <td class="px-5 sm:px-7 py-5">
                                <x-ui.status-badge :status="$notebook->status" :label="$notebook->status_label" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

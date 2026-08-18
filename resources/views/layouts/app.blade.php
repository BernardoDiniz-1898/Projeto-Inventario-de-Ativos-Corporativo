<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', session('locale', config('app.locale'))) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keep Inventory - @yield('title', __('nav.dashboard'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        (function() {
            const s = JSON.parse(localStorage.getItem('app_settings') || '{}');
            const theme = s.theme || 'dark';
            const font = s.font_size || 'normal';
            const accent = s.accent_color || 'blue';

            document.documentElement.setAttribute('data-theme', theme);
            document.documentElement.setAttribute('data-font', font);
            document.documentElement.setAttribute('data-accent', accent);

            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
</head>
<body class="bg-slate-200 dark:bg-slate-900 min-h-screen antialiased" x-data="appLayout">

    {{-- ═══════════════════════════════════════════════════
         SIDEBAR DESKTOP (md+)
         ═══════════════════════════════════════════════════ --}}
    <aside class="sidebar-desktop fixed top-0 left-0 bottom-0 z-40 flex flex-col border-r transition-all duration-300"
           :class="sidebarCollapsed ? 'w-16' : 'w-64'"
           style="background: linear-gradient(180deg, #0b1120 0%, #111827 100%); border-color: rgba(51,65,85,0.4);">
        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto py-3 px-2.5">
            {{-- Main section --}}
            <div x-show="!sidebarCollapsed" class="px-2.5 mb-1.5">
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.15em]">Principal</span>
            </div>

            <div class="flex flex-col items-stretch gap-0.5">

                @php
                    $navItems = [
                        ['route' => 'dashboard', 'name' => 'dashboard', 'label' => __('nav.dashboard'), 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>', 'admin' => false],
                        ['route' => 'notebooks', 'name' => 'notebooks.index', 'label' => __('nav.notebooks'), 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>', 'admin' => true],
                        ['route' => 'employees', 'name' => 'employees.index', 'label' => __('nav.employees'), 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>', 'admin' => true],
                        ['route' => 'inventory', 'name' => 'inventory.index', 'label' => __('nav.inventory'), 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>', 'admin' => false],
                        ['route' => 'grupos', 'name' => 'grupos.index', 'label' => __('nav.grupos'), 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>', 'admin' => false],
                        ['route' => 'localizacoes', 'name' => 'localizacoes.index', 'label' => __('nav.localizacoes'), 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>', 'admin' => false],
                    ];
                @endphp

                @foreach ($navItems as $item)
                    @if ($item['admin'] && !auth()->user()->isAdmin() && !auth()->user()->isEditor())
                        @continue
                    @endif
                    @php $active = request()->routeIs($item['route'] . '.*') || request()->routeIs($item['route']); @endphp
                    <a href="{{ route($item['name']) }}"
                       class="sidebar-link group relative flex items-center rounded-xl text-sm font-medium transition-all duration-200 {{ $active ? 'sidebar-link-active' : 'text-slate-300 hover:text-white hover:bg-white/[0.06]' }}"
                       :class="sidebarCollapsed ? 'justify-center p-2.5' : 'gap-3 px-3 py-2.5'">
                        @if ($active)
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-[3px] h-5 bg-blue-500 rounded-r-full shadow-lg shadow-blue-500/50"></div>
                        @endif
                        <div class="sidebar-icon w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 transition-all duration-200
                            {{ $active ? 'bg-blue-500/20 text-blue-400' : 'bg-transparent text-slate-400 group-hover:bg-white/[0.08] group-hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $item['icon'] !!}</svg>
                        </div>
                        <span x-show="!sidebarCollapsed">{{ $item['label'] }}</span>
                    </a>
                @endforeach

                {{-- Admin section --}}
                @if (auth()->user()->isAdmin())
                    <div x-show="!sidebarCollapsed" class="mt-4 mb-1.5 px-2.5">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.15em]">Admin</span>
                    </div>
                    @php $active = request()->routeIs('admin.*'); @endphp
                    <a href="{{ route('admin.users.index') }}"
                       class="sidebar-link group relative flex items-center rounded-xl text-sm font-medium transition-all duration-200 {{ $active ? 'sidebar-link-active' : 'text-slate-300 hover:text-white hover:bg-white/[0.06]' }}"
                       :class="sidebarCollapsed ? 'justify-center p-2.5' : 'gap-3 px-3 py-2.5'">
                        @if ($active)
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-[3px] h-5 bg-blue-500 rounded-r-full shadow-lg shadow-blue-500/50"></div>
                        @endif
                        <div class="sidebar-icon w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 transition-all duration-200
                            {{ $active ? 'bg-blue-500/20 text-blue-400' : 'bg-transparent text-slate-400 group-hover:bg-white/[0.08] group-hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                            </svg>
                        </div>
                        <span x-show="!sidebarCollapsed">{{ __('nav.users') }}</span>
                    </a>
                @endif
            </div>
        </nav>

        {{-- Bottom section --}}
        <div class="flex-shrink-0 py-2 px-2.5" style="border-top: 1px solid rgba(51,65,85,0.4);">
            @php $active = request()->routeIs('settings.*'); @endphp
            <a href="{{ route('settings.index') }}"
                       class="sidebar-link group relative flex items-center rounded-xl text-sm font-medium transition-all duration-200 {{ $active ? 'sidebar-link-active' : 'text-slate-300 hover:text-white hover:bg-white/[0.06]' }}"
                       :class="sidebarCollapsed ? 'justify-center p-2.5' : 'gap-3 px-3 py-2.5'">
                @if ($active)
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-[3px] h-5 bg-blue-500 rounded-r-full shadow-lg shadow-blue-500/50"></div>
                @endif
                <div class="sidebar-icon w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 transition-all duration-200
                    {{ $active ? 'bg-blue-500/20 text-blue-400' : 'bg-transparent text-slate-400 group-hover:bg-white/[0.08] group-hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed">{{ __('nav.settings') }}</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                   class="w-full group relative flex items-center rounded-xl text-sm font-medium transition-all duration-200 text-slate-400 hover:text-red-400 hover:bg-red-500/[0.08]"
                   :class="sidebarCollapsed ? 'justify-center p-2.5' : 'gap-3 px-3 py-2.5'">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 bg-transparent text-slate-400 group-hover:bg-red-500/15 group-hover:text-red-400 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </div>
                    <span x-show="!sidebarCollapsed">{{ __('nav.logout') }}</span>
                </button>
            </form>

            <button @click="toggleSidebar"
                    class="w-full group flex items-center rounded-xl text-sm font-medium transition-all duration-200 text-slate-400 hover:text-slate-200 hover:bg-white/[0.06] mt-0.5"
                    :class="sidebarCollapsed ? 'justify-center p-2.5' : 'gap-3 px-3 py-2.5'"
                    title="Toggle sidebar">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 bg-transparent text-slate-400 group-hover:bg-white/[0.08] group-hover:text-slate-200 transition-all duration-200">
                    <svg class="w-4 h-4 transition-transform duration-300" :class="sidebarCollapsed ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" class="text-slate-400">{{ __('nav.collapse') ?? 'Recolher' }}</span>
            </button>
        </div>
    </aside>

    {{-- ═══════════════════════════════════════════════════
         TOP BAR (all screens)
         ═══════════════════════════════════════════════════ --}}
    <div class="min-h-screen transition-all duration-300" :class="sidebarCollapsed ? 'md:ml-16' : 'md:ml-64'">
        <nav class="corporate-nav bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm border-b border-slate-200/80 dark:border-slate-700/80 sticky top-0 z-30">
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center gap-4">
                        {{-- Hamburger (mobile only) --}}
                        <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 -ml-2 rounded-lg text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                            <svg x-show="!mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            <svg x-show="mobileOpen" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>

                        {{-- Breadcrumb / Page title --}}
                        <div class="hidden md:flex items-center gap-2 ml-2">
                            <div class="w-8 h-8 bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">@yield('title', __('nav.dashboard'))</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <x-lang-switcher />

                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2.5 p-1.5 rounded-xl hover:bg-slate-100 transition-all duration-200">
                                <div class="w-8 h-8 bg-gradient-to-br from-slate-600 to-slate-800 dark:from-slate-500 dark:to-slate-700 text-white rounded-lg flex items-center justify-center font-bold text-xs shadow-sm">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </div>
                                <div class="hidden sm:flex flex-col items-start">
                                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-200 leading-tight">{{ auth()->user()->name }}</span>
                                    <span class="text-[10px] text-slate-400 dark:text-slate-500 font-medium leading-tight">{{ auth()->user()->role_label }}</span>
                                </div>
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                 class="absolute right-0 mt-2 w-64 bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 py-2 z-50">
                                <div class="px-4 py-3 border-b border-slate-100 dark:border-slate-700">
                                    <div class="font-semibold text-slate-800 dark:text-white text-sm">{{ auth()->user()->name }}</div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ auth()->user()->email }}</div>
                                    <div class="mt-2">
                                        <span class="text-xs px-2 py-0.5 rounded-md font-medium
                                            {{ auth()->user()->role === 'admin' ? 'bg-slate-800 text-white' : (auth()->user()->role === 'editor' ? 'bg-slate-600 text-white' : 'bg-slate-200 text-slate-700') }}">
                                            {{ auth()->user()->role_label }}
                                        </span>
                                    </div>
                                </div>
                                <div class="py-1.5">
                                    <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition mx-1.5 rounded-lg">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ __('settings.title') }}
                                    </a>
                                </div>
                                <div class="border-t border-slate-100 dark:border-slate-700 pt-1.5">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 transition mx-1.5 rounded-lg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            {{ __('nav.logout') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        {{-- ═══════════════════════════════════════════════════
             MOBILE SLIDE-OUT SIDEBAR
             ═══════════════════════════════════════════════════ --}}
        <template x-if="mobileOpen">
            <div class="md:hidden fixed inset-0 z-50" x-data="{ leaving: false }">
                {{-- Backdrop --}}
                <div x-show="!leaving"
                     @click="leaving = true; setTimeout(() => { mobileOpen = false; leaving = false; }, 200)"
                     class="absolute inset-0 bg-black/40 backdrop-enter"
                     x-transition:leave="backdrop-leave"></div>

                {{-- Panel --}}
                <div class="absolute top-0 left-0 bottom-0 w-72 max-w-[85vw] bg-slate-900 shadow-2xl mobile-nav-enter flex flex-col"
                     :class="leaving ? 'mobile-nav-leave' : ''">
                    {{-- Header --}}
                    <div class="h-16 px-5 border-b border-slate-800 flex items-center justify-end flex-shrink-0">
                        <button @click="leaving = true; setTimeout(() => { mobileOpen = false; leaving = false; }, 200)" class="p-2 -mr-2 rounded-lg text-slate-400 hover:text-slate-200 hover:bg-slate-800 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    {{-- User info --}}
                    <div class="px-5 py-4 border-b border-slate-800">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-slate-600 to-slate-800 text-white rounded-xl flex items-center justify-center font-bold text-sm shadow-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-white text-sm truncate">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- Nav links --}}
                    <div class="flex-1 overflow-y-auto py-4 px-3">
                        {{-- Main --}}
                        <div class="mb-2">
                            <div class="px-3 mb-2">
                                <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-widest">{{ __('nav.main_menu') }}</span>
                            </div>

                            <a href="{{ route('dashboard') }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                               {{ request()->routeIs('dashboard') ? 'bg-blue-500/15 text-blue-400' : 'text-slate-400 hover:bg-slate-800' }}">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0
                                    {{ request()->routeIs('dashboard') ? 'bg-blue-500/15 text-blue-400' : 'bg-slate-800 text-slate-500' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                </div>
                                <span>{{ __('nav.dashboard') }}</span>
                            </a>

                            @if (auth()->user()->isAdmin() || auth()->user()->isEditor())
                            <a href="{{ route('notebooks.index') }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                               {{ request()->routeIs('notebooks.*') ? 'bg-blue-500/15 text-blue-400' : 'text-slate-400 hover:bg-slate-800' }}">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0
                                    {{ request()->routeIs('notebooks.*') ? 'bg-blue-500/15 text-blue-400' : 'bg-slate-800 text-slate-500' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <span>{{ __('nav.notebooks') }}</span>
                            </a>

                            <a href="{{ route('employees.index') }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                               {{ request()->routeIs('employees.*') ? 'bg-blue-500/15 text-blue-400' : 'text-slate-400 hover:bg-slate-800' }}">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0
                                    {{ request()->routeIs('employees.*') ? 'bg-blue-500/15 text-blue-400' : 'bg-slate-800 text-slate-500' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <span>{{ __('nav.employees') }}</span>
                            </a>
                            @endif

                            <a href="{{ route('inventory.index') }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                               {{ request()->routeIs('inventory.*') ? 'bg-blue-500/15 text-blue-400' : 'text-slate-400 hover:bg-slate-800' }}">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0
                                    {{ request()->routeIs('inventory.*') ? 'bg-blue-500/15 text-blue-400' : 'bg-slate-800 text-slate-500' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                    </svg>
                                </div>
                                <span>{{ __('nav.inventory') }}</span>
                            </a>

                            <a href="{{ route('grupos.index') }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                               {{ request()->routeIs('grupos.*') ? 'bg-blue-500/15 text-blue-400' : 'text-slate-400 hover:bg-slate-800' }}">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0
                                    {{ request()->routeIs('grupos.*') ? 'bg-blue-500/15 text-blue-400' : 'bg-slate-800 text-slate-500' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                                <span>{{ __('nav.grupos') }}</span>
                            </a>

                            <a href="{{ route('localizacoes.index') }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                               {{ request()->routeIs('localizacoes.*') ? 'bg-blue-500/15 text-blue-400' : 'text-slate-400 hover:bg-slate-800' }}">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0
                                    {{ request()->routeIs('localizacoes.*') ? 'bg-blue-500/15 text-blue-400' : 'bg-slate-800 text-slate-500' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <span>{{ __('nav.localizacoes') }}</span>
                            </a>
                        </div>

                        {{-- Admin --}}
                        @if (auth()->user()->isAdmin())
                        <div class="mt-6">
                            <div class="px-3 mb-2">
                                <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-widest">{{ __('nav.administration') }}</span>
                            </div>

                            <a href="{{ route('admin.users.index') }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                               {{ request()->routeIs('admin.*') ? 'bg-blue-500/15 text-blue-400' : 'text-slate-400 hover:bg-slate-800' }}">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0
                                    {{ request()->routeIs('admin.*') ? 'bg-blue-500/15 text-blue-400' : 'bg-slate-800 text-slate-500' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                                    </svg>
                                </div>
                                <span>{{ __('nav.users') }}</span>
                            </a>
                        </div>
                        @endif
                    </div>

                    {{-- Footer --}}
                    <div class="flex-shrink-0 border-t border-slate-800 p-3">
                        <a href="{{ route('settings.index') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                           {{ request()->routeIs('settings.*') ? 'bg-blue-500/15 text-blue-400' : 'text-slate-400 hover:bg-slate-800' }}">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0
                                {{ request()->routeIs('settings.*') ? 'bg-blue-500/15 text-blue-400' : 'bg-slate-800 text-slate-500' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <span>{{ __('settings.title') }}</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-red-400 hover:bg-slate-800 transition-all duration-200">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 bg-red-500/15 text-red-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                </div>
                                <span>{{ __('nav.logout') }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </template>

        {{-- Main content --}}
        <main class="w-full px-4 sm:px-6 lg:px-8 py-6">
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                     x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="mb-5 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded-xl flex items-center gap-3 text-sm flash-message">
                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium flex-1">{{ session('success') }}</span>
                    <button @click="show = false" class="text-green-500 hover:text-green-700">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                     x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="mb-5 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-xl flex items-center gap-3 text-sm flash-message">
                    <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium flex-1">{{ session('error') }}</span>
                    <button @click="show = false" class="text-red-500 hover:text-red-700">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                    </button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    {{-- Toast component --}}
    <div x-data="toast" x-on:toast.window="add($event.detail)" class="fixed bottom-6 right-6 z-50 space-y-3">
        <template x-for="t in toasts" :key="t.id">
            <div x-show="t.show"
                 x-transition:enter="toast-enter"
                 x-transition:leave="toast-exit"
                 class="flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg text-sm font-medium pointer-events-auto min-w-[280px]"
                 :class="{
                     'bg-green-600 text-white': t.type === 'success',
                     'bg-red-600 text-white': t.type === 'error',
                     'bg-blue-600 text-white': t.type === 'info',
                     'bg-amber-600 text-white': t.type === 'warning'
                 }">
                <svg x-show="t.type === 'success'" class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <svg x-show="t.type === 'error'" class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                <span class="flex-1" x-text="t.message"></span>
                <button @click="remove(t.id)" class="text-white/70 hover:text-white">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                </button>
            </div>
        </template>
    </div>

</body>
</html>

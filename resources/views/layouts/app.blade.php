<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', session('locale', config('app.locale'))) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keep Inventory - @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        (function() {
            const s = JSON.parse(localStorage.getItem('app_settings') || '{}');
            const theme = s.theme || 'light';
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
<body class="bg-slate-100 min-h-screen antialiased">

    <nav class="corporate-nav bg-white border-b border-slate-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-14">
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center shadow-sm shadow-blue-500/20">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <span class="font-bold text-slate-800 text-sm tracking-wide hidden sm:block uppercase">Keep Inventory</span>
                    </a>

                    <div class="hidden md:flex items-center gap-0.5">
                        <a href="{{ route('dashboard') }}"
                           class="px-3 py-1.5 rounded-md text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-slate-100 text-slate-900' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                            {{ __('nav.dashboard') }}
                        </a>
                        @if (auth()->user()->isAdmin() || auth()->user()->isEditor())
                        <a href="{{ route('notebooks.index') }}"
                           class="px-3 py-1.5 rounded-md text-sm font-medium transition {{ request()->routeIs('notebooks.*') ? 'bg-slate-100 text-slate-900' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                            {{ __('nav.notebooks') }}
                        </a>
                        <a href="{{ route('employees.index') }}"
                           class="px-3 py-1.5 rounded-md text-sm font-medium transition {{ request()->routeIs('employees.*') ? 'bg-slate-100 text-slate-900' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                            {{ __('nav.employees') }}
                        </a>
                        @endif
                        @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.users.index') }}"
                           class="px-3 py-1.5 rounded-md text-sm font-medium transition {{ request()->routeIs('admin.*') ? 'bg-slate-100 text-slate-900' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                            {{ __('nav.users') }}
                        </a>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <x-lang-switcher />

                    <a href="{{ route('settings.index') }}" class="p-2 rounded-md text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition" title="{{ __('nav.settings') }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </a>

                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 p-1.5 rounded-md hover:bg-slate-100 transition">
                            <div class="w-7 h-7 bg-slate-700 text-white rounded-md flex items-center justify-center font-semibold text-xs">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <span class="text-sm font-medium text-slate-700 hidden sm:block">{{ auth()->user()->name }}</span>
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                             class="absolute right-0 mt-2 w-60 bg-white rounded-lg shadow-lg border border-slate-200 py-1.5 z-50">
                            <div class="px-4 py-3 border-b border-slate-100">
                                <div class="font-semibold text-slate-800 text-sm">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">{{ auth()->user()->email }}</div>
                                <div class="mt-2">
                                    <span class="text-xs px-2 py-0.5 rounded font-medium
                                        {{ auth()->user()->role === 'admin' ? 'bg-slate-800 text-white' : (auth()->user()->role === 'editor' ? 'bg-slate-600 text-white' : 'bg-slate-200 text-slate-700') }}">
                                        {{ auth()->user()->role_label }}
                                    </span>
                                </div>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('settings.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 transition">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ __('settings.title') }}
                                </a>
                            </div>
                            <div class="border-t border-slate-100 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
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

        {{-- Mobile menu --}}
        <div x-data="{ mobileOpen: false }" class="md:hidden border-t border-slate-100">
            <button @click="mobileOpen = !mobileOpen" class="w-full flex items-center justify-between px-4 py-3 text-sm text-slate-600 hover:bg-slate-50 transition">
                <span class="font-medium">{{ __('nav.menu') }}</span>
                <svg :class="mobileOpen ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="mobileOpen" x-transition class="pb-2">
                <a href="{{ route('dashboard') }}" class="block px-6 py-2 text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-blue-600 bg-blue-50' : 'text-slate-600 hover:bg-slate-50' }}">{{ __('nav.dashboard') }}</a>
                @if (auth()->user()->isAdmin() || auth()->user()->isEditor())
                <a href="{{ route('notebooks.index') }}" class="block px-6 py-2 text-sm font-medium {{ request()->routeIs('notebooks.*') ? 'text-blue-600 bg-blue-50' : 'text-slate-600 hover:bg-slate-50' }}">{{ __('nav.notebooks') }}</a>
                <a href="{{ route('employees.index') }}" class="block px-6 py-2 text-sm font-medium {{ request()->routeIs('employees.*') ? 'text-blue-600 bg-blue-50' : 'text-slate-600 hover:bg-slate-50' }}">{{ __('nav.employees') }}</a>
                @endif
                @if (auth()->user()->isAdmin())
                <a href="{{ route('admin.users.index') }}" class="block px-6 py-2 text-sm font-medium {{ request()->routeIs('admin.*') ? 'text-blue-600 bg-blue-50' : 'text-slate-600 hover:bg-slate-50' }}">{{ __('nav.users') }}</a>
                @endif
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="mb-5 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-3 text-sm flash-message">
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
                 class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center gap-3 text-sm flash-message">
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

    {{-- Toast component --}}
    <div x-data="toast" x-on:toast.window="add($event.detail)" class="fixed bottom-6 right-6 z-50 space-y-3">
        <template x-for="t in toasts" :key="t.id">
            <div x-show="t.show"
                 x-transition:enter="toast-enter"
                 x-transition:leave="toast-exit"
                 class="flex items-center gap-3 px-4 py-3 rounded-lg shadow-lg text-sm font-medium pointer-events-auto min-w-[280px]"
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

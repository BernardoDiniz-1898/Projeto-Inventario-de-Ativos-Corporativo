<!DOCTYPE html>
<html lang="pt-BR">
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
    <style>
        [data-font="small"] { font-size: 14px; }
        [data-font="normal"] { font-size: 15px; }
        [data-font="large"] { font-size: 17px; }

        /* ========== DARK THEME ========== */
        .dark { background-color: #0f172a; color: #e2e8f0; }

        /* Navbar */
        .dark .corporate-nav { background-color: #1e293b; border-color: #334155; }
        .dark .corporate-nav .text-slate-800 { color: #f1f5f9; }
        .dark .corporate-nav .text-slate-700 { color: #e2e8f0; }
        .dark .corporate-nav .text-slate-500 { color: #94a3b8; }
        .dark .corporate-nav .text-slate-400 { color: #64748b; }
        .dark .corporate-nav .hover\:text-slate-600:hover { color: #e2e8f0; }
        .dark .corporate-nav .bg-slate-800 { background-color: #334155; }
        .dark .corporate-nav .bg-slate-700 { background-color: #475569; }

        /* Cards and backgrounds */
        .dark .bg-white { background-color: #1e293b; }
        .dark .bg-slate-50 { background-color: #1e293b; }
        .dark .bg-slate-100 { background-color: #0f172a; }

        /* Text */
        .dark .text-slate-900 { color: #f1f5f9; }
        .dark .text-slate-800 { color: #f1f5f9; }
        .dark .text-slate-700 { color: #e2e8f0; }
        .dark .text-slate-600 { color: #94a3b8; }
        .dark .text-slate-500 { color: #94a3b8; }
        .dark .text-slate-400 { color: #64748b; }

        /* Borders */
        .dark .border-slate-200 { border-color: #334155; }
        .dark .border-slate-100 { border-color: #334155; }
        .dark .divide-slate-100 > :not([hidden]) ~ :not([hidden]) { border-color: #334155; }
        .dark .divide-slate-200 > :not([hidden]) ~ :not([hidden]) { border-color: #334155; }

        /* Inputs */
        .dark input, .dark select, .dark textarea {
            background-color: #0f172a; border-color: #475569; color: #f1f5f9;
        }
        .dark input::placeholder, .dark textarea::placeholder { color: #64748b; }
        .dark input:focus, .dark select:focus, .dark textarea:focus {
            border-color: #3b82f6; box-shadow: 0 0 0 2px rgba(59,130,246,0.2);
        }

        /* Hover states */
        .dark .hover\:bg-slate-50:hover { background-color: #334155; }
        .dark .hover\:bg-slate-100:hover { background-color: #334155; }
        .dark .hover\:bg-gray-50:hover { background-color: #334155; }

        /* Tables */
        .dark table { color: #e2e8f0; }
        .dark thead tr { background-color: #0f172a; }
        .dark tbody tr:hover { background-color: #334155; }

        /* Status badges */
        .dark .bg-green-100 { background-color: rgba(34,197,94,0.15); }
        .dark .text-green-700 { color: #4ade80; }
        .dark .bg-blue-100 { background-color: rgba(59,130,246,0.15); }
        .dark .text-blue-700 { color: #60a5fa; }
        .dark .bg-yellow-100 { background-color: rgba(234,179,8,0.15); }
        .dark .text-yellow-700 { color: #facc15; }
        .dark .bg-orange-100 { background-color: rgba(249,115,22,0.15); }
        .dark .text-orange-700 { color: #fb923c; }
        .dark .bg-purple-100 { background-color: rgba(168,85,247,0.15); }
        .dark .text-purple-700 { color: #c084fc; }
        .dark .bg-red-100 { background-color: rgba(239,68,68,0.15); }
        .dark .text-red-700 { color: #f87171; }
        .dark .bg-amber-100 { background-color: rgba(245,158,11,0.15); }
        .dark .text-amber-700 { color: #fbbf24; }
        .dark .bg-green-50 { background-color: rgba(34,197,94,0.1); }
        .dark .bg-red-50 { background-color: rgba(239,68,68,0.1); }
        .dark .bg-blue-50 { background-color: rgba(59,130,246,0.1); }

        /* Text colors in dark */
        .dark .text-green-600 { color: #4ade80; }
        .dark .text-blue-600 { color: #60a5fa; }
        .dark .text-yellow-600 { color: #facc15; }
        .dark .text-orange-600 { color: #fb923c; }
        .dark .text-red-600 { color: #f87171; }
        .dark .text-purple-600 { color: #c084fc; }
        .dark .text-indigo-600 { color: #818cf8; }

        /* Alerts */
        .dark .bg-green-50 { background-color: rgba(34,197,94,0.1); }
        .dark .bg-green-50.border-green-200 { border-color: rgba(34,197,94,0.3); }
        .dark .text-green-700 { color: #4ade80; }
        .dark .bg-red-50 { background-color: rgba(239,68,68,0.1); }
        .dark .bg-red-50.border-red-200 { border-color: rgba(239,68,68,0.3); }
        .dark .text-red-700 { color: #f87171; }

        /* Shadow */
        .dark .shadow-sm { box-shadow: 0 1px 2px 0 rgba(0,0,0,0.3); }
        .dark .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0,0,0,0.4); }

        /* Dropdown */
        .dark .bg-white.rounded-lg.shadow-lg { background-color: #1e293b; border-color: #334155; }
        .dark .border-b.border-slate-100 { border-color: #334155; }
        .dark .border-t.border-slate-100 { border-color: #334155; }
        .dark .border-t.border-slate-200 { border-color: #334155; }
        .dark .hover\:bg-red-50:hover { background-color: rgba(239,68,68,0.1); }

        /* Code */
        .dark code { background-color: #334155; color: #94a3b8; }

        /* White avatars in dark */
        .dark .bg-slate-700 { background-color: #475569; }

        /* Gray palette (used by dashboard) */
        .dark .bg-gray-50 { background-color: #0f172a; }
        .dark .bg-gray-100 { background-color: #1e293b; }
        .dark .text-gray-900, .dark .text-gray-800, .dark .text-gray-700 { color: #e2e8f0; }
        .dark .text-gray-600, .dark .text-gray-500, .dark .text-gray-400 { color: #94a3b8; }
        .dark .border-gray-100, .dark .border-gray-200 { border-color: #334155; }
        .dark .divide-gray-100 > :not([hidden]) ~ :not([hidden]) { border-color: #334155; }
        .dark .hover\:bg-gray-50:hover { background-color: #334155; }
        .dark .hover\:bg-gray-100:hover { background-color: #334155; }

        /* Pagination */
        .dark .pagination .active span { background-color: #334155; color: #f1f5f9; }
        .dark .pagination a { color: #94a3b8; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen antialiased">

    <nav class="corporate-nav bg-white border-b border-slate-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-14">
                <div class="flex items-center gap-8">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                        <div class="w-8 h-8 bg-slate-800 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <span class="font-bold text-slate-800 text-sm tracking-wide hidden sm:block uppercase">Keep Inventory</span>
                    </a>

                    <div class="hidden md:flex items-center gap-0.5">
                        <a href="{{ route('dashboard') }}"
                           class="px-3 py-1.5 rounded-md text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-slate-100 text-slate-900' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                            Dashboard
                        </a>
                        @if (auth()->user()->isAdmin() || auth()->user()->isEditor())
                        <a href="{{ route('notebooks.index') }}"
                           class="px-3 py-1.5 rounded-md text-sm font-medium transition {{ request()->routeIs('notebooks.*') ? 'bg-slate-100 text-slate-900' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                            Notebooks
                        </a>
                        <a href="{{ route('employees.index') }}"
                           class="px-3 py-1.5 rounded-md text-sm font-medium transition {{ request()->routeIs('employees.*') ? 'bg-slate-100 text-slate-900' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                            Funcionários
                        </a>
                        @endif
                        @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.users.index') }}"
                           class="px-3 py-1.5 rounded-md text-sm font-medium transition {{ request()->routeIs('admin.*') ? 'bg-slate-100 text-slate-900' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                            Usuários
                        </a>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('settings.index') }}" class="p-2 rounded-md text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition" title="Configurações">
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
                                    Configurações
                                </a>
                            </div>
                            <div class="border-t border-slate-100 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Sair da conta
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if (session('success'))
            <div class="mb-5 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-3 text-sm">
                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center gap-3 text-sm">
                <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>

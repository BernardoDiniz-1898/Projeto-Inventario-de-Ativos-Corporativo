@extends('layouts.app')

@section('title', __('settings.title'))

@section('content')
<div class="mb-6">
    <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700 inline-flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        {{ __('settings.back') }}
    </a>
</div>

<h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('settings.title') }}</h1>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Theme --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
            </svg>
            {{ __('settings.theme') }}
        </h2>
        <div class="space-y-3">
            <label class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition theme-option" data-theme="light">
                <input type="radio" name="theme" value="light" class="text-blue-600 focus:ring-blue-500">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-white border-2 border-gray-200 flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.591 1.59a.75.75 0 101.06 1.061l1.591-1.59zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5H21a.75.75 0 01.75.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 10-1.061 1.06l1.59 1.591zM12 18a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM7.758 17.303a.75.75 0 00-1.061-1.06l-1.591 1.59a.75.75 0 001.06 1.061l1.591-1.59zM6 12a.75.75 0 01-.75.75H3a.75.75 0 010-1.5h2.25A.75.75 0 016 12zM6.697 7.757a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 00-1.061 1.06l1.59 1.591z"/></svg>
                    </div>
                    <div>
                        <div class="font-medium text-sm text-gray-800">{{ __('settings.light') }}</div>
                        <div class="text-xs text-gray-500">{{ __('settings.light_desc') }}</div>
                    </div>
                </div>
            </label>
            <label class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition theme-option" data-theme="dark">
                <input type="radio" name="theme" value="dark" class="text-blue-600 focus:ring-blue-500">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gray-800 border-2 border-gray-700 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 24 24"><path d="M9.528 1.718a.75.75 0 01.162.819A8.97 8.97 0 009 6a9 9 0 009 9 8.97 8.97 0 003.463-.69.75.75 0 01.981.98 10.503 10.503 0 01-9.694 6.46c-5.799 0-10.5-4.701-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 01.818.162z"/></svg>
                    </div>
                    <div>
                        <div class="font-medium text-sm text-gray-800">{{ __('settings.dark') }}</div>
                        <div class="text-xs text-gray-500">{{ __('settings.dark_desc') }}</div>
                    </div>
                </div>
            </label>
        </div>
    </div>

    {{-- Font Size --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
            </svg>
            {{ __('settings.font_size') }}
        </h2>
        <div class="space-y-3">
            <label class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition font-option" data-font="small">
                <input type="radio" name="font_size" value="small" class="text-blue-600 focus:ring-blue-500">
                <div>
                    <div class="font-medium text-xs text-gray-800">{{ __('settings.font_small') }}</div>
                    <div class="text-xs text-gray-500">{{ __('settings.font_small_desc') }}</div>
                </div>
            </label>
            <label class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition font-option" data-font="normal">
                <input type="radio" name="font_size" value="normal" class="text-blue-600 focus:ring-blue-500">
                <div>
                    <div class="font-medium text-sm text-gray-800">{{ __('settings.font_normal') }}</div>
                    <div class="text-xs text-gray-500">{{ __('settings.font_normal_desc') }}</div>
                </div>
            </label>
            <label class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition font-option" data-font="large">
                <input type="radio" name="font_size" value="large" class="text-blue-600 focus:ring-blue-500">
                <div>
                    <div class="font-medium text-base text-gray-800">{{ __('settings.font_large') }}</div>
                    <div class="text-xs text-gray-500">{{ __('settings.font_large_desc') }}</div>
                </div>
            </label>
        </div>
    </div>

    {{-- Accent Color --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
            </svg>
            {{ __('settings.accent_color') }}
        </h2>
        <div class="grid grid-cols-5 gap-3">
            <button type="button" class="color-btn w-full aspect-square rounded-xl border-2 transition-all hover:scale-105" data-color="blue" style="background: #2563eb">
                <svg class="w-5 h-5 text-white mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </button>
            <button type="button" class="color-btn w-full aspect-square rounded-xl border-2 transition-all hover:scale-105" data-color="green" style="background: #16a34a">
                <svg class="w-5 h-5 text-white mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </button>
            <button type="button" class="color-btn w-full aspect-square rounded-xl border-2 transition-all hover:scale-105" data-color="purple" style="background: #9333ea">
                <svg class="w-5 h-5 text-white mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </button>
            <button type="button" class="color-btn w-full aspect-square rounded-xl border-2 transition-all hover:scale-105" data-color="red" style="background: #dc2626">
                <svg class="w-5 h-5 text-white mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </button>
            <button type="button" class="color-btn w-full aspect-square rounded-xl border-2 transition-all hover:scale-105" data-color="orange" style="background: #ea580c">
                <svg class="w-5 h-5 text-white mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </button>
        </div>
    </div>

    {{-- Layout --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
            </svg>
            {{ __('settings.layout') }}
        </h2>
        <div class="space-y-3">
            <label class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition" data-layout="expanded">
                <input type="radio" name="sidebar" value="expanded" class="text-blue-600 focus:ring-blue-500">
                <div class="w-16 h-10 bg-gray-100 rounded border flex overflow-hidden">
                    <div class="w-4 bg-gray-300"></div>
                    <div class="flex-1 p-1"><div class="h-1 bg-gray-200 rounded w-full mb-1"></div><div class="h-1 bg-gray-200 rounded w-3/4"></div></div>
                </div>
                <div>
                    <div class="font-medium text-sm text-gray-800">{{ __('settings.layout_expanded') }}</div>
                    <div class="text-xs text-gray-500">{{ __('settings.layout_expanded_desc') }}</div>
                </div>
            </label>
            <label class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition" data-layout="collapsed">
                <input type="radio" name="sidebar" value="collapsed" class="text-blue-600 focus:ring-blue-500">
                <div class="w-16 h-10 bg-gray-100 rounded border flex overflow-hidden">
                    <div class="w-2 bg-gray-300"></div>
                    <div class="flex-1 p-1"><div class="h-1 bg-gray-200 rounded w-full mb-1"></div><div class="h-1 bg-gray-200 rounded w-3/4"></div></div>
                </div>
                <div>
                    <div class="font-medium text-sm text-gray-800">{{ __('settings.layout_collapsed') }}</div>
                    <div class="text-xs text-gray-500">{{ __('settings.layout_collapsed_desc') }}</div>
                </div>
            </label>
        </div>
    </div>

</div>

<div class="mt-6 flex items-center gap-3">
    <button type="button" id="saveSettings" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700 transition">
        {{ __('settings.save') }}
    </button>
    <button type="button" id="resetSettings" class="text-gray-500 hover:text-gray-700 text-sm font-medium px-4 py-2.5">
        {{ __('settings.reset') }}
    </button>
</div>

<script>
    const STORAGE_KEY = 'app_settings';
    const defaults = { theme: 'light', font_size: 'normal', accent_color: 'blue', sidebar: 'expanded' };

    function loadSettings() {
        try { return { ...defaults, ...JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}') }; }
        catch { return { ...defaults }; }
    }

    function saveSettings(settings) {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(settings));
        applySettings(settings);
    }

    function applySettings(s) {
        document.documentElement.setAttribute('data-theme', s.theme);
        document.documentElement.setAttribute('data-font', s.font_size);
        document.documentElement.setAttribute('data-accent', s.accent_color);
        document.documentElement.setAttribute('data-sidebar', s.sidebar);

        document.documentElement.classList.toggle('dark', s.theme === 'dark');

        document.querySelectorAll('input[name="theme"]').forEach(r => r.checked = r.value === s.theme);
        document.querySelectorAll('input[name="font_size"]').forEach(r => r.checked = r.value === s.font_size);
        document.querySelectorAll('input[name="sidebar"]').forEach(r => r.checked = r.value === s.sidebar);

        document.querySelectorAll('.color-btn').forEach(b => {
            b.classList.toggle('ring-2', b.dataset.color === s.accent_color);
            b.classList.toggle('ring-offset-2', b.dataset.color === s.accent_color);
        });

        // Apply accent color to navbar brand
        const brand = document.querySelector('.corporate-nav .bg-gradient-to-br');
        if (brand) {
            const colors = {
                blue: 'from-blue-500 to-blue-700',
                green: 'from-green-500 to-green-700',
                purple: 'from-purple-500 to-purple-700',
                red: 'from-red-500 to-red-700',
                orange: 'from-orange-500 to-orange-700'
            };
            brand.className = brand.className.replace(/from-\w+-\d+ to-\w+-\d+/, colors[s.accent_color] || colors.blue);
        }
    }

    function showToast(message) {
        window.dispatchEvent(new CustomEvent('toast', { detail: { message, type: 'success' } }));
    }

    document.addEventListener('DOMContentLoaded', () => {
        const settings = loadSettings();
        applySettings(settings);

        document.querySelectorAll('input[name="theme"], input[name="font_size"], input[name="sidebar"]').forEach(r => {
            r.addEventListener('change', () => {
                const s = loadSettings();
                s[r.name] = r.value;
                saveSettings(s);
            });
        });

        document.querySelectorAll('.color-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const s = loadSettings();
                s.accent_color = btn.dataset.color;
                saveSettings(s);
            });
        });

        document.getElementById('saveSettings').addEventListener('click', () => {
            showToast('Configurações salvas!');
        });

        document.getElementById('resetSettings').addEventListener('click', () => {
            saveSettings({ ...defaults });
            showToast('Configurações redefinidas!');
        });
    });
</script>
@endsection

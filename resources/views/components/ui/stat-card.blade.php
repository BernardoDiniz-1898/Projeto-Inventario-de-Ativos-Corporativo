@props(['value', 'label', 'color' => 'gray', 'icon' => null, 'class' => ''])

@php
    $colorClasses = match($color) {
        'green' => 'bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400',
        'blue' => 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400',
        'indigo' => 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400',
        'yellow' => 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400',
        'orange' => 'bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400',
        'purple' => 'bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400',
        'red' => 'bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400',
        default => 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400',
    };
    $valueColor = match($color) {
        'green' => 'text-green-600 dark:text-green-400',
        'blue' => 'text-blue-600 dark:text-blue-400',
        'indigo' => 'text-indigo-600 dark:text-indigo-400',
        'yellow' => 'text-yellow-600 dark:text-yellow-400',
        'orange' => 'text-orange-600 dark:text-orange-400',
        'purple' => 'text-purple-600 dark:text-purple-400',
        'red' => 'text-red-600 dark:text-red-400',
        default => 'text-gray-900 dark:text-white',
    };
@endphp
<div class="stat-card bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-4 border border-gray-100 dark:border-slate-700 hover:shadow-md transition-shadow flex-shrink-0 flex items-center gap-3 min-w-0 {{ $class }}">
    <div class="stat-icon w-9 h-9 {{ $colorClasses }} rounded-xl flex items-center justify-center shrink-0">
        {{ $slot }}
    </div>
    <div class="min-w-0">
        <p class="stat-value text-xl font-bold {{ $valueColor }}">{{ $value }}</p>
        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $label }}</p>
    </div>
</div>
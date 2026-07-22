@props(['name', 'size' => 'md', 'color' => 'blue'])

@php
    $initials = strtoupper(substr($name, 0, 2));
    $sizeClass = match($size) {
        'sm' => 'w-7 h-7 text-xs rounded-lg',
        'md' => 'w-9 h-9 text-xs rounded-full',
        'lg' => 'w-14 h-14 text-xl rounded-2xl',
        default => 'w-9 h-9 text-xs rounded-full',
    };
    $colorClass = match($color) {
        'orange' => 'bg-orange-100 dark:bg-orange-900/40 text-orange-500 dark:text-orange-400',
        'purple' => 'bg-purple-100 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400',
        'gray' => 'bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-500',
        default => 'bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400',
    };
@endphp
<div class="{{ $sizeClass }} {{ $colorClass }} flex items-center justify-center font-semibold shrink-0 {{ $attributes->get('class') }}">
    {{ $slot->isEmpty() ? $initials : $slot }}
</div>
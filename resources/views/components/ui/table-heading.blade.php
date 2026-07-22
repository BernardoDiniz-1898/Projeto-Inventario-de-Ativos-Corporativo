@props(['text', 'class' => '', 'responsive' => null, 'padding' => 'py-5'])

<th class="px-5 sm:px-7 {{ $padding }} font-semibold text-[11px] uppercase tracking-wider text-gray-500 dark:text-gray-400 {{ $responsive }} {{ $class }}">
    {{ $text }}
</th>
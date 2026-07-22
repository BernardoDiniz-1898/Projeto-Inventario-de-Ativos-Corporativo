@props(['action', 'searchValue' => '', 'filterOptions' => [], 'filterValue' => ''])

<form method="GET" action="{{ $action }}" class="p-4 flex flex-col sm:flex-row gap-3">
    <div class="flex-1 relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
        <input type="text" name="search" value="{{ $searchValue }}" placeholder="{{ __('common.search') }}"
               class="w-full border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
    </div>
    @if(!empty($filterOptions))
        <select name="{{ $filterOptions['name'] }}" class="w-full sm:w-auto border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option value="">{{ $filterOptions['allLabel'] }}</option>
            @foreach($filterOptions['options'] as $value => $label)
                <option value="{{ $value }}" {{ $filterValue === $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    @endif
    <div class="flex gap-2">
        <button type="submit" class="flex-1 sm:flex-none bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300 px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-200 dark:hover:bg-slate-600 transition">
            {{ __('common.filter') }}
        </button>
        @if ($searchValue || $filterValue)
            <a href="{{ strtok($action, '?') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 px-4 py-2.5 text-sm font-medium">
                {{ __('common.clear') }}
            </a>
        @endif
    </div>
</form>
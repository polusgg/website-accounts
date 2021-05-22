@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block pl-3 pr-4 py-2 border-l-4 border-purple-400 text-base font-medium text-purple-700 dark:text-gray-50 bg-gray-50 dark:bg-gray-900 dark:bg-opacity-30 focus:outline-none focus:text-gray-800 dark:focus:text-purple-400 dark:focus:bg-opacity-50 focus:border-purple-700 transition'
            : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-900 dark:hover:bg-opacity-30 hover:border-gray-300 dark:hover:border-purple-400 focus:outline-none focus:text-purple-700 dark:focus:text-purple-400 focus:bg-gray-100 dark:focus:bg-gray-900 dark:focus:bg-opacity-50 focus:border-purple-400 dark:focus:border-purple-700 transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

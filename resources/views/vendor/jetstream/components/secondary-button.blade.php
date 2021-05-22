<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-white uppercase tracking-widest shadow-sm hover:text-gray-500 dark:hover:text-white dark:hover:border-purple-500 focus:outline-none focus:border-purple-500 focus:ring focus:ring-blue-200 dark:focus:ring-purple-600 active:text-gray-800 dark:active:text-white active:bg-gray-50 dark:active:bg-gray-600 disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>

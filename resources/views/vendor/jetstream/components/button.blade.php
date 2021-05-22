<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-purple-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-purple-800 active:bg-gray-900 dark:active:bg-purple-800 focus:outline-none focus:border-gray-500 dark:focus:border-purple-800 focus:ring focus:ring-gray-300 dark:focus:ring-purple-200 disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>

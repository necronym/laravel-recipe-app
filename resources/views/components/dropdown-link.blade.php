<!-- resources/views/components/dropdown-link.blade.php -->

<!-- 
    A reusable link component designed for use in dropdown menus.
    Provides consistent styling and interaction effects.
    Example usage: <x-dropdown-link href="/logout">Logout</x-dropdown-link>
-->

<a {{ $attributes->merge([
    'class' => '
        block w-full px-4 py-2 text-start text-sm leading-5
        text-gray-700 dark:text-gray-300
        hover:bg-gray-100 dark:hover:bg-gray-800
        focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800
        transition duration-150 ease-in-out
    '
]) }}>
    {{ $slot }}
</a>

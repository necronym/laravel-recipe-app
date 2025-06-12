<!-- resources/views/components/danger-button.blade.php -->

<!-- 
    A reusable red "danger" button component.
    Typically used for delete or destructive actions.
    Accepts custom attributes and slot content.
    Example usage: <x-danger-button>Delete</x-danger-button>
-->

<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => '
        inline-flex items-center px-4 py-2
        bg-red-600 border border-transparent rounded-md
        font-semibold text-xs text-white uppercase tracking-widest
        hover:bg-red-500 active:bg-red-700
        focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2
        dark:focus:ring-offset-gray-800
        transition ease-in-out duration-150
    '
]) }}>
    {{ $slot }}
</button>

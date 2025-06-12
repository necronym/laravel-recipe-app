<!-- resources/views/components/input-label.blade.php -->

<!--
    Label component for form inputs.
    Accepts either a 'value' prop or slot content.
-->

@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700 dark:text-gray-300']) }}>
    {{ $value ?? $slot }}
</label>

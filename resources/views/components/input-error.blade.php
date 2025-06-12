<!-- resources/views/components/input-error.blade.php -->

<!--
    Displays validation error messages for form inputs.
    Expects a 'messages' prop, which can be a string or an array of strings.
-->

@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 dark:text-red-400 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif

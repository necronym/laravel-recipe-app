<!-- resources/views/components/auth-session-status.blade.php -->

@props(['status'])

<!-- 
    Displays a session status message, commonly used for login/register success messages.
    Example usage: <x-auth-session-status :status="session('status')" />
-->
@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600 dark:text-green-400']) }}>
        {{ $status }}
    </div>
@endif

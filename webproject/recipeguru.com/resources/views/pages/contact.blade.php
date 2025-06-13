<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Contact Us</h2>
    </x-slot>

    <div class="max-w-xl mx-auto py-10 text-gray-800">
        @if (session('status'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('status') }}
            </div>
        @endif

        <p class="text-l">Need help? Have feedback? Fill out the form below and we’ll get back to you soon.</p>

        <form method="POST" action="{{ route('contact.submit') }}">
            @csrf

            <div class="mt-4">
                <label for="messengerEmail" class="block text-sm font-medium mb-1">Your Email</label>
                <input type="email" id="messengerEmail" name="messengerEmail" required
                    class="w-full border border-gray-300 rounded px-3 py-2 shadow-sm"
                    value="{{ old('messengerEmail') }}">
                @error('messengerEmail') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mt-4 mb-4">
                <label for="message" class="block text-sm font-medium mb-1">Message</label>
                <textarea id="message" name="message" rows="5" required
                          class="w-full border border-gray-300 rounded px-3 py-2 shadow-sm">{{ old('message') }}</textarea>
                @error('message') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Send Message
            </button>
        </form>
    </div>
</x-app-layout>

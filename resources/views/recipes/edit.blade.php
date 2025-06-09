<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Edit Recipe</h2>
    </x-slot>

    <div class="py-6 max-w-xl">
        <form method="POST" action="{{ route('recipes.update', $recipe) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="Name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Recipe Name</label>
                <input type="text" name="Name" value="{{ $recipe->Name }}" class="w-full border rounded p-2 dark:bg-gray-800 dark:text-white" required>
            </div>

            <div>
                <label for="Instructions" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Preparation Steps</label>
                <textarea name="Instructions" rows="5" required class="w-full border rounded p-2 dark:bg-gray-800 dark:text-white">{{ $recipe->Instructions }}</textarea>
            </div>

            <div>
                <label for="Time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Time (minutes)</label>
                <input type="number" name="Time" value="{{ $recipe->Time }}" class="w-full border rounded p-2 dark:bg-gray-800 dark:text-white">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Current Image</label>
                @if ($recipe->Image)
                    <img src="{{ asset('storage/recipes/' . $recipe->Image) }}" width="200" class="mb-2 rounded shadow">
                @else
                    <p class="text-sm text-gray-500">No image uploaded.</p>
                @endif
                <input type="file" name="Image" class="mt-2">
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
        </form>
    </div>
</x-app-layout>

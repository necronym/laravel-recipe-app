<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Create Recipe</h2>
    </x-slot>

    <div class="py-6">
        <form method="POST" action="{{ route('recipes.store') }}" enctype="multipart/form-data" class="space-y-4 max-w-xl">
            @csrf

            <div>
                <label for="Name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Recipe Name</label>
                <input type="text" name="Name" required class="w-full border rounded p-2 dark:bg-gray-800 dark:text-white" />
            </div>

            <div>
                <label for="Instructions" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Preparation Steps</label>
                <textarea name="Instructions" required rows="5" class="w-full border rounded p-2 dark:bg-gray-800 dark:text-white"></textarea>
            </div>

            <div>
                <label for="Time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Time (minutes)</label>
                <input type="number" name="Time" class="w-full border rounded p-2 dark:bg-gray-800 dark:text-white" />
            </div>

            <div>
                <label for="Image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Recipe Image</label>
                <input type="file" name="Image" class="w-full" />
            </div>

            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Save Recipe
            </button>
        </form>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Create Recipe</h2>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto bg-white dark:bg-gray-900 p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Create a New Recipe</h2>

            <form method="POST" action="{{ route('recipes.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Recipe Name -->
                <div>
                    <label for="Name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Recipe Name</label>
                    <input type="text" name="Name" required
                           class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 dark:bg-gray-800 dark:text-white" />
                </div>

                <!-- Instructions -->
                <div>
                    <label for="Instructions" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Preparation Steps</label>
                    <textarea name="Instructions" required rows="5"
                              class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 dark:bg-gray-800 dark:text-white"></textarea>
                </div>

                <!-- Time -->
                <div>
                    <label for="Time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Time (minutes)</label>
                    <input type="number" name="Time"
                           class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 dark:bg-gray-800 dark:text-white" />
                </div>

                <!-- Image -->
                <div>
                    <label for="Image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Recipe Image</label>
                    <input type="file" name="Image"
                           class="w-full mt-1 text-gray-700 dark:text-white" />
                </div>

                <!-- Categories -->
                @foreach($categoryTypes as $type)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-4">{{ $type->Name }}</label>
                        <select name="categories[]" multiple
                                class="tom-select w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 dark:bg-gray-800 dark:text-white">
                            @foreach($type->categories as $category)
                                <option value="{{ $category->CategoryID }}">{{ $category->Name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endforeach

                <!-- Ingredients -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-4">Ingredients</label>
                    <select name="ingredients[]" multiple
                            class="tom-select w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 dark:bg-gray-800 dark:text-white">
                        @foreach($ingredients as $ingredient)
                            <option value="{{ $ingredient->IngredientID }}">{{ $ingredient->Name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                            class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition duration-200">
                        Save Recipe
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
        <script>
            document.querySelectorAll('.tom-select').forEach(el => {
                new TomSelect(el, {
                    plugins: ['remove_button'],
                    create: false,
                    persist: false
                });
            });
        </script>
    @endpush

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    @endpush
</x-app-layout>


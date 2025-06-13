<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-800">Create Recipe</h2>
    </x-slot>

    <div class="py-6">
        <form method="POST" action="{{ route('recipes.store') }}" enctype="multipart/form-data" class="space-y-6 max-w-2xl mx-auto">
            @csrf

            <!-- Name -->
            <div>
                <label for="Name" class="block text-base font-medium text-gray-800">Recipe Name</label>
                <input type="text" name="Name" required class="w-full border rounded p-2 bg-white text-black" />
            </div>

            <!-- Instructions -->
            <div>
                <label for="Instructions" class="block text-base font-medium text-gray-800">Preparation Steps</label>
                <textarea name="Instructions" required rows="5" class="w-full border rounded p-2 bg-white text-black"></textarea>
            </div>

            <!-- Time -->
            <div>
                <label for="Time" class="block text-base font-medium text-gray-800">Time (minutes)</label>
                <input type="number" name="Time" class="w-full border rounded p-2 bg-white text-black" />
            </div>

            <!-- Image -->
            <div>
                <label for="Image" class="block text-base font-medium text-gray-800">Recipe Image</label>
                <input type="file" name="Image" class="w-full" />
            </div>

            <!-- Categories -->
            @foreach($categoryTypes as $type)
                <div>
                    <label class="block text-base font-medium text-gray-800 mt-4">{{ $type->Name }}</label>
                    <select name="categories[]" multiple class="tom-select w-full">
                        @foreach($type->categories as $category)
                            <option value="{{ $category->CategoryID }}">{{ $category->Name }}</option>
                        @endforeach
                    </select>
                </div>
            @endforeach

            <!-- Ingredients -->
            <div>
                <label class="block text-base font-medium text-gray-800 mt-4">Ingredients</label>
                <select name="ingredients[]" multiple class="tom-select w-full">
                    @foreach($ingredients as $ingredient)
                        <option value="{{ $ingredient->IngredientID }}">{{ $ingredient->Name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Create Recipe!
            </button>
        </form>
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

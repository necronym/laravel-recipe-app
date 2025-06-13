<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-800">Edit Recipe</h2>
    </x-slot>

    <div class="py-6">
        <form method="POST" action="{{ route('recipes.update', $recipe) }}" enctype="multipart/form-data" class="space-y-6 max-w-2xl mx-auto">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="Name" class="block text-base font-medium text-gray-800">Recipe Name</label>
                <input type="text" name="Name" value="{{ old('Name', $recipe->Name) }}" required class="w-full border rounded p-2 bg-white text-black" />
            </div>

            <!-- Instructions -->
            <div>
                <label for="Instructions" class="block text-base font-medium text-gray-800">Preparation Steps</label>
                <textarea name="Instructions" required rows="5" class="w-full border rounded p-2 bg-white text-black">{{ old('Instructions', $recipe->Instructions) }}</textarea>
            </div>

            <!-- Time -->
            <div>
                <label for="Time" class="block text-base font-medium text-gray-800">Time (minutes)</label>
                <input type="number" name="Time" value="{{ old('Time', $recipe->Time) }}" class="w-full border rounded p-2 bg-white text-black" />
            </div>

            <!-- Current Image -->
            <div>
                <label class="block text-base font-medium text-gray-800">Current Image</label>
                @if ($recipe->Image)
                    <img src="{{ asset('storage/recipes/' . $recipe->Image) }}" width="200" class="mb-2 rounded shadow">
                @else
                    <p class="text-sm text-gray-500">No image uploaded.</p>
                @endif
                <input type="file" name="Image" class="w-full" />
            </div>

            <!-- Categories -->
            @foreach($categoryTypes as $type)
                <div>
                    <label class="block text-base font-medium text-gray-800 mt-4">{{ $type->Name }}</label>
                    <select name="categories[]" multiple class="tom-select w-full">
                        @foreach($type->categories as $category)
                            <option value="{{ $category->CategoryID }}"
                                @if(in_array($category->CategoryID, $selectedCategories)) selected @endif>
                                {{ $category->Name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endforeach

            <!-- Ingredients -->
            <div>
                <label class="block text-base font-medium text-gray-800 mt-4">Ingredients</label>
                <select name="ingredients[]" multiple class="tom-select w-full">
                    @foreach($ingredients as $ingredient)
                        <option value="{{ $ingredient->IngredientID }}"
                            @if(in_array($ingredient->IngredientID, $selectedIngredients)) selected @endif>
                            {{ $ingredient->Name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Update Recipe
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

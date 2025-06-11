<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            All Recipes
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <div class="flex justify-between items-start">
            <!-- Recipe Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 flex-1">
                @foreach($recipes as $recipe)
                    <div class="border rounded shadow dark:border-gray-700 p-2">
                        @if ($recipe->Image)
                            <a href="{{ route('recipes.show', $recipe) }}">
                                <img src="{{ asset('storage/recipes/' . $recipe->Image) }}"
                                     alt="{{ $recipe->Name }}"
                                     class="w-full h-40 object-cover rounded mb-2">
                            </a>
                        @endif

                        <a href="{{ route('recipes.show', $recipe) }}"
                           class="text-md font-semibold text-blue-600 hover:underline block text-center mb-1">
                            {{ $recipe->Name }}
                        </a>

                        @php $avg = $recipe->ratings()->avg('Score'); @endphp
                        <div class="text-sm text-center text-gray-700 dark:text-gray-300">
                            @if($avg)
                                @for ($i = 1; $i <= 5; $i++)
                                    {!! $i <= round($avg) ? '⭐' : '☆' !!}
                                @endfor
                                <span class="text-xs text-gray-500">({{ number_format($avg, 1) }})</span>
                            @else
                                <span class="text-xs text-gray-500">No ratings yet</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Sidebar Filters -->
            <div class="w-72 ml-8 space-y-6">
                <form method="GET" action="{{ route('recipes.index') }}">
                    @csrf

                    <!-- Time Filter -->
                    <select name="time" class="w-full border rounded p-1 mb-4">
                        <option value="">All Times</option>
                        <option value="0-10" {{ ($selectedTime ?? '') == '0-10' ? 'selected' : '' }}>0–10 min</option>
                        <option value="10-20" {{ ($selectedTime ?? '') == '10-20' ? 'selected' : '' }}>10–20 min</option>
                        <option value="20-40" {{ ($selectedTime ?? '') == '20-40' ? 'selected' : '' }}>20–40 min</option>
                        <option value="40-60" {{ ($selectedTime ?? '') == '40-60' ? 'selected' : '' }}>40–60 min</option>
                        <option value="60+" {{ ($selectedTime ?? '') == '60+' ? 'selected' : '' }}>60+ min</option>
                    </select>

                    <!-- Category Filters -->
                    @foreach ($categoryTypes as $type)
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-4">
                            {{ $type->Name }}
                        </label>
                        <select name="categories[{{ $type->CategoryTypeID }}][]" multiple class="tom-select w-full">
                            @foreach ($type->categories as $category)
                                <option value="{{ $category->CategoryID }}"
                                    @if(collect(($selectedCategories[$type->CategoryTypeID] ?? []))->contains($category->CategoryID)) selected @endif>
                                    {{ $category->Name }}
                                </option>
                            @endforeach
                        </select>
                    @endforeach

                    <!-- Ingredients Filter -->
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-4">Ingredients</label>
                    <select name="ingredients[]" multiple class="tom-select w-full">
                        @foreach ($ingredients as $ingredient)
                            <option value="{{ $ingredient->IngredientID }}"
                                @if(in_array($ingredient->IngredientID, $selectedIngredients ?? [])) selected @endif>
                                {{ $ingredient->Name }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="mt-4 bg-blue-600 text-white px-3 py-2 rounded w-full hover:bg-blue-700">
                        Apply Filters
                    </button>

                    <a href="{{ route('recipes.index') }}" class="inline-block mt-2 text-sm text-red-600 hover:underline">
                        Reset Filters
                    </a>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
        <script>
            document.querySelectorAll('.tom-select').forEach(el => {
                new TomSelect(el, {
                    plugins: ['remove_button'],
                    create: false,
                    maxOptions: 100,
                    persist: false
                });
            });
        </script>
    @endpush

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    @endpush
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            All Recipes
        </h2>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto flex gap-8">

            <!-- Floating Sidebar -->
            <aside class="w-72 sticky top-28 self-start bg-white dark:bg-gray-900 p-4 rounded-lg shadow-md h-fit">
                <form method="GET" action="{{ route('recipes.index') }}" class="space-y-4">
                    @csrf

                    <!-- Time Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Time</label>
                        <select name="time"
                                class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-white">
                            <option value="">All Times</option>
                            <option value="0-10" {{ ($selectedTime ?? '') == '0-10' ? 'selected' : '' }}>0–10 min</option>
                            <option value="10-20" {{ ($selectedTime ?? '') == '10-20' ? 'selected' : '' }}>10–20 min</option>
                            <option value="20-40" {{ ($selectedTime ?? '') == '20-40' ? 'selected' : '' }}>20–40 min</option>
                            <option value="40-60" {{ ($selectedTime ?? '') == '40-60' ? 'selected' : '' }}>40–60 min</option>
                            <option value="60+" {{ ($selectedTime ?? '') == '60+' ? 'selected' : '' }}>60+ min</option>
                        </select>
                    </div>

                    <!-- Category Filters -->
                    @foreach ($categoryTypes as $type)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $type->Name }}</label>
                            <select name="categories[{{ $type->CategoryTypeID }}][]" multiple
                                    class="tom-select w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-white">
                                @foreach ($type->categories as $category)
                                    <option value="{{ $category->CategoryID }}"
                                        @if(collect(($selectedCategories[$type->CategoryTypeID] ?? []))->contains($category->CategoryID)) selected @endif>
                                        {{ $category->Name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach

                    <!-- Ingredients Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ingredients</label>
                        <select name="ingredients[]" multiple
                                class="tom-select w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-white">
                            @foreach ($ingredients as $ingredient)
                                <option value="{{ $ingredient->IngredientID }}"
                                    @if(in_array($ingredient->IngredientID, $selectedIngredients ?? [])) selected @endif>
                                    {{ $ingredient->Name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="pt-2 space-y-2">
                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg shadow-md">
                            Apply Filters
                        </button>
                        <a href="{{ route('recipes.index') }}"
                           class="block text-center text-sm text-red-600 hover:underline">
                            Reset Filters
                        </a>
                    </div>
                </form>
            </aside>

            <!-- Recipe Grid -->
            <main class="flex-1">
                @if($recipes->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($recipes as $recipe)
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-transform hover:scale-[1.02]">
                                <a href="{{ route('recipes.show', $recipe) }}">
                                    @if ($recipe->Image)
                                        <img src="{{ asset('storage/recipes/' . $recipe->Image) }}"
                                             alt="{{ $recipe->Name }}"
                                             class="w-full h-40 object-cover">
                                    @endif
                                </a>
                                <div class="p-4 text-center">
                                    <a href="{{ route('recipes.show', $recipe) }}"
                                       class="block text-md font-semibold text-blue-600 hover:underline mb-1">
                                        {{ $recipe->Name }}
                                    </a>
                                    @php $avg = $recipe->ratings()->avg('Score'); @endphp
                                    <div class="text-sm text-gray-700 dark:text-gray-300">
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
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 dark:text-gray-300 text-center mt-6">No recipes found.</p>
                @endif
            </main>
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

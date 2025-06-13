<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">
            Welcome to RecipeGuru! Check the available recipes here and happy food hunting!
        </h2>
    </x-slot>

    <div class="py-6 max-w-[1400px] mx-auto px-6">
        <div class="flex gap-8">
            <!-- Recipe Gallery -->
            <div class="grid grid-cols-4 gap-[40px]">
                @foreach($recipes as $recipe)
                    <div class="w-[230px] h-[270px] bg-gray-200 border border-black rounded-lg shadow-md overflow-hidden flex flex-col transition-transform hover:scale-[1.02] hover:shadow-lg">
                        <a href="{{ route('recipes.show', $recipe) }}">
                            @if ($recipe->Image && file_exists(public_path('storage/recipes/' . $recipe->Image)))
                                <div class="w-full h-[200px] overflow-hidden border-b border-black">
                                    <img src="{{ asset('storage/recipes/' . $recipe->Image) }}"
                                        alt="{{ $recipe->Name }}"
                                        class="w-full h-full object-cover" />
                                </div>
                            @else
                                <div class="w-full h-[200px] flex items-center justify-center text-sm text-gray-600 border-b border-black bg-white">
                                    Missing image
                                </div>
                            @endif
                        </a>

                        <div class="p-3 text-left text-sm flex flex-col flex-grow justify-between">
                            <a href="{{ route('recipes.show', $recipe) }}"
                            class="block font-semibold text-black hover:underline mb-1 truncate">
                                {{ $recipe->Name }}
                            </a>

                            @php $avg = $recipe->ratings()->avg('Score'); @endphp
                            <div class="text-black text-xs">
                                @if($avg)
                                    @for ($i = 1; $i <= 5; $i++)
                                        {!! $i <= round($avg) ? '⭐' : '☆' !!}
                                    @endfor
                                @else
                                    <span class="text-gray-600">No ratings yet</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


            <!-- Sidebar Filters -->
            <div class="w-64 space-y-4 sticky top-24">
                <form method="GET" action="{{ route('recipes.index') }}" class="space-y-3 text-sm">
                    @csrf

                    <!-- Time Filter -->
                    <select name="time" class="w-full border border-gray-300 bg-white rounded p-2 mb-4">
                        <option value="">All Times</option>
                        <option value="0-10" {{ ($selectedTime ?? '') == '0-10' ? 'selected' : '' }}>0–10 min</option>
                        <option value="10-20" {{ ($selectedTime ?? '') == '10-20' ? 'selected' : '' }}>10–20 min</option>
                        <option value="20-40" {{ ($selectedTime ?? '') == '20-40' ? 'selected' : '' }}>20–40 min</option>
                        <option value="40-60" {{ ($selectedTime ?? '') == '40-60' ? 'selected' : '' }}>40–60 min</option>
                        <option value="60+" {{ ($selectedTime ?? '') == '60+' ? 'selected' : '' }}>60+ min</option>
                    </select>

                    <!-- Category Filters -->
                    @foreach ($categoryTypes as $type)
                        <label class="block text-sm font-medium text-gray-700 mt-4">
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
                    <label class="block text-sm font-medium text-gray-700 mt-4">Ingredients</label>
                    <select name="ingredients[]" multiple class="tom-select w-full">
                        @foreach ($ingredients as $ingredient)
                            <option value="{{ $ingredient->IngredientID }}"
                                @if(in_array($ingredient->IngredientID, $selectedIngredients ?? [])) selected @endif>
                                {{ $ingredient->Name }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="mt-4 bg-green-700 text-white border border-green-900 px-4 py-2 rounded w-full hover:bg-green-800">
                        Apply Filters
                    </button>


                    <a href="{{ route('recipes.index') }}" class="inline-block mt-2 text-sm text-red-600 hover:underline">
                        Reset Filters
                    </a>

                    <p class="text-s text-gray-500 mt-6">
                        Please be respectful and considerate when sharing or reviewing recipes. Let's keep our community welcoming for everyone. For more rules, please check our <a href="{{ route('rules') }}" class="text-blue-600 hover:underline">Rules</a>.
                        If you have any questions or need assistance, feel free to <a href="{{ route('contact') }}" class="text-blue-600 hover:underline">Contact Us</a>.
                        Thank you for being a part of our community!
                    </p>
                </form>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $recipes->appends(request()->query())->links() }}
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

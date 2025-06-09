<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            All Recipes
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <div class="flex justify-between items-start">
            {{-- Recipe Grid --}}
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

                        {{-- Star Rating --}}
                        @php
                            $avg = $recipe->ratings()->avg('Score');
                        @endphp
                        <div class="text-sm text-center text-gray-700 dark:text-gray-300">
                            @if($avg)
                                @for ($i = 1; $i <= 5; $i++)
                                    @if($i <= round($avg))
                                        ⭐
                                    @else
                                        ☆
                                    @endif
                                @endfor
                                <span class="text-xs text-gray-500">({{ number_format($avg, 1) }})</span>
                            @else
                                <span class="text-xs text-gray-500">No ratings yet</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Sidebar Filters (to be implemented) --}}
            <div class="w-64 ml-8 space-y-4">
                <h3 class="text-md font-semibold">Filter</h3>
                <select class="w-full border rounded p-1">
                    <option disabled selected>Food Type</option>
                </select>
                <select class="w-full border rounded p-1">
                    <option disabled selected>Ingredients</option>
                </select>
                <select class="w-full border rounded p-1">
                    <option disabled selected>Cuisine</option>
                </select>
                <select class="w-full border rounded p-1">
                    <option disabled selected>Time to Prepare</option>
                </select>
                <select class="w-full border rounded p-1">
                    <option disabled selected>Diet or Lifestyle</option>
                </select>
                <select class="w-full border rounded p-1">
                    <option disabled selected>Nutritional Value</option>
                </select>

                <p class="text-xs mt-4">
                    <strong>Be polite</strong> writing commentaries!<br>
                    <span class="text-red-600">We will NOT accept any bullying or harassment.</span>
                </p>
            </div>
        </div>
    </div>
</x-app-layout>

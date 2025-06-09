<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">My Dashboard</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto space-y-8">
        <!-- User Info -->
        <div class="flex items-center space-x-4">
            @if($user->Avatar)
                <img src="{{ asset('storage/' . $user->Avatar) }}" class="w-12 h-12 rounded-5 object-cover border">
            @else
                <div class="w-12 h-12 rounded-5 bg-gray-300"></div>
            @endif

            <div>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $user->name }}</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300">{{ $user->email }}</p>
                @if($user->Bio)
                    <p class="mt-2 text-gray-700 dark:text-gray-400">{{ $user->Bio }}</p>
                @endif
            </div>
        </div>

        <!-- User's Recipes -->
        <div>
            <h4 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">My Recipes</h4>

            @if($recipes->count())
                <div class="grid gap-6 sm:grid-cols-2">
                    @foreach ($recipes as $recipe)
                        <a href="{{ route('recipes.show', $recipe) }}" class="block p-4 bg-white dark:bg-gray-800 border rounded hover:shadow">
                            <h5 class="text-lg font-semibold">{{ $recipe->Name }}</h5>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                Time: {{ $recipe->Time }} min
                            </p>
                            @if ($recipe->ratings_avg_score)
                                <p class="text-sm text-yellow-500">★ {{ number_format($recipe->ratings_avg_score, 1) }}/5</p>
                            @else
                                <p class="text-sm text-gray-400 italic">No ratings yet</p>
                            @endif
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400">You haven’t created any recipes yet.</p>
            @endif
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-white">My Dashboard</h2>
    </x-slot>

    <div class="py-10 max-w-5xl mx-auto space-y-10 px-4">
        <!-- User Info Card -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex items-center space-x-6">
            @if($user->Avatar)
                <img src="{{ asset('storage/' . $user->Avatar) }}" alt="Avatar" class="w-16 h-16 rounded-full object-cover border-2 border-gray-300 dark:border-gray-700">
            @else
                <div class="w-16 h-16 rounded-full bg-gray-300 dark:bg-gray-700"></div>
            @endif

            <div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                @if($user->Bio)
                    <p class="mt-2 text-gray-700 dark:text-gray-300 text-sm">{{ $user->Bio }}</p>
                @endif
            </div>
        </div>

        <!-- Recent Comments -->
        <div class="space-y-4">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Your Recent Comments</h3>
            <ul class="space-y-2">
                @forelse($recentComments as $comment)
                    <li class="text-gray-700 dark:text-gray-300">
                        On 
                        <a href="{{ route('recipes.show', $comment->recipe->RecipeID) }}" class="text-blue-600 hover:underline">
                            {{ $comment->recipe->Name }}
                        </a>: 
                        <span class="italic">"{{ Str::limit($comment->Content, 50) }}"</span> 
                        <span class="text-sm text-gray-500">({{ $comment->created_at ? $comment->created_at->diffForHumans() : 'Unknown time' }})</span>
                    </li>
                @empty
                    <li class="text-gray-500 italic">No comments added yet.</li>
                @endforelse
            </ul>
        </div>

        <!-- Recent Ratings -->
        <div class="space-y-4">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Your Recent Ratings</h3>
            <ul class="space-y-2">
                @forelse($recentRatings as $rating)
                    <li class="text-gray-700 dark:text-gray-300">
                        Rated 
                        <a href="{{ route('recipes.show', $rating->recipe->RecipeID) }}" class="text-blue-600 hover:underline">
                            {{ $rating->recipe->Name }}
                        </a>: 
                        <span class="text-yellow-500 font-semibold">{{ $rating->Score }}/5</span> 
                        <span class="text-sm text-gray-500">({{ $rating->created_at ? $rating->created_at->diffForHumans() : 'Unknown time' }})</span>
                    </li>
                @empty
                    <li class="text-gray-500 italic">No ratings given yet.</li>
                @endforelse
            </ul>
        </div>

        <!-- User's Recipes -->
        <div>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">My Recipes</h3>

            @if($recipes->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach ($recipes as $recipe)
                        <a href="{{ route('recipes.show', $recipe) }}" class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow hover:shadow-lg transition border border-gray-200 dark:border-gray-700 block">
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-1">{{ $recipe->Name }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Time: {{ $recipe->Time }} min</p>
                            @if ($recipe->ratings_avg_score)
                                <p class="mt-1 text-sm text-yellow-500">★ {{ number_format($recipe->ratings_avg_score, 1) }}/5</p>
                            @else
                                <p class="mt-1 text-sm text-gray-400 italic">No ratings yet</p>
                            @endif
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400 italic">You haven’t created any recipes yet.</p>
            @endif
        </div>
    </div>
</x-app-layout>


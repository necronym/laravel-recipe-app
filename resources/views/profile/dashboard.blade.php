<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">My Dashboard</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Panel: User Info -->
        <aside class="lg:col-span-1 space-y-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow">
                @if($user->Avatar)
                    <img src="{{ asset('storage/' . $user->Avatar) }}" class="w-32 h-32 rounded-full object-cover border mb-4">
                @else
                    <div class="w-32 h-32 rounded-full bg-gray-300 mb-4"></div>
                @endif

                <div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                    <p class="text-base text-gray-700 dark:text-gray-300 mt-1">{{ $user->email }}</p>
                    <p class="text-base text-gray-700 dark:text-gray-300 mt-1">
                        Role:
                        <span class="font-medium">
                            @if ($user->RoleID === 1)
                                Admin
                            @else
                                User
                            @endif
                        </span>
                    </p>
                </div>

                @if($user->Bio)
                    <div class="mt-6">
                        <h4 class="text-base font-semibold text-gray-800 dark:text-gray-200">Bio</h4>
                        <p class="text-base text-gray-700 dark:text-gray-300 mt-2 whitespace-pre-line break-words leading-relaxed">
                            {{ $user->Bio }}
                        </p>
                    </div>
                @endif
            </div>
        </aside>

        <!-- Right Panel: Activity + Recipes -->
        <section class="lg:col-span-2 space-y-8">
            <!-- Recent Comments -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Your Recent Comments</h3>
                <ul class="list-disc ml-6 text-gray-700 dark:text-gray-300">
                    @forelse($recentComments as $comment)
                        <li>
                            On 
                            <a href="{{ route('recipes.show', $comment->recipe->RecipeID) }}" class="text-blue-600 hover:underline">
                                {{ $comment->recipe->Name }}
                            </a>: "{{ Str::limit($comment->Content, 50) }}" 
                            <span class="text-sm text-gray-500">({{ $comment->created_at?->diffForHumans() }})</span>
                        </li>
                    @empty
                        <li>No comments added yet.</li>
                    @endforelse
                </ul>
            </div>

            <!-- Recent Ratings -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Your Recent Ratings</h3>
                <ul class="list-disc ml-6 text-gray-700 dark:text-gray-300">
                    @forelse($recentRatings as $rating)
                        <li>
                            Rated 
                            <a href="{{ route('recipes.show', $rating->recipe->RecipeID) }}" class="text-blue-600 hover:underline">
                                {{ $rating->recipe->Name }}
                            </a>:
                            {{ $rating->Score }}/5
                        </li>
                    @empty
                        <li>No ratings given yet.</li>
                    @endforelse
                </ul>
            </div>

            <!-- User's Recipes (Paginated) -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow">
                <h4 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">My Recipes</h4>

                @if($recipes->count())
                    <div class="grid gap-6 sm:grid-cols-2">
                        @foreach ($recipes as $recipe)
                            <a href="{{ route('recipes.show', $recipe) }}" class="block p-4 bg-gray-50 dark:bg-gray-700 border rounded hover:shadow">
                                <h5 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $recipe->Name }}</h5>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Time: {{ $recipe->Time }} min</p>
                                @if ($recipe->ratings_avg_score)
                                    <p class="text-sm text-yellow-500">★ {{ number_format($recipe->ratings_avg_score, 1) }}/5</p>
                                @else
                                    <p class="text-sm text-gray-400 italic">No ratings yet</p>
                                @endif
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $recipes->links() }}
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400">You haven’t created any recipes yet.</p>
                @endif
            </div>
        </section>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-800">
            {{ $user->name }}'s Profile
        </h2>
        <x-report-button type="user" :id="$user->id" />

        @auth
            @if(auth()->user()->RoleID === 1 && auth()->id() !== $user->id)
                <form method="POST" action="{{ route('admin.ban', $user->id) }}" class="mt-2" onsubmit="return confirm('Are you sure you want to ban this user? This will delete their account, recipes, comments, and ratings.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline">
                        Ban User
                    </button>
                </form>
            @endif
        @endauth
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left: User Info -->
        <aside class="lg:col-span-1 space-y-4">
            @if($user->Avatar)
                <img src="{{ asset('storage/' . $user->Avatar) }}" class="w-[300px] h-[300px] object-cover rounded border">
            @endif

            <div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h3>
                <p class="text-base text-gray-800 mt-1">{{ $user->email }}</p>
                <p class="text-base text-gray-800 mt-1">
                    Role:
                    <span class="font-semibold">
                        {{ $user->RoleID === 1 ? 'Admin' : 'User' }}
                    </span>
                </p>
            </div>

            @if($user->Bio)
                <div class="mt-4">
                    <h4 class="text-lg font-semibold text-gray-800">Bio</h4>
                    <p class="text-base text-gray-800 whitespace-pre-line break-words leading-relaxed mt-1">
                        {{ $user->Bio }}
                    </p>
                </div>
            @endif
        </aside>

        <!-- Right: Recipes -->
        <section class="lg:col-span-2 space-y-6">
            <h3 class="text-2xl font-semibold text-gray-800">Recipes by {{ $user->name }}</h3>
            @if($recipes->count())
                <div class="space-y-4">
                    @foreach($recipes as $recipe)
                        <a href="{{ route('recipes.show', $recipe) }}" class="block p-4 bg-white dark:bg-gray-200 border rounded hover:shadow">
                            <h5 class="text-xl font-semibold text-gray-800 truncate">{{ $recipe->Name }}</h5>
                            <p class="text-base text-gray-800">Time: {{ $recipe->Time }} min</p>
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
                <p class="text-base text-gray-800">No recipes yet.</p>
            @endif
        </section>
    </div>
</x-app-layout>

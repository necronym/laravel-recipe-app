<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">
                    {{ $user->name }}'s Profile
                </h2>
            </div>
            <div class="flex items-center gap-4">
                <x-report-button type="user" :id="$user->id" />

                @auth
                    @if(auth()->user()->RoleID === 1 && auth()->id() !== $user->id)
                        <form method="POST" action="{{ route('admin.ban', $user->id) }}" 
                            onsubmit="return confirm('Are you sure you want to ban this user? This will delete their account, recipes, comments, and ratings.')" 
                            class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-red-600 hover:underline">
                                Ban User
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto space-y-10">
        <!-- Avatar and Bio -->
        <div class="flex items-center gap-6">
            @if($user->Avatar)
                <img src="{{ asset('storage/' . $user->Avatar) }}" class="w-24 h-24 rounded-full border shadow-sm object-cover">
            @else
                <div class="w-24 h-24 rounded-full bg-gray-300"></div>
            @endif

            <div>
                @if($user->Bio)
                    <p class="text-gray-700 dark:text-gray-300 text-base">{{ $user->Bio }}</p>
                @else
                    <p class="text-gray-500 italic">This user hasn't added a bio.</p>
                @endif
            </div>
        </div>

        <!-- Recipes -->
        <div>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-3">Recipes by {{ $user->name }}</h3>

            @if($user->recipes->count())
                <ul class="space-y-2 list-disc list-inside text-blue-600 dark:text-blue-400">
                    @foreach($user->recipes as $recipe)
                        <li>
                            <a href="{{ route('recipes.show', $recipe) }}" class="hover:underline">
                                {{ $recipe->Name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500 dark:text-gray-400 italic">This user hasn't published any recipes yet.</p>
            @endif
        </div>
    </div>
</x-app-layout>

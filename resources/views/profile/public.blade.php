<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ $user->name }}'s Profile
        </h2>
        <x-report-button type="user" :id="$user->id" />

        @auth
        @if(auth()->user()->RoleID === 1 && auth()->id() !== $user->id)
            <form method="POST" action="{{ route('admin.ban', $user->id) }}" onsubmit="return confirm('Are you sure you want to ban this user? This will delete their account, recipes, comments, and ratings.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:underline">
                    Ban User
                </button>
            </form>
        @endif
    @endauth
    </x-slot>

    <div class="py-6 space-y-4 max-w-3xl">
        @if($user->Avatar)
            <img src="{{ asset('storage/' . $user->Avatar) }}" class="w-24 h-24 rounded-full">
        @endif

        <p class="text-gray-700 dark:text-gray-300">{{ $user->Bio }}</p>

        <h3 class="text-lg font-semibold mt-6">Recipes by {{ $user->name }}</h3>
        @if($user->recipes->count())
            <ul class="list-disc ml-6">
                @foreach($user->recipes as $recipe)
                    <li>
                        <a href="{{ route('recipes.show', $recipe) }}" class="text-blue-600 hover:underline">
                            {{ $recipe->Name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <p>No recipes yet.</p>
        @endif
    </div>
</x-app-layout>

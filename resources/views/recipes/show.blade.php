<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ $recipe->Name }}
        </h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            By 
            <a href="{{ route('user.profile', $recipe->user->id) }}" class="text-blue-600 hover:underline">
                {{ $recipe->user->name }}
            </a>
        </p>
    </x-slot>

    <div class="py-6 space-y-4 max-w-3xl mx-auto px-4">
        @if($recipe->Image)
            <img src="{{ asset('storage/recipes/' . $recipe->Image) }}" width="400" class="rounded shadow" alt="{{ $recipe->Name }}">
        @endif

        <!-- Recipe Instructions -->
        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $recipe->Instructions }}</p>

        <!-- Recipe Rating -->
        <h3 class="text-lg font-semibold mt-6">Rating</h3>
        @php
            $average = $recipe->ratings()->avg('Score');
            $userRating = auth()->check() ? $recipe->ratings()->where('UserID', auth()->id())->first() : null;
        @endphp

        <p>Average rating: {{ $average !== null ? number_format($average, 1) : 'N/A' }} / 5</p>

        @auth
            @if(!$userRating)
                <form method="POST" action="{{ route('ratings.store', $recipe->RecipeID) }}">
                    @csrf
                    <label for="Score">Rate this recipe:</label>
                    <select name="Score" id="Score" class="border rounded p-1">
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                        @endfor
                    </select>
                    <button type="submit" class="ml-2 px-2 py-1 bg-blue-500 text-white rounded">Submit</button>
                </form>
            @else
                <p>Your rating: {{ $userRating->Score }} / 5</p>

                @if(Auth::id() === $userRating->UserID)
                    <form method="POST" action="{{ route('ratings.store', $recipe->RecipeID) }}">
                        @csrf
                        <label for="Score">Update your rating:</label>
                        <select name="Score" id="Score" class="border rounded p-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ $userRating->Score == $i ? 'selected' : '' }}>
                                    {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                </option>
                            @endfor
                        </select>
                        <button type="submit" class="ml-2 px-2 py-1 bg-yellow-500 text-white rounded">Update</button>
                    </form>
                @endif

                @if(Auth::id() === $userRating->UserID || Auth::user()->RoleID === 1)
                    <form method="POST" action="{{ route('ratings.destroy', $userRating->RatingID) }}" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Delete Rating</button>
                    </form>
                @endif
            @endif
        @else
            <p class="text-sm text-gray-600">Login to rate this recipe.</p>
        @endauth

        <!-- Recipe Time -->
        <p><strong>Time:</strong> {{ $recipe->Time }} minutes</p>

        <!-- Recipe Categories -->
        @if($recipe->categories->count())
            <div class="mt-4">
                <h4 class="text-md font-semibold">Categories</h4>
                <ul class="list-disc ml-5 text-gray-700 dark:text-gray-300">
                    @foreach ($recipe->categories->groupBy('categoryType.Name') as $type => $group)
                        <li>
                            <strong>{{ $type }}:</strong>
                            {{ $group->pluck('Name')->join(', ') }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Recipe Ingredients -->
        @if($recipe->ingredients->count())
            <div class="mt-4">
                <h4 class="text-md font-semibold">Ingredients</h4>
                <ul class="list-disc ml-5 text-gray-700 dark:text-gray-300">
                    @foreach($recipe->ingredients as $ingredient)
                        <li>{{ $ingredient->Name }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Recipe Reporting -->
        <x-report-button type="recipe" :id="$recipe->RecipeID" />

        <!-- Recipe Edit or Delete -->
        @auth
            @if (Auth::id() === $recipe->UserID)
                <a href="{{ route('recipes.edit', $recipe) }}" class="text-blue-600 hover:underline">Edit</a>
            @endif
            @if (Auth::id() === $recipe->UserID || Auth::user()->RoleID === 1)
                <form method="POST" action="{{ route('recipes.destroy', $recipe) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline ml-4">Delete</button>
                </form>
            @endif
        @endauth
    </div>

    <!-- Comments Section -->
    <div class="mt-8 max-w-3xl mx-auto px-4">
        <h3 class="text-lg font-semibold mb-4">Comments</h3>

        @auth
            <form method="POST" action="{{ route('comments.store') }}" class="mb-6">
                @csrf
                <input type="hidden" name="RecipeID" value="{{ $recipe->RecipeID }}">

                <textarea name="Content" rows="3" required class="w-full p-2 border rounded dark:bg-gray-800 dark:text-white"
                          placeholder="Write your comment..."></textarea>

                <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Add Comment
                </button>
            </form>
        @else
            <p class="text-sm text-gray-500">Please <a href="{{ route('login') }}" class="text-blue-600 hover:underline">login</a> to comment.</p>
        @endauth

        @forelse ($recipe->comments as $comment)
            <div class="mb-4 p-3 border border-gray-300 rounded dark:border-gray-700">
                <p class="text-sm text-gray-800 dark:text-gray-200">
                    <strong>
                        <a href="{{ route('user.profile', $comment->user->id) }}" class="text-blue-600 hover:underline">
                            {{ $comment->user->name ?? 'Unknown' }}
                        </a>
                    </strong>: {{ $comment->Content }}
                </p>
                <p class="text-xs text-gray-500">{{ $comment->created_at->format('M d, Y H:i') }}</p>
                <x-report-button type="comment" :id="$comment->CommentID" />

                @auth
                    @if (Auth::id() === $comment->UserID || Auth::user()->RoleID === 1)
                        <div class="mt-2 space-x-2">
                            @if (Auth::id() === $comment->UserID)
                                <a href="{{ route('comments.edit', $comment->CommentID) }}" class="text-blue-600 text-sm hover:underline">Edit</a>
                            @endif

                            <form method="POST" action="{{ route('comments.destroy', $comment->CommentID) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 text-sm hover:underline">Delete</button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        @empty
            <p class="text-sm text-gray-500">No comments yet. Be the first to comment!</p>
        @endforelse
    </div>
</x-app-layout>

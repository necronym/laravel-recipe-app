<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ $recipe->Name }}
        </h2>
        <p class="text-sm text-gray-600">
            By 
            <a href="{{ route('user.profile', $recipe->user->id) }}" class="text-blue-600 hover:underline">
                {{ $recipe->user->name }}
            </a>
        </p>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-6">
        <div class="flex gap-8">
            <!-- Left: Image & Info -->
            <div class="w-[600px]">
                @auth
                    @if (Auth::id() === $recipe->UserID)
                        <div class="mb-2 flex gap-4">
                            <a href="{{ route('recipes.edit', $recipe) }}" class="bg-amber-100 border border-amber-300 text-black px-3 py-1 rounded">Edit</a>
                            @if (Auth::id() === $recipe->UserID || Auth::user()->RoleID === 1)
                                <form method="POST" action="{{ route('recipes.destroy', $recipe) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-800 text-white px-3 py-1 rounded">Delete</button>
                                </form>
                            @endif
                        </div>
                    @endif
                @endauth

                @if($recipe->Image)
                    <div class="rounded shadow overflow-hidden mb-4">
                        <img src="{{ asset('storage/recipes/' . $recipe->Image) }}" class="w-full h-auto" />
                    </div>
                @endif

                <!-- Recipe Instructions -->
                <div class="text-gray-800 whitespace-pre-line w-[600px] break-words mt-4">
                    <h3 class="text-lg font-semibold mb-2">Instructions</h3>
                    <p>{{ $recipe->Instructions }}</p>
                </div>

                <!-- Time -->
                <p class="mt-4"><strong>Time:</strong> {{ $recipe->Time }} minutes</p>

                <!-- Categories -->
                @if($recipe->categories->count())
                    <div class="mt-4">
                        <h4 class="text-md font-semibold">Categories</h4>
                        <ul class="list-disc ml-5 text-gray-800">
                            @foreach ($recipe->categories->groupBy('categoryType.Name') as $type => $group)
                                <li>
                                    <strong>{{ $type }}:</strong>
                                    {{ $group->pluck('Name')->join(', ') }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Ingredients -->
                @if($recipe->ingredients->count())
                    <div class="mt-4">
                        <h4 class="text-md font-semibold">Ingredients</h4>
                        <ul class="list-disc ml-5 text-gray-800">
                            @foreach($recipe->ingredients as $ingredient)
                                <li>{{ $ingredient->Name }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Right: Rating & Comments -->
            <div class="flex-1 max-w-xl">
                <h3 class="text-lg font-semibold">Rating</h3>
                @php
                    $average = $recipe->ratings()->avg('Score');
                    $userRating = auth()->check() ? $recipe->ratings()->where('UserID', auth()->id())->first() : null;
                @endphp

                <div class="flex items-center gap-2 text-gray-800 text-sm">
                    @if($average)
                        <div class="flex text-yellow-500">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($average >= $i)
                                    ⭐
                                @else
                                    ☆
                                @endif
                            @endfor
                        </div>
                        <span>({{ number_format($average, 1) }} / 5)</span>
                    @else
                        <span class="text-gray-500">No ratings yet</span>
                    @endif
                </div>

                @if(auth()->check())
                    @if(!$userRating)
                        <form method="POST" action="{{ route('ratings.store', $recipe->RecipeID) }}">
                            @csrf
                            <label for="Score">Rate this recipe:</label>
                            <select name="Score" id="Score" class="border rounded p-1 w-[100px]">
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                            <button type="submit" class="ml-2 px-2 py-1 bg-blue-600 text-white rounded">Submit</button>
                        </form>
                    @else
                        <p>Your rating: {{ $userRating->Score }} / 5</p>
                        <form method="POST" action="{{ route('ratings.store', $recipe->RecipeID) }}">
                            @csrf
                            <label for="Score">Update your rating:</label>
                            <select name="Score" id="Score" class="border rounded p-1 w-[100px]">
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ $userRating->Score == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                            <button type="submit" class="ml-2 px-2 py-1 bg-yellow-500 text-white rounded">Update</button>
                        </form>

                        <form method="POST" action="{{ route('ratings.destroy', $userRating->RatingID) }}" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete Rating</button>
                        </form>
                    @endif
                @else
                    <p class="text-base text-gray-600">Login to rate this recipe.</p>
                @endif

                <div class="mt-4">
                    <x-report-button type="recipe" :id="$recipe->RecipeID" />
                </div>

                <!-- Comments -->
                <div class="mt-10">
                    <h3 class="text-lg font-semibold mb-4">Comments</h3>
                    @auth
                        <form method="POST" action="{{ route('comments.store') }}" class="mb-6">
                            @csrf
                            <input type="hidden" name="RecipeID" value="{{ $recipe->RecipeID }}">
                            <textarea name="Content" rows="3" required class="w-full p-2 border rounded bg-white text-black" placeholder="Write your comment..."></textarea>
                            <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Add Comment
                            </button>
                        </form>
                    @endauth

                    @foreach ($comments as $comment)
                        <div class="mb-4 p-3 w-[500px] break-words border border-gray-300 rounded dark:border-gray-700">
                            <p class="text-base text-gray-800 leading-relaxed">
                                <strong>
                                    <a href="{{ route('user.profile', $comment->user->id) }}" class="text-blue-600 hover:underline">
                                        {{ $comment->user->name ?? 'Unknown' }}
                                    </a>
                                </strong>: {{ $comment->Content }}
                            </p>
                            <p class="text-xs text-gray-500">{{ $comment->created_at }}</p>
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
                    @endforeach

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $comments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

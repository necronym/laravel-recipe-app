<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ $recipe->Name }}
        </h2>
    </x-slot>

    <div class="flex flex-col lg:flex-row px-6 py-10 gap-8">
        <!-- Main Recipe Content -->
        <div class="flex-1 max-w-4xl mx-auto space-y-6">
            @if($recipe->Image)
                <img src="{{ asset('storage/recipes/' . $recipe->Image) }}" alt="{{ $recipe->Name }}"
                     class="w-full rounded-lg shadow-md">
            @endif

            <div class="text-gray-800 dark:text-gray-300 whitespace-pre-line text-lg leading-relaxed">
                {{ $recipe->Instructions }}
            </div>

            <p class="text-gray-600 dark:text-gray-400"><strong>Time:</strong> {{ $recipe->Time }} minutes</p>

            @auth
                @if(Auth::id() === $recipe->UserID || Auth::user()->RoleID === 1)
                    <div class="flex gap-4">
                        <a href="{{ route('recipes.edit', $recipe) }}"
                           class="text-blue-600 hover:underline">Edit</a>

                        <form method="POST" action="{{ route('recipes.destroy', $recipe) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </div>
                @endif
            @endauth

            <hr class="my-6 border-gray-400 dark:border-gray-700">

            <!-- Comments Section -->
            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Comments</h3>

            @foreach($recipe->comments as $comment)
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 mb-4 shadow-sm">
                    <p class="text-gray-900 dark:text-white font-medium">{{ $comment->user->name }} said:</p>
                    <p class="text-gray-700 dark:text-gray-300 mt-1">{{ $comment->Content }}</p>
                    <p class="text-sm text-gray-500 mt-2">{{ $comment->created_at->format('F j, Y \a\t g:i A') }}</p>

                    @auth
                        @if(Auth::id() === $comment->UserID || Auth::user()->RoleID === 1)
                            <div class="mt-2 flex gap-3">
                                <form method="POST" action="{{ route('comments.destroy', $comment->CommentID) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline text-sm">Delete</button>
                                </form>
                                @if(Auth::id() === $comment->UserID)
                                    <a href="{{ route('comments.edit', $comment->CommentID) }}"
                                       class="text-blue-600 hover:underline text-sm">Edit</a>
                                @endif
                            </div>
                        @endif
                    @endauth
                </div>
            @endforeach

            @auth
                <form method="POST" action="{{ route('comments.store') }}" class="mt-8 space-y-4">
                    @csrf
                    <textarea name="Text" rows="3" class="w-full p-4 border rounded-md dark:bg-gray-800 dark:text-white dark:border-gray-600 focus:ring focus:ring-green-500" placeholder="Leave a comment..." required></textarea>
                    <input type="hidden" name="RecipeID" value="{{ $recipe->RecipeID }}">
                    <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded-md hover:bg-green-700 shadow">Post Comment</button>
                </form>
            @endauth

            @guest
                <p class="text-sm text-gray-600 mt-6">Please <a href="{{ route('login') }}" class="text-blue-600 hover:underline">login</a> to comment.</p>
            @endguest
        </div>

        <!-- Floating Sidebar Filters (only for wider screens) -->
        <div class="hidden lg:block w-64 sticky top-24 h-fit self-start">
            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow border dark:border-gray-700">
                <h4 class="text-md font-semibold text-gray-700 dark:text-gray-100 mb-4">Filter</h4>

                <div class="space-y-3">
                    <select class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
                        <option>Food Type</option>
                        <!-- more options -->
                    </select>

                    <select class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
                        <option>Ingredients</option>
                    </select>

                    <select class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
                        <option>Cuisine</option>
                    </select>

                    <select class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
                        <option>Time to Prepare</option>
                    </select>

                    <select class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
                        <option>Diet or Lifestyle</option>
                    </select>

                    <select class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
                        <option>Nutritional value</option>
                    </select>
                </div>

                <div class="text-xs text-gray-500 dark:text-gray-400 mt-6">
                    <p><span class="text-red-600 font-bold">Reminder:</span> Be polite when commenting!</p>
                    <p>We do <strong>not accept</strong> bullying or harassment.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

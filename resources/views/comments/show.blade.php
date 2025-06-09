<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ $recipe->Name }}
        </h2>
    </x-slot>

    <div class="py-6 space-y-4 max-w-3xl">
        @if($recipe->Image)
            <img src="{{ asset('storage/recipes/' . $recipe->Image) }}" width="400" class="rounded shadow">
        @endif

        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $recipe->Instructions }}</p>
        <p><strong>Time:</strong> {{ $recipe->Time }} minutes</p>

        @auth
            @if(Auth::id() === $recipe->UserID || Auth::user()->RoleID === 1)
                <a href="{{ route('recipes.edit', $recipe) }}" class="text-blue-600 hover:underline">Edit</a>

                <form method="POST" action="{{ route('recipes.destroy', $recipe) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline ml-4">Delete</button>
                </form>
            @endif
        @endauth

        <hr class="my-6">

        <h3 class="text-lg font-semibold">Comments</h3>

        @foreach($recipe->comments as $comment)
            <div class="border rounded p-3 my-2 bg-white dark:bg-gray-800">
                <p class="text-gray-800 dark:text-gray-200"><strong>{{ $comment->user->name }}</strong> said:</p>
                <p class="text-gray-700 dark:text-gray-300">{{ $comment->Content }}</p>
                <p class="text-sm text-gray-500">{{ $comment->created_at }}</p>

                @auth
                    @if(Auth::id() === $comment->UserID || Auth::user()->RoleID === 1)
                        <form method="POST" action="{{ route('comments.destroy', $comment->CommentID) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline text-sm">Delete</button>
                        </form>
                        @if(Auth::id() === $comment->UserID)
                            <a href="{{ route('comments.edit', $comment->CommentID) }}" class="text-blue-600 hover:underline text-sm ml-2">Edit</a>
                        @endif
                    @endif
                @endauth
            </div>
        @endforeach

        @auth
            <form method="POST" action="{{ route('comments.store') }}" class="mt-6">
                @csrf
                <textarea name="Text" rows="3" class="w-full p-2 border rounded dark:bg-gray-800 dark:text-white" placeholder="Leave a comment..." required></textarea>
                <input type="hidden" name="RecipeID" value="{{ $recipe->RecipeID }}">
                <button type="submit" class="mt-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Post Comment</button>
            </form>
        @endauth

        @guest
            <p class="text-sm text-gray-600 mt-4">Please <a href="{{ route('login') }}" class="text-blue-600 hover:underline">login</a> to comment.</p>
        @endguest
    </div>
</x-app-layout>

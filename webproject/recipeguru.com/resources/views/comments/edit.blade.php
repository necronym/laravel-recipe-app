<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Edit Comment</h2>
    </x-slot>

    <div class="py-10 flex justify-center">
        <div class="w-full max-w-xl">
            <form method="POST" action="{{ route('comments.update', $comment->CommentID) }}">
                @csrf
                @method('PUT')

                <textarea 
                    name="Content" 
                    rows="4" 
                    class="w-full p-3 border rounded bg-white text-gray-800" 
                    required>{{ $comment->Content }}</textarea>

                <div class="mt-4 flex justify-between items-center">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Update
                    </button>
                    <a href="{{ route('recipes.show', $comment->RecipeID) }}" class="text-gray-600 hover:underline">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

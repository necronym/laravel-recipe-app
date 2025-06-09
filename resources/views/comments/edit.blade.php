<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Edit Comment</h2>
    </x-slot>

    <div class="py-6 max-w-xl">
        <form method="POST" action="{{ route('comments.update', $comment->CommentID) }}">
            @csrf
            @method('PUT')

            <textarea name="Content" rows="4" class="w-full p-2 border rounded dark:bg-gray-800 dark:text-white" required>{{ $comment->Content }}</textarea>

            <div class="mt-4">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
                <a href="{{ route('recipes.show', $comment->RecipeID) }}" class="ml-4 text-gray-600 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>

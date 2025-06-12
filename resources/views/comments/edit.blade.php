<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Edit Comment</h2>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8 flex justify-center">
        <div class="w-full max-w-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow p-6">
            <form method="POST" action="{{ route('comments.update', $comment->CommentID) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="Content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Edit your comment:</label>
                    <textarea name="Content" id="Content" rows="5"
                        class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 resize-y"
                        required>{{ $comment->Content }}</textarea>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('recipes.show', $comment->RecipeID) }}"
                       class="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white underline">
                        Cancel
                    </a>

                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md shadow transition">
                        Update Comment
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

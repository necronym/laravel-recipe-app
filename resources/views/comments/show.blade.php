<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Edit Comment on "{{ $recipe->Name }}"
        </h2>
    </x-slot>

    <div class="py-10 px-8">
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 md:p-10 max-w-5xl mx-auto">
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Your Original Comment:</h3>
                <p class="text-gray-700 dark:text-gray-300 border p-4 rounded bg-gray-50 dark:bg-gray-800">
                    {{ $comment->Content }}
                </p>
            </div>

            <form method="POST" action="{{ route('comments.update', $comment->CommentID) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="Content" class="block text-base font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Edit Your Comment:
                    </label>
                    <textarea name="Content" rows="5"
                        class="w-full p-4 border rounded-lg dark:bg-gray-800 dark:text-white dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"
                        required>{{ old('Content', $comment->Content) }}</textarea>
                </div>

                <div class="flex justify-end gap-4 pt-4">
                    <a href="{{ route('recipes.show', $recipe->RecipeID) }}"
                        class="px-5 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg shadow">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow">
                        Update Comment
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-black">
            Report Management
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <!-- Recipe Reports -->
        <div class="mb-10">
            <h3 class="text-lg font-bold mb-3 text-black">Reported Recipes</h3>
            @forelse($recipeReports as $report)
                <div class="border border-gray-300 p-4 mb-3 rounded shadow-sm bg-gray-100">
                    <p class="text-black">
                        <strong>Recipe:</strong>
                        <a href="{{ route('recipes.show', $report->recipe) }}" class="text-blue-700 underline">
                            {{ $report->recipe->Name }}
                        </a>
                    </p>
                    <p class="text-sm text-black mt-1">{{ $report->Reason }}</p>

                    <form method="POST" action="{{ route('admin.reports.dismiss', $report->ReportID) }}" class="mt-2">
                        @csrf
                        <button type="submit" class="text-sm px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                            Dismiss
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-sm text-black">No reported recipes.</p>
            @endforelse
        </div>

        <!-- Comment Reports -->
        <div class="mb-10">
            <h3 class="text-lg font-bold mb-3 text-black">Reported Comments</h3>
            @forelse($commentReports as $report)
                <div class="border border-gray-300 p-4 mb-3 rounded shadow-sm bg-gray-100">
                    <p class="text-black">
                        <strong>Comment:</strong> "{{ $report->comment->Content }}"
                        <br>
                        <strong>Recipe:</strong>
                        <a href="{{ route('recipes.show', $report->comment->recipe->RecipeID) }}" class="text-blue-700 underline">
                            {{ $report->comment->recipe->Name }}
                        </a>
                    </p>
                    <p class="text-sm text-black mt-1">{{ $report->Reason }}</p>

                    <form method="POST" action="{{ route('admin.reports.dismiss', $report->ReportID) }}" class="mt-2">
                        @csrf
                        <button type="submit" class="text-sm px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                            Dismiss
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-sm text-black">No reported comments.</p>
            @endforelse
        </div>

        <!-- User Reports -->
        <div>
            <h3 class="text-lg font-bold mb-3 text-black">Reported Users</h3>
            @forelse($userReports as $report)
                <div class="border border-gray-300 p-4 mb-3 rounded shadow-sm bg-gray-100">
                    <p class="text-black">
                        <strong>User:</strong>
                        <a href="{{ route('user.profile', $report->user->id) }}" class="text-blue-700 underline">
                            {{ $report->user->name }}
                        </a>
                    </p>
                    <p class="text-sm text-black mt-1">{{ $report->Reason }}</p>

                    <form method="POST" action="{{ route('admin.reports.dismiss', $report->ReportID) }}" class="mt-2">
                        @csrf
                        <button type="submit" class="text-sm px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                            Dismiss
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-sm text-black">No reported users.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>

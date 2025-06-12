<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-black">
            Admin Panel - Reports
        </h2>
    </x-slot>

    <div class="flex flex-col lg:flex-row py-6 max-w-7xl mx-auto px-4 gap-6">

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Recipe Reports -->
            <div class="mb-10">
                <h3 class="text-lg font-bold mb-3 text-black">Reported Recipes</h3>
                @forelse($recipeReports as $report)
                    <div class="border border-brown-600 p-4 mb-3 rounded shadow-sm bg-[#e6d9c5]">
                        <p class="text-black">
                            <strong>Recipe:</strong>
                            <a href="{{ route('recipes.show', $report->recipe) }}" class="text-blue-700 underline">
                                {{ $report->recipe->Name }}
                            </a>
                        </p>
                        <p class="text-sm text-black mt-1">{{ $report->Reason }}</p>

                        <form method="POST" action="{{ route('admin.reports.dismiss', $report->ReportID) }}" class="mt-2">
                            @csrf
                            <button type="submit"
                                class="text-sm px-3 py-1 bg-[#e6d9c5] text-black rounded hover:bg-[#d9cab8] border border-brown-600">
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
                    <div class="border border-brown-600 p-4 mb-3 rounded shadow-sm bg-[#e6d9c5]">
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
                            <button type="submit"
                                class="text-sm px-3 py-1 bg-[#e6d9c5] text-black rounded hover:bg-[#d9cab8] border border-brown-600">
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
                    <div class="border border-brown-600 p-4 mb-3 rounded shadow-sm bg-[#e6d9c5]">
                        <p class="text-black">
                            <strong>User:</strong>
                            <a href="{{ route('user.profile', $report->user->id) }}" class="text-blue-700 underline">
                                {{ $report->user->name }}
                            </a>
                        </p>
                        <p class="text-sm text-black mt-1">{{ $report->Reason }}</p>

                        <form method="POST" action="{{ route('admin.reports.dismiss', $report->ReportID) }}" class="mt-2">
                            @csrf
                            <button type="submit"
                                class="text-sm px-3 py-1 bg-[#e6d9c5] text-black rounded hover:bg-[#d9cab8] border border-brown-600">
                                Dismiss
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-sm text-black">No reported users.</p>
                @endforelse
            </div>
        </div>

        <!-- Floating Sidebar (Admin Info) -->
        <div class="w-full lg:w-1/4 lg:sticky top-20 h-fit">
            <div class="bg-[#f7f3ec] border border-brown-600 rounded p-4 shadow">
                <h4 class="text-md font-bold mb-2 text-black">Admin Tools</h4>
                <ul class="text-sm text-black list-disc list-inside">
                    <li>View flagged content</li>
                    <li>Dismiss reports</li>
                    <li>Monitor activity</li>
                </ul>
                <p class="text-xs text-red-700 mt-4">
                    Please ensure all reports are reviewed fairly. Abuse of this panel may result in loss of admin privileges.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>

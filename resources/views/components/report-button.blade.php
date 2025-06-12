@props(['type', 'id'])

@auth
    <!-- Trigger Button -->
    <button
        class="text-red-500 text-sm hover:underline mt-1 focus:outline-none focus:ring-2 focus:ring-red-500"
        onclick="document.getElementById('report-modal-{{ $type }}-{{ $id }}').showModal()">
        Report {{ ucfirst($type) }}
    </button>

    <!-- Modal -->
    <dialog id="report-modal-{{ $type }}-{{ $id }}" class="rounded-lg w-full max-w-md p-6 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-xl backdrop:bg-black/30">
        <form method="POST" action="{{ route('report') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="TargetType" value="{{ $type }}">
            <input type="hidden" name="TargetID" value="{{ $id }}">

            <h3 class="font-semibold text-lg text-gray-900 dark:text-white">
                Report {{ ucfirst($type) }}
            </h3>

            <textarea name="Reason" rows="4"
                      class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-md resize-none dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-red-500"
                      placeholder="Reason (optional)..."></textarea>

            <div class="flex justify-end space-x-3">
                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-500 transition focus:outline-none focus:ring-2 focus:ring-red-500">
                    Submit
                </button>
                <button type="button"
                        onclick="this.closest('dialog').close()"
                        class="px-4 py-2 border rounded-md text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition focus:outline-none">
                    Cancel
                </button>
            </div>
        </form>
    </dialog>
@endauth

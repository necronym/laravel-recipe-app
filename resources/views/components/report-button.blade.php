@props(['type', 'id'])

@auth
    <!-- Trigger Button -->
    <button
        class="text-red-500 text-sm hover:underline mt-1"
        onclick="document.getElementById('report-modal-{{ $type }}-{{ $id }}').showModal()">
        Report {{ ucfirst($type) }}
    </button>

    <!-- Modal -->
    <dialog id="report-modal-{{ $type }}-{{ $id }}" class="rounded-md w-96 p-4 border dark:bg-gray-800 dark:text-white">
        <form method="POST" action="{{ route('report') }}" class="space-y-3">
            @csrf
            <input type="hidden" name="TargetType" value="{{ $type }}">
            <input type="hidden" name="TargetID" value="{{ $id }}">

            <h3 class="font-semibold text-lg">Report {{ ucfirst($type) }}</h3>

            <textarea name="Reason" rows="4"
                      class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white"
                      placeholder="Reason (optional)..."></textarea>

            <div class="flex justify-end space-x-2">
                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded">Submit</button>
                <button type="button" onclick="this.closest('dialog').close()" class="px-3 py-1 border rounded">Cancel</button>
            </div>
        </form>
    </dialog>
@endauth

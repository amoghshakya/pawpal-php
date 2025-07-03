<div class="flex justify-center gap-2">
    <a
        class="text-indigo-600 hover:text-indigo-800"
        href="{{ route('pets.edit', $id) }}"
    >
        @svg('heroicon-o-pencil-square', 'w-5 h-5')
    </a>
    <button
        class="text-red-600 hover:text-red-800 cursor-pointer"
        type="submit"
        onclick="document.getElementById('delete-confirmation-modal').classList.remove('hidden')"
    >
        @svg('heroicon-o-trash', 'w-5 h-5')
    </button>

    <x-modal
        id="delete-confirmation-modal"
        title="Delete listing?"
    >
        <form
            class="flex flex-col items-center justify-center gap-4"
            method="POST"
            action="{{ route('pets.delete', $id) }}"
        >
            @csrf
            @method('DELETE')
            <p class="text-sm/6 text-gray-600">
                Are you sure you want to delete this listing? This action cannot be undone.
            </p>
            <div class="flex w-full items-center gap-2">
                <x-button
                    variant="secondary"
                    onclick="document.getElementById('delete-confirmation-modal').classList.add('hidden')"
                >Cancel</x-button>
                <x-button
                    type="submit"
                    variant="danger"
                >Delete</x-button>
            </div>
        </form>
    </x-modal>
</div>

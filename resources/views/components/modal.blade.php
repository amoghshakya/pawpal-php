@props(['id' => 'modal-' . uniqid(), 'title' => null])

<div
    id="{{ $id }}"
    {{ $attributes->merge(['class' => 'fixed inset-0 z-50 flex items-center justify-center bg-black/50 hidden']) }}
>
    <div class="relative w-full max-w-lg rounded-lg bg-white p-4 shadow-lg">
        <div class="absolute right-2 top-2 m-2 rounded-md *:transition">
            @svg('heroicon-o-x-mark', 'size-5 hover:text-gray-700 text-gray-500 cursor-pointer', [
                'onclick' => "document.getElementById('{$id}').classList.add('hidden')",
            ])
        </div>
        @if ($title)
            <h4 class="tracking-tight! mb-4 text-lg font-semibold">
                {{ $title }}
            </h4>
        @endif
        {{ $slot }}
    </div>
</div>

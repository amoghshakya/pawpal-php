@props(['images'])

<div
    class="relative"
    x-data="carousel()"
    x-init="init()"
    {{ $attributes->merge(['class' => '']) }}
>
    <div
        class="relative aspect-[9/11] overflow-hidden rounded-md shadow-md"
        x-ref="carousel"
    >
        @foreach ($images as $index => $image)
            <div
                class="carousel-item {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }} absolute inset-0 h-full w-full transition-opacity duration-500">
                <img
                    class="h-full w-full rounded-md object-cover"
                    src="{{ asset('storage/' . $image->image_path) }}"
                    alt="{{ $image->pet->name }}'s image"
                />
                <div
                    class="absolute bottom-0 flex w-full items-center justify-between bg-black/70 px-4 py-2 text-sm text-white">
                    <span>
                        {{ $image->caption }}
                    </span>
                    <span class="opacity-80">
                        {{ $index + 1 . '/' . count($images) }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4 flex justify-center gap-4">
        <button
            class="rounded-full bg-gray-200 p-1 text-sm hover:bg-gray-300"
            type="button"
            @click="prevImage"
        >
            @svg('heroicon-o-chevron-left', 'h-4 w-4')
        </button>
        <button
            class="rounded-full bg-gray-200 p-1 text-sm hover:bg-gray-300"
            type="button"
            @click="nextImage"
        >
            @svg('heroicon-o-chevron-right', 'h-4 w-4')
        </button>
    </div>
</div>

@push('scripts')
    <script>
        function carousel() {
            return {
                items: [],
                current: 0,
                init() {
                    this.items = this.$el.querySelectorAll('.carousel-item');
                },
                showImage(index) {
                    this.items.forEach((item, i) => {
                        item.classList.toggle('opacity-100', i === index);
                        item.classList.toggle('z-10', i === index);
                        item.classList.toggle('opacity-0', i !== index);
                        item.classList.toggle('z-0', i !== index);
                    });
                    this.current = index;
                },
                prevImage() {
                    const newIndex = (this.current - 1 + this.items.length) % this.items.length;
                    this.showImage(newIndex);
                },
                nextImage() {
                    const newIndex = (this.current + 1) % this.items.length;
                    this.showImage(newIndex);
                }
            };
        }
    </script>
@endpush

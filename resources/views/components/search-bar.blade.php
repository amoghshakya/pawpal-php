<div class="relative">
    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
        @svg('heroicon-o-magnifying-glass', 'size-5 text-muted')
    </div>
    <x-input
        class="pl-10!"
        name="search"
        type="search"
        {{ $attributes->merge(['placeholder' => 'Search...']) }}
    />
</div>

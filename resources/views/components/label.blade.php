@props(['required'])

<label {{ $attributes->merge(['class' => 'block text-sm/6 font-medium text-gray-900']) }}>
    {{ $slot }}
    @if ($required)
        <span class="text-accent text-xs/snug">*</span>
    @endif
</label>

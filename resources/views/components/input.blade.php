@props(['name', 'type', 'value' => null])

@php
    $type = $type ?? 'text';
    $inputValue = $value ?? old($name);
@endphp


<div class="flex items-center rounded-md bg-white">
    <input
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ $inputValue }}"
        {{ $attributes->merge([
            'class' =>
                'block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6',
        ]) }}
    />
</div>

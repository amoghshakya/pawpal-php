@php
    $base =
        'w-full inline-flex items-center justify-center px-4 py-2 gap-2 whitespace-nowrap font-medium rounded-md text-sm transition focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 cursor-pointer shadow';
    $variants = [
        'primary' => 'bg-primary text-bg hover:bg-primary/90 focus-visible:ring-primary/50 text-bg!',
        'secondary' => 'bg-gray-100 text-black hover:bg-gray-200 focus-visible:ring-gray-400',
        'disabled' => 'bg-gray-300 text-gray-500! cursor-not-allowed!',
        'danger' => 'bg-red-600 text-bg! hover:bg-red-700 focus-visible:ring-red-500',
    ];
@endphp

<button
    class="{{ $base }} {{ $variants[$variant] }}"
    type="{{ $type }}"
    {{ $attributes->merge(['class' => '']) }}
>
    {{ $slot }}
</button>

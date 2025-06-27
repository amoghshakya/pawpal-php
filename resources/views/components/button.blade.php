@php
    $base =
        "inline-flex items-center justify-center px-4 py-2 gap-2 whitespace-nowrap font-medium rounded-md text-sm transition focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 cursor-pointer";
    $variants = [
        "primary" => "bg-primary text-bg hover:bg-primary/90 focus-visible:ring-primary/50 text-bg!",
        "secondary" => "bg-gray-100 text-black hover:bg-gray-200 focus-visible:ring-gray-400",
    ];
@endphp

<button class="{{ $base }} {{ $variants[$variant] }}" type="{{ $type }}"
    {{ $attributes->merge(["class" => ""]) }}>
    {{ $slot }}
</button>

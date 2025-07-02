@props(['variant' => 'link'])

@php
    $base =
        'w-full text-sm inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 cursor-pointer ease-in-out';
    $variants = [
        'link' => 'hover:text-primary/90 focus-visible:ring-primary/50 hover:underline underline-offset-2',
        'primary' =>
            'px-4 py-2 bg-primary text-bg hover:bg-primary/90 focus-visible:ring-primary/50 text-bg! hover:no-underline!',
        'secondary' =>
            'px-4 py-2 bg-gray-100 text-black hover:bg-gray-200 focus-visible:ring-gray-400 hover:no-underline!',
    ];
@endphp

<a {{ $attributes->merge(['class' => "$base $variants[$variant]"]) }}>
    {{ $slot }}
</a>

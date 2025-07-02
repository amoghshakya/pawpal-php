@props(['variant' => 'default'])

@php
    $classes = match ($variant) {
        'success' => 'bg-green-100 text-green-800 border-green-400',
        'error' => 'bg-red-100 text-red-800 border-red-400',
        'warning' => 'bg-yellow-100 border-yellow-400 text-yellow-800',
        default => 'bg-blue-100 text-blue-800 border-blue-400',
    };
@endphp

<div {{ $attributes->merge(['class' => "border w-full p-4 mb-4 $classes"]) }}>
    {{ $slot }}
</div>

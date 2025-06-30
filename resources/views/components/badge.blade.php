@props(['variant' => 'default'])

@php
    $base =
        'inline-flex items-center rounded-full px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10';
    // Some pre-defined stuff or use the class to build your own
    $variants = [
        'default' => 'bg-gray-100 text-gray-600',
        'primary' => 'bg-primary/20 text-blue-800',
        'secondary' => 'bg-secondary/20 text-text/60',
        'success' => 'bg-green-100 text-green-800',
        'warning' => 'bg-yellow-100 text-yellow-800',
        'danger' => 'bg-red-100 text-red-800',
        'stale' => 'bg-gray-200 text-gray-800',
    ];
@endphp

<span {{ $attributes->merge(['class' => "$base $variants[$variant]"]) }}>{{ $slot }}</span>

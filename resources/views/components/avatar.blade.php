@php
    $user = auth()->user();
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center justify-center']) }}>
    {{-- Check if the user has a pfp --}}
    @if ($user->profile_image)
        <img
            class="h-10 w-10 rounded-full"
            src="{{ asset('storage/' . $user->avatar_path) }}"
            alt="{{ $user->name }}'s avatar"
        />
    @else
        @svg('heroicon-o-user-circle', 'h-8 w-8 text-text/80')
    @endif
</div>

@props(['title' => 'Dashboard'])

@php
    use Illuminate\Support\Str;
    $currentRoute = request()->route()->getName();
@endphp

<aside class="bg-primary fixed left-0 top-0 hidden h-screen w-72 flex-col justify-between px-4 py-2 md:flex">
    <div class="flex flex-col justify-between gap-8">
        <div>LOGO</div>

        <ul class="text-bg w-full space-y-1 text-sm font-medium">
            @foreach ($links as $link)
                @php
                    $routeName = request()->route()->getName();
                    $isActive = match ($link['route']) {
                        'dashboard.index' => $routeName === 'dashboard.index',
                        'dashboard.pets' => str_starts_with($routeName, 'dashboard.pets') ||
                            str_starts_with($routeName, 'pets.edit'),
                        'dashboard.adoptions' => str_starts_with($routeName, 'dashboard.') &&
                            !in_array($routeName, ['dashboard.index', 'dashboard.pets', 'dashboard.pets.create']),
                        default => false,
                    };
                @endphp
                <li>
                    <a
                        class="{{ $isActive ? 'bg-text/20 font-semibold' : '' }} hover:no-underline! hover:bg-text/10 flex items-center gap-2 rounded-md px-4 py-2"
                        href="{{ route($link['route']) }}"
                    >
                        @svg($isActive ? $link['activeIcon'] : $link['icon'], 'size-5')
                        {{ $link['name'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="border-t-bg/10 w-full space-y-2 border-t py-4">
        <form
            method="POST"
            action="{{ route('logout') }}"
        >
            @csrf
            <button
                class="hover:bg-text/10 text-bg! flex w-full cursor-pointer items-center gap-2 rounded-md px-4 py-2 text-sm font-medium"
                type="submit"
            >
                @svg('heroicon-o-arrow-left-on-rectangle', 'size-5')
                Log out
            </button>
        </form>
    </div>
</aside>

{{-- Topbar --}}
<header
    class="fixed left-0 top-0 z-10 flex h-14 w-full items-center justify-between bg-white px-4 shadow md:ml-72 md:w-[calc(100%-18rem)]"
>
    {{-- Mobile menu toggle --}}
    <div class="md:hidden">MENU</div>

    <div>
        <h6 class="text-base font-semibold">{{ $title }}</h6>
    </div>

    <div class="flex items-center gap-2">
        <x-avatar />
        <p class="hidden text-sm font-semibold md:block">{{ auth()->user()->name }}</p>
    </div>
</header>

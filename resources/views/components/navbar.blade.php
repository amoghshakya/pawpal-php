<nav class="flex w-full items-center justify-between px-4 text-sm text-white only:sm:py-2">
    <div>
        <img
            src=""
            alt="PawPal Logo"
        />
    </div>
    <ul class="font-body text-text hidden justify-around gap-2 text-xs font-medium uppercase tracking-wider lg:flex">
        @foreach ($navlinks as $link)
            <li class="p-4">
                <x-nav-link
                    class="px-2 hover:font-[600]"
                    href="{{ route($link['route']) }}"
                >
                    {{ $link['label'] }}
                </x-nav-link>
            </li>
        @endforeach
    </ul>
    <div class="items-around text-text hidden gap-1 font-medium lg:flex">
        @auth
            {{-- TODO: Avatar --}}
            <x-avatar />
        @endauth
        @guest
            <x-nav-link
                href="{{ route('login') }}"
                variant="secondary"
            >
                Login
            </x-nav-link>
            <x-nav-link
                href="{{ route('register') }}"
                variant="primary"
            >
                Register
            </x-nav-link>
        @endguest
    </div>
    {{-- TODO: Onclick JS and Animations --}}
    <button class="px-1 py-2 lg:hidden">
        @svg('heroicon-o-bars-3', 'w-6 h-6')
    </button>
</nav>

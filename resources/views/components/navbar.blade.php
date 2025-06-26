<nav class="flex justify-between items-center px-4 text-sm">
    <div>
        <div>
            LOGO!!
        </div>
        <ul class="flex justify-around gap-2">
            @foreach ($navlinks as $link)
                <li class="text-gray-700 p-4">
                    <a href="{{ route($link['route']) }}" class="hover:text-blue-500 hover:underline underline-offset-2">
                        {{ $link['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="flex items-around gap-4">
        @if (auth()->check())
            <span class="text-gray-700">Welcome, {{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-gray-700 hover:text-blue-500">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="hover:text-blue-500">Login</a>
            <a href="{{ route('register') }}" class="hover:text-blue-500">Register</a>
        @endif
    </div>
</nav>

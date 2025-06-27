@extends("components.base-layout")

@section("title", "Login")

@section("content")
    <h3>Login</h3>
    <form class="flex w-1/2 flex-col gap-4 p-12" method="POST" action="{{ route("login") }}">
        @csrf
        <input name="email" type="email" placeholder="Email" required />
        <input name="password" type="password" placeholder="Password" required />
        <x-button type="submit" variant="primary">Login</x-button>
    </form>
@endsection

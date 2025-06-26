@extends('components.base-layout')

@section('title', 'Login')

@section('content')
    <h3>Login</h3>
    <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4 p-12 w-1/2">
        @csrf
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit" class="primary">Login</button>
    </form>
@endsection

@extends('components.base-layout')

@section('title', 'Login')

@section('content')
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img
                class="mx-auto h-10 w-auto"
                src=""
                alt="PawPal logo"
            />
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Sign in to your account</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form
                class="space-y-6"
                action="{{ route('login') }}"
                method="POST"
            >
                @csrf
                <div>
                    <label
                        class="block text-sm/6 font-medium text-gray-900"
                        for="email"
                    >Email address</label>
                    <div class="mt-2">
                        <x-input
                            id="email"
                            name="email"
                            type="email"
                            required
                            autofocus
                        />
                    </div>
                    <x-error-field name="email" />
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label
                            class="block text-sm/6 font-medium text-gray-900"
                            for="password"
                        >Password</label>
                        <div class="text-sm">
                            <a
                                class="text-primary hover:text-primary/80 font-semibold"
                                href="#"
                            >
                                Forgot password?
                            </a>
                        </div>
                    </div>
                    <div class="mt-2">
                        <x-input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            required
                        />
                    </div>
                    <x-error-field name="password" />
                </div>

                <div>
                    <x-button
                        type="submit"
                        variant="primary"
                    >Sign in</x-button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm/6 text-gray-500">
                Not a member? Register
                <a
                    class="text-primary hover:text-primary/80 font-semibold"
                    href="{{ route('register') }}"
                >here.</a>
            </p>
        </div>
    </div>

@endsection

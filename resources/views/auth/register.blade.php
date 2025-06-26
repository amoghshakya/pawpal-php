@extends('components.base-layout')

@section('title', 'Register')

@section('header')
    <h1>Register</h1>
    <p>Welcome to PawPal! Please fill out the form below to create your account.</p>
@endsection

@section('content')
    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required><br><br>

        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required><br><br>

        <input type="text" name="phone" placeholder="Phone" value="{{ old('phone') }}" required><br><br>

        <input type="password" name="password" placeholder="Password" required><br><br>

        <input type="password" name="password_confirmation" placeholder="Confirm Password" required><br><br>

        <select name="role" required>
            <option value="adopter" {{ old('role') == 'adopter' ? 'selected' : '' }}>Adopter</option>
            <option value="lister" {{ old('role') == 'lister' ? 'selected' : '' }}>Lister</option>
        </select><br><br>

        <input type="text" name="address" placeholder="Address" value="{{ old('address') }}" required><br><br>

        <input type="text" name="city" placeholder="City" value="{{ old('city') }}" required><br><br>

        <input type="text" name="state" placeholder="State" value="{{ old('state') }}" required><br><br>

        <!-- <label>Profile Image:</label> -->
        <!-- <input type="file" name="profile_image"><br><br> -->

        <button type="submit" class="primary">Register</button>
    </form>
@endsection

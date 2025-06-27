@extends("components.base-layout")

@section("title", "Register")

@section("header")
    <h1>Register</h1>
    <p>Welcome to PawPal! Please fill out the form below to create your account.</p>
@endsection

@section("content")
    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route("register") }}" enctype="multipart/form-data">
        @csrf

        <input name="name" type="text" value="{{ old("name") }}" placeholder="Name" required><br><br>

        <input name="email" type="email" value="{{ old("email") }}" placeholder="Email" required><br><br>

        <input name="phone" type="text" value="{{ old("phone") }}" placeholder="Phone" required><br><br>

        <input name="password" type="password" placeholder="Password" required><br><br>

        <input name="password_confirmation" type="password" placeholder="Confirm Password" required><br><br>

        <select name="role" required>
            <option value="adopter" {{ old("role") == "adopter" ? "selected" : "" }}>Adopter</option>
            <option value="lister" {{ old("role") == "lister" ? "selected" : "" }}>Lister</option>
        </select><br><br>

        <input name="address" type="text" value="{{ old("address") }}" placeholder="Address" required><br><br>

        <input name="city" type="text" value="{{ old("city") }}" placeholder="City" required><br><br>

        <input name="state" type="text" value="{{ old("state") }}" placeholder="State" required><br><br>

        <!-- <label>Profile Image:</label> -->
        <!-- <input name="profile_image" type="file"><br><br> -->

        <x-button variant="primary" type="submit">Register</x-button>
    </form>
@endsection

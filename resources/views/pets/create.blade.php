@extends('components.base-layout')

@section('title', 'Create Pet')

@section('content')
    {{-- TODO: UI --}}
    <form method="POST" action="{{ route('pets.store') }}" enctype="multipart/form-data">
        @csrf
        <input name="name" type="text" value="{{ old('name') }}" placeholder="Pet Name" required><br><br>
        <input name="species" type="text" value="{{ old('species') }}" placeholder="Species" required><br><br>
        <input name="breed" type="text" value="{{ old('breed') }}" placeholder="Breed"><br><br>
        <input name="age" type="number" value="{{ old('age') }}" placeholder="Age" required><br><br>
        <textarea name="description" placeholder="Description">{{ old('description') }}</textarea><br><br>

        <select name="gender" required>
            <option value="" disabled selected>Select Gender</option>
            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
        </select><br><br>
        {{-- <input name="photo" type="file" accept="image/*"><br><br> --}}
        <button type="submit">Create Pet</button>
    </form>
@endsection

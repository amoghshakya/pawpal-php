@extends('components.base-layout')

@section('title', 'Create Pet')

@section('content')
    {{-- TODO: UI --}}
    {{-- <form method="POST" action="{{ route('pets.store') }}" enctype="multipart/form-data">
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
        <button type="submit">Create Pet</button>
    </form> --}}


    <form>
        @csrf
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base/7 font-semibold text-gray-900">Create a new pet listing</h2>
                <p class="mt-1 text-sm/6 text-gray-600">
                    This information will be displayed publicly so please include key details about your pet.
                </p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <label class="block text-sm/6 font-medium text-gray-900" for="name">Name</label>
                        <div class="mt-2">
                            <div class="flex items-center rounded-md bg-white">
                                <input
                                    class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                                    id="name" name="name" type="text" value="{{ old('name') }}"
                                    placeholder="Buddy" />
                            </div>
                        </div>
                    </div>

                    <div class="col-span-full">
                        <label class="block text-sm/6 font-medium text-gray-900" for="about">About</label>
                        <div class="mt-2">
                            <textarea class="block w-full rounded-md bg-white px-3 py-1.5 text-base sm:text-sm/6" id="about" name="about"
                                rows="3"></textarea>
                        </div>
                        <p class="mt-3 text-sm/6 text-gray-600">Write a few sentences about the pet.</p>
                    </div>

                    <div class="col-span-full">
                        <label class="block text-sm/6 font-medium text-gray-900" for="cover-photo">Photos</label>
                        <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                            <div class="text-center">
                                <svg class="mx-auto size-12 text-gray-300" data-slot="icon" aria-hidden="true"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="mt-4 flex text-sm/6 text-gray-600">
                                    <label
                                        class="focus-within:outline-hidden relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500"
                                        for="file-upload">
                                        <span>Upload a file</span>
                                        <input class="sr-only" id="file-upload" name="file-upload" type="file" />
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs/5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </form>


@endsection

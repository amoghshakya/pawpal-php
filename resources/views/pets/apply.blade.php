@extends('components.base-layout')

@section('title', "Apply to Adopt $pet->name")

@section('content')
    <section class="p-8">
        <form
            method="POST"
            action="{{ route('pets.apply', $pet) }}"
        >
            @csrf
            <div class="space-y-6">
                <div class="border-b border-gray-900/10 pb-4">
                    <h2 class="text-base/7 font-semibold text-gray-900">Apply to adopt {{ $pet->name }}</h2>
                    <p class="mt-1 text-sm/6 text-gray-600">
                        This information will be provided to the pet's lister to help them decide if you are a good fit for
                        their pet. Please answer all questions honestly and to the best of your ability.
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-[40vw_1fr]">
                    <div>
                        <div class="">
                            <x-carousel :images="$pet->images" />
                        </div>
                    </div>
                    <div class="space-y-4 px-4">
                        <div>
                            <x-label
                                for="message"
                                required
                            >
                                Message
                            </x-label>
                            <div class="mt-2">
                                <textarea
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base sm:text-sm/6"
                                    id="message"
                                    name="message"
                                    value="{{ old('message') }}"
                                    rows="3"
                                    placeholder="Tell us about yourself and why you want to adopt this pet."
                                    maxlength="1000"
                                    minlength="100"
                                    required
                                ></textarea>
                            </div>
                            <x-error-field name="message" />
                        </div>
                        <div>
                            <x-label
                                for="other_pets"
                                required
                            >
                                Do you have any other pets?
                            </x-label>
                            <div class="mt-2">
                                <div class="flex items-center gap-8 rounded-md bg-white p-2">
                                    <div class="flex items-center">
                                        <input
                                            class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600"
                                            id="yes-other_pets"
                                            name="other_pets"
                                            type="radio"
                                            value="true"
                                        >
                                        <label
                                            class="ms-2 text-sm font-medium text-gray-900"
                                            for="yes-other_pets"
                                        >Yes</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input
                                            class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600"
                                            id="no-other_pets"
                                            name="other_pets"
                                            type="radio"
                                            value="false"
                                            checked
                                        >
                                        <label
                                            class="ms-2 text-sm font-medium text-gray-900"
                                            for="no-other_pets"
                                        >No</label>
                                    </div>
                                </div>

                            </div>
                            <x-error-field name="other_pets" />
                        </div>
                        <div
                            class="hidden"
                            id="other_pets_details_container"
                        >
                            <x-label
                                for="other_pets_details"
                                required
                            >
                                Other Pets Details
                            </x-label>
                            <div class="mt-2">
                                <textarea
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base sm:text-sm/6"
                                    id="other_pets_details"
                                    name="other_pets_details"
                                    value="{{ old('other_pets_details') }}"
                                    rows="3"
                                    placeholder="Tell us about your other pets, including their species, breed, age, and any relevant details."
                                    maxlength="1000"
                                    minlength="100"
                                ></textarea>
                            </div>
                            <x-error-field name="other_pets_details" />
                        </div>
                        <div>
                            <x-label
                                for="living_conditions"
                                required
                            >Living Conditions</x-label>
                            <div class="mt-2">
                                <textarea
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base sm:text-sm/6"
                                    id="living_conditions"
                                    name="living_conditions"
                                    value="{{ old('living_condtions') }}"
                                    rows="3"
                                    placeholder="Describe your living conditions, including whether you have a yard, the type of housing, and any other relevant details."
                                    maxlength="1000"
                                    minlength="100"
                                    required
                                ></textarea>
                            </div>
                            <x-error-field name="living_conditions" />
                        </div>
                        <x-button
                            type="submit"
                            variant="primary"
                        >
                            Send
                        </x-button>
                    </div>
                </div>
        </form>
    </section>
@endsection

@push('scripts')
    <script>
        const otherPetsRadios = document.querySelectorAll('input[name="other_pets"]');
        const container = document.getElementById('other_pets_details_container');
        const detailsInput = document.querySelector('textarea#other_pets_details');

        if (document.getElementById('yes-other_pets').checked) {
            container.classList.remove('hidden');
            detailsInput.required = true;
        } else {
            container.classList.add('hidden');
            detailsInput.required = false;
        }

        otherPetsRadios.forEach((radio) => {
            radio.addEventListener('change', () => {
                if (radio.value === 'true') {
                    container.classList.remove('hidden');
                    detailsInput.required = true;
                } else {
                    container.classList.add('hidden');
                    detailsInput.required = true;
                }
            })
        })
    </script>
@endpush

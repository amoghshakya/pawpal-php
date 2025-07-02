@extends('components.base-layout')

@section('title', 'Register')

@section('header')
@endsection

@section('content')
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img
                class="mx-auto h-10 w-auto"
                src=""
                alt="PawPal logo"
            />
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Create a new account</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form
                class="mb-4 space-y-2"
                action="{{ route('register') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                <div>
                    <label
                        class="block text-sm/6 font-medium text-gray-900"
                        for="email"
                    >Name</label>
                    <div class="mt-2">
                        <x-input
                            id="name"
                            name="name"
                            required
                        />
                    </div>
                    <x-error-field name="name" />
                </div>

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
                            autocomplete="email"
                            required
                        />
                    </div>
                    <x-error-field name="email" />
                </div>


                <div>
                    <label
                        class="block text-sm/6 font-medium text-gray-900"
                        for="email"
                    >Phone Number</label>
                    <div class="mt-2">
                        <x-input
                            name="phone"
                            type="tel"
                            autocomplete="phone"
                            required
                        />
                    </div>
                    <x-error-field name="phone" />
                </div>

                <div>
                    <label
                        class="block text-sm/6 font-medium text-gray-900"
                        for="password"
                    >Password</label>
                    <div class="mt-2">
                        <x-input
                            id="password"
                            name="password"
                            type="password"
                            minlength="8"
                            autocomplete="current-password"
                            required
                        />
                    </div>
                    @error('password')
                        <span
                            class="text-xs/snug font-semibold text-red-500"
                            id="password-error"
                        >{{ $message }}</span>
                    @enderror
                </div>


                <div>
                    <label
                        class="block text-sm/6 font-medium text-gray-900"
                        for="confirm-password"
                    >Confirm Password</label>
                    <div class="mt-2">
                        <x-input
                            id="confirm-password"
                            name="password_confirmation"
                            type="password"
                            autocomplete="current-password"
                            required
                        />
                    </div>
                    <x-error-field name="password_confirmation" />
                    <span
                        class="text-xs/snug font-semibold text-red-500"
                        id="confirm-password-error"
                    ></span>
                </div>

                <div>
                    <label
                        class="block text-sm/6 font-medium text-gray-900"
                        id="listbox-label"
                    >Assigned to</label>
                    <div class="relative mt-2">
                        <button
                            class="border-text/20 grid w-full cursor-default grid-cols-1 rounded-md border bg-white py-1.5 pl-3 pr-2 text-left text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            type="button"
                            aria-haspopup="listbox"
                            aria-expanded="false"
                            aria-labelledby="listbox-label"
                        >
                            <span class="col-start-1 row-start-1 flex items-center gap-3 pr-6">
                                @svg('heroicon-o-user', 'size-5 shrink-0 text-gray-500')
                                <span class="block truncate">Adopter</span>
                            </span>
                            <div
                                class="col-start-1 row-start-1 size-5 self-center justify-self-end sm:size-4"
                                data-slot="icon"
                                aria-hidden="true"
                            >
                                @svg('heroicon-o-chevron-up-down', 'h-4 w-4 shrink-0 text-text/70')
                            </div>
                        </button>

                        <ul
                            class="focus:outline-hidden absolute z-10 mt-1 hidden max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 sm:text-sm"
                            id="select-options"
                            role="listbox"
                            aria-labelledby="listbox-label"
                            aria-activedescendant="listbox-option-0"
                            tabindex="-1"
                        >

                            <li
                                class="option hover:bg-text/5 focus-visible:bg-accent relative cursor-default select-none py-2 pl-3 pr-9 text-gray-900"
                                id="listbox-option-0"
                                role="option"
                            >
                                <div class="flex items-center">
                                    @svg('heroicon-o-user', 'size-5 shrink-0 text-gray-500')
                                    <span class="ml-3 block truncate font-normal">Adopter</span>
                                </div>
                            </li>
                            <li
                                class="option hover:bg-text/5 focus-visible:bg-accent relative cursor-default select-none py-2 pl-3 pr-9 text-gray-900"
                                id="listbox-option-1"
                                role="option"
                            >
                                <div class="flex items-center">
                                    @svg('heroicon-o-clipboard-document-check', 'size-5 shrink-0 text-gray-500')
                                    <span class="ml-3 block truncate font-normal">Lister</span>
                                </div>
                            </li>
                            {{-- <!-- More items... --> --}}
                        </ul>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div class="flex-shrink">
                        <label
                            class="block text-sm/6 font-medium text-gray-900"
                            for="address"
                        >Address</label>
                        <div class="mt-2">
                            <x-input
                                id="address"
                                name="address"
                                autocomplete="address"
                                required
                            />
                        </div>
                        <x-error-field name="address" />
                    </div>
                    <div class="flex-shrink">
                        <label
                            class="block text-sm/6 font-medium text-gray-900"
                            for="city"
                        >City</label>
                        <div class="mt-2">
                            <x-input
                                id="city"
                                name="city"
                                autocomplete="city"
                                required
                            />
                        </div>
                        <x-error-field name="city" />
                    </div>
                </div>

                <div class="">
                    <label
                        class="block text-sm/6 font-medium text-gray-900"
                        for="state"
                    >State</label>
                    <div class="mt-2">
                        <x-input
                            id="state"
                            name="state"
                            autocomplete="state"
                            required
                        />
                    </div>
                    <x-error-field name="state" />
                </div>
                {{-- For role input --}}
                <input
                    id="selected-role"
                    name="role"
                    type="hidden"
                    value="adopter"
                />

                <div class="mt-6">
                    <x-button
                        type="submit"
                        variant="primary"
                    >Register</x-button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm/6 text-gray-500">
                Already a member? Login
                <a
                    class="text-primary hover:text-primary/80 font-semibold"
                    href="{{ route('login') }}"
                >here.</a>
            </p>
        </div>
    </div>



@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm-password');

            const validatePasswordMatch = () => {
                const errorSpan = document.querySelector('#confirm-password-error');
                if (password.value !== confirmPassword.value) {
                    errorSpan.textContent = 'Passwords do not match';
                    errorSpan.classList.remove('hidden');
                } else {
                    errorSpan.textContent = '';
                    errorSpan.classList.add('hidden');
                }
            };

            confirmPassword.addEventListener('input', validatePasswordMatch);
            password.addEventListener('input', validatePasswordMatch);

            const selectButton = document.querySelector('[aria-haspopup="listbox"]');
            const optionsList = document.getElementById('select-options');
            const selectedText = selectButton.querySelector('span.block.truncate');
            const selectedIconContainer = selectButton.querySelector('span.flex');

            function closeDropdown() {
                optionsList.classList.add('hidden');
                selectButton.setAttribute('aria-expanded', 'false');
            }

            function openDropdown() {
                optionsList.classList.remove('hidden');
                selectButton.setAttribute('aria-expanded', 'true');
            }

            function toggleDropdown() {
                const expanded = selectButton.getAttribute('aria-expanded') === 'true';
                expanded ? closeDropdown() : openDropdown();
            }

            // Open/close dropdown
            selectButton.addEventListener('click', (e) => {
                e.stopPropagation();
                toggleDropdown();
            });

            // Close when clicking outside
            document.addEventListener('click', (e) => {
                if (!selectButton.contains(e.target) && !optionsList.contains(e.target)) {
                    closeDropdown();
                }
            });

            // Handle option selection
            const options = optionsList.querySelectorAll('.option');
            options.forEach(option => {
                option.addEventListener('click', () => {
                    const optionText = option.querySelector('span.block.truncate').textContent;
                    const optionIcon = option.querySelector('svg')?.outerHTML;

                    // Update visible text
                    selectedText.textContent = optionText;

                    // Update hidden input value
                    document.getElementById('selected-role').value = optionText.toLowerCase();

                    // Swap icon
                    const currentIcon = selectedIconContainer.querySelector('svg');
                    if (currentIcon) currentIcon.remove();
                    if (optionIcon) selectedText.insertAdjacentHTML('beforebegin', optionIcon);

                    closeDropdown();
                });
            });
        });
    </script>
@endpush

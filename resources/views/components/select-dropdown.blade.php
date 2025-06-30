@php
    $dropdownId = $name . '-dropdown';
@endphp

<div class="relative mt-2">
    <button
        class="border-text/20 grid w-full cursor-default grid-cols-1 rounded-md border bg-white py-1.5 pl-3 pr-2 text-left text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
        id="{{ $dropdownId }}-button"
        type="button"
        aria-haspopup="listbox"
        aria-expanded="false"
        aria-labelledby="{{ $dropdownId }}-label"
    >
        <span class="col-start-1 row-start-1 flex items-center gap-3 pr-6">
            <span class="block truncate">{{ $selected }}</span>
        </span>
        <div
            class="col-start-1 row-start-1 size-5 self-center justify-self-end sm:size-4"
            data-slot="icon"
            aria-hidden="true"
        >
            @svg('heroicon-o-chevron-up-down', 'h-4 w-4 shrink-0 text-text/70')
        </div>
    </button>

    <input
        id="{{ $dropdownId }}-value"
        name="{{ $name }}"
        type="hidden"
        value="{{ $selected }}"
    />

    <ul
        class="focus:outline-hidden absolute z-10 mt-1 hidden max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 sm:text-sm"
        id="{{ $dropdownId }}-options"
        role="listbox"
        aria-labelledby="{{ $dropdownId }}-label"
        tabindex="-1"
    >
        @foreach ($options as $i => $option)
            <li
                class="option hover:bg-text/5 focus-visible:bg-accent relative cursor-default select-none py-2 pl-3 pr-9 text-gray-900"
                id="{{ $dropdownId }}-option-{{ $i }}"
                role="option"
                aria-selected="{{ $option === $selected ? 'true' : 'false' }}"
                tabindex="-1"
            >
                <div class="flex items-center">
                    <span class="ml-3 block truncate font-normal">{{ $option }}</span>
                </div>
            </li>
        @endforeach
    </ul>
</div>


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const button = document.getElementById('{{ $dropdownId }}-button');
            const optionsList = document.getElementById('{{ $dropdownId }}-options');
            const valueInput = document.getElementById('{{ $dropdownId }}-value');
            const selectedText = button.querySelector('span.block.truncate');
            const options = optionsList.querySelectorAll('.option');

            let currentIndex = 0;

            function openDropdown() {
                optionsList.classList.remove('hidden');
                button.setAttribute('aria-expanded', 'true');
                options[currentIndex].focus();
            }

            function closeDropdown() {
                optionsList.classList.add('hidden');
                button.setAttribute('aria-expanded', 'false');
            }

            function updateSelection(index) {
                const option = options[index];
                const text = option.querySelector('span.block.truncate').textContent;
                selectedText.textContent = text;
                valueInput.value = text.toLowerCase();

                options.forEach((opt, i) => {
                    opt.setAttribute('aria-selected', i === index ? 'true' : 'false');
                });

                closeDropdown();
            }

            button.addEventListener('click', () => {
                const expanded = button.getAttribute('aria-expanded') === 'true';
                expanded ? closeDropdown() : openDropdown();
            });

            button.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    openDropdown();
                    currentIndex = (currentIndex + 1) % options.length;
                    options[currentIndex].focus();
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    currentIndex = (currentIndex - 1 + options.length) % options.length;
                    options[currentIndex].focus();
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    updateSelection(currentIndex);
                } else if (e.key === 'Escape') {
                    closeDropdown();
                }
            });

            options.forEach((option, index) => {
                option.addEventListener('click', () => updateSelection(index));
                option.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        updateSelection(index);
                    }
                });
            });

            document.addEventListener('click', (e) => {
                if (!button.contains(e.target) && !optionsList.contains(e.target)) {
                    closeDropdown();
                }
            });
        });
    </script>
@endpush

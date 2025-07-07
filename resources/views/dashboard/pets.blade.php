@extends('components.dashboard-layout')

@section('title', 'Dashboard - Pet Listings')

@section('header')
    <x-dashboard-navbar title="Pet Listings" />
@endsection

@section('content')
    <section class="p-6">
        <div class="mb-4">
            <x-search-bar
                id="searchInput"
                placeholder="Search pets, breeds, species..."
            />
        </div>
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h4 class="text-lg font-semibold">Your Pets</h4>
                <p class="text-muted text-sm">
                    A list of all your pet listings including their details.
                </p>
            </div>
            <div>
                <x-nav-link
                    href="{{ route('dashboard.pets.create') }}"
                    variant="primary"
                >
                    @svg('heroicon-o-plus', 'size-5')
                    Create
                </x-nav-link>
            </div>
        </div>

        <div id="petsTableWrapper">
            <x-table
                :headers="['name', 'species', 'breed', 'created_at', 'updated_at', 'status']"
                :rows="$pets"
                :actionsSlot="function ($row) {
                    return view('components.partials.table-actions', ['id' => $row->id]);
                }"
            />
        </div>

    </section>
@endsection


@push('scripts')
    <script>
        function debounce(fn, delay = 300) {
            let timeoutId;
            return function(...args) {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(() => fn.apply(this, args), delay);
            }
        }
        const searchInput = document.getElementById('searchInput');
        const searchPets = debounce(function() {
            const query = this.value;

            fetch(`{{ route('dashboard.pets.search') }}?search=${encodeURIComponent(query)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                })
                .then(res => res.text())
                .then(html => {
                    document.getElementById('petsTableWrapper').innerHTML = html;
                });
        })
        searchInput.addEventListener('input', searchPets);
    </script>
@endpush

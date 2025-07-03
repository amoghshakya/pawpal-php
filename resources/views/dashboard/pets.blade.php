@extends('components.dashboard-layout')

@section('title', 'Dashboard - Pet Listings')

@section('header')
    <x-dashboard-navbar title="Pet Listings" />
@endsection

@section('content')
    <section>
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
        <div>
            <x-table
                :headers="['name', 'species', 'breed', 'created_at', 'updated_at', 'status']"
                :rows="$pets"
            >
                @slot('actionsSlot', function ($row) {
                    return view('components.partials.table-actions', ['id' => $row->id]);
                    })
                </x-table>

                {{-- Pagination --}}
                <div class="p-4">
                    {{ $pets->links() }}
                </div>
            </div>

        </section>
    @endsection

@props([
    'headers' => [],
    'rows' => null, // Must be a Paginator instance
    'actionsSlot' => null, // Optional slot for actions column
])

<div class="overflow-x-auto rounded-md shadow-sm ring-1 ring-black/5">
    <table class="min-w-full table-auto divide-y divide-gray-200 text-left text-sm">
        <thead class="bg-gray-100 font-semibold text-gray-700">
            <tr>
                <th class="px-4 py-2">#</th>
                @foreach ($headers as $header)
                    <th class="whitespace-nowrap px-4 py-2">{{ ucwords(str_replace('_', ' ', $header)) }}</th>
                @endforeach
                <th class="px-4 py-2 text-center"></th>
            </tr>
        </thead>
        <tbody class="*:even:bg-gray-100">
            @forelse ($rows as $row)
                <tr class="group">
                    <td class="w-fit px-4 py-2">
                        {{ ($rows->firstItem() ?? 0) + $loop->index }}
                    </td>
                    @foreach ($headers as $key)
                        <td class="whitespace-nowrap px-4 py-2">
                            @php
                                $status = data_get($row, 'status');
                            @endphp
                            @if ($key === 'status' && $status)
                                <x-badge variant="{{ $status === 'available' ? 'success' : 'danger' }}">
                                    {{ ucwords($status) }}
                                </x-badge>
                            @else
                                {{ data_get($row, $key) ?? '-' }}
                            @endif
                        </td>
                    @endforeach
                    <td class="py-2 text-center transition ease-in md:opacity-0 md:group-hover:opacity-100">
                        {{ $actionsSlot ? $actionsSlot($row) : '' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td
                        class="px-4 py-4 text-center text-gray-500"
                        colspan="{{ count($headers) + 2 }}"
                    >
                        No data found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{-- Pagination --}}
    <div class="p-4">
        {{ $rows->links() }}
    </div>
</div>

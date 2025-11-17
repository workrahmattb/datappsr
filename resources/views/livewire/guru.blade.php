<div class="p-4">
    <h1 class="text-2xl font-semibold mb-4">Data Mts Putri</h1>

    <!-- Search Bar -->
    <div class="mb-4">
        <input type="text" wire:model.live="search" placeholder="Cari Nama Anak atau Nama Ayah..."
            class="border rounded-lg px-3 py-2 w-full focus:outline-none focus:ring focus:ring-green-300">
    </div>

    <!-- Table -->
    <div class="overflow-x-auto bg-white rounded-xl shadow">
        <table class="table-auto w-full border-collapse">
            <thead class="bg-green-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left">No</th>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">NISN</th>
                    <th class="px-4 py-2 text-left">Nama Ayah</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mtsputris as $index => $item)
                    <tr class="border-b hover:bg-green-50">
                        <td class="px-4 py-2">
                            {{ $mtsputris->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-2">{{ $item->nama }}</td>
                        <td class="px-4 py-2">{{ $item->nisn }}</td>
                        <td class="px-4 py-2">{{ $item->nama_ayah }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">
                            Tidak ada data ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 flex justify-center">
        {{ $mtsputris->links() }}
    </div>
</div>

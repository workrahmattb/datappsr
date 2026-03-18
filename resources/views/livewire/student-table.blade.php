<div class="space-y-4">
    <!-- Filters -->
    <div class="flex flex-col-reverse md:flex-row gap-4 items-end">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search by name</label>
            <input type="text" wire:model.live="search" placeholder="Cari nama siswa..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
        </div>

        <div class="w-full md:w-auto">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Tingkat</label>
            <select wire:model.live="studentType"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="all">Tingkat Madrasah</option>
                <option value="maputra">MA Putra</option>
                <option value="maputri">MA Putri</option>
                <option value="mtsputra">MTS Putra</option>
                <option value="mtsputri">MTS Putri</option>
            </select>
        </div>
    </div>

    <!-- Table Desktop View -->
    <div class="hidden md:block overflow-x-auto border border-gray-300 rounded-lg dark:border-gray-600">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 dark:bg-gray-700 border-b border-gray-300 dark:border-gray-600">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-gray-900 dark:text-white cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600"
                        wire:click="sort('nama')">
                        <div class="flex items-center gap-2">
                            Nama Siswa
                            @if ($sortBy === 'nama')
                                <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-900 dark:text-white">NISN</th>

                    <th class="px-6 py-3 text-left font-semibold text-gray-900 dark:text-white">Tempat Lahir</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-900 dark:text-white">Tanggal Lahir</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-300 dark:divide-gray-600">
                @forelse($students as $student)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-6 py-3 text-gray-900 dark:text-gray-100">
                            <div class="font-medium">{{ $student->nama ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-3 text-gray-600 dark:text-gray-300">{{ $student->nisn ?? '-' }}</td>

                        <td class="px-6 py-3 text-gray-600 dark:text-gray-300">{{ $student->tempat_lahir ?? '-' }}</td>
                        <td class="px-6 py-3 text-gray-600 dark:text-gray-300">
                            @if ($student->tanggal_lahir)
                                {{ date('d M Y', strtotime($student->tanggal_lahir)) }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-600 dark:text-gray-400">
                            Tidak ada data siswa ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile Card View -->
    <div class="md:hidden space-y-3">
        @forelse($students as $student)
            <div
                class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg p-4 shadow hover:shadow-md transition">
                <div class="space-y-2">
                    <div class="flex justify-between items-start gap-2">
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Nama Siswa</p>
                            <p class="font-bold text-gray-900 dark:text-white">{{ $student->nama ?? '-' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Tipe</p>
                            <p class="text-xs font-semibold text-green-600 dark:text-green-400">
                                @if (class_basename($student) === 'Maputra')
                                    MA Putra
                                @elseif (class_basename($student) === 'Maputri')
                                    MA Putri
                                @elseif (class_basename($student) === 'Mtsputra')
                                    MTS Putra
                                @else
                                    MTS Putri
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2 pt-2 border-t border-gray-200 dark:border-gray-600">
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">NISN</p>
                            <p class="text-sm text-gray-900 dark:text-gray-100">{{ $student->nisn ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Tempat Lahir</p>
                            <p class="text-sm text-gray-900 dark:text-gray-100">{{ $student->tempat_lahir ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Tanggal Lahir</p>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                @if ($student->tanggal_lahir)
                                    {{ date('d M Y', strtotime($student->tanggal_lahir)) }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-600 dark:text-gray-400">
                Tidak ada data siswa ditemukan
            </div>
        @endforelse
    </div>

    <!-- Pagination Info -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Showing <span class="font-semibold">{{ $students->count() }}</span> of <span
                class="font-semibold">{{ $totalItems }}</span> students
        </p>

        @if ($totalPages > 1)
            <div class="flex flex-wrap gap-2">
                @if ($currentPage > 1)
                    <button wire:click="gotoPage(1)"
                        class="px-2 md:px-3 py-1 text-xs md:text-sm border border-gray-300 rounded hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700 transition cursor-pointer">First</button>
                    <button wire:click="gotoPage({{ $currentPage - 1 }})"
                        class="px-2 md:px-3 py-1 text-xs md:text-sm border border-gray-300 rounded hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700 transition cursor-pointer">Prev</button>
                @endif

                @for ($i = max(1, $currentPage - 1); $i <= min($totalPages, $currentPage + 1); $i++)
                    <button wire:click="gotoPage({{ $i }})"
                        class="px-2 md:px-3 py-1 text-xs md:text-sm rounded transition cursor-pointer {{ $i == $currentPage ? 'bg-green-600 text-white' : 'border border-gray-300 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700' }}">
                        {{ $i }}
                    </button>
                @endfor

                @if ($currentPage < $totalPages)
                    <button wire:click="gotoPage({{ $currentPage + 1 }})"
                        class="px-2 md:px-3 py-1 text-xs md:text-sm border border-gray-300 rounded hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700 transition cursor-pointer">Next</button>
                    <button wire:click="gotoPage({{ $totalPages }})"
                        class="px-2 md:px-3 py-1 text-xs md:text-sm border border-gray-300 rounded hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700 transition cursor-pointer">Last</button>
                @endif
            </div>
        @endif
    </div>
</div>

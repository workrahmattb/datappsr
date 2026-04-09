<div class="space-y-4">
    <!-- Filters -->
    <div class="flex flex-col-reverse md:flex-row gap-4 items-end">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ketik Nama Calon
                Santri</label>
            <input type="text" wire:model.live="search" placeholder="Cari nama siswa..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
        </div>
    </div>

    <!-- Initial State - Show message to search -->
    @if(!$hasSearched || strlen($search) === 0)
        <div class="text-center py-12 bg-gray-50 dark:bg-gray-700/50 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600">
            <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">Ketik nama siswa untuk mencari</p>
            <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Data akan muncul setelah Anda mengetik di kolom pencarian</p>
        </div>
    @else
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
                    <th class="px-6 py-3 text-left font-semibold text-gray-900 dark:text-white">Jenjang Pendidikan</th>
                    <th class="px-6 py-3 text-center font-semibold text-gray-900 dark:text-white">Aksi</th>
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
                        <td class="px-6 py-3 text-gray-600 dark:text-gray-300">{{ $student->jenjang_pendidikan ?? '-' }}</td>
                        <td class="px-6 py-3 text-center">
                            @if(isset($student->status_pendaftaran) && $student->status_pendaftaran === 'pending')
                                <a href="{{ route('daftar-ulang.form', $student->id) }}" 
                                   class="inline-block px-3 py-1.5 text-xs font-semibold text-white bg-green-600 hover:bg-green-700 rounded-md transition-colors duration-200">
                                    Daftar Ulang
                                </a>
                            @else
                                <span class="text-xs text-gray-400 dark:text-gray-500">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-600 dark:text-gray-400">
                            Tidak ada data santri ditemukan
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
                        <div class="flex-1">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Nama Siswa</p>
                            <p class="font-bold text-gray-900 dark:text-white">{{ $student->nama ?? '-' }}</p>
                        </div>
                        @if(isset($student->status_pendaftaran) && $student->status_pendaftaran === 'pending')
                            <a href="{{ route('daftar-ulang.form', $student->id) }}" 
                               class="inline-block px-3 py-1.5 text-xs font-semibold text-white bg-green-600 hover:bg-green-700 rounded-md transition-colors duration-200 whitespace-nowrap">
                                Daftar Ulang
                            </a>
                        @endif
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
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Jenjang Pendidikan</p>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                {{ $student->jenjang_pendidikan ?? '-' }}</p>
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
    @endif
</div>

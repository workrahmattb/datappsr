<div>
    <!-- Search Bar -->
    <div class="relative">
        <input 
            type="text" 
            wire:model.live.debounce.300ms="search" 
            placeholder="Ketik Nama / NISN / NIK untuk mencari data siswa TA 2026/2027..."
            class="w-full px-4 py-3 pl-12 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 focus:outline-none focus:ring-0 transition duration-200"
        >
        <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
    </div>

    @if(strlen($search) === 0)
        <div class="text-center py-12 bg-gray-50 dark:bg-gray-700/50 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 mt-6">
            <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">Ketik nama siswa untuk mencari</p>
            <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Data akan muncul setelah Anda mengetik di kolom pencarian</p>
        </div>
    @elseif($students->count() === 0)
        <div class="text-center py-12 bg-gray-50 dark:bg-gray-700/50 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 mt-6">
            <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">Data tidak ditemukan</p>
            <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Tidak ada siswa dengan nama "{{ $search }}" untuk TA 2026/2027</p>
        </div>
    @else
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto border border-gray-200 dark:border-gray-600 rounded-lg mt-6">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-gray-900 dark:text-white">Nama Siswa</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-900 dark:text-white">NISN</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-900 dark:text-white">Jenjang</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-900 dark:text-white">Tempat, Tgl Lahir</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-900 dark:text-white">Foto</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-900 dark:text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                    @forelse($students as $student)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-3">
                                    @if($student->foto)
                                        <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-gray-200 shrink-0">
                                            <img src="{{ Storage::url($student->foto) }}" class="w-full h-full object-cover" alt="Foto">
                                        </div>
                                    @else
                                        <div class="w-10 h-10 bg-gray-100 border border-gray-200 rounded-full flex items-center justify-center text-gray-700 font-bold text-sm shrink-0">
                                            {{ substr($student->nama, 0, 1) }}
                                        </div>
                                    @endif
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $student->nama }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-gray-600 dark:text-gray-300">{{ $student->nisn ?? '-' }}</td>
                            <td class="px-6 py-3">
                                <span class="inline-block px-2.5 py-1 text-xs font-semibold rounded-full
                                    @if($student->is_pendaftaran) bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300
                                    @elseif(str_contains($student->student_type, 'Mts')) bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                                    @else bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300 @endif">
                                    @if($student->is_pendaftaran)
                                        {{ $student->jenjang_pendidikan ?? 'Pendaftaran' }}
                                    @else
                                        {{ str_replace(['Mtsputra', 'Mtsputri', 'Maputra', 'Maputri'], ['MTs Putra', 'MTs Putri', 'MA Putra', 'MA Putri'], $student->student_type) }}
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-3 text-gray-600 dark:text-gray-300">
                                {{ $student->tempat_lahir ?? '-' }},
                                @if($student->tanggal_lahir)
                                    {{ \Carbon\Carbon::parse($student->tanggal_lahir)->format('d M Y') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-3 text-center">
                                @if($student->is_pendaftaran)
                                    <span class="text-xs text-amber-600 dark:text-amber-400 font-semibold">⏳ Pending</span>
                                @elseif($student->foto)
                                    <span class="text-xs text-green-600 dark:text-green-400 font-semibold">✓ Ada</span>
                                @else
                                    <span class="text-xs text-gray-400 dark:text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-center">
                                @if($student->is_pendaftaran)
                                    <a href="{{ route('daftar-ulang.form', $student->id) }}"
                                       class="inline-block px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 rounded-md transition-colors duration-200">
                                        Daftar Ulang
                                    </a>
                                @else
                                    <a href="{{ route('update-foto.form', ['type' => $student->student_type, 'id' => $student->id]) }}"
                                       class="inline-block px-3 py-1.5 text-xs font-semibold text-white bg-green-600 hover:bg-green-700 rounded-md transition-colors duration-200">
                                        Update Foto
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden space-y-3 mt-6">
            @forelse($students as $student)
                <div class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-4 shadow hover:shadow-md transition">
                    <div class="flex items-center gap-3 mb-3">
                        @if($student->foto)
                            <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-gray-200 shrink-0">
                                <img src="{{ Storage::url($student->foto) }}" class="w-full h-full object-cover" alt="Foto">
                            </div>
                        @else
                            <div class="w-12 h-12 bg-gray-100 border border-gray-200 rounded-full flex items-center justify-center text-gray-700 font-bold text-base shrink-0">
                                {{ substr($student->nama, 0, 1) }}
                            </div>
                        @endif
                        <div class="flex-1">
                            <p class="font-bold text-gray-900 dark:text-white">{{ $student->nama }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $student->nisn ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2 pt-2 border-t border-gray-200 dark:border-gray-600">
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Jenjang</p>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                <span class="inline-block px-2 py-0.5 text-xs font-semibold rounded-full
                                    @if($student->is_pendaftaran) bg-amber-100 text-amber-800
                                    @elseif(str_contains($student->student_type, 'Mts')) bg-blue-100 text-blue-800
                                    @else bg-purple-100 text-purple-800 @endif">
                                    @if($student->is_pendaftaran)
                                        {{ $student->jenjang_pendidikan ?? 'Pendaftaran' }}
                                    @else
                                        {{ str_replace(['Mtsputra', 'Mtsputri', 'Maputra', 'Maputri'], ['MTs Putra', 'MTs Putri', 'MA Putra', 'MA Putri'], $student->student_type) }}
                                    @endif
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Tanggal Lahir</p>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                @if($student->tanggal_lahir)
                                    {{ \Carbon\Carbon::parse($student->tanggal_lahir)->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="mt-3 pt-2 border-t border-gray-200 dark:border-gray-600">
                        @if($student->is_pendaftaran)
                            <a href="{{ route('daftar-ulang.form', $student->id) }}"
                               class="block w-full text-center px-3 py-2 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 rounded-md transition-colors duration-200">
                                Daftar Ulang
                            </a>
                        @else
                            <a href="{{ route('update-foto.form', ['type' => $student->student_type, 'id' => $student->id]) }}"
                               class="block w-full text-center px-3 py-2 text-xs font-semibold text-white bg-green-600 hover:bg-green-700 rounded-md transition-colors duration-200">
                                Update Foto
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Result Count -->
        <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
            Ditemukan <span class="font-semibold">{{ $students->count() }}</span> data siswa untuk TA {{ $tahunAjaran }}
        </div>
    @endif
</div>

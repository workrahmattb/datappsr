<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-xl overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 sm:px-8 py-8">
                <h1 class="text-3xl font-bold text-white mb-2">Data Daftar Baru TA 2026/2027</h1>
                <p class="text-green-100">Klik tombol "Daftar Ulang" pada nama siswa untuk melengkapi data pendaftaran</p>
            </div>

            <!-- Search Bar -->
            <div class="px-6 sm:px-8 py-6 border-b border-gray-200">
                <div class="relative">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="Ketik Nama Calon Santri..."
                        class="w-full px-4 py-3 pl-12 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none focus:ring-0 transition duration-200"
                    >
                    <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">NISN</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tempat Lahir</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal Lahir</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jenjang Pendidikan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($pendaftarans as $pendaftaran)
                            <tr class="hover:bg-green-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <span class="text-sm font-medium text-gray-900">{{ $pendaftaran->nama }}</span>
                                        <a href="{{ route('daftar-ulang.form', $pendaftaran->id) }}" 
                                           class="inline-block px-3 py-1 text-xs font-semibold text-white bg-green-600 hover:bg-green-700 rounded-md transition-colors duration-200">
                                            Daftar Ulang
                                        </a>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $pendaftaran->nisn }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $pendaftaran->tempat_lahir }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ \Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $pendaftaran->jenjang_pendidikan }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                        <p class="text-gray-500 font-medium">Tidak ada data pendaftaran</p>
                                        <p class="text-gray-400 text-sm mt-1">Belum ada calon santri yang perlu daftar ulang</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($pendaftarans->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $pendaftarans->links() }}
                </div>
            @endif

            <!-- Info Footer -->
            <div class="bg-blue-50 border-t border-blue-200 px-6 py-4">
                <p class="text-sm text-blue-800 flex items-center gap-2">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    Menampilkan {{ $pendaftarans->total() }} calon santri yang perlu melakukan pendaftaran ulang
                </p>
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center">
            <a href="/" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition duration-200">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>

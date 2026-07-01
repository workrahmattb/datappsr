<div class="min-h-screen bg-gradient-to-br from-sky-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-sky-600 to-blue-600 px-6 sm:px-8 py-8 text-center sm:text-left">
                <div class="flex flex-col sm:flex-row items-center gap-4">
                    <div class="bg-white/20 rounded-full p-3">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white">Galeri Foto Santri</h1>
                        <p class="text-sky-100 mt-1">Pondok Pesantren Syafa'aturrasul — Tahun Ajaran {{ $tahunAjaran }}</p>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="px-6 sm:px-8 py-5 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-wrap gap-3">
                    <div class="flex-1 min-w-[250px] relative">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="search" 
                            placeholder="Cari nama atau NISN..."
                            class="w-full pl-9 pr-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-colors dark:text-white"
                        >
                    </div>
                    <select wire:model.live="jenjang" class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-colors min-w-[150px] dark:text-white">
                        <option value="">Semua Jenjang</option>
                        <option value="MTs Putra">MTs Putra</option>
                        <option value="MTs Putri">MTs Putri</option>
                        <option value="MA Putra">MA Putra</option>
                        <option value="MA Putri">MA Putri</option>
                    </select>
                    @if($search || $jenjang)
                        <button wire:click="$set('search', ''); $set('jenjang', null)" class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors">
                            Reset Filter
                        </button>
                    @endif
                </div>
            </div>
        </div>

        @if($students->count() === 0)
            <!-- Empty State -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-12 text-center">
                <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Belum Ada Data Santri</h3>
                <p class="text-gray-500 dark:text-gray-400">
                    @if($search)
                        Tidak ditemukan santri dengan nama "{{ $search }}"
                    @else
                        Belum ada data santri untuk TA {{ $tahunAjaran }}
                    @endif
                </p>
            </div>
        @else
            <!-- Stats -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl px-6 py-4 mb-6 flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Ditemukan</span>
                    <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $students->total() }}</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">santri</span>
                </div>
                <div class="flex items-center gap-4 text-xs text-gray-400 dark:text-gray-500">
                    <span class="flex items-center gap-1">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span> Ada Foto
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="w-2.5 h-2.5 rounded-full bg-gray-300 dark:bg-gray-600"></span> Belum Ada Foto
                    </span>
                </div>
            </div>

            <!-- Card Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach($students as $student)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 group">
                        <!-- Photo Section -->
                        <div class="relative bg-gradient-to-br from-sky-100 to-blue-100 dark:from-gray-700 dark:to-gray-700 p-5 flex items-center justify-center h-56">
                            @if($student->foto)
                                <div class="w-full h-full flex items-center justify-center">
                                    <img 
                                        src="{{ Storage::url($student->foto) }}" 
                                        alt="Foto {{ $student->nama }}"
                                        class="max-w-full max-h-full object-contain rounded-xl shadow-md"
                                        loading="lazy"
                                    >
                                </div>
                                <!-- Download Button -->
                                <a 
                                    href="{{ Storage::url($student->foto) }}" 
                                    download="{{ $student->nama }} - {{ $student->nisn }}.jpg"
                                    class="absolute top-3 right-3 w-9 h-9 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-md opacity-0 group-hover:opacity-100 transition-all duration-300 hover:bg-white hover:scale-110"
                                    title="Download Foto"
                                >
                                    <svg class="w-4.5 h-4.5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </a>
                                <!-- Ada Foto Badge -->
                                <div class="absolute bottom-3 left-3">
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-emerald-500/90 backdrop-blur-sm text-white text-[10px] font-semibold">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Ada Foto
                                    </span>
                                </div>
                            @else
                                <!-- No Photo Placeholder -->
                                <div class="text-center">
                                    <div class="w-24 h-24 bg-white dark:bg-gray-600 rounded-full flex items-center justify-center mx-auto mb-3 shadow-lg border-4 border-white/80 dark:border-gray-500">
                                        <span class="text-4xl font-bold text-sky-500 dark:text-sky-400">
                                            {{ substr($student->nama, 0, 1) }}
                                        </span>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-gray-300/80 dark:bg-gray-600 text-gray-600 dark:text-gray-400 text-[10px] font-semibold">
                                        Belum Ada Foto
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Info Section -->
                        <div class="p-4 space-y-3">
                            <!-- Nama & Jenjang -->
                            <div>
                                <h3 class="font-bold text-gray-900 dark:text-white text-base leading-tight truncate">{{ $student->nama }}</h3>
                                <span class="inline-block mt-1 px-2.5 py-0.5 text-xs font-semibold rounded-full
                                    @if($student->jenjang_label === 'MTs Putra') bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300
                                    @elseif($student->jenjang_label === 'MTs Putri') bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-300
                                    @elseif($student->jenjang_label === 'MA Putra') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300
                                    @else bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300 @endif
                                ">
                                    {{ $student->jenjang_label }}
                                </span>
                            </div>

                            <!-- NISN -->
                            <div class="flex items-center gap-2 text-sm">
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11a3 3 0 10-4 2.83M12 14v2m0 0h2m-2 0h-2"></path>
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400 font-medium">NISN:</span>
                                <span class="text-gray-900 dark:text-white font-semibold">{{ $student->nisn ?? '-' }}</span>
                            </div>

                            <!-- Tempat, Tanggal Lahir -->
                            <div class="flex items-start gap-2 text-sm">
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">TTL:</span>
                                    <span class="text-gray-800 dark:text-gray-200">
                                        {{ $student->tempat_lahir ?? '-' }},
                                        @if($student->tanggal_lahir)
                                            {{ \Carbon\Carbon::parse($student->tanggal_lahir)->isoFormat('D MMMM Y') }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <!-- Alamat -->
                            <div class="flex items-start gap-2 text-sm">
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">Alamat:</span>
                                    <span class="text-gray-700 dark:text-gray-300 line-clamp-2">{{ $student->alamat_lengkap }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($students->hasPages())
                <div class="mt-8 bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-4">
                    {{ $students->links() }}
                </div>
            @endif

            <!-- Footer Info -->
            <div class="mt-6 text-center">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl shadow-sm text-xs text-gray-500 dark:text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Klik ikon download <svg class="w-3.5 h-3.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> di pojok kanan atas foto untuk menyimpan gambar
                </div>
            </div>
        @endif

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>

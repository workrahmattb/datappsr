<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="relative bg-zinc-900 rounded-2xl shadow-sm p-8 text-white overflow-hidden border border-zinc-800">
        <!-- Decorative Elements -->
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-zinc-800 rounded-full blur-3xl opacity-50"></div>
        <div class="absolute bottom-0 left-20 w-32 h-32 bg-zinc-800 rounded-full blur-3xl opacity-30"></div>
        
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight mb-2 text-zinc-100">Selamat Datang di Admin Panel</h1>
                <p class="text-zinc-400 font-medium">Kelola data siswa dan pendaftaran dengan mudah dan terpusat.</p>
            </div>
            <div class="hidden lg:block bg-zinc-800/50 p-4 rounded-xl backdrop-blur-sm border border-zinc-700/50">
                <svg class="w-12 h-12 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Mts Putra -->
        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('mtsputra'))
        <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 p-6 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-semibold text-zinc-500 tracking-wide mb-1">MTs PUTRA</p>
                    <p class="text-3xl font-bold text-zinc-900">{{ $stats['mtsputra_count'] }}</p>
                    <p class="text-xs text-zinc-400 mt-1 font-medium">Total Siswa Terdaftar</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center border border-blue-100/50">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-5 pt-4 border-t border-zinc-100">
                <a wire:navigate href="{{ route('admin.mtsputras.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-semibold flex items-center transition-colors">
                    Lihat Detail
                    <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
        @endif

        <!-- Mts Putri -->
        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('mtsputri'))
        <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 p-6 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-semibold text-zinc-500 tracking-wide mb-1">MTs PUTRI</p>
                    <p class="text-3xl font-bold text-zinc-900">{{ $stats['mtsputri_count'] }}</p>
                    <p class="text-xs text-zinc-400 mt-1 font-medium">Total Siswi Terdaftar</p>
                </div>
                <div class="w-12 h-12 bg-pink-50 rounded-xl flex items-center justify-center border border-pink-100/50">
                    <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-5 pt-4 border-t border-zinc-100">
                <a wire:navigate href="{{ route('admin.mtsputris.index') }}" class="text-sm text-pink-600 hover:text-pink-700 font-semibold flex items-center transition-colors">
                    Lihat Detail
                    <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
        @endif

        <!-- MA Putra -->
        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('maputra'))
        <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 p-6 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-semibold text-zinc-500 tracking-wide mb-1">MA PUTRA</p>
                    <p class="text-3xl font-bold text-zinc-900">{{ $stats['maputra_count'] }}</p>
                    <p class="text-xs text-zinc-400 mt-1 font-medium">Total Siswa Terdaftar</p>
                </div>
                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center border border-emerald-100/50">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-5 pt-4 border-t border-zinc-100">
                <a wire:navigate href="{{ route('admin.maputras.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-semibold flex items-center transition-colors">
                    Lihat Detail
                    <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
        @endif

        <!-- MA Putri -->
        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('maputri'))
        <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 p-6 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-semibold text-zinc-500 tracking-wide mb-1">MA PUTRI</p>
                    <p class="text-3xl font-bold text-zinc-900">{{ $stats['maputri_count'] }}</p>
                    <p class="text-xs text-zinc-400 mt-1 font-medium">Total Siswi Terdaftar</p>
                </div>
                <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center border border-purple-100/50">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-5 pt-4 border-t border-zinc-100">
                <a wire:navigate href="{{ route('admin.maputris.index') }}" class="text-sm text-purple-600 hover:text-purple-700 font-semibold flex items-center transition-colors">
                    Lihat Detail
                    <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
        @endif

        <!-- Total Pendaftaran -->
        <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 p-6 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-semibold text-zinc-500 tracking-wide mb-1">TOTAL PENDAFTARAN</p>
                    <p class="text-3xl font-bold text-zinc-900">{{ $stats['pendaftaran_count'] }}</p>
                    <p class="text-xs text-zinc-400 mt-1 font-medium">Semua Jenjang Pendidikan</p>
                </div>
                <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center border border-amber-100/50">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-5 pt-4 border-t border-zinc-100">
                <a wire:navigate href="{{ route('admin.pendaftarans.index') }}" class="text-sm text-amber-600 hover:text-amber-700 font-semibold flex items-center transition-colors">
                    Lihat Semua
                    <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Pending -->
        <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 p-6 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-semibold text-zinc-500 tracking-wide mb-1">MENUNGGU VERIFIKASI</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $stats['pendaftaran_pending'] }}</p>
                    <p class="text-xs text-zinc-400 mt-1 font-medium">Perlu Tindakan Review</p>
                </div>
                <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center border border-orange-100/50">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-5 pt-4 border-t border-zinc-100">
                <a wire:navigate href="{{ route('admin.pendaftarans.index', ['status' => 'pending']) }}" class="text-sm text-orange-600 hover:text-orange-700 font-semibold flex items-center transition-colors">
                    Mulai Verifikasi
                    <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 p-6 hover:shadow-md transition-shadow duration-300">
            <div class="flex-1">
                <p class="text-sm font-semibold text-zinc-500 tracking-wide mb-1">AKSI CEPAT</p>
                <p class="text-lg font-bold text-zinc-900 mb-4">Pintasan Menu</p>
                <div class="space-y-2">
                    <a wire:navigate href="{{ route('admin.pendaftarans.create') }}" class="group flex items-center justify-between px-3 py-2 bg-zinc-50 hover:bg-zinc-100 border border-zinc-200 text-zinc-700 rounded-lg text-sm font-medium transition-colors">
                        <span>Pendaftaran Baru</span>
                        <svg class="w-4 h-4 text-zinc-400 group-hover:text-zinc-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </a>
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('mtsputra'))
                    <a wire:navigate href="{{ route('admin.mtsputras.create') }}" class="group flex items-center justify-between px-3 py-2 bg-zinc-50 hover:bg-zinc-100 border border-zinc-200 text-zinc-700 rounded-lg text-sm font-medium transition-colors">
                        <span>Siswa MTs Putra</span>
                        <svg class="w-4 h-4 text-zinc-400 group-hover:text-zinc-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Pendaftarans -->
    <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 overflow-hidden">
        <div class="px-6 py-5 border-b border-zinc-200/80 bg-zinc-50/50 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-zinc-900 tracking-tight">Pendaftaran Terbaru</h3>
                <p class="text-sm text-zinc-500 mt-1 font-medium">10 pendaftaran terakhir yang masuk ke dalam sistem</p>
            </div>
            <a wire:navigate href="{{ route('admin.pendaftarans.index') }}" class="text-sm text-zinc-900 bg-white border border-zinc-200 hover:bg-zinc-50 font-semibold px-4 py-2 rounded-lg flex items-center transition-colors shadow-sm">
                Lihat Semua
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200/80">
                <thead class="bg-zinc-50/80">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">Pendaftar</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">Jenjang</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-zinc-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-zinc-200/80">
                    @forelse($recentPendaftarans as $pendaftaran)
                    <tr class="hover:bg-zinc-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-zinc-100 border border-zinc-200 rounded-full flex items-center justify-center text-zinc-700 font-bold text-sm">
                                    {{ $loop->iteration }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-zinc-900">{{ $pendaftaran->nama }}</div>
                                    <div class="text-xs text-zinc-500 font-medium mt-0.5">NIK: {{ $pendaftaran->nik }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-zinc-100 text-zinc-800 text-xs font-semibold border border-zinc-200">
                                {{ strtoupper($pendaftaran->jenjang_pendidikan) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold border
                                @if($pendaftaran->status_pendaftaran === 'completed')
                                    bg-green-50 text-green-700 border-green-200
                                @else
                                    bg-orange-50 text-orange-700 border-orange-200
                                @endif">
                                @if($pendaftaran->status_pendaftaran === 'completed')
                                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @else
                                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                @endif
                                {{ ucfirst($pendaftaran->status_pendaftaran) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-zinc-600 font-medium">
                            <div class="flex flex-col">
                                <span>{{ $pendaftaran->created_at?->format('d M Y') ?? '-' }}</span>
                                <span class="text-xs text-zinc-400 mt-0.5">{{ $pendaftaran->created_at?->format('H:i') ?? '-' }} WIB</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right text-sm font-medium">
                            <a wire:navigate href="{{ route('admin.pendaftarans.show', $pendaftaran) }}" class="inline-flex items-center justify-center bg-white border border-zinc-200 text-zinc-700 hover:bg-zinc-50 hover:text-zinc-900 px-3 py-1.5 rounded-lg transition-colors shadow-sm">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-zinc-50 rounded-full flex items-center justify-center border border-zinc-100 mb-4">
                                    <svg class="h-8 w-8 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-zinc-900 mb-1">Belum ada pendaftaran</h3>
                                <p class="text-sm text-zinc-500">Pendaftaran yang masuk akan muncul di sini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Resource Tables Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- MTs Putra -->
        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('mtsputra'))
        <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 overflow-hidden">
            <div class="px-6 py-4 border-b border-zinc-200/80 bg-zinc-50/50 flex items-center justify-between">
                <div>
                    <h3 class="text-md font-bold text-zinc-900 tracking-tight">Siswa MTs Putra Terbaru</h3>
                </div>
                <a wire:navigate href="{{ route('admin.mtsputras.index') }}" class="text-xs text-blue-600 hover:text-blue-700 font-semibold transition-colors">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200/80">
                    <tbody class="bg-white divide-y divide-zinc-200/80">
                        @forelse($recentMtsputras as $mtsputra)
                        <tr class="hover:bg-zinc-50/50 transition-colors">
                            <td class="px-6 py-3">
                                <div class="text-sm font-bold text-zinc-900">{{ $mtsputra->nama }}</div>
                                <div class="text-xs text-zinc-500 font-medium">Tahun Ajaran: {{ $mtsputra->tahun_ajaran ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-3 text-right">
                                <span class="text-xs text-zinc-500 font-medium">{{ $mtsputra->created_at->diffForHumans() }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="px-6 py-4 text-center text-xs text-zinc-500">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- MTs Putri -->
        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('mtsputri'))
        <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 overflow-hidden">
            <div class="px-6 py-4 border-b border-zinc-200/80 bg-zinc-50/50 flex items-center justify-between">
                <div>
                    <h3 class="text-md font-bold text-zinc-900 tracking-tight">Siswi MTs Putri Terbaru</h3>
                </div>
                <a wire:navigate href="{{ route('admin.mtsputris.index') }}" class="text-xs text-pink-600 hover:text-pink-700 font-semibold transition-colors">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200/80">
                    <tbody class="bg-white divide-y divide-zinc-200/80">
                        @forelse($recentMtsputris as $mtsputri)
                        <tr class="hover:bg-zinc-50/50 transition-colors">
                            <td class="px-6 py-3">
                                <div class="text-sm font-bold text-zinc-900">{{ $mtsputri->nama }}</div>
                                <div class="text-xs text-zinc-500 font-medium">Tahun Ajaran: {{ $mtsputri->tahun_ajaran ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-3 text-right">
                                <span class="text-xs text-zinc-500 font-medium">{{ $mtsputri->created_at->diffForHumans() }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="px-6 py-4 text-center text-xs text-zinc-500">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- MA Putra -->
        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('maputra'))
        <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 overflow-hidden">
            <div class="px-6 py-4 border-b border-zinc-200/80 bg-zinc-50/50 flex items-center justify-between">
                <div>
                    <h3 class="text-md font-bold text-zinc-900 tracking-tight">Siswa MA Putra Terbaru</h3>
                </div>
                <a wire:navigate href="{{ route('admin.maputras.index') }}" class="text-xs text-emerald-600 hover:text-emerald-700 font-semibold transition-colors">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200/80">
                    <tbody class="bg-white divide-y divide-zinc-200/80">
                        @forelse($recentMaputras as $maputra)
                        <tr class="hover:bg-zinc-50/50 transition-colors">
                            <td class="px-6 py-3">
                                <div class="text-sm font-bold text-zinc-900">{{ $maputra->nama }}</div>
                                <div class="text-xs text-zinc-500 font-medium">Tahun Ajaran: {{ $maputra->tahun_ajaran ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-3 text-right">
                                <span class="text-xs text-zinc-500 font-medium">{{ $maputra->created_at->diffForHumans() }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="px-6 py-4 text-center text-xs text-zinc-500">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- MA Putri -->
        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('maputri'))
        <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 overflow-hidden">
            <div class="px-6 py-4 border-b border-zinc-200/80 bg-zinc-50/50 flex items-center justify-between">
                <div>
                    <h3 class="text-md font-bold text-zinc-900 tracking-tight">Siswi MA Putri Terbaru</h3>
                </div>
                <a wire:navigate href="{{ route('admin.maputris.index') }}" class="text-xs text-purple-600 hover:text-purple-700 font-semibold transition-colors">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200/80">
                    <tbody class="bg-white divide-y divide-zinc-200/80">
                        @forelse($recentMaputris as $maputri)
                        <tr class="hover:bg-zinc-50/50 transition-colors">
                            <td class="px-6 py-3">
                                <div class="text-sm font-bold text-zinc-900">{{ $maputri->nama }}</div>
                                <div class="text-xs text-zinc-500 font-medium">Tahun Ajaran: {{ $maputri->tahun_ajaran ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-3 text-right">
                                <span class="text-xs text-zinc-500 font-medium">{{ $maputri->created_at->diffForHumans() }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="px-6 py-4 text-center text-xs text-zinc-500">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>

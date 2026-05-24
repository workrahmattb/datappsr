<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-50 dark:from-gray-900 dark:to-gray-800 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        @if($submitted)
            <!-- Success Page -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden">
                <!-- Header dengan ucapan sukses -->
                <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 sm:px-8 py-8 text-center">
                    <div class="flex justify-center mb-4">
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="h-16 w-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Pendaftaran Ulang Berhasil!</h1>
                    <p class="text-green-100 mb-4">{{ $tahun_ajaran }}</p>
                </div>

                <!-- Data Pendaftaran -->
                <div class="px-6 sm:px-8 py-8">
                    <!-- Jenjang Pendidikan Badge -->
                    <div class="mb-6 text-center">
                        <span class="inline-block bg-gradient-to-r from-green-500 to-emerald-600 text-white text-lg font-bold px-6 py-2 rounded-full shadow-md">
                            {{ $jenjangPendidikan }} - {{ $tahun_ajaran }}
                        </span>
                    </div>

                    <!-- Card Data Siswa -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-gray-800 dark:to-gray-700 rounded-lg border-2 border-green-200 dark:border-green-900 p-6 mb-6">
                        <h3 class="text-xl font-bold text-green-800 dark:text-green-400 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Data Siswa
                        </h3>
                        
                        <div class="space-y-3">
                            <div class="flex flex-col sm:flex-row sm:gap-4">
                                <span class="font-semibold text-gray-700 dark:text-gray-300 sm:w-32">Nama</span>
                                <span class="text-gray-900 dark:text-white font-bold text-lg">{{ $nama }}</span>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row sm:gap-4">
                                <span class="font-semibold text-gray-700 dark:text-gray-300 sm:w-32">Tempat, Tgl Lahir</span>
                                <span class="text-gray-900 dark:text-white">{{ $tempat_lahir }}, {{ \Carbon\Carbon::parse($tanggal_lahir)->isoFormat('D MMMM YYYY') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Alamat -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700 rounded-lg border-2 border-blue-200 dark:border-blue-900 p-6 mb-6">
                        <h3 class="text-lg font-bold text-blue-800 dark:text-blue-400 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Alamat
                        </h3>
                        
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 space-y-2">
                            <div class="flex flex-col sm:flex-row sm:gap-4">
                                <span class="font-semibold text-gray-700 dark:text-gray-300 sm:w-32">Desa/Kelurahan</span>
                                <span class="text-gray-900 dark:text-white">{{ $desa }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:gap-4">
                                <span class="font-semibold text-gray-700 dark:text-gray-300 sm:w-32">Kecamatan</span>
                                <span class="text-gray-900 dark:text-white">{{ $kecamatan }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:gap-4">
                                <span class="font-semibold text-gray-700 dark:text-gray-300 sm:w-32">Kabupaten/Kota</span>
                                <span class="text-gray-900 dark:text-white">{{ $kabupaten }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:gap-4">
                                <span class="font-semibold text-gray-700 dark:text-gray-300 sm:w-32">Provinsi</span>
                                <span class="text-gray-900 dark:text-white">{{ $provinsi }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Data Orang Tua -->
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-gray-800 dark:to-gray-700 rounded-lg border-2 border-purple-200 dark:border-purple-900 p-6 mb-6">
                        <h3 class="text-lg font-bold text-purple-800 dark:text-purple-400 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Data Orang Tua
                        </h3>
                        
                        <div class="space-y-3">
                            <div class="bg-white dark:bg-gray-800 rounded-lg p-4">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Nama Ayah</p>
                                <p class="text-gray-900 dark:text-white font-semibold text-lg">{{ $nama_ayah }}</p>
                            </div>
                            <div class="bg-white dark:bg-gray-800 rounded-lg p-4">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Nama Ibu</p>
                                <p class="text-gray-900 dark:text-white font-semibold text-lg">{{ $nama_ibu }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Ucapan Terima Kasih Bahasa Arab -->
                    <div class="bg-gradient-to-r from-amber-50 to-yellow-50 dark:from-gray-800 dark:to-gray-700 rounded-lg border-2 border-amber-300 dark:border-amber-700 px-6 py-8 text-center mb-6">
                        <div class="mb-4">
                            <p class="text-5xl font-arabic text-gray-800 dark:text-gray-200 mb-3" style="font-family: 'Traditional Arabic', 'Scheherazade', 'Amiri', serif; line-height: 1.6;">
                                جَزَاكُمُ اللهُ خَيْرًا
                            </p>
                            <p class="text-3xl text-gray-700 dark:text-gray-300 mb-2" style="font-family: 'Traditional Arabic', 'Scheherazade', 'Amiri', serif; line-height: 1.6;">
                                بَارَكَ اللهُ فِيْكُمْ
                            </p>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 text-base mb-4 italic">
                            "Semoga Allah memberikan balasan yang baik kepada kalian dan memberkahi kalian"
                        </p>
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 max-w-lg mx-auto border border-amber-200 dark:border-amber-700">
                            <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed">
                                Terima kasih telah melakukan pendaftaran ulang di
                                <br>
                                <span class="font-bold text-green-700 dark:text-green-400 text-xl">Pondok Pesantren Syafa'aturrasul</span>
                            </p>
                        </div>
                    </div>

                    <!-- Informasi Selanjutnya -->
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-gray-800 dark:to-gray-700 border-l-4 border-amber-500 p-4 mb-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-amber-900 dark:text-amber-300 font-semibold mb-1">Informasi Selanjutnya</p>
                                <p class="text-amber-800 dark:text-amber-200 text-sm">
                                    Data Alhamdulillah sudah tersimpan dan mohon tunggu informasi selanjutnya oleh Pihak Pondok Pesantren Syafa'aturrasul
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex flex-col-reverse md:flex-row gap-3">
                        <a href="{{ route('daftar-ulang.table') }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 sm:py-4 px-4 sm:px-6 rounded-lg transition duration-200 text-center flex items-center justify-center gap-2 active:bg-gray-800 dark:active:bg-gray-900">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                            </svg>
                            <span>Kembali ke Daftar</span>
                        </a>
                        <a href="/" class="flex-1 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-3 sm:py-4 px-4 sm:px-6 rounded-lg transition duration-200 text-center flex items-center justify-center gap-2 active:from-green-700 active:to-emerald-700 dark:active:from-green-800 dark:active:to-emerald-800">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span>Beranda</span>
                        </a>
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-green-50 dark:bg-gray-800 border-t border-green-200 dark:border-gray-700 px-6 sm:px-8 py-4 text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Data tersimpan dengan aman di sistem <span class="font-semibold text-green-700 dark:text-green-400">Pondok Pesantren Syafa'aturrasul</span>
                    </p>
                </div>
            </div>
        @else
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 sm:px-8 py-8 text-center">
                <h1 class="text-2xl sm:text-3xl font-bold text-white mb-3">Form Pendaftaran Ulang</h1>
                
                <!-- Badge Jenjang Pendidikan -->
                <div class="inline-block bg-white dark:bg-gray-800 px-6 py-2 rounded-lg mb-3 shadow-md">
                    <p class="text-gray-900 dark:text-white font-bold text-base sm:text-lg">{{ $jenjangPendidikan }}</p>
                </div>
                
                <p class="text-green-100 text-sm sm:text-base">Pondok Pesantren Syafa'aturrasul</p>
                <p class="text-green-200 text-xs sm:text-sm mt-1">Tahun Ajaran {{ $tahun_ajaran }}</p>
            </div>

            <!-- Step Indicator -->
            <div class="px-6 sm:px-8 py-6 bg-gray-50 dark:bg-gray-800 border-b dark:border-gray-700">
                <div class="flex items-center justify-between max-w-2xl mx-auto">
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $currentStep >= 1 ? 'bg-green-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-600 dark:text-gray-300' }}">
                            @if($currentStep > 1)
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @else
                                1
                            @endif
                        </div>
                        <p class="mt-2 text-xs font-semibold {{ $currentStep >= 1 ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400' }}">Upload Bukti Transfer</p>
                    </div>
                    
                    <div class="flex-1 h-1 mx-4 {{ $currentStep > 1 ? 'bg-green-600' : 'bg-gray-300 dark:bg-gray-600' }}"></div>
                    
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $currentStep >= 2 ? 'bg-green-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-600 dark:text-gray-300' }}">
                            2
                        </div>
                        <p class="mt-2 text-xs font-semibold {{ $currentStep >= 2 ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400' }}">Lengkapi Data</p>
                    </div>
                </div>
            </div>

            @if (session()->has('error'))
                <div class="mx-6 mt-6 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded">
                    <p class="text-red-800 dark:text-red-300">{{ session('error') }}</p>
                </div>
            @endif

            @if (session()->has('success'))
                <div class="mx-6 mt-6 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 p-4 rounded">
                    <p class="text-green-800 dark:text-green-300">{{ session('success') }}</p>
                </div>
            @endif

            <!-- STEP 1: Upload Bukti Transfer -->
            @if($currentStep == 1)
                <form wire:submit.prevent="submitStep1" class="px-6 sm:px-8 py-8 relative">
                    
                    <div class="mb-8 rounded-xl shadow-lg border-2 border-blue-100 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700 px-6 py-4 border-b-2 border-blue-200 dark:border-gray-600">
                            <h2 class="text-xl font-bold text-blue-800 dark:text-blue-400 flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                Upload Bukti Transfer Pembayaran Uang Masuk
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 dark:border-blue-400 p-4 mb-6 rounded-r-lg">
                                <p class="text-sm text-blue-700 dark:text-blue-300">
                                    <strong>Langkah 1:</strong> Silakan upload bukti transfer pembayaran uang masuk terlebih dahulu. Setelah itu, Anda akan melanjutkan ke form pengisian data lengkap.
                                </p>
                            </div>

                            <div x-data="{ uploading: false, progress: 0, uploaded: false }"
                                 x-on:livewire-upload-start.window="uploading = true; progress = 0; uploaded = false"
                                 x-on:livewire-upload-progress.window="progress = $event.detail.progress"
                                 x-on:livewire-upload-finish.window="uploading = false; uploaded = true"
                                 x-on:livewire-upload-error.window="uploading = false; uploaded = false">
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">
                                    Bukti Transfer <span class="text-red-500 dark:text-red-400">*</span>
                                </label>
                                <input type="file" wire:model="fototransfer" accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-sm file:bg-blue-500 file:border-0 file:text-white file:px-4 file:py-2 file:rounded-md file:cursor-pointer file:font-semibold dark:text-gray-300">
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">PDF, JPG, PNG (Max. 2MB)</p>
                                @error('fototransfer') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror

                                {{-- Progress Bar (real-time dari Livewire upload events) --}}
                                <div x-show="uploading" x-cloak class="mt-4 bg-white dark:bg-gray-800 rounded-lg border border-blue-200 dark:border-blue-800 p-4 shadow-sm">
                                    <div class="flex items-center gap-3 mb-3">
                                        <svg class="animate-spin h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-semibold text-blue-800 dark:text-blue-300">Mengupload Berkas...</p>
                                            <p class="text-xs text-blue-600 dark:text-blue-400" x-text="progress + '%'"></p>
                                        </div>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-400 dark:to-blue-500 rounded-full transition-all duration-300 ease-out"
                                             :style="'width: ' + progress + '%'"></div>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Mohon tunggu, jangan tutup halaman ini...</p>
                                </div>

                                {{-- Success Indicator (setelah upload ke temp selesai) --}}
                                <div x-show="uploaded" x-cloak class="mt-4 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-2 border-green-300 dark:border-green-700 rounded-xl p-5 shadow-sm">
                                    <div class="flex items-center gap-4">
                                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-green-100 dark:bg-green-800/50 flex items-center justify-center">
                                            <svg class="w-7 h-7 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-base font-bold text-green-800 dark:text-green-300">✓ File Berhasil Diupload!</p>
                                            <p class="text-sm text-green-600 dark:text-green-400 mt-0.5">
                                                @if ($fototransfer)
                                                    {{ $fototransfer->getClientOriginalName() }} — Siap diproses
                                                @endif
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <svg class="w-6 h-6 text-green-400 dark:text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                {{-- Nama file preview (fallback) --}}
                                @if ($fototransfer && !$errors->has('fototransfer'))
                                    <div class="mt-3 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg"
                                         x-show="!uploading && !uploaded">
                                        <p class="text-sm text-blue-700 dark:text-blue-300 flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $fototransfer->getClientOriginalName() }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl shadow-lg border-2 border-gray-200 dark:border-gray-700 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-gray-800 dark:to-gray-700 p-4 sm:p-6">
                        <div class="flex flex-col-reverse sm:flex-row gap-3">
                            <a href="/" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 sm:py-4 px-4 sm:px-6 rounded-lg transition text-center flex items-center justify-center gap-2 active:bg-gray-800 dark:active:bg-gray-900">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span>Beranda</span>
                            </a>
                            <button type="submit" wire:loading.attr="disabled" 
                                    class="flex-1 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-3 sm:py-4 px-4 sm:px-6 rounded-lg transition-all duration-300 flex items-center justify-center gap-2 active:from-green-700 active:to-emerald-700 dark:active:from-green-800 dark:active:to-emerald-800 disabled:opacity-60 disabled:cursor-not-allowed disabled:hover:from-green-600 disabled:hover:to-emerald-600 relative overflow-hidden group">
                                {{-- Default state --}}
                                <span wire:loading.remove wire:target="submitStep1" class="flex items-center justify-center gap-2">
                                    <span>Lanjutkan ke Form Data</span>
                                    <svg class="w-5 h-5 flex-shrink-0 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </span>
                                {{-- Loading state di dalam tombol --}}
                                <span wire:loading wire:target="submitStep1" class="flex items-center justify-center gap-3 w-full">
                                    {{-- Animated spinner --}}
                                    <svg class="animate-spin h-5 w-5 flex-shrink-0 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-30" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-100" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    {{-- Pulsing text --}}
                                    <span class="animate-pulse font-semibold">Menyimpan...</span>
                                    {{-- Bouncing dots --}}
                                    <span class="flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 bg-white rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                                        <span class="w-1.5 h-1.5 bg-white rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                                        <span class="w-1.5 h-1.5 bg-white rounded-full animate-bounce" style="animation-delay: 300ms"></span>
                                    </span>
                                </span>
                                {{-- Progress bar animasi di bottom tombol --}}
                                <span wire:loading wire:target="submitStep1" 
                                      class="absolute bottom-0 left-0 h-1 bg-gradient-to-r from-green-300 via-white to-green-300 animate-pulse rounded-full"
                                      style="width: 65%"></span>
                            </button>
                        </div>
                    </div>
                </form>
            @endif

            <!-- STEP 2: Form Lengkap (UI/UX sama seperti sebelumnya) -->
            @if($currentStep == 2)
                <form wire:submit.prevent="submit" class="px-6 sm:px-8 py-8">

                    {{-- DATA PRIBADI --}}
                    <div class="mb-8 rounded-xl shadow-lg border-2 border-green-100 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-gray-800 dark:to-gray-700 px-6 py-4 border-b-2 border-green-200 dark:border-gray-600">
                            <h2 class="text-xl font-bold text-green-800 dark:text-green-400 flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Data Pribadi Siswa
                            </h2>
                        </div>
                        <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Nama Lengkap <span class="text-red-500 dark:text-red-400">*</span></label>
                                <input type="text" wire:model="nama" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none @error('nama') border-red-500 @enderror">
                                @error('nama') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Tempat Lahir <span class="text-red-500 dark:text-red-400">*</span></label>
                                <input type="text" wire:model="tempat_lahir" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none @error('tempat_lahir') border-red-500 @enderror">
                                @error('tempat_lahir') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Tanggal Lahir <span class="text-red-500 dark:text-red-400">*</span></label>
                                <input type="date" wire:model="tanggal_lahir" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none @error('tanggal_lahir') border-red-500 @enderror">
                                @error('tanggal_lahir') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">NIK (Nomor Induk Keluarga) <span class="text-red-500 dark:text-red-400">*</span></label>
                                <input type="text" wire:model="nik" maxlength="16" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                @error('nik') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">NISN (Nomor Induk Siswa Nasional) <span class="text-red-500 dark:text-red-400">*</span></label>
                                <input type="text" wire:model="nisn" maxlength="10" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                @error('nisn') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Nomor Kartu Keluarga (KK)</label>
                                <input type="text" wire:model="kk" maxlength="16" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">16 digit nomor KK (jika ada)</p>
                                @error('kk') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Anak Ke- <span class="text-red-500 dark:text-red-400">*</span></label>
                                <input type="number" wire:model="anak_ke" min="1" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                @error('anak_ke') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Jumlah Saudara <span class="text-red-500 dark:text-red-400">*</span></label>
                                <input type="number" wire:model="jumlah_saudara" min="0" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                @error('jumlah_saudara') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                    {{-- DATA SEKOLAH --}}
                    <div class="mb-8 rounded-xl shadow-lg border-2 border-blue-100 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700 px-6 py-4 border-b-2 border-blue-200 dark:border-gray-600">
                            <h2 class="text-xl font-bold text-blue-800 dark:text-blue-400 flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                Data Sekolah Sebelumnya
                            </h2>
                        </div>
                        <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Nama Sekolah <span class="text-red-500 dark:text-red-400">*</span></label>
                                <input type="text" wire:model="nama_sekolah_sebelumnya" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                @error('nama_sekolah_sebelumnya') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">NPSN (Nomor Pokok Sekolah Nasional) <span class="text-red-500 dark:text-red-400">*</span></label>
                                <input type="text" wire:model="npsn_sekolah_sebelumnya" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                @error('npsn_sekolah_sebelumnya') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Alamat Sekolah <span class="text-red-500 dark:text-red-400">*</span></label>
                                <textarea wire:model="alamat_sekolah_sebelumnya" rows="3" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none resize-none"></textarea>
                                @error('alamat_sekolah_sebelumnya') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                    {{-- DATA ORANG TUA --}}
                    <div class="mb-8 rounded-xl shadow-lg border-2 border-purple-100 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-gray-800 dark:to-gray-700 px-6 py-4 border-b-2 border-purple-200 dark:border-gray-600">
                            <h2 class="text-xl font-bold text-purple-800 dark:text-purple-400 flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Data Orang Tua
                            </h2>
                        </div>
                        <div class="p-6">
                        
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Data Ayah</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Nama Ayah <span class="text-red-500 dark:text-red-400">*</span></label>
                                <input type="text" wire:model="nama_ayah" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                @error('nama_ayah') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">NIK Ayah (Nomor Induk Keluarga) <span class="text-red-500 dark:text-red-400">*</span></label>
                                <input type="text" wire:model="nik_ayah" maxlength="16" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                @error('nik_ayah') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Tempat Lahir Ayah <span class="text-red-500 dark:text-red-400">*</span></label>
                                <input type="text" wire:model="tempat_lahir_ayah" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                @error('tempat_lahir_ayah') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Tanggal Lahir Ayah <span class="text-red-500 dark:text-red-400">*</span></label>
                                <input type="date" wire:model="tanggal_lahir_ayah" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                @error('tanggal_lahir_ayah') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">No HP Ayah <span class="text-red-500 dark:text-red-400">*</span></label>
                                <input type="tel" wire:model="no_hp_ayah" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                @error('no_hp_ayah') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Pendidikan Ayah <span class="text-red-500 dark:text-red-400">*</span></label>
                                <select wire:model="pendidikan_ayah" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                    <option value="">Pilih Pendidikan</option>
                                    <option value="SD/Sederajat">SD/Sederajat</option>
                                    <option value="SMP/Sederajat">SMP/Sederajat</option>
                                    <option value="SMA/Sederajat">SMA/Sederajat</option>
                                    <option value="D1">D1</option>
                                    <option value="D2">D2</option>
                                    <option value="D3">D3</option>
                                    <option value="D4/S1">D4/S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                    <option value="Tidak Bersekolah">Tidak Bersekolah</option>
                                </select>
                                @error('pendidikan_ayah') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Pekerjaan Ayah <span class="text-red-500 dark:text-red-400">*</span></label>
                                <select wire:model.live="pekerjaan_ayah" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                    <option value="">Pilih Pekerjaan</option>
                                    <option value="Tidak Bekerja">Tidak Bekerja</option>
                                    <option value="Pensiunan">Pensiunan</option>
                                    <option value="PNS">PNS</option>
                                    <option value="TNI/Polisi">TNI/Polisi</option>
                                    <option value="Guru/Dosen">Guru/Dosen</option>
                                    <option value="Pegawai Swasta">Pegawai Swasta</option>
                                    <option value="Wiraswasta">Wiraswasta</option>
                                    <option value="Pengacara/Jaksa/Hakim/Notaris">Pengacara/Jaksa/Hakim/Notaris</option>
                                    <option value="Seniman/Pelukis/Artis/Sejenis">Seniman/Pelukis/Artis/Sejenis</option>
                                    <option value="Dokter/Bidan/Perawat">Dokter/Bidan/Perawat</option>
                                    <option value="Pilot/Pramugara">Pilot/Pramugara</option>
                                    <option value="Pedagang">Pedagang</option>
                                    <option value="Petani/Peternak">Petani/Peternak</option>
                                    <option value="Nelayan">Nelayan</option>
                                    <option value="Buruh (Tani/Pabrik/Bangunan)">Buruh (Tani/Pabrik/Bangunan)</option>
                                    <option value="Sopir/Masinis/Kondektur">Sopir/Masinis/Kondektur</option>
                                    <option value="Politikus">Politikus</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                @error('pekerjaan_ayah') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Penghasilan Ayah <span class="text-red-500 dark:text-red-400">*</span></label>
                                <select wire:model="penghasilan_ayah" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                    <option value="">Pilih Penghasilan</option>
                                    <option value="Tidak Ada">Tidak Ada</option>
                                    <option value="Dibawah 800.000">Dibawah 800.000</option>
                                    <option value="800.001 - 1.200.000">800.001 - 1.200.000</option>
                                    <option value="1.200.001 - 1.800.000">1.200.001 - 1.800.000</option>
                                    <option value="1.800.001 - 2.500.000">1.800.001 - 2.500.000</option>
                                    <option value="2.500.001 - 3.500.000">2.500.001 - 3.500.000</option>
                                    <option value="3.500.001 - 4.800.000">3.500.001 - 4.800.000</option>
                                    <option value="4.800.001 - 6.500.000">4.800.001 - 6.500.000</option>
                                    <option value="6.500.001 - 10.000.000">6.500.001 - 10.000.000</option>
                                    <option value="10.000.001 - 20.000.000">10.000.001 - 20.000.000</option>
                                    <option value="Diatas 20.000.001">Diatas 20.000.001</option>
                                </select>
                                @error('penghasilan_ayah') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Data Ibu</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Nama Ibu <span class="text-red-500 dark:text-red-400">*</span></label>
                                <input type="text" wire:model="nama_ibu" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                @error('nama_ibu') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">NIK Ibu (Nomor Induk Keluarga) <span class="text-red-500 dark:text-red-400">*</span></label>
                                <input type="text" wire:model="nik_ibu" maxlength="16" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                @error('nik_ibu') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Tempat Lahir Ibu <span class="text-red-500 dark:text-red-400">*</span></label>
                                <input type="text" wire:model="tempat_lahir_ibu" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                @error('tempat_lahir_ibu') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Tanggal Lahir Ibu <span class="text-red-500 dark:text-red-400">*</span></label>
                                <input type="date" wire:model="tanggal_lahir_ibu" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                @error('tanggal_lahir_ibu') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">No HP Ibu <span class="text-red-500 dark:text-red-400">*</span></label>
                                <input type="tel" wire:model="no_hp_ibu" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                @error('no_hp_ibu') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Pendidikan Ibu <span class="text-red-500 dark:text-red-400">*</span></label>
                                <select wire:model="pendidikan_ibu" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                    <option value="">Pilih Pendidikan</option>
                                    <option value="SD/Sederajat">SD/Sederajat</option>
                                    <option value="SMP/Sederajat">SMP/Sederajat</option>
                                    <option value="SMA/Sederajat">SMA/Sederajat</option>
                                    <option value="D1">D1</option>
                                    <option value="D2">D2</option>
                                    <option value="D3">D3</option>
                                    <option value="D4/S1">D4/S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                    <option value="Tidak Bersekolah">Tidak Bersekolah</option>
                                </select>
                                @error('pendidikan_ibu') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Pekerjaan Ibu <span class="text-red-500 dark:text-red-400">*</span></label>
                                <select wire:model.live="pekerjaan_ibu" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                    <option value="">Pilih Pekerjaan</option>
                                    <option value="Tidak Bekerja">Tidak Bekerja</option>
                                    <option value="Pensiunan">Pensiunan</option>
                                    <option value="PNS">PNS</option>
                                    <option value="TNI/Polisi">TNI/Polisi</option>
                                    <option value="Guru/Dosen">Guru/Dosen</option>
                                    <option value="Pegawai Swasta">Pegawai Swasta</option>
                                    <option value="Wiraswasta">Wiraswasta</option>
                                    <option value="Pengacara/Jaksa/Hakim/Notaris">Pengacara/Jaksa/Hakim/Notaris</option>
                                    <option value="Seniman/Pelukis/Artis/Sejenis">Seniman/Pelukis/Artis/Sejenis</option>
                                    <option value="Dokter/Bidan/Perawat">Dokter/Bidan/Perawat</option>
                                    <option value="Pilot/Pramugara">Pilot/Pramugara</option>
                                    <option value="Pedagang">Pedagang</option>
                                    <option value="Petani/Peternak">Petani/Peternak</option>
                                    <option value="Nelayan">Nelayan</option>
                                    <option value="Buruh (Tani/Pabrik/Bangunan)">Buruh (Tani/Pabrik/Bangunan)</option>
                                    <option value="Sopir/Masinis/Kondektur">Sopir/Masinis/Kondektur</option>
                                    <option value="Politikus">Politikus</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                @error('pekerjaan_ibu') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Penghasilan Ibu <span class="text-red-500 dark:text-red-400">*</span></label>
                                <select wire:model="penghasilan_ibu" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                    <option value="">Pilih Penghasilan</option>
                                    <option value="Tidak Ada">Tidak Ada</option>
                                    <option value="Dibawah 800.000">Dibawah 800.000</option>
                                    <option value="800.001 - 1.200.000">800.001 - 1.200.000</option>
                                    <option value="1.200.001 - 1.800.000">1.200.001 - 1.800.000</option>
                                    <option value="1.800.001 - 2.500.000">1.800.001 - 2.500.000</option>
                                    <option value="2.500.001 - 3.500.000">2.500.001 - 3.500.000</option>
                                    <option value="3.500.001 - 4.800.000">3.500.001 - 4.800.000</option>
                                    <option value="4.800.001 - 6.500.000">4.800.001 - 6.500.000</option>
                                    <option value="6.500.001 - 10.000.000">6.500.001 - 10.000.000</option>
                                    <option value="10.000.001 - 20.000.000">10.000.001 - 20.000.000</option>
                                    <option value="Diatas 20.000.001">Diatas 20.000.001</option>
                                </select>
                                @error('penghasilan_ibu') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                    {{-- ALAMAT --}}
                    <div class="mb-8 rounded-xl shadow-lg border-2 border-amber-100 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
                        <div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-gray-800 dark:to-gray-700 px-6 py-4 border-b-2 border-amber-200 dark:border-gray-600">
                            <h2 class="text-xl font-bold text-amber-800 dark:text-amber-400 flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Data Alamat
                            </h2>
                        </div>
                        <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Desa/Kelurahan <span class="text-red-500 dark:text-red-400">*</span></label>
                                <input type="text" wire:model="desa" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                @error('desa') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Kecamatan <span class="text-red-500 dark:text-red-400">*</span></label>
                                <input type="text" wire:model="kecamatan" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                @error('kecamatan') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Kabupaten/Kota <span class="text-red-500 dark:text-red-400">*</span></label>
                                <input type="text" wire:model="kabupaten" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                @error('kabupaten') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Provinsi <span class="text-red-500 dark:text-red-400">*</span></label>
                                <input type="text" wire:model="provinsi" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-green-500 dark:focus:border-green-400 focus:outline-none">
                                @error('provinsi') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                    {{-- UPLOAD DOKUMEN --}}
                    <div class="mb-8 rounded-xl shadow-lg border-2 border-teal-100 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
                        <div class="bg-gradient-to-r from-teal-50 to-cyan-50 dark:from-gray-800 dark:to-gray-700 px-6 py-4 border-b-2 border-teal-200 dark:border-gray-600">
                            <h2 class="text-xl font-bold text-teal-800 dark:text-teal-400 flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Upload Dokumen
                            </h2>
                        </div>
                        <div class="p-6">
                        
                        <div x-data="{ kkUpload: { uploading: false, progress: 0, uploaded: false }, aktaUpload: { uploading: false, progress: 0, uploaded: false } }"
                             x-on:livewire-upload-start.window="let m = $event.detail?.model || $event.target.getAttribute?.('wire:model'); if (m === 'fotokk') { kkUpload.uploading = true; kkUpload.progress = 0; kkUpload.uploaded = false } else if (m === 'fotoakta') { aktaUpload.uploading = true; aktaUpload.progress = 0; aktaUpload.uploaded = false }"
                             x-on:livewire-upload-progress.window="let m = $event.detail?.model || $event.target.getAttribute?.('wire:model'); if (m === 'fotokk') kkUpload.progress = $event.detail.progress; else if (m === 'fotoakta') aktaUpload.progress = $event.detail.progress"
                             x-on:livewire-upload-finish.window="let m = $event.detail?.model || $event.target.getAttribute?.('wire:model'); if (m === 'fotokk') { kkUpload.uploading = false; kkUpload.uploaded = true } else if (m === 'fotoakta') { aktaUpload.uploading = false; aktaUpload.uploaded = true }"
                             x-on:livewire-upload-error.window="let m = $event.detail?.model || $event.target.getAttribute?.('wire:model'); if (m === 'fotokk') { kkUpload.uploading = false; kkUpload.uploaded = false } else if (m === 'fotoakta') { aktaUpload.uploading = false; aktaUpload.uploaded = false }">
                            <div class="space-y-6">
                            {{-- KK --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">
                                    Foto Kartu Keluarga (KK) <span class="text-red-500 dark:text-red-400">*</span>
                                </label>
                                <input type="file" wire:model.live="fotokk" accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-sm file:bg-green-500 file:border-0 file:text-white file:px-4 file:py-2 file:rounded-md file:cursor-pointer file:font-semibold dark:text-gray-300">
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">PDF, JPG, PNG (Max. 2MB)</p>
                                @error('fotokk') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror

                                {{-- Progress Bar KK --}}
                                <div x-show="kkUpload.uploading" x-cloak class="mt-4 bg-white dark:bg-gray-800 rounded-lg border border-teal-200 dark:border-teal-800 p-4 shadow-sm">
                                    <div class="flex items-center gap-3 mb-3">
                                        <svg class="animate-spin h-5 w-5 text-teal-600 dark:text-teal-400" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-semibold text-teal-800 dark:text-teal-300">Mengupload KK...</p>
                                            <p class="text-xs text-teal-600 dark:text-teal-400" x-text="kkUpload.progress + '%'"></p>
                                        </div>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-teal-500 to-teal-600 dark:from-teal-400 dark:to-teal-500 rounded-full transition-all duration-300 ease-out"
                                             :style="'width: ' + kkUpload.progress + '%'"></div>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Mohon tunggu, jangan tutup halaman ini...</p>
                                </div>

                                {{-- Success Indicator KK --}}
                                <div x-show="kkUpload.uploaded" x-cloak class="mt-4 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-2 border-green-300 dark:border-green-700 rounded-xl p-5 shadow-sm">
                                    <div class="flex items-center gap-4">
                                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-green-100 dark:bg-green-800/50 flex items-center justify-center">
                                            <svg class="w-7 h-7 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-base font-bold text-green-800 dark:text-green-300">✓ KK Berhasil Diupload!</p>
                                            <p class="text-sm text-green-600 dark:text-green-400 mt-0.5">
                                                @if ($fotokk)
                                                    {{ $fotokk->getClientOriginalName() }} — Siap diproses
                                                @endif
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <svg class="w-6 h-6 text-green-400 dark:text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                {{-- Preview Gambar KK (otomatis muncul setelah wire:model.live selesai upload) --}}
                                @if ($fotokk)
                                    <div class="mt-3 animate-fadeIn">
                                        @if (in_array($fotokk->getClientOriginalExtension(), ['jpg', 'jpeg', 'png']))
                                            <div class="rounded-lg border-2 border-teal-200 dark:border-teal-800 overflow-hidden bg-white dark:bg-gray-800 shadow-sm">
                                                <div class="px-3 py-2 bg-teal-50 dark:bg-gray-700 border-b border-teal-200 dark:border-teal-800 flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <span class="text-xs font-semibold text-teal-700 dark:text-teal-300">Preview KK</span>
                                                </div>
                                                <img src="{{ $fotokk->temporaryUrl() }}" alt="Preview Kartu Keluarga" class="w-full h-auto max-h-80 object-contain p-2">
                                            </div>
                                        @else
                                            <div class="rounded-lg border-2 border-teal-200 dark:border-teal-800 p-6 text-center bg-teal-50 dark:bg-teal-900/20">
                                                <svg class="w-12 h-12 mx-auto text-teal-400 dark:text-teal-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                </svg>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">File PDF — Preview tidak tersedia</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $fotokk->getClientOriginalName() }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                {{-- Nama file preview KK (fallback) --}}
                                @if ($fotokk && !$errors->has('fotokk'))
                                    <div class="mt-3 p-3 bg-teal-50 dark:bg-teal-900/20 border border-teal-200 dark:border-teal-800 rounded-lg"
                                         x-show="!kkUpload.uploading && !kkUpload.uploaded">
                                        <p class="text-sm text-teal-700 dark:text-teal-300 flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $fotokk->getClientOriginalName() }}
                                        </p>
                                    </div>
                                @endif
                            </div>

                            {{-- Akta --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">
                                    Foto Akta Kelahiran <span class="text-red-500 dark:text-red-400">*</span>
                                </label>
                                <input type="file" wire:model.live="fotoakta" accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-sm file:bg-green-500 file:border-0 file:text-white file:px-4 file:py-2 file:rounded-md file:cursor-pointer file:font-semibold dark:text-gray-300">
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">PDF, JPG, PNG (Max. 2MB)</p>
                                @error('fotoakta') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror

                                {{-- Progress Bar Akta --}}
                                <div x-show="aktaUpload.uploading" x-cloak class="mt-4 bg-white dark:bg-gray-800 rounded-lg border border-purple-200 dark:border-purple-800 p-4 shadow-sm">
                                    <div class="flex items-center gap-3 mb-3">
                                        <svg class="animate-spin h-5 w-5 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-semibold text-purple-800 dark:text-purple-300">Mengupload Akta...</p>
                                            <p class="text-xs text-purple-600 dark:text-purple-400" x-text="aktaUpload.progress + '%'"></p>
                                        </div>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-purple-500 to-purple-600 dark:from-purple-400 dark:to-purple-500 rounded-full transition-all duration-300 ease-out"
                                             :style="'width: ' + aktaUpload.progress + '%'"></div>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Mohon tunggu, jangan tutup halaman ini...</p>
                                </div>

                                {{-- Success Indicator Akta --}}
                                <div x-show="aktaUpload.uploaded" x-cloak class="mt-4 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-2 border-green-300 dark:border-green-700 rounded-xl p-5 shadow-sm">
                                    <div class="flex items-center gap-4">
                                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-green-100 dark:bg-green-800/50 flex items-center justify-center">
                                            <svg class="w-7 h-7 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-base font-bold text-green-800 dark:text-green-300">✓ Akta Berhasil Diupload!</p>
                                            <p class="text-sm text-green-600 dark:text-green-400 mt-0.5">
                                                @if ($fotoakta)
                                                    {{ $fotoakta->getClientOriginalName() }} — Siap diproses
                                                @endif
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <svg class="w-6 h-6 text-green-400 dark:text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                {{-- Preview Gambar Akta (otomatis muncul setelah wire:model.live selesai upload) --}}
                                @if ($fotoakta)
                                    <div class="mt-3 animate-fadeIn">
                                        @if (in_array($fotoakta->getClientOriginalExtension(), ['jpg', 'jpeg', 'png']))
                                            <div class="rounded-lg border-2 border-purple-200 dark:border-purple-800 overflow-hidden bg-white dark:bg-gray-800 shadow-sm">
                                                <div class="px-3 py-2 bg-purple-50 dark:bg-gray-700 border-b border-purple-200 dark:border-purple-800 flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <span class="text-xs font-semibold text-purple-700 dark:text-purple-300">Preview Akta</span>
                                                </div>
                                                <img src="{{ $fotoakta->temporaryUrl() }}" alt="Preview Akta Kelahiran" class="w-full h-auto max-h-80 object-contain p-2">
                                            </div>
                                        @else
                                            <div class="rounded-lg border-2 border-purple-200 dark:border-purple-800 p-6 text-center bg-purple-50 dark:bg-purple-900/20">
                                                <svg class="w-12 h-12 mx-auto text-purple-400 dark:text-purple-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                </svg>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">File PDF — Preview tidak tersedia</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $fotoakta->getClientOriginalName() }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                {{-- Nama file preview Akta (fallback) --}}
                                @if ($fotoakta && !$errors->has('fotoakta'))
                                    <div class="mt-3 p-3 bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg"
                                         x-show="!aktaUpload.uploading && !aktaUpload.uploaded">
                                        <p class="text-sm text-purple-700 dark:text-purple-300 flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $fotoakta->getClientOriginalName() }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                    {{-- SUBMIT --}}
                    <div class="rounded-xl shadow-lg border-2 border-gray-200 dark:border-gray-700 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-gray-800 dark:to-gray-700 p-4 sm:p-6">
                        <div class="flex flex-col-reverse sm:flex-row gap-3">
                            <a href="/" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 sm:py-4 px-4 sm:px-6 rounded-lg transition flex items-center justify-center gap-2 active:bg-gray-800 dark:active:bg-gray-900">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span>Beranda</span>
                            </a>
                            <button type="submit" wire:loading.attr="disabled" 
                                    class="flex-1 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-3 sm:py-4 px-4 sm:px-6 rounded-lg transition-all duration-300 flex items-center justify-center gap-2 active:from-green-700 active:to-emerald-700 dark:active:from-green-800 dark:active:to-emerald-800 disabled:opacity-60 disabled:cursor-not-allowed disabled:hover:from-green-600 disabled:hover:to-emerald-600 relative overflow-hidden group">
                                {{-- Default state --}}
                                <span wire:loading.remove wire:target="submit" class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5 flex-shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Simpan Data</span>
                                </span>
                                {{-- Loading state di dalam tombol --}}
                                <span wire:loading wire:target="submit" class="flex items-center justify-center gap-3 w-full">
                                    {{-- Animated spinner --}}
                                    <svg class="animate-spin h-5 w-5 flex-shrink-0 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-30" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-100" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    {{-- Pulsing text --}}
                                    <span class="animate-pulse font-semibold">Menyimpan...</span>
                                    {{-- Bouncing dots --}}
                                    <span class="flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 bg-white rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                                        <span class="w-1.5 h-1.5 bg-white rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                                        <span class="w-1.5 h-1.5 bg-white rounded-full animate-bounce" style="animation-delay: 300ms"></span>
                                    </span>
                                </span>
                                {{-- Progress bar animasi di bottom tombol --}}
                                <span wire:loading wire:target="submit" 
                                      class="absolute bottom-0 left-0 h-1 bg-gradient-to-r from-green-300 via-white to-green-300 animate-pulse rounded-full"
                                      style="width: 65%"></span>
                            </button>
                        </div>
                    </div>
                </form>
            @endif
            </div>
        @endif
    </div>
</div>

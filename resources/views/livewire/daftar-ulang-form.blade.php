<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        @if($submitted)
            <!-- Success Page -->
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">
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
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg border-2 border-green-200 p-6 mb-6">
                        <h3 class="text-xl font-bold text-green-800 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Data Siswa
                        </h3>
                        
                        <div class="space-y-3">
                            <div class="flex flex-col sm:flex-row sm:gap-4">
                                <span class="font-semibold text-gray-700 sm:w-32">Nama</span>
                                <span class="text-gray-900 font-bold text-lg">{{ $nama }}</span>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row sm:gap-4">
                                <span class="font-semibold text-gray-700 sm:w-32">Tempat, Tgl Lahir</span>
                                <span class="text-gray-900">{{ $tempat_lahir }}, {{ \Carbon\Carbon::parse($tanggal_lahir)->isoFormat('D MMMM YYYY') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Alamat -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg border-2 border-blue-200 p-6 mb-6">
                        <h3 class="text-lg font-bold text-blue-800 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Alamat
                        </h3>
                        
                        <div class="bg-white rounded-lg p-4 space-y-2">
                            <div class="flex flex-col sm:flex-row sm:gap-4">
                                <span class="font-semibold text-gray-700 sm:w-32">Desa/Kelurahan</span>
                                <span class="text-gray-900">{{ $desa }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:gap-4">
                                <span class="font-semibold text-gray-700 sm:w-32">Kecamatan</span>
                                <span class="text-gray-900">{{ $kecamatan }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:gap-4">
                                <span class="font-semibold text-gray-700 sm:w-32">Kabupaten/Kota</span>
                                <span class="text-gray-900">{{ $kabupaten }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:gap-4">
                                <span class="font-semibold text-gray-700 sm:w-32">Provinsi</span>
                                <span class="text-gray-900">{{ $provinsi }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Data Orang Tua -->
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-lg border-2 border-purple-200 p-6 mb-6">
                        <h3 class="text-lg font-bold text-purple-800 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Data Orang Tua
                        </h3>
                        
                        <div class="space-y-3">
                            <div class="bg-white rounded-lg p-4">
                                <p class="text-sm text-gray-600 mb-1">Nama Ayah</p>
                                <p class="text-gray-900 font-semibold text-lg">{{ $nama_ayah }}</p>
                            </div>
                            <div class="bg-white rounded-lg p-4">
                                <p class="text-sm text-gray-600 mb-1">Nama Ibu</p>
                                <p class="text-gray-900 font-semibold text-lg">{{ $nama_ibu }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Ucapan Terima Kasih Bahasa Arab -->
                    <div class="bg-gradient-to-r from-amber-50 to-yellow-50 rounded-lg border-2 border-amber-300 px-6 py-8 text-center mb-6">
                        <div class="mb-4">
                            <p class="text-5xl font-arabic text-gray-800 mb-3" style="font-family: 'Traditional Arabic', 'Scheherazade', 'Amiri', serif; line-height: 1.6;">
                                جَزَاكُمُ اللهُ خَيْرًا
                            </p>
                            <p class="text-3xl text-gray-700 mb-2" style="font-family: 'Traditional Arabic', 'Scheherazade', 'Amiri', serif; line-height: 1.6;">
                                بَارَكَ اللهُ فِيْكُمْ
                            </p>
                        </div>
                        <p class="text-gray-600 text-base mb-4 italic">
                            "Semoga Allah memberikan balasan yang baik kepada kalian dan memberkahi kalian"
                        </p>
                        <div class="bg-white rounded-lg p-4 max-w-lg mx-auto border border-amber-200">
                            <p class="text-gray-700 text-lg leading-relaxed">
                                Terima kasih telah melakukan pendaftaran ulang di
                                <br>
                                <span class="font-bold text-green-700 text-xl">Pondok Pesantren Syafa'aturrasul</span>
                            </p>
                        </div>
                    </div>

                    <!-- Informasi Selanjutnya -->
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 border-l-4 border-amber-500 p-4 mb-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-amber-900 font-semibold mb-1">Informasi Selanjutnya</p>
                                <p class="text-amber-800 text-sm">
                                    Data Anda telah tersimpan. Silakan tunggu informasi selanjutnya dari pihak sekolah mengenai jadwal tes dan pengumuman.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex flex-col-reverse md:flex-row gap-3">
                        <a href="{{ route('daftar-ulang.table') }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 sm:py-4 px-4 sm:px-6 rounded-lg transition duration-200 text-center flex items-center justify-center gap-2 active:bg-gray-800">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                            </svg>
                            <span>Kembali ke Daftar</span>
                        </a>
                        <a href="/" class="flex-1 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-3 sm:py-4 px-4 sm:px-6 rounded-lg transition duration-200 text-center flex items-center justify-center gap-2 active:from-green-700 active:to-emerald-700">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span>Beranda</span>
                        </a>
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-green-50 border-t border-green-200 px-6 sm:px-8 py-4 text-center">
                    <p class="text-sm text-gray-600">
                        Data tersimpan dengan aman di sistem <span class="font-semibold text-green-700">Pondok Pesantren Syafa'aturrasul</span>
                    </p>
                </div>
            </div>
        @else
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 sm:px-8 py-8 text-center">
                <h1 class="text-2xl sm:text-3xl font-bold text-white mb-3">Form Pendaftaran Ulang</h1>
                
                <!-- Badge Jenjang Pendidikan -->
                <div class="inline-block bg-white px-6 py-2 rounded-lg mb-3 shadow-md">
                    <p class="text-gray-900 font-bold text-base sm:text-lg">{{ $jenjangPendidikan }}</p>
                </div>
                
                <p class="text-green-100 text-sm sm:text-base">Pondok Pesantren Syafa'aturrasul</p>
                <p class="text-green-200 text-xs sm:text-sm mt-1">Tahun Ajaran {{ $tahun_ajaran }}</p>
            </div>

            <!-- Step Indicator -->
            <div class="px-6 sm:px-8 py-6 bg-gray-50 border-b">
                <div class="flex items-center justify-between max-w-2xl mx-auto">
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $currentStep >= 1 ? 'bg-green-600 text-white' : 'bg-gray-300 text-gray-600' }}">
                            @if($currentStep > 1)
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @else
                                1
                            @endif
                        </div>
                        <p class="mt-2 text-xs font-semibold {{ $currentStep >= 1 ? 'text-green-600' : 'text-gray-500' }}">Upload Bukti Transfer</p>
                    </div>
                    
                    <div class="flex-1 h-1 mx-4 {{ $currentStep > 1 ? 'bg-green-600' : 'bg-gray-300' }}"></div>
                    
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $currentStep >= 2 ? 'bg-green-600 text-white' : 'bg-gray-300 text-gray-600' }}">
                            2
                        </div>
                        <p class="mt-2 text-xs font-semibold {{ $currentStep >= 2 ? 'text-green-600' : 'text-gray-500' }}">Lengkapi Data</p>
                    </div>
                </div>
            </div>

            @if (session()->has('error'))
                <div class="mx-6 mt-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                    <p class="text-red-800">{{ session('error') }}</p>
                </div>
            @endif

            @if (session()->has('success'))
                <div class="mx-6 mt-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <!-- STEP 1: Upload Bukti Transfer -->
            @if($currentStep == 1)
                <form wire:submit.prevent="submitStep1" class="px-6 sm:px-8 py-8">
                    <div class="mb-8 rounded-xl shadow-lg border-2 border-blue-100 bg-white overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b-2 border-blue-200">
                            <h2 class="text-xl font-bold text-blue-800 flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                Upload Bukti Transfer Pembayaran Uang Masuk
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg">
                                <p class="text-sm text-blue-700">
                                    <strong>Langkah 1:</strong> Silakan upload bukti transfer pembayaran uang masuk terlebih dahulu. Setelah itu, Anda akan melanjutkan ke form pengisian data lengkap.
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">
                                    Bukti Transfer <span class="text-red-500">*</span>
                                </label>
                                <input type="file" wire:model="fototransfer" accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-sm file:bg-blue-500 file:border-0 file:text-white file:px-4 file:py-2 file:rounded-md file:cursor-pointer file:font-semibold">
                                <p class="text-xs text-gray-600 mt-2">PDF, JPG, PNG (Max. 5MB)</p>
                                @error('fototransfer') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                                @if ($fototransfer)
                                    <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                        <p class="text-sm text-blue-700 flex items-center gap-2">
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

                    <div class="rounded-xl shadow-lg border-2 border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50 p-4 sm:p-6">
                        <div class="flex flex-col-reverse sm:flex-row gap-3">
                            <a href="{{ route('daftar-ulang.table') }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 sm:py-4 px-4 sm:px-6 rounded-lg transition text-center flex items-center justify-center gap-2 active:bg-gray-800">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span>Batal</span>
                            </a>
                            <button type="submit" class="flex-1 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-3 sm:py-4 px-4 sm:px-6 rounded-lg transition flex items-center justify-center gap-2 active:from-green-700 active:to-emerald-700">
                                <span wire:loading.remove class="flex items-center justify-center gap-2">
                                    <span>Lanjutkan ke Form Data</span>
                                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </span>
                                <span wire:loading class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span>Memproses...</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            @endif

            <!-- STEP 2: Form Lengkap (UI/UX sama seperti sebelumnya) -->
            @if($currentStep == 2)
                <form wire:submit.prevent="submit" class="px-6 sm:px-8 py-8">

                    {{-- DATA PRIBADI --}}
                    <div class="mb-8 rounded-xl shadow-lg border-2 border-green-100 bg-white overflow-hidden">
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b-2 border-green-200">
                            <h2 class="text-xl font-bold text-green-800 flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Data Pribadi Siswa
                            </h2>
                        </div>
                        <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="nama" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none @error('nama') border-red-500 @enderror">
                                @error('nama') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Tempat Lahir <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="tempat_lahir" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none @error('tempat_lahir') border-red-500 @enderror">
                                @error('tempat_lahir') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                                <input type="date" wire:model="tanggal_lahir" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none @error('tanggal_lahir') border-red-500 @enderror">
                                @error('tanggal_lahir') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">NIK <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="nik" maxlength="16" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                @error('nik') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">NISN <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="nisn" maxlength="10" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                @error('nisn') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Anak Ke- <span class="text-red-500">*</span></label>
                                <input type="number" wire:model="anak_ke" min="1" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                @error('anak_ke') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Jumlah Saudara <span class="text-red-500">*</span></label>
                                <input type="number" wire:model="jumlah_saudara" min="0" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                @error('jumlah_saudara') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                    {{-- DATA SEKOLAH --}}
                    <div class="mb-8 rounded-xl shadow-lg border-2 border-blue-100 bg-white overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b-2 border-blue-200">
                            <h2 class="text-xl font-bold text-blue-800 flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                Data Sekolah Sebelumnya
                            </h2>
                        </div>
                        <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Sekolah <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="nama_sekolah_sebelumnya" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                @error('nama_sekolah_sebelumnya') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">NPSN <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="npsn_sekolah_sebelumnya" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                @error('npsn_sekolah_sebelumnya') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Alamat Sekolah <span class="text-red-500">*</span></label>
                                <textarea wire:model="alamat_sekolah_sebelumnya" rows="3" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none resize-none"></textarea>
                                @error('alamat_sekolah_sebelumnya') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                    {{-- DATA ORANG TUA --}}
                    <div class="mb-8 rounded-xl shadow-lg border-2 border-purple-100 bg-white overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b-2 border-purple-200">
                            <h2 class="text-xl font-bold text-purple-800 flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Data Orang Tua
                            </h2>
                        </div>
                        <div class="p-6">
                        
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Data Ayah</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Ayah <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="nama_ayah" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                @error('nama_ayah') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">NIK Ayah <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="nik_ayah" maxlength="16" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                @error('nik_ayah') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Tempat Lahir Ayah <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="tempat_lahir_ayah" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                @error('tempat_lahir_ayah') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Tanggal Lahir Ayah <span class="text-red-500">*</span></label>
                                <input type="date" wire:model="tanggal_lahir_ayah" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                @error('tanggal_lahir_ayah') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">No HP Ayah <span class="text-red-500">*</span></label>
                                <input type="tel" wire:model="no_hp_ayah" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                @error('no_hp_ayah') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Pendidikan Ayah <span class="text-red-500">*</span></label>
                                <select wire:model="pendidikan_ayah" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                    <option value="">Pilih</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                </select>
                                @error('pendidikan_ayah') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Pekerjaan Ayah <span class="text-red-500">*</span></label>
                                <select wire:model.live="pekerjaan_ayah" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                    <option value="">Pilih</option>
                                    <option value="Tidak Bekerja">Tidak Bekerja</option>
                                    <option value="PNS">PNS</option>
                                    <option value="Wiraswasta">Wiraswasta</option>
                                    <option value="Pedagang">Pedagang</option>
                                    <option value="Petani">Petani</option>
                                    <option value="Buruh">Buruh</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                @error('pekerjaan_ayah') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Penghasilan Ayah <span class="text-red-500">*</span></label>
                                <select wire:model="penghasilan_ayah" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                    <option value="">Pilih</option>
                                    <option value="Tidak Ada">Tidak Ada</option>
                                    <option value="< 1 Juta">< 1 Juta</option>
                                    <option value="1-3 Juta">1-3 Juta</option>
                                    <option value="3-5 Juta">3-5 Juta</option>
                                    <option value="> 5 Juta">> 5 Juta</option>
                                </select>
                                @error('penghasilan_ayah') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Data Ibu</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Ibu <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="nama_ibu" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                @error('nama_ibu') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">NIK Ibu <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="nik_ibu" maxlength="16" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                @error('nik_ibu') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Tempat Lahir Ibu <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="tempat_lahir_ibu" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                @error('tempat_lahir_ibu') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Tanggal Lahir Ibu <span class="text-red-500">*</span></label>
                                <input type="date" wire:model="tanggal_lahir_ibu" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                @error('tanggal_lahir_ibu') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">No HP Ibu <span class="text-red-500">*</span></label>
                                <input type="tel" wire:model="no_hp_ibu" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                @error('no_hp_ibu') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Pendidikan Ibu <span class="text-red-500">*</span></label>
                                <select wire:model="pendidikan_ibu" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                    <option value="">Pilih</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                </select>
                                @error('pendidikan_ibu') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Pekerjaan Ibu <span class="text-red-500">*</span></label>
                                <select wire:model.live="pekerjaan_ibu" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                    <option value="">Pilih</option>
                                    <option value="Tidak Bekerja">Tidak Bekerja</option>
                                    <option value="PNS">PNS</option>
                                    <option value="Wiraswasta">Wiraswasta</option>
                                    <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                @error('pekerjaan_ibu') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Penghasilan Ibu <span class="text-red-500">*</span></label>
                                <select wire:model="penghasilan_ibu" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                    <option value="">Pilih</option>
                                    <option value="Tidak Ada">Tidak Ada</option>
                                    <option value="< 1 Juta">< 1 Juta</option>
                                    <option value="1-3 Juta">1-3 Juta</option>
                                    <option value="3-5 Juta">3-5 Juta</option>
                                    <option value="> 5 Juta">> 5 Juta</option>
                                </select>
                                @error('penghasilan_ibu') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                    {{-- ALAMAT --}}
                    <div class="mb-8 rounded-xl shadow-lg border-2 border-amber-100 bg-white overflow-hidden">
                        <div class="bg-gradient-to-r from-amber-50 to-orange-50 px-6 py-4 border-b-2 border-amber-200">
                            <h2 class="text-xl font-bold text-amber-800 flex items-center gap-2">
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
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Desa/Kelurahan <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="desa" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                @error('desa') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Kecamatan <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="kecamatan" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                @error('kecamatan') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Kabupaten/Kota <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="kabupaten" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                @error('kabupaten') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Provinsi <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="provinsi" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                @error('provinsi') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                    {{-- UPLOAD DOKUMEN --}}
                    <div class="mb-8 rounded-xl shadow-lg border-2 border-teal-100 bg-white overflow-hidden">
                        <div class="bg-gradient-to-r from-teal-50 to-cyan-50 px-6 py-4 border-b-2 border-teal-200">
                            <h2 class="text-xl font-bold text-teal-800 flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Upload Dokumen
                            </h2>
                        </div>
                        <div class="p-6">
                        
                        <div class="space-y-6">
                            {{-- KK --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">
                                    Foto Kartu Keluarga (KK) <span class="text-red-500">*</span>
                                </label>
                                <input type="file" wire:model="fotokk" accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-sm file:bg-green-500 file:border-0 file:text-white file:px-4 file:py-2 file:rounded-md file:cursor-pointer file:font-semibold">
                                <p class="text-xs text-gray-600 mt-2">PDF, JPG, PNG (Max. 5MB)</p>
                                @error('fotokk') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                                @if ($fotokk)
                                    <p class="text-sm text-green-700 mt-2">File: {{ $fotokk->getClientOriginalName() }}</p>
                                @endif
                            </div>

                            {{-- Akta --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">
                                    Foto Akta Kelahiran <span class="text-red-500">*</span>
                                </label>
                                <input type="file" wire:model="fotoakta" accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-sm file:bg-green-500 file:border-0 file:text-white file:px-4 file:py-2 file:rounded-md file:cursor-pointer file:font-semibold">
                                <p class="text-xs text-gray-600 mt-2">PDF, JPG, PNG (Max. 5MB)</p>
                                @error('fotoakta') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                                @if ($fotoakta)
                                    <p class="text-sm text-green-700 mt-2">File: {{ $fotoakta->getClientOriginalName() }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                    {{-- SUBMIT --}}
                    <div class="rounded-xl shadow-lg border-2 border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50 p-4 sm:p-6">
                        <div class="flex flex-col-reverse sm:flex-row gap-3">
                            <button type="button" wire:click="$set('currentStep', 1)" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 sm:py-4 px-4 sm:px-6 rounded-lg transition flex items-center justify-center gap-2 active:bg-gray-800">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                                </svg>
                                <span>Kembali ke Step 1</span>
                            </button>
                            <button type="submit" class="flex-1 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-3 sm:py-4 px-4 sm:px-6 rounded-lg transition flex items-center justify-center gap-2 active:from-green-700 active:to-emerald-700">
                                <span wire:loading.remove class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Simpan Data</span>
                                </span>
                                <span wire:loading class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span>Menyimpan...</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            @endif
            </div>
        @endif
    </div>
</div>

<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Success Page -->
        @if ($submitted && !empty($submittedDataArray))
            <div class="space-y-6">
                <!-- Success Card -->
                <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                    <!-- Success Header -->
                    <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 sm:px-8 py-6 text-center">
                        <div class="flex justify-center mb-3">
                            <svg class="h-12 w-12 text-green-100 bg-green-500 rounded-full p-2" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h1 class="text-2xl font-bold text-white mb-1">Pendaftaran Berhasil!</h1>
                        <p class="text-green-100 text-sm">Terima kasih telah mendaftar di <br> <span
                                class="font-bold">Pondok Pesantren Syafa'aturrasul <br> Kuantan Singingi</span></p>
                    </div>

                    <!-- Success Content -->
                    <div class="px-6 sm:px-8 py-8">
                        <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded-lg mb-8">
                            <p class="text-gray-700 mb-6">
                                <span class="font-semibold text-gray-800">Atas nama:</span>
                                <span class="text-lg text-green-700 font-bold">{{ $submittedDataArray['nama'] }}</span>
                                <br> <span class="font-semibold text-gray-800">Tahun Ajaran:</span>
                                <span
                                    class="text-lg text-green-700 font-bold">{{ $submittedDataArray['tahun_ajaran'] }}</span>
                            </p>





                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 border-t pt-4">
                                <div>
                                    <p class="text-sm text-gray-600 font-semibold">NISN</p>
                                    <p class="text-gray-800">{{ $submittedDataArray['nisn'] }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 font-semibold">Jenjang Pendidikan</p>
                                    <p class="text-gray-800">{{ $submittedDataArray['jenjang_pendidikan'] }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 font-semibold">Tempat Lahir</p>
                                    <p class="text-gray-800">{{ $submittedDataArray['tempat_lahir'] }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 font-semibold">Tanggal Lahir</p>
                                    <p class="text-gray-800">
                                        {{ \Carbon\Carbon::parse($submittedDataArray['tanggal_lahir'])->format('d M Y') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 font-semibold">Asal Sekolah</p>
                                    <p class="text-gray-800">{{ $submittedDataArray['asal_sekolah'] }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 font-semibold">No. HP</p>
                                    <p class="text-gray-800">{{ $submittedDataArray['no_hp'] }}</p>
                                </div>
                            </div>

                            <div class="border-t pt-4">
                                <p class="text-sm text-gray-600 font-semibold mb-2">Alamat</p>
                                <p class="text-gray-800 leading-relaxed">{{ $submittedDataArray['alamat'] }}</p>
                            </div>

                            <div class="border-t pt-4">
                                <p class="text-sm text-gray-600 font-semibold">Silahkan klik Tombol dibawah ini</p>
                                <a href="https://chat.whatsapp.com/HKmThd3bFKn4WXBQvs5kYn"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 transform hover:scale-105 flex items-center justify-center gap-2">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-4">
                                        </path>
                                    </svg>
                                    Masuk WA Grup Ponpes Syafa'aturrasul
                                </a>
                            </div>
                        </div>

                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg mb-8">
                            <p class="text-sm text-blue-800">
                                <svg class="inline h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Data Anda telah disimpan Silakan klik Masuk WA Grup diatas dan tunggu informasi
                                selanjutnya
                                melalui Grup & Konfirmasi Pendaftaran ke Ustadz Rahmat 0852-5987-5754.
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3 pt-4">
                            <a href="/"
                                class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 transform hover:scale-105 flex items-center justify-center gap-2">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-4"></path>
                                </svg>
                                Beranda
                            </a>
                            <button wire:click="resetForm"
                                class="flex-1 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 transform hover:scale-105 flex items-center justify-center gap-2">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Pendaftaran
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Form Page -->
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                <!-- Header Image -->
                <div class="w-full bg-gray-100">
                    <img src="{{ asset('images/psb.webp') }}" alt="Header Pondok Pesantren Syafa'aturrasul"
                        class="w-full h-auto object-cover max-h-64">
                </div>

                <!-- Header -->
                <div class="bg-white px-6 sm:px-8 py-12 border-b-4 border-green-500">
                    <!-- Main Title -->
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-1 h-10 bg-gradient-to-b from-green-500 to-emerald-500 rounded-full"></div>
                            <h1 class="text-4xl font-bold text-gray-800">Formulir Pendaftaran</h1>
                        </div>
                    </div>

                    <!-- Program Info -->
                    <div
                        class="mb-10 bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg p-5 border-l-4 border-green-500">
                        <h2 class="text-green-700 font-bold text-sm tracking-wider mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.5 1.5H3.75A2.25 2.25 0 001.5 3.75v12.5A2.25 2.25 0 003.75 18.5h12.5a2.25 2.25 0 002.25-2.25V9.5m-15-4h14m-14 3.5h14m-14 3.5h14m-14 3.5h7" />
                            </svg>
                            PENERIMAAN SANTRI BARU (PSB)
                        </h2>
                        <p class="text-gray-700 text-sm leading-relaxed font-medium">
                            Madrasah Tsanawiyah (MTs) & Madrasah Aliyah (MA)
                            <br class="hidden sm:block">
                            Pondok Pesantren Syafa'aturrasul Kuantan Singingi
                            <br>
                            <span class="text-green-600 font-semibold">Tahun Ajaran 2026-2027</span>
                        </p>
                    </div>

                    <!-- Instructions Card -->
                    <div class="bg-white rounded-xl p-6 border-2 border-gray-100 shadow-sm">
                        <h3
                            class="font-bold text-gray-800 mb-6 text-lg flex items-center gap-2 pb-4 border-b-2 border-green-100">
                            <span class="text-2xl">📋</span>
                            <span>Langkah Pendaftaran</span>
                        </h3>

                        <div class="space-y-5">
                            <!-- Step 1 -->
                            <div class="flex gap-4 p-4 rounded-lg hover:bg-green-50 transition-colors duration-200">
                                <div
                                    class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-br from-green-500 to-emerald-600 text-white font-bold text-sm shadow-md">
                                    1</div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-gray-800">Persiapan Transfer</p>
                                    <p class="text-sm text-gray-600 mt-1">Siapkan <span class="font-semibold">bukti
                                            transfer pembayaran formulir pendaftaran</span></p>
                                    <p class="text-sm font-bold text-green-600 mt-2 flex items-center gap-1">💰 Rp.
                                        200.000</p>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div class="flex gap-4 p-4 rounded-lg hover:bg-green-50 transition-colors duration-200">
                                <div
                                    class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-br from-green-500 to-emerald-600 text-white font-bold text-sm shadow-md">
                                    2</div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-gray-800">Transfer Ke Rekening</p>
                                    <div
                                        class="text-sm text-gray-700 mt-2 space-y-1.5 bg-white rounded p-3 border border-gray-100">
                                        <p><span class="font-semibold text-gray-800">No. Rekening:</span> <span
                                                class="text-green-600 font-mono font-bold">8253122288</span></p>
                                        <p><span class="font-semibold text-gray-800">Bank:</span> <span
                                                class="text-gray-600">Riau Kepri Syariah</span></p>
                                        <p><span class="font-semibold text-gray-800">Atas Nama:</span> <span
                                                class="text-gray-600">Pondok Pesantren Syafa'aturrasul</span></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="flex gap-4 p-4 rounded-lg hover:bg-green-50 transition-colors duration-200">
                                <div
                                    class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-br from-green-500 to-emerald-600 text-white font-bold text-sm shadow-md">
                                    3</div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-gray-800">Isi Formulir</p>
                                    <p class="text-sm text-gray-600 mt-1">Lengkapi semua data yang diperlukan dengan
                                        <span class="font-semibold">benar dan jujur</span>
                                    </p>
                                </div>
                            </div>

                            <!-- Step 4 -->
                            <div class="flex gap-4 p-4 rounded-lg hover:bg-green-50 transition-colors duration-200">
                                <div
                                    class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-br from-green-500 to-emerald-600 text-white font-bold text-sm shadow-md">
                                    4</div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-gray-800">Upload & Konfirmasi</p>
                                    <p class="text-sm text-gray-600 mt-1">Upload <span class="font-semibold">bukti
                                            transfer</span> dan konfirmasi ke nomor di bawah</p>
                                    <div class="bg-green-100 rounded-lg p-3 mt-3 border border-green-200">
                                        <p class="text-sm font-bold text-green-700 flex items-center gap-2">
                                            📱 0852-5987-5754 (Ustadz Rahmat)
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form wire:submit.prevent="submit" class="px-6 sm:px-8 py-8">

                    <!-- Tahun Ajaran -->
                    <div class="mb-7">
                        <input type="hidden" wire:model="tahun_ajaran" value="2026/2027">
                    </div>


                    <!-- NISN -->
                    <div class="mb-7">
                        <label for="nisn" class="block text-sm font-semibold text-gray-800 mb-2">
                            NISN
                            <span class="text-red-500">*</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">
                            Nomor Induk Siswa Nasional (10 digit angka)
                        </p>
                        <input type="text" id="nisn" wire:model="nisn"
                            placeholder="Masukkan NISN (Nomor Induk Siswa Nasional)"
                            maxlength="10"
                            inputmode="numeric"
                            pattern="[0-9]{10}"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                            class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none focus:ring-0 transition duration-200 @error('nisn') border-red-500 @enderror">
                        @error('nisn')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18.101 12.93a10 10 0 11-19.202 0 10 10 0 0119.202 0zm-9-5.5a1 1 0 11-2 0 1 1 0 012 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Nama -->
                    <div class="mb-7">
                        <label for="nama" class="block text-sm font-semibold text-gray-800 mb-2">
                            Nama Lengkap
                            <span class="text-red-500">*</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">
                            Nama Lengkap sesuai Kartu Keluarga/Ijazah
                        </p>
                        <input type="text" id="nama" wire:model="nama"
                            placeholder="Masukkan nama lengkap Anda"
                            class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none focus:ring-0 transition duration-200 @error('nama') border-red-500 @enderror">
                        @error('nama')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18.101 12.93a10 10 0 11-19.202 0 10 10 0 0119.202 0zm-9-5.5a1 1 0 11-2 0 1 1 0 012 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Jenjang Pendidikan -->
                    <div class="mb-7">
                        <label for="jenjang_pendidikan" class="block text-sm font-semibold text-gray-800 mb-2">
                            Jenjang Pendidikan
                            <span class="text-red-500">*</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">
                            Jenjang pendidikan yang akan dipilih Ponpes Syafa'aturrasul
                        </p>
                        <select id="jenjang_pendidikan" wire:model="jenjang_pendidikan"
                            class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none focus:ring-0 transition duration-200 @error('jenjang_pendidikan') border-red-500 @enderror">
                            <option value="">Pilih Jenjang Pendidikan</option>
                            <option value="MTs Putri">MTs (Madsarah Tsanawiyah) Putri</option>
                            <option value="MTs Putra">MTs (Madsarah Tsanawiyah) Putra</option>
                            <option value="MA Putri">MA (Madsarah Aliyah) Putri</option>
                            <option value="MA Putra">MA (Madsarah Aliyah) Putra</option>
                        </select>
                        @error('jenjang_pendidikan')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18.101 12.93a10 10 0 11-19.202 0 10 10 0 0119.202 0zm-9-5.5a1 1 0 11-2 0 1 1 0 012 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Tempat Lahir -->
                    <div class="mb-7">
                        <label for="tempat_lahir" class="block text-sm font-semibold text-gray-800 mb-2">
                            Tempat Lahir
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="tempat_lahir" wire:model="tempat_lahir"
                            placeholder="Masukkan tempat lahir Anda"
                            class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none focus:ring-0 transition duration-200 @error('tempat_lahir') border-red-500 @enderror">
                        @error('tempat_lahir')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18.101 12.93a10 10 0 11-19.202 0 10 10 0 0119.202 0zm-9-5.5a1 1 0 11-2 0 1 1 0 012 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="mb-7">
                        <label for="tanggal_lahir" class="block text-sm font-semibold text-gray-800 mb-2">
                            Tanggal Lahir
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="tanggal_lahir" wire:model="tanggal_lahir"
                            class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none focus:ring-0 transition duration-200 @error('tanggal_lahir') border-red-500 @enderror">
                        @error('tanggal_lahir')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18.101 12.93a10 10 0 11-19.202 0 10 10 0 0119.202 0zm-9-5.5a1 1 0 11-2 0 1 1 0 012 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Asal Sekolah -->
                    <div class="mb-7">
                        <label for="asal_sekolah" class="block text-sm font-semibold text-gray-800 mb-2">
                            Asal Sekolah
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="asal_sekolah" wire:model="asal_sekolah"
                            placeholder="Masukkan nama sekolah asal Anda"
                            class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none focus:ring-0 transition duration-200 @error('asal_sekolah') border-red-500 @enderror">
                        @error('asal_sekolah')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18.101 12.93a10 10 0 11-19.202 0 10 10 0 0119.202 0zm-9-5.5a1 1 0 11-2 0 1 1 0 012 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div class="mb-7">
                        <label for="alamat" class="block text-sm font-semibold text-gray-800 mb-2">
                            Alamat
                            <span class="text-red-500">*</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">
                            Contoh : Desa Beringin Taluk, Kec. Kuantan Tengah, Kab. Kuantan Singingi, Riau
                        </p>
                        <textarea id="alamat" wire:model="alamat" rows="3" placeholder="Masukkan alamat lengkap Anda"
                            class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none focus:ring-0 transition duration-200 @error('alamat') border-red-500 @enderror resize-none"></textarea>
                        @error('alamat')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18.101 12.93a10 10 0 11-19.202 0 10 10 0 0119.202 0zm-9-5.5a1 1 0 11-2 0 1 1 0 012 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Nama Ayah -->
                    <div class="mb-7">
                        <label for="nama_ayah" class="block text-sm font-semibold text-gray-800 mb-2">
                            Nama Ayah
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_ayah" wire:model="nama_ayah"
                            placeholder="Masukkan nama ayah Anda"
                            class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none focus:ring-0 transition duration-200 @error('nama_ayah') border-red-500 @enderror">
                        @error('nama_ayah')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18.101 12.93a10 10 0 11-19.202 0 10 10 0 0119.202 0zm-9-5.5a1 1 0 11-2 0 1 1 0 012 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Nama Ibu -->
                    <div class="mb-7">
                        <label for="nama_ibu" class="block text-sm font-semibold text-gray-800 mb-2">
                            Nama Ibu
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_ibu" wire:model="nama_ibu"
                            placeholder="Masukkan nama ibu Anda"
                            class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none focus:ring-0 transition duration-200 @error('nama_ibu') border-red-500 @enderror">
                        @error('nama_ibu')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18.101 12.93a10 10 0 11-19.202 0 10 10 0 0119.202 0zm-9-5.5a1 1 0 11-2 0 1 1 0 012 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Nomor HP -->
                    <div class="mb-7">
                        <label for="no_hp" class="block text-sm font-semibold text-gray-800 mb-2">
                            Nomor HP / WhatsApp Orangtua
                            <span class="text-red-500">*</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">
                            No WhatsApp yang aktif yang bisa dihubungi
                        </p>
                        <input type="tel" id="no_hp" wire:model="no_hp"
                            placeholder="Masukkan nomor HP (format: 08xxxxx)"
                            class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none focus:ring-0 transition duration-200 @error('no_hp') border-red-500 @enderror">
                        @error('no_hp')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18.101 12.93a10 10 0 11-19.202 0 10 10 0 0119.202 0zm-9-5.5a1 1 0 11-2 0 1 1 0 012 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Bukti Transfer -->
                    <div class="mb-8">
                        <label for="buktitransfer" class="block text-sm font-semibold text-gray-800 mb-2">
                            Upload Bukti Transfer (PDF/Gambar)
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="file" id="buktitransfer" wire:model="buktitransfer"
                                accept=".pdf,.jpg,.jpeg,.png"
                                class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none focus:ring-0 transition duration-200 @error('buktitransfer') border-red-500 @enderror file:bg-green-500 file:border-0 file:text-white file:px-4 file:py-2 file:rounded-md file:cursor-pointer file:font-semibold file:mr-4">
                            <p class="text-xs text-gray-600 mt-2">
                                Format: PDF, JPG, JPEG, PNG | Maksimal: 2 MB
                            </p>
                        </div>

                        <!-- File preview -->
                        @if ($buktitransfer)
                            <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span
                                            class="text-sm text-green-800 font-semibold">{{ $buktitransfer->getClientOriginalName() }}</span>
                                    </div>
                                    <span
                                        class="text-xs text-green-600">{{ number_format($buktitransfer->getSize() / 1024, 2) }}
                                        KB</span>
                                </div>
                            </div>
                        @endif

                        @error('buktitransfer')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18.101 12.93a10 10 0 11-19.202 0 10 10 0 0119.202 0zm-9-5.5a1 1 0 11-2 0 1 1 0 012 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-3 pt-4">
                        <button type="submit"
                            class="flex-1 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 transform hover:scale-105 flex items-center justify-center gap-2">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span wire:loading.remove>Kirim Pendaftaran</span>
                            <span wire:loading class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Mengirim...
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Footer Info -->
                <div class="bg-green-50 border-t border-green-200 px-6 sm:px-8 py-6">
                    <p class="text-sm text-gray-600">
                        <span class="text-red-500 font-semibold">*</span> Menunjukkan bidang yang wajib diisi
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>

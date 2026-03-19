<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        @if($submitted)
            <!-- Success Page -->
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 sm:px-8 py-6 text-center">
                    <div class="flex justify-center mb-3">
                        <svg class="h-12 w-12 text-green-100 bg-green-500 rounded-full p-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-white mb-1">Pendaftaran Ulang Berhasil!</h1>
                    <p class="text-green-100 text-sm mb-2">Terima kasih telah melakukan pendaftaran ulang di <br> <span class="font-bold text-base">Pondok Pesantren Syafa'aturrasul</span></p>
                    <p class="text-green-100 text-sm">Data Anda telah tersimpan ke {{ $pendaftaran->jenjang_pendidikan }}</p>
                </div>

                <div class="px-6 sm:px-8 py-8">
                    <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded-lg mb-6">
                        <p class="text-gray-700 mb-4">
                            <span class="font-semibold text-gray-800">Nama:</span>
                            <span class="text-lg text-green-700 font-bold">{{ $nama }}</span>
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border-t pt-4">
                            <div>
                                <p class="text-sm text-gray-600 font-semibold">NISN</p>
                                <p class="text-gray-800">{{ $nisn ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 font-semibold">Tempat Lahir</p>
                                <p class="text-gray-800">{{ $tempat_lahir ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 font-semibold">Tanggal Lahir</p>
                                <p class="text-gray-800">
                                    {{ $tanggal_lahir ? \Carbon\Carbon::parse($tanggal_lahir)->format('d M Y') : '-' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 font-semibold">Desa/Kelurahan</p>
                                <p class="text-gray-800">{{ $desa ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 font-semibold">Kecamatan</p>
                                <p class="text-gray-800">{{ $kecamatan ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 font-semibold">Kabupaten/Kota</p>
                                <p class="text-gray-800">{{ $kabupaten ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 font-semibold">Provinsi</p>
                                <p class="text-gray-800">{{ $provinsi ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600 font-semibold">Nama Ayah</p>
                                    <p class="text-gray-800">{{ $nama_ayah ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 font-semibold">Nama Ibu</p>
                                    <p class="text-gray-800">{{ $nama_ibu ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg mb-6">
                        <p class="text-sm text-blue-800">
                            Data Anda telah tersimpan. Silakan tunggu informasi selanjutnya dari pihak sekolah.
                        </p>
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('daftar-ulang.table') }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 text-center">
                            Kembali ke Daftar
                        </a>
                        <a href="/" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 text-center">
                            Beranda
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- Form Page -->
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 sm:px-8 py-8">
                    <h1 class="text-3xl font-bold text-white mb-2">Form Pendaftaran Ulang</h1>
                    <h2 class="text-xl font-semibold text-green-50 mb-3">Pondok Pesantren Syafa'aturrasul</h2>
                    <p class="text-green-100">{{ $pendaftaran->jenjang_pendidikan }} - TA {{ $pendaftaran->tahun_ajaran }}</p>
                    <p class="text-green-200 text-sm mt-2">Lengkapi semua data dengan benar dan jujur</p>
                </div>

                @if (session()->has('error'))
                    <div class="mx-6 mt-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                        <p class="text-red-800">{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Form -->
                <form wire:submit.prevent="submit" class="px-6 sm:px-8 py-8">
                    
                    {{-- DATA PRIBADI SISWA --}}
                    <div class="mb-8 pb-6 border-b-2 border-gray-200">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                            <span class="text-green-600">📋</span> Data Pribadi Siswa
                        </h2>
                        
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
                                <label class="block text-sm font-semibold text-gray-800 mb-2">NIK Anak <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="nik" maxlength="16" placeholder="Nomor Induk Kependudukan" inputmode="numeric" pattern="[0-9]{16}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                <p class="text-xs text-gray-500 mt-1">NIK harus 16 digit</p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">NISN (Nomor Induk Siswa Nasional) <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="nisn" maxlength="10" placeholder="Nomor Induk Siswa Nasional" inputmode="numeric" pattern="[0-9]{10}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                <p class="text-xs text-gray-500 mt-1">NISN harus 10 digit</p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Anak Ke- <span class="text-red-500">*</span></label>
                                <input type="number" wire:model="anak_ke" min="1" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Jumlah Saudara <span class="text-red-500">*</span></label>
                                <input type="number" wire:model="jumlah_saudara" min="0" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                            </div>

                            <!-- Hidden field for Tahun Ajaran -->
                            <input type="hidden" wire:model="tahun_ajaran" value="2026/2027">
                        </div>
                    </div>

                    {{-- DATA SEKOLAH SEBELUMNYA --}}
                    <div class="mb-8 pb-6 border-b-2 border-gray-200">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                            <span class="text-green-600">🏫</span> Data Sekolah Sebelumnya
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            


                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Sekolah <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="nama_sekolah_sebelumnya" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">NPSN (Nomor Pokok Sekolah Nasional) <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="npsn_sekolah_sebelumnya" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                            </div>

                            

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Alamat Sekolah <span class="text-red-500">*</span></label>
                                <textarea wire:model="alamat_sekolah_sebelumnya" rows="3" placeholder="Masukkan alamat lengkap sekolah sebelumnya" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none resize-none"></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- DATA AYAH --}}
                    <div class="mb-8 pb-6 border-b-2 border-gray-200">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                            Data Ayah
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Ayah <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="nama_ayah" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none @error('nama_ayah') border-red-500 @enderror">
                                @error('nama_ayah') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">NIK Ayah <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="nik_ayah" maxlength="16" placeholder="16 digit" inputmode="numeric" pattern="[0-9]{16}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Tempat Lahir Ayah <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="tempat_lahir_ayah" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Tanggal Lahir Ayah <span class="text-red-500">*</span></label>
                                <input type="date" wire:model="tanggal_lahir_ayah" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                            </div>

                            

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">No. HP Ayah /Whatsapp Aktif <span class="text-red-500">*</span></label>
                                <input type="tel" wire:model="no_hp_ayah" placeholder="08xxxxxxxxxx" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none @error('no_hp_ayah') border-red-500 @enderror">
                                @error('no_hp_ayah') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Pendidikan Terakhir Ayah <span class="text-red-500">*</span></label>
                                <select wire:model="pendidikan_ayah" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
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
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Pekerjaan Ayah <span class="text-red-500">*</span></label>
                                <select wire:model.live="pekerjaan_ayah" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
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
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Penghasilan Ayah <span class="text-red-500">*</span></label>
                                <select wire:model="penghasilan_ayah" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                    <option value="">Pilih Penghasilan</option>
                                    <option value="Tidak Ada">Tidak Ada</option>
                                    <option value="dibawah 800.000">Dibawah 800.000</option>
                                    <option value="800.001 - 1.200.000">800.001 - 1.200.000</option>
                                    <option value="1.200.001 - 1.800.000">1.200.001 - 1.800.000</option>
                                    <option value="1.800.001 - 2.500.000">1.800.001 - 2.500.000</option>
                                    <option value="2.500.001 - 3.500.000">2.500.001 - 3.500.000</option>
                                    <option value="3.500.001 - 4.800.000">3.500.001 - 4.800.000</option>
                                    <option value="4.800.001 - 6.500.000">4.800.001 - 6.500.000</option>
                                    <option value="6.500.001 - 10.000.000">6.500.001 - 10.000.000</option>
                                    <option value="10.000.001 - 20.000.000">10.000.001 - 20.000.000</option>
                                    <option value="diatas 20.000.001">Diatas 20.000.001</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- DATA IBU --}}
                    <div class="mb-8 pb-6 border-b-2 border-gray-200">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                            Data Ibu
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Ibu <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="nama_ibu" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none @error('nama_ibu') border-red-500 @enderror">
                                @error('nama_ibu') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">NIK Ibu <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="nik_ibu" maxlength="16" placeholder="16 digit" inputmode="numeric" pattern="[0-9]{16}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Tempat Lahir Ibu <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="tempat_lahir_ibu" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Tanggal Lahir Ibu <span class="text-red-500">*</span></label>
                                <input type="date" wire:model="tanggal_lahir_ibu" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                            </div>

                            

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">No. HP Ibu/Whatsapp Aktif <span class="text-red-500">*</span></label>
                                <input type="tel" wire:model="no_hp_ibu" placeholder="08xxxxxxxxxx" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Pendidikan Terakhir Ibu <span class="text-red-500">*</span></label>
                                <select wire:model="pendidikan_ibu" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
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
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Pekerjaan Ibu <span class="text-red-500">*</span></label>
                                <select wire:model.live="pekerjaan_ibu" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
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
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Penghasilan Ibu <span class="text-red-500">*</span></label>
                                <select wire:model="penghasilan_ibu" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                    <option value="">Pilih Penghasilan</option>
                                    <option value="Tidak Ada">Tidak Ada</option>
                                    <option value="dibawah 800.000">Dibawah 800.000</option>
                                    <option value="800.001 - 1.200.000">800.001 - 1.200.000</option>
                                    <option value="1.200.001 - 1.800.000">1.200.001 - 1.800.000</option>
                                    <option value="1.800.001 - 2.500.000">1.800.001 - 2.500.000</option>
                                    <option value="2.500.001 - 3.500.000">2.500.001 - 3.500.000</option>
                                    <option value="3.500.001 - 4.800.000">3.500.001 - 4.800.000</option>
                                    <option value="4.800.001 - 6.500.000">4.800.001 - 6.500.000</option>
                                    <option value="6.500.001 - 10.000.000">6.500.001 - 10.000.000</option>
                                    <option value="10.000.001 - 20.000.000">10.000.001 - 20.000.000</option>
                                    <option value="diatas 20.000.001">Diatas 20.000.001</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- DATA ALAMAT --}}
                    <div class="mb-8 pb-6 border-b-2 border-gray-200">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                            Data Alamat Tempat Tinggal
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Desa/Kelurahan <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="desa" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Kecamatan <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="kecamatan" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Kabupaten/Kota <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="kabupaten" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Provinsi <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="provinsi" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                            </div>

                            
                        </div>
                    </div>

                    {{-- DATA WALI --}}
                    <div class="mb-8 pb-6 border-b-2 border-gray-200">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                            Data Wali (Jika Ada)
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Wali</label>
                                <input type="text" wire:model="nama_wali" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">NIK Wali</label>
                                <input type="text" wire:model="nik_wali" maxlength="16" placeholder="16 digit" inputmode="numeric" pattern="[0-9]{16}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Tempat Lahir Wali</label>
                                <input type="text" wire:model="tempat_lahir_wali" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Tanggal Lahir Wali</label>
                                <input type="date" wire:model="tanggal_lahir_wali" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">No. HP Wali</label>
                                <input type="tel" wire:model="no_hp_wali" placeholder="08xxxxxxxxxx" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Pendidikan Terakhir Wali</label>
                                <select wire:model="pendidikan_wali" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
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
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Pekerjaan Wali</label>
                                <select wire:model.live="pekerjaan_wali" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
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
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Penghasilan Wali</label>
                                <select wire:model="penghasilan_wali" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                                    <option value="">Pilih Penghasilan</option>
                                    <option value="Tidak Berpenghasilan">Tidak Berpenghasilan</option>
                                    <option value="< Rp 1.000.000">< Rp 1.000.000</option>
                                    <option value="Rp 1.000.000 - Rp 2.500.000">Rp 1.000.000 - Rp 2.500.000</option>
                                    <option value="Rp 2.500.001 - Rp 5.000.000">Rp 2.500.001 - Rp 5.000.000</option>
                                    <option value="Rp 5.000.001 - Rp 10.000.000">Rp 5.000.001 - Rp 10.000.000</option>
                                    <option value="> Rp 10.000.000">> Rp 10.000.000</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- UPLOAD DOKUMEN --}}
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                            <span class="text-green-600">📄</span> Upload Dokumen
                        </h2>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Foto Kartu Keluarga (KK) <span class="text-red-500">*</span></label>
                                <input type="file" wire:model="fotokk" accept=".pdf,.jpg,.jpeg,.png" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none file:bg-green-500 file:border-0 file:text-white file:px-4 file:py-2 file:rounded-md file:cursor-pointer file:font-semibold file:mr-4">
                                <p class="text-xs text-gray-600 mt-2">Format: PDF, JPG, PNG | Max: 5MB</p>
                                @if($fotokk)
                                    <div class="mt-2 p-2 bg-green-50 border border-green-200 rounded text-sm text-green-700">
                                        File dipilih: {{ $fotokk->getClientOriginalName() }}
                                    </div>
                                @endif
                                @error('fotokk') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Foto Akta Kelahiran <span class="text-red-500">*</span></label>
                                <input type="file" wire:model="fotoakta" accept=".pdf,.jpg,.jpeg,.png" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:outline-none file:bg-green-500 file:border-0 file:text-white file:px-4 file:py-2 file:rounded-md file:cursor-pointer file:font-semibold file:mr-4">
                                <p class="text-xs text-gray-600 mt-2">Format: PDF, JPG, PNG | Max: 5MB</p>
                                @if($fotoakta)
                                    <div class="mt-2 p-2 bg-green-50 border border-green-200 rounded text-sm text-green-700">
                                        File dipilih: {{ $fotoakta->getClientOriginalName() }}
                                    </div>
                                @endif
                                @error('fotoakta') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex flex-col-reverse md:flex-row gap-3 pt-6 border-t-2 border-gray-200">
                        <a href="{{ route('daftar-ulang.table') }}" class="w-full md:flex-1 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-4 px-6 rounded-lg transition duration-200 text-center">
                            Batal
                        </a>
                        <button type="submit" class="w-full md:flex-1 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-4 px-6 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                            <span wire:loading.remove>
                                <svg class="inline h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Simpan Data
                            </span>
                            <span wire:loading class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Menyimpan...
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Footer -->
                <div class="bg-green-50 border-t border-green-200 px-6 sm:px-8 py-4">
                    <p class="text-sm text-gray-600">
                        <span class="text-red-500 font-semibold">*</span> Menunjukkan bidang yang wajib diisi
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-50 dark:from-gray-900 dark:to-gray-800 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        @if($submitted)
            <!-- Success Page -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 sm:px-8 py-8 text-center">
                    <div class="flex justify-center mb-4">
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="h-16 w-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Foto Profil Berhasil Diperbarui!</h1>
                    <p class="text-green-100">{{ $student->nama }} - {{ str_replace(['Mtsputra', 'Mtsputri', 'Maputra', 'Maputri'], ['MTs Putra', 'MTs Putri', 'MA Putra', 'MA Putri'], $type) }}</p>
                </div>

                <div class="px-6 sm:px-8 py-8">
                    <!-- Foto Preview -->
                    <div class="flex justify-center mb-6">
                        <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-green-200 shadow-lg">
                            <img src="{{ Storage::url($student->foto) }}" class="w-full h-full object-cover" alt="Foto Profil">
                        </div>
                    </div>

                    <div class="text-center mb-6">
                        <p class="text-gray-700 dark:text-gray-300 font-medium">Nama: <span class="font-bold text-gray-900 dark:text-white">{{ $student->nama }}</span></p>
                        <p class="text-gray-700 dark:text-gray-300 font-medium">NISN: <span class="font-bold text-gray-900 dark:text-white">{{ $student->nisn ?? '-' }}</span></p>
                    </div>

                    <div class="flex flex-col-reverse md:flex-row gap-3 mt-8">
                        <a href="{{ route('home') }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 text-center flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span>Kembali ke Beranda</span>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 sm:px-8 py-8 text-center rounded-t-lg">
                <h1 class="text-2xl sm:text-3xl font-bold text-white mb-3">Update Foto Profil</h1>
                <div class="inline-block bg-white dark:bg-gray-800 px-6 py-2 rounded-lg shadow-md">
                    <p class="text-gray-900 dark:text-white font-bold text-base sm:text-lg">{{ $student->nama }}</p>
                </div>
                <p class="text-green-100 text-sm sm:text-base mt-3">{{ str_replace(['Mtsputra', 'Mtsputri', 'Maputra', 'Maputri'], ['MTs Putra', 'MTs Putri', 'MA Putra', 'MA Putri'], $type) }}</p>
            </div>

            @if (session()->has('error'))
                <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded mx-6 mt-6">
                    <p class="text-red-800 dark:text-red-300">{{ session('error') }}</p>
                </div>
            @endif

            @if (session()->has('success'))
                <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 p-4 rounded mx-6 mt-6">
                    <p class="text-green-800 dark:text-green-300">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 px-6 sm:px-8 py-8">
                <!-- Current Photo -->
                @if($existingFoto)
                    <div class="mb-8 text-center">
                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Foto Profil Saat Ini</p>
                        <div class="w-32 h-32 mx-auto rounded-full overflow-hidden border-4 border-gray-200 shadow-lg">
                            <img src="{{ Storage::url($existingFoto) }}" class="w-full h-full object-cover" alt="Foto Profil Saat Ini">
                        </div>
                    </div>
                @else
                    <div class="mb-8 text-center">
                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Belum Ada Foto Profil</p>
                        <div class="w-32 h-32 mx-auto rounded-full bg-gray-100 dark:bg-gray-700 border-4 border-gray-200 dark:border-gray-600 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                @endif

                <form wire:submit.prevent="submit">
                    <div x-data="{ uploading: false, progress: 0, preview: null }"
                         x-on:livewire-upload-start.window="uploading = true; progress = 0"
                         x-on:livewire-upload-progress.window="progress = $event.detail.progress"
                         x-on:livewire-upload-finish.window="uploading = false"
                         x-on:livewire-upload-error.window="uploading = false">
                        
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">
                                Upload Foto Profil Baru <span class="text-red-500">*</span>
                            </label>
                            <input type="file" wire:model="foto" accept=".jpg,.jpeg,.png"
                                   class="block w-full text-sm file:bg-green-500 file:border-0 file:text-white file:px-4 file:py-2 file:rounded-md file:cursor-pointer file:font-semibold dark:text-gray-300">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">JPG atau PNG (Max. 2MB)</p>
                            @error('foto') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Progress Bar -->
                        <div x-show="uploading" x-cloak class="mb-6 bg-white dark:bg-gray-800 rounded-lg border border-green-200 dark:border-green-800 p-4 shadow-sm">
                            <div class="flex items-center gap-3 mb-3">
                                <svg class="animate-spin h-5 w-5 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-semibold text-green-800 dark:text-green-300">Mengupload Foto...</p>
                                    <p class="text-xs text-green-600 dark:text-green-400" x-text="progress + '%'"></p>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-green-500 to-green-600 dark:from-green-400 dark:to-green-500 rounded-full transition-all duration-300 ease-out"
                                     :style="'width: ' + progress + '%'"></div>
                            </div>
                        </div>

                        <!-- Preview -->
                        @if ($foto)
                            <div class="mb-6 text-center">
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Preview Foto Baru</p>
                                <div class="w-32 h-32 mx-auto rounded-full overflow-hidden border-4 border-green-300 shadow-lg">
                                    <img src="{{ $foto->temporaryUrl() }}" class="w-full h-full object-cover" alt="Preview">
                                </div>
                            </div>
                        @endif

                        <!-- Actions -->
                        <div class="rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-gray-800 dark:to-gray-700 p-4 sm:p-6">
                            <div class="flex flex-col-reverse sm:flex-row gap-3">
                                <a href="{{ route('home') }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg transition text-center flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    <span>Beranda</span>
                                </a>
                                <button type="submit" wire:loading.attr="disabled"
                                        class="flex-1 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed">
                                    <span wire:loading.remove wire:target="submit" class="flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                        </svg>
                                        <span>Simpan Foto</span>
                                    </span>
                                    <span wire:loading wire:target="submit" class="flex items-center justify-center gap-2">
                                        <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span>Menyimpan...</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>

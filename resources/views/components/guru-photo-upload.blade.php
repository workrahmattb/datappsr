@props(['current' => null])

<div class="flex flex-col gap-4" data-guru-photo-upload>
    <label for="guru-foto" class="text-sm font-medium text-gray-700">Foto profil guru</label>
    <div class="flex flex-col gap-5 sm:flex-row sm:items-start">
        <div class="flex shrink-0 flex-col items-center gap-2">
            <img data-photo-preview src="{{ $current ?: asset('images/template-foto-guru.svg') }}"
                alt="Pratinjau lingkaran foto guru" width="160" height="160"
                class="h-40 w-40 rounded-full border-4 border-white bg-white object-cover object-center shadow-md">
            <span class="text-xs text-gray-500">Pratinjau tampilan lingkaran</span>
        </div>
        <div class="flex flex-1 flex-col gap-3">
            <p class="text-sm font-semibold text-gray-800">Ukuran anjuran: 800 × 800 piksel (rasio 1:1)</p>
            <p class="text-sm text-gray-600">Gunakan foto kepala dan bahu dengan wajah di tengah. Sisakan ruang di atas kepala serta di sisi kanan dan kiri agar kepala atau hijab tidak terpotong.</p>
            <a href="{{ asset('images/template-foto-guru.svg') }}" download="template-foto-guru-800x800.svg" class="text-sm font-semibold text-emerald-700 underline">Unduh template ukuran foto</a>
            <p class="text-xs text-gray-500">Template adalah panduan posisi. Ganti dengan foto Anda, hapus garis dan tulisan panduan, lalu ekspor menjadi JPG, PNG, atau WebP.</p>
            <input id="guru-foto" type="file" name="foto" accept="image/jpeg,image/png,image/webp" aria-describedby="guru-foto-help"
                class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-600">
            <p id="guru-foto-help" class="text-xs text-gray-500">Maksimal 2 MB. Foto tidak harus persegi, tetapi bagian tepi akan terpotong mengikuti pratinjau. Pratinjau tidak mengubah file asli.</p>
            <p data-photo-info class="text-sm text-gray-600" role="status" aria-live="polite"></p>
            @error('foto') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('[data-guru-photo-upload]').forEach((container) => {
        const input = container.querySelector('input[type="file"]');
        const preview = container.querySelector('[data-photo-preview]');
        const info = container.querySelector('[data-photo-info]');
        const original = preview.src;
        let objectUrl;
        input.addEventListener('change', () => {
            if (objectUrl) URL.revokeObjectURL(objectUrl);
            preview.src = original;
            info.textContent = '';
            const file = input.files[0];
            if (!file) return;
            if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type) || file.size > 2 * 1024 * 1024) {
                info.textContent = 'Pilih JPG, PNG, atau WebP dengan ukuran maksimal 2 MB.';
                input.value = '';
                return;
            }
            objectUrl = URL.createObjectURL(file);
            const selectedUrl = objectUrl;
            const image = new Image();
            image.onload = () => {
                if (objectUrl !== selectedUrl) return;
                preview.src = selectedUrl;
                info.textContent = `Ukuran foto: ${image.naturalWidth} × ${image.naturalHeight} piksel. ` +
                    (image.naturalWidth === image.naturalHeight ? 'Rasio persegi sesuai panduan.' : 'Foto akan dipotong dari tengah. Periksa posisi wajah pada lingkaran.');
            };
            image.onerror = () => {
                if (objectUrl !== selectedUrl) return;
                info.textContent = 'Gambar tidak dapat dibaca. Pilih file gambar lain.';
                input.value = '';
            };
            image.src = selectedUrl;
        });
    });
</script>
@endpush

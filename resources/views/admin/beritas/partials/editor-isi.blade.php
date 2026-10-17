@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" data-quill-css="1">
    <style>
        .ql-toolbar.ql-snow {
            border-color: #d1d5db;
            border-top-left-radius: .375rem;
            border-top-right-radius: .375rem;
            background: #fafafa;
        }

        .ql-container.ql-snow {
            border-color: #d1d5db;
            border-bottom-left-radius: .375rem;
            border-bottom-right-radius: .375rem;
            font-size: .9375rem;
            font-family: inherit;
        }

        .ql-editor {
            min-height: 280px;
        }

        /* Tailwind preflight menghapus style list/heading → dikembalikan di editor */
        .ql-editor h1 { font-size: 1.75rem; font-weight: 700; }
        .ql-editor h2 { font-size: 1.5rem; font-weight: 700; }
        .ql-editor h3 { font-size: 1.25rem; font-weight: 700; }
        .ql-editor h4 { font-size: 1.125rem; font-weight: 700; }
        .ql-editor ul { list-style-type: disc; }
        .ql-editor ol { list-style-type: decimal; }
        .ql-editor blockquote { border-left: 4px solid #d1d5db; padding-left: 1rem; }
        .ql-editor img { max-width: 100%; }
    </style>
@endpush

<div>
    <label class="block text-sm font-medium text-gray-700">Isi Berita <span class="text-red-500">*</span></label>

    {{-- Wadah editor (disembunyikan dulu; ditampilkan hanya bila editor siap) --}}
    <div id="isi-editor" class="hidden mt-1 bg-white">{!! $value !!}</div>

    {{-- Field yang benar-benar dikirim ke server --}}
    <textarea name="isi" id="isi-textarea" rows="12" placeholder="Tulis isi berita di sini..."
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">{{ $value }}</textarea>

    <p class="text-xs text-gray-500 mt-1">
        Gunakan tombol di toolbar untuk <strong>bold</strong>, miring, daftar, kutipan, tautan, dan menyisipkan gambar.
        Maksimal gambar 2 MB.
    </p>
    @error('isi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
</div>

@push('scripts')
    <script>
        (function () {
            const CSS_HREF = 'https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css';
            const JS_SRC = 'https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js';

            /**
             * Pastikan aset Quill tersedia — baik saat halaman dibuka langsung
             * (full page load) maupun lewat navigasi SPA wire:navigate.
             */
            function pastikanAsetQuill() {
                if (!document.querySelector('link[data-quill-css]')) {
                    const link = document.createElement('link');
                    link.rel = 'stylesheet';
                    link.href = CSS_HREF;
                    link.setAttribute('data-quill-css', '1');
                    document.head.appendChild(link);
                }

                if (window.Quill) {
                    return Promise.resolve();
                }

                if (!window.__quillMemuat) {
                    window.__quillMemuat = new Promise(function (resolve) {
                        const script = document.createElement('script');
                        script.src = JS_SRC;
                        script.onload = resolve;
                        script.onerror = resolve;
                        document.head.appendChild(script);
                    });
                }

                return window.__quillMemuat;
            }

            /** Inisialisasi editor pada halaman aktif (aman dipanggil berulang). */
            window.__initEditorIsi = function () {
                const editorEl = document.getElementById('isi-editor');
                const textarea = document.getElementById('isi-textarea');

                if (!editorEl || !textarea || editorEl.dataset.siap === '1') {
                    return;
                }

                pastikanAsetQuill().then(function () {
                    if (!window.Quill || editorEl.dataset.siap === '1') {
                        // Quill gagal dimuat → textarea tetap dipakai (fallback aman).
                        return;
                    }

                    editorEl.dataset.siap = '1';
                    editorEl.classList.remove('hidden');
                    textarea.classList.add('hidden');

                    const form = textarea.closest('form');
                    const uploadUrl = @json(route('admin.beritas.upload-gambar'));
                    const csrfToken = @json(csrf_token());

                    const quill = new Quill(editorEl, {
                theme: 'snow',
                placeholder: 'Tulis isi berita di sini...',
                modules: {
                    toolbar: {
                        container: [
                            [{ header: [1, 2, 3, 4, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ list: 'ordered' }, { list: 'bullet' }],
                            [{ indent: '-1' }, { indent: '+1' }],
                            [{ align: [] }],
                            ['blockquote', 'code-block'],
                            ['link', 'image', 'video'],
                            ['clean']
                        ],
                        handlers: {
                            image: function () {
                                const input = document.createElement('input');
                                input.setAttribute('type', 'file');
                                input.setAttribute('accept', 'image/jpeg,image/png,image/webp');
                                input.click();

                                input.addEventListener('change', function () {
                                    const file = input.files && input.files[0];

                                    if (!file) {
                                        return;
                                    }

                                    const formData = new FormData();
                                    formData.append('gambar', file);

                                    fetch(uploadUrl, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                            'Accept': 'application/json'
                                        },
                                        body: formData
                                    })
                                        .then(function (res) {
                                            return res.json().then(function (data) {
                                                return { ok: res.ok, data: data };
                                            });
                                        })
                                        .then(function (result) {
                                            if (!result.ok || !result.data.url) {
                                                alert(result.data && result.data.message
                                                    ? result.data.message
                                                    : 'Gagal mengunggah gambar.');
                                                return;
                                            }

                                            const range = quill.getSelection(true);
                                            quill.insertEmbed(range ? range.index : 0, 'image', result.data.url);
                                        })
                                        .catch(function () {
                                            alert('Gagal mengunggah gambar. Periksa koneksi Anda.');
                                        });
                                });
                            }
                        }
                    }
                }
            });

                    function sync() {
                        const html = quill.root.innerHTML;
                        textarea.value = html === '<p><br></p>' ? '' : html;
                    }

                    quill.on('text-change', sync);

                    if (form) {
                        form.addEventListener('submit', sync);
                    }

                    sync();
                });
            };

            // Halaman dibuka langsung (full page load).
            window.__initEditorIsi();

            // Halaman dibuka lewat wire:navigate — daftarkan listener sekali saja.
            if (!window.__editorIsiListener) {
                window.__editorIsiListener = true;
                document.addEventListener('livewire:navigated', function () {
                    window.__initEditorIsi();
                });
            }
        })();
    </script>
@endpush

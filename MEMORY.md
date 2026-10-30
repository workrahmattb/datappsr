# 🧠 MEMORY.md — Alur Kerja & Memori Project PPSR Putra

> **Dokumen ini adalah memori kerja antara User (Rahmat) dan AI Assistant (Cline).**
> **Baca bagian ini PERTAMA KALI di setiap sesi**, sebelum menyentuh kode apa pun.
>
> - **Bagian atas** (1–7) = cara kita bekerja + kondisi project saat ini.
> - **Bagian bawah** = ARSIP CHANGELOG HISTORIS (jangan dihapus).

| Info | Nilai |
|---|---|
| Project | Sistem PPDB Pondok Pesantren Syafa'aturrasul — 4 jenjang (MTs Putra/Putri, MA Putra/Putri) |
| Repo | `workrahmattb/datappsr` — branch `main` |
| Lokasi | `/Users/rahmattanri/Documents/Project Code/ppsr2025putra` |
| Terakhir diperbarui | 26 Oktober 2026 — sesi 12 (logo navbar, SEO homepage, konsistensi footer publik) |
| Status kode saat ini | `/` = website sekolah, `/psb` = PSB & cari data — test terkait perubahan lulus; full suite belum dijalankan ulang |

> ⚠️ Di macOS, `memory.md` dan `MEMORY.md` adalah **file yang sama** (filesystem case-insensitive).

---

## 1. ⚖️ Aturan Kerja (WAJIB DIPATUHI)

1. **Jangan ubah kode sebelum diperintah.** Mode *Plan* = hanya baca & analisa. Mode *Act* = baru eksekusi.
2. **Baca `MEMORY.md` + konteks dulu.** Verifikasi ke file nyata, jangan berasumsi.
3. **Rencana dulu, baru eksekusi.** Sampaikan plan singkat sebelum mengedit.
4. **Jangan ubah dependency** (`composer.json` / `package.json`) tanpa persetujuan.
5. **Jangan buat file dokumentasi baru** kecuali diminta. Cukup perbarui `MEMORY.md`.
6. **Ikuti konvensi yang sudah ada** (bagian 3). Cek file tetangga sebelum membuat file baru.
7. **Setiap perubahan harus diuji** (Pest) dan diformat (`vendor/bin/pint --dirty`).
8. **Setelah sesi selesai:** tambahkan entri changelog baru di **paling bawah** bagian arsip.
9. **Jangan hapus test atau file penting** tanpa persetujuan.
10. **Laporkan jujur:** bedakan mana yang sudah diverifikasi vs masih asumsi.

---

## 2. 🔁 Alur Kerja Standar (SOP Per Sesi)

```
[MULAI]
  │
  1. BACA     → MEMORY.md (bagian 1–7) + README.md
  │             → git status / git log --oneline -5
  │
  2. PAHAMI   → baca file relevan + route + konvensi + file tetangga
  │
  3. RENCANA  → sampaikan plan singkat + daftar file yang akan disentuh
  │             (mode Plan: STOP di sini, tunggu perintah)
  │
  4. EKSEKUSI → edit minimal & presisi, satu concern per langkah
  │
  5. VALIDASI → php artisan test --filter=<relevan>
  │             → vendor/bin/pint --dirty
  │             → npm run build (jika ubah blade/css/js)
  │
  6. CATAT    → tambah entri changelog di akhir MEMORY.md
  │             (tanggal, fokus, file, ringkasan, catatan/risiko)
  │
  7. LAPOR    → ringkasan + temuan/risiko + langkah lanjut
[SELESAI]
```

### Perintah harian
| Kebutuhan | Perintah |
|---|---|
| Jalankan dev lengkap (server+queue+log+vite) | `composer run dev` |
| Test semua | `php artisan test` |
| Test 1 file | `php artisan test tests/Feature/XTest.php` |
| Test 1 nama | `php artisan test --filter=namaTest` |
| Format kode (wajib sebelum selesai) | `vendor/bin/pint --dirty` |
| Build asset | `npm run build` |
| Cek daftar route | `php artisan route:list --except-vendor` |
| Info environment | `php artisan about` |
| Storage link | `php artisan storage:link` |
| Migrasi & seed | `php artisan migrate` · `php artisan db:seed` |

### Definition of Done
- [ ] Perubahan hanya pada file relevan, alur lain tidak berubah
- [ ] Tidak ada error di log / browser console
- [ ] Test relevan dibuat & lulus
- [ ] `vendor/bin/pint --dirty` bersih
- [ ] Changelog `MEMORY.md` diperbarui
- [ ] Ringkasan hasil dilaporkan ke user

## 3. 🗺️ Peta Project & Konvensi

### Stack (jangan diubah tanpa izin)
| Layer | Teknologi |
|---|---|
| Backend | Laravel 12.37 (PHP 8.4) |
| Interaktivitas | Livewire 3.7 + Volt 1.x |
| UI | Flux UI 2 (free) + Tailwind CSS 4 (CSS-first `@theme`) |
| Auth | Fortify 1.30 (session) + Sanctum 4 (API token) |
| Export / PDF | `spatie/simple-excel` 3.8 · `barryvdh/laravel-dompdf` 3.1 |
| Database | MySQL `ppsr2025putra` (test: sqlite `:memory:`) |
| Build | Vite 7 |
| Test / Format | Pest 4 · Laravel Pint |

### Struktur penting
```
app/
├── Http/Controllers/Admin/     → CRUD per jenjang + Pendaftaran (+ export Excel) + konten (berita/fasilitas/guru/kontak)
├── Http/Requests/              → Form Request validasi konten (Berita/Fasilitas/Guru/Kontak)
├── Http/Controllers/Api/       → resource API (⚠️ tanpa auth)
├── Http/Middleware/CheckRole.php
├── Http/Responses/LoginResponse.php    → redirect per role setelah login
├── Livewire/                   → publik: PendaftaranForm, DaftarUlang*, CariSiswa,
│                                  Foto, UangMasuk, UpdateFoto
│   └── Admin/                  → Dashboard, *Table (4 jenjang + pendaftaran), Settings
├── Models/                     → 4 model siswa + Pendaftaran + User + Setting
│   └── Concerns/SanitizesInput.php
└── helpers.php                 → activeTahunAjaran()
resources/views/
├── admin/                      → layout + view CRUD per jenjang
├── livewire/                   → view semua komponen Livewire
├── layouts/standalone.blade.php → layout publik full-page
└── pdf/rapor.blade.php
routes/web.php (publik + admin) · routes/api.php (resource, tanpa auth)
database/migrations/ · database/seeders/ (UserSeeder = sumber kredensial)
```

### Konvensi kode
- **Livewire:** satu root element; `wire:model.live` untuk realtime; `wire:key` di dalam loop; `wire:loading` untuk state loading.
- **Volt:** komponen di project ini **class-based** (`new class extends Component`) — cek tetangga dulu sebelum membuat baru.
- **Validasi:** pesan error dalam **Bahasa Indonesia**. Untuk resource baru gunakan **Form Request** di `app/Http/Requests` (sudah ada: `BeritaRequest`, `FasilitasRequest`, `GuruRequest`, `KontakRequest`); controller siswa/pendaftaran masih inline (belum dimigrasi).
- **Konten HTML dari editor:** jangan pernah `{!! !!}` HTML mentah. Simpan lewat `App\Support\HtmlSanitizer::clean()` (whitelist tag/atribut) dan render dengan accessor `isi_html`.
- **Struktur halaman publik (full SPA Livewire):** SEMUA halaman publik adalah **komponen Livewire full-page** di `app/Livewire/Site/` (view di `resources/views/livewire/site/`) dan memakai satu layout bersama **`layouts.public`** (navbar `<livewire:site.navbar />` + `{{ $slot }}` + footer `<livewire:site.footer />`). Rute: `/` = `Site\Home`, `/berita` = `Site\BeritaIndex`, `/berita/{slug}` = `Site\BeritaShow`, `/fasilitas`, `/guru`, `/kontak`, `/psb`. **Semua tautan internal wajib `wire:navigate`** (kecuali `target="_blank"`/export). Jangan kembali ke `@extends`/controller untuk halaman publik.
- **Navigasi SPA (wire:navigate):** SEMUA tautan antar-halaman admin wajib memakai `wire:navigate` (termasuk tombol "Tambah", "Batal", "Lihat", "Edit", "Kembali"). **Pengecualian:** link **export Excel** dan tautan **`target="_blank"`** (file/gambar/`wa.me`/website) — jangan diberi `wire:navigate`.
- **Skrip di halaman admin:** karena halaman dinavigasi via SPA, skrip harus **tahan navigasi** — jangan asumsikan `<script>` hanya jalan sekali. Pola yang dipakai editor berita: `window.__initX()` idempoten (dijaga `dataset`) + panggil saat load + listener `document.addEventListener('livewire:navigated', ...)` yang didaftarkan sekali, dan aset pihak ketiga dimuat dinamis (`window.__quillMemuat`).
- **Eloquent:** pakai relasi bertipe + eager loading; hindari `DB::` (kecuali transaksi); prefer `Model::query()`.
- **Cast:** gunakan method `casts()` (konvensi Laravel 12), bukan property `$casts`.
- **Nama:** variabel & method deskriptif; PHPDoc untuk array shape.
- **UI:** komponen Flux bila tersedia, fallback komponen Blade sendiri; **wajib dukung dark mode** (`dark:`); spasi list pakai `gap-*`; jangan pakai utility Tailwind v3 yang deprecated.

---

## 4. 📊 Kondisi Project Saat Ini (per 17 Okt 2026)

### Fitur yang sudah berjalan
| Fitur | Route | Komponen |
|---|---|---|
| Pendaftaran awal (publik) | `/pendaftaran` | `PendaftaranForm` |
| Daftar ulang 2 step (publik) | `/daftar-ulang`, `/daftar-ulang/{id}` | `DaftarUlangTable`, `DaftarUlangForm` |
| Halaman utama (website sekolah) | `/` | **`Site\Home`** (Livewire) — carousel (`Site\Carousel`), berita terbaru, fasilitas, profil guru, kontak |
| Halaman publik: Berita | `/berita`, `/berita/{slug}` | **`Site\BeritaIndex`** (paginasi 9) + **`Site\BeritaShow`** (`isi_html`) |
| Halaman publik: Fasilitas | `/fasilitas` | **`Site\FasilitasIndex`** — kartu + galeri semua foto |
| Halaman publik: Profil Guru | `/guru` | **`Site\GuruIndex`** |
| Halaman publik: Kontak | `/kontak` | **`Site\KontakIndex`** — info lembaga, kontak person, peta |
| Navbar & footer publik | — | **`Site\Navbar`** + **`Site\Footer`** (Livewire) di dalam `layouts.public` — satu komponen dipakai semua halaman publik; logo `public/images/logo-navbar.webp` di kiri navbar; footer identik (link Cari Data Santri/Galeri Foto/Uang Masuk dihapus) |
| Galeri foto & uang masuk | `/foto`, `/uangmasuk` | `FotoTable`, `UangMasukTable` — kini pakai `layouts.public` (navbar/footer ikut) |
| PSB: pendaftaran & cari siswa | `/psb` | **`Site\Psb`** + `CariSiswaTable` — **min. 3 huruf** + **pagination 10/halaman** |
| Update foto mandiri (publik) | `/update-foto/{type}/{id}` | `UpdateFotoForm` |
| Galeri foto santri | `/foto` | `FotoTable` |
| Uang masuk (publik) | `/uangmasuk` | `UangMasukTable` |
| Cetak rapor PDF (auth) | `/cetak-rapor/generate` | `CetakRaporController` |
| Admin CRUD 4 jenjang + export | `/admin/{jenjang}*` | 4 controller + 4 tabel Livewire |
| Data pendaftaran admin | `/admin/pendaftarans*` | `PendaftaransTable` + `PendaftaranController` |
| Pengaturan (TA + header image) | `/admin/settings` | `Admin\Settings` |
| Konten: Berita | `/admin/beritas*` | `Admin\BeritasTable` + `Admin\BeritaController` |
| Konten: Fasilitas | `/admin/fasilitas*` | `Admin\FasilitasTable` + `Admin\FasilitasController` |
| Konten: Profil Guru | `/admin/gurus*` | `Admin\GurusTable` + `Admin\GuruController` |
| Konten: Kontak person | `/admin/kontaks*` | `Admin\KontaksTable` + `Admin\KontakController` |
| Konten: Kontak lembaga | `/admin/kontak-lembaga` | `Admin\KontakLembagaSettings` (tabel `settings`) |
| Konten: Carousel (halaman utama) | `/admin/carousels*` | `Admin\CarouselsTable` + `Admin\CarouselController` |
| API resource | `/api/*` | 5 controller API |

### Snapshot data (17 Okt 2026)
`pendaftaran` **236** (23 `pending`) · `mtsputra` 195 · `mtsputri` 389 · `maputra` 6 · `maputri` 22 · `users` 16
`settings`: `tahun_ajaran_aktif = 2026/2027`, `header_image = images/psb.webp`

### Alur data inti
```
pendaftarans (status = pending)
      │  DaftarUlangForm::submit()  [DB::transaction]
      ▼
tabel siswa sesuai jenjang (baris baru dibuat + upload KK/Akta/Pas Photo)
      │
      ▼
pendaftarans (status = completed, student_id & student_type terisi)

Mapping jenjang: Pendaftaran::getTargetModelClass() / getStudentType()
```

### Akun default (sumber: `database/seeders/UserSeeder.php`)
| Role | Email | Password |
|---|---|---|
| Super Admin | `admin@ppsr.local` | `password` |
| MTs Putra | `mtsputra@admin.com` | `123ppsr` |
| MTs Putri | `mtsputri@admin.com` | `123ppsr` |
| MA Putra | `maputra@admin.com` | `123ppsr` |
| MA Putri | `maputri@admin.com` | `123ppsr` |

### Struktur storage upload
```
storage/app/public/
├── pendaftaran/                       bukti transfer pendaftaran awal
├── dokumen-siswa/{transfer,kk,akta}/  dokumen daftar ulang
├── foto/                              pas photo (daftar ulang & update foto)
├── documents/{jenjang}/               dokumen + foto dari admin
├── settings/                          header image
├── konten/berita/                     gambar berita
├── konten/berita/isi/                 gambar di dalam isi berita (dari editor)
├── konten/fasilitas/                  gambar fasilitas
├── konten/guru/                       foto profil guru
├── konten/carousel/                   gambar slide carousel
└── temp/                              export Excel sementara
```

## 5. 🚧 Backlog & Temuan Review (belum dikerjakan)

> Sumber: review sesi 1 Juli 2026 (skor 7/10) + audit menyeluruh 17 Oktober 2026.
> Status: ⬜ belum · 🔄 sedang dikerjakan · ✅ selesai

### 🔴 Prioritas Kritis
| # | Temuan | Bukti | Status |
|---|---|---|---|
| K1 | Registrasi publik aktif + default role `admin` → siapa pun bisa mendaftar jadi admin | `config/fortify.php` (`Features::registration()`) · migration `2026_03_20_071742` (`->default('admin')`) | ⬜ |
| K2 | API `/api/*` tanpa auth — siapa pun bisa CRUD data santri | `routes/api.php` | ⬜ |
| K3 | Endpoint publik tanpa proteksi identitas: `/update-foto/{type}/{id}`, `/daftar-ulang/{id}`, `/uangmasuk` | `routes/web.php` | ⬜ |
| K4 | Dynamic class instantiation dari input request | `app/Http/Controllers/CetakRaporController.php` baris 21 (`$siswaType::find()`) | ⬜ |
| K5 | Backdoor email hardcoded `admin@ppsr.local` di `hasRole()` | `app/Models/User.php` | ⬜ |

### 🟡 Prioritas Menengah
| # | Temuan | Bukti | Status |
|---|---|---|---|
| M1 | Duplikasi masif 4 jenjang (controller/model/view/table/policy) → mulai drift: `casts()` tanggal hanya ada di `Mtsputri` | bandingkan `app/Models/Mtsputri.php` vs `Mtsputra.php` | ⬜ |
| M2 | Data loss di `DaftarUlangForm::submit()`: field tervalidasi tidak masuk `$data` (`status_milik`, `kode_pos`, `status_ayah/ibu/wali`, `jenjang_pendidikan_sebelumnya`, `status_sekolah_sebelumnya`, `kecamatan/kabupaten/provinsi_sekolah_sebelumnya`) | `app/Livewire/DaftarUlangForm.php` | ⬜ |
| M3 | Sanitasi XSS tidak konsisten — model `Pendaftaran` belum pakai `SanitizesInput` | `app/Models/Pendaftaran.php` | ⬜ |
| M4 | Orphan file upload Step 1 daftar ulang + tidak ada rate limit di endpoint upload publik | `DaftarUlangForm::submitStep1()` | ⬜ |
| M5 | Query boros — `CariSiswaTable` & `FotoTable` load semua baris 4 tabel lalu paginate manual di memori | `app/Livewire/CariSiswaTable.php`, `FotoTable.php` | ⬜ |
| M6 | Validasi inline panjang di controller (~70 rule) → pindahkan ke Form Request | `app/Http/Controllers/Admin/MtsputraController.php` | 🔄 (4 resource konten baru sudah pakai Form Request; siswa/pendaftaran belum) |
| M7 | Path & penamaan file upload tidak konsisten (nama memakai nama user + timestamp) | `storage/app/public/*` | ⬜ |
| M8 | `.env` belum production-ready (`APP_DEBUG=true`, DB `root/root`, `FILESYSTEM_DISK=local`) | `.env` | ⬜ |
| M9 | Sisa hardcode tahun ajaran di beberapa komponen walau `Setting` sudah ada | grep `2026/2027` | ⬜ |

### 🟢 Prioritas Ringan
| # | Temuan | Status |
|---|---|---|
| R1 | Tidak ada test untuk alur PPDB — `tests/` hanya starter kit (Auth, Settings, Dashboard) | 🔄 (185 test: PPDB + konten website sudah ditest; **15 test starter kit masih gagal** — route `dashboard`/`profile.edit` tidak ada di app ini) |
| R2 | Tidak ada factory untuk 4 model siswa (dan `Guru`) → sulit menulis feature test | 🔄 (factory `Berita`/`Fasilitas`/`Kontak` sudah dibuat) |
| R3 | `Pendaftaran` pakai property `$casts` (bukan method `casts()`); belum ada relasi `morphTo`; `kelas_id` tidak ada di `$fillable` | ⬜ |
| R4 | Modul akademik (`kelas`/`gurus`/`nilais`) belum terhubung ke model siswa → rapor kosong | ⬜ |
| R5 | Route sisa uji coba masih publik: `/lagibelajar`, `/beranda` | ⬜ |
| R6 | `AGENTS.md` & `CLAUDE.md` duplikat (±27KB); `.DS_Store` ikut ter-track | ⬜ |

---

## 6. ⚠️ Risiko & Catatan Penting

- **Jangan sentuh data produksi.** DB lokal berisi data nyata (236 pendaftaran). Selalu cek `git status` sebelum & sesudah kerja.
- `MEMORY.md` & `README.md` **ter-track git** → aman di-restore: `git checkout -- MEMORY.md`.
- File **untracked** saat ini: `AGENTS.md`, `CLAUDE.md`, `.cursor/`, `.junie/`, `.kilo/`, `.qwen/`, `.mcp.json`, `boost.json`, `opencode.json`, `.github/copilot-instructions.md`.
- File **termodifikasi belum di-commit**: `composer.json`, `composer.lock` (+`laravel/ai`, boost 1.8), `.DS_Store`.
- **Upload publik tanpa auth = permukaan risiko terbesar.** Hati-hati saat refactor endpoint publik.
- `resources/views/livewire/settings/*` ada, tetapi `Features::updateProfileInformation()` & `updatePasswords()` **dimatikan** di Fortify → verifikasi dulu sebelum menyentuh halaman settings.
- `DaftarUlangForm` menyimpan state di komponen: refresh halaman saat Step 2 akan mengulang Step 1.
- `Mtsputri` punya date cast, 3 model lain tidak → selalu pakai `\Carbon\Carbon::parse()` saat format tanggal dari model siswa.

## 7. 📝 Cara Menambah Catatan Sesi Baru

Setiap sesi selesai, tambahkan entri baru di **paling bawah** bagian ARSIP CHANGELOG HISTORIS, dengan format:

```markdown
# Changelog — Sesi <tanggal> — <fokus singkat>

> **Tanggal:** ...
> **Fokus:** ...

## Ringkasan Perubahan
- ...

## File yang Dimodifikasi
| File | Perubahan |
|------|-----------|
| `path/file.php` | ... |

## Hasil Validasi
- `php artisan test --filter=...` → lulus
- `vendor/bin/pint --dirty` → bersih

## Catatan / Risiko
- ...
```

---

# 📚 ARSIP CHANGELOG HISTORIS

> Arsip changelog asli project ini (22 April 2026 – 29 Juli 2026). **Jangan dihapus** — dipakai sebagai referensi riwayat keputusan & perubahan.
> Format entri baru: lihat bagian 7.

## 22 April 2026

### Filter Jenjang di Admin Data Pendaftaran

Menambahkan filter Jenjang Pendidikan di halaman admin data pendaftaran.

#### Backend (`app/Livewire/Admin/P registrantansTable.php`)

1. **Tambah property `$jenjang`** (line 23):
   ```php
   public ?string $jenjang = null;
   ```

2. **Tambah ke `$queryString`** (line 31):
   ```php
   protected $queryString = [
       'search' => ['except' => ''],
       'tahunAjaran' => ['except' => null],
       'status' => ['except' => ''],
       'jenjang' => ['except' => null],
   ];
   ```

3. **Tambah method `updatingJenjang()`** (lines 49-52):
   ```php
   public function updatingJenjang(): void
   {
       $this->resetPage();
   }
   ```

4. **Tambah filter di `render()`** (lines 221-223):
   ```php
   if ($this->jenjang) {
       $query->where('jenjang_pendidikan', $this->jenjang);
   }
   ```

5. **Tambah filter di `export()`** (lines 99-101):
   ```php
   if ($this->jenjang) {
       $query->where('jenjang_pendidikan', $this->jenjang);
   }
   ```

#### Frontend (`resources/views/livewire/admin/pendaftarans-table.blade.php`)

1. **Tambah dropdown filter Jenjang** (setelah dropdown Status):
   ```blade
   <select wire:model.live="jenjang" class="...">
       <option value="">Semua Jenjang</option>
       <option value="MTs Putri">MTs Putri</option>
       <option value="MTs Putra">MTs Putra</option>
       <option value="MA Putri">MA Putri</option>
       <option value="MA Putra">MA Putra</option>
   </select>
   ```

2. **Update kondisi Reset Filter** (line 56):
   ```blade
   @if($search || $tahunAjaran || $status || $jenjang)
   ```

3. **Update tombol Reset Filter**:
   ```blade
   wire:click="$set('search', ''); $set('tahunAjaran', null); $set('status', ''); $set('jenjang', null)"
   ```

---

### Ubah Kolom Kontak di Table

Mengubah tampilan kolom Kontak untuk menampilkan field `no_hp` dari database.

**File:** `resources/views/livewire/admin/pendaftarans-table.blade.php`

- Sebelum:
   ```blade
   {{ $pendaftaran->no_hp_ibu ?? $pendaftaran->no_hp_ayah ?? 'Tidak ada data' }}
   ```

- Sesudah:
   ```blade
   {{ $pendaftaran->no_hp ?? '-' }}
   ```

---

### Tambah Kolom Tanggal di Table

Menambahkan kolom Tanggal (create_at) di tabel data pendaftaran.

**File:** `resources/views/livewire/admin/pendaftarans-table.blade.php`

1. **Tambah header kolom Tanggal** (setelah Jenjang):
   ```blade
   <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">Tanggal</th>
   ```

2. **Tambah display tanggal di baris data**:
   ```blade
   <td class="px-6 py-4">
       <div class="text-sm text-zinc-900 font-medium">{{ $pendaftaran->created_at->format('d/m/Y') }}</div>
   </td>
   ```

3. **Update colspan** (untuk empty state):
   ```blade
   <td colspan="6" class="px-6 py-12 text-center">
   ```

---

## Catatan

- UI tidak diubah, hanya menambahkan fitur baru dengan gaya yang sudah ada
- Alur existing tidak diubah
- Filter Jenjang options menyesuaikan data di database: MTs Putri, MTs Putra, MA Putri, MA Putra
- Format tanggal: d/m/Y (contoh: 22/04/2026)

---

# Changelog — Fitur Pendaftaran Ulang (Daftar Ulang)

> **Tanggal:** 23 Mei 2026
> **File Utama:** `app/Livewire/DaftarUlangForm.php`, `resources/views/livewire/daftar-ulang-form.blade.php`

---

## Daftar Perubahan

### 1. Loading Overlay Saat Upload Bukti Transfer (Step 1)

**Masalah:** Tidak ada indikator visual saat user mengklik "Lanjutkan ke Form Data" — user tidak tahu apakah proses upload sedang berjalan.

**Solusi:**
- Awalnya dibuat **full-page overlay** dengan animasi:
  - Lingkaran spinner berputar + icon upload memantul
  - Teks "Mengupload Berkas..." + deskripsi
  - Progress bar dengan animasi pulse
  - Titik-titik memantul (bouncing dots)
  - Backdrop blur, dark mode support
- Overlay menggunakan `wire:loading wire:target="submitStep1"` (client-side CSS class agar muncul selama AJAX request)

**File:** `resources/views/livewire/daftar-ulang-form.blade.php`

---

### 2. Dark Mode Support untuk Input Teks

**Masalah:** Teks yang diinputkan user tidak terlihat di dark mode karena warna font sama dengan background.

**Solusi:** Memastikan semua input field memiliki class `dark:text-white` dan `dark:bg-gray-700` agar kontras di dark mode.

**File:** `resources/views/livewire/daftar-ulang-form.blade.php`

---

### 3. Real-time Progress Bar Upload (Livewire Upload Events)

**Masalah:** User tidak tahu progress upload file — hanya ada spinner tanpa indikasi berapa persen yang sudah terupload.

**Solusi:** Menambahkan **real-time progress bar** menggunakan Alpine.js + Livewire upload events:

```blade
<div x-data="{ uploading: false, progress: 0, uploaded: false }"
     x-on:livewire-upload-start.window="uploading = true; progress = 0; uploaded = false"
     x-on:livewire-upload-progress.window="progress = $event.detail.progress"
     x-on:livewire-upload-finish.window="uploading = false; uploaded = true"
     x-on:livewire-upload-error.window="uploading = false; uploaded = false">
```

- Progress bar dengan **gradient animasi** dan persentase real-time
- Spinner animasi selama upload
- Mengupdate lebar bar secara dinamis: `:style="'width: ' + progress + '%'"`
- Dark mode support penuh

**File:** `resources/views/livewire/daftar-ulang-form.blade.php`

---

### 4. Success Indicator Setelah Upload Berhasil

**Masalah:** Setelah file selesai diupload, user tidak mendapat konfirmasi yang jelas apakah file sudah tersimpan dengan baik.

**Solusi:** Menambahkan **success indicator** berupa:
- Card gradien hijau dengan background `from-green-50 to-emerald-50`
- Icon checkmark dalam lingkaran hijau
- Teks **"✓ File Berhasil Diupload!"**
- Nama file yang diupload
- Icon shield (security feel)
- Dark mode support

**File:** `resources/views/livewire/daftar-ulang-form.blade.php`

---

### 5. Tombol Disabled Selama Proses Upload

**Masalah:** Tombol "Lanjutkan ke Form Data" bisa diklik berkali-kali saat upload berlangsung, menyebabkan multiple request.

**Solusi:** Menambahkan `wire:loading.attr="disabled"` pada tombol:
```blade
<button type="submit" wire:loading.attr="disabled" ...>
```
- Tombol otomatis disabled selama proses upload
- Visual: `opacity-60`, `cursor-not-allowed`, hover effect dinonaktifkan

**File:** `resources/views/livewire/daftar-ulang-form.blade.php`

---

### 6. CSS `[x-cloak]` untuk Mencegah Flash Alpine.js

**Masalah:** Konten yang menggunakan `x-show` sempat terlihat sejenak sebelum Alpine.js selesai dimuat (flash of unstyled content).

**Solusi:** Menambahkan di `resources/css/app.css`:
```css
[x-cloak] { display: none !important; }
```

**File:** `resources/css/app.css`

---

### 7. Perbaikan Event Listener: `@` → `x-on:` + `.window` Modifier

**Masalah Kritis — ArgumentCountError (500 Internal Server Error):**
```
Too few arguments to function App\\Livewire\\DaftarUlangForm::{closure:...}()
```

**Penyebab:** Di Livewire 3, Blade menggunakan `@` untuk memanggil komponen (`@livewire('nama-komponen')`). Saat Blade membaca `@livewire-upload-start.window`, ia mengira itu pemanggilan komponen Livewire, lalu meng-compile-nya menjadi kode PHP yang salah.

**Solusi:**
1. Ganti `@livewire-upload-start.window` → `x-on:livewire-upload-start.window` (dan seterusnya untuk progress, finish, error)
2. Tambahkan **`.window` modifier** karena Livewire 3 mendispatch upload events dari component root (bubbling ke atas), jadi child element tidak akan menerima event tanpa `.window`
3. Hapus compiled view cache: `php artisan view:clear`

**File:** `resources/views/livewire/daftar-ulang-form.blade.php`

---

### 8. Animasi Loading Langsung di Dalam Tombol

**Masalah:** Full-page overlay menutupi seluruh form — user tidak bisa melihat form di belakangnya.

**Solusi:** Hapus full-page overlay, ganti dengan animasi **langsung di dalam tombol**:
- Spinner animasi berputar (`animate-spin`)
- Teks **"Menyimpan..."** dengan efek pulse (`animate-pulse`)
- **3 bouncing dots** putih di samping teks
- **Progress bar strip** di bagian bawah tombol (gradien, animasi pulse)
- Arrow icon di state default dengan efek hover `group-hover:translate-x-1`

Tambahan **info strip biru** di atas tombol:
> "Status upload akan terlihat di tombol di bawah. Mohon tunggu hingga proses selesai."

**File:** `resources/views/livewire/daftar-ulang-form.blade.php`

---

### 9. Progress Bar & Success Indicator untuk KK & Akta (Step 2)

**Masalah:** Upload Kartu Keluarga (KK) dan Akta Kelahiran di Step 2 tidak memiliki progress bar atau indikator sukses — user tidak tahu status upload.

**Solusi:** Menambahkan fitur yang sama seperti Step 1 untuk kedua upload:

| Fitur | KK | Akta |
|-------|----|------|
| Progress bar real-time | ✅ (teal theme) | ✅ (purple theme) |
| Success indicator | ✅ "✓ KK Berhasil Diupload!" | ✅ "✓ Akta Berhasil Diupload!" |
| Nama file preview | ✅ | ✅ |
| Fallback preview | ✅ | ✅ |

**Desain teknis:**
- **Satu `x-data` wrapper** untuk kedua upload dengan nested state objects:
  ```js
  { kkUpload: { uploading, progress, uploaded },
    aktaUpload: { uploading, progress, uploaded } }
  ```
- **Event diferensiasi** via `$event.detail?.model || $event.target.getAttribute?.('wire:model')` — fallback yang robust
- `.window` modifier pada semua event listeners

**File:** `resources/views/livewire/daftar-ulang-form.blade.php`

---

## Arsitektur Alur Upload

### Step 1 — Upload Bukti Transfer Pembayaran Uang Masuk

```
[User pilih file]
    ↓
Progress bar muncul (Livewire upload to temp, real-time 0-100%)
    ↓
Success indicator hijau + nama file
    ↓
[User klik "Lanjutkan ke Form Data"]
    ↓
Tombol disabled + animasi loading (spinner, dots, progress bar)
    ↓
File disimpan ke storage (`storage/app/public/dokumen-siswa/transfer/`)
    ↓
Otomatis pindah ke Step 2
```

### Step 2 — Upload Dokumen & Isi Data

```
[User pilih file KK]
    ↓
Progress bar teal (0-100%) + "Mengupload KK..."
    ↓
Success indicator: "✓ KK Berhasil Diupload!" + nama file
    ↓
[User pilih file Akta]
    ↓
Progress bar purple (0-100%) + "Mengupload Akta..."
    ↓
Success indicator: "✓ Akta Berhasil Diupload!" + nama file
    ↓
[User isi data lengkap → klik "Simpan Data"]
    ↓
Data disimpan + file KK & Akta ke storage
    ↓
Halaman sukses dengan ucapan terima kasih + Bahasa Arab
```

### Struktur File di Storage

```
storage/app/public/
└── dokumen-siswa/
    ├── transfer/
    │   └── TRANSFER_{NISN}_{Nama}_{Timestamp}.{ext}
    ├── kk/
    │   └── KK_{NISN}_{Nama}_{Timestamp}.{ext}
    └── akta/
        └── AKTA_{NISN}_{Nama}_{Timestamp}.{ext}
```

---

## Perbaikan Bug

| # | Bug | Penyebab | Solusi |
|---|-----|----------|--------|
| 1 | `ArgumentCountError` 500 | `@livewire-*` dikira Blade component | Ganti ke `x-on:livewire-*` |
| 2 | Alpine events tidak terdeteksi | Livewire dispatch dari component root (bubbling ke atas) | Tambah `.window` modifier |
| 3 | Flash of content sebelum Alpine siap | Belum ada CSS `[x-cloak]` | Tambah di `app.css` |
| 4 | Tombol bisa diklik ganda | Tidak ada `disabled` state | Tambah `wire:loading.attr="disabled"` |
| 5 | Progress KK & Akta interferensi | State terpisah bisa bereaksi ke upload lain | Satu wrapper + nested objects + diferensiasi model |

---

## File yang Dimodifikasi

| File | Perubahan |
|------|-----------|
| `app/Livewire/DaftarUlangForm.php` | Tambah `$fototransferPath`, simpan file di step 1, pakai `$this->fototransferPath` di submit step 2 |
| `resources/views/livewire/daftar-ulang-form.blade.php` | Progress bar, success indicator, animasi tombol, Alpine upload events, dark mode, info strip |
| `resources/css/app.css` | Tambah `[x-cloak]` CSS rule |

---

## Teknologi yang Digunakan

- **Livewire 3** — `wire:model` untuk file upload, `wire:loading` untuk loading states
- **Alpine.js 3** — `x-data`, `x-on:`, `x-show`, `x-cloak`, `x-text`, `:style` untuk reactive UI
- **Tailwind CSS 4** — animasi (`animate-spin`, `animate-pulse`, `animate-bounce`), gradient, dark mode
- **PHP 8.4 / Laravel 12** — backend logic, file storage

---

# Changelog — Sesi 24 Mei 2026 — Role-Based Access, Perbaikan Form & Preview Upload

> **Tanggal:** 24 Mei 2026
> **Fokus:** Role-based redirect, sembunyikan menu non-admin, perbaikan form edit, audit & debug fitur Pendaftaran Ulang, optimasi upload & preview

---

## 1. Login Redirect: Fix 403 untuk Non-Admin

**File:** `app/Http/Responses/LoginResponse.php`

**Masalah:** User non-admin (mtsputra, mtsputri, maputra, maputri) mendapat **403 Unauthorized** setelah login karena `redirect()->intended()` mengirim mereka kembali ke `/admin` (URL sebelum login) yang sekarang dilindungi middleware `CheckRole:admin`.

**Solusi:**
- Ganti `redirect()->intended($default)` → `redirect()->to($url)` langsung
- Admin → `/admin`
- Mtsputra → `/admin/mtsputras`
- Mtsputri → `/admin/mtsputris`
- Maputra → `/admin/maputras`
- Maputri → `/admin/maputris`

---

## 2. Sembunyikan Menu Data Pendaftaran untuk Non-Admin

**File:** `resources/views/admin/layout.blade.php`, `routes/web.php`

**Masalah:** User non-admin masih melihat menu "Data Pendaftaran" di sidebar & bisa mengakses route `/admin/pendaftarans`.

**Solusi:**
- **Sidebar desktop & mobile** — Bungkus menu Pendaftaran dengan `@if(auth()->user()->hasRole('admin'))`
- **Route `pendaftarans`** — Tambah middleware `CheckRole:admin` ke semua route grup pendaftaran

---

## 3. Perbaikan Tanggal Lahir Hilang di Form Edit

**File (4 file):**
- `resources/views/admin/mtsputris/edit.blade.php`
- `resources/views/admin/mtsputras/edit.blade.php`
- `resources/views/admin/maputras/edit.blade.php`
- `resources/views/admin/maputris/edit.blade.php`

**Masalah:** Field `<input type="date">` menampilkan kosong karena:
- Mtsputri punya `'tanggal_lahir' => 'date'` cast → return Carbon → `Carbon::__toString()` menghasilkan format `2025-01-15 00:00:00` → tidak kompatibel dengan `input type="date"` (butuh `Y-m-d`)
- Mtsputra/Maputra/Maputri **tidak punya** date cast → return string → `->format()` error

**Solusi:**
```blade
value="{{ old('tanggal_lahir', $model->tanggal_lahir ? \Carbon\Carbon::parse($model->tanggal_lahir)->format('Y-m-d') : '') }}"
```
- `\Carbon\Carbon::parse()` menangani **string** maupun **Carbon object** dengan aman
- Null-safe ternary untuk handle nilai null

---

## 4. Audit Menyeluruh Fitur Pendaftaran Ulang (Daftar Ulang)

**File yang diaudit:**
- `app/Livewire/DaftarUlangForm.php`
- `app/Livewire/DaftarUlangTable.php`
- `resources/views/livewire/daftar-ulang-form.blade.php`
- `resources/views/livewire/daftar-ulang-table.blade.php`
- `config/filesystems.php`
- `routes/web.php`
- Migration files

### 🔴 Bug Ditemukan & Diperbaiki

| # | Bug | Detail |
|---|------|--------|
| 1 | **Tombol "Simpan Data" Step 2 tidak ada `wire:loading.attr="disabled"`** | Bisa menyebabkan double submit. Sudah diperbaiki dengan animasi loading lengkap: spinner, pulsing text, bouncing dots, progress bar strip |

### 🟡 Catatan Non-Kritis
1. Tahun ajaran di `DaftarUlangTable.php:14` masih hardcoded `'2026/2027'`
2. Beberapa field nullable di $data tidak ada input form (kk, nis, status_ayah, rt, rw, dll.)
3. `no_hp_ibu` tidak di-pre-populate dari pendaftaran awal

### ✅ Status Berfungsi Normal
- Upload file ke storage (transfer/, kk/, akta/) ✅
- Progress bar real-time (Alpine + Livewire upload events) ✅
- Success indicator ✅
- DB::transaction ✅
- Dark mode ✅
- Error handling ✅

---

## 5. Hapus Info Strip Biru di Step 1

**File:** `resources/views/livewire/daftar-ulang-form.blade.php`

**Perubahan:** Hapus info strip:
```
"Status upload akan terlihat di tombol di bawah. Mohon tunggu hingga proses selesai."
```

---

## 6. Limit Upload Diubah ke 2MB

**File:** `app/Livewire/DaftarUlangForm.php`, `resources/views/livewire/daftar-ulang-form.blade.php`

**Perubahan:** Semua validasi upload diubah dari `max:5120` (5MB) ke `max:2048` (2MB):
- `fototransfer` (Bukti Transfer — Step 1)
- `fotokk` (Kartu Keluarga — Step 2)
- `fotoakta` (Akta Kelahiran — Step 2)

Teks petunjuk juga diubah: "Max. 5MB" → "Max. 2MB"

---

## 7. Preview File KK & Akta (wire:model.live)

**File:** `resources/views/livewire/daftar-ulang-form.blade.php`, `app/Livewire/DaftarUlangForm.php`

### Perubahan
1. **`wire:model` → `wire:model.live`** — file langsung diupload ke Livewire temp storage saat dipilih
2. **Preview Gambar KK** — thumbnail image dalam card teal setelah upload berhasil
3. **Preview Gambar Akta** — thumbnail image dalam card purple setelah upload berhasil
4. **File PDF** — icon placeholder dengan nama file (preview tidak tersedia)
5. **`temporaryUrl()`** — untuk preview gambar real-time

### Bug: Preview Tidak Muncul

**Masalah:** Preview dibungkus `x-show="kkUpload.uploaded"` yang bergantung pada Alpine state. Setelah `wire:model.live` selesai upload, Livewire re-render (morphdom) bisa mereset Alpine `x-data` → `uploaded` jadi `false` → preview tersembunyi.

**Solusi:** Ganti dari:
```blade
<div x-show="kkUpload.uploaded" x-cloak>
    @if ($fotokk) ... @endif
</div>
```
Menjadi (murni Blade):
```blade
@if ($fotokk)
    <div class="mt-3 animate-fadeIn">
        @if (in_array(...)) ... @else ... @endif
    </div>
@endif
```

Preview muncul saat Livewire re-render dengan `$fotokk` terisi — tidak tergantung Alpine state.

---

## 8. CSS animate-fadeIn

**File:** `resources/css/app.css`

**Tambahan:**
```css
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
}
```
- Didaftarkan di `@theme { --animate-fadeIn: fadeIn 0.4s ease-out; }`
- Untuk smooth appearance saat preview muncul setelah upload

---

## 9. Ubah Teks Informasi Selanjutnya

**File:** `resources/views/livewire/daftar-ulang-form.blade.php`

**Perubahan teks di halaman sukses:**
- **Sebelum:** "Data Anda telah tersimpan. Silakan tunggu informasi selanjutnya dari pihak sekolah mengenai jadwal tes dan pengumuman."
- **Sesudah:** "Data Alhamdulillah sudah tersimpan dan mohon tunggu informasi selanjutnya oleh Pihak Pondok Pesantren Syafa'aturrasul"

---

## Ringkasan File yang Dimodifikasi (Sesi Ini)

| File | Perubahan |
|------|-----------|
| `app/Http/Responses/LoginResponse.php` | Ganti `intended()` → `to()` untuk redirect non-admin |
| `resources/views/admin/layout.blade.php` | Sembunyikan menu Pendaftaran untuk non-admin |
| `routes/web.php` | Tambah middleware `CheckRole:admin` ke route pendaftaran |
| `resources/views/admin/mtsputris/edit.blade.php` | Fix tanggal_lahir pakai `Carbon::parse()` |
| `resources/views/admin/mtsputras/edit.blade.php` | Fix tanggal_lahir pakai `Carbon::parse()` |
| `resources/views/admin/maputras/edit.blade.php` | Fix tanggal_lahir pakai `Carbon::parse()` |
| `resources/views/admin/maputris/edit.blade.php` | Fix tanggal_lahir pakai `Carbon::parse()` |
| `app/Livewire/DaftarUlangForm.php` | Limit upload 2MB + `wire:model.live` untuk fotokk & fotoakta |
| `resources/views/livewire/daftar-ulang-form.blade.php` | Animasi loading tombol Step 2, hapus info strip, limit upload 2MB, `wire:model.live`, preview KK/Akta, fix preview bug, ubah teks sukses |
| `resources/css/app.css` | Tambah CSS `@keyframes fadeIn` & `--animate-fadeIn` |

---

## Daftar User Non-Admin

> Kredensial berikut bersumber dari `database/seeders/UserSeeder.php` (referensi tunggal yang benar).

| Role | Nama | Email | Password |
|------|------|-------|----------|
| 🟢 **MTs Putra** | Admin MTs Putra | `mtsputra@admin.com` | `123ppsr` |
| 🟣 **MTs Putri** | Admin MTs Putri | `mtsputri@admin.com` | `123ppsr` |
| 🔵 **MA Putra** | Admin MA Putra | `maputra@admin.com` | `123ppsr` |
| 🟠 **MA Putri** | Admin MA Putri | `maputri@admin.com` | `123ppsr` |
| 🔴 **Super Admin** | Admin PPSR | `admin@ppsr.local` | `password` |

---

# Dokumentasi Route

> **File:** `routes/web.php`, `routes/api.php`
> **Auth:** Laravel Fortify (email + password) + Sanctum (API token)
> **Middleware Roles:** `CheckRole:admin`, `CheckRole:mtsputra`, `CheckRole:mtsputri`, `CheckRole:maputra`, `CheckRole:maputri`

---

## Public Routes (No Auth Required)

| Method | URL | Nama Route | Controller/Component | Keterangan |
|--------|-----|------------|---------------------|------------|
| `GET` | `/` | `home` | `welcome.blade.php` | Halaman utama / landing page |
| `GET` | `/beranda` | `beranda` | `testcoba.blade.php` | Halaman beranda (test) |
| `GET` | `/lagibelajar` | — | `HelloWorld` Livewire | Halaman uji coba |
| `GET` | `/pendaftaran` | `pendaftaran` | `PendaftaranForm` Livewire | Form pendaftaran siswa baru |
| `GET` | `/daftar-ulang` | `daftar-ulang.table` | `DaftarUlangTable` Livewire | Tabel daftar ulang (entry point) |
| `GET` | `/daftar-ulang/{id}` | `daftar-ulang.form` | `DaftarUlangForm` Livewire | Form pendaftaran ulang per siswa |

---

## Public Route (Auth Required)

| Method | URL | Nama Route | Controller | Middleware | Keterangan |
|--------|-----|------------|-----------|------------|------------|
| `GET` | `/cetak-rapor/generate` | `cetak-rapor.generate` | `CetakRaporController@generate` | `auth` | Generate & cetak rapor PDF |

---

## Admin Routes — Prefix `/admin` (Auth: `auth`, `verified`)

Semua route di bawah membutuhkan login (`auth`) dan verifikasi email (`verified`).

### Dashboard (Hanya Admin)

| Method | URL | Nama Route | Component | Middleware |
|--------|-----|------------|-----------|-----------|
| `GET` | `/admin` | `admin.dashboard` | `Admin\Dashboard` Livewire | `CheckRole:admin` |

---

### MTs Putra — Prefix `/admin/mtsputras` (Role: `mtsputra`)

| Method | URL | Nama Route | Controller/Component |
|--------|-----|------------|---------------------|
| `GET` | `/admin/mtsputras` | `admin.mtsputras.index` | `Admin\MtsputrasTable` Livewire |
| `GET` | `/admin/mtsputras/create` | `admin.mtsputras.create` | `MtsputraController@create` |
| `POST` | `/admin/mtsputras` | `admin.mtsputras.store` | `MtsputraController@store` |
| `GET` | `/admin/mtsputras-export` | `admin.mtsputras.export` | `MtsputraController@export` |
| `GET` | `/admin/mtsputras/{id}` | `admin.mtsputras.show` | `MtsputraController@show` |
| `GET` | `/admin/mtsputras/{id}/edit` | `admin.mtsputras.edit` | `MtsputraController@edit` |
| `PUT` | `/admin/mtsputras/{id}` | `admin.mtsputras.update` | `MtsputraController@update` |
| `DELETE` | `/admin/mtsputras/{id}` | `admin.mtsputras.destroy` | `MtsputraController@destroy` |

---

### MTs Putri — Prefix `/admin/mtsputris` (Role: `mtsputri`)

| Method | URL | Nama Route | Controller/Component |
|--------|-----|------------|---------------------|
| `GET` | `/admin/mtsputris` | `admin.mtsputris.index` | `Admin\MtsputrisTable` Livewire |
| `GET` | `/admin/mtsputris/create` | `admin.mtsputris.create` | `MtsputriController@create` |
| `POST` | `/admin/mtsputris` | `admin.mtsputris.store` | `MtsputriController@store` |
| `GET` | `/admin/mtsputris-export` | `admin.mtsputris.export` | `MtsputriController@export` |
| `GET` | `/admin/mtsputris/{id}` | `admin.mtsputris.show` | `MtsputriController@show` |
| `GET` | `/admin/mtsputris/{id}/edit` | `admin.mtsputris.edit` | `MtsputriController@edit` |
| `PUT` | `/admin/mtsputris/{id}` | `admin.mtsputris.update` | `MtsputriController@update` |
| `DELETE` | `/admin/mtsputris/{id}` | `admin.mtsputris.destroy` | `MtsputriController@destroy` |

---

### MA Putra — Prefix `/admin/maputras` (Role: `maputra`)

| Method | URL | Nama Route | Controller/Component |
|--------|-----|------------|---------------------|
| `GET` | `/admin/maputras` | `admin.maputras.index` | `Admin\MaputrasTable` Livewire |
| `GET` | `/admin/maputras/create` | `admin.maputras.create` | `MaputraController@create` |
| `POST` | `/admin/maputras` | `admin.maputras.store` | `MaputraController@store` |
| `GET` | `/admin/maputras-export` | `admin.maputras.export` | `MaputraController@export` |
| `GET` | `/admin/maputras/{id}` | `admin.maputras.show` | `MaputraController@show` |
| `GET` | `/admin/maputras/{id}/edit` | `admin.maputras.edit` | `MaputraController@edit` |
| `PUT` | `/admin/maputras/{id}` | `admin.maputras.update` | `MaputraController@update` |
| `DELETE` | `/admin/maputras/{id}` | `admin.maputras.destroy` | `MaputraController@destroy` |

---

### MA Putri — Prefix `/admin/maputris` (Role: `maputri`)

| Method | URL | Nama Route | Controller/Component |
|--------|-----|------------|---------------------|
| `GET` | `/admin/maputris` | `admin.maputris.index` | `Admin\MaputrisTable` Livewire |
| `GET` | `/admin/maputris/create` | `admin.maputris.create` | `MaputriController@create` |
| `POST` | `/admin/maputris` | `admin.maputris.store` | `MaputriController@store` |
| `GET` | `/admin/maputris-export` | `admin.maputris.export` | `MaputriController@export` |
| `GET` | `/admin/maputris/{id}` | `admin.maputris.show` | `MaputriController@show` |
| `GET` | `/admin/maputris/{id}/edit` | `admin.maputris.edit` | `MaputriController@edit` |
| `PUT` | `/admin/maputris/{id}` | `admin.maputris.update` | `MaputriController@update` |
| `DELETE` | `/admin/maputris/{id}` | `admin.maputris.destroy` | `MaputriController@destroy` |

---

### Data Pendaftaran — Prefix `/admin/pendaftarans` (Hanya Admin: `CheckRole:admin`)

| Method | URL | Nama Route | Controller/Component |
|--------|-----|------------|---------------------|
| `GET` | `/admin/pendaftarans` | `admin.pendaftarans.index` | `Admin\PendaftaransTable` Livewire |
| `GET` | `/admin/pendaftarans/create` | `admin.pendaftarans.create` | `PendaftaranController@create` |
| `POST` | `/admin/pendaftarans` | `admin.pendaftarans.store` | `PendaftaranController@store` |
| `GET` | `/admin/pendaftarans/{id}` | `admin.pendaftarans.show` | `PendaftaranController@show` |
| `GET` | `/admin/pendaftarans/{id}/edit` | `admin.pendaftarans.edit` | `PendaftaranController@edit` |
| `PUT` | `/admin/pendaftarans/{id}` | `admin.pendaftarans.update` | `PendaftaranController@update` |
| `DELETE` | `/admin/pendaftarans/{id}` | `admin.pendaftarans.destroy` | `PendaftaranController@destroy` |
| `GET` | `/admin/pendaftarans-export` | `admin.pendaftarans.export` | `PendaftaranController@export` |

---

## API Routes — Prefix `/api` (Sanctum)

| Method | URL | Controller | Auth |
|--------|-----|-----------|------|
| `GET` | `/api/user` | — (Closure) | `auth:sanctum` |
| `GET` | `/api/pendaftaran` | `Api\PendaftaranController@index` | — |
| `POST` | `/api/pendaftaran` | `Api\PendaftaranController@store` | — |
| `GET` | `/api/pendaftaran/{id}` | `Api\PendaftaranController@show` | — |
| `PUT` | `/api/pendaftaran/{id}` | `Api\PendaftaranController@update` | — |
| `DELETE` | `/api/pendaftaran/{id}` | `Api\PendaftaranController@destroy` | — |
| `GET` | `/api/mtsputri` | `Api\MtsputriController@index` | — |
| `POST` | `/api/mtsputri` | `Api\MtsputriController@store` | — |
| `GET` | `/api/mtsputri/{id}` | `Api\MtsputriController@show` | — |
| `PUT` | `/api/mtsputri/{id}` | `Api\MtsputriController@update` | — |
| `DELETE` | `/api/mtsputri/{id}` | `Api\MtsputriController@destroy` | — |
| `GET` | `/api/mtsputra` | `Api\MtsputraController@index` | — |
| `POST` | `/api/mtsputra` | `Api\MtsputraController@store` | — |
| `GET` | `/api/mtsputra/{id}` | `Api\MtsputraController@show` | — |
| `PUT` | `/api/mtsputra/{id}` | `Api\MtsputraController@update` | — |
| `DELETE` | `/api/mtsputra/{id}` | `Api\MtsputraController@destroy` | — |
| `GET` | `/api/maputri` | `Api\MaputriController@index` | — |
| `POST` | `/api/maputri` | `Api\MaputriController@store` | — |
| `GET` | `/api/maputri/{id}` | `Api\MaputriController@show` | — |
| `PUT` | `/api/maputri/{id}` | `Api\MaputriController@update` | — |
| `DELETE` | `/api/maputri/{id}` | `Api\MaputriController@destroy` | — |
| `GET` | `/api/maputra` | `Api\MaputraController@index` | — |
| `POST` | `/api/maputra` | `Api\MaputraController@store` | — |
| `GET` | `/api/maputra/{id}` | `Api\MaputraController@show` | — |
| `PUT` | `/api/maputra/{id}` | `Api\MaputraController@update` | — |
| `DELETE` | `/api/maputra/{id}` | `Api\MaputraController@destroy` | — |

---

## Ringkasan Akses per Role

| Role | Dashboard | MTs Putra | MTs Putri | MA Putra | MA Putri | Pendaftaran | Daftar Ulang |
|------|:---------:|:---------:|:---------:|:--------:|:--------:|:-----------:|:------------:|
| 🔴 **admin** | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |
| 🟢 **mtsputra** | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | ✅ |
| 🟣 **mtsputri** | ❌ | ❌ | ✅ | ❌ | ❌ | ❌ | ✅ |
| 🔵 **maputra** | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ | ✅ |
| 🟠 **maputri** | ❌ | ❌ | ❌ | ❌ | ✅ | ❌ | ✅ |
| 👤 **Tamu (no login)** | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ (terbatas) |

---

---

# Changelog — Sesi 28 Mei 2026 — Perbaikan Tabel, Form Edit Lengkap & Fitur WhatsApp

> **Tanggal:** 28 Mei 2026
> **Fokus:** Tampilan tabel pendaftaran, edit form lengkap semua jenjang, fitur WhatsApp, perbaikan alamat di view/show

---

## 1. Format Tanggal & Jam WIB di Tabel Pendaftaran Admin

**File:** `resources/views/livewire/admin/pendaftarans-table.blade.php`

**Perubahan:**
- Kolom "Tanggal" → "Tgl. Daftar"
- Format: `27 Mei 2026` (locale Indonesia) + `14:30 WIB`
- Timezone: `Asia/Jakarta`
- Menghindari double `setTimezone()` dengan menyimpan ke variable `$wib` di `@php` block

```blade
@php
    $wib = $pendaftaran->created_at->setTimezone('Asia/Jakarta');
@endphp
<div class="text-sm text-zinc-900 font-medium">{{ $wib->locale('id')->isoFormat('D MMMM Y') }}</div>
<div class="text-xs text-zinc-400 font-medium mt-0.5">{{ $wib->format('H:i') }} WIB</div>
```

---

## 2. Edit Form Lengkap untuk Semua Jenjang Siswa

**File (4 file):**
- `resources/views/admin/mtsputras/edit.blade.php`
- `resources/views/admin/mtsputris/edit.blade.php`
- `resources/views/admin/maputras/edit.blade.php`
- `resources/views/admin/maputris/edit.blade.php`

**Perubahan:** Form minimal → form **lengkap** (sama dengan create form):

| Section | Field |
|---------|-------|
| Data Pribadi | nama, NIK, tempat/tgl lahir, NISN, NIS, KK, kepala keluarga, anak ke-, jumlah saudara, tahun ajaran, tgl masuk, KKS, PKH, KIP |
| Sekolah Sebelumnya | jenjang, status, nama sekolah, NPSN, alamat, kecamatan, kabupaten, provinsi |
| Data Ayah + Ibu | lengkap dengan dropdown pendidikan, pekerjaan, penghasilan + JS auto-set |
| Alamat | status milik + alamat rumah (khusus MA: `alamat_rumah_tinggal`) + RT/RW, desa, kec, kab, prov, kode pos |
| Data Wali | NIK, nama, tempat/tgl lahir, no HP, pendidikan, pekerjaan, penghasilan |
| Dokumen | upload KK, Akta, Transfer (dengan info file existing) |

Semua data terisi otomatis dari database via `old('field', $siswa->field)`.

---

## 3. Tombol WhatsApp di Tabel Pendaftaran Admin

**File:** `resources/views/livewire/admin/pendaftarans-table.blade.php`, `app/Livewire/Admin/PendaftaransTable.php`

**Perubahan:**
- Tombol WA hijau di kolom **Aksi** → `wa.me/6285259875754`
- Pesan otomatis berisi:
  - Nama, Tempat/Tgl Lahir, Jenjang, Nama Ayah, Nama Ibu
  - Asal Sekolah (`nama_sekolah_sebelumnya` → `asal_sekolah`)
  - No. Kontak (`no_hp` → `no_hp_ayah` → `no_hp_ibu`)
  - Alamat (dari `alamat` atau gabungan desa/kec/kab/prov yang difilter)

**Bug fix — `Undefined variable`:**
- **Akar masalah:** Variable dari `@php` block di Livewire Blade compiler tidak bisa diakses di luar block karena masalah scoping kompilasi
- **Solusi:** Memindahkan logic ke **static method** `waUrl($p)` di class `PendaftaransTable` dan memanggil langsung via `{{ PendaftaransTable::waUrl($pendaftaran) }}` di atribut `href`
- Alamat menggunakan `collect()->filter()->implode(', ')` agar tidak ada koma berlebih

---

## 4. Kolom Asal Sekolah di Tabel Pendaftaran Admin

**File:** `resources/views/livewire/admin/pendaftarans-table.blade.php`

**Perubahan:**
- Menambahkan kolom **"Asal Sekolah"** di antara kolom Jenjang dan Tgl. Daftar
- Menampilkan `nama_sekolah_sebelumnya` → `asal_sekolah` → `-`
- Update `colspan` baris kosong dari 6 → 7

---

## 5. Perbaikan Alamat di View Detail Pendaftaran (Show)

**File:** `resources/views/admin/pendaftarans/show.blade.php`

**Masalah:** Field `alamat` (diisi di form pendaftaran awal — textarea alamat lengkap) tidak ditampilkan di halaman detail/show. Yang tampil hanya `alamat_rumah_tinggal` (field berbeda yang hanya terisi saat daftar ulang).

**Solusi:** Menambahkan baris **"Alamat Lengkap (Pendaftaran)"** (`$student->alamat`) di atas "Alamat Rumah Tinggal Detail":

```blade
<div class="sm:col-span-3">
    <x-detail-item label="Alamat Lengkap (Pendaftaran)" :value="$student->alamat" />
</div>
<div class="sm:col-span-2">
    <x-detail-item label="Alamat Rumah Tinggal Detail" :value="$student->alamat_rumah_tinggal" />
</div>
```

---

## 6. Form Edit Pendaftaran Lengkap (Admin)

### Controller (`app/Http/Controllers/Admin/PendaftaranController.php`)

**Validasi update method — field yang ditambahkan:**
- `status_pendaftaran`, `hobi`, `cita_cita`, `tk`, `paud`
- `alamat`, `alamat_rumah_tinggal`, `asal_sekolah`, `no_hp`
- `status_bayar_uang_masuk`, `keterangan_bayar`, `bukti_transfer_uang_masuk`

**Tambahan:**
- Handler upload `bukti_transfer_uang_masuk`
- Cleanup file `bukti_transfer_uang_masuk` di method `destroy`

### View (`resources/views/admin/pendaftarans/edit.blade.php`)

Rewrite total dari form minimal → form lengkap dengan **10 section**:

| Section | Grid | Field Utama |
|---------|------|-------------|
| **Data Pendaftaran** | 2 col | status, jenjang, nama, TTL, NIK, NISN, NIS, tahun ajaran, no_hp |
| **Data Pribadi Tambahan** | 2 col | KK, nama_kk, anak_ke, jumlah_saudara, hobi, cita_cita, tgl_masuk, tk, paud |
| **Alamat & Tempat Tinggal** | 3 col | alamat, alamat_rumah_tinggal, status_milik, RT/RW, desa, kec, kab, prov, kode_pos |
| **Bantuan Sosial** | 2 col | KKS, PKH, KIP |
| **Pendidikan Sebelumnya** | 2 col | asal_sekolah, jenjang, status, nama, NPSN, alamat, kec, kab, prov sekolah |
| **Data Ayah** | 2 col | nama, NIK, TTL, status, no_hp, pendidikan, pekerjaan, penghasilan |
| **Data Ibu** | 2 col | nama, NIK, TTL, status, no_hp, pendidikan, pekerjaan, penghasilan |
| **Data Wali** | 3 col | nama, NIK, TTL, no_hp, pendidikan, pekerjaan, penghasilan |
| **Keuangan** | 3 col | bayar_uang_masuk, status_bayar, keterangan, upload bukti |
| **Dokumen** | 3 col | upload KK, Akta, Transfer (dengan preview gambar) |

---

## Ringkasan File yang Dimodifikasi (Sesi Ini)

| File | Perubahan |
|------|-----------|
| `resources/views/livewire/admin/pendaftarans-table.blade.php` | Format tgl WIB, tombol WhatsApp, kolom Asal Sekolah |
| `app/Livewire/Admin/PendaftaransTable.php` | Tambah static method `waUrl()` |
| `resources/views/admin/mtsputras/edit.blade.php` | Form edit lengkap |
| `resources/views/admin/mtsputris/edit.blade.php` | Form edit lengkap |
| `resources/views/admin/maputras/edit.blade.php` | Form edit lengkap (plus alamat_rumah_tinggal) |
| `resources/views/admin/maputris/edit.blade.php` | Form edit lengkap (plus alamat_rumah_tinggal) |
| `resources/views/admin/pendaftarans/show.blade.php` | Tambah field alamat |
| `resources/views/admin/pendaftarans/edit.blade.php` | Form edit lengkap 10 section |
| `app/Http/Controllers/Admin/PendaftaranController.php` | Validasi field baru, upload handler, cleanup destroy |

---

## Diagram Navigasi

```
[Home] ──── [Pendaftaran (Public)]
  │              └─ Form Pendaftaran (Livewire)
  │
  ├── [Daftar Ulang (Public)]
  │      └─ /daftar-ulang/{id} → Form (Livewire)
  │
  ├── [Login] ── [Dashboard /admin] (admin only)
  │      │
  │      ├── /admin/mtsputras/*   (mtsputra)
  │      ├── /admin/mtsputris/*   (mtsputri)
  │      ├── /admin/maputras/*    (maputra)
  │      ├── /admin/maputris/*    (maputri)
  │      └── /admin/pendaftarans/* (admin only)
  │
  └── [API] ── /api/pendaftaran, /api/mtsputri, /api/mtsputra, /api/maputri, /api/maputra
```

---

# Changelog — Sesi 23 Juni 2026 — Fitur Foto Profil Siswa & Pencarian Data

> **Tanggal:** 23 Juni 2026
> **Fokus:** Menambahkan fitur foto profil (pas photo) untuk semua jenjang siswa, halaman pencarian data siswa di beranda, dan form update foto mandiri

---

## 1. Migration — Tambah Kolom `foto` di Semua Tabel Siswa

**File:** `database/migrations/2026_06_23_000001_add_foto_to_student_tables.php` (NEW)

Menambahkan kolom `foto` (nullable string) setelah kolom `fototransfer` di 4 tabel:
- `mtsputras`
- `mtsputris`
- `maputras`
- `maputris`

```php
$table->string('foto')->nullable()->after('fototransfer');
```

---

## 2. Models — Tambah `foto` ke $fillable

**File (4 file):**
- `app/Models/Maputra.php`
- `app/Models/Maputri.php`
- `app/Models/Mtsputra.php`
- `app/Models/Mtsputri.php`

**Perubahan:** Menambahkan `'foto'` ke array `$fillable`.

---

## 3. Controllers — Upload Foto Profil

**File (4 file):**
- `app/Http/Controllers/Admin/MaputraController.php`
- `app/Http/Controllers/Admin/MaputriController.php`
- `app/Http/Controllers/Admin/MtsputraController.php`
- `app/Http/Controllers/Admin/MtsputriController.php`

**Perubahan di method `store()`:**
- Validasi: `'foto' => 'nullable|image|max:2048'`
- Upload: `$validated['foto'] = $request->file('foto')->storeAs('documents/{jenjang}', 'foto_' . $validated['nama'] . '.' . $ext, 'public');`

**Perubahan di method `update()`:**
- Validasi: `'foto' => 'nullable|image|max:2048'`
- Hapus foto lama jika ada: `if ($siswa->foto) Storage::disk('public')->delete($siswa->foto);`
- Upload foto baru dengan nama `foto_{Nama}.{ext}`

**Perubahan di method `destroy()`:**
- Cleanup: `if ($siswa->foto) Storage::disk('public')->delete($siswa->foto);`

**Path penyimpanan:**
| Jenjang | Storage Path |
|---------|-------------|
| Mtsputra | `documents/mtsputra/foto_{Nama}.{ext}` |
| Mtsputri | `documents/mtsputri/foto_{Nama}.{ext}` |
| Maputra | `documents/maputra/foto_{Nama}.{ext}` |
| Maputri | `documents/maputri/foto_{Nama}.{ext}` |

---

## 4. Admin Create Views — Input Foto Profil

**File (4 file):**
- `resources/views/admin/mtsputras/create.blade.php`
- `resources/views/admin/mtsputris/create.blade.php`
- `resources/views/admin/maputras/create.blade.php`
- `resources/views/admin/maputris/create.blade.php`

**Perubahan:**
- Grid dokumen: `md:grid-cols-3` → `md:grid-cols-4`
- Menambahkan input "Foto Profil" di awal section Dokumen:
  ```blade
  <div>
      <label class="block text-sm font-medium text-gray-700">Foto Profil</label>
      <input type="file" name="foto" accept="image/*" class="...">
      @error('foto')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
  </div>
  ```

---

## 5. Admin Edit Views — Input Foto Profil + Info File Existing

**File (4 file):**
- `resources/views/admin/mtsputras/edit.blade.php`
- `resources/views/admin/mtsputris/edit.blade.php`
- `resources/views/admin/maputras/edit.blade.php`
- `resources/views/admin/maputris/edit.blade.php`

**Perubahan:**
- Grid dokumen: `md:grid-cols-3` → `md:grid-cols-4`
- Input "Foto Profil" dengan info file existing:
  ```blade
  @if($model->foto)<p class="text-xs text-gray-500 mt-1">File saat ini: {{ $model->foto }}</p>@endif
  ```

---

## 6. Admin Show Views — Tampilkan Foto Profil

**File (4 file):**
- `resources/views/admin/mtsputras/show.blade.php`
- `resources/views/admin/mtsputris/show.blade.php`
- `resources/views/admin/maputras/show.blade.php`
- `resources/views/admin/maputris/show.blade.php`

**Perubahan di header card:**
- Jika `$student->foto` ada → tampilkan gambar lingkaran:
  ```blade
  <div class="w-16 h-16 rounded-full overflow-hidden shrink-0 border-2 border-zinc-200 shadow-sm">
      <img src="{{ Storage::url($student->foto) }}" class="w-full h-full object-cover" alt="Foto Profil">
  </div>
  ```
- Jika tidak ada → fallback ke inisial nama (seperti sebelumnya)

---

## 7. DaftarUlangForm — Tambah Upload Pas Photo

**File:** `app/Livewire/DaftarUlangForm.php`

**Perubahan:**
- Tambah property: `public $foto;`
- Tambah validasi di `rulesStep2()`: `'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048'`
- Tambah custom messages:
  ```php
  'foto.required' => 'Pas photo anak wajib diunggah.',
  'foto.image' => 'Pas photo harus berupa gambar.',
  'foto.mimes' => 'Pas photo harus berformat JPG atau PNG.',
  'foto.max' => 'Ukuran pas photo tidak boleh lebih dari 2 MB.',
  ```
- Method `submit()`: simpan foto ke `storage/app/public/foto/FOTO_{NISN}_{Nama}_{Timestamp}.{ext}`
- Validasi menggunakan custom messages: `$this->validate($this->rulesStep2(), [], $this->messages())`

---

## 8. DaftarUlangForm Blade — UI Upload Pas Photo

**File:** `resources/views/livewire/daftar-ulang-form.blade.php`

**Perubahan:**
- Tambah input file "Pas Photo" di section upload dokumen (KK & Akta)
- Progress bar real-time dengan Alpine.js (`x-on:livewire-upload-*`)
- Preview gambar setelah upload (`$foto->temporaryUrl()`)
- Validasi format: JPG/PNG, max 2MB

---

## 9. Welcome Page — Ganti ke Pencarian Data Siswa

**File:** `resources/views/welcome.blade.php`

**Perubahan:**
- Hapus Livewire component `registration-buttons`
- Tambah section "Cari Data TA 2026/2027" dengan Livewire component `cari-siswa-table`
- Section Hero, Data Siswa, dan Features di-comment (disable)
- Hanya menyisakan Search section dan About section

---

## 10. Komponen Baru: CariSiswaTable

**File:** `app/Livewire/CariSiswaTable.php` (NEW)

**Deskripsi:** Livewire component dengan search real-time yang mencari data siswa dari 4 tabel:
- `Mtsputra`, `Mtsputri`, `Maputra`, `Maputri` — filter by `tahun_ajaran` + search by `nama`, `nisn`, `nik`
- `Pendaftaran` — status `pending`, filter by `tahun_ajaran` + search by `nama`, `nisn`, `nik`

**View:** `resources/views/livewire/cari-siswa-table.blade.php` (NEW)

**Fitur UI:**
- Search bar dengan icon search + `wire:model.live.debounce.300ms`
- **Desktop:** Tabel dengan kolom: Nama (dengan foto/avatar), NISN, Jenjang, TTL, Status Foto, Aksi
- **Mobile:** Card view responsif dengan informasi lengkap
- Status foto: "✓ Ada" (hijau), "⏳ Pending" (kuning), atau "-" (abu-abu)
- Tombol aksi:
  - Data pendaftaran pending → "Daftar Ulang" (amber, link ke `daftar-ulang.form`)
  - Data siswa existing → "Update Foto" (green, link ke `update-foto.form`)
- Empty state dengan icon saat belum mencari atau tidak ditemukan
- Hitung jumlah data ditemukan
- Dark mode support penuh

---

## 11. Komponen Baru: UpdateFotoForm

**File:** `app/Livewire/UpdateFotoForm.php` (NEW)

**Deskripsi:** Livewire component untuk update foto profil siswa secara mandiri dari halaman publik.

**Alur:**
1. **Input type + student ID** via route `{type}/{id}`
2. Cari model class via `match($this->type)`
3. Tampilkan current foto (jika ada) atau placeholder avatar
4. Upload foto baru via `wire:model="foto"` dengan validasi: `image|mimes:jpg,jpeg,png|max:2048`
5. Progress bar real-time dengan Alpine.js
6. Preview foto baru dengan `temporaryUrl()`
7. Simpan: hapus foto lama → upload ke `storage/app/public/foto/FOTO_{NISN}_{Nama}_{Timestamp}.{ext}` → update `foto` column
8. **Success page:** card hijau dengan icon checkmark, preview foto final, nama & NISN, tombol "Kembali ke Beranda"

**Layout:** Menggunakan `layouts.standalone` (full-page tanpa sidebar)

**View:** `resources/views/livewire/update-foto-form.blade.php` (NEW)

**Fitur UI:**
- Gradient header hijau dengan nama siswa dalam card putih
- Tampilkan current foto (lingkaran, border gray) atau placeholder icon user
- Form upload dengan input file, progress bar, dan preview
- Action buttons: "Kembali ke Beranda" + "Simpan Foto" (dengan loading state)
- Success page dengan foto final (lingkaran, border green) + confetti-like icon
- Tombol kembali ke beranda di success page
- Dark mode support penuh

---

## 12. Routes — Tambah Route Update Foto

**File:** `routes/web.php`

**Perubahan:**
- Tambah route ke UpdateFotoForm:
  ```php
  Route::get('/update-foto/{type}/{id}', \App\Livewire\UpdateFotoForm::class)
      ->name('update-foto.form');
  ```
- Route ini public (tanpa middleware auth)

---

## Ringkasan File yang Dimodifikasi (Sesi Ini)

| File | Status | Perubahan |
|------|--------|-----------|
| `database/migrations/2026_06_23_000001_add_foto_to_student_tables.php` | **NEW** | Migration tambah kolom foto |
| `app/Livewire/CariSiswaTable.php` | **NEW** | Livewire component pencarian siswa |
| `resources/views/livewire/cari-siswa-table.blade.php` | **NEW** | View tabel pencarian + mobile card |
| `app/Livewire/UpdateFotoForm.php` | **NEW** | Livewire component update foto |
| `resources/views/livewire/update-foto-form.blade.php` | **NEW** | View form update foto + success page |
| `app/Models/Maputra.php` | Modified | Tambah `foto` ke $fillable |
| `app/Models/Maputri.php` | Modified | Tambah `foto` ke $fillable |
| `app/Models/Mtsputra.php` | Modified | Tambah `foto` ke $fillable |
| `app/Models/Mtsputri.php` | Modified | Tambah `foto` ke $fillable |
| `app/Http/Controllers/Admin/MaputraController.php` | Modified | Upload/update/delete foto di store, update, destroy |
| `app/Http/Controllers/Admin/MaputriController.php` | Modified | Upload/update/delete foto di store, update, destroy |
| `app/Http/Controllers/Admin/MtsputraController.php` | Modified | Upload/update/delete foto di store, update, destroy |
| `app/Http/Controllers/Admin/MtsputriController.php` | Modified | Upload/update/delete foto di store, update, destroy |
| `resources/views/admin/mtsputras/create.blade.php` | Modified | Tambah input Foto Profil |
| `resources/views/admin/mtsputris/create.blade.php` | Modified | Tambah input Foto Profil |
| `resources/views/admin/maputras/create.blade.php` | Modified | Tambah input Foto Profil |
| `resources/views/admin/maputris/create.blade.php` | Modified | Tambah input Foto Profil |
| `resources/views/admin/mtsputras/edit.blade.php` | Modified | Tambah input Foto Profil + info file |
| `resources/views/admin/mtsputris/edit.blade.php` | Modified | Tambah input Foto Profil + info file |
| `resources/views/admin/maputras/edit.blade.php` | Modified | Tambah input Foto Profil + info file |
| `resources/views/admin/maputris/edit.blade.php` | Modified | Tambah input Foto Profil + info file |
| `resources/views/admin/mtsputras/show.blade.php` | Modified | Tampilkan foto profil di header |
| `resources/views/admin/mtsputris/show.blade.php` | Modified | Tampilkan foto profil di header |
| `resources/views/admin/maputras/show.blade.php` | Modified | Tampilkan foto profil di header |
| `resources/views/admin/maputris/show.blade.php` | Modified | Tampilkan foto profil di header |
| `app/Livewire/DaftarUlangForm.php` | Modified | Tambah $foto, validasi, upload pas photo |
| `resources/views/livewire/daftar-ulang-form.blade.php` | Modified | Tambah input pas photo + progress bar |
| `resources/views/welcome.blade.php` | Modified | Ganti ke CariSiswaTable component |
| `routes/web.php` | Modified | Tambah route update-foto.form |

---

## Struktur File Foto di Storage

```
storage/app/public/
├── foto/
│   └── FOTO_{NISN}_{Nama}_{Timestamp}.{ext}    (via DaftarUlangForm & UpdateFotoForm)
└── documents/
    ├── mtsputra/
    │   └── foto_{Nama}.{ext}                    (via Admin Controller)
    ├── mtsputri/
    │   └── foto_{Nama}.{ext}
    ├── maputra/
    │   └── foto_{Nama}.{ext}
    └── maputri/
        └── foto_{Nama}.{ext}
```

---

## Alur Update Foto Publik

```
[Home] → Cari Siswa (nama/NISN/NIK)
    ↓
Klik "Update Foto" (jika data sudah terdaftar di tabel siswa)
    ↓
Halaman UpdateFotoForm
    ├── Lihat foto saat ini (atau placeholder)
    ├── Pilih file gambar (JPG/PNG, max 2MB)
    ├── Progress bar real-time
    ├── Preview foto baru
    └── Klik "Simpan Foto"
    ↓
Halaman Sukses
    ├── Foto baru ditampilkan
    ├── Nama & NISN
    └── Tombol "Kembali ke Beranda"
```

---

## Catatan

- `CariSiswaTable` menggunakan `debounce.300ms` untuk menghindari terlalu banyak request saat mengetik
- Pencarian dilakukan di 5 tabel sekaligus (4 tabel siswa + 1 tabel pendaftaran)
- Data diurutkan berdasarkan nama secara ascending
- Tahun ajaran hardcoded `2026/2027` (✅ SUDAH FIX — sekarang pakai sistem settings)
- Format foto: lingkaran (rounded-full) dengan border tipis
- Fallback: inisial nama dalam lingkaran abu-abu jika tidak ada foto

---

# Changelog — Sesi 30 Juni 2026 — Foto Profil di Tabel Admin & Filter Per Halaman

> **Tanggal:** 30 Juni 2026
> **Fokus:** Menampilkan foto profil siswa di tabel admin (avatar lingkaran + nomor urut), filter jumlah data per halaman (15/25/50/100)

---

## 1. Foto Profil & Nomor Urut di Tabel Admin Siswa

**File (4 file view Livewire):**
- `resources/views/livewire/admin/mtsputras-table.blade.php`
- `resources/views/livewire/admin/mtsputris-table.blade.php`
- `resources/views/livewire/admin/maputras-table.blade.php`
- `resources/views/livewire/admin/maputris-table.blade.php`

**Perubahan:** Avatar nomor urut (angka `1, 2, 3...`) diganti dengan:
- **Nomor urut** (teks abu kecil di kiri)
- **Foto siswa** (thumbnail lingkaran 36×36px, `rounded-full object-cover`) jika `$siswa->foto` terisi
- **Inisial huruf pertama nama** (lingkaran warna) sebagai fallback jika tidak ada foto

| Jenjang | Warna Fallback Inisial |
|---------|----------------------|
| MTs Putra | 🟢 **Emerald** (`bg-emerald-100 text-emerald-600`) |
| MTs Putri | 🩷 **Pink** (`bg-pink-100 text-pink-600`) |
| MA Putra | 🔵 **Blue** (`bg-blue-100 text-blue-600`) |
| MA Putri | 🟣 **Purple** (`bg-purple-100 text-purple-600`) |

**Layout per baris:**
```
[ 1 ] [Foto/Inisial]  Nama Siswa
                       NIK
```

---

## 2. Filter Jumlah Data Per Halaman (perPage)

**File Backend (4 file):**
- `app/Livewire/Admin/MtsputrasTable.php`
- `app/Livewire/Admin/MtsputrisTable.php`
- `app/Livewire/Admin/MaputrasTable.php`
- `app/Livewire/Admin/MaputrisTable.php`

**File Frontend (4 file):**
- `resources/views/livewire/admin/mtsputras-table.blade.php`
- `resources/views/livewire/admin/mtsputris-table.blade.php`
- `resources/views/livewire/admin/maputras-table.blade.php`
- `resources/views/livewire/admin/maputris-table.blade.php`

**Perubahan Backend per komponen:**
1. Tambah property: `public int $perPage = 15;`
2. Tambah ke `$queryString`: `'perPage' => ['except' => 15]`
3. Tambah method:
   ```php
   public function updatingPerPage(): void
   {
       $this->resetPage();
   }
   ```
4. Validasi di `render()`:
   ```php
   $perPage = in_array($this->perPage, [15, 25, 50, 100]) ? $this->perPage : 15;
   $query->paginate($perPage);
   ```

**Perubahan Frontend:**
- Dropdown `<select wire:model.live="perPage">` setelah filter Tahun Ajaran
- Opsi: **15**, **25**, **50**, **100** per halaman
- Sama seperti yang sudah ada di `PendaftaransTable`

---

## Ringkasan File yang Dimodifikasi (Sesi Ini)

| File | Perubahan |
|------|-----------|
| `app/Livewire/Admin/MtsputrasTable.php` | Tambah $perPage, queryString, updatingPerPage, validasi render |
| `app/Livewire/Admin/MtsputrisTable.php` | Tambah $perPage, queryString, updatingPerPage, validasi render |
| `app/Livewire/Admin/MaputrasTable.php` | Tambah $perPage, queryString, updatingPerPage, validasi render |
| `app/Livewire/Admin/MaputrisTable.php` | Tambah $perPage, queryString, updatingPerPage, validasi render |
| `resources/views/livewire/admin/mtsputras-table.blade.php` | Avatar nomor urut → foto + inisial; dropdown perPage |
| `resources/views/livewire/admin/mtsputris-table.blade.php` | Avatar nomor urut → foto + inisial; dropdown perPage |
| `resources/views/livewire/admin/maputras-table.blade.php` | Avatar nomor urut → foto + inisial; dropdown perPage |
| `resources/views/livewire/admin/maputris-table.blade.php` | Avatar nomor urut → foto + inisial; dropdown perPage |

---

# Changelog — Sesi 1 Juli 2026 — Review Project & Error Summary Box Daftar Ulang

> **Tanggal:** 1 Juli 2026
> **Fokus:** Review menyeluruh project, menambahkan Error Summary Box di form daftar ulang Step 2, update MEMORY.md

---

## 1. Review Menyeluruh Project

**File:** Seluruh codebase + `MEMORY.md`

**Review mencakup:**
- **Arsitektur & Teknologi Stack:** Laravel 12, Livewire 3, Alpine.js, Tailwind CSS 4, Fortify, Sanctum
- **Role-Based Access Control (RBAC):** Middleware CheckRole + LoginResponse dengan 5 role
- **Alur Pendaftaran 2 Step:** Upload bukti transfer → form lengkap + dokumen
- **Multi-Jenjang:** 4 tabel identik (mtsputras, mtsputris, maputras, maputris)
- **Fitur:** Cari Siswa, Update Foto Mandiri, WhatsApp Integration, Export Excel, Uang Masuk, dll.

**Skor Review: 7/10**

### 🔴 Rekomendasi Prioritas Tinggi
1. API routes tidak memiliki proteksi auth — siapa saja bisa CRUD data
2. Duplikasi code massif 4 jenjang → sarankan polymorphic
3. Tahun ajaran masih hardcoded (`'2026/2027'`)
4. XSS protection hanya di model Mtsputri, tidak di model lain

### 🟡 Rekomendasi Menengah
5. File storage path tidak konsisten (`documents/` vs `dokumen-siswa/` vs `foto/`)
6. Validasi panjang di controller bisa dipindah ke Form Request
7. Potensi N+1 query di CariSiswaTable (query 5 tabel terpisah)

### 🟢 Catatan Ringan
8. Footer masih "PPSR 2025" padahal project 2026
9. Nama migration file tidak遵循 Laravel convention
10. Tidak ada unit test untuk fitur-fitur penting

---

## 2. Error Summary Box di Tombol Simpan Data (Step 2 Daftar Ulang)

**File:** `resources/views/livewire/daftar-ulang-form.blade.php`

**Masalah:** Saat user mengklik "Simpan Data" di Step 2 form daftar ulang, error validasi hanya muncul **inline** di bawah masing-masing field. User harus scroll ke atas untuk melihat semua error.

**Solusi:** Menambahkan **Error Summary Box** berwarna merah dengan gradient `from-red-500 to-rose-600` yang muncul di atas tombol "Simpan Data" jika ada validation errors:

- Header: "Mohon perbaiki error berikut sebelum menyimpan:"
- List semua error dengan icon X merah di setiap item
- Hanya muncul jika `@if ($errors->any())`
- Dark mode support penuh
- Tidak mengubah satu baris pun dari kode yang sudah ada (insert di antara section Upload Dokumen dan SUBMIT)

**Hasil pengecekan:**
- ✅ Semua pesan error di method `messages()` di `app/Livewire/DaftarUlangForm.php` sudah dalam **Bahasa Indonesia**
- ✅ Tidak ada perubahan pada alur/logic yang sudah ada
- ✅ Syntax Blade/Livewire 3 benar dan sudah di-review

---

## Ringkasan File yang Dimodifikasi (Sesi Ini)

| File | Perubahan |
|------|-----------|
| `resources/views/livewire/daftar-ulang-form.blade.php` | Tambah Error Summary Box di atas tombol Simpan Data (Step 2) — card merah dengan daftar semua validation error |
| `MEMORY.md` | Ditambahkan changelog sesi ini |

---

# Changelog — Sesi 1 Juli 2026 — Halaman Galeri Foto Santri (/foto)

> **Tanggal:** 1 Juli 2026 (lanjutan)
> **Fokus:** Membuat halaman galeri foto santri publik dengan data dari 4 jenjang, menampilkan foto, nama, NISN, TTL, alamat, jenjang untuk TA 2026/2027

---

## 1. Livewire Component Baru: FotoTable

**File:** `app/Livewire/FotoTable.php` (NEW)

**Deskripsi:** Livewire component untuk menampilkan galeri foto seluruh santri dari 4 jenjang (public, tanpa auth).

**Query logic:**
- Mengumpulkan data dari 4 model: `Mtsputra`, `Mtsputri`, `Maputra`, `Maputri` — semuanya filter `tahun_ajaran = '2026/2027'`
- Filter jenjang: skip model jika `$this->jenjang` diisi dan tidak sesuai
- Search: filter by `nama` atau `nisn` (LIKE)
- Dynamic attribute: `jenjang_label` (MTs Putra/MTs Putri/MA Putra/MA Putri) dan `alamat_lengkap` (prioritas `alamat_rumah_tinggal`, fallback gabungan desa/kec/kab/prov)
- Sort by `nama` ascending
- **Manual pagination** via `LengthAwarePaginator`

**Properties:**
- `$search` — search string (queryString, debounce 300ms)
- `$jenjang` — filter jenjang (queryString)
- `$tahunAjaran` — hardcoded '2026/2027'

---

## 2. View Baru: Galeri Foto Card Grid

**File:** `resources/views/livewire/foto-table.blade.php` (NEW)

**Layout & UI:**
- Background gradient `from-sky-50 to-blue-50` / dark mode `from-gray-900 to-gray-800`
- **Header** dengan gradient `from-sky-600 to-blue-600`: icon gallery, judul "Galeri Foto Santri", subtitle TA
- **Filter bar**:
  - Search input dengan icon + wire:model.live.debounce.300ms
  - Dropdown filter jenjang (Semua/MTs Putra/MTs Putri/MA Putra/MA Putri)
  - Tombol "Reset Filter" (muncul jika ada filter aktif)
- **Stats bar**: jumlah santri ditemukan + legend "Ada Foto" (hijau) / "Belum Ada Foto" (abu-abu)
- **Card Grid**: `grid-cols-1 sm:2 lg:3 xl:4` — gap 5

**Per Card:**
- **Photo Section** (h-56, gradient sky/blue):
  - Jika `$student->foto` ada → gambar (object-contain) + border shadow + badge "Ada Foto" di kiri bawah + **tombol download** di kanan atas (opacity 0 → 1 on hover)
  - Jika tidak ada → placeholder inisial nama (lingkaran putih besar) + badge "Belum Ada Foto"
- **Info Section**:
  - Nama (truncate) + badge jenjang (warna per jenjang: MTs Putra=emerald, MTs Putri=pink, MA Putra=blue, MA Putri=purple)
  - NISN dengan icon kartu
  - TTL (Tempat, Tanggal Lahir) dengan icon calendar
  - Alamat (line-clamp-2) dengan icon location
- **Hover**: shadow-lg → shadow-xl, opacity download button
- **Dark mode** support penuh

**Pagination:**
- Links dari LengthAwarePaginator (default Laravel/Bootstrap) dibungkus card putih
- Tidak ada dropdown perPage — hardcoded 15 data per halaman

**Empty State:**
- Icon gallery besar dalam lingkaran abu
- Pesan berbeda: jika search → "Tidak ditemukan santri...", jika tidak → "Belum ada data santri untuk TA..."

**Footer:**
- Info tooltip tentang tombol download
- Tombol "Kembali ke Beranda" (gray, shadow)

---

## 3. Route Baru: /foto

**File:** `routes/web.php`

**Perubahan:**
- Tambah route:
  ```php
  Route::get('/foto', \App\Livewire\FotoTable::class)->name('foto.index');
  ```
- Route public (tanpa middleware auth)
- Ditempatkan setelah route admin group, sebelum `/uangmasuk`

---

## 4. Fix Pagination — Hapus Dropdown Per Halaman

**Perubahan dari hasil review user:**

| File | Perubahan |
|------|-----------|
| `app/Livewire/FotoTable.php` | Hapus property `$perPage`, hapus dari `$queryString`, hapus `updatingPerPage()`, hardcode `$perPage = 15` di render |
| `resources/views/livewire/foto-table.blade.php` | Hapus dropdown selector "per halaman" (tidak ada di versi awal) |

---

## Ringkasan File (Sesi Ini)

| File | Status | Perubahan |
|------|--------|-----------|
| `app/Livewire/FotoTable.php` | **NEW** | Livewire component galeri foto — query 4 tabel, filter, search, manual pagination 15 |
| `resources/views/livewire/foto-table.blade.php` | **NEW** | View card gallery grid — foto, download, info, badges, dark mode |
| `routes/web.php` | Modified | Tambah route `GET /foto` → `FotoTable` (public) |

---

## Alur Halaman /foto

```
[/foto]
    ├── Header gradient (judul + TA)
    ├── Filter: Search (nama/NISN) + Jenjang dropdown
    ├── Stats: Total santri + legend foto
    ├── Card Grid (1-4 kolom responsif)
    │   ├── Foto (thumbnail) + tombol download hover
    │   ├── Badge Ada Foto / Belum Ada Foto
    │   ├── Nama + Badge Jenjang (warna per jenjang)
    │   ├── NISN, TTL, Alamat
    │   └── Hover: shadow naik + download muncul
    ├── Pagination (15/halaman, tanpa opsi ganti)
    └── Tombol "Kembali ke Beranda"
```

---

## Teknologi yang Digunakan

- **Livewire 3** — `WithPagination`, `wire:model.live.debounce`, `$queryString`
- **Tailwind CSS 4** — grid, gradient, dark mode, ring, shadow, animation, line-clamp
- **Laravel** — `LengthAwarePaginator` manual, `Storage::url()`, `Carbon::parse()`

---

## Catatan

- Tahun ajaran masih hardcoded `'2026/2027'` — perlu diupdate jika TA berganti
- Manual pagination (`collect all → slice`) mungkin kurang optimal untuk data sangat besar (1000+), tapi untuk 1 TA masih sangat amatir
- Warna badge jenjang konsisten dengan tabel admin: MTs Putra=emerald, MTs Putri=pink, MA Putra=blue, MA Putri=purple
- File yang di-download via tombol download mengikuti ekstensi asli file (via Storage::url)

---

# Changelog — Sesi 2 Juli 2026 — Hilangkan Status "Pending" di Halaman /uangmasuk

> **Tanggal:** 2 Juli 2026
> **Fokus:** Menyembunyikan badge status "Pending" di tabel uang masuk, hanya menampilkan status lunas atau lainnya (rejected/uploaded/verified)

---

## Perubahan

**File:** `resources/views/livewire/uang-masuk-table.blade.php`

**Perubahan (1 baris kondisi):**
- **Sebelum:** `@if($pendaftaran->status_bayar_uang_masuk)` — badge status tampil untuk semua status (pending, lunas, rejected, dll)
- **Sesudah:** `@if($pendaftaran->status_bayar_uang_masuk && $pendaftaran->status_bayar_uang_masuk !== 'pending')` — badge status hanya tampil jika bukan 'pending'
- Cabang `@elseif` untuk warna oranye (pending) juga dihapus karena tidak lagi diperlukan

**Tidak ada file lain yang diubah.**

---

## Status Badge yang Tampil

| Status | Tampil | Warna |
|--------|--------|-------|
| `pending` | ❌ **Disembunyikan** | — |
| `lunas` | ✅ | 🟢 Hijau |
| `rejected` / `uploaded` / `verified` | ✅ | 🔴 Merah |
---

# Changelog — Sesi 29 Juli 2026 — Sistem Pengaturan Tahun Ajaran Aktif

> **Tanggal:** 29 Juli 2026
> **Fokus:** Membuat sistem settings tahun ajaran aktif yang bisa diubah dari admin panel. Semua halaman (pendaftaran, daftar ulang, pencarian siswa, galeri foto, dashboard) otomatis menggunakan tahun ajaran dari settings.

---

## Ringkasan Perubahan

### 🆕 File Baru (5 files)

| File | Deskripsi |
|------|-----------|
| `database/migrations/2026_07_29_154048_create_settings_table.php` | Migration table `settings` (key-value: key unique, text value) |
| `app/Models/Setting.php` | Model Setting dengan `value()`, `set()`, `activeTahunAjaran()` + in-memory cache |
| `app/helpers.php` | Global helper function `activeTahunAjaran()` |
| `app/Livewire/Admin/Settings.php` | Livewire component halaman pengaturan admin |
| `resources/views/livewire/admin/settings.blade.php` | View halaman pengaturan dengan dropdown tahun ajaran |

### ✏️ File Dimodifikasi (14 files)

| File | Perubahan |
|------|-----------|
| `composer.json` | Tambah `autoload.files` untuk `app/helpers.php` |
| `routes/web.php` | Tambah route `GET /admin/settings` → `admin.settings.index` (middleware admin) |
| `resources/views/admin/layout.blade.php` | Tambah menu "Pengaturan" di sidebar desktop & mobile |
| `app/Livewire/CariSiswaTable.php` | Ganti hardcoded `'2026/2027'` → `activeTahunAjaran()` via `boot()` |
| `app/Livewire/DaftarUlangTable.php` | Ganti hardcoded `'2026/2027'` → `activeTahunAjaran()` |
| `app/Livewire/FotoTable.php` | Ganti hardcoded `'2026/2027'` → `activeTahunAjaran()` via `boot()` |
| `app/Livewire/PendaftaranForm.php` | Ganti hardcoded `'2026/2027'` → `activeTahunAjaran()` via `boot()` |
| `app/Livewire/Admin/Dashboard.php` | Tambah `Setting::activeTahunAjaran()` → view |
| `resources/views/welcome.blade.php` | Teks "TA 2026/2027" → dinamis `{{ activeTahunAjaran() }}` |
| `resources/views/livewire/cari-siswa-table.blade.php` | 2 teks hardcoded → dinamis |
| `resources/views/livewire/daftar-ulang-table.blade.php` | Teks header → dinamis |
| `resources/views/livewire/pendaftaran-form.blade.php` | Hidden input value & teks → dinamis |
| `resources/views/livewire/admin/dashboard.blade.php` | Tambah badge "TA {tahun aktif}" di banner |
| `database/seeders/DatabaseSeeder.php` | Tambah default setting `tahun_ajaran_aktif = 2026/2027` |

### 🐛 Bug Fix

| Masalah | Solusi |
|---------|--------|
| `Access to undeclared static property Setting::$cache` | Local static variable `$cache` di method `value()` diubah ke class-level `protected static array $cache`. Method `set()` pakai `unset(static::$cache[$key])` untuk clear cache |

### 🎯 Halaman yang Terdampak

- ✅ **Pendaftaran (Public)** — hidden `tahun_ajaran` otomatis dari settings
- ✅ **Daftar Ulang (Table)** — filter tahun ajaran dari settings
- ✅ **Cari Siswa (Welcome)** — filter & teks dari settings
- ✅ **Galeri Foto (Public)** — filter tahun ajaran dari settings
- ✅ **Dashboard Admin** — badge TA {aktif} di banner

### 🛠️ Cara Pakai

```
[Admin Login] → Sidebar "Pengaturan" → Pilih Tahun Ajaran → Simpan
    ↓
Semua halaman otomatis update
```

---

---

# Changelog — Sesi 29 Juli 2026 — Pengaturan Header Image

> **Tanggal:** 29 Juli 2026
> **Fokus:** Menambahkan fitur upload/ubah header image di halaman pendaftaran melalui halaman Pengaturan admin. Ukuran header image sesuai yang sudah ada (tidak diubah).

---

## Ringkasan Perubahan

### File Dimodifikasi (3 file)

| File | Perubahan |
|------|-----------|
| `app/Livewire/Admin/Settings.php` | Tambah `WithFileUploads` trait, property `$headerImage`, `$headerImagePreview`, methods `updatedHeaderImage()`, `saveHeader()`, `removeHeader()` |
| `resources/views/livewire/admin/settings.blade.php` | Tambah card "Header Image Pendaftaran" dengan preview gambar, tombol upload, tombol reset ke default + info rekomendasi ukuran 1600×400 px |
| `resources/views/livewire/pendaftaran-form.blade.php` | Ganti `asset('images/psb.webp')` jadi dinamis: `Setting::value('header_image', 'images/psb.webp')` + logic fallback asset/storage |

### 🖼️ Detail Header Image

**Lokasi penyimpanan:** `storage/app/public/settings/{file}`

**Validasi:**
- Format: JPG, JPEG, PNG, WebP
- Ukuran max: 2MB

**Rekomendasi ukuran:** 1600 × 400 px (sesuai ukuran asli `public/images/psb.webp`)

**Alur:**
```
[Admin Login] → Sidebar "Pengaturan" → Scroll ke "Header Image Pendaftaran"
    │
    ├── Preview header image saat ini
    ├── Pilih file gambar baru → preview otomatis muncul
    ├── Klik "Simpan Header" → file tersimpan, tampil di preview
    └── Klik "Reset ke Default" → kembali ke gambar default psb.webp
    ↓
Halaman Pendaftaran otomatis pakai header image terbaru
```

### 🔧 Detail Teknis

**Settings.php:**
- `mount()` — set `$headerImagePreview` dari `Setting::value('header_image', 'images/psb.webp')`
- `updatedHeaderImage()` — validasi (image, max:2048, mimes:jpg,jpeg,png,webp), set `$headerImagePreview = $this->headerImage->temporaryUrl()`
- `saveHeader()` — hapus file lama (jika bukan default), simpan file baru ke `settings/`, update Setting, refresh preview via `Storage::url()`
- `removeHeader()` — hapus file dari storage (jika bukan default), set ke `'images/psb.webp'`

**pendaftaran-form.blade.php:**
```blade
@php
    $headerImg = \App\Models\Setting::value('header_image', 'images/psb.webp');
@endphp
<img src="{{ str_starts_with($headerImg, 'images/') ? asset($headerImg) : Storage::url($headerImg) }}"
     alt="Header Pondok Pesantren Syafa'aturrasul"
     class="w-full h-auto object-cover max-h-64 rounded-xl">
```

### 📐 Rekomendasi Ukuran

Info ukuran ditampilkan di halaman settings:
```
📐 Rekomendasi ukuran: 1600 × 400 px (lebar 1600, tinggi 400)
```

---

# Changelog — Sesi 17 Oktober 2026 — Pemahaman Project & Penyusunan Alur Kerja

> **Tanggal:** 17 Oktober 2026
> **Fokus:** Membaca & memahami seluruh alur project, membaca `MEMORY.md`, review menyeluruh, lalu menyusun `MEMORY.md` menjadi dokumen **Alur Kerja (SOP) + kondisi project + backlog**.
> **Status kode aplikasi:** ⚠️ **TIDAK ADA perubahan kode** — hanya `MEMORY.md` yang diubah (dokumentasi).

---

## 1. Pemetaan & Pemahaman Project (read-only)

Yang dipelajari: stack (Laravel 12.37 / PHP 8.4 / Livewire 3.7 / Volt / Tailwind 4 / Flux / Fortify / Sanctum / Pest), struktur `app/`, seluruh route (`web.php` + `api.php`), 4 tabel siswa + `pendaftarans`, RBAC (`CheckRole` + `LoginResponse` + `User::hasRole`), `Setting` + `activeTahunAjaran()`, alur pendaftaran → daftar ulang → tabel siswa, dan modul pendukung (uang masuk, galeri foto, cari siswa, update foto, cetak rapor, API).

Snapshot data terverifikasi (tinker read-only): `pendaftaran` 236 (23 pending) · `mtsputra` 195 · `mtsputri` 389 · `maputra` 6 · `maputri` 22 · `users` 16 · `settings.tahun_ajaran_aktif = 2026/2027`.

## 2. Hasil Review (ringkas)

Lihat **bagian 5** dokumen ini (Backlog & Temuan Review) untuk daftar lengkap + prioritas. Temuan paling mendesak:
1. Registrasi publik aktif dengan default role `admin`.
2. API `/api/*` tanpa auth.
3. Endpoint publik tanpa proteksi (`/update-foto/{type}/{id}`, `/daftar-ulang/{id}`, `/uangmasuk`).
4. Data loss di `DaftarUlangForm::submit()` (field tervalidasi tidak tersimpan).

## 3. File yang Dimodifikasi

| File | Perubahan |
|------|-----------|
| `MEMORY.md` | Restrukturisasi: menambahkan **Bagian 1–7 (Alur Kerja, SOP, Peta Project & Konvensi, Kondisi Saat Ini, Backlog & Temuan, Risiko, Format Changelog)** di bagian atas. Seluruh changelog historis (22 Apr 2026 – 29 Jul 2026) **tetap utuh** di bawah judul `# 📚 ARSIP CHANGELOG HISTORIS`. |

## 4. Hasil Validasi

- Tidak ada perubahan kode → tidak ada test yang perlu dijalankan.
- Verifikasi struktur dokumen: heading 1–7 urut, arsip historis utuh, tidak ada isi lama yang hilang.

## 5. Catatan / Risiko

- `MEMORY.md` & `memory.md` adalah file yang sama di macOS (case-insensitive).
- Belum ada commit untuk perubahan ini — menunggu perintah user.
- Backlog (K1–K5, M1–M9, R1–R6) masih ⬜ semua; belum ada yang dikerjakan.

---


# Changelog — Sesi 17 Oktober 2026 (sesi 2) — Minimal 3 Huruf di Pencarian Beranda

> **Tanggal:** 17 Oktober 2026
> **Fokus:** Membatasi pencarian di halaman utama (`/`) agar baru dijalankan setelah user mengetik **minimal 3 huruf**, untuk mengurangi beban server (query ke 4 tabel siswa + 1 tabel pendaftaran tidak lagi jalan setiap keystroke).

---

## 1. Ringkasan Perubahan

- Pencarian **tidak lagi** berjalan saat user baru mengetik 1–2 huruf.
- Ditambahkan konstanta `MIN_SEARCH_LENGTH = 3` di komponen agar ambang batas mudah diubah di satu tempat.
- Kata kunci di-`trim()` — spasi di awal/akhir tidak dihitung dan tidak ikut dikirim ke query.
- UI: ada petunjuk "Minimal 3 huruf untuk mulai mencari" + counter sisa huruf, dan **state khusus** saat baru 1–2 huruf (tidak lagi salah menampilkan "Data tidak ditemukan").

---

## 2. File yang Dimodifikasi

| File | Perubahan |
|------|-----------|
| `app/Livewire/CariSiswaTable.php` | Tambah `public const MIN_SEARCH_LENGTH = 3`; method baru `hasValidSearchTerm()` & `searchKeyword()`; guard `if (strlen($this->search) > 0)` → `if ($this->hasValidSearchTerm())`; query memakai `$keyword` hasil trim; kirim `minSearchLength` ke view |
| `resources/views/livewire/cari-siswa-table.blade.php` | `@php $keyword/$keywordLength`; placeholder baru; baris petunjuk minimal huruf + counter; state `$keywordLength === 0` (empty) / `$keywordLength < 3` (amber "Ketik minimal 3 huruf") / `$students->count() === 0` (tidak ditemukan) / tabel hasil |
| `tests/Feature/CariSiswaTableTest.php` | **NEW** — 7 test Pest |

---

## 3. Alur Logika Baru

```
user mengetik
   │
   ├─ 0 huruf          → state kosong ("Ketik nama siswa untuk mencari")
   ├─ 1–2 huruf        → TIDAK query, tampil kartu amber "Ketik minimal 3 huruf"
   │                     (+ hint "1 huruf lagi...")
   └─ ≥ 3 huruf        → query 4 tabel siswa + pendaftaran (pending)
                         ├─ ada hasil  → tabel desktop + card mobile + jumlah hasil
                         └─ kosong     → "Data tidak ditemukan"
```

---

## 4. Hasil Validasi

- `php artisan test tests/Feature/CariSiswaTableTest.php` → **7 passed (13 assertions)**
  - tidak search saat < 3 huruf (dan tidak muncul "Data tidak ditemukan")
  - search jalan saat ≥ 3 huruf
  - pesan "Data tidak ditemukan" untuk kata kunci valid tanpa hasil
  - spasi awal/akhir diabaikan
  - kata kunci hanya spasi tidak dianggap pencarian
  - pendaftar `pending` tetap ditemukan + tombol "Daftar Ulang"
  - halaman utama `GET /` sukses & memuat komponen pencarian
- `vendor/bin/pint --dirty` → **PASS** (2 files)
- `php -l app/Livewire/CariSiswaTable.php` → no syntax errors

---

## 5. Catatan / Risiko

- Ambang batas 3 huruf berlaku di **beranda** saja (`CariSiswaTable`). Komponen lain yang juga punya pencarian — `FotoTable` (`/foto`) dan `DaftarUlangTable` (`/daftar-ulang`) — **belum** dibatasi; bisa diterapkan pola yang sama bila diinginkan.
- Perilaku berubah: keyword 1–2 huruf yang sebelumnya menampilkan hasil (atau "tidak ditemukan") sekarang sengaja tidak menghasilkan query.
- Livewire tetap mengirim request setiap keystroke (debounce 300ms) selama 1–2 huruf; yang dihindari adalah **query database**-nya. Bila ingin request-nya juga nol, perlu pendekatan Alpine/`wire:model` non-live (belum dilakukan).
- `php artisan test` (seluruh suite) belum dijalankan; `tests/Feature/DashboardTest.php` memakai `route('dashboard')` yang **tidak ada** di `routes/web.php` → test itu kemungkinan gagal (temuan lama, belum diperbaiki).

---


# Changelog — Sesi 17 Oktober 2026 (sesi 3) — Pagination 10 Data per Halaman di Pencarian Beranda

> **Tanggal:** 17 Oktober 2026
> **Fokus:** Mengaktifkan pagination di tabel pencarian halaman utama (`/`) dengan **10 nama per halaman**.

---

## 1. Temuan Awal (penting)

`CariSiswaTable` **sudah** `use WithPagination`, tetapi pagination-nya **belum diterapkan** — `render()` mengumpulkan semua hasil lalu `$students` di-loop seluruhnya di view (`@forelse($students as $student)`), sehingga semua hasil ter-render sekaligus (berat kalau hasil banyak).

---

## 2. Ringkasan Perubahan

- Pagination manual memakai `LengthAwarePaginator` — **mengikuti pola yang sudah ada di `FotoTable`** (karena hasil digabung dari 4 tabel siswa + tabel pendaftaran, bukan satu query).
- **10 data per halaman** via konstanta `PER_PAGE = 10`.
- Ditambahkan link pagination + info rentang data ("menampilkan 1-10 dari 12").
- `resetPage()` sudah otomatis jalan saat kata kunci berubah (dari sesi 2).

---

## 3. File yang Dimodifikasi

| File | Perubahan |
|------|-----------|
| `app/Livewire/CariSiswaTable.php` | Tambah `use Illuminate\Pagination\LengthAwarePaginator`; konstanta `PER_PAGE = 10`; bungkus hasil pencarian ke `LengthAwarePaginator` (`$students->forPage($this->getPage(), self::PER_PAGE)`) dengan `path` + `query` dari request |
| `resources/views/livewire/cari-siswa-table.blade.php` | `$students->count()` → `$students->total()` (kondisi "tidak ditemukan" + hitungan hasil); tambah blok `@if($students->hasPages()) {{ $students->links() }}`; tambah info rentang `firstItem()`–`lastItem()` + `perPage()` |
| `tests/Feature/CariSiswaTableTest.php` | Tambah 5 test pagination + helper `buatSiswaUjiPagination()` |

---

## 4. Alur Logika (setelah sesi 2 + sesi 3)

```
user mengetik
   │
   ├─ 0 huruf      → state kosong (tidak query)
   ├─ 1–2 huruf    → kartu amber "Ketik minimal 3 huruf" (tidak query)
   └─ ≥ 3 huruf    → query 4 tabel siswa + pendaftaran (pending)
                     → sort by nama
                     → potong 10 data sesuai halaman aktif
                     ├─ ada hasil → tabel/card + link pagination + "Ditemukan N data (menampilkan x-y)"
                     └─ kosong    → "Data tidak ditemukan"
```

Catatan: pagination memakai view bawaan Livewire (`livewire::tailwind`) → tombolnya `wire:click="gotoPage(...)"`, jadi **berpindah halaman tanpa reload**.

---

## 5. Hasil Validasi

- `php artisan test tests/Feature/CariSiswaTableTest.php` → **12 passed (26 assertions)**, termasuk:
  - hanya 10 data per halaman (dibuat 12 data, halaman 1 = Siswa Uji 01–10)
  - halaman kedua menampilkan sisa data (Siswa Uji 11–12)
  - info rentang muncul hanya jika hasil > 10
  - link pagination memakai Livewire (`wire:click="gotoPage(2`) → tanpa reload
  - ganti kata kunci mereset ke halaman pertama
- `vendor/bin/pint --dirty` → **PASS** (2 files)
- `php -l app/Livewire/CariSiswaTable.php` → no syntax errors

---

## 6. Catatan / Risiko

- Pagination tetap **memuat semua hasil ke memory** dulu (collect → sort → `forPage`), jadi query tetap seberat sebelumnya; yang berkurang adalah jumlah elemen yang di-render + dikirim ke browser. Optimasi berikutnya (opsional): pindahkan sort & limit ke level database (mis. `union` query + `orderBy('nama')->paginate(10)`) — lihat backlog **M5**.
- Urutan data: `sortBy('nama')` (ascending, case-sensitive per perilaku `Collection`). Bila ingin urut mirip SQL (`ORDER BY nama`), perlu penyesuaian terpisah.
- Ambang minimal 3 huruf (sesi 2) tetap berlaku; pagination hanya aktif pada pencarian valid.
- Komponen lain belum disamakan: `DaftarUlangTable` sudah `->paginate(10)`, `FotoTable` 15/halaman, `UangMasukTable` 15/halaman.

---


# Changelog — Sesi 17 Oktober 2026 (sesi 4) — 4 Resource Admin Konten Website

> **Tanggal:** 17 Oktober 2026
> **Fokus:** Resource admin (backend) untuk **upload berita**, **profil guru**, **fasilitas**, dan **kontak** (kontak person + pengaturan kontak lembaga).
> **Ruang lingkup:** Admin/backend saja. Halaman publik untuk menampilkan konten ini **belum dibuat**.

---

## 1. Ringkasan

| Resource | Route | CRUD | Upload | Filter tabel |
|---|---|---|---|---|
| Berita | `/admin/beritas*` | lengkap | gambar | search, status (draft/terbit), kategori, perPage |
| Fasilitas | `/admin/fasilitas*` | lengkap | gambar | search, kategori, perPage |
| Profil Guru | `/admin/gurus*` | lengkap | foto | search (nama/NIP/jabatan), jenis kelamin, perPage |
| Kontak person | `/admin/kontaks*` | lengkap | — | search (nama/unit/jabatan/telepon/WA/email), perPage |
| Kontak lembaga | `/admin/kontak-lembaga` | form pengaturan (singleton) | — | — |

Semua route dilindungi middleware `CheckRole:admin` dan ditambahkan ke sidebar admin pada section baru **"Konten Website"** (desktop & mobile).

---

## 2. Database

**Migration baru (3 tabel):**
- `beritas` — judul, slug (unique), kategori, ringkasan, isi, gambar, penulis, status (draft/published), published_at, is_featured
- `fasilitas` — nama, kategori, deskripsi, gambar, urutan, is_active
- `kontaks` — unit, nama, jabatan, telepon, whatsapp, email, alamat, urutan, is_active

**Migration alter:** `add_profile_fields_to_gurus_table` — menambah kolom **nullable** ke tabel `gurus` yang sudah ada: `nip`, `jabatan`, `jenis_kelamin`, `pendidikan`, `email`, `deskripsi`, `foto`, `urutan`, `is_active`.
> Dipilih ALTER (bukan tabel baru) agar relasi existing `kelas.guru_id` & `pengajarans.guru_id` tidak terputus.

**Kontak lembaga** tidak memakai tabel baru — disimpan di tabel `settings` (key-value) dengan key `kontak_*`: `alamat`, `telepon`, `whatsapp`, `email`, `jam_layanan`, `maps_embed`, `facebook`, `instagram`, `youtube`.

---

## 3. Model

| File | Catatan |
|---|---|
| `app/Models/Berita.php` | slug otomatis unik dari judul (`generateUniqueSlug`), `published_at` otomatis diisi saat status `published`, scope `published()`, konstanta `STATUSES` |
| `app/Models/Fasilitas.php` | `protected $table = 'fasilitas'` (eksplisit, karena pluralizer Laravel tidak menangani kata Indonesia), scope `aktif()` |
| `app/Models/Kontak.php` | accessor `whatsapp_link` → `https://wa.me/62...` (nomor `08xx` otomatis dikonversi ke `628xx`), scope `aktif()` |
| `app/Models/Guru.php` | `$fillable` + `casts()` (`urutan` int, `is_active` bool) + scope `aktif()` ditambahkan |
| `app/Models/Concerns/SanitizesTextFields.php` | **TRAIT BARU** — strip HTML tags untuk field teks yang dideklarasikan per model via `protected array $sanitizedTextFields` (override `setAttribute`) |

**Factory baru:** `BeritaFactory` (+ state `published()`), `FasilitasFactory` (+ `nonaktif()`), `KontakFactory` (+ `nonaktif()`).

---

## 4. Validasi (Form Request) & Controller

**Form Request baru di `app/Http/Requests/`:** `BeritaRequest`, `FasilitasRequest`, `GuruRequest`, `KontakRequest`
- `authorize()` memeriksa `hasRole('admin')`
- pesan error lengkap dalam **Bahasa Indonesia**
- `BeritaRequest` memakai `Rule::unique('beritas','slug')->ignore($id)` agar slug boleh sama dengan dirinya sendiri saat update

**Controller baru di `app/Http/Controllers/Admin/`:** `BeritaController`, `FasilitasController`, `GuruController`, `KontakController`
- pola sama seperti controller jenjang: upload ke disk `public`, **hapus file lama** saat update, **cleanup file** saat destroy
- direktori upload: `konten/berita`, `konten/fasilitas`, `konten/guru`

---


## 5. Livewire (Tabel Admin)

**Komponen baru di `app/Livewire/Admin/`:** `BeritasTable`, `FasilitasTable`, `GurusTable`, `KontaksTable`, `KontakLembagaSettings`

Pola mengikuti tabel admin yang sudah ada: `#[Layout('admin.layout')]`, `WithPagination`, `queryString`, search `wire:model.live.debounce.300ms`, dropdown perPage (15/25/50/100), tombol reset filter, modal konfirmasi hapus `flux:modal name="delete-confirm"`, dan `@script` listener untuk `.delete-btn`.

**Perbedaan dari tabel sibling (perbaikan):** `confirmDelete(int $id)` **hanya menerima ID**; nama item di-lookup di dalam komponen — tidak lagi mengirim nama lewat `data-name` dari DOM (lebih aman terhadap tanda kutip pada judul/nama).

---

## 6. View

- `resources/views/livewire/admin/{beritas,fasilitas,gurus,kontaks}-table.blade.php` — 4 view tabel (gaya zinc/rounded-xl seperti tabel admin existing)
- `resources/views/livewire/admin/kontak-lembaga-settings.blade.php` — form pengaturan kontak lembaga
- `resources/views/admin/{beritas,fasilitas,gurus,kontaks}/{index,create,edit,show}.blade.php` — 16 view CRUD (`@extends('admin.layout')`)
- `resources/views/admin/layout.blade.php` — section sidebar **"Konten Website"** (Berita, Fasilitas, Profil Guru, Kontak) di nav desktop & mobile

---

## 7. Hasil Validasi

- `php artisan migrate` → 4 migration **DONE**
- `php artisan route:list --except-vendor` → 29 route baru terdaftar benar (termasuk `admin/kontak-lembaga`)
- `vendor/bin/pint` (25 file baru) → **FIXED 5 style issues**, sisanya bersih
- Test Pest baru:
  - `tests/Feature/BeritaAdminTest.php` → **11 passed**
  - `tests/Feature/FasilitasAdminTest.php` → **10 passed**
  - `tests/Feature/GuruAdminTest.php` → **10 passed**
  - `tests/Feature/KontakAdminTest.php` → **13 passed**
- Gabungan dengan test sesi 3: **56 passed (152 assertions)**

Cakupan test: tamu diarahkan ke login, non-admin **403**, admin lihat/tambah/update/hapus, validasi field wajib, upload + **hapus file lama saat update**, cleanup file saat destroy, sanitasi XSS (`strip_tags`), slug unik otomatis, `published_at` otomatis, konversi nomor WA `08xx` → `628xx`, search/filter tabel, dan hapus dari tabel Livewire.

---

## 8. Catatan / Risiko

- **Frontend publik belum dibuat.** Data berita/fasilitas/guru/kontak belum ditampilkan di halaman publik — langkah berikutnya.
- **Isi berita** ~~plain text~~ → **SUDAH DIPERBARUI di sesi 6**: isi berita memakai editor rich text (Quill) dan disanitasi dengan whitelist `App\Support\HtmlSanitizer` (bukan lagi `strip_tags`).
- Model `Pendaftaran` **belum** memakai sanitasi (masih temuan M3).
- Field `alamat` pada `gurus` tetap **NOT NULL** (kolom lama) sehingga dijadikan `required` pada `GuruRequest`.
- `KontakLembagaSettings` memakai tabel `settings` (key `kontak_*`); bila nanti butuh multi-bahasa/multi-cabang, sebaiknya pindah ke tabel sendiri.
- Modul ini **belum** punya export Excel (tidak diminta).
- `php artisan test` (seluruh suite) belum dijalankan; `tests/Feature/DashboardTest.php` masih memakai `route('dashboard')` yang tidak ada (temuan lama).

---


# Changelog — Sesi 17 Oktober 2026 (sesi 5) — Sidebar Admin Bisa Di-scroll

> **Tanggal:** 17 Oktober 2026
> **Fokus:** Memperbaiki UI navbar/sidebar admin yang **tidak bisa di-scroll** sehingga menu bagian bawah terpotong (semakin terasa setelah menu "Konten Website" ditambahkan di sesi 4).

---

## 1. Akar Masalah

- Wrapper `div.flex.h-screen.overflow-hidden` mengunci tinggi layar, sedangkan `<aside>` masih `md:block` (bukan flex) tanpa `overflow-y-auto` → isi menu yang melebihi tinggi layar **terpotong, tidak bisa digeser**.
- Blok info user + tombol logout memakai `absolute bottom-0 w-72` — diposisikan absolut terhadap viewport (bukan bagian dari alur sidebar), sehingga ikut menutupi/menabrak item menu terbawah.

## 2. Perubahan (`resources/views/admin/layout.blade.php`)

| Elemen | Sebelum | Sesudah |
|---|---|---|
| `<aside>` | `hidden md:block shadow-xl` | `hidden md:flex md:flex-col h-screen overflow-hidden shadow-xl` |
| Header logo | `p-6 border-b border-emerald-500` | + `shrink-0` (tidak ikut ter-scroll) |
| `<nav>` menu | `mt-4 px-3 space-y-1` | + `flex-1 overflow-y-auto sidebar-scroll pb-6` → **area yang di-scroll** |
| Footer user/logout | `absolute bottom-0 w-72 p-4 ...` | `w-full p-4 ... shrink-0` (item flex, tetap nempel bawah) |
| Menu mobile | `hidden md:hidden bg-emerald-700 text-white` | + `max-h-[70vh] overflow-y-auto sidebar-scroll` |

Ditambahkan CSS `scrollbar` tipis bertema emerald (`scrollbar-width: thin` + `::-webkit-scrollbar*`) di blok `<style>` layout.

**Hasil:** header (logo) tetap diam di atas, **daftar menu bisa digeser**, info user + tombol logout tetap terlihat di bawah.

## 3. File yang Dimodifikasi

| File | Perubahan |
|------|-----------|
| `resources/views/admin/layout.blade.php` | Struktur sidebar jadi flex-column + area menu scrollable + CSS scrollbar + footer tidak lagi absolute + menu mobile scrollable |
| `tests/Feature/AdminLayoutTest.php` | **NEW** — 5 test untuk mengunci perilaku ini |

## 4. Hasil Validasi

- `php artisan test tests/Feature/AdminLayoutTest.php` → **5 passed (14 assertions)**
  - nav sidebar memakai `flex-1 overflow-y-auto sidebar-scroll`
  - sidebar memakai `md:flex md:flex-col h-screen overflow-hidden` dan footer `absolute bottom-0 w-72` sudah tidak ada
  - footer info user `w-full ... shrink-0` (nempel bawah)
  - menu mobile scrollable
  - menu "Konten Website" (Berita/Fasilitas/Profil Guru/Kontak) tampil di sidebar
- Regresi semua halaman admin: **61 passed (166 assertions)**
- `vendor/bin/pint tests/Feature/AdminLayoutTest.php` → **PASS**
- `php artisan view:clear` dijalankan

## 5. Catatan

- Perbaikan murni Blade + CSS inline di layout → **tidak perlu `npm run build`**.
- `absolute bottom-0` masih ada di `resources/views/livewire/admin/dashboard.blade.php` dan `daftar-ulang-form.blade.php`, tapi itu elemen dekoratif/progress bar (bukan sidebar) — tidak diubah.

---


# Changelog — Sesi 17 Oktober 2026 (sesi 6) — Editor Rich Text (WYSIWYG) untuk Isi Berita

> **Tanggal:** 17 Oktober 2026
> **Fokus:** Isi berita kini bisa diformat lengkap (bold, miring, heading, list, kutipan, tautan, sisip gambar) memakai editor **WYSIWYG Quill 2** — plus **HTML sanitizer whitelist** agar tetap aman dari XSS.

---

## 1. Ringkasan

- Editor: **Quill 2.0.3** (CDN jsDelivr) dengan toolbar lengkap: heading 1–4, bold/italic/underline/strike, list ordered/bullet, indent, align, blockquote, code-block, link, **upload gambar**, video, dan tombol clear-format.
- Upload gambar di dalam isi berita lewat endpoint admin baru → tersimpan di `storage/app/public/konten/berita/isi/`.
- **Tanpa menambah dependency** composer/npm: editor via CDN, sanitizer ditulis sendiri (`App\Support\HtmlSanitizer`).
- Halaman detail berita (`show`) kini merender HTML berformat (sebelumnya plain text).

---

## 2. Keamanan (penting)

Sebelumnya `isi` melewati `strip_tags` (plain text). Begitu editor dipakai, menyimpan HTML mentah akan membuka **stored XSS**. Solusinya dua lapis:

1. **Sanitasi saat simpan** — `Berita::booted()` → hook `saving` memanggil `HtmlSanitizer::clean()`. Berlaku untuk semua jalur tulis (form admin, factory, seeder).
2. **Sanitasi saat baca** — accessor `isi_html` memanggil sanitizer lagi (defense in depth, terutama untuk data lama).

**Kebijakan sanitizer:**

| Kategori | Perlakuan |
|---|---|
| Tag diizinkan | `p, br, strong, b, em, i, u, s, strike, sub, sup, h1–h6, ul, ol, li, blockquote, pre, code, a, img, hr, span, div` |
| Atribut diizinkan | `a`: `href, title, target, rel` · `img`: `src, alt, title, width, height` |
| Dibuang total (beserta isi) | `script, style, iframe, frame, frameset, object, embed, applet, form, input, button, select, option, textarea, svg, math, link, meta, base, noscript, template, title` |
| Dibuang (tag-nya saja, teks tetap ada) | tag lain yang tidak dikenal → di-*unwrap* |
| Selalu dibuang | semua atribut `on*` (event handler) & inline `style` |
| Skema URL | hanya `http`, `https`, `mailto`, `tel`, + URL relatif (`/...`, `#...`, `?...`); `javascript:`, `vbscript:`, `data:`, `file:` ditolak (termasuk yang disamarkan pakai entity/tab) |
| Link | otomatis diberi `rel="noopener noreferrer"` |

---

## 3. File Baru / Dimodifikasi

| File | Status | Perubahan |
|---|---|---|
| `app/Support/HtmlSanitizer.php` | **NEW** | Sanitizer HTML berbasis whitelist (DOMDocument, tanpa dependency) |
| `app/Models/Berita.php` | EDIT | `isi` dikeluarkan dari `$sanitizedTextFields`; sanitasi `isi` di hook `saving`; accessor baru `isi_html` + `ringkasan_singkat` |
| `app/Http/Controllers/Admin/BeritaController.php` | EDIT | Method baru `uploadGambar()` (JSON) + konstanta `ISI_GAMBAR_DIRECTORY` |
| `routes/web.php` | EDIT | Route baru `POST admin/beritas/upload-gambar` (`beritas.upload-gambar`) |
| `resources/views/admin/beritas/partials/editor-isi.blade.php` | **NEW** | Komponen editor (Quill CDN + toolbar + upload gambar + sinkronisasi ke `<textarea name="isi">`) |
| `resources/views/admin/beritas/create.blade.php` | EDIT | `<textarea>` isi → `@include` partial editor |
| `resources/views/admin/beritas/edit.blade.php` | EDIT | Sama, dengan nilai awal dari berita |
| `resources/views/admin/beritas/show.blade.php` | EDIT | `{{ $berita->isi }}` → `{!! $berita->isi_html !!}` di dalam `.rich-text` |
| `resources/views/livewire/admin/beritas-table.blade.php` | EDIT | Link "Tambah Berita" & "Edit" **tanpa** `wire:navigate` (agar script editor pasti dimuat) |
| `resources/views/admin/layout.blade.php` | EDIT | CSS `.rich-text` (gaya heading/list/kutipan/gambar untuk halaman detail) |
| `tests/Unit/HtmlSanitizerTest.php` | **NEW** | 16 test sanitizer (termasuk dataset vektor XSS) |
| `tests/Feature/BeritaAdminTest.php` | EDIT | +8 test editor/sanitasi/upload (total 19 test) |

---


## 4. Alur Editor

```
Halaman create/edit
   ├─ <div id="isi-editor">   ← konten awal (HTML tersanitasi)
   ├─ <textarea name="isi">   ← field yang DIKIRIM ke server (fallback)
   └─ JS: jika Quill tersedia → tampilkan editor, sembunyikan textarea,
          sync Quill → textarea pada setiap perubahan & saat submit
      jika Quill GAGAL dimuat (offline) → textarea tetap tampil (degradasi aman)
```

Upload gambar: toolbar image → `POST /admin/beritas/upload-gambar` (CSRF) → simpan ke `konten/berita/isi/` → sisipkan URL ke editor.

---

## 5. Hasil Validasi

- `php artisan test tests/Unit/HtmlSanitizerTest.php` → **16 passed (35 assertions)**
- `php artisan test tests/Feature/BeritaAdminTest.php` → **19 passed**
- Gabungan seluruh test sesi ini (layout, 4 resource konten, pencarian, sanitizer) → **85 passed (230 assertions)**
- `vendor/bin/pint` pada semua file baru/berubah → **PASS**

Test penting: tag diizinkan dipertahankan · `<script>`/`<iframe>`/`<svg>` dibuang beserta isi · `onclick`/`onerror`/`style` dibuang · `javascript:` (termasuk `java&#09;script:`) ditolak · `data:` ditolak · URL relatif/https/mailto/tel diizinkan · tag tak dikenal di-*unwrap* · upload gambar berhasil & tersimpan · non-admin **403** pada endpoint upload · upload non-gambar ditolak · halaman create/edit memuat editor & URL upload · isi HTML tersimpan tersanitasi.

---

## 6. Catatan / Risiko

- **Editor & CSS-nya dari CDN** (`cdn.jsdelivr.net`) — konsisten dengan pola yang sudah ada (font `fonts.bunny.net`, embed Google Maps, link `wa.me`). Bila ingin 100% offline, perlu `npm i quill` + `npm run build` (perlu persetujuan karena mengubah dependency).
- Bila CDN gagal dimuat, form otomatis memakai `<textarea>` biasa (HTML mentah) — data tetap bisa disimpan.
- Link "Tambah/Edit Berita" sengaja **tanpa** `wire:navigate` agar script editor selalu dieksekusi (navigasi Livewire tidak menjalankan ulang `<script src>` halaman baru).
- Gambar yang dihapus dari isi berita **tidak** otomatis dihapus dari storage (belum ada pembersihan orphan) — kandidat backlog.
- Sanitizer ini ditulis sendiri (bukan HTMLPurifier). Cakupan test sudah mencakup vektor umum; bila nanti butuh jaminan lebih kuat, pertimbangkan `ezyang/htmlpurifier` (butuh persetujuan penambahan dependency).
- Halaman **publik** berita belum dibuat; saat dibuat, render isi dengan `{!! $berita->isi_html !!}` (jangan HTML mentah).

---


# Changelog — Sesi 17 Oktober 2026 (sesi 7) — Resource Admin Carousel (Slide Halaman Utama)

> **Tanggal:** 17 Oktober 2026
> **Fokus:** Menambahkan resource admin untuk mengelola **carousel/slider halaman utama** (tambah, ubah, atur urutan, aktif/nonaktif, hapus).
> **Ruang lingkup:** Admin saja. Menampilkan carousel di halaman utama **belum dikerjakan** (akan dibahas terpisah).

---

## 1. Ringkasan

| Item | Keterangan |
|---|---|
| Route | `/admin/carousels*` (7 route: index, create, store, show, edit, update, destroy) |
| Akses | middleware `CheckRole:admin` (role lain **403**) |
| Menu | Sidebar section **"Konten Website"** → item baru **Carousel** (desktop + mobile) |
| Upload | `storage/app/public/konten/carousel/` (gambar wajib saat tambah, opsional saat edit) |
| Fitur | CRUD penuh, search, perPage (15/25/50/100), badge Aktif/Nonaktif, **tombol naik/turun urutan**, modal konfirmasi hapus, pratinjau gambar live (Alpine) |

---

## 2. Skema `carousels`

| Kolom | Tipe | Catatan |
|---|---|---|
| `judul` | string nullable | teks utama slide |
| `deskripsi` | text nullable | teks pendukung |
| `gambar` | string (NOT NULL) | path di disk `public` |
| `link_url` | string nullable | tautan tombol (boleh relatif, mis. `/pendaftaran`) |
| `link_text` | string nullable | label tombol |
| `urutan` | unsignedInteger default 0 | angka kecil tampil lebih dulu (index) |
| `is_active` | boolean default true | tampil/tidak di halaman utama |

---

## 3. File Baru / Dimodifikasi

| File | Status | Keterangan |
|---|---|---|
| `database/migrations/2026_10_17_180315_create_carousels_table.php` | **NEW** | Tabel `carousels` |
| `app/Models/Carousel.php` | **NEW** | fillable + casts + scope `aktif()` + accessor `punya_tombol`; hook `saving` menolak `link_url` berbahaya |
| `database/factories/CarouselFactory.php` | **NEW** | Factory (+ state `nonaktif()`) |
| `app/Http/Requests/CarouselRequest.php` | **NEW** | Validasi + pesan Bahasa Indonesia; `gambar` **required** saat create, nullable saat update |
| `app/Http/Controllers/Admin/CarouselController.php` | **NEW** | CRUD + upload/hapus gambar (`konten/carousel`) |
| `app/Livewire/Admin/CarouselsTable.php` | **NEW** | Tabel admin + aksi `pindah(id, arah)` untuk atur urutan |
| `resources/views/livewire/admin/carousels-table.blade.php` | **NEW** | View tabel (thumbnail, tombol urutan ↑↓, modal hapus) |
| `resources/views/admin/carousels/{index,create,edit,show}.blade.php` | **NEW** | 4 view CRUD (create/edit pakai pratinjau gambar live via Alpine) |
| `routes/web.php` | EDIT | +7 route carousel (dalam grup Konten Website, admin only) |
| `resources/views/admin/layout.blade.php` | EDIT | Menu sidebar "Carousel" (desktop + mobile) |
| `app/Support/HtmlSanitizer.php` | EDIT | `isSafeUrl()` diubah `private` → **`public static`** agar bisa dipakai model lain |
| `tests/Feature/CarouselAdminTest.php` | **NEW** | 14 test |

---

## 4. Keamanan

- **Teks** (`judul`, `deskripsi`, `link_text`) lewat trait `SanitizesTextFields` → `strip_tags` saat disimpan.
- **`link_url`** divalidasi memakai `HtmlSanitizer::isSafeUrl()` di hook `saving`: `javascript:`, `data:`, `vbscript:`, `file:` **ditolak dan dikosongkan**; URL relatif (`/pendaftaran`) dan `http/https/mailto/tel` diizinkan. Ini mencegah XSS saat nanti dirender di halaman publik.
- Halaman detail admin menampilkan pratinjau tombol dengan `rel="noopener noreferrer"`.

---

## 5. Hasil Validasi

- `php artisan migrate` → `create_carousels_table` **DONE**
- `php artisan route:list` → **7 route** `admin/carousels*` terdaftar benar
- `php artisan test tests/Feature/CarouselAdminTest.php` → **14 passed (41 assertions)**
- Regresi seluruh suite sesi ini → **99 passed (271 assertions)**
- `vendor/bin/pint` → **FIXED 1 style issue**, sisanya bersih

Cakupan test: tamu → login, non-admin **403**, admin lihat daftar, tambah slide + gambar tersimpan di `konten/carousel/`, **gambar wajib**, update ganti gambar (+ hapus file lama), update tanpa gambar tetap pakai gambar lama, hapus + cleanup file, `javascript:` pada `link_url` ditolak, tautan relatif tersimpan, teks disanitasi, search, **naik/turun urutan**, hapus via tabel Livewire.

---

## 6. Catatan / Risiko

- **Halaman utama belum menampilkan carousel.** Saat dibuat nanti, ambil data dengan `Carousel::aktif()->get()` dan render `Storage::url($slide->gambar)`; tombol hanya bila `$slide->punya_tombol`.
- Belum ada batas jumlah slide — disarankan di halaman publik nanti hanya menampilkan slide `is_active` sesuai urutan.
- Gambar lama otomatis dihapus saat diganti/dihapus, tetapi gambar yang **tidak terpakai** (mis. gagal simpan) tidak dibersihkan — belum ada pembersihan orphan (sama seperti modul konten lain).
- Tidak ada validasi dimensi gambar; hanya rekomendasi 1920 × 800 px di UI. Ukuran maks **2 MB** (mengikuti konvensi project).
- Belum ada export Excel untuk carousel (tidak diminta).

---


# Changelog — Sesi 17 Oktober 2026 (sesi 8) — Ketentuan Ukuran Gambar & Fasilitas Multi-Foto

> **Tanggal:** 17 Oktober 2026
> **Fokus:** (1) Menetapkan **ketentuan ukuran gambar** untuk thumbnail berita & foto fasilitas, (2) **Fasilitas bisa mengunggah lebih dari satu foto** (galeri).

---

## 1. Ketentuan Ukuran Gambar

| Gambar | Rekomendasi | Minimum | Rasio (wajib lanskap) | Maks |
|---|---|---|---|---|
| Thumbnail berita (`beritas.gambar`) | 1200 × 675 px (16:9) | 800 × 450 px | 1.3 – 2.2 | 2 MB |
| Foto fasilitas (`fasilitas_fotos.path`) | 1200 × 900 px (4:3) | 800 × 600 px | 1.2 – 1.8 | 2 MB per foto |

Ketentuan ditampilkan sebagai kotak petunjuk di form admin (berita create/edit, fasilitas create/edit) dan **ditegakkan saat validasi**.

### Rule baru: `App\Rules\KetentuanUkuranGambar`
`KetentuanUkuranGambar(minLebar, minTinggi, minRasio, maxRasio, rekomendasi)` — memakai `getimagesize()`.

Pesan error menyertakan **ukuran gambar yang diunggah** agar pengguna tahu apa yang salah, contoh:
> "Ukuran gambar terlalu kecil: 400 × 300 px (rasio 1.33). Minimal 800 × 450 px. Rekomendasi 1200 × 675 px (16:9)."

⚠️ **Penting:** rule bawaan Laravel `dimensions:min_ratio` / `max_ratio` **TIDAK dipakai** karena semantiknya terbalik dari namanya (kode Laravel: `min_ratio` gagal bila rasio **lebih besar** dari nilai → jadi batas **atas**; `max_ratio` gagal bila rasio **lebih kecil** → batas **bawah**). Rule kustom dibuat agar maksud kodenya jelas.

---

## 2. Fasilitas Multi-Foto

- **Tabel baru `fasilitas_fotos`**: `id`, `fasilitas_id` (FK cascade), `path`, `urutan`, timestamps.
- **Model baru `FasilitasFoto`** + relasi `Fasilitas::fotos()` (urut `urutan`, lalu `id`).
- **`Fasilitas::syncGambarUtama()`** — kolom `fasilitas.gambar` dipakai sebagai **cover** (dipakai daftar/kartu) dan otomatis disinkronkan = path foto pertama. Kolom `gambar` diubah menjadi **nullable** (bila semua foto dihapus).
- **Backfill**: gambar lama (`fasilitas.gambar`) dipindahkan menjadi foto pertama di galeri. *(Di DB saat ini tabel `fasilitas` masih kosong, jadi tidak ada data yang perlu dipindah.)*
- **Upload banyak berkas**: input `fotos[]` (multiple) — create wajib minimal 1 foto, maksimal **8 berkas sekali unggah** (`FasilitasRequest::MAX_FOTOS`).
- **Hapus satu foto**: route baru `DELETE admin/fasilitas/{fasilitas}/foto/{foto}` (`fasilitas.foto.destroy`), lalu cover ikut disinkronkan. Tombol hapus ada di kartu galeri (di luar form utama agar tidak nested form).
- **Hapus fasilitas**: semua foto (baris + berkas) ikut dihapus — baik dari controller maupun dari tabel Livewire.
- **Urutan foto** = urutan unggah (foto baru ditambahkan di belakang).
- Pratinjau foto baru (multi) memakai Alpine `x-data="{ files: [] }"` + `URL.createObjectURL`.

---

## 3. File Baru / Dimodifikasi

| File | Status | Keterangan |
|---|---|---|
| `app/Rules/KetentuanUkuranGambar.php` | **NEW** | Rule validasi ukuran + rasio gambar |
| `database/migrations/2026_10_17_181539_create_fasilitas_fotos_table.php` | **NEW** | Tabel `fasilitas_fotos` + `gambar` jadi nullable + backfill |
| `app/Models/FasilitasFoto.php` | **NEW** | Model galeri foto |
| `app/Models/Fasilitas.php` | EDIT | `fotos()`, `syncGambarUtama()` |
| `app/Http/Requests/BeritaRequest.php` | EDIT | `ketentuanThumbnail()` + rule gambar berita |
| `app/Http/Requests/FasilitasRequest.php` | EDIT | `MAX_FOTOS`, `ketentuanFoto()`, rule `fotos`/`fotos.*` |
| `app/Http/Controllers/Admin/FasilitasController.php` | EDIT | Multi-upload, `simpanFotos()`, `destroyFoto()`, destroy semua foto, `withCount('fotos')` |
| `app/Livewire/Admin/FasilitasTable.php` | EDIT | Hapus fasilitas ikut menghapus semua foto |
| `resources/views/admin/fasilitas/create.blade.php` | EDIT | Input `fotos[]` multiple + pratinjau + ketentuan |
| `resources/views/admin/fasilitas/edit.blade.php` | EDIT | Kartu galeri + hapus per foto + tambah foto |
| `resources/views/admin/fasilitas/show.blade.php` | EDIT | Galeri foto (badge "Foto Utama") |
| `resources/views/admin/fasilitas/index.blade.php` | EDIT | Kolom Foto (thumbnail + jumlah foto) |
| `resources/views/admin/beritas/create.blade.php` + `edit.blade.php` | EDIT | Kotak ketentuan ukuran thumbnail |
| `routes/web.php` | EDIT | + route `fasilitas.foto.destroy` |
| `tests/Feature/FasilitasAdminTest.php` | EDIT | 14 test (multi-foto, hapus per foto, ketentuan ukuran) |
| `tests/Feature/BeritaAdminTest.php` | EDIT | 22 test (+3 test ketentuan ukuran thumbnail) |

---

## 4. Hasil Validasi

- `php artisan migrate` → `create_fasilitas_fotos_table` **DONE**
- `php artisan route:list` → **8 route** fasilitas (termasuk `admin/fasilitas/{fasilitas}/foto/{foto}`)
- `php artisan test tests/Feature/FasilitasAdminTest.php` → **14 passed (51 assertions)**
- `php artisan test tests/Feature/BeritaAdminTest.php` → **22 passed (71 assertions)**
- Regresi seluruh suite → **106 passed (303 assertions)**
- `vendor/bin/pint` → **PASS** (10 file)

Cakupan test baru: unggah 3 foto sekaligus, foto pertama jadi cover, tambah foto tanpa menghapus foto lama, hapus satu foto + cover otomatis pindah, foto wajib, foto terlalu kecil ditolak, foto portrait ditolak, hapus fasilitas menghapus semua foto, hapus dari tabel Livewire membersihkan berkas, thumbnail berita (sesuai / terlalu kecil / portrait).

---

## 5. Catatan / Risiko

- **Ketentuan bersifat menegakkan (hard rule)** — gambar yang tidak sesuai akan ditolak. Bila dirasa terlalu ketat, cukup ubah parameter di `BeritaRequest::ketentuanThumbnail()` / `FasilitasRequest::ketentuanFoto()` (mis. longgarkan rasio).
- Belum ada **penanda urutan foto** di UI (urutan = urutan unggah). Bila perlu drag-and-drop urutan, itu penambahan terpisah.
- Belum ada **pembersihan orphan** bila unggahan gagal di tengah proses (sama seperti modul konten lain).
- Halaman **publik** (berita/fasilitas/guru/kontak/carousel) belum dibuat; saat itu tiba, fasilitas tampilkan `$fasilitas->fotos` dan cover dari `$fasilitas->gambar`.

---


# Changelog — Sesi 17 Oktober 2026 (sesi 9) — Semua Tombol Admin Jadi Navigasi SPA (wire:navigate)

> **Tanggal:** 17 Oktober 2026
> **Fokus:** Menyeragamkan **seluruh tautan antar-halaman admin** menjadi navigasi SPA Livewire (`wire:navigate`) — sebelumnya banyak tombol "Tambah", "Batal", "Lihat", "Edit", "Kembali" yang masih melakukan full page reload.

---

## 1. Temuan

- Ada **66 tautan** `route('admin.*')` yang belum memakai `wire:navigate` (mayoritas tombol "Batal" di halaman create/edit, tombol "Tambah" di halaman index non-Livewire, dan tombol "Lihat/Edit" di view index lama).
- Tombol "Tambah Berita" & "Edit" di tabel berita sengaja saya lepas dari `wire:navigate` pada sesi 6 (karena skrip editor Quill tidak ikut jalan saat navigasi SPA). Karena diminta semua SPA, masalah itu **diselesaikan di akarnya**, bukan dengan melepas SPA.

---

## 2. Editor Berita Dibuat Tahan Navigasi SPA

Hasil riset ke source Livewire (`vendor/livewire/livewire/dist/livewire.esm.js`): pada navigasi, Livewire menjalankan ulang `<script>` di body (`prepNewBodyScriptTagsToRun`) dan menggabungkan `<head>` (`mergeNewHead`). Tapi ada **race**: `<script src>` eksternal dieksekusi asinkron, sehingga inline script bisa jalan sebelum library siap.

Solusi di `resources/views/admin/beritas/partials/editor-isi.blade.php`:

| Bagian | Perubahan |
|---|---|
| Aset Quill | **Tidak lagi** pakai `<script src>` statis. Dimuat **dinamis** lewat `pastikanAsetQuill()` (dengan `window.__quillMemuat` sebagai promise cache agar hanya sekali) + CSS `<link data-quill-css>` idempoten |
| Inisialisasi | Dibungkus `window.__initEditorIsi()` yang **idempoten** (dijaga `editorEl.dataset.siap === '1'`) |
| Pemicu | Dipanggil saat load **dan** pada `document.addEventListener('livewire:navigated', ...)` (listener didaftarkan sekali lewat `window.__editorIsiListener`) |
| Fallback | Bila Quill gagal dimuat → `<textarea name="isi">` tetap tampil (perilaku aman, tidak berubah) |

Dengan pola ini editor tetap muncul baik saat halaman dibuka langsung (full load) maupun via `wire:navigate`.

---

## 3. Penambahan `wire:navigate`

Diterapkan ke **semua** `<a>` di `resources/views/admin/**` dan `resources/views/livewire/admin/**` yang mengarah ke `route('admin.*')`, dengan **pengecualian** yang disengaja:

- ❌ Link **export Excel** (`admin.*.export`) → harus full navigation agar file ter-download normal.
- ❌ Tautan **`target="_blank"`** (buka gambar/file, `wa.me`, website pondok, Google Maps).

Setelah perubahan: **hanya 5 tautan** admin yang tanpa `wire:navigate` — semuanya link export.

Contoh yang sekarang SPA: tombol **Tambah** (berita/fasilitas/guru/kontak/carousel/siswa/pendaftaran), tombol **Batal** di semua halaman create & edit, tombol **Lihat/Edit/Kembali** di halaman index & show, serta tombol **Reset filter** pada halaman index lama.

---

## 4. File yang Dimodifikasi

| File | Perubahan |
|---|---|
| `resources/views/admin/beritas/partials/editor-isi.blade.php` | Loader aset dinamis + init idempoten + listener `livewire:navigated` |
| `resources/views/livewire/admin/beritas-table.blade.php` | `wire:navigate` dikembalikan pada tombol Tambah & Edit |
| `resources/views/livewire/admin/{mtsputras,mtsputris,maputras,maputris}-table.blade.php` | `wire:navigate` pada tombol Tambah Siswa (link export tetap non-SPA) |
| `resources/views/livewire/admin/carousels-table.blade.php` | `wire:navigate` pada tombol Tambah Slide |
| `resources/views/admin/{beritas,fasilitas,gurus,kontaks,carousels}/{index,create,edit,show}.blade.php` | `wire:navigate` pada Tambah/Batal/Lihat/Edit/Kembali |
| `resources/views/admin/{mtsputras,mtsputris,maputras,maputris,pendaftarans}/index.blade.php` | idem |
| `resources/views/admin/{mtsputras,mtsputris,maputras,maputris,pendaftarans}/show.blade.php` | sudah SPA (tidak berubah) |
| `tests/Feature/AdminSpaNavigationTest.php` | **NEW** — 15 test regresi |

---

## 5. Hasil Validasi

- `php artisan view:clear` dijalankan
- `php artisan test tests/Feature/AdminSpaNavigationTest.php` → **15 passed (31 assertions)**
- Regresi seluruh suite → **121 passed (334 assertions)**
- `vendor/bin/pint` → **PASS**
- Audit grep: `66` tautan admin tanpa `wire:navigate` → **tinggal 5** (semua link export)

Cakupan test: tombol Tambah SPA di 7 halaman daftar, tombol Batal SPA di 5 halaman create, tombol Tambah & Edit pada tabel berita SPA, tombol Batal di halaman edit berita SPA, dan link export **tetap tidak** SPA.

---

## 6. Catatan

- Tautan `target="_blank"` yang **sudah** punya `wire:navigate` (mis. "Uang Masuk" di sidebar) tidak diubah — Livewire otomatis mengabaikan `wire:navigate` bila ada `target`.
- Tidak perlu `npm run build` (perubahan Blade/JS inline saja).
- Bila nanti menambah halaman admin baru: **wajib** pakai `wire:navigate` untuk tautan antar-halaman admin (kecuali export / `target="_blank"`), dan skrip apa pun harus dibuat tahan navigasi (lihat bagian Konvensi kode).

---


# Changelog — Sesi 17 Oktober 2026 (sesi 10) — Halaman Utama Pindah ke `/psb`, `/` Jadi Website Sekolah

> **Tanggal:** 17 Oktober 2026
> **Fokus:** Memindahkan halaman utama lama (pencarian data santri) ke **`/psb`**, dan menyiapkan **`/`** sebagai **halaman utama / website sekolah** yang akan menampilkan konten website (berita, fasilitas, profil guru, kontak).

---

## 1. Perubahan Struktur Halaman

| URL | Nama route | Sebelum | Sesudah |
|---|---|---|---|
| `/` | `home` | Halaman pencarian data santri (`welcome.blade.php`) | **Halaman utama / website sekolah** (`home.blade.php`) |
| `/psb` | `psb` | — (belum ada) | **PSB & pencarian data santri** (`psb.blade.php`) |

`resources/views/welcome.blade.php` **dipindahkan** (via `git mv`, riwayat terjaga) menjadi `resources/views/psb.blade.php`.

---

## 2. Halaman `/psb` (hasil pindahan)

Konten sama seperti halaman utama lama (pencarian siswa + section about + footer), dengan penyesuaian:

- `<title>` → "PSB & Cari Data Santri - PPSR 2026"
- Logo di header kini **tautan ke Beranda** (`route('home')`)
- Menu header diisi tautan nyata: **Beranda · PSB · Galeri Foto · Uang Masuk** (sebelumnya komentar kosong)
- Footer "Quick Links" (yang masih `#`) diganti tautan nyata: Beranda, PSB & Cari Data, Galeri Foto, Uang Masuk
- Label footer "PPSR 2025" → "PPSR 2026", copyright jadi `{{ date('Y') }}`

---

## 3. Halaman `/` (baru — website sekolah)

`resources/views/home.blade.php` — halaman publik mandiri (tanpa layout admin), tema hijau konsisten:

| Bagian | Isi |
|---|---|
| Header | Logo PPSR, menu (Beranda, Layanan, Kontak, PSB, Galeri Foto), tombol **Cari Data** & **Daftar PSB** |
| Hero | Nama pondok, tagline, badge **Tahun Ajaran aktif**, 2 CTA (Daftar Santri Baru, Cari Data Santri) |
| **Layanan** | 4 kartu akses cepat: Pendaftaran Santri Baru, Cari Data Santri, Galeri Foto, Uang Masuk |
| **Hubungi Kami** | Alamat, telepon/WhatsApp (link `wa.me`), email, jam layanan, + embed Google Maps — **diambil dari Pengaturan → Kontak Lembaga**; seluruh section disembunyikan bila data masih kosong |
| Catatan | Info strip: berita, fasilitas, dan profil guru **sedang disiapkan** |
| Footer | Deskripsi, tautan layanan, tautan pendaftaran, kontak (fallback ke data lama bila kosong) |

---

## 4. Penyesuaian Referensi

| File | Perubahan |
|---|---|
| `routes/web.php` | `/` → `view('home')` (name `home`), route baru `/psb` → `view('psb')` (name `psb`) |
| `app/Livewire/UpdateFotoForm.php` | Redirect jenis data tidak valid: `route('home')` → **`route('psb')`** (user berasal dari halaman PSB) |
| `tests/Feature/CariSiswaTableTest.php` | Test "halaman utama memuat pencarian" → **`route('psb')`** |
| `tests/Feature/HomePageTest.php` | **NEW** — 6 test halaman utama baru |

Tautan lain yang menunjuk `route('home')` (tombol "Kembali ke Beranda" di Update Foto & Galeri Foto, logo di layout auth) **tetap** — sekarang mengarah ke halaman utama sekolah, sesuai labelnya.

---

## 5. Hasil Validasi

- `php artisan route:list` → `GET /` = `home`, `GET /psb` = `psb` ✓
- `php artisan view:clear` dijalankan
- `php artisan test tests/Feature/HomePageTest.php tests/Feature/CariSiswaTableTest.php tests/Feature/ExampleTest.php` → **19 passed (45 assertions)**
- Regresi seluruh suite → **127 passed (352 assertions)**
- `vendor/bin/pint` → PASS (pint juga merapikan `UpdateFotoForm.php`: urutan import, spasi `! `, concat — tanpa perubahan logika)

Cakupan test: `/` dapat diakses & memuat nama pondok, `/` menyediakan tautan ke PSB/pendaftaran/galeri/uang masuk, `/` **tidak lagi** memuat komponen pencarian, `/psb` memuat komponen pencarian, section kontak muncul bila data diisi & **tersembunyi** bila kosong.

---

## 6. Catatan / Risiko

- **`/` sekarang bukan lagi halaman pencarian.** Siapa pun yang menyimpan tautan lama ke `/` (mis. dari poster/WhatsApp) akan mendarat di halaman utama baru — tombol **"Cari Data"** sudah disediakan di header & hero sebagai jalan pintas ke `/psb`.
- Halaman utama masih **versi jembatan**: berita, fasilitas, dan profil guru **belum ditampilkan** (hanya info strip "sedang disiapkan"). Data carousel/berita/fasilitas/guru sudah siap di admin dan tinggal dirender.
- Halaman publik baru yang **belum ada**: `/berita`, `/berita/{slug}`, `/fasilitas`, `/guru`. Rencana: dibuat saat penyusunan halaman utama lengkap.
- Belum ada halaman publik untuk daftar fasilitas/guru, sehingga kartu "Fasilitas" belum masuk ke menu.
- `/beranda` (`testcoba.blade.php`) masih halaman uji coba — belum dibersihkan.

---

# Changelog — Sesi 17 Oktober 2026 (sesi 11) — Website Sekolah Lengkap: Navbar Berita/Fasilitas/Guru/Kontak

> **Tanggal:** 17 Oktober 2026
> **Fokus:** Melengkapi `/` sebagai website sekolah yang **benar-benar menampilkan Konten Website** (carousel, berita, fasilitas, profil guru, kontak) + membuat **4 halaman publik** di navbar: **Berita, Fasilitas, Guru, Kontak**.

---

## 1. Ringkasan Perubahan

| URL | Nama route | Sebelum | Sesudah |
|---|---|---|---|
| `/` | `home` | Versi jembatan (hero + Layanan + Kontak) | **Website sekolah lengkap** (carousel + berita + fasilitas + guru + kontak) |
| `/berita` | `berita.index` | — | **Daftar berita terbit** (paginasi 9/halaman) |
| `/berita/{slug}` | `berita.show` | — | **Detail berita** (isi HTML disanitasi + berita lainnya) |
| `/fasilitas` | `fasilitas.index` | — | **Daftar fasilitas aktif + galeri foto** (paginasi 9) |
| `/guru` | `guru.index` | — | **Daftar profil guru aktif** (paginasi 12) |
| `/kontak` | `kontak.index` | — | **Kontak lembaga + kontak person + peta + CTA** |
| `/psb` | `psb` | Halaman mandiri (header/footer sendiri) | Pakai **layout publik bersama** |

View dipindahkan: `resources/views/psb.blade.php` → **`resources/views/site/psb.blade.php`** (via `git mv`), `resources/views/home.blade.php` → **`resources/views/site/home.blade.php`** (file lama dihapus).

---

## 2. Layout Publik Bersama — `resources/views/layouts/public.blade.php` (BARU)

Header/footer tidak lagi diduplikasi di tiap halaman publik.

| Bagian | Isi |
|---|---|
| Navbar | Logo `PPSR 2026` → `route('home')` + **menu: Berita · Fasilitas · Guru · Kontak** (desktop & mobile) + tombol **PSB** |
| Status aktif | `request()->routeIs(explode('.', $route)[0].'.*')` → `berita.index` menyorot juga `berita.show` |
| Menu mobile | Toggle vanilla JS (`#site-menu-btn` / `#site-menu`) — tanpa Alpine, aman untuk semua halaman |
| Footer | 4 kolom: deskripsi, Tautan (Berita/Fasilitas/Guru/Kontak), Layanan (Pendaftaran/PSB/Galeri Foto/Uang Masuk), Kontak (`Setting::value('kontak_*')` + fallback data lama) |
| Aset | `@vite` + **`@livewireStyles`/`@livewireScripts`** eksplisit → Alpine & Livewire selalu tersedia di halaman publik |

**Catatan penting (Blade):** variabel yang dideklarasikan `@php` di **layout** TIDAK tersedia di `@section('content')` milik child view (child dievaluasi lebih dulu). Karena itu data kontak lembaga yang dipakai isi halaman dikirim dari controller (`$lembaga`), bukan diandalkan dari layout. Layout hanya memakai variabelnya sendiri di footer.

---

## 3. Halaman Utama `/` — `resources/views/site/home.blade.php`

Controller: `app/Http/Controllers/Site/HomeController.php`

| Bagian | Sumber data | Catatan |
|---|---|---|
| **Carousel** | `Carousel::aktif()->take(5)` | Slider Alpine (`x-data` + `x-init="mulai()"`): auto 6 detik, tombol ‹ ›, dot indikator, `x-transition.opacity`. Judul/deskripsi/tombol (CTA) dari `link_url` + `link_text` |
| Hero cadangan | — | Muncul **hanya bila belum ada slide**: gradien hijau + badge Tahun Ajaran aktif + 2 CTA |
| **Berita** | `Berita::published()->latest('published_at')->take(3)` | Kartu: gambar, kategori, tanggal, `ringkasan_singkat` |
| **Fasilitas** | `Fasilitas::aktif()->with('fotos')->take(3)` | Kartu: cover (`gambar`), kategori, deskripsi, jumlah foto |
| **Profil Guru** | `Guru::aktif()->take(4)` | Kartu: foto (fallback inisial nama), nama, jabatan |
| **Kontak** | `Kontak::aktif()->take(4)` + `Setting::value('kontak_*')` | Info lembaga + kartu kontak person (WhatsApp `wa.me`) + CTA ke `/kontak` & `/pendaftaran` |

Setiap section **disembunyikan otomatis** bila datanya kosong (`@if ($x->isNotEmpty())`), kecuali section Kontak yang selalu tampil sebagai ajakan (dengan pesan pengisian bila data kontak kosong).

---


## 4. Halaman Publik Baru (Navbar)

Semua di `app/Http/Controllers/Site/` dan `resources/views/site/`:

| Halaman | Controller | Query | Isi view |
|---|---|---|---|
| `/berita` | `BeritaController@index` | `Berita::published()->latest('published_at')->paginate(9)` | Grid kartu berita + pesan kosong + `links()` |
| `/berita/{slug}` | `BeritaController@show` | `published()->where('slug')->firstOrFail()` + 3 berita lain (`whereKeyNot`) | Judul, kategori, tanggal, penulis, gambar, ringkasan, **`{!! $berita->isi_html !!}`**, tombol kembali, "Berita Lainnya" |
| `/fasilitas` | `FasilitasController@index` | `Fasilitas::aktif()->with('fotos')->paginate(9)` | Kartu besar (cover + deskripsi) + **galeri semua foto** (klik → buka ukuran penuh), anchor `#fasilitas-{id}` |
| `/guru` | `GuruController@index` | `Guru::aktif()->paginate(12)` | Grid kartu: foto/inisial, nama, jabatan, pendidikan, deskripsi, anchor `#guru-{id}` |
| `/kontak` | `KontakController@index` | `Kontak::aktif()->get()` + `Setting::value('kontak_*')` | 4 kartu info lembaga, tautan sosial media, kartu kontak person (`whatsapp_link`), **peta iframe**, CTA pendaftaran |

Kartu di halaman utama menautkan ke halaman ini (mis. fasilitas → `/fasilitas#fasilitas-{id}`, guru → `/guru#guru-{id}`), dengan `scroll-mt-24` pada anchor agar tidak tertutup navbar sticky.

---

## 5. Keamanan — Peta Tidak Lagi Dirender sebagai HTML Mentah

`kontak_maps_embed` disimpan apa adanya (kode embed Google Maps) — sebelumnya berpotensi menjadi celah XSS bila dirender `{!! !!}`.

**Solusi:** method baru **`HtmlSanitizer::embedUrl(?string $html): ?string`**
- Ambil hanya nilai `src="..."` dari snippet (atau pakai input langsung bila berupa URL);
- Validasi lewat `HtmlSanitizer::isSafeUrl()` (menolak `javascript:`, `data:`, dll.);
- View merender **`<iframe src="{{ $lembaga['maps'] }}">` milik sendiri** (dengan `loading="lazy"` + `referrerpolicy`) — bukan HTML dari admin.

Konsisten dengan aturan proyek: **tidak ada `{!! !!}` HTML mentah dari input admin**. Satu-satunya `{!! !!}` yang tersisa adalah `$berita->isi_html` (sudah disanitasi saat simpan + saat baca).

---

## 6. File Baru / Dimodifikasi

**Baru:**
- `app/Http/Controllers/Site/{HomeController,BeritaController,FasilitasController,GuruController,KontakController}.php`
- `resources/views/layouts/public.blade.php`
- `resources/views/site/home.blade.php`, `resources/views/site/psb.blade.php` (dipindah)
- `resources/views/site/berita/{index,show}.blade.php`, `site/fasilitas/index.blade.php`, `site/guru/index.blade.php`, `site/kontak/index.blade.php`
- `tests/Feature/SitePagesTest.php` (19 test)

**Dimodifikasi:**
- `routes/web.php` — blok "Website Sekolah (halaman publik)" + `/psb` → `view('site.psb')`
- `app/Support/HtmlSanitizer.php` — `embedUrl()`
- `tests/Feature/HomePageTest.php` — test "bagian kontak disembunyikan bila kosong" → "detail kontak diganti pesan pengisian" (section kontak kini selalu tampil)
- `tests/Unit/HtmlSanitizerTest.php` — +5 test `embedUrl()`
- `MEMORY.md`

---

## 7. Hasil Validasi

- `php artisan view:clear` dijalankan; `vendor/bin/pint --dirty` → 2 style issue diperbaiki (import `routes/web.php`, blank line EOF)
- `php artisan test tests/Feature/SitePagesTest.php tests/Feature/HomePageTest.php tests/Unit/HtmlSanitizerTest.php` → **47 passed (124 assertions)**
- Seluruh suite → **170 passed (463 assertions)**, 15 gagal (**pre-existing**, lihat catatan)
- Uji langsung `php artisan serve` (port 8123/8124) + `curl`:
  - `/`, `/berita`, `/fasilitas`, `/guru`, `/kontak`, `/psb` → **HTTP 200, tanpa error marker**
  - `/` memuat navbar (Berita/Fasilitas/Guru/Kontak), section Berita (3 berita terbit), Profil Guru (5 guru), Kontak; Fasilitas/Carousel kosong di DB → section disembunyikan, hero cadangan dipakai ✓

Cakupan test: navbar 4 tautan, carousel aktif saja (+ sembunyikan nonaktif), hero cadangan, berita terbit saja, fasilitas & guru aktif saja, kontak lembaga + kontak person aktif, daftar berita (terbit vs draft + pesan kosong), detail berita (isi disanitasi, `<script>` hilang, draft → 404, slug asing → 404), fasilitas (galeri foto + nonaktif tersembunyi + pesan kosong), guru (aktif saja + pesan kosong), kontak (info lembaga, `wa.me`, kontak nonaktif tersembunyi, peta aman vs tidak aman), `embedUrl()` (src dari snippet, URL langsung, null/kosong/javascript/data).

---

## 8. Catatan / Risiko

- **15 test gagal = warisan starter kit Laravel, bukan regresi sesi ini**: `tests/Feature/Auth/*`, `tests/Feature/DashboardTest.php`, `tests/Feature/Settings/*` memanggil route yang **tidak ada** di aplikasi ini (`dashboard`, `profile.edit`). Semua error berupa `RouteNotFoundException`/`ViewException` pada route tersebut. Perlu dibersihkan/disesuaikan pada sesi terpisah (hapus atau arahkan ke `admin.dashboard`).
- `/beranda` (`testcoba.blade.php`) **masih** halaman uji coba — belum dibersihkan.
- Carousel/fasilitas/kontak **belum ada datanya di DB lokal** → tampil hero cadangan / section tersembunyi. Isi lewat admin (`/admin/carousels`, `/admin/fasilitas`, `/admin/kontaks`, `/admin/kontak-lembaga`) untuk melihat tampilan penuh.
- Halaman publik **tanpa cache** — setiap kunjungan menjalankan query; bila trafik naik, pertimbangkan `Cache::remember` untuk carousel/berita terbaru.
- Semua pekerjaan sesi ini **belum di-commit** (bersama pekerjaan sesi 4–10).

---
# Changelog — Sesi 18 Oktober 2026 (sesi 12) — Situs Publik Jadi Full SPA Livewire

> **Tanggal:** 18 Oktober 2026
> **Fokus:** Mengubah **seluruh halaman publik** menjadi **komponen Livewire full-page** (halaman utama, navbar, footer, dan 5 halaman navbar) dengan navigasi **`wire:navigate`** → tanpa reload halaman (SPA).

---

## 1. Ringkasan Perubahan Arsitektur

| Sebelum (sesi 11) | Sesudah (sesi 12) |
|---|---|
| `app/Http/Controllers/Site/*Controller.php` + `resources/views/site/*.blade.php` | **`app/Livewire/Site/*.php`** + **`resources/views/livewire/site/*.blade.php`** |
| `layouts/public.blade.php` (Blade `@extends`, navbar/footer markup statis) | **`layouts/public.blade.php`** = layout Livewire (`{{ $slot }}`) + **`<livewire:site.navbar />`** + **`<livewire:site.footer />`** |
| Tautan antar halaman = reload penuh | **`wire:navigate`** di semua tautan internal → SPA |
| Carousel pakai Alpine (`x-data`) | Carousel **server-side** (`Site\Carousel`) + `wire:poll.6s` |
| `FotoTable` & `UangMasukTable` pakai `layouts.standalone` | Pakai **`layouts.public`** → navbar/footer ikut tampil |

Folder `app/Http/Controllers/Site/` dan `resources/views/site/` **dihapus** (tidak ada lagi controller halaman publik).

---

## 2. Komponen Baru — `app/Livewire/Site/`

| Komponen | Peran | Catatan |
|---|---|---|
| `Navbar` | Navbar situs | Menu Berita/Fasilitas/Guru/Kontak + tombol PSB, `$menuTerbuka` (toggle mobile via `wire:click="toggleMenu"` — **state di server**), `$routeAktif` diambil di `mount()` agar sorotan tetap benar saat re-render, `apakahAktif()` + `aria-current="page"` |
| `Footer` | Footer situs | `mount()` membaca `Setting::value('kontak_*')` |
| `Carousel` | Slider halaman utama | `$slides` = **array primitif** (bukan model) → polling tidak memicu query ulang; aksi `berikut()`, `sebelumnya()`, `keSlide()`; auto-rotate `wire:poll.6s="berikut"` (hanya bila >1 slide); crossfade murni CSS (`opacity-100`/`opacity-0` + `transition-opacity duration-700`) |
| `Home` | Halaman utama | `adaSlide`, berita terbaru, fasilitas, guru, kontak, `$lembaga` |
| `BeritaIndex` | Daftar berita | `WithPagination` → 9/halaman (pagination Livewire, tanpa reload) |
| `BeritaShow` | Detail berita | `mount(string $slug)` (route parameter otomatis), `firstOrFail()` → 404 untuk draft/slug asing |
| `FasilitasIndex` | Daftar fasilitas | `WithPagination` 9/halaman + `with('fotos')` |
| `GuruIndex` | Profil guru | `WithPagination` 12/halaman |
| `KontakIndex` | Kontak | Info lembaga + kontak person + peta (`HtmlSanitizer::embedUrl`) |
| `Psb` | Layanan PSB | Membungkus `<livewire:cari-siswa-table />` (nested component) |

Semua halaman: `#[Layout('layouts.public', ['description' => '...'])]` + `#[Title('...')]`. Untuk judul dinamis (detail berita) dipakai `->title(...)->layout('layouts.public', ['description' => ...])` di `render()`.

---

## 3. Detail Teknis yang Perlu Diketahui

- **Judul & deskripsi halaman:** Livewire mengirim `$title` (dari `#[Title]`/`->title()`) dan param `description` (dari `#[Layout('layouts.public', [...])]`/`->layout(..., [...])`) ke layout. Layout memakai `{{ $title ?? ... }}` / `{{ $description ?? ... }}`. **Jangan** pakai `@extends`/`@yield` lagi di halaman publik.
- **Satu root element** wajib untuk setiap komponen → semua view halaman dibungkus `<div>` (navbar → `<header>`, footer → `<footer>`, carousel → `<section>`).
- **`@php` di layout tidak tersedia di slot** (slot dirender lebih dulu) → data seperti kontak lembaga dikirim lewat `render()` komponen.
- **`wire:poll` di `Site\Carousel`** hanya me-render ulang komponen carousel (bukan seluruh halaman) karena polling dipasang di root komponen terpisah. Livewire otomatis menurunkan frekuensi polling saat tab tidak aktif.
- **Tautan aktif** ditandai `aria-current="page"` (semantik + mudah di-test). Navbar memakai `$routeAktif` dari `mount()`; karena `wire:navigate` men-swap seluruh body, komponen navbar ikut ter-mount ulang sehingga sorotan selalu benar.
- **Pagination Livewire 3.7** memakai properti `paginators` (bukan `$page`) → test memakai `assertSet('paginators.page', 2)`.
- **Nested component:** `#[Layout]` hanya berlaku untuk komponen paling luar; navbar/footer/carousel tidak perlu atribut layout.

---


## 4. File Baru / Dimodifikasi

**Baru:**
- `app/Livewire/Site/{Navbar,Footer,Carousel,Home,BeritaIndex,BeritaShow,FasilitasIndex,GuruIndex,KontakIndex,Psb}.php`
- `resources/views/livewire/site/{navbar,footer,carousel,home,berita-index,berita-show,fasilitas-index,guru-index,kontak-index,psb}.blade.php`
- `tests/Feature/SiteLivewireTest.php` (17 test)

**Dimodifikasi:**
- `resources/views/layouts/public.blade.php` → layout Livewire (`{{ $slot }}` + navbar/footer komponen)
- `routes/web.php` → 7 route publik diarahkan ke komponen Livewire
- `app/Livewire/FotoTable.php`, `app/Livewire/UangMasukTable.php` → `#[Layout('layouts.public')]`
- `MEMORY.md`

**Dihapus:** `app/Http/Controllers/Site/` (5 controller) dan `resources/views/site/` (7 view).

---

## 5. Hasil Validasi

- `php artisan test tests/Feature/SiteLivewireTest.php` → **17 passed**
- Test publik terkait → **41 passed (141 assertions)** (`SiteLivewireTest` + `SitePagesTest` + `HomePageTest`)
- Seluruh suite → **187 passed (522 assertions)**, 15 gagal (**pre-existing** starter kit, route `dashboard`/`profile.edit`)
- `vendor/bin/pint --dirty` ✓ · `npm run build` ✓ (CSS 257,95 kB)
- Uji langsung `php artisan serve` + `curl`:

| URL | HTTP | `wire:snapshot` | `wire:navigate` | Judul halaman |
|---|---|---|---|---|
| `/` | 200 | 3 | 28 | Pondok Pesantren Syafa'aturrasul — Kuantan Singingi |
| `/berita` | 200 | 3 | 19 | Berita & Pengumuman - PPSR |
| `/fasilitas` | 200 | 3 | 16 | Fasilitas - PPSR |
| `/guru` | 200 | 3 | 16 | Profil Guru - PPSR |
| `/kontak` | 200 | 3 | 18 | Kontak - PPSR |
| `/psb` | 200 | 4 | 17 | Cari Data & Pendaftaran Santri - PPSR 2026 |
| `/foto` | 200 | 3 | 15 | — |
| `/uangmasuk` | 200 | 3 | 15 | — |

`wire:snapshot` = 3 → navbar + footer + komponen halaman (semuanya Livewire); `/psb` = 4 (tambah `CariSiswaTable`). Meta `description` per halaman juga terverifikasi muncul.

---

## 6. Catatan / Risiko

- **Halaman formulir tetap standalone** (`PendaftaranForm`, `DaftarUlangForm`, `DaftarUlangTable`, `UpdateFotoForm` memakai `layouts.standalone` via `->layout()` di `render()`) — sengaja dibiarkan fokus tanpa navbar/footer (biasanya dibuka dari tautan/QR). Bila ingin seragam, ganti ke `layouts.public`.
- **Belum di-commit** (bersama pekerjaan sesi 4–11).
- 15 test starter kit masih gagal (lihat sesi 11) — perlu dibersihkan terpisah.
- Carousel/kontak/fasilitas masih kosong di DB lokal → halaman utama menampilkan hero cadangan; isi dari admin untuk melihat tampilan penuh.
- `resources/views/site/psb.blade.php` (hasil `git mv` dari `welcome.blade.php` di sesi 10) kini dihapus — isinya dikonversi ke `resources/views/livewire/site/psb.blade.php` (riwayat rename tidak lagi terlacak git, tapi isi lama tetap ada di histori).

---
# Changelog — Sesi 18 Oktober 2026 (sesi 13) — Ukuran Carousel Halaman Utama Disamakan dengan Gambar yang Diunggah

> **Fokus:** Banner carousel di `/` sebelumnya memakai **tinggi tetap** (`h-[380px] md:h-[520px]`) sehingga gambar slide terpotong. Sekarang tinggi banner **mengikuti rasio asli berkas gambar** yang diunggah lewat admin carousel.

---

## 1. Temuan

- Slide nyata di DB lokal: **1920 × 1080 px (rasio 1.78 / 16:9)**; kotak tampilan lama ber-tinggi tetap → gambar terpotong.
- Rekomendasi ukuran di admin carousel (`admin/carousels/create.blade.php` & `edit.blade.php`): **1920 × 800 px (12:5)** — baru berupa **saran**, belum ada validasi dimensi (berbeda dengan `BeritaRequest`/`FasilitasRequest` yang memakai `KetentuanUkuranGambar`).

---

## 2. Perbaikan

| Bagian | Perubahan |
|---|---|
| `Site\Carousel` | `mount()` menghitung rasio tiap slide via `getimagesize()` berkas di disk `public` → disimpan sebagai string `"lebar / tinggi"` di array slide (tetap **primitif**, jadi polling tidak menambah query). Method baru `rasioAktif()`. Konstanta `RASIO_DEFAULT = '12 / 5'` (= 1920×800 rekomendasi admin) dipakai bila berkas hilang/tidak terbaca |
| `livewire/site/carousel.blade.php` | `h-[380px] md:h-[520px]` → `min-h-[200px] max-h-[800px]` + `style="aspect-ratio: {{ $this->rasioAktif() }}"`. Overlay teks jadi responsif (`text-xl sm:text-2xl md:text-4xl lg:text-5xl`, `pb-6 md:pb-14`, tombol `px-4 py-2 md:px-6 md:py-3`) |
| `admin/carousels/index.blade.php` | Thumbnail `w-24 h-14` → `w-24 aspect-[12/5]` (pratinjau admin memakai bentuk yang sama) |

**Hasil:** gambar tampil **utuh tanpa crop/distorsi**; gambar 1920×1080 → banner `aspect-ratio: 1920 / 1080`, gambar 1920×800 → `1920 / 800` (12:5).

---

## 3. Hasil Validasi

- Test baru di `SiteLivewireTest`: rasio asli gambar (fake 1200×500 → `aspect-ratio: 1200 / 500`) & cadangan `12 / 5` bila berkas tidak ada → **19 passed**
- Seluruh suite → **189 passed (526 assertions)**, 15 gagal (**pre-existing** starter kit)
- Uji langsung `curl /` dengan slide asli 1920×1080 → `aspect-ratio: 1920 / 1080` ✓ (verifikasi live)
- `vendor/bin/pint --dirty` → PASS · `npm run build` ✓

---

## 4. Catatan

- Karena mengikuti rasio berkas, tinggi banner bisa **berbeda antar slide** bila rasio gambar berbeda. Ingin dikunci seragam? Ganti `style="aspect-ratio: ..."` menjadi kelas `aspect-[12/5]` (standar rekomendasi admin).
- Validasi dimensi unggah carousel **belum ditambahkan** (opsional): bisa memakai `App\Rules\KetentuanUkuranGambar` seperti berita/fasilitas, mis. `new KetentuanUkuranGambar(1200, 500, 2.0, 3.0, '1920 × 800 px (12:5)')`.
- Belum di-commit (bersama pekerjaan sesi 4–12).

---

# Changelog — Sesi 18 Oktober 2026 (sesi 14) — Carousel Halaman Utama Didesain Ulang (Rapi & Profesional)

> **Fokus:** Memperbaiki tampilan carousel `/` yang tidak rapi setelah mode "rasio asli" (sesi 13). Sekarang memakai **hero card** dengan rasio bertingkat, kartu teks kaca (glassmorphism), dan kontrol yang tidak saling tumpuk.

---

## 1. Penyebab "tidak rapi"

| Masalah | Penjelasan |
|---|---|
| Banner terlalu tinggi | Mode `aspect-ratio` dari berkas gambar: slide 1920×1080 → tinggi banner ~1080 px (memenuhi layar) / terpotong di `max-h-800px` |
| Kontrol tumpang tindih | Titik indikator di `bottom-5` bertabrakan dengan teks/tombol yang juga menempel di bawah |
| Gradasi terlalu pekat | `from-black/80 via-black/40` menutupi hampir seluruh foto |
| Tanpa batas tepi | Banner full-bleed menempel ke navbar sticky |

---

## 2. Desain Baru (`livewire/site/carousel.blade.php`)

- **Hero card**: dibungkus `max-w-7xl mx-auto px-4…pt-6 md:pt-8` + `rounded-2xl md:rounded-3xl shadow-xl ring-1 ring-black/5` → ada jarak dari navbar & tepi layar.
- **Rasio bertingkat (tinggi konsisten antar slide)**: `aspect-[3/2] sm:aspect-[2/1] lg:aspect-[21/9]` — di 1440 px ≈ 520 px tinggi (tidak memenuhi layar, tidak melompat antar slide). Gambar `object-cover object-center` (tidak gepeng; crop ringan ~11–24%).
- **Kartu teks kaca**: `max-w-xl rounded-2xl bg-black/30 p-4 ring-1 ring-white/15 backdrop-blur-md` di kiri bawah, dengan `pb-12…lg:pb-16` supaya **tidak menabrak titik indikator**; judul memakai `<h2>` (bukan `<h1>` lagi), deskripsi `line-clamp-2`, tombol dengan ikon panah.
- **Hanya tampil bila ada teks**: method baru `Carousel::adaTeks()` + atribut `data-slide-caption` (tanpa teks → banner bersih tanpa kartu).
- **Gradasi lembut**: `from-black/70 via-black/20 to-black/5` (foto tetap terlihat).
- **Kontrol**: panah `rounded-full bg-white/15 ring-1 ring-white/25 backdrop-blur hover:bg-white/30` (`h-9 w-9 md:h-11 md:w-11`), titik indikator di **tengah bawah** (aktif `w-6 bg-white`, non-aktif `w-1.5 bg-white/50`) + `aria-current`. Semua kontrol hanya muncul bila slide > 1.
- **Judul utama halaman**: `<h1 class="sr-only">` di `home.blade.php` (karena judul slide & hero cadangan memakai `<h2>`) → struktur heading tetap valid.
- **Hero cadangan** (bila belum ada slide) disamakan: kartu gradien hijau `rounded-2xl md:rounded-3xl` dalam container yang sama.
- Method `rasioGambar()`/`rasioAktif()` + konstanta `RASIO_DEFAULT` (sesi 13) **dihapus** (tidak dipakai lagi).

---

## 3. Hasil Validasi

- `SiteLivewireTest` → **19 passed** (test baru: "rasio hero konsisten", "kartu teks hanya tampil bila ada teks")
- Suite publik (`SiteLivewireTest` + `SitePagesTest` + `HomePageTest`) → **43 passed (148 assertions)**
- Seluruh suite → **189 passed (529 assertions)**, 15 gagal (**pre-existing** starter kit)
- `vendor/bin/pint --dirty` PASS · `npm run build` ✓ (CSS 261,26 kB)
- Uji live `curl /` dengan slide nyata: section `class="relative overflow-hidden rounded-2xl md:rounded-3xl bg-gray-900 shadow-xl ring-1 ring-black/5 aspect-[3/2] sm:aspect-[2/1] lg:aspect-[21/9]"`, tanpa inline style, kartu teks 1×, kontrol (panah/titik) **tidak dirender** karena hanya ada 1 slide ✓

---

## 4. Catatan

- Rasio hero sekarang **tetap** (bukan mengikuti rasio berkas). Ingin kembali ke mode "gambar utuh tanpa crop"? Bisa dibuat opsi lanjutan (mis. `object-contain` + latar blur).
- Rekomendasi unggah di admin tetap **1920 × 800 px**; dengan rasio hero 2:1/21:9, gambar 16:9 hanya terpotong sedikit (~11–24% di bagian atas/bawah).
- Belum di-commit (bersama pekerjaan sesi 4–13).

---

# Changelog — Sesi 18 Oktober 2026 (sesi 15) — Hilangkan Latar Kaca (Glassmorphism) di Carousel

> **Fokus:** Atas permintaan: hapus latar kaca pada carousel halaman utama — teks & kontrol tampil **tanpa background**.

---

## 1. Perubahan (`livewire/site/carousel.blade.php`)

| Elemen | Sebelum | Sesudah |
|---|---|---|
| Kartu teks (caption) | `rounded-2xl bg-black/30 p-4 ring-1 ring-white/15 backdrop-blur-md` | **tanpa latar** — hanya `<div class="max-w-xl">`; teks langsung di atas foto |
| Judul slide | `drop-shadow-md` | `text-shadow-md text-shadow-black/60` (Tailwind v4.1 `text-shadow-*`) |
| Deskripsi | `drop-shadow` | `text-shadow-sm text-shadow-black/60` |
| Tombol panah ‹ › | `bg-white/15 ring-1 ring-white/25 backdrop-blur` | **tanpa latar** — ikon saja (`text-white drop-shadow-md`, ikon diperbesar `h-6 w-6 md:h-7 md:w-7`, stroke 2.5), hover `bg-white/20` |
| Gradasi bawah | `from-black/70 via-black/20 to-black/5` | `from-black/75 via-black/25 to-transparent` (sedikit lebih kuat agar teks tetap terbaca tanpa kotak) |

Titik indikator (`bg-white` / `bg-white/50`) tetap — itu indikator, bukan latar kaca.

---

## 2. Hasil Validasi

- Test baru: **"teks dan kontrol carousel tampil tanpa latar kaca"** → `assertDontSeeHtml('backdrop-blur')`, `'bg-black/30'`, `'ring-white/25'` + `assertSeeHtml('text-shadow-md')`
- `SiteLivewireTest` → **20 passed**; suite publik → **44 passed (153 assertions)**
- Seluruh suite → **190 passed (534 assertions)**, 15 gagal (**pre-existing** starter kit)
- `vendor/bin/pint --dirty` PASS · `npm run build` ✓ (CSS 264,11 kB — `text-shadow-md/sm` + `text-shadow-black/60` ter-generate, `--tw-text-shadow-color:#0009`)
- Uji live `curl /`: carousel **tidak lagi mengandung** `backdrop-blur`/`bg-black/30`/`ring-white/*`; gradasi & text-shadow terpasang ✓. (Satu-satunya `backdrop-blur` di halaman utama berasal dari kartu **"Hubungi Kami"** di section kontak — di luar carousel, sengaja dibiarkan.)

---

## 3. Catatan

- Bila ingin kartu "Hubungi Kami" (section kontak) juga tanpa kaca, tinggal hapus `backdrop-blur-sm bg-white/10 ring-1 ring-white/20` di `livewire/site/home.blade.php`.
- Belum di-commit (bersama pekerjaan sesi 4–14).

---

# Changelog — Sesi 18 Oktober 2026 (sesi 16) — Tombol WhatsApp Mengambang di Situs Publik

> **Fokus:** Floating button WhatsApp di pojok kanan bawah **semua halaman publik**, lengkap dengan pesan pembuka otomatis.

---

## 1. Komponen Baru — `App\Livewire\Site\WhatsappButton`

| Bagian | Isi |
|---|---|
| `NOMOR_DEFAULT` | `6285259875754` (format internasional, tanpa `+`) |
| `PESAN_DEFAULT` | "Assalamualaikum warohmatullahi wabarokatuh, Kami ingin mengetahui informasi lebih lanjut Pondok Pesantren Syafa'aturrasul" |
| `nomorDariPengaturan()` (static) | Ambil `Setting::value('kontak_whatsapp')`, buang karakter non-digit, awalan `0` → `62`; bila kosong → `NOMOR_DEFAULT` |
| `linkWhatsapp()` | `https://wa.me/{nomor}?text={rawurlencode(PESAN_DEFAULT)}` |
| View `livewire/site/whatsapp-button.blade.php` | `<a>` bulat hijau `bg-[#25D366]` + ikon WhatsApp SVG, **`fixed bottom-5 right-5 z-50`** (mobile) → `md:bottom-6 md:right-6`, hover `scale-105` + `bg-[#20bd5a]`, label "Chat WhatsApp" melebar saat hover (`group-hover:max-w-[10rem]`), `aria-label` + `title`, **`target="_blank" rel="noopener noreferrer"`** (tautan luar → **tanpa** `wire:navigate`) |

Dipasang **satu kali** di `resources/views/layouts/public.blade.php` (setelah `<livewire:site.footer />`) sehingga otomatis tampil di: `/`, `/berita`, `/berita/{slug}`, `/fasilitas`, `/guru`, `/kontak`, `/psb`, `/foto`, `/uangmasuk`.

---

## 2. Hasil Validasi

- **9 test baru** di `SiteLivewireTest`:
  - tampil di 6 halaman publik (dataset) + `fixed bottom-5 right-5`
  - tautan wa.me + pesan ter-encode + `target="_blank"` dan **bukan** `wire:navigate`
  - nomor dari Pengaturan (`085259875754` → `6285259875754`)
  - fallback ke nomor default bila pengaturan kosong
- `SiteLivewireTest` → **29 passed**; seluruh suite → **199 passed (565 assertions)**, 15 gagal (**pre-existing** starter kit)
- `vendor/bin/pint --dirty` PASS · `npm run build` ✓ (`#25d366`, `#20bd5a`, `max-width:10rem` ter-generate)
- Uji live `curl /` (HTTP 200):
  - `href="https://wa.me/6285259875754?text=Assalamualaikum%20warohmatullahi%20wabarokatuh%2C%20Kami%20ingin%20mengetahui%20informasi%20lebih%20lanjut%20Pondok%20Pesantren%20Syafa%27aturrasul"` ✓ (setelah didekode = pesan yang diminta)
  - `class="group fixed bottom-5 right-5 z-50 …"` ✓

---

## 3. Catatan

- Nomor tujuan mengikuti **Pengaturan → Kontak Lembaga** (`kontak_whatsapp`) bila diisi; bila dikosongkan otomatis kembali ke `6285259875754`.
- Belum di-commit (bersama pekerjaan sesi 4–15).

---


# Changelog — Sesi 24 Oktober 2026 — Visi dan Misi Halaman Utama

## Ringkasan Perubahan
- Menambahkan Visi Pesantren dan enam Misi dari teks pengguna tepat setelah carousel/hero, sebelum berita.
- Layout dua kolom pada desktop dan bertumpuk pada mobile, mendukung dark mode.
- Membersihkan artefak HTML spasi/tanda kutip dan merapikan ejaan “Luar Negri” menjadi “Luar Negeri”.
- Foto pendukung belum diberikan pengguna; belum ditambahkan.
- Arahan pengguna: Modul Rapor ditangguhkan sampai diminta kembali.

## File yang Dimodifikasi
- `resources/views/livewire/site/home.blade.php`
- `tests/Feature/HomePageTest.php`
- `MEMORY.md`

## Hasil Validasi
- Pest `HomePageTest` + `SiteLivewireTest` dengan SQLite `:memory:`: 37 passed, 126 assertions.
- `vendor/bin/pint --dirty`: PASS.
- `npm run build`: berhasil.
- Test baru memastikan visi dan seluruh misi tampil dengan maupun tanpa carousel.

# Changelog — Sesi 24 Oktober 2026 — Peta Lokasi Pondok Putri dan Putra

## Ringkasan Perubahan
- Menambahkan dua peta Google Maps di halaman utama sebelum Hubungi Kami, berdampingan di desktop dan bertumpuk pada layar kecil.
- Lokasi diverifikasi dari redirect tautan pengguna: Putri `-0.5124461,101.577084`; Putra `-0.415269,101.6124704`. Menggunakan koordinat tempat (`!3d/!4d`), bukan titik tengah kamera (`@`).
- Tombol membuka tautan asli Google Maps di tab baru, tanpa `wire:navigate`.
- Iframe diberi judul aksesibel dan lazy loading. Tidak menambahkan alamat jalan yang belum diberikan/diverifikasi.

## File yang Dimodifikasi
- `resources/views/livewire/site/home.blade.php`
- `tests/Feature/HomePageTest.php`
- `MEMORY.md`

## Hasil Validasi
- Test halaman utama dan SiteLivewire memeriksa pemetaan judul, koordinat, dan tautan masing-masing pondok.
- Tampilan peta eksternal memerlukan akses Google Maps dari browser pengunjung.

# Changelog — Sesi 24 Oktober 2026 — Judul Lokasi Pondok

- Mengubah judul peta halaman utama menjadi “Lokasi Pondok Pesantren Syafa'aturasul” mengikuti teks pengguna.
- Memperbarui assertion judul pada `tests/Feature/HomePageTest.php`.
- Validasi: HomePageTest 9 test lulus; `vendor/bin/pint --dirty` lulus.

# Changelog — Sesi 24 Oktober 2026 — Posisi Berita Sebelum Lokasi

## Ringkasan Perubahan
- Memindahkan Berita & Pengumuman dari setelah Visi Misi ke tepat sebelum Lokasi Pondok.
- Urutan section: carousel/hero → Visi Misi → Fasilitas → Profil Guru → Berita & Pengumuman → Lokasi Pondok → Hubungi Kami. Section konten kosong tetap disembunyikan.
- Pengguna berencana menambahkan konten lain setelah Visi Misi; konten tersebut belum diberikan.

## File yang Dimodifikasi
- `resources/views/livewire/site/home.blade.php`
- `tests/Feature/HomePageTest.php`
- `MEMORY.md`

## Hasil Validasi
- HomePageTest: 10 passed, 46 assertions; termasuk pemeriksaan DOM bahwa section tepat sebelum lokasi adalah berita.
- `vendor/bin/pint --dirty`: PASS.
- `npm run build`: berhasil.

# Changelog — Sesi 24 Oktober 2026 — Banner Pondok Setelah Visi Misi

## Ringkasan Perubahan
- Menambahkan banner WebP yang diberikan pengguna tepat di bawah Visi Misi dan sebelum Fasilitas.
- Gambar asli disalin ke `public/images/profil-pondok-syafaaturrasul.webp`, ditampilkan utuh dengan lebar responsif dan rasio asli 1600 × 383, alt deskriptif, lazy loading, dan decoding async.

## File yang Dimodifikasi
- `public/images/profil-pondok-syafaaturrasul.webp` (baru)
- `resources/views/livewire/site/home.blade.php`
- `tests/Feature/HomePageTest.php`
- Aset build Vite dan `MEMORY.md`.

## Hasil Validasi
- HomePageTest: 11 passed, 52 assertions. Test baru memeriksa posisi banner tepat setelah Visi Misi, URL aset, alt, dan dimensi terhadap file asli.
- `vendor/bin/pint --dirty`: PASS.
- `npm run build`: berhasil.

# Changelog — Sesi 25 Oktober 2026 — Optimasi Performa Website Publik

## Dasar dan Lingkup
- Menindaklanjuti PDF PageSpeed pengguna tanggal 22 Oktober: performance mobile 73, LCP 10 detik, rekomendasi utama optimasi gambar dan aset pemblokir render. Angka tersebut adalah laporan sebelum perubahan, bukan hasil pengukuran baru.
- Fokus halaman publik/utama. Modul Rapor tetap ditangguhkan. Tidak mengubah dependensi atau data santri, dan belum melakukan deploy produksi.

## Perubahan
- Memisahkan CSS publik `resources/css/site.css` dari CSS aplikasi admin melalui input Vite khusus. Layout publik tidak lagi memuat bundel admin maupun entry JavaScript kosong; Livewire tetap dimuat.
- Menambahkan `App\Support\ResponsiveImage`, komponen Blade `site-image`, dan command `site:optimize-images`. Varian WebP dibuat di luar request pengunjung, pada lebar 320/640/960/1280/1920 yang dibatasi ukuran asli. File asli tidak diganti.
- Optimasi dibatasi ke `public/images` dan public disk lokal `konten`; dokumen siswa tidak diproses. File hilang/rusak, gambar terlalu besar, JPEG berorientasi EXIF selain normal, dan WebP animasi dilewati. Varian kedaluwarsa tidak dipakai; URL varian diberi versi timestamp.
- Hero pertama memakai eager loading dan fetchpriority high; gambar lainnya lazy loading. Banner, fasilitas, guru, dan berita di homepage memakai srcset, sizes, serta dimensi intrinsik.
- Polling carousel menggunakan `wire:poll.6s.visible` sehingga berhenti ketika tidak terlihat. Memperbaiki hierarki heading footer.
- `.htaccess` menambahkan kompresi untuk respons teks dan cache immutable satu tahun khusus nama CSS/JS hasil build dengan hash. Memerlukan modul Apache/LiteSpeed yang sesuai; tidak otomatis berlaku pada Nginx.

## Hasil Lokal dan Validasi
- Build publik: CSS 56,76 KB (gzip 9,28 KB), dibanding bundel aplikasi 268,02 KB (gzip 34,40 KB). Pengurangan ukuran CSS mentah sekitar 79%.
- Banner asli sekitar 800 KiB; varian 640px sekitar 26 KiB dan 1600px sekitar 100 KiB. Pilihan ukuran unduhan bergantung viewport dan kepadatan piksel perangkat.
- `site:optimize-images --no-interaction` berhasil menghasilkan varian aset publik dan carousel lokal.
- Pemeriksaan browser sesi sebelumnya: tampilan desktop/mobile 390px, gambar responsif termuat, menu dan navigasi Berita bekerja, tanpa error JavaScript pada pemeriksaan tersebut.
- Tes terfokus `SitePerformanceTest`, `HomePageTest`, `SiteLivewireTest`, dan `SitePagesTest`: **65 passed, 258 assertions** dengan `APP_ENV=testing DB_CONNECTION=sqlite DB_DATABASE=:memory:`. Meliputi sumber asli tetap utuh, ukuran responsif, tidak memperbesar gambar kecil, fallback, varian kedaluwarsa, pembatasan folder, opsi command invalid, dan prioritas hero.
- `vendor/bin/pint --dirty`: PASS. `npm run build`: berhasil. Seluruh suite tidak dijalankan ulang; kegagalan baseline terdahulu di luar lingkup ini tidak dinyatakan selesai.

## Penerapan di Hosting
- Sertakan source, `public/build`, serta aset/varian `public/images` dalam deploy. Setelah file konten tersedia di server, jalankan `php artisan site:optimize-images --no-interaction`; PHP GD dengan dukungan WebP diperlukan.
- Command dapat dijalankan ulang dengan aman, dan perlu dijalankan kembali setelah unggah/perubahan gambar konten. Belum ada otomatisasi saat upload. Tanpa varian, gambar asli tetap menjadi fallback.
- Pastikan konfigurasi produksi `APP_ENV=production`, `APP_DEBUG=false`, dan `APP_URL` sesuai domain. Setelah konfigurasi benar, jalankan `php artisan optimize --no-interaction`. Untuk build dari source gunakan `npm run build`.
- Skor PageSpeed dan LCP setelah perubahan **belum diukur di produksi**. Jalankan ulang setelah deploy; konfigurasi kompresi/cache hosting juga perlu diverifikasi pada respons server sebenarnya.

## Pemeriksaan Insiden CSS Setelah Deploy — 25 Oktober 2026
- Pengguna melakukan deploy menggunakan `git pull` lewat terminal hosting.
- HTML produksi berhasil dibaca dan menunjuk `/build/assets/site-Bif1qVjs.css`, tetapi URL CSS tersebut mengembalikan HTTP 404. Bundel admin baru `app-xU0pcVhB.css` juga 404; bundel lama `app-CAfEjjPr.css` masih HTTP 200 dengan tipe `text/css`.
- File build baru sudah dilacak Git lokal (commit terbaru saat pemeriksaan `4680104`). Bukti menunjukkan aset yang disajikan domain belum sinkron dengan manifest/template terbaru; belum dapat memastikan apakah document root terpisah, checkout berbeda, atau proses penyalinan aset belum dilakukan tanpa melihat lokasi folder hosting.
- Belum mengubah server atau menyatakan insiden selesai. Langkah berikutnya: periksa commit dan keberadaan `public/build/assets/site-Bif1qVjs.css` di checkout hosting, lalu cocokkan lokasi tersebut dengan document root domain. Hindari mengganti kode CSS atau membersihkan cache secara acak karena URL aset secara nyata 404.
- Hasil terminal pengguna mengonfirmasi checkout `/home/ppsyafaa/datappsr` pada commit `4680104` memiliki CSS terbaru, sementara `/home/ppsyafaa/public_html/build/assets` hanya memiliki CSS lama. Kedua folder build berupa direktori terpisah; `git pull` tidak menyinkronkan salinan di public_html.
- Perbaikan yang diberikan: salin isi `datappsr/public/build/assets/.` ke `public_html/build/assets/` terlebih dahulu, lalu manifest. Tidak menghapus aset lama. Setelah setiap deploy, sinkronisasi ini perlu diulang selama struktur hosting masih memakai salinan public terpisah. Pemulihan belum terverifikasi sampai command dijalankan dan URL CSS mengembalikan HTTP 200 dengan tipe text/css.
- Pemeriksaan lanjutan URL banner `images/profil-pondok-syafaaturrasul.webp.optimized-1600.webp?v=1792899679` juga menghasilkan HTTP 404. File asli dan varian tersedia di project lokal. Pengguna diarahkan menyalin isi `datappsr/public/images/.` ke `public_html/images/`, termasuk semua ukuran srcset; sinkronisasi deploy harus meliputi images selain build. Pemulihan banner belum diverifikasi di produksi.
- Pengguna mengonfirmasi gambar sudah tampil kembali setelah penyalinan. Menjelaskan alur deployment struktur saat ini: build dan tes lokal → commit/push source beserta public/build dan aset images → pull hosting → optimasi gambar bila diperlukan → sinkronisasi assets/images ke public_html → manifest terakhir → refresh cache Laravel → verifikasi HTTP dan tampilan. Otomatisasi script deployment atau perubahan document root belum diimplementasikan.

# Changelog — Sesi 25 Oktober 2026 — Profil Pesantren dan Foto Santri

- Menambahkan bagian profil tepat setelah Visi Misi, sebelum banner pondok yang sudah ada. Teks mengikuti materi pengguna, termasuk empat satuan pendidikan dan keterangan Akreditasi A.
- Desktop menggunakan dua kolom: teks di kiri, tiga foto di kanan (santriwati di atas, dua foto santri di bawah). Pada ponsel foto berada setelah teks. Mendukung dark mode, alt deskriptif, dan gambar utuh tanpa crop.
- Menyalin tiga WebP pengguna dari Downloads menjadi `public/images/profil-santriwati.webp`, `profil-santri-quran.webp`, dan `profil-santri-pramuka.webp`; membuat varian responsif memakai command optimasi yang sudah ada. Gambar asli tetap dipertahankan; lazy loading dan srcset melalui komponen site-image.
- Validasi: HomePageTest + SitePerformanceTest 19 passed, 116 assertions; Pint dirty lulus; build Vite berhasil. Browser ponsel menunjukkan ketiga foto tampil; grid desktop terverifikasi dua kolom. Test posisi banner diperbarui agar berada sesudah profil baru.
- Deploy: sertakan hasil build dan semua gambar/varian baru dalam commit. Setelah pull hosting, sinkronkan public/build/assets dan public/images ke public_html, lalu manifest terakhir. Belum deploy/push dari sesi ini.

## Penyesuaian Profil — Foto Transparan Menyatu dengan Teks
- Menghapus seluruh latar warna dan bingkai pada tiga foto profil, serta menghapus kartu putih/border pembungkus profil agar teks dan foto berada di latar halaman yang sama.
- Ketiga WebP asli sudah memiliki alpha transparan; tidak perlu mengubah foto atau identitas subjek. Susunan foto dibuat lebih rapat; desktop tetap di samping teks dan mobile di bawah teks.
- HomePageTest diperbarui untuk memeriksa transparansi sudut file sumber dan ketiadaan kelas latar/bingkai pada figure foto. Validasi: 12 passed, 80 assertions; Pint dirty dan build Vite berhasil. Belum deploy.

## Revisi Profil — Foto di Dalam Alur Deskripsi
- Mengganti dua kolom teks/galeri terpisah menjadi tiga paragraf dengan foto masing-masing di dalam alur teks. Pada layar sm ke atas foto mengambang bergantian kanan/kiri/kanan sehingga teks mengalir di sampingnya; pada ponsel foto berada sebelum paragraf terkait agar area baca tetap cukup lebar.
- Seluruh foto tetap transparan tanpa kartu/bingkai. Judul dan slogan menjadi pembuka dan penutup bersama; isi teks tetap dipertahankan.
- Test memeriksa setiap foto berada bersama paragrafnya. HomePageTest: 12 passed, 81 assertions; Pint dirty dan build Vite berhasil. Belum deploy.

## Revisi Profil — Komposisi Lebih Rapat
- Mengurangi lebar area profil menjadi max-w-5xl agar paragraf tidak terlalu panjang dan foto tidak terasa jauh dari teks.
- Mengganti float bergantian dengan tiga pasangan foto/paragraf yang konsisten, sejajar vertikal di tengah. Jarak foto-teks 12px pada ponsel dan 20px mulai sm; foto 104px/160px. Tidak ada kotak latar atau bingkai pada foto.
- Mengurangi jarak antar pasangan menjadi 12px, padding section, dan line-height paragraf dari loose menjadi relaxed. Teks, tiga foto transparan, dan urutan section tetap dipertahankan.
- Validasi: HomePageTest, Pint dirty, dan build Vite berhasil. Belum deploy; pemeriksaan visual browser belum dilakukan untuk revisi ini.

## Revisi Teks Profil — Paragraf Pembuka Disingkat
- Mengganti paragraf pembuka profil menjadi persis: “Memadukan pendidikan agama, ilmu pengetahuan, pembinaan karakter, dan pengembangan potensi santri.” sesuai permintaan pengguna.
- Memperbarui HomePageTest untuk memastikan teks baru tampil dan kalimat lama tidak tampil. HomePageTest: 12 passed, 90 assertions; Pint dirty lulus. Perubahan hanya teks, tidak mengubah CSS/aset. Belum deploy.

## Revisi Teks Profil — Satuan Pendidikan
- Mengganti kalimat satuan pendidikan sesuai permintaan menjadi “MTs Putra, MTs Putri, MA Putra, dan MA Putri ber Akreditasi A.” Nama satuan pendidikan dan Akreditasi A tetap tebal; penulisan “ber” mengikuti teks pengguna.
- HomePageTest diperbarui: 12 passed, 92 assertions. Pint dirty lulus. Hanya perubahan teks, belum deploy.

## Revisi Teks Profil — Komitmen Pesantren
- Mengganti paragraf komitmen menjadi persis: “Berkomitmen mencetak generasi muslim yang beriman, berilmu, berakhlak mulia, mandiri, dan siap menghadapi tantangan zaman.”
- HomePageTest memeriksa kalimat baru dan ketiadaan pembuka lama: 12 passed, 94 assertions. Pint dirty lulus. Hanya perubahan teks, belum deploy.

# Changelog — Sesi 25 Oktober 2026 — Fondasi SEO Nama Pesantren dan Kuansing
- Permintaan pengguna: meningkatkan pencarian syafaaturrasul/syafaturasul, ponpes, pondok pesantren Kuansing/Kuantan Singingi, serta MTs/MA. Peringkat pertama tidak dijanjikan; tidak membuat keyword stuffing atau meta keywords.
- Memperbarui judul/deskripsi homepage untuk nama Syafaaturrasul, Kuansing, MTs dan MA. Label profil menyebut nama lembaga dan Kuantan Singingi (Kuansing), Riau secara terlihat tanpa mengubah tiga paragraf singkat yang diminta sebelumnya.
- Layout publik menggunakan lang=id, canonical URL berbasis config seo.url (default domain produksi; dapat diatur SEO_URL), metadata Open Graph, serta JSON-LD EducationalOrganization di homepage. Nama alternatif memakai nama lembaga yang wajar, bukan daftar salah eja. Tidak menambahkan klaim prestasi/alamat yang belum diketahui.
- Canonical membuang tracking query, mempertahankan page pada listing berita/guru/fasilitas. Layanan pencarian santri PSB diberi noindex pada layout publik; ini bukan kontrol akses atau perlindungan data.
- Menambahkan SitemapController dan route /sitemap.xml: lima halaman informasi utama serta berita published dengan published_at tidak di masa depan. Draft dan layanan data santri tidak dimasukkan. lastmod hanya dari updated_at berita, tidak memalsukan tanggal halaman statis.
- robots.txt mencantumkan sitemap domain produksi. Jika domain SEO_URL berubah, robots.txt perlu disesuaikan juga.
- Dokumentasi Laravel Boost tidak tersedia dalam katalog tools; merujuk dokumentasi resmi Laravel 12 dan Google Search Central sebelum implementasi. Tidak mengubah dependensi atau modul Rapor.
- Validasi: SiteSeoTest + HomePageTest + SitePagesTest 33 passed, 175 assertions; Pint dirty dan npm run build berhasil. Belum push/deploy atau mengakses Google Search Console.
- Deploy hosting terpisah: sinkronkan build/images seperti sebelumnya, dan salin public/robots.txt ke /home/ppsyafaa/public_html/robots.txt. Route sitemap dilayani aplikasi, bukan file XML yang perlu disalin. Refresh cache Laravel setelah deploy.
- Tindak lanjut eksternal: verifikasi kepemilikan domain di Search Console, kirim sitemap.xml, periksa pengindeksan homepage, lalu pantau kueri dan halaman. Konten rinci MTs/MA dan profil lokasi perlu materi faktual pengguna untuk dikembangkan berikutnya.

## Domain Resmi — Tautan Footer Diperbarui
- Pengguna mengonfirmasi syafaaturrasul.com tidak digunakan lagi dan mengizinkan penggantian tautannya.
- Mengganti tautan Website Pondok pada footer dari https://www.syafaaturrasul.com ke https://ppsyafaaturrasul.com. Referensi domain dalam config SEO dan robots.txt sudah memakai domain baru.
- SiteSeoTest memeriksa tautan domain baru dan memastikan domain lama tidak muncul dalam HTML homepage. Validasi: SiteSeoTest 3 tes lulus; Pint dirty lulus. Tidak mengatur redirect domain lama atau mengubah DNS. Belum deploy.

# Audit SEO — 25 Oktober 2026

## Lingkup dan Metode
- Audit read-only kode dan respons website produksi: homepage, berita, fasilitas, guru, kontak, pendaftaran; variasi domain HTTP/www; robots; URL 404 uji; CSS produksi. Tidak mengubah perilaku aplikasi atau hosting dalam audit ini.
- SiteSeoTest dijalankan dengan database SQLite memory: 3 passed, 22 assertions. Tidak menjalankan Lighthouse baru, Rich Results Test, atau masuk akun Search Console. Screenshot pengguna sebelumnya mengonfirmasi sitemap sukses (5 URL) dan homepage indexed.

## Temuan Prioritas
1. Konsolidasi URL produksi belum tuntas: http://ppsyafaaturrasul.com/ dan https://www.ppsyafaaturrasul.com/ sama-sama merespons HTTP 200 pada HEAD, bukan redirect permanen ke https://ppsyafaaturrasul.com/. Canonical sudah ada tetapi redirect lebih konsisten. Perlu konfigurasi hosting yang memperhitungkan proxy/TLS agar tidak loop.
2. Pendaftaran memakai layouts.standalone → partials.head, bukan layouts.public. HTML produksi: lang=en, title=syafaaturrasul, tanpa meta description/canonical. Rekomendasi beri metadata spesifik jika halaman dimaksudkan masuk Google, atau sediakan halaman informasi penerimaan santri yang indexable dan pisahkan formulir layanan. Tidak otomatis mengindeks seluruh layanan data siswa.
3. Halaman percobaan masih dirutekan publik: /beranda (view testcoba, HTTP 200) dan /lagibelajar (HTTP 500 pada HEAD). Rekomendasi batasi pengembangan atau hapus route yang tidak diperlukan, dengan pertimbangan tautan yang sudah dipakai. Belum ada bukti halaman ini terindeks atau menyebabkan penurunan peringkat.
4. Pagination berita/fasilitas/guru memakai default Livewire links yang menghasilkan button wire:click, tanpa a href untuk halaman berikutnya. Canonical page sudah dipertahankan tetapi penemuan halaman lanjut sebaiknya memakai tautan crawlable. Risiko meningkat saat data lebih dari satu halaman; sitemap berita membantu mitigasi.
5. Kelengkapan konten: homepage produksi masih memuat pesan “Informasi kontak dapat diisi melalui menu Pengaturan → Kontak Lembaga.” Berita produksi masih kosong. Alamat/kontak lembaga perlu diisi dan konten MTs/MA/pendaftaran faktual perlu dikembangkan; bukan mengulang variasi kata kunci.
6. Konsistensi berita terjadwal: scopePublished pada model hanya memfilter status, sedangkan sitemap juga mensyaratkan published_at <= now. Berita masa depan dapat muncul di listing/detail tetapi belum masuk sitemap. Temuan kode; tidak ditemukan kasus aktif di produksi yang berita terbitnya masih kosong.

## Yang Sudah Baik
- Lima halaman informasi yang diperiksa memiliki judul/deskripsi/canonical dan satu H1; layout publik lang=id. Homepage memiliki JSON-LD lembaga dan metadata sosial. Semua enam img homepage memiliki alt.
- robots.txt produksi HTTP 200 dan mencantumkan sitemap dengan domain benar. Footer produksi sudah tidak mengarah ke domain lama.
- URL uji yang tidak ada mengembalikan 404. CSS produksi HTTP 200, gzip sekitar 9,4 KB, cache satu minggu (berbeda dengan aturan satu tahun repo tetapi tetap memiliki cache).
- Belum dapat menyimpulkan peringkat kata kunci, indeks seluruh halaman, atau Core Web Vitals terkini dari audit ini. Data Search Console dan pengukuran performa terpisah diperlukan. Tidak ada jaminan nomor satu.

## Urutan Perbaikan Disarankan
- Rapikan domain HTTPS/non-www dan route percobaan, kemudian metadata pendaftaran serta pagination, lalu isi kontak dan informasi pendidikan. Article/Breadcrumb structured data dapat menjadi peningkatan lanjutan, bukan penghambat pengindeksan utama.

# Perbaikan Hasil Audit SEO — 25 Oktober 2026

## Implementasi
- Menambahkan middleware global App\Support\CanonicalDomain setelah middleware bawaan. Aktif secara default jika APP_ENV=production, dapat dikendalikan SEO_REDIRECT_DOMAIN. Untuk host domain SEO dan www-nya, HTTP/www dialihkan ke SEO_URL; path/query dipertahankan, GET/HEAD 301, metode lain 308 agar body/metode tidak hilang. Localhost dan host lain tidak dialihkan. Redirect ini berlaku pada request aplikasi; aturan static assets tetap milik web server.
- Konfigurasi SEO_URL default https://ppsyafaaturrasul.com. Tidak mempercayai X-Forwarded-Proto dari sumber sembarang. Bila hosting memakai TLS termination/proxy, trusted proxy harus dikonfigurasi berdasarkan infrastruktur sebenarnya sebelum mengaktifkan redirect; dapat mematikan sementara dengan SEO_REDIRECT_DOMAIN=false jika perlu. Belum diuji pada server produksi setelah deploy.
- Route /lagibelajar dihapus; /beranda menjadi redirect permanen ke /. File view/demo tidak dihapus.
- Metadata pendaftaran: judul khusus MTs/MA, deskripsi, canonical, lang=id, robots index/follow. Halaman pendaftaran masuk sitemap (enam URL statis sekarang). Layout standalone lainnya diberi noindex/follow untuk layanan formulir.
- Pagination berita/fasilitas/guru memakai view publik dengan a href untuk prev/next dan wire:navigate. Path paginator ditetapkan ke named route supaya tautan absolut konsisten dan metadata diperbarui saat navigasi halaman.
- scopePublished sekarang mensyaratkan status published DAN published_at <= now, dipakai bersama oleh listing, detail, homepage dan sitemap. Test membuktikan berita masa depan 404 lalu tersedia setelah waktunya lewat.
- Detail berita mendapatkan JSON-LD NewsArticle dari konten aktual: headline, deskripsi, tanggal, publisher, author/image jika diisi. OG type menjadi article.
- Pesan pengisian pengaturan yang semula tampil di homepage diganti arahan pengunjung ke halaman kontak. Tidak mengisi data kontak, berita, atau klaim pendidikan palsu. Data alamat lengkap/kontak/jam layanan diminta melalui pertanyaan pengguna dan masih menunggu.

## Validasi dan Deploy
- SiteSeoTest, HomePageTest, SitePagesTest, SiteLivewireTest, BeritaAdminTest: 89 passed, 380 assertions dengan SQLite :memory:.
- vendor/bin/pint --dirty dan npm run build berhasil. Tidak mengubah dependensi atau modul Rapor.
- Belum push/deploy. Setelah deploy, pastikan APP_ENV=production, APP_DEBUG=false, SEO_URL=https://ppsyafaaturrasul.com (atau default), jalankan php artisan optimize:clear lalu php artisan optimize; sinkronkan build/images/robots.txt ke public_html seperti prosedur hosting sebelumnya.
- Verifikasi hosting: HTTP dan www harus 301 ke domain HTTPS utama; domain HTTPS utama tetap 200 tanpa loop; /lagibelajar 404, /beranda 301, /sitemap.xml berisi pendaftaran dan berita yang sudah terbit. Jika memakai proxy TLS, periksa konfigurasi proxy sebelum rollout redirect.
- Tidak menjanjikan peringkat teratas. Konten program pendidikan, berita faktual, informasi kontak, Search Console, dan performa lapangan tetap perlu pemeliharaan; full suite belum dijalankan (baseline kegagalan starter routes terdahulu di luar scope).

# Changelog — Sesi 26 Oktober 2026 — Logo Navbar, SEO Homepage, Konsistensi Footer Publik

> **Tanggal:** 26 Oktober 2026
> **Fokus:** Logo di navbar publik, metadata SEO homepage, dan penyatuan footer publik.

## Ringkasan Perubahan
- **Logo navbar:** menyalin `logonavbar/Logo untuk Navbar .webp` ke `public/images/logo-navbar.webp`, lalu mengganti teks `PPSR` + `2026` di kiri navbar dengan `<img>` berukuran `h-10 w-auto object-contain` (width/height 600×134, `decoding="async"`, `fetchpriority="high"`). Tautan logo ke `route('home')` dan `wire:navigate` tetap dipertahankan.
- **SEO homepage:** `Site\Home` sekarang memakai title persis `Pondok Pesantren Syafa'aturrasul | Kuantan Singingi` dan description persis `Website resmi Pondok Pesantren Syafa'aturrasul di Kuantan Singingi, Riau. Pendidikan MTs dan MA Putra-Putri terakreditasi A.`. `og:site_name` dan canonical `https://ppsyafaaturrasul.com/` sudah sesuai. Menambahkan JSON-LD `WebSite` khusus homepage di `layouts.public` (berdampingan dengan `EducationalOrganization` yang sudah ada).
- **Pitfall JSON-LD:** key `'@context'` wajib didefinisikan di dalam blok `@php`. Bila ditulis langsung di array inline Blade, `@context` dikompilasi sebagai directive dan merusak output JSON.
- **Footer publik:** menghapus link **Cari Data Santri**, **Galeri Foto**, dan **Uang Masuk** dari komponen footer bersama (bukan lagi kondisional per halaman). Footer kini identik di seluruh halaman publik dan tetap satu komponen Livewire.
- **Struktur SPA:** `navbar` dan `footer` tetap satu komponen masing-masing di `layouts.public`; semua tautan internal memakai `wire:navigate`. Admin (`layouts.admin`) dan halaman form standalone (`/pendaftaran`, daftar ulang, update foto) tidak disentuh.
- **Tes:** `SiteSeoTest` diperbarui untuk title baru dan schema `WebSite`; `HomePageTest` memastikan link foto/uang masuk tidak lagi muncul di homepage.

## File yang Dimodifikasi
| File | Perubahan |
|------|-----------|
| `resources/views/livewire/site/navbar.blade.php` | Teks brand kiri diganti logo `images/logo-navbar.webp` |
| `public/images/logo-navbar.webp` | Aset logo baru (hasil salin dari folder `logonavbar/`) |
| `app/Livewire/Site/Home.php` | Title dan description homepage sesuai permintaan |
| `resources/views/layouts/public.blade.php` | Tambah JSON-LD `WebSite` khusus route `home` |
| `resources/views/livewire/site/footer.blade.php` | Hapus 3 link layanan dari footer publik bersama |
| `tests/Feature/SiteSeoTest.php` | Assertion title baru + schema `WebSite` |
| `tests/Feature/HomePageTest.php` | Assertion homepage tanpa link foto/uang masuk |

## Hasil Validasi
- `php artisan test tests/Feature/SiteSeoTest.php` → **8 passed, 51 assertions**
- `php artisan test tests/Feature/SiteLivewireTest.php` → **29 passed, 102 assertions**
- `php artisan test tests/Feature/HomePageTest.php --filter="layanan utama"` → **1 passed, 5 assertions**
- `vendor/bin/pint --dirty` → lulus
- Verifikasi render homepage: title, description, `og:site_name`, canonical, serta dua JSON-LD (`EducationalOrganization` + `WebSite`) sesuai.
- Tidak menjalankan `npm run build` karena tidak ada perubahan CSS/JS.

## Catatan / Risiko
- Perubahan footer berlaku untuk **semua halaman publik** yang memakai `layouts.public`: Home, Berita (daftar/detail), Fasilitas, Guru, Kontak, PSB, Galeri Foto, dan Uang Masuk. Link layanan masih bisa diakses lewat URL langsung/admin; tombol **Cari Data Santri** di hero homepage tetap ada.
- Logo memiliki latar putih, sehingga di dark mode tampil sebagai kotak putih. Belum dibuat versi transparan.
- Full suite belum dijalankan ulang. Diketahui ada 1 test lama gagal di `HomePageTest` (`Hubungi kami melalui halaman kontak`) karena teks tersebut memang tidak ada di kode sejak HEAD — tidak terkait perubahan sesi ini.
- Belum di-push/deploy.

## Verifikasi Metadata Contoh Google Search — 26 Oktober 2026
- Memeriksa kode terbaru setelah perubahan sesi lain: title dan meta description homepage sudah persis sesuai contoh pengguna, og:site_name/canonical benar, JSON-LD WebSite berisi nama Pondok Pesantren Syafa'aturrasul, alternateName Syafaaturrasul, URL domain utama. EducationalOrganization tetap terpisah untuk alamat dan kontak.
- Menambahkan regresi DOM/JSON-LD untuk metadata persis, dua nomor telepon internasional, dan alamat Putri/Putra pada homepage serta halaman kontak. Memperbaiki assertion lama HomePageTest yang masih menunggu pesan kontak kosong, kini memeriksa kontak resmi.
- HomePageTest + SiteSeoTest: 21 passed, 169 assertions; Pint dirty lulus. Tidak mengubah metadata yang sudah sesuai atau perubahan pengguna pada .DS_Store. Tidak melakukan deploy atau pemeriksaan metadata produksi pada sesi ini.
- Menjelaskan bahwa nama situs, judul, dan snippet Google merupakan pilihan otomatis. Markup adalah preferensi/sinyal, bukan jaminan tampilan persis. Setelah deploy dapat meminta pengindeksan ulang homepage; Rich Results Test tidak mendukung validasi fitur site names, sesuai dokumentasi Google.

## Favicon Halaman Publik — 26 Oktober 2026
- Memasang favicon PNG dan apple-touch-icon menggunakan public/favicon.png yang sudah tersedia pada layouts.public. Berlaku untuk homepage dan halaman publik lain yang memakai layout tersebut; URL stabil tanpa query acak.
- Test memeriksa keberadaan file serta tag favicon pada homepage dan kontak. SiteSeoTest: 10 passed, 79 assertions; Pint dirty lulus. Tidak memerlukan build ulang CSS/JS. Belum deploy; pastikan favicon.png juga tersedia di public_html saat deploy hosting.

## Tautan Grup WhatsApp Setelah Pendaftaran — 26 Oktober 2026
- Mengganti tautan tombol “Masuk WA Grup Ponpes Syafa'aturrasul” pada tampilan pendaftaran berhasil ke undangan FMyYh8xiajs6YFDaZwCEmr dengan parameter s=cl&p=a&mlu=4&ilr=4 sesuai pengguna. Parameter dipertahankan dan ampersand di-escape untuk HTML.
- Tautan tetap membuka tab baru dengan noopener noreferrer. Tidak bergabung ke grup atau mengirim pesan.
- PendaftaranGroupLinkTest menjalankan submit dengan data/file palsu dan storage/database pengujian, memeriksa tautan hanya pada sukses, URL lengkap, serta tidak ada undangan lama: 1 passed, 8 assertions. Pint dirty lulus. Belum deploy.

## Kontrol Periode Penerimaan — 26 Oktober 2026
- Menambahkan empat pilihan tahap pada Pengaturan → Periode Pendaftaran: awal penerimaan (pendaftaran buka/daftar ulang tutup), keduanya buka, penerimaan calon baru selesai (pendaftaran tutup/daftar ulang buka), dan semua proses selesai (keduanya tutup). Pilih tahap lalu Simpan periode penerimaan.
- Tahap tersimpan di settings per tahun ajaran aktif. Tahun yang belum diatur mempertahankan perilaku sebelumnya: keduanya terbuka. Tidak mengubah database operasional atau memilih tahap atas nama admin. Pergantian tahun memuat pengaturan tahun tujuan; halaman admin lama tidak boleh menyimpan ke tahun yang telah berubah.
- Pembatasan diterapkan pada render formulir/list publik, URL langsung, submit pendaftaran, upload tahap pertama daftar ulang, dan submit akhir. Setting dibaca segar agar formulir yang sudah dibuka tidak dapat mengirim setelah periode ditutup. Data lama tetap tersimpan.
- Daftar ulang tetap menggunakan pending dan tahun ajaran aktif; ID Livewire dikunci. Tidak menambahkan aturan kelulusan/seleksi. Layout daftar ulang diperbaiki menjadi standalone karena layout default lama merujuk route dashboard yang tidak tersedia.
- AdmissionPeriodTest dan PendaftaranGroupLinkTest: 11 passed, 71 assertions, database SQLite memory dan data palsu. Pint dirty dan npm run build berhasil. Full suite tidak dijalankan. Belum push/deploy; build terbaru perlu ikut disalin ke public_html pada hosting sesuai alur deployment sebelumnya.

## Tombol Daftar Ulang pada Pencarian — 26 Oktober 2026
- Tombol Daftar Ulang di CariSiswaTable dan PendaftaranTable disembunyikan ketika periode daftar ulang ditutup (tahap awal penerimaan dan semua proses selesai), pada tabel desktop dan kartu mobile. Data hasil pencarian tetap tampil; aksi Update Foto untuk siswa tetap seperti sebelumnya.
- Status periode dibaca saat render, sehingga refresh/pencarian berikutnya mengikuti pengaturan terbaru. Proteksi akses langsung dan submit tetap menggunakan kontrol periode yang telah dibuat sebelumnya.
- AdmissionPeriodTest: 14 passed, 95 assertions, mencakup empat tahap pada kedua tabel dan kedua tampilan serta perubahan periode saat komponen sudah terbuka. Pint dirty lulus. Tidak ada perubahan CSS/JS baru; tidak perlu build tambahan. Belum push/deploy.

## Koneksi Laravel Boost ke Codex — 29 Oktober 2026
- Memastikan laravel/boost v1.8.0 terpasang; .mcp.json dan pedoman AGENTS.md sudah tersedia, tetapi belum ada entri Boost pada konfigurasi MCP Codex yang diperiksa.
- Menambahkan .codex/config.toml khusus project dengan command PHP absolut, artisan boost:mcp, cwd project, timeout startup 30 detik. CACHE_STORE=array diterapkan hanya pada proses MCP agar discovery tool tidak bergantung pada cache MySQL yang diblokir sandbox. Konfigurasi website/.env dan data santri tidak diubah.
- Validasi TOML berhasil; menjalankan transport JSON-RPC dari konfigurasi baru berhasil mengambil 16 tool dan menjalankan list-routes untuk home. Akses database dan search-docs daring belum diuji. Tool Boost belum terpasang pada katalog sesi chat berjalan; perlu memuat ulang aplikasi/sesi untuk memverifikasi integrasi penuh.
- CLI codex global yang tersedia mengalami ENOENT binary vendor, sehingga konfigurasi ditulis langsung sesuai dokumentasi resmi; tidak menginstal ulang atau mengubah CLI global.

## Verifikasi Boost Setelah Restart Codex — 29 Oktober 2026
- Namespace tool Laravel Boost sudah tersedia langsung pada sesi Codex setelah aplikasi dibuka ulang.
- Pemanggilan application-info berhasil: PHP 8.4.10, Laravel 12.37.0, Livewire 3.7.11, Flux 2.6.1, dan paket lainnya terbaca. list-routes dengan nama home juga berhasil, mengarah ke App\Livewire\Site\Home.
- Integrasi langsung terkonfirmasi untuk kedua tool tersebut. Belum menguji akses database atau pencarian dokumentasi daring; tidak mengubah kode aplikasi maupun data santri.

## Lingkaran Foto Guru Putih — 31 Oktober 2026
- Mengganti border hijau foto profil guru menjadi border putih dengan shadow-md pada homepage dan halaman daftar guru. Avatar inisial tanpa foto juga memakai latar putih dan shadow, termasuk mode gelap.
- SitePagesTest: 19 passed, 68 assertions. Pint dirty dan npm run build berhasil. Build terbaru disertakan; belum push/deploy. Perubahan konfigurasi/pedoman lain yang sudah ada tidak diubah.

## Panduan Foto Profil Guru — 31 Oktober 2026
- Form tambah/edit Profil Guru kini menggunakan komponen unggah bersama dengan rekomendasi 800 × 800 piksel (1:1), panduan wajah di tengah dan ruang kepala/hijab, serta template SVG 800 × 800 yang dapat diunduh dari public/images/template-foto-guru.svg. Panduan harus dihapus sebelum ekspor foto final JPG/PNG/WebP.
- Pratinjau foto lokal berbentuk lingkaran putih dengan shadow, object-cover/object-center sama seperti frontend. Menampilkan dimensi file dan keterangan pemotongan jika tidak persegi. Batas tetap 2 MB; tidak memaksa dimensi baru atau mengubah foto lama/file asli. Edit menampilkan foto tersimpan sebelum memilih foto pengganti.
- GuruAdminTest: 11 passed, 47 assertions; uji JavaScript dengan DOM simulasi untuk pemilihan foto, ukuran berlebih, dan pembatalan berhasil. Pint dirty dan build berhasil. Belum verifikasi visual browser, push, atau deploy. Saat deploy sertakan template SVG pada public_html/images bersama build terbaru.

## Keyboard Angka Kolom NIK Daftar Ulang — 31 Oktober 2026
- Menambahkan inputmode="numeric" pada NIK santri, NIK ayah, dan NIK ibu agar browser HP meminta keyboard angka. type="text" dan maxlength="16" tetap dipertahankan; tidak mengubah aturan validasi atau data.
- Test render form tahap kedua memeriksa atribut ketiga input: 1 passed, 12 assertions. Pint dirty lulus. Tidak memerlukan build CSS/JS. Belum push/deploy.

## Lebar Input Tanggal Lahir Pendaftaran — 31 Oktober 2026
- Membatasi input date pada form Pendaftaran dengan min-w-0, max-w-full, w-full, box-border dan block; wrapper juga min-w-0. appearance-none mengurangi perbedaan tampilan native browser, text-base dan min-h-12 menjaga ukuran input. Pemilih tanggal native tetap digunakan.
- PendaftaranGroupLinkTest: 2 passed, 17 assertions (submit dan atribut input). Pint dirty dan build berhasil. Belum verifikasi visual pada perangkat pelapor; belum push/deploy.

## Ringkasan Error Sebelum Kirim Pendaftaran — 31 Oktober 2026
- Menambahkan ringkasan seluruh pesan validasi tepat di atas tombol Kirim Pendaftaran. Pesan per kolom tetap tersedia. Ringkasan memakai role alert, judul yang jelas, daftar pesan, dan dukungan dark mode; hanya tampil saat ada error.
- PendaftaranGroupLinkTest: 3 passed, 30 assertions. Memeriksa error submit, isi ringkasan dan urutannya sebelum tombol, serta tidak tampil pada form awal/sukses. Pint dirty dan build berhasil. Belum push/deploy.

## Tombol Tambah Pendaftaran pada Halaman Berhasil — 31 Oktober 2026
- Mengubah grup tombol Beranda/Tambah Pendaftaran menjadi grid satu kolom di HP dan dua kolom sama lebar mulai sm. Tinggi minimal 48px, teks 14px, ikon tidak menyusut, dan menghapus efek membesar saat hover agar tombol tidak berdesakan.
- Tombol reset memakai type button dan nonaktif saat proses reset; tautan Beranda menggunakan named route home. Tidak mengubah proses penyimpanan pendaftaran.
- PendaftaranGroupLinkTest: 3 passed, 37 assertions; memeriksa struktur tombol pada hasil pendaftaran sukses. Pint dirty dan npm run build berhasil. Belum verifikasi visual perangkat pengguna atau push/deploy.

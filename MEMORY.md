# Memory Perubahan Project PPSR 2025 Putra

## Tanggal: 22 April 2026

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

| Role | Nama | Email | Password |
|------|------|-------|----------|
| 🟢 **MTs Putra** | Admin MTs Putra | `mtsputra@admin.com` | `password` |
| 🟣 **MTs Putri** | Admin MTs Putri | `mtsputri@admin.com` | `password` |
| 🔵 **MA Putra** | Admin MA Putra | `maputra@admin.com` | `password` |
| 🟠 **MA Putri** | Admin MA Putri | `maputri@admin.com` | `password` |
| 🔴 **Super Admin** | Admin PPSR | `admin@admin.com` | `password` |

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
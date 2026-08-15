# 🏫 Sistem PPDB Pondok Pesantren Syafa'aturrasul (PPSR 2026 Putra)

Sistem Pendaftaran Peserta Didik Baru (PPDB) berbasis web untuk Pondok Pesantren Syafa'aturrasul dengan **4 jenjang**: MTs Putra, MTs Putri, MA Putra, dan MA Putri.

Aplikasi ini menangani seluruh alur PPDB: **pendaftaran awal** (publik) → **daftar ulang** (upload dokumen + data lengkap) → **kelola data santri** (admin per jenjang) → **uang masuk** → **galeri foto santri** → **pencarian data santri** hingga **cetak rapor PDF**.

---

## 🧰 Teknologi & Framework

| Teknologi | Versi | Fungsi |
|-----------|-------|--------|
| **PHP** | ^8.2 (dev: 8.4) | Bahasa pemrograman |
| **Laravel** | 12.37 | Framework utama (Eloquent ORM, routing, middleware, migration, queue, storage) |
| **Livewire** | 3.x | Interaktivitas SPA-like tanpa JS framework (komponen server-rendered + DOM diffing via morphdom) |
| **Alpine.js** | 3.x | UI state reaktif client-side (`x-data`, `x-show`, `x-on`, `x-cloak`) |
| **Tailwind CSS** | 4.x | Utility-first styling + dark mode + animasi |
| **Vite** | 7.x | Build tool frontend (`@vite`, `npm run build/dev`) |
| **Laravel Fortify** | 1.30 | Autentikasi (login, registrasi, reset password, 2FA, verifikasi email) |
| **Laravel Sanctum** | 4.x | API token authentication (route `/api/user`) |
| **spatie/simple-excel** | 3.8 | Export data ke Excel (`.xlsx`) |
| **barryvdh/laravel-dompdf** | 3.1 | Generate PDF rapor |
| **Livewire Flux** | 2.x | Komponen UI (starter kit) |
| **Database** | MySQL (sqlite untuk test) | Penyimpanan data |

### Pola Interaksi Frontend-Backend

- **Livewire 3** menjadi tulang punggung interaktivitas: `wire:model.live` (realtime), `wire:click`, `wire:loading` (state loading), `wire:navigate` (SPA-like navigasi tanpa reload penuh).
- **Alpine.js** menangani hal-hal yang murni client-side: progress bar upload real-time (via `x-on:livewire-upload-*` dengan modifier `.window`), preview file, dan modal konfirmasi.
- **Upload file** memakai `WithFileUploads` trait Livewire — file di-upload ke temp storage, lalu dipindah ke `storage/app/public/` saat submit.

---

## 🏗️ Arsitektur & Keputusan Desain

### 1. Multi-Jenjang (4 Tabel Siswa)

Data siswa dipisah ke **4 tabel identik** berdasarkan jenjang:

```
mtsputras   → App\Models\Mtsputra   (MTs Putra)
mtsputris   → App\Models\Mtsputri   (MTs Putri)
maputras    → App\Models\Maputra    (MA Putra)
maputris    → App\Models\Maputri    (MA Putri)
```

- Setiap tabel memiliki struktur kolom yang sama (data pribadi, orang tua, wali, alamat, dokumen, foto).
- `nisn` diberi constraint **unique** per tabel.
- Mapping dari `Pendaftaran` ke model siswa ditangani oleh `Pendaftaran::getTargetModelClass()` / `getStudentType()` berdasarkan kolom `jenjang_pendidikan`.

### 2. Role-Based Access Control (RBAC)

Auth memakai **Fortify** (session) dengan **kolom `role`** pada tabel `users` (bukan package Spatie — migration `permission_tables` tidak terpakai).

| Role | Akses |
|------|-------|
| `admin` | Semua halaman admin + pengaturan + data pendaftaran |
| `mtsputra` / `mtsputri` / `maputra` / `maputri` | Hanya halaman CRUD jenjangnya masing-masing |

- **Middleware** `App\Http\Middleware\CheckRole` (`CheckRole:admin`, `CheckRole:mtsputra`, dst.) melindungi route admin.
- **Redirect setelah login** di `App\Http\Responses\LoginResponse` — diarahkan ke halaman sesuai role (menghindari 403 dari `intended()`).
- `User::hasRole()` + atribut dinamis `getJenjangAttribute()` untuk membatasi query per jenjang.

### 3. Sistem Pengaturan Tahun Ajaran

Sistem key-value di tabel `settings` (model `App\Models\Setting`) dengan **in-memory cache per request**:

- `tahun_ajaran_aktif` — tahun ajaran yang sedang berjalan.
- `header_image` — gambar header halaman pendaftaran (bisa di-upload dari admin).

Helper global `activeTahunAjaran()` (didaftarkan via `composer.json` → `autoload.files`) dipakai di seluruh halaman publik & admin sehingga **tahun ajaran tidak hardcoded**.

### 4. Sanitasi Input (Anti XSS)

Trait `App\Models\Concerns\SanitizesInput` dipakai di **4 model siswa** untuk strip HTML tags (`strip_tags`) pada field `nama`, `tempat_lahir`, `nama_kk`, `nama_ayah`, `nama_ibu`, `nama_wali` saat disimpan.

> Implementasi memakai **method-based Eloquent attribute** (mis. `nama()`, `namaKk()`) — bukan array `casts()` — karena sejak Laravel 12, nilai cast harus `Stringable` dan `Attribute::make()` di array `casts()` akan melempar exception.

---

## 📁 Struktur Direktori

```
app/
├── Actions/Fortify/          # CreateNewUser (registrasi), PasswordValidationRules, dll.
├── Http/
│   ├── Controllers/
│   │   ├── Admin/            # Mtsputra/Mtsputri/Maputra/Maputri/Pendaftaran Controller (CRUD + export)
│   │   ├── Api/              # Pendaftaran & 4 jenjang (resource API)
│   │   └── CetakRaporController.php
│   ├── Middleware/CheckRole.php
│   └── Responses/LoginResponse.php
├── Livewire/                 # Komponen publik (pendaftaran, daftar ulang, cari siswa, foto, uang masuk, update foto)
│   └── Admin/                # Dashboard, tabel 4 jenjang, pendaftaran, settings
├── Models/                   # Mtsputra/Mtsputri/Maputra/Maputri/Pendaftaran/User/Setting/Guru/Kelas/dll.
│   └── Concerns/SanitizesInput.php
├── helpers.php               # activeTahunAjaran()
database/
├── migrations/               # Schema semua tabel
└── seeders/                  # UserSeeder + DatabaseSeeder (setting default)
resources/
├── views/
│   ├── admin/                # Layout admin + view CRUD (index/create/edit/show) per jenjang
│   ├── layouts/standalone.blade.php   # Layout publik full-page (tanpa sidebar)
│   ├── livewire/             # View semua komponen Livewire
│   └── pdf/rapor.blade.php   # Template PDF rapor
routes/
├── web.php                   # Route publik + admin
└── api.php                   # Route API
```

---

## 🔐 Role & Matriks Akses

| Halaman | `admin` | `mtsputra` | `mtsputri` | `maputra` | `maputri` | Tamu |
|---|:---:|:---:|:---:|:---:|:---:|:---:|
| Beranda / Cari Siswa | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |
| Pendaftaran (`/pendaftaran`) | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |
| Daftar Ulang (`/daftar-ulang*`) | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |
| Galeri Foto (`/foto`) | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |
| Uang Masuk (`/uangmasuk`) | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |
| Dashboard (`/admin`) | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| CRUD jenjangnya | ✅ | ✅ (hanya mtsputras) | ✅ (hanya mtsputris) | ✅ (hanya maputras) | ✅ (hanya maputris) | ❌ |
| Data Pendaftaran | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| Pengaturan | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| Cetak Rapor | ✅ (butuh login) | ✅ | ✅ | ✅ | ✅ | ❌ |

---

## 🗄️ Skema Database (Ringkas)

| Tabel | Keterangan |
|-------|-----------|
| `users` | Akun login (kolom `role`: admin/mtsputra/mtsputri/maputra/maputri) |
| `pendaftarans` | Data pendaftaran awal + status (`pending` → `completed`), data orang tua/wali, upload bukti transfer, status bayar uang masuk (`status_bayar_uang_masuk`), `student_id` + `student_type` (relasi polimorfik ke 4 tabel siswa) |
| `mtsputras`, `mtsputris`, `maputras`, `maputris` | Data lengkap santri per jenjang (data pribadi, ayah, ibu, wali, alamat, sekolah sebelumnya, dokumen `fotokk`/`fotoakta`/`fototransfer`, `foto`, `kelas_id`) |
| `settings` | Key-value: `tahun_ajaran_aktif`, `header_image` |
| `kelas`, `gurus`, `mata_pelajarans`, `pengajarans`, `nilais` | Modul akademik (belum dipakai di alur PPDB utama, dipakai oleh Cetak Rapor) |
| `personal_access_tokens` | Token Sanctum |

### Alur Data Pendaftaran → Santri

```
pendaftarans (status=pending)
        │  Daftar Ulang berhasil (DaftarUlangForm::submit)
        ▼
tabel siswa per jenjang (baris baru dibuat)
        │
        ▼
pendaftarans (status=completed, student_id & student_type terisi)
```

---

## 🔄 Alur Aplikasi (Detail)

### 1. Pendaftaran Awal (Publik) — `/pendaftaran`

Komponen: `App\Livewire\PendaftaranForm` | View: `livewire.pendaftaran-form` | Layout: `standalone`

1. Calon santri mengisi form singkat: NISN, nama, jenjang (MTs/MA Putra/Putri), TTL, asal sekolah, alamat, nama ayah/ibu, no HP, dan **upload bukti transfer** (PDF/JPG/PNG, max 2MB).
2. `tahun_ajaran` diisi otomatis dari `activeTahunAjaran()`.
3. Header halaman bisa dikustomisasi lewat Pengaturan (`header_image`).
4. Data disimpan ke tabel `pendaftarans` dengan status **`pending`**, file ke `storage/app/public/pendaftaran/`.

### 2. Daftar Ulang (Publik) — `/daftar-ulang` & `/daftar-ulang/{id}`

Komponen: `App\Livewire\DaftarUlangTable` (tabel pencarian) & `DaftarUlangForm` | View: `livewire.daftar-ulang-form` | Layout: `standalone`

Tabel menampilkan pendaftaran berstatus `pending` pada tahun ajaran aktif, bisa dicari per nama/NISN/tempat lahir.

Form **2 langkah**:

**Step 1 — Upload Bukti Transfer**
- Wajib upload bukti transfer (PDF/JPG/JPEG/PNG, max 2MB).
- Progress bar real-time (Alpine `x-on:livewire-upload-*`), tombol di-disable selama upload, indicator sukses.
- File tersimpan ke `storage/app/public/dokumen-siswa/transfer/TRANSFER_{NISN}_{Nama}_{Timestamp}.{ext}`.

**Step 2 — Form Data Lengkap**
- Field: data pribadi (nama, TTL, NIK 16 digit, KK, NISN 10 digit, anak ke-, jumlah saudara), sekolah sebelumnya, data ayah/ibu/wali (NIK, TTL, pendidikan, pekerjaan, penghasilan), alamat (desa/kec/kab/prov/RT/RW).
- Auto-set: jika pekerjaan "Tidak Bekerja" → penghasilan otomatis "Tidak Ada".
- Upload wajib: **KK**, **Akta** (PDF/JPG/PNG, 2MB), dan **Pas Photo** (JPG/PNG, 2MB) — masing-masing dengan progress bar + preview.
- Error Summary Box merah menampilkan semua error validasi sebelum disimpan.
- Submit memakai `DB::transaction`: upload KK/Akta/Foto → buat baris di tabel siswa sesuai jenjang → update `pendaftarans` jadi `completed` + isi `student_id`/`student_type`.
- Halaman sukses dengan pesan terima kasih.

**Struktur storage:**
```
storage/app/public/dokumen-siswa/
├── transfer/  TRANSFER_{NISN}_{Nama}_{Timestamp}.{ext}
├── kk/        KK_{NISN}_{Nama}_{Timestamp}.{ext}
└── akta/      AKTA_{NISN}_{Nama}_{Timestamp}.{ext}
storage/app/public/foto/  FOTO_{NISN}_{Nama}_{Timestamp}.{ext}
```

### 3. Cari Siswa (Beranda Publik) — `/`

Komponen: `App\Livewire\CariSiswaTable` | View: `livewire.cari-siswa-table`

- Pencarian real-time (`wire:model.live.debounce.300ms`) berdasarkan **nama / NISN / NIK**.
- Mencari di 5 sumber: 4 tabel siswa (filter tahun ajaran aktif) + tabel `pendaftarans` berstatus `pending`.
- Hasil: tabel di desktop, card di mobile. Status foto (ada/pending/tidak ada).
- Aksi: pendaftaran pending → tombol **Daftar Ulang**; siswa existing → tombol **Update Foto**.

### 4. Update Foto Mandiri (Publik) — `/update-foto/{type}/{id}`

Komponen: `App\Livewire\UpdateFotoForm` | View: `livewire.update-foto-form` | Layout: `standalone`

1. Tampilkan foto saat ini (atau placeholder inisial).
2. Upload foto baru (JPG/PNG, max 2MB) dengan progress bar + preview (`temporaryUrl()`).
3. Simpan → hapus foto lama, simpan ke `storage/app/public/foto/`, update kolom `foto`.
4. Halaman sukses dengan preview foto final + tombol kembali ke beranda.

### 5. Galeri Foto Santri (Publik) — `/foto`

Komponen: `App\Livewire\FotoTable` | View: `livewire.foto-table` | Layout: `standalone`

- Card grid (1–4 kolom responsif) menampilkan foto, nama, NISN, TTL, alamat, badge jenjang per santri pada tahun ajaran aktif.
- Filter: search (nama/NISN) + dropdown jenjang. Pagination manual 15/halaman (collect → slice → `LengthAwarePaginator`).
- Tombol **download foto** (muncul saat hover), badge "Ada Foto" / "Belum Ada Foto".

### 6. Uang Masuk (Publik) — `/uangmasuk`

Komponen: `App\Livewire\UangMasukTable` | View: `livewire.uang-masuk-table` | Layout: `standalone`

- Tabel pendaftaran dengan search, filter tahun ajaran & jenjang, sortable kolom, perPage (15/25/50/100).
- Menampilkan status bayar uang masuk; badge status **`pending` disembunyikan** (hanya tampil `lunas`/`rejected`/`uploaded`/`verified`).
- Dari sidebar admin, halaman ini dibuka `target="_blank"`.

### 7. Dashboard Admin — `/admin`

Komponen: `App\Livewire\Admin\Dashboard` | View: `livewire.admin.dashboard` | Layout: `admin.layout`

- Statistik jumlah santri per jenjang + jumlah pendaftaran (total & pending).
- Banner menampilkan tahun ajaran aktif.
- Daftar 10 pendaftaran terbaru + 5 santri terbaru per jenjang.

### 8. CRUD Data Siswa per Jenjang — `/admin/{jenjang}/*`

- **Livewire table** (`Admin\MtsputrasTable`, dst.) untuk index: search, filter tahun ajaran, dropdown perPage (15/25/50/100), foto profil + inisial sebagai avatar, kolom NISN/NIK.
- **Controller** (`Admin\MtsputraController`, dst.) untuk create/show/edit/delete:
  - Form lengkap (data pribadi → orang tua → wali → alamat → dokumen → foto profil).
  - Upload `fotokk`/`fotoakta`/`fototransfer`/`foto` ke `storage/app/public/documents/{jenjang}/`; file lama dihapus saat update/delete.
  - Export Excel (`SimpleExcelWriter::streamDownload`).
- Warna khas per jenjang: MTs Putra = **emerald**, MTs Putri = **pink**, MA Putra = **blue**, MA Putri = **purple**.

### 9. Data Pendaftaran Admin — `/admin/pendaftarans` (hanya admin)

Komponen: `App\Livewire\Admin\PendaftaransTable` + `Admin\PendaftaranController`

- Tabel dengan search, filter **tahun ajaran / status / jenjang**, sortable, perPage, kolom: foto, nama, NISN, jenjang, asal sekolah, **Tgl. Daftar (WIB)**, status, uang masuk, aksi.
- **Edit inline nominal uang masuk** (`bayar_uang_masuk`) via Alpine (klik → input → enter/blur → simpan).
- **Tombol WhatsApp** — pesan otomatis berisi data pendaftaran ke `wa.me/6285259875754` (helper `PendaftaransTable::waUrl()`).
- **Export Excel** dengan filter aktif (hasil disimpan ke `storage/app/public/temp/` lalu di-download, file lama >1 jam dibersihkan).
- Konfirmasi hapus via modal + cleanup file terkait.
- CRUD penuh via controller untuk admin (create/edit/show dengan 10 section form, upload bukti transfer uang masuk `bukti_transfer_uang_masuk`).

### 10. Pengaturan Admin — `/admin/settings`

Komponen: `App\Livewire\Admin\Settings` | View: `livewire.admin.settings` | Layout: `admin.layout`

- **Tahun Ajaran Aktif** — dropdown (2025/2026 s.d. 2032/2033), disimpan ke `settings.tahun_ajaran_aktif`. Semua halaman otomatis memakainya.
- **Header Image Pendaftaran** — upload gambar (JPG/JPEG/PNG/WebP, max 2MB, rekomendasi 1600×400px) ke `storage/app/public/settings/`, preview live, tombol reset ke default (`images/psb.webp`).

### 11. Cetak Rapor PDF — `/cetak-rapor/generate` (butuh login)

`App\Http\Controllers\CetakRaporController` + `barryvdh/laravel-dompdf`

- Input: `siswa_id`, `siswa_type`, `semester`, `tahun_ajaran`.
- Mengambil nilai (Pengetahuan/Keterampilan/Sikap) dari tabel `nilais` per mata pelajaran, menghitung rata-rata & predikat (A–E), lalu men-download PDF (`pdf.rapor`).

### 12. API — `/api/*` (Sanctum)

| Route | Fungsi | Auth |
|-------|--------|------|
| `GET /api/user` | Data user terautentikasi | `auth:sanctum` |
| `GET/POST/PUT/DELETE /api/pendaftaran`, `/api/mtsputra`, `/api/mtsputri`, `/api/maputra`, `/api/maputri` | Resource API CRUD + filter (`search`, `tahun_ajaran`, `per_page`) | ⚠️ **belum ada auth** |

---

## 🎨 Design System

### Layout

- **`resources/views/layouts/standalone.blade.php`** — layout publik: full-page, tanpa sidebar, `bg-white`, dipakai semua halaman Livewire publik (`#[Layout('layouts.standalone')]` atau `->layout()`).
- **`resources/views/admin/layout.blade.php`** — layout admin: **sidebar gradient emerald** (desktop) + menu hamburger (mobile), `wire:navigate` untuk navigasi SPA-like, icon SVG inline, active state `bg-white/20 shadow-lg`.

### Gaya Visual

- **Tailwind CSS 4** — utility-first, konfigurasi via CSS (`@theme` di `resources/css/app.css`).
- **Dark mode** — hampir semua komponen publik mendukung `dark:` variant.
- **Kartu** — card putih dengan `rounded-2xl`, shadow lembut (`shadow-sm` → `shadow-xl` saat hover), border zinc/gray.
- **Gradient** — header hero memakai gradient per konteks (emerald hijau untuk PPDB, sky/blue untuk galeri foto, dll).
- **Font** — Instrument Sans (via fonts.bunny.net) + `@fluxAppearance`.
- **Animasi kustom** — `animate-fadeIn`, `animate-spin`, `animate-pulse`, `animate-bounce`, progress bar upload dengan gradient.
- **CSS `[x-cloak]`** — mencegah flash konten sebelum Alpine siap.
- **Badge status** — warna per status: pending (kuning), lunas (hijau), rejected (merah), dst.
- **Avatar** — foto profil lingkaran `rounded-full object-cover`; fallback inisial nama berwarna sesuai jenjang.

### Komponen UI

- **Blade components** (`resources/views/components/`) — misal `x-detail-item` untuk halaman detail.
- **Livewire Flux** — komponen UI bawaan starter kit.
- **Ikon** — SVG inline (tidak memakai icon library eksternal).

---

## 🚀 Instalasi & Setup

```bash
# 1. Install dependency
composer install
npm install

# 2. Konfigurasi environment
cp .env.example .env
php artisan key:generate
# → isi DB_CONNECTION, DB_DATABASE, dll. di .env

# 3. Migrasi & seed
php artisan migrate
php artisan db:seed

# 4. Storage link (agar file upload bisa diakses via /storage)
php artisan storage:link

# 5. Build asset (atau `npm run dev` saat development)
npm run build

# 6. Jalankan
php artisan serve
```

> 💡 Saat development, bisa pakai `composer dev` (menjalankan server, queue, pail, dan vite sekaligus).

### Akun Default (dari `database/seeders/UserSeeder.php`)

| Role | Email | Password |
|------|-------|----------|
| 🔴 **Super Admin** | `admin@ppsr.local` | `password` |
| 🟢 **MTs Putra** | `mtsputra@admin.com` | `123ppsr` |
| 🟣 **MTs Putri** | `mtsputri@admin.com` | `123ppsr` |
| 🔵 **MA Putra** | `maputra@admin.com` | `123ppsr` |
| 🟠 **MA Putri** | `maputri@admin.com` | `123ppsr` |

> ⚠️ Ganti password default sebelum digunakan secara publik.

---

## 🗺️ Daftar Route Utama

### Publik (tanpa login)

| Method | URL | Nama | Komponen/Controller |
|--------|-----|------|---------------------|
| GET | `/` | `home` | `welcome` (Cari Siswa) |
| GET | `/pendaftaran` | `pendaftaran` | `PendaftaranForm` |
| GET | `/daftar-ulang` | `daftar-ulang.table` | `DaftarUlangTable` |
| GET | `/daftar-ulang/{id}` | `daftar-ulang.form` | `DaftarUlangForm` |
| GET | `/update-foto/{type}/{id}` | `update-foto.form` | `UpdateFotoForm` |
| GET | `/foto` | `foto.index` | `FotoTable` |
| GET | `/uangmasuk` | `uangmasuk.index` | `UangMasukTable` |
| GET | `/cetak-rapor/generate` | `cetak-rapor.generate` | `CetakRaporController` (butuh `auth`) |

### Admin (login + `verified`, prefix `/admin`)

| URL | Role | Keterangan |
|-----|------|-----------|
| `/admin` | admin | Dashboard |
| `/admin/mtsputras*` | admin, mtsputra | CRUD MTs Putra + export |
| `/admin/mtsputris*` | admin, mtsputri | CRUD MTs Putri + export |
| `/admin/maputras*` | admin, maputra | CRUD MA Putra + export |
| `/admin/maputris*` | admin, maputri | CRUD MA Putri + export |
| `/admin/pendaftarans*` | admin | Data pendaftaran + export |
| `/admin/settings` | admin | Pengaturan tahun ajaran & header |

### API (prefix `/api`)

| Route | Keterangan |
|-------|-----------|
| `/api/user` | User terautentikasi (Sanctum) |
| `/api/pendaftaran`, `/api/mtsputra`, `/api/mtsputri`, `/api/maputra`, `/api/maputri` | Resource CRUD |

---

## 💾 Struktur File Upload

```
storage/app/public/
├── pendaftaran/           # Bukti transfer pendaftaran awal
├── dokumen-siswa/
│   ├── transfer/          # Bukti transfer daftar ulang
│   ├── kk/                # Kartu Keluarga
│   └── akta/              # Akta kelahiran
├── foto/                  # Pas photo (daftar ulang & update foto mandiri)
├── documents/{jenjang}/   # Dokumen + foto dari admin (mtsputra/mtsputri/maputra/maputri)
├── settings/              # Header image dari pengaturan
└── temp/                  # Export Excel sementara (dibersihkan >1 jam)
```

---

## ⚠️ Catatan & Rekomendasi

- **API `/api/*` belum diproteksi auth** — siapa pun bisa membaca/mengubah data via API. Disarankan menambah `auth:sanctum` sebelum live.
- **Registrasi publik aktif** (`Features::registration()`) dengan default role `admin` di migration — sebaiknya dimatikan atau ubah default role sebelum dipakai publik.
- Route publik seperti `/update-foto/{type}/{id}` dan `/daftar-ulang/{id}` tidak memerlukan login (by design, tapi perhatikan risiko penyalahgunaan).
- Struktur 4 tabel siswa identik menduplikasi banyak kode — opsi refactor jangka panjang: polymorphic relation atau single table + kolom `jenjang`.
- `APP_DEBUG=true` dan `APP_ENV=local` di `.env` — pastikan diganti di production.

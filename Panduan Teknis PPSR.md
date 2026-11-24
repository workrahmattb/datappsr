---
tags: [ppsr, arsitektur, deploy]
---

# Panduan teknis PPSR

Ditinjau 24 November 2026. Mulai dari [[MULAI-DI-SINI]] dan [[Alur Proyek PPSR]]. Riwayat keputusan tersimpan di [[MEMORY]].

## Peta kode dan pengujian

| Area | Titik masuk kode | Tes rujukan |
|---|---|---|
| Pendaftaran dan bukti awal | app/Livewire/PendaftaranForm.php | tests/Feature/PendaftaranGroupLinkTest.php |
| Periode penerimaan | app/Support/AdmissionPeriod.php | tests/Feature/AdmissionPeriodTest.php |
| Daftar ulang | app/Livewire/DaftarUlangForm.php | tests/Feature/AdmissionPeriodTest.php |
| Pencarian | app/Livewire/CariSiswaTable.php | tests/Feature/CariSiswaTableTest.php |
| Keterangan dan export admin | app/Livewire/Admin/PendaftaransTable.php | tests/Feature/PendaftaranKeteranganTest.php |
| Situs publik | app/Livewire/Site | tests/Feature/SitePagesTest.php |
| SEO | app/Http/Controllers/SitemapController.php | tests/Feature/SiteSeoTest.php |
| Aset gambar | app/Support/ResponsiveImage.php | tests/Feature/SitePerformanceTest.php |
| CRUD konten | app/Http/Controllers/Admin | tests/Feature/BeritaAdminTest.php, tests/Feature/GuruAdminTest.php, tests/Feature/FasilitasAdminTest.php, tests/Feature/KontakAdminTest.php |
| Akun dan login | app/Actions/Fortify | tests/Feature/Auth |

Tes rujukan membantu memulai pemeriksaan. Baca kasusnya untuk mengetahui cakupan yang sudah ada. Tampilan mengikuti resources/views, rute web ada di routes/web.php, rute API di routes/api.php, dan struktur tabel ada di database/migrations.

## Data dan status

- Pendaftaran menyimpan data awal pada pendaftarans. Setelah daftar ulang, student_type dan student_id menunjuk data santri di salah satu tabel jenjang.
- Mtsputra, Mtsputri, Maputra dan Maputri memakai tabel terpisah. getTargetModelClass dan getStudentType pada app/Models/Pendaftaran.php menentukan mapping tujuan.
- pending menandai pendaftaran yang belum selesai daftar ulang. completed menandai data santri telah dibuat melalui alur daftar ulang. Aturan kelulusan tersendiri ditunda.
- Setting memakai key-value. AdmissionPeriod membaca tahun_ajaran_aktif dan admission_stage_ diikuti tahun ajaran. Matriks tahap ada di [[Alur Proyek PPSR#Penerimaan dan daftar ulang]].
- Keterangan tersimpan pada pendaftarans.keterangan, maksimal 2.000 karakter. Nilai kosong menjadi null dan baris baru dipertahankan dalam export.
- Berita, Fasilitas, FasilitasFoto, Guru, Kontak dan Carousel menyediakan data situs publik. Periksa app/Models untuk definisi relasi saat mengubah modul tersebut.

## Akses

Grup admin di routes/web.php memakai auth dan verified serta pemeriksaan peran melalui app/Http/Middleware/CheckRole.php. Peran admin dapat mengakses kelompok jenjang. Pengguna jenjang mengikuti kelompok rute masing-masing. Aksi Livewire perlu diperiksa tersendiri karena dapat dipanggil langsung.

Dalam routes/api.php, auth:sanctum hanya dipasang pada /api/user. Resource pendaftaran dan empat jenjang dideklarasikan tanpa middleware autentikasi pada rute tersebut. Halaman /foto, /uangmasuk dan form publik berada di luar grup admin.

## Upload dan aset

| Data | Lokasi atau kolom |
|---|---|
| Bukti awal | buktitransfer, disk public, folder pendaftaran |
| Transfer daftar ulang | fototransfer, folder dokumen-siswa/transfer |
| KK dan akta daftar ulang | fotokk dan fotoakta, folder dokumen-siswa/kk dan dokumen-siswa/akta |
| Foto form publik | foto, folder foto |
| Export tabel pendaftaran | disk public, folder temp |
| Build produksi | public/build/manifest.json dan public/build/assets |

Disk public berakar di storage/app/public sesuai config/filesystems.php. Database menyimpan path relatif. Upload melalui controller admin dapat memakai folder berbeda. Periksa aksi terkait sebelum mengubah penyimpanan berkas.

## Pengujian lokal

Feature tests memakai RefreshDatabase melalui tests/Pest.php. Gunakan database pengujian terpisah. Contoh dari akar proyek

```bash
APP_ENV=testing DB_CONNECTION=sqlite DB_DATABASE=:memory: php artisan test tests/Feature/PendaftaranKeteranganTest.php
vendor/bin/pint --dirty
```

Untuk perubahan tampilan atau CSS, jalankan npm run build. Pemeriksaan browser dibutuhkan untuk interaksi visual yang belum tercakup tes. Catat hasil dan keterbatasannya di MEMORY.md.

## Deploy hosting

| Lokasi | Path |
|---|---|
| Checkout hosting | /home/ppsyafaa/datappsr |
| Folder publik | /home/ppsyafaa/public_html |

Alur rilis mengikuti lokal → commit dan push → pull hosting → migrasi bila diperlukan → sinkronisasi aset → pemeriksaan website.

1. Periksa git status dan diff lokal, jalankan tes terkait dan build. Commit file yang termasuk perubahan, lalu push.
2. Di checkout hosting, periksa git status --short. Identifikasi perubahan lokal sebelum pull agar dapat dipertahankan.
3. Sebelum perubahan schema produksi, siapkan backup database melalui fasilitas hosting.
4. Untuk rilis schema, gunakan php artisan down, kemudian git pull --ff-only origin main. Periksa migrasi tertunda dan jalankan migrasi yang diperlukan.
5. Salin aset terlebih dahulu, kemudian manifest. Bersihkan view cache dan jalankan php artisan up setelah langkah sebelumnya berhasil.
6. Periksa fitur di hosting dan catat commit, tanggal, hasil migrasi serta hasil pengujian website.

Penyalinan build dijalankan dari /home/ppsyafaa/datappsr

```bash
mkdir -p /home/ppsyafaa/public_html/build/assets
cp -a public/build/assets/. /home/ppsyafaa/public_html/build/assets/
cp public/build/manifest.json /home/ppsyafaa/public_html/build/manifest.json
php artisan view:clear
```

Jika rilis menyertakan gambar baru, salin gambar terkait ke public_html/images. Tentukan langkah Composer serta cache konfigurasi berdasarkan perubahan rilis. Migrasi fitur Keterangan adalah database/migrations/2026_11_18_165032_add_keterangan_to_pendaftarans_table.php.

## Diagnosis dan pemulihan

| Gejala | Pemeriksaan |
|---|---|
| CSS hilang | Cocokkan manifest dan keberadaan aset di public_html/build/assets. |
| Bukti transfer tidak terbuka | Cocokkan buktitransfer dengan storage/app/public dan pemetaan public_html/storage. |
| Unknown column keterangan | Periksa status migrasi kolom pada database aplikasi. |
| Catatan belum masuk export | Pastikan Tersimpan sudah muncul dan filter export sesuai. |
| MySQL Connection refused | Periksa layanan MySQL dan host/port lingkungan yang dipakai. |

Jika deploy gagal, simpan output error dan commit aktif. Periksa kompatibilitas schema sebelum mengembalikan kode. Pemulihan database menggunakan backup yang diverifikasi perlu mempertimbangkan data baru sejak backup dibuat.

## Status verifikasi

Enam tes pendaftaran lulus dengan 68 assertion pada 19 November 2026, disertai build produksi. Ini hasil pengujian pada tanggal tersebut. Konfirmasi migrasi dan deploy hosting belum tersedia dalam catatan. Docker tetap opsi yang ditangguhkan dan image belum terverifikasi.

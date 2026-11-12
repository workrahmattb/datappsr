---
tags: [ppsr, arsitektur]
aliases: ["Alur PPSR"]
---

# Alur proyek PPSR

Buka [[Peta PPSR.canvas]] untuk melihat gambaran visual. Untuk memahami satu proses, ikuti bagian di bawah dari halaman yang digunakan, aturan yang berlaku, lalu file yang menjalankannya.

## Situs publik

Pengunjung masuk melalui `/` untuk mengenal pondok. Dari navigasi mereka dapat membaca berita, melihat fasilitas dan guru, membuka kontak, atau masuk ke `/psb` untuk penerimaan. Daftar berita berada di `/berita` dan setiap artikel dibuka melalui `/berita/{slug}`. Google membaca daftar URL dari `/sitemap.xml`.

**Telusuri kode:** Mulai di `routes/web.php`. Halaman publik menggunakan komponen di `app/Livewire/Site` dan tampilan di `resources/views/livewire/site`. Untuk sitemap, lihat `app/Http/Controllers/SitemapController.php`. Pengujian terkait ada di `tests/Feature/SitePagesTest.php` dan `tests/Feature/SiteSeoTest.php`.

## Penerimaan dan daftar ulang

1. **Admin memilih tahap untuk tahun ajaran aktif.** Pengaturan di `/admin/settings` menentukan dua hal berikut melalui `app/Support/AdmissionPeriod.php`.

   | Tahap | Pendaftaran awal | Daftar ulang |
   |---|---|---|
   | Awal penerimaan | Buka | Tutup |
   | Keduanya dibuka | Buka | Buka |
   | Penerimaan calon baru selesai | Tutup | Buka |
   | Semua proses selesai | Tutup | Tutup |

2. **Calon santri mendaftar.** Dari `/psb`, calon santri membuka `/pendaftaran`. Komponen `app/Livewire/PendaftaranForm.php` memvalidasi isian dan menyimpan data awal ke model `Pendaftaran`. Halaman berhasil menyediakan tautan grup dan tombol kembali ke PSB.
3. **Keluarga mencari pendaftar.** Lihat `app/Livewire/CariSiswaTable.php` untuk pencarian. Saat daftar ulang ditutup, aksi pengisian tidak tersedia. Membuka periode memberi akses pengisian. Keputusan kelulusan tersendiri masih ditunda.
4. **Pendaftar melengkapi berkas.** Form `/daftar-ulang/{id}` ditangani oleh `app/Livewire/DaftarUlangForm.php`. Saat mengirim setiap tahap, komponen memeriksa periode, tahun ajaran aktif dan status `pending`. Tahap pertama menyimpan bukti transfer. Tahap kedua melengkapi data santri, keluarga dan dokumen.
5. **Data masuk ke jenjang yang dituju.** Saat penyimpanan akhir berhasil, `app/Models/Pendaftaran.php` menentukan model tujuan. Form membuat data di `Mtsputra`, `Mtsputri`, `Maputra`, atau `Maputri` sesuai jenjang. Dalam transaksi database yang sama, pendaftaran menyimpan `student_id`, `student_type` dan berubah menjadi `completed`. Status ini menandai daftar ulang selesai. Tombol kembali mengarah ke `/psb`.

**Tes rujukan:** `tests/Feature/AdmissionPeriodTest.php` untuk periode dan `tests/Feature/CariSiswaTableTest.php` untuk pencarian.

## Administrasi dan pengelolaan konten

Rute `/admin` memakai grup middleware `auth` dan `verified`. Pemeriksaan peran ada di `app/Http/Middleware/CheckRole.php`. Admin dapat mengakses semua kelompok jenjang. Pengguna dengan peran jenjang mengikuti kelompok rute yang sesuai, misalnya `/admin/mtsputras` untuk MTs Putra.

| Kebutuhan | Jalur di aplikasi | Titik awal di kode |
|---|---|---|
| Memeriksa data awal calon santri | Daftar pendaftaran admin | `app/Livewire/Admin/PendaftaransTable.php` |
| Mengelola dan mengekspor data santri | Tabel masing-masing jenjang | `routes/web.php` → controller jenjang di `app/Http/Controllers/Admin` |
| Mengubah isi situs | Admin mengelola berita, fasilitas, guru, kontak dan carousel. Halaman publik membaca data modul terkait. | Daftar di `app/Livewire/Admin`, aksi simpan di `app/Http/Controllers/Admin`, model di `app/Models` |
| Menyesuaikan periode dan kontak lembaga | Pengaturan admin | `app/Livewire/Admin/Settings.php` dan `app/Livewire/Admin/KontakLembagaSettings.php` |

## Menelusuri perubahan

Untuk masalah tampilan, mulai dari URL di `routes/web.php`, ikuti komponen Livewire ke tampilan Blade, lalu cari tes fitur yang sesuai. Untuk perubahan data, ikuti aksi simpan ke model di `app/Models` dan struktur tabel di `database/migrations`. Jalur API terpisah dideklarasikan di `routes/api.php`; `bootstrap/app.php` mendaftarkan rute web dan API.

Alur rilis yang digunakan adalah lokal → Git push → Git pull di hosting → sinkronisasi aset publik. Jika tampilan lokal benar tetapi CSS atau gambar hilang setelah deploy, periksa kesesuaian aset di dua lokasi hosting yang tercantum di [[MULAI-DI-SINI#Keputusan yang tetap berlaku]]. Modul Rapor ditangguhkan dan Docker merupakan opsi lokal.

Untuk melanjutkan pekerjaan, baca [[AGENTS]] dan entri terbaru [[MEMORY]]. Perbarui catatan alur ini ketika rute, aturan periode, peran, atau penyimpanan data berubah.

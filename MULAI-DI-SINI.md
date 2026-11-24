---
aliases: ["Serah terima PPSR"]
tags: [ppsr]
---

# Mulai di sini — Proyek PPSR

Vault ini adalah folder proyek Laravel yang sama. [[MEMORY]] menyimpan keputusan dan riwayat perubahan; [[AGENTS]] memuat aturan teknis. Keduanya bisa dibaca langsung dari repositori tanpa Obsidian.

Buka [[Peta PPSR.canvas]] untuk melihat hubungan antarmodul. Baca [[Alur Proyek PPSR]] untuk menelusuri langkah pengguna, aturan dan file sumber.

## Saat mengambil alih pekerjaan

1. Baca bagian pembuka MEMORY.md, lalu entri terbaru di bagian bawah. Cari juga riwayat fitur yang hendak diubah. Bila catatan lama berbeda dengan keputusan terbaru, periksa tanggal dan kode saat ini.
2. Periksa status Git dan perubahan lokal sebelum mengedit. Telusuri rute di `routes/web.php`, implementasi dan pengujian terkait; jangan menganggap perubahan lokal sudah terpasang di hosting.
3. Setelah perubahan, tambahkan entri bertanggal ke MEMORY.md: apa yang berubah, bagaimana diuji, apa yang belum terverifikasi, dan langkah berikutnya. Perbarui indeks ini bila keputusan kerja berubah.

## Keputusan yang tetap berlaku

- Halaman utama sekolah berada di `/`; portal penerimaan dan pencarian pendaftar berada di `/psb`. Domain resmi: `ppsyafaaturrasul.com`.
- Periode pendaftaran dan daftar ulang dapat dibuka atau ditutup secara terpisah. Saat daftar ulang ditutup, aksi pengisian dari pencarian tidak tersedia. Membuka periode bukan keputusan kelulusan; aturan kelulusan tersendiri ditunda.
- Modul Rapor ditangguhkan. Docker juga opsional; konfigurasi Compose pernah diperiksa tetapi image belum berhasil diuji. Jangan menjadikannya syarat kerja.
- Hosting memakai Git pull di `/home/ppsyafaa/datappsr`. Aset publik disajikan dari `/home/ppsyafaa/public_html`: saat deploy, pastikan manifest, berkas CSS/JS yang dirujuk, dan gambar baru tersedia bersama. Riwayat insiden: [[MEMORY#Pemeriksaan Insiden CSS Setelah Deploy — 25 Oktober 2026]].
- Gunakan instruksi dan pengujian proyek di AGENTS.md. Simpan catatan tanpa kredensial, isi .env, atau data pribadi pendaftar.

## Urutan baca AI

1. Baca catatan ini dan [[AGENTS]] untuk keputusan serta aturan kerja.
2. Baca [[README]] dan [[Alur Proyek PPSR]] untuk konteks pengguna.
3. Gunakan [[Panduan Teknis PPSR]] untuk menemukan kode, tes dan langkah deploy.
4. Baca entri terbaru [[MEMORY]] serta riwayat fitur terkait sebelum memeriksa implementasi.

## Kondisi terakhir yang diketahui

Ditinjau 24 November 2026. Fitur terakhir adalah Keterangan pada tabel Pendaftaran Admin dan export Excel. Enter menyimpan, Shift+Enter membuat baris baru. Riwayat pengujian 19 November mencatat enam tes lulus dengan 68 assertion.

Git lokal bersih saat peninjauan awal. Keberhasilan migrasi dan deploy hosting belum dikonfirmasi. Kegagalan koneksi MySQL lokal pada 18 November merupakan hasil pemeriksaan saat itu dan perlu diperiksa ulang jika dibutuhkan.

## Memperbarui dokumentasi

Setiap perubahan dicatat di MEMORY.md. Jika alur, data, akses atau deploy berubah, perbarui panduan terkait dan ringkasan ini dalam pekerjaan yang sama. Catat hasil verifikasi lokal dan hosting beserta tanggalnya. Cocokkan catatan yang berbeda versi dengan kode, migrasi dan tes.

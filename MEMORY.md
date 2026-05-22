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
# 📚 Input Nilai - Developer Guide

## Cara Menggunakan

### 1. **Akses Halaman**

```
URL: /admin/input-nilais
Akses: Admin Panel → Sidebar → Manajemen Akademik → Input Nilai
```

### 2. **Step-by-Step Flow**

#### Step 1: Pilih Filter

```php
1. Kelas: Pilih kelas dari dropdown
2. Mata Pelajaran: Pilih mata pelajaran yang akan dinilai
3. Semester: Semester 1 atau 2
4. Tahun Ajaran: Tahun ajaran yang diinginkan (default: 2024/2025)
5. Jenis Nilai: Pilih tipe (Pengetahuan, Keterampilan, atau Sikap)
```

#### Step 2: Load Data Siswa

```php
Klik tombol "🔍 Muat Data Siswa"
↓
System akan:
- Validasi semua filter sudah dipilih
- Ambil data siswa sesuai kelas dan gender
- Load nilai yang sudah ada (jika ada)
- Tampilkan jumlah siswa ditemukan
```

#### Step 3: Input Nilai

```
Desktop:
- Input nilai di kolom Nilai
- Predikat otomatis tersetting
- Tambahkan deskripsi (opsional)

Mobile:
- Lihat kartu siswa
- Masukkan nilai di input field
- Lihat skor langsung
- Tambahkan deskripsi di textarea
```

#### Step 4: Search (Optional)

```php
Gunakan search bar untuk mencari:
- Nama siswa (case-insensitive)
- NISN siswa

Contoh:
[🔍 Cari: "Ahmad"]
Hasil: Ahmad Rizki, Ahmad Subhan, Muhammad Ahmad
```

#### Step 5: Simpan Nilai

```php
Klik tombol "✓ Simpan Nilai"
↓
System akan:
- Validate semua nilai (0-100)
- Calculate predikat otomatis
- UpdateOrCreate di database
- Show notification hasil
- Auto-reload data
```

---

## Architecture

### Component Structure

```
ManageInputNilais (Livewire Component)
├── Form (Filament Forms)
│   ├── Select (Kelas)
│   ├── Select (Mata Pelajaran)
│   ├── Select (Semester)
│   ├── Select (Tahun Ajaran)
│   └── Select (Jenis Nilai)
├── Properties
│   ├── $selectedKelas
│   ├── $selectedMataPelajaran
│   ├── $selectedSemester
│   ├── $selectedTahunAjaran
│   ├── $selectedJenisNilai
│   ├── $students (array)
│   ├── $nilaiData (array)
│   ├── $searchNilai (string)
│   └── $isSaving (boolean)
├── Methods
│   ├── loadStudents()
│   ├── saveNilai()
│   ├── calculatePredikat($nilai)
│   ├── getPredikatColor($predikat)
│   ├── countFilledNilai()
│   └── getFilteredStudentsProperty()
└── View (manage-input-nilais.blade.php)
    ├── Desktop (Table view)
    └── Mobile (Card view)
```

### Data Models

```php
// Form State
$data = [
    'kelas_id' => 1,
    'mata_pelajaran_id' => 2,
    'semester' => '1',
    'tahun_ajaran' => '2024/2025',
    'jenis_nilai' => 'Pengetahuan'
]

// Students Array
$students = [
    [
        'id' => 1,
        'type' => 'App\Models\Mtsputri',
        'nama' => 'Siti Nurhaliza',
        'nisn' => '1234567890'
    ],
    ...
]

// Nilai Data
$nilaiData = [
    1 => [
        'nilai' => 90,
        'deskripsi' => 'Sangat baik, terus semangat'
    ],
    2 => [
        'nilai' => 85,
        'deskripsi' => 'Baik, masih perlu tingkatkan'
    ],
    ...
]
```

### Database Operations

```php
// Read existing grades
Nilai::where('siswa_id', $siswaId)
    ->where('siswa_type', $modelClass)
    ->where('mata_pelajaran_id', $mataPelajaranId)
    ->where('semester', $semester)
    ->where('tahun_ajaran', $tahunAjaran)
    ->where('jenis_nilai', $jenisNilai)
    ->first();

// Create/Update grades
Nilai::updateOrCreate(
    [
        'siswa_id' => $siswaId,
        'siswa_type' => $modelClass,
        'mata_pelajaran_id' => $mataPelajaranId,
        'semester' => $semester,
        'tahun_ajaran' => $tahunAjaran,
        'jenis_nilai' => $jenisNilai,
    ],
    [
        'kelas_id' => $kelasId,
        'guru_id' => Auth::id(),
        'nilai' => (int) $nilai,
        'predikat' => $predikat,
        'deskripsi' => $deskripsi,
    ]
);
```

---

## Key Functions

### `calculatePredikat($nilai)`

```php
Menghitung predikat berdasarkan nilai:
- Input: int (0-100)
- Output: string ('A', 'B', 'C', 'D', 'E', atau '-')

Contoh:
$this->calculatePredikat(90)   // return 'A'
$this->calculatePredikat(85)   // return 'B'
$this->calculatePredikat(72)   // return 'C'
$this->calculatePredikat(65)   // return 'D'
$this->calculatePredikat(45)   // return 'E'
$this->calculatePredikat(null) // return '-'
```

### `getPredikatColor($predikat)`

```php
Mengembalikan warna untuk badge:
- Input: string ('A', 'B', 'C', 'D', 'E')
- Output: string (color name)

Contoh:
$this->getPredikatColor('A') // return 'success' (green)
$this->getPredikatColor('B') // return 'info' (blue)
$this->getPredikatColor('C') // return 'warning' (yellow)
$this->getPredikatColor('D') // return 'danger' (red)
$this->getPredikatColor('E') // return 'gray'
```

### `countFilledNilai()`

```php
Menghitung berapa nilai yang sudah diisi:
- Input: none (menggunakan $this->nilaiData)
- Output: int

Contoh:
countFilledNilai() // return 15 (dari 25 siswa)
```

### `getFilteredStudentsProperty()`

```php
Filter siswa berdasarkan search term:
- Input: $this->searchNilai (string)
- Output: array of students

Contoh:
[searchNilai = "Ahmad"]
// return siswa dengan nama/NISN mengandung "Ahmad"
```

### `loadStudents()`

```php
Load daftar siswa sesuai filter:
- Validate semua filter sudah dipilih
- Query siswa dari kelas
- Load nilai yang sudah ada
- Set $this->students dan $this->nilaiData
- Show notification hasil

Triggers when:
- Form submitted (loadStudents button clicked)
- After saveNilai() success
```

### `saveNilai()`

```php
Simpan semua nilai yang diinput:
- Validate tidak ada data
- Loop semua $nilaiData
- Validate nilai 0-100
- UpdateOrCreate di database
- Show notification
- Reload students

Error handling:
- Empty data: warning notification
- Invalid nilai: warning + stop
- Success: success notification + reload
```

---

## Validation Rules

| Field          | Rule           | Error Message                        |
| -------------- | -------------- | ------------------------------------ |
| Kelas          | Required       | Pilih kelas terlebih dahulu          |
| Mata Pelajaran | Required       | Pilih mata pelajaran terlebih dahulu |
| Semester       | Required       | Pilih semester terlebih dahulu       |
| Tahun Ajaran   | Required       | Pilih tahun ajaran terlebih dahulu   |
| Jenis Nilai    | Required       | Pilih jenis nilai terlebih dahulu    |
| Nilai          | Numeric, 0-100 | Nilai harus antara 0-100             |
| Deskripsi      | Text, optional | -                                    |

---

## States & Notifications

### Loading States

```php
// Show loading: $isSaving = true
// Hide loading: $isSaving = false
```

### Notifications

**Success:**

```php
Notification::make()
    ->title('✓ Berhasil Disimpan')
    ->body('15 nilai berhasil disimpan (10 kosong tidak disimpan)')
    ->success()
    ->send();
```

**Warning:**

```php
Notification::make()
    ->title('Lengkapi Filter')
    ->body('Silakan pilih semua filter terlebih dahulu')
    ->warning()
    ->send();
```

**Info:**

```php
Notification::make()
    ->title('Data Dimuat')
    ->body('25 siswa ditemukan')
    ->success()
    ->send();
```

---

## Testing Scenarios

### Scenario 1: Normal Flow

```
1. ✅ Pilih kelas, mata pelajaran, semester, tahun ajaran, jenis nilai
2. ✅ Click "Muat Data Siswa"
3. ✅ See 25 siswa in table/cards
4. ✅ Input nilai untuk beberapa siswa
5. ✅ Check predikat otomatis terkalkulasi
6. ✅ Click "Simpan Nilai"
7. ✅ See success notification
8. ✅ Data tersimpan di database
```

### Scenario 2: Search Function

```
1. ✅ Data sudah dimuat
2. ✅ Type "Ahmad" di search bar
3. ✅ See 3 siswa dengan nama Ahmad
4. ✅ Input nilai untuk siswa yang tampil
5. ✅ Clear search = semua siswa muncul lagi
```

### Scenario 3: Empty Input

```
1. ✅ Data sudah dimuat
2. ✅ Tidak input nilai apapun
3. ✅ Click "Simpan Nilai"
4. ✅ See warning: "Tidak ada nilai yang diisi"
5. ✅ Button disabled (karena countFilledNilai() == 0)
```

### Scenario 4: Invalid Input

```
1. ✅ Data sudah dimuat
2. ✅ Input nilai 105 (invalid)
3. ✅ Click "Simpan Nilai"
4. ✅ See error notification
5. ✅ Operasi dibatalkan
```

### Scenario 5: Update Existing Grade

```
1. ✅ Student sudah punya nilai 80 (predikat B)
2. ✅ Reload halaman > nilai muncul di form
3. ✅ Update nilai menjadi 90 (predikat A)
4. ✅ Click "Simpan Nilai"
5. ✅ Database updated dengan nilai baru
```

---

## Performance Tips

1. **Eager Loading**

    ```php
    // Kalau query siswa jadi slow, tambahkan eager load
    $students = $kelas->mtsputris()->with('nilais')->get();
    ```

2. **Pagination** (jika siswa >100)

    ```php
    // Pertimbangkan pagination per halaman
    $students = $students->paginate(50);
    ```

3. **Caching**
    ```php
    // Cache option dari dropdown
    Kelas::all()->pluck('name', 'id')
    // Bisa di-cache jika tidak sering berubah
    ```

---

## Troubleshooting

### Nilai tidak tersimpan

- ✅ Check filter sudah dipilih semua
- ✅ Check input nilai valid (0-100)
- ✅ Check user punya permission input-nilai
- ✅ Check database connection

### Predikat tidak otomatis kalkulasi

- ✅ Check method calculatePredikat() exist
- ✅ Check Blade syntax untuk calculate
- ✅ Refresh halaman

### Search tidak work

- ✅ Check wire:model.live="searchNilai"
- ✅ Check getFilteredStudentsProperty() method
- ✅ Check Livewire component refresh

### Mobile layout messed up

- ✅ Check viewport meta tag
- ✅ Check Tailwind responsive class (md:hidden / hidden md:block)
- ✅ Clear browser cache

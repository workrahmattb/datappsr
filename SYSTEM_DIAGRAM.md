# 🎯 INPUT NILAI - SYSTEM DIAGRAM

## Architecture Overview

```
┌─────────────────────────────────────────────────────────────────┐
│                    INPUT NILAI SYSTEM                           │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ┌──────────────────────┐                                      │
│  │   USER INTERFACE     │                                      │
│  ├──────────────────────┤                                      │
│  │ • Filter Form        │                                      │
│  │ • Search Bar         │                                      │
│  │ • Data Display       │                                      │
│  │ • Save Button        │                                      │
│  └──────────────────────┘                                      │
│           │                                                    │
│           ▼                                                    │
│  ┌──────────────────────────────────────────────────────────┐ │
│  │        LIVEWIRE COMPONENT                                │ │
│  │    (ManageInputNilais.php)                               │ │
│  ├──────────────────────────────────────────────────────────┤ │
│  │                                                          │ │
│  │  Properties:                 Methods:                   │ │
│  │  • $selectedKelas            • loadStudents()           │ │
│  │  • $selectedMapel            • saveNilai()             │ │
│  │  • $selectedSemester         • calculatePredikat()      │ │
│  │  • $selectedTahunAjaran      • getPredikatColor()       │ │
│  │  • $selectedJenisNilai       • countFilledNilai()       │ │
│  │  • $students                 • getFiltered..()          │ │
│  │  • $nilaiData                                           │ │
│  │  • $searchNilai                                         │ │
│  │  • $isSaving                                            │ │
│  │                                                          │ │
│  └──────────────────────────────────────────────────────────┘ │
│           │                                                    │
│           ├──────────────────────┬──────────────────────┐     │
│           ▼                      ▼                      ▼     │
│  ┌────────────────┐  ┌──────────────────┐  ┌────────────────┐ │
│  │   DATABASE     │  │   VALIDATION     │  │   NOTIFICATION │ │
│  ├────────────────┤  ├──────────────────┤  ├────────────────┤ │
│  │ • Nilai        │  │ • Range 0-100    │  │ • Success      │ │
│  │ • Students     │  │ • Required fields│  │ • Warning      │ │
│  │ • Subjects     │  │ • Business logic │  │ • Error        │ │
│  │ • Classes      │  │                  │  │ • Info         │ │
│  │ • Grades       │  │                  │  │                │ │
│  └────────────────┘  └──────────────────┘  └────────────────┘ │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

---

## Data Flow Diagram

```
START
  │
  ▼
[User Opens Page]
  │
  ├─► Load form with empty state
  │
  ▼
[Select Filters]
  │
  ├─► Kelas selected
  ├─► Mata Pelajaran selected
  ├─► Semester selected
  ├─► Tahun Ajaran selected
  ├─► Jenis Nilai selected
  │
  ▼
[Click "Muat Data Siswa"]
  │
  ├─► Validate all filters
  │   ├─ All selected? → YES
  │   └─ All selected? → NO → Show warning
  │
  ▼
[loadStudents() method]
  │
  ├─► Get Kelas from DB
  ├─► Determine student type (MTs/MA, Putra/Putri)
  ├─► Load all students from $kelas->relation
  ├─► For each student:
  │   ├─ Find existing Nilai record
  │   ├─ Store in $students array
  │   └─ Store nilai data in $nilaiData array
  │
  ▼
[Render View]
  │
  ├─► Check device size
  │   ├─ Mobile (0-767px) → Show CARD view
  │   └─ Desktop (768px+) → Show TABLE view
  │
  ▼
[User inputs data]
  │
  ├─► Option A: Direct input (type nilai)
  │   ├─► Livewire detects change
  │   ├─► calculatePredikat() runs
  │   └─► Badge color updates
  │
  ├─► Option B: Search (type in search bar)
  │   ├─► wire:model.live="searchNilai"
  │   ├─► getFilteredStudentsProperty() runs
  │   ├─► View filters automatically
  │   └─► Show matching students only
  │
  ▼
[User clicks "Simpan Nilai"]
  │
  ├─► Validate data:
  │   ├─ Are there any filled values? → NO → Show warning
  │   ├─ Are all values 0-100? → NO → Show error
  │   └─ All valid? → YES → Continue
  │
  ▼
[saveNilai() method]
  │
  ├─► For each filled $nilaiData:
  │   ├─ Get student info
  │   ├─ Validate nilai (0-100)
  │   ├─ Calculate predikat
  │   └─ updateOrCreate() in DB:
  │       ├─ Identify by:
  │       │  ├─ siswa_id
  │       │  ├─ siswa_type
  │       │  ├─ mata_pelajaran_id
  │       │  ├─ semester
  │       │  ├─ tahun_ajaran
  │       │  └─ jenis_nilai
  │       │
  │       └─ Update with:
  │          ├─ nilai
  │          ├─ predikat
  │          ├─ deskripsi
  │          ├─ guru_id
  │          └─ kelas_id
  │
  ▼
[Show Notification]
  │
  ├─► "✓ Berhasil Disimpan"
  ├─► "15 nilai berhasil disimpan (10 kosong)"
  │
  ▼
[Auto reload]
  │
  ├─► Call loadStudents() again
  ├─► Refresh display with latest data
  │
  ▼
[User can continue]
  │
  ├─► Input more students
  ├─► Search for others
  ├─► Load different class
  │
  ▼
END
```

---

## Component Relationship

```
┌──────────────────────────────────────────────────────┐
│           Filament Page                              │
│        (manage-input-nilais.blade.php)               │
└──────────────────────────────────────────────────────┘
                      │
                      ├─────────────────────────────┐
                      ▼                             ▼
        ┌──────────────────────────┐  ┌──────────────────────┐
        │   Form Component         │  │  Livewire Component  │
        │ (Filament Forms)         │  │ (ManageInputNilais)  │
        ├──────────────────────────┤  ├──────────────────────┤
        │ • Select Kelas           │  │ • Handle events      │
        │ • Select Mapel           │  │ • Process data       │
        │ • Select Semester        │  │ • Calculate values   │
        │ • Select Tahun Ajaran    │  │ • Save to DB         │
        │ • Select Jenis Nilai     │  │ • Handle search      │
        │                          │  │ • Validation logic   │
        └──────────────────────────┘  └──────────────────────┘
                      │                        │
                      └────────────┬───────────┘
                                   ▼
        ┌──────────────────────────────────────────────┐
        │          Database Models                     │
        ├──────────────────────────────────────────────┤
        │ • Kelas                                      │
        │ • Nilai                                      │
        │ • Mtsputri, Mtsputra, Maputri, Maputra      │
        │ • MataPelajaran                              │
        │ • User (Guru)                                │
        └──────────────────────────────────────────────┘
```

---

## State Flow

```
COMPONENT STATE LIFECYCLE
━━━━━━━━━━━━━━━━━━━━━━━━━━━

[Initial State]
├─ $students = []
├─ $nilaiData = []
├─ $selectedKelas = null
├─ $selectedMapel = null
├─ $selectedSemester = null
├─ $selectedTahunAjaran = null
├─ $selectedJenisNilai = null
├─ $searchNilai = ''
└─ $isSaving = false
   │
   ▼
[After selecting filters]
├─ $selectedKelas = 1
├─ $selectedMapel = 2
├─ $selectedSemester = '1'
├─ $selectedTahunAjaran = '2024/2025'
├─ $selectedJenisNilai = 'Pengetahuan'
   │
   ▼
[After clicking "Muat Data"]
├─ $students = [array of 25 students]
├─ $nilaiData = [array of grade data]
   │
   ▼
[During input]
├─ $nilaiData[1]['nilai'] = 90
├─ $nilaiData[1]['deskripsi'] = 'Bagus'
   │
   ▼
[During search]
├─ $searchNilai = 'Ahmad'
├─ filteredStudents = [array of filtered students]
   │
   ▼
[Before save]
├─ $isSaving = true
   │
   ▼
[After save]
├─ $isSaving = false
├─ $nilaiData = [refreshed from DB]
└─ Show notification
```

---

## Database Operation

```
UPDATEORCREATE OPERATION
━━━━━━━━━━━━━━━━━━━━━━━━━━━

Nilai::updateOrCreate(
    [unique identifiers],
    [attributes to update/create]
)

↓

Check existing record with:
├─ siswa_id = 1
├─ siswa_type = 'App\Models\Mtsputri'
├─ mata_pelajaran_id = 2
├─ semester = '1'
├─ tahun_ajaran = '2024/2025'
└─ jenis_nilai = 'Pengetahuan'

↓

Found?
├─ YES: Update existing record
│   ├─ nilai = 90
│   ├─ predikat = 'A'
│   ├─ deskripsi = 'Bagus'
│   ├─ guru_id = 1
│   └─ kelas_id = 3
│
└─ NO: Create new record with all data

↓

Result: Database updated/inserted successfully
```

---

## Responsive Layout Logic

```
DEVICE DETECTION & RENDERING
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

Screen Size Detected
        │
        ├─ Mobile (0-767px)
        │  │
        │  ├─► hidden md:block classes HIDDEN
        │  ├─► md:hidden classes VISIBLE
        │  │
        │  └─► Render:
        │      ├─ Filter form stacked
        │      ├─ Search bar full width
        │      ├─ Card layout (one per card)
        │      ├─ Large input fields
        │      └─ Textarea for desc
        │
        └─ Desktop (768px+)
           │
           ├─► hidden md:block classes VISIBLE
           ├─► md:hidden classes HIDDEN
           │
           └─► Render:
               ├─ Filter form 2 rows
               ├─ Search bar with icon
               ├─ Table layout
               ├─ Compact input fields
               └─ Text input for desc
```

---

## Search Filter Logic

```
SEARCH IMPLEMENTATION
━━━━━━━━━━━━━━━━━━━━━━━━━

User types in search bar
        │
        ▼
wire:model.live="searchNilai" triggers
        │
        ▼
getFilteredStudentsProperty() method called
        │
        ├─► If searchNilai is empty
        │   └─ Return all $students
        │
        └─► If searchNilai has value
            │
            ├─► Convert to lowercase
            ├─► Loop through $students
            ├─► Check each student:
            │   ├─ Match dalam nama?
            │   └─ Match dalam NISN?
            │
            ├─► If match found
            │   └─ Add to filtered array
            │
            └─► Return filtered array
                │
                ▼
            View updates with filtered results
            Only matching students display
```

---

## Validation Flow

```
INPUT VALIDATION
━━━━━━━━━━━━━━━━━━━━

1. FILTER VALIDATION
   ├─ Kelas selected? YES/NO
   ├─ Mapel selected? YES/NO
   ├─ Semester selected? YES/NO
   ├─ Tahun Ajaran selected? YES/NO
   └─ Jenis Nilai selected? YES/NO
      └─ Any NO? → Show warning

2. DATA LOADING VALIDATION
   ├─ Students found? YES/NO
   └─ Any NO? → Show message

3. INPUT VALIDATION (per field)
   ├─ Value is numeric? YES/NO
   ├─ Value 0-100? YES/NO
   └─ Any NO? → Show error & stop

4. SAVE VALIDATION
   ├─ Any value filled? YES/NO
   │  └─ NO? → Show warning
   │
   ├─ All values 0-100? YES/NO
   │  └─ NO? → Show error & stop
   │
   └─ YES? → Proceed with save
```

---

## Notification System

```
NOTIFICATION TRIGGERS
━━━━━━━━━━━━━━━━━━━━━

Event                          → Notification
────────────────────────────────────────────────────
Filter validation fail         → ⚠️ Warning
Data loaded successfully       → ℹ️ Info
Input value invalid           → ✗ Error
Save value invalid            → ✗ Error
Save successful               → ✓ Success
Data reloaded after save      → ℹ️ Info

Each notification shows:
├─ Title (emoji + text)
├─ Body (detailed message)
├─ Color (warning/info/error/success)
└─ Duration (auto-dismiss)
```

---

## Summary

```
INPUT NILAI SYSTEM =

User Interface
    ↓
Livewire Component (React to changes)
    ↓
Blade Template (Responsive display)
    ↓
PHP Methods (Business logic)
    ↓
Database Models (Data persistence)
    ↓
Notifications (User feedback)

Everything connected and working together seamlessly!
```

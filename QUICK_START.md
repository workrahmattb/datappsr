# 🚀 Quick Start - Input Nilai

## What's New? ✨

```
✅ Mobile-friendly design (cards + table)
✅ Real-time search functionality
✅ Auto predikat calculation
✅ Input validation (0-100)
✅ Progress counter
✅ Better error handling
✅ Improved UX/UI
✅ Dark mode support
```

## Where to Find?

```
URL:  /admin/input-nilais
Menu: Admin Panel → Manajemen Akademik → Input Nilai
```

## Files Changed

```
📝 Modified Files:
├── app/Filament/Resources/InputNilais/Pages/ManageInputNilais.php
└── resources/views/filament/resources/input-nilais/pages/manage-input-nilais.blade.php

📚 Documentation:
├── INPUT_NILAI_IMPROVEMENTS.md (Feature docs)
├── INPUT_NILAI_DEVELOPER_GUIDE.md (Developer guide)
└── VISUAL_PREVIEW.md (UI mockups)
```

## Key Changes Summary

### PHP (ManageInputNilais.php)

**Added Properties:**

- `$searchNilai` - Search term
- `$isSaving` - Save state

**Added Methods:**

- `calculatePredikat($nilai)` - Calculate grade A-E
- `getPredikatColor($predikat)` - Get badge color
- `countFilledNilai()` - Count filled inputs
- `getFilteredStudentsProperty()` - Filter by search

**Enhanced Methods:**

- `saveNilai()` - Better validation & error handling
- `loadStudents()` - Adds search filter property

### Blade Template

**New Features:**

- Search bar with live filter
- Desktop table view (hidden on mobile)
- Mobile card view (visible only on mobile)
- Color-coded predikat badges
- Progress indicator (Diisi: X / Y)
- Better responsive layout
- Enhanced styling & animations

**Responsive Breakpoints:**

```
Mobile:  0px - 767px    (cards)
Desktop: 768px+         (table)
```

## How to Use

### 1. Select Filters

```
[ Kelas ] → [ Mata Pelajaran ] → [ Semester ] →
[ Tahun Ajaran ] → [ Jenis Nilai ]
```

### 2. Load Data

```
Click: "🔍 Muat Data Siswa"
↓
Shows: 25 siswa ditemukan
```

### 3. Input Grades

**Desktop:** Edit in table cells

```
No │ Nama  │ Nilai │ Predikat │ Deskripsi
 1 │ Ahmad │ [90]  │   A      │ Bagus
```

**Mobile:** Edit in cards

```
┌──────────────────────┐
│ No. 1             A  │
│ Nama: Ahmad Rizki    │
│ Nilai: [90]          │
│ Skor: 90             │
└──────────────────────┘
```

### 4. Search (Optional)

```
[🔍 Cari nama atau NISN...]
Type: "Ahmad" → See only Ahmad's
```

### 5. Save

```
Progress: Diisi 15 / 25
Button: [ ✓ Simpan Nilai ]
```

## Grading Scale

```
Nilai   Predikat   Color
90-100     A        🟢 Green
80-89      B        🔵 Blue
70-79      C        🟡 Yellow
60-69      D        🔴 Red
<60        E        ⚫ Gray
```

## Validation

```
✅ Semua filter harus dipilih
✅ Nilai harus 0-100
✅ Predikat otomatis dihitung
✅ Deskripsi opsional
```

## Desktop View

```
┌─────────────────────────────────────────┐
│ Filter Form (single row)                │
├─────────────────────────────────────────┤
│ Search bar                              │
├─────────────────────────────────────────┤
│ Data Table (7 columns)                  │
│ ┌──┬────┬────┬────┬────┬────┬────┐    │
│ │No│Name│NISN│Nilai│Pred│Desc│ │   │
│ └──┴────┴────┴────┴────┴────┴────┘    │
├─────────────────────────────────────────┤
│ Save Button (right aligned)             │
└─────────────────────────────────────────┘
```

## Mobile View

```
┌─────────────────┐
│ Filter Form     │
│ (stacked)       │
├─────────────────┤
│ Search bar      │
├─────────────────┤
│ Card 1          │
│ ┌─────────────┐ │
│ │ No.1   A    │ │
│ │ Nama: Ahmad │ │
│ │ Nilai: [90] │ │
│ │ Desc: [Txt] │ │
│ └─────────────┘ │
│ Card 2          │
│ ┌─────────────┐ │
│ │ No.2   B    │ │
│ │ Nama: Siti  │ │
│ │ Nilai: [85] │ │
│ │ Desc: [Txt] │ │
│ └─────────────┘ │
├─────────────────┤
│ Save Button     │
└─────────────────┘
```

## Notifications

```
✓ Success:  "15 nilai berhasil disimpan"
⚠ Warning: "Lengkapi filter terlebih dahulu"
ℹ Info:    "25 siswa ditemukan"
✗ Error:   "Nilai harus antara 0-100"
```

## Performance Notes

- Search is live (no page reload)
- Filter form is reactive
- Predikat calculates client-side (fast)
- Save is async with loading state
- Optimized for mobile devices

## Browser Support

```
✅ Chrome 90+
✅ Firefox 88+
✅ Safari 14+
✅ Edge 90+
✅ Mobile browsers (iOS Safari, Chrome Mobile)
```

## Common Issues & Solutions

### Problem: Value not saving

```
✓ Solution: Check all filters are selected
✓ Solution: Check value is 0-100
✓ Solution: Click button, wait for notification
```

### Problem: Search not working

```
✓ Solution: Refresh page
✓ Solution: Check network connection
✓ Solution: Clear browser cache
```

### Problem: Mobile layout broken

```
✓ Solution: Check viewport in browser DevTools
✓ Solution: Zoom to 100%
✓ Solution: Refresh page
```

## Tips & Tricks

1. **Batch Input**
    - Load data once
    - Input untuk banyak siswa
    - Save once → all data saved

2. **Search Before Input**
    - Search untuk siswa tertentu
    - Input hanya untuk hasil search
    - Lebih fokus dan cepat

3. **Use Tab Key**
    - Desktop: Press Tab to move between inputs
    - Faster input workflow

4. **Keyboard Shortcuts**
    - (Future enhancement planned)

## API Reference

### Properties

```php
$selectedKelas          // Selected class ID
$selectedMataPelajaran  // Selected subject ID
$selectedSemester       // Selected semester (1/2)
$selectedTahunAjaran    // Selected year
$selectedJenisNilai     // Selected grade type
$students               // Array of students
$nilaiData              // Array of grade data
$searchNilai            // Search term
$isSaving               // Save state
```

### Key Methods

```php
loadStudents()                              // Load data
saveNilai()                                 // Save grades
calculatePredikat($nilai)                   // Calculate grade A-E
getPredikatColor($predikat)                 // Get badge color
countFilledNilai()                          // Count filled inputs
getFilteredStudentsProperty()               // Filter by search
```

## Next Steps (Future)

- [ ] Bulk import from Excel
- [ ] Export to PDF/Excel
- [ ] Grade history/audit log
- [ ] Email notifications
- [ ] Custom scoring rules
- [ ] Keyboard shortcuts
- [ ] Auto-save draft

## Questions?

Check these files for more details:

- `INPUT_NILAI_IMPROVEMENTS.md` - Feature documentation
- `INPUT_NILAI_DEVELOPER_GUIDE.md` - Developer guide
- `VISUAL_PREVIEW.md` - UI mockups

Happy grading! 🎓

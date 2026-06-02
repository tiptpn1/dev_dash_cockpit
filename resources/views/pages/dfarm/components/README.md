# Komponen DFarm

Folder ini berisi komponen reusable untuk halaman-halaman DFarm.

## Komponen yang Tersedia

### `application-select.blade.php`

Komponen dropdown untuk memilih aplikasi dengan opsi redirect otomatis.

**Cara Penggunaan:**

```blade
@include('pages.dfarm.components.application-select')
```

**Dengan Selected Option:**

```blade
@include('pages.dfarm.components.application-select', ['selected' => 'HRIS'])
```

**Parameter:**
- `selected` (optional) - Nilai opsi yang akan dipilih secara default

**Opsi yang Tersedia:**
- Digital Farming → `/dfarmkaret`
- Digital Farming Produksi → `/dfarmkaretproduksi`
- HRIS → `/evaluasi-aplikasi`
- MAIA
- MONIKA
- Aplikasi BPD
- SAPA-Amanah

**Catatan:**
Komponen ini dilengkapi dengan event listener JavaScript yang akan otomatis melakukan redirect saat opsi dipilih. Pastikan file yang menggunakan komponen ini sudah include script redirect di bagian `@section('scripts')`.

Untuk menambahkan script redirect:

```javascript
document.getElementById('selectedApp').addEventListener('change', function() {
  const selectedApp = this.value;

  // Redirect to Digital Farming if selected
  if (selectedApp === 'Digital Farming') {
    window.location.href = '/dfarmkaret';
    return;
  }

  // Redirect to Digital Farming Produksi if selected
  if (selectedApp === 'Digital Farming Produksi') {
    window.location.href = '/dfarmkaretproduksi';
    return;
  }

  // Redirect to HRIS if selected
  if (selectedApp === 'HRIS') {
    window.location.href = '/evaluasi-aplikasi';
    return;
  }
});
```

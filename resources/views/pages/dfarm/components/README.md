# Komponen DFarm

Folder ini berisi komponen reusable untuk halaman-halaman DFarm.

## Komponen yang Tersedia

### 1. `application-select.blade.php`

Komponen dropdown untuk memilih aplikasi.

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
- Digital Farming
- Digital Farming Produksi
- HRIS
- MAIA
- MONIKA
- Aplikasi BPD
- SAPA-Amanah

---

### 2. `application-select-handler.js`

Script JavaScript yang menangani redirect otomatis saat opsi aplikasi dipilih.

**Cara Penggunaan:**

Tambahkan script berikut di bagian `@section('scripts')` atau sebelum `@endsection` dalam file Blade:

```blade
<script src="{{ asset('js/components/application-select-handler.js') }}"></script>
```

**Redirect Mapping:**
- Digital Farming → `/dfarmkaret`
- Digital Farming Produksi → `/dfarmkaretproduksi`
- HRIS → `/evaluasi-aplikasi`
- SAPA-Amanah → `/sapa-evaluasi`

**Catatan:**
- Script ini akan otomatis mencari elemen dengan ID `selectedApp` dan menambahkan event listener untuk redirect
- Pastikan komponen `application-select.blade.php` sudah diinclude sebelum script ini dimuat
- Script menggunakan `DOMContentLoaded` untuk memastikan DOM sudah siap

---

## Contoh Implementasi Lengkap

**Dalam file Blade:**

```blade
@section('content')
  <!-- Filters Section -->
  <div class="filter-card">
    <div class="filter-title">
      <i class="fas fa-sliders-h"></i> Filter Parameter
    </div>
    @include('pages.dfarm.components.application-select', ['selected' => 'Digital Farming'])
  </div>
  
  <!-- Konten halaman lainnya -->
@endsection

@section('scripts')
  <!-- Script lainnya -->
  
  <script src="{{ asset('js/components/application-select-handler.js') }}"></script>
  
  @include('pages.dfarm.menu.menu-script')
@endsection
```

---

## File Structure

```
resources/views/pages/dfarm/components/
├── application-select.blade.php          (Blade component)
├── application-select-handler.js         (JavaScript handler)
└── README.md                              (Dokumentasi ini)
```

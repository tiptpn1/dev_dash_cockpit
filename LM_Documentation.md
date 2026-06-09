# Dokumentasi Modul LM Dashboard — Dev Dash Cockpit

> **Project**: `dev_dash_cockpit` (Laravel)  
> **BigQuery Project**: `dashboard-cockpit`  
> **BigQuery Dataset**: `data_dash`  
> **BigQuery Location**: `asia-southeast2`  

---

## Daftar Halaman LM

| Halaman | Nama Laporan | Route | SP BigQuery |
|---------|-------------|-------|-------------|
| **LM13** | Biaya Produksi | `GET /lm13` | `sp_laporan_lm13_{komoditi}` |
| **LM14** | Biaya Tanaman | `GET /lm14` | `sp_laporan_lm14_{komoditi}` |
| **LM16** | Biaya Pengolahan | `GET /lm16` | `sp_laporan_lm16_{komoditi}` |
| **LM34** | Realisasi Penjualan | `GET /lm34` | `sp_laporan_lm34` |
| **LM34 Tab** | Realisasi Penjualan (Tab) | `GET /lm34_tab` | `sp_laporan_lm34`, `sp_laporan_lm34_by_negara`, `sp_laporan_lm34_by_customer` |

---

## Arsitektur Umum

```
Browser (Filter Form)
    │
    │  GET /get_data_lmXX?komoditi=TH&region=...&plant=...&tahun=...&bulan=...
    ▼
BigQueryController::get_data_lmXX()
    │
    │  CALL `dashboard-cockpit.data_dash.sp_laporan_lmXX_teh`(...)
    ▼
runBigQueryCall()  ← method private, shared semua halaman LM
    │
    │  1. startQuery()   → jobs.insert (async, support CALL/script)
    │  2. waitUntilComplete()
    │  3. cek parent job schema → jika ada, ambil rows langsung
    │  4. jika tidak ada schema → iterasi CHILD JOBS
    │     - BigQuery CALL menghasilkan N child jobs (1 per statement)
    │     - Ambil SEMUA child jobs, overwrite dengan child terakhir yg punya rows
    │     - Child job terakhir (suffix _N terbesar) = SELECT akhir prosedur
    ▼
JSON Response: { status, total, data: [...rows] }
    │
    ▼
View (Blade) — render tabel HTML + subtotal otomatis
```

---

## PageController — Method Halaman

Semua method LM di `PageController.php` (baris ~1557–1610) memiliki pola yang **identik**:

```php
public function lmXX()
{
    $tahunSekarang = date('Y');
    $plantList    = Plant::orderBy('plant', 'asc')->get();
    $regionalList = Plant::distinct()->orderBy('regional', 'asc')->get(['regional']);
    $tahunList    = range($tahunSekarang, $tahunSekarang + 9); // 10 tahun ke depan

    return view('pages/lmXX', compact('plantList', 'regionalList', 'tahunList', 'tahunSekarang'));
}
```

**Data yang dikirim ke view:**

| Variable | Sumber | Keterangan |
|----------|--------|------------|
| `$plantList` | Model `Plant` | Semua plant, diurutkan by `plant` |
| `$regionalList` | Model `Plant` (distinct) | Daftar regional unik |
| `$tahunList` | `range(tahunIni, +9)` | Daftar tahun untuk filter |
| `$tahunSekarang` | `date('Y')` | Tahun berjalan |

---

## BigQueryController — `runBigQueryCall()`

**File**: `app/Http/Controllers/BigQueryController.php`

Method private yang dipakai oleh **semua** endpoint `get_data_lmXX`:

```php
private function runBigQueryCall(string $query): array
```

### Alur Eksekusi

```
1. startQuery($query)           → async job (mendukung CALL/script)
2. waitUntilComplete()          → polling sampai job selesai
3. cek errorResult              → throw RuntimeException jika gagal
4. cek parent job schema        → jika ada rows, return langsung
5. iterasi CHILD JOBS:
   a. Kumpulkan semua child jobs ke array
   b. Untuk setiap child job:
      - Cek schema di queryResults()->info()
      - Jika tidak ada schema → skip (DML, DDL, SET)
      - Jika ada schema → baca rows(), simpan ke $finalRows
      - OVERWRITE $finalRows setiap kali ada rows (supaya yang terakhir menang)
   c. Return $finalRows (= hasil dari child job terakhir yg punya rows)
```

### Kenapa Pakai Child Jobs?

BigQuery `CALL` berjalan sebagai **script job**. Setiap statement di dalam stored procedure = 1 child job. Statement `SELECT` terakhir adalah child job dengan suffix `_N` tertinggi.

`getQueryResults` pada parent job **tidak mengembalikan rows** untuk script job — hanya child job yang berisi hasil SELECT.

### ⚠️ Syarat Penting: SP Harus Diakhiri `SELECT`

| SP Type | Akhir SP | Status |
|---------|----------|--------|
| LM13, LM14, LM34 | `SELECT * FROM temp_table` | ✅ Bekerja |
| LM16 (sebelum fix) | `CREATE TEMP TABLE AS SELECT` | ❌ Rows null |
| LM16 (setelah fix SP) | `SELECT * FROM temp_result` | ✅ Bekerja |

**Jika SP diakhiri DML** (INSERT/CREATE TABLE), `total_rows` akan `null` dan data tidak bisa dibaca via PHP. **Solusi: tambahkan `SELECT` di baris terakhir SP di BigQuery console.**

---

## Detail Per Halaman

### LM13 — Biaya Produksi

| Item | Detail |
|------|--------|
| **Route halaman** | `GET /lm13` → `PageController::lm13()` |
| **Route data** | `GET /get_data_lm13` → `BigQueryController::get_data_lm13()` |
| **View** | `resources/views/pages/lm13.blade.php` (~1185 baris) |
| **SP BigQuery** | `sp_laporan_lm13_karet`, `sp_laporan_lm13_teh`, `sp_laporan_lm13_kopi` |
| **Parameter SP** | `(region, plant, tahun, bulan)` |
| **Kolom hasil** | `kode`, `uraian`, + kolom numerik (otomatis dideteksi) |

**Filter:**
- Komoditas: KR / TH / KP (wajib dipilih untuk menentukan SP mana yang dipanggil)
- Regional → dinamis filter plant
- Plant (opsional)
- Tahun + Bulan (wajib)

**Logika Tabel:**
- Header kolom diambil otomatis dari `Object.keys(rows[0])`
- Kolom numerik dideteksi dengan scan semua baris (`rows.some(r => !isNaN(parseFloat(r[h])))`)
- **Subtotal otomatis** berdasarkan 2 karakter pertama kolom `kode` (grup 2-char) dan 1 karakter pertama (grup 1-char)
- Grand total dihitung di client-side

**Format bulan ke SP:** `bulan < 10 → '00' + bulan` (misal: April = `004`)

---

### LM14 — Biaya Tanaman

| Item | Detail |
|------|--------|
| **Route halaman** | `GET /lm14` → `PageController::lm14()` |
| **Route data** | `GET /get_data_lm14` → `BigQueryController::get_data_lm14()` |
| **View** | `resources/views/pages/lm14.blade.php` (~1356 baris) |
| **SP BigQuery** | `sp_laporan_lm14_karet`, `sp_laporan_lm14_teh`, `sp_laporan_lm14_kopi` |
| **Parameter SP** | `(region, plant, tahun, bulan)` |
| **Kolom hasil** | `kode`, `uraian`, `qty_*`, `barang_bahan_*`, `biaya_pemeliharaan_*`, `biaya_total_*`, `biaya_per_ha_*` |

**Perbedaan dari LM13:**
- **Kolom subtotal** dideteksi via partial match nama: `barang_bahan`, `biaya_pemeliharaan`, `biaya_total`
- Ada kolom **`biaya_per_ha`** yang dihitung ulang client-side dari `biaya_total / luas_areal`
- **Luas areal** diambil dari baris dengan `kode = '00'` atau `uraian.includes('luas areal')`
- Layout tabel menggunakan `table-layout: fixed` dengan distribusi lebar proporsional (teks vs angka)
- Format 2 desimal khusus untuk kolom `biaya_per_ha`

> **⚠️ Catatan**: Ada `console.log` debug yang belum dihapus di lm14.blade.php baris ~797-799. Aman secara fungsional tapi sebaiknya dibersihkan.

---

### LM16 — Biaya Pengolahan

| Item | Detail |
|------|--------|
| **Route halaman** | `GET /lm16` → `PageController::lm16()` |
| **Route data** | `GET /get_data_lm16` → `BigQueryController::get_data_lm16()` |
| **View** | `resources/views/pages/lm16.blade.php` (~1185 baris) |
| **SP BigQuery** | `sp_laporan_lm16_karet`, `sp_laporan_lm16_teh`, `sp_laporan_lm16_kopi` |
| **Parameter SP** | `(region, plant, tahun, bulan)` |
| **Kolom hasil** | `kode`, `grup`, `uraian`, `biaya_tahun_lalu`, `biaya_tahun_ini`, `biaya_per_kg_tahun_lalu`, `biaya_per_kg_tahun_ini` |

**Riwayat Masalah & Fix:**

```
[Masalah 1] JS Error: RATIO_COLS is not defined
  → Fix: Hapus referensi variabel yang tidak terdefinisi di lm16.blade.php

[Masalah 2] PHP Warning: Undefined array key "schema"
  → Penyebab: BigQuery library v1.36 crash saat CALL via runQuery()
  → Fix: Ganti ke startQuery() + iterasi child jobs

[Masalah 3] Data tidak muncul (child job ada tapi rows null)
  → Penyebab: SP lm16 diubah — statement akhir bukan SELECT tapi CREATE TEMP TABLE
  → Fix PERMANEN: Edit SP di BigQuery console, tambahkan SELECT di baris terakhir
```

**⚠️ Status LM16**: Data akan muncul **setelah** SP di BigQuery dimodifikasi untuk menambahkan `SELECT` di akhir.

---

### LM34 — Realisasi Penjualan

| Item | Detail |
|------|--------|
| **Route halaman** | `GET /lm34` → `PageController::lm34()` |
| **Route data** | `GET /get_data_lm34` → `BigQueryController::get_data_lm34()` |
| **View** | `resources/views/pages/lm34.blade.php` (~1149 baris) |
| **SP BigQuery** | `sp_laporan_lm34` |
| **Parameter SP** | `(komoditi_nama, region, plant, tahun, bulan)` |
| **Kolom hasil** | Dinamis (termasuk: `prodheir2_id`, `material_id`, volume, nilai, dll.) |

> **Note**: LM34 meneruskan `komoditi` sebagai nama lengkap (`karet`/`teh`/`kopi`), bukan kode (KR/TH/KP).

**Perbedaan Signifikan dari LM13/LM14:**
- Kolom dideteksi lebih canggih dengan regex pattern:
  - **ID cols**: `/_id$|material|prodheir|kdbe|norek|^kode|uraian|^nama/i`
  - **Harga cols**: `/harga|price|rate|satuan/i`
  - **Volume cols**: `/volume|vol\b|qty|kuantitas/i`
  - **Nilai cols**: `/nilai|value|amount/i`
- **Subtotal** hanya pada volume + nilai (bukan semua kolom numerik)
- Grouping subtotal berdasarkan kolom `prodheir2_id` (jika ada)
- **Grand Total** di akhir tabel

**Halaman LM34 Tab** (`lm34_tab.blade.php`):
- Tampilkan 3 tab: **LM34 Utama**, **By Negara**, **By Customer**
- Memanggil 3 endpoint berbeda: `get_data_lm34`, `get_data_lm34_by_negara`, `get_data_lm34_by_customer`
- SP yang digunakan: `sp_laporan_lm34_by_negara` dan `sp_laporan_lm34_by_customer`

---

## API Endpoints

Semua endpoint ada di `routes/web.php` dalam grup middleware `auth:custom`:

```php
Route::get('/get_data_lm13',             [BigQueryController::class, 'get_data_lm13']);
Route::get('/get_data_lm14',             [BigQueryController::class, 'get_data_lm14']);
Route::get('/get_data_lm16',             [BigQueryController::class, 'get_data_lm16']);
Route::get('/get_data_lm34',             [BigQueryController::class, 'get_data_lm34']);
Route::get('/get_data_lm34_by_negara',   [BigQueryController::class, 'get_data_lm34_by_negara']);
Route::get('/get_data_lm34_by_customer', [BigQueryController::class, 'get_data_lm34_by_customer']);
```

### Query Parameters

| Parameter | LM13 | LM14 | LM16 | LM34 |
|-----------|------|------|------|------|
| `komoditi` | KR/TH/KP | KR/TH/KP | KR/TH/KP | KR/TH/KP |
| `region` | ✅ | ✅ | ✅ | ✅ |
| `plant` | ✅ | ✅ | ✅ | ✅ |
| `tahun` | ✅ | ✅ | ✅ | ✅ |
| `bulan` | ✅ (1-12) | ✅ (1-12) | ✅ (1-12) | ✅ (1-12) |

**Format bulan ke SP**: Bulan 1–9 diformat menjadi `001`–`009`, bulan 10–12 menjadi `010`–`012`.

> ⚠️ **Bug minor**: Ada kondisi `elseif ($bulan >= 10 && $bulan < 12)` yang tidak mencakup bulan 12 (Desember). Bulan 12 tidak mendapat prefix `0`. Sebaiknya diperbaiki ke `$bulan < 13` atau `<= 12`.

### Response Format

```json
{
  "status": "success",
  "total": 42,
  "data": [
    { "kode": "A1", "uraian": "...", "biaya_tahun_ini": 12345.67 },
    ...
  ]
}
```

Error:
```json
{
  "status": "error",
  "message": "Error description"
}
```

---

## View — Pola Umum (Semua LM)

Semua view LM menggunakan pola yang **sama persis**:

### Struktur HTML
```
@extends('layouts.app')

lm13-container (main-content)
├── lm-page-header
│   ├── Logo Danantara (kiri)
│   ├── Judul LMxx (tengah)
│   └── Logo PTPN1 (kanan)
└── content-section
    ├── filter-card
    │   └── form#filterForm
    │       ├── select#komoditasFilter   (KR/TH/KP)
    │       ├── select#regionalFilter    (dari $regionalList)
    │       ├── select#plantFilter       (dari $plantList, dimuat via Select2, disabled jika regional kosong)
    │       ├── select#tahunFilter       (dari $tahunList)
    │       ├── select#bulanFilter       (Jan–Des)
    │       ├── button#btnReset
    │       └── button#btnFilter         (disabled sampai tahun+bulan dipilih)
    └── table-card#resultCard            (hidden sampai data dimuat)
        ├── table-header (judul + tombol Excel/PDF)
        └── table-wrapper
            ├── div#tableLoading
            ├── div#tableError
            └── div#tableResult
```

> **Catatan**: Semua view menggunakan CSS class `lm13-container` (meski itu untuk LM14/16/34 sekalipun). Ini adalah penamaan yang kurang konsisten tapi tidak memengaruhi fungsi.

### JavaScript Libraries (CDN)

```html
<script src="select2@4.1.0-rc.0/dist/js/select2.min.js"></script>   <!-- Plant dropdown -->
<script src="exceljs@4.4.0/dist/exceljs.min.js"></script>            <!-- Export Excel -->
<script src="jspdf@2.5.1/dist/jspdf.umd.min.js"></script>            <!-- Export PDF -->
<script src="jspdf-autotable@3.8.2/dist/jspdf.plugin.autotable.min.js"></script>
```

### Logika Filter Plant
```javascript
// Plant didisable jika regional belum dipilih
// Saat regional berubah → rebuild options plant dari allPlants (data dari server)
const allPlants = @json($plantList->map(fn($p) => [
    'plant'    => $p->plant,
    'nama'     => $p->nama,
    'regional' => $p->regional
]));
```

### Export Excel (ExcelJS)
- Baris 1: Judul laporan (merged cells)
- Baris 2: Header kolom (background hijau `#15803D`)
- Baris 3–N: Data dengan alternating rows (`#FFF` / `#F9FAFB`)
- Baris subtotal: Background `#F0FDF4` (level 2) dan `#DCFCE7` (level 1)
- Baris grand total: Background `#14532D`, font putih
- Format angka: `#,##0` (tanpa desimal untuk integer, 2 desimal untuk float)

### Export PDF (jsPDF + autoTable)
- Orientasi: **landscape**, format **A3**
- Font size: 6.5pt (data), 10pt (judul)
- Struktur tabel sama seperti HTML (judul → header → data → subtotal → grand total)

---

## Model Database

**Plant Model** (`App\Models\Plant`):
```php
// Digunakan untuk mengisi filter Regional dan Plant di semua halaman LM
Plant::orderBy('plant', 'asc')->get()
// Kolom yang digunakan: plant, nama, regional
```

---

## Konfigurasi BigQuery

**File**: `config/bigquery.php`
```php
'projectId' => env('BIGQUERY_PROJECT_ID', 'dashboard-cockpit')
```

**Library**: `google/cloud-bigquery: ^1.36`

> ⚠️ **Breaking change di v1.36**: `BigQuery::runQuery()` tidak bisa digunakan untuk `CALL` stored procedure. Gunakan `startQuery()` + `waitUntilComplete()` + iterasi child jobs (sudah diimplementasikan di `runBigQueryCall()`).

---

## Checklist Jika SP BigQuery Diubah

Jika tim data mengubah struktur SP (nama kolom, penambahan parameter, dll):

- [ ] Pastikan SP **diakhiri dengan `SELECT`** (bukan INSERT/CREATE TABLE)
- [ ] Cek nama kolom yang dikembalikan SP — view merender header secara dinamis, tapi logic subtotal/grouping mungkin perlu disesuaikan
- [ ] Untuk LM13/LM16: grouping subtotal berdasarkan **2 karakter pertama kolom `kode`**
- [ ] Untuk LM14: kolom subtotal dideteksi via partial match `barang_bahan | biaya_pemeliharaan | biaya_total`
- [ ] Untuk LM34: kolom dideteksi via regex pattern (ID vs harga vs volume vs nilai)

---

## File-File Kunci

| File | Fungsi |
|------|--------|
| `app/Http/Controllers/BigQueryController.php` | Semua endpoint data LM + `runBigQueryCall()` |
| `app/Http/Controllers/PageController.php` | Method render halaman LM (baris ~1557–1610) |
| `resources/views/pages/lm13.blade.php` | View LM13 |
| `resources/views/pages/lm14.blade.php` | View LM14 (paling kompleks, 1356 baris) |
| `resources/views/pages/lm16.blade.php` | View LM16 |
| `resources/views/pages/lm34.blade.php` | View LM34 |
| `resources/views/pages/lm34_tab.blade.php` | View LM34 (versi tab) |
| `routes/web.php` | Route halaman + API endpoint LM |

---

## 📋 Changelog — Riwayat Perubahan Kode LM

> Setiap perubahan kode yang menyangkut fitur LM **wajib** dicatat di sini.
> Format entry: `[YYYY-MM-DD] | [File yang berubah] | [Deskripsi singkat perubahan]`

### Panduan Pengisian

| Field | Keterangan |
|-------|------------|
| **Tanggal** | Format `YYYY-MM-DD` |
| **File** | Path relatif dari root project, pisahkan dengan koma jika lebih dari 1 file |
| **Tipe** | `FIX` / `FEAT` / `REFACTOR` / `STYLE` / `DOCS` / `SP` (perubahan di BigQuery SP) |
| **Deskripsi** | Penjelasan singkat apa yang berubah dan alasannya |

---

### Entri Perubahan

#### 2026-05-21 — Fix: BigQuery CALL via `runBigQueryCall()` (Child Job Iterator)

| Field | Detail |
|-------|--------|
| **Tipe** | FIX |
| **File** | `app/Http/Controllers/BigQueryController.php` |
| **Masalah** | Library `google/cloud-bigquery` v1.36 tidak mengembalikan rows pada parent job untuk statement `CALL`. `PHP Warning: Undefined array key "schema"` |
| **Fix** | Ganti `runQuery()` → `startQuery()` + `waitUntilComplete()`. Iterasi semua child jobs, ambil rows dari child job terakhir yang memiliki schema/rows |
| **Dampak** | Semua endpoint LM (`get_data_lm13`, `lm14`, `lm16`, `lm34`, dll.) kini menggunakan `runBigQueryCall()` yang sudah diperbaiki |

#### 2026-05-21 — Fix: LM16 Data Kosong karena SP Diakhiri DML

| Field | Detail |
|-------|--------|
| **Tipe** | FIX + SP |
| **File** | `resources/views/pages/lm16.blade.php` + SP BigQuery `sp_laporan_lm16_*` |
| **Masalah** | SP LM16 sebelumnya diakhiri `CREATE TEMP TABLE AS SELECT`, bukan `SELECT`. Child job terakhir adalah DDL → tidak ada rows yang bisa dibaca |
| **Fix** | Tambahkan `SELECT * FROM temp_result` di baris terakhir setiap SP LM16 (karet/teh/kopi) di BigQuery console |
| **Dampak** | Data LM16 muncul setelah SP diperbaiki |

#### 2026-05-21 — Fix: JS Error `RATIO_COLS is not defined` di LM16

| Field | Detail |
|-------|--------|
| **Tipe** | FIX |
| **File** | `resources/views/pages/lm16.blade.php` |
| **Masalah** | Referensi ke variabel `RATIO_COLS` yang tidak pernah dideklarasikan menyebabkan JS error |
| **Fix** | Hapus/ganti referensi variabel tersebut |

#### 2026-06-09 — FIX: 504 Timeout Handling & Optimasi Child Job Iterator

| Field | Detail |
|-------|--------|
| **Tipe** | FIX + REFACTOR |
| **File** | `app/Http/Controllers/BigQueryController.php`, `resources/views/pages/lm13.blade.php` |
| **Masalah** | SP BigQuery memakan waktu > batas timeout Nginx (~60 detik) di production, menyebabkan 504 Gateway Timeout. Frontend menampilkan error "Unexpected token '<'" karena mencoba parse HTML error page sebagai JSON |
| **Perubahan** | (1) Tambah `ignore_user_abort(true)` agar PHP tetap jalan di background meski koneksi user putus. (2) Tambah `Cache::remember` 30 menit per kombinasi parameter. (3) Ganti iterasi child jobs dari sequential ke **reverse + break** — langsung ambil child job terakhir tanpa download intermediate results. (4) Frontend LM13: cek HTTP status sebelum parse JSON, tampilkan pesan 504 yang ramah, dan **auto-retry otomatis** maksimal 3x setiap 12 detik jika 504 terjadi |
| **Dampak** | Semua endpoint LM (LM13, LM14, LM16, LM34, LM34_by_negara, LM34_by_customer, LM62). LM13 frontend mendapat auto-retry |
| **Catatan** | Root cause sesungguhnya adalah timeout Nginx di server managed service. Solusi permanen: minta pihak server naikkan `fastcgi_read_timeout` dan `proxy_read_timeout` ke 300 detik |

---

 
========================================================
  TEMPLATE ENTRY BARU — copy-paste di atas baris ini
========================================================

#### YYYY-MM-DD — [Tipe]: [Judul singkat perubahan]

| Field | Detail |
|-------|--------|
| **Tipe** | FIX / FEAT / REFACTOR / STYLE / SP |
| **File** | `path/ke/file.php`, `path/ke/file.blade.php` |
| **Masalah / Latar belakang** | Jelaskan konteks / bug / kebutuhan |
| **Perubahan** | Apa yang diubah secara teknis |
| **Dampak** | Halaman / endpoint / SP mana yang terpengaruh |

======================================================== 
-->

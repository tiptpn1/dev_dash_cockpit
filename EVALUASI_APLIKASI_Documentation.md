# Dokumentasi Modul Evaluasi Aplikasi — Dev Dash Cockpit

> **Project**: `dev_dash_cockpit` (Laravel 10)  
> **Database**: MySQL (koneksi `hris` — database HRIS terpisah)  
> **Regional Default**: `SuppCo HO`  
> **Halaman**: `/evaluasi-aplikasi`

---

## Ringkasan Modul

Modul **Evaluasi Kinerja Aplikasi** adalah dashboard monitoring kehadiran/absensi karyawan yang datanya diambil dari database HRIS. Saat ini hanya aplikasi **HRIS** yang memiliki data aktif — aplikasi lain (Digital Farming, MAIA, MONIKA, SAPA-Amanah) menampilkan placeholder "belum tersedia".

Modul ini mendukung **dua mode akses**:
1. **Session login biasa** — user login ke Dashcockpit, lalu kunjungi `/evaluasi-aplikasi`
2. **Static token via URL** — akses langsung tanpa login: `/evaluasi-aplikasi?token=ptpn1-hris-eval-2024-xK9mPqRs`

---

## Daftar Route

| Route | Method | Controller | Fungsi |
|-------|--------|------------|--------|
| `/evaluasi-aplikasi` | GET | `PageController::evaluasi_aplikasi()` | Halaman utama evaluasi |
| `/evaluasi-aplikasi/hris-data` | GET | `PageController::evaluasi_hris_data()` | API: Rekap absensi per divisi |
| `/evaluasi-aplikasi/hris-detail` | GET | `PageController::evaluasi_hris_detail()` | API: Detail karyawan per divisi |
| `/evaluasi-aplikasi/hris-divisi` | GET | `PageController::evaluasi_hris_divisi()` | API: Daftar divisi |
| `/evaluasi-aplikasi/hris-harian` | GET | `PageController::evaluasi_hris_harian()` | API: Absensi harian per tanggal |
| `/evaluasi-aplikasi/hris-perkaryawan` | GET | `PageController::evaluasi_hris_perkaryawan()` | API: Riwayat absensi per karyawan |
| `/evaluasi-aplikasi/hris-pegawai-list` | GET | `PageController::evaluasi_hris_pegawai_list()` | API: Pencarian karyawan (autocomplete) |
| `/evaluasi-aplikasi/hris-regional-list` | GET | `PageController::evaluasi_hris_regional_list()` | API: Daftar regional (saat ini hardcoded) |

**Middleware**: `check.token.or.session` (grup `web`)

---

## Arsitektur & Data Flow

```
Browser (evaluasi.blade.php)
    │
    │  Fetch API (AJAX)
    │  GET /evaluasi-aplikasi/hris-data?periode=2026-05
    ▼
PageController::evaluasi_hris_data()
    │
    │  1. Validasi format periode (YYYY-MM)
    │  2. Konversi ke format HRIS: "052026" (MMYYYY)
    │  3. Cek apakah pakai tabel `absensi_import` atau `absensi`
    │  4. Query ke database HRIS (koneksi 'hris')
    ▼
JSON Response: { status, periode, regional, total, summary, data }
    │
    ▼
JavaScript — render tabel dinamis + progress bar kehadiran
```

---

## Middleware: CheckTokenOrSession

**File**: `app/Http/Middleware/CheckTokenOrSession.php`

### Logika Validasi (urutan prioritas):

```
1. Cek ?token= di URL
   ├─ Token valid → login sebagai 'token_access_user', simpan ke session
   ├─ Token tidak valid → abort 403
   └─ Tidak ada token → lanjut ke step 2

2. Cek session('url_token_valid') === true
   └─ Jika ya → akses diizinkan (token sudah divalidasi sebelumnya)

3. Cek Auth::guard('custom')->check()
   └─ Jika ya → akses diizinkan (login biasa)

4. Tidak ada token & tidak login → redirect ke login
```

### Token Statis yang Valid:

| Token | Keterangan |
|-------|------------|
| `ptpn1-hris-eval-2024-xK9mPqRs` | HRIS Dashboard (permanent) |
| `agrinav-cockpit-token-LzW3nYvB` | Agrinav Integration (permanent) |

### Token Mode Behavior:
- Sidebar disembunyikan
- Dropdown aplikasi di-lock ke "HRIS" (readonly)
- Layout full-width

---

## Database Schema (Koneksi `hris`)

### Tabel yang Digunakan:

| Tabel | Fungsi |
|-------|--------|
| `pegawai` | Master data karyawan (pegawai_id, nik, nama, jabatan, divisi, regional, regional_kode, area_kode) |
| `absensi` | Data absensi real-time (pegawai_id, jam, jenis_absen, latitude, longitude, alamat) |
| `absensi_import` | Data absensi import/batch (pegawai_id, periode, tanggal_date, checkin_time, checkout_time, jenis_absen, checkin_lat, checkin_long, alamat, psa, mood_in, mood_out, hari_kerja) |
| `absensi_periode` | Konfigurasi hari kerja per regional/area per periode (regional_kode, area_kode, periode, hari_kerja) |
| `presensi_pegawai` | Data mood masuk/pulang (id_pegawai, tanggal, periode, mood_masuk, mood_pulang) |

### Koneksi Database:

```php
// config/database.php
'hris' => [
    'driver' => env('DB_CONNECTION_HRIS', 'mysql'),
    'host' => env('DB_HOST_HRIS', '127.0.0.1'),
    'port' => env('DB_PORT_HRIS', '3306'),
    'database' => env('DB_DATABASE_HRIS', 'forge'),
    'username' => env('DB_USERNAME_HRIS', 'forge'),
    'password' => env('DB_PASSWORD_HRIS', ''),
]
```

### Format Periode HRIS:

```
Input user: "2026-05" (YYYY-MM)
Format HRIS: "052026" (MMYYYY) — digunakan di kolom `periode` tabel absensi_import & absensi_periode
```

Konversi: `str_pad(bulan, 2, '0', STR_PAD_LEFT) . tahun`

---

## Dual Data Source Strategy

Sistem otomatis memilih sumber data berdasarkan ketersediaan data import:

```php
private function hrisUsesImportData(string $periodeHris): bool
{
    $importCount = DB::connection('hris')
        ->selectOne('SELECT COUNT(*) AS c FROM absensi_import WHERE periode = ?', [$periodeHris]);
    return ($importCount->c ?? 0) > 0;
}
```

| Kondisi | Sumber Data | Keterangan |
|---------|-------------|------------|
| `absensi_import` ada data untuk periode | Tabel `absensi_import` | Data batch/import (lebih lengkap) |
| `absensi_import` kosong untuk periode | Tabel `absensi` | Data real-time (fallback) |

---

## API Endpoints — Detail

### 1. `/evaluasi-aplikasi/hris-data` — Rekap per Divisi

**Parameter:**
| Param | Format | Wajib | Default |
|-------|--------|-------|---------|
| `periode` | `YYYY-MM` | Tidak | Bulan berjalan |

**Response:**
```json
{
  "status": "success",
  "periode": "2026-05",
  "regional": "SuppCo HO",
  "total": 8,
  "summary": {
    "divisi": "RATA-RATA KESELURUHAN — SuppCo HO",
    "hari_kerja": 22,
    "jumlah_pegawai": 150,
    "persentase_kehadiran": 87.5,
    "is_summary": true
  },
  "data": [
    {
      "divisi": "IT",
      "hari_kerja": 22,
      "jumlah_pegawai": 12,
      "persentase_kehadiran": 95.2
    }
  ]
}
```

**Logika Perhitungan Kehadiran:**
```sql
ROUND(AVG(
    CASE WHEN COALESCE(b.hari_kerja, 0) > 0
    THEN COALESCE(att.check_in, 0) / b.hari_kerja * 100
    ELSE 0 END
), 1) AS persentase_kehadiran
```

---

### 2. `/evaluasi-aplikasi/hris-detail` — Detail Karyawan per Divisi

**Parameter:**
| Param | Format | Wajib |
|-------|--------|-------|
| `periode` | `YYYY-MM` | Tidak (default: bulan ini) |
| `divisi` | String | Ya |

**Response fields per karyawan:**
- `pegawai_id`, `pegawai_nik`, `nama`, `jabatan`
- `hari_kerja` — jumlah hari kerja dalam periode
- `absensi` — total hari absen (WFO + WFH + Izin + Dinas)
- `cnt_wfo`, `cnt_wfh`, `cnt_izin`, `cnt_dinas` — breakdown per jenis
- `persentase_kehadiran` — (absensi / hari_kerja × 100)
- `belum_absen` — flag 1/0

**Sorting:** Belum absen di atas, lalu persentase kehadiran ASC, lalu nama ASC.

---

### 3. `/evaluasi-aplikasi/hris-harian` — Absensi Harian

**Parameter:**
| Param | Format | Wajib |
|-------|--------|-------|
| `periode` | `YYYY-MM` | Tidak |
| `divisi` | String | Tidak (kosong = semua divisi) |
| `tanggal` | `YYYY-MM-DD` | Ya |
| `status` | `sudah` / `belum` | Tidak |

**Validasi:** Tanggal harus berada dalam periode yang dipilih.

**Response fields per karyawan:**
- `nama`, `pegawai_nik`, `divisi`, `jabatan`, `tanggal`
- `hari_kerja`, `checkin_time`, `checkout_time`
- `latitude`, `longitude`, `lokasi`
- `jenis_absen`, `mood_masuk`, `mood_pulang`

---

### 4. `/evaluasi-aplikasi/hris-perkaryawan` — Riwayat per Karyawan

**Parameter:**
| Param | Format | Wajib |
|-------|--------|-------|
| `periode` | `YYYY-MM` | Tidak |
| `pegawai_id` | String | Ya |
| `tanggal_awal` | `YYYY-MM-DD` | Ya |
| `tanggal_akhir` | `YYYY-MM-DD` | Ya |

**Validasi:** Kedua tanggal harus berada dalam periode yang dipilih.

---

### 5. `/evaluasi-aplikasi/hris-pegawai-list` — Pencarian Karyawan

**Parameter:**
| Param | Format | Wajib |
|-------|--------|-------|
| `search` | String (min 3 karakter) | Ya |
| `regional` | String | Ya |

**Response:** Max 20 hasil, search by nama LIKE atau nik LIKE.

---

### 6. `/evaluasi-aplikasi/hris-regional-list` — Daftar Regional

**Response:** Saat ini hardcoded return `"SuppCo HO"`.

---

## Tampilan (Frontend)

### Struktur Halaman

```
evaluasi.blade.php
├── Page Header (logo Danantara + judul + logo PTPN1)
├── Filter Card
│   └── Dropdown: Nama Aplikasi (Digital Farming, HRIS, MAIA, MONIKA, SAPA-Amanah)
│       └── Token mode: locked ke HRIS
├── Table Card
│   ├── Table Header (judul + badge regional + count)
│   ├── HRIS Tabs (hanya muncul jika app = HRIS)
│   │   ├── Tab 1: Rekap Kehadiran
│   │   │   ├── Filter: Periode (month picker)
│   │   │   └── Tabel: No | Divisi | Hari Kerja | Persentase Kehadiran
│   │   │       ├── Summary row (rata-rata keseluruhan, background hijau gelap)
│   │   │       ├── Divisi rows (klik untuk expand detail karyawan)
│   │   │       └── Detail rows (nested table per divisi)
│   │   ├── Tab 2: Detail Harian
│   │   │   ├── Filter: Divisi | Status | Tanggal | Export Excel
│   │   │   └── Tabel: No | Nama | NIK | Divisi | Status | Hari Kerja | Check In | Mood In | Check Out | Mood Out | Lokasi | Jenis
│   │   └── Tab 3: Detail per Karyawan
│   │       ├── Filter: Regional | Nama (autocomplete) | Tanggal Awal | Tanggal Akhir
│   │       └── Tabel: No | Tanggal | NIK | Hari Kerja | Check In | Mood In | Check Out | Mood Out | Lokasi | Jenis
│   └── Non-HRIS Wrapper (placeholder "belum tersedia")
├── Popup: Info Ketentuan Absensi (WFO, WFH, Izin, Dinas)
└── Popup: Map Lokasi (Leaflet.js + OpenStreetMap)
```

### Tab 1: Rekap Kehadiran

- Menampilkan rekap per divisi untuk regional "SuppCo HO"
- Baris pertama = **summary row** (rata-rata keseluruhan, background gradient hijau gelap)
- Setiap baris divisi bisa di-klik untuk expand detail karyawan (accordion)
- Progress bar visual untuk persentase kehadiran
- Color coding:
  - ≥ 98%: Hijau
  - ≥ 95%: Biru
  - < 95%: Kuning/amber

### Tab 2: Detail Harian

- Filter per divisi, status (sudah/belum absen), dan tanggal spesifik
- Menampilkan semua karyawan dengan status absensi hari itu
- Badge "BELUM ABSEN" untuk yang belum check-in
- Pin lokasi (icon map) yang bisa diklik untuk membuka popup peta
- **Export Excel** (ExcelJS) dengan format:
  - Header hijau, alternating rows, status berwarna (merah/hijau)
  - Filename: `Detail_Harian_{divisi}_{tanggal}.xlsx`

### Tab 3: Detail per Karyawan

- Autocomplete pencarian karyawan (min 3 huruf, max 20 hasil)
- Range tanggal dalam satu periode
- Menampilkan riwayat absensi harian karyawan terpilih
- Pin lokasi dengan popup peta

### Popup Peta (Leaflet.js)

- Library: Leaflet 1.9.4 + OpenStreetMap tiles
- Fitur: Auto-detect & koreksi koordinat yang tertukar (lat/lng swap)
- Menampilkan: marker, info lokasi, latitude, longitude

---

## Jenis Absensi yang Dihitung

```php
private const HRIS_JENIS_ABSENSI = ['WFO', 'WFH', 'IZIN', 'DINAS'];
```

| Jenis | Keterangan |
|-------|------------|
| WFO | Work From Office |
| WFH | Work From Home |
| IZIN / IJIN | Izin (kedua ejaan diterima) |
| DINAS | Dinas luar |

---

## JavaScript Libraries (CDN)

| Library | Versi | Fungsi |
|---------|-------|--------|
| Leaflet | 1.9.4 | Peta lokasi absensi |
| ExcelJS | 4.4.0 | Export Excel (tab harian) |
| Font Awesome | (dari layout) | Icons |

---

## Sidebar Visibility

Halaman ini muncul di sidebar hanya jika:
```php
// layouts/sidebar.blade.php
@if($username == 'hris' || $username == 'superadmin')
    @if($user && $user->evaluasi_aplikasi)
        <a href="/evaluasi-aplikasi">Evaluasi Aplikasi</a>
    @endif
@endif
```

Syarat: username = `hris` atau `superadmin`, DAN field `evaluasi_aplikasi` pada user = truthy.

---

## Styling & Design System

| Elemen | Warna/Style |
|--------|-------------|
| Primary color | `#166534` (hijau gelap) |
| Header background | `#166534` |
| Table header | `#15803d` |
| Summary row | Gradient `#14532d` → `#166534` |
| Hover row | `#f0fdf4` |
| Active divisi | `#dcfce7` |
| Belum absen badge | Background `#fef2f2`, border `#fecaca`, text `#991b1b` |
| Error banner | Background `#fef2f2`, text `#991b1b` |
| Font | Google Sans / Inter |
| Border radius | 6-8px |

---

## File-File Kunci

| File | Fungsi |
|------|--------|
| `app/Http/Controllers/PageController.php` (baris ~2056–2850) | Semua method evaluasi |
| `app/Http/Middleware/CheckTokenOrSession.php` | Middleware token/session |
| `resources/views/pages/evaluasi.blade.php` (1898 baris) | View utama |
| `resources/views/layouts/sidebar.blade.php` | Menu sidebar (visibility check) |
| `routes/web.php` (baris ~127–139) | Route definitions |
| `config/database.php` (koneksi `hris`) | Database HRIS config |

---

## Catatan & Known Issues

1. **Regional hardcoded** — Saat ini regional di-hardcode ke `SuppCo HO`. Endpoint `hris-regional-list` hanya return string statis, bukan query database.

2. **Aplikasi selain HRIS** — Hanya menampilkan placeholder. Belum ada implementasi data untuk Digital Farming (redirect ke `/dfarmkaret`), MAIA, MONIKA, SAPA-Amanah.

3. **Token statis** — Token di-hardcode di middleware PHP. Untuk production sebaiknya dipindah ke database atau environment variable.

4. **Koordinat tertukar** — Ada logic auto-swap di JavaScript jika latitude > 90 (mendeteksi lat/lng yang tertukar dari data HRIS).

5. **Ejaan IZIN/IJIN** — Query SQL meng-handle kedua ejaan: `UPPER(TRIM(jenis_absen)) IN ('IZIN', 'IJIN')`.

6. **Export Excel** — Hanya tersedia di Tab 2 (Detail Harian). Tab 1 dan Tab 3 belum ada fitur export.

---

## Contoh Akses

### Via Token (tanpa login):
```
http://localhost:8001/evaluasi-aplikasi?token=ptpn1-hris-eval-2024-xK9mPqRs
```

### Via Login Biasa:
```
1. Login ke http://localhost:8001/login
2. Kunjungi http://localhost:8001/evaluasi-aplikasi
```

### API Test (setelah punya session/token):
```bash
# Rekap per divisi
curl "http://localhost:8001/evaluasi-aplikasi/hris-data?periode=2026-05"

# Detail karyawan divisi IT
curl "http://localhost:8001/evaluasi-aplikasi/hris-detail?periode=2026-05&divisi=IT"

# Absensi harian tanggal tertentu
curl "http://localhost:8001/evaluasi-aplikasi/hris-harian?periode=2026-05&tanggal=2026-05-20&divisi=IT"

# Riwayat per karyawan
curl "http://localhost:8001/evaluasi-aplikasi/hris-perkaryawan?periode=2026-05&pegawai_id=123&tanggal_awal=2026-05-01&tanggal_akhir=2026-05-31"

# Pencarian karyawan
curl "http://localhost:8001/evaluasi-aplikasi/hris-pegawai-list?search=Ahmad&regional=SuppCo%20HO"
```

---

## Diagram Interaksi Tab

```
┌─────────────────────────────────────────────────────────────────┐
│  Tab 1: Rekap Kehadiran                                         │
│                                                                  │
│  [Periode: 2026-05]                                             │
│                                                                  │
│  ┌─────────────────────────────────────────────────────────┐    │
│  │ RATA-RATA KESELURUHAN — SuppCo HO (150 karyawan)       │    │
│  │ 22 Hari  ████████████████████░░░░ 87.5%                │    │
│  └─────────────────────────────────────────────────────────┘    │
│                                                                  │
│  1. IT (12 karyawan)        22 Hari  ████████████████████ 95.2% │
│     └─ [EXPAND] Detail karyawan IT                              │
│        ├─ Ahmad (NIK 001) — 20/22 hari — 90.9%                 │
│        ├─ Budi (NIK 002) — 22/22 hari — 100%                   │
│        └─ ...                                                    │
│  2. Finance (8 karyawan)    22 Hari  ██████████████████░░ 88.0% │
│  3. ...                                                          │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│  Tab 2: Detail Harian                                           │
│                                                                  │
│  [Divisi: IT] [Status: SEMUA] [Tanggal: 2026-05-20] [Excel]    │
│                                                                  │
│  No | Nama    | NIK  | Divisi | Status      | Check In | ...    │
│  1  | Ahmad   | 001  | IT     | SUDAH ABSEN | 07:45    | ...    │
│  2  | Charlie | 003  | IT     | BELUM ABSEN | -        | ...    │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│  Tab 3: Detail per Karyawan                                     │
│                                                                  │
│  [Regional: SuppCo HO] [Nama: Ahm...▼] [01/05] s/d [31/05]    │
│                                                                  │
│  No | Tanggal    | NIK | Hari Kerja | Check In | Mood | ...     │
│  1  | 2026-05-20 | 001 | 22         | 07:45    | 😊   | ...     │
│  2  | 2026-05-19 | 001 | 22         | 08:01    | 😐   | ...     │
└─────────────────────────────────────────────────────────────────┘
```

---

**Dokumentasi dibuat:** 2026-05-29  
**Status:** Aktif & Production-ready (untuk HRIS)

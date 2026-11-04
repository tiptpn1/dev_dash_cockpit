# MANUAL BOOK & PANDUAN PENGGUNA
## SISTEM INFORMASI AGRINAV
### (Asset and Agribusiness Navigation Dashboard)
**PT Perkebunan Nusantara I (PTPN I)**

---

## DAFTAR ISI
1. [Pendahuluan & Gambaran Umum Sistem](#1-pendahuluan--gambaran-umum-sistem)
2. [Kebijakan Keamanan Informasi (SMKI) & Aksesibilitas](#2-kebijakan-keamanan-informasi-smki--aksesibilitas)
3. [Alur Autentikasi & Akun Pengguna](#3-alur-autentikasi--akun-pengguna)
   - 3.1. [Tampilan dan Interaksi Halaman Login](#31-tampilan-dan-interaksi-halaman-login)
   - 3.2. [Proses Login Langkah-demi-Langkah](#32-proses-login-langkah-demi-langkah)
   - 3.3. [Penanganan Khusus Akun Regional (Auto-Routing)](#33-penanganan-khusus-akun-regional-auto-routing)
   - 3.4. [Fitur Mandiri Ubah Password](#34-fitur-mandiri-ubah-password)
   - 3.5. [Proses Logout Aman](#35-proses-logout-aman)
4. [Struktur Tata Letak (Layout) & Navigasi Dashboard](#4-struktur-tata-letak-layout--navigasi-dashboard)
   - 4.1. [Tombol Toggle Sidebar & Menu Melayang](#41-tombol-toggle-sidebar--menu-melayang)
   - 4.2. [Perilaku Sidebar Dinamis (Berdasarkan Hak Akses)](#42-perilaku-sidebar-dinamis-berdasarkan-hak-akses)
   - 4.3. [Cara Berinteraksi dengan Dashboard Terintegrasi (Looker Studio)](#43-cara-berinteraksi-dengan-dashboard-terintegrasi-looker-studio)
5. [Panduan Utama: Modul Manajemen Sistem (System Management)](#5-panduan-utama-modul-manajemen-sistem-system-management)
   - 5.1. [Manajemen Pengguna (User Management)](#51-manajemen-pengguna-user-management)
     - A. Melihat & Mencari Data Pengguna
     - B. Menambah Pengguna Baru
     - C. Mengubah Data & Reset Password Pengguna
     - D. Menghapus Pengguna
     - E. Export Data Pengguna ke Excel
   - 5.2. [Manajemen Fitur & Menu (Feature Management)](#52-manajemen-fitur--menu-feature-management)
     - A. Tampilan Hirarki Pohon Menu (Accordion View)
     - B. Fitur Drag & Drop Urutan Menu (Reordering)
     - C. Menambah Fitur Baru
     - D. Mengubah & Menghapus Fitur
     - E. Kamus Hirarki Fitur & Export Excel
   - 5.3. [Manajemen Hak Akses Pengguna (Access Management)](#53-manajemen-hak-akses-pengguna-access-management)
     - A. Ringkasan Matriks Akses Pengguna
     - B. Formulir Penetapan Akses (Smart Group Checkbox)
     - C. Fitur Mandiri / Direct Menus
     - D. Export Matriks Hak Akses ke Excel (.xlsx Cross-Tab)
   - 5.4. [Pemantauan Riwayat Login (Last Login Monitoring)](#54-pemantauan-riwayat-login-last-login-monitoring)
     - A. Membaca Data Aktivitas Login Terakhir
     - B. Pencarian & Export Excel Last Login
6. [Fitur Lokal Khusus & Interaktif](#6-fitur-lokal-khusus--interaktif)
   - 6.1. [AGRO Skyview Table (CRUD Video Monitoring Unit)](#61-agro-skyview-table-crud-video-monitoring-unit)
   - 6.2. [Portal Aplikasi & Evaluasi Terintegrasi](#62-portal-aplikasi--evaluasi-terintegrasi)
   - 6.3. [Fitur Asisten AI & Log Viewer (Admin)](#63-fitur-asisten-ai--log-viewer-admin)
7. [Katalog Ringkas Modul Bisnis & Dashboard Eksekutif](#7-katalog-ringkas-modul-bisnis--dashboard-eksekutif)
8. [Panduan Pemecahan Masalah (Troubleshooting & FAQ)](#8-panduan-pemecahan-masalah-troubleshooting--faq)

---

## 1. PENDAHULUAN & GAMBARAN UMUM SISTEM

### 1.1. Latar Belakang
**AGRINAV** (*Asset and Agribusiness Navigation Dashboard*) adalah platform *executive dashboard cockpit* terintegrasi milik **PT Perkebunan Nusantara I (Persero)**. Sistem ini dirancang untuk menyatukan data operasional, keuangan, pemasaran, aset, sumber daya manusia, legal, hingga pelaporan manajemen ke dalam satu pintu akses terpusat (*Single Portal View*).

### 1.2. Karakteristik Aplikasi
Sebagian besar tampilan modul analitik di AGRINAV berupa **visualisasi dashboard terintegrasi** (Google Looker Studio / BigQuery Engine) yang memiliki struktur antarmuka dan kendali seragam. Oleh karena itu, fokus utama manual book ini dititikberatkan pada:
1. **Keamanan, Autentikasi, dan Tata Kelola Akun (Login & Password)**.
2. **Modul Manajemen Sistem (System Management)** yang memiliki alur kerja interaktif (CRUD User, Manajemen Hirarki Fitur, Matriks Hak Akses Granular, dan Audit Last Login).
3. **Standar Operasional Penggunaan Dashboard & Penanganan Kendala Teknis**.

---

## 2. KEBIJAKAN KEAMANAN INFORMASI (SMKI) & AKSESIBILITAS

Sesuai dengan komitmen PT Perkebunan Nusantara I (Persero) terhadap standar keamanan data dan Sistem Manajemen Keamanan Informasi (SMKI), setiap pengguna yang mengakses sistem AGRINAV terikat oleh ketentuan berikut:

1. **Prinsip *Need-to-Know* & *Least Privilege*:**
   Pengguna hanya diberikan wewenang membuka data/fitur yang relevan langsung dengan tugas dan jabatannya. Modul yang tidak diberi izin oleh Administrator tidak akan muncul di navigasi.
2. **Kerahasiaan Kredensial:**
   Dilarang keras membagikan akun (*username* & *password*) kepada pihak lain. Setiap tindakan dalam sistem dicatat atas nama pemilik akun.
3. **Kepatuhan Perlindungan Data Pribadi (UU PDP):**
   Seluruh data karyawan, data finansial, dan rahasia dagang perusahaan wajib dijaga kerahasiaannya.
4. **Perekaman Jejak Aktivitas (Audit Trail):**
   Sistem mencatat waktu login terakhir, IP pemanggil, dan perubahan akses untuk kebutuhan audit berkala.
5. **Kewajiban Penggantian Password Berkala:**
   Pengguna wajib mengganti password berkala dengan spesifikasi: minimal 8 karakter, kombinasi huruf besar/kecil, angka, dan karakter spesial.

---

## 3. ALUR AUTENTIKASI & AKUN PENGGUNA

### 3.1. Tampilan dan Interaksi Halaman Login
Saat mengakses URL utama AGRINAV (`/login`), pengguna akan disambut oleh halaman otentikasi dengan proteksi berlapis:

```
+-------------------------------------------------------------------------+
|                                                                         |
|   +-----------------------------------------------------------------+   |
|   |  [MODAL POPUP: KEBIJAKAN KEAMANAN INFORMASI (SMKI)]             |   |
|   |  Komitmen manajemen & seluruh karyawan terhadap keamanan data. |   |
|   |  Aturan kredensial, privasi data, dan pergantian password.       |   |
|   |  [ Tombol: "Saya sudah membaca & Setuju" ]                      |   |
|   +-----------------------------------------------------------------+   |
|                                                                         |
|         +-----------------------------------------------------+         |
|         |                     [LOGO PTPN I]                   |         |
|         |    Asset and Agribusiness Navigation Dashboard      |         |
|         |                       PTPN I                        |         |
|         |                   "Welcome Back"                    |         |
|         |                                                     |         |
|         |  Username:          [___________________________]   |         |
|         |  Password:          [_______________________] [👁]  |         |
|         |  Kode Keamanan:     [ G 7 X 9 K ] [🔄] [________]   |         |
|         |                                                     |         |
|         |  [             TOMBOL: LOGIN             ]          |         |
|         |                                                     |         |
|         |  🛡️ Baca Kebijakan Keamanan Informasi (SMKI)         |         |
|         +-----------------------------------------------------+         |
+-------------------------------------------------------------------------+
```

#### Komponen Utama Form Login:
- **Modal Persetujuan SMKI:** Muncul otomatis saat halaman dibuka pertama kali. Pengguna wajib mengklik tombol **"Saya sudah membaca & Setuju"** agar form login dapat diakses. Link SMKI dapat dibuka kembali sewaktu-waktu di bawah tombol Login.
- **Field Username:** Masukkan nama akun yang terdaftar (contoh: NIK, username unit, atau nama akun).
- **Field Password dengan Toggle Show/Hide [👁]:** Membantu memeriksa ketikan password agar tidak salah ketik sebelum dikirim.
- **SVG Captcha (5 Karakter Alfanumerik):** Perlindungan dari serangan brute-force dan bot otomatis. Dilengkapi tombol **Refresh [🔄]** untuk mengganti kombinasi kode jika sulit terbaca.

### 3.2. Proses Login Langkah-demi-Langkah
1. Buka peramban (browser) yang direkomendasikan: **Google Chrome** atau **Microsoft Edge** versi terbaru.
2. Akses alamat web AGRINAV.
3. Pada pop-up SMKI, baca ringkasan ketentuan keamanan, lalu klik **"Saya sudah membaca & Setuju"**.
4. Masukkan **Username** dan **Password** Anda.
5. Perhatikan gambar kode acak pada kotak Captcha, lalu ketikkan 5 huruf/angka tersebut pada kolom **Kode Keamanan**.
6. Klik tombol **Login**.
7. Jika data valid, sistem akan mengarahkan pengguna ke halaman utama (*Executive Overview* atau halaman spesifik perannya).

> [!NOTE]
> Jika muncul pesan *"Kode keamanan tidak sesuai"*, klik tombol refresh Captcha lalu ketikkan kembali kode baru. Jika muncul pesan *"Username dan Password Salah"*, periksa kembali huruf besar/kecil (Caps Lock) Anda.

### 3.3. Penanganan Khusus Akun Regional (Auto-Routing)
Sistem AGRINAV memiliki logika otomatisasi rute (*automatic smart redirect*) untuk akun operasional Regional:
- Akun dengan username format `regional1`, `regional2`, `regional3`, `regional5`, `regional7`, `regional8` atau yang terasosiasi dengan regional tertentu **langsung dialihkan secara otomatis ke dashboard Areal Produksi Regional masing-masing**.
- Akun regional juga secara otomatis disembunyikan dari widget chat global untuk menjaga fokus pelaporan wilayah kerja terkait.

### 3.4. Fitur Mandiri Ubah Password
Setiap pengguna disarankan dan diwajibkan mengubah password secara mandiri secara berkala demi keamanan akun.

#### Langkah Mengubah Password:
1. Buka bilah menu sidebar (klik ikon menu di kiri atas).
2. Gulir ke bagian paling bawah sidebar, klik menu **"Ubah Password"** (`/ubah-password`).
3. Pada form yang tampil:
   - **Password Saat Ini:** Masukkan password lama yang saat ini sedang aktif.
   - **Password Baru:** Masukkan password baru (minimal 6 karakter, dianjurkan >= 8 karakter kombinasi huruf, angka, dan simbol).
   - **Konfirmasi Password Baru:** Ketikkan ulang password baru persis sama.
4. Klik tombol **Simpan / Perbarui Password**.
5. Sistem akan menampilkan notifikasi hijau *"Password berhasil diubah"*.

### 3.5. Proses Logout Aman
1. Buka bilah menu sidebar.
2. Klik tombol **"Logout"** di menu paling bawah.
3. Sistem secara otomatis menghapus sesi aktif, menginvalidsi CSRF token, dan mengembalikan tampilan ke halaman login.

---

## 4. STRUKTUR TATA LETAK (LAYOUT) & NAVIGASI DASHBOARD

### 4.1. Tombol Toggle Sidebar & Menu Melayang
Antarmuka AGRINAV mengadopsi konsep **Clean Canvas**: tampilan dashboard disajikan dalam resolusi layar penuh (*full-screen view*) tanpa terganggu bilah menu permanen yang memakan tempat.

- **Ikon Menu Mengambang (Floating Icon):** Berada di sudut kiri atas layar (`top: 10px; left: 10px`).
- Klik ikon tersebut untuk memunculkan bilah navigasi **Sidebar**.
- Pada perangkat mobile/tablet, klik area gelap (backdrop) atau tombol silang `[×]` di kepala sidebar untuk menutup kembali bilah menu.

### 4.2. Perilaku Sidebar Dinamis (Berdasarkan Hak Akses)
Menu yang tampil di sidebar bersifat **100% dinamis dan terpersonalisasi**:
- Menu hanya akan dirender jika akun pengguna telah diberikan izin hak akses (*Feature Access*) oleh Administrator.
- Menu bertingkat (*Parent-Child Accordion*) ditandai dengan tanda panah `▶`. Klik menu induk untuk mengekspansi daftar sub-menu di bawahnya.
- Tautan eksternal (seperti CCTV, GIS, SONIA SSO) secara otomatis ditandai dan akan terbuka pada tab peramban baru (*open in new tab*) tanpa menutup aplikasi AGRINAV.

### 4.3. Cara Berinteraksi dengan Dashboard Terintegrasi (Looker Studio)
Hampir seluruh dashboard analitik AGRINAV disematkan menggunakan teknologi secure embed Looker Studio. Pengguna dapat melakukan hal-hal berikut:

| Fitur Dashboard | Cara Penggunaan |
|---|---|
| **Filter Periode & Regional** | Klik dropdown filter di bagian atas lembar dashboard (misal: Tahun, Bulan, Kebun, Regional). Data di seluruh grafik dan tabel akan terhitung ulang secara instan. |
| **Pindah Halaman Laporan** | Gunakan navigasi halaman di bagian bawah atau kiri kanvas dashboard untuk berpindah sheet/tab. |
| **Mode Layar Penuh (Fullscreen)**| Klik ikon panah diagonal di bilah bawah Looker Studio untuk memaksimalkan visualisasi ke layar monitor/TV display. |
| **Refresh Data** | Arahkan kursor ke titik tiga di pojok kanan dashboard Looker, pilih **"Refresh data"** untuk mengambil angka terkini dari database/BigQuery. |
| **Download / Export Data Grafis** | Klik kanan pada tabel tertentu di dalam dashboard Looker -> pilih **"Export"** (CSV, Excel, atau Google Sheets). |

---

## 5. PANDUAN UTAMA: MODUL MANAJEMEN SISTEM (SYSTEM MANAGEMENT)

> [!IMPORTANT]
> Modul **System Management** hanya dapat diakses oleh pengguna dengan peran **ADMIN** atau **SUPERADMIN** yang memiliki izin slug:
> - `management_users` (Manajemen Pengguna)
> - `management_features` (Manajemen Fitur)
> - `management_access` (Manajemen Hak Akses & Last Login)

```
                       +-------------------------------------------------------+
                       |              MODUL SYSTEM MANAGEMENT                  |
                       +-------------------------------------------------------+
                                   |                   |                   |
            +----------------------+     +-------------+-------+     +-----+-----------------+
            |                            |                           |                       |
   [ User Management ]          [ Feature Management ]      [ Access Management ]   [ Last Login ]
   - Data Pengguna              - Hirarki Menu              - Matriks Akses User    - Audit Login
   - Tambah/Edit/Hapus          - Drag & Drop Urutan        - Smart Checkbox        - Durasi Relatif
   - Reset Password             - Status Aktif & Sidebar    - Cross-Tab Excel       - Export Excel
   - Export Data User           - Export Excel Fitur
```

---

### 5.1. MANAJEMEN PENGGUNA (USER MANAGEMENT)
Rute: `/management/users`

Modul ini digunakan untuk mendaftarkan akun baru, memperbarui identitas pengguna, mengatur peran (*role*), dan menonaktifkan akun yang sudah tidak bertugas.

#### A. Melihat & Mencari Data Pengguna
1. Buka sidebar -> pilih grup **System Management** -> klik sub-menu **User**.
2. Pada halaman utama tabel pengguna, Anda dapat melihat informasi:
   - **No.**
   - **Username**
   - **NIK** (Nomor Induk Karyawan)
   - **Plant / Unit Kerja**
   - **Role Badge:** `SUPERADMIN` (ungu), `ADMIN` (merah), `VIEWER` (kuning), atau role lainnya.
   - **Aksi:** Tombol Edit `[Pensil]` dan Hapus `[Tempat Sampah]`.
3. **Pencarian Data:** Ketikkan username atau NIK pada input pencarian di atas tabel, lalu klik tombol **Search** `[🔍]`. Klik tombol **Clear** untuk mengembalikan daftar lengkap.

#### B. Menambah Pengguna Baru
1. Klik tombol hijau **"+ Tambah User Baru"** di sudut kanan atas.
2. Lengkapi formulir pembuatan user:
   - **Username (Wajib):** Karakter unik minimal 3 karakter (contoh: `agus_ho`, `manager_karet`).
   - **Password (Wajib):** Password awal pengguna (minimal 6 karakter).
   - **NIK (Opsional):** Nomor Induk Karyawan resmi.
   - **Role (Wajib/Pilihan):**
     - `superadmin`: Akses penuh ke seluruh konfigurasi sistem dan log tingkat tinggi.
     - `admin`: Pengelola data operasional dan administrasi user.
     - `viewer_ho`: Pengguna internal Head Office (Kantor Pusat) dengan akses pantau laporan.
     - `viewer_unit`: Pengguna tingkat kebun/unit operasional lapangan.
   - **Plant:** Kode atau nama pabrik/kebun (contoh: `P001`, `Kebun Karet Sei Dadap`).
   - **Regional:** Penugasan regional (contoh: `1`, `2`, `3`, `5`, `7`, `8`).
3. Klik tombol **Simpan**. Sistem akan memvalidasi data dan mengembalikan Anda ke tabel pengguna dengan pesan sukses.

#### C. Mengubah Data & Reset Password Pengguna
1. Pada baris user yang diinginkan, klik tombol aksi **Edit** `[Pensil]`.
2. Anda dapat mengubah data NIK, Role, Plant, Regional, dan Username.
3. **Reset Password:** Jika pengguna lupa password:
   - Ketikkan password baru pada kolom **Password**.
   - Biarkan kolom password kosong jika tidak ingin mengubah password yang sudah ada.
4. Klik tombol **Update User**.

#### D. Menghapus Pengguna
1. Klik tombol **Hapus** `[Merah / Tempat Sampah]` pada baris user yang ingin dihapus.
2. Konfirmasi pop-up browser yang muncul (*"Apakah Anda yakin ingin menghapus user ini?"*).
3. Klik **OK**. Akun beserta seluruh relasi hak aksesnya akan dihapus dari sistem.

#### E. Export Data Pengguna ke Excel
- Klik tombol **"Export Excel"** di sebelah tombol pencarian.
- File spreadsheet `.xls` berisi seluruh daftar pengguna (Username, NIK, Plant, Role) akan otomatis terunduh ke komputer Anda.

---

### 5.2. MANAJEMEN FITUR & MENU (FEATURE MANAGEMENT)
Rute: `/management/features`

Modul ini adalah pusat kendali arsitektur navigasi AGRINAV. Seluruh menu yang tampil di sidebar diatur hierarki, urutan, ikon, dan tautan rutenya melalui modul ini.

#### A. Tampilan Hirarki Pohon Menu (Accordion View)
- Menu ditampilkan dalam struktur induk (*Parent Menu*) dan anak (*Sub-Menu*).
- Setiap kartu menu induk dilengkapi dengan:
  - **Drag Handle `[⠿]`**: Untuk menggeser urutan secara visual.
  - **Tombol Panah `[▼]`**: Untuk membuka/menutup daftar sub-menu.
  - **Badge Ikon FontAwesome**.
  - **Nama Fitur & Slug** (pengenal unik sistem).
  - **Target Rute / URL**.
  - **Status Sidebar & Status Aktif**.
- **Tombol Kontrol Global:**
  - Klik **"Expand All"** untuk membuka seluruh sub-menu sekaligus.
  - Klik **"Collapse All"** untuk melipat seluruh sub-menu.
  - Gunakan input pencarian instan untuk memfilter fitur berdasarkan nama atau slug secara live.

#### B. Fitur Drag & Drop Urutan Menu (Reordering)
AGRINAV dilengkapi teknologi penataan urutan menu interaktif:
1. Klik dan tahan ikon pegangan drag `[⠿]` pada menu induk atau sub-menu yang ingin dipindahkan.
2. Geser mouse ke posisi atas atau bawah yang diinginkan, lalu lepaskan klik (*drag and drop*).
3. Begitu posisi menu bergeser, **Banner Peringatan Kuning** akan muncul di bagian atas:
   > *"Ada perubahan posisi menu yang belum disimpan. Klik 'Simpan Perubahan Urutan' untuk menerapkan ke database."*
4. Tombol **"Simpan Perubahan Urutan"** di kanan atas akan aktif. Klik tombol tersebut untuk menyimpan struktur baru secara permanen.

#### C. Menambah Fitur Baru
1. Klik tombol **"+ Tambah Fitur"**.
2. Isi formulir konfigurasi fitur:
   - **Slug (Wajib):** Kode unik huruf kecil dan underscore tanpa spasi (contoh: `operasional_teh_rekap`). Slug ini menjadi kunci penugasan hak akses.
   - **Nama Fitur (Wajib):** Nama label yang akan dibaca pengguna di sidebar (contoh: `On Farm Teh`).
   - **Menu Induk (Parent ID):** 
     - Pilih *None / Kosong* jika fitur ini adalah menu utama berdiri sendiri.
     - Pilih nama menu induk jika fitur ini adalah sub-menu (contoh: Induk: `Operasional`).
   - **Ikon FontAwesome:** Kode ikon (contoh: `fa-solid fa-chart-line`, `fa-solid fa-leaf`).
   - **URL / Rute:** Alamat URL internal (contoh: `/onfarmteh`) atau eksternal URL (`https://...`).
   - **Urutan (Sort Order):** Angka integer untuk urutan tampil (1, 2, 3...).
   - **Tampilkan di Sidebar (is_sidebar):** Pilih *Ya* agar tampil di bilah navigasi.
   - **Status (is_active):** Pilih *Aktif* untuk mengaktifkan fitur.
   - **Deskripsi:** Catatan fungsional fitur.
3. Klik **Simpan Fitur**.

#### D. Mengubah & Menghapus Fitur
- Klik tombol **Edit** pada fitur terkait untuk memperbarui URL, nama, atau ikon.
- Klik tombol **Hapus** jika fitur sudah dinonaktifkan permanen (menghapus fitur akan otomatis mencabut izin slug fitur tersebut dari seluruh user).

#### E. Kamus Hirarki Fitur & Export Excel
- Anda dapat mengunduh seluruh kamus konfigurasi menu ke spreadsheet dengan mengklik tombol **"Export Excel"** (`/management/features/export`). Hasil unduhan mencantumkan nama, slug, parent, rute URL, sort order, dan status aktif.

---

### 5.3. MANAJEMEN HAK AKSES PENGGUNA (ACCESS MANAGEMENT)
Rute: `/management/access`

Modul ini adalah jantung kendali privasi AGRINAV. Setiap pengguna **hanya dapat melihat menu dashboard yang telah dicentang pada modul ini**.

#### A. Ringkasan Matriks Akses Pengguna
Pada tabel utama Hak Akses:
- Menampilkan daftar setiap pengguna berserta role dan daftar tag slug fitur yang dimilikinya.
- Terdapat kolom **Total Fitur** yang menghitung berapa banyak modul yang diizinkan untuk akun tersebut.
- Kolom pencarian memudahkan mencari pengguna berdasarkan nama atau username.

#### B. Formulir Penetapan Akses (Smart Group Checkbox)
Untuk mengubah atau menetapkan fitur pada seorang pengguna:
1. Klik tombol **"Kelola Akses"** `[Kunci]` di samping kanan baris user target.
2. Anda akan diarahkan ke halaman **Kelola Akses: [Username]** (`/management/access/{user}/edit`).

```
+----------------------------------------------------------------------------------------+
| KELOLA AKSES: budi_operasional                                                         |
|                                                                                        |
| [DAFTAR FITUR SISTEM]                                     [INFO PENGGUNA]              |
|                                                           - Username: budi_operasional |
| [x] [📁 Operasional] ---------------------- (Menu Induk)   - Role: VIEWER               |
|     |                                                     - Plant: Karet Sei Dadap     |
|     +-- [x] AMANAH                                                                     |
|     +-- [x] DFarm PTPN I                                  [AKSES AKTIF SAAT INI (8)]   |
|     +-- [ ] CCTV Monitoring                               - operasional_amanah         |
|     +-- [x] On Farm Karet                                 - operasional_dfarm          |
|                                                           - operasional_onfarmkaret    |
| [ ] [📁 Finansial] ------------------------ (Menu Induk)  - ...                        |
|     +-- [ ] Consolidate                                                                |
|     +-- [ ] Parent Only                                                                |
|                                                                                        |
| [FITUR MANDIRI / DIRECT MENUS]                                                         |
| [ ] MRC Dashboard       [x] Portal Aplikasi                                            |
|                                                                                        |
| [ Tombol: SIMPAN AKSES ]  [ Batal ]                                                    |
+----------------------------------------------------------------------------------------+
```

#### Cara Kerja Fitur Smart Checkbox:
- **Centang Induk Grup:** Mengklik kotak centang pada *Header Folder Menu Induk* (contoh: `Operasional`) akan **secara otomatis mencentang seluruh sub-menu anak di bawahnya**.
- **Hilangkan Centang Induk:** Mengosongkan centang folder induk akan otomatis membatalkan pilihan seluruh sub-menunya.
- **Centang Sub-Menu Tunggal:** Mengklik salah satu sub-menu (misal hanya `On Farm Karet`) akan secara otomatis mengaktifkan status folder induknya agar menu dapat terbuka di sidebar.
- **Panel Akses Aktif:** Di bilah kanan, sistem menampilkan jumlah dan daftar lencana (*badge*) fitur yang saat ini aktif untuk pengguna tersebut.
3. Setelah selesai memilih fitur yang diizinkan, klik tombol hijau **"Simpan Akses"**.
4. Perubahan akan berlaku seketika pada saat pengguna tersebut memuat ulang (*refresh*) halaman atau melakukan login berikutnya.

#### C. Fitur Mandiri / Direct Menus
Fitur mandiri adalah modul yang tidak berada di bawah folder accordion, melainkan berdiri sendiri di sidebar (seperti *MRC*, *Portal Aplikasi*, *AIGR1*, atau *Garda AI*). Pengaturan izinnya dapat dicentang pada blok kartu tersendiri di bagian bawah formulir.

#### D. Export Matriks Hak Akses ke Excel (.xlsx Cross-Tab)
Administrator dapat mengunduh **Matriks Lengkap Hak Akses Pengguna** dalam format Excel resmi:
1. Pada halaman daftar hak akses, klik tombol **"Export Excel"** (`/management/access/export`).
2. Sistem akan menghasilkan berkas Excel `.xlsx` dengan format **Tabel Silang (Cross-Tabulation Matrix)**:
   - **Baris:** Seluruh daftar fitur dan sub-menu terurut sesuai hirarki aplikasi.
   - **Kolom:** Daftar seluruh pengguna sistem beserta rolenya.
   - **Isi Sel:** Ditandai simbol **"V" tebal hijau** jika user memiliki hak akses, atau tanda strip abu-abu `"-"` jika tidak memiliki akses.
3. File ini sangat berguna untuk lampiran audit SMKI, reviu berkala hak akses, dan tata kelola IT governance.

---

### 5.4. PEMANTAUAN RIWAYAT LOGIN (LAST LOGIN MONITORING)
Rute: `/management/lastlogin`

Modul ini berfungsi sebagai instrumen kepatuhan dan audit keamanan informasi untuk memantau keaktifan akun pengguna.

#### A. Membaca Data Aktivitas Login Terakhir
- **No.**
- **Username:** Dilengkapi badge hijau.
- **NIK:** Nomor induk karyawan pemilik akun.
- **Role:** Tingkatan wewenang pengguna.
- **Waktu Login Terakhir:** Menampilkan tanggal, jam, menit, dan detik login terakhir, disertai kalkulasi waktu relatif (contoh: `27 Oct 2026 14:15:22 (2 hours ago)`).
- Jika akun belum pernah masuk sejak dibuat, sistem akan menampilkan label abu-abu *"Belum pernah login"*.

#### B. Pencarian & Export Excel Last Login
- Gunakan input pencarian untuk melacak akun tertentu berdasarkan username, NIK, atau role.
- Klik tombol **"Export Excel"** untuk mengunduh rekap riwayat login ke dalam file Excel berformat rapi untuk pelaporan manajemen.

---

## 6. FITUR LOKAL KHUSUS & INTERAKTIF

Di samping modul dashboard analitik Looker Studio dan Modul Manajemen Sistem, AGRINAV memiliki beberapa fitur interaktif lokal yang memiliki antarmuka khusus:

### 6.1. AGRO Skyview Table (CRUD Video Monitoring Unit)
Rute: `/skyview-table`

Modul ini digunakan untuk mendokumentasikan dan memutar video pantauan udara (*drone skyview monitoring*) pada setiap kebun dan unit operasional.
- **Pencarian & Filter Tanggal:** Memfilter rekaman video berdasarkan nama Kebun/Unit dan rentang tanggal pengambilan video.
- **Form Input Rekaman Drone Baru:**
  1. Klik tombol Tambah Data.
  2. Masukkan nama **Kebun / Unit**.
  3. Pilih **Tanggal Pengambilan**.
  4. Masukkan URL video **Link YouTube** hasil unggahan rekaman udara.
  5. Klik Simpan.
- **Pemutaran Video:** Pengguna dapat mengklik tautan untuk memutar rekaman pemantauan kebun secara langsung.
- **Edit & Hapus:** Administrator unit dapat memperbarui link atau menghapus rekaman lama.

### 6.2. Portal Aplikasi & Evaluasi Terintegrasi
Rute: `/portalaplikasi` dan `/evaluasi-aplikasi`

- **Portal Aplikasi:** Katalog peluncur (*application launcher*) yang mengumpulkan seluruh sistem ekosistem PTPN I ke dalam satu pintu dengan otentikasi terpadu / SSO.
- **Evaluasi Aplikasi (MONIKA, MAIA, AGHRIS):** Dashboard analitik untuk memantau utilisasi, keaktifan pengguna, dan efektivitas aplikasi operasional PTPN I di seluruh regional.

### 6.3. Fitur Asisten AI & Log Viewer (Admin)
- **Asisten Virtual AGRINAV:** Ikon chatbot cerdas di sudut kanan bawah yang siap membantu navigasi data dan informasi operasional bagi pengguna Head Office.
- **Log Viewer System (`/admin/logs`):** Khusus Superadmin untuk memantau kesehatan server, pesan error, uji coba API endpoint, dan diagnosa konektivitas database.

---

## 7. KATALOG RINGKAS MODUL BISNIS & DASHBOARD EKSEKUTIF

Berikut adalah ringkasan modul-modul analitik yang terdaftar di AGRINAV beserta fungsi utamanya:

| Modul | Sub-Menu Unggulan | Deskripsi Bisnis Utama | Tipe Tampilan |
|---|---|---|---|
| **MRC** | MRC Dashboard | Rapat Komite Reviu Manajemen (*Management Review Committee*). | Looker Studio |
| **Operasional** | AMANAH, DFarm, On/Off Farm Karet, Teh, Kopi, SDM Penyadap, CCTV | Pemantauan operasional kebun harian, absensi penyadap, utilisasi pabrik, dan CCTV unit. | Looker Studio & Eksternal |
| **PICA** | Kuadran Problem, List Corrective Actions | Identifikasi akar permasalahan tanaman/pabrik dan matriks rencana tindakan korektif. | Looker Studio |
| **Warehouse** | Gudang Utilisasi | Utilisasi kapasitas tampung gudang logistik dan komoditas per regional. | Looker Studio |
| **Sales** | Overview Sales, Comodities, Tea Inventory, Rubber Delivery, CRM, SONIA | Monitoring realisasi kontrak penjualan komoditas, stok gudang, dan platform CRM. | Looker Studio & SSO |
| **Asset** | Peta Aset, Recovery, Optimalisasi, Divestasi | Pemantauan aset lahan perkebunan, status sertifikasi HGU, dan optimalisasi aset non-produktif. | Looker Studio |
| **Finansial** | Consolidate, Parent Only, Rasio Keuangan, Executive Dashboard, Subsidiary | Kinerja keuangan konsolidasi, neraca laba-rugi, EBITDA, dan rasio solvabilitas/likuiditas. | Looker Studio |
| **HR** | Demographics, Learning & Development, Revenue & Cost, SGnA | Analisis demografi SDM karyawan, produktivitas per kapita, dan efisiensi biaya ketenagakerjaan. | Looker Studio & Lokal |
| **Legal** | Tax Relaxation BPHTB 0%, Agraria | Pengelolaan administrasi perpajakan agraria dan kepatuhan regulasi pertanahan. | Looker Studio |
| **Capaian Progres** | SLA Monitoring | Pemantauan pemenuhan Service Level Agreement pekerjaan proyek strategis. | Looker Studio |
| **Pengadaan** | Pra Pengadaan, Proses, Kontrak, Stok | Alur pengadaan barang & jasa mulai dari tender, penetapan pemenang, hingga monitoring stok. | Looker Studio |
| **Carbon** | Dashboard Emisi | Pemantauan jejak emisi karbon dan inisiatif keberlanjutan lingkungan (ESG). | Looker Studio |
| **GIS** | Peta Areal, NDVI, Cuaca | Pemetaan satelit vegetasi tanaman (NDVI), cuaca mikro, dan poligon blok kebun. | Eksternal GIS |
| **Laporan Manajemen** | LM13, LM14, LM16, LM34, LM62 | Format laporan manajemen baku operasional perkebunan PTPN Group terintegrasi BigQuery. | Looker Studio & BigQuery |

---

## 8. PANDUAN PEMECAHAN MASALAH (TROUBLESHOOTING & FAQ)

### Q1: Muncul pesan error "403 Forbidden - Akses Ditolak" saat membuka menu tertentu
- **Penyebab:** Akun Anda belum diberikan izin akses ke slug fitur tersebut oleh Administrator.
- **Solusi:** Hubungi Administrator sistem AGRINAV di unit Anda. Minta Administrator membuka menu **System Management -> Hak Akses (Access Management)**, lalu mencentang fitur yang Anda butuhkan.

### Q2: Layar dashboard Looker Studio blank putih atau meminta "Request Access"
- **Penyebab:** Google Looker Studio memerlukan akun Google resmi perusahaan atau cookies pihak ketiga (*third-party cookies*) diblokir oleh browser Anda.
- **Solusi:**
  1. Pastikan Anda telah login ke akun email Google resmi perusahaan pada browser yang sama.
  2. Buka pengaturan browser -> Privasi & Keamanan -> Aktifkan *"Izinkan cookie pihak ketiga"* untuk domain `ptpn1.co.id` dan `lookerstudio.google.com`.
  3. Lakukan refresh halaman dengan menekan tombol `Ctrl + F5`.

### Q3: Gambar Captcha tidak muncul atau tidak terbaca di halaman Login
- **Solusi:** Klik tombol panah melingkar `[🔄 Refresh Captcha]` yang terletak di samping kanan kotak gambar captcha untuk membuat kode baru.

### Q4: Lupa Password Akun
- **Solusi:** Laporkan ke Administrator sistem di Head Office / Regional. Administrator dapat mengatur ulang password Anda melalui menu **System Management -> User -> Edit -> Masukkan Password Baru**.

### Q5: Tampilan tabel dashboard terpotong di layar ponsel/tablet
- **Solusi:** 
  1. Tutup bilah menu sidebar dengan menekan tanda silang `[×]`.
  2. Gunakan orientasi ponsel **Landscape** (mendatar) untuk kenyamanan analisis data tabel grafik.
  3. Gunakan tombol fullscreen Looker Studio di pojok kanan bawah kanvas.

---
*Manual Book ini disusun sebagai pedoman resmi operasional sistem AGRINAV - PT Perkebunan Nusantara I.*

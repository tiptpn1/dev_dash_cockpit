# Kamus Fitur & Akses Kontrol (AGRINAV)

Dokumen ini berisi daftar lengkap seluruh slug fitur/akses kontrol yang terdaftar di sistem **AGRINAV (Dev Dash Cockpit)** beserta informasi rute, fungsi controller, posisi di menu sidebar, dan deskripsi fungsinya.

---

## Ringkasan Menu & Slug Fitur

| No | Modul / Kategori | Posisi di Sidebar | Nama Fitur | Slug Fitur | Rute URL | Nama Rute (Laravel) | Tipe / Sumber Data |
|---|---|---|---|---|---|---|---|
| 1 | **MRC** | Utama (Direct) | MRC | `mrc` | `/mrc` | `mrc` | Looker Studio |
| 2 | **Operasional** | Operasional -> AMANAH | Operasional - AMANAH | `operasional_amanah` | `/amanah` | `amanah` | Looker Studio |
| 3 | **Operasional** | Operasional -> DFarm PTPN I | Operasional - DFarm PTPN I | `operasional_dfarm` | `/dfarmkaret` | `dfarmkaretpresensi` | Looker Studio |
| 4 | **Operasional** | Operasional -> CCTV | Operasional - CCTV | `operasional_cctv` | `https://cctv.ptpn1.co.id/...` | - (Eksternal) | Situs Eksternal |
| 5 | **Operasional** | Operasional -> On Farm Karet | Operasional - On Farm Karet | `operasional_onfarmkaret` | `/onfarmkaret` | `onfarmkaret` | Looker Studio |
| 6 | **Operasional** | Operasional -> On Farm Teh | Operasional - On Farm Teh | `operasional_onfarmteh` | `/onfarmteh` | `onfarmteh` | Looker Studio |
| 7 | **Operasional** | Operasional -> On Farm Kopi | Operasional - On Farm Kopi | `operasional_onfarmkopi` | `/onfarmkopi` | `onfarmkopi` | Looker Studio |
| 8 | **Operasional** | Operasional -> Off Farm Karet | Operasional - Off Farm Karet | `operasional_offfarmkaret` | `/offfarmkaret` | `offfarmkaret` | Looker Studio |
| 9 | **Operasional** | Operasional -> Off Farm Teh | Operasional - Off Farm Teh | `operasional_offfarmteh` | `/offfarmteh` | `offfarmteh` | Looker Studio |
| 10 | **Operasional** | Operasional -> Off Farm Kopi | Operasional - Off Farm Kopi | `operasional_offfarmkopi` | `/offfarmkopi` | `offfarmkopi` | Looker Studio |
| 11 | **Operasional** | Operasional -> Monitoring SDM Penyadap | Operasional - Monitoring SDM Penyadap | `operasional_sdmpenyadap` | `/sdmpenyadap` | `sdmpenyadap` | Looker Studio |
| 12 | **PICA** | PICA -> Kuadran Problem | PICA - Kuadran Problem | `pica_kuadran` | `/pica/kuadran-problem-identifications` | `pica.kuadran_problem_identifications` | Looker Studio |
| 13 | **PICA** | PICA -> List Corrective Actions | PICA - List Corrective Actions | `pica_corrective` | `/pica/list-corrective-actions` | `pica.list_corrective_actions` | Looker Studio |
| 14 | **Warehouse** | Utama (Direct) | Warehouse - Gudang Utilisasi | `warehouse_gudang` | `/gudangutilisasi` | `gudangutilisasi` | Looker Studio |
| 15 | **Sales** | Sales -> Overview Sales | Sales - Overview Sales | `sales_overview` | `/overview_sales` | `overview_sales` | Looker Studio |
| 16 | **Sales** | Sales -> Comodities Sales | Sales - Comodities Sales | `sales_comodities` | `/sales_comodities` | `sales_comodities` | Looker Studio |
| 17 | **Sales** | Sales -> Tea Inventory | Sales - Tea Inventory | `sales_tea_inventory` | `/soptea` | `soptea` | Looker Studio |
| 18 | **Sales** | Sales -> Rubber Delivery | Sales - Rubber Delivery | `sales_rubber_delivery` | `/penjualan_karet` | `penjualan_karet` | Looker Studio |
| 19 | **Sales** | Sales -> CRM | Sales - CRM | `sales_crm` | `/crm` | `crm_dashboard` | Looker Studio |
| 20 | **Sales** | Sales -> SONIA | Sales - SONIA | `sales_sonia` | `https://sonia.ptpn1.co.id/...` | - (Eksternal) | Situs Eksternal (SSO) |
| 21 | **Asset** | Asset -> Peta | Asset - Peta | `aset_peta` | `/asset_peta` | `asset_peta` | Looker Studio |
| 22 | **Asset** | Asset -> Recovery | Asset - Recovery | `aset_recovery` | `/asset_recovery` | `asset_recovery` | Looker Studio |
| 23 | **Asset** | Asset -> Optimalisasi | Asset - Optimalisasi | `aset_optimalisasi` | `/asset_optimalisasi` | `asset_optimalisasi` | Looker Studio |
| 24 | **Asset** | Asset -> Divestasi | Asset - Divestasi | `aset_divestasi` | `/asset_divestasi` | `asset_divestasi` | Looker Studio |
| 25 | **Finansial** | Finansial -> Consolidate | Finansial - Consolidate | `finansial_console` | `/fin_console` | `fin_console` | Looker Studio |
| 26 | **Finansial** | Finansial -> Parent Only | Finansial - Parent Only | `finansial_parent` | `/fin_parent` | `fin_parent` | Looker Studio |
| 27 | **Finansial** | Finansial -> Rasio Keuangan | Finansial - Rasio Keuangan | `finansial_ratio` | `/fin_ratio` | `fin_ratio` | Looker Studio |
| 28 | **Finansial** | Finansial -> Executive Dashboard | Finansial - Executive Dashboard | `finansial_executive` | `/fin_executive` | `fin_executive` | Looker Studio |
| 29 | **Finansial** | Finansial -> Subsidiary | Finansial - Subsidiary | `finansial_sub` | `/fin_sub` | `fin_sub` | Looker Studio |
| 30 | **Human Resource** | HR -> Demographics (Dashboard) | HR - Demographics | `hr_demographics` | `/hr_demographics` | `hr_demographics` | Looker Studio |
| 31 | **Human Resource** | HR -> Learning & Development | HR - Learning & Development | `hr_dev` | `/hr_dev` | `hr_dev` | Looker Studio |
| 32 | **Human Resource** | HR -> Revenue & Cost | HR - Revenue & Cost | `hr_revenue` | `/hr_revenue` | `hr_revenue` | Looker Studio |
| 33 | **Human Resource** | HR -> Demographic (Aplikasi) | HR - Demographic | `hr_demographic` | `/hr_demographic` | `hr_demographic` | Aplikasi Lokal |
| 34 | **Human Resource** | HR -> SGnA | HR - SGnA | `hr_sgna` | `/hr_sgna` | `hr_sgna` | Looker Studio |
| 35 | **Legal** | Legal -> Tax Relaxation BPHTB 0% | Legal - Tax Relaxation | `legal_tax` | `/agraria_tax` | `agraria_tax` | Looker Studio |
| 36 | **Legal** | Legal -> Agraria | Legal - Agraria | `legal_agraria` | `/agraria` | `agraria` | Looker Studio |
| 37 | **Capaian Progres** | Capaian Progres -> SLA | Progress - SLA | `progress_sla` | `/sla` | `sla` | Looker Studio |
| 38 | **Pengadaan** | Pengadaan -> Pra Pengadaan | Pengadaan - Pra Pengadaan | `pengadaan_pra` | `/prapengadaan` | `prapengadaan` | Looker Studio |
| 39 | **Pengadaan** | Pengadaan -> Proses Pengadaan | Pengadaan - Proses Pengadaan | `pengadaan_proses` | `/prosespengadaan` | `prosespengadaan` | Looker Studio |
| 40 | **Pengadaan** | Pengadaan -> Kontrak Pengadaan | Pengadaan - Kontrak Pengadaan | `pengadaan_kontrak` | `/kontrakpengadaan` | `kontrakpengadaan` | Looker Studio |
| 41 | **Pengadaan** | Pengadaan -> Stok Pengadaan | Pengadaan - Stok Pengadaan | `pengadaan_stok` | `/stokpengadaan` | `stokpengadaan` | Looker Studio |
| 42 | **Carbon** | Carbon -> Dashboard Emisi | Carbon - Dashboard Emisi | `carbon_emisi` | `/dashboardemisi` | `dashboardemisi` | Looker Studio |
| 43 | **GIS** | GIS -> PETA | GIS - Areal | `gis_areal` | `https://gis.ptpn1.co.id/tree...` | - (Eksternal) | Situs Eksternal |
| 44 | **GIS** | GIS -> NDVI | GIS - NDVI | `gis_ndvi` | `http://gis.ptpn1.co.id/...` | - (Eksternal) | Situs Eksternal |
| 45 | **GIS** | GIS -> CUACA | GIS - Cuaca | `gis_cuaca` | `http://aset-dives-dev.ptpn1.co.id/...` | - (Eksternal) | Situs Eksternal |
| 46 | **AGRO Skyview** | AGRO Skyview -> AGRO Skyview Table | Skyview - AGRO Skyview Table | `skyview_table` | `/skyview-table` | `skyview_table` | Aplikasi Lokal (CRUD) |
| 47 | **AGRO Skyview** | AGRO Skyview -> Exec Summary | Skyview - Exec Summary | `skyview_exec` | `/exec_summary` | `exec_summary` | Looker Studio |
| 48 | **Laporan Manajemen** | Laporan Manajemen -> LM13 | LM - LM13 | `lm_13` | `/lm13` | `lm13` | Looker Studio |
| 49 | **Laporan Manajemen** | Laporan Manajemen -> LM14 | LM - LM14 | `lm_14` | `/lm14` | `lm14` | Looker Studio |
| 50 | **Laporan Manajemen** | Laporan Manajemen -> LM16 | LM - LM16 | `lm_16` | `/lm16` | `lm16` | Looker Studio |
| 51 | **Laporan Manajemen** | Laporan Manajemen -> LM34 | LM - LM34 | `lm_34` | `/lm34_tab` | `lm34_tab` | Looker Studio |
| 52 | **Laporan Manajemen** | Laporan Manajemen -> LM62 | LM - LM62 | `lm_62` | `/lm62` | `lm62` | Looker Studio |
| 53 | **Sales & Operation** | Sales & Operation -> Karet | Sales & Operation - Karet | `pemasaran_karet_sales` | `/sales_operational_karet` | `sales_operational_karet` | Looker Studio |
| 54 | **AIGR1** | Utama (Direct) | AIGR1 | `aigr1` | `/portalaplikasi` (Icon) | `portalaplikasi` | Aplikasi Lokal |
| 55 | **Garda AI** | Utama (Direct) | Garda AI | `garda` | `https://gardaprep.holding-perkebunan.com/` | - (Eksternal) | Situs Eksternal |
| 56 | **Portal Aplikasi** | Utama (Direct) | Portal Aplikasi | `portalaplikasi` | `/portalaplikasi` | `portalaplikasi` | Aplikasi Lokal |
| 57 | **Evaluasi Aplikasi** | Utama (Direct) | Evaluasi Aplikasi | `evaluasi_aplikasi` | `https://evaluasi-aplikasi.ptpn1.co.id/` | - (Eksternal) | Situs Eksternal |
| 58 | **System Management** | System Management -> User | User Management | `management_users` | `/management/users` | `management.users.index` | Aplikasi Lokal |
| 59 | **System Management** | System Management -> Fitur | Feature Management | `management_features` | `/management/features` | `management.features.index` | Aplikasi Lokal |
| 60 | **System Management** | System Management -> Hak Akses / Last Login | Access Management | `management_access` | `/management/access` | `management.access.index` | Aplikasi Lokal |

---

## Detail Fungsional Rute & Controller

Berikut adalah asosiasi detail antara rute dengan method controller dan deskripsi kegunaannya:

### 1. Modul Operasional (`operasional`)
* **AMANAH**
  * Rute: `GET /amanah` (Nama: `amanah`)
  * Controller: `PageController@amanah`
  * Deskripsi: Menampilkan Dashboard AMANAH terintegrasi.
* **DFarm PTPN I**
  * Rute: `GET /dfarmkaret` (Nama: `dfarmkaretpresensi`)
  * Controller: `PageController@dfarmkaretpresensi`
  * Deskripsi: Dashboard monitoring sistem DFarm Karet.
* **CCTV**
  * Rute: Tautan Eksternal `https://cctv.ptpn1.co.id/...`
  * Deskripsi: Link langsung menuju monitoring cctv wilayah kerja PTPN I.
* **On Farm Karet**
  * Rute: `GET /onfarmkaret` (Nama: `onfarmkaret`)
  * Controller: `PageController@onfarmkaret`
  * Deskripsi: Dashboard visualisasi data on farm karet.
* **On Farm Teh**
  * Rute: `GET /onfarmteh` (Nama: `onfarmteh`)
  * Controller: `PageController@onfarmteh`
  * Deskripsi: Dashboard visualisasi data on farm teh.
* **On Farm Kopi**
  * Rute: `GET /onfarmkopi` (Nama: `onfarmkopi`)
  * Controller: `PageController@onfarmkopi`
  * Deskripsi: Dashboard visualisasi data on farm kopi.
* **Off Farm Karet**
  * Rute: `GET /offfarmkaret` (Nama: `offfarmkaret`)
  * Controller: `PageController@offfarmkaret`
  * Deskripsi: Dashboard visualisasi data pengolahan (pabrik) karet.
* **Off Farm Teh**
  * Rute: `GET /offfarmteh` (Nama: `offfarmteh`)
  * Controller: `PageController@offfarmteh`
  * Deskripsi: Dashboard visualisasi data pengolahan (pabrik) teh.
* **Off Farm Kopi**
  * Rute: `GET /offfarmkopi` (Nama: `offfarmkopi`)
  * Controller: `PageController@offfarmkopi`
  * Deskripsi: Dashboard visualisasi data pengolahan (pabrik) kopi.
* **Monitoring SDM Penyadap**
  * Rute: `GET /sdmpenyadap` (Nama: `sdmpenyadap`)
  * Controller: `PageController@sdmpenyadap`
  * Deskripsi: Dashboard monitoring produktivitas dan kehadiran SDM Penyadap.


### 2. Modul PICA (`pica`)
* **Kuadran Problem Identifications**
  * Rute: `GET /pica/kuadran-problem-identifications` (Nama: `pica.kuadran_problem_identifications`)
  * Controller: `PageController@picaKuadranProblemIdentifications`
  * Deskripsi: Mengakses visualisasi Looker Studio matriks kuadran problem.
* **List Corrective Actions**
  * Rute: `GET /pica/list-corrective-actions` (Nama: `pica.list_corrective_actions`)
  * Controller: `PageController@picaListCorrectiveActions`
  * Deskripsi: Laporan data perbaikan tindakan korektif.

### 3. Modul Warehouse (`warehouse`)
* **Warehouse - Gudang Utilisasi**
  * Rute: `GET /gudangutilisasi` (Nama: `gudangutilisasi`)
  * Controller: `PageController@gudangutilisasi`
  * Deskripsi: Laporan utilisasi ruang gudang regional.

### 4. Modul Sales (`sales`)
* **Overview Sales**
  * Rute: `GET /overview_sales` (Nama: `overview_sales`)
  * Controller: `PageController@overview_sales`
* **Comodities Sales**
  * Rute: `GET /sales_comodities` (Nama: `sales_comodities`)
  * Controller: `PageController@sales_comodities`
* **Tea Inventory**
  * Rute: `GET /soptea` (Nama: `soptea`)
  * Controller: `PageController@soptea`
* **Rubber Delivery**
  * Rute: `GET /penjualan_karet` (Nama: `penjualan_karet`)
  * Controller: `PageController@penjualan_karet`
* **CRM**
  * Rute: `GET /crm` (Nama: `crm_dashboard`)
  * Controller: `PageController@crm_dashboard`
* **SONIA**
  * Rute: Tautan Eksternal SSO

### 5. Modul Asset (`aset`)
* **Peta**
  * Rute: `GET /asset_peta` (Nama: `asset_peta`)
  * Controller: `PageController@asset_peta`
* **Recovery**
  * Rute: `GET /asset_recovery` (Nama: `asset_recovery`)
  * Controller: `PageController@asset_recovery`
* **Optimalisasi**
  * Rute: `GET /asset_optimalisasi` (Nama: `asset_optimalisasi`)
  * Controller: `PageController@asset_optimalisasi`
* **Divestasi**
  * Rute: `GET /asset_divestasi` (Nama: `asset_divestasi`)
  * Controller: `PageController@asset_divestasi`

### 6. Modul Finansial (`finansial`)
* **Consolidate**
  * Rute: `GET /fin_console` (Nama: `fin_console`)
  * Controller: `PageController@fin_console`
* **Parent Only**
  * Rute: `GET /fin_parent` (Nama: `fin_parent`)
  * Controller: `PageController@fin_parent`
* **Rasio Keuangan**
  * Rute: `GET /fin_ratio` (Nama: `fin_ratio`)
  * Controller: `PageController@fin_ratio`
* **Executive Dashboard**
  * Rute: `GET /fin_executive` (Nama: `fin_executive`)
  * Controller: `PageController@fin_executive`
* **Subsidiary**
  * Rute: `GET /fin_sub` (Nama: `fin_sub`)
  * Controller: `PageController@fin_sub`

### 7. Modul Human Resource (`hr`)
* **Demographics**
  * Rute: `GET /hr_demographics` (Nama: `hr_demographics`)
  * Controller: `PageController@hr_demographics`
* **Learning & Development**
  * Rute: `GET /hr_dev` (Nama: `hr_dev`)
  * Controller: `PageController@hr_dev`
* **Revenue & Cost**
  * Rute: `GET /hr_revenue` (Nama: `hr_revenue`)
  * Controller: `PageController@hr_revenue`
* **Demographic (Aplikasi)**
  * Rute: `GET /hr_demographic` (Nama: `hr_demographic`)
  * Controller: `PageController@hr_demographic`
* **SGnA**
  * Rute: `GET /hr_sgna` (Nama: `hr_sgna`)
  * Controller: `PageController@hr_sgna`

### 8. Modul Legal (`legal`)
* **Tax Relaxation**
  * Rute: `GET /agraria_tax` (Nama: `agraria_tax`)
  * Controller: `PageController@agraria_tax`
* **Agraria**
  * Rute: `GET /agraria` (Nama: `agraria`)
  * Controller: `PageController@agraria`

### 9. Modul Progress (`progress`)
* **SLA**
  * Rute: `GET /sla` (Nama: `sla`)
  * Controller: `PageController@sla`

### 10. Modul Pengadaan (`pengadaan`)
* **Pra Pengadaan**
  * Rute: `GET /prapengadaan` (Nama: `prapengadaan`)
  * Controller: `PageController@prapengadaan`
* **Proses Pengadaan**
  * Rute: `GET /prosespengadaan` (Nama: `prosespengadaan`)
  * Controller: `PageController@prosespengadaan`
* **Kontrak Pengadaan**
  * Rute: `GET /kontrakpengadaan` (Nama: `kontrakpengadaan`)
  * Controller: `PageController@kontrakpengadaan`
* **Stok Pengadaan**
  * Rute: `GET /stokpengadaan` (Nama: `stokpengadaan`)
  * Controller: `PageController@stokpengadaan`

### 11. Modul Carbon (`carbon`)
* **Dashboard Emisi**
  * Rute: `GET /dashboardemisi` (Nama: `dashboardemisi`)
  * Controller: `PageController@dashboardemisi`

### 12. Modul GIS (`gis`)
* **PETA / Areal**
  * Tautan Eksternal GIS
* **NDVI**
  * Tautan Eksternal GIS NDVI
* **Cuaca**
  * Tautan Eksternal GIS Cuaca

### 13. Modul AGRO Skyview (`skyview`)
* **AGRO Skyview Table**
  * Rute: `GET /skyview-table` (Nama: `skyview_table`)
  * Controller: `SkyviewController@index`
* **Exec Summary**
  * Rute: `GET /exec_summary` (Nama: `exec_summary`)
  * Controller: `PageController@exec_summary`

### 14. Modul Laporan Manajemen (`lm`)
* **LM13**
  * Rute: `GET /lm13` (Nama: `lm13`)
  * Controller: `PageController@lm13`
* **LM14**
  * Rute: `GET /lm14` (Nama: `lm14`)
  * Controller: `PageController@lm14`
* **LM16**
  * Rute: `GET /lm16` (Nama: `lm16`)
  * Controller: `PageController@lm16`
* **LM34**
  * Rute: `GET /lm34_tab` (Nama: `lm34_tab`)
  * Controller: `PageController@lm34_tab`
* **LM62**
  * Rute: `GET /lm62` (Nama: `lm62`)
  * Controller: `PageController@lm62`

### 15. Modul Sales & Operation Karet (`pemasaran_karet`)
* **Sales & Operation Karet**
  * Rute: `GET /sales_operational_karet` (Nama: `sales_operational_karet`)
  * Controller: `PageController@sales_operational_karet`

### 16. Modul System Management (`management`)
* **User Management**
  * Rute: `GET /management/users` (Nama: `management.users.index`)
  * Controller: `UserManagementController`
* **Feature Management**
  * Rute: `GET /management/features` (Nama: `management.features.index`)
  * Controller: `FeatureManagementController`
* **Access Management**
  * Rute: `GET /management/access` (Nama: `management.access.index`)
  * Controller: `UserFeatureAccessController`

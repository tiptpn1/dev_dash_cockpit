@extends('layouts.app')

@section('styles')
<style>
    /* ===== SCROLL FIX — override Tailwind h-screen di body ===== */
    html,
    body {
        height: auto !important;
        min-height: 100vh;
        overflow-y: auto !important;
        background-color: #f8fafc !important;
        color: #1f2937;
        font-family: 'Google Sans', 'Inter', sans-serif;
    }

    /* Override padding dari layout .main-content agar tidak ada space aneh */
    .evaluasi-container.main-content {
        padding: 0 !important;
        margin-left: 0 !important;
        background-color: #f8fafc;
        min-height: 100vh;
    }

    /* ===== MAIN CONTAINER ===== */
    .evaluasi-container {
        padding: 0;
        margin: 0;
        width: 100%;
        min-height: 100vh;
        background: #f8fafc;
        overflow-x: hidden;
        box-sizing: border-box;
    }

    /* ===== PAGE HEADER ===== */
    .lm-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 50px;
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
        min-height: 56px;
    }

    .lm-header-logo {
        width: 130px;
        height: 44px;
        display: flex;
        align-items: center;
    }

    .lm-header-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .lm-header-center {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .lm-header-center h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #166534;
        margin: 0;
    }

    .lm-header-right {
        display: flex;
        align-items: center;
    }

    .lm-header-right img {
        height: 44px;
        width: auto;
        object-fit: contain;
    }

    .content-section {
        max-width: 100%;
        margin: 0;
        padding: 18px 50px 32px;
    }

    /* ===== FILTER CARD ===== */
    .filter-card {
        background: #fff;
        border: 1px solid #d1fae5;
        border-left: 4px solid #166534;
        border-radius: 8px;
        padding: 18px 20px;
        margin-bottom: 20px;
        box-shadow: 0 1px 4px rgba(22, 101, 52, 0.08);
    }

    .filter-title {
        color: #166534;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-label {
        color: #374151;
        font-size: 11px;
        font-weight: 700;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-select, .form-input {
        width: 100%;
        padding: 8px 10px;
        background-color: #fff;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        color: #1f2937;
        font-size: 13px;
        transition: border-color 0.2s;
    }

    .form-select:focus, .form-input:focus {
        outline: none;
        border-color: #166534;
        box-shadow: 0 0 0 2px rgba(22, 101, 52, 0.12);
    }

    /* ===== TABLE CARD ===== */
    .table-card {
        background: #fff;
        border: 2px solid #166534;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(22, 101, 52, 0.10);
    }

    .table-header {
        background: #166534;
        padding: 12px 20px;
        border-bottom: 2px solid #14532d;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .table-title {
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
        letter-spacing: 0.02em;
    }

    .table-count {
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .table-wrapper {
        overflow-x: auto;
        width: 100%;
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12.5px;
        color: #1f2937;
    }

    .report-table thead th {
        background: #15803d;
        color: #fff;
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 9px 12px;
        border: 1px solid #166534;
        text-align: center;
        white-space: nowrap;
    }

    .report-table tbody td {
        padding: 8px 12px;
        border: 1px solid #e5e7eb;
        vertical-align: middle;
        color: #1f2937;
    }

    .report-table tbody tr:hover td {
        background-color: #f0fdf4;
    }

    .progress-bar-bg {
        background: #e2e8f0;
        border-radius: 9999px;
        overflow: hidden;
    }

    /* Empty state styling */
    .empty-state {
        text-align: center;
        padding: 48px 24px;
        color: #6b7280;
    }

    .empty-icon {
        font-size: 2.5rem;
        color: #d1d5db;
        margin-bottom: 12px;
    }

    .loading-row td {
        text-align: center;
        padding: 32px;
        color: #6b7280;
        font-size: 13px;
    }

    .error-banner {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 12px 16px;
        margin: 12px 16px;
        border-radius: 6px;
        font-size: 13px;
    }

    .divisi-row {
        cursor: pointer;
        transition: background-color 0.15s;
    }

    .divisi-row:hover td {
        background-color: #ecfdf5 !important;
    }

    .divisi-row.active td {
        background-color: #dcfce7 !important;
    }

    .divisi-row .expand-icon {
        color: #166534;
        margin-right: 6px;
        font-size: 10px;
        transition: transform 0.2s;
    }

    .divisi-row.active .expand-icon {
        transform: rotate(90deg);
    }

    .detail-row td {
        background: #f8fafc !important;
        padding: 0 !important;
        border-left: 3px solid #166534;
    }

    .detail-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        margin: 0;
    }

    .detail-table thead th {
        background: #f0fdf4;
        color: #166534;
        font-size: 11px;
        padding: 8px 12px;
        border: 1px solid #d1fae5;
        text-align: center;
    }

    .detail-table tbody td {
        padding: 7px 12px;
        border: 1px solid #e5e7eb;
        background: #fff;
    }

    .regional-badge {
        display: inline-block;
        background: #ecfdf5;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
        margin-left: 8px;
    }

    .hris-tabs {
        display: flex;
        gap: 0;
        border-bottom: 2px solid #e5e7eb;
        padding: 0 16px;
        background: #f9fafb;
    }

    .hris-tab-btn {
        padding: 10px 18px;
        font-size: 13px;
        font-weight: 600;
        color: #6b7280;
        background: transparent;
        border: none;
        border-bottom: 2px solid transparent;
        margin-bottom: -2px;
        cursor: pointer;
        transition: color 0.15s, border-color 0.15s;
    }

    .hris-tab-btn.active {
        color: #166534;
        border-bottom-color: #166534;
        background: #fff;
    }

    .hris-tab-panel {
        display: none;
    }

    .hris-tab-panel.active {
        display: block;
    }

    .belum-absen-badge {
        display: inline-block;
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
        padding: 1px 6px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 700;
        margin-left: 6px;
    }

    .filter-card-tab2 {
        margin: 16px 16px 0;
        padding: 14px 16px;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
    }

    .filter-grid-tab2 {
        display: grid;
        grid-template-columns: 160px 1fr 150px 150px;
        gap: 12px;
        align-items: start;
    }

    .filter-grid-tab2-harian {
        display: grid;
        grid-template-columns: 1fr 180px 140px auto;
        gap: 12px;
        align-items: end;
    }

    .btn-export-excel {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 14px;
        background-color: #16a34a;
        color: #fff;
        border: 1px solid #15803d;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        height: 35px;
    }

    .btn-export-excel:hover {
        background-color: #15803d;
        border-color: #166534;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .btn-export-excel:active {
        background-color: #166534;
    }

    .regional-summary-row td {
        background: linear-gradient(90deg, #14532d 0%, #166534 100%) !important;
        color: #fff !important;
        border-color: #14532d !important;
        font-weight: 700;
    }

    .regional-summary-row:hover td {
        background: linear-gradient(90deg, #14532d 0%, #166534 100%) !important;
    }

    .regional-summary-row .summary-label {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .regional-summary-row .summary-label i {
        color: #bbf7d0;
    }

    .regional-summary-row .progress-bar-bg {
        background: rgba(255, 255, 255, 0.25) !important;
    }

    .regional-summary-row .summary-pct-badge {
        background: rgba(255, 255, 255, 0.2) !important;
        color: #fff !important;
        border: 1px solid rgba(255, 255, 255, 0.35) !important;
    }

    .absensi-info-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 16px;
        height: 16px;
        margin-left: 4px;
        padding: 0;
        border: none;
        background: #dbeafe;
        color: #1d4ed8;
        border-radius: 50%;
        font-size: 10px;
        cursor: pointer;
        vertical-align: middle;
        line-height: 1;
    }

    .absensi-info-btn:hover {
        background: #bfdbfe;
    }

    .absensi-popup-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .absensi-popup-overlay.show {
        display: flex;
    }

    .absensi-popup {
        background: #fff;
        border-radius: 8px;
        max-width: 400px;
        width: 100%;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.18);
        overflow: hidden;
    }

    .absensi-popup-header {
        background: #166534;
        color: #fff;
        padding: 12px 16px;
        font-size: 14px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .absensi-popup-body {
        padding: 16px;
        font-size: 13px;
        color: #374151;
        line-height: 1.6;
    }

    .absensi-popup-body ul {
        margin: 10px 0 0;
        padding-left: 20px;
    }

    .absensi-popup-body li {
        margin-bottom: 6px;
    }

    .absensi-popup-breakdown {
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid #e5e7eb;
        font-size: 12px;
    }

    .absensi-popup-close {
        background: transparent;
        border: none;
        color: #fff;
        font-size: 18px;
        cursor: pointer;
        padding: 0 4px;
        line-height: 1;
    }

    /* ===== TOKEN MODE READONLY STYLES ===== */
    .token-mode-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        background: #fef9c3;
        color: #92400e;
        border: 1px solid #fde68a;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 700;
        margin-left: 8px;
        vertical-align: middle;
    }

    select.select-locked {
        background-color: #f3f4f6;
        color: #374151;
        cursor: not-allowed;
        pointer-events: none;
        border-color: #d1d5db;
        opacity: 0.85;
    }

    /* ===== DROPDOWN STYLES ===== */
    .dropdown-list {
        background-color: #fff;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .dropdown-item {
        padding: 10px 12px;
        cursor: pointer;
        border-bottom: 1px solid #e5e7eb;
        transition: background-color 0.15s;
    }

    .dropdown-item:last-child {
        border-bottom: none;
    }

    .dropdown-item:hover {
        background-color: #f3f4f6;
    }

    #perkaryawan_nama_search {
        margin: 0 !important;
    }

    #perkaryawan_nama_dropdown {
        margin-top: 0 !important;
    }

    #perkaryawan_selected_nama {
        margin-top: 4px !important;
    }

    /* ===== MAP POPUP STYLES ===== */
    .map-popup-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .map-popup-overlay.show {
        display: flex;
    }

    .map-popup-container {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 600px;
        max-height: 90vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .map-popup-header {
        background: #166534;
        color: #fff;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #e5e7eb;
    }

    .map-popup-header h2 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .map-popup-close {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        padding: 0 6px;
        border-radius: 4px;
        transition: background 0.2s;
    }

    .map-popup-close:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .map-popup-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    #mapContainer {
        width: 100%;
        height: 400px;
        background: #f0f0f0;
    }

    .map-info-panel {
        padding: 16px 20px;
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
        font-size: 12px;
        color: #6b7280;
    }

    .map-info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        align-items: center;
    }

    .map-info-row:last-child {
        margin-bottom: 0;
    }

    .map-info-label {
        font-weight: 600;
        color: #374151;
        min-width: 100px;
    }

    .map-info-value {
        color: #1f2937;
        word-break: break-word;
    }

    .map-pin-icon {
        cursor: pointer;
        color: #166534;
        font-size: 16px;
        padding: 4px 8px;
        border-radius: 4px;
        transition: background 0.2s;
        display: inline-flex;
        align-items: center;
    }

    .map-pin-icon:hover {
        background: rgba(22, 101, 52, 0.1);
        color: #14532d;
    }
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""><script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection


@section('content')
<div class="evaluasi-container main-content">
    
    <!-- Page Header -->
    <header class="lm-page-header">
        <div class="lm-header-logo">
            <img src="{{ asset('danantara.png') }}" alt="Danantara">
        </div>
        <div class="lm-header-center">
            <svg style="width:28px;height:28px;color:#22c55e;flex-shrink:0;" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.95-2.3A5 5 0 008 22c12 0 15-17 15-17-1 2-8 2-13 3-5 1-6 7-6 7s5.5-2 8.5-2 5 2 5 2-3-5-3-5 3 5 3 5-5 3-5 3 2 3 2 6-2 6-2 6 3-3 3-6-2-6-2-6z" />
            </svg>
            <h1 class="text-white">Evaluasi Kinerja Aplikasi</h1>
        </div>
        <div class="lm-header-right">
            <img src="{{ asset('ptpn1.png') }}" alt="PTPN 1">
        </div>
    </header>

    <!-- Main Content Section -->
    <div class="content-section">
        
        <!-- Filter Card -->
        <div class="filter-card">
            <div class="filter-title">
                <i class="fas fa-sliders-h"></i> Filter Parameter
            </div>
            <div class="filter-grid" style="grid-template-columns: minmax(220px, 380px);">
                <div class="form-group">
                    <label class="form-label">
                        Nama Aplikasi
                        @if($tokenMode)
                            <span class="token-mode-badge"><i class="fas fa-lock"></i> Readonly</span>
                        @endif
                    </label>
                    @if($tokenMode)
                        {{-- Token mode: hanya HRIS, tidak bisa diubah --}}
                        <select id="app_select" class="form-select select-locked" disabled>
                            <option value="HRIS" selected>HRIS</option>
                        </select>
                        <input type="hidden" id="app_select_hidden" value="HRIS">
                    @else
                        <select id="app_select" class="form-select">
                            <option value="Digital Farming">DFarm Presensi</option>
                            <option value="Digital Farming Produksi">DFarm Prestasi</option>
                            <option value="HRIS" selected>HRIS</option>
                            <option value="MAIA">MAIA</option>
                            <option value="MONIKA">MONIKA</option>
                            <option value="BPD">Aplikasi BPD</option>
                            <option value="SAPA-Amanah">SAPA-Amanah</option>
                        </select>
                    @endif
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="table-card">
            <div class="table-header">
                <div class="table-title">
                    <i class="fas fa-table"></i> <span id="table-title">Data Evaluasi Aplikasi</span>
                    <span id="regional-badge" class="regional-badge" style="display:none;">SuppCo HO</span>
                </div>
                <span id="data-count-badge" class="table-count">-- Data</span>
            </div>

            <div id="hris-tabs-wrap" style="display: none;">
                <div class="hris-tabs">
                    <button type="button" class="hris-tab-btn active" data-tab="rekap">
                        <i class="fas fa-chart-bar"></i> Rekap Kehadiran
                    </button>
                    <button type="button" class="hris-tab-btn" data-tab="harian">
                        <i class="fas fa-calendar-day"></i> Detail Harian
                    </button>
                    <button type="button" class="hris-tab-btn" data-tab="perkaryawan">
                        <i class="fas fa-user"></i> Detail per Karyawan
                    </button>
                </div>

                <div id="hris-error" class="error-banner" style="display: none;"></div>

                <!-- Tab 1: Rekap -->
                <div id="tab-rekap" class="hris-tab-panel active">
                    <div class="filter-card-tab2" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <label class="form-label" style="margin:0; white-space:nowrap;"><i class="fas fa-calendar-alt" style="color:#166534;"></i> Periode:</label>
                            <input type="month" id="periode_select" class="form-input" value="{{ date('Y-m') }}" style="width:160px;">
                        </div>
                        <div id="rekap-periode-info" style="font-size:12px; color:#6b7280; font-style:italic;"></div>
                    </div>
                    <div class="table-wrapper">
                        <table id="hris-table" class="report-table">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">No</th>
                                    <th style="text-align: left;">Divisi <span style="font-weight:400;text-transform:none;">(klik untuk detail karyawan)</span></th>
                                    <th style="width: 200px;">Jumlah Hari Kerja</th>
                                    <th style="width: 320px;">Persentase Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody id="hris-tbody"></tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab 2: Detail Harian -->
                <div id="tab-harian" class="hris-tab-panel">
                    <div class="filter-card-tab2">
                        <div class="filter-grid-tab2-harian">
                            <div class="form-group">
                                <label class="form-label">Divisi</label>
                                <select id="harian_divisi_select" class="form-select">
                                    <option value="">Semua Divisi</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <select id="harian_status_select" class="form-select">
                                    <option value="">SEMUA</option>
                                    <option value="sudah">SUDAH ABSEN</option>
                                    <option value="belum">BELUM ABSEN</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tanggal (Hari)</label>
                                <input type="date" id="harian_tanggal_select" class="form-input">
                            </div>
                            <div class="form-group">
                                <button type="button" id="btnExportExcelHarian" class="btn-export-excel">
                                    <i class="fas fa-file-excel"></i> Excel
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-wrapper">
                        <table id="harian-table" class="report-table">
                            <thead>
                                <tr>
                                    <th style="width:40px;">No</th>
                                    <th style="text-align:left;">Nama Karyawan</th>
                                    <th style="width:100px;">NIK</th>
                                    <th style="text-align:left;min-width:160px;">Divisi</th>
                                    <th style="width:120px;">Status Absen</th>
                                    <th style="width:90px;">Hari Kerja</th>
                                    <th style="width:100px;">Check In</th>
                                    <th style="width:110px;">Mood Check In</th>
                                    <th style="width:100px;">Check Out</th>
                                    <th style="width:110px;">Mood Check Out</th>
                                    <th style="text-align:left;min-width:180px;">Lokasi</th>
                                    <th style="width:90px;">Jenis Absen</th>
                                </tr>
                            </thead>
                            <tbody id="harian-tbody">
                                <tr class="loading-row"><td colspan="12">Pilih tanggal untuk menampilkan data.</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab 3: Detail per Karyawan -->
                <div id="tab-perkaryawan" class="hris-tab-panel">
                    <div class="filter-card-tab2">
                        <div class="filter-grid-tab2">
                            <div class="form-group">
                                <label class="form-label">Regional</label>
                                <select id="perkaryawan_regional_select" class="form-select">
                                    <option value="">-- Pilih Regional --</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nama Karyawan</label>
                                <div style="position: relative;">
                                    <input type="text" id="perkaryawan_nama_search" class="form-input" placeholder="Ketik minimal 3 huruf..." autocomplete="off">
                                    <div id="perkaryawan_nama_dropdown" class="dropdown-list" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; max-height: 300px; overflow-y: auto; z-index: 1000; border-radius: 4px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                    </div>
                                </div>
                                <input type="hidden" id="perkaryawan_pegawai_id" value="">
                                <div id="perkaryawan_selected_nama" style="margin-top: 8px; font-size: 12px; color: #6b7280;"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tanggal Awal</label>
                                <input type="date" id="perkaryawan_tanggal_awal" class="form-input">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tanggal Akhir</label>
                                <input type="date" id="perkaryawan_tanggal_akhir" class="form-input">
                            </div>
                        </div>
                    </div>
                    <div class="table-wrapper">
                        <table id="perkaryawan-table" class="report-table">
                            <thead>
                                <tr>
                                    <th style="width:40px;">No</th>
                                    <th style="text-align:left;">Tanggal Absensi</th>
                                    <th style="width:100px;">NIK</th>
                                    <th style="width:90px;">Hari Kerja</th>
                                    <th style="width:100px;">Check In</th>
                                    <th style="width:110px;">Mood Check In</th>
                                    <th style="width:100px;">Check Out</th>
                                    <th style="width:110px;">Mood Check Out</th>
                                    <th style="text-align:left;min-width:180px;">Lokasi</th>
                                    <th style="width:90px;">Jenis Absen</th>
                                </tr>
                            </thead>
                            <tbody id="perkaryawan-tbody">
                                <tr class="loading-row"><td colspan="10">Pilih regional, karyawan, dan range tanggal untuk menampilkan data.</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="table-wrapper" id="non-hris-wrapper">
                <!-- Placeholder / Empty State -->
                <div id="placeholder-state" class="empty-state" style="display: none;">
                    <div class="empty-icon">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <h4 style="font-size: 14px; font-weight: 700; color: #374151;" id="placeholder-title">Data Belum Tersedia</h4>
                    <p style="font-size: 12px; color: #6b7280; margin-top: 4px;" id="placeholder-desc">Data evaluasi untuk aplikasi ini sedang dalam proses pengumpulan.</p>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Popup info Absensi -->
<div id="absensi-popup-overlay" class="absensi-popup-overlay" role="dialog" aria-modal="true">
    <div class="absensi-popup">
        <div class="absensi-popup-header">
            <span><i class="fas fa-info-circle"></i> Ketentuan Absensi</span>
            <button type="button" class="absensi-popup-close" id="absensi-popup-close" aria-label="Tutup">&times;</button>
        </div>
        <div class="absensi-popup-body" id="absensi-popup-body">
            <p>Yang termasuk dalam perhitungan <strong>Absensi</strong>:</p>
            <ul>
                <li><strong>WFO</strong> — Work From Office</li>
                <li><strong>WFH</strong> — Work From Home</li>
                <li><strong>Izin</strong></li>
                <li><strong>Dinas</strong></li>
            </ul>
            <div id="absensi-popup-breakdown" class="absensi-popup-breakdown" style="display:none;"></div>
        </div>
    </div>
</div>

<!-- Map Popup -->
<div id="mapPopupOverlay" class="map-popup-overlay">
    <div class="map-popup-container">
        <div class="map-popup-header">
            <h2>
                <i class="fas fa-map-marker-alt"></i>
                <span id="mapPopupTitle">Lokasi Absensi</span>
            </h2>
            <button type="button" class="map-popup-close" id="mapPopupClose" aria-label="Tutup">&times;</button>
        </div>
        <div class="map-popup-content">
            <div id="mapContainer"></div>
            <div class="map-info-panel">
                <div class="map-info-row">
                    <span class="map-info-label">Lokasi:</span>
                    <span class="map-info-value" id="mapInfoLokasi">-</span>
                </div>
                <div class="map-info-row">
                    <span class="map-info-label">Latitude:</span>
                    <span class="map-info-value" id="mapInfoLatitude">-</span>
                </div>
                <div class="map-info-row">
                    <span class="map-info-label">Longitude:</span>
                    <span class="map-info-value" id="mapInfoLongitude">-</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- ExcelJS for Export Excel feature -->
<script src="https://cdn.jsdelivr.net/npm/exceljs@4.4.0/dist/exceljs.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const appSelect = document.getElementById('app_select');
        const periodeSelect = document.getElementById('periode_select');
        const hrisTable = document.getElementById('hris-table');
        const placeholderState = document.getElementById('placeholder-state');
        const tableTitle = document.getElementById('table-title');
        const dataCountBadge = document.getElementById('data-count-badge');
        const hrisTbody = document.getElementById('hris-tbody');

        const hrisError = document.getElementById('hris-error');
        const regionalBadge = document.getElementById('regional-badge');
        const hrisTabsWrap = document.getElementById('hris-tabs-wrap');
        const nonHrisWrapper = document.getElementById('non-hris-wrapper');
        const harianDivisiSelect = document.getElementById('harian_divisi_select');
        const harianStatusSelect = document.getElementById('harian_status_select');
        const harianTanggalSelect = document.getElementById('harian_tanggal_select');
        const harianTbody = document.getElementById('harian-tbody');
        const perkaryawanRegionalSelect = document.getElementById('perkaryawan_regional_select');
        const perkaryawanNamaSearch = document.getElementById('perkaryawan_nama_search');
        const perkaryawanNamaDropdown = document.getElementById('perkaryawan_nama_dropdown');
        const perkaryawanPegawaiId = document.getElementById('perkaryawan_pegawai_id');
        const perkaryawanSelectedNama = document.getElementById('perkaryawan_selected_nama');
        const perkaryawanTanggalAwal = document.getElementById('perkaryawan_tanggal_awal');
        const perkaryawanTanggalAkhir = document.getElementById('perkaryawan_tanggal_akhir');
        const perkaryawanTbody = document.getElementById('perkaryawan-tbody');
        const hrisDataUrl = @json(route('evaluasi_hris_data'));
        const hrisDetailUrl = @json(route('evaluasi_hris_detail'));
        const hrisDivisiUrl = @json(route('evaluasi_hris_divisi'));
        const hrisHarianUrl = @json(route('evaluasi_hris_harian'));
        const hrisPerKaryawanUrl = @json(route('evaluasi_hris_perkaryawan'));
        const hrisPegawaiListUrl = @json(route('evaluasi_hris_pegawai_list'));
        const hrisRegionalListUrl = @json(route('evaluasi_hris_regional_list'));
        let activeDivisi = null;
        let currentPeriode = null;
        let activeHrisTab = 'rekap';
        let _harianData = [];

        const monthNames = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        function formatPeriodLabel(periodVal) {
            const parts = periodVal.split('-');
            const year = parseInt(parts[0]) || new Date().getFullYear();
            const month = parseInt(parts[1], 10) - 1;
            return `${monthNames[month] || ''} ${year}`;
        }

        function getAttendanceStyle(attendance) {
            const pct = parseFloat(attendance);
            if (pct >= 98.0) {
                return {
                    badgeStyle: 'background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0;',
                    barColor: '#16a34a',
                };
            }
            if (pct >= 95.0) {
                return {
                    badgeStyle: 'background-color: #dbeafe; color: #1d4ed8; border: 1px solid #bfdbfe;',
                    barColor: '#2563eb',
                };
            }
            return {
                badgeStyle: 'background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a;',
                barColor: '#d97706',
            };
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text ?? '';
            return div.innerHTML;
        }

        function hasValidCoordinates(row) {
            if (!row.latitude || !row.longitude) return false;
            const lat = row.latitude.toString().trim();
            const lng = row.longitude.toString().trim();
            return lat !== '' && lat !== '-' && lat !== '0' && lng !== '' && lng !== '-' && lng !== '0';
        }

        const absensiPopupOverlay = document.getElementById('absensi-popup-overlay');
        const absensiPopupBreakdown = document.getElementById('absensi-popup-breakdown');

        function openAbsensiPopup(employee) {
            if (employee) {
                absensiPopupBreakdown.style.display = 'block';
                absensiPopupBreakdown.innerHTML = `
                    <strong>${escapeHtml(employee.nama)}</strong><br>
                    WFO: ${employee.cnt_wfo ?? 0} hari &bull;
                    WFH: ${employee.cnt_wfh ?? 0} hari &bull;
                    Izin: ${employee.cnt_izin ?? 0} hari &bull;
                    Dinas: ${employee.cnt_dinas ?? 0} hari
                    <br><span style="color:#6b7280;">Total absensi: ${employee.absensi ?? 0} / ${employee.hari_kerja ?? '-'} hari kerja</span>
                `;
            } else {
                absensiPopupBreakdown.style.display = 'none';
                absensiPopupBreakdown.innerHTML = '';
            }
            absensiPopupOverlay.classList.add('show');
        }

        function closeAbsensiPopup() {
            absensiPopupOverlay.classList.remove('show');
        }

        document.getElementById('absensi-popup-close').addEventListener('click', closeAbsensiPopup);
        absensiPopupOverlay.addEventListener('click', (e) => {
            if (e.target === absensiPopupOverlay) closeAbsensiPopup();
        });

        function absensiColumnHeaderHtml() {
            return `Absensi
                <button type="button" class="absensi-info-btn" title="Info ketentuan absensi" onclick="event.stopPropagation(); openAbsensiPopup(null);">
                    <i class="fas fa-info"></i>
                </button>`;
        }

        function renderAbsensiCell(emp) {
            const total = emp.absensi ?? 0;
            const hariKerja = emp.hari_kerja ?? '-';
            return `<span>${total} / ${hariKerja} hari</span>`;
        }

        window.openAbsensiPopup = openAbsensiPopup;

        function renderAttendanceCell(attendance) {
            const { badgeStyle, barColor } = getAttendanceStyle(attendance);
            return `
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div class="progress-bar-bg" style="flex-grow: 1; height: 8px;">
                        <div style="background-color: ${barColor}; height: 8px; width: ${Math.min(attendance, 100)}%; border-radius: 9999px;"></div>
                    </div>
                    <span style="display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; min-width: 50px; text-align: center; ${badgeStyle}">
                        ${attendance}%
                    </span>
                </div>
            `;
        }

        function renderRegionalSummaryRow(summary) {
            const hariKerja = summary.hari_kerja ?? '-';
            const jumlahPegawai = summary.jumlah_pegawai ?? 0;
            const attendance = parseFloat(summary.persentase_kehadiran ?? 0).toFixed(1);
            const barColor = '#bbf7d0';

            const tr = document.createElement('tr');
            tr.className = 'regional-summary-row';
            tr.innerHTML = `
                <td style="text-align: center;"><i class="fas fa-building" style="color:#bbf7d0;"></i></td>
                <td>
                    <div class="summary-label">
                        <i class="fas fa-chart-line"></i>
                        <span>${escapeHtml(summary.divisi)}</span>
                        <span style="font-size:11px;font-weight:500;opacity:0.9;">(${jumlahPegawai} karyawan)</span>
                    </div>
                </td>
                <td style="text-align: center;">${hariKerja} Hari</td>
                <td>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div class="progress-bar-bg" style="flex-grow: 1; height: 8px;">
                            <div style="background-color: ${barColor}; height: 8px; width: ${Math.min(attendance, 100)}%; border-radius: 9999px;"></div>
                        </div>
                        <span class="summary-pct-badge" style="display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; min-width: 50px; text-align: center;">
                            ${attendance}%
                        </span>
                    </div>
                </td>
            `;
            return tr;
        }

        function renderHrisRow(row, index) {
            const divisi = row.divisi || '-';
            const hariKerja = row.hari_kerja ?? '-';
            const jumlahPegawai = row.jumlah_pegawai ?? 0;
            const attendance = parseFloat(row.persentase_kehadiran ?? 0).toFixed(1);

            const tr = document.createElement('tr');
            tr.className = 'divisi-row';
            tr.dataset.divisi = divisi;
            tr.innerHTML = `
                <td style="text-align: center; font-weight: 700; color: #94a3b8;">${index + 1}</td>
                <td style="text-align: left; font-weight: 600; color: #1f2937;">
                    <i class="fas fa-chevron-right expand-icon"></i>${escapeHtml(divisi)}
                    <span style="font-size:11px;color:#6b7280;font-weight:500;margin-left:6px;">(${jumlahPegawai} karyawan)</span>
                </td>
                <td style="text-align: center; color: #4b5563;">${hariKerja} Hari</td>
                <td>${renderAttendanceCell(attendance)}</td>
            `;

            tr.addEventListener('click', () => toggleDivisiDetail(tr, divisi));
            return tr;
        }

        function renderDetailRow(divisi, employees, isLoading, errorMsg) {
            const tr = document.createElement('tr');
            tr.className = 'detail-row';
            tr.dataset.detailFor = divisi;

            let inner = '';
            if (isLoading) {
                inner = '<div style="padding:16px;text-align:center;color:#6b7280;"><i class="fas fa-spinner fa-spin"></i> Memuat karyawan...</div>';
            } else if (errorMsg) {
                inner = `<div style="padding:16px;color:#991b1b;">⚠️ ${escapeHtml(errorMsg)}</div>`;
            } else if (!employees.length) {
                inner = '<div style="padding:16px;color:#6b7280;">Tidak ada data karyawan.</div>';
            } else {
                const rows = employees.map((emp, i) => {
                    const pct = parseFloat(emp.persentase_kehadiran ?? 0).toFixed(1);
                    const belumAbsen = (emp.belum_absen == 1 || (emp.absensi ?? 0) == 0);
                    const belumBadge = belumAbsen ? '<span class="belum-absen-badge">Belum absen</span>' : '';
                    return `
                        <tr style="${belumAbsen ? 'background:#fffbfb;' : ''}">
                            <td style="text-align:center;">${i + 1}</td>
                            <td style="text-align:left;font-weight:600;">${escapeHtml(emp.nama)}${belumBadge}</td>
                            <td style="text-align:center;">${escapeHtml(emp.pegawai_nik)}</td>
                            <td style="text-align:left;">${escapeHtml(emp.jabatan || '-')}</td>
                            <td style="text-align:center;">${renderAbsensiCell(emp)}</td>
                            <td>${renderAttendanceCell(pct)}</td>
                        </tr>
                    `;
                }).join('');

                inner = `
                    <div style="padding:12px 16px 16px 32px;">
                        <div style="font-size:12px;font-weight:700;color:#166534;margin-bottom:8px;">
                            Detail Karyawan &mdash; ${escapeHtml(divisi)}
                        </div>
                        <table class="detail-table">
                            <thead>
                                <tr>
                                    <th style="width:40px;">No</th>
                                    <th style="text-align:left;">Nama Karyawan</th>
                                    <th style="width:110px;">NIK</th>
                                    <th style="text-align:left;">Jabatan</th>
                                    <th style="width:140px;">${absensiColumnHeaderHtml()}</th>
                                    <th style="width:220px;">Persentase</th>
                                </tr>
                            </thead>
                            <tbody>${rows}</tbody>
                        </table>
                    </div>
                `;
            }

            tr.innerHTML = `<td colspan="4">${inner}</td>`;
            return tr;
        }

        function removeDetailRow(divisi) {
            const existing = hrisTbody.querySelector(`tr.detail-row[data-detail-for="${CSS.escape(divisi)}"]`);
            if (existing) existing.remove();
        }

        function fetchHrisDetail(periode, divisi) {
            const params = new URLSearchParams({ periode, divisi });
            return fetch(`${hrisDetailUrl}?${params}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status !== 'success') {
                        throw new Error(data.message || 'Gagal memuat detail karyawan.');
                    }
                    return data.data;
                });
        }

        function toggleDivisiDetail(divisiRow, divisi) {
            const isActive = divisiRow.classList.contains('active');

            hrisTbody.querySelectorAll('.divisi-row.active').forEach(r => r.classList.remove('active'));
            hrisTbody.querySelectorAll('.detail-row').forEach(r => r.remove());

            if (isActive && activeDivisi === divisi) {
                activeDivisi = null;
                return;
            }

            divisiRow.classList.add('active');
            activeDivisi = divisi;

            const detailRow = renderDetailRow(divisi, [], true);
            divisiRow.insertAdjacentElement('afterend', detailRow);

            fetchHrisDetail(currentPeriode, divisi)
                .then(employees => {
                    const updated = renderDetailRow(divisi, employees, false);
                    detailRow.replaceWith(updated);
                })
                .catch(err => {
                    const updated = renderDetailRow(divisi, [], false, err.message);
                    detailRow.replaceWith(updated);
                });
        }

        function showHrisLoading() {
            hrisError.style.display = 'none';
            hrisTbody.innerHTML = '<tr class="loading-row"><td colspan="4"><i class="fas fa-spinner fa-spin"></i> Memuat data HRIS...</td></tr>';
            dataCountBadge.textContent = 'Memuat...';
        }

        function setHrisTab(tab) {
            activeHrisTab = tab;
            document.querySelectorAll('.hris-tab-btn').forEach(btn => {
                btn.classList.toggle('active', btn.dataset.tab === tab);
            });
            document.getElementById('tab-rekap').classList.toggle('active', tab === 'rekap');
            document.getElementById('tab-harian').classList.toggle('active', tab === 'harian');
            document.getElementById('tab-perkaryawan').classList.toggle('active', tab === 'perkaryawan');

            // Auto-load data harian saat tab dibuka jika tanggal sudah terisi
            if (tab === 'harian' && harianTanggalSelect.value) {
                loadHarianData();
            }
        }

        document.querySelectorAll('.hris-tab-btn').forEach(btn => {
            btn.addEventListener('click', () => setHrisTab(btn.dataset.tab));
        });

        function updateHarianDateBounds() {
            if (!currentPeriode) return;
            const [y, m] = currentPeriode.split('-');
            const lastDay = new Date(parseInt(y), parseInt(m), 0).getDate();
            const min = `${y}-${m}-01`;
            const max = `${y}-${m}-${String(lastDay).padStart(2, '0')}`;
            harianTanggalSelect.min = min;
            harianTanggalSelect.max = max;

            const today = new Date();
            const todayStr = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;

            if (todayStr >= min && todayStr <= max) {
                harianTanggalSelect.value = todayStr;
            } else if (todayStr > max) {
                harianTanggalSelect.value = max;
            } else {
                harianTanggalSelect.value = min;
            }
        }

        function loadHarianDivisiOptions(periode) {
            return fetch(`${hrisDivisiUrl}?periode=${encodeURIComponent(periode)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status !== 'success') throw new Error(data.message);
                    const prev = harianDivisiSelect.value;
                    harianDivisiSelect.innerHTML = '<option value="">Semua Divisi</option>';
                    data.data.forEach(row => {
                        const opt = document.createElement('option');
                        opt.value = row.divisi;
                        opt.textContent = row.divisi;
                        harianDivisiSelect.appendChild(opt);
                    });
                    if (prev) harianDivisiSelect.value = prev;
                });
        }

        function loadHarianData() {
            const divisi = harianDivisiSelect.value;
            const tanggal = harianTanggalSelect.value;
            const status = harianStatusSelect.value;
            _harianData = [];
            if (!tanggal || !currentPeriode) {
                harianTbody.innerHTML = '<tr class="loading-row"><td colspan="12">Pilih tanggal untuk menampilkan data.</td></tr>';
                return;
            }

            harianTbody.innerHTML = '<tr class="loading-row"><td colspan="12"><i class="fas fa-spinner fa-spin"></i> Memuat detail harian...</td></tr>';
            const params = new URLSearchParams({ periode: currentPeriode, divisi, tanggal, status });
            fetch(`${hrisHarianUrl}?${params}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status !== 'success') throw new Error(data.message);
                    _harianData = data.data || [];
                    if (!_harianData.length) {
                        harianTbody.innerHTML = '<tr class="loading-row"><td colspan="12">Tidak ada data karyawan untuk filter yang dipilih.</td></tr>';
                        return;
                    }
                    harianTbody.innerHTML = '';
                    data.data.forEach((row, i) => {
                        const tr = document.createElement('tr');
                        const noAbsen = row.checkin_time === '-' && row.checkout_time === '-';
                        if (noAbsen) tr.style.background = '#fffbfb';

                        const statusBadge = noAbsen 
                            ? `<span style="display: inline-block; background-color: #fef2f2; color: #991b1b; border: 1px solid #fecaca; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; width: 100%; text-align: center;">BELUM ABSEN</span>`
                            : `<span style="display: inline-block; background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; width: 100%; text-align: center;">SUDAH ABSEN</span>`;

                        const mapPinHtml = hasValidCoordinates(row)
                            ? ` <i class="fas fa-map-marker-alt map-pin-icon" data-lat="${row.latitude}" data-lng="${row.longitude}" title="Lihat peta"></i>`
                            : '';

                        tr.innerHTML = `
                            <td style="text-align:center;">${i + 1}</td>
                            <td style="text-align:left;font-weight:600;">${escapeHtml(row.nama)}</td>
                            <td style="text-align:center;">${escapeHtml(row.pegawai_nik)}</td>
                            <td style="text-align:left;font-size:11px;">${escapeHtml(row.divisi || '-')}</td>
                            <td style="text-align:center;">${statusBadge}</td>
                            <td style="text-align:center;">${escapeHtml(row.hari_kerja)}</td>
                            <td style="text-align:center;">${escapeHtml(row.checkin_time)}</td>
                            <td style="text-align:center;font-size:11px;">${escapeHtml(row.mood_masuk)}</td>
                            <td style="text-align:center;">${escapeHtml(row.checkout_time)}</td>
                            <td style="text-align:center;font-size:11px;">${escapeHtml(row.mood_pulang)}</td>
                            <td style="text-align:left;font-size:11px;">${escapeHtml(row.lokasi)}${mapPinHtml}</td>
                            <td style="text-align:center;">${escapeHtml(row.jenis_absen)}</td>
                        `;
                        harianTbody.appendChild(tr);
                    });
                })
                .catch(err => {
                    harianTbody.innerHTML = `<tr class="loading-row"><td colspan="12" style="color:#991b1b;">⚠️ ${escapeHtml(err.message)}</td></tr>`;
                });
        }

        harianDivisiSelect.addEventListener('change', loadHarianData);
        harianStatusSelect.addEventListener('change', loadHarianData);
        harianTanggalSelect.addEventListener('change', loadHarianData);

        const btnExportExcelHarian = document.getElementById('btnExportExcelHarian');
        if (btnExportExcelHarian) {
            btnExportExcelHarian.addEventListener('click', exportHarianExcel);
        }

        async function exportHarianExcel() {
            if (!_harianData || !_harianData.length) {
                alert('Tidak ada data detail harian untuk diekspor.');
                return;
            }

            const divisi = harianDivisiSelect.value || '-';
            const tanggal = harianTanggalSelect.value || '-';
            const statusVal = harianStatusSelect.value || 'SEMUA';
            const statusLabel = statusVal === 'sudah' ? 'SUDAH ABSEN' : (statusVal === 'belum' ? 'BELUM ABSEN' : 'SEMUA');

            // Format date to local ID format (DD-MM-YYYY)
            let formattedDate = tanggal;
            if (tanggal && tanggal !== '-') {
                const d = new Date(tanggal);
                if (!isNaN(d.getTime())) {
                    formattedDate = `${String(d.getDate()).padStart(2, '0')}-${String(d.getMonth() + 1).padStart(2, '0')}-${d.getFullYear()}`;
                }
            }

            const workbook = new ExcelJS.Workbook();
            const ws = workbook.addWorksheet('Detail Harian');

            const headers = [
                'No', 'Nama Karyawan', 'NIK', 'Divisi', 'Status Absen', 'Hari Kerja', 
                'Check In', 'Mood Check In', 'Check Out', 'Mood Check Out', 'Lokasi', 'Jenis Absen'
            ];

            ws.columns = [
                { key: 'no', width: 6 },
                { key: 'nama', width: 28 },
                { key: 'nik', width: 14 },
                { key: 'divisi', width: 30 },
                { key: 'status_absen', width: 16 },
                { key: 'hari_kerja', width: 12 },
                { key: 'check_in', width: 12 },
                { key: 'mood_masuk', width: 16 },
                { key: 'check_out', width: 12 },
                { key: 'mood_pulang', width: 16 },
                { key: 'lokasi', width: 45 },
                { key: 'jenis_absen', width: 15 }
            ];

            const borderStyle = {
                top: { style: 'thin', color: { argb: 'FFE5E7EB' } },
                left: { style: 'thin', color: { argb: 'FFE5E7EB' } },
                bottom: { style: 'thin', color: { argb: 'FFE5E7EB' } },
                right: { style: 'thin', color: { argb: 'FFE5E7EB' } }
            };
            const fillSolid = argb => ({ type: 'pattern', pattern: 'solid', fgColor: { argb } });

            // Title Row
            ws.mergeCells(1, 1, 1, 12);
            const titleCell = ws.getCell(1, 1);
            titleCell.value = 'DETAIL ABSENSI HARIAN KARYAWAN';
            titleCell.font = { bold: true, size: 14, color: { argb: 'FF166534' } };
            titleCell.alignment = { horizontal: 'center', vertical: 'middle' };
            ws.getRow(1).height = 28;

            // Subtitle / Filters Row
            ws.mergeCells(2, 1, 2, 12);
            const subTitleCell = ws.getCell(2, 1);
            subTitleCell.value = `Divisi: ${divisi}   |   Tanggal: ${formattedDate}   |   Status: ${statusLabel}`;
            subTitleCell.font = { italic: true, size: 10, color: { argb: 'FF4B5563' } };
            subTitleCell.alignment = { horizontal: 'center', vertical: 'middle' };
            ws.getRow(2).height = 20;

            // Empty row
            ws.addRow([]);

            // Header Row (Row 4)
            const hRow = ws.addRow(headers);
            hRow.height = 22;
            hRow.eachCell(cell => {
                cell.fill = fillSolid('FF166534');
                cell.font = { bold: true, color: { argb: 'FFFFFFFF' }, size: 10 };
                cell.alignment = { horizontal: 'center', vertical: 'middle', wrapText: true };
                cell.border = {
                    top: { style: 'thin', color: { argb: 'FF14532D' } },
                    left: { style: 'thin', color: { argb: 'FF14532D' } },
                    bottom: { style: 'medium', color: { argb: 'FF14532D' } },
                    right: { style: 'thin', color: { argb: 'FF14532D' } }
                };
            });

            // Data Rows
            _harianData.forEach((row, i) => {
                const noAbsen = row.checkin_time === '-' && row.checkout_time === '-';
                const statusText = noAbsen ? 'BELUM ABSEN' : 'SUDAH ABSEN';

                const rowData = [
                    i + 1,
                    row.nama,
                    row.pegawai_nik,
                    row.divisi || '-',
                    statusText,
                    row.hari_kerja,
                    row.checkin_time,
                    row.mood_masuk,
                    row.checkout_time,
                    row.mood_pulang,
                    row.lokasi,
                    row.jenis_absen
                ];

                const exRow = ws.addRow(rowData);
                exRow.height = 20;

                const bg = noAbsen ? 'FFFFF5F5' : (i % 2 === 0 ? 'FFFFFFFF' : 'FFF9FAFB');

                exRow.eachCell({ includeEmpty: true }, (cell, colNum) => {
                    cell.fill = fillSolid(bg);
                    cell.font = { size: 9.5 };
                    cell.border = borderStyle;
                    
                    // Alignments
                    // col 1=No, 2=Nama, 3=NIK, 4=Divisi, 5=Status, 6=HariKerja, 7=CheckIn, 8=MoodCheckin, 9=CheckOut, 10=MoodCheckout, 11=Lokasi, 12=JenisAbsen
                    if (colNum === 1 || colNum === 3 || colNum === 6 || colNum === 7 || colNum === 8 || colNum === 9 || colNum === 10 || colNum === 12) {
                        cell.alignment = { horizontal: 'center', vertical: 'middle' };
                    } else if (colNum === 5) {
                        cell.alignment = { horizontal: 'center', vertical: 'middle' };
                        cell.font = { bold: true, size: 9.5, color: { argb: noAbsen ? 'FF991B1B' : 'FF166534' } };
                    } else {
                        cell.alignment = { horizontal: 'left', vertical: 'middle', wrapText: colNum === 11 };
                    }
                });
            });

            const buffer = await workbook.xlsx.writeBuffer();
            const blob = new Blob([buffer], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `Detail_Harian_${divisi.replace(/[^a-zA-Z0-9]/g, '_')}_${tanggal}.xlsx`;
            a.click();
            URL.revokeObjectURL(url);
        }

        function loadPerKaryawanData() {
            const regional = perkaryawanRegionalSelect.value;
            const pegawai_id = perkaryawanPegawaiId.value;
            const tanggal_awal = perkaryawanTanggalAwal.value;
            const tanggal_akhir = perkaryawanTanggalAkhir.value;

            if (!regional || !pegawai_id || !tanggal_awal || !tanggal_akhir || !currentPeriode) {
                perkaryawanTbody.innerHTML = '<tr class="loading-row"><td colspan="9">Pilih regional, karyawan, dan range tanggal untuk menampilkan data.</td></tr>';
                return;
            }

                        perkaryawanTbody.innerHTML = '<tr class="loading-row"><td colspan="10"><i class="fas fa-spinner fa-spin"></i> Memuat detail per karyawan...</td></tr>';
            const params = new URLSearchParams({ periode: currentPeriode, pegawai_id, tanggal_awal, tanggal_akhir });
            fetch(`${hrisPerKaryawanUrl}?${params}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status !== 'success') throw new Error(data.message);
                    if (!data.data.length) {
                        perkaryawanTbody.innerHTML = '<tr class="loading-row"><td colspan="10">Tidak ada data absensi untuk periode yang dipilih.</td></tr>';
                        return;
                    }
                    perkaryawanTbody.innerHTML = '';
                    data.data.forEach((row, i) => {
                        const tr = document.createElement('tr');
                        const noAbsen = row.checkin_time === '-' && row.checkout_time === '-';
                        if (noAbsen) tr.style.background = '#fffbfb';
                        const mapPinHtml = hasValidCoordinates(row)
                            ? ` <i class="fas fa-map-marker-alt map-pin-icon" data-lat="${row.latitude}" data-lng="${row.longitude}" title="Lihat peta"></i>`
                            : '';

                        tr.innerHTML = `
                            <td style="text-align:center;">${i + 1}</td>
                            <td style="text-align:left;font-weight:600;">${escapeHtml(row.tanggal)}${noAbsen ? '<span class="belum-absen-badge">Belum absen</span>' : ''}</td>
                            <td style="text-align:center;">${escapeHtml(row.pegawai_nik)}</td>
                            <td style="text-align:center;">${escapeHtml(row.hari_kerja)}</td>
                            <td style="text-align:center;">${escapeHtml(row.checkin_time)}</td>
                            <td style="text-align:center;font-size:11px;">${escapeHtml(row.mood_masuk)}</td>
                            <td style="text-align:center;">${escapeHtml(row.checkout_time)}</td>
                            <td style="text-align:center;font-size:11px;">${escapeHtml(row.mood_pulang)}</td>
                            <td style="text-align:left;font-size:11px;">${escapeHtml(row.lokasi)}${mapPinHtml}</td>
                            <td style="text-align:center;">${escapeHtml(row.jenis_absen)}</td>
                        `;
                        perkaryawanTbody.appendChild(tr);
                    });
                })
                .catch(err => {
                    perkaryawanTbody.innerHTML = `<tr class="loading-row"><td colspan="10" style="color:#991b1b;">⚠️ ${escapeHtml(err.message)}</td></tr>`;
                });
        }

        perkaryawanRegionalSelect.addEventListener('change', () => {
            perkaryawanNamaSearch.value = '';
            perkaryawanPegawaiId.value = '';
            perkaryawanSelectedNama.textContent = '';
            perkaryawanNamaDropdown.style.display = 'none';
            perkaryawanTbody.innerHTML = '<tr class="loading-row"><td colspan="10">Pilih regional, karyawan, dan range tanggal untuk menampilkan data.</td></tr>';
        });

        perkaryawanNamaSearch.addEventListener('input', (e) => {
            const search = e.target.value.trim();
            const regional = perkaryawanRegionalSelect.value;

            if (search.length < 3) {
                perkaryawanNamaDropdown.style.display = 'none';
                return;
            }

            if (!regional) {
                perkaryawanNamaDropdown.innerHTML = '<div style="padding:8px;color:#991b1b;">Pilih regional terlebih dahulu</div>';
                perkaryawanNamaDropdown.style.display = 'block';
                return;
            }

            const params = new URLSearchParams({ search, regional });
            fetch(`${hrisPegawaiListUrl}?${params}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status !== 'success') throw new Error(data.message);
                    if (!data.data.length) {
                        perkaryawanNamaDropdown.innerHTML = '<div style="padding:8px;color:#6b7280;">Tidak ada karyawan ditemukan</div>';
                        perkaryawanNamaDropdown.style.display = 'block';
                        return;
                    }
                    perkaryawanNamaDropdown.innerHTML = data.data.map(emp => `
                        <div class="dropdown-item" data-pegawai-id="${escapeHtml(emp.pegawai_id)}" data-nama="${escapeHtml(emp.nama)}" style="padding:10px;border-bottom:1px solid #e5e7eb;cursor:pointer;hover:background:#f3f4f6;">
                            <div style="font-weight:600;">${escapeHtml(emp.nama)}</div>
                            <div style="font-size:11px;color:#6b7280;">${escapeHtml(emp.nik)} - ${escapeHtml(emp.divisi)}</div>
                        </div>
                    `).join('');
                    perkaryawanNamaDropdown.style.display = 'block';

                    document.querySelectorAll('.dropdown-item').forEach(item => {
                        item.addEventListener('click', () => {
                            const pegawaiId = item.dataset.pegawaiId;
                            const nama = item.dataset.nama;
                            perkaryawanPegawaiId.value = pegawaiId;
                            perkaryawanNamaSearch.value = nama;
                            perkaryawanSelectedNama.textContent = `✓ ${nama}`;
                            perkaryawanNamaDropdown.style.display = 'none';
                        });
                    });
                })
                .catch(err => {
                    perkaryawanNamaDropdown.innerHTML = `<div style="padding:8px;color:#991b1b;">⚠️ ${escapeHtml(err.message)}</div>`;
                    perkaryawanNamaDropdown.style.display = 'block';
                });
        });

        document.addEventListener('click', (e) => {
            if (!e.target.closest('#perkaryawan_nama_search') && !e.target.closest('.dropdown-list')) {
                perkaryawanNamaDropdown.style.display = 'none';
            }
        });

        perkaryawanTanggalAwal.addEventListener('change', loadPerKaryawanData);
        perkaryawanTanggalAkhir.addEventListener('change', loadPerKaryawanData);

        function loadRegionalList() {
            fetch(hrisRegionalListUrl)
                .then(res => res.json())
                .then(data => {
                    if (data.status !== 'success') throw new Error(data.message);
                    const regionalValue = data.data;
                    // Populate regional select for per-karyawan tab
                    const currentOption = perkaryawanRegionalSelect.querySelector(`option[value="${regionalValue}"]`);
                    if (!currentOption) {
                        const option = document.createElement('option');
                        option.value = regionalValue;
                        option.textContent = regionalValue;
                        perkaryawanRegionalSelect.appendChild(option);
                    }
                    perkaryawanRegionalSelect.value = regionalValue;
                })
                .catch(err => {
                    console.error('Error loading regional list:', err);
                });
        }

        function fetchHrisData(periode) {
            showHrisLoading();

            const params = new URLSearchParams({ periode });
            return fetch(`${hrisDataUrl}?${params}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status !== 'success') {
                        throw new Error(data.message || 'Gagal memuat data HRIS.');
                    }
                    return data;
                });
        }

        function updateDashboard() {
            const selectedApp = appSelect.value;
            const periodVal = periodeSelect.value;
            const formattedPeriod = formatPeriodLabel(periodVal);

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

            tableTitle.textContent = `Hasil Evaluasi Aplikasi ${selectedApp} &mdash; Periode ${formattedPeriod}`;

            if (selectedApp === 'HRIS') {
                currentPeriode = periodVal;
                activeDivisi = null;
                regionalBadge.style.display = 'inline-block';
                hrisTabsWrap.style.display = 'block';
                nonHrisWrapper.style.display = 'none';
                placeholderState.style.display = 'none';
                updateHarianDateBounds();
                loadHarianDivisiOptions(periodVal)
                    .then(() => loadHarianData())
                    .catch(() => loadHarianData());
                loadRegionalList();

                fetchHrisData(periodVal)
                    .then(data => {
                        hrisError.style.display = 'none';
                        hrisTbody.innerHTML = '';

                        if (!data.data || data.data.length === 0) {
                            hrisTbody.innerHTML = '<tr class="loading-row"><td colspan="4">Tidak ada data SuppCo HO untuk periode ini.</td></tr>';
                            dataCountBadge.textContent = '0 Divisi';
                            return;
                        }

                        if (data.summary) {
                            hrisTbody.appendChild(renderRegionalSummaryRow(data.summary));
                        }

                        data.data.forEach((row, index) => {
                            hrisTbody.appendChild(renderHrisRow(row, index));
                        });
                        dataCountBadge.textContent = `${data.total} Divisi`;
                    })
                    .catch(err => {
                        hrisTbody.innerHTML = '';
                        hrisError.style.display = 'block';
                        hrisError.textContent = '⚠️ ' + err.message;
                        dataCountBadge.textContent = 'Error';
                    });

                if (activeHrisTab === 'harian' && harianDivisiSelect.value && harianTanggalSelect.value) {
                    loadHarianData();
                }
                return;
            }

            hrisError.style.display = 'none';
            regionalBadge.style.display = 'none';
            hrisTabsWrap.style.display = 'none';
            nonHrisWrapper.style.display = 'block';
            placeholderState.style.display = 'block';
            activeDivisi = null;

            document.getElementById('placeholder-title').textContent = `Evaluasi Aplikasi ${selectedApp} Belum Tersedia`;
            document.getElementById('placeholder-desc').textContent = `Data evaluasi dan rekapan performa untuk aplikasi ${selectedApp} untuk periode ${formattedPeriod} sedang dipersiapkan.`;

            dataCountBadge.textContent = '0 Data';
        }

        // ===== TOKEN MODE GUARD =====
        const isTokenMode = @json($tokenMode);
        if (isTokenMode) {
            // Sembunyikan sidebar agar tampilan bersih saat embed/token access
            const sidebar = document.getElementById('sidebar');
            const menuIcon = document.getElementById('menuIcon');
            if (sidebar) sidebar.style.display = 'none';
            if (menuIcon) menuIcon.style.display = 'none';

            // Paksa mainContent full width
            const mainContent = document.querySelector('.evaluasi-container.main-content');
            if (mainContent) {
                mainContent.style.marginLeft = '0';
                mainContent.style.width = '100%';
            }

            // Blok event change app_select (sudah disabled tapi double-safety)
            appSelect.addEventListener('change', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                this.value = 'HRIS';
            }, true);
        }

        appSelect.addEventListener('change', updateDashboard);
        periodeSelect.addEventListener('change', updateDashboard);

        updateDashboard();

        // Map popup functionality
        const mapPopupOverlay = document.getElementById('mapPopupOverlay');
        const mapPopupClose = document.getElementById('mapPopupClose');
        const mapInfoLokasi = document.getElementById('mapInfoLokasi');
        const mapInfoLatitude = document.getElementById('mapInfoLatitude');
        const mapInfoLongitude = document.getElementById('mapInfoLongitude');
        const mapContainer = document.getElementById('mapContainer');
        let mapInstance = null;
        let mapMarker = null;

        function openMapPopup(lat, lng, lokasi) {
            if (!lat || !lng) {
                alert('Koordinat tidak tersedia.');
                return;
            }

            let latitude = parseFloat(lat);
            let longitude = parseFloat(lng);

            if (isNaN(latitude) || isNaN(longitude)) {
                alert('Koordinat tidak valid.');
                return;
            }

            // Detect and correct swapped coordinates
            // In Indonesia, longitude is positive and large (~95 to 141), latitude is small (~-11 to 6).
            // If latitude is outside [-90, 90] (e.g. 106.xxx or 110.xxx) and longitude is inside [-90, 90] (e.g. -6.xxx), swap them.
            if (latitude > 90 || latitude < -90) {
                const temp = latitude;
                latitude = longitude;
                longitude = temp;
            }

            mapPopupOverlay.classList.add('show');
            if (!mapInstance) {
                mapInstance = L.map('mapContainer').setView([latitude, longitude], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(mapInstance);
                mapMarker = L.marker([latitude, longitude]).addTo(mapInstance);
            } else {
                mapInstance.setView([latitude, longitude], 13);
                mapMarker.setLatLng([latitude, longitude]);
            }
            setTimeout(() => {
                if (mapInstance) {
                    mapInstance.invalidateSize();
                }
            }, 250);
            mapInfoLokasi.textContent = lokasi || '-';
            mapInfoLatitude.textContent = latitude;
            mapInfoLongitude.textContent = longitude;
        }

        mapPopupClose.addEventListener('click', () => {
            mapPopupOverlay.classList.remove('show');
        });

        // Delegate click for map pin icons
        document.addEventListener('click', function(e) {
            const target = e.target;
            const mapPin = target.closest('.map-pin-icon');
            if (mapPin) {
                const lat = mapPin.dataset.lat;
                const lng = mapPin.dataset.lng;
                const td = mapPin.closest('td');
                const lokasi = td ? td.textContent.trim() : '';
                openMapPopup(lat, lng, lokasi);
            }
        });
    });
</script>

<!-- Application Select Handler for redirects -->
<script src="{{ asset('js/components/application-select-handler.js') }}"></script>

@endsection


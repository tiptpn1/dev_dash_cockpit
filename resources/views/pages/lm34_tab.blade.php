@extends('layouts.app')

@section('styles')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* ===== Select2 — sesuaikan dengan tema hijau ===== */
        .select2-container--default .select2-selection--single {
            height: 36px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background-color: #fff;
            color: #1f2937;
            font-size: 13px;
            display: flex;
            align-items: center;
            padding: 0 10px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px;
            padding-left: 0;
            color: #111827 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #6b7280 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 34px;
        }

        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: #166534;
            box-shadow: 0 0 0 2px rgba(22, 101, 52, 0.12);
            outline: none;
        }

        .select2-container--default .select2-results__option {
            color: #111827 !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #166534;
            color: #fff !important;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #d1d5db;
            border-radius: 4px;
            padding: 4px 8px;
            font-size: 12px;
            color: #111827 !important;
        }

        .select2-dropdown {
            border: 1px solid #166534;
            border-radius: 6px;
            font-size: 13px;
        }

        .select2-container {
            width: 100% !important;
        }

        html,
        body {
            height: auto !important;
            min-height: 100vh;
            overflow-y: auto !important;
        }

        .lm13-container.main-content {
            padding: 0 !important;
            margin-left: 0 !important;
        }

        /* ===== MAIN CONTAINER ===== */
        .lm13-container {
            padding: 0;
            margin: 0;
            width: 100%;
            min-height: 100vh;
            background: #f8fafc;
            overflow-x: hidden;
            box-sizing: border-box;
            font-family: inherit;
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

        /* ===== TAB NAVIGATION ===== */
        .lm-tab-nav {
            display: flex;
            gap: 0;
            background: #fff;
            border-bottom: 2px solid #e5e7eb;
            margin-bottom: 20px;
            border-radius: 8px 8px 0 0;
            padding: 0;
        }

        .lm-tab-btn {
            padding: 12px 24px;
            background: transparent;
            border: none;
            border-bottom: 3px solid transparent;
            color: #6b7280;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
            position: relative;
        }

        .lm-tab-btn:hover {
            color: #374151;
            background: #f9fafb;
        }

        .lm-tab-btn.active {
            color: #166534;
            border-bottom-color: #166534;
            background: #f0fdf4;
        }

        .lm-tab-btn i {
            font-size: 16px;
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
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
            margin-bottom: 12px;
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

        .form-select {
            width: 100%;
            padding: 8px 10px;
            background-color: #fff;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            color: #1f2937;
            font-size: 13px;
            transition: border-color 0.2s;
        }

        .form-select:focus {
            outline: none;
            border-color: #166534;
            box-shadow: 0 0 0 2px rgba(22, 101, 52, 0.12);
        }

        .button-group {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
            margin-top: 12px;
        }

        .btn-filter {
            padding: 8px 22px;
            background: #166534;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
        }

        .btn-filter:hover {
            background: #15803d;
        }

        .btn-reset {
            padding: 8px 22px;
            background: #fff;
            color: #374151;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
        }

        .btn-reset:hover {
            background: #f3f4f6;
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

        .table-wrapper {
            overflow-x: auto;
            overflow-y: auto;
            max-height: 70vh;
            width: 100%;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11.5px;
            color: #1f2937;
        }

        .report-table thead th {
            background: #15803d;
            color: #fff;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 9px 12px;
            border: 1px solid #166534;
            text-align: center;
            white-space: nowrap;
            position: sticky;
            top: 0;
            z-index: 2;
        }

        .report-table tbody td {
            padding: 5px 8px;
            border: 1px solid #e5e7eb;
            vertical-align: middle;
            color: #1f2937;
        }

        .report-table tbody td.num {
            text-align: right;
            font-family: 'Courier New', Courier, monospace;
            white-space: nowrap;
            width: 100px;
        }

        .report-table tbody td.label-cell {
            text-align: left;
            padding-left: 10px;
            white-space: nowrap;
        }

        .report-table tbody tr.row-subtotal td {
            background: #f0fdf4;
            font-weight: 700;
            color: #14532d;
            border-top: 1px solid #bbf7d0;
        }

        .report-table tbody tr.row-total td {
            background: #dcfce7;
            font-weight: 800;
            color: #14532d;
            border-top: 2px solid #166534;
            border-bottom: 2px solid #166534;
        }

        .report-table tbody tr:hover td {
            background-color: #f0fdf4;
        }

        .dash {
            color: #9ca3af;
        }

        /* ===== TAB CONTENT CONTAINER ===== */
        .lm-tab-content {
            display: none;
        }

        .lm-tab-content.active {
            display: block;
            animation: fadeIn 0.2s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0.8;
            }

            to {
                opacity: 1;
            }
        }
    </style>
@endsection

@section('content')
    <div class="lm13-container main-content">
        <!-- Page Header -->
        <header class="lm-page-header">
            <div class="lm-header-logo">
                <img src="{{ asset('danantara.png') }}" alt="Danantara">
            </div>
            <div class="lm-header-center">
                <svg style="width:28px;height:28px;color:#22c55e;flex-shrink:0;" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.95-2.3A5 5 0 008 22c12 0 15-17 15-17-1 2-8 2-13 3-5 1-6 7-6 7s5.5-2 8.5-2 5 2 5 2-3-5-3-5 3 5 3 5-5 3-5 3 2 3 2 6-2 6-2 6 3-3 3-6-2-6-2-6z" />
                </svg>
                <h1>LM 34 &mdash; Laporan Realisasi Penjualan</h1>
            </div>
            <div class="lm-header-right">
                <img src="{{ asset('ptpn1.png') }}" alt="PTPN 1">
            </div>
        </header>

        <!-- Main Content -->
        <div class="content-section">

            <!-- Tab Navigation -->
            <div class="lm-tab-nav">
                <button class="lm-tab-btn active" onclick="switchTab('kebun')">
                    <i class="fas fa-leaf"></i> LM34 by Material
                </button>
                <button class="lm-tab-btn" onclick="switchTab('negara')">
                    <i class="fas fa-globe"></i> LM34 by Negara
                </button>
                <button class="lm-tab-btn" onclick="switchTab('customer')">
                    <i class="fas fa-users"></i> LM34 by Customer
                </button>
            </div>

            <!-- ====== TAB 1: KEBUN ====== -->
            <div id="tab-kebun" class="lm-tab-content active">
                <!-- Filter Section -->
                <div class="filter-card">
                    <div class="filter-title">
                        <i class="fas fa-sliders-h"></i> Filter Data
                    </div>
                    <form id="filterForm-kebun">
                        <div class="filter-grid">
                            <div class="form-group">
                                <label class="form-label">Komoditas</label>
                                <select class="form-select" id="komoditasFilter-kebun">
                                    <option value="">-- Pilih Komoditas --</option>
                                    <option value="KR">Karet</option>
                                    <option value="TH">Teh</option>
                                    <option value="KP">Kopi</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Regional</label>
                                <select class="form-select" id="regionalFilter-kebun">
                                    <option value="">-- Semua Regional --</option>
                                    @foreach ($regionalList as $item)
                                        <option value="{{ $item->regional }}">{{ $item->regional }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Plant</label>
                                <select class="form-select select2-plant" id="plantFilter-kebun" style="width:100%;"
                                    disabled>
                                    <option value="">-- Pilih Regional dulu --</option>
                                    @foreach ($plantList as $item)
                                        <option value="{{ $item->plant }}">{{ $item->plant }} - {{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tahun</label>
                                <select class="form-select" id="tahunFilter-kebun">
                                    <option value="">-- Pilih Tahun --</option>
                                    @foreach ($tahunList as $thn)
                                        <option value="{{ $thn }}">{{ $thn }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Bulan</label>
                                <select class="form-select" id="bulanFilter-kebun">
                                    <option value="">-- Pilih Bulan --</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="button-group">
                            <button type="reset" class="btn-reset" id="btnReset-kebun">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                            <button type="submit" class="btn-filter" id="btnFilter-kebun" disabled
                                style="opacity:0.45; cursor:not-allowed;">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Result Table -->
                <div class="table-card" id="resultCard-kebun" style="display:none;">
                    <div class="table-header">
                        <div class="table-title">
                            <i class="fas fa-seedling"></i> Hasil Data LM34 by Kebun
                        </div>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span id="resultInfo-kebun" style="color:#93c5fd; font-size:12px;"></span>
                            <button id="btnExportExcel-kebun" onclick="exportExcel('kebun')"
                                style="display:inline-flex; align-items:center; gap:5px; padding:6px 14px; background:#16a34a; color:#fff; border:none; border-radius:6px; font-size:12px; font-weight:700; cursor:pointer;">
                                <i class="fas fa-file-excel"></i> Excel
                            </button>
                            <button id="btnExportPdf-kebun" onclick="exportPdf('kebun')"
                                style="display:inline-flex; align-items:center; gap:5px; padding:6px 14px; background:#dc2626; color:#fff; border:none; border-radius:6px; font-size:12px; font-weight:700; cursor:pointer;">
                                <i class="fas fa-file-pdf"></i> PDF
                            </button>
                        </div>
                    </div>
                    <div class="table-wrapper">
                        <div id="tableLoading-kebun" style="display:none; text-align:center; padding:24px; color:#6b7280;">
                            <i class="fas fa-spinner fa-spin"></i> Memuat data...
                        </div>
                        <div id="tableError-kebun" style="display:none; padding:16px 20px; color:#dc2626; font-size:13px;">
                        </div>
                        <div id="tableResult-kebun"></div>
                    </div>
                </div>
            </div>

            <!-- ====== TAB 2: NEGARA ====== -->
            <div id="tab-negara" class="lm-tab-content">
                <!-- Filter Section -->
                <div class="filter-card">
                    <div class="filter-title">
                        <i class="fas fa-sliders-h"></i> Filter Data
                    </div>
                    <form id="filterForm-negara">
                        <div class="filter-grid">
                            <div class="form-group">
                                <label class="form-label">Komoditas</label>
                                <select class="form-select" id="komoditasFilter-negara">
                                    <option value="">-- Pilih Komoditas --</option>
                                    <option value="KR">Karet</option>
                                    <option value="TH">Teh</option>
                                    <option value="KP">Kopi</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Regional</label>
                                <select class="form-select" id="regionalFilter-negara">
                                    <option value="">-- Semua Regional --</option>
                                    @foreach ($regionalList as $item)
                                        <option value="{{ $item->regional }}">{{ $item->regional }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Plant</label>
                                <select class="form-select select2-plant" id="plantFilter-negara" style="width:100%;"
                                    disabled>
                                    <option value="">-- Pilih Regional dulu --</option>
                                    @foreach ($plantList as $item)
                                        <option value="{{ $item->plant }}">{{ $item->plant }} - {{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tahun</label>
                                <select class="form-select" id="tahunFilter-negara">
                                    <option value="">-- Pilih Tahun --</option>
                                    @foreach ($tahunList as $thn)
                                        <option value="{{ $thn }}">{{ $thn }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Bulan</label>
                                <select class="form-select" id="bulanFilter-negara">
                                    <option value="">-- Pilih Bulan --</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="button-group">
                            <button type="reset" class="btn-reset" id="btnReset-negara">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                            <button type="submit" class="btn-filter" id="btnFilter-negara" disabled
                                style="opacity:0.45; cursor:not-allowed;">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Result Table -->
                <div class="table-card" id="resultCard-negara" style="display:none;">
                    <div class="table-header">
                        <div class="table-title">
                            <i class="fas fa-seedling"></i> Hasil Data LM34 by Negara
                        </div>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span id="resultInfo-negara" style="color:#93c5fd; font-size:12px;"></span>
                            <button id="btnExportExcel-negara" onclick="exportExcel('negara')"
                                style="display:inline-flex; align-items:center; gap:5px; padding:6px 14px; background:#16a34a; color:#fff; border:none; border-radius:6px; font-size:12px; font-weight:700; cursor:pointer;">
                                <i class="fas fa-file-excel"></i> Excel
                            </button>
                            <button id="btnExportPdf-negara" onclick="exportPdf('negara')"
                                style="display:inline-flex; align-items:center; gap:5px; padding:6px 14px; background:#dc2626; color:#fff; border:none; border-radius:6px; font-size:12px; font-weight:700; cursor:pointer;">
                                <i class="fas fa-file-pdf"></i> PDF
                            </button>
                        </div>
                    </div>
                    <div class="table-wrapper">
                        <div id="tableLoading-negara" style="display:none; text-align:center; padding:24px; color:#6b7280;">
                            <i class="fas fa-spinner fa-spin"></i> Memuat data...
                        </div>
                        <div id="tableError-negara" style="display:none; padding:16px 20px; color:#dc2626; font-size:13px;">
                        </div>
                        <div id="tableResult-negara"></div>
                    </div>
                </div>
            </div>

            <!-- ====== TAB 3: CUSTOMER ====== -->
            <div id="tab-customer" class="lm-tab-content">
                <!-- Filter Section -->
                <div class="filter-card">
                    <div class="filter-title">
                        <i class="fas fa-sliders-h"></i> Filter Data
                    </div>
                    <form id="filterForm-customer">
                        <div class="filter-grid">
                            <div class="form-group">
                                <label class="form-label">Komoditas</label>
                                <select class="form-select" id="komoditasFilter-customer">
                                    <option value="">-- Pilih Komoditas --</option>
                                    <option value="KR">Karet</option>
                                    <option value="TH">Teh</option>
                                    <option value="KP">Kopi</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Regional</label>
                                <select class="form-select" id="regionalFilter-customer">
                                    <option value="">-- Semua Regional --</option>
                                    @foreach ($regionalList as $item)
                                        <option value="{{ $item->regional }}">{{ $item->regional }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Plant</label>
                                <select class="form-select select2-plant" id="plantFilter-customer" style="width:100%;"
                                    disabled>
                                    <option value="">-- Pilih Regional dulu --</option>
                                    @foreach ($plantList as $item)
                                        <option value="{{ $item->plant }}">{{ $item->plant }} - {{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tahun</label>
                                <select class="form-select" id="tahunFilter-customer">
                                    <option value="">-- Pilih Tahun --</option>
                                    @foreach ($tahunList as $thn)
                                        <option value="{{ $thn }}">{{ $thn }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Bulan</label>
                                <select class="form-select" id="bulanFilter-customer">
                                    <option value="">-- Pilih Bulan --</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="button-group">
                            <button type="reset" class="btn-reset" id="btnReset-customer">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                            <button type="submit" class="btn-filter" id="btnFilter-customer" disabled
                                style="opacity:0.45; cursor:not-allowed;">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Result Table -->
                <div class="table-card" id="resultCard-customer" style="display:none;">
                    <div class="table-header">
                        <div class="table-title">
                            <i class="fas fa-seedling"></i> Hasil Data LM34 by Customer
                        </div>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span id="resultInfo-customer" style="color:#93c5fd; font-size:12px;"></span>
                            <button id="btnExportExcel-customer" onclick="exportExcel('customer')"
                                style="display:inline-flex; align-items:center; gap:5px; padding:6px 14px; background:#16a34a; color:#fff; border:none; border-radius:6px; font-size:12px; font-weight:700; cursor:pointer;">
                                <i class="fas fa-file-excel"></i> Excel
                            </button>
                            <button id="btnExportPdf-customer" onclick="exportPdf('customer')"
                                style="display:inline-flex; align-items:center; gap:5px; padding:6px 14px; background:#dc2626; color:#fff; border:none; border-radius:6px; font-size:12px; font-weight:700; cursor:pointer;">
                                <i class="fas fa-file-pdf"></i> PDF
                            </button>
                        </div>
                    </div>
                    <div class="table-wrapper">
                        <div id="tableLoading-customer"
                            style="display:none; text-align:center; padding:24px; color:#6b7280;">
                            <i class="fas fa-spinner fa-spin"></i> Memuat data...
                        </div>
                        <div id="tableError-customer"
                            style="display:none; padding:16px 20px; color:#dc2626; font-size:13px;"></div>
                        <div id="tableResult-customer"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        // ========== SHARED DATA & HELPERS ==========
        const allPlants = @json($plantList->map(fn($p) => ['plant' => $p->plant, 'nama' => $p->nama, 'regional' => $p->regional]));
        const bulanNames = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        // Export data containers (per tab)
        let _exportData = {
            kebun: null,
            negara: null,
            customer: null,
        };

        // ========== TAB SWITCHING ==========
        function switchTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.lm-tab-content').forEach(el => el.classList.remove('active'));
            // Remove active from buttons
            document.querySelectorAll('.lm-tab-btn').forEach(el => el.classList.remove('active'));
            // Show selected tab
            document.getElementById('tab-' + tabName).classList.add('active');
            // Mark button as active
            event.target.closest('.lm-tab-btn').classList.add('active');
        }

        // ========== INIT EACH TAB ==========
        const tabs = ['kebun', 'negara', 'customer'];
        const endpoints = {
            kebun: '{{ route("get_data_lm34") }}',
            negara: '{{ route("get_data_lm34_by_negara") }}',
            customer: '{{ route("get_data_lm34_by_customer") }}',
        };

        tabs.forEach(tabName => {
            initTab(tabName);
        });

        function initTab(tabName) {
            const tahunSel = document.getElementById(`tahunFilter-${tabName}`);
            const bulanSel = document.getElementById(`bulanFilter-${tabName}`);
            const btnFilter = document.getElementById(`btnFilter-${tabName}`);
            const regionalSel = document.getElementById(`regionalFilter-${tabName}`);
            const plantSel = document.getElementById(`plantFilter-${tabName}`);
            const formEl = document.getElementById(`filterForm-${tabName}`);
            const btnResetEl = document.getElementById(`btnReset-${tabName}`);

            // ── Filter plant by regional ──────────────────────────────────────
            function rebuildPlantFilter(selectedRegional) {
                const currentVal = plantSel.value;
                const filtered = selectedRegional
                    ? allPlants.filter(p => p.regional === selectedRegional)
                    : [];

                if (selectedRegional) {
                    plantSel.disabled = false;
                    plantSel.style.opacity = '1';
                    plantSel.style.cursor = 'pointer';
                    plantSel.innerHTML = '<option value="">-- Semua Kebun --</option>';
                    filtered.forEach(p => {
                        const opt = document.createElement('option');
                        opt.value = p.plant;
                        opt.textContent = `${p.plant} - ${p.nama}`;
                        if (p.plant === currentVal) opt.selected = true;
                        plantSel.appendChild(opt);
                    });
                } else {
                    plantSel.disabled = true;
                    plantSel.style.opacity = '0.5';
                    plantSel.style.cursor = 'not-allowed';
                    plantSel.innerHTML = '<option value="">-- Pilih Regional dulu --</option>';
                }

                $(`#plantFilter-${tabName}`).val('').trigger('change');
            }

            regionalSel.addEventListener('change', function () {
                rebuildPlantFilter(this.value);
            });

            // ── Enable tombol Cari hanya jika Tahun & Bulan sudah dipilih ────────
            function checkEnableSearch() {
                const tahunOk = !!tahunSel.value;
                const bulanOk = !!bulanSel.value;
                const ok = tahunOk && bulanOk;
                btnFilter.disabled = !ok;
                btnFilter.style.opacity = ok ? '1' : '0.45';
                btnFilter.style.cursor = ok ? 'pointer' : 'not-allowed';
            }

            tahunSel.addEventListener('change', checkEnableSearch);
            bulanSel.addEventListener('change', checkEnableSearch);
            checkEnableSearch();

            // ── Form submit ─────────────────────────────────────────────────────
            formEl.addEventListener('submit', function (e) {
                e.preventDefault();
                const komoditas = document.getElementById(`komoditasFilter-${tabName}`).value;
                const regional = regionalSel.value;
                const plant = plantSel.value;
                const tahun = tahunSel.value;
                const bulan = bulanSel.value;

                fetchData(tabName, komoditas, regional, plant, tahun, bulan);
            });

            // ── Reset button ────────────────────────────────────────────────────
            btnResetEl.addEventListener('click', function () {
                setTimeout(() => {
                    tahunSel.value = '';
                    bulanSel.value = '';
                    regionalSel.value = '';
                    rebuildPlantFilter('');
                    $(`#plantFilter-${tabName}`).val('').trigger('change');
                    document.getElementById(`resultCard-${tabName}`).style.display = 'none';
                    checkEnableSearch();
                }, 50);
            });
        }

        // ========== FETCH DATA ═══════════════════════════════════════════════════
        function fetchData(tabName, komoditas, regional, plant, tahun, bulan) {
            const card = document.getElementById(`resultCard-${tabName}`);
            const loading = document.getElementById(`tableLoading-${tabName}`);
            const errBox = document.getElementById(`tableError-${tabName}`);
            const result = document.getElementById(`tableResult-${tabName}`);
            const info = document.getElementById(`resultInfo-${tabName}`);

            card.style.display = '';
            loading.style.display = '';
            errBox.style.display = 'none';
            result.innerHTML = '';
            info.textContent = '';

            const params = new URLSearchParams({ komoditi: komoditas, region: regional, plant, tahun, bulan });
            const endpoint = endpoints[tabName];

            fetch(`${endpoint}?${params}`)
                .then(res => res.json())
                .then(data => {
                    loading.style.display = 'none';
                    if (data.status !== 'success') {
                        errBox.style.display = '';
                        errBox.textContent = '⚠️ ' + (data.message || 'Terjadi kesalahan.');
                        return;
                    }

                    const rows = data.data;
                    info.textContent = `${data.total} baris ditemukan`;

                    if (!rows || rows.length === 0) {
                        result.innerHTML = '<p style="padding:16px 20px;color:#6b7280;font-size:13px;">Tidak ada data untuk filter yang dipilih.</p>';
                        return;
                    }

                    // Render table dengan logic yang sama seperti sebelumnya
                    renderTable(tabName, rows, data);
                })
                .catch(err => {
                    loading.style.display = 'none';
                    errBox.style.display = '';
                    errBox.textContent = '⚠️ Gagal menghubungi server: ' + err.message;
                });
        }

        // ========== RENDER TABLE ════════════════════════════════════════════════
        function renderTable(tabName, rows, data) {
            const result = document.getElementById(`tableResult-${tabName}`);
            const headers = Object.keys(rows[0]);

            // Column classifiers (dari kode original Anda)
            const isIdCol = h => /(_id$|^id_|_id_|material|prodheir|kdbe|norek|^kode|^no$|^plant|^regional|_desc$|uraian|^nama)/i.test(h);
            const isHargaCol = h => /harga|price|rate|satuan/i.test(h);
            const isVolumeCol = h => /volume|vol\b|qty|kuantitas/i.test(h);
            const isNilaiCol = h => /nilai|value|amount/i.test(h);
            const isStrictNum = v => {
                if (v === null || v === '' || v === undefined) return false;
                return /^-?\d+(\.\d+)?$/.test(String(v).trim());
            };

            const NUMERIC_COLS = new Set(
                headers.filter(h => {
                    if (isIdCol(h)) return false;
                    if (isHargaCol(h)) return true;
                    return rows.some(r => isStrictNum(r[h]));
                })
            );

            const SUBTOTAL_COLS = new Set(
                headers.filter(h =>
                    (isVolumeCol(h) || isNilaiCol(h)) && NUMERIC_COLS.has(h)
                )
            );

            const isNumericCol = h => NUMERIC_COLS.has(h);
            const isSubtotalCol = h => SUBTOTAL_COLS.has(h);

            const fmt = (v, colName = '') => {
                if (colName && isIdCol(colName)) {
                    return (v === null || v === undefined || v === '') ? '' : String(v);
                }
                if (v === null || v === '' || v === undefined) {
                    // harga kosong → tampil 0,00
                    return (colName && isHargaCol(colName)) ? '0,00' : '-';
                }
                if (!isStrictNum(v)) return String(v);
                const n = parseFloat(v);
                // harga SELALU 2 desimal (termasuk angka bulat → ,00)
                const forceTwo = colName && isHargaCol(colName);
                const hasDecimal = String(v).includes('.');
                return n.toLocaleString('id-ID', {
                    minimumFractionDigits: (forceTwo || hasDecimal) ? 2 : 0,
                    maximumFractionDigits: 2,
                });
            };

            // Title
            const regionalSel = document.getElementById(`regionalFilter-${tabName}`);
            const plantSel = document.getElementById(`plantFilter-${tabName}`);
            const bulanSel = document.getElementById(`bulanFilter-${tabName}`);
            const tahunSel = document.getElementById(`tahunFilter-${tabName}`);
            const komoSel = document.getElementById(`komoditasFilter-${tabName}`);
            const regionalText = regionalSel.value ? 'Regional ' + regionalSel.options[regionalSel.selectedIndex].text : 'Semua Regional';
            const plantText = plantSel.value ? plantSel.options[plantSel.selectedIndex].text : 'Semua Kebun';
            const bulanText = bulanSel.value ? 'Periode ' + bulanNames[parseInt(bulanSel.value)] : 'Semua Bulan';
            const tahunText = tahunSel.value || 'Semua Tahun';
            const komoText = komoSel.value ? komoSel.options[komoSel.selectedIndex].text : 'Semua Komoditas';

            const grouping = tabName === 'kebun' ? 'Material' : (tabName === 'negara' ? 'Negara' : 'Customer');
            const judulLaporan = `LM34 - Laporan Realisasi Penjualan [${grouping}] - ${regionalText} - ${plantText} - Komoditas: ${komoText} ${bulanText} ${tahunText}`;

            // Simpan untuk export
            _exportData[tabName] = {
                rows,
                headers,
                judul: judulLaporan,
                numericCols: NUMERIC_COLS,
                subtotalCols: SUBTOTAL_COLS,
            };

            // Build HTML table
            let html = '<table class="report-table" style="font-size:12.5px;">';
            html += '<thead><tr><th colspan="' + headers.length + '" style="background:#ffffff; color:#111827; text-align:center; font-size:13px; font-weight:800; padding:10px 16px; letter-spacing:0.05em; border-bottom:2px solid #16a34a;">' + judulLaporan + '</th></tr>';
            html += '<tr>';
            headers.forEach(h => {
                html += '<th style="text-align:left; padding:8px 12px; background:#15803d; color:#fff; white-space:nowrap;">' + h.replace(/_/g, ' ').toUpperCase() + '</th>';
            });
            html += '</tr></thead><tbody>';

            const initAcc = () => Object.fromEntries(headers.map(h => [h, 0]));
            const addToAcc = (acc, row) => headers.forEach(h => { if (isSubtotalCol(h) && isStrictNum(row[h])) acc[h] += parseFloat(row[h]); });

            let leadingNonNum = 0;
            for (let j = 0; j < headers.length; j++) {
                if (!isNumericCol(headers[j])) leadingNonNum++;
                else break;
            }
            const labelSpan = Math.max(leadingNonNum, 1);

            const makeSubtotalRow = (label, acc, bgColor, fontWeight, borderTop, textColor = '#14532d') => {
                let r = `<tr style="background:${bgColor}; font-weight:${fontWeight}; border-top:${borderTop};">`;
                headers.forEach((h, idx) => {
                    if (idx === 0) {
                        r += `<td colspan="${labelSpan}" style="padding:6px 14px; border:1px solid #bbf7d0; text-align:right; font-style:italic; white-space:nowrap; color:${textColor};">${label}</td>`;
                    } else if (idx < labelSpan) {
                        return;
                    } else if (isSubtotalCol(h)) {
                        r += `<td style="padding:6px 14px; border:1px solid #bbf7d0; text-align:right; white-space:nowrap; color:${textColor};">${fmt(acc[h])}</td>`;
                    } else {
                        r += `<td style="padding:6px 14px; border:1px solid #bbf7d0;"></td>`;
                    }
                });
                r += '</tr>';
                return r;
            };

            let accTotal = initAcc();
            let rowIdx = 0;

            rows.forEach((row) => {
                addToAcc(accTotal, row);

                const bg = rowIdx % 2 === 0 ? '#fff' : '#f9fafb';
                html += `<tr style="background:${bg};">`;
                headers.forEach(h => {
                    const val = row[h];
                    const align = isNumericCol(h) ? 'right' : 'left';
                    html += `<td style="padding:5px 12px; border:1px solid #e5e7eb; text-align:${align}; white-space:nowrap;">${fmt(val, h)}</td>`;
                });
                html += '</tr>';
                rowIdx++;
            });

            html += makeSubtotalRow('JUMLAH TOTAL', accTotal, '#14532d', '900', '3px solid #052e16', '#fff');
            html += '</tbody></table>';

            result.innerHTML = html;
        }

        // ========== EXPORT FUNCTIONS ════════════════════════════════════════════
        async function exportExcel(tabName) {
            if (!_exportData[tabName]) { alert('Belum ada data untuk diekspor.'); return; }

            const { rows, headers, judul, numericCols, subtotalCols } = _exportData[tabName];
            const isIdCol = h => /(_id$|^id_|_id_|material|prodheir|kdbe|norek|^kode|^no$|^plant|^regional|_desc$|uraian|^nama)/i.test(h);
            const isHargaCol = h => /harga|price|rate|satuan/i.test(h);
            const isStrictNum = v => { if (v === null || v === '' || v === undefined) return false; return /^-?\d+(\.\d+)?$/.test(String(v).trim()); };
            const isNumericCol = h => numericCols && numericCols.has(h);
            const isSubtotalCol = h => subtotalCols && subtotalCols.has(h);

            let leadingNonNum = 0;
            for (let j = 0; j < headers.length; j++) {
                if (!isNumericCol(headers[j])) leadingNonNum++; else break;
            }
            const labelSpan = Math.max(leadingNonNum, 1);

            const workbook = new ExcelJS.Workbook();
            const ws = workbook.addWorksheet('LM34');
            ws.columns = headers.map(h => ({
                key: h,
                width: isIdCol(h) ? 14 : h.toLowerCase().includes('desc') ? 28 : isHargaCol(h) ? 16 : isSubtotalCol(h) ? 18 : 14,
            }));

            const bdr = (s = 'thin') => ({ top: { style: s }, left: { style: s }, bottom: { style: s }, right: { style: s } });
            const fill = argb => ({ type: 'pattern', pattern: 'solid', fgColor: { argb } });

            // Row 1: Title
            ws.mergeCells(1, 1, 1, headers.length);
            const tc = ws.getCell(1, 1);
            tc.value = judul; tc.font = { bold: true, size: 11 };
            tc.alignment = { horizontal: 'center', vertical: 'middle', wrapText: true };
            tc.fill = fill('FFFFFFFF'); tc.border = bdr();
            ws.getRow(1).height = 24;

            // Row 2: Column headers
            const hRow = ws.addRow(headers.map(h => h.replace(/_/g, ' ').toUpperCase()));
            hRow.eachCell((cell, colNum) => {
                cell.fill = fill('FF15803D');
                cell.font = { bold: true, color: { argb: 'FFFFFFFF' }, size: 9 };
                cell.alignment = { horizontal: isNumericCol(headers[colNum - 1]) ? 'right' : 'center', vertical: 'middle', wrapText: true };
                cell.border = bdr();
            });
            ws.getRow(2).height = 18;

            const initAcc = () => Object.fromEntries(headers.map(h => [h, 0]));
            const addToAcc = (acc, row) => headers.forEach(h => {
                if (isSubtotalCol(h) && isStrictNum(row[h])) acc[h] += parseFloat(row[h]);
            });
            let accTotal = initAcc();
            let rowIdx = 0;

            for (const row of rows) {
                addToAcc(accTotal, row);
                const rowData = headers.map(h => {
                    const v = row[h];
                    if (isIdCol(h)) return (v === null || v === undefined || v === '') ? '' : String(v);
                    if (isStrictNum(v)) return parseFloat(v);
                    if (v === null || v === '' || v === undefined) return isHargaCol(h) ? 0 : '';
                    return String(v);
                });
                const exRow = ws.addRow(rowData);
                const bg = rowIdx % 2 === 0 ? 'FFFFFFFF' : 'FFF9FAFB';
                exRow.eachCell({ includeEmpty: true }, (cell, colNum) => {
                    const h = headers[colNum - 1];
                    cell.fill = fill(bg); cell.font = { size: 9 }; cell.border = bdr();
                    if (isNumericCol(h)) {
                        cell.numFmt = isHargaCol(h) ? '#,##0.00' : '#,##0';
                        cell.alignment = { horizontal: 'right' };
                    } else {
                        cell.alignment = { horizontal: 'left' };
                    }
                });
                rowIdx++;
            }

            // Grand Total row
            const gtData = headers.map((h, idx) => {
                if (idx === 0) return 'JUMLAH TOTAL';
                if (idx < labelSpan) return null;
                if (isSubtotalCol(h)) return parseFloat(accTotal[h]) || 0;
                return null;
            });
            const gtRow = ws.addRow(gtData);
            const gtn = ws.rowCount;
            gtRow.eachCell({ includeEmpty: true }, (cell, colNum) => {
                const h = headers[colNum - 1];
                cell.fill = fill('FF14532D');
                cell.font = { bold: true, size: 9, color: { argb: 'FFFFFFFF' } };
                cell.border = bdr('medium');
                if (colNum - 1 >= labelSpan) {
                    if (isSubtotalCol(h)) { cell.numFmt = '#,##0'; cell.alignment = { horizontal: 'right' }; }
                    else if (isNumericCol(h)) { cell.numFmt = isHargaCol(h) ? '#,##0.00' : '#,##0'; cell.alignment = { horizontal: 'right' }; }
                }
            });
            try { ws.mergeCells(gtn, 1, gtn, labelSpan); } catch (e) { }
            ws.getCell(gtn, 1).alignment = { horizontal: 'right', vertical: 'middle' };

            const buffer = await workbook.xlsx.writeBuffer();
            const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url; a.download = `${judul}.xlsx`; a.click();
            URL.revokeObjectURL(url);
        }

        function exportPdf(tabName) {
            if (!_exportData[tabName]) { alert('Belum ada data untuk diekspor.'); return; }

            const { rows, headers, judul, numericCols, subtotalCols } = _exportData[tabName];
            const isIdCol = h => /(_id$|^id_|_id_|material|prodheir|kdbe|norek|^kode|^no$|^plant|^regional|_desc$|uraian|^nama)/i.test(h);
            const isHargaCol = h => /harga|price|rate|satuan/i.test(h);
            const isStrictNum = v => { if (v === null || v === '' || v === undefined) return false; return /^-?\d+(\.\d+)?$/.test(String(v).trim()); };
            const isNumericCol = h => numericCols && numericCols.has(h);
            const isSubtotalCol = h => subtotalCols && subtotalCols.has(h);

            let leadingNonNum = 0;
            for (let j = 0; j < headers.length; j++) {
                if (!isNumericCol(headers[j])) leadingNonNum++; else break;
            }
            const labelSpan = Math.max(leadingNonNum, 1);

            const fmtNum = (v, colName = '') => {
                if (isIdCol(colName)) return (v === null || v === undefined || v === '') ? '' : String(v);
                if (v === null || v === '' || v === undefined) return isHargaCol(colName) ? '0,00' : '-';
                if (!isStrictNum(v)) return String(v);
                const n = parseFloat(v);
                const forceTwo = isHargaCol(colName);
                const hasDecimal = String(v).includes('.');
                return n.toLocaleString('id-ID', {
                    minimumFractionDigits: (forceTwo || hasDecimal) ? 2 : 0,
                    maximumFractionDigits: 2,
                });
            };

            const initAcc = () => Object.fromEntries(headers.map(h => [h, 0]));
            const addToAcc = (acc, row) => headers.forEach(h => {
                if (isSubtotalCol(h) && isStrictNum(row[h])) acc[h] += parseFloat(row[h]);
            });
            const body = [];
            let accTotal = initAcc();

            for (const row of rows) {
                addToAcc(accTotal, row);
                body.push(headers.map(h => ({
                    content: fmtNum(row[h], h),
                    styles: { halign: isNumericCol(h) ? 'right' : 'left', fontSize: 6.5 },
                })));
            }

            // Grand Total row
            body.push(headers.map((h, idx) => {
                let val = '', halign = 'left';
                if (idx === 0) { val = 'JUMLAH TOTAL'; halign = 'right'; }
                else if (idx < labelSpan) { val = ''; }
                else if (isSubtotalCol(h)) { val = fmtNum(accTotal[h], h); halign = 'right'; }
                else if (isNumericCol(h)) { val = ''; halign = 'right'; }
                return { content: val, styles: { halign, fontStyle: 'bold', fillColor: [20, 83, 45], textColor: [255, 255, 255], fontSize: 6.5 } };
            }));

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({ orientation: 'landscape', unit: 'pt', format: 'a3' });
            const pageW = doc.internal.pageSize.getWidth();
            doc.setFontSize(10); doc.setFont('helvetica', 'bold');
            doc.text(judul, pageW / 2, 28, { align: 'center' });

            doc.autoTable({
                head: [headers.map(h => h.replace(/_/g, ' ').toUpperCase())],
                body,
                startY: 42,
                styles: { fontSize: 6.5, cellPadding: 2.5, lineWidth: 0.3, lineColor: [209, 250, 229], overflow: 'ellipsize' },
                headStyles: { fillColor: [21, 128, 61], textColor: 255, fontStyle: 'bold', fontSize: 6.5, halign: 'center', cellPadding: 3 },
                columnStyles: Object.fromEntries(headers.map((h, i) => [i, { halign: isNumericCol(h) ? 'right' : 'left' }])),
                alternateRowStyles: { fillColor: [249, 250, 251] },
                margin: { top: 42, left: 18, right: 18 },
                tableWidth: 'auto',
            });

            doc.save(`${judul}.pdf`);
        }
    </script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2-plant').select2({
                placeholder: '-- Semua Kebun --',
                allowClear: true,
                width: '100%',
            });
        });
    </script>

    <!-- ExcelJS & jsPDF (untuk export, optional untuk tahap ini) -->
    <script src="https://cdn.jsdelivr.net/npm/exceljs@4.4.0/dist/exceljs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspdf-autotable@3.8.2/dist/jspdf.plugin.autotable.min.js"></script>
@endsection
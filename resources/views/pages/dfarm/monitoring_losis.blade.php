@extends('layouts.app')

@section('title', 'Monitoring Losis D-Farm')

@section('styles')
    <style>
        /* ===== SCROLL FIX & RESET ===== */
        html, body {
            height: auto !important;
            min-height: 100vh;
            overflow-y: auto !important;
            background-color: #f8fafc !important;
            color: #1f2937;
            font-family: 'Google Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .losis-container.main-content {
            padding: 0 !important;
            margin-left: 0 !important;
            background-color: #f8fafc;
            min-height: 100vh;
        }

        .losis-container {
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
            padding: 10px 40px;
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            min-height: 60px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        .lm-header-logo {
            width: 130px;
            height: 42px;
            display: flex;
            align-items: center;
        }

        .lm-header-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .lm-header-center {
            text-align: center;
        }

        .lm-header-center h1 {
            font-size: 1.4rem;
            font-weight: 800;
            color: #166534;
            margin: 0;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .lm-header-center p {
            font-size: 0.8rem;
            color: #64748b;
            margin: 2px 0 0 0;
        }

        .lm-header-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .lm-header-right img {
            height: 40px;
            width: auto;
            object-fit: contain;
        }

        /* ===== CONTENT SECTION ===== */
        .content-section {
            max-width: 100%;
            margin: 0;
            padding: 20px 40px 40px;
        }

        /* ===== FILTER CARD ===== */
        .filter-card {
            background: #fff;
            border: 1px solid #d1fae5;
            border-left: 4px solid #166534;
            border-radius: 10px;
            padding: 18px 22px;
            margin-bottom: 22px;
            box-shadow: 0 2px 6px rgba(22, 101, 52, 0.06);
        }

        .filter-title {
            color: #166534;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            align-items: flex-end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            min-width: 190px;
            flex: 1;
        }

        .form-label {
            color: #374151;
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-select,
        .form-input {
            width: 100%;
            padding: 8px 12px;
            background-color: #fff;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            color: #1f2937;
            font-size: 13px;
            transition: all 0.2s;
            box-sizing: border-box;
            height: 38px;
        }

        .form-select:focus,
        .form-input:focus {
            outline: none;
            border-color: #166534;
            box-shadow: 0 0 0 3px rgba(22, 101, 52, 0.12);
        }

        .btn-filter {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 18px;
            background-color: #16a34a;
            color: #fff;
            border: 1px solid #15803d;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            height: 38px;
        }

        .btn-filter:hover {
            background-color: #15803d;
            border-color: #166534;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }

        .btn-reset {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 14px;
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            height: 38px;
        }

        .btn-reset:hover {
            background-color: #e2e8f0;
            color: #1e293b;
        }

        /* ===== METRICS CARDS (ROW OF 4) ===== */
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .metric-card {
            background: #fff;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .metric-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.06);
        }

        .metric-info {
            display: flex;
            flex-direction: column;
        }

        .metric-label {
            font-size: 12px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .metric-value {
            font-size: 1.55rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.2;
        }

        .metric-sub {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 4px;
            font-weight: 500;
        }

        .metric-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .icon-green { background: #dcfce7; color: #166534; }
        .icon-blue  { background: #dbeafe; color: #1d4ed8; }
        .icon-amber { background: #fef3c7; color: #b45309; }
        .icon-red   { background: #fee2e2; color: #b91c1c; }

        /* ===== CHART CARD ===== */
        .chart-card {
            background: #fff;
            border: 2px solid #166534;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(22, 101, 52, 0.08);
            margin-bottom: 24px;
        }

        .chart-card-header {
            background: #166534;
            padding: 12px 22px;
            border-bottom: 2px solid #14532d;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #fff;
        }

        .chart-card-title {
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            letter-spacing: 0.02em;
        }

        .chart-card-hint {
            font-size: 11px;
            font-weight: 500;
            color: #dcfce7;
            background: rgba(255, 255, 255, 0.15);
            padding: 4px 10px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .chart-card-body {
            padding: 20px 22px;
            position: relative;
        }

        .main-chart-wrapper {
            position: relative;
            height: 380px;
            width: 100%;
        }

        /* ===== BREAKDOWN CONTAINER ===== */
        .breakdown-section {
            display: none;
            margin-top: 24px;
            animation: fadeIn 0.35s ease-out forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .breakdown-card {
            background: #fff;
            border: 2px solid #2563eb;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.1);
            margin-bottom: 24px;
        }

        .breakdown-header {
            background: #2563eb;
            padding: 12px 22px;
            border-bottom: 2px solid #1d4ed8;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #fff;
        }

        .breakdown-title {
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-close-breakdown {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            border: none;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .btn-close-breakdown:hover {
            background: rgba(255, 255, 255, 0.35);
        }

        .breakdown-chart-wrapper {
            position: relative;
            min-height: 320px;
            width: 100%;
            padding: 16px 20px;
        }

        /* ===== DETAIL TABLE CARD ===== */
        .table-card {
            background: #fff;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            margin-bottom: 30px;
        }

        .table-header {
            padding: 14px 22px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .table-title {
            font-size: 14px;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table-search-box {
            position: relative;
            width: 260px;
        }

        .table-search-box input {
            width: 100%;
            padding: 6px 12px 6px 32px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            font-size: 12px;
            outline: none;
            box-sizing: border-box;
        }

        .table-search-box input:focus {
            border-color: #166534;
            box-shadow: 0 0 0 2px rgba(22, 101, 52, 0.1);
        }

        .table-search-box i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 12px;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            max-height: 480px;
            overflow-y: auto;
        }

        .losis-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            text-align: left;
            white-space: nowrap;
        }

        .losis-table thead th {
            position: sticky;
            top: 0;
            background: #f1f5f9;
            color: #334155;
            font-weight: 700;
            padding: 10px 14px;
            border-bottom: 2px solid #cbd5e1;
            z-index: 10;
        }

        .losis-table tbody td {
            padding: 9px 14px;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
        }

        .losis-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .badge-losis {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 11px;
        }

        .badge-susut { background: #fee2e2; color: #b91c1c; }
        .badge-gain  { background: #dcfce7; color: #15803d; }
        .badge-pass  { background: #f1f5f9; color: #475569; }

        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-mono { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; }

        /* ===== TREE / GROUPED TABLE STYLES ===== */
        .row-total-kebun {
            background-color: #f0fdf4 !important;
            border-top: 2px solid #86efac !important;
            border-bottom: 1px solid #bbf7d0 !important;
            font-weight: 700;
            cursor: pointer;
            user-select: none;
            transition: background 0.15s ease;
        }
        .row-total-kebun:hover {
            background-color: #dcfce7 !important;
        }
        .row-total-kebun td {
            padding: 10px 14px !important;
            color: #14532d !important;
            font-size: 12.5px;
        }

        .row-subtotal-afdeling {
            background-color: #f8fafc !important;
            border-top: 1px solid #e2e8f0 !important;
            border-bottom: 1px solid #e2e8f0 !important;
            font-weight: 600;
            cursor: pointer;
            user-select: none;
            transition: background 0.15s ease;
        }
        .row-subtotal-afdeling:hover {
            background-color: #f1f5f9 !important;
        }
        .row-subtotal-afdeling td {
            padding: 9px 14px !important;
            color: #1e293b !important;
            font-size: 12px;
        }

        .row-subtotal-produk {
            background-color: #ffffff !important;
            border-top: 1px dashed #cbd5e1 !important;
            border-bottom: 1px solid #f1f5f9 !important;
            font-weight: 600;
            cursor: pointer;
            user-select: none;
            transition: background 0.15s ease;
        }
        .row-subtotal-produk:hover {
            background-color: #f8fafc !important;
        }
        .row-subtotal-produk td {
            padding: 8px 14px !important;
            color: #334155 !important;
            font-size: 11.5px;
        }

        .row-trans-detail td {
            padding: 7px 14px !important;
            color: #475569 !important;
            font-size: 11.5px;
            background-color: #fff;
        }
        .row-trans-detail:hover td {
            background-color: #f8fafc !important;
        }

        .tfoot-grand-total {
            background-color: #166534 !important;
            color: #ffffff !important;
            font-weight: 800;
            font-size: 13px;
        }
        .tfoot-grand-total td {
            position: sticky;
            bottom: 0;
            background-color: #166534 !important;
            padding: 12px 14px !important;
            border-top: 2px solid #14532d;
            color: #ffffff !important;
            z-index: 10;
        }

        .chevron-icon {
            display: inline-block;
            width: 14px;
            text-align: center;
            margin-right: 6px;
            font-size: 11px;
            color: #64748b;
            transition: transform 0.2s ease;
        }

        .badge-tag {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 4px;
            font-size: 10.5px;
            font-weight: 600;
            margin-left: 6px;
        }
        .badge-tag-kebun { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .badge-tag-afd   { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
        .badge-tag-prd   { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }

        .table-view-controls {
            display: flex;
            gap: 6px;
            align-items: center;
        }
        .btn-subtle {
            background: #fff;
            border: 1px solid #cbd5e1;
            color: #475569;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 4px;
            transition: all 0.2s;
        }
        .btn-subtle:hover {
            background: #f1f5f9;
            color: #0f172a;
            border-color: #94a3b8;
        }

        /* ===== LOADING OVERLAY ===== */
        .loading-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(2px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 50;
            border-radius: 8px;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #dcfce7;
            border-top: 4px solid #166534;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 1024px) {
            .metrics-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .metrics-grid {
                grid-template-columns: 1fr;
            }
            .content-section, .lm-page-header {
                padding: 12px 16px;
            }
        }
    </style>
@endsection

@section('content')
<div class="losis-container main-content">
    
    <!-- PAGE HEADER -->
    <div class="lm-page-header">
        <div class="lm-header-logo">
            <img src="{{ asset('ptpn1.png') }}" alt="PTPN I Logo">
        </div>
        <div class="lm-header-center">
            <h1><i class="fa-solid fa-chart-line"></i> Monitoring Losis D-Farm</h1>
            <p>Perbandingan Produksi Kebun vs Penerimaan Pabrik Real-Time</p>
        </div>
        <div class="lm-header-right">
            <img src="{{ asset('holding.png') }}" alt="Holding Perkebunan Logo" onerror="this.style.display='none'">
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="content-section">

        <!-- FILTER CARD -->
        <div class="filter-card">
            <div class="filter-title">
                <i class="fa-solid fa-filter"></i> Filter Data Monitoring Losis
            </div>
            <div class="filter-grid">
                <!-- Komoditi -->
                <div class="form-group" style="max-width: 220px;">
                    <label class="form-label" for="filterKomoditi">Komoditi</label>
                    <select id="filterKomoditi" class="form-select" onchange="onCommodityChange()">
                        @foreach($commodities as $c)
                            <option value="{{ $c->id }}" {{ $c->id == 2 ? 'selected' : '' }}>
                                {{ $c->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Produk (Dinamis) -->
                <div class="form-group" style="max-width: 240px;">
                    <label class="form-label" for="filterProduk">Produk</label>
                    <select id="filterProduk" class="form-select">
                        <option value="all">-- Semua Produk --</option>
                    </select>
                </div>

                <!-- Tanggal Awal -->
                <div class="form-group" style="max-width: 180px;">
                    <label class="form-label" for="filterTglAwal">Tanggal Awal</label>
                    <input type="date" id="filterTglAwal" class="form-input" value="{{ date('Y-m-d', strtotime('-1 day')) }}">
                </div>

                <!-- Tanggal Akhir -->
                <div class="form-group" style="max-width: 180px;">
                    <label class="form-label" for="filterTglAkhir">Tanggal Akhir</label>
                    <input type="date" id="filterTglAkhir" class="form-input" value="{{ date('Y-m-d') }}">
                </div>

                <!-- Actions -->
                <div style="display: flex; gap: 8px;">
                    <button id="btnFilter" class="btn-filter" onclick="loadDashboardData()">
                        <i class="fa-solid fa-magnifying-glass"></i> Filter Data
                    </button>
                    <button id="btnReset" class="btn-reset" onclick="resetFilter()">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- KPI SUMMARY CARDS -->
        <div class="metrics-grid">
            <div class="metric-card">
                <div class="metric-info">
                    <div class="metric-label">Total Produksi Kebun</div>
                    <div class="metric-value" id="kpiTotalKebun" style="color: #166534;">0 <span style="font-size: 0.9rem; font-weight: 500;">kg</span></div>
                    <div class="metric-sub" id="kpiSubKebun">Estimasi timbangan kebun</div>
                </div>
                <div class="metric-icon icon-green">
                    <i class="fa-solid fa-tractor"></i>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-info">
                    <div class="metric-label">Total Diterima Pabrik</div>
                    <div class="metric-value" id="kpiTotalPabrik" style="color: #1d4ed8;">0 <span style="font-size: 0.9rem; font-weight: 500;">kg</span></div>
                    <div class="metric-sub" id="kpiSubPabrik">Timbangan bruto/netto pabrik</div>
                </div>
                <div class="metric-icon icon-blue">
                    <i class="fa-solid fa-industry"></i>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-info">
                    <div class="metric-label">Total Selisih (Losis)</div>
                    <div class="metric-value" id="kpiTotalSelisih" style="color: #b91c1c;">0 <span style="font-size: 0.9rem; font-weight: 500;">kg</span></div>
                    <div class="metric-sub" id="kpiSubSelisih">Selisih berat (kebun - pabrik)</div>
                </div>
                <div class="metric-icon icon-amber">
                    <i class="fa-solid fa-scale-unbalanced"></i>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-info">
                    <div class="metric-label">Persentase Losis</div>
                    <div class="metric-value" id="kpiLosisPct" style="color: #0f172a;">0.00%</div>
                    <div class="metric-sub" id="kpiTotalRitase">0 ritase pengiriman</div>
                </div>
                <div class="metric-icon icon-red" id="kpiPctIcon">
                    <i class="fa-solid fa-percent"></i>
                </div>
            </div>
        </div>

        <!-- MAIN CHART: REGIONAL COMPARISON -->
        <div class="chart-card">
            <div class="chart-card-header">
                <div class="chart-card-title">
                    <i class="fa-solid fa-chart-column"></i> Perbandingan Produksi Kebun vs Penerimaan Pabrik per Regional
                </div>
                <div class="chart-card-hint">
                    <i class="fa-solid fa-hand-pointer"></i> Klik salah satu batang Regional untuk melihat breakdown kebun
                </div>
            </div>
            <div class="chart-card-body">
                <div id="chartLoadingOverlay" class="loading-overlay" style="display: none;">
                    <div class="spinner"></div>
                    <div style="margin-top: 10px; font-weight: 700; color: #166534; font-size: 13px;">Memuat Data Monitoring Losis...</div>
                </div>
                <div class="main-chart-wrapper">
                    <canvas id="regionalChart"></canvas>
                </div>
            </div>
        </div>

        <!-- BREAKDOWN SECTION (DRILLDOWN PER KEBUN) -->
        <div id="breakdownSection" class="breakdown-section">
            <div class="breakdown-card">
                <div class="breakdown-header">
                    <div class="breakdown-title">
                        <i class="fa-solid fa-tree"></i> Breakdown Produksi Kebun vs Pabrik: <span id="selectedRegionalTitle" style="text-decoration: underline; margin-left: 4px;">Regional</span>
                    </div>
                    <button class="btn-close-breakdown" onclick="closeBreakdown()">
                        <i class="fa-solid fa-xmark"></i> Tutup Rincian
                    </button>
                </div>
                <div class="chart-card-body" style="padding: 16px 20px;">
                    <div class="breakdown-chart-wrapper" id="breakdownChartWrapper">
                        <canvas id="kebunChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- DETAILED TRANSACTIONS TABLE -->
        <div class="table-card">
            <div class="table-header">
                <div class="table-title">
                    <i class="fa-solid fa-table-list" style="color: #166534;"></i> Rincian Transaksi Pengiriman & Penerimaan
                    <span id="tableFilterTag" style="font-size: 11px; font-weight: normal; color: #64748b; margin-left: 6px;">(Semua Regional)</span>
                </div>
                <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                    <div class="table-view-controls">
                        <button class="btn-subtle" onclick="expandAllGroups()" title="Buka semua baris">
                            <i class="fa-solid fa-angles-down"></i> Buka Semua
                        </button>
                        <button class="btn-subtle" onclick="showSubtotalsOnly()" title="Tampilkan hanya total kebun & subtotal">
                            <i class="fa-solid fa-list-check"></i> Subtotal Saja
                        </button>
                        <button class="btn-subtle" onclick="collapseAllGroups()" title="Tutup semua kebun">
                            <i class="fa-solid fa-angles-up"></i> Tutup Semua
                        </button>
                    </div>
                    <div class="table-search-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" id="tableSearch" placeholder="Cari kebun, afdeling, no pol, tiket..." oninput="onTableSearch()">
                    </div>
                    <button class="btn-reset" style="height: 32px; padding: 0 12px; font-size: 11px;" onclick="exportTableToExcel()">
                        <i class="fa-solid fa-file-excel" style="color: #16a34a;"></i> Export Excel
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="losis-table" id="transactionTable">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 40px;">No</th>
                            <th>Tanggal</th>
                            <th>Regional</th>
                            <th>Kebun</th>
                            <th>Afdeling</th>
                            <th>Produk</th>
                            <th>No. Tiket Transport</th>
                            <th class="text-center">Rit</th>
                            <th>No. Polisi Truk</th>
                            <th class="text-right">Kg Kebun</th>
                            <th class="text-right">Kg Pabrik</th>
                            <th class="text-right">Selisih (Kg)</th>
                            <th class="text-center">Status / % Losis</th>
                        </tr>
                    </thead>
                    <tbody id="transactionTableBody">
                        <tr>
                            <td colspan="13" class="text-center" style="padding: 30px; color: #94a3b8;">
                                <i class="fa-solid fa-spinner fa-spin" style="margin-right: 6px;"></i> Sedang mengambil data...
                            </td>
                        </tr>
                    </tbody>
                    <tfoot id="transactionTableFoot"></tfoot>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx-js-style@1.2.0/dist/xlsx.bundle.js"></script>
<script>
    // Embedded products catalogue
    const allProducts = @json($products);

    // Global state
    let regionalChartInstance = null;
    let kebunChartInstance = null;
    let currentDashboardData = null;
    let selectedRegionalName = null;
    let allTableRows = [];

    // Initialize on DOM Ready
    document.addEventListener('DOMContentLoaded', function() {
        onCommodityChange();
        loadDashboardData();
    });

    // Handle dynamic product dropdown based on commodity
    function onCommodityChange() {
        const komoditiId = parseInt(document.getElementById('filterKomoditi').value);
        const produkSelect = document.getElementById('filterProduk');
        
        produkSelect.innerHTML = '<option value="all">-- Semua Produk --</option>';
        
        const filteredProducts = allProducts.filter(p => p.comodity_id === komoditiId);
        filteredProducts.forEach(p => {
            const opt = document.createElement('option');
            opt.value = p.id;
            opt.textContent = p.nama;
            produkSelect.appendChild(opt);
        });
    }

    // Reset filters to defaults
    function resetFilter() {
        document.getElementById('filterKomoditi').value = "2"; // Default Karet
        onCommodityChange();
        document.getElementById('filterProduk').value = "all";
        selectedRegionalName = null;
        
        const today = new Date();
        const yesterday = new Date();
        yesterday.setDate(today.getDate() - 1);
        
        document.getElementById('filterTglAwal').value = formatDateInput(yesterday);
        document.getElementById('filterTglAkhir').value = formatDateInput(today);
        
        loadDashboardData();
    }

    function formatDateInput(d) {
        const year = d.getFullYear();
        const month = String(d.getMonth() + 1).padStart(2, '0');
        const day = String(d.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    // Format number to Indonesian locale
    function formatNumber(num, decimals = 0) {
        if (num === null || num === undefined || isNaN(num)) return '0';
        return Number(num).toLocaleString('id-ID', {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals
        });
    }

    // Load data from Backend via AJAX
    async function loadDashboardData() {
        const komoditiId = document.getElementById('filterKomoditi').value;
        const produkId = document.getElementById('filterProduk').value;
        const tglAwal = document.getElementById('filterTglAwal').value;
        const tglAkhir = document.getElementById('filterTglAkhir').value;

        if (tglAwal > tglAkhir) {
            alert('Tanggal awal tidak boleh lebih besar dari tanggal akhir!');
            return;
        }

        const overlay = document.getElementById('chartLoadingOverlay');
        overlay.style.display = 'flex';
        closeBreakdown();

        try {
            const response = await fetch("{{ route('ajax_dfarmlosis') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    komoditi_id: komoditiId,
                    produk_id: produkId,
                    tgl_awal: tglAwal,
                    tgl_akhir: tglAkhir
                })
            });

            const result = await response.json();

            if (!result.success) {
                alert(result.error || 'Terjadi kesalahan saat memuat data.');
                return;
            }

            currentDashboardData = result;
            allTableRows = result.table_data || [];

            // 1. Update KPI Cards
            updateKpiCards(result.kpi);

            // 2. Render Regional Bar Chart
            renderRegionalChart(result.regional_chart);

            // 3. Render Transaction Table
            renderTableData(allTableRows);

        } catch (error) {
            console.error('Fetch error:', error);
            alert('Gagal menghubungi server untuk memuat data.');
        } finally {
            overlay.style.display = 'none';
        }
    }

    // Update KPI Cards
    function updateKpiCards(kpi) {
        document.getElementById('kpiTotalKebun').innerHTML = `${formatNumber(kpi.total_kebun)} <span style="font-size: 0.9rem; font-weight: 500;">kg</span>`;
        document.getElementById('kpiTotalPabrik').innerHTML = `${formatNumber(kpi.total_pabrik)} <span style="font-size: 0.9rem; font-weight: 500;">kg</span>`;
        
        const selisihEl = document.getElementById('kpiTotalSelisih');
        selisihEl.innerHTML = `${formatNumber(kpi.total_selisih)} <span style="font-size: 0.9rem; font-weight: 500;">kg</span>`;
        if (kpi.total_selisih > 0) {
            selisihEl.style.color = '#b91c1c'; // Merah jika susut/losis
        } else if (kpi.total_selisih < 0) {
            selisihEl.style.color = '#15803d'; // Hijau jika pabrik lebih berat
        } else {
            selisihEl.style.color = '#334155';
        }

        const pctEl = document.getElementById('kpiLosisPct');
        pctEl.textContent = `${formatNumber(kpi.losis_pct, 2)}%`;
        
        document.getElementById('kpiTotalRitase').textContent = `${formatNumber(kpi.total_ritase)} ritase pengiriman`;
    }

    // Render Grouped Bar Chart: Regional Level
    function renderRegionalChart(regionalList) {
        const ctx = document.getElementById('regionalChart').getContext('2d');

        if (regionalChartInstance) {
            regionalChartInstance.destroy();
        }

        if (!regionalList || regionalList.length === 0) {
            ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
            ctx.font = '14px sans-serif';
            ctx.fillStyle = '#94a3b8';
            ctx.textAlign = 'center';
            ctx.fillText('Tidak ada data penerimaan untuk filter yang dipilih', ctx.canvas.width / 2, 180);
            return;
        }

        const labels = regionalList.map(r => r.name);
        const dataKebun = regionalList.map(r => r.kg_kebun);
        const dataPabrik = regionalList.map(r => r.kg_pabrik);

        regionalChartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Produksi Kebun (Kg)',
                        data: dataKebun,
                        backgroundColor: '#166534',
                        hoverBackgroundColor: '#14532d',
                        borderRadius: 5,
                        barPercentage: 0.85,
                        categoryPercentage: 0.7,
                    },
                    {
                        label: 'Diterima Pabrik (Kg)',
                        data: dataPabrik,
                        backgroundColor: '#2563eb',
                        hoverBackgroundColor: '#1d4ed8',
                        borderRadius: 5,
                        barPercentage: 0.85,
                        categoryPercentage: 0.7,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                onClick: (event, elements) => {
                    if (elements && elements.length > 0) {
                        const index = elements[0].index;
                        const regObj = regionalList[index];
                        showBreakdown(regObj.name);
                    }
                },
                onHover: (event, chartElement) => {
                    event.native.target.style.cursor = chartElement[0] ? 'pointer' : 'default';
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 10,
                            font: { weight: 'bold', size: 12 }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const idx = context.dataIndex;
                                const regObj = regionalList[idx];
                                const label = context.dataset.label || '';
                                const valStr = formatNumber(context.raw) + ' kg';
                                return ` ${label}: ${valStr}`;
                            },
                            afterBody: function(contexts) {
                                if (contexts.length > 0) {
                                    const idx = contexts[0].dataIndex;
                                    const regObj = regionalList[idx];
                                    return [
                                        `------------------------------`,
                                        `Selisih: ${formatNumber(regObj.selisih)} kg`,
                                        `Losis: ${formatNumber(regObj.losis_pct, 2)}% (${regObj.kebun_count} Kebun)`,
                                        `👉 Klik batang untuk rincian kebun`
                                    ];
                                }
                                return [];
                            }
                        }
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        offset: 4,
                        color: '#475569',
                        font: { weight: 'bold', size: 11 },
                        formatter: function(value) {
                            return value > 0 ? formatNumber(value) : '';
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            callback: function(value) {
                                return formatNumber(value);
                            }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { weight: 'bold', size: 12 } }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    }

    // Drilldown breakdown: per Kebun
    function showBreakdown(regionalName) {
        selectedRegionalName = regionalName;
        const breakdownSection = document.getElementById('breakdownSection');
        const regionalTitle = document.getElementById('selectedRegionalTitle');
        regionalTitle.textContent = regionalName;

        const kebunList = (currentDashboardData && currentDashboardData.kebun_breakdown) ? currentDashboardData.kebun_breakdown[regionalName] : [];

        if (!kebunList || kebunList.length === 0) {
            alert(`Tidak ada data kebun untuk ${regionalName}`);
            return;
        }

        breakdownSection.style.display = 'block';

        // Dynamic height based on kebun count
        const calculatedHeight = Math.max(340, kebunList.length * 48);
        document.getElementById('breakdownChartWrapper').style.height = `${calculatedHeight}px`;

        const ctx = document.getElementById('kebunChart').getContext('2d');
        if (kebunChartInstance) {
            kebunChartInstance.destroy();
        }

        const labels = kebunList.map(k => k.name);
        const dataKebun = kebunList.map(k => k.kg_kebun);
        const dataPabrik = kebunList.map(k => k.kg_pabrik);

        kebunChartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Produksi Kebun (Kg)',
                        data: dataKebun,
                        backgroundColor: '#16a34a',
                        hoverBackgroundColor: '#15803d',
                        borderRadius: 4,
                        barPercentage: 0.85,
                        categoryPercentage: 0.8,
                    },
                    {
                        label: 'Diterima Pabrik (Kg)',
                        data: dataPabrik,
                        backgroundColor: '#60a5fa',
                        hoverBackgroundColor: '#3b82f6',
                        borderRadius: 4,
                        barPercentage: 0.85,
                        categoryPercentage: 0.8,
                    }
                ]
            },
            options: {
                indexAxis: 'y', // Horizontal bars for clean readability with many kebuns
                responsive: true,
                maintainAspectRatio: false,
                onClick: (event, elements) => {
                    if (elements && elements.length > 0) {
                        const idx = elements[0].index;
                        const kbnObj = kebunList[idx];
                        filterTableByKebun(kbnObj.name);
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8,
                            font: { weight: 'bold', size: 11 }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ` ${context.dataset.label}: ${formatNumber(context.raw)} kg`;
                            },
                            afterBody: function(contexts) {
                                if (contexts.length > 0) {
                                    const idx = contexts[0].dataIndex;
                                    const kbnObj = kebunList[idx];
                                    return [
                                        `------------------------------`,
                                        `Selisih: ${formatNumber(kbnObj.selisih)} kg`,
                                        `Losis: ${formatNumber(kbnObj.losis_pct, 2)}%`,
                                        `👉 Klik untuk memfilter tabel di bawah`
                                    ];
                                }
                                return [];
                            }
                        }
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'right',
                        offset: 4,
                        color: '#475569',
                        font: { weight: 'bold', size: 10 },
                        formatter: function(val) {
                            return val > 0 ? formatNumber(val) : '';
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            callback: function(v) { return formatNumber(v); }
                        }
                    },
                    y: {
                        grid: { display: false },
                        ticks: { font: { weight: 'bold', size: 11 } }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

        // Update table to show only this regional
        document.getElementById('tableFilterTag').innerHTML = `(Difilter: <strong>${regionalName}</strong>)`;
        const filteredRows = allTableRows.filter(r => r.regional === regionalName);
        renderTableData(filteredRows);

        // Smooth scroll to breakdown section
        breakdownSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Close breakdown card
    function closeBreakdown() {
        document.getElementById('breakdownSection').style.display = 'none';
        selectedRegionalName = null;
        document.getElementById('tableFilterTag').textContent = '(Semua Regional)';
        renderTableData(allTableRows);
    }

    // Filter table specifically for clicked kebun
    function filterTableByKebun(kebunName) {
        document.getElementById('tableFilterTag').innerHTML = `(Difilter: <strong>${selectedRegionalName}</strong> &rsaquo; <strong>${kebunName}</strong>)`;
        const filtered = allTableRows.filter(r => r.regional === selectedRegionalName && r.kebun === kebunName);
        renderTableData(filtered);
    }

    // Collapse state registry
    let collapseState = {};

    function toggleGroup(type, id) {
        const key = `${type}-${id}`;
        collapseState[key] = !collapseState[key];
        updateTableVisibility();
    }

    function expandAllGroups() {
        for (const k in collapseState) {
            collapseState[k] = false;
        }
        updateTableVisibility();
    }

    function collapseAllGroups() {
        for (const k in collapseState) {
            if (k.startsWith('kbn-')) {
                collapseState[k] = true;
            }
        }
        updateTableVisibility();
    }

    function showSubtotalsOnly() {
        for (const k in collapseState) {
            if (k.startsWith('kbn-') || k.startsWith('afd-')) {
                collapseState[k] = false;
            } else if (k.startsWith('prd-')) {
                collapseState[k] = true;
            }
        }
        updateTableVisibility();
    }

    function updateTableVisibility() {
        // 1. Update chevron icons
        document.querySelectorAll('.toggle-btn').forEach(btn => {
            const id = btn.dataset.targetId;
            const icon = btn.querySelector('.chevron-icon');
            if (icon) {
                if (collapseState[id]) {
                    icon.className = 'fa-solid fa-chevron-right chevron-icon';
                } else {
                    icon.className = 'fa-solid fa-chevron-down chevron-icon';
                }
            }
        });

        // 2. Update rows visibility according to parent state
        document.querySelectorAll('#transactionTableBody tr').forEach(row => {
            const level = row.dataset.level;
            const kbn = row.dataset.kbn;
            const afd = row.dataset.afd;
            const prd = row.dataset.prd;

            let visible = true;
            if (level !== 'kbn') {
                if (collapseState['kbn-' + kbn]) visible = false;
            }
            if (visible && level !== 'kbn' && level !== 'afd') {
                if (collapseState['afd-' + afd]) visible = false;
            }
            if (visible && level === 'detail') {
                if (collapseState['prd-' + prd]) visible = false;
            }

            row.style.display = visible ? '' : 'none';
        });
    }

    // Render HTML Table Rows with Hierarchical Tree Grouping (Kebun -> Afdeling -> Produk -> Detail)
    function renderTableData(rows) {
        const tbody = document.getElementById('transactionTableBody');
        const tfoot = document.getElementById('transactionTableFoot');
        
        if (!rows || rows.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="13" class="text-center" style="padding: 24px; color: #94a3b8;">
                        Tidak ada transaksi ditemukan.
                    </td>
                </tr>`;
            if (tfoot) tfoot.innerHTML = '';
            return;
        }

        // Group rows by Kebun -> Afdeling -> Produk
        const groups = {};
        let grandKebun = 0;
        let grandPabrik = 0;
        let grandSelisih = 0;

        rows.forEach(r => {
            const kKey = r.kebun || 'Kebun Lainnya';
            const aKey = r.afdeling || '-';
            const pKey = r.produk || '-';

            const kgK = Number(r.kg_kebun) || 0;
            const kgP = Number(r.kg_pabrik) || 0;
            const diff = Number(r.selisih) || 0;

            grandKebun += kgK;
            grandPabrik += kgP;
            grandSelisih += diff;

            if (!groups[kKey]) {
                groups[kKey] = {
                    kebun: r.kebun,
                    regional: r.regional,
                    kg_kebun: 0,
                    kg_pabrik: 0,
                    selisih: 0,
                    itemCount: 0,
                    afdelings: {}
                };
            }
            groups[kKey].kg_kebun += kgK;
            groups[kKey].kg_pabrik += kgP;
            groups[kKey].selisih += diff;
            groups[kKey].itemCount++;

            if (!groups[kKey].afdelings[aKey]) {
                groups[kKey].afdelings[aKey] = {
                    afdeling: aKey,
                    kg_kebun: 0,
                    kg_pabrik: 0,
                    selisih: 0,
                    itemCount: 0,
                    produks: {}
                };
            }
            groups[kKey].afdelings[aKey].kg_kebun += kgK;
            groups[kKey].afdelings[aKey].kg_pabrik += kgP;
            groups[kKey].afdelings[aKey].selisih += diff;
            groups[kKey].afdelings[aKey].itemCount++;

            if (!groups[kKey].afdelings[aKey].produks[pKey]) {
                groups[kKey].afdelings[aKey].produks[pKey] = {
                    produk: pKey,
                    kg_kebun: 0,
                    kg_pabrik: 0,
                    selisih: 0,
                    items: []
                };
            }
            groups[kKey].afdelings[aKey].produks[pKey].kg_kebun += kgK;
            groups[kKey].afdelings[aKey].produks[pKey].kg_pabrik += kgP;
            groups[kKey].afdelings[aKey].produks[pKey].selisih += diff;
            groups[kKey].afdelings[aKey].produks[pKey].items.push(r);
        });

        let html = '';
        let kIdx = 0;
        let globalCounter = 0;
        const sortedKebuns = Object.keys(groups).sort();

        sortedKebuns.forEach(kKey => {
            const kbn = groups[kKey];
            const kId = `kbn-${kIdx}`;
            if (collapseState[kId] === undefined) {
                collapseState[kId] = false; // default expanded
            }

            const kbnLosisPct = kbn.kg_kebun > 0 ? ((kbn.selisih / kbn.kg_kebun) * 100) : 0;
            const kbnBadgeClass = kbn.selisih > 0 ? 'badge-susut' : (kbn.selisih < 0 ? 'badge-gain' : 'badge-pass');
            const kbnBadgeText = kbn.selisih > 0 ? `Losis ${formatNumber(kbnLosisPct, 2)}%` : (kbn.selisih < 0 ? `Gain ${formatNumber(Math.abs(kbnLosisPct), 2)}%` : '0.00%');

            html += `
                <tr class="row-total-kebun" data-level="kbn" data-kbn="${kIdx}" onclick="toggleGroup('kbn', '${kIdx}')" title="Klik untuk expand / collapse kebun ${kbn.kebun}">
                    <td colspan="9">
                        <span class="toggle-btn" data-target-id="${kId}">
                            <i class="fa-solid fa-chevron-down chevron-icon"></i>
                        </span>
                        <i class="fa-solid fa-tree" style="color: #166534; margin-right: 4px;"></i>
                        <strong>TOTAL KEBUN: ${kbn.kebun}</strong>
                        <span class="badge-tag badge-tag-kebun">${kbn.regional}</span>
                        <span class="badge-tag" style="background: #f1f5f9; color: #475569;">${formatNumber(kbn.itemCount)} rit / pengiriman</span>
                        <span class="badge-tag" style="background: #f1f5f9; color: #475569;">${Object.keys(kbn.afdelings).length} Afdeling</span>
                    </td>
                    <td class="text-right font-mono font-bold" style="color: #166534;">${formatNumber(kbn.kg_kebun, 2)}</td>
                    <td class="text-right font-mono font-bold" style="color: #2563eb;">${formatNumber(kbn.kg_pabrik, 2)}</td>
                    <td class="text-right font-mono font-bold" style="color: ${kbn.selisih > 0 ? '#b91c1c' : (kbn.selisih < 0 ? '#15803d' : '#334155')};">
                        ${formatNumber(kbn.selisih, 2)}
                    </td>
                    <td class="text-center font-bold">
                        <span class="badge-losis ${kbnBadgeClass}">${kbnBadgeText}</span>
                    </td>
                </tr>
            `;

            let aIdx = 0;
            const sortedAfds = Object.keys(kbn.afdelings).sort();
            sortedAfds.forEach(aKey => {
                const afd = kbn.afdelings[aKey];
                const aId = `afd-${kIdx}-${aIdx}`;
                if (collapseState[aId] === undefined) {
                    collapseState[aId] = false;
                }

                const afdLosisPct = afd.kg_kebun > 0 ? ((afd.selisih / afd.kg_kebun) * 100) : 0;
                const afdBadgeClass = afd.selisih > 0 ? 'badge-susut' : (afd.selisih < 0 ? 'badge-gain' : 'badge-pass');
                const afdBadgeText = afd.selisih > 0 ? `Losis ${formatNumber(afdLosisPct, 2)}%` : (afd.selisih < 0 ? `Gain ${formatNumber(Math.abs(afdLosisPct), 2)}%` : '0.00%');

                html += `
                    <tr class="row-subtotal-afdeling" data-level="afd" data-kbn="${kIdx}" data-afd="${kIdx}-${aIdx}" onclick="toggleGroup('afd', '${kIdx}-${aIdx}')" title="Klik untuk expand / collapse afdeling ${afd.afdeling}">
                        <td colspan="9" style="padding-left: 28px !important;">
                            <span class="toggle-btn" data-target-id="${aId}">
                                <i class="fa-solid fa-chevron-down chevron-icon"></i>
                            </span>
                            <i class="fa-solid fa-layer-group" style="color: #2563eb; margin-right: 4px;"></i>
                            <span>Subtotal Afdeling: <strong>${afd.afdeling}</strong></span>
                            <span class="badge-tag badge-tag-afd">${formatNumber(afd.itemCount)} rit</span>
                            <span class="badge-tag" style="background: #f1f5f9; color: #475569;">${Object.keys(afd.produks).length} Produk</span>
                        </td>
                        <td class="text-right font-mono font-semibold" style="color: #166534;">${formatNumber(afd.kg_kebun, 2)}</td>
                        <td class="text-right font-mono font-semibold" style="color: #2563eb;">${formatNumber(afd.kg_pabrik, 2)}</td>
                        <td class="text-right font-mono font-semibold" style="color: ${afd.selisih > 0 ? '#b91c1c' : (afd.selisih < 0 ? '#15803d' : '#334155')};">
                            ${formatNumber(afd.selisih, 2)}
                        </td>
                        <td class="text-center font-semibold">
                            <span class="badge-losis ${afdBadgeClass}">${afdBadgeText}</span>
                        </td>
                    </tr>
                `;

                let pIdx = 0;
                const sortedPrds = Object.keys(afd.produks).sort();
                sortedPrds.forEach(pKey => {
                    const prd = afd.produks[pKey];
                    const pId = `prd-${kIdx}-${aIdx}-${pIdx}`;
                    if (collapseState[pId] === undefined) {
                        collapseState[pId] = false;
                    }

                    const prdLosisPct = prd.kg_kebun > 0 ? ((prd.selisih / prd.kg_kebun) * 100) : 0;
                    const prdBadgeClass = prd.selisih > 0 ? 'badge-susut' : (prd.selisih < 0 ? 'badge-gain' : 'badge-pass');
                    const prdBadgeText = prd.selisih > 0 ? `Losis ${formatNumber(prdLosisPct, 2)}%` : (prd.selisih < 0 ? `Gain ${formatNumber(Math.abs(prdLosisPct), 2)}%` : '0.00%');

                    html += `
                        <tr class="row-subtotal-produk" data-level="prd" data-kbn="${kIdx}" data-afd="${kIdx}-${aIdx}" data-prd="${kIdx}-${aIdx}-${pIdx}" onclick="toggleGroup('prd', '${kIdx}-${aIdx}-${pIdx}')" title="Klik untuk expand / collapse transaksi produk ${prd.produk}">
                            <td colspan="9" style="padding-left: 50px !important;">
                                <span class="toggle-btn" data-target-id="${pId}">
                                    <i class="fa-solid fa-chevron-down chevron-icon"></i>
                                </span>
                                <i class="fa-solid fa-tag" style="color: #d97706; margin-right: 4px;"></i>
                                <span>Subtotal Produk: <strong>${prd.produk}</strong></span>
                                <span class="badge-tag badge-tag-prd">${formatNumber(prd.items.length)} transaksi</span>
                            </td>
                            <td class="text-right font-mono" style="font-weight: 600; color: #166534;">${formatNumber(prd.kg_kebun, 2)}</td>
                            <td class="text-right font-mono" style="font-weight: 600; color: #2563eb;">${formatNumber(prd.kg_pabrik, 2)}</td>
                            <td class="text-right font-mono" style="font-weight: 600; color: ${prd.selisih > 0 ? '#b91c1c' : (prd.selisih < 0 ? '#15803d' : '#334155')};">
                                ${formatNumber(prd.selisih, 2)}
                            </td>
                            <td class="text-center">
                                <span class="badge-losis ${prdBadgeClass}">${prdBadgeText}</span>
                            </td>
                        </tr>
                    `;

                    // Detail rows
                    prd.items.forEach(r => {
                        globalCounter++;
                        let badgeClass = 'badge-pass';
                        let badgeText = `${formatNumber(r.losis_pct, 2)}%`;
                        if (r.selisih > 0) {
                            badgeClass = 'badge-susut';
                            badgeText = `Losis ${formatNumber(r.losis_pct, 2)}%`;
                        } else if (r.selisih < 0) {
                            badgeClass = 'badge-gain';
                            badgeText = `Gain ${formatNumber(Math.abs(r.losis_pct), 2)}%`;
                        }

                        html += `
                            <tr class="row-trans-detail" data-level="detail" data-kbn="${kIdx}" data-afd="${kIdx}-${aIdx}" data-prd="${kIdx}-${aIdx}-${pIdx}">
                                <td class="text-center" style="color: #94a3b8; font-size: 11px;">${globalCounter}</td>
                                <td>${r.tanggal}</td>
                                <td><span style="font-weight: 600; color: #166534;">${r.regional}</span></td>
                                <td style="font-weight: 500;">${r.kebun}</td>
                                <td>${r.afdeling}</td>
                                <td>${r.produk}</td>
                                <td class="font-mono" style="font-size: 11px;">${r.nomor_dokumen}</td>
                                <td class="text-center">${r.rit}</td>
                                <td class="font-mono">${r.no_pol}</td>
                                <td class="text-right font-mono" style="color: #166534;">${formatNumber(r.kg_kebun, 2)}</td>
                                <td class="text-right font-mono" style="color: #2563eb;">${formatNumber(r.kg_pabrik, 2)}</td>
                                <td class="text-right font-mono" style="color: ${r.selisih > 0 ? '#b91c1c' : (r.selisih < 0 ? '#15803d' : '#334155')};">
                                    ${formatNumber(r.selisih, 2)}
                                </td>
                                <td class="text-center">
                                    <span class="badge-losis ${badgeClass}">${badgeText}</span>
                                </td>
                            </tr>
                        `;
                    });

                    pIdx++;
                });

                aIdx++;
            });

            kIdx++;
        });

        tbody.innerHTML = html;

        // Render Grand Total in Footer
        if (tfoot) {
            const grandLosisPct = grandKebun > 0 ? ((grandSelisih / grandKebun) * 100) : 0;
            const grandBadgeClass = grandSelisih > 0 ? 'badge-susut' : (grandSelisih < 0 ? 'badge-gain' : 'badge-pass');
            const grandBadgeText = grandSelisih > 0 ? `Losis ${formatNumber(grandLosisPct, 2)}%` : (grandSelisih < 0 ? `Gain ${formatNumber(Math.abs(grandLosisPct), 2)}%` : '0.00%');

            tfoot.innerHTML = `
                <tr class="tfoot-grand-total">
                    <td colspan="9" style="letter-spacing: 0.03em;">
                        <i class="fa-solid fa-calculator" style="margin-right: 6px;"></i>
                        GRAND TOTAL (${sortedKebuns.length} Kebun &bull; ${formatNumber(rows.length)} Transaksi)
                    </td>
                    <td class="text-right font-mono">${formatNumber(grandKebun, 2)}</td>
                    <td class="text-right font-mono">${formatNumber(grandPabrik, 2)}</td>
                    <td class="text-right font-mono">${formatNumber(grandSelisih, 2)}</td>
                    <td class="text-center">
                        <span class="badge-losis" style="background: rgba(255,255,255,0.25); color: #fff;">${grandBadgeText}</span>
                    </td>
                </tr>
            `;
        }

        updateTableVisibility();
    }

    // Client-side quick filter on table
    function onTableSearch() {
        const query = document.getElementById('tableSearch').value.toLowerCase().trim();
        let targetRows = allTableRows;

        if (selectedRegionalName) {
            targetRows = targetRows.filter(r => r.regional === selectedRegionalName);
        }

        if (!query) {
            renderTableData(targetRows);
            return;
        }

        const filtered = targetRows.filter(r => {
            return (
                r.kebun.toLowerCase().includes(query) ||
                r.afdeling.toLowerCase().includes(query) ||
                r.no_pol.toLowerCase().includes(query) ||
                r.nomor_dokumen.toLowerCase().includes(query) ||
                r.produk.toLowerCase().includes(query) ||
                r.tanggal.includes(query)
            );
        });

        // Automatically expand all groups during search so matching rows are visible
        for (const k in collapseState) {
            collapseState[k] = false;
        }

        renderTableData(filtered);
    }

    // Export to Excel (.xlsx) using xlsx-js-style with Title Headers & Dynamic Filename
    function exportTableToExcel() {
        if (!allTableRows || allTableRows.length === 0) {
            alert('Tidak ada data untuk diekspor!');
            return;
        }

        // 1. Extract Filter Information
        const komoditiSelect = document.getElementById('filterKomoditi');
        const komoditiText = komoditiSelect ? komoditiSelect.options[komoditiSelect.selectedIndex].text.trim() : 'Komoditi';

        const produkSelect = document.getElementById('filterProduk');
        let produkText = 'Semua Produk';
        if (produkSelect && produkSelect.value !== 'all' && produkSelect.selectedIndex >= 0) {
            produkText = produkSelect.options[produkSelect.selectedIndex].text.trim();
        }

        const regionalText = selectedRegionalName ? selectedRegionalName.trim() : 'Semua Regional';

        const tglAwal = document.getElementById('filterTglAwal').value;
        const tglAkhir = document.getElementById('filterTglAkhir').value;

        function formatDisplayDate(dateStr) {
            if (!dateStr) return '-';
            const p = dateStr.split('-');
            if (p.length === 3) return `${p[2]}/${p[1]}/${p[0]}`;
            return dateStr;
        }
        const tglAwalDisplay = formatDisplayDate(tglAwal);
        const tglAkhirDisplay = formatDisplayDate(tglAkhir);
        const downloadTimeStr = new Date().toLocaleString('id-ID');

        // Rows to export (respects active search or regional filter)
        const query = document.getElementById('tableSearch').value.toLowerCase().trim();
        let exportRows = allTableRows;
        if (regionalText !== 'Semua Regional') {
            exportRows = exportRows.filter(r => r.regional === regionalText);
        }
        if (query) {
            exportRows = exportRows.filter(r => (
                r.kebun.toLowerCase().includes(query) ||
                r.afdeling.toLowerCase().includes(query) ||
                r.no_pol.toLowerCase().includes(query) ||
                r.nomor_dokumen.toLowerCase().includes(query) ||
                r.produk.toLowerCase().includes(query) ||
                r.tanggal.includes(query)
            ));
        }

        // Shared Style definitions
        const headerColStyle = {
            font: { bold: true, color: { rgb: "FFFFFFFF" }, sz: 11 },
            fill: { fgColor: { rgb: "FF166534" } }, // PTPN 1 Dark Green
            border: {
                top: { style: "thin", color: { rgb: "FF14532D" } },
                bottom: { style: "medium", color: { rgb: "FF14532D" } },
                left: { style: "thin", color: { rgb: "FF14532D" } },
                right: { style: "thin", color: { rgb: "FF14532D" } }
            },
            alignment: { horizontal: "center", vertical: "center", wrapText: true }
        };

        const borderStyle = {
            top: { style: "thin", color: { rgb: "FFE2E8F0" } },
            bottom: { style: "thin", color: { rgb: "FFE2E8F0" } },
            left: { style: "thin", color: { rgb: "FFE2E8F0" } },
            right: { style: "thin", color: { rgb: "FFE2E8F0" } }
        };

        // Header Title Styles
        const titleRow1Style = {
            font: { bold: true, sz: 15, color: { rgb: "FF166534" } },
            alignment: { horizontal: "center", vertical: "center" }
        };

        const titleRow2Style = {
            font: { bold: true, sz: 11, color: { rgb: "FF334155" } },
            alignment: { horizontal: "center", vertical: "center" }
        };

        const filterBannerStyle = {
            font: { bold: true, sz: 11.5, color: { rgb: "FF14532D" } },
            fill: { fgColor: { rgb: "FFDCFCE7" } },
            border: {
                top: { style: "thin", color: { rgb: "FF86EFAC" } },
                bottom: { style: "thin", color: { rgb: "FF86EFAC" } },
                left: { style: "thin", color: { rgb: "FF86EFAC" } },
                right: { style: "thin", color: { rgb: "FF86EFAC" } }
            },
            alignment: { horizontal: "center", vertical: "center" }
        };

        const titleRow4Style = {
            font: { italic: true, sz: 9.5, color: { rgb: "FF64748B" } },
            alignment: { horizontal: "center", vertical: "center" }
        };

        // --- SHEET 1: Rincian Transaksi ---
        const titleRowsDetail = [
            ["MONITORING LOSIS D-FARM PTPN I"],
            ["LAPORAN RINCIAN TRANSAKSI PENGIRIMAN & PENERIMAAN"],
            [`KOMODITI: ${komoditiText.toUpperCase()}   |   PRODUK: ${produkText.toUpperCase()}   |   REGIONAL: ${regionalText.toUpperCase()}`],
            [`Periode: ${tglAwalDisplay} s/d ${tglAkhirDisplay}    |    Waktu Unduh: ${downloadTimeStr}`],
            [], // Baris kosong pemisah
            // Table Column Headers (14 columns):
            ["No", "Tanggal", "Regional", "Kebun", "Afdeling", "Produk", "No. Tiket Transport", "Rit", "No. Polisi", "Kg Kebun", "Kg Pabrik", "Selisih (Kg)", "% Losis", "Status"]
        ];

        exportRows.forEach((r, idx) => {
            let status = 'Sesuai';
            if (r.selisih > 0) status = 'Losis (Susut)';
            else if (r.selisih < 0) status = 'Gain (Lebih)';

            titleRowsDetail.push([
                idx + 1,
                r.tanggal,
                r.regional,
                r.kebun,
                r.afdeling,
                r.produk,
                r.nomor_dokumen,
                r.rit,
                r.no_pol,
                Number(r.kg_kebun) || 0,
                Number(r.kg_pabrik) || 0,
                Number(r.selisih) || 0,
                (Number(r.losis_pct) || 0) / 100,
                status
            ]);
        });

        const wsDetail = XLSX.utils.aoa_to_sheet(titleRowsDetail);

        // Styling Title & Filter Metadata across ALL merged cells (Rows 1-4, cols 0-13)
        for (let C = 0; C <= 13; ++C) {
            const c0 = XLSX.utils.encode_cell({ c: C, r: 0 });
            if (!wsDetail[c0]) wsDetail[c0] = { t: 's', v: '' };
            wsDetail[c0].s = titleRow1Style;

            const c1 = XLSX.utils.encode_cell({ c: C, r: 1 });
            if (!wsDetail[c1]) wsDetail[c1] = { t: 's', v: '' };
            wsDetail[c1].s = titleRow2Style;

            const c2 = XLSX.utils.encode_cell({ c: C, r: 2 });
            if (!wsDetail[c2]) wsDetail[c2] = { t: 's', v: '' };
            wsDetail[c2].s = filterBannerStyle;

            const c3 = XLSX.utils.encode_cell({ c: C, r: 3 });
            if (!wsDetail[c3]) wsDetail[c3] = { t: 's', v: '' };
            wsDetail[c3].s = titleRow4Style;
        }

        // Merges for Title & Metadata
        wsDetail['!merges'] = [
            { s: { r: 0, c: 0 }, e: { r: 0, c: 13 } },
            { s: { r: 1, c: 0 }, e: { r: 1, c: 13 } },
            { s: { r: 2, c: 0 }, e: { r: 2, c: 13 } },
            { s: { r: 3, c: 0 }, e: { r: 3, c: 13 } }
        ];

        // Row Heights
        wsDetail['!rows'] = [
            { hpt: 26 }, // Title
            { hpt: 18 }, // Subtitle
            { hpt: 24 }, // Filter Banner (Komoditi, Produk, Regional)
            { hpt: 18 }, // Periode & Download Time
            { hpt: 10 }, // Blank
            { hpt: 24 }  // Table Headers
        ];

        // Style Table Column Headers on Row 5
        for (let C = 0; C <= 13; ++C) {
            const headAddr = XLSX.utils.encode_cell({ c: C, r: 5 });
            if (wsDetail[headAddr]) wsDetail[headAddr].s = headerColStyle;
        }

        // Style Data Rows from Row 6 onwards
        const rangeDetail = XLSX.utils.decode_range(wsDetail['!ref']);
        for (let R = 6; R <= rangeDetail.e.r; ++R) {
            for (let C = 0; C <= 13; ++C) {
                const cellAddr = XLSX.utils.encode_cell({ c: C, r: R });
                if (!wsDetail[cellAddr]) continue;

                if (C === 0 || C === 1 || C === 7) {
                    wsDetail[cellAddr].s = { alignment: { horizontal: "center" }, border: borderStyle };
                } else if (C >= 9 && C <= 11) {
                    wsDetail[cellAddr].s = { alignment: { horizontal: "right" }, border: borderStyle };
                    wsDetail[cellAddr].z = "#,##0.00";
                } else if (C === 12) {
                    wsDetail[cellAddr].s = { alignment: { horizontal: "right" }, border: borderStyle };
                    wsDetail[cellAddr].z = "0.00%";
                } else {
                    wsDetail[cellAddr].s = { alignment: { horizontal: "left" }, border: borderStyle };
                }
            }
        }

        wsDetail['!cols'] = [
            { wch: 6 },  { wch: 12 }, { wch: 14 }, { wch: 24 }, { wch: 16 },
            { wch: 14 }, { wch: 28 }, { wch: 8 },  { wch: 14 }, { wch: 15 },
            { wch: 15 }, { wch: 15 }, { wch: 12 }, { wch: 16 }
        ];

        // --- SHEET 2: Rekap Per Kebun & Afdeling ---
        const groups = {};
        exportRows.forEach(r => {
            const kKey = r.kebun;
            const aKey = r.afdeling || '-';
            if (!groups[kKey]) groups[kKey] = { kebun: r.kebun, regional: r.regional, afdelings: {} };
            if (!groups[kKey].afdelings[aKey]) groups[kKey].afdelings[aKey] = { afdeling: aKey, kg_kebun: 0, kg_pabrik: 0, selisih: 0, rit: 0 };
            groups[kKey].afdelings[aKey].kg_kebun += Number(r.kg_kebun) || 0;
            groups[kKey].afdelings[aKey].kg_pabrik += Number(r.kg_pabrik) || 0;
            groups[kKey].afdelings[aKey].selisih += Number(r.selisih) || 0;
            groups[kKey].afdelings[aKey].rit++;
        });

        const titleRowsRekap = [
            ["MONITORING LOSIS D-FARM PTPN I"],
            ["REKAPITULASI DATA PER KEBUN & AFDELING"],
            [`KOMODITI: ${komoditiText.toUpperCase()}   |   PRODUK: ${produkText.toUpperCase()}   |   REGIONAL: ${regionalText.toUpperCase()}`],
            [`Periode: ${tglAwalDisplay} s/d ${tglAkhirDisplay}    |    Waktu Unduh: ${downloadTimeStr}`],
            [],
            // Headers (9 columns):
            ["No", "Regional", "Kebun", "Afdeling", "Jumlah Rit", "Total Kg Kebun", "Total Kg Pabrik", "Total Selisih (Kg)", "% Losis"]
        ];

        let rIdx = 1;
        Object.keys(groups).sort().forEach(kKey => {
            const kbn = groups[kKey];
            Object.keys(kbn.afdelings).sort().forEach(aKey => {
                const afd = kbn.afdelings[aKey];
                const pct = afd.kg_kebun > 0 ? (afd.selisih / afd.kg_kebun) : 0;
                titleRowsRekap.push([
                    rIdx++,
                    kbn.regional,
                    kbn.kebun,
                    afd.afdeling,
                    afd.rit,
                    afd.kg_kebun,
                    afd.kg_pabrik,
                    afd.selisih,
                    pct
                ]);
            });
        });

        const wsRekap = XLSX.utils.aoa_to_sheet(titleRowsRekap);

        // Styling Title & Filter Metadata across ALL merged cells (Rows 1-4, cols 0-8)
        for (let C = 0; C <= 8; ++C) {
            const c0 = XLSX.utils.encode_cell({ c: C, r: 0 });
            if (!wsRekap[c0]) wsRekap[c0] = { t: 's', v: '' };
            wsRekap[c0].s = titleRow1Style;

            const c1 = XLSX.utils.encode_cell({ c: C, r: 1 });
            if (!wsRekap[c1]) wsRekap[c1] = { t: 's', v: '' };
            wsRekap[c1].s = titleRow2Style;

            const c2 = XLSX.utils.encode_cell({ c: C, r: 2 });
            if (!wsRekap[c2]) wsRekap[c2] = { t: 's', v: '' };
            wsRekap[c2].s = filterBannerStyle;

            const c3 = XLSX.utils.encode_cell({ c: C, r: 3 });
            if (!wsRekap[c3]) wsRekap[c3] = { t: 's', v: '' };
            wsRekap[c3].s = titleRow4Style;
        }

        wsRekap['!merges'] = [
            { s: { r: 0, c: 0 }, e: { r: 0, c: 8 } },
            { s: { r: 1, c: 0 }, e: { r: 1, c: 8 } },
            { s: { r: 2, c: 0 }, e: { r: 2, c: 8 } },
            { s: { r: 3, c: 0 }, e: { r: 3, c: 8 } }
        ];

        wsRekap['!rows'] = [
            { hpt: 26 }, { hpt: 18 }, { hpt: 24 }, { hpt: 18 }, { hpt: 10 }, { hpt: 24 }
        ];

        for (let C = 0; C <= 8; ++C) {
            const headAddr = XLSX.utils.encode_cell({ c: C, r: 5 });
            if (wsRekap[headAddr]) wsRekap[headAddr].s = headerColStyle;
        }

        const rangeRekap = XLSX.utils.decode_range(wsRekap['!ref']);
        for (let R = 6; R <= rangeRekap.e.r; ++R) {
            for (let C = 0; C <= 8; ++C) {
                const cellAddr = XLSX.utils.encode_cell({ c: C, r: R });
                if (!wsRekap[cellAddr]) continue;

                if (C === 0 || C === 4) {
                    wsRekap[cellAddr].s = { alignment: { horizontal: "center" }, border: borderStyle };
                } else if (C >= 5 && C <= 7) {
                    wsRekap[cellAddr].s = { alignment: { horizontal: "right" }, border: borderStyle };
                    wsRekap[cellAddr].z = "#,##0.00";
                } else if (C === 8) {
                    wsRekap[cellAddr].s = { alignment: { horizontal: "right" }, border: borderStyle };
                    wsRekap[cellAddr].z = "0.00%";
                } else {
                    wsRekap[cellAddr].s = { alignment: { horizontal: "left" }, border: borderStyle };
                }
            }
        }

        wsRekap['!cols'] = [
            { wch: 6 }, { wch: 14 }, { wch: 24 }, { wch: 16 }, { wch: 12 },
            { wch: 16 }, { wch: 16 }, { wch: 16 }, { wch: 12 }
        ];

        // Create workbook & write to file
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, wsDetail, "Rincian Transaksi");
        XLSX.utils.book_append_sheet(wb, wsRekap, "Rekap Kebun & Afdeling");

        // Format Dynamic Filename: Monitoring_Losis_[Komoditi]_[Produk]_[Regional]_[TglAwal]_sd_[TglAkhir].xlsx
        function cleanName(str) {
            return str
                .replace(/--/g, '')
                .replace(/[^a-zA-Z0-9]/g, '_')
                .replace(/_+/g, '_')
                .replace(/^_|_$/g, '');
        }

        const safeKomoditi = cleanName(komoditiText) || 'Semua_Komoditi';
        const safeProduk = cleanName(produkText) || 'Semua_Produk';
        const safeRegional = cleanName(regionalText) || 'Semua_Regional';
        const safeTglAwal = cleanName(tglAwal);
        const safeTglAkhir = cleanName(tglAkhir);

        const filename = `Monitoring_Losis_${safeKomoditi}_${safeProduk}_${safeRegional}_${safeTglAwal}_sd_${safeTglAkhir}.xlsx`;
        XLSX.writeFile(wb, filename);
    }
</script>
@endsection

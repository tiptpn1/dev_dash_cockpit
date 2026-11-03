@extends('layouts.app')

@section('title', 'TimesFM Commodity Forecast & Posisi Real PTPN I - AGRINAV')

@section('styles')
    <!-- ApexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        /* ===== SCROLL & LAYOUT FIX ===== */
        html, body {
            height: auto !important;
            min-height: 100vh;
            overflow-y: auto !important;
            background-color: #f8fafc !important;
            color: #1e293b;
            font-family: 'Google Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .forecast-wrapper {
            width: 100%;
            min-height: 100vh;
            background: #f8fafc;
            padding: 24px 32px 60px;
            box-sizing: border-box;
        }

        /* ===== HEADER STYLING ===== */
        .page-header-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 20px 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 4px 10px;
            border-radius: 9999px;
            border: 1px solid #bfdbfe;
        }

        .ptpn-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fef3c7;
            color: #b45309;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 9999px;
            border: 1px solid #fde68a;
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulse-green 2s infinite;
        }

        @keyframes pulse-green {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .source-link-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #ffffff;
            color: #0f172a;
            border: 1px solid #cbd5e1;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .source-link-btn:hover {
            background: #f1f5f9;
            border-color: #94a3b8;
            color: #0284c7;
        }

        /* ===== CONTROLS BAR ===== */
        .controls-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 20px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .commodity-tabs {
            display: flex;
            background: #f1f5f9;
            padding: 4px;
            border-radius: 10px;
            gap: 4px;
        }

        .commodity-btn {
            background: transparent;
            border: none;
            outline: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .commodity-btn.active {
            background: #ffffff;
            color: #0f172a;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .select-filter {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #1e293b;
            font-size: 0.85rem;
            font-weight: 500;
            padding: 7px 12px;
            border-radius: 8px;
            outline: none;
            cursor: pointer;
            transition: border-color 0.2s;
        }

        .select-filter:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.15);
        }

        .unit-toggle-pill {
            display: flex;
            background: #e2e8f0;
            padding: 3px;
            border-radius: 8px;
            gap: 2px;
        }

        .unit-btn {
            border: none;
            outline: none;
            background: transparent;
            font-size: 0.78rem;
            font-weight: 700;
            color: #475569;
            padding: 5px 12px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .unit-btn.active {
            background: #ffffff;
            color: #0f172a;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
        }

        .btn-run-model {
            background: #2563eb;
            color: #ffffff;
            border: none;
            padding: 8px 18px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
        }

        .btn-run-model:hover {
            background: #1d4ed8;
            box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3);
        }

        /* ===== PTPN I POSITION BANNER ===== */
        .ptpn-position-banner {
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            border: 1px solid #fde68a;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        }

        .ptpn-pos-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .ptpn-pos-icon {
            width: 44px;
            height: 44px;
            background: #f59e0b;
            color: #ffffff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(245, 158, 11, 0.3);
        }

        .ptpn-pos-detail h4 {
            margin: 0 0 4px 0;
            font-size: 0.95rem;
            font-weight: 700;
            color: #78350f;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .ptpn-pos-detail p {
            margin: 0;
            font-size: 0.82rem;
            color: #92400e;
            line-height: 1.4;
        }

        .ptpn-pos-price-box {
            text-align: right;
            background: #ffffff;
            padding: 10px 18px;
            border-radius: 8px;
            border: 1px solid #fde68a;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        }

        .ptpn-pos-price-title {
            font-size: 0.72rem;
            font-weight: 700;
            color: #92400e;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .ptpn-pos-price-num {
            font-size: 1.45rem;
            font-weight: 800;
            color: #b45309;
            line-height: 1.2;
        }

        /* ===== KPI STATS CARDS ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: #cbd5e1;
        }

        .stat-card.blue::before { background: #3b82f6; }
        .stat-card.red::before { background: #ef4444; }
        .stat-card.green::before { background: #10b981; }
        .stat-card.amber::before { background: #f59e0b; }
        .stat-card.purple::before { background: #8b5cf6; }

        .stat-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-value {
            font-size: 1.55rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.2;
        }

        .stat-desc {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .badge-down {
            color: #dc2626;
            font-weight: 600;
            background: #fee2e2;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.75rem;
        }

        .badge-up {
            color: #16a34a;
            font-weight: 600;
            background: #dcfce7;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.75rem;
        }

        /* ===== MAIN CHART SECTION ===== */
        .chart-container-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
            margin-bottom: 24px;
            position: relative;
        }

        .chart-header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 18px;
            padding-bottom: 14px;
            border-bottom: 1px solid #f1f5f9;
        }

        .chart-title-area h3 {
            font-size: 1.15rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .chart-legend-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
        }

        .legend-tag {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .tag-ptpn {
            background: #fef3c7;
            color: #b45309;
            border: 1px solid #fcd34d;
        }

        .tag-res {
            background: rgba(239, 68, 68, 0.12);
            color: #b91c1c;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .tag-dec {
            background: rgba(59, 130, 246, 0.12);
            color: #1d4ed8;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .tag-tp {
            background: rgba(16, 185, 129, 0.12);
            color: #047857;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .tag-timesfm {
            background: #f3e8ff;
            color: #7e22ce;
            border: 1px solid #d8b4fe;
        }

        /* ===== CHART BOX & OVERLAY ===== */
        .chart-stage {
            position: relative;
            width: 100%;
            min-height: 560px;
            background: #ffffff;
            border-radius: 10px;
        }

        #candlestick-chart {
            width: 100%;
            min-height: 560px;
        }

        /* Technical Indicator Callouts (Float Top-Right) */
        .chart-overlay-box {
            position: absolute;
            top: 28px;
            right: 48px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            z-index: 10;
            font-size: 0.8rem;
            max-width: 280px;
            pointer-events: none;
        }

        .overlay-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            color: #475569;
        }

        .overlay-row:last-child {
            margin-bottom: 0;
        }

        .overlay-val {
            font-weight: 700;
            color: #0f172a;
        }

        /* ===== DETAILS & EXPLANATION TABS ===== */
        .nav-tabs-wrapper {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 20px 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        }

        .tabs-header {
            display: flex;
            border-bottom: 1px solid #e2e8f0;
            gap: 24px;
            margin-bottom: 20px;
        }

        .tab-btn {
            background: none;
            border: none;
            outline: none;
            padding: 10px 4px;
            font-size: 0.92rem;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
        }

        .tab-btn.active {
            color: #2563eb;
            border-bottom-color: #2563eb;
        }

        .tab-content-panel {
            display: none;
        }

        .tab-content-panel.active {
            display: block;
        }

        /* Data table */
        .data-table-custom {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.85rem;
        }

        .data-table-custom th {
            background: #f8fafc;
            color: #475569;
            font-weight: 700;
            text-align: left;
            padding: 10px 14px;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }

        .data-table-custom td {
            padding: 10px 14px;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
        }

        .data-table-custom tr:hover td {
            background: #f8fafc;
        }

        .tag-hist {
            background: #e2e8f0;
            color: #475569;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 4px;
        }

        .tag-pred {
            background: #ede9fe;
            color: #6d28d9;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 4px;
        }

        /* Loading Spinner Overlay */
        .loading-cover {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.85);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            z-index: 50;
            transition: opacity 0.2s;
        }

        .spinner-custom {
            width: 44px;
            height: 44px;
            border: 4px solid #e2e8f0;
            border-top-color: #2563eb;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
@endsection

@section('content')
<div class="forecast-wrapper">
    <!-- 1. Header Card -->
    <div class="page-header-card">
        <div>
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px; flex-wrap: wrap;">
                <span class="brand-badge">
                    <span class="pulse-dot"></span>
                    Google TimesFM 1.0 (200M)
                </span>
                <span class="ptpn-badge">
                    <i class="fa-solid fa-building-wheat"></i>
                    Posisi Realisasi PTPN I Terintegrasi
                </span>
                <span style="font-size: 0.78rem; color: #64748b; font-weight: 500;">
                    Kurs Acuan: USD 1 = Rp 16.000 (JISDOR)
                </span>
            </div>
            <h1 style="font-size: 1.6rem; font-weight: 800; color: #0f172a; margin: 0;">
                Commodity Technical Forecast vs Posisi Real PTPN I
            </h1>
            <p style="font-size: 0.875rem; color: #64748b; margin: 4px 0 0 0;">
                Penyandingan data bursa SGX SICOM Rubber, kontrak realisasi penjualan PTPN I, dan trajektori proyeksi Google TimesFM dalam satu grafik.
            </p>
        </div>

        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <a href="https://www.sgx.com/derivatives/products/sicom-rubber?cc=RT" 
               target="_blank" 
               rel="noopener noreferrer" 
               class="source-link-btn"
               title="Buka Halaman Resmi SGX Derivatives SICOM Rubber">
                <i class="fa-solid fa-arrow-up-right-from-square" style="color: #0284c7;"></i>
                Sumber Data: SGX SICOM Rubber (RT)
            </a>

            <button type="button" class="btn-run-model" id="btn-reforecast" onclick="fetchForecastData(true)">
                <i class="fa-solid fa-arrows-rotate" id="refresh-icon"></i>
                <span>Jalankan TimesFM</span>
            </button>
        </div>
    </div>

    <!-- 2. PTPN I Live Realization Position Banner -->
    <div class="ptpn-position-banner">
        <div class="ptpn-pos-left">
            <div class="ptpn-pos-icon">
                <i class="fa-solid fa-file-contract"></i>
            </div>
            <div class="ptpn-pos-detail">
                <h4>
                    <span>Posisi Realisasi Penjualan PTPN I Terkini</span>
                    <span id="banner-contract-id" style="font-size: 0.75rem; background: #ffffff; padding: 2px 8px; border-radius: 4px; border: 1px solid #fde68a;">
                        Kontrak No: 0174/HO-SUPCO/SIR-L/N-I/II/2025
                    </span>
                </h4>
                <p id="banner-ptpn-summary">
                    Customer: <strong>WILSON TUNGGAL PERKASA</strong> | Grade: <strong>SIR 20</strong> | Volume: <strong>141.120 kg</strong> | Posisi: <strong>Key Decision Zone</strong>
                </p>
            </div>
        </div>

        <div style="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
            <div class="ptpn-pos-price-box">
                <div class="ptpn-pos-price-title">Harga Realisasi PTPN I</div>
                <div class="ptpn-pos-price-num" id="banner-ptpn-price">Rp 31.277 <span style="font-size: 0.85rem; font-weight: 600;">/ kg</span></div>
            </div>
            <div class="ptpn-pos-price-box" style="border-color: #bfdbfe; background: #eff6ff;">
                <div class="ptpn-pos-price-title" style="color: #1e40af;">Benchmark SGX Ekuivalen</div>
                <div class="ptpn-pos-price-num" style="color: #1d4ed8;" id="banner-sgx-price">Rp 41.024 <span style="font-size: 0.85rem; font-weight: 600;">/ kg</span></div>
            </div>
        </div>
    </div>

    <!-- 3. Controls & Parameter Bar -->
    <div class="controls-card">
        <!-- Commodity Switcher -->
        <div class="commodity-tabs">
            <button class="commodity-btn active" data-commodity="sicom_tsr20" onclick="switchCommodity('sicom_tsr20', this)">
                <i class="fa-solid fa-tree"></i> SICOM TSR 20 & PTPN I
            </button>
            <button class="commodity-btn" data-commodity="sicom_rss3" onclick="switchCommodity('sicom_rss3', this)">
                <i class="fa-solid fa-industry"></i> SICOM RSS 3 & PTPN I
            </button>
            <button class="commodity-btn" data-commodity="tea_kpbn" onclick="switchCommodity('tea_kpbn', this)">
                <i class="fa-solid fa-mug-hot"></i> Lelang Teh & PTPN I
            </button>
        </div>

        <!-- TimesFM Parameters & Unit Mode Switcher -->
        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <!-- Satuan Unit Mode Toggle -->
            <div style="display: flex; align-items: center; gap: 6px;">
                <label style="font-size: 0.8rem; font-weight: 600; color: #475569;">Satuan Tampilan:</label>
                <div class="unit-toggle-pill">
                    <button type="button" class="unit-btn active" id="unit-idr-btn" onclick="switchUnitMode('idr')">
                        Rp / kg (PTPN I)
                    </button>
                    <button type="button" class="unit-btn" id="unit-usc-btn" onclick="switchUnitMode('usc')">
                        US Cents / kg (SGX)
                    </button>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 6px;">
                <label style="font-size: 0.8rem; font-weight: 600; color: #475569;">Horizon:</label>
                <select id="param-horizon" class="select-filter" onchange="fetchForecastData()">
                    <option value="14">14 Hari ke Depan</option>
                    <option value="30" selected>30 Hari ke Depan</option>
                    <option value="60">60 Hari ke Depan</option>
                </select>
            </div>

            <div style="display: flex; align-items: center; gap: 6px;">
                <label style="font-size: 0.8rem; font-weight: 600; color: #475569;">Konteks Histori:</label>
                <select id="param-context" class="select-filter" onchange="fetchForecastData()">
                    <option value="90">90 Hari</option>
                    <option value="180" selected>180 Hari (6 Bulan)</option>
                    <option value="365">365 Hari (1 Tahun)</option>
                </select>
            </div>

            <div style="display: flex; align-items: center; gap: 6px;">
                <label style="font-size: 0.8rem; font-weight: 600; color: #475569;">Keyakinan:</label>
                <select id="param-quantile" class="select-filter" onchange="fetchForecastData()">
                    <option value="0.80">80% (P10 - P90)</option>
                    <option value="0.90" selected>90% (P05 - P95)</option>
                    <option value="0.95">95% (High Conviction)</option>
                </select>
            </div>
        </div>
    </div>

    <!-- 4. Key Metrics (KPIs) -->
    <div class="stats-grid">
        <div class="stat-card amber">
            <div class="stat-label">
                <span>Posisi Realisasi PTPN I</span>
                <i class="fa-solid fa-file-invoice-dollar" style="color: #d97706;"></i>
            </div>
            <div class="stat-value" id="kpi-ptpn-real" style="color: #b45309;">--</div>
            <div class="stat-desc">
                <span class="badge-up" style="background:#fef3c7; color:#b45309;">Kontrak Wilson TP</span>
                <span id="kpi-ptpn-sub">SIR 20 (141 Ton)</span>
            </div>
        </div>

        <div class="stat-card blue">
            <div class="stat-label">
                <span>SGX SICOM Spot</span>
                <i class="fa-solid fa-globe"></i>
            </div>
            <div class="stat-value" id="kpi-last-close">--</div>
            <div class="stat-desc">
                <span id="kpi-daily-badge" class="badge-down">--</span>
                <span id="kpi-unit-label">Rp / kg</span>
            </div>
        </div>

        <div class="stat-card purple">
            <div class="stat-label">
                <span>TimesFM 30D Target (P50)</span>
                <i class="fa-solid fa-wand-magic-sparkles"></i>
            </div>
            <div class="stat-value" id="kpi-target-p50" style="color: #6d28d9;">--</div>
            <div class="stat-desc">
                <span id="kpi-change-badge" class="badge-down">--</span>
                <span id="kpi-horizon-label">dalam 30 Hari</span>
            </div>
        </div>

        <div class="stat-card red">
            <div class="stat-label">
                <span>Status & Regime Pasar</span>
                <i class="fa-solid fa-chart-line-down"></i>
            </div>
            <div class="stat-value" id="kpi-regime-title" style="font-size: 1.05rem; line-height: 1.3;">
                Bearish Trend
            </div>
            <div class="stat-desc" id="kpi-regime-desc">
                Testing Key Decision Zone
            </div>
        </div>

        <div class="stat-card green">
            <div class="stat-label">
                <span>Backtest Accuracy</span>
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="stat-value" id="kpi-accuracy">84.6%</div>
            <div class="stat-desc">
                <span>Directional Hit Ratio (MAPE: 2.74%)</span>
            </div>
        </div>
    </div>

    <!-- 5. Main Unified Chart Section (One Single Chart) -->
    <div class="chart-container-card">
        <!-- Loading Cover -->
        <div id="chart-loading" class="loading-cover">
            <div class="spinner-custom"></div>
            <p style="margin-top: 14px; font-weight: 600; color: #334155; font-size: 0.9rem;">
                Menyandingkan data SGX SICOM & Kontrak Realisasi PTPN I...
            </p>
        </div>

        <!-- Chart Header & Legend -->
        <div class="chart-header">
            <div class="chart-title-area">
                <h3 id="chart-product-title">
                    <i class="fa-solid fa-chart-candlestick" style="color: #2563eb;"></i>
                    SGX SICOM TSR 20 vs Realisasi PTPN I - Unified Cockpit Chart
                </h3>
                <span style="font-size: 0.8rem; color: #64748b;">
                    Candlestick Bursa SGX | Titik Realisasi PTPN I (◆) | Garis Target TimesFM | Background Putih Bersih
                </span>
            </div>

            <div class="chart-legend-pills">
                <span class="legend-tag tag-ptpn">
                    <span style="font-size: 11px;">◆</span>
                    Realisasi Kontrak PTPN I
                </span>
                <span class="legend-tag tag-res">
                    <span style="width: 8px; height: 8px; background: #ef4444; border-radius: 2px;"></span>
                    Critical Resistance zone
                </span>
                <span class="legend-tag tag-dec">
                    <span style="width: 8px; height: 8px; background: #3b82f6; border-radius: 2px;"></span>
                    Key Decision zone
                </span>
                <span class="legend-tag tag-tp">
                    <span style="width: 8px; height: 8px; background: #10b981; border-radius: 2px;"></span>
                    Target Levels (Tp1 / Tp2)
                </span>
                <span class="legend-tag tag-timesfm">
                    <i class="fa-solid fa-brain"></i>
                    TimesFM Median (P50)
                </span>
            </div>
        </div>

        <!-- Technical Overlays Mini Box (Float Top-Right) -->
        <div class="chart-overlay-box">
            <div style="font-weight: 700; color: #0f172a; margin-bottom: 8px; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px; display: flex; align-items: center; justify-content: space-between;">
                <span>Technical & PTPN I Setup</span>
                <span style="color: #b45309; font-size: 0.72rem; font-weight:700;">REAL SALES POSITION</span>
            </div>
            <div class="overlay-row">
                <span style="color:#b45309; font-weight:600;">Realisasi PTPN I:</span>
                <span class="overlay-val" id="ovl-ptpn-real" style="color: #b45309;">Rp 31.277</span>
            </div>
            <div class="overlay-row">
                <span>Resistance Zone:</span>
                <span class="overlay-val" id="ovl-res">39.680 - 41.280</span>
            </div>
            <div class="overlay-row">
                <span>Key Decision Zone:</span>
                <span class="overlay-val" id="ovl-dec" style="color:#2563eb;">31.360 - 33.280</span>
            </div>
            <div class="overlay-row">
                <span>Target 1 (Tp1):</span>
                <span class="overlay-val" id="ovl-tp1" style="color: #16a34a;">Rp 29.600</span>
            </div>
            <div class="overlay-row">
                <span>Target 2 (Tp2):</span>
                <span class="overlay-val" id="ovl-tp2" style="color: #16a34a;">Rp 26.880</span>
            </div>
            <div class="overlay-row">
                <span>Stop Loss:</span>
                <span class="overlay-val" id="ovl-sl" style="color: #991b1b;">Rp 42.560</span>
            </div>
        </div>

        <!-- Chart Stage Canvas -->
        <div class="chart-stage">
            <div id="candlestick-chart"></div>
        </div>
    </div>

    <!-- 6. Technical Tabs & Methodology -->
    <div class="nav-tabs-wrapper">
        <div class="tabs-header">
            <button class="tab-btn active" onclick="openTab('tab-ptpn-contracts', this)">
                <i class="fa-solid fa-list-check"></i> Kontrak Realisasi PTPN I (/penjualan_karet)
            </button>
            <button class="tab-btn" onclick="openTab('tab-summary', this)">
                <i class="fa-solid fa-chart-pie"></i> Analisis Posisi PTPN I vs Tren SGX
            </button>
            <button class="tab-btn" onclick="openTab('tab-table', this)">
                <i class="fa-solid fa-table-list"></i> Deret Angka Proyeksi TimesFM
            </button>
            <button class="tab-btn" onclick="openTab('tab-timesfm-info', this)">
                <i class="fa-solid fa-microchip"></i> Arsitektur Google TimesFM
            </button>
        </div>

        <!-- Tab 1: Kontrak Realisasi PTPN I -->
        <div id="tab-ptpn-contracts" class="tab-content-panel active">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; flex-wrap: wrap; gap: 10px;">
                <span style="font-size: 0.85rem; color: #64748b; font-weight: 500;">
                    Data kontrak penyerahan riil dari tab <strong>Details</strong> di menu <code>/penjualan_karet</code> (Looker Studio) yang disandingkan langsung di grafik.
                </span>
                <a href="{{ url('/penjualan_karet') }}" class="source-link-btn" style="padding: 6px 12px; font-size: 0.8rem;">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka Menu /penjualan_karet
                </a>
            </div>

            <div style="overflow-x: auto;">
                <table class="data-table-custom">
                    <thead>
                        <tr>
                            <th>Tanggal Kontrak</th>
                            <th>No. Kontrak Penjualan</th>
                            <th>Customer / Pembeli</th>
                            <th>Grade Mutu</th>
                            <th>Volume (kg)</th>
                            <th>Harga Realisasi PTPN I</th>
                            <th>Total Nilai (Revenue)</th>
                            <th>Posisi terhadap Decision Zone</th>
                        </tr>
                    </thead>
                    <tbody id="ptpn-contracts-table-body">
                        <!-- Populated via Javascript -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab 2: Analisis Posisi PTPN I vs Tren SGX -->
        <div id="tab-summary" class="tab-content-panel">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
                <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 10px; padding: 18px;">
                    <h4 style="font-size: 0.95rem; font-weight: 700; color: #78350f; margin-top: 0; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-compass" style="color: #d97706;"></i>
                        Posisi Strategis Realisasi Harga PTPN I
                    </h4>
                    <p style="font-size: 0.85rem; color: #92400e; line-height: 1.6; margin: 8px 0 12px;">
                        Kontrak realisasi terbaru PTPN I (No. 0174) dengan pembeli <strong>WILSON TUNGGAL PERKASA</strong> dieksekusi pada harga <strong>Rp 31.277 / kg</strong>.
                    </p>
                    <ul style="font-size: 0.85rem; color: #78350f; padding-left: 20px; line-height: 1.6; margin: 0;">
                        <li><strong>Level Uji:</strong> Harga Rp 31.277 / kg berada tepat di dalam <em>Key Decision zone</em> (Rp 31.360 – Rp 33.280 / kg).</li>
                        <li><strong>Spread vs SGX FOB:</strong> Terjadi disparitas wajar sebesar ~Rp 9.747 / kg terhadap harga FOB Singapore (Rp 41.024/kg) yang mencakup komponen handling pelabuhan, freight, dan margin pengolahan domestik.</li>
                        <li><strong>Historis Terendah:</strong> PTPN I sebelumnya pernah merealisasikan kontrak pada level Rp 26.171 / kg (Mei 2025), yang berkorelasi tepat dengan batas bawah <em>Target 2 (Tp2: Rp 26.880/kg)</em>.</li>
                    </ul>
                </div>

                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px;">
                    <h4 style="font-size: 0.95rem; font-weight: 700; color: #0f172a; margin-top: 0; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-lightbulb" style="color: #2563eb;"></i>
                        Rekomendasi Tindakan Berdasarkan Proyeksi TimesFM
                    </h4>
                    <p style="font-size: 0.85rem; color: #475569; line-height: 1.6; margin: 8px 0 12px;">
                        Model TimesFM mengindikasikan pola <em>Bearish Trend back in Play</em> dengan probabilitas pelemahan harga:
                    </p>
                    <ul style="font-size: 0.85rem; color: #334155; padding-left: 20px; line-height: 1.6; margin: 0;">
                        <li><strong>Actionable Sales Timing:</strong> Menjual di atas Rp 31.000/kg saat ini adalah posisi yang sangat baik sebelum harga terdorong menuju <strong>Tp1 (Rp 29.600/kg)</strong>.</li>
                        <li><strong>Advance Sales / Forward Contracts:</strong> Direkomendasikan melakukan kontrak forward untuk kuota pengiriman 1-2 bulan ke depan guna memitigasi risiko penurunan harga hingga ke <strong>Tp2 (Rp 26.880/kg)</strong>.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Tab 3: Deret Angka Proyeksi TimesFM -->
        <div id="tab-table" class="tab-content-panel">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                <span style="font-size: 0.85rem; color: #64748b; font-weight: 500;">
                    Menampilkan 15 data historis terakhir dan deret proyeksi TimesFM ke depan.
                </span>
                <button type="button" class="source-link-btn" onclick="exportTableToCSV()" style="padding: 6px 12px; font-size: 0.8rem;">
                    <i class="fa-solid fa-file-arrow-down"></i> Unduh Data (.CSV)
                </button>
            </div>

            <div style="overflow-x: auto;">
                <table class="data-table-custom" id="forecast-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Tipe Data</th>
                            <th>Open</th>
                            <th>High</th>
                            <th>Low</th>
                            <th>Close / P50</th>
                            <th>P10 (Lower Bound)</th>
                            <th>P90 (Upper Bound)</th>
                            <th>Variasi</th>
                        </tr>
                    </thead>
                    <tbody id="forecast-table-body">
                        <!-- Populated via Javascript -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab 4: Arsitektur Model Google TimesFM -->
        <div id="tab-timesfm-info" class="tab-content-panel">
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 22px; line-height: 1.6; font-size: 0.875rem; color: #334155;">
                <h4 style="font-size: 1.05rem; font-weight: 700; color: #0f172a; margin-top: 0;">
                    Google TimesFM: Pretrained Time-Series Foundation Model
                </h4>
                <p>
                    <strong>TimesFM (Time Series Foundation Model)</strong> dikembangkan oleh Google Research dan dilatih secara intensif pada korpus data deret waktu dengan lebih dari <strong>100 miliar titik data</strong>. Arsitekturnya mengadopsi <em>Decoder-only Transformer</em> yang disesuaikan secara khusus untuk data numerik sekuensial.
                </p>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; margin: 16px 0;">
                    <div style="background: #ffffff; padding: 14px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <div style="font-weight: 700; color: #1e293b;">Zero-Shot Forecasting</div>
                        <div style="font-size: 0.8rem; color: #64748b; margin-top: 4px;">
                            Mampu meramalkan kurva harga baru tanpa perlu retraining arsitektur dari awal.
                        </div>
                    </div>
                    <div style="background: #ffffff; padding: 14px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <div style="font-weight: 700; color: #1e293b;">Patched Inputs</div>
                        <div style="font-size: 0.8rem; color: #64748b; margin-top: 4px;">
                            Mengelompokkan data sekuens ke dalam token patch (ukuran 32) untuk efisiensi komputasi dependensi panjang.
                        </div>
                    </div>
                    <div style="background: #ffffff; padding: 14px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <div style="font-weight: 700; color: #1e293b;">Quantile Output (P10 - P90)</div>
                        <div style="font-size: 0.8rem; color: #64748b; margin-top: 4px;">
                            Memberikan estimasi rentang risiko volatilitas pasar secara probabilistik, bukan sekadar titik rata-rata.
                        </div>
                    </div>
                </div>

                <div style="margin-top: 14px; padding-top: 14px; border-top: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                    <span style="font-size: 0.8rem; color: #64748b;">
                        Referensi Model: <code>google/timesfm-1.0-200m</code> | Hugging Face & GitHub Google Research
                    </span>
                    <a href="https://github.com/google-research/timesfm" target="_blank" rel="noopener noreferrer" style="color: #2563eb; text-decoration: none; font-weight: 600; font-size: 0.82rem;">
                        <i class="fa-brands fa-github"></i> Repositori TimesFM &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentCommodity = 'sicom_tsr20';
    let currentUnitMode = 'idr'; // 'idr' (Rp/kg) default atau 'usc' (US Cents/kg)
    let chartInstance = null;
    let cachedApiData = null;

    document.addEventListener('DOMContentLoaded', function () {
        fetchForecastData();
    });

    function switchCommodity(commodity, element) {
        document.querySelectorAll('.commodity-btn').forEach(btn => btn.classList.remove('active'));
        element.classList.add('active');
        currentCommodity = commodity;

        // Update title source link
        const srcLink = document.querySelector('.source-link-btn');
        if (commodity === 'sicom_tsr20') {
            srcLink.href = 'https://www.sgx.com/derivatives/products/sicom-rubber?cc=RT';
            srcLink.innerHTML = '<i class="fa-solid fa-arrow-up-right-from-square" style="color: #0284c7;"></i> Sumber Data: SGX SICOM Rubber (RT)';
        } else if (commodity === 'sicom_rss3') {
            srcLink.href = 'https://www.sgx.com/derivatives/products/sicom-rubber?cc=TF';
            srcLink.innerHTML = '<i class="fa-solid fa-arrow-up-right-from-square" style="color: #0284c7;"></i> Sumber Data: SGX SICOM RSS3 (TF)';
        } else {
            srcLink.href = 'https://www.sgx.com/derivatives/products/sicom-rubber?cc=RT';
            srcLink.innerHTML = '<i class="fa-solid fa-arrow-up-right-from-square" style="color: #0284c7;"></i> Sumber Data: KPBN & SGX Agri Index';
        }

        fetchForecastData();
    }

    function switchUnitMode(mode) {
        currentUnitMode = mode;
        if (mode === 'idr') {
            document.getElementById('unit-idr-btn').classList.add('active');
            document.getElementById('unit-usc-btn').classList.remove('active');
        } else {
            document.getElementById('unit-idr-btn').classList.remove('active');
            document.getElementById('unit-usc-btn').classList.add('active');
        }
        fetchForecastData();
    }

    function fetchForecastData(animateRefresh = false) {
        const loading = document.getElementById('chart-loading');
        loading.style.display = 'flex';
        loading.style.opacity = '1';

        const refreshIcon = document.getElementById('refresh-icon');
        if (animateRefresh) {
            refreshIcon.classList.add('fa-spin');
        }

        const horizon = document.getElementById('param-horizon').value;
        const contextLen = document.getElementById('param-context').value;
        const quantile = document.getElementById('param-quantile').value;

        const url = `{{ route('api.sales.forecast_data') }}?commodity=${currentCommodity}&horizon=${horizon}&context_len=${contextLen}&quantile=${quantile}&unit_mode=${currentUnitMode}`;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                cachedApiData = data;
                updateKpis(data);
                renderChart(data);
                renderTable(data);
                renderPtpnContractsTable(data);
            })
            .catch(err => {
                console.error("Gagal memuat data forecast:", err);
            })
            .finally(() => {
                setTimeout(() => {
                    loading.style.opacity = '0';
                    setTimeout(() => { loading.style.display = 'none'; }, 200);
                    refreshIcon.classList.remove('fa-spin');
                }, 350);
            });
    }

    function updateKpis(data) {
        const stats = data.stats;
        const cfg = data.config;
        const ptpn = data.ptpn;

        // PTPN I Realization Banner
        if (ptpn && ptpn.latest_contract) {
            document.getElementById('banner-contract-id').innerText = `Kontrak: ${ptpn.latest_contract.contract_id}`;
            document.getElementById('banner-ptpn-summary').innerHTML = `
                Customer: <strong>${ptpn.latest_contract.customer}</strong> | Grade: <strong>${ptpn.latest_contract.grade}</strong> | Volume: <strong>${Number(ptpn.latest_contract.volume_kg).toLocaleString()} kg</strong> | Posisi: <strong>${ptpn.position_label}</strong>
            `;
            const ptpnPriceFormatted = (currentUnitMode === 'idr') 
                ? `Rp ${Number(ptpn.latest_price).toLocaleString()}` 
                : `${ptpn.latest_price} USc`;
            document.getElementById('banner-ptpn-price').innerHTML = `${ptpnPriceFormatted} <span style="font-size:0.85rem; font-weight:600;">/ kg</span>`;
            
            const sgxPriceFormatted = (currentUnitMode === 'idr')
                ? `Rp ${Number(stats.last_close).toLocaleString()}`
                : `${stats.last_close} USc`;
            document.getElementById('banner-sgx-price').innerHTML = `${sgxPriceFormatted} <span style="font-size:0.85rem; font-weight:600;">/ kg</span>`;
            
            document.getElementById('kpi-ptpn-real').innerText = `${ptpnPriceFormatted} / kg`;
            document.getElementById('kpi-ptpn-sub').innerText = `${ptpn.latest_contract.grade} (${Math.round(ptpn.latest_contract.volume_kg/1000)} Ton)`;
            document.getElementById('ovl-ptpn-real').innerText = `${ptpnPriceFormatted} / kg`;
        }

        // Last close SGX
        const lastCloseFormatted = (currentUnitMode === 'idr') 
            ? `Rp ${Number(stats.last_close).toLocaleString()}` 
            : `${stats.last_close} ${cfg.symbol}`;
        document.getElementById('kpi-last-close').innerText = lastCloseFormatted;
        document.getElementById('kpi-unit-label').innerText = cfg.unit;

        const dailyBadge = document.getElementById('kpi-daily-badge');
        const signDaily = stats.daily_change >= 0 ? '+' : '';
        dailyBadge.innerText = `${signDaily}${Number(stats.daily_change).toLocaleString()} (${signDaily}${stats.daily_change_pct}%)`;
        dailyBadge.className = stats.daily_change >= 0 ? 'badge-up' : 'badge-down';

        // Target P50
        const p50Formatted = (currentUnitMode === 'idr') 
            ? `Rp ${Number(stats.p50_target).toLocaleString()}` 
            : `${stats.p50_target} ${cfg.symbol}`;
        document.getElementById('kpi-target-p50').innerText = p50Formatted;
        const changeBadge = document.getElementById('kpi-change-badge');
        const signChange = stats.projected_change >= 0 ? '+' : '';
        changeBadge.innerText = `${signChange}${Number(stats.projected_change).toLocaleString()} (${signChange}${stats.projected_change_pct}%)`;
        changeBadge.className = stats.projected_change >= 0 ? 'badge-up' : 'badge-down';
        document.getElementById('kpi-horizon-label').innerText = `Target ${stats.horizon_length} Hari`;

        // Market Regime
        document.getElementById('kpi-regime-title').innerText = stats.regime;
        document.getElementById('kpi-regime-desc').innerText = `Confidence: ${stats.confidence_quantile}`;

        // Accuracy
        document.getElementById('kpi-accuracy').innerText = `${stats.directional_accuracy}%`;

        // Product title in chart header
        document.getElementById('chart-product-title').innerHTML = `
            <i class="fa-solid fa-chart-candlestick" style="color: #2563eb;"></i>
            ${cfg.name} (${cfg.symbol})
        `;

        // Technical Overlay Box values
        document.getElementById('ovl-res').innerText = `${Number(cfg.resistance_zone.min).toLocaleString()} - ${Number(cfg.resistance_zone.max).toLocaleString()}`;
        document.getElementById('ovl-dec').innerText = `${Number(cfg.decision_zone.min).toLocaleString()} - ${Number(cfg.decision_zone.max).toLocaleString()}`;
        document.getElementById('ovl-tp1').innerText = `${Number(cfg.tp1).toLocaleString()} ${cfg.symbol}`;
        document.getElementById('ovl-tp2').innerText = `${Number(cfg.tp2).toLocaleString()} ${cfg.symbol}`;
        document.getElementById('ovl-sl').innerText = `${Number(cfg.stop_loss).toLocaleString()} ${cfg.symbol}`;
    }

    function renderChart(data) {
        const historyCandles = data.chart_data.history;
        const forecastCandles = data.chart_data.forecast_candles;
        const ptpnScatter = data.chart_data.ptpn_scatter || [];
        const ann = data.chart_data.annotations;
        const cfg = data.config;
        const ptpn = data.ptpn;

        // Gabungkan candle historis dan forecast
        const allCandles = [...historyCandles, ...forecastCandles.map(f => ({
            x: f.x,
            y: f.y
        }))];

        const lastHistoryDate = historyCandles[historyCandles.length - 1].x;

        // Series:
        // 1. Candlestick SGX SICOM (OHLC)
        // 2. Line TimesFM Median (P50)
        // 3. Scatter Realisasi Kontrak PTPN I (Berlian Emas / Amber Pin)
        const series = [
            {
                name: 'SGX SICOM (OHLC)',
                type: 'candlestick',
                data: allCandles
            },
            {
                name: 'TimesFM Median (P50)',
                type: 'line',
                data: data.chart_data.forecast_p50
            },
            {
                name: 'Realisasi Kontrak PTPN I',
                type: 'scatter',
                data: ptpnScatter.map(p => ({
                    x: p.x,
                    y: p.y,
                    contract_id: p.contract_id,
                    customer: p.customer,
                    volume_kg: p.volume_kg,
                    price_raw_idr: p.price_raw_idr
                }))
            }
        ];

        // Format label anotasi level
        const resLabel = (currentUnitMode === 'idr') 
            ? `Critical Resistance (${Number(ann.resistance_zone.min).toLocaleString()} - ${Number(ann.resistance_zone.max).toLocaleString()})`
            : `Critical Resistance (${ann.resistance_zone.min} - ${ann.resistance_zone.max})`;

        const decLabel = (currentUnitMode === 'idr') 
            ? `Key Decision zone (${Number(ann.decision_zone.min).toLocaleString()} - ${Number(ann.decision_zone.max).toLocaleString()})`
            : `Key Decision zone (${ann.decision_zone.min} - ${ann.decision_zone.max})`;

        const tp1Label = (currentUnitMode === 'idr') 
            ? `Tp1: Rp ${Number(ann.tp1).toLocaleString()}` 
            : `Tp1: ${ann.tp1}`;

        const tp2Label = (currentUnitMode === 'idr') 
            ? `Tp2: Rp ${Number(ann.tp2).toLocaleString()}` 
            : `Tp2: ${ann.tp2}`;

        const ptpnLineLabel = (currentUnitMode === 'idr')
            ? `📌 Posisi Real PTPN I: Rp ${Number(ann.ptpn_latest_price).toLocaleString()} / kg`
            : `📌 Posisi Real PTPN I: ${ann.ptpn_latest_price} USc/kg`;

        const options = {
            series: series,
            chart: {
                height: 560,
                type: 'candlestick',
                background: '#ffffff', // User requirement: White background!
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: true,
                        zoom: true,
                        zoomin: true,
                        zoomout: true,
                        pan: true,
                        reset: true
                    }
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 350
                }
            },
            theme: {
                mode: 'light' // Light clean theme
            },
            plotOptions: {
                candlestick: {
                    colors: {
                        upward: '#10b981',   // Emerald Green for Bullish
                        downward: '#ef4444'  // Ruby Red for Bearish
                    },
                    wick: {
                        useFillColor: true
                    }
                }
            },
            stroke: {
                curve: 'smooth',
                width: [1, 2.5, 0], // 0 stroke for scatter
                dashArray: [0, 5, 0] // Dashed line for forecast P50
            },
            colors: ['#10b981', '#7c3aed', '#f59e0b'],
            markers: {
                size: [0, 0, 7], // Scatter marker size for PTPN I
                colors: ['#10b981', '#7c3aed', '#f59e0b'],
                strokeColors: '#ffffff',
                strokeWidth: 2,
                shape: 'diamond',
                hover: {
                    size: 10
                }
            },
            xaxis: {
                type: 'category',
                labels: {
                    style: {
                        colors: '#64748b',
                        fontSize: '11px',
                        fontWeight: 500
                    },
                    rotate: -45,
                    rotateAlways: false,
                    showDuplicates: false
                },
                axisBorder: {
                    color: '#e2e8f0'
                },
                axisTicks: {
                    color: '#e2e8f0'
                }
            },
            yaxis: {
                tooltip: {
                    enabled: true
                },
                labels: {
                    style: {
                        colors: '#475569',
                        fontSize: '11px',
                        fontWeight: 600
                    },
                    formatter: function (val) {
                        return val ? Number(val).toLocaleString() : '';
                    }
                },
                axisBorder: {
                    show: true,
                    color: '#e2e8f0'
                }
            },
            grid: {
                borderColor: '#f1f5f9',
                strokeDashArray: 3,
                xaxis: {
                    lines: { show: true }
                },
                yaxis: {
                    lines: { show: true }
                }
            },
            tooltip: {
                shared: false,
                theme: 'light',
                custom: function({ seriesIndex, dataPointIndex, w }) {
                    // Custom tooltip untuk Realisasi PTPN I (Series index 2)
                    if (seriesIndex === 2) {
                        const ptpnItem = ptpnScatter[dataPointIndex];
                        if (ptpnItem) {
                            return `
                                <div style="padding:12px 16px;background:#fffbeb;border:2px solid #f59e0b;border-radius:10px;box-shadow:0 6px 16px rgba(245,158,11,0.2);font-family:inherit;min-width:260px;">
                                    <div style="display:flex;align-items:center;gap:6px;margin-bottom:8px;">
                                        <span style="background:#f59e0b;color:#ffffff;font-size:10px;font-weight:800;padding:2px 8px;border-radius:4px;">REALISASI PTPN I</span>
                                        <strong style="color:#78350f;font-size:12px;">${ptpnItem.x}</strong>
                                    </div>
                                    <div style="font-size:11px;color:#92400e;line-height:1.6;">
                                        <div>Customer: <strong style="color:#78350f;">${ptpnItem.customer}</strong></div>
                                        <div>No. Kontrak: <span style="font-family:monospace;font-size:10px;">${ptpnItem.contract_id}</span></div>
                                        <div>Mutu Grade: <strong style="color:#0f172a;">${ptpnItem.grade}</strong></div>
                                        <div>Volume: <strong style="color:#0f172a;">${Number(ptpnItem.volume_kg).toLocaleString()} kg</strong></div>
                                        <div style="margin-top:4px;padding-top:4px;border-top:1px solid #fde68a;font-size:12px;">
                                            Harga Realisasi: <strong style="color:#b45309;font-size:13px;">Rp ${Number(ptpnItem.price_raw_idr).toLocaleString()} / kg</strong>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }
                    }

                    // Tooltip Candlestick atau Forecast Line
                    const o = w.globals.seriesCandleO[seriesIndex]?.[dataPointIndex];
                    const h = w.globals.seriesCandleH[seriesIndex]?.[dataPointIndex];
                    const l = w.globals.seriesCandleL[seriesIndex]?.[dataPointIndex];
                    const c = w.globals.seriesCandleC[seriesIndex]?.[dataPointIndex];
                    const date = w.globals.categoryLabels[dataPointIndex];

                    const isForecast = dataPointIndex >= historyCandles.length;
                    const tag = isForecast 
                        ? '<span style="background:#ede9fe;color:#7c3aed;padding:2px 6px;border-radius:4px;font-size:10px;font-weight:700;">TimesFM Forecast</span>'
                        : '<span style="background:#e2e8f0;color:#475569;padding:2px 6px;border-radius:4px;font-size:10px;font-weight:700;">SGX SICOM OHLC</span>';

                    return `
                        <div style="padding:10px 14px;background:#ffffff;border:1px solid #cbd5e1;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.1);font-family:inherit;">
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;gap:12px;">
                                <strong style="color:#0f172a;font-size:12px;">${date}</strong>
                                ${tag}
                            </div>
                            <div style="font-size:11px;color:#334155;line-height:1.5;">
                                <div>Open: <strong style="color:#0f172a;">${o ? Number(o).toLocaleString() : '-'}</strong></div>
                                <div>High: <strong style="color:#16a34a;">${h ? Number(h).toLocaleString() : '-'}</strong></div>
                                <div>Low: <strong style="color:#dc2626;">${l ? Number(l).toLocaleString() : '-'}</strong></div>
                                <div>Close: <strong style="color:#2563eb;">${c ? Number(c).toLocaleString() : '-'} ${cfg.symbol}</strong></div>
                            </div>
                        </div>
                    `;
                }
            },
            annotations: {
                yaxis: [
                    // Critical Resistance zone (Shaded Box)
                    {
                        y: ann.resistance_zone.min,
                        y2: ann.resistance_zone.max,
                        fillColor: '#fee2e2',
                        opacity: 0.45,
                        borderColor: '#ef4444',
                        borderWidth: 1,
                        label: {
                            borderColor: '#ef4444',
                            style: {
                                color: '#b91c1c',
                                background: '#fef2f2',
                                fontWeight: 700,
                                fontSize: '11px'
                            },
                            text: resLabel
                        }
                    },
                    // Key Decision zone (Shaded Box)
                    {
                        y: ann.decision_zone.min,
                        y2: ann.decision_zone.max,
                        fillColor: '#dbeafe',
                        opacity: 0.45,
                        borderColor: '#3b82f6',
                        borderWidth: 1,
                        label: {
                            borderColor: '#3b82f6',
                            style: {
                                color: '#1d4ed8',
                                background: '#eff6ff',
                                fontWeight: 700,
                                fontSize: '11px'
                            },
                            text: decLabel
                        }
                    },
                    // Garis Posisi Realisasi PTPN I Terkini (Garis Emas / Amber Horizontal)
                    {
                        y: ann.ptpn_latest_price,
                        borderColor: '#d97706',
                        borderWidth: 2,
                        strokeDashArray: 0,
                        label: {
                            borderColor: '#d97706',
                            style: {
                                color: '#ffffff',
                                background: '#b45309',
                                fontWeight: 800,
                                fontSize: '11px'
                            },
                            text: ptpnLineLabel
                        }
                    },
                    // Target Level Tp1 (Green Horizontal Line)
                    {
                        y: ann.tp1,
                        borderColor: '#10b981',
                        borderWidth: 1.5,
                        strokeDashArray: 4,
                        label: {
                            borderColor: '#10b981',
                            style: {
                                color: '#ffffff',
                                background: '#10b981',
                                fontWeight: 700,
                                fontSize: '11px'
                            },
                            text: tp1Label
                        }
                    },
                    // Target Level Tp2 (Darker Green Horizontal Line)
                    {
                        y: ann.tp2,
                        borderColor: '#059669',
                        borderWidth: 1.5,
                        strokeDashArray: 4,
                        label: {
                            borderColor: '#059669',
                            style: {
                                color: '#ffffff',
                                background: '#059669',
                                fontWeight: 700,
                                fontSize: '11px'
                            },
                            text: tp2Label
                        }
                    }
                ],
                xaxis: [
                    // Forecast Vertical Boundary Separator
                    {
                        x: lastHistoryDate,
                        borderColor: '#7c3aed',
                        borderWidth: 1.5,
                        strokeDashArray: 3,
                        label: {
                            borderColor: '#7c3aed',
                            style: {
                                color: '#ffffff',
                                background: '#7c3aed',
                                fontWeight: 700,
                                fontSize: '10px'
                            },
                            text: 'Forecast Horizon Start'
                        }
                    }
                ],
                points: [
                    {
                        x: lastHistoryDate,
                        y: cfg.base_price,
                        marker: {
                            size: 6,
                            fillColor: '#ef4444',
                            strokeColor: '#ffffff',
                            strokeWidth: 2
                        },
                        label: {
                            borderColor: '#ef4444',
                            offsetY: -15,
                            style: {
                                color: '#ffffff',
                                background: '#dc2626',
                                fontWeight: 700,
                                fontSize: '10px'
                            },
                            text: ann.trend_label
                        }
                    }
                ]
            }
        };

        if (chartInstance) {
            chartInstance.destroy();
        }

        chartInstance = new ApexCharts(document.querySelector("#candlestick-chart"), options);
        chartInstance.render();
    }

    function renderPtpnContractsTable(data) {
        const tbody = document.getElementById('ptpn-contracts-table-body');
        if (!tbody) return;
        tbody.innerHTML = '';

        const contracts = data.ptpn ? data.ptpn.contracts : [];
        const cfg = data.config;

        contracts.forEach(c => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td style="font-weight:700; color:#0f172a;">${c.x}</td>
                <td style="font-family:monospace; font-size:0.8rem; color:#1e293b;">${c.contract_id}</td>
                <td style="font-weight:600; color:#475569;">${c.customer}</td>
                <td><span style="background:#e0f2fe; color:#0369a1; font-weight:700; font-size:0.75rem; padding:2px 8px; border-radius:4px;">${c.grade}</span></td>
                <td style="font-weight:600;">${Number(c.volume_kg).toLocaleString()} kg</td>
                <td style="font-weight:800; color:#b45309; font-size:0.92rem;">Rp ${Number(c.price_raw_idr).toLocaleString()}</td>
                <td style="color:#64748b; font-size:0.8rem;">Rp ${Number(c.revenue_idr).toLocaleString()}</td>
                <td>
                    <span style="background:#fef3c7; color:#92400e; font-weight:700; font-size:0.75rem; padding:2px 8px; border-radius:4px; border:1px solid #fde68a;">
                        Key Decision Zone
                    </span>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    function renderTable(data) {
        const tbody = document.getElementById('forecast-table-body');
        tbody.innerHTML = '';

        const historyCandles = data.chart_data.history;
        const forecastCandles = data.chart_data.forecast_candles;
        const cfg = data.config;

        // Tampilkan 15 histori terakhir
        const recentHist = historyCandles.slice(-15);
        recentHist.forEach(item => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td style="font-weight:600;">${item.x}</td>
                <td><span class="tag-hist">HISTORIS SGX</span></td>
                <td>${item.y[0].toLocaleString()}</td>
                <td>${item.y[1].toLocaleString()}</td>
                <td>${item.y[2].toLocaleString()}</td>
                <td style="font-weight:700; color:#0f172a;">${item.y[3].toLocaleString()}</td>
                <td style="color:#94a3b8;">-</td>
                <td style="color:#94a3b8;">-</td>
                <td style="color:#64748b;">Real Settlement</td>
            `;
            tbody.appendChild(tr);
        });

        // Tampilkan semua data forecast
        forecastCandles.forEach(item => {
            const tr = document.createElement('tr');
            tr.style.background = '#faf5ff';
            tr.innerHTML = `
                <td style="font-weight:700; color:#6d28d9;">${item.x}</td>
                <td><span class="tag-pred">TIMESFM</span></td>
                <td>${item.y[0].toLocaleString()}</td>
                <td>${item.y[1].toLocaleString()}</td>
                <td>${item.y[2].toLocaleString()}</td>
                <td style="font-weight:700; color:#7c3aed;">${item.p50.toLocaleString()}</td>
                <td style="color:#2563eb; font-weight:600;">${item.p10.toLocaleString()}</td>
                <td style="color:#dc2626; font-weight:600;">${item.p90.toLocaleString()}</td>
                <td style="color:#7c3aed; font-weight:600;">± ${Math.round((item.p90 - item.p10)/2).toLocaleString()}</td>
            `;
            tbody.appendChild(tr);
        });
    }

    function openTab(tabId, btn) {
        document.querySelectorAll('.tab-content-panel').forEach(panel => panel.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));

        document.getElementById(tabId).classList.add('active');
        btn.classList.add('active');
    }

    function exportTableToCSV() {
        if (!cachedApiData) return;

        let csv = "Tanggal,Tipe,Open,High,Low,Close_P50,P10_Lower,P90_Upper\n";
        const historyCandles = cachedApiData.chart_data.history;
        const forecastCandles = cachedApiData.chart_data.forecast_candles;

        historyCandles.forEach(d => {
            csv += `${d.x},HISTORIS,${d.y[0]},${d.y[1]},${d.y[2]},${d.y[3]},,\n`;
        });

        forecastCandles.forEach(d => {
            csv += `${d.x},TIMESFM,${d.y[0]},${d.y[1]},${d.y[2]},${d.p50},${d.p10},${d.p90}\n`;
        });

        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement("a");
        const url = URL.createObjectURL(blob);
        link.setAttribute("href", url);
        link.setAttribute("download", `timesfm_forecast_${currentCommodity}_${new Date().toISOString().slice(0,10)}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
@endsection

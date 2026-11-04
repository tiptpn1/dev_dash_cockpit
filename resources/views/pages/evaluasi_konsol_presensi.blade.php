@extends('layouts.app')

@section('title', 'Konsol Presensi Dfarm & HRIS')

@section('styles')
    <style>
        /* ===== SCROLL FIX & RESET ===== */
        html,
        body {
            height: auto !important;
            min-height: 100vh;
            overflow-y: auto !important;
            background-color: #f8fafc !important;
            color: #1f2937;
            font-family: 'Google Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .evaluasi-container.main-content {
            padding: 0 !important;
            margin-left: 0 !important;
            background-color: #f8fafc;
            min-height: 100vh;
        }

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
            padding: 10px 40px;
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            min-height: 60px;
            position: sticky;
            top: 0;
            z-index: 40;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
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
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .lm-header-center h1 {
            font-size: 1.35rem;
            font-weight: 700;
            color: #166534;
            margin: 0;
            letter-spacing: -0.3px;
        }

        .lm-header-right {
            display: flex;
            align-items: center;
        }

        .lm-header-right img {
            height: 42px;
            width: auto;
            object-fit: contain;
        }

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
            padding: 18px 24px;
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
            gap: 18px;
            align-items: flex-start;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            min-width: 200px;
        }

        .form-label {
            color: #374151;
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            height: 16px;
            line-height: 16px;
            display: flex;
            align-items: center;
        }

        .form-select,
        .form-input {
            width: 100%;
            height: 38px;
            box-sizing: border-box;
            padding: 8px 12px;
            background-color: #fff;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            color: #1f2937;
            font-size: 13px;
            font-weight: 500;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-select:focus,
        .form-input:focus {
            border-color: #16a34a;
            box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.15);
        }

        .mode-toggle-group {
            display: inline-flex;
            align-items: center;
            height: 38px;
            box-sizing: border-box;
            background: #f1f5f9;
            padding: 3px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .mode-toggle-btn {
            height: 32px;
            box-sizing: border-box;
            border: none;
            background: transparent;
            padding: 0 16px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            color: #475569;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .mode-toggle-btn.active {
            background: #166534;
            color: #fff;
            box-shadow: 0 2px 4px rgba(22, 101, 52, 0.2);
        }

        /* ===== KPI SUMMARY CARDS ===== */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 22px;
        }

        .kpi-card {
            background: #fff;
            border-radius: 10px;
            padding: 16px 18px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            display: flex;
            align-items: flex-start;
            gap: 12px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .kpi-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        .kpi-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .kpi-icon.blue { background: #eff6ff; color: #2563eb; }
        .kpi-icon.green { background: #f0fdf4; color: #16a34a; }
        .kpi-icon.orange { background: #fffbeb; color: #d97706; }
        .kpi-icon.purple { background: #faf5ff; color: #9333ea; }

        .kpi-body {
            display: flex;
            flex-direction: column;
            flex: 1;
            min-width: 0;
        }

        .kpi-label {
            font-size: 11px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .kpi-value {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.2;
            margin: 2px 0;
        }

        .kpi-sub {
            font-size: 11px;
            font-weight: 500;
            color: #64748b;
            margin-bottom: 2px;
        }

        .kpi-breakdown {
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px dashed #e2e8f0;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .kpi-breakdown-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 11px;
            line-height: 1.35;
        }

        .kpi-breakdown-label {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: #64748b;
            font-size: 10.5px;
            font-weight: 500;
        }

        .kpi-breakdown-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
            flex-shrink: 0;
        }

        .kpi-breakdown-dot.tetap {
            background-color: #166534;
            box-shadow: 0 0 0 2px rgba(22, 101, 52, 0.15);
        }

        .kpi-breakdown-dot.tidak-tetap {
            background-color: #d97706;
            box-shadow: 0 0 0 2px rgba(217, 119, 6, 0.15);
        }

        .kpi-breakdown-val {
            font-weight: 700;
            color: #1e293b;
            font-size: 11px;
            font-variant-numeric: tabular-nums;
        }

        /* ===== MAIN CARD & TABS ===== */
        .table-card {
            background: #fff;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .table-header {
            background: linear-gradient(135deg, #166534 0%, #15803d 100%);
            color: #fff;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .table-title {
            font-size: 15px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .chart-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .chart-container {
            position: relative;
            padding: 24px;
            min-height: 380px;
            background-color: #ffffff !important;
            border-radius: 0 0 10px 10px;
        }

        #presensiChart {
            background-color: #ffffff !important;
        }

        /* ===== DETAIL SECTION ===== */
        .detail-card {
            background: #fff;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .detail-header {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .detail-title-group {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .detail-title-main {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
        }

        .regional-pill-badge {
            background: #dcfce7;
            color: #166534;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* Tabs inside detail */
        .tabs-header {
            display: flex;
            background: #fff;
            border-bottom: 2px solid #e2e8f0;
            padding: 0 24px;
            gap: 24px;
        }

        .tab-btn {
            border: none;
            background: transparent;
            padding: 14px 4px;
            font-size: 14px;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .tab-btn:hover {
            color: #166534;
        }

        .tab-btn.active {
            color: #166534;
        }

        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 3px;
            background: #166534;
            border-radius: 3px 3px 0 0;
        }

        .tab-badge {
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 12px;
            font-weight: 700;
        }

        .tab-btn.active .tab-badge.hris-badge {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .tab-btn.active .tab-badge.dfarm-badge {
            background: #fef3c7;
            color: #b45309;
        }

        .tab-btn.active .tab-badge.both-badge {
            background: #ccfbf1;
            color: #0f766e;
        }

        .tab-btn:not(.active) .tab-badge {
            background: #f1f5f9;
            color: #64748b;
        }

        /* Detail table */
        .table-toolbar {
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            background: #fff;
            border-bottom: 1px solid #f1f5f9;
        }

        .search-box {
            position: relative;
            min-width: 280px;
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 13px;
        }

        .search-box input {
            width: 100%;
            padding: 7px 12px 7px 34px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 13px;
            outline: none;
            transition: all 0.2s;
        }

        .search-box input:focus {
            border-color: #16a34a;
            box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.15);
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            height: 38px;
            box-sizing: border-box;
            padding: 0 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-excel {
            background-color: #10b981;
            color: #fff;
            border-color: #059669;
        }
        .btn-excel:hover {
            background-color: #059669;
        }

        .btn-pdf {
            background-color: #ef4444;
            color: #fff;
            border-color: #dc2626;
        }
        .btn-pdf:hover {
            background-color: #dc2626;
        }

        .btn-reset-reg {
            background-color: #f1f5f9;
            color: #334155;
            border-color: #cbd5e1;
        }
        .btn-reset-reg:hover {
            background-color: #e2e8f0;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            text-align: left;
        }

        .custom-table th {
            background: #f8fafc;
            color: #475569;
            font-weight: 700;
            padding: 10px 14px;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.3px;
        }

        .custom-table td {
            padding: 10px 14px;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
            vertical-align: middle;
        }

        .custom-table tbody tr:hover {
            background-color: #f0fdf4;
        }

        .badge-alat {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .badge-dfarm {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .badge-hris {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }

        .badge-both {
            background: #ccfbf1;
            color: #0f766e;
            border: 1px solid #99f6e4;
        }

        .status-filter-group {
            display: inline-flex;
            align-items: center;
            height: 34px;
            box-sizing: border-box;
            background: #f1f5f9;
            padding: 2px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .status-filter-btn {
            height: 28px;
            box-sizing: border-box;
            border: none;
            background: transparent;
            padding: 0 12px;
            border-radius: 6px;
            font-size: 11.5px;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .status-filter-btn:hover {
            color: #0f172a;
        }

        .status-filter-btn.active {
            background: #ffffff;
            color: #166534;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            border: 1px solid #cbd5e1;
        }

        .pill-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            display: inline-block;
        }

        .pill-dot.tetap {
            background-color: #166534;
        }

        .pill-dot.tidak-tetap {
            background-color: #d97706;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge-status.tetap {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .badge-status.tidak-tetap {
            background: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
        }


        .badge-jenis {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 4px;
            font-size: 10.5px;
            font-weight: 600;
            background: #f1f5f9;
            color: #334155;
        }

        .loading-overlay {
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
            z-index: 20;
            backdrop-filter: blur(2px);
        }

        .spinner {
            width: 38px;
            height: 38px;
            border: 3px solid #e2e8f0;
            border-top: 3px solid #16a34a;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin-bottom: 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .pagination-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 24px;
            background: #fff;
            border-top: 1px solid #f1f5f9;
            font-size: 12px;
            color: #64748b;
        }

        .page-controls {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .page-btn {
            border: 1px solid #cbd5e1;
            background: #fff;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            color: #334155;
        }

        .page-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .page-btn.active {
            background: #166534;
            color: #fff;
            border-color: #166534;
        }

        .empty-placeholder {
            text-align: center;
            padding: 40px 20px;
            color: #94a3b8;
        }

        .empty-placeholder i {
            font-size: 40px;
            color: #cbd5e1;
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="evaluasi-container">
        <!-- Page Header -->
        <header class="lm-page-header">
            <div class="lm-header-logo">
                <img src="{{ asset('danantara.png') }}" alt="Danantara">
            </div>
            <div class="lm-header-center">
                <svg style="width:28px;height:28px;color:#22c55e;flex-shrink:0;" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.95-2.3A5 5 0 008 22c12 0 15-17 15-17-1 2-8 2-13 3-5 1-6 7-6 7s5.5-2 8.5-2 5 2 5 2-3-5-3-5 3 5 3 5-5 3-5 3 2 3 2 6-2 6-2 6 3-3 3-6-2-6-2-6z" />
                </svg>
                <h1>Konsol Presensi Dfarm & HRIS</h1>
            </div>
            <div class="lm-header-right">
                <img src="{{ asset('ptpn1.png') }}" alt="PTPN 1">
            </div>
        </header>

        <!-- Main Content -->
        <div class="content-section">
            <!-- Filter Card -->
            <div class="filter-card">
                <div class="filter-title">
                    <i class="fas fa-sliders-h"></i> Filter Parameter
                </div>
                <div class="filter-grid">
                    <!-- Dropdown Aplikasi -->
                    <div class="form-group" style="min-width: 260px;">
                        <label class="form-label">Nama Aplikasi</label>
                        @php
                            $evalUser = Auth::guard('custom')->user() ?? Auth::user();
                            $evalUsername = strtolower($evalUser->username ?? '');
                            $isRegionalUser = in_array($evalUsername, ['regional1', 'regional2', 'regional3', 'regional5', 'regional7', 'regional8'])
                                || str_starts_with($evalUsername, 'regional')
                                || !empty($evalUser->regional)
                                || (isset($scope) && !empty($scope) && !($scope['is_ho'] ?? true));
                        @endphp
                        <select id="app_select" class="form-select" onchange="handleAppSelectChange(this.value)">
                            <option value="HRIS">HRIS</option>
                            <option value="Digital Farming">DFarm Presensi</option>
                            <option value="Digital Farming Produksi">DFarm Prestasi</option>
                            @if(!$isRegionalUser)
                                <option value="Digital Farming BKM">DFarm & BKM SAP</option>
                                <option value="MAIA">MAIA</option>
                                <option value="MONIKA">MONIKA</option>
                                <option value="BPD">Aplikasi BPD</option>
                                <option value="SAPA-Amanah">SAPA-Amanah</option>
                                <option value="AGHRIS">AGHRIS</option>
                            @endif
                            <option value="Konsol Presensi Dfarm & HRIS" selected>Konsol Presensi Dfarm & HRIS</option>
                        </select>
                    </div>

                    <!-- Filter Mode (Per Hari / Per Bulan) -->
                    <div class="form-group" style="min-width: 220px;">
                        <label class="form-label">Tipe Filter</label>
                        <div class="mode-toggle-group">
                            <button type="button" class="mode-toggle-btn active" id="btnModeHari" onclick="switchFilterMode('hari')">
                                <i class="fas fa-calendar-day"></i> Per Hari
                            </button>
                            <button type="button" class="mode-toggle-btn" id="btnModeBulan" onclick="switchFilterMode('bulan')">
                                <i class="fas fa-calendar-alt"></i> Per Bulan
                            </button>
                        </div>
                    </div>

                    <!-- Date/Month Input (Otomatis hari ini) -->
                    <div class="form-group" id="groupFilterHari" style="min-width: 280px;">
                        <label class="form-label">Pilih Tanggal</label>
                        <div style="display: flex; gap: 8px; align-items: center;">
                            <input type="date" id="filterTanggal" class="form-input" style="flex: 1 1 auto; min-width: 140px; height: 38px;" value="{{ date('Y-m-d') }}" onchange="loadDashboardData()">
                            <button type="button" class="btn-action btn-reset-reg" style="height: 38px; flex-shrink: 0; white-space: nowrap;" title="Set ke Hari Ini" onclick="setToToday()">
                                Hari Ini
                            </button>
                        </div>
                    </div>

                    <div class="form-group" id="groupFilterBulan" style="display:none; min-width: 220px;">
                        <label class="form-label">Pilih Bulan</label>
                        <input type="month" id="filterBulan" class="form-input" style="height: 38px;" value="{{ date('Y-m') }}" onchange="loadDashboardData()">
                    </div>

                    <!-- Refresh Button -->
                    <div class="form-group" style="min-width: auto;">
                        <label class="form-label" style="visibility: hidden;">&nbsp;</label>
                        <button type="button" class="btn-action" style="background:#166534; color:#fff; height: 38px;" onclick="loadDashboardData()">
                            <i class="fas fa-sync-alt"></i> Segarkan Data
                        </button>
                    </div>
                </div>
            </div>

            <!-- KPI Cards -->
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="kpi-icon blue">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="kpi-body">
                        <span class="kpi-label">Total Pegawai Aktif</span>
                        <span class="kpi-value" id="kpiTotalPegawai">0</span>
                        <span class="kpi-sub" id="kpiSubTotalPegawai" title="HO & Reg 1 - Reg 8" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;">HO & Reg 1 - Reg 8</span>
                        <div class="kpi-breakdown">
                            <div class="kpi-breakdown-row" title="Karyawan Tetap">
                                <span class="kpi-breakdown-label"><span class="kpi-breakdown-dot tetap"></span>Tetap:</span>
                                <span class="kpi-breakdown-val" id="kpiTetapPegawai">0</span>
                            </div>
                            <div class="kpi-breakdown-row" title="Karyawan Tidak Tetap">
                                <span class="kpi-breakdown-label"><span class="kpi-breakdown-dot tidak-tetap"></span>Tidak Tetap:</span>
                                <span class="kpi-breakdown-val" id="kpiTidakTetapPegawai">0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-icon green">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="kpi-body">
                        <span class="kpi-label">Total Kehadiran</span>
                        <span class="kpi-value" id="kpiTotalHadir">0</span>
                        <span class="kpi-sub" id="kpiPctTotal">0% Kehadiran</span>
                        <div class="kpi-breakdown">
                            <div class="kpi-breakdown-row" title="Karyawan Tetap Hadir">
                                <span class="kpi-breakdown-label"><span class="kpi-breakdown-dot tetap"></span>Tetap:</span>
                                <span class="kpi-breakdown-val" id="kpiTetapTotalHadir">0</span>
                            </div>
                            <div class="kpi-breakdown-row" title="Karyawan Tidak Tetap Hadir">
                                <span class="kpi-breakdown-label"><span class="kpi-breakdown-dot tidak-tetap"></span>Tidak Tetap:</span>
                                <span class="kpi-breakdown-val" id="kpiTidakTetapTotalHadir">0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="kpi-card" style="cursor: pointer;" onclick="switchDetailTab('hris'); scrollToDetail();" title="Klik untuk lihat rincian Presensi HRIS">
                    <div class="kpi-icon" style="background: #f0fdf4; color: #15803d;">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div class="kpi-body">
                        <span class="kpi-label">Presensi HRIS</span>
                        <span class="kpi-value" id="kpiHadirHris">0</span>
                        <span class="kpi-sub" id="kpiPctHris">0% dari Pegawai</span>
                        <div class="kpi-breakdown">
                            <div class="kpi-breakdown-row" title="Karyawan Tetap Presensi HRIS">
                                <span class="kpi-breakdown-label"><span class="kpi-breakdown-dot tetap"></span>Tetap:</span>
                                <span class="kpi-breakdown-val" id="kpiTetapHris">0</span>
                            </div>
                            <div class="kpi-breakdown-row" title="Karyawan Tidak Tetap Presensi HRIS">
                                <span class="kpi-breakdown-label"><span class="kpi-breakdown-dot tidak-tetap"></span>Tidak Tetap:</span>
                                <span class="kpi-breakdown-val" id="kpiTidakTetapHris">0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="kpi-card" style="cursor: pointer;" onclick="switchDetailTab('dfarm'); scrollToDetail();" title="Klik untuk lihat rincian Presensi DFarm">
                    <div class="kpi-icon" style="background: #ecfdf5; color: #16a34a;">
                        <i class="fas fa-tractor"></i>
                    </div>
                    <div class="kpi-body">
                        <span class="kpi-label">Presensi DFarm</span>
                        <span class="kpi-value" id="kpiHadirDfarm">0</span>
                        <span class="kpi-sub" id="kpiPctDfarm">0% dari Pegawai</span>
                        <div class="kpi-breakdown">
                            <div class="kpi-breakdown-row" title="Karyawan Tetap Presensi DFarm">
                                <span class="kpi-breakdown-label"><span class="kpi-breakdown-dot tetap"></span>Tetap:</span>
                                <span class="kpi-breakdown-val" id="kpiTetapDfarm">0</span>
                            </div>
                            <div class="kpi-breakdown-row" title="Karyawan Tidak Tetap Presensi DFarm">
                                <span class="kpi-breakdown-label"><span class="kpi-breakdown-dot tidak-tetap"></span>Tidak Tetap:</span>
                                <span class="kpi-breakdown-val" id="kpiTidakTetapDfarm">0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="kpi-card" id="cardKpiBoth" style="cursor: pointer;" onclick="switchDetailTab('both'); scrollToDetail();" title="Klik untuk lihat karyawan yang presensi di kedua aplikasi">
                    <div class="kpi-icon" style="background: #f0fdfa; color: #0d9488;">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div class="kpi-body">
                        <span class="kpi-label">Presensi di Dfarm & HRIS</span>
                        <span class="kpi-value" id="kpiHadirBoth">0</span>
                        <span class="kpi-sub" id="kpiPctBoth">0% dari Pegawai</span>
                        <div class="kpi-breakdown">
                            <div class="kpi-breakdown-row" title="Karyawan Tetap Presensi DFarm & HRIS">
                                <span class="kpi-breakdown-label"><span class="kpi-breakdown-dot tetap"></span>Tetap:</span>
                                <span class="kpi-breakdown-val" id="kpiTetapBoth">0</span>
                            </div>
                            <div class="kpi-breakdown-row" title="Karyawan Tidak Tetap Presensi DFarm & HRIS">
                                <span class="kpi-breakdown-label"><span class="kpi-breakdown-dot tidak-tetap"></span>Tidak Tetap:</span>
                                <span class="kpi-breakdown-val" id="kpiTidakTetapBoth">0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Card -->
            <div class="table-card" style="position: relative; background: #ffffff !important;">
                <div class="table-header">
                    <div class="table-title">
                        <i class="fas fa-chart-bar"></i> 
                        <span id="chartCardTitle">Grafik Persentase Presensi Regional (Head Office, Regional 1 s/d Regional 8)</span>
                    </div>
                    <div class="chart-controls">
                        <button type="button" id="btnBackToRegionalChart" class="btn-action" style="display:none; background:#ffffff; color:#166534; font-weight:700; height:32px; padding:0 14px; border-radius:6px; border:none; box-shadow:0 1px 3px rgba(0,0,0,0.15); cursor:pointer;" onclick="resetToAllRegional()">
                            <i class="fas fa-arrow-left"></i> Kembali ke Semua Regional
                        </button>
                        <div class="mode-toggle-group" style="background: rgba(255,255,255,0.15); border-color: rgba(255,255,255,0.2);">
                            <button type="button" class="mode-toggle-btn active" id="btnMetricPegawai" style="color:#fff;" onclick="switchMetric('kehadiran')">
                                % Kehadiran Pegawai
                            </button>
                            <button type="button" class="mode-toggle-btn" id="btnMetricProporsi" style="color:#e2e8f0;" onclick="switchMetric('proporsi')">
                                % Rasio HRIS vs DFarm
                            </button>
                        </div>
                    </div>
                </div>

                <div class="chart-container" style="background: #ffffff !important;">
                    <div id="chartLoadingOverlay" class="loading-overlay" style="display:none; background: rgba(255, 255, 255, 0.9);">
                        <div class="spinner"></div>
                        <p style="color:#166534; font-size:13px; font-weight:600;">Mengambil Data Presensi...</p>
                    </div>

                    <p style="color:#475569; font-size:12.5px; margin-bottom:16px;">
                        <i class="fas fa-info-circle" style="color:#16a34a;"></i>
                        <span id="chartSubtext">Klik salah satu batang regional pada grafik untuk melihat rincian stacked bar per unit di regional tersebut.</span>
                    </p>

                    <div id="chartScrollContainer" style="width: 100%; overflow-x: auto; background: #ffffff !important;">
                        <div id="chartCanvasWrapper" style="height: 380px; width: 100%; min-width: 100%; background: #ffffff !important; position: relative;">
                            <canvas id="presensiChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Table Section -->
            <div class="detail-card" id="detailSection">
                <div class="detail-header">
                    <div class="detail-title-group">
                        <i class="fas fa-table" style="color:#166534; font-size:16px;"></i>
                        <span class="detail-title-main">Detail Presensi</span>
                        <span class="regional-pill-badge" id="activeRegionalBadge">
                            <i class="fas fa-map-marker-alt"></i> Semua Regional
                        </span>
                        <span class="regional-pill-badge" id="activeUnitBadge" style="display:none; background:#fef3c7; color:#92400e; border:1px solid #fde68a;">
                            <i class="fas fa-seedling"></i> <span id="activeUnitText"></span>
                            <i class="fas fa-times" onclick="clearUnitFilter(event)" style="margin-left:6px; cursor:pointer;" title="Hapus Filter Kebun/Unit"></i>
                        </span>
                    </div>

                    <div style="display:flex; align-items:center; gap:8px;">
                        <button type="button" class="btn-action btn-reset-reg" id="btnShowAllReg" onclick="selectRegional('ALL')">
                            <i class="fas fa-globe"></i> Tampilkan Semua Regional
                        </button>
                        <button type="button" class="btn-action btn-excel" onclick="exportDetailExcel()">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </button>
                        <button type="button" class="btn-action btn-pdf" onclick="exportDetailPDF()">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </button>
                    </div>
                </div>

                <!-- 3 Tabs: HRIS, Dfarm, dan Keduanya -->
                <div class="tabs-header">
                    <button type="button" class="tab-btn active" id="tabBtnHris" onclick="switchDetailTab('hris')">
                        <i class="fas fa-mobile-alt"></i> Presensi HRIS
                        <span class="tab-badge hris-badge" id="badgeCountHris">0</span>
                    </button>
                    <button type="button" class="tab-btn" id="tabBtnDfarm" onclick="switchDetailTab('dfarm')">
                        <i class="fas fa-tractor"></i> Presensi DFarm
                        <span class="tab-badge dfarm-badge" id="badgeCountDfarm">0</span>
                    </button>
                    <button type="button" class="tab-btn" id="tabBtnBoth" onclick="switchDetailTab('both')">
                        <i class="fas fa-layer-group"></i> Presensi di Dfarm & HRIS
                        <span class="tab-badge both-badge" id="badgeCountBoth">0</span>
                    </button>
                </div>

                <!-- Table Toolbar (Search, Filter Status & info) -->
                <div class="table-toolbar">
                    <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="tableSearchInput" placeholder="Cari NIK, Nama, Divisi, atau Jabatan..." oninput="handleSearchInput(this.value)">
                        </div>
                        <div class="status-filter-group" title="Filter berdasarkan Status Karyawan">
                            <button type="button" class="status-filter-btn active" id="btnFilterStatusAll" onclick="switchStatusFilter('ALL')">
                                Semua
                            </button>
                            <button type="button" class="status-filter-btn" id="btnFilterStatusTetap" onclick="switchStatusFilter('tetap')">
                                <span class="pill-dot tetap"></span> Kary. Tetap
                            </button>
                            <button type="button" class="status-filter-btn" id="btnFilterStatusTidakTetap" onclick="switchStatusFilter('tidak_tetap')">
                                <span class="pill-dot tidak-tetap"></span> Kary. Tidak Tetap
                            </button>
                        </div>
                    </div>
                    <div style="font-size:12px; color:#64748b; white-space:nowrap;">
                        Menampilkan <strong id="infoShowingRows">0</strong> data presensi
                    </div>
                </div>

                <!-- Table Content -->
                <div class="table-responsive" style="position: relative; min-height: 250px;">
                    <div id="tableLoadingOverlay" class="loading-overlay" style="display:none;">
                        <div class="spinner"></div>
                        <p style="color:#64748b; font-size:13px; font-weight:600;">Memuat Detail Data...</p>
                    </div>

                    <table class="custom-table" id="detailPresensiTable">
                        <thead>
                            <tr>
                                <th style="width: 50px; text-align: center;">NO</th>
                                <th style="width: 100px;">NIK</th>
                                <th>NAMA KARYAWAN</th>
                                <th style="width: 110px; text-align: center;">STATUS</th>
                                <th>JABATAN</th>
                                <th>UNIT / DIVISI</th>
                                <th>REGIONAL</th>
                                <th style="width: 150px;">WAKTU CHECK-IN</th>
                                <th style="width: 90px; text-align: center;">JENIS</th>
                                <th style="width: 110px; text-align: center;">SUMBER ALAT</th>
                                <th>LOKASI / ALAMAT</th>
                            </tr>
                        </thead>
                        <tbody id="detailTableBody">
                            <!-- Dynamic Content -->
                        </tbody>
                    </table>

                    <div id="emptyTableState" class="empty-placeholder" style="display:none;">
                        <i class="fas fa-clipboard-list"></i>
                        <p style="font-size:14px; font-weight:600; color:#64748b; margin:0;">Tidak ada data presensi ditemukan</p>
                        <p style="font-size:12px; color:#94a3b8; margin:4px 0 0;">Coba pilih regional lain atau ubah parameter tanggal filter.</p>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="pagination-bar" id="paginationBar">
                    <div id="paginationInfoText">Halaman 1 dari 1</div>
                    <div class="page-controls">
                        <button type="button" class="page-btn" id="btnPagePrev" onclick="changePage(-1)" disabled>
                            <i class="fas fa-chevron-left"></i> Prev
                        </button>
                        <span id="pageNumbers"></span>
                        <button type="button" class="page-btn" id="btnPageNext" onclick="changePage(1)" disabled>
                            Next <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Chart.js and DataLabels plugin -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <!-- Export Excel & PDF libraries -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx-js-style@1.2.0/dist/xlsx.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

    <script>
        // Register DataLabels
        Chart.register(ChartDataLabels);

        // State Variables
        let currentMode = 'hari'; // 'hari' or 'bulan'
        let currentMetric = 'kehadiran'; // 'kehadiran' or 'proporsi'
        let activeRegional = 'ALL'; // 'ALL' or regional name e.g. 'Regional 2'
        let activeUnit = ''; // '' or unit name e.g. 'Kebun Sukamangli'
        let activeTab = 'hris'; // 'hris' or 'dfarm'
        let activeStatusFilter = 'ALL'; // 'ALL', 'tetap', or 'tidak_tetap'
        let chartInstance = null;
        let chartRawData = null;

        // Detail table state
        let detailDataCache = {
            hris: [],
            dfarm: [],
            both: [],
            counts: { count_hris: 0, count_dfarm: 0, count_both: 0 }
        };
        let filteredRows = [];
        let currentPage = 1;
        const pageSize = 50;

        document.addEventListener('DOMContentLoaded', function() {
            loadDashboardData();
        });

        function handleAppSelectChange(val) {
            if (val === 'HRIS') {
                window.location.href = '/evaluasi-aplikasi';
            } else if (val === 'Digital Farming') {
                window.location.href = '/dfarmkaret';
            } else if (val === 'Digital Farming Produksi') {
                window.location.href = '/dfarmkaretproduksi';
            } else if (val === 'Digital Farming BKM') {
                window.location.href = '/dfarmkaretbkmsap';
            } else if (val === 'MAIA') {
                window.location.href = '/evaluasi-aplikasi/maia';
            } else if (val === 'MONIKA') {
                window.location.href = '/evaluasi-aplikasi/monika';
            } else if (val === 'BPD') {
                window.location.href = '/bpd-evaluasi';
            } else if (val === 'SAPA-Amanah') {
                window.location.href = '/sapa-evaluasi';
            } else if (val === 'AGHRIS') {
                window.location.href = '/evaluasi-aghris';
            }
        }

        function switchFilterMode(mode) {
            currentMode = mode;
            if (mode === 'hari') {
                document.getElementById('btnModeHari').classList.add('active');
                document.getElementById('btnModeBulan').classList.remove('active');
                document.getElementById('groupFilterHari').style.display = 'flex';
                document.getElementById('groupFilterBulan').style.display = 'none';
            } else {
                document.getElementById('btnModeBulan').classList.add('active');
                document.getElementById('btnModeHari').classList.remove('active');
                document.getElementById('groupFilterHari').style.display = 'none';
                document.getElementById('groupFilterBulan').style.display = 'flex';
            }
            loadDashboardData();
        }

        function setToToday() {
            const today = new Date().toISOString().slice(0, 10);
            document.getElementById('filterTanggal').value = today;
            if (currentMode !== 'hari') {
                switchFilterMode('hari');
            } else {
                loadDashboardData();
            }
        }

        function switchMetric(metric) {
            currentMetric = metric;
            if (metric === 'kehadiran') {
                document.getElementById('btnMetricPegawai').classList.add('active');
                document.getElementById('btnMetricPegawai').style.color = '#fff';
                document.getElementById('btnMetricProporsi').classList.remove('active');
                document.getElementById('btnMetricProporsi').style.color = '#e2e8f0';
            } else {
                document.getElementById('btnMetricProporsi').classList.add('active');
                document.getElementById('btnMetricProporsi').style.color = '#fff';
                document.getElementById('btnMetricPegawai').classList.remove('active');
                document.getElementById('btnMetricPegawai').style.color = '#e2e8f0';
            }
            if (chartRawData) {
                renderChart(chartRawData);
            }
        }

        async function loadDashboardData(regionalOverride) {
            const tanggal = document.getElementById('filterTanggal').value;
            const bulan = document.getElementById('filterBulan').value;

            document.getElementById('chartLoadingOverlay').style.display = 'flex';

            const regToFetch = (typeof regionalOverride !== 'undefined') ? regionalOverride : activeRegional;

            const queryParams = new URLSearchParams({
                mode: currentMode,
                tanggal: tanggal,
                bulan: bulan,
                regional: regToFetch || 'ALL'
            });

            try {
                const response = await fetch(`/api/konsol-presensi/chart-data?${queryParams.toString()}`);
                const data = await response.json();

                if (data.status === 'success') {
                    chartRawData = data;
                    updateKPI(data.summary, data.period_label);
                    renderChart(data);

                    // Load detail table for current active regional
                    loadDetailData();
                } else {
                    alert('Gagal memuat data grafik: ' + (data.message || 'Terjadi kesalahan'));
                }
            } catch (err) {
                console.error(err);
                alert('Terjadi kesalahan jaringan saat memuat data grafik.');
            } finally {
                document.getElementById('chartLoadingOverlay').style.display = 'none';
            }
        }

        function updateKPI(summary, periodLabel) {
            if (!summary) return;
            const fmt = (n) => new Intl.NumberFormat('id-ID').format(n || 0);

            // 1. Total Pegawai Aktif
            document.getElementById('kpiTotalPegawai').textContent = fmt(summary.total_pegawai);
            if (document.getElementById('kpiTetapPegawai')) {
                document.getElementById('kpiTetapPegawai').textContent = fmt(summary.total_pegawai_tetap);
            }
            if (document.getElementById('kpiTidakTetapPegawai')) {
                document.getElementById('kpiTidakTetapPegawai').textContent = fmt(summary.total_pegawai_tidak_tetap);
            }

            // Sub-keterangan Scope Total Pegawai (HO & Reg 1 - Reg 8, Regional Name, atau Unit Name)
            const subTotalElem = document.getElementById('kpiSubTotalPegawai');
            if (subTotalElem) {
                let scopeText = 'HO & Reg 1 - Reg 8';
                let scopeTitle = 'HO & Reg 1 - Reg 8';
                if (summary.scope_label) {
                    scopeText = summary.scope_label;
                    scopeTitle = summary.scope_title || summary.scope_label;
                } else if (activeUnit) {
                    scopeText = activeUnit;
                    scopeTitle = (activeRegional && activeRegional !== 'ALL') ? `${activeRegional} • ${activeUnit}` : activeUnit;
                } else if (activeRegional && activeRegional !== 'ALL') {
                    scopeText = activeRegional;
                    scopeTitle = activeRegional;
                }
                subTotalElem.textContent = scopeText;
                subTotalElem.title = scopeTitle;
            }

            // 2. Total Kehadiran
            document.getElementById('kpiTotalHadir').textContent = fmt(summary.total_hadir);
            document.getElementById('kpiPctTotal').textContent = `${summary.pct_total}% Persentase Kehadiran`;
            if (document.getElementById('kpiTetapTotalHadir')) {
                document.getElementById('kpiTetapTotalHadir').textContent = fmt(summary.hadir_tetap);
            }
            if (document.getElementById('kpiTidakTetapTotalHadir')) {
                document.getElementById('kpiTidakTetapTotalHadir').textContent = fmt(summary.hadir_tidak_tetap);
            }

            // 3. Presensi HRIS
            document.getElementById('kpiHadirHris').textContent = fmt(summary.hadir_hris);
            document.getElementById('kpiPctHris').textContent = `${summary.pct_hris}% dari Total Pegawai`;
            if (document.getElementById('kpiTetapHris')) {
                document.getElementById('kpiTetapHris').textContent = fmt(summary.hadir_hris_tetap);
            }
            if (document.getElementById('kpiTidakTetapHris')) {
                document.getElementById('kpiTidakTetapHris').textContent = fmt(summary.hadir_hris_tidak_tetap);
            }

            // 4. Presensi DFarm
            document.getElementById('kpiHadirDfarm').textContent = fmt(summary.hadir_dfarm);
            document.getElementById('kpiPctDfarm').textContent = `${summary.pct_dfarm}% dari Total Pegawai`;
            if (document.getElementById('kpiTetapDfarm')) {
                document.getElementById('kpiTetapDfarm').textContent = fmt(summary.hadir_dfarm_tetap);
            }
            if (document.getElementById('kpiTidakTetapDfarm')) {
                document.getElementById('kpiTidakTetapDfarm').textContent = fmt(summary.hadir_dfarm_tidak_tetap);
            }

            // 5. Presensi DFarm & HRIS
            document.getElementById('kpiHadirBoth').textContent = fmt(summary.hadir_both);
            document.getElementById('kpiPctBoth').textContent = `${summary.pct_both}% dari Total Pegawai`;
            if (document.getElementById('kpiTetapBoth')) {
                document.getElementById('kpiTetapBoth').textContent = fmt(summary.hadir_both_tetap);
            }
            if (document.getElementById('kpiTidakTetapBoth')) {
                document.getElementById('kpiTidakTetapBoth').textContent = fmt(summary.hadir_both_tidak_tetap);
            }

            const isUnit = chartRawData && chartRawData.level === 'unit';
            const regName = chartRawData && chartRawData.regional ? chartRawData.regional : activeRegional;
            const btnBack = document.getElementById('btnBackToRegionalChart');
            const subtext = document.getElementById('chartSubtext');

            if (isUnit) {
                document.getElementById('chartCardTitle').innerHTML = 
                    `<span style="opacity:0.85; font-weight:500;">Semua Regional &gt;</span> <b>Grafik Presensi Per Unit - ${regName}</b> <span style="font-size:12px; font-weight:normal; opacity:0.9;">(${periodLabel || ''})</span>`;
                if (btnBack) btnBack.style.display = 'inline-flex';
                if (subtext) subtext.innerHTML = `Menampilkan rincian stacked bar per unit di <b>${regName}</b>. Klik batang unit untuk menyaring data pada tabel di bawah, atau klik <b>"Kembali ke Semua Regional"</b> untuk melihat level regional.`;
            } else {
                document.getElementById('chartCardTitle').textContent = `Grafik Persentase Presensi Regional (${periodLabel || ''})`;
                if (btnBack) btnBack.style.display = 'none';
                if (subtext) subtext.innerHTML = `Klik salah satu batang regional pada grafik untuk melihat rincian stacked bar per unit di regional tersebut.`;
            }
        }

        function renderChart(data) {
            const ctx = document.getElementById('presensiChart').getContext('2d');
            if (chartInstance) {
                chartInstance.destroy();
            }

            const isUnit = data.level === 'unit';
            const isProporsi = currentMetric === 'proporsi';

            // Set canvas wrapper height and dynamic width for scrollability if many units
            const canvasWrapper = document.getElementById('chartCanvasWrapper');
            if (canvasWrapper) {
                if (isUnit) {
                    const dynamicWidth = Math.max(900, data.labels.length * 42);
                    canvasWrapper.style.width = dynamicWidth > 1100 ? `${dynamicWidth}px` : '100%';
                    canvasWrapper.style.height = '430px';
                } else {
                    canvasWrapper.style.width = '100%';
                    canvasWrapper.style.height = '380px';
                }
            }

            let datasetHrisData = isProporsi ? (data.data_share_hris || data.data_hris) : data.data_hris;
            let datasetDfarmData = isProporsi ? (data.data_share_dfarm || data.data_dfarm) : data.data_dfarm;
            let datasetBothData = isProporsi ? (data.data_share_both || data.data_both) : (data.data_both || []);

            let datasets = [
                {
                    label: isProporsi ? 'Proporsi HRIS (%)' : 'Persentase Hadir HRIS (%)',
                    data: datasetHrisData,
                    backgroundColor: '#166534', // Hijau Tua Korporat / Forest Green
                    borderColor: '#14532d',
                    borderWidth: 1,
                    stack: 'presensi_gabungan',
                    barPercentage: isUnit ? 0.65 : 0.52,
                    categoryPercentage: isUnit ? 0.85 : 0.75,
                    datalabels: {
                        color: '#ffffff',
                        anchor: 'center',
                        align: 'center',
                        font: { weight: 'bold', size: isUnit ? 9.5 : 11 },
                        formatter: function(val) {
                            return val >= (isUnit ? 5 : 4) ? val + '%' : '';
                        }
                    }
                },
                {
                    label: isProporsi ? 'Proporsi DFarm (%)' : 'Persentase Hadir DFarm (%)',
                    data: datasetDfarmData,
                    backgroundColor: '#f97316', // Orange Profesional / DFarm
                    borderColor: '#ea580c',
                    borderWidth: 1,
                    stack: 'presensi_gabungan',
                    barPercentage: isUnit ? 0.65 : 0.52,
                    categoryPercentage: isUnit ? 0.85 : 0.75,
                    datalabels: {
                        color: '#ffffff',
                        anchor: 'center',
                        align: 'center',
                        font: { weight: 'bold', size: isUnit ? 9.5 : 11 },
                        formatter: function(val) {
                            return val >= (isUnit ? 5 : 4) ? val + '%' : '';
                        }
                    }
                },
                {
                    label: isProporsi ? 'Proporsi di Dfarm & HRIS (%)' : 'Persentase di Dfarm & HRIS (%)',
                    data: datasetBothData,
                    backgroundColor: '#0d9488', // Hijau Teal Korporat
                    borderColor: '#0f766e',
                    borderWidth: 1,
                    stack: 'presensi_gabungan',
                    borderRadius: { topLeft: 4, topRight: 4 },
                    barPercentage: isUnit ? 0.65 : 0.52,
                    categoryPercentage: isUnit ? 0.85 : 0.75,
                    datalabels: {
                        color: '#ffffff',
                        anchor: 'center',
                        align: 'center',
                        font: { weight: 'bold', size: isUnit ? 9 : 10 },
                        formatter: function(val) {
                            return val >= (isUnit ? 4 : 2) ? val + '%' : '';
                        }
                    }
                }
            ];

            // Plugin solid white background pada canvas
            const canvasBackgroundPlugin = {
                id: 'canvasBackgroundPlugin',
                beforeDraw: (chart) => {
                    const { ctx } = chart;
                    ctx.save();
                    ctx.fillStyle = '#ffffff';
                    ctx.fillRect(0, 0, chart.width, chart.height);
                    ctx.restore();
                }
            };

            // Custom plugin to show combined total percentage above the stacked bar
            const stackedTotalPlugin = {
                id: 'stackedTotalPlugin',
                afterDatasetsDraw(chart) {
                    const { ctx, scales: { x, y } } = chart;
                    data.labels.forEach((label, index) => {
                        const total = Number(data.data_total[index]) || 0;

                        if (total > 0) {
                            const xPos = x.getPixelForValue(index);
                            const yPos = y.getPixelForValue(total);
                            ctx.save();
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            ctx.font = 'bold 10px -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif';
                            
                            const text = total.toFixed(1) + '%';
                            const metrics = ctx.measureText(text);
                            const textWidth = metrics.width;

                            // Clean badge with green border on solid white background
                            ctx.fillStyle = '#ffffff';
                            ctx.strokeStyle = '#86efac';
                            ctx.lineWidth = 1;
                            ctx.beginPath();
                            if (ctx.roundRect) {
                                ctx.roundRect(xPos - textWidth / 2 - 3, yPos - 14, textWidth + 6, 13, 3);
                            } else {
                                ctx.rect(xPos - textWidth / 2 - 3, yPos - 14, textWidth + 6, 13);
                            }
                            ctx.fill();
                            ctx.stroke();

                            ctx.fillStyle = '#14532d';
                            ctx.fillText(text, xPos, yPos - 2);
                            ctx.restore();
                        }
                    });
                }
            };

            chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: datasets
                },
                plugins: [canvasBackgroundPlugin, stackedTotalPlugin],
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    onHover: (event, chartElement) => {
                        event.native.target.style.cursor = chartElement[0] ? 'pointer' : 'default';
                    },
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    scales: {
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            max: isProporsi ? 100 : Math.min(100, Math.max(60, ...data.data_total.map(v => Math.ceil(v / 10) * 10))),
                            ticks: {
                                callback: (val) => val + '%',
                                font: { size: 11, weight: '600' },
                                color: '#475569'
                            },
                            grid: {
                                color: '#f1f5f9'
                            }
                        },
                        x: {
                            stacked: true,
                            ticks: {
                                font: { size: isUnit ? 10.5 : 11.5, weight: isUnit ? '600' : '700' },
                                color: '#1e293b',
                                maxRotation: isUnit ? 45 : 0,
                                minRotation: isUnit ? 30 : 0,
                                autoSkip: false
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                boxWidth: 14,
                                font: { size: 12, weight: '700' },
                                color: '#1e293b',
                                padding: 16
                            }
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleFont: { size: 13, weight: 'bold' },
                            bodyFont: { size: 12 },
                            padding: 10,
                            cornerRadius: 6,
                            callbacks: {
                                afterBody: function(tooltipItems) {
                                    const index = tooltipItems[0].dataIndex;
                                    const raw = data.raw_rows[index];
                                    if (!raw) return [];
                                    const fmt = (n) => new Intl.NumberFormat('id-ID').format(n || 0);
                                    return [
                                        `--------------------------`,
                                        `Total Pegawai: ${fmt(raw.total_pegawai)} org (Tetap: ${fmt(raw.total_pegawai_tetap)}, Tdk Tetap: ${fmt(raw.total_pegawai_tidak_tetap)})`,
                                        `Hanya HRIS: ${fmt(raw.hadir_hris)} org (${raw.pct_hris}%) [Tetap: ${fmt(raw.hadir_hris_tetap)}, Tdk Tetap: ${fmt(raw.hadir_hris_tidak_tetap)}]`,
                                        `Hanya DFarm: ${fmt(raw.hadir_dfarm)} org (${raw.pct_dfarm}%) [Tetap: ${fmt(raw.hadir_dfarm_tetap)}, Tdk Tetap: ${fmt(raw.hadir_dfarm_tidak_tetap)}]`,
                                        `Di Keduanya: ${fmt(raw.hadir_both)} org (${raw.pct_both}%) [Tetap: ${fmt(raw.hadir_both_tetap)}, Tdk Tetap: ${fmt(raw.hadir_both_tidak_tetap)}]`,
                                        `Total Hadir: ${fmt(raw.total_hadir)} org (${raw.pct_total}%) [Tetap: ${fmt(raw.hadir_tetap)}, Tdk Tetap: ${fmt(raw.hadir_tidak_tetap)}]`,
                                        isUnit ? `Klik untuk menyaring tabel detail` : `Klik untuk melihat stacked chart per unit`
                                    ];
                                }
                            }
                        },
                        datalabels: {
                            display: true
                        }
                    },
                    onClick: function(evt, elements) {
                        if (elements && elements.length > 0) {
                            const index = elements[0].index;
                            const clickedLabel = data.labels[index];
                            if (!clickedLabel) return;

                            if (isUnit) {
                                // Sudah di level unit, klik batang unit -> saring tabel detail dan perbarui tab counts sesuai unit
                                selectUnit(clickedLabel);
                            } else {
                                // Masih di level regional, drill down ke unit chart
                                drillDownToRegional(clickedLabel);
                            }
                        }
                    }
                }
            });
        }

        function selectUnit(unitName) {
            activeUnit = unitName;

            // Bersihkan teks pencarian agar user bisa mencari pegawai di unit tersebut
            const searchInput = document.getElementById('tableSearchInput');
            if (searchInput) searchInput.value = '';

            // Tampilkan badge unit di header tabel detail
            const unitBadge = document.getElementById('activeUnitBadge');
            const unitText = document.getElementById('activeUnitText');
            if (unitBadge && unitText) {
                unitText.textContent = unitName;
                unitBadge.style.display = 'inline-flex';
            }

            // Update KPI cards khusus untuk unit yang dipilih jika datanya ada di chartRawData
            if (chartRawData && chartRawData.raw_rows) {
                const row = chartRawData.raw_rows.find(r => r.unit_nama === unitName);
                if (row) {
                    const unitSummary = {
                        total_pegawai: row.total_pegawai,
                        total_pegawai_tetap: row.total_pegawai_tetap,
                        total_pegawai_tidak_tetap: row.total_pegawai_tidak_tetap,
                        total_hadir: row.total_hadir,
                        hadir_tetap: row.hadir_tetap,
                        hadir_tidak_tetap: row.hadir_tidak_tetap,
                        hadir_hris: row.hadir_hris,
                        hadir_hris_tetap: row.hadir_hris_tetap,
                        hadir_hris_tidak_tetap: row.hadir_hris_tidak_tetap,
                        hadir_dfarm: row.hadir_dfarm,
                        hadir_dfarm_tetap: row.hadir_dfarm_tetap,
                        hadir_dfarm_tidak_tetap: row.hadir_dfarm_tidak_tetap,
                        hadir_both: row.hadir_both,
                        hadir_both_tetap: row.hadir_both_tetap,
                        hadir_both_tidak_tetap: row.hadir_both_tidak_tetap,
                        pct_hris: row.pct_hris,
                        pct_dfarm: row.pct_dfarm,
                        pct_both: row.pct_both,
                        pct_total: row.pct_total,
                        scope_label: unitName,
                        scope_title: (activeRegional && activeRegional !== 'ALL') ? `${activeRegional} • ${unitName}` : unitName
                    };
                    updateKPI(unitSummary, chartRawData.period_label);
                }
            }

            // Scroll halus ke tabel detail
            scrollToDetail();

            // Muat data detail khusus unit tersebut!
            currentPage = 1;
            loadDetailData();
        }

        function clearUnitFilter(evt) {
            if (evt) evt.stopPropagation();
            activeUnit = '';
            const unitBadge = document.getElementById('activeUnitBadge');
            if (unitBadge) {
                unitBadge.style.display = 'none';
            }
            const searchInput = document.getElementById('tableSearchInput');
            if (searchInput) searchInput.value = '';

            // Kembalikan KPI cards ke summary regional saat ini
            if (chartRawData && chartRawData.summary) {
                updateKPI(chartRawData.summary, chartRawData.period_label);
            }

            currentPage = 1;
            loadDetailData();
        }

        function drillDownToRegional(regName) {
            activeRegional = regName;
            activeUnit = '';
            const unitBadge = document.getElementById('activeUnitBadge');
            if (unitBadge) unitBadge.style.display = 'none';

            const badge = document.getElementById('activeRegionalBadge');
            if (badge) {
                badge.innerHTML = `<i class="fas fa-map-marker-alt"></i> ${regName}`;
            }

            // Update label KPI sementara menunggu data datang
            const subTotalElem = document.getElementById('kpiSubTotalPegawai');
            if (subTotalElem) {
                subTotalElem.textContent = regName;
                subTotalElem.title = regName;
            }

            loadDashboardData(regName);
        }

        function resetToAllRegional() {
            activeRegional = 'ALL';
            activeUnit = '';
            const unitBadge = document.getElementById('activeUnitBadge');
            if (unitBadge) unitBadge.style.display = 'none';

            const badge = document.getElementById('activeRegionalBadge');
            if (badge) {
                badge.innerHTML = `<i class="fas fa-map-marker-alt"></i> Semua Regional`;
            }
            const searchInput = document.getElementById('tableSearchInput');
            if (searchInput) {
                searchInput.value = '';
            }

            // Reset sub-keterangan ke default
            const subTotalElem = document.getElementById('kpiSubTotalPegawai');
            if (subTotalElem) {
                subTotalElem.textContent = 'HO & Reg 1 - Reg 8';
                subTotalElem.title = 'HO & Reg 1 - Reg 8';
            }

            loadDashboardData('ALL');
        }

        function selectRegional(regName) {
            if (regName === 'ALL') {
                resetToAllRegional();
            } else {
                drillDownToRegional(regName);
            }
        }

        function switchStatusFilter(status) {
            activeStatusFilter = status;

            const btnAll = document.getElementById('btnFilterStatusAll');
            const btnTetap = document.getElementById('btnFilterStatusTetap');
            const btnTidakTetap = document.getElementById('btnFilterStatusTidakTetap');

            if (btnAll) btnAll.classList.toggle('active', status === 'ALL');
            if (btnTetap) btnTetap.classList.toggle('active', status === 'tetap');
            if (btnTidakTetap) btnTidakTetap.classList.toggle('active', status === 'tidak_tetap');

            currentPage = 1;
            loadDetailData();
        }

        async function loadDetailData() {
            const tanggal = document.getElementById('filterTanggal').value;
            const bulan = document.getElementById('filterBulan').value;
            const searchVal = document.getElementById('tableSearchInput').value;

            document.getElementById('tableLoadingOverlay').style.display = 'flex';

            const queryParams = new URLSearchParams({
                mode: currentMode,
                tanggal: tanggal,
                bulan: bulan,
                regional: activeRegional,
                unit: activeUnit || '',
                status: activeStatusFilter,
                tab: 'all',
                search: searchVal
            });

            try {
                const response = await fetch(`/api/konsol-presensi/detail-data?${queryParams.toString()}`);
                const res = await response.json();

                if (res.status === 'success') {
                    detailDataCache = res;

                    // Update Tab Badges
                    updateTabBadges();

                    renderDetailTable();
                } else {
                    console.error('Error detail:', res.message);
                }
            } catch (err) {
                console.error('Failed to load detail table:', err);
            } finally {
                document.getElementById('tableLoadingOverlay').style.display = 'none';
            }
        }

        function updateTabBadges() {
            const fmt = (n) => new Intl.NumberFormat('id-ID').format(n || 0);
            const searchVal = (document.getElementById('tableSearchInput').value || '').trim().toLowerCase();

            if (searchVal) {
                const matchRow = (r) => {
                    const nik = (r.nik || '').toLowerCase();
                    const nama = (r.nama || '').toLowerCase();
                    const divisi = (r.divisi || '').toLowerCase();
                    const jabatan = (r.jabatan || '').toLowerCase();
                    return nik.includes(searchVal) || nama.includes(searchVal) || divisi.includes(searchVal) || jabatan.includes(searchVal);
                };
                const cntHris = (detailDataCache.hris || []).filter(matchRow).length;
                const cntDfarm = (detailDataCache.dfarm || []).filter(matchRow).length;
                const cntBoth = (detailDataCache.both || []).filter(matchRow).length;

                document.getElementById('badgeCountHris').textContent = fmt(cntHris);
                document.getElementById('badgeCountDfarm').textContent = fmt(cntDfarm);
                document.getElementById('badgeCountBoth').textContent = fmt(cntBoth);
            } else if (detailDataCache && detailDataCache.counts) {
                document.getElementById('badgeCountHris').textContent = fmt(detailDataCache.counts.count_hris);
                document.getElementById('badgeCountDfarm').textContent = fmt(detailDataCache.counts.count_dfarm);
                document.getElementById('badgeCountBoth').textContent = fmt(detailDataCache.counts.count_both);
            }
        }

        function switchDetailTab(tab) {
            activeTab = tab;
            document.getElementById('tabBtnHris').classList.toggle('active', tab === 'hris');
            document.getElementById('tabBtnDfarm').classList.toggle('active', tab === 'dfarm');
            document.getElementById('tabBtnBoth').classList.toggle('active', tab === 'both');
            currentPage = 1;
            renderDetailTable();
        }

        function scrollToDetail() {
            const detailSec = document.getElementById('detailSection');
            if (detailSec) {
                detailSec.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        function handleSearchInput(query) {
            updateTabBadges();
            currentPage = 1;
            renderDetailTable();
        }

        function renderDetailTable() {
            const tbody = document.getElementById('detailTableBody');
            const emptyState = document.getElementById('emptyTableState');
            const searchVal = (document.getElementById('tableSearchInput').value || '').trim().toLowerCase();

            let rows = [];
            if (activeTab === 'hris') {
                rows = detailDataCache.hris || [];
            } else if (activeTab === 'dfarm') {
                rows = detailDataCache.dfarm || [];
            } else if (activeTab === 'both') {
                rows = detailDataCache.both || [];
            }

            // Client filter by search query if any
            if (searchVal) {
                rows = rows.filter(r => {
                    const nik = (r.nik || '').toLowerCase();
                    const nama = (r.nama || '').toLowerCase();
                    const divisi = (r.divisi || '').toLowerCase();
                    const jabatan = (r.jabatan || '').toLowerCase();
                    return nik.includes(searchVal) || nama.includes(searchVal) || divisi.includes(searchVal) || jabatan.includes(searchVal);
                });
            }

            filteredRows = rows;
            const totalRows = filteredRows.length;
            document.getElementById('infoShowingRows').textContent = new Intl.NumberFormat('id-ID').format(totalRows);

            if (totalRows === 0) {
                tbody.innerHTML = '';
                emptyState.style.display = 'block';
                document.getElementById('paginationBar').style.display = 'none';
                return;
            }

            emptyState.style.display = 'none';
            document.getElementById('paginationBar').style.display = 'flex';

            // Calculate pagination
            const totalPages = Math.ceil(totalRows / pageSize) || 1;
            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;

            const startIdx = (currentPage - 1) * pageSize;
            const endIdx = Math.min(startIdx + pageSize, totalRows);
            const pageData = filteredRows.slice(startIdx, endIdx);

            document.getElementById('paginationInfoText').textContent = 
                `Menampilkan baris ${startIdx + 1} s/d ${endIdx} dari ${totalRows} data (Halaman ${currentPage} dari ${totalPages})`;

            document.getElementById('btnPagePrev').disabled = (currentPage <= 1);
            document.getElementById('btnPageNext').disabled = (currentPage >= totalPages);

            let html = '';
            pageData.forEach((row, i) => {
                const no = startIdx + i + 1;
                const isBoth = row.alat === 'Dfarm dan HRIS' || row.alat === 'DFarm dan HRIS' || row.alat === 'DFARM & HRIS';
                const isDfarm = row.alat === 'OFFONFARM';
                let alatBadge = '';
                if (isBoth) {
                    alatBadge = `<span class="badge-alat badge-both"><i class="fas fa-layer-group"></i> Dfarm dan HRIS</span>`;
                } else if (isDfarm) {
                    alatBadge = `<span class="badge-alat badge-dfarm"><i class="fas fa-tractor"></i> DFARM</span>`;
                } else {
                    alatBadge = `<span class="badge-alat badge-hris"><i class="fas fa-mobile-alt"></i> ${row.alat || 'HRIS'}</span>`;
                }

                const jenisBadge = `<span class="badge-jenis">${row.jenis_absen || '-'}</span>`;

                const isTetap = row.status_karyawan === 'tetap' || (row.kelompok_pegawai && row.kelompok_pegawai.includes('Tetap') && !row.kelompok_pegawai.includes('Tidak'));
                const statusBadge = isTetap
                    ? `<span class="badge-status tetap" title="${row.kelompok_pegawai || 'Karyawan Tetap'}"><i class="fas fa-check-circle" style="font-size:10px;"></i> Tetap</span>`
                    : `<span class="badge-status tidak-tetap" title="${row.kelompok_pegawai || 'Karyawan Tidak Tetap'}"><i class="fas fa-clock" style="font-size:10px;"></i> Tdk Tetap</span>`;

                html += `
                    <tr>
                        <td style="text-align: center; color: #64748b; font-weight: 600;">${no}</td>
                        <td style="font-family: monospace; font-weight: 600; color: #334155;">${row.nik || '-'}</td>
                        <td style="font-weight: 700; color: #0f172a;">${row.nama || '-'}</td>
                        <td style="text-align: center;">${statusBadge}</td>
                        <td style="color: #475569;">${row.jabatan || '-'}</td>
                        <td style="color: #1e293b; font-weight: 500;">${row.divisi || '-'}</td>
                        <td><span style="font-size:11px; font-weight:600; color:#166534;">${row.regional_nama || '-'}</span></td>
                        <td style="white-space: nowrap; font-size:11.5px; color:#334155;">${row.jam || '-'}</td>
                        <td style="text-align: center;">${jenisBadge}</td>
                        <td style="text-align: center;">${alatBadge}</td>
                        <td style="font-size: 11px; color: #64748b; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="${row.alamat || '-'}">${row.alamat || '-'}</td>
                    </tr>
                `;
            });

            tbody.innerHTML = html;
        }

        function changePage(direction) {
            currentPage += direction;
            renderDetailTable();
        }

        // ============================================
        // EXPORT EXCEL
        // ============================================
        function exportDetailExcel() {
            if (!filteredRows || filteredRows.length === 0) {
                alert('Tidak ada data untuk diexport.');
                return;
            }

            const tabName = activeTab === 'hris' ? 'HRIS' : (activeTab === 'dfarm' ? 'DFarm' : 'DFarm_dan_HRIS');
            const regLabel = activeRegional === 'ALL' ? 'Semua_Regional' : activeRegional.replace(/\s+/g, '_');
            const unitLabel = activeUnit ? `_${activeUnit.replace(/\s+/g, '_')}` : '';
            const statusLabel = activeStatusFilter === 'ALL' ? '' : (activeStatusFilter === 'tetap' ? '_Tetap' : '_Tidak_Tetap');
            const dateStr = currentMode === 'hari' ? document.getElementById('filterTanggal').value : document.getElementById('filterBulan').value;
            const fileName = `Presensi_${tabName}${statusLabel}_${regLabel}${unitLabel}_${dateStr}.xlsx`;

            const exportData = filteredRows.map((r, idx) => {
                const isTetap = r.status_karyawan === 'tetap' || (r.kelompok_pegawai && r.kelompok_pegawai.includes('Tetap') && !r.kelompok_pegawai.includes('Tidak'));
                return {
                    'No': idx + 1,
                    'NIK': r.nik || '',
                    'Nama Karyawan': r.nama || '',
                    'Status': isTetap ? 'Tetap' : 'Tidak Tetap',
                    'Kelompok Pegawai': r.kelompok_pegawai || '',
                    'Jabatan': r.jabatan || '',
                    'Divisi / Unit': r.divisi || '',
                    'Regional': r.regional_nama || '',
                    'Waktu Absen': r.jam || '',
                    'Jenis Absen': r.jenis_absen || '',
                    'Alat': r.alat || '',
                    'Lokasi / Alamat': r.alamat || ''
                };
            });

            const ws = XLSX.utils.json_to_sheet(exportData);

            // Styling header
            const headerRange = XLSX.utils.decode_range(ws['!ref']);
            for (let C = headerRange.s.c; C <= headerRange.e.c; ++C) {
                const cellRef = XLSX.utils.encode_cell({ c: C, r: 0 });
                if (ws[cellRef]) {
                    ws[cellRef].s = {
                        font: { bold: true, color: { rgb: "FFFFFF" } },
                        fill: { fgColor: { rgb: "166534" } },
                        alignment: { horizontal: "center", vertical: "center" }
                    };
                }
            }

            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, `Presensi_${tabName}`);
            XLSX.writeFile(wb, fileName);
        }

        // ============================================
        // EXPORT PDF
        // ============================================
        function exportDetailPDF() {
            if (!filteredRows || filteredRows.length === 0) {
                alert('Tidak ada data untuk diexport.');
                return;
            }

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({ orientation: 'landscape', unit: 'mm', format: 'a4' });

            const tabName = activeTab === 'hris' ? 'HRIS' : (activeTab === 'dfarm' ? 'DFarm' : 'DFarm & HRIS');
            const regLabel = activeRegional === 'ALL' ? 'Semua Regional' : activeRegional;
            const unitSub = activeUnit ? ` | Unit: ${activeUnit}` : '';
            const statusLabel = activeStatusFilter === 'ALL' ? 'Semua Status' : (activeStatusFilter === 'tetap' ? 'Kary. Tetap' : 'Kary. Tidak Tetap');
            const dateStr = currentMode === 'hari' ? document.getElementById('filterTanggal').value : document.getElementById('filterBulan').value;

            doc.setFontSize(14);
            doc.setTextColor(22, 101, 52);
            doc.text(`Laporan Presensi ${tabName}`, 14, 15);

            doc.setFontSize(10);
            doc.setTextColor(71, 85, 105);
            doc.text(`Regional: ${regLabel}${unitSub} | Status: ${statusLabel} | Periode: ${dateStr} | Total: ${filteredRows.length} Data`, 14, 22);

            const tableHeaders = [
                ['No', 'NIK', 'Nama Karyawan', 'Status', 'Jabatan', 'Divisi', 'Regional', 'Waktu', 'Jenis', 'Alat', 'Alamat']
            ];

            const tableRows = filteredRows.map((r, idx) => {
                const isTetap = r.status_karyawan === 'tetap' || (r.kelompok_pegawai && r.kelompok_pegawai.includes('Tetap') && !r.kelompok_pegawai.includes('Tidak'));
                return [
                    idx + 1,
                    r.nik || '',
                    r.nama || '',
                    isTetap ? 'Tetap' : 'Tdk Tetap',
                    r.jabatan || '',
                    r.divisi || '',
                    r.regional_nama || '',
                    r.jam || '',
                    r.jenis_absen || '',
                    r.alat || '',
                    (r.alamat || '').slice(0, 35)
                ];
            });

            doc.autoTable({
                head: tableHeaders,
                body: tableRows,
                startY: 27,
                theme: 'striped',
                headStyles: { fillColor: [22, 101, 52], fontSize: 8, fontStyle: 'bold' },
                bodyStyles: { fontSize: 7.5 },
                styles: { cellPadding: 2, overflow: 'linebreak' },
                columnStyles: {
                    0: { cellWidth: 10, halign: 'center' },
                    1: { cellWidth: 18 },
                    2: { cellWidth: 35 },
                    3: { cellWidth: 35 },
                    4: { cellWidth: 35 },
                    5: { cellWidth: 22 },
                    6: { cellWidth: 25 },
                    7: { cellWidth: 15, halign: 'center' },
                    8: { cellWidth: 18, halign: 'center' },
                    9: { cellWidth: 'auto' }
                }
            });

            const fileName = `Presensi_${tabName}_${regLabel}_${dateStr}.pdf`.replace(/\s+/g, '_');
            doc.save(fileName);
        }
    </script>
@endsection

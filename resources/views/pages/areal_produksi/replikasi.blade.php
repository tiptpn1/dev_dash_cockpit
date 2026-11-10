@extends('layouts.app')

@section('title', 'Areal, Produksi & Produktivitas')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@500;600;700&display=swap" rel="stylesheet">

<!-- ApexCharts CDN -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<style>
    /* ============================================================
       DARK COMMAND-CENTER THEME (LOOKER & COCKPIT PREMIUM EDITION)
       ============================================================ */
    :root {
        --bg-main: #070e1e;
        --bg-panel: #0d1b34;
        --bg-card: #132347;
        --bg-card-hover: #182c58;
        --border-color: #1e3668;
        --border-glow: rgba(56, 189, 248, 0.25);
        --text-white: #f8fafc;
        --text-muted: #94a3b8;
        --text-subtle: #64748b;
        
        --color-blue: #38bdf8;
        --color-orange: #fb923c;
        --color-green: #4ade80;
        --color-purple: #c084fc;
        --color-red: #f87171;
    }

    html, body {
        height: auto !important;
        min-height: 100vh;
        overflow-y: auto !important;
        background-color: var(--bg-main) !important;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        color: var(--text-white);
    }

    .main-content {
        height: auto !important;
        overflow-y: auto !important;
        padding: 0 !important;
        margin-left: 0 !important;
        background-color: var(--bg-main) !important;
    }

    .dashboard-wrapper {
        background-color: var(--bg-main);
        min-height: 100vh;
        padding: 20px 28px 60px 28px;
    }

    /* Top Page Header */
    .lm-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 32px;
        background: #0b172e;
        border-bottom: 1px solid var(--border-color);
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

    /* Glowing Title Banner */
    .header-glow-title {
        background: linear-gradient(90deg, #1e40af 0%, #2563eb 50%, #1e40af 100%);
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.4);
        border: 1px solid rgba(96, 165, 250, 0.35);
        border-radius: 8px;
        padding: 10px 24px;
        text-align: center;
        font-weight: 800;
        font-size: 1.15rem;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #ffffff;
    }

    /* Top Nav Tabs */
    .tab-nav-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-bottom: 16px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 12px;
    }

    .tab-btn {
        background: transparent;
        color: var(--text-muted);
        border: none;
        outline: none;
        padding: 8px 20px;
        font-size: 0.85rem;
        font-weight: 700;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .tab-btn:hover {
        color: #ffffff;
        background: rgba(255, 255, 255, 0.06);
    }

    .tab-btn.active {
        color: #ffffff;
        background: #2563eb;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.45);
    }

    /* Cards */
    .dark-card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.35);
        transition: transform 0.2s ease, border-color 0.2s ease;
    }
    .dark-card:hover {
        border-color: #38bdf8;
    }

    /* Top KPI Pills in Summary (3 Grouped Columns) */
    .kpi-row-group {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }

    .kpi-column-box {
        background: var(--bg-panel);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.25);
    }

    .kpi-column-title {
        font-size: 0.85rem;
        font-weight: 800;
        color: var(--text-muted);
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .kpi-item-pill {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 9px 16px;
        border-radius: 8px;
        margin-bottom: 10px;
        font-weight: 700;
        font-size: 0.92rem;
    }

    .kpi-item-pill:last-child {
        margin-bottom: 0;
    }

    .pill-blue {
        background: linear-gradient(90deg, rgba(2, 132, 199, 0.35) 0%, rgba(2, 132, 199, 0.18) 100%);
        border: 1px solid rgba(56, 189, 248, 0.4);
        color: #7dd3fc;
    }
    .pill-orange {
        background: linear-gradient(90deg, rgba(234, 88, 12, 0.35) 0%, rgba(234, 88, 12, 0.18) 100%);
        border: 1px solid rgba(251, 146, 60, 0.4);
        color: #fed7aa;
    }
    .pill-green {
        background: linear-gradient(90deg, rgba(22, 163, 74, 0.35) 0%, rgba(22, 163, 74, 0.18) 100%);
        border: 1px solid rgba(74, 222, 128, 0.4);
        color: #bbf7d0;
    }

    .badge-rkap {
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.82rem;
        font-weight: 800;
        min-width: 58px;
        text-align: center;
        display: inline-block;
    }

    /* Percentage Color Rules (>100 / >=100 = Hijau, >=90 & <100 = Kuning, <90 = Merah) */
    .pct-green {
        color: #4ade80 !important;
        font-weight: 700;
    }
    .pct-yellow {
        color: #facc15 !important;
        font-weight: 700;
    }
    .pct-red {
        color: #f87171 !important;
        font-weight: 700;
    }

    .badge-pct-green {
        background: rgba(34, 197, 94, 0.22) !important;
        border: 1px solid rgba(74, 222, 128, 0.5) !important;
        color: #4ade80 !important;
    }
    .badge-pct-yellow {
        background: rgba(234, 179, 8, 0.22) !important;
        border: 1px solid rgba(250, 204, 21, 0.5) !important;
        color: #facc15 !important;
    }
    .badge-pct-red {
        background: rgba(239, 68, 68, 0.22) !important;
        border: 1px solid rgba(248, 113, 113, 0.5) !important;
        color: #f87171 !important;
    }

    /* Remove white outlines from donut/pie slices */
    .apexcharts-pie-slice,
    .apexcharts-donut-slice,
    .apexcharts-pie-area,
    path.apexcharts-pie-area {
        stroke: transparent !important;
        stroke-width: 0 !important;
    }

    /* Ensure combo chart legend never wraps into multiple lines */
    #chartComboKebun .apexcharts-legend {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        white-space: nowrap !important;
        max-width: none !important;
        width: auto !important;
        justify-content: flex-end !important;
        gap: 14px !important;
        overflow: visible !important;
    }
    #chartComboKebun .apexcharts-legend-series {
        display: inline-flex !important;
        align-items: center !important;
        white-space: nowrap !important;
        margin-right: 0 !important;
        margin-bottom: 0 !important;
    }

    /* ============================================================
       TAB 2: MATRIX GRADIENT CARDS & CAPAIAN INDICATORS
       ============================================================ */
    .matrix-wrapper {
        overflow-x: auto;
        width: 100%;
    }
    .matrix-grid-header {
        display: grid;
        grid-template-columns: 140px 1fr 1fr 1fr 110px;
        gap: 12px;
        align-items: center;
        font-size: 0.82rem;
        font-weight: 800;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.04em;
        padding-bottom: 10px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        margin-bottom: 14px;
        min-width: 600px;
    }
    .matrix-grid-row {
        display: grid;
        grid-template-columns: 140px 1fr 1fr 1fr 110px;
        gap: 12px;
        align-items: center;
        margin-bottom: 14px;
        min-width: 600px;
    }
    .matrix-grid-row:last-child {
        margin-bottom: 0;
    }
    .matrix-metric-label {
        font-size: 0.95rem;
        font-weight: 800;
        color: #f8fafc;
        padding-left: 4px;
    }
    .matrix-card-orange {
        background: linear-gradient(180deg, rgba(249, 115, 22, 0.28) 0%, rgba(234, 88, 12, 0.14) 100%);
        border: 1.5px solid rgba(251, 146, 60, 0.55);
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.15);
        border-radius: 8px;
        padding: 12px 10px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(6px);
        transition: all 0.2s ease;
    }
    .matrix-card-orange:hover {
        background: linear-gradient(180deg, rgba(249, 115, 22, 0.38) 0%, rgba(234, 88, 12, 0.20) 100%);
        border-color: rgba(251, 146, 60, 0.75);
    }
    .matrix-card-green {
        background: linear-gradient(180deg, rgba(34, 197, 94, 0.28) 0%, rgba(22, 163, 74, 0.14) 100%);
        border: 1.5px solid rgba(74, 222, 128, 0.55);
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.15);
        border-radius: 8px;
        padding: 12px 10px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(6px);
        transition: all 0.2s ease;
    }
    .matrix-card-green:hover {
        background: linear-gradient(180deg, rgba(34, 197, 94, 0.38) 0%, rgba(22, 163, 74, 0.20) 100%);
        border-color: rgba(74, 222, 128, 0.75);
    }
    .matrix-card-blue {
        background: linear-gradient(180deg, rgba(14, 165, 233, 0.28) 0%, rgba(2, 132, 199, 0.14) 100%);
        border: 1.5px solid rgba(56, 189, 248, 0.55);
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.15);
        border-radius: 8px;
        padding: 12px 10px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(6px);
        transition: all 0.2s ease;
    }
    .matrix-card-blue:hover {
        background: linear-gradient(180deg, rgba(14, 165, 233, 0.38) 0%, rgba(2, 132, 199, 0.20) 100%);
        border-color: rgba(56, 189, 248, 0.75);
    }
    .matrix-val {
        font-size: 1.25rem;
        font-weight: 800;
        color: #ffffff !important;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
        letter-spacing: -0.01em;
    }
    .matrix-indicators-cell {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 14px;
    }

    /* Filters Bar */
    .filter-bar {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }

    .filter-select {
        background-color: var(--bg-card);
        color: var(--text-white);
        border: 1px solid var(--border-color);
        padding: 7px 14px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        outline: none;
        cursor: pointer;
        transition: border-color 0.2s;
    }
    .filter-select:focus {
        border-color: #38bdf8;
    }

    /* Multi-select Dropdown Styling */
    .multiselect-wrapper {
        position: relative;
        display: inline-block;
    }
    .multiselect-trigger {
        background-color: var(--bg-card);
        color: var(--text-white);
        border: 1px solid var(--border-color);
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        user-select: none;
        transition: all 0.2s;
        min-width: 145px;
    }
    .multiselect-trigger:hover,
    .multiselect-wrapper.active .multiselect-trigger {
        border-color: #38bdf8;
        background-color: var(--bg-card-hover);
    }
    .multiselect-dropdown {
        display: none;
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        z-index: 1000;
        min-width: 210px;
        max-width: 320px;
        background: #0b172e;
        border: 1px solid #1e3668;
        border-radius: 10px;
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.9);
        padding: 8px;
        backdrop-filter: blur(10px);
    }
    .multiselect-wrapper.active .multiselect-dropdown {
        display: block;
    }
    .multiselect-search {
        width: 100%;
        padding: 6px 10px;
        font-size: 0.78rem;
        background: #070e1e;
        border: 1px solid #1e3668;
        border-radius: 6px;
        color: #fff;
        outline: none;
        margin-bottom: 6px;
    }
    .multiselect-search:focus {
        border-color: #38bdf8;
    }
    .multiselect-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 6px;
        margin-bottom: 6px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        font-size: 0.72rem;
    }
    .multiselect-action-btn {
        color: #38bdf8;
        background: transparent;
        border: none;
        cursor: pointer;
        font-weight: 700;
        padding: 2px 4px;
        border-radius: 4px;
        transition: color 0.15s;
    }
    .multiselect-action-btn:hover {
        color: #7dd3fc;
        text-decoration: underline;
    }
    .multiselect-list {
        max-height: 200px;
        overflow-y: auto;
    }
    .multiselect-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 5px 8px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.8rem;
        font-weight: 500;
        color: #cbd5e1;
        transition: background 0.15s;
    }
    .multiselect-item:hover {
        background: rgba(255, 255, 255, 0.06);
        color: #ffffff;
    }
    .multiselect-checkbox {
        accent-color: #0284c7;
        width: 14px;
        height: 14px;
        cursor: pointer;
    }
    .multiselect-footer {
        padding-top: 8px;
        margin-top: 6px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }
    .multiselect-apply-btn {
        width: 100%;
        padding: 6px 12px;
        background: #0284c7;
        color: #ffffff;
        font-size: 0.78rem;
        font-weight: 700;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: background 0.15s;
    }
    .multiselect-apply-btn:hover {
        background: #0369a1;
    }

    /* Tables */
    .looker-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.85rem;
    }

    .looker-table thead th {
        background: #1e3a8a;
        color: #ffffff;
        font-weight: 800;
        padding: 10px 14px;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.12);
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .looker-table tbody td {
        padding: 9px 14px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: #f1f5f9;
        font-size: 0.85rem;
    }

    .looker-table tbody tr:hover td {
        background-color: rgba(255, 255, 255, 0.05);
    }

    .table-total-row td {
        background: rgba(30, 58, 138, 0.45) !important;
        font-weight: 800;
        color: #38bdf8 !important;
        border-top: 1px solid rgba(56, 189, 248, 0.4) !important;
    }

    .num-font {
        font-family: 'JetBrains Mono', 'Plus Jakarta Sans', monospace;
        font-feature-settings: "tnum";
        font-variant-numeric: tabular-nums;
    }

    /* Indicator arrows */
    .ind-up { color: #4ade80; font-weight: 700; }
    .ind-down { color: #f87171; font-weight: 700; }

    /* Custom Scroll */
    .custom-scroll::-webkit-scrollbar { height: 6px; width: 6px; }
    .custom-scroll::-webkit-scrollbar-track { background: var(--bg-panel); border-radius: 4px; }
    .custom-scroll::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 4px; }
    .custom-scroll::-webkit-scrollbar-thumb:hover { background: #38bdf8; }

    /* Hidden Tab Panels */
    .tab-panel {
        display: none;
    }
    .tab-panel.active {
        display: block;
        animation: fadeIn 0.25s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(4px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<!-- Top Page Banner -->
<header class="lm-page-header">
    <div class="lm-header-logo">
        <img src="{{ asset('danantara.png') }}" alt="Danantara Indonesia">
    </div>
    <div class="flex items-center gap-2">
        <span class="text-xs uppercase tracking-widest text-slate-400 font-bold">PT PERKEBUNAN NUSANTARA I</span>
    </div>
    <div class="lm-header-logo" style="justify-content: flex-end;">
        <img src="{{ asset('ptpn1.png') }}" alt="PTPN 1">
    </div>
</header>

<div class="dashboard-wrapper">
    @php
        $getPctClass = function($val) {
            $num = floatval(str_replace(['%', ','], ['', '.'], $val));
            if ($num >= 100) return 'pct-green';
            if ($num >= 90) return 'pct-yellow';
            return 'pct-red';
        };

        $getPctBadgeClass = function($val) {
            $num = floatval(str_replace(['%', ','], ['', '.'], $val));
            if ($num >= 100) return 'badge-pct-green';
            if ($num >= 90) return 'badge-pct-yellow';
            return 'badge-pct-red';
        };

        $renderMatrixIndicator = function($val) {
            $num = floatval(str_replace(['%', ','], ['', '.'], $val));
            $isAbove = ($num >= 100);
            $triangleColor = $isAbove ? '#38bdf8' : '#ef4444'; // biru jika >=100, merah jika <100
            
            if ($isAbove) {
                // Segitiga menghadap ke atas (Biru)
                $svg = '<svg width="24" height="20" viewBox="0 0 24 20" fill="' . $triangleColor . '" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.4));"><path d="M12 2L23 19H1L12 2Z"/></svg>';
            } else {
                // Segitiga menghadap ke bawah (Merah)
                $svg = '<svg width="24" height="20" viewBox="0 0 24 20" fill="' . $triangleColor . '" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.4));"><path d="M1 2H23L12 19Z"/></svg>';
            }

            return '<div class="flex flex-col items-center justify-center min-w-[42px]">' .
                $svg .
                '<span class="text-sm font-extrabold text-white mt-1 num-font">' . $val . '%</span>' .
            '</div>';
        };
    @endphp
    
    <!-- Tab Navigation -->
    <div class="tab-nav-container">
        <button type="button" class="tab-btn {{ $activeTab == 'summary' ? 'active' : '' }}" onclick="switchTab('summary')">
            <i class="fa-solid fa-chart-pie"></i> Summary
        </button>
        <button type="button" class="tab-btn {{ $activeTab == 'produktivitas_regional' ? 'active' : '' }}" onclick="switchTab('produktivitas_regional')">
            <i class="fa-solid fa-chart-column"></i> Produktivitas Regional
        </button>
        <button type="button" class="tab-btn {{ $activeTab == 'trend_produksi' ? 'active' : '' }}" onclick="switchTab('trend_produksi')">
            <i class="fa-solid fa-arrow-trend-up"></i> Trend Produksi
        </button>
        <button type="button" class="tab-btn {{ $activeTab == 'rincian_kebun' ? 'active' : '' }}" onclick="switchTab('rincian_kebun')">
            <i class="fa-solid fa-table-list"></i> Rincian Per Kebun
        </button>
    </div>

    <!-- Hidden form to preserve filters when submitting -->
    <form id="filterForm" method="GET" action="{{ route('arealproduksi_repl') }}" class="filter-bar">
        <input type="hidden" name="tab" id="activeTabInput" value="{{ $activeTab }}">
        
        <!-- Regional Filter (Multi-select) -->
        <div id="filterRegionalWrapper" class="flex items-center" style="{{ in_array($activeTab, ['produktivitas_regional', 'trend_produksi', 'rincian_kebun']) ? '' : 'display:none;' }}">
            <span class="text-xs text-slate-400 font-bold mr-1">Regional:</span>
            <div class="multiselect-wrapper" id="multiselectRegional">
                <div class="multiselect-trigger" onclick="toggleMultiselect('multiselectRegional')">
                    <span class="multiselect-label-text">
                        @php
                            $isAllRegSelected = empty($regionalSelected) || in_array('all', $regionalSelected);
                            $regCount = is_array($regionalSelected) ? count($regionalSelected) : 1;
                        @endphp
                        @if($isAllRegSelected || $regCount == count($listRegional))
                            Semua Regional
                        @elseif($regCount == 1)
                            Regional {{ is_array($regionalSelected) ? $regionalSelected[0] : $regionalSelected }}
                        @else
                            {{ $regCount }} Regional Dipilih
                        @endif
                    </span>
                    <i class="fa-solid fa-chevron-down text-slate-400 text-[10px]"></i>
                </div>
                <div class="multiselect-dropdown">
                    <div class="multiselect-actions">
                        <button type="button" class="multiselect-action-btn" onclick="multiselectSelectAll('multiselectRegional', true)">Pilih Semua</button>
                        <button type="button" class="multiselect-action-btn text-slate-400" onclick="multiselectSelectAll('multiselectRegional', false)">Reset</button>
                    </div>
                    <div class="multiselect-list custom-scroll">
                        @foreach($listRegional as $reg)
                            @php
                                $isRegChecked = (is_array($regionalSelected) && in_array($reg, $regionalSelected)) || ($isAllRegSelected && count($regionalSelected) == count($listRegional));
                            @endphp
                            <label class="multiselect-item">
                                <input type="checkbox" name="regional[]" value="{{ $reg }}" class="multiselect-checkbox" 
                                    {{ $isRegChecked ? 'checked' : '' }}
                                    onchange="updateMultiselectDisplay('multiselectRegional', 'Regional', {{ count($listRegional) }})">
                                <span>Regional {{ $reg }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="multiselect-footer">
                        <button type="button" class="multiselect-apply-btn" onclick="submitFilter()">
                            <i class="fa-solid fa-check"></i> Terapkan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kebun Filter (Multi-select) -->
        <div id="filterKebunWrapper" class="flex items-center" style="{{ in_array($activeTab, ['trend_produksi', 'rincian_kebun']) ? '' : 'display:none;' }}">
            <span class="text-xs text-slate-400 font-bold mr-1">Kebun:</span>
            <div class="multiselect-wrapper" id="multiselectKebun">
                <div class="multiselect-trigger" onclick="toggleMultiselect('multiselectKebun')">
                    <span class="multiselect-label-text truncate max-w-[150px]">
                        @php
                            $isAllKebunSelected = empty($kebunSelected) || in_array('all', $kebunSelected);
                            $kebunCount = is_array($kebunSelected) ? count($kebunSelected) : 0;
                        @endphp
                        @if($isAllKebunSelected || $kebunCount == 0 || $kebunCount == count($listKebun))
                            Semua Kebun
                        @elseif($kebunCount == 1)
                            {{ is_array($kebunSelected) ? $kebunSelected[0] : $kebunSelected }}
                        @else
                            {{ $kebunCount }} Kebun Dipilih
                        @endif
                    </span>
                    <i class="fa-solid fa-chevron-down text-slate-400 text-[10px]"></i>
                </div>
                <div class="multiselect-dropdown" style="min-width: 250px;">
                    <input type="text" placeholder="Cari nama kebun..." class="multiselect-search" onkeyup="filterMultiselectList('multiselectKebun', this.value)">
                    <div class="multiselect-actions">
                        <button type="button" class="multiselect-action-btn" onclick="multiselectSelectAll('multiselectKebun', true)">Pilih Semua</button>
                        <button type="button" class="multiselect-action-btn text-slate-400" onclick="multiselectSelectAll('multiselectKebun', false)">Reset</button>
                    </div>
                    <div class="multiselect-list custom-scroll">
                        @foreach($listKebun as $k)
                            @php
                                $isKChecked = is_array($kebunSelected) && in_array($k, $kebunSelected);
                                $kComms = implode(',', $kebunKomoditiMap[$k] ?? []);
                            @endphp
                            <label class="multiselect-item kebun-item" data-komoditi="{{ $kComms }}">
                                <input type="checkbox" name="kebun[]" value="{{ $k }}" class="multiselect-checkbox" 
                                    {{ $isKChecked ? 'checked' : '' }}
                                    onchange="updateKebunMultiselectDisplay()">
                                <span class="truncate">{{ $k }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="multiselect-footer">
                        <button type="button" class="multiselect-apply-btn" onclick="submitFilter()">
                            <i class="fa-solid fa-check"></i> Terapkan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Komoditi Filter (For Tabs 2 & 4) -->
        <div id="filterKomoditiWrapper" style="{{ in_array($activeTab, ['produktivitas_regional', 'rincian_kebun']) ? '' : 'display:none;' }}">
            <span class="text-xs text-slate-400 font-bold mr-1">Komoditi:</span>
            <select name="komoditi" id="selectKomoditi" class="filter-select" onchange="submitFilter()">
                @foreach($listKomoditi as $c)
                    <option value="{{ $c }}" {{ $komoditiSelected == $c ? 'selected' : '' }}>{{ $c }}</option>
                @endforeach
            </select>
        </div>

        <!-- Tahun Filter -->
        <div>
            <span class="text-xs text-slate-400 font-bold mr-1">Tahun:</span>
            <select name="tahun" id="selectTahun" class="filter-select" onchange="submitFilter()">
                @foreach($listTahun as $y)
                    <option value="{{ $y }}" {{ $tahunSelected == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>

        <!-- Periode / Bulan Filter -->
        <div class="flex items-center gap-1.5">
            <span class="text-xs text-slate-400 font-bold mr-0.5">Periode:</span>
            <div class="inline-flex rounded-lg p-0.5 bg-slate-900 border border-slate-700/80 text-xs font-semibold">
                <button type="button" 
                    class="px-2.5 py-1 rounded-md transition-all text-xs font-bold cursor-pointer {{ ($modePeriode ?? 'sd') == 'sd' ? 'bg-sky-600 text-white shadow-sm' : 'text-slate-400 hover:text-white' }}"
                    onclick="setPeriodeMode('sd')">
                    s.d.
                </button>
                <button type="button" 
                    class="px-2.5 py-1 rounded-md transition-all text-xs font-bold cursor-pointer {{ ($modePeriode ?? 'sd') == 'single' ? 'bg-sky-600 text-white shadow-sm' : 'text-slate-400 hover:text-white' }}"
                    onclick="setPeriodeMode('single')">
                    Hanya
                </button>
            </div>
            <input type="hidden" name="mode_periode" id="modePeriodeInput" value="{{ $modePeriode ?? 'sd' }}">

            <select name="bulan" id="selectBulan" class="filter-select font-semibold" onchange="submitFilter()">
                @foreach($listBulan as $num => $nama)
                    <option value="{{ $num }}" {{ $bulanSelected == $num ? 'selected' : '' }}>
                        {{ ($modePeriode ?? 'sd') == 'sd' ? 's.d. ' : '' }}{{ $nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Print Button -->
        <button type="button" onclick="window.print()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-sky-600/30 hover:bg-sky-600/50 text-sky-200 border border-sky-500/40 text-xs font-bold transition-all cursor-pointer">
            <i class="fa-solid fa-print"></i> Cetak
        </button>
    </form>


    <!-- ===================================================================
         TAB 1: SUMMARY (AREAL, PRODUKSI & PRODUKTIVITAS)
         =================================================================== -->
    <div id="tab-summary" class="tab-panel {{ $activeTab == 'summary' ? 'active' : '' }}">
        
        <div class="header-glow-title mb-6">
            AREAL, PRODUKSI &amp; PRODUKTIVITAS
        </div>

        <!-- 3 Grouped Columns KPI Cards -->
        <div class="kpi-row-group">
            
            <!-- Group 1: Luas Areal (Ha) -->
            <div class="kpi-column-box">
                <div class="kpi-column-title">
                    <span>Luas Areal (Ha)</span>
                    <span>% RKAP</span>
                </div>
                @foreach(['KARET', 'TEH', 'ARABICA', 'ROBUSTA'] as $comm)
                    @php $item = $summaryData['cards'][$comm]; @endphp
                    <div class="kpi-item-pill pill-blue">
                        <span class="text-xs font-bold uppercase">{{ ucfirst(strtolower($comm)) }}</span>
                        <div class="flex items-center gap-3">
                            <span class="num-font text-base font-bold">{{ number_format($item['luas_real'], 2, ',', '.') }}</span>
                            <span class="badge-rkap {{ $getPctBadgeClass($item['luas_pct_rkap']) }}">{{ $item['luas_pct_rkap'] }}%</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Group 2: Produksi (Ton) -->
            <div class="kpi-column-box">
                <div class="kpi-column-title">
                    <span>Produksi (Ton)</span>
                    <span>% RKAP</span>
                </div>
                @foreach(['KARET', 'TEH', 'ARABICA', 'ROBUSTA'] as $comm)
                    @php $item = $summaryData['cards'][$comm]; @endphp
                    <div class="kpi-item-pill pill-orange">
                        <span class="text-xs font-bold uppercase">{{ ucfirst(strtolower($comm)) }}</span>
                        <div class="flex items-center gap-3">
                            <span class="num-font text-base font-bold">{{ number_format($item['prod_real_ton'], 2, ',', '.') }}</span>
                            <span class="badge-rkap {{ $getPctBadgeClass($item['prod_pct_rkap']) }}">{{ $item['prod_pct_rkap'] }}%</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Group 3: Produktivitas (Kg/Ha) -->
            <div class="kpi-column-box">
                <div class="kpi-column-title">
                    <span>Produktivitas (Kg/Ha)</span>
                    <span>% RKAP</span>
                </div>
                @foreach(['KARET', 'TEH', 'ARABICA', 'ROBUSTA'] as $comm)
                    @php $item = $summaryData['cards'][$comm]; @endphp
                    <div class="kpi-item-pill pill-green">
                        <span class="text-xs font-bold uppercase">{{ ucfirst(strtolower($comm)) }}</span>
                        <div class="flex items-center gap-3">
                            <span class="num-font text-base font-bold">{{ number_format($item['protas_real'], 2, ',', '.') }}</span>
                            <span class="badge-rkap {{ $getPctBadgeClass($item['protas_pct_rkap']) }}">{{ $item['protas_pct_rkap'] }}%</span>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

        <!-- 3 Visual Charts (Luas, Produksi, Produktivitas) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-8">
            <div class="dark-card p-4">
                <div class="text-xs font-bold uppercase text-slate-300 tracking-wider mb-2">Luas Areal (Ha)</div>
                <div id="chartSummaryLuas" style="min-height: 240px;"></div>
            </div>
            <div class="dark-card p-4">
                <div class="text-xs font-bold uppercase text-slate-300 tracking-wider mb-2">Produksi (Ton)</div>
                <div id="chartSummaryProduksi" style="min-height: 240px;"></div>
            </div>
            <div class="dark-card p-4">
                <div class="text-xs font-bold uppercase text-slate-300 tracking-wider mb-2">Produktivitas (Kg/Ha)</div>
                <div id="chartSummaryProtas" style="min-height: 240px;"></div>
            </div>
        </div>

        <!-- Tabel Perbandingan Produksi & Protas Per Regional -->
        <div class="dark-card p-5">
            <div class="text-xs font-extrabold uppercase text-slate-200 tracking-wider mb-3">
                Tabel Perbandingan Produksi &amp; Protas Per Regional
            </div>
            <div class="overflow-x-auto custom-scroll">
                <table class="looker-table">
                    <thead>
                        <tr>
                            <th style="width: 140px; text-align: left;">Komoditi</th>
                            <th style="width: 50px;">Reg</th>
                            <th>Luas Areal (Ha)</th>
                            <th>Prod Thn Lalu (Ton)</th>
                            <th>Prod RKAP (Ton)</th>
                            <th>Prod Realisasi (Ton)</th>
                            <th>%_TL</th>
                            <th>%_rkap</th>
                            <th>Protas Thn Lalu (Kg/Ha)</th>
                            <th>Protas RKAP (Kg/Ha)</th>
                            <th>Protas Realisasi (Kg/Ha)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(['KARET', 'TEH', 'ARABICA', 'ROBUSTA'] as $idx => $comm)
                            @php 
                                $group = $summaryData['tabelRegional'][$comm]; 
                                $rowCount = count($group['rows']);
                            @endphp
                            @foreach($group['rows'] as $rIdx => $row)
                                <tr>
                                    @if($rIdx === 0)
                                        <td rowspan="{{ $rowCount + 1 }}" style="font-weight: 800; background: rgba(13, 27, 52, 0.7); vertical-align: top; border-right: 1px solid var(--border-color);">
                                            {{ $idx + 1 }}. {{ $comm }}
                                        </td>
                                    @endif
                                    <td class="text-center font-bold">{{ $row['reg'] }}</td>
                                    <td class="text-right num-font">{{ number_format($row['luas_real'], 2, ',', '.') }}</td>
                                    <td class="text-right num-font">{{ number_format($row['prod_thn_lalu_ton'], 2, ',', '.') }}</td>
                                    <td class="text-right num-font">{{ number_format($row['prod_rkap_ton'], 2, ',', '.') }}</td>
                                    <td class="text-right num-font font-bold text-white">{{ number_format($row['prod_real_ton'], 2, ',', '.') }}</td>
                                    <td class="text-center num-font {{ $getPctClass($row['pct_tl']) }}">{{ $row['pct_tl'] }}%</td>
                                    <td class="text-center num-font {{ $getPctClass($row['pct_rkap']) }}">{{ $row['pct_rkap'] }}%</td>
                                    <td class="text-right num-font">{{ number_format($row['protas_thn_lalu'], 2, ',', '.') }}</td>
                                    <td class="text-right num-font">{{ number_format($row['protas_rkap'], 2, ',', '.') }}</td>
                                    <td class="text-right num-font font-bold text-emerald-400">{{ number_format($row['protas_real'], 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            <!-- Total Row -->
                            <tr class="table-total-row">
                                <td class="text-center font-black">Total</td>
                                <td class="text-right num-font font-bold">{{ number_format($group['total']['luas_real'], 2, ',', '.') }}</td>
                                <td class="text-right num-font font-bold">{{ number_format($group['total']['prod_thn_lalu_ton'], 2, ',', '.') }}</td>
                                <td class="text-right num-font font-bold">{{ number_format($group['total']['prod_rkap_ton'], 2, ',', '.') }}</td>
                                <td class="text-right num-font font-bold text-white">{{ number_format($group['total']['prod_real_ton'], 2, ',', '.') }}</td>
                                <td class="text-center num-font font-bold {{ $getPctClass($group['total']['pct_tl']) }}">{{ $group['total']['pct_tl'] }}%</td>
                                <td class="text-center num-font font-bold {{ $getPctClass($group['total']['pct_rkap']) }}">{{ $group['total']['pct_rkap'] }}%</td>
                                <td class="text-right num-font font-bold">{{ number_format($group['total']['protas_thn_lalu'], 2, ',', '.') }}</td>
                                <td class="text-right num-font font-bold">{{ number_format($group['total']['protas_rkap'], 2, ',', '.') }}</td>
                                <td class="text-right num-font font-bold text-emerald-300">{{ number_format($group['total']['protas_real'], 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>


    <!-- ===================================================================
         TAB 2: PRODUKTIVITAS REGIONAL
         =================================================================== -->
    <div id="tab-produktivitas_regional" class="tab-panel {{ $activeTab == 'produktivitas_regional' ? 'active' : '' }}">
        
        <div class="header-glow-title mb-6">
            PRODUKTIVITAS REGIONAL
        </div>

        <!-- Top Section: Donut Chart & Matrix Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 mb-8">
            
            <!-- Donut Chart -->
            <div class="lg:col-span-5 dark-card p-4 flex flex-col">
                <div class="text-xs font-bold uppercase text-slate-300 mb-2">Komposisi Luas Areal Regional</div>
                <div id="chartDonutAreal" style="min-height: 270px;" class="flex-1 flex items-center justify-center"></div>
            </div>

            <!-- Matrix KPI Cards -->
            <div class="lg:col-span-7 dark-card p-4 flex flex-col justify-between">
                <div class="matrix-wrapper custom-scroll">
                    <div class="matrix-grid-header">
                        <div class="text-left pl-2">Metrik</div>
                        <div class="text-center">Tahun Lalu (YoY)</div>
                        <div class="text-center">{{ ($modePeriode ?? 'sd') == 'single' ? 'RKAP (Bulan)' : 'RKAP (YTD)' }}</div>
                        <div class="text-center">{{ ($modePeriode ?? 'sd') == 'single' ? 'Realisasi (Bulan)' : 'Realisasi (YTD)' }}</div>
                        <div class="text-center">% Capaian</div>
                    </div>

                    <!-- Row 1: Luas Areal (Orange Cards) -->
                    @php $m = $regionalData['matrix']; @endphp
                    <div class="matrix-grid-row">
                        <div class="matrix-metric-label">Luas Areal (Ha)</div>
                        <div class="matrix-card-orange">
                            <span class="matrix-val num-font">{{ number_format($m['luas']['thn_lalu'], 2, ',', '.') }}</span>
                        </div>
                        <div class="matrix-card-orange">
                            <span class="matrix-val num-font">{{ number_format($m['luas']['rkap'], 2, ',', '.') }}</span>
                        </div>
                        <div class="matrix-card-orange">
                            <span class="matrix-val num-font">{{ number_format($m['luas']['real'], 2, ',', '.') }}</span>
                        </div>
                        <div class="matrix-indicators-cell">
                            {!! $renderMatrixIndicator($m['luas']['pct_tl']) !!}
                            {!! $renderMatrixIndicator($m['luas']['pct_rkap']) !!}
                        </div>
                    </div>

                    <!-- Row 2: Produksi (Green Cards) -->
                    <div class="matrix-grid-row">
                        <div class="matrix-metric-label">Produksi (Ton)</div>
                        <div class="matrix-card-green">
                            <span class="matrix-val num-font">{{ number_format($m['produksi']['thn_lalu'], 2, ',', '.') }}</span>
                        </div>
                        <div class="matrix-card-green">
                            <span class="matrix-val num-font">{{ number_format($m['produksi']['rkap'], 2, ',', '.') }}</span>
                        </div>
                        <div class="matrix-card-green">
                            <span class="matrix-val num-font">{{ number_format($m['produksi']['real'], 2, ',', '.') }}</span>
                        </div>
                        <div class="matrix-indicators-cell">
                            {!! $renderMatrixIndicator($m['produksi']['pct_tl']) !!}
                            {!! $renderMatrixIndicator($m['produksi']['pct_rkap']) !!}
                        </div>
                    </div>

                    <!-- Row 3: Protas (Blue Cards) -->
                    <div class="matrix-grid-row">
                        <div class="matrix-metric-label">Protas (Kg/Ha)</div>
                        <div class="matrix-card-blue">
                            <span class="matrix-val num-font">{{ number_format($m['protas']['thn_lalu'], 2, ',', '.') }}</span>
                        </div>
                        <div class="matrix-card-blue">
                            <span class="matrix-val num-font">{{ number_format($m['protas']['rkap'], 2, ',', '.') }}</span>
                        </div>
                        <div class="matrix-card-blue">
                            <span class="matrix-val num-font">{{ number_format($m['protas']['real'], 2, ',', '.') }}</span>
                        </div>
                        <div class="matrix-indicators-cell">
                            {!! $renderMatrixIndicator($m['protas']['pct_tl']) !!}
                            {!! $renderMatrixIndicator($m['protas']['pct_rkap']) !!}
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Middle Section: Combo Chart Produktivitas Tiap Kebun -->
        <div class="dark-card p-5 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-2">
                <div class="text-xs font-extrabold uppercase text-slate-200 tracking-wider">
                    Perbandingan Pencapaian Produktivitas Tiap Kebun
                </div>
                <div class="flex items-center gap-6 text-xs font-bold whitespace-nowrap">
                    <span class="flex items-center gap-2 cursor-pointer select-none transition-opacity hover:opacity-80" onclick="toggleComboSeries('Realisasi (Kg/Ha)', this)">
                        <span style="width: 12px; height: 12px; border-radius: 50%; background: #22c55e; border: 2px solid #86efac; display: inline-block; box-shadow: 0 0 8px rgba(34, 197, 94, 0.5);"></span>
                        <span style="color: #f1f5f9;">Realisasi (Kg/Ha)</span>
                    </span>
                    <span class="flex items-center gap-2 cursor-pointer select-none transition-opacity hover:opacity-80" onclick="toggleComboSeries('% Tahun Lalu', this)">
                        <span style="width: 12px; height: 12px; border-radius: 50%; background: #0284c7; border: 2px solid #7dd3fc; display: inline-block; box-shadow: 0 0 8px rgba(2, 132, 199, 0.5);"></span>
                        <span style="color: #38bdf8;">% Tahun Lalu</span>
                    </span>
                    <span class="flex items-center gap-2 cursor-pointer select-none transition-opacity hover:opacity-80" onclick="toggleComboSeries('% RKAP', this)">
                        <span style="width: 12px; height: 12px; border-radius: 50%; background: #ea580c; border: 2px solid #fdba74; display: inline-block; box-shadow: 0 0 8px rgba(234, 88, 12, 0.5);"></span>
                        <span style="color: #fb923c;">% RKAP</span>
                    </span>
                </div>
            </div>
            <div id="chartComboKebun" style="min-height: 320px;"></div>
        </div>

        <!-- Bottom Section: Bubble Chart Luas vs Produksi -->
        <div class="dark-card p-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-2">
                <div class="text-xs font-extrabold uppercase text-slate-200 tracking-wider">
                    Perbandingan Luas Areal terhadap Pencapaian Produksi
                </div>
                <div class="flex items-center gap-5 text-xs font-bold text-slate-300">
                    <span class="flex items-center gap-2">
                        <span style="width: 12px; height: 12px; border-radius: 50%; background: #0284c7; border: 2px solid #7dd3fc; display: inline-block; box-shadow: 0 0 8px rgba(2, 132, 199, 0.5);"></span>
                        <span>Kebun Realisasi</span>
                    </span>
                    <span class="flex items-center gap-2 text-amber-400">
                        <span style="width: 22px; height: 0; border-top: 2.5px dashed #f59e0b; display: inline-block;"></span>
                        <span>Garis Target RKAP (Rasio Normal)</span>
                    </span>
                </div>
            </div>
            <div id="chartBubbleAreal" style="min-height: 340px;"></div>
        </div>

    </div>


    <!-- ===================================================================
         TAB 3: TREND PRODUKSI (4 CHARTS KOMODITI)
         =================================================================== -->
    <div id="tab-trend_produksi" class="tab-panel {{ $activeTab == 'trend_produksi' ? 'active' : '' }}">
        
        <div class="header-glow-title mb-6">
            TREND PRODUKSI
        </div>

        <div class="flex flex-col gap-6">
            @foreach(['KARET', 'TEH', 'ARABICA', 'ROBUSTA'] as $c)
                <div class="dark-card p-5">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-xs font-bold uppercase tracking-wider text-slate-200">
                            {{ $c }} (Kg)
                        </div>
                        <div class="flex items-center gap-5 text-xs font-bold whitespace-nowrap">
                            <span class="flex items-center gap-2 cursor-pointer select-none transition-opacity hover:opacity-80" onclick="toggleTrendSeries('{{ $c }}', 'Tahun Lalu', this)">
                                <span style="width: 12px; height: 12px; border-radius: 50%; background: #0284c7; border: 2px solid #7dd3fc; display: inline-block; box-shadow: 0 0 8px rgba(2, 132, 199, 0.5);"></span>
                                <span style="color: #38bdf8;">Tahun Lalu</span>
                            </span>
                            <span class="flex items-center gap-2 cursor-pointer select-none transition-opacity hover:opacity-80" onclick="toggleTrendSeries('{{ $c }}', 'RKAP', this)">
                                <span style="width: 12px; height: 12px; border-radius: 50%; background: #ea580c; border: 2px solid #fdba74; display: inline-block; box-shadow: 0 0 8px rgba(234, 88, 12, 0.5);"></span>
                                <span style="color: #fb923c;">RKAP</span>
                            </span>
                            <span class="flex items-center gap-2 cursor-pointer select-none transition-opacity hover:opacity-80" onclick="toggleTrendSeries('{{ $c }}', 'Realisasi', this)">
                                <span style="width: 12px; height: 12px; border-radius: 50%; background: #16a34a; border: 2px solid #86efac; display: inline-block; box-shadow: 0 0 8px rgba(22, 163, 74, 0.5);"></span>
                                <span style="color: #4ade80;">Realisasi</span>
                            </span>
                        </div>
                    </div>
                    <div id="chartTrend{{ $c }}" style="min-height: 270px;"></div>
                </div>
            @endforeach
        </div>

    </div>


    <!-- ===================================================================
         TAB 4: RINCIAN PER KEBUN
         =================================================================== -->
    <div id="tab-rincian_kebun" class="tab-panel {{ $activeTab == 'rincian_kebun' ? 'active' : '' }}">
        
        <div class="header-glow-title mb-6">
            RINCIAN DATA PRODUKTIVITAS PER KEBUN
        </div>

        <!-- 3 Executive Top Summary KPI Cards (Clean, Right-Aligned Values, No Progress Bar) -->
        @php $tc = $rincianData['topCards']; @endphp
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
            
            <!-- Card 1: Luas Areal (Ha) -->
            <div class="relative overflow-hidden rounded-2xl p-5 group transition-all duration-300" 
                 style="background: linear-gradient(135deg, rgba(14, 30, 60, 0.75) 0%, rgba(7, 14, 30, 0.95) 100%); border: 1px solid rgba(56, 189, 248, 0.22); box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);">
                <!-- Ambient Glow -->
                <div class="absolute -right-10 -top-10 w-36 h-36 rounded-full pointer-events-none opacity-20 blur-2xl" style="background: #38bdf8;"></div>

                <!-- Header: Icon, Label & Badge -->
                <div class="flex items-center justify-between mb-4 relative z-10">
                    <div class="flex items-center gap-3">
                        <div style="width: 38px; height: 38px; border-radius: 10px; background: rgba(2, 132, 199, 0.18); border: 1px solid rgba(56, 189, 248, 0.3); display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-map-location-dot text-sky-400 text-sm"></i>
                        </div>
                        <div class="text-xs font-black uppercase tracking-wider text-sky-300">Luas Areal</div>
                    </div>
                    <!-- Percentage Badge -->
                    <div class="px-2.5 py-1 rounded-full text-xs font-black num-font flex items-center gap-1.5"
                         style="{{ $tc['luas']['pct'] >= 100 ? 'background: rgba(34, 197, 94, 0.16); border: 1px solid rgba(74, 222, 128, 0.4); color: #4ade80;' : ($tc['luas']['pct'] >= 90 ? 'background: rgba(234, 179, 8, 0.16); border: 1px solid rgba(250, 204, 21, 0.4); color: #facc15;' : 'background: rgba(239, 68, 68, 0.16); border: 1px solid rgba(248, 113, 113, 0.4); color: #f87171;') }}">
                        <i class="fa-solid {{ $tc['luas']['pct'] >= 100 ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }} text-[10px]"></i>
                        <span>{{ $tc['luas']['pct'] }}%</span>
                        <span class="text-[9px] font-bold text-slate-400 opacity-80">RKAP</span>
                    </div>
                </div>

                <!-- Big Hero Number (Rata Kanan) -->
                <div class="mt-3 mb-2 flex items-baseline justify-between relative z-10">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Realisasi</span>
                    <div class="flex items-baseline gap-2 text-right">
                        <span class="text-3xl font-black num-font text-white tracking-tight">
                            {{ number_format($tc['luas']['real'], 2, ',', '.') }}
                        </span>
                        <span class="text-xs font-bold text-sky-400/90 tracking-wide uppercase">Ha</span>
                    </div>
                </div>

                <!-- Sub-stat strip (Satu baris masing-masing, label kiri, nilai kanan, tanpa persentase) -->
                <div class="space-y-2 relative z-10" style="margin-top: 14px; padding-top: 12px; border-top: 1px solid rgba(255, 255, 255, 0.08);">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-[11px] uppercase font-bold text-slate-400">Target RKAP</span>
                        <span class="font-bold text-slate-200 num-font">
                            {{ number_format($tc['luas']['rkap'], 2, ',', '.') }} <span class="text-[10px] font-normal text-slate-400">Ha</span>
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-[11px] uppercase font-bold text-slate-400">Tahun Lalu (YoY)</span>
                        <span class="font-bold text-slate-300 num-font">
                            {{ number_format($tc['luas']['thn_lalu'] ?? 0, 2, ',', '.') }} <span class="text-[10px] font-normal text-slate-400">Ha</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card 2: Produksi (Ton) -->
            <div class="relative overflow-hidden rounded-2xl p-5 group transition-all duration-300" 
                 style="background: linear-gradient(135deg, rgba(30, 22, 14, 0.75) 0%, rgba(14, 10, 7, 0.95) 100%); border: 1px solid rgba(245, 158, 11, 0.22); box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);">
                <!-- Ambient Glow -->
                <div class="absolute -right-10 -top-10 w-36 h-36 rounded-full pointer-events-none opacity-20 blur-2xl" style="background: #f59e0b;"></div>

                <!-- Header: Icon, Label & Badge -->
                <div class="flex items-center justify-between mb-4 relative z-10">
                    <div class="flex items-center gap-3">
                        <div style="width: 38px; height: 38px; border-radius: 10px; background: rgba(245, 158, 11, 0.18); border: 1px solid rgba(245, 158, 11, 0.3); display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-boxes-stacked text-amber-400 text-sm"></i>
                        </div>
                        <div class="text-xs font-black uppercase tracking-wider text-amber-300">Produksi</div>
                    </div>
                    <!-- Percentage Badge -->
                    <div class="px-2.5 py-1 rounded-full text-xs font-black num-font flex items-center gap-1.5"
                         style="{{ $tc['produksi']['pct'] >= 100 ? 'background: rgba(34, 197, 94, 0.16); border: 1px solid rgba(74, 222, 128, 0.4); color: #4ade80;' : ($tc['produksi']['pct'] >= 90 ? 'background: rgba(234, 179, 8, 0.16); border: 1px solid rgba(250, 204, 21, 0.4); color: #facc15;' : 'background: rgba(239, 68, 68, 0.16); border: 1px solid rgba(248, 113, 113, 0.4); color: #f87171;') }}">
                        <i class="fa-solid {{ $tc['produksi']['pct'] >= 100 ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }} text-[10px]"></i>
                        <span>{{ $tc['produksi']['pct'] }}%</span>
                        <span class="text-[9px] font-bold text-slate-400 opacity-80">RKAP</span>
                    </div>
                </div>

                <!-- Big Hero Number (Rata Kanan) -->
                <div class="mt-3 mb-2 flex items-baseline justify-between relative z-10">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Realisasi</span>
                    <div class="flex items-baseline gap-2 text-right">
                        <span class="text-3xl font-black num-font text-white tracking-tight">
                            {{ number_format($tc['produksi']['real'], 2, ',', '.') }}
                        </span>
                        <span class="text-xs font-bold text-amber-400/90 tracking-wide uppercase">Ton</span>
                    </div>
                </div>

                <!-- Sub-stat strip (Satu baris masing-masing, label kiri, nilai kanan, tanpa persentase) -->
                <div class="space-y-2 relative z-10" style="margin-top: 14px; padding-top: 12px; border-top: 1px solid rgba(255, 255, 255, 0.08);">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-[11px] uppercase font-bold text-slate-400">Target RKAP</span>
                        <span class="font-bold text-slate-200 num-font">
                            {{ number_format($tc['produksi']['rkap'], 2, ',', '.') }} <span class="text-[10px] font-normal text-slate-400">Ton</span>
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-[11px] uppercase font-bold text-slate-400">Tahun Lalu (YoY)</span>
                        <span class="font-bold text-slate-300 num-font">
                            {{ number_format($tc['produksi']['thn_lalu'] ?? 0, 2, ',', '.') }} <span class="text-[10px] font-normal text-slate-400">Ton</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card 3: Produktivitas (Kg/Ha) -->
            <div class="relative overflow-hidden rounded-2xl p-5 group transition-all duration-300" 
                 style="background: linear-gradient(135deg, rgba(10, 32, 22, 0.75) 0%, rgba(6, 18, 12, 0.95) 100%); border: 1px solid rgba(34, 197, 94, 0.22); box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);">
                <!-- Ambient Glow -->
                <div class="absolute -right-10 -top-10 w-36 h-36 rounded-full pointer-events-none opacity-20 blur-2xl" style="background: #22c55e;"></div>

                <!-- Header: Icon, Label & Badge -->
                <div class="flex items-center justify-between mb-4 relative z-10">
                    <div class="flex items-center gap-3">
                        <div style="width: 38px; height: 38px; border-radius: 10px; background: rgba(34, 197, 94, 0.18); border: 1px solid rgba(74, 222, 128, 0.3); display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-gauge-high text-emerald-400 text-sm"></i>
                        </div>
                        <div class="text-xs font-black uppercase tracking-wider text-emerald-300">Produktivitas</div>
                    </div>
                    <!-- Percentage Badge -->
                    <div class="px-2.5 py-1 rounded-full text-xs font-black num-font flex items-center gap-1.5"
                         style="{{ $tc['protas']['pct'] >= 100 ? 'background: rgba(34, 197, 94, 0.16); border: 1px solid rgba(74, 222, 128, 0.4); color: #4ade80;' : ($tc['protas']['pct'] >= 90 ? 'background: rgba(234, 179, 8, 0.16); border: 1px solid rgba(250, 204, 21, 0.4); color: #facc15;' : 'background: rgba(239, 68, 68, 0.16); border: 1px solid rgba(248, 113, 113, 0.4); color: #f87171;') }}">
                        <i class="fa-solid {{ $tc['protas']['pct'] >= 100 ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }} text-[10px]"></i>
                        <span>{{ $tc['protas']['pct'] }}%</span>
                        <span class="text-[9px] font-bold text-slate-400 opacity-80">RKAP</span>
                    </div>
                </div>

                <!-- Big Hero Number (Rata Kanan) -->
                <div class="mt-3 mb-2 flex items-baseline justify-between relative z-10">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Realisasi</span>
                    <div class="flex items-baseline gap-2 text-right">
                        <span class="text-3xl font-black num-font text-white tracking-tight">
                            {{ number_format($tc['protas']['real'], 2, ',', '.') }}
                        </span>
                        <span class="text-xs font-bold text-emerald-400/90 tracking-wide uppercase">Kg/Ha</span>
                    </div>
                </div>

                <!-- Sub-stat strip (Satu baris masing-masing, label kiri, nilai kanan, tanpa persentase) -->
                <div class="space-y-2 relative z-10" style="margin-top: 14px; padding-top: 12px; border-top: 1px solid rgba(255, 255, 255, 0.08);">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-[11px] uppercase font-bold text-slate-400">Target RKAP</span>
                        <span class="font-bold text-slate-200 num-font">
                            {{ number_format($tc['protas']['rkap'], 2, ',', '.') }} <span class="text-[10px] font-normal text-slate-400">Kg/Ha</span>
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-[11px] uppercase font-bold text-slate-400">Tahun Lalu (YoY)</span>
                        <span class="font-bold text-slate-300 num-font">
                            {{ number_format($tc['protas']['thn_lalu'] ?? 0, 2, ',', '.') }} <span class="text-[10px] font-normal text-slate-400">Kg/Ha</span>
                        </span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Tabel Perbandingan Per Kebun -->
        <div class="dark-card p-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-3">
                <div class="text-xs font-extrabold uppercase text-slate-200 tracking-wider">
                    TABEL PERBANDINGAN PER KEBUN
                </div>
                <!-- Quick Search Input -->
                <div class="relative">
                    <input type="text" id="tableSearchInput" onkeyup="filterKebunTable()" placeholder="Cari nama kebun..." class="px-3 py-1 text-xs rounded-lg bg-slate-800 text-white border border-slate-700 focus:outline-none focus:border-sky-400 w-48 font-medium">
                </div>
            </div>

            <div class="overflow-x-auto custom-scroll">
                <table class="looker-table" id="rincianKebunTable">
                    <thead>
                        <tr>
                            <th style="width: 45px;">Reg</th>
                            <th style="text-align: left; width: 180px;">Kebun</th>
                            <th>Luas Real (Ha)</th>
                            <th>Prod TL (Ton)</th>
                            <th>Prod RKAP (Ton)</th>
                            <th>Prod Real (Ton)</th>
                            <th>% TL</th>
                            <th>% RKAP</th>
                            <th>Protas TL (Kg/Ha)</th>
                            <th>Protas RKAP (Kg/Ha)</th>
                            <th>Protas Real (Kg/Ha)</th>
                            <th title="% Capaian Produktivitas terhadap Tahun Lalu">% TL</th>
                            <th title="% Capaian Produktivitas terhadap RKAP">% RKAP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rincianData['rows'] as $r)
                            <tr>
                                <td class="text-center font-bold">{{ $r['reg'] }}</td>
                                <td class="font-bold text-white kebun-name-cell">{{ $r['kebun'] }}</td>
                                <td class="text-right num-font">{{ number_format($r['luas_real'], 2, ',', '.') }}</td>
                                <td class="text-right num-font">{{ number_format($r['prod_tl_ton'], 2, ',', '.') }}</td>
                                <td class="text-right num-font">{{ number_format($r['prod_rkap_ton'], 2, ',', '.') }}</td>
                                <td class="text-right num-font font-bold text-white">{{ number_format($r['prod_real_ton'], 2, ',', '.') }}</td>
                                <td class="text-center num-font {{ $getPctClass($r['pct_tl']) }}">{{ $r['pct_tl'] }}%</td>
                                <td class="text-center num-font {{ $getPctClass($r['pct_rkap']) }}">{{ $r['pct_rkap'] }}%</td>
                                <td class="text-right num-font">{{ number_format($r['protas_tl'], 2, ',', '.') }}</td>
                                <td class="text-right num-font">{{ number_format($r['protas_rkap'], 2, ',', '.') }}</td>
                                <td class="text-right num-font font-bold text-emerald-400">{{ number_format($r['protas_real'], 2, ',', '.') }}</td>
                                <td class="text-center num-font {{ $getPctClass($r['protas_pct_tl']) }}">{{ $r['protas_pct_tl'] }}%</td>
                                <td class="text-center num-font {{ $getPctClass($r['protas_pct_rkap']) }}">{{ $r['protas_pct_rkap'] }}%</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="13" class="text-center py-6 text-slate-400">Tidak ada data untuk filter yang dipilih.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

<!-- ===================================================================
     JAVASCRIPT: TAB SWITCHING, FILTERS & APEXCHARTS
     =================================================================== -->
<script>
    // Tab Switching Function
    function switchTab(tabId) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));

        const targetBtn = document.querySelector(`.tab-btn[onclick="switchTab('${tabId}')"]`);
        if (targetBtn) targetBtn.classList.add('active');

        const targetPanel = document.getElementById('tab-' + tabId);
        if (targetPanel) targetPanel.classList.add('active');

        document.getElementById('activeTabInput').value = tabId;

        // Toggle Filter Visibility depending on tab
        const regWrapper = document.getElementById('filterRegionalWrapper');
        const kebunWrapper = document.getElementById('filterKebunWrapper');
        const komoditiWrapper = document.getElementById('filterKomoditiWrapper');
        const selectKomoditi = document.getElementById('selectKomoditi');

        if (tabId === 'summary') {
            regWrapper.style.display = 'none';
            kebunWrapper.style.display = 'none';
            komoditiWrapper.style.display = 'none';
            if (selectKomoditi) selectKomoditi.disabled = true;
        } else if (tabId === 'produktivitas_regional') {
            regWrapper.style.display = '';
            kebunWrapper.style.display = 'none';
            komoditiWrapper.style.display = '';
            if (selectKomoditi) selectKomoditi.disabled = false;
        } else if (tabId === 'trend_produksi') {
            regWrapper.style.display = '';
            kebunWrapper.style.display = '';
            komoditiWrapper.style.display = 'none';
            // Disable komoditi agar Tab 3 Trend Produksi sama sekali tidak terpengaruh filter komoditi
            if (selectKomoditi) selectKomoditi.disabled = true;
            updateKebunFilterByTab('trend_produksi');
        } else if (tabId === 'rincian_kebun') {
            regWrapper.style.display = '';
            kebunWrapper.style.display = '';
            komoditiWrapper.style.display = '';
            if (selectKomoditi) selectKomoditi.disabled = false;
            updateKebunFilterByTab('rincian_kebun');
        }

        // Trigger chart redraw when tab becomes visible
        window.dispatchEvent(new Event('resize'));
    }

    function submitFilter() {
        const activeTab = document.getElementById('activeTabInput').value;
        const selectKomoditi = document.getElementById('selectKomoditi');
        if (activeTab === 'trend_produksi' || activeTab === 'summary') {
            if (selectKomoditi) selectKomoditi.disabled = true;
        }
        document.getElementById('filterForm').submit();
    }

    function setPeriodeMode(mode) {
        const input = document.getElementById('modePeriodeInput');
        if (input && input.value !== mode) {
            input.value = mode;
            submitFilter();
        }
    }

    // Multi-select Dropdown Handlers
    function toggleMultiselect(id) {
        const el = document.getElementById(id);
        if (!el) return;
        const isActive = el.classList.contains('active');
        document.querySelectorAll('.multiselect-wrapper').forEach(w => w.classList.remove('active'));
        if (!isActive) {
            el.classList.add('active');
            const searchInput = el.querySelector('.multiselect-search');
            if (searchInput) {
                searchInput.value = '';
                filterMultiselectList(id, '');
                setTimeout(() => searchInput.focus(), 60);
            }
        }
    }

    function multiselectSelectAll(id, checkAll) {
        const wrapper = document.getElementById(id);
        if (!wrapper) return;
        const checkboxes = wrapper.querySelectorAll('.multiselect-checkbox');
        checkboxes.forEach(cb => {
            if (cb.closest('.multiselect-item').style.display !== 'none') {
                cb.checked = checkAll;
            }
        });
        if (id === 'multiselectKebun') {
            updateKebunMultiselectDisplay();
        } else {
            const prefix = id.includes('Regional') ? 'Regional' : 'Kebun';
            updateMultiselectDisplay(id, prefix, checkboxes.length);
        }
    }

    function updateMultiselectDisplay(id, prefix, totalCount) {
        const wrapper = document.getElementById(id);
        if (!wrapper) return;
        const checked = wrapper.querySelectorAll('.multiselect-checkbox:checked');
        const labelText = wrapper.querySelector('.multiselect-label-text');
        if (!labelText) return;

        if (checked.length === 0 || checked.length === totalCount) {
            labelText.textContent = prefix === 'Regional' ? 'Semua Regional' : 'Semua Kebun';
        } else if (checked.length === 1) {
            const val = checked[0].value;
            labelText.textContent = prefix === 'Regional' ? 'Regional ' + val : val;
        } else {
            labelText.textContent = checked.length + ' ' + prefix + ' Dipilih';
        }
    }

    // Khusus Kebun: Update display label teks berdasarkan item yang terlihat
    function updateKebunMultiselectDisplay() {
        const wrapper = document.getElementById('multiselectKebun');
        if (!wrapper) return;
        const labelText = wrapper.querySelector('.multiselect-label-text');
        if (!labelText) return;

        const visibleItems = Array.from(wrapper.querySelectorAll('.kebun-item')).filter(it => it.style.display !== 'none');
        const checkedVisible = visibleItems.filter(it => it.querySelector('.multiselect-checkbox').checked);

        if (checkedVisible.length === 0 || checkedVisible.length === visibleItems.length) {
            labelText.textContent = 'Semua Kebun';
        } else if (checkedVisible.length === 1) {
            labelText.textContent = checkedVisible[0].querySelector('span').textContent.trim();
        } else {
            labelText.textContent = checkedVisible.length + ' Kebun Dipilih';
        }
    }

    // Filter daftar kebun berdasarkan Tab (Tab 3: Tampilkan SEMUA kebun; Tab 4: Tampilkan kebun sesuai komoditi terpilih)
    function updateKebunFilterByTab(tabId) {
        const activeTab = tabId || document.getElementById('activeTabInput').value;
        const selectKomoditi = document.getElementById('selectKomoditi');
        const selectedComm = selectKomoditi ? selectKomoditi.value : '';

        const items = document.querySelectorAll('#multiselectKebun .kebun-item');
        items.forEach(it => {
            if (activeTab === 'trend_produksi') {
                // Tab 3 Trend Produksi: Bebas dari filter komoditi, tampilkan seluruh kebun
                it.style.display = '';
            } else if (activeTab === 'rincian_kebun') {
                // Tab 4 Rincian Kebun: Tampilkan hanya kebun yang menghasilkan komoditi terpilih
                const comms = (it.dataset.komoditi || '').split(',');
                const matchesComm = !selectedComm || selectedComm === 'all' || comms.includes(selectedComm);
                it.style.display = matchesComm ? '' : 'none';
            } else {
                it.style.display = '';
            }
        });

        updateKebunMultiselectDisplay();
    }

    function filterMultiselectList(id, query) {
        const wrapper = document.getElementById(id);
        if (!wrapper) return;
        const q = query.toLowerCase();
        const activeTab = document.getElementById('activeTabInput').value;
        const selectKomoditi = document.getElementById('selectKomoditi');
        const selectedComm = selectKomoditi ? selectKomoditi.value : '';

        const items = wrapper.querySelectorAll('.multiselect-item');
        items.forEach(it => {
            const text = it.textContent.toLowerCase();
            const matchesQuery = text.includes(q);

            if (id === 'multiselectKebun' && activeTab === 'rincian_kebun') {
                const comms = (it.dataset.komoditi || '').split(',');
                const matchesComm = !selectedComm || selectedComm === 'all' || comms.includes(selectedComm);
                it.style.display = (matchesQuery && matchesComm) ? '' : 'none';
            } else {
                it.style.display = matchesQuery ? '' : 'none';
            }
        });
    }

    // Close multiselects when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.multiselect-wrapper')) {
            document.querySelectorAll('.multiselect-wrapper').forEach(w => w.classList.remove('active'));
        }
    });

    // Client-side search for Tab 4 Table
    function filterKebunTable() {
        const input = document.getElementById('tableSearchInput');
        const filter = input.value.toUpperCase();
        const table = document.getElementById('rincianKebunTable');
        const tr = table.getElementsByTagName('tr');

        for (let i = 1; i < tr.length; i++) {
            const td = tr[i].getElementsByClassName('kebun-name-cell')[0];
            if (td) {
                const txtValue = td.textContent || td.innerText;
                tr[i].style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? '' : 'none';
            }
        }
    }

    // =================================================================
    // APEXCHARTS INITIALIZATION (Dark High-Contrast Theme)
    // =================================================================
    document.addEventListener('DOMContentLoaded', function () {
        const initialTab = document.getElementById('activeTabInput').value;
        updateKebunFilterByTab(initialTab);
        if (initialTab === 'trend_produksi' || initialTab === 'summary') {
            const selectKomoditi = document.getElementById('selectKomoditi');
            if (selectKomoditi) selectKomoditi.disabled = true;
        }

        const fontFam = 'Plus Jakarta Sans, sans-serif';
        const darkTheme = {
            mode: 'dark',
            palette: 'palette1',
            monochrome: { enabled: false }
        };

        // -------------------------------------------------------------
        // TAB 1: 3 SUMMARY CHARTS (Luas, Produksi, Produktivitas)
        // -------------------------------------------------------------
        const sCats = @json($summaryData['chartData']['categories']);
        
        function makeBarOptions(series, unit) {
            return {
                theme: darkTheme,
                chart: {
                    type: 'bar',
                    height: 240,
                    background: 'transparent',
                    fontFamily: fontFam,
                    toolbar: { show: false }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        borderRadius: 4
                    }
                },
                dataLabels: { enabled: false },
                stroke: {
                    show: true,
                    width: 1.5,
                    colors: ['#38bdf8', '#fbbf24', '#34d399']
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        type: 'vertical',
                        shadeIntensity: 0.35,
                        inverseColors: false,
                        opacityFrom: 0.72,
                        opacityTo: 0.22,
                        stops: [0, 100]
                    }
                },
                colors: ['#0284c7', '#f59e0b', '#10b981'],
                xaxis: {
                    categories: sCats,
                    labels: { style: { colors: '#cbd5e1', fontSize: '11px', fontWeight: 700 } }
                },
                yaxis: {
                    labels: {
                        style: { colors: '#cbd5e1', fontSize: '11px', fontFamily: "'JetBrains Mono', monospace", fontWeight: 600 },
                        formatter: function(val) {
                            if (val >= 1000) return (val / 1000).toLocaleString('id-ID') + ' rb';
                            return val.toLocaleString('id-ID');
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val.toLocaleString('id-ID', { maximumFractionDigits: 2 }) + ' ' + unit;
                        }
                    }
                },
                legend: {
                    position: 'top',
                    labels: { colors: '#cbd5e1' },
                    fontSize: '12px'
                },
                grid: {
                    borderColor: 'rgba(255, 255, 255, 0.08)'
                },
                series: series
            };
        }

        const chartLuas = new ApexCharts(document.getElementById('chartSummaryLuas'), makeBarOptions([
            { name: 'Tahun Lalu (YoY)', data: @json($summaryData['chartData']['luas']['thn_lalu']) },
            { name: 'RKAP', data: @json($summaryData['chartData']['luas']['rkap']) },
            { name: 'Realisasi {{ ($modePeriode ?? "sd") == "single" ? "(Bulan)" : "(YTD)" }}', data: @json($summaryData['chartData']['luas']['real']) }
        ], 'Ha'));
        chartLuas.render();

        const chartProd = new ApexCharts(document.getElementById('chartSummaryProduksi'), makeBarOptions([
            { name: 'Tahun Lalu (YoY)', data: @json($summaryData['chartData']['produksi']['thn_lalu']) },
            { name: 'RKAP', data: @json($summaryData['chartData']['produksi']['rkap']) },
            { name: 'Real {{ ($modePeriode ?? "sd") == "single" ? "(Bulan)" : "(YTD)" }}', data: @json($summaryData['chartData']['produksi']['real']) }
        ], 'Ton'));
        chartProd.render();

        const chartProtas = new ApexCharts(document.getElementById('chartSummaryProtas'), makeBarOptions([
            { name: 'Tahun Lalu (YoY)', data: @json($summaryData['chartData']['protas']['thn_lalu']) },
            { name: 'RKAP', data: @json($summaryData['chartData']['protas']['rkap']) },
            { name: 'Real {{ ($modePeriode ?? "sd") == "single" ? "(Bulan)" : "(YTD)" }}', data: @json($summaryData['chartData']['protas']['real']) }
        ], 'Kg/Ha'));
        chartProtas.render();


        // -------------------------------------------------------------
        // TAB 2: PRODUKTIVITAS REGIONAL (Donut, Combo, Bubble)
        // -------------------------------------------------------------
        
        // 1. Donut Chart
        const donutOptions = {
            theme: darkTheme,
            chart: {
                type: 'donut',
                height: 270,
                background: 'transparent',
                fontFamily: fontFam
            },
            stroke: {
                show: false,
                width: 0,
                colors: ['transparent']
            },
            fill: {
                opacity: 0.72
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%'
                    },
                    expandOnClick: false
                }
            },
            series: @json($regionalData['donut']['series']),
            labels: @json($regionalData['donut']['labels']),
            colors: ['#38bdf8', '#fb923c', '#4ade80', '#c084fc', '#f43f5e', '#a3e635', '#06b6d4', '#e879f9', '#facc15', '#94a3b8', '#fdba74', '#6ee7b7', '#93c5fd', '#f472b6', '#cbd5e1'],
            legend: {
                position: 'right',
                labels: { colors: '#cbd5e1' },
                fontSize: '11px',
                fontFamily: fontFam
            },
            dataLabels: {
                dropShadow: {
                    enabled: true,
                    top: 1,
                    left: 1,
                    blur: 2,
                    color: '#000000',
                    opacity: 0.95
                },
                style: {
                    fontSize: '11px',
                    fontFamily: "'JetBrains Mono', 'Plus Jakarta Sans', monospace",
                    fontWeight: 800,
                    colors: ['#ffffff']
                },
                formatter: function (val) {
                    return val.toFixed(1) + "%";
                }
            },
            tooltip: {
                theme: 'dark',
                style: {
                    fontSize: '12px',
                    fontFamily: fontFam
                },
                y: {
                    formatter: function(val) {
                        return Number(val).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' Ha';
                    }
                }
            }
        };
        const chartDonut = new ApexCharts(document.getElementById('chartDonutAreal'), donutOptions);
        chartDonut.render();

        // 2. Combo Chart (Bar = Protas Real, Line = % TL & % RKAP)
        const comboCats = @json($regionalData['combo']['categories']);
        const comboOptions = {
            theme: darkTheme,
            chart: {
                type: 'line',
                height: 330,
                background: 'transparent',
                fontFamily: fontFam,
                toolbar: { show: false }
            },
            stroke: {
                width: [1.5, 2.5, 2.5],
                curve: 'smooth',
                colors: ['#4ade80', '#0284c7', '#ea580c']
            },
            fill: {
                type: ['gradient', 'solid', 'solid'],
                gradient: {
                    shade: 'dark',
                    type: 'vertical',
                    shadeIntensity: 0.35,
                    gradientToColors: ['#22c55e', undefined, undefined],
                    inverseColors: false,
                    opacityFrom: 0.70, // soft translucent bar top
                    opacityTo: 0.20,   // elegant glass bar bottom
                    stops: [0, 100]
                }
            },
            dataLabels: {
                enabled: true,
                enabledOnSeries: [0],
                offsetY: -10,
                formatter: function (val) {
                    if (val === null || val === undefined) return '';
                    if (val >= 1000) {
                        return (val / 1000).toLocaleString('id-ID', { minimumFractionDigits: 1, maximumFractionDigits: 1 }) + ' rb';
                    }
                    return Number(val).toLocaleString('id-ID', { maximumFractionDigits: 1 });
                },
                style: {
                    fontSize: '11px',
                    fontFamily: "'JetBrains Mono', 'Plus Jakarta Sans', monospace",
                    fontWeight: 800,
                    colors: ['#ffffff']
                },
                background: {
                    enabled: false
                },
                dropShadow: {
                    enabled: true,
                    top: 1,
                    left: 1,
                    blur: 3,
                    color: '#000000',
                    opacity: 0.95
                }
            },
            plotOptions: {
                bar: {
                    columnWidth: '45%',
                    borderRadius: 4,
                    dataLabels: {
                        position: 'top'
                    }
                }
            },
            colors: ['#22c55e', '#0284c7', '#ea580c'],
            series: [
                { name: 'Realisasi (Kg/Ha)', type: 'column', data: @json($regionalData['combo']['bar']) },
                { name: '% Tahun Lalu', type: 'line', data: @json($regionalData['combo']['line_tl']) },
                { name: '% RKAP', type: 'line', data: @json($regionalData['combo']['line_rkap']) }
            ],
            xaxis: {
                categories: comboCats,
                labels: {
                    style: { colors: '#cbd5e1', fontSize: '11px', fontWeight: 600 },
                    rotate: -35
                }
            },
            yaxis: [
                {
                    title: { text: 'Protas (Kg/Ha)', style: { color: '#cbd5e1', fontSize: '11px' } },
                    labels: { style: { colors: '#cbd5e1', fontSize: '11px', fontFamily: "'JetBrains Mono', monospace" } },
                    max: function(max) { return Math.ceil((max * 1.18) / 100) * 100; }
                },
                {
                    opposite: true,
                    title: { text: '% Capaian', style: { color: '#cbd5e1', fontSize: '11px' } },
                    labels: {
                        style: { colors: '#cbd5e1', fontSize: '11px', fontFamily: "'JetBrains Mono', monospace" },
                        formatter: function(val) { return Math.round(val) + '%'; }
                    }
                }
            ],
            tooltip: {
                y: {
                    formatter: function(val, { seriesIndex }) {
                        if (val === null || val === undefined) return '';
                        if (seriesIndex === 0) {
                            return Number(val).toLocaleString('id-ID', { maximumFractionDigits: 2 }) + ' Kg/Ha';
                        }
                        return Number(val).toLocaleString('id-ID', { maximumFractionDigits: 1 }) + '%';
                    }
                }
            },
            legend: {
                show: false
            },
            grid: {
                borderColor: 'rgba(255, 255, 255, 0.08)',
                padding: {
                    top: 10,
                    right: 15,
                    left: 15
                }
            }
        };
        const chartCombo = new ApexCharts(document.getElementById('chartComboKebun'), comboOptions);
        chartCombo.render();

        function toggleComboSeries(seriesName, el) {
            if (typeof chartCombo !== 'undefined') {
                chartCombo.toggleSeries(seriesName);
                el.classList.toggle('opacity-35');
                el.classList.toggle('line-through');
            }
        }

        // 3. Bubble Chart (Luas vs Produksi)
        const bubbleRaw = @json($regionalData['bubble']);
        const targetProtasRkap = {{ (float)($regionalData['matrix']['protas']['rkap'] ?? 0) }};

        // Calculate dynamic round ranges for X & Y axes so bubbles are never cut off
        const xVals = bubbleRaw.map(b => parseFloat(b.x)).filter(v => !isNaN(v) && v > 0);
        const maxXVal = xVals.length > 0 ? Math.max(...xVals) : 2000;
        
        let xStep = 250;
        if (maxXVal > 4000) xStep = 1000;
        else if (maxXVal > 2500) xStep = 500;
        else if (maxXVal > 1200) xStep = 250;
        else if (maxXVal > 500) xStep = 100;
        else xStep = 50;

        // Give ~20% headroom and round up to next clean step
        const xMaxRound = Math.ceil((maxXVal * 1.20) / xStep) * xStep;
        const xTicks = Math.round(xMaxRound / xStep);

        const yVals = bubbleRaw.map(b => parseFloat(b.y)).filter(v => !isNaN(v) && v > 0);
        const maxYVal = yVals.length > 0 ? Math.max(...yVals) : 2000000;
        let yStep = 500000;
        if (maxYVal > 5000000) yStep = 1000000;
        else if (maxYVal < 500000) yStep = 100000;
        const yMaxRound = Math.ceil((maxYVal * 1.15) / yStep) * yStep;
        const yTicks = Math.round(yMaxRound / yStep);

        const bubbleSeries = [{
            name: 'Kebun',
            data: bubbleRaw.map(b => ({
                x: b.x,
                y: b.y,
                z: Math.max(12, Math.min(28, (b.x / 100) * 1.8)),
                kebunName: b.name,
                protas: b.protas,
                pct_rkap: b.pct_rkap
            }))
        }];

        // Function to draw Target RKAP Ratio Line across the bubble chart
        function drawTargetRkapLine(chartContext) {
            if (!chartContext || !chartContext.el) return;
            const inner = chartContext.el.querySelector('.apexcharts-inner');
            if (!inner) return;

            // Remove existing line group if already drawn
            const existingGroup = inner.querySelector('#targetRkapLineGroup');
            if (existingGroup) existingGroup.remove();

            if (!targetProtasRkap || targetProtasRkap <= 0) return;

            let gW = chartContext.w?.globals?.gridWidth;
            let gH = chartContext.w?.globals?.gridHeight;

            if (!gW || !gH || gW <= 0 || gH <= 0) {
                const gridBorder = inner.querySelector('.apexcharts-grid-borders') || inner.querySelector('.apexcharts-grid');
                if (gridBorder) {
                    const bbox = gridBorder.getBBox();
                    gW = bbox.width;
                    gH = bbox.height;
                }
            }

            if (!gW || !gH || gW <= 0 || gH <= 0) return;

            // Target line: Y = targetProtasRkap * X
            let xEnd = xMaxRound;
            let yEnd = xMaxRound * targetProtasRkap;

            if (yEnd > yMaxRound) {
                yEnd = yMaxRound;
                xEnd = yMaxRound / targetProtasRkap;
            }

            // Map Cartesian coordinates to SVG inner space: (0,0) -> (0, gH)
            const px0 = 0;
            const py0 = gH;
            const pxEnd = (xEnd / xMaxRound) * gW;
            const pyEnd = gH - ((yEnd / yMaxRound) * gH);

            const svgNS = "http://www.w3.org/2000/svg";
            const g = document.createElementNS(svgNS, "g");
            g.setAttribute("id", "targetRkapLineGroup");
            g.style.pointerEvents = "all";

            // Hit area line for comfortable hover interaction along the line
            const hitLine = document.createElementNS(svgNS, "line");
            hitLine.setAttribute("x1", px0);
            hitLine.setAttribute("y1", py0);
            hitLine.setAttribute("x2", pxEnd);
            hitLine.setAttribute("y2", pyEnd);
            hitLine.setAttribute("stroke", "transparent");
            hitLine.setAttribute("stroke-width", "24");
            hitLine.setAttribute("stroke-linecap", "round");
            hitLine.style.cursor = "pointer";
            hitLine.style.pointerEvents = "stroke";

            // Dashed Target Line
            const line = document.createElementNS(svgNS, "line");
            line.setAttribute("x1", px0);
            line.setAttribute("y1", py0);
            line.setAttribute("x2", pxEnd);
            line.setAttribute("y2", pyEnd);
            line.setAttribute("stroke", "#f59e0b"); // Vibrant amber/gold
            line.setAttribute("stroke-width", "2.5");
            line.setAttribute("stroke-dasharray", "8, 5");
            line.setAttribute("stroke-linecap", "round");
            line.style.filter = "drop-shadow(0px 2px 4px rgba(0,0,0,0.85))";
            line.style.pointerEvents = "none";

            const title = document.createElementNS(svgNS, "title");
            title.textContent = "Garis Target RKAP: " + Number(targetProtasRkap).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + " Kg/Ha (Rasio Normal)";
            line.appendChild(title);

            g.appendChild(hitLine);
            g.appendChild(line);

            // Badge Pill along the target line (hidden by default, appears only on hover)
            const tInit = 0.50;
            const initX = px0 + (pxEnd - px0) * tInit;
            const initY = py0 + (pyEnd - py0) * tInit;

            const badgeG = document.createElementNS(svgNS, "g");
            badgeG.setAttribute("id", "targetRkapBadge");
            badgeG.setAttribute("transform", `translate(${initX}, ${initY - 20})`);
            badgeG.style.pointerEvents = "none";
            badgeG.style.opacity = "0";
            badgeG.style.transition = "opacity 0.15s ease-in-out";

            const labelText = "Target RKAP: " + Number(targetProtasRkap).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + " Kg/Ha";
            const rect = document.createElementNS(svgNS, "rect");
            const padX = 12;
            const rectW = labelText.length * 6.8 + (padX * 2);
            const rectH = 24;

            rect.setAttribute("x", -rectW / 2);
            rect.setAttribute("y", -rectH / 2);
            rect.setAttribute("width", rectW);
            rect.setAttribute("height", rectH);
            rect.setAttribute("rx", "12");
            rect.setAttribute("fill", "#091224");
            rect.setAttribute("stroke", "#f59e0b");
            rect.setAttribute("stroke-width", "1.5");
            rect.style.filter = "drop-shadow(0 4px 10px rgba(0,0,0,0.95))";

            const text = document.createElementNS(svgNS, "text");
            text.setAttribute("x", "0");
            text.setAttribute("y", "4");
            text.setAttribute("text-anchor", "middle");
            text.setAttribute("fill", "#fbbf24");
            text.setAttribute("font-size", "11px");
            text.setAttribute("font-weight", "800");
            text.setAttribute("font-family", "'JetBrains Mono', 'Plus Jakarta Sans', monospace");
            text.textContent = labelText;

            badgeG.appendChild(rect);
            badgeG.appendChild(text);
            g.appendChild(badgeG);

            // Interactive hover listeners: badge appears and tracks mouse along the target line
            const svgEl = chartContext.el.querySelector('svg.apexcharts-svg');
            function updateTargetBadgePosition(e) {
                if (!svgEl) return;
                try {
                    const pt = svgEl.createSVGPoint();
                    pt.x = e.clientX;
                    pt.y = e.clientY;
                    const svgP = pt.matrixTransform(inner.getScreenCTM().inverse());
                    
                    const ratio = Math.max(0.05, Math.min(0.95, (svgP.x - px0) / ((pxEnd - px0) || 1)));
                    const currentX = px0 + (pxEnd - px0) * ratio;
                    const currentY = py0 + (pyEnd - py0) * ratio;

                    const minX = rectW / 2 + 8;
                    const maxX = gW - (rectW / 2 + 8);
                    const clampedX = Math.max(minX, Math.min(maxX, currentX));
                    const clampedY = (currentY - 22 < 15) ? (currentY + 24) : (currentY - 22);

                    badgeG.setAttribute("transform", `translate(${clampedX}, ${clampedY})`);
                } catch (err) {}
            }

            hitLine.addEventListener('mouseenter', function(e) {
                updateTargetBadgePosition(e);
                badgeG.style.opacity = "1";
            });

            hitLine.addEventListener('mousemove', function(e) {
                updateTargetBadgePosition(e);
                badgeG.style.opacity = "1";
            });

            hitLine.addEventListener('mouseleave', function() {
                badgeG.style.opacity = "0";
            });

            // Insert BEFORE bubble series so circles sit on top of the line
            const bubbleSeriesEl = inner.querySelector('.apexcharts-bubble-series') || inner.querySelector('.apexcharts-series');
            if (bubbleSeriesEl) {
                inner.insertBefore(g, bubbleSeriesEl);
            } else {
                inner.appendChild(g);
            }
        }

        const bubbleOptions = {
            theme: darkTheme,
            chart: {
                type: 'bubble',
                height: 340,
                background: 'transparent',
                fontFamily: fontFam,
                toolbar: { show: false },
                events: {
                    mounted: function(chartContext) {
                        setTimeout(() => drawTargetRkapLine(chartContext), 50);
                    },
                    updated: function(chartContext) {
                        setTimeout(() => drawTargetRkapLine(chartContext), 50);
                    },
                    animationEnd: function(chartContext) {
                        drawTargetRkapLine(chartContext);
                    }
                }
            },
            colors: ['#0284c7'],
            series: bubbleSeries,
            stroke: {
                width: 2,
                colors: ['#38bdf8']
            },
            dataLabels: { enabled: false },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: "horizontal",
                    shadeIntensity: 0.5,
                    gradientToColors: ['#38bdf8'],
                    opacityFrom: 0.7,
                    opacityTo: 0.9,
                }
            },
            xaxis: {
                min: 0,
                max: xMaxRound,
                tickAmount: xTicks,
                title: { text: 'Luas Areal (Ha)', style: { color: '#cbd5e1', fontSize: '11px', fontWeight: 600 } },
                labels: {
                    style: { colors: '#cbd5e1', fontSize: '11px', fontFamily: "'JetBrains Mono', monospace" },
                    formatter: function(val) {
                        const n = Math.round(Number(val));
                        return n.toLocaleString('id-ID');
                    }
                }
            },
            yaxis: {
                min: 0,
                max: yMaxRound,
                tickAmount: yTicks,
                title: { text: 'Produksi (Kg)', style: { color: '#cbd5e1', fontSize: '11px', fontWeight: 600 } },
                labels: {
                    style: { colors: '#cbd5e1', fontSize: '11px', fontFamily: "'JetBrains Mono', monospace" },
                    formatter: function(val) {
                        const n = Math.round(Number(val));
                        if (n >= 1000000) {
                            const jt = n / 1000000;
                            return (Number.isInteger(jt) ? jt : jt.toLocaleString('id-ID', { maximumFractionDigits: 1 })) + ' jt';
                        }
                        if (n >= 1000) return (n / 1000).toLocaleString('id-ID') + ' rb';
                        return n.toLocaleString('id-ID');
                    }
                }
            },
            tooltip: {
                custom: function({seriesIndex, dataPointIndex, w}) {
                    const data = w.config.series[seriesIndex].data[dataPointIndex];
                    const isAbove = targetProtasRkap > 0 ? (data.protas >= targetProtasRkap) : (parseFloat(data.pct_rkap) >= 100);
                    const diffProtas = targetProtasRkap > 0 ? (data.protas - targetProtasRkap) : 0;
                    const diffPct = targetProtasRkap > 0 ? ((data.protas / targetProtasRkap) * 100) : parseFloat(data.pct_rkap);

                    const badgeColor = isAbove ? '#22c55e' : '#ef4444';
                    const badgeBg = isAbove ? 'rgba(34, 197, 94, 0.15)' : 'rgba(239, 68, 68, 0.15)';
                    const badgeBorder = isAbove ? 'rgba(34, 197, 94, 0.4)' : 'rgba(239, 68, 68, 0.4)';
                    const badgeIcon = isAbove ? '▲' : '▼';
                    const badgeText = isAbove ? 'DI ATAS TARGET' : 'DI BAWAH TARGET';

                    return `
                    <div style="background: #0b1329; border: 1px solid ${isAbove ? '#38bdf8' : '#f87171'}; border-radius: 8px; padding: 12px 14px; box-shadow: 0 10px 25px rgba(0,0,0,0.7); min-width: 220px; font-family: 'Plus Jakarta Sans', sans-serif;">
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-bottom: 8px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 6px;">
                            <span style="font-weight: 800; font-size: 13px; color: #f8fafc; letter-spacing: 0.3px;">${data.kebunName}</span>
                            <span style="font-size: 10px; font-weight: 800; color: ${badgeColor}; background: ${badgeBg}; border: 1px solid ${badgeBorder}; padding: 2px 7px; border-radius: 9999px;">
                                ${badgeIcon} ${badgeText}
                            </span>
                        </div>
                        <div style="font-size: 11px; line-height: 1.6; color: #cbd5e1; font-family: 'JetBrains Mono', monospace;">
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #94a3b8;">Luas Areal:</span>
                                <strong style="color: #fff;">${Number(data.x).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} Ha</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #94a3b8;">Produksi:</span>
                                <strong style="color: #fff;">${Number(data.y).toLocaleString('id-ID')} Kg</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #94a3b8;">Protas Real:</span>
                                <strong style="color: ${badgeColor};">${Number(data.protas).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} Kg/Ha</strong>
                            </div>
                            ${targetProtasRkap > 0 ? `
                            <div style="display: flex; justify-content: space-between; border-top: 1px dashed rgba(255,255,255,0.1); margin-top: 4px; padding-top: 4px;">
                                <span style="color: #fbbf24;">Target RKAP:</span>
                                <strong style="color: #fbbf24;">${Number(targetProtasRkap).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} Kg/Ha</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #94a3b8;">Rasio vs Target:</span>
                                <strong style="color: ${badgeColor};">${diffPct.toFixed(1)}% (${diffProtas >= 0 ? '+' : ''}${Number(diffProtas.toFixed(1)).toLocaleString('id-ID')} Kg/Ha)</strong>
                            </div>
                            ` : ''}
                        </div>
                    </div>`;
                }
            },
            grid: { borderColor: 'rgba(255, 255, 255, 0.08)' }
        };
        const chartBubble = new ApexCharts(document.getElementById('chartBubbleAreal'), bubbleOptions);
        chartBubble.render();
        setTimeout(() => drawTargetRkapLine(chartBubble), 150);

        window.addEventListener('resize', () => {
            if (typeof chartBubble !== 'undefined' && chartBubble) {
                setTimeout(() => drawTargetRkapLine(chartBubble), 100);
            }
        });


        // -------------------------------------------------------------
        // TAB 3: TREND PRODUKSI (4 Area Charts: Karet, Teh, Arabica, Robusta)
        // -------------------------------------------------------------
        const trendMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const trendData = @json($trendData);
        const trendCharts = {};
        window.trendCharts = trendCharts;

        ['KARET', 'TEH', 'ARABICA', 'ROBUSTA'].forEach(comm => {
            const cData = trendData[comm];
            const el = document.getElementById('chartTrend' + comm);
            if (!el || !cData) return;

            const trendOpt = {
                theme: darkTheme,
                chart: {
                    type: 'area',
                    height: 270,
                    background: 'transparent',
                    fontFamily: fontFam,
                    toolbar: { show: false }
                },
                stroke: {
                    curve: 'smooth',
                    width: 2.5
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        if (val === null || val === undefined) return '';
                        return Number(val).toLocaleString('id-ID');
                    },
                    style: {
                        fontSize: '11px',
                        fontFamily: "'JetBrains Mono', 'Plus Jakarta Sans', monospace",
                        fontWeight: '700'
                    },
                    background: {
                        enabled: true,
                        borderRadius: 4,
                        padding: 4,
                        opacity: 0.9,
                        borderWidth: 1,
                        borderColor: 'rgba(255, 255, 255, 0.4)'
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.35,
                        opacityTo: 0.05,
                        stops: [0, 95, 100]
                    }
                },
                colors: ['#0284c7', '#ea580c', '#16a34a'],
                series: [
                    { name: 'Tahun Lalu', data: cData.thn_lalu },
                    { name: 'RKAP', data: cData.rkap },
                    { name: 'Realisasi', data: cData.real }
                ],
                xaxis: {
                    categories: trendMonths,
                    labels: { style: { colors: '#cbd5e1', fontSize: '11px', fontWeight: 600 } }
                },
                yaxis: {
                    labels: {
                        style: { colors: '#cbd5e1', fontSize: '11px', fontFamily: "'JetBrains Mono', monospace", fontWeight: 600 },
                        formatter: function(val) {
                            if (val >= 1000000) return (val / 1000000).toFixed(1) + ' jt';
                            if (val >= 1000) return (val / 1000).toLocaleString('id-ID') + ' rb';
                            return val.toLocaleString('id-ID');
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val.toLocaleString('id-ID') + ' Kg';
                        }
                    }
                },
                legend: { show: false },
                grid: { borderColor: 'rgba(255, 255, 255, 0.08)' }
            };

            const tChart = new ApexCharts(el, trendOpt);
            tChart.render();
            trendCharts[comm] = tChart;
        });

        window.toggleTrendSeries = function(comm, seriesName, el) {
            if (!window.trendCharts || !window.trendCharts[comm]) return;
            window.trendCharts[comm].toggleSeries(seriesName);
            const isHidden = el.style.opacity === '0.35';
            el.style.opacity = isHidden ? '1' : '0.35';
        };
    });
</script>
@endsection

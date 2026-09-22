@extends('layouts.app')

@section('title', 'Rekapitulasi Alas Hak & Areal Konsesi')

@section('styles')
<style>
    /* ===== LAYOUT & SCROLL FIX ===== */
    html, body {
        height: auto !important;
        min-height: 100vh;
        overflow-y: auto !important;
        background-color: #f8fafc !important;
        font-family: 'Google Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        color: #1e293b;
    }

    .alas-hak-container.main-content {
        padding: 0 !important;
        margin-left: 0 !important;
        background-color: #f8fafc;
        min-height: 100vh;
    }

    .alas-hak-container {
        padding: 0;
        margin: 0;
        width: 100%;
        min-height: 100vh;
        background: #f8fafc;
        box-sizing: border-box;
    }

    /* ===== PAGE HEADER ===== */
    .ah-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 40px;
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        min-height: 60px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .ah-header-logo {
        width: 140px;
        height: 44px;
        display: flex;
        align-items: center;
    }

    .ah-header-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .ah-header-title-box {
        text-align: center;
    }

    .ah-header-title-box h1 {
        font-size: 1.35rem;
        font-weight: 800;
        color: #166534;
        margin: 0;
        letter-spacing: -0.02em;
    }

    .ah-header-title-box p {
        font-size: 0.825rem;
        color: #64748b;
        margin: 2px 0 0 0;
    }

    .ah-header-right {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .ah-header-right img {
        height: 42px;
        width: auto;
        object-fit: contain;
    }

    /* ===== CONTENT SECTION ===== */
    .ah-content {
        max-width: 100%;
        margin: 0;
        padding: 24px 40px 40px;
    }

    /* ===== TAB NAVIGATION ===== */
    .ah-tab-navigation {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #ffffff;
        padding: 6px 8px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        transition: all 0.25s ease;
    }

    .ah-tab-navigation.is-floating {
        position: fixed !important;
        top: 14px !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
        z-index: 99999 !important;
        background: rgba(255, 255, 255, 0.96) !important;
        backdrop-filter: blur(16px) !important;
        -webkit-backdrop-filter: blur(16px) !important;
        padding: 6px 12px !important;
        border-radius: 50px !important;
        border: 1px solid #166534 !important;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.18), 0 2px 8px rgba(22, 101, 52, 0.2) !important;
        margin-bottom: 0 !important;
        animation: tabNavSlideDown 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes tabNavSlideDown {
        from {
            opacity: 0;
            transform: translate(-50%, -15px);
        }
        to {
            opacity: 1;
            transform: translate(-50%, 0);
        }
    }

    .ah-tab-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 22px;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 700;
        color: #64748b;
        background: transparent;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .ah-tab-btn:hover {
        color: #166534;
        background: #f1f5f9;
    }

    .ah-tab-btn.active {
        background: #166534;
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(22, 101, 52, 0.25);
    }

    /* ===== SUMMARY CARDS ===== */
    .ah-metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .ah-metrics-row-5 {
        grid-template-columns: repeat(5, 1fr);
    }

    .ah-metrics-row-4 {
        grid-template-columns: repeat(4, 1fr);
    }

    @media (max-width: 1200px) {
        .ah-metrics-row-5,
        .ah-metrics-row-4 {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }
    }

    .ah-metric-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 16px 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .ah-metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }

    .ah-metric-info .ah-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.05em;
        color: #64748b;
    }

    .ah-metric-info .ah-value {
        font-size: 1.4rem;
        font-weight: 800;
        color: #0f172a;
        margin-top: 4px;
    }

    .ah-metric-icon {
        width: 46px;
        height: 46px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .ah-icon-green { background: #dcfce7; color: #15803d; }
    .ah-icon-blue { background: #dbeafe; color: #1d4ed8; }
    .ah-icon-amber { background: #fef9c3; color: #854d0e; }
    .ah-icon-purple { background: #f3e8ff; color: #6b21a8; }
    .ah-icon-red { background: #fee2e2; color: #b91c1c; }

    /* ===== CHARTS & DASHBOARD LAYOUT ===== */
    .ah-charts-grid-2 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(420px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }

    .ah-charts-grid-1 {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
        margin-bottom: 24px;
    }

    .ah-chart-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 22px 26px;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.05), 0 4px 6px -2px rgba(15, 23, 42, 0.02);
        transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.35s ease;
        animation: chartCardFadeIn 0.7s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    .ah-chart-card:hover {
        transform: translateY(-6px) scale(1.008);
        box-shadow: 0 20px 30px -10px rgba(15, 23, 42, 0.12), 0 8px 16px -6px rgba(22, 101, 52, 0.1);
    }

    @keyframes chartCardFadeIn {
        from {
            opacity: 0;
            transform: translateY(24px) scale(0.96);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .ah-chart-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f1f5f9;
    }

    .ah-chart-title {
        font-size: 0.95rem;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .ah-chart-title i {
        color: #166534;
    }

    .ah-chart-container {
        position: relative;
        width: 100%;
        min-height: 280px;
    }

    /* ===== TOP FILTER CARD (TAB 2) ===== */
    .ah-filter-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 18px 24px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .ah-filter-title {
        font-weight: 700;
        font-size: 0.95rem;
        color: #166534;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .ah-filter-row {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 16px;
    }

    .ah-field-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        flex: 1;
        min-width: 200px;
    }

    .ah-field-label {
        font-size: 0.775rem;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    /* ===== TOOLBAR ===== */
    .ah-toolbar-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 14px 20px;
        margin-bottom: 20px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .ah-input-group {
        position: relative;
        min-width: 280px;
    }

    .ah-input-group i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 0.9rem;
    }

    .ah-input {
        width: 100%;
        padding: 8px 12px 8px 36px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 0.875rem;
        outline: none;
        transition: all 0.2s;
    }

    .ah-input:focus {
        border-color: #166534;
        box-shadow: 0 0 0 3px rgba(22, 101, 52, 0.15);
    }

    .ah-select {
        padding: 8px 32px 8px 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 0.875rem;
        outline: none;
        background-color: #fff;
        cursor: pointer;
        transition: all 0.2s;
    }

    .ah-select:focus {
        border-color: #166534;
    }

    .ah-btn-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .ah-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        border: 1px solid transparent;
    }

    .ah-btn-primary {
        background: #166534;
        color: #ffffff;
    }
    .ah-btn-primary:hover { background: #14532d; }

    .ah-btn-secondary {
        background: #f1f5f9;
        color: #475569;
        border-color: #cbd5e1;
    }
    .ah-btn-secondary:hover { background: #e2e8f0; }

    .ah-btn-excel {
        background: #166534;
        color: #ffffff;
    }
    .ah-btn-excel:hover { background: #14532d; }

    .ah-btn-print {
        background: #ffffff;
        color: #334155;
        border-color: #cbd5e1;
    }
    .ah-btn-print:hover { background: #f1f5f9; }

    /* ===== TABLE CARD & STYLES ===== */
    .ah-table-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    .ah-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .ah-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.825rem;
        text-align: left;
    }

    .ah-table thead th {
        background: #f8fafc;
        color: #0f172a;
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        padding: 12px 14px;
        border: 1px solid #cbd5e1;
        text-align: center;
        vertical-align: middle;
    }

    .ah-table thead tr:first-child th {
        background: #e2e8f0;
        color: #0f172a;
    }

    .ah-table tbody td {
        padding: 8px 12px;
        border: 1px solid #cbd5e1;
        vertical-align: middle;
        color: #334155;
    }

    .td-center { text-align: center; }
    .td-right { text-align: right; font-variant-numeric: tabular-nums; }
    .td-left { text-align: left; }

    .ah-table tbody tr:not(.region-header-row):not(.kebun-subtotal-row):hover {
        background-color: #f1f5f9 !important;
    }

    .badge-alas {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.02em;
    }

    .badge-hgu { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .badge-proses { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
    .badge-hgb { background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }
    .badge-hpl { background: #f3e8ff; color: #6b21a8; border: 1px solid #e9d5ff; }

    .badge-status {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.02em;
        white-space: nowrap;
    }

    .badge-status-berlaku { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    .badge-status-berakhir { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
    .badge-status-belum { background: #fef9c3; color: #854d0e; border: 1px solid #fef08a; }
    .badge-status-eks { background: #e2e8f0; color: #334155; border: 1px solid #cbd5e1; }
    .badge-eks { background: #e2e8f0; color: #334155; border: 1px solid #cbd5e1; }

    /* Row status background highlights */
    .ah-table tbody tr.row-status-berakhir { background-color: #fef2f2 !important; }
    .ah-table tbody tr.row-status-berakhir:hover { background-color: #fee2e2 !important; }
    .ah-table tbody tr.row-status-belum { background-color: #fefce8 !important; }
    .ah-table tbody tr.row-status-belum:hover { background-color: #fef9c3 !important; }
    .ah-table tbody tr.row-status-eks { background-color: #f1f5f9 !important; }
    .ah-table tbody tr.row-status-eks:hover { background-color: #e2e8f0 !important; }

    /* ===== DETAIL BUTTON ===== */
    .ah-btn-detail {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        color: #166534;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .ah-btn-detail:hover {
        background: #166534;
        color: #ffffff;
        border-color: #166534;
        box-shadow: 0 2px 6px rgba(22, 101, 52, 0.25);
        transform: translateY(-1px);
    }

    /* ===== DETAIL SPREADSHEET MODAL ===== */
    .ah-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(6px);
        z-index: 99999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
    }

    .ah-modal-card {
        background: #ffffff;
        width: 100%;
        max-width: 900px;
        max-height: 90vh;
        border-radius: 16px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        animation: modalZoomIn 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        border: 1px solid #cbd5e1;
    }

    @keyframes modalZoomIn {
        from {
            opacity: 0;
            transform: scale(0.92) translateY(12px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .ah-modal-header {
        background: linear-gradient(135deg, #064e3b 0%, #022c22 100%);
        color: #ffffff;
        padding: 18px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #10b981;
    }

    .ah-modal-title {
        font-size: 1.1rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #34d399;
    }

    .ah-modal-close {
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: #ffffff;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        cursor: pointer;
        transition: background 0.2s;
    }

    .ah-modal-close:hover {
        background: rgba(239, 68, 68, 0.8);
    }

    .ah-modal-body {
        padding: 24px;
        overflow-y: auto;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .ah-modal-section {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px 20px;
    }

    .ah-modal-sec-title {
        font-size: 0.85rem;
        font-weight: 800;
        color: #166534;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
        border-bottom: 2px solid #e2e8f0;
        padding-bottom: 6px;
    }

    .ah-modal-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 14px 20px;
    }

    .ah-detail-field {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .ah-detail-label {
        font-size: 0.725rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .ah-detail-val {
        font-size: 0.875rem;
        font-weight: 700;
        color: #0f172a;
        word-break: break-word;
    }

    /* Print Styles */
    @media print {
        .ah-page-header, .ah-tab-navigation, .ah-filter-card, .ah-toolbar-card, .ah-metrics-grid, .sidebar {
            display: none !important;
        }
        .ah-content { padding: 0 !important; }
        .ah-table-card { border: none !important; box-shadow: none !important; }
        .ah-table thead th, .ah-table tbody td, .ah-table tfoot td {
            border: 1px solid #000 !important;
        }
    }
</style>
@endsection

@section('content')
<div class="alas-hak-container main-content">
    
    <!-- PAGE HEADER -->
    <div class="ah-page-header">
        <div class="ah-header-logo">
            <img src="{{ asset('ptpn1.png') }}" alt="PTPN I Logo" onerror="this.style.display='none'">
        </div>
        <div class="ah-header-title-box">
            <h1>REKAPITULASI ALAS HAK & AREAL KONSESI</h1>
            <p>Dashboard Monitoring Legalitas & Agraria PTPN I</p>
        </div>
        <div class="ah-header-right">
            <img src="{{ asset('holding.png') }}" alt="Holding Perkebunan Logo" onerror="this.style.display='none'">
        </div>
    </div>

    <!-- MAIN CONTENT SECTION -->
    <div class="ah-content">

        @php
            $dataset = isset($rekapAlasHak) && is_array($rekapAlasHak) ? $rekapAlasHak : [];

            // Global Metrics & Aggregates Calculation
            $totalRegionCount = count($dataset);
            $totalKebunCount = 0;
            $grandTotalAreal = 0;
            $grandTotalLuas = 0;
            $totalSertifikatCount = 0;

            $statusCounts = ['BERLAKU' => 0, 'BERAKHIR' => 0, 'BELUM BERSERTIFIKAT' => 0, 'EKS HGU' => 0];
            $statusHa = ['BERLAKU' => 0, 'BERAKHIR' => 0, 'BELUM BERSERTIFIKAT' => 0, 'EKS HGU' => 0];
            $jenisCounts = [];
            $jenisHa = ['HGU' => 0, 'HGB' => 0, 'HPL' => 0, 'HP' => 0];

            $chartRegionLabels = [];
            $chartRegionKonsesi = [];
            $chartRegionSertifikat = [];

            $chartStatusBerlaku = [];
            $chartStatusBerakhir = [];
            $chartStatusBelum = [];
            $chartStatusEks = [];

            $chartStatusHaBerlaku = [];
            $chartStatusHaBerakhir = [];
            $chartStatusHaBelum = [];
            $chartStatusHaEks = [];

            $expiredKebunAlert = [];

            foreach($dataset as $regionName => $regionInfo) {
                $chartRegionLabels[] = $regionName;
                $regKonsesiVal = round($regionInfo['areal_konsesi'], 2);
                $chartRegionKonsesi[] = $regKonsesiVal;
                $grandTotalAreal += $regKonsesiVal;

                $regSertLuas = 0;
                $regBerlaku = 0;
                $regBerakhir = 0;
                $regBelum = 0;
                $regEks = 0;

                $regBerlakuHa = 0;
                $regBerakhirHa = 0;
                $regBelumHa = 0;
                $regEksHa = 0;

                $kebunList = $regionInfo['kebun_list'];
                $totalKebunCount += count($kebunList);

                foreach($kebunList as $kebunName => $kebunItem) {
                    $items = $kebunItem['items'];
                    $arealKonsesi = $kebunItem['areal_konsesi'];
                    $kebunExpiredCount = 0;

                    if(count($items) === 0) {
                        $regBelum++;
                        $statusCounts['BELUM BERSERTIFIKAT']++;
                        $regBelumHa += $arealKonsesi;
                        $statusHa['BELUM BERSERTIFIKAT'] += $arealKonsesi;
                    } else {
                        $kebunCertifiedLuas = 0;
                        foreach($items as $item) {
                            $itemLuas = $item['luas'];
                            $regSertLuas += $itemLuas;
                            $grandTotalLuas += $itemLuas;
                            $totalSertifikatCount++;

                            $st = strtoupper($item['status'] ?? 'BELUM BERSERTIFIKAT');
                            $jHak = strtoupper($item['jenis'] ?? '');
                            $nomorUpper = strtoupper($item['nomor'] ?? '');

                            if (str_contains($st, 'EKS') || str_contains($jHak, 'EKS') || str_contains($nomorUpper, 'EKS')) {
                                $regEks++;
                                $statusCounts['EKS HGU']++;
                                $regEksHa += $itemLuas;
                                $statusHa['EKS HGU'] += $itemLuas;
                                $kebunCertifiedLuas += $itemLuas;
                            } elseif(str_contains($st, 'AKHIR') || str_contains($st, 'EXPIRE')) {
                                $regBerakhir++;
                                $kebunExpiredCount++;
                                $statusCounts['BERAKHIR']++;
                                $regBerakhirHa += $itemLuas;
                                $statusHa['BERAKHIR'] += $itemLuas;
                                $kebunCertifiedLuas += $itemLuas;
                            } elseif(str_contains($st, 'BELUM') || str_contains($st, 'PROSES')) {
                                $regBelum++;
                                $statusCounts['BELUM BERSERTIFIKAT']++;
                                $regBelumHa += $itemLuas;
                                $statusHa['BELUM BERSERTIFIKAT'] += $itemLuas;
                            } else {
                                $regBerlaku++;
                                $statusCounts['BERLAKU']++;
                                $regBerlakuHa += $itemLuas;
                                $statusHa['BERLAKU'] += $itemLuas;
                                $kebunCertifiedLuas += $itemLuas;
                            }

                            $j = strtoupper($item['jenis'] ?? 'LAINNYA');
                            $jenisCounts[$j] = ($jenisCounts[$j] ?? 0) + 1;

                            if (str_contains($j, 'HGU')) {
                                $jenisHa['HGU'] = ($jenisHa['HGU'] ?? 0) + $itemLuas;
                            } elseif (str_contains($j, 'HGB')) {
                                $jenisHa['HGB'] = ($jenisHa['HGB'] ?? 0) + $itemLuas;
                            } elseif (str_contains($j, 'HPL')) {
                                $jenisHa['HPL'] = ($jenisHa['HPL'] ?? 0) + $itemLuas;
                            } elseif (str_contains($j, 'HP')) {
                                $jenisHa['HP'] = ($jenisHa['HP'] ?? 0) + $itemLuas;
                            } else {
                                $jenisHa[$j] = ($jenisHa[$j] ?? 0) + $itemLuas;
                            }
                        }
                    }

                    if($kebunExpiredCount > 0) {
                        $expiredKebunAlert[] = [
                            'region' => $regionName,
                            'kebun' => $kebunName,
                            'expired_count' => $kebunExpiredCount,
                            'areal_konsesi' => $kebunItem['areal_konsesi']
                        ];
                    }
                }

                $chartRegionSertifikat[] = round($regSertLuas, 2);
                $chartStatusBerlaku[] = $regBerlaku;
                $chartStatusBerakhir[] = $regBerakhir;
                $chartStatusBelum[] = $regBelum;
                $chartStatusEks[] = $regEks;

                $chartStatusHaBerlaku[] = round($regBerlakuHa, 2);
                $chartStatusHaBerakhir[] = round($regBerakhirHa, 2);
                $chartStatusHaBelum[] = round($regBelumHa, 2);
                $chartStatusHaEks[] = round($regEksHa, 2);
            }

            usort($expiredKebunAlert, function($a, $b) {
                return $b['expired_count'] <=> $a['expired_count'];
            });

            $overallPct = $grandTotalAreal > 0 ? ($grandTotalLuas / $grandTotalAreal) * 100 : 0;
        @endphp

        <!-- GLOBAL TOP FILTER CARD (MOVED ABOVE TABS FOR GLOBAL FILTERING) -->
        <div class="ah-filter-card">
            <div class="ah-filter-title">
                <i class="fa-solid fa-filter"></i> Filter Data Dashboard & Tabular (Global Filter)
            </div>
            <div class="ah-filter-row">
                <div class="ah-field-group">
                    <label for="selectRegional" class="ah-field-label">1. Pilih Regional</label>
                    <select id="selectRegional" class="ah-select" onchange="onRegionalChange(); applyFilter();">
                        <option value="">-- Semua Regional --</option>
                        @foreach($dataset as $regionName => $rInfo)
                            <option value="{{ $regionName }}">{{ $regionName }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="ah-field-group">
                    <label for="selectKebun" class="ah-field-label">2. Pilih Kebun</label>
                    <select id="selectKebun" class="ah-select" onchange="applyFilter();">
                        <option value="">-- Semua Kebun --</option>
                    </select>
                </div>

                <div class="ah-field-group">
                    <label for="selectStatus" class="ah-field-label">3. Status Sertifikat</label>
                    <select id="selectStatus" class="ah-select" onchange="applyFilter();">
                        <option value="">-- Semua Status --</option>
                        <option value="BERLAKU">BERLAKU (Hijau)</option>
                        <option value="BERAKHIR">BERAKHIR (Merah)</option>
                        <option value="BELUM BERSERTIFIKAT">BELUM BERSERTIFIKAT (Kuning)</option>
                        <option value="EKS HGU">EKS HGU (Abu-abu)</option>
                    </select>
                </div>

                <div class="ah-field-group">
                    <label for="selectJenis" class="ah-field-label">4. Jenis Hak</label>
                    <select id="selectJenis" class="ah-select" onchange="applyFilter();">
                        <option value="">-- Semua Jenis Hak --</option>
                        @php
                            $sortedJenisKeys = array_keys($jenisCounts);
                            sort($sortedJenisKeys);
                        @endphp
                        @foreach($sortedJenisKeys as $jKey)
                            <option value="{{ $jKey }}">{{ $jKey }} ({{ number_format($jenisCounts[$jKey], 0, ',', '.') }} Berkas)</option>
                        @endforeach
                    </select>
                </div>

                <div style="display: flex; gap: 8px;">
                    <button class="ah-btn ah-btn-primary" onclick="applyFilter()">
                        <i class="fa-solid fa-play"></i> Proses
                    </button>
                    <button class="ah-btn ah-btn-secondary" onclick="resetFilter()">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- TAB NAVIGATION HEADER -->
        <div class="ah-tab-navigation">
            <button id="tabBtn1" class="ah-tab-btn active" onclick="switchTab('analyticsTab', this)">
                <i class="fa-solid fa-chart-pie"></i> Visual Analytics & Monitoring
            </button>
            <button id="tabBtn2" class="ah-tab-btn" onclick="switchTab('tabularTab', this)">
                <i class="fa-solid fa-table-cells"></i> Data Tabular & Detail Berkas
            </button>
        </div>

        <!-- ========================================== -->
        <!-- TAB 1: EXECUTIVE ANALYTICS DASHBOARD      -->
        <!-- ========================================== -->
        <div id="analyticsTab" class="ah-tab-content">
            
            <!-- EXECUTIVE METRICS SUMMARY CARDS - ROW 1: STATUS & AREAL (5 CARDS) -->
            <div class="ah-metrics-grid ah-metrics-row-5" style="margin-bottom: 16px;">
                <div class="ah-metric-card">
                    <div class="ah-metric-info">
                        <div class="ah-label">Total Areal Konsesi</div>
                        <div class="ah-value" id="cardTotalAreal">{{ number_format($grandTotalAreal, 2, ',', '.') }} <span style="font-size: 0.85rem; font-weight: normal;">Ha</span></div>
                    </div>
                    <div class="ah-metric-icon ah-icon-blue">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </div>
                </div>

                <div class="ah-metric-card">
                    <div class="ah-metric-info">
                        <div class="ah-label">Luas Berlaku (Ha)</div>
                        <div class="ah-value" id="cardLuasBerlaku" style="color: #15803d;">{{ number_format($statusHa['BERLAKU'], 2, ',', '.') }} <span style="font-size: 0.85rem; font-weight: normal;">Ha</span></div>
                    </div>
                    <div class="ah-metric-icon ah-icon-green">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>

                <div class="ah-metric-card">
                    <div class="ah-metric-info">
                        <div class="ah-label">Luas Berakhir (Ha)</div>
                        <div class="ah-value" id="cardLuasBerakhir" style="color: #b91c1c;">{{ number_format($statusHa['BERAKHIR'], 2, ',', '.') }} <span style="font-size: 0.85rem; font-weight: normal;">Ha</span></div>
                    </div>
                    <div class="ah-metric-icon ah-icon-red">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                </div>

                <div class="ah-metric-card">
                    <div class="ah-metric-info">
                        <div class="ah-label">Belum Bersertifikat (Ha)</div>
                        <div class="ah-value" id="cardLuasBelum" style="color: #ca8a04;">{{ number_format($statusHa['BELUM BERSERTIFIKAT'], 2, ',', '.') }} <span style="font-size: 0.85rem; font-weight: normal;">Ha</span></div>
                    </div>
                    <div class="ah-metric-icon ah-icon-amber">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                </div>

                <div class="ah-metric-card">
                    <div class="ah-metric-info">
                        <div class="ah-label">Eks HGU (Ha)</div>
                        <div class="ah-value" id="cardLuasEks" style="color: #475569;">{{ number_format($statusHa['EKS HGU'] ?? 0, 2, ',', '.') }} <span style="font-size: 0.85rem; font-weight: normal;">Ha</span></div>
                    </div>
                    <div class="ah-metric-icon" style="background: #e2e8f0; color: #475569;">
                        <i class="fa-solid fa-file-contract"></i>
                    </div>
                </div>
            </div>

            <!-- EXECUTIVE METRICS SUMMARY CARDS - ROW 2: JENIS HAK (4 CARDS) -->
            <div class="ah-metrics-grid ah-metrics-row-4" style="margin-bottom: 24px;">
                <div class="ah-metric-card">
                    <div class="ah-metric-info">
                        <div class="ah-label">HGU (Ha)</div>
                        <div class="ah-value" id="cardLuasHgu" style="color: #166534;">{{ number_format($jenisHa['HGU'] ?? 0, 2, ',', '.') }} <span style="font-size: 0.85rem; font-weight: normal;">Ha</span></div>
                    </div>
                    <div class="ah-metric-icon" style="background: #dcfce7; color: #166534;">
                        <i class="fa-solid fa-file-shield"></i>
                    </div>
                </div>

                <div class="ah-metric-card">
                    <div class="ah-metric-info">
                        <div class="ah-label">HGB (Ha)</div>
                        <div class="ah-value" id="cardLuasHgb" style="color: #1d4ed8;">{{ number_format($jenisHa['HGB'] ?? 0, 2, ',', '.') }} <span style="font-size: 0.85rem; font-weight: normal;">Ha</span></div>
                    </div>
                    <div class="ah-metric-icon" style="background: #dbeafe; color: #1d4ed8;">
                        <i class="fa-solid fa-building"></i>
                    </div>
                </div>

                <div class="ah-metric-card">
                    <div class="ah-metric-info">
                        <div class="ah-label">HPL (Ha)</div>
                        <div class="ah-value" id="cardLuasHpl" style="color: #6b21a8;">{{ number_format($jenisHa['HPL'] ?? 0, 2, ',', '.') }} <span style="font-size: 0.85rem; font-weight: normal;">Ha</span></div>
                    </div>
                    <div class="ah-metric-icon" style="background: #f3e8ff; color: #6b21a8;">
                        <i class="fa-solid fa-landmark"></i>
                    </div>
                </div>

                <div class="ah-metric-card">
                    <div class="ah-metric-info">
                        <div class="ah-label">HP (Ha)</div>
                        <div class="ah-value" id="cardLuasHp" style="color: #0369a1;">{{ number_format($jenisHa['HP'] ?? 0, 2, ',', '.') }} <span style="font-size: 0.85rem; font-weight: normal;">Ha</span></div>
                    </div>
                    <div class="ah-metric-icon" style="background: #e0f2fe; color: #0369a1;">
                        <i class="fa-solid fa-stamp"></i>
                    </div>
                </div>
            </div>

            <!-- 3D GLOBE MONITORING CARD (TOUCH / CURSOR INTERACTIVE) -->
            <div class="ah-globe-card" style="background: linear-gradient(135deg, #064e3b 0%, #022c22 100%); border-radius: 16px; border: 1px solid #10b981; padding: 22px 28px; margin-bottom: 24px; box-shadow: 0 10px 25px rgba(0,0,0,0.12); position: relative; overflow: hidden; color: #ffffff;">
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 14px; border-bottom: 1px solid rgba(255,255,255,0.15); padding-bottom: 12px;">
                    <div style="font-size: 1rem; font-weight: 800; display: flex; align-items: center; gap: 10px; color: #34d399;">
                        <i class="fa-solid fa-earth-asia" style="font-size: 1.25rem;"></i> Wilayah Operasional PTPN I
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span id="globeCityBadge" style="display: none; font-size: 0.775rem; background: rgba(239, 68, 68, 0.25); border: 1px solid #ef4444; padding: 4px 14px; border-radius: 20px; color: #fca5a5; font-weight: 700; align-items: center; gap: 6px;"></span>
                        <div style="font-size: 0.775rem; background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; padding: 4px 14px; border-radius: 20px; color: #a7f3d0; font-weight: 700; display: flex; align-items: center; gap: 6px;">
                            <i class="fa-solid fa-hand-pointer"></i> Sentuh & Geser Kursor untuk Memutar Bola Dunia 3D
                        </div>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: center;">
                    <!-- Canvas Container for 3D Globe -->
                    <div id="globeCanvasContainer" style="width: 100%; height: 340px; position: relative; cursor: grab;">
                        <div id="globeLoadingOverlay" style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; color: #a7f3d0; font-size: 0.875rem;">
                            <i class="fa-solid fa-circle-notch fa-spin" style="margin-right: 8px;"></i> Memuat Bola Dunia 3D...
                        </div>
                    </div>

                    <!-- Regional Stats Overlay Side Panel -->
                    <div style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(8px); border-radius: 12px; padding: 18px 20px; border: 1px solid rgba(255,255,255,0.15);">
                        <div style="font-weight: 800; font-size: 0.875rem; color: #a7f3d0; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-building-flag" style="color: #f59e0b;"></i> Kantor Regional PTPN I
                        </div>
                        
                        <div style="display: flex; flex-direction: column; gap: 8px; font-size: 0.775rem; color: #cbd5e1; max-height: 220px; overflow-y: auto; padding-right: 4px;">
                            <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 4px;">
                                <span><strong style="color:#ef4444;">Regional 1:</strong> Medan</span>
                                <span style="color:#94a3b8;">Sumatra Utara</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 4px;">
                                <span><strong style="color:#3b82f6;">Regional 2:</strong> Bandung</span>
                                <span style="color:#94a3b8;">Jawa Barat</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 4px;">
                                <span><strong style="color:#10b981;">Regional 3:</strong> Semarang</span>
                                <span style="color:#94a3b8;">Jawa Tengah</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 4px;">
                                <span><strong style="color:#f59e0b;">Regional 4 & 5:</strong> Surabaya</span>
                                <span style="color:#94a3b8;">Jawa Timur</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 4px;">
                                <span><strong style="color:#ec4899;">Regional 6:</strong> Aceh</span>
                                <span style="color:#94a3b8;">D.I. Aceh</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 4px;">
                                <span><strong style="color:#06b6d4;">Regional 7:</strong> Lampung</span>
                                <span style="color:#94a3b8;">Bandar Lampung</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 4px;">
                                <span><strong style="color:#f97316;">Regional 8:</strong> Makassar</span>
                                <span style="color:#94a3b8;">Sulawesi Selatan</span>
                            </div>
                        </div>

                        <div style="margin-top: 14px; padding-top: 10px; border-top: 1px solid rgba(255,255,255,0.15); font-size: 0.725rem; color: #94a3b8; line-height: 1.4;">
                            <i class="fa-solid fa-circle-info" style="color: #60a5fa; margin-right: 4px;"></i> 
                            Pin merah & label 3D menandakan lokasi Kantor Regional di Indonesia.
                        </div>
                    </div>
                </div>
            </div>

            <!-- ROW 2: DONUT CHART LUAS HEKTAR & DONUT CHART BERKAS -->
            <div class="ah-charts-grid-2">
                <div class="ah-chart-card">
                    <div class="ah-chart-header">
                        <div class="ah-chart-title">
                            <i class="fa-solid fa-chart-pie"></i> Distribusi Luas Areal (Hektar) per Status Legalitas
                        </div>
                    </div>
                    <div class="ah-chart-container">
                        <canvas id="statusHaDonutChart"></canvas>
                    </div>
                </div>

                <div class="ah-chart-card">
                    <div class="ah-chart-header">
                        <div class="ah-chart-title">
                            <i class="fa-solid fa-chart-donut"></i> Proporsi Jumlah Berkas Sertifikat per Status
                        </div>
                    </div>
                    <div class="ah-chart-container">
                        <canvas id="statusDonutChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- ROW 3: STACKED BAR CHART LUAS HEKTAR PER REGIONAL -->
            <div class="ah-charts-grid-1">
                <div class="ah-chart-card">
                    <div class="ah-chart-header">
                        <div class="ah-chart-title">
                            <i class="fa-solid fa-chart-column"></i> Sebaran Luas Areal (Hektar) Berlaku, Berakhir & Belum Bersertifikat per Regional
                        </div>
                    </div>
                    <div class="ah-chart-container" style="min-height: 320px;">
                        <canvas id="regionalStatusHaStackedChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- ROW 3.5: BAR CHART PERBANDINGAN LUAS KONSESI VS LUAS ALAS HAK PER REGIONAL -->
            <div class="ah-charts-grid-1">
                <div class="ah-chart-card">
                    <div class="ah-chart-header">
                        <div class="ah-chart-title">
                            <i class="fa-solid fa-chart-bar"></i> Perbandingan Luas Konsesi vs Luas Alas Hak per Regional (Hektar)
                        </div>
                    </div>
                    <div class="ah-chart-container" style="min-height: 340px;">
                        <canvas id="regionalKonsesiVsAlasChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- ROW 4: JENIS HAK BAR CHART & EARLY WARNING TABLE -->
            <div class="ah-charts-grid-2">
                <div class="ah-chart-card">
                    <div class="ah-chart-header">
                        <div class="ah-chart-title">
                            <i class="fa-solid fa-layer-group"></i> Distribusi Jenis Hak Atas Tanah (Berkas)
                        </div>
                    </div>
                    <div class="ah-chart-container">
                        <canvas id="jenisBarChart"></canvas>
                    </div>
                </div>

                <div class="ah-chart-card" style="display: flex; flex-direction: column;">
                    <div class="ah-chart-header">
                        <div class="ah-chart-title" style="color: #991b1b;">
                            <i class="fa-solid fa-triangle-exclamation" style="color: #b91c1c;"></i> Early Warning: Kebun dengan Sertifikat Berakhir
                        </div>
                        <span id="expiredKebunCountBadge" style="font-size: 0.75rem; background: #fee2e2; color: #991b1b; padding: 2px 8px; border-radius: 4px; font-weight: 700;">
                            {{ count($expiredKebunAlert) }} Kebun
                        </span>
                    </div>
                    <div style="flex: 1; overflow-y: auto; max-height: 320px;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 0.825rem;">
                            <thead>
                                <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; text-align: left;">
                                    <th style="padding: 8px 10px; color: #475569;">Regional / Kebun</th>
                                    <th style="padding: 8px 10px; color: #475569; text-align: right;">Areal (Ha)</th>
                                    <th style="padding: 8px 10px; color: #475569; text-align: center;">Jumlah Berakhir</th>
                                </tr>
                            </thead>
                            <tbody id="expiredKebunTbody">
                                @foreach(array_slice($expiredKebunAlert, 0, 10) as $exKebun)
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td style="padding: 8px 10px; font-weight: 700; color: #0f172a;">
                                            {{ $exKebun['kebun'] }}
                                            <div style="font-size: 0.75rem; color: #64748b; font-weight: normal;">{{ $exKebun['region'] }}</div>
                                        </td>
                                        <td style="padding: 8px 10px; text-align: right; font-weight: 700; color: #15803d;">
                                            {{ number_format($exKebun['areal_konsesi'], 2, ',', '.') }}
                                        </td>
                                        <td style="padding: 8px 10px; text-align: center;">
                                            <span style="background: #fee2e2; color: #b91c1c; font-weight: 800; padding: 2px 8px; border-radius: 6px; font-size: 0.8rem;">
                                                {{ $exKebun['expired_count'] }} Berkas
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <!-- ========================================== -->
        <!-- TAB 2: REKAPITULASI DATA TABULAR           -->
        <!-- ========================================== -->
        <div id="tabularTab" class="ah-tab-content" style="display: none;">

            <!-- METRICS SUMMARY CARDS (TABULAR) -->
            <div class="ah-metrics-grid">
                <div class="ah-metric-card">
                    <div class="ah-metric-info">
                        <div class="ah-label">Total Regional / Kebun</div>
                        <div class="ah-value" id="metricKebunCount">{{ $totalRegionCount }} Reg / {{ number_format($totalKebunCount, 0, ',', '.') }} Kebun</div>
                    </div>
                    <div class="ah-metric-icon ah-icon-green">
                        <i class="fa-solid fa-tree"></i>
                    </div>
                </div>

                <div class="ah-metric-card">
                    <div class="ah-metric-info">
                        <div class="ah-label">Areal Konsesi</div>
                        <div class="ah-value" id="metricArealTotal">{{ number_format($grandTotalAreal, 2, ',', '.') }} <span style="font-size: 0.85rem; font-weight: normal;">Ha</span></div>
                    </div>
                    <div class="ah-metric-icon ah-icon-blue">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </div>
                </div>

                <div class="ah-metric-card">
                    <div class="ah-metric-info">
                        <div class="ah-label">Total Luas Alas Hak</div>
                        <div class="ah-value" id="metricLuasAlas">{{ number_format($grandTotalLuas, 2, ',', '.') }} <span style="font-size: 0.85rem; font-weight: normal;">Ha</span></div>
                    </div>
                    <div class="ah-metric-icon ah-icon-purple">
                        <i class="fa-solid fa-file-contract"></i>
                    </div>
                </div>

                <div class="ah-metric-card">
                    <div class="ah-metric-info">
                        <div class="ah-label">Sertifikasi Thd. Konsesi</div>
                        <div class="ah-value" id="metricPctAlas">{{ number_format($overallPct, 2, ',', '.') }}%</div>
                    </div>
                    <div class="ah-metric-icon ah-icon-amber">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                </div>
            </div>

            <!-- TOOLBAR -->
            <div class="ah-toolbar-card">
                <div class="ah-input-group">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="searchInput" class="ah-input" placeholder="Cari Sertifikat / Jenis / Kebun..." onkeyup="applyFilter()">
                </div>

                <div class="ah-btn-group">
                    <button class="ah-btn ah-btn-excel" onclick="exportToExcel()">
                        <i class="fa-solid fa-file-excel"></i> Export Excel
                    </button>
                    <button class="ah-btn ah-btn-print" onclick="window.print()">
                        <i class="fa-solid fa-print"></i> Cetak / PDF
                    </button>
                </div>
            </div>

            <!-- TABLE CARD -->
            <div class="ah-table-card">
                <div class="ah-table-wrapper">
                    <table class="ah-table" id="alasHakTable">
                        <thead>
                            <tr>
                                <th rowspan="2" style="width: 120px;">Regional</th>
                                <th rowspan="2" style="width: 220px;">Kebun</th>
                                <th rowspan="2" style="width: 130px;">Areal Konsesi (Ha)</th>
                                <th colspan="6">Alas Hak (HGU/HGB/HPL/TIDAK BERSERTIFIKAT)</th>
                                <th rowspan="2" style="width: 130px;">Prosentase Alas Hak<br>Thd. Konsesi (%)</th>
                                <th rowspan="2" style="width: 90px; text-align: center;">Detail</th>
                            </tr>
                            <tr>
                                <th style="width: 120px;">Jenis</th>
                                <th style="width: 220px;">Nama Sertifikat</th>
                                <th style="width: 110px;">Tgl. Terbit</th>
                                <th style="width: 110px;">Tgl. Berakhir</th>
                                <th style="width: 140px;">Status</th>
                                <th style="width: 110px;">Luas (Ha)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataset as $regionName => $regionInfo)
                                @php
                                    $kebunList = $regionInfo['kebun_list'];
                                    $regAreal = $regionInfo['areal_konsesi'];
                                @endphp

                                <!-- REGION SECTION HEADER ROW -->
                                <tr class="region-header-row" data-region="{{ $regionName }}" style="background-color: #f1f5f9; font-weight: 800;">
                                    <td colspan="11" class="td-left" style="font-size: 0.875rem; color: #166534; padding: 10px 14px; border-bottom: 2px solid #cbd5e1;">
                                        <i class="fa-solid fa-layer-group" style="margin-right: 6px;"></i> 
                                        <strong>{{ $regionName }}</strong> 
                                        <span style="font-weight: normal; color: #475569; font-size: 0.8rem; margin-left: 8px;">
                                            ({{ count($kebunList) }} Kebun - Total Konsesi: {{ number_format($regAreal, 2, ',', '.') }} Ha)
                                        </span>
                                    </td>
                                </tr>

                                 <!-- KEBUN ROWS & SERTIFIKAT ITEMS -->
                                @foreach($kebunList as $kebunName => $kebunItem)
                                    @php
                                        $items = $kebunItem['items'];
                                        $rowCount = count($items);
                                        $arealKonsesi = $kebunItem['areal_konsesi'];
                                        $kebunTotalLuas = 0;
                                    @endphp

                                    @if($rowCount > 0)
                                        @foreach($items as $index => $item)
                                            @php
                                                $luas = $item['luas'];
                                                $kebunTotalLuas += $luas;
                                                $pct = $arealKonsesi > 0 ? ($luas / $arealKonsesi) * 100 : 0;

                                                $jenisUpper = strtoupper($item['jenis']);
                                                $jenisClass = 'badge-hgu';
                                                if (str_contains($jenisUpper, 'EKS')) {
                                                    $jenisClass = 'badge-eks';
                                                } elseif (str_contains($jenisUpper, 'PROSES')) {
                                                    $jenisClass = 'badge-proses';
                                                } elseif (str_contains($jenisUpper, 'HGB')) {
                                                    $jenisClass = 'badge-hgb';
                                                } elseif (str_contains($jenisUpper, 'HPL') || str_contains($jenisUpper, 'HP')) {
                                                    $jenisClass = 'badge-hpl';
                                                }

                                                $statusVal = strtoupper($item['status'] ?? 'BELUM BERSERTIFIKAT');
                                                $nomorUpper = strtoupper($item['nomor'] ?? '');
                                                $statusClass = 'badge-status-berlaku';
                                                $rowStatusClass = '';

                                                if (str_contains($jenisUpper, 'EKS') || str_contains($nomorUpper, 'EKS') || str_contains($statusVal, 'EKS')) {
                                                    $statusVal = 'EKS HGU';
                                                    $statusClass = 'badge-status-eks';
                                                    $rowStatusClass = 'row-status-eks';
                                                } elseif (str_contains($statusVal, 'AKHIR') || str_contains($statusVal, 'EXPIRE')) {
                                                    $statusClass = 'badge-status-berakhir';
                                                    $rowStatusClass = 'row-status-berakhir';
                                                } elseif (str_contains($statusVal, 'BELUM') || str_contains($statusVal, 'PROSES')) {
                                                    $statusClass = 'badge-status-belum';
                                                    $rowStatusClass = 'row-status-belum';
                                                }
                                            @endphp
                                            <tr class="kebun-item-row {{ $rowStatusClass }}" data-region="{{ $regionName }}" data-kebun="{{ $kebunName }}" data-status="{{ $statusVal }}" data-jenis="{{ strtoupper($item['jenis'] ?? '') }}" data-areal="{{ $arealKonsesi }}" data-luas="{{ $luas }}" data-search="{{ strtolower($regionName . ' ' . $kebunName . ' ' . $item['jenis'] . ' ' . $item['nomor'] . ' ' . $statusVal) }}">
                                                <td class="cell-region td-left" style="color: #475569; font-weight: 600; background-color: #ffffff;">{{ $regionName }}</td>
                                                <td class="cell-kebun td-left font-bold" style="color: #0f172a; background-color: #ffffff;">{{ $kebunName }}</td>
                                                <td class="cell-areal td-right font-bold" style="color: #15803d; background-color: #ffffff;">{{ number_format($arealKonsesi, 2, ',', '.') }}</td>

                                                <td class="td-center">
                                                    <span class="badge-alas {{ $jenisClass }}">{{ $item['jenis'] }}</span>
                                                </td>
                                                <td class="td-left font-mono" style="font-size: 0.8rem;">{{ $item['nomor'] }}</td>
                                                <td class="td-center" style="font-size: 0.8rem;">{{ $item['tgl_terbit'] ?? '-' }}</td>
                                                <td class="td-center" style="font-size: 0.8rem;">{{ $item['tgl_berakhir'] ?? '-' }}</td>
                                                <td class="td-center">
                                                    <span class="badge-status {{ $statusClass }}">{{ $statusVal }}</span>
                                                </td>
                                                <td class="td-right font-bold">{{ number_format($luas, 2, ',', '.') }}</td>
                                                <td class="td-right">{{ number_format($pct, 2, ',', '.') }}%</td>
                                                <td class="td-center">
                                                    <button type="button" class="ah-btn-detail" onclick="openDetailModal(this)"
                                                        data-region="{{ $regionName }}"
                                                        data-kebun="{{ $kebunName }}"
                                                        data-jenis="{{ $item['jenis'] ?? '-' }}"
                                                        data-nomor="{{ $item['nomor'] ?? '-' }}"
                                                        data-status="{{ $statusVal }}"
                                                        data-luas="{{ number_format($luas, 2, ',', '.') }}"
                                                        data-nosert="{{ $item['no_sertifikat'] ?? '-' }}"
                                                        data-saplegal="{{ $item['sap_legal'] ?? '-' }}"
                                                        data-eksptpn="{{ $item['eks_ptpn'] ?? '-' }}"
                                                        data-desa="{{ $item['desa'] ?? '-' }}"
                                                        data-kecamatan="{{ $item['kecamatan'] ?? '-' }}"
                                                        data-kabupaten="{{ $item['kabupaten'] ?? '-' }}"
                                                        data-provinsi="{{ $item['provinsi'] ?? '-' }}"
                                                        data-pulau="{{ $item['pulau'] ?? '-' }}"
                                                        data-komoditas="{{ $item['komoditas'] ?? '-' }}"
                                                        data-planted="{{ $item['areal_planted'] ?? '-' }}"
                                                        data-kosong="{{ $item['areal_lahan_kosong'] ?? '-' }}"
                                                        data-jalan="{{ $item['areal_jalan_jembatan'] ?? '-' }}"
                                                        data-bangunan="{{ $item['areal_bangunan'] ?? '-' }}"
                                                        data-rawa="{{ $item['areal_kanal_rawa'] ?? '-' }}"
                                                        data-konservasi="{{ $item['areal_konservasi'] ?? '-' }}"
                                                        data-kerjasama="{{ $item['areal_kerjasama'] ?? '-' }}"
                                                        data-okupasi="{{ $item['areal_okupasi'] ?? '-' }}"
                                                        data-okupasiberat="{{ $item['okupasi_berat'] ?? '-' }}"
                                                        data-bidang="{{ $item['jumlah_bidang'] ?? '-' }}"
                                                        data-nilaibuku="{{ $item['nilai_buku'] ?? '-' }}"
                                                        data-njop="{{ $item['njop'] ?? '-' }}"
                                                        data-fairvalue="{{ $item['fair_value'] ?? '-' }}"
                                                        data-nop="{{ $item['nop'] ?? '-' }}"
                                                        data-statusbphtb="{{ $item['status_bphtb'] ?? '-' }}"
                                                        data-linkpolygon="{{ $item['link_polygon'] ?? '-' }}"
                                                        data-tahunberakhir="{{ $item['tahun_berakhir'] ?? '-' }}">
                                                        <i class="fa-solid fa-eye"></i> Detail
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="kebun-item-row row-status-belum" data-region="{{ $regionName }}" data-kebun="{{ $kebunName }}" data-status="BELUM BERSERTIFIKAT" data-jenis="TIDAK BERSERTIFIKAT" data-areal="{{ $arealKonsesi }}" data-luas="0" data-search="{{ strtolower($regionName . ' ' . $kebunName) }}">
                                            <td class="cell-region td-left" style="color: #475569; font-weight: 600; background-color: #ffffff;">{{ $regionName }}</td>
                                            <td class="cell-kebun td-left font-bold" style="color: #0f172a; background-color: #ffffff;">{{ $kebunName }}</td>
                                            <td class="cell-areal td-right font-bold" style="color: #15803d; background-color: #ffffff;">{{ number_format($arealKonsesi, 2, ',', '.') }}</td>
                                            <td class="td-center" style="color: #94a3b8;">-</td>
                                            <td class="td-center" style="color: #94a3b8;">-</td>
                                            <td class="td-center" style="color: #94a3b8;">-</td>
                                            <td class="td-center" style="color: #94a3b8;">-</td>
                                            <td class="td-center">
                                                <span class="badge-status badge-status-belum">BELUM BERSERTIFIKAT</span>
                                            </td>
                                            <td class="td-right" style="color: #94a3b8;">0,00</td>
                                            <td class="td-right" style="color: #94a3b8;">0,00%</td>
                                            <td class="td-center" style="color: #94a3b8;">-</td>
                                        </tr>
                                    @endif

                                    {{-- SUBTOTAL ROW PER KEBUN --}}
                                    @php
                                        $subtotalPct = $arealKonsesi > 0 ? ($kebunTotalLuas / $arealKonsesi) * 100 : 0;
                                    @endphp
                                    <tr class="kebun-subtotal-row" data-region="{{ $regionName }}" data-kebun="{{ $kebunName }}" style="background-color: #e2e8f0; font-weight: 800; color: #0f172a;">
                                        <td colspan="2" class="td-left" style="padding-left: 14px; font-weight: 800;">
                                            Total {{ $kebunName }} ({{ $rowCount }} Sertifikat)
                                        </td>
                                        <td class="td-right" style="font-weight: 800; color: #15803d;">
                                            {{ number_format($arealKonsesi, 2, ',', '.') }}
                                        </td>
                                        <td class="td-center" style="color: #64748b;">-</td>
                                        <td class="td-center" style="color: #64748b;">-</td>
                                        <td class="td-center" style="color: #64748b;">-</td>
                                        <td class="td-center" style="color: #64748b;">-</td>
                                        <td class="td-center" style="color: #64748b;">-</td>
                                        <td class="td-right" style="font-weight: 800; color: #0f172a;">
                                            {{ number_format($kebunTotalLuas, 2, ',', '.') }}
                                        </td>
                                        <td class="td-right" style="font-weight: 800; color: #0f172a;">
                                            {{ number_format($subtotalPct, 2, ',', '.') }}%
                                        </td>
                                        <td class="td-center" style="color: #64748b;">-</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background-color: #cbd5e1; font-weight: 800;">
                                <td colspan="2" class="td-left" id="footerKebunCount" style="font-weight: 800;">Grand Total ({{ $totalKebunCount }} Kebun)</td>
                                <td class="td-right" id="footerArealTotal" style="font-weight: 800; color: #15803d;">{{ number_format($grandTotalAreal, 2, ',', '.') }}</td>
                                <td class="td-center">-</td>
                                <td class="td-center">-</td>
                                <td class="td-center">-</td>
                                <td class="td-center">-</td>
                                <td class="td-center">-</td>
                                <td class="td-right" id="footerLuasAlas" style="font-weight: 800;">{{ number_format($grandTotalLuas, 2, ',', '.') }}</td>
                                <td class="td-right" id="footerPctAlas" style="font-weight: 800;">{{ number_format($overallPct, 2, ',', '.') }}%</td>
                                <td class="td-center">-</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>

    </div>

    <!-- DETAIL SPREADSHEET POPUP MODAL -->
    <div id="detailModalOverlay" class="ah-modal-overlay" onclick="handleOverlayClick(event)">
        <div class="ah-modal-card" onclick="event.stopPropagation()">
            <div class="ah-modal-header">
                <div>
                    <div class="ah-modal-title">
                        <i class="fa-solid fa-file-invoice"></i> Detail Berkas & Aset Spreadsheet
                    </div>
                    <div id="modalSubTitle" style="font-size: 0.8rem; color: #cbd5e1; margin-top: 2px;"></div>
                </div>
                <button class="ah-modal-close" onclick="closeDetailModal()" title="Tutup">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="ah-modal-body">
                <!-- RINGKASAN UTAMA HEADER BANNER -->
                <div style="background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                    <div>
                        <span style="font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Nama Sertifikat / Berkas:</span>
                        <div id="mMainNomor" style="font-size: 1rem; font-weight: 800; color: #0f172a;">-</div>
                    </div>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <span id="mMainJenis" class="badge-alas badge-hgu">-</span>
                        <span id="mMainStatus" class="badge-status badge-status-berlaku">-</span>
                    </div>
                </div>

                <!-- SEKSI 1: IDENTIFIKASI ASET & LOKASI ADMINISTRATIF -->
                <div class="ah-modal-section">
                    <div class="ah-modal-sec-title">
                        <i class="fa-solid fa-map-location-dot"></i> Identifikasi Aset & Lokasi Administratif
                    </div>
                    <div class="ah-modal-grid">
                        <div class="ah-detail-field">
                            <span class="ah-detail-label">No. Sertifikat Spesifik</span>
                            <span class="ah-detail-val" id="mNoSertifikat">-</span>
                        </div>
                        <div class="ah-detail-field">
                            <span class="ah-detail-label">SAP Legal Asset ID</span>
                            <span class="ah-detail-val" id="mSapLegal">-</span>
                        </div>
                        <div class="ah-detail-field">
                            <span class="ah-detail-label">Eks PTPN</span>
                            <span class="ah-detail-val" id="mEksPtpn">-</span>
                        </div>
                        <div class="ah-detail-field">
                            <span class="ah-detail-label">Jumlah Bidang</span>
                            <span class="ah-detail-val" id="mJumlahBidang">-</span>
                        </div>
                        <div class="ah-detail-field">
                            <span class="ah-detail-label">Desa / Kelurahan</span>
                            <span class="ah-detail-val" id="mDesa">-</span>
                        </div>
                        <div class="ah-detail-field">
                            <span class="ah-detail-label">Kecamatan</span>
                            <span class="ah-detail-val" id="mKecamatan">-</span>
                        </div>
                        <div class="ah-detail-field">
                            <span class="ah-detail-label">Kabupaten / Kota</span>
                            <span class="ah-detail-val" id="mKabupaten">-</span>
                        </div>
                        <div class="ah-detail-field">
                            <span class="ah-detail-label">Provinsi</span>
                            <span class="ah-detail-val" id="mProvinsi">-</span>
                        </div>
                        <div class="ah-detail-field">
                            <span class="ah-detail-label">Pulau</span>
                            <span class="ah-detail-val" id="mPulau">-</span>
                        </div>
                        <div class="ah-detail-field">
                            <span class="ah-detail-label">Komoditas Utama</span>
                            <span class="ah-detail-val" id="mKomoditas" style="color: #166534;">-</span>
                        </div>
                    </div>
                </div>

                <!-- SEKSI 2: RINCIAN USAGE & BREAKDOWN LAHAN (HEKTAR) -->
                <div class="ah-modal-section">
                    <div class="ah-modal-sec-title">
                        <i class="fa-solid fa-chart-pie"></i> Rincian Usage & Breakdown Areal (Hektar)
                    </div>
                    <div class="ah-modal-grid">
                        <div class="ah-detail-field">
                            <span class="ah-detail-label">Areal Planted</span>
                            <span class="ah-detail-val" id="mArealPlanted">-</span>
                        </div>
                        <div class="ah-detail-field">
                            <span class="ah-detail-label">Lahan Kosong / Cadangan</span>
                            <span class="ah-detail-val" id="mArealKosong">-</span>
                        </div>
                        <div class="ah-detail-field">
                            <span class="ah-detail-label">Areal Jalan & Jembatan</span>
                            <span class="ah-detail-val" id="mArealJalan">-</span>
                        </div>
                        <div class="ah-detail-field">
                            <span class="ah-detail-label">Bangunan, Emplasment & Fasum</span>
                            <span class="ah-detail-val" id="mArealBangunan">-</span>
                        </div>
                        <div class="ah-detail-field">
                            <span class="ah-detail-label">Kanal, Parit, Sungai & Rawa</span>
                            <span class="ah-detail-val" id="mArealKanalRawa">-</span>
                        </div>
                        <div class="ah-detail-field">
                            <span class="ah-detail-label">Konservasi / Kawasan Hutan</span>
                            <span class="ah-detail-val" id="mArealKonservasi">-</span>
                        </div>
                        <div class="ah-detail-field">
                            <span class="ah-detail-label">Areal Kerjasama</span>
                            <span class="ah-detail-val" id="mArealKerjasama">-</span>
                        </div>
                        <div class="ah-detail-field">
                            <span class="ah-detail-label">Areal Okupasi (Total)</span>
                            <span class="ah-detail-val" id="mArealOkupasi" style="color: #b91c1c;">-</span>
                        </div>
                    </div>
                </div>

                <!-- SEKSI 3: KEUANGAN, PAJAK & DOKUMEN SPASIAL -->
                <div class="ah-modal-section">
                    <div class="ah-modal-sec-title">
                        <i class="fa-solid fa-coins"></i> Keuangan, Pajak & Legal Spasial
                    </div>
                    <div class="ah-modal-grid">
                        <div class="ah-detail-field">
                            <span class="ah-detail-label">Nilai Buku (Rp)</span>
                            <span class="ah-detail-val" id="mNilaiBuku">-</span>
                        </div>
                        <div class="ah-detail-field">
                            <span class="ah-detail-label">NJOP (Rp)</span>
                            <span class="ah-detail-val" id="mNjop">-</span>
                        </div>
                        <div class="ah-detail-field">
                            <span class="ah-detail-label">Fair Value</span>
                            <span class="ah-detail-val" id="mFairValue">-</span>
                        </div>
                        <div class="ah-detail-field">
                            <span class="ah-detail-label">NOP Pajak</span>
                            <span class="ah-detail-val" id="mNop">-</span>
                        </div>
                        <div class="ah-detail-field">
                            <span class="ah-detail-label">Status BPHTB</span>
                            <span class="ah-detail-val" id="mStatusBphtb">-</span>
                        </div>
                        <div class="ah-detail-field">
                            <span class="ah-detail-label">Tahun Berakhir</span>
                            <span class="ah-detail-val" id="mTahunBerakhir">-</span>
                        </div>
                        <div class="ah-detail-field" style="grid-column: span 2;">
                            <span class="ah-detail-label">Link Polygon / Peta GIS</span>
                            <span class="ah-detail-val" id="mLinkPolygonContainer">-</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
<script>
    const regionKebunData = @json($dataset);
    const statusCountsData = @json($statusCounts);
    const statusHaData = @json($statusHa);
    const jenisCountsData = @json($jenisCounts);

    const chartRegionLabels = @json($chartRegionLabels);
    const chartRegionKonsesi = @json($chartRegionKonsesi);
    const chartRegionSertifikat = @json($chartRegionSertifikat);

    const chartStatusBerlaku = @json($chartStatusBerlaku);
    const chartStatusBerakhir = @json($chartStatusBerakhir);
    const chartStatusBelum = @json($chartStatusBelum);
    const chartStatusEks = @json($chartStatusEks);

    const chartStatusHaBerlaku = @json($chartStatusHaBerlaku);
    const chartStatusHaBerakhir = @json($chartStatusHaBerakhir);
    const chartStatusHaBelum = @json($chartStatusHaBelum);
    const chartStatusHaEks = @json($chartStatusHaEks);

    // Tab Switching Function
    function switchTab(tabId, btn) {
        document.querySelectorAll('.ah-tab-content').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.ah-tab-btn').forEach(el => el.classList.remove('active'));

        document.getElementById(tabId).style.display = 'block';
        btn.classList.add('active');

        if (tabId === 'analyticsTab') {
            if (!window.chartsInitialized) {
                initCharts();
                window.chartsInitialized = true;
            }
            if (!window.globeInitialized) {
                init3DGlobe();
                window.globeInitialized = true;
            }
        }
    }

    // Initialize 3D Globe with Three.js & OrbitControls (Photorealistic NASA Blue Marble Earth)
    function init3DGlobe() {
        const container = document.getElementById('globeCanvasContainer');
        if (!container) return;

        const overlay = document.getElementById('globeLoadingOverlay');
        if (overlay) overlay.style.display = 'none';

        const width = container.clientWidth;
        const height = container.clientHeight;

        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(45, width / height, 0.1, 2000);
        
        // Cosmic deep space starting position for Milky Way warp intro
        camera.position.set(0, 80, 650);

        const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        renderer.setSize(width, height);
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        container.appendChild(renderer.domElement);

        const controls = new THREE.OrbitControls(camera, renderer.domElement);
        controls.enableDamping = true;
        controls.dampingFactor = 0.05;
        controls.rotateSpeed = 0.8;
        controls.enableZoom = true;
        controls.minDistance = 75;
        controls.maxDistance = 800;

        const globeRadius = 70;
        const geometry = new THREE.SphereGeometry(globeRadius, 64, 64);

        // -------------------------------------------------------------
        // 1. GALAXY / MILKY WAY STARFIELD BACKGROUND
        // -------------------------------------------------------------
        const starsCount = 2800;
        const starsGeom = new THREE.BufferGeometry();
        const starsPositions = new Float32Array(starsCount * 3);
        const starsColors = new Float32Array(starsCount * 3);

        for (let i = 0; i < starsCount; i++) {
            const r = 350 + Math.random() * 650;
            const theta = Math.random() * Math.PI * 2;
            const phi = Math.acos((Math.random() * 2) - 1);
            
            starsPositions[i * 3] = r * Math.sin(phi) * Math.cos(theta);
            starsPositions[i * 3 + 1] = r * Math.sin(phi) * Math.sin(theta);
            starsPositions[i * 3 + 2] = r * Math.cos(phi);

            const tint = Math.random();
            if (tint < 0.5) {
                starsColors[i * 3] = 1.0; starsColors[i * 3 + 1] = 1.0; starsColors[i * 3 + 2] = 1.0;
            } else if (tint < 0.8) {
                starsColors[i * 3] = 0.55; starsColors[i * 3 + 1] = 0.82; starsColors[i * 3 + 2] = 1.0;
            } else {
                starsColors[i * 3] = 1.0; starsColors[i * 3 + 1] = 0.88; starsColors[i * 3 + 2] = 0.45;
            }
        }
        starsGeom.setAttribute('position', new THREE.BufferAttribute(starsPositions, 3));
        starsGeom.setAttribute('color', new THREE.BufferAttribute(starsColors, 3));

        const starsMat = new THREE.PointsMaterial({
            size: 2.2,
            vertexColors: true,
            transparent: true,
            opacity: 0.9
        });
        const starField = new THREE.Points(starsGeom, starsMat);
        scene.add(starField);

        // -------------------------------------------------------------
        // 2. PHOTOREALISTIC NASA BLUE MARBLE EARTH GLOBE
        // -------------------------------------------------------------
        const textureLoader = new THREE.TextureLoader();
        
        // High-res photorealistic NASA Earth satellite maps
        const earthMap = textureLoader.load('https://cdn.jsdelivr.net/gh/mrdoob/three.js@dev/examples/textures/planets/earth_atmos_2048.jpg');
        const specularMap = textureLoader.load('https://cdn.jsdelivr.net/gh/mrdoob/three.js@dev/examples/textures/planets/earth_specular_2048.jpg');
        const normalMap = textureLoader.load('https://cdn.jsdelivr.net/gh/mrdoob/three.js@dev/examples/textures/planets/earth_normal_2048.jpg');

        const earthMaterial = new THREE.MeshPhongMaterial({
            map: earthMap,
            specularMap: specularMap,
            normalMap: normalMap,
            normalScale: new THREE.Vector2(0.85, 0.85),
            specular: new THREE.Color(0x334455),
            shininess: 25
        });

        const globe = new THREE.Mesh(geometry, earthMaterial);
        scene.add(globe);

        // -------------------------------------------------------------
        // 3. REALISTIC ATMOSPHERE GLOW RIM LAYER
        // -------------------------------------------------------------
        const atmosGeom = new THREE.SphereGeometry(globeRadius + 2.5, 64, 64);
        const atmosMat = new THREE.MeshBasicMaterial({
            color: 0x38bdf8,
            transparent: true,
            opacity: 0.25,
            side: THREE.BackSide
        });
        const atmos = new THREE.Mesh(atmosGeom, atmosMat);
        scene.add(atmos);

        // Outer blue haze aura
        const outerHazeGeom = new THREE.SphereGeometry(globeRadius + 5.5, 64, 64);
        const outerHazeMat = new THREE.MeshBasicMaterial({
            color: 0x0284c7,
            transparent: true,
            opacity: 0.1,
            side: THREE.BackSide
        });
        scene.add(new THREE.Mesh(outerHazeGeom, outerHazeMat));

        // -------------------------------------------------------------
        // 4. 3D GLOWING PINS & BEACONS FOR PTPN I REGIONAL OFFICES
        // -------------------------------------------------------------
        const regionalOffices = [
            { key: 'Regional 1', label: 'Reg 1 (Medan)', lat: 3.5952, lon: 98.6722 },
            { key: 'Regional 2', label: 'Reg 2 (Bandung)', lat: -6.9175, lon: 107.6191 },
            { key: 'Regional 3', label: 'Reg 3 (Semarang)', lat: -6.9667, lon: 110.4167 },
            { key: 'Regional 4', label: 'Reg 4 (Surabaya)', lat: -7.2575, lon: 112.7521 },
            { key: 'Regional 5', label: 'Reg 5 (Surabaya)', lat: -7.4000, lon: 112.8200 },
            { key: 'Regional 6', label: 'Reg 6 (Aceh)', lat: 5.5483, lon: 95.3238 },
            { key: 'Regional 7', label: 'Reg 7 (Lampung)', lat: -5.4500, lon: 105.2667 },
            { key: 'Regional 8', label: 'Reg 8 (Makassar)', lat: -5.1477, lon: 119.4327 }
        ];

        const markerGroup = new THREE.Group();
        const regionalMarkers = [];

        function latLonToVector3(lat, lon, radius) {
            const phi = (90 - lat) * (Math.PI / 180);
            const theta = (lon + 180) * (Math.PI / 180);
            const x = -(radius * Math.sin(phi) * Math.cos(theta));
            const z = radius * Math.sin(phi) * Math.sin(theta);
            const y = radius * Math.cos(phi);
            return new THREE.Vector3(x, y, z);
        }

        // Sleek micro pin & ring scaling so they remain crisp dots even when zoomed in close
        const pinGeom = new THREE.SphereGeometry(0.35, 16, 16);
        const pinMat = new THREE.MeshBasicMaterial({ color: 0xef4444 });
        const ringGeom = new THREE.RingGeometry(0.5, 1.0, 32);
        const ringMat = new THREE.MeshBasicMaterial({ color: 0xf59e0b, side: THREE.DoubleSide, transparent: true, opacity: 0.85 });

        regionalOffices.forEach(c => {
            const pos = latLonToVector3(c.lat, c.lon, globeRadius + 0.4);
            const pin = new THREE.Mesh(pinGeom, pinMat);
            pin.position.copy(pos);

            const ring = new THREE.Mesh(ringGeom, ringMat);
            ring.position.copy(latLonToVector3(c.lat, c.lon, globeRadius + 0.5));
            ring.lookAt(0, 0, 0);

            markerGroup.add(pin);
            markerGroup.add(ring);

            regionalMarkers.push({ key: c.key, pin: pin, ring: ring });
        });

        globe.add(markerGroup);

        // -------------------------------------------------------------
        // 5. PHOTOREALISTIC MOON ORBITING EARTH
        // -------------------------------------------------------------
        const moonTexture = textureLoader.load('https://cdn.jsdelivr.net/gh/mrdoob/three.js@dev/examples/textures/planets/moon_1024.jpg');
        const moonMat = new THREE.MeshStandardMaterial({
            map: moonTexture,
            roughness: 0.95,
            metalness: 0.1
        });
        const moonGeom = new THREE.SphereGeometry(11, 32, 32);
        const moonMesh = new THREE.Mesh(moonGeom, moonMat);
        scene.add(moonMesh);

        let moonAngle = 0.5;

        // -------------------------------------------------------------
        // 6. REALISTIC SPACE LIGHTING & SUN POSITION
        // -------------------------------------------------------------
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.7);
        scene.add(ambientLight);

        const sunLight = new THREE.DirectionalLight(0xffffff, 1.3);
        sunLight.position.set(200, 100, 180);
        scene.add(sunLight);

        // Target rotation & distance for interactive zooming
        let targetGlobeRotY = -Math.PI / 1.75;
        let targetGlobeRotX = 0.15;
        let targetCamDist = 145; // Default closer overview of Indonesia
        let targetCamY = 0;

        let isIntro = true;
        let introTime = 0;

        // Smooth zoom to regional city coordinates (Focused Regional View)
        window.zoomToRegional = function(regName) {
            let matched = null;
            if (regName) {
                const searchLower = regName.toLowerCase();
                regionalOffices.forEach(r => {
                    if (searchLower.includes(r.key.toLowerCase()) || r.key.toLowerCase().includes(searchLower)) {
                        matched = r;
                    }
                });
            }

            // Filter 3D Pin Markers: Show only matched pin if filter selected, or all if no filter
            regionalMarkers.forEach(m => {
                if (!regName || regName === '') {
                    m.pin.visible = true;
                    m.ring.visible = true;
                } else {
                    const isMatch = regName.toLowerCase().includes(m.key.toLowerCase()) || m.key.toLowerCase().includes(regName.toLowerCase());
                    m.pin.visible = isMatch;
                    m.ring.visible = isMatch;
                }
            });

            if (matched) {
                const lonRad = (matched.lon * Math.PI) / 180;
                const latRad = (matched.lat * Math.PI) / 180;

                targetGlobeRotY = -lonRad - Math.PI / 2;
                targetGlobeRotX = latRad * 0.7;
                targetCamDist = 95; // Close-up aerial view (~95 units from globe center)
                targetCamY = 0;

                const cityBadge = document.getElementById('globeCityBadge');
                if (cityBadge) {
                    cityBadge.innerHTML = `<i class="fa-solid fa-location-dot" style="color: #ef4444;"></i> Aerial View: <strong>${matched.label}</strong> (~1000m)`;
                    cityBadge.style.display = 'inline-flex';
                }
            } else {
                // Reset zoom to Indonesia overview
                targetGlobeRotY = -Math.PI / 1.75;
                targetGlobeRotX = 0.15;
                targetCamDist = 145;
                targetCamY = 0;

                const cityBadge = document.getElementById('globeCityBadge');
                if (cityBadge) {
                    cityBadge.style.display = 'none';
                }
            }
        };

        // Animation Loop
        function animate() {
            requestAnimationFrame(animate);

            // Rotate starfield background slowly
            starField.rotation.y += 0.0002;

            // Orbit Moon around Earth
            moonAngle += 0.0035;
            moonMesh.position.x = Math.sin(moonAngle) * 140;
            moonMesh.position.z = Math.cos(moonAngle) * 140;
            moonMesh.position.y = Math.sin(moonAngle * 0.5) * 22;
            moonMesh.rotation.y += 0.003;

            // Intro zoom from deep space to Earth
            if (isIntro) {
                introTime += 0.012;
                const t = Math.min(1, introTime);
                const ease = 1 - Math.pow(1 - t, 3);
                camera.position.z = 650 - (650 - targetCamDist) * ease;
                camera.position.y = 80 - (80 - targetCamY) * ease;
                if (t >= 1) isIntro = false;
            } else {
                camera.position.z += (targetCamDist - camera.position.z) * 0.06;
                camera.position.y += (targetCamY - camera.position.y) * 0.06;
            }

            // Smooth interpolation to target globe rotation
            globe.rotation.y += (targetGlobeRotY - globe.rotation.y) * 0.06;
            globe.rotation.x += (targetGlobeRotX - globe.rotation.x) * 0.06;

            controls.update();
            renderer.render(scene, camera);
        }
        animate();

        window.addEventListener('resize', function() {
            if (!container) return;
            const w = container.clientWidth;
            const h = container.clientHeight;
            camera.aspect = w / h;
            camera.updateProjectionMatrix();
            renderer.setSize(w, h);
        });
    }



    let chartStatusHaDonut, chartStatusDonut, chartRegionalStacked, chartJenisBar, chartRegionalKonsesiVsAlas;

    // Initialize Chart.js Charts with DataLabels plugin
    function initCharts() {
        if (typeof ChartDataLabels !== 'undefined') {
            Chart.register(ChartDataLabels);
        }

        if (chartStatusHaDonut) { chartStatusHaDonut.destroy(); }
        if (chartStatusDonut) { chartStatusDonut.destroy(); }
        if (chartRegionalStacked) { chartRegionalStacked.destroy(); }
        if (chartJenisBar) { chartJenisBar.destroy(); }
        if (chartRegionalKonsesiVsAlas) { chartRegionalKonsesiVsAlas.destroy(); }

        // Helper function for 3D Gradient colors
        function create3DGrad(ctx, topColor, bottomColor) {
            const g = ctx.createLinearGradient(0, 0, 0, 260);
            g.addColorStop(0, topColor);
            g.addColorStop(1, bottomColor);
            return g;
        }

        // 1. Donut Chart - Luas Areal (Hektar) per Status (3D Gradient & Entrance Animation)
        const statusHaCtx = document.getElementById('statusHaDonutChart').getContext('2d');
        const g1Berlaku = create3DGrad(statusHaCtx, '#34d399', '#15803d');
        const g1Berakhir = create3DGrad(statusHaCtx, '#f87171', '#991b1b');
        const g1Belum = create3DGrad(statusHaCtx, '#fcd34d', '#b45309');
        const g1Eks = create3DGrad(statusHaCtx, '#cbd5e1', '#475569');

        chartStatusHaDonut = new Chart(statusHaCtx, {
            type: 'doughnut',
            data: {
                labels: ['BERLAKU', 'BERAKHIR', 'BELUM BERSERTIFIKAT', 'EKS HGU'],
                datasets: [{
                    data: [
                        statusHaData['BERLAKU'] || 0,
                        statusHaData['BERAKHIR'] || 0,
                        statusHaData['BELUM BERSERTIFIKAT'] || 0,
                        statusHaData['EKS HGU'] || 0
                    ],
                    backgroundColor: [g1Berlaku, g1Berakhir, g1Belum, g1Eks],
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverOffset: 16,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 1500,
                    easing: 'easeInOutQuart'
                },
                plugins: {
                    legend: { position: 'bottom', labels: { font: { weight: 'bold', size: 12 } } },
                    datalabels: {
                        color: function(context) {
                            return context.dataIndex === 2 ? '#713f12' : '#ffffff';
                        },
                        font: { weight: 'bold', size: 11 },
                        formatter: function(value, context) {
                            if (!value || value <= 0) return '';
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let pct = total > 0 ? (value / total * 100).toFixed(1).replace('.', ',') : '0';
                            return [Math.round(value).toLocaleString('id-ID') + ' Ha', '(' + pct + '%)'];
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.parsed || 0;
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let pct = total > 0 ? (value / total * 100).toFixed(1).replace('.', ',') : '0';
                                return label + ': ' + value.toLocaleString('id-ID', { minimumFractionDigits: 2 }) + ' Ha (' + pct + '%)';
                            }
                        }
                    }
                }
            }
        });

        // 2. Donut Chart - Jumlah Berkas Sertifikat per Status (3D Gradient & Entrance Animation)
        const statusCtx = document.getElementById('statusDonutChart').getContext('2d');
        const g2Berlaku = create3DGrad(statusCtx, '#34d399', '#15803d');
        const g2Berakhir = create3DGrad(statusCtx, '#f87171', '#991b1b');
        const g2Belum = create3DGrad(statusCtx, '#fcd34d', '#b45309');
        const g2Eks = create3DGrad(statusCtx, '#cbd5e1', '#475569');

        chartStatusDonut = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['BERLAKU', 'BERAKHIR', 'BELUM BERSERTIFIKAT', 'EKS HGU'],
                datasets: [{
                    data: [
                        statusCountsData['BERLAKU'] || 0,
                        statusCountsData['BERAKHIR'] || 0,
                        statusCountsData['BELUM BERSERTIFIKAT'] || 0,
                        statusCountsData['EKS HGU'] || 0
                    ],
                    backgroundColor: [g2Berlaku, g2Berakhir, g2Belum, g2Eks],
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverOffset: 16,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 1500,
                    easing: 'easeInOutQuart'
                },
                plugins: {
                    legend: { position: 'bottom', labels: { font: { weight: 'bold', size: 12 } } },
                    datalabels: {
                        color: function(context) {
                            return context.dataIndex === 2 ? '#713f12' : '#ffffff';
                        },
                        font: { weight: 'bold', size: 11 },
                        formatter: function(value, context) {
                            if (!value || value <= 0) return '';
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let pct = total > 0 ? (value / total * 100).toFixed(1).replace('.', ',') : '0';
                            return [value.toLocaleString('id-ID') + ' Berkas', '(' + pct + '%)'];
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.parsed || 0;
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let pct = total > 0 ? (value / total * 100).toFixed(1).replace('.', ',') : '0';
                                return label + ': ' + value.toLocaleString('id-ID') + ' Berkas (' + pct + '%)';
                            }
                        }
                    }
                }
            }
        });

        // 3. Stacked Bar Chart - Sebaran Luas Areal (Hektar) per Regional (3D Gradient & Staggered Bar Animation)
        const regStatusHaCtx = document.getElementById('regionalStatusHaStackedChart').getContext('2d');
        const gBarBerlaku = create3DGrad(regStatusHaCtx, '#34d399', '#15803d');
        const gBarBerakhir = create3DGrad(regStatusHaCtx, '#f87171', '#991b1b');
        const gBarBelum = create3DGrad(regStatusHaCtx, '#fcd34d', '#b45309');
        const gBarEks = create3DGrad(regStatusHaCtx, '#cbd5e1', '#475569');

        chartRegionalStacked = new Chart(regStatusHaCtx, {
            type: 'bar',
            data: {
                labels: chartRegionLabels,
                datasets: [
                    { label: 'Luas Berlaku (Ha)', data: chartStatusHaBerlaku, backgroundColor: gBarBerlaku, borderRadius: 4 },
                    { label: 'Luas Berakhir (Ha)', data: chartStatusHaBerakhir, backgroundColor: gBarBerakhir, borderRadius: 4 },
                    { label: 'Belum Bersertifikat (Ha)', data: chartStatusHaBelum, backgroundColor: gBarBelum, borderRadius: 4 },
                    { label: 'Eks HGU (Ha)', data: chartStatusHaEks || [], backgroundColor: gBarEks, borderRadius: 4 }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1300,
                    easing: 'easeOutQuart',
                    delay: function(context) {
                        let delay = 0;
                        if (context.type === 'data' && context.mode === 'default') {
                            delay = context.dataIndex * 80 + (context.datasetIndex || 0) * 120;
                        }
                        return delay;
                    }
                },
                scales: {
                    x: { stacked: true, grid: { display: false } },
                    y: { 
                        stacked: true, 
                        beginAtZero: true, 
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            callback: function(val) {
                                return val.toLocaleString('id-ID') + ' Ha';
                            }
                        }
                    }
                },
                plugins: { 
                    legend: { position: 'top', labels: { font: { weight: 'bold' } } },
                    datalabels: {
                        color: function(context) {
                            return context.datasetIndex === 2 ? '#713f12' : '#ffffff';
                        },
                        font: { weight: 'bold', size: 9 },
                        formatter: function(value, context) {
                            if (!value || value < 3000) return '';
                            let dataIndex = context.dataIndex;
                            let stackTotal = 0;
                            context.chart.data.datasets.forEach(ds => {
                                stackTotal += (ds.data[dataIndex] || 0);
                            });
                            let pct = stackTotal > 0 ? (value / stackTotal * 100).toFixed(1).replace('.', ',') : '0';
                            return Math.round(value).toLocaleString('id-ID') + ' (' + pct + '%)';
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let dataIndex = context.dataIndex;
                                let stackTotal = 0;
                                context.chart.data.datasets.forEach(ds => {
                                    stackTotal += (ds.data[dataIndex] || 0);
                                });
                                let value = context.parsed.y || 0;
                                let pct = stackTotal > 0 ? (value / stackTotal * 100).toFixed(1).replace('.', ',') : '0';
                                return context.dataset.label + ': ' + value.toLocaleString('id-ID', { minimumFractionDigits: 2 }) + ' Ha (' + pct + '%)';
                            }
                        }
                    }
                }
            }
        });

        // 4. Bar Chart - Jenis Hak (Berkas) (3D Sapphire Gradient & Staggered Bar Animation)
        const jenisCtx = document.getElementById('jenisBarChart').getContext('2d');
        const gJenis = create3DGrad(jenisCtx, '#60a5fa', '#1d4ed8');
        const jenisKeys = Object.keys(jenisCountsData);
        const jenisVals = Object.values(jenisCountsData);

        chartJenisBar = new Chart(jenisCtx, {
            type: 'bar',
            data: {
                labels: jenisKeys,
                datasets: [{
                    label: 'Jumlah Berkas',
                    data: jenisVals,
                    backgroundColor: gJenis,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1200,
                    easing: 'easeOutQuart',
                    delay: function(context) {
                        let delay = 0;
                        if (context.type === 'data' && context.mode === 'default') {
                            delay = context.dataIndex * 90;
                        }
                        return delay;
                    }
                },
                plugins: { 
                    legend: { display: false },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        color: '#1e293b',
                        font: { weight: 'bold', size: 10 },
                        formatter: function(value, context) {
                            if (!value || value <= 0) return '';
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let pct = total > 0 ? (value / total * 100).toFixed(1).replace('.', ',') : '0';
                            return value.toLocaleString('id-ID') + ' (' + pct + '%)';
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let value = context.parsed.y || 0;
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let pct = total > 0 ? (value / total * 100).toFixed(1).replace('.', ',') : '0';
                                return 'Jumlah Berkas: ' + value.toLocaleString('id-ID') + ' (' + pct + '%)';
                            }
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // 5. Grouped Bar Chart - Perbandingan Luas Konsesi vs Luas Alas Hak per Regional
        const regKonsesiVsAlasCtx = document.getElementById('regionalKonsesiVsAlasChart').getContext('2d');
        const gBarKonsesiVal = create3DGrad(regKonsesiVsAlasCtx, '#60a5fa', '#1d4ed8');
        const gBarAlasVal = create3DGrad(regKonsesiVsAlasCtx, '#34d399', '#15803d');

        chartRegionalKonsesiVsAlas = new Chart(regKonsesiVsAlasCtx, {
            type: 'bar',
            data: {
                labels: chartRegionLabels,
                datasets: [
                    {
                        label: 'Luas Areal Konsesi (Ha)',
                        data: chartRegionKonsesi,
                        backgroundColor: gBarKonsesiVal,
                        borderRadius: 4
                    },
                    {
                        label: 'Luas Alas Hak (Ha)',
                        data: chartRegionSertifikat,
                        backgroundColor: gBarAlasVal,
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1300,
                    easing: 'easeOutQuart',
                    delay: function(context) {
                        let delay = 0;
                        if (context.type === 'data' && context.mode === 'default') {
                            delay = context.dataIndex * 80 + (context.datasetIndex || 0) * 120;
                        }
                        return delay;
                    }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            callback: function(val) {
                                return val.toLocaleString('id-ID') + ' Ha';
                            }
                        }
                    }
                },
                plugins: {
                    legend: { position: 'top', labels: { font: { weight: 'bold' } } },
                    datalabels: {
                        color: function(context) {
                            return context.datasetIndex === 1 ? '#15803d' : '#1d4ed8';
                        },
                        anchor: 'end',
                        align: 'top',
                        font: { weight: 'bold', size: 9 },
                        formatter: function(value) {
                            if (!value || value <= 0) return '';
                            return Math.round(value).toLocaleString('id-ID') + ' Ha';
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let value = context.parsed.y || 0;
                                return context.dataset.label + ': ' + value.toLocaleString('id-ID', { minimumFractionDigits: 2 }) + ' Ha';
                            }
                        }
                    }
                }
            }
        });
    }

    // Populate Kebun dropdown based on selected Regional
    function onRegionalChange() {
        const regSelect = document.getElementById('selectRegional');
        const kebunSelect = document.getElementById('selectKebun');
        const selectedReg = regSelect.value;

        kebunSelect.innerHTML = '<option value="">-- Semua Kebun --</option>';

        if (selectedReg && regionKebunData[selectedReg]) {
            const kebunMap = regionKebunData[selectedReg].kebun_list || {};
            Object.keys(kebunMap).forEach(kebunName => {
                const opt = document.createElement('option');
                opt.value = kebunName;
                opt.textContent = kebunName;
                kebunSelect.appendChild(opt);
            });
        } else {
            Object.keys(regionKebunData).forEach(reg => {
                const kebunMap = regionKebunData[reg].kebun_list || {};
                Object.keys(kebunMap).forEach(kebunName => {
                    const opt = document.createElement('option');
                    opt.value = kebunName;
                    opt.textContent = kebunName + ' (' + reg + ')';
                    kebunSelect.appendChild(opt);
                });
            });
        }
    }

    // Apply Filter on clicking "Proses" button or typing search
    function applyFilter() {
        const selectedReg = document.getElementById('selectRegional').value.trim();
        const selectedKebun = document.getElementById('selectKebun').value.trim();
        const selectedStatus = document.getElementById('selectStatus').value.trim().toUpperCase();
        const selectedJenis = (document.getElementById('selectJenis') ? document.getElementById('selectJenis').value.trim().toUpperCase() : '');
        const searchInputEl = document.getElementById('searchInput');
        const searchVal = searchInputEl ? searchInputEl.value.toLowerCase().trim() : '';

        // Trigger 3D Globe camera zoom & rotation to selected Regional city
        if (typeof window.zoomToRegional === 'function') {
            window.zoomToRegional(selectedReg);
        }

        const itemRows = document.querySelectorAll('#alasHakTable tbody tr.kebun-item-row');
        const subtotalRows = document.querySelectorAll('#alasHakTable tbody tr.kebun-subtotal-row');
        const headerRows = document.querySelectorAll('#alasHakTable tbody tr.region-header-row');

        let visibleKebunMap = {}; // key: reg + '::' + kebun -> arealKonsesi
        let kebunVisibleLuasMap = {}; // key: reg + '::' + kebun -> sum of visible item luas
        let kebunVisibleCountMap = {}; // key: reg + '::' + kebun -> count of visible items
        let visibleRegions = new Set();
        let totalLuasSum = 0;

        // Data containers for updating Tab 1 charts and metrics
        let filteredStatusHa = { 'BERLAKU': 0, 'BERAKHIR': 0, 'BELUM BERSERTIFIKAT': 0, 'EKS HGU': 0 };
        let filteredStatusCounts = { 'BERLAKU': 0, 'BERAKHIR': 0, 'BELUM BERSERTIFIKAT': 0, 'EKS HGU': 0 };
        let filteredJenisHa = { 'HGU': 0, 'HGB': 0, 'HPL': 0, 'HP': 0 };
        let filteredJenisCounts = {};
        
        let filteredRegStatusHa = {};
        chartRegionLabels.forEach(reg => {
            filteredRegStatusHa[reg] = { 'BERLAKU': 0, 'BERAKHIR': 0, 'BELUM BERSERTIFIKAT': 0, 'EKS HGU': 0 };
        });

        let kebunExpiredMap = {}; // key: reg + '::' + kebun -> { region, kebun, areal_konsesi, expired_count }

        let kebunCertifiedLuasMap = {}; // key: reg + '::' + kebun -> sum of visible certified item luas

        itemRows.forEach(row => {
            const rowRegion = row.getAttribute('data-region') || '';
            const rowKebun = row.getAttribute('data-kebun') || '';
            const rowStatus = (row.getAttribute('data-status') || '').toUpperCase();
            const rowJenis = (row.getAttribute('data-jenis') || '').toUpperCase();
            const rowSearch = row.getAttribute('data-search') || '';

            const matchesReg = selectedReg === '' || rowRegion === selectedReg;
            const matchesKebun = selectedKebun === '' || rowKebun === selectedKebun;
            const matchesStatus = selectedStatus === '' || rowStatus.includes(selectedStatus);
            const matchesJenis = selectedJenis === '' || rowJenis.includes(selectedJenis);
            const matchesSearch = searchVal === '' || rowSearch.includes(searchVal) || rowRegion.toLowerCase().includes(searchVal);

            if (matchesReg && matchesKebun && matchesStatus && matchesJenis && matchesSearch) {
                row.style.display = '';
                const kebunKey = rowRegion + '::' + rowKebun;
                const arealVal = parseFloat(row.getAttribute('data-areal') || '0');
                const luasVal = parseFloat(row.getAttribute('data-luas') || '0');

                visibleKebunMap[kebunKey] = arealVal;
                visibleRegions.add(rowRegion);

                kebunVisibleLuasMap[kebunKey] = (kebunVisibleLuasMap[kebunKey] || 0) + luasVal;
                kebunVisibleCountMap[kebunKey] = (kebunVisibleCountMap[kebunKey] || 0) + 1;
                totalLuasSum += luasVal;

                // Accumulate Jenis Hak Luas (Ha)
                if (rowJenis.includes('HGU')) {
                    filteredJenisHa['HGU'] += luasVal;
                } else if (rowJenis.includes('HGB')) {
                    filteredJenisHa['HGB'] += luasVal;
                } else if (rowJenis.includes('HPL')) {
                    filteredJenisHa['HPL'] += luasVal;
                } else if (rowJenis.includes('HP')) {
                    filteredJenisHa['HP'] += luasVal;
                }

                // Determine category status
                let stCat = 'BERLAKU';
                if (rowStatus.includes('EKS')) {
                    stCat = 'EKS HGU';
                } else if (rowStatus.includes('AKHIR') || rowStatus.includes('EXPIRE')) {
                    stCat = 'BERAKHIR';
                } else if (rowStatus.includes('BELUM') || rowStatus.includes('PROSES')) {
                    stCat = 'BELUM BERSERTIFIKAT';
                } else {
                    stCat = 'BERLAKU';
                }

                if (rowJenis !== 'TIDAK BERSERTIFIKAT' && rowJenis !== '-') {
                    filteredStatusCounts[stCat] = (filteredStatusCounts[stCat] || 0) + 1;
                    filteredStatusHa[stCat] = (filteredStatusHa[stCat] || 0) + luasVal;
                    if (filteredRegStatusHa[rowRegion]) {
                        filteredRegStatusHa[rowRegion][stCat] += luasVal;
                    }
                    if (rowJenis) {
                        filteredJenisCounts[rowJenis] = (filteredJenisCounts[rowJenis] || 0) + 1;
                    }
                } else {
                    filteredStatusCounts['BELUM BERSERTIFIKAT'] = (filteredStatusCounts['BELUM BERSERTIFIKAT'] || 0) + 1;
                }

                if (stCat === 'BERAKHIR') {
                    if (!kebunExpiredMap[kebunKey]) {
                        kebunExpiredMap[kebunKey] = { region: rowRegion, kebun: rowKebun, areal_konsesi: arealVal, expired_count: 0 };
                    }
                    kebunExpiredMap[kebunKey].expired_count += 1;
                }
            } else {
                row.style.display = 'none';
            }
        });

        // Calculate regional active kebun and areal sums
        let regKebunCountMap = {};
        let regArealSumMap = {};

        Object.keys(visibleKebunMap).forEach(kebunKey => {
            const parts = kebunKey.split('::');
            const rName = parts[0];
            const arealVal = visibleKebunMap[kebunKey];
            regKebunCountMap[rName] = (regKebunCountMap[rName] || 0) + 1;
            regArealSumMap[rName] = (regArealSumMap[rName] || 0) + arealVal;
        });

        // Update Kebun Subtotal Rows
        subtotalRows.forEach(row => {
            const rowRegion = row.getAttribute('data-region') || '';
            const rowKebun = row.getAttribute('data-kebun') || '';
            const kebunKey = rowRegion + '::' + rowKebun;

            if (kebunVisibleCountMap[kebunKey] && kebunVisibleCountMap[kebunKey] > 0) {
                row.style.display = '';
                const kebunLuas = kebunVisibleLuasMap[kebunKey] || 0;
                const arealVal = visibleKebunMap[kebunKey] || 0;
                const pct = arealVal > 0 ? (kebunLuas / arealVal) * 100 : 0;

                if (row.children[0]) {
                    row.children[0].innerHTML = '<strong>Total ' + rowKebun + ' (' + kebunVisibleCountMap[kebunKey] + ' Sertifikat)</strong>';
                }
                if (row.children[7]) {
                    row.children[7].textContent = kebunLuas.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }
                if (row.children[8]) {
                    row.children[8].textContent = pct.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '%';
                }
            } else {
                row.style.display = 'none';
            }
        });

        // Update Region Header Rows
        headerRows.forEach(row => {
            const rowRegion = row.getAttribute('data-region') || '';
            if (visibleRegions.has(rowRegion)) {
                row.style.display = '';
                const regKebunCnt = regKebunCountMap[rowRegion] || 0;
                const regArealSum = regArealSumMap[rowRegion] || 0;
                if (row.children[0]) {
                    row.children[0].innerHTML = '<i class="fa-solid fa-layer-group" style="margin-right: 6px;"></i> ' +
                        '<strong>' + rowRegion + '</strong> ' +
                        '<span style="font-weight: normal; color: #475569; font-size: 0.8rem; margin-left: 8px;">' +
                        '(' + regKebunCnt + ' Kebun - Total Konsesi: ' + regArealSum.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' Ha)' +
                        '</span>';
                }
            } else {
                row.style.display = 'none';
            }
        });

        // Calculate Totals
        let totalArealSum = 0;
        Object.values(visibleKebunMap).forEach(val => {
            totalArealSum += val;
        });

        const visibleKebunCount = Object.keys(visibleKebunMap).length;
        const totalPct = totalArealSum > 0 ? (totalLuasSum / totalArealSum) * 100 : 0;

        // Dynamic update of Tab 1 Executive Metric Cards
        const cardTotalArealEl = document.getElementById('cardTotalAreal');
        const cardLuasBerlakuEl = document.getElementById('cardLuasBerlaku');
        const cardLuasBerakhirEl = document.getElementById('cardLuasBerakhir');
        const cardLuasBelumEl = document.getElementById('cardLuasBelum');
        const cardLuasEksEl = document.getElementById('cardLuasEks');

        const cardLuasHguEl = document.getElementById('cardLuasHgu');
        const cardLuasHgbEl = document.getElementById('cardLuasHgb');
        const cardLuasHplEl = document.getElementById('cardLuasHpl');
        const cardLuasHpEl = document.getElementById('cardLuasHp');

        if (cardTotalArealEl) cardTotalArealEl.innerHTML = totalArealSum.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' <span style="font-size: 0.85rem; font-weight: normal;">Ha</span>';
        if (cardLuasBerlakuEl) cardLuasBerlakuEl.innerHTML = (filteredStatusHa['BERLAKU'] || 0).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' <span style="font-size: 0.85rem; font-weight: normal;">Ha</span>';
        if (cardLuasBerakhirEl) cardLuasBerakhirEl.innerHTML = (filteredStatusHa['BERAKHIR'] || 0).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' <span style="font-size: 0.85rem; font-weight: normal;">Ha</span>';
        if (cardLuasBelumEl) cardLuasBelumEl.innerHTML = (filteredStatusHa['BELUM BERSERTIFIKAT'] || 0).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' <span style="font-size: 0.85rem; font-weight: normal;">Ha</span>';
        if (cardLuasEksEl) cardLuasEksEl.innerHTML = (filteredStatusHa['EKS HGU'] || 0).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' <span style="font-size: 0.85rem; font-weight: normal;">Ha</span>';

        if (cardLuasHguEl) cardLuasHguEl.innerHTML = (filteredJenisHa['HGU'] || 0).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' <span style="font-size: 0.85rem; font-weight: normal;">Ha</span>';
        if (cardLuasHgbEl) cardLuasHgbEl.innerHTML = (filteredJenisHa['HGB'] || 0).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' <span style="font-size: 0.85rem; font-weight: normal;">Ha</span>';
        if (cardLuasHplEl) cardLuasHplEl.innerHTML = (filteredJenisHa['HPL'] || 0).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' <span style="font-size: 0.85rem; font-weight: normal;">Ha</span>';
        if (cardLuasHpEl) cardLuasHpEl.innerHTML = (filteredJenisHa['HP'] || 0).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' <span style="font-size: 0.85rem; font-weight: normal;">Ha</span>';

        // Dynamic update of Tab 2 Summary Cards
        const kebunMetric = document.getElementById('metricKebunCount');
        const arealMetric = document.getElementById('metricArealTotal');
        const luasMetric = document.getElementById('metricLuasAlas');
        const pctMetric = document.getElementById('metricPctAlas');

        if (kebunMetric) kebunMetric.textContent = (selectedReg ? selectedReg + ' / ' : '') + visibleKebunCount.toLocaleString('id-ID') + ' Kebun';
        if (arealMetric) arealMetric.innerHTML = totalArealSum.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' <span style="font-size: 0.85rem; font-weight: normal;">Ha</span>';
        if (luasMetric) luasMetric.innerHTML = totalLuasSum.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' <span style="font-size: 0.85rem; font-weight: normal;">Ha</span>';
        if (pctMetric) pctMetric.textContent = totalPct.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '%';

        // Dynamic update of Table Footer (<tfoot>)
        const footerKebunCount = document.getElementById('footerKebunCount');
        const footerArealTotal = document.getElementById('footerArealTotal');
        const footerLuasAlas = document.getElementById('footerLuasAlas');
        const footerPctAlas = document.getElementById('footerPctAlas');

        if (footerKebunCount) footerKebunCount.textContent = 'Grand Total (' + visibleKebunCount.toLocaleString('id-ID') + ' Kebun)';
        if (footerArealTotal) footerArealTotal.textContent = totalArealSum.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        if (footerLuasAlas) footerLuasAlas.textContent = totalLuasSum.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        if (footerPctAlas) footerPctAlas.textContent = totalPct.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '%';

        // Dynamic update of Early Warning Table
        const expiredKebunList = Object.values(kebunExpiredMap).sort((a, b) => b.expired_count - a.expired_count);
        const expiredBadge = document.getElementById('expiredKebunCountBadge');
        const expiredTbody = document.getElementById('expiredKebunTbody');
        if (expiredBadge) expiredBadge.textContent = expiredKebunList.length + ' Kebun';
        if (expiredTbody) {
            let html = '';
            expiredKebunList.slice(0, 10).forEach(ex => {
                html += `<tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 8px 10px; font-weight: 700; color: #0f172a;">
                        ${ex.kebun}
                        <div style="font-size: 0.75rem; color: #64748b; font-weight: normal;">${ex.region}</div>
                    </td>
                    <td style="padding: 8px 10px; text-align: right; font-weight: 700; color: #15803d;">
                        ${ex.areal_konsesi.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                    </td>
                    <td style="padding: 8px 10px; text-align: center;">
                        <span style="background: #fee2e2; color: #b91c1c; font-weight: 800; padding: 2px 8px; border-radius: 6px; font-size: 0.8rem;">
                            ${ex.expired_count} Berkas
                        </span>
                    </td>
                </tr>`;
            });
            if (expiredKebunList.length === 0) {
                html = `<tr><td colspan="3" style="padding: 16px; text-align: center; color: #64748b;">Tidak ada kebun dengan sertifikat berakhir pada filter ini.</td></tr>`;
            }
            expiredTbody.innerHTML = html;
        }

        // Update Chart.js Charts if initialized
        if (chartStatusHaDonut) {
            chartStatusHaDonut.data.datasets[0].data = [
                filteredStatusHa['BERLAKU'] || 0,
                filteredStatusHa['BERAKHIR'] || 0,
                filteredStatusHa['BELUM BERSERTIFIKAT'] || 0,
                filteredStatusHa['EKS HGU'] || 0
            ];
            chartStatusHaDonut.update();
        }

        if (chartStatusDonut) {
            chartStatusDonut.data.datasets[0].data = [
                filteredStatusCounts['BERLAKU'] || 0,
                filteredStatusCounts['BERAKHIR'] || 0,
                filteredStatusCounts['BELUM BERSERTIFIKAT'] || 0,
                filteredStatusCounts['EKS HGU'] || 0
            ];
            chartStatusDonut.update();
        }

        if (chartRegionalStacked) {
            let berlakuArr = [];
            let berakhirArr = [];
            let belumArr = [];
            let eksArr = [];

            chartRegionLabels.forEach(reg => {
                const regStats = filteredRegStatusHa[reg] || { 'BERLAKU': 0, 'BERAKHIR': 0, 'BELUM BERSERTIFIKAT': 0, 'EKS HGU': 0 };
                berlakuArr.push(Math.round(regStats['BERLAKU']));
                berakhirArr.push(Math.round(regStats['BERAKHIR']));
                belumArr.push(Math.round(regStats['BELUM BERSERTIFIKAT']));
                eksArr.push(Math.round(regStats['EKS HGU']));
            });

            chartRegionalStacked.data.datasets[0].data = berlakuArr;
            chartRegionalStacked.data.datasets[1].data = berakhirArr;
            chartRegionalStacked.data.datasets[2].data = belumArr;
            chartRegionalStacked.data.datasets[3].data = eksArr;
            chartRegionalStacked.update();
        }

        if (chartJenisBar) {
            const newKeys = Object.keys(filteredJenisCounts);
            const newVals = Object.values(filteredJenisCounts);
            chartJenisBar.data.labels = newKeys;
            chartJenisBar.data.datasets[0].data = newVals;
            chartJenisBar.update();
        }

        if (chartRegionalKonsesiVsAlas) {
            let konsesiArr = [];
            let sertifikatArr = [];

            chartRegionLabels.forEach(reg => {
                const regArealSum = regArealSumMap[reg] || 0;
                const regStats = filteredRegStatusHa[reg] || { 'BERLAKU': 0, 'BERAKHIR': 0, 'BELUM BERSERTIFIKAT': 0, 'EKS HGU': 0 };
                const regAlasSum = (regStats['BERLAKU'] || 0) + (regStats['BERAKHIR'] || 0) + (regStats['BELUM BERSERTIFIKAT'] || 0) + (regStats['EKS HGU'] || 0);

                konsesiArr.push(Math.round(regArealSum));
                sertifikatArr.push(Math.round(regAlasSum));
            });

            chartRegionalKonsesiVsAlas.data.datasets[0].data = konsesiArr;
            chartRegionalKonsesiVsAlas.data.datasets[1].data = sertifikatArr;
            chartRegionalKonsesiVsAlas.update();
        }

        // Recalculate merged rowspans
        updateRowSpans();
    }

    // Dynamic Rowspan Merging for Regional, Kebun, and Areal Konsesi cells
    function updateRowSpans() {
        const kebunGroups = {};
        document.querySelectorAll('#alasHakTable tbody tr.kebun-item-row').forEach(row => {
            const kebunKey = (row.getAttribute('data-region') || '') + '::' + (row.getAttribute('data-kebun') || '');
            if (!kebunGroups[kebunKey]) kebunGroups[kebunKey] = [];
            kebunGroups[kebunKey].push(row);
        });

        Object.keys(kebunGroups).forEach(kebunKey => {
            const rows = kebunGroups[kebunKey];
            const visibleRows = rows.filter(r => r.style.display !== 'none');
            
            rows.forEach(r => {
                const cRegion = r.querySelector('.cell-region');
                const cKebun = r.querySelector('.cell-kebun');
                const cAreal = r.querySelector('.cell-areal');
                if (cRegion) cRegion.style.display = 'none';
                if (cKebun) cKebun.style.display = 'none';
                if (cAreal) cAreal.style.display = 'none';
            });

            if (visibleRows.length > 0) {
                const firstRow = visibleRows[0];
                const cRegion = firstRow.querySelector('.cell-region');
                const cKebun = firstRow.querySelector('.cell-kebun');
                const cAreal = firstRow.querySelector('.cell-areal');

                if (cRegion) {
                    cRegion.rowSpan = visibleRows.length;
                    cRegion.style.display = '';
                    cRegion.style.verticalAlign = 'middle';
                }
                if (cKebun) {
                    cKebun.rowSpan = visibleRows.length;
                    cKebun.style.display = '';
                    cKebun.style.verticalAlign = 'middle';
                }
                if (cAreal) {
                    cAreal.rowSpan = visibleRows.length;
                    cAreal.style.display = '';
                    cAreal.style.verticalAlign = 'middle';
                }
            }
        });
    }

    // Reset Filters
    function resetFilter() {
        document.getElementById('selectRegional').value = '';
        document.getElementById('selectStatus').value = '';
        if (document.getElementById('selectJenis')) document.getElementById('selectJenis').value = '';
        const searchInputEl = document.getElementById('searchInput');
        if (searchInputEl) searchInputEl.value = '';
        onRegionalChange();
        document.getElementById('selectKebun').value = '';
        applyFilter();
    }

    // ===== DETAIL MODAL HANDLERS =====
    function openDetailModal(btn) {
        const ds = btn.dataset;

        document.getElementById('modalSubTitle').textContent = (ds.kebun || '-') + ' • ' + (ds.region || '-');
        document.getElementById('mMainNomor').textContent = ds.nomor || '-';

        const mJenisEl = document.getElementById('mMainJenis');
        if (mJenisEl) mJenisEl.textContent = ds.jenis || '-';

        const mStatusEl = document.getElementById('mMainStatus');
        if (mStatusEl) {
            mStatusEl.textContent = ds.status || '-';
            const st = (ds.status || '').toUpperCase();
            if (st.includes('BERLAKU')) {
                mStatusEl.className = 'badge-status badge-status-berlaku';
            } else if (st.includes('AKHIR') || st.includes('EXPIRE')) {
                mStatusEl.className = 'badge-status badge-status-berakhir';
            } else if (st.includes('BELUM') || st.includes('PROSES')) {
                mStatusEl.className = 'badge-status badge-status-belum';
            } else {
                mStatusEl.className = 'badge-status badge-status-eks';
            }
        }

        // Set fields (extra spreadsheet details)
        document.getElementById('mNoSertifikat').textContent = ds.nosert || '-';
        document.getElementById('mSapLegal').textContent = ds.saplegal || '-';
        document.getElementById('mEksPtpn').textContent = ds.eksptpn || '-';
        document.getElementById('mJumlahBidang').textContent = ds.bidang || '-';
        document.getElementById('mDesa').textContent = ds.desa || '-';
        document.getElementById('mKecamatan').textContent = ds.kecamatan || '-';
        document.getElementById('mKabupaten').textContent = ds.kabupaten || '-';
        document.getElementById('mProvinsi').textContent = ds.provinsi || '-';
        document.getElementById('mPulau').textContent = ds.pulau || '-';
        document.getElementById('mKomoditas').textContent = ds.komoditas || '-';

        document.getElementById('mArealPlanted').textContent = ds.planted && ds.planted !== '-' ? ds.planted + ' Ha' : '-';
        document.getElementById('mArealKosong').textContent = ds.kosong && ds.kosong !== '-' ? ds.kosong + ' Ha' : '-';
        document.getElementById('mArealJalan').textContent = ds.jalan && ds.jalan !== '-' ? ds.jalan + ' Ha' : '-';
        document.getElementById('mArealBangunan').textContent = ds.bangunan && ds.bangunan !== '-' ? ds.bangunan + ' Ha' : '-';
        document.getElementById('mArealKanalRawa').textContent = ds.rawa && ds.rawa !== '-' ? ds.rawa + ' Ha' : '-';
        document.getElementById('mArealKonservasi').textContent = ds.konservasi && ds.konservasi !== '-' ? ds.konservasi + ' Ha' : '-';
        document.getElementById('mArealKerjasama').textContent = ds.kerjasama && ds.kerjasama !== '-' ? ds.kerjasama + ' Ha' : '-';
        
        let okupasiStr = ds.okupasi && ds.okupasi !== '-' ? ds.okupasi + ' Ha' : '-';
        if (ds.okupasiberat && ds.okupasiberat !== '0' && ds.okupasiberat !== '-') {
            okupasiStr += ' (Berat: ' + ds.okupasiberat + ')';
        }
        document.getElementById('mArealOkupasi').textContent = okupasiStr;

        document.getElementById('mNilaiBuku').textContent = ds.nilaibuku || '-';
        document.getElementById('mNjop').textContent = ds.njop || '-';
        document.getElementById('mFairValue').textContent = ds.fairvalue || '-';
        document.getElementById('mNop').textContent = ds.nop || '-';
        document.getElementById('mStatusBphtb').textContent = ds.statusbphtb || '-';
        document.getElementById('mTahunBerakhir').textContent = ds.tahunberakhir || '-';

        const polyContainer = document.getElementById('mLinkPolygonContainer');
        if (polyContainer) {
            if (ds.linkpolygon && ds.linkpolygon !== '-' && ds.linkpolygon.startsWith('http')) {
                polyContainer.innerHTML = `<a href="${ds.linkpolygon}" target="_blank" style="color: #1d4ed8; font-weight: 700; text-decoration: underline; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka Link Polygon / Peta GIS
                </a>`;
            } else {
                polyContainer.textContent = ds.linkpolygon || '-';
            }
        }

        const overlay = document.getElementById('detailModalOverlay');
        if (overlay) overlay.style.display = 'flex';
    }

    function closeDetailModal() {
        const overlay = document.getElementById('detailModalOverlay');
        if (overlay) overlay.style.display = 'none';
    }

    function handleOverlayClick(e) {
        if (e.target.id === 'detailModalOverlay') {
            closeDetailModal();
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDetailModal();
        }
    });

    // Export Table to Excel (CSV format)
    function exportToExcel() {
        const table = document.getElementById("alasHakTable");
        let csv = [];
        for (let i = 0; i < table.rows.length; i++) {
            if (table.rows[i].style.display === 'none') continue;

            let row = [], cols = table.rows[i].querySelectorAll("td, th");
            for (let j = 0; j < cols.length; j++) {
                let text = cols[j].innerText.replace(/[\r\n]+/g, " ").replace(/"/g, '""');
                row.push('"' + text.trim() + '"');
            }
            csv.push(row.join(","));
        }
        let csvFile = new Blob([csv.join("\n")], { type: "text/csv;charset=utf-8;" });
        let downloadLink = document.createElement("a");
        downloadLink.download = "Rekap_Alas_Hak_Areal_Konsesi_PTPN1.csv";
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }

    // ===== FLOATING TAB NAV OBSERVER =====
    function initStickyTabNav() {
        const tabNav = document.querySelector('.ah-tab-navigation');
        if (!tabNav) return;

        const placeholder = document.createElement('div');
        placeholder.className = 'ah-tab-nav-placeholder';
        placeholder.style.display = 'none';
        tabNav.parentNode.insertBefore(placeholder, tabNav);

        let initialTop = 0;

        function updateInitialTop() {
            if (!tabNav.classList.contains('is-floating')) {
                const rect = tabNav.getBoundingClientRect();
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
                initialTop = rect.top + scrollTop;
            }
        }

        updateInitialTop();

        function onScroll() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
            
            if (initialTop > 0 && scrollTop > initialTop + 10) {
                if (!tabNav.classList.contains('is-floating')) {
                    placeholder.style.height = tabNav.offsetHeight + 'px';
                    placeholder.style.marginBottom = getComputedStyle(tabNav).marginBottom;
                    placeholder.style.display = 'block';
                    tabNav.classList.add('is-floating');
                }
            } else {
                if (tabNav.classList.contains('is-floating')) {
                    tabNav.classList.remove('is-floating');
                    placeholder.style.display = 'none';
                    updateInitialTop();
                }
            }
        }

        window.addEventListener('scroll', onScroll, { passive: true });
        document.addEventListener('scroll', onScroll, { passive: true });
        window.addEventListener('resize', updateInitialTop);
    }

    // Initialize charts, 3D globe & options on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        onRegionalChange();
        initCharts();
        init3DGlobe();
        initStickyTabNav();
        updateRowSpans();
        window.chartsInitialized = true;
        window.globeInitialized = true;
    });
</script>
@endsection

@extends('layouts.app')

@section('title', 'Human Capital Dashboard - PTPN I')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Orbitron:wght@600;700;800&display=swap" rel="stylesheet">

<!-- ApexCharts CDN -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<!-- Leaflet.js CDN -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
    /* Global Reset - White Theme */
    html, body {
        height: auto !important;
        min-height: 100vh;
        overflow-y: auto !important;
        background-color: #f8fafc !important;
        color: #1e293b;
        font-family: 'Inter', sans-serif;
    }

    .main-content {
        padding: 0 !important;
        margin-left: 0 !important;
    }

    /* Container dengan Latar Belakang Putih & Kebun Teh Samar-samar */
    .hr-dashboard-wrapper {
        width: 100%;
        min-height: 100vh;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.92) 0%, rgba(240, 253, 244, 0.88) 100%), 
                    url("{{ asset('5.jpg') }}") no-repeat center center fixed;
        background-size: cover;
        padding-bottom: 60px;
        color: #1e293b;
    }

    /* ===== PAGE HEADER ===== */
    .lm-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 24px;
        width: 100%;
        box-sizing: border-box;
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-bottom: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }

    .lm-header-logo {
        height: 44px;
        display: flex;
        align-items: center;
    }

    .lm-header-logo img {
        height: 100%;
        width: auto;
        object-fit: contain;
    }

    .lm-header-center {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .lm-header-center h1 {
        font-family: 'Orbitron', 'Inter', sans-serif;
        font-size: 1.55rem;
        font-weight: 800;
        background: linear-gradient(90deg, #166534 0%, #15803d 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin: 0;
        letter-spacing: 0.02em;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .pulse-dot {
        width: 10px;
        height: 10px;
        background-color: #166534;
        border-radius: 50%;
        box-shadow: 0 0 10px #166534;
        animation: pulseGlow 1.8s infinite;
        display: inline-block;
    }

    @keyframes pulseGlow {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(22, 101, 52, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(22, 101, 52, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(22, 101, 52, 0); }
    }

    .lm-header-right {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .update-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #dcfce7;
        color: #15803d;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        border: 1px solid #bbf7d0;
        box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08);
    }

    /* ===== CONTENT SECTION (WIDE MODE) ===== */
    .content-section {
        max-width: 100% !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 24px 28px 40px 28px !important;
        box-sizing: border-box !important;
    }

    /* ===== FILTER CARD ===== */
    .filter-card {
        background: rgba(255, 255, 255, 0.94);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border: 1px solid #d1fae5;
        border-left: 5px solid #166534;
        border-radius: 14px;
        padding: 20px 24px;
        margin-bottom: 24px;
        box-shadow: 0 4px 20px rgba(22, 101, 52, 0.06);
    }

    .filter-title {
        color: #166534;
        font-family: 'Orbitron', sans-serif;
        font-size: 13px;
        font-weight: 800;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        letter-spacing: 1px;
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
        color: #475569;
        font-size: 11px;
        font-weight: 700;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    .form-select {
        width: 100%;
        padding: 10px 14px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        color: #1e293b;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.25s ease;
        outline: none;
        cursor: pointer;
    }

    .form-select:focus {
        border-color: #166534;
        box-shadow: 0 0 0 3px rgba(22, 101, 52, 0.15);
    }

    /* ===== 6 SUMMARY CARDS ===== */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }

    .summary-card {
        background: rgba(255, 255, 255, 0.94);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border-radius: 16px;
        padding: 22px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .summary-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #166534, #22c55e);
    }

    .summary-card:hover {
        transform: translateY(-4px);
        border-color: #166534;
        box-shadow: 0 10px 30px rgba(22, 101, 52, 0.12);
    }

    .card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .card-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #dcfce7;
        color: #166534;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        border: 1px solid #bbf7d0;
    }

    .card-label {
        font-size: 0.775rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .card-value {
        font-family: 'Orbitron', 'Inter', sans-serif;
        font-size: 2.5rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
        margin-top: 6px;
    }

    /* ===== CHART CARDS ===== */
    .grid-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        margin-bottom: 24px;
    }

    .grid-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-bottom: 24px;
    }

    .grid-1 {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
        margin-bottom: 24px;
    }

    @media (max-width: 1200px) {
        .grid-2, .grid-3 {
            grid-template-columns: 1fr;
        }
    }

    .chart-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        display: flex;
        flex-direction: column;
        min-height: 400px;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .chart-card:hover {
        border-color: #166534;
        box-shadow: 0 8px 28px rgba(22, 101, 52, 0.1);
    }

    .chart-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f1f5f9;
    }

    .chart-title {
        font-size: 1.05rem;
        font-weight: 800;
        color: #166534;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .chart-title-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #dcfce7;
        color: #166534;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        border: 1px solid #bbf7d0;
    }

    .chart-body {
        flex: 1;
        position: relative;
        width: 100%;
        min-height: 300px;
    }

    /* Submetric cards for Mutasi & Pensiun */
    .submetric-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
        gap: 14px;
        margin-bottom: 20px;
    }

    .submetric-card {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 12px;
        padding: 14px;
        text-align: center;
    }

    .submetric-val {
        font-family: 'Orbitron', sans-serif;
        font-size: 1.5rem;
        font-weight: 800;
        color: #166534;
    }

    .submetric-lbl {
        font-size: 0.775rem;
        font-weight: 700;
        color: #475569;
        margin-top: 4px;
    }

    /* Leaflet Custom Pin & Popup Styling */
    .hr-pin-marker {
        background: #166534;
        border: 2px solid #ffffff;
        color: #ffffff;
        border-radius: 20px;
        padding: 4px 10px;
        font-weight: 800;
        font-size: 11.5px;
        box-shadow: 0 4px 14px rgba(22, 101, 52, 0.4);
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        font-family: 'Inter', sans-serif;
    }

    .hr-pin-marker.ho-pin {
        background: #0f172a;
        border-color: #22c55e;
        color: #22c55e;
    }

    .hr-popup-card {
        padding: 6px 4px;
        font-family: 'Inter', sans-serif;
    }

    .hr-popup-title {
        font-size: 13.5px;
        font-weight: 800;
        color: #166534;
        margin-bottom: 2px;
    }

    .hr-popup-city {
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 8px;
    }

    .hr-popup-val {
        font-size: 14px;
        font-weight: 800;
        color: #0f172a;
    }

    .leaflet-container {
        font-family: 'Inter', sans-serif !important;
    }

    /* ===== EMP DETAIL MODAL STYLING ===== */
    .summary-card, .submetric-card {
        cursor: pointer;
    }

    .summary-card:hover, .submetric-card:hover {
        transform: translateY(-4px);
    }

    .emp-modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
        animation: fadeInModal 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes fadeInModal {
        from { opacity: 0; transform: scale(0.97); }
        to { opacity: 1; transform: scale(1); }
    }

    .emp-modal-container {
        background: #ffffff;
        border-radius: 16px;
        width: 95%;
        max-width: 1240px;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .emp-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 24px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    .emp-modal-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 1.15rem;
        font-weight: 800;
        color: #0f172a;
    }

    .emp-count-badge {
        font-size: 0.8rem;
        font-weight: 700;
        background: #dcfce7;
        color: #166534;
        padding: 4px 12px;
        border-radius: 20px;
        border: 1px solid #bbf7d0;
    }

    .emp-modal-close {
        background: transparent;
        border: none;
        font-size: 1.75rem;
        font-weight: 700;
        color: #64748b;
        cursor: pointer;
        line-height: 1;
        transition: color 0.2s;
    }

    .emp-modal-close:hover {
        color: #ef4444;
    }

    .emp-modal-controls {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 24px;
        background: #ffffff;
        border-bottom: 1px solid #f1f5f9;
        gap: 16px;
        flex-wrap: wrap;
    }

    .emp-btn-export {
        background: #262626;
        color: #ffffff;
        border: none;
        padding: 8px 18px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.85rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .emp-btn-export:hover {
        background: #171717;
    }

    .emp-search-group {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.875rem;
        font-weight: 700;
        color: #334155;
    }

    .emp-search-group input {
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        padding: 6px 14px;
        font-size: 0.85rem;
        outline: none;
        width: 240px;
        transition: border-color 0.2s;
    }

    .emp-search-group input:focus {
        border-color: #166534;
        box-shadow: 0 0 0 3px rgba(22, 101, 52, 0.1);
    }

    .emp-modal-body {
        flex: 1;
        overflow-y: auto;
        padding: 0;
        position: relative;
        background: #ffffff;
        min-height: 350px;
    }

    .emp-loading-spinner {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.85);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        font-weight: 700;
        color: #166534;
        font-size: 1.05rem;
        z-index: 10;
    }

    .emp-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .emp-detail-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.85rem;
        color: #1e293b;
        text-align: left;
    }

    .emp-detail-table th {
        background: #334155;
        color: #ffffff;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.775rem;
        letter-spacing: 0.04em;
        padding: 12px 14px;
        border-right: 1px solid #475569;
        white-space: nowrap;
        position: sticky;
        top: 0;
        z-index: 5;
    }

    .emp-detail-table th:last-child {
        border-right: none;
    }

    .emp-detail-table td {
        padding: 10px 14px;
        border-bottom: 1px solid #f1f5f9;
        border-right: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .emp-detail-table td:last-child {
        border-right: none;
    }

    .emp-detail-table tbody tr:nth-child(even) {
        background: #f8fafc;
    }

    .emp-detail-table tbody tr:hover {
        background: #f0fdf4;
    }

    .emp-modal-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        font-size: 0.85rem;
    }

    .emp-pagination-info {
        font-weight: 600;
        color: #64748b;
    }

    .emp-pagination-controls {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .emp-page-btn {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        padding: 5px 12px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.8rem;
        color: #334155;
        cursor: pointer;
        transition: all 0.2s;
    }

    .emp-page-btn:hover:not(:disabled) {
        background: #166534;
        color: #ffffff;
        border-color: #166534;
    }

    .emp-page-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .emp-page-num {
        font-weight: 700;
        color: #0f172a;
        margin: 0 4px;
    }

    .emp-popup-btn {
        margin-top: 8px;
        width: 100%;
        background: #166534;
        color: #ffffff;
        border: none;
        padding: 6px 10px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 11.5px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .emp-popup-btn:hover {
        background: #15803d;
    }

    /* ===== PAGE LOADING OVERLAY ===== */
    .page-loading-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(15, 23, 42, 0.75);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        z-index: 999999;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }

    .page-loading-backdrop.active {
        opacity: 1;
        pointer-events: auto;
    }

    .page-loading-card {
        background: rgba(255, 255, 255, 0.96);
        border: 1px solid rgba(255, 255, 255, 0.8);
        box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.3), 0 0 40px rgba(22, 101, 52, 0.25);
        border-radius: 24px;
        padding: 40px 50px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        max-width: 440px;
        width: 90%;
        transform: scale(0.95);
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .page-loading-backdrop.active .page-loading-card {
        transform: scale(1);
    }

    .loading-spinner-ring {
        position: relative;
        width: 84px;
        height: 84px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .spinner-outer {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 3.5px solid transparent;
        border-top-color: #166534;
        border-right-color: #22c55e;
        animation: spinOuter 1.2s linear infinite;
    }

    .spinner-inner {
        position: absolute;
        width: 65%;
        height: 65%;
        border-radius: 50%;
        border: 3px solid transparent;
        border-bottom-color: #15803d;
        border-left-color: #86efac;
        animation: spinInner 0.8s linear infinite reverse;
    }

    .spinner-logo {
        width: 38px;
        height: 38px;
        object-fit: contain;
        z-index: 2;
        animation: logoPulse 1.8s ease-in-out infinite;
    }

    @keyframes spinOuter {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes spinInner {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes logoPulse {
        0%, 100% { transform: scale(1); opacity: 0.9; }
        50% { transform: scale(1.1); opacity: 1; }
    }

    .loading-title {
        font-family: 'Orbitron', 'Inter', sans-serif;
        font-size: 1.2rem;
        font-weight: 800;
        background: linear-gradient(90deg, #166534 0%, #15803d 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 6px;
        letter-spacing: 0.02em;
    }

    .loading-subtext {
        font-size: 0.85rem;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 20px;
    }

    .loading-progress-bar {
        width: 100%;
        height: 6px;
        background: #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        position: relative;
    }

    .loading-progress-fill {
        width: 40%;
        height: 100%;
        background: linear-gradient(90deg, #166534, #22c55e);
        border-radius: 10px;
        position: absolute;
        animation: progressSlide 1.5s ease-in-out infinite;
    }

    @keyframes progressSlide {
        0% { left: -40%; width: 30%; }
        50% { width: 60%; }
        100% { left: 100%; width: 30%; }
    }
</style>

<!-- Fullscreen Loading Overlay -->
<div id="pageLoadingOverlay" class="page-loading-backdrop active">
    <div class="page-loading-card">
        <div class="loading-spinner-ring">
            <div class="spinner-outer"></div>
            <div class="spinner-inner"></div>
            <img src="{{ asset('ptpn1.png') }}" class="spinner-logo" alt="PTPN I Logo">
        </div>
        <div class="loading-title">MEMUAT DASHBOARD HR</div>
        <div class="loading-subtext">Sinkronisasi analitik demografi &amp; data pegawai...</div>
        <div class="loading-progress-bar">
            <div class="loading-progress-fill"></div>
        </div>
    </div>
</div>

<div class="hr-dashboard-wrapper">
    <!-- Header White Futuristic -->
    <div class="lm-page-header">
        <div class="lm-header-logo">
            <img src="{{ asset('ptpn1.png') }}" alt="PTPN I Logo">
        </div>
        <div class="lm-header-center">
            <h1>
                <span class="pulse-dot"></span>
                Human Capital Dashboard
            </h1>
        </div>
        <div class="lm-header-right">
            <div class="update-badge">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span id="lastUpdateText">Update: Loading...</span>
            </div>
            <img src="{{ asset('danantara.png') }}" alt="Danantara Logo" style="height: 38px;">
        </div>
    </div>

    <!-- Content Section Wide Mode -->
    <div class="content-section">
        <!-- Filter Card -->
        <div class="filter-card">
            <div class="filter-title">
                <i class="fa-solid fa-sliders"></i> Filter Parameters &amp; Analytics Controls
            </div>
            <div class="filter-grid">
                <div class="form-group">
                    <label class="form-label" for="filterTahun">Tahun</label>
                    <select id="filterTahun" class="form-select">
                        <option value="ALL">Semua Tahun</option>
                        <option value="2026" selected>2026</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="filterRegional">Regional</label>
                    <select id="filterRegional" class="form-select">
                        <option value="ALL">Semua Regional</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="filterUnitKerja">Unit Kerja</label>
                    <select id="filterUnitKerja" class="form-select">
                        <option value="ALL">Semua Unit Kerja</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="filterStatusPegawai">Status Pegawai</label>
                    <select id="filterStatusPegawai" class="form-select">
                        <option value="ALL">Semua Status Pegawai</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- 6 Summary Cards -->
        <div class="summary-grid">
            <div class="summary-card" onclick="openEmpDetailModal('total')" title="Klik untuk rincian Total Karyawan">
                <div class="card-head">
                    <span class="card-label">Total Karyawan</span>
                    <div class="card-icon"><i class="fa-solid fa-users"></i></div>
                </div>
                <div class="card-value" id="valTotalKaryawan">-</div>
            </div>

            <div class="summary-card" onclick="openEmpDetailModal('head_office')" title="Klik untuk rincian Karyawan Head Office">
                <div class="card-head">
                    <span class="card-label">Head Office</span>
                    <div class="card-icon"><i class="fa-solid fa-building"></i></div>
                </div>
                <div class="card-value" id="valHeadOffice">-</div>
            </div>

            <div class="summary-card" onclick="openEmpDetailModal('regional')" title="Klik untuk rincian Karyawan Regional">
                <div class="card-head">
                    <span class="card-label">Regional</span>
                    <div class="card-icon"><i class="fa-solid fa-map-location-dot"></i></div>
                </div>
                <div class="card-value" id="valRegional">-</div>
            </div>

            <div class="summary-card" onclick="openEmpDetailModal('tetap')" title="Klik untuk rincian Karyawan Tetap">
                <div class="card-head">
                    <span class="card-label">Karyawan Tetap</span>
                    <div class="card-icon"><i class="fa-solid fa-user-check"></i></div>
                </div>
                <div class="card-value" id="valKaryawanTetap">-</div>
            </div>

            <div class="summary-card" onclick="openEmpDetailModal('tidak_tetap')" title="Klik untuk rincian Karyawan Tidak Tetap">
                <div class="card-head">
                    <span class="card-label">Karyawan Tidak Tetap</span>
                    <div class="card-icon"><i class="fa-solid fa-user-clock"></i></div>
                </div>
                <div class="card-value" id="valKaryawanTidakTetap">-</div>
            </div>
        </div>

        <!-- Peta Sebaran Karyawan Aktif Indonesia Card -->
        <div class="chart-card" style="margin-bottom: 24px; min-height: 485px;">
            <div class="chart-header">
                <span class="chart-title">
                    <div class="chart-title-icon"><i class="fa-solid fa-map-location-dot"></i></div>
                    Peta Sebaran Karyawan Aktif Indonesia (Regional &amp; Head Office)
                </span>
                <div style="font-size: 0.8rem; font-weight: 700; color: #166534; background: #dcfce7; padding: 6px 14px; border-radius: 20px; border: 1px solid #bbf7d0;">
                    <i class="fa-solid fa-location-dot"></i> Pin Lokasi Regional &amp; Head Office
                </div>
            </div>
            <div id="indonesia-hr-map" style="width: 100%; height: 410px; border-radius: 12px; z-index: 1; border: 1px solid #cbd5e1;"></div>
        </div>

        <!-- Row 1: Komposisi Status & Jabatan per Regional -->
        <div class="grid-2">
            <div class="chart-card">
                <div class="chart-header">
                    <span class="chart-title">
                        <div class="chart-title-icon"><i class="fa-solid fa-chart-column"></i></div>
                        Komposisi Status Karyawan (Tetap vs Tidak Tetap)
                    </span>
                </div>
                <div style="display: flex; gap: 20px; align-items: stretch; flex: 1; flex-wrap: wrap;">
                    <!-- Left Side Submetric Cards -->
                    <div style="display: flex; flex-direction: column; gap: 14px; width: 170px; min-width: 170px; justify-content: center;">
                        <div class="submetric-card" onclick="openEmpDetailModal('tetap')" style="cursor:pointer; background:#f0fdf4; border:1px solid #bbf7d0; text-align:left; padding:16px; border-radius:12px; transition: transform 0.2s;" title="Klik rincian Karyawan Tetap">
                            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:6px;">
                                <span style="font-size:0.75rem; font-weight:700; color:#475569; text-transform:uppercase;">Karyawan Tetap</span>
                                <div style="width:28px; height:28px; border-radius:8px; background:#dcfce7; color:#166534; display:flex; align-items:center; justify-content:center; font-size:0.85rem;"><i class="fa-solid fa-user-check"></i></div>
                            </div>
                            <div class="submetric-val" id="valChart1Tetap" style="color:#166534; font-size:1.6rem; font-weight:800;">-</div>
                        </div>
                        <div class="submetric-card" onclick="openEmpDetailModal('tidak_tetap')" style="cursor:pointer; background:#fffbe6; border:1px solid #ffe58f; text-align:left; padding:16px; border-radius:12px; transition: transform 0.2s;" title="Klik rincian Karyawan Tidak Tetap">
                            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:6px;">
                                <span style="font-size:0.75rem; font-weight:700; color:#475569; text-transform:uppercase;">Tidak Tetap</span>
                                <div style="width:28px; height:28px; border-radius:8px; background:#fff1b8; color:#d48806; display:flex; align-items:center; justify-content:center; font-size:0.85rem;"><i class="fa-solid fa-user-clock"></i></div>
                            </div>
                            <div class="submetric-val" id="valChart1TidakTetap" style="color:#d48806; font-size:1.6rem; font-weight:800;">-</div>
                        </div>
                    </div>
                    <!-- Right Side Stacked Bar Chart -->
                    <div class="chart-body" id="chart1" style="flex: 1; min-width: 280px;"></div>
                </div>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <span class="chart-title">
                        <div class="chart-title-icon"><i class="fa-solid fa-chart-column"></i></div>
                        Komposisi Jabatan Karyawan (Karpim vs Karpel)
                    </span>
                </div>
                <div style="display: flex; gap: 20px; align-items: stretch; flex: 1; flex-wrap: wrap;">
                    <!-- Left Side Submetric Cards -->
                    <div style="display: flex; flex-direction: column; gap: 14px; width: 170px; min-width: 170px; justify-content: center;">
                        <div class="submetric-card" onclick="openEmpDetailModal('pimpinan')" style="cursor:pointer; background:#eff6ff; border:1px solid #bfdbfe; text-align:left; padding:16px; border-radius:12px; transition: transform 0.2s;" title="Klik rincian Karpim (Pimpinan)">
                            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:6px;">
                                <span style="font-size:0.75rem; font-weight:700; color:#475569; text-transform:uppercase;">Karpim (Pimpinan)</span>
                                <div style="width:28px; height:28px; border-radius:8px; background:#dbeafe; color:#1e40af; display:flex; align-items:center; justify-content:center; font-size:0.85rem;"><i class="fa-solid fa-user-tie"></i></div>
                            </div>
                            <div class="submetric-val" id="valChart2Karpim" style="color:#1e40af; font-size:1.6rem; font-weight:800;">-</div>
                        </div>
                        <div class="submetric-card" onclick="openEmpDetailModal('pelaksana')" style="cursor:pointer; background:#ecfdf5; border:1px solid #a7f3d0; text-align:left; padding:16px; border-radius:12px; transition: transform 0.2s;" title="Klik rincian Karpel (Pelaksana)">
                            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:6px;">
                                <span style="font-size:0.75rem; font-weight:700; color:#475569; text-transform:uppercase;">Karpel (Pelaksana)</span>
                                <div style="width:28px; height:28px; border-radius:8px; background:#d1fae5; color:#10b981; display:flex; align-items:center; justify-content:center; font-size:0.85rem;"><i class="fa-solid fa-users-gear"></i></div>
                            </div>
                            <div class="submetric-val" id="valChart2Karpel" style="color:#10b981; font-size:1.6rem; font-weight:800;">-</div>
                        </div>
                    </div>
                    <!-- Right Side Stacked Bar Chart -->
                    <div class="chart-body" id="chart2" style="flex: 1; min-width: 280px;"></div>
                </div>
            </div>
        </div>

        <!-- Row 1.5: Level Organisasi (BOD Level per Regional) -->
        <div class="grid-1" style="margin-bottom: 24px;">
            <div class="chart-card">
                <div class="chart-header">
                    <span class="chart-title">
                        <div class="chart-title-icon"><i class="fa-solid fa-sitemap"></i></div>
                        Komposisi Level Organisasi per Regional (BOD Level)
                    </span>
                </div>
                <!-- 8 Small BOD Level Cards Strip -->
                <div style="display: grid; grid-template-columns: repeat(8, 1fr); gap: 8px; margin-bottom: 14px;">
                    <div class="submetric-card" onclick="openEmpDetailModal('bod_level', 'BOD')" style="cursor:pointer; background:#f0fdf4; border:1px solid #bbf7d0; text-align:center; padding:8px 4px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan BOD">
                        <div style="font-size:0.68rem; font-weight:700; color:#166534; text-transform:uppercase;">BOD</div>
                        <div class="submetric-val" id="valBodBOD" style="color:#166534; font-size:1.15rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('bod_level', 'BOD-1')" style="cursor:pointer; background:#f0fdf4; border:1px solid #bbf7d0; text-align:center; padding:8px 4px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan BOD-1">
                        <div style="font-size:0.68rem; font-weight:700; color:#15803d; text-transform:uppercase;">BOD-1</div>
                        <div class="submetric-val" id="valBodBOD1" style="color:#15803d; font-size:1.15rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('bod_level', 'BOD-2')" style="cursor:pointer; background:#ecfdf5; border:1px solid #a7f3d0; text-align:center; padding:8px 4px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan BOD-2">
                        <div style="font-size:0.68rem; font-weight:700; color:#10b981; text-transform:uppercase;">BOD-2</div>
                        <div class="submetric-val" id="valBodBOD2" style="color:#059669; font-size:1.15rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('bod_level', 'BOD-3')" style="cursor:pointer; background:#ecfdf5; border:1px solid #a7f3d0; text-align:center; padding:8px 4px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan BOD-3">
                        <div style="font-size:0.68rem; font-weight:700; color:#059669; text-transform:uppercase;">BOD-3</div>
                        <div class="submetric-val" id="valBodBOD3" style="color:#047857; font-size:1.15rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('bod_level', 'BOD-4')" style="cursor:pointer; background:#eff6ff; border:1px solid #bfdbfe; text-align:center; padding:8px 4px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan BOD-4">
                        <div style="font-size:0.68rem; font-weight:700; color:#2563eb; text-transform:uppercase;">BOD-4</div>
                        <div class="submetric-val" id="valBodBOD4" style="color:#1d4ed8; font-size:1.15rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('bod_level', 'BOD-5')" style="cursor:pointer; background:#eff6ff; border:1px solid #bfdbfe; text-align:center; padding:8px 4px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan BOD-5">
                        <div style="font-size:0.68rem; font-weight:700; color:#3b82f6; text-transform:uppercase;">BOD-5</div>
                        <div class="submetric-val" id="valBodBOD5" style="color:#2563eb; font-size:1.15rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('bod_level', 'BOD-6')" style="cursor:pointer; background:#f5f3ff; border:1px solid #ddd6fe; text-align:center; padding:8px 4px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan BOD-6">
                        <div style="font-size:0.68rem; font-weight:700; color:#8b5cf6; text-transform:uppercase;">BOD-6</div>
                        <div class="submetric-val" id="valBodBOD6" style="color:#7c3aed; font-size:1.15rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('bod_level', 'Lainnya')" style="cursor:pointer; background:#fffbeb; border:1px solid #fde68a; text-align:center; padding:8px 4px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan Lainnya">
                        <div style="font-size:0.68rem; font-weight:700; color:#d97706; text-transform:uppercase;">Lainnya</div>
                        <div class="submetric-val" id="valBodLainnya" style="color:#b45309; font-size:1.15rem; font-weight:800;">-</div>
                    </div>
                </div>
                <div class="chart-body" id="chart8"></div>
            </div>
        </div>

        <!-- Row 1.6: Person Grade per Regional (Stacked Bar) -->
        <div class="grid-1" style="margin-bottom: 20px;">
            <div class="chart-card">
                <div class="chart-header">
                    <span class="chart-title">
                        <div class="chart-title-icon"><i class="fa-solid fa-layer-group"></i></div>
                        Komposisi Person Grade per Regional
                    </span>
                </div>
                <!-- 15 Small Person Grade Cards Strip -->
                <div style="display: grid; grid-template-columns: repeat(15, 1fr); gap: 6px; margin-bottom: 14px;">
                    <div class="submetric-card" onclick="openEmpDetailModal('person_grade', 'PG-06')" style="cursor:pointer; background:#f0fdf4; border:1px solid #bbf7d0; text-align:center; padding:7px 3px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan PG-06">
                        <div style="font-size:0.62rem; font-weight:700; color:#166534; text-transform:uppercase;">PG-06</div>
                        <div class="submetric-val" id="valPG06" style="color:#166534; font-size:1rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('person_grade', 'PG-07')" style="cursor:pointer; background:#ecfdf5; border:1px solid #a7f3d0; text-align:center; padding:7px 3px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan PG-07">
                        <div style="font-size:0.62rem; font-weight:700; color:#059669; text-transform:uppercase;">PG-07</div>
                        <div class="submetric-val" id="valPG07" style="color:#059669; font-size:1rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('person_grade', 'PG-08')" style="cursor:pointer; background:#eff6ff; border:1px solid #bfdbfe; text-align:center; padding:7px 3px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan PG-08">
                        <div style="font-size:0.62rem; font-weight:700; color:#2563eb; text-transform:uppercase;">PG-08</div>
                        <div class="submetric-val" id="valPG08" style="color:#1d4ed8; font-size:1rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('person_grade', 'PG-09')" style="cursor:pointer; background:#eef2ff; border:1px solid #c7d2fe; text-align:center; padding:7px 3px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan PG-09">
                        <div style="font-size:0.62rem; font-weight:700; color:#4338ca; text-transform:uppercase;">PG-09</div>
                        <div class="submetric-val" id="valPG09" style="color:#3730a3; font-size:1rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('person_grade', 'PG-10')" style="cursor:pointer; background:#f5f3ff; border:1px solid #ddd6fe; text-align:center; padding:7px 3px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan PG-10">
                        <div style="font-size:0.62rem; font-weight:700; color:#7c3aed; text-transform:uppercase;">PG-10</div>
                        <div class="submetric-val" id="valPG10" style="color:#6d28d9; font-size:1rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('person_grade', 'PG-11')" style="cursor:pointer; background:#fdf4ff; border:1px solid #e9d5ff; text-align:center; padding:7px 3px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan PG-11">
                        <div style="font-size:0.62rem; font-weight:700; color:#9333ea; text-transform:uppercase;">PG-11</div>
                        <div class="submetric-val" id="valPG11" style="color:#7e22ce; font-size:1rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('person_grade', 'PG-12')" style="cursor:pointer; background:#fdf2f8; border:1px solid #fbcfe8; text-align:center; padding:7px 3px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan PG-12">
                        <div style="font-size:0.62rem; font-weight:700; color:#db2777; text-transform:uppercase;">PG-12</div>
                        <div class="submetric-val" id="valPG12" style="color:#be185d; font-size:1rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('person_grade', 'PG-13')" style="cursor:pointer; background:#fff7ed; border:1px solid #ffedd5; text-align:center; padding:7px 3px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan PG-13">
                        <div style="font-size:0.62rem; font-weight:700; color:#ea580c; text-transform:uppercase;">PG-13</div>
                        <div class="submetric-val" id="valPG13" style="color:#c2410c; font-size:1rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('person_grade', 'PG-14')" style="cursor:pointer; background:#fef9c3; border:1px solid #fde68a; text-align:center; padding:7px 3px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan PG-14">
                        <div style="font-size:0.62rem; font-weight:700; color:#d97706; text-transform:uppercase;">PG-14</div>
                        <div class="submetric-val" id="valPG14" style="color:#b45309; font-size:1rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('person_grade', 'PG-15')" style="cursor:pointer; background:#fef3c7; border:1px solid #fde68a; text-align:center; padding:7px 3px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan PG-15">
                        <div style="font-size:0.62rem; font-weight:700; color:#b45309; text-transform:uppercase;">PG-15</div>
                        <div class="submetric-val" id="valPG15" style="color:#92400e; font-size:1rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('person_grade', 'PG-16')" style="cursor:pointer; background:#fef2f2; border:1px solid #fecaca; text-align:center; padding:7px 3px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan PG-16">
                        <div style="font-size:0.62rem; font-weight:700; color:#ef4444; text-transform:uppercase;">PG-16</div>
                        <div class="submetric-val" id="valPG16" style="color:#dc2626; font-size:1rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('person_grade', 'PG-17')" style="cursor:pointer; background:#fef2f2; border:1px solid #fca5a5; text-align:center; padding:7px 3px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan PG-17">
                        <div style="font-size:0.62rem; font-weight:700; color:#dc2626; text-transform:uppercase;">PG-17</div>
                        <div class="submetric-val" id="valPG17" style="color:#b91c1c; font-size:1rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('person_grade', 'PG-18')" style="cursor:pointer; background:#fdf4ff; border:1px solid #d8b4fe; text-align:center; padding:7px 3px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan PG-18">
                        <div style="font-size:0.62rem; font-weight:700; color:#a855f7; text-transform:uppercase;">PG-18</div>
                        <div class="submetric-val" id="valPG18" style="color:#9333ea; font-size:1rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('person_grade', 'PG-19')" style="cursor:pointer; background:#f5f3ff; border:1px solid #c4b5fd; text-align:center; padding:7px 3px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan PG-19">
                        <div style="font-size:0.62rem; font-weight:700; color:#7c3aed; text-transform:uppercase;">PG-19</div>
                        <div class="submetric-val" id="valPG19" style="color:#6d28d9; font-size:1rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('person_grade', 'Non-Grade')" style="cursor:pointer; background:#f8fafc; border:1px solid #cbd5e1; text-align:center; padding:7px 3px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan Non-Grade">
                        <div style="font-size:0.62rem; font-weight:700; color:#64748b; text-transform:uppercase;">Non-Grade</div>
                        <div class="submetric-val" id="valPGNonGrade" style="color:#475569; font-size:1rem; font-weight:800;">-</div>
                    </div>
                </div>
                <div class="chart-body" id="chart9"></div>
            </div>
        </div>

        <!-- Row 2: Jenis Kelamin & Pernikahan -->
        <div class="grid-2">
            <div class="chart-card">
                <div class="chart-header">
                    <span class="chart-title">
                        <div class="chart-title-icon"><i class="fa-solid fa-venus-mars"></i></div>
                        Komposisi Jenis Kelamin per Regional (Laki-laki vs Perempuan)
                    </span>
                </div>
                <div style="display: flex; gap: 20px; align-items: stretch; flex: 1; flex-wrap: wrap;">
                    <!-- Left Side Submetric Cards -->
                    <div style="display: flex; flex-direction: column; gap: 14px; width: 170px; min-width: 170px; justify-content: center;">
                        <div class="submetric-card" onclick="openEmpDetailModal('gender', 'Laki-laki')" style="cursor:pointer; background:#f0fdf4; border:1px solid #bbf7d0; text-align:left; padding:16px; border-radius:12px; transition: transform 0.2s;" title="Klik rincian Karyawan Laki-laki">
                            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:6px;">
                                <span style="font-size:0.75rem; font-weight:700; color:#475569; text-transform:uppercase;">Total Laki-laki</span>
                                <div style="width:28px; height:28px; border-radius:8px; background:#dcfce7; color:#166534; display:flex; align-items:center; justify-content:center; font-size:0.85rem;"><i class="fa-solid fa-mars"></i></div>
                            </div>
                            <div class="submetric-val" id="valTotalLakiLaki" style="color:#166534; font-size:1.6rem; font-weight:800;">-</div>
                        </div>
                        <div class="submetric-card" onclick="openEmpDetailModal('gender', 'Perempuan')" style="cursor:pointer; background:#fdf2f8; border:1px solid #fbcfe8; text-align:left; padding:16px; border-radius:12px; transition: transform 0.2s;" title="Klik rincian Karyawan Perempuan">
                            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:6px;">
                                <span style="font-size:0.75rem; font-weight:700; color:#475569; text-transform:uppercase;">Total Perempuan</span>
                                <div style="width:28px; height:28px; border-radius:8px; background:#fce7f3; color:#ec4899; display:flex; align-items:center; justify-content:center; font-size:0.85rem;"><i class="fa-solid fa-venus"></i></div>
                            </div>
                            <div class="submetric-val" id="valTotalPerempuan" style="color:#ec4899; font-size:1.6rem; font-weight:800;">-</div>
                        </div>
                    </div>
                    <!-- Right Side Stacked Bar Chart -->
                    <div class="chart-body" id="chart5" style="flex: 1; min-width: 280px;"></div>
                </div>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <span class="chart-title">
                        <div class="chart-title-icon"><i class="fa-solid fa-ring"></i></div>
                        Komposisi Status Pernikahan per Regional (Menikah vs Belum Menikah)
                    </span>
                </div>
                <div style="display: flex; gap: 20px; align-items: stretch; flex: 1; flex-wrap: wrap;">
                    <!-- Left Side Submetric Cards -->
                    <div style="display: flex; flex-direction: column; gap: 14px; width: 170px; min-width: 170px; justify-content: center;">
                        <div class="submetric-card" onclick="openEmpDetailModal('nikah', 'Menikah')" style="cursor:pointer; background:#f0fdf4; border:1px solid #bbf7d0; text-align:left; padding:16px; border-radius:12px; transition: transform 0.2s;" title="Klik rincian Karyawan Menikah">
                            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:6px;">
                                <span style="font-size:0.75rem; font-weight:700; color:#475569; text-transform:uppercase;">Total Menikah</span>
                                <div style="width:28px; height:28px; border-radius:8px; background:#dcfce7; color:#10b981; display:flex; align-items:center; justify-content:center; font-size:0.85rem;"><i class="fa-solid fa-ring"></i></div>
                            </div>
                            <div class="submetric-val" id="valTotalMenikah" style="color:#10b981; font-size:1.6rem; font-weight:800;">-</div>
                        </div>
                        <div class="submetric-card" onclick="openEmpDetailModal('nikah', 'Belum Menikah')" style="cursor:pointer; background:#eff6ff; border:1px solid #bfdbfe; text-align:left; padding:12px 14px; border-radius:12px; transition: transform 0.2s;" title="Klik rincian Karyawan Belum Menikah">
                            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:4px;">
                                <span style="font-size:0.75rem; font-weight:700; color:#475569; text-transform:uppercase;">Belum Menikah</span>
                                <div style="width:26px; height:26px; border-radius:6px; background:#dbeafe; color:#3b82f6; display:flex; align-items:center; justify-content:center; font-size:0.8rem;"><i class="fa-solid fa-user"></i></div>
                            </div>
                            <div class="submetric-val" id="valTotalBelumMenikah" style="color:#3b82f6; font-size:1.4rem; font-weight:800;">-</div>
                        </div>
                        <div class="submetric-card" onclick="openEmpDetailModal('nikah', 'Cerai')" style="cursor:pointer; background:#fef2f2; border:1px solid #fecaca; text-align:left; padding:12px 14px; border-radius:12px; transition: transform 0.2s;" title="Klik rincian Karyawan Cerai / Lainnya">
                            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:4px;">
                                <span style="font-size:0.75rem; font-weight:700; color:#475569; text-transform:uppercase;">Cerai / Lainnya</span>
                                <div style="width:26px; height:26px; border-radius:6px; background:#fee2e2; color:#ef4444; display:flex; align-items:center; justify-content:center; font-size:0.8rem;"><i class="fa-solid fa-heart-crack"></i></div>
                            </div>
                            <div class="submetric-val" id="valTotalCerai" style="color:#ef4444; font-size:1.4rem; font-weight:800;">-</div>
                        </div>
                    </div>
                    <!-- Right Side Stacked Bar Chart -->
                    <div class="chart-body" id="chart15" style="flex: 1; min-width: 280px;"></div>
                </div>
            </div>
        </div>

        <!-- Row 3: Pendidikan & Agama -->
        <div class="grid-2">
            <div class="chart-card">
                <div class="chart-header">
                    <span class="chart-title">
                        <div class="chart-title-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                        Komposisi Tingkat Pendidikan per Regional (SD s/d S3)
                    </span>
                </div>
                <!-- 8 Small Education Cards Strip -->
                <div style="display: grid; grid-template-columns: repeat(8, 1fr); gap: 8px; margin-bottom: 14px;">
                    <div class="submetric-card" onclick="openEmpDetailModal('pendidikan', 'SD')" style="cursor:pointer; background:#f0fdf4; border:1px solid #bbf7d0; text-align:center; padding:8px 4px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan SD">
                        <div style="font-size:0.68rem; font-weight:700; color:#166534; text-transform:uppercase;">SD</div>
                        <div class="submetric-val" id="valEduSD" style="color:#166534; font-size:1.15rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('pendidikan', 'SMP')" style="cursor:pointer; background:#f0fdf4; border:1px solid #bbf7d0; text-align:center; padding:8px 4px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan SMP">
                        <div style="font-size:0.68rem; font-weight:700; color:#15803d; text-transform:uppercase;">SMP</div>
                        <div class="submetric-val" id="valEduSMP" style="color:#15803d; font-size:1.15rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('pendidikan', 'SMA')" style="cursor:pointer; background:#f0fdf4; border:1px solid #bbf7d0; text-align:center; padding:8px 4px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan SMA">
                        <div style="font-size:0.68rem; font-weight:700; color:#22c55e; text-transform:uppercase;">SMA</div>
                        <div class="submetric-val" id="valEduSMA" style="color:#15803d; font-size:1.15rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('pendidikan', 'D3')" style="cursor:pointer; background:#ecfdf5; border:1px solid #a7f3d0; text-align:center; padding:8px 4px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan D3">
                        <div style="font-size:0.68rem; font-weight:700; color:#10b981; text-transform:uppercase;">D3</div>
                        <div class="submetric-val" id="valEduD3" style="color:#059669; font-size:1.15rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('pendidikan', 'D4')" style="cursor:pointer; background:#ecfdf5; border:1px solid #a7f3d0; text-align:center; padding:8px 4px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan D4">
                        <div style="font-size:0.68rem; font-weight:700; color:#059669; text-transform:uppercase;">D4</div>
                        <div class="submetric-val" id="valEduD4" style="color:#047857; font-size:1.15rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('pendidikan', 'S1')" style="cursor:pointer; background:#eff6ff; border:1px solid #bfdbfe; text-align:center; padding:8px 4px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan S1">
                        <div style="font-size:0.68rem; font-weight:700; color:#2563eb; text-transform:uppercase;">S1</div>
                        <div class="submetric-val" id="valEduS1" style="color:#1d4ed8; font-size:1.15rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('pendidikan', 'S2')" style="cursor:pointer; background:#f5f3ff; border:1px solid #ddd6fe; text-align:center; padding:8px 4px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan S2">
                        <div style="font-size:0.68rem; font-weight:700; color:#8b5cf6; text-transform:uppercase;">S2</div>
                        <div class="submetric-val" id="valEduS2" style="color:#7c3aed; font-size:1.15rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('pendidikan', 'S3')" style="cursor:pointer; background:#fffbeb; border:1px solid #fde68a; text-align:center; padding:8px 4px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan S3">
                        <div style="font-size:0.68rem; font-weight:700; color:#d97706; text-transform:uppercase;">S3</div>
                        <div class="submetric-val" id="valEduS3" style="color:#b45309; font-size:1.15rem; font-weight:800;">-</div>
                    </div>
                </div>
                <div class="chart-body" id="chart4"></div>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <span class="chart-title">
                        <div class="chart-title-icon"><i class="fa-solid fa-hands-praying"></i></div>
                        Komposisi Sebaran Agama per Regional
                    </span>
                </div>
                <!-- 7 Small Agama Cards Strip -->
                <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 8px; margin-bottom: 14px;">
                    <div class="submetric-card" onclick="openEmpDetailModal('agama', 'Islam')" style="cursor:pointer; background:#f0fdf4; border:1px solid #bbf7d0; text-align:center; padding:8px 4px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan Agama Islam">
                        <div style="font-size:0.68rem; font-weight:700; color:#166534; text-transform:uppercase;">Islam</div>
                        <div class="submetric-val" id="valAgamaIslam" style="color:#166534; font-size:1.15rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('agama', 'Kristen')" style="cursor:pointer; background:#eff6ff; border:1px solid #bfdbfe; text-align:center; padding:8px 4px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan Agama Kristen">
                        <div style="font-size:0.68rem; font-weight:700; color:#2563eb; text-transform:uppercase;">Kristen</div>
                        <div class="submetric-val" id="valAgamaKristen" style="color:#1d4ed8; font-size:1.15rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('agama', 'Katolik')" style="cursor:pointer; background:#f5f3ff; border:1px solid #ddd6fe; text-align:center; padding:8px 4px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan Agama Katolik">
                        <div style="font-size:0.68rem; font-weight:700; color:#7c3aed; text-transform:uppercase;">Katolik</div>
                        <div class="submetric-val" id="valAgamaKatolik" style="color:#6d28d9; font-size:1.15rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('agama', 'Hindu')" style="cursor:pointer; background:#fffbeb; border:1px solid #fde68a; text-align:center; padding:8px 4px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan Agama Hindu">
                        <div style="font-size:0.68rem; font-weight:700; color:#d97706; text-transform:uppercase;">Hindu</div>
                        <div class="submetric-val" id="valAgamaHindu" style="color:#b45309; font-size:1.15rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('agama', 'Buddha')" style="cursor:pointer; background:#fff7ed; border:1px solid #ffedd5; text-align:center; padding:8px 4px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan Agama Buddha">
                        <div style="font-size:0.68rem; font-weight:700; color:#ea580c; text-transform:uppercase;">Buddha</div>
                        <div class="submetric-val" id="valAgamaBuddha" style="color:#c2410c; font-size:1.15rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('agama', 'Konghucu')" style="cursor:pointer; background:#fdf2f8; border:1px solid #fbcfe8; text-align:center; padding:8px 4px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan Agama Konghucu">
                        <div style="font-size:0.68rem; font-weight:700; color:#db2777; text-transform:uppercase;">Konghucu</div>
                        <div class="submetric-val" id="valAgamaKonghucu" style="color:#be185d; font-size:1.15rem; font-weight:800;">-</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('agama', 'Lainnya')" style="cursor:pointer; background:#f8fafc; border:1px solid #e2e8f0; text-align:center; padding:8px 4px; border-radius:10px; transition: transform 0.2s;" title="Klik rincian Karyawan Agama Lainnya">
                        <div style="font-size:0.68rem; font-weight:700; color:#64748b; text-transform:uppercase;">Lainnya</div>
                        <div class="submetric-val" id="valAgamaLainnya" style="color:#475569; font-size:1.15rem; font-weight:800;">-</div>
                    </div>
                </div>
                <div class="chart-body" id="chart6"></div>
            </div>
        </div>

        <!-- Row 4: Suku Treemap -->
        <div class="grid-1">
            <div class="chart-card">
                <div class="chart-header">
                    <span class="chart-title">
                        <div class="chart-title-icon"><i class="fa-solid fa-people-group"></i></div>
                        Suku &amp; Keberagaman Kultur
                    </span>
                </div>
                <div class="chart-body" id="chart7"></div>
            </div>
        </div>


        <!-- Row 8: Umur & Masa Kerja -->
        <div class="grid-2">
            <div class="chart-card">
                <div class="chart-header">
                    <span class="chart-title">
                        <div class="chart-title-icon"><i class="fa-solid fa-cake-candles"></i></div>
                        Distribusi Umur Karyawan
                    </span>
                </div>
                <div class="chart-body" id="chart13"></div>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <span class="chart-title">
                        <div class="chart-title-icon"><i class="fa-solid fa-business-time"></i></div>
                        Masa Kerja Karyawan
                    </span>
                </div>
                <div class="chart-body" id="chart14"></div>
            </div>
        </div>

        <!-- Row 9: Mutasi & Pensiun -->
        <div class="grid-2">
            <div class="chart-card">
                <div class="chart-header">
                    <span class="chart-title">
                        <div class="chart-title-icon"><i class="fa-solid fa-right-left"></i></div>
                        Mutasi &amp; Pergerakan Pegawai
                    </span>
                </div>
                <div class="submetric-grid">
                    <div class="submetric-card" onclick="openEmpDetailModal('mutasi', 'Total')" title="Klik rincian mutasi">
                        <div class="submetric-val" id="mutasiTotal">-</div>
                        <div class="submetric-lbl">Total Mutasi</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('mutasi', 'Promosi')" title="Klik rincian promosi">
                        <div class="submetric-val" id="mutasiPromosi" style="color:#166534;">-</div>
                        <div class="submetric-lbl">Promosi</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('mutasi', 'Rotasi')" title="Klik rincian rotasi">
                        <div class="submetric-val" id="mutasiRotasi" style="color:#2563eb;">-</div>
                        <div class="submetric-lbl">Rotasi</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('mutasi', 'Demosi')" title="Klik rincian demosi">
                        <div class="submetric-val" id="mutasiDemosi" style="color:#dc2626;">-</div>
                        <div class="submetric-lbl">Demosi</div>
                    </div>
                </div>
                <div class="chart-body" id="chart16"></div>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <span class="chart-title">
                        <div class="chart-title-icon"><i class="fa-solid fa-user-clock"></i></div>
                        Estimasi Pensiun Pegawai
                    </span>
                </div>
                <div class="submetric-grid">
                    <div class="submetric-card" onclick="openEmpDetailModal('pensiun', '30d')" title="Klik rincian pensiun 30 hari">
                        <div class="submetric-val" id="pensiun30d" style="color:#e11d48;">-</div>
                        <div class="submetric-lbl">30 Hari</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('pensiun', '6m')" title="Klik rincian pensiun 6 bulan">
                        <div class="submetric-val" id="pensiun6m" style="color:#d97706;">-</div>
                        <div class="submetric-lbl">6 Bulan</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('pensiun', '1y')" title="Klik rincian pensiun 1 tahun">
                        <div class="submetric-val" id="pensiun1y" style="color:#2563eb;">-</div>
                        <div class="submetric-lbl">1 Tahun</div>
                    </div>
                    <div class="submetric-card" onclick="openEmpDetailModal('pensiun', '3y')" title="Klik rincian pensiun 3 tahun">
                        <div class="submetric-val" id="pensiun3y" style="color:#166534;">-</div>
                        <div class="submetric-lbl">3 Tahun</div>
                    </div>
                </div>
                <div class="chart-body" id="chart17"></div>
            </div>
        </div>
    </div>
</div>

<script>
    // Light Theme Palette (Deep Forest Green & Emerald Accents)
    const GREEN_PALETTE = ['#166534', '#15803d', '#22c55e', '#10b981', '#047857', '#34d399', '#86efac', '#065f46', '#a7f3d0'];

    let chartInstances = {};
    let mapInstance = null;
    let pinsLayer = null;

    document.addEventListener('DOMContentLoaded', function() {
        loadDashboardData();

        document.getElementById('filterTahun').addEventListener('change', loadDashboardData);
        document.getElementById('filterRegional').addEventListener('change', loadDashboardData);
        document.getElementById('filterUnitKerja').addEventListener('change', loadDashboardData);
        document.getElementById('filterStatusPegawai').addEventListener('change', loadDashboardData);
    });

    function showPageLoading() {
        const overlay = document.getElementById('pageLoadingOverlay');
        if (overlay) overlay.classList.add('active');
    }

    function hidePageLoading() {
        const overlay = document.getElementById('pageLoadingOverlay');
        if (overlay) {
            setTimeout(() => {
                overlay.classList.remove('active');
            }, 300);
        }
    }

    function loadDashboardData() {
        showPageLoading();
        const tahun = document.getElementById('filterTahun').value;
        const regional = document.getElementById('filterRegional').value;
        const unit_kerja = document.getElementById('filterUnitKerja').value;
        const status_pegawai = document.getElementById('filterStatusPegawai').value;

        const params = new URLSearchParams({ tahun, regional, unit_kerja, status_pegawai });

        fetch("{{ route('api.hr_demographic_data') }}?" + params.toString())
            .then(res => res.json())
            .then(data => {
                populateFilters(data.filter_options);
                updateSummary(data.summary);
                renderMapPins(data.map_pins);
                renderAllCharts(data);
                hidePageLoading();
            })
            .catch(err => {
                console.error("Error loading HRIS data:", err);
                hidePageLoading();
            });
    }

    function populateFilters(opts) {
        if (!opts) return;

        const regSelect = document.getElementById('filterRegional');
        if (regSelect.options.length <= 1 && opts.regional_list) {
            opts.regional_list.forEach(r => {
                const opt = document.createElement('option');
                opt.value = r;
                opt.textContent = r;
                regSelect.appendChild(opt);
            });
        }

        const unitSelect = document.getElementById('filterUnitKerja');
        if (unitSelect.options.length <= 1 && opts.unit_kerja_list) {
            opts.unit_kerja_list.forEach(u => {
                const opt = document.createElement('option');
                opt.value = u;
                opt.textContent = u;
                unitSelect.appendChild(opt);
            });
        }

        const stSelect = document.getElementById('filterStatusPegawai');
        if (stSelect.options.length <= 1 && opts.status_pegawai_list) {
            opts.status_pegawai_list.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s;
                opt.textContent = s;
                stSelect.appendChild(opt);
            });
        }
    }

    function updateSummary(s) {
        if (!s) return;
        const setVal = (id, val) => {
            const el = document.getElementById(id);
            if (el) el.textContent = val;
        };
        setVal('valTotalKaryawan', (s.total || 0).toLocaleString());
        setVal('valHeadOffice', (s.head_office || 0).toLocaleString());
        setVal('valRegional', (s.regional || 0).toLocaleString());
        setVal('valKaryawanTetap', (s.tetap || 0).toLocaleString());
        setVal('valKaryawanTidakTetap', (s.tidak_tetap || 0).toLocaleString());
        setVal('valPersenPimpinan', (s.pimpinan_pct || 0) + '%');
        setVal('lastUpdateText', 'Update: ' + (s.last_update || ''));
    }

    function renderMapPins(pins) {
        if (!pins || !pins.length) return;

        if (!mapInstance) {
            mapInstance = L.map('indonesia-hr-map', { zoomControl: false }).setView([-2.5, 118], 5);
            L.control.zoom({ position: 'topright' }).addTo(mapInstance);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(mapInstance);
            pinsLayer = L.layerGroup().addTo(mapInstance);
        }

        pinsLayer.clearLayers();

        pins.forEach(p => {
            const isHO = p.key === 'HO';
            const iconHtml = `
                <div class="hr-pin-marker ${isHO ? 'ho-pin' : ''}">
                    <i class="fa-solid ${isHO ? 'fa-building' : 'fa-location-dot'}"></i>
                    <span>${p.title}: ${p.total.toLocaleString()}</span>
                </div>
            `;
            const customIcon = L.divIcon({
                html: iconHtml,
                className: 'hr-custom-leaflet-icon',
                iconSize: [140, 30],
                iconAnchor: [70, 15]
            });

            const popupContent = `
                <div class="hr-popup-card">
                    <div class="hr-popup-title">${p.title}</div>
                    <div class="hr-popup-city"><i class="fa-solid fa-city"></i> ${p.city}</div>
                    <div class="hr-popup-val"><i class="fa-solid fa-users"></i> ${p.total.toLocaleString()} Karyawan Aktif</div>
                    <div style="display: flex; gap: 6px; margin-top: 8px; flex-wrap: wrap;">
                        <div style="font-size:11.5px; color:#166534; font-weight:700; background:#dcfce7; padding:4px 8px; border-radius:6px; border:1px solid #bbf7d0;">
                            Tetap: ${(p.tetap || 0).toLocaleString()} Karyawan
                        </div>
                        <div style="font-size:11.5px; color:#b45309; font-weight:700; background:#fef3c7; padding:4px 8px; border-radius:6px; border:1px solid #fde68a;">
                            Tidak Tetap: ${(p.tidak_tetap || 0).toLocaleString()} Karyawan
                        </div>
                    </div>
                    <button class="emp-popup-btn" onclick="openEmpDetailModal('map_pin', '${p.key}')">
                        <i class="fa-solid fa-users-rectangle"></i> Lihat Rincian Karyawan
                    </button>
                </div>
            `;

            L.marker([p.lat, p.lng], { icon: customIcon })
                .bindPopup(popupContent)
                .addTo(pinsLayer);
        });
    }

    function renderAllCharts(d) {
        Object.keys(chartInstances).forEach(key => {
            if (chartInstances[key]) chartInstances[key].destroy();
        });
        chartInstances = {};

        const lightChartBase = {
            chart: { background: 'transparent', fontFamily: 'Inter, sans-serif' },
            grid: { borderColor: '#f1f5f9' },
            tooltip: { theme: 'light' }
        };

        // Helper for chart click events
        const bindClick = (type, getVal) => ({
            events: {
                dataPointSelection: (evt, ctx, config) => {
                    if (config.dataPointIndex !== undefined && config.dataPointIndex >= 0) {
                        const val = getVal(config);
                        if (val) openEmpDetailModal(type, val);
                    }
                }
            }
        });

        // 1. Stacked Bar Chart Status Karyawan per Regional (Tetap vs Tidak Tetap)
        if (d.chart1) {
            document.getElementById('valChart1Tetap').textContent = (d.chart1.total_tetap || 0).toLocaleString();
            document.getElementById('valChart1TidakTetap').textContent = (d.chart1.total_tidak_tetap || 0).toLocaleString();
        }

        chartInstances['c1'] = new ApexCharts(document.querySelector("#chart1"), {
            ...lightChartBase,
            chart: { 
                ...lightChartBase.chart, 
                type: 'bar', 
                height: 290,
                stacked: true,
                toolbar: { show: false },
                events: {
                    dataPointSelection: (evt, ctx, config) => {
                        const sIdx = config.seriesIndex;
                        const dIdx = config.dataPointIndex;
                        const category = d.chart1.categories[dIdx];
                        const stackName = d.chart1.series[sIdx].name;
                        openEmpDetailModal('chart1_stack', `${category}|${stackName}`);
                    }
                }
            },
            plotOptions: { bar: { horizontal: false, columnWidth: '50%', borderRadius: 4 } },
            xaxis: { categories: d.chart1.categories, labels: { rotate: -25, style: { fontSize: '11px', fontWeight: 600 } } },
            series: d.chart1.series,
            colors: ['#166534', '#f59e0b'],
            legend: { position: 'top' }
        });
        chartInstances['c1'].render();

        // 2. Stacked Bar Chart Jabatan Karyawan per Regional (Karpim vs Karpel)
        if (d.chart2) {
            document.getElementById('valChart2Karpim').textContent = (d.chart2.total_karpim || 0).toLocaleString();
            document.getElementById('valChart2Karpel').textContent = (d.chart2.total_karpel || 0).toLocaleString();
        }

        chartInstances['c2'] = new ApexCharts(document.querySelector("#chart2"), {
            ...lightChartBase,
            chart: { 
                ...lightChartBase.chart, 
                type: 'bar', 
                height: 290, 
                stacked: true, 
                toolbar: { show: false },
                events: {
                    dataPointSelection: (evt, ctx, config) => {
                        const sIdx = config.seriesIndex;
                        const dIdx = config.dataPointIndex;
                        const category = d.chart2.categories[dIdx];
                        const stackName = d.chart2.series[sIdx].name;
                        openEmpDetailModal('chart2_stack', `${category}|${stackName}`);
                    }
                }
            },
            plotOptions: { bar: { horizontal: false, columnWidth: '50%', borderRadius: 4 } },
            xaxis: { categories: d.chart2.categories, labels: { rotate: -25, style: { fontSize: '11px', fontWeight: 600 } } },
            series: d.chart2.series,
            colors: ['#1e40af', '#10b981'],
            legend: { position: 'top' }
        });
        chartInstances['c2'].render();

        // 4. Grouped Bar Chart Tingkat Pendidikan per Regional (SD s/d S3)
        if (d.chart4 && d.chart4.totals) {
            ['SD', 'SMP', 'SMA', 'D3', 'D4', 'S1', 'S2', 'S3'].forEach(lvl => {
                const el = document.getElementById('valEdu' + lvl);
                if (el) el.textContent = (d.chart4.totals[lvl] || 0).toLocaleString();
            });
        }

        const eduPalette = ['#166534', '#15803d', '#22c55e', '#10b981', '#059669', '#2563eb', '#8b5cf6', '#d97706'];

        chartInstances['c4'] = new ApexCharts(document.querySelector("#chart4"), {
            ...lightChartBase,
            chart: { 
                ...lightChartBase.chart, 
                type: 'bar', 
                height: 330, 
                stacked: false, 
                toolbar: { show: false },
                events: {
                    dataPointSelection: (evt, ctx, config) => {
                        const sIdx = config.seriesIndex;
                        const dIdx = config.dataPointIndex;
                        const category = d.chart4.categories[dIdx];
                        const stackName = d.chart4.series[sIdx].name;
                        openEmpDetailModal('chart4_stack', `${category}|${stackName}`);
                    }
                }
            },
            plotOptions: { 
                bar: { 
                    horizontal: false, 
                    columnWidth: '85%', 
                    borderRadius: 2
                } 
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '9px',
                    fontFamily: 'Inter, sans-serif',
                    fontWeight: 700
                },
                offsetY: -5,
                formatter: function (val) {
                    return val > 0 ? val.toLocaleString() : '';
                }
            },
            xaxis: { 
                categories: d.chart4.categories, 
                labels: { rotate: -25, style: { fontSize: '11px', fontWeight: 600 } } 
            },
            series: d.chart4.series,
            colors: eduPalette,
            legend: { position: 'top' }
        });
        chartInstances['c4'].render();

        // 5. Stacked Bar Chart Jenis Kelamin (Laki-laki vs Perempuan per Regional)
        if (d.chart5) {
            document.getElementById('valTotalLakiLaki').textContent = (d.chart5.total_laki || 0).toLocaleString();
            document.getElementById('valTotalPerempuan').textContent = (d.chart5.total_perempuan || 0).toLocaleString();
        }

        chartInstances['c5'] = new ApexCharts(document.querySelector("#chart5"), {
            ...lightChartBase,
            chart: { 
                ...lightChartBase.chart, 
                type: 'bar', 
                height: 290, 
                stacked: true, 
                toolbar: { show: false },
                events: {
                    dataPointSelection: (evt, ctx, config) => {
                        const sIdx = config.seriesIndex;
                        const dIdx = config.dataPointIndex;
                        const category = d.chart5.categories[dIdx];
                        const stackName = d.chart5.series[sIdx].name;
                        openEmpDetailModal('chart5_stack', `${category}|${stackName}`);
                    }
                }
            },
            plotOptions: { 
                bar: { 
                    horizontal: false, 
                    columnWidth: '50%', 
                    borderRadius: 4
                } 
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '11px',
                    fontFamily: 'Inter, sans-serif',
                    fontWeight: 700,
                    colors: ['#ffffff']
                },
                formatter: function (val) {
                    return val > 0 ? val.toLocaleString() : '';
                }
            },
            xaxis: { 
                categories: d.chart5.categories, 
                labels: { rotate: -25, style: { fontSize: '11px', fontWeight: 600 } } 
            },
            series: d.chart5.series,
            colors: ['#166534', '#ec4899'],
            legend: { position: 'top' }
        });
        chartInstances['c5'].render();

        // 6. Stacked Bar Chart Sebaran Agama per Regional
        if (d.chart6 && d.chart6.totals) {
            ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'].forEach(ag => {
                const el = document.getElementById('valAgama' + ag);
                if (el) el.textContent = (d.chart6.totals[ag] || 0).toLocaleString();
            });
        }

        const agamaPalette = ['#166534', '#2563eb', '#7c3aed', '#d97706', '#ea580c', '#db2777', '#64748b'];

        chartInstances['c6'] = new ApexCharts(document.querySelector("#chart6"), {
            ...lightChartBase,
            chart: { 
                ...lightChartBase.chart, 
                type: 'bar', 
                height: 310, 
                stacked: true, 
                toolbar: { show: false },
                events: {
                    dataPointSelection: (evt, ctx, config) => {
                        const sIdx = config.seriesIndex;
                        const dIdx = config.dataPointIndex;
                        const category = d.chart6.categories[dIdx];
                        const stackName = d.chart6.series[sIdx].name;
                        openEmpDetailModal('chart6_stack', `${category}|${stackName}`);
                    }
                }
            },
            plotOptions: { 
                bar: { 
                    horizontal: false, 
                    columnWidth: '50%', 
                    borderRadius: 4
                } 
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '10px',
                    fontFamily: 'Inter, sans-serif',
                    fontWeight: 700,
                    colors: ['#ffffff']
                },
                formatter: function (val) {
                    return val > 0 ? val.toLocaleString() : '';
                }
            },
            xaxis: { 
                categories: d.chart6.categories, 
                labels: { rotate: -25, style: { fontSize: '11px', fontWeight: 600 } } 
            },
            series: d.chart6.series,
            colors: agamaPalette,
            legend: { position: 'top' }
        });
        chartInstances['c6'].render();

        // 7. Suku (Treemap)
        chartInstances['c7'] = new ApexCharts(document.querySelector("#chart7"), {
            ...lightChartBase,
            chart: { 
                ...lightChartBase.chart, 
                type: 'treemap', 
                height: 320, 
                toolbar: { show: false },
                events: {
                    dataPointSelection: (evt, ctx, config) => {
                        if (config.dataPointIndex !== undefined && config.dataPointIndex >= 0) {
                            const item = config.w.config.series[config.seriesIndex]?.data[config.dataPointIndex];
                            const sukuName = item ? (item.x || item) : null;
                            if (sukuName) openEmpDetailModal('suku', sukuName);
                        }
                    }
                }
            },
            series: [{ data: d.chart7.series }],
            colors: ['#166534', '#15803d', '#22c55e', '#047857']
        });
        chartInstances['c7'].render();

        // 8. Stacked Bar Chart Level Organisasi (BOD Level per Regional)
        if (d.chart8 && d.chart8.totals) {
            const mapKeys = { 'BOD': 'valBodBOD', 'BOD-1': 'valBodBOD1', 'BOD-2': 'valBodBOD2', 'BOD-3': 'valBodBOD3', 'BOD-4': 'valBodBOD4', 'BOD-5': 'valBodBOD5', 'BOD-6': 'valBodBOD6', 'Lainnya': 'valBodLainnya' };
            Object.keys(mapKeys).forEach(lvl => {
                const el = document.getElementById(mapKeys[lvl]);
                if (el) el.textContent = (d.chart8.totals[lvl] || 0).toLocaleString();
            });
        }

        const bodPalette = ['#166534', '#15803d', '#10b981', '#059669', '#2563eb', '#3b82f6', '#8b5cf6', '#d97706'];

        chartInstances['c8'] = new ApexCharts(document.querySelector("#chart8"), {
            ...lightChartBase,
            chart: { 
                ...lightChartBase.chart, 
                type: 'bar', 
                height: 310, 
                stacked: true, 
                toolbar: { show: false },
                events: {
                    dataPointSelection: (evt, ctx, config) => {
                        const sIdx = config.seriesIndex;
                        const dIdx = config.dataPointIndex;
                        const category = d.chart8.categories[dIdx];
                        const stackName = d.chart8.series[sIdx].name;
                        openEmpDetailModal('chart8_stack', `${category}|${stackName}`);
                    }
                }
            },
            plotOptions: { 
                bar: { 
                    horizontal: false, 
                    columnWidth: '50%', 
                    borderRadius: 4
                } 
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '10px',
                    fontFamily: 'Inter, sans-serif',
                    fontWeight: 700,
                    colors: ['#ffffff']
                },
                formatter: function (val) {
                    return val > 0 ? val.toLocaleString() : '';
                }
            },
            xaxis: { 
                categories: d.chart8.categories, 
                labels: { rotate: -25, style: { fontSize: '11px', fontWeight: 600 } } 
            },
            series: d.chart8.series,
            colors: bodPalette,
            legend: { position: 'top' }
        });
        chartInstances['c8'].render();

        // 9. Person Grade per Regional (Stacked Bar)
        if (d.chart9 && d.chart9.totals) {
            const pgCardMap = {
                'PG-06': 'valPG06', 'PG-07': 'valPG07', 'PG-08': 'valPG08',
                'PG-09': 'valPG09', 'PG-10': 'valPG10', 'PG-11': 'valPG11',
                'PG-12': 'valPG12', 'PG-13': 'valPG13', 'PG-14': 'valPG14',
                'PG-15': 'valPG15', 'PG-16': 'valPG16', 'PG-17': 'valPG17',
                'PG-18': 'valPG18', 'PG-19': 'valPG19', 'Non-Grade': 'valPGNonGrade'
            };
            Object.keys(pgCardMap).forEach(pg => {
                const el = document.getElementById(pgCardMap[pg]);
                if (el) el.textContent = (d.chart9.totals[pg] || 0).toLocaleString();
            });
        }

        const pgPalette = [
            '#166534', '#059669', '#2563eb', '#4338ca', '#7c3aed',
            '#9333ea', '#db2777', '#ea580c', '#d97706', '#b45309',
            '#92400e', '#dc2626', '#b91c1c', '#a855f7', '#64748b'
        ];

        chartInstances['c9'] = new ApexCharts(document.querySelector("#chart9"), {
            ...lightChartBase,
            chart: { 
                ...lightChartBase.chart, 
                type: 'bar', 
                height: 320, 
                stacked: true, 
                toolbar: { show: false },
                events: {
                    dataPointSelection: (evt, ctx, config) => {
                        const sIdx = config.seriesIndex;
                        const dIdx = config.dataPointIndex;
                        const category = d.chart9.categories[dIdx];
                        const stackName = d.chart9.series[sIdx].name;
                        openEmpDetailModal('chart9_stack', `${category}|${stackName}`);
                    }
                }
            },
            plotOptions: { 
                bar: { 
                    horizontal: false, 
                    columnWidth: '50%', 
                    borderRadius: 4
                } 
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '10px',
                    fontFamily: 'Inter, sans-serif',
                    fontWeight: 700,
                    colors: ['#ffffff']
                },
                formatter: function (val) {
                    return val > 0 ? val.toLocaleString() : '';
                }
            },
            xaxis: { 
                categories: d.chart9.categories, 
                labels: { rotate: -25, style: { fontSize: '11px', fontWeight: 600 } } 
            },
            series: d.chart9.series,
            colors: pgPalette,
            legend: { position: 'top' }
        });
        chartInstances['c9'].render();

        // 13. Distribusi Umur (Histogram)
        chartInstances['c13'] = new ApexCharts(document.querySelector("#chart13"), {
            ...lightChartBase,
            chart: { 
                ...lightChartBase.chart, 
                type: 'bar', 
                height: 290, 
                toolbar: { show: false },
                ...bindClick('umur', (cfg) => d.chart13.categories[cfg.dataPointIndex]).events
            },
            plotOptions: { bar: { borderRadius: 6, columnWidth: '55%' } },
            xaxis: { categories: d.chart13.categories },
            series: [{ name: 'Jumlah Karyawan', data: d.chart13.series }],
            colors: ['#166534']
        });
        chartInstances['c13'].render();

        // 14. Masa Kerja (Bar)
        chartInstances['c14'] = new ApexCharts(document.querySelector("#chart14"), {
            ...lightChartBase,
            chart: { 
                ...lightChartBase.chart, 
                type: 'bar', 
                height: 290, 
                toolbar: { show: false },
                ...bindClick('masa_kerja', (cfg) => d.chart14.categories[cfg.dataPointIndex]).events
            },
            plotOptions: { bar: { borderRadius: 6, columnWidth: '55%' } },
            xaxis: { categories: d.chart14.categories },
            series: [{ name: 'Karyawan', data: d.chart14.series }],
            colors: ['#15803d']
        });
        chartInstances['c14'].render();

        // 15. Stacked Bar Chart Status Pernikahan per Regional (Menikah, Belum Menikah, Cerai)
        if (d.chart15) {
            document.getElementById('valTotalMenikah').textContent = (d.chart15.total_menikah || 0).toLocaleString();
            document.getElementById('valTotalBelumMenikah').textContent = (d.chart15.total_belum_menikah || 0).toLocaleString();
            if (document.getElementById('valTotalCerai')) {
                document.getElementById('valTotalCerai').textContent = (d.chart15.total_cerai || 0).toLocaleString();
            }
        }

        chartInstances['c15'] = new ApexCharts(document.querySelector("#chart15"), {
            ...lightChartBase,
            chart: { 
                ...lightChartBase.chart, 
                type: 'bar', 
                height: 290, 
                stacked: true, 
                toolbar: { show: false },
                events: {
                    dataPointSelection: (evt, ctx, config) => {
                        const sIdx = config.seriesIndex;
                        const dIdx = config.dataPointIndex;
                        const category = d.chart15.categories[dIdx];
                        const stackName = d.chart15.series[sIdx].name;
                        openEmpDetailModal('chart15_stack', `${category}|${stackName}`);
                    }
                }
            },
            plotOptions: { 
                bar: { 
                    horizontal: false, 
                    columnWidth: '50%', 
                    borderRadius: 4
                } 
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '11px',
                    fontFamily: 'Inter, sans-serif',
                    fontWeight: 700,
                    colors: ['#ffffff']
                },
                formatter: function (val) {
                    return val > 0 ? val.toLocaleString() : '';
                }
            },
            xaxis: { 
                categories: d.chart15.categories, 
                labels: { rotate: -25, style: { fontSize: '11px', fontWeight: 600 } } 
            },
            series: d.chart15.series,
            colors: ['#10b981', '#3b82f6', '#ef4444'],
            legend: { position: 'top' }
        });
        chartInstances['c15'].render();

        // 16. Mutasi Dashboard Sub-metrics & Bar Chart
        document.getElementById('mutasiTotal').textContent = d.chart16.total.toLocaleString();
        document.getElementById('mutasiPromosi').textContent = d.chart16.promosi.toLocaleString();
        document.getElementById('mutasiRotasi').textContent = d.chart16.rotasi.toLocaleString();
        document.getElementById('mutasiDemosi').textContent = d.chart16.demosi.toLocaleString();

        chartInstances['c16'] = new ApexCharts(document.querySelector("#chart16"), {
            ...lightChartBase,
            chart: { 
                ...lightChartBase.chart, 
                type: 'bar', 
                height: 200, 
                toolbar: { show: false },
                ...bindClick('mutasi', (cfg) => ['Promosi', 'Rotasi', 'Demosi'][cfg.dataPointIndex]).events
            },
            plotOptions: { bar: { borderRadius: 6, columnWidth: '40%' } },
            xaxis: { categories: ['Promosi', 'Rotasi', 'Demosi'] },
            series: [{ name: 'Pergerakan', data: [d.chart16.promosi, d.chart16.rotasi, d.chart16.demosi] }],
            colors: ['#166534', '#2563eb', '#dc2626']
        });
        chartInstances['c16'].render();

        // 17. Pensiun Dashboard Sub-metrics & Bar Chart
        document.getElementById('pensiun30d').textContent = d.chart17.pensiun_30d.toLocaleString();
        document.getElementById('pensiun6m').textContent = d.chart17.pensiun_6m.toLocaleString();
        document.getElementById('pensiun1y').textContent = d.chart17.pensiun_1y.toLocaleString();
        document.getElementById('pensiun3y').textContent = d.chart17.pensiun_3y.toLocaleString();

        chartInstances['c17'] = new ApexCharts(document.querySelector("#chart17"), {
            ...lightChartBase,
            chart: { 
                ...lightChartBase.chart, 
                type: 'bar', 
                height: 200, 
                toolbar: { show: false },
                ...bindClick('pensiun', (cfg) => ['30d', '6m', '1y', '3y'][cfg.dataPointIndex]).events
            },
            plotOptions: { bar: { borderRadius: 6, columnWidth: '45%' } },
            xaxis: { categories: ['30 Hari', '6 Bulan', '1 Tahun', '3 Tahun'] },
            series: [{ name: 'Jumlah Pensiun', data: [d.chart17.pensiun_30d, d.chart17.pensiun_6m, d.chart17.pensiun_1y, d.chart17.pensiun_3y] }],
            colors: ['#e11d48', '#d97706', '#2563eb', '#166534']
        });
        chartInstances['c17'].render();
    }

    // ===== EMP DETAIL MODAL CONTROLLER =====
    let currentEmpDetailList = [];
    let currentEmpPage = 1;
    const empPageSize = 50;

    function openEmpDetailModal(type, value = '') {
        const modal = document.getElementById('empDetailModal');
        const titleText = document.getElementById('empModalTitleText');
        const badgeCount = document.getElementById('empModalBadgeCount');
        const tbody = document.getElementById('empTableBody');
        const loading = document.getElementById('empModalLoading');
        const searchInput = document.getElementById('empSearchInput');

        modal.style.display = 'flex';
        loading.style.display = 'flex';
        tbody.innerHTML = '';
        searchInput.value = '';
        badgeCount.textContent = 'Loading...';
        titleText.textContent = 'Memuat Rincian Karyawan...';

        const tahun = document.getElementById('filterTahun').value;
        const regional = document.getElementById('filterRegional').value;
        const unit_kerja = document.getElementById('filterUnitKerja').value;
        const status_pegawai = document.getElementById('filterStatusPegawai').value;

        const params = new URLSearchParams({ type, value, tahun, regional, unit_kerja, status_pegawai });

        fetch("{{ route('api.hr_demographic_detail') }}?" + params.toString())
            .then(res => res.json())
            .then(data => {
                loading.style.display = 'none';
                titleText.textContent = data.title || 'Rincian Karyawan';
                badgeCount.textContent = (data.total || 0).toLocaleString() + ' Karyawan';
                currentEmpDetailList = data.employees || [];
                currentEmpPage = 1;
                renderEmpDetailTable();
            })
            .catch(err => {
                console.error("Error fetching detail:", err);
                loading.style.display = 'none';
                titleText.textContent = 'Gagal Memuat Data';
                tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding:30px; color:#ef4444; font-weight:700;">Gagal memuat rincian data karyawan.</td></tr>';
            });
    }

    function closeEmpDetailModal() {
        document.getElementById('empDetailModal').style.display = 'none';
    }

    function filterEmpDetailTable() {
        currentEmpPage = 1;
        renderEmpDetailTable();
    }

    function renderEmpDetailTable() {
        const tbody = document.getElementById('empTableBody');
        const searchVal = document.getElementById('empSearchInput').value.toLowerCase().trim();
        const infoText = document.getElementById('empPaginationInfo');
        const pageControls = document.getElementById('empPaginationControls');

        let filtered = currentEmpDetailList.filter(emp => {
            if (!searchVal) return true;
            return (
                (emp.nik && emp.nik.toLowerCase().includes(searchVal)) ||
                (emp.nama && emp.nama.toLowerCase().includes(searchVal)) ||
                (emp.jabatan && emp.jabatan.toLowerCase().includes(searchVal)) ||
                (emp.level_jabatan && emp.level_jabatan.toLowerCase().includes(searchVal)) ||
                (emp.personnel_area && emp.personnel_area.toLowerCase().includes(searchVal)) ||
                (emp.personnel_subarea && emp.personnel_subarea.toLowerCase().includes(searchVal))
            );
        });

        const total = filtered.length;
        const totalPages = Math.ceil(total / empPageSize) || 1;
        if (currentEmpPage > totalPages) currentEmpPage = totalPages;
        if (currentEmpPage < 1) currentEmpPage = 1;

        const startIdx = (currentEmpPage - 1) * empPageSize;
        const endIdx = Math.min(startIdx + empPageSize, total);
        const pageRows = filtered.slice(startIdx, endIdx);

        if (total === 0) {
            tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding:30px; color:#64748b; font-weight:600;">Tidak ada data karyawan yang sesuai.</td></tr>';
            infoText.textContent = 'Menampilkan 0 dari 0 data';
            pageControls.innerHTML = '';
            return;
        }

        let html = '';
        pageRows.forEach((row, i) => {
            const rowNo = startIdx + i + 1;
            html += `
                <tr>
                    <td style="text-align: center; font-weight: 600; color: #64748b;">${rowNo}</td>
                    <td style="text-align: center; font-weight: 600; font-family: monospace;">${escapeHtml(row.nik)}</td>
                    <td style="font-weight: 700; color: #0f172a;">${escapeHtml(row.nama)}</td>
                    <td style="color: #334155;">${escapeHtml(row.jabatan)}</td>
                    <td style="color: #475569; font-size: 12px; font-weight: 600;">${escapeHtml(row.level_jabatan)}</td>
                    <td style="color: #166534; font-size: 12px; font-weight: 600;">${escapeHtml(row.personnel_area)}</td>
                    <td style="color: #475569; font-size: 12px;">${escapeHtml(row.personnel_subarea)}</td>
                </tr>
            `;
        });
        tbody.innerHTML = html;

        infoText.textContent = `Menampilkan ${startIdx + 1} s/d ${endIdx} dari ${total.toLocaleString()} data`;

        let btnHtml = '';
        btnHtml += `<button class="emp-page-btn" ${currentEmpPage === 1 ? 'disabled' : ''} onclick="changeEmpPage(${currentEmpPage - 1})"><i class="fa-solid fa-chevron-left"></i> Prev</button>`;
        btnHtml += `<span class="emp-page-num">Halaman ${currentEmpPage} / ${totalPages}</span>`;
        btnHtml += `<button class="emp-page-btn" ${currentEmpPage === totalPages ? 'disabled' : ''} onclick="changeEmpPage(${currentEmpPage + 1})">Next <i class="fa-solid fa-chevron-right"></i></button>`;
        pageControls.innerHTML = btnHtml;
    }

    function changeEmpPage(newPage) {
        currentEmpPage = newPage;
        renderEmpDetailTable();
    }

    function exportEmpDetailTableToCSV() {
        const searchVal = document.getElementById('empSearchInput').value.toLowerCase().trim();
        let filtered = currentEmpDetailList.filter(emp => {
            if (!searchVal) return true;
            return (
                (emp.nik && emp.nik.toLowerCase().includes(searchVal)) ||
                (emp.nama && emp.nama.toLowerCase().includes(searchVal)) ||
                (emp.jabatan && emp.jabatan.toLowerCase().includes(searchVal)) ||
                (emp.level_jabatan && emp.level_jabatan.toLowerCase().includes(searchVal)) ||
                (emp.personnel_area && emp.personnel_area.toLowerCase().includes(searchVal)) ||
                (emp.personnel_subarea && emp.personnel_subarea.toLowerCase().includes(searchVal))
            );
        });

        if (!filtered.length) {
            alert("Tidak ada data untuk diexport!");
            return;
        }

        let csvContent = "\uFEFFNO,NIK,NAMA,JABATAN,LEVEL JABATAN,PERSONNEL AREA,PERSONNEL SUBAREA\n";

        filtered.forEach((r, idx) => {
            const no = idx + 1;
            const nik = `"${(r.nik || '').replace(/"/g, '""')}"`;
            const nama = `"${(r.nama || '').replace(/"/g, '""')}"`;
            const jabatan = `"${(r.jabatan || '').replace(/"/g, '""')}"`;
            const level = `"${(r.level_jabatan || '').replace(/"/g, '""')}"`;
            const area = `"${(r.personnel_area || '').replace(/"/g, '""')}"`;
            const subarea = `"${(r.personnel_subarea || '').replace(/"/g, '""')}"`;
            csvContent += `${no},${nik},${nama},${jabatan},${level},${area},${subarea}\n`;
        });

        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement("a");
        link.setAttribute("href", url);
        const title = (document.getElementById('empModalTitleText').textContent || 'Rincian_Karyawan').replace(/[^a-zA-Z0-9_]/g, '_');
        link.setAttribute("download", `${title}_${new Date().toISOString().slice(0,10)}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }
</script>

<!-- Modal Pop-Up Detail Karyawan -->
<div id="empDetailModal" class="emp-modal-backdrop" style="display: none;" onclick="if(event.target===this) closeEmpDetailModal();">
    <div class="emp-modal-container">
        <div class="emp-modal-header">
            <div class="emp-modal-title">
                <i class="fa-solid fa-users-rectangle" style="color: #166534;"></i>
                <span id="empModalTitleText">Rincian Karyawan</span>
                <span id="empModalBadgeCount" class="emp-count-badge">0 Karyawan</span>
            </div>
            <button class="emp-modal-close" onclick="closeEmpDetailModal()">&times;</button>
        </div>

        <div class="emp-modal-controls">
            <button class="emp-btn-export" onclick="exportEmpDetailTableToCSV()">
                <i class="fa-solid fa-file-excel"></i> Export
            </button>
            <div class="emp-search-group">
                <label for="empSearchInput">Pencarian :</label>
                <input type="text" id="empSearchInput" placeholder="Cari NIK, Nama, Jabatan..." onkeyup="filterEmpDetailTable()">
            </div>
        </div>

        <div class="emp-modal-body">
            <div id="empModalLoading" class="emp-loading-spinner" style="display: none;">
                <i class="fa-solid fa-spinner fa-spin"></i> Memuat data karyawan...
            </div>
            <div class="emp-table-wrapper">
                <table class="emp-detail-table" id="empDetailTable">
                    <thead>
                        <tr>
                            <th style="width: 50px; text-align: center;">NO</th>
                            <th style="width: 110px; text-align: center;">NIK</th>
                            <th>NAMA</th>
                            <th>JABATAN</th>
                            <th style="width: 140px;">LEVEL JABATAN</th>
                            <th style="width: 170px;">PERSONNEL AREA</th>
                            <th style="width: 170px;">PERSONNEL SUBAREA</th>
                        </tr>
                    </thead>
                    <tbody id="empTableBody">
                        <!-- Rows populated by JS -->
                    </tbody>
                </table>
            </div>
        </div>

        <div class="emp-modal-footer">
            <div class="emp-pagination-info" id="empPaginationInfo">
                Menampilkan 0 dari 0 data
            </div>
            <div class="emp-pagination-controls" id="empPaginationControls">
                <!-- Pagination Buttons -->
            </div>
        </div>
    </div>
</div>
@endsection

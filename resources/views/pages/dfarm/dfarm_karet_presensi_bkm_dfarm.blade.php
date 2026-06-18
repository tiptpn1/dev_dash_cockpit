
@extends('layouts.app')

@section('content')
  <link rel="stylesheet" href="{{ asset('css/dfarm.css') }}">

  <style>
    html, body {
    height: auto !important;
    min-height: 100vh;
    overflow-y: auto !important;
    background-color: #f8fafc !important;
    color: #1f2937;
    font-family: 'Google Sans', 'Inter', sans-serif;
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

    .content-section {
    max-width: 100%;
    margin: 0;
    padding: 18px 50px 32px;
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
  </style>

  <div class="gradient-container">
    <!-- Page Header -->
    <header class="lm-page-header">
    <div class="lm-header-logo">
      <img src="{{ asset('danantara.png') }}" alt="Danantara">
    </div>
    <div class="lm-header-center">
      <svg style="width:28px;height:28px;color:#22c55e;flex-shrink:0;" viewBox="0 0 24 24" fill="currentColor">
      <path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.95-2.3A5 5 0 008 22c12 0 15-17 15-17-1 2-8 2-13 3-5 1-6 7-6 7s5.5-2 8.5-2 5 2 5 2-3-5-3-5 3 5 3 5-5 3-5 3 2 3 2 6-2 6-2 6 3-3 3-6-2-6-2-6z" />
      </svg>
      <h1>Evaluasi Kinerja Aplikasi</h1>
    </div>
    <div class="lm-header-right">
      <img src="{{ asset('ptpn1.png') }}" alt="PTPN 1">
    </div>
    </header>

    <!-- Main Content Section -->
    <div class="content-section">
      <div class="flex-1">
        <div class="mx-auto">

          <!-- Error Notification Popup -->
          <div id="errorPopup" class="hidden fixed top-20 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3 z-50 animate-slide-in">
            <div class="flex-1">
              <p id="errorMessage" class="text-sm font-medium"></p>
            </div>
            <button id="closeErrorBtn" class="text-white hover:text-gray-200 transition-colors">
            <i class="fa-solid fa-xmark"></i>
            </button>
          </div>

          <style>
            @keyframes slide-in {
            from {
            transform: translateX(400px);
            opacity: 0;
            }
            to {
            transform: translateX(0);
            opacity: 1;
            }
            }

            @keyframes slide-out {
            from {
            transform: translateX(0);
            opacity: 1;
            }
            to {
            transform: translateX(400px);
            opacity: 0;
            }
            }

            .animate-slide-in {
            animation: slide-in 0.3s ease-out;
            }

            .animate-slide-out {
            animation: slide-out 0.3s ease-out;
            }
          </style>

          <!-- Filters Section -->
          <div class="filter-card">
            <div class="filter-title">
              <i class="fas fa-sliders-h"></i> Filter Parameter
            </div>
            @include('pages.dfarm.components.application-select', ['selected' => 'Digital Farming BKM'])
          </div>

          <!-- Table Card -->
          <div class="table-card" style='overflow: unset;'>
            <div class="table-header">
              <div class="table-title">
                <i class="fas fa-table"></i>
                <span id="table-title">Data Presensi DFARM & BKM SAP</span>
                <span id="regional-badge" class="regional-badge" style="display:none;"></span>
              </div>
              <span id="data-count-badge" class="table-count">Dfarm & BKM SAP PTPN I</span>
            </div>
            <style>
              .iframe-container{
                position: relative;
                width: 100%;
                height: 100%;
              }
              .iframe-container iframe{
                  width: 100%;
                  height: 800px;
                  display: block;
              }
              </style>
            <div class="iframe-container main-content">
                <iframe
                  src="{{ $linkiframe }}"
                  frameborder="0"
                  width="100%"
                  height="800"
                  style="border:0;"
                  allowfullscreen
                  sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox">
              </iframe>
            </div>
            
          </div>
        </div>
      </div>
    </div>

    <!-- Chart.js Library -->
    
    <script src="{{ asset('js/components/application-select-handler.js') }}"></script>

    @include('pages.dfarm.menu.menu-script')

    @endsection

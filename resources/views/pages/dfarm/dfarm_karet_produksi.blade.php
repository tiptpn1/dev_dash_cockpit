
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

    .chart-card {
    background: #fff;
    border: 1px solid #cbd5e1;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    }

    .chart-card h2 {
    color: #166534;
    font-size: 14px;
    font-weight: 700;
    margin: 0 0 16px 0;
    text-align: center;
    }

    .button-group {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    }

    .btn-filter {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 8px 16px;
    background-color: #16a34a;
    color: white;
    border: 1px solid #15803d;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.2s;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .btn-filter:hover {
    background-color: #15803d;
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

    /* Loading Spinner Animation */
    .teh-loading-spinner {
      display: none;
      text-align: center;
      padding: 24px;
      margin: 16px;
    }

    .teh-loading-spinner.active {
      display: block;
    }

    .spinner {
      border: 4px solid #f0f0f0;
      border-top: 4px solid #16a34a;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      animation: spin 1s linear infinite;
      margin: 0 auto;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .spinner-text {
      color: #16a34a;
      font-size: 14px;
      font-weight: 600;
      margin-top: 12px;
    }

    /* Loading Spinner Animation */
    .teh-loading-spinner {
      display: none;
      text-align: center;
      padding: 24px;
      margin: 16px;
    }

    .teh-loading-spinner.active {
      display: block;
    }

    .spinner {
      border: 4px solid #f0f0f0;
      border-top: 4px solid #16a34a;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      animation: spin 1s linear infinite;
      margin: 0 auto;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .spinner-text {
      color: #16a34a;
      font-size: 14px;
      font-weight: 600;
      margin-top: 12px;
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
      <div class="flex-1 overflow-y-auto">
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
            <div class="filter-grid">
              <div class="form-group">
                <label class="form-label">Aplikasi</label>
                <select id="selectJobDesc" class="form-select">
                  <option value="PENYADAP" <?php if ($jobdesc == 'PENYADAP') echo 'selected'; ?>>PENYADAP</option>
                  <option value="PEMETIK" <?php if ($jobdesc == 'PEMETIK') echo 'selected'; ?>>PEMETIK</option>
                  <option value="PANEN KOPI" <?php if ($jobdesc == 'PANEN KOPI') echo 'selected'; ?>>PANEN KOPI</option>
                  <option value="PEMELIHARAAN" <?php if ($jobdesc == 'PEMELIHARAAN') echo 'selected'; ?>>PEMELIHARAAN</option>
                </select>
              </div>
            </div>
          </div>
          
          <div class="table-card">
            <div class="table-header">
              <div class="table-title">
                <i class="fas fa-table"></i>
                <span id="table-title">Data Produksi On Farm DFARM</span>
                <span id="regional-badge" class="regional-badge" style="display:none;"></span>
              </div>
              <span id="data-count-badge" class="table-count">Dfarm PTPN I</span>
            </div>

            <div id="tabs-wrap" style="display: block;">
              <div class="hris-tabs">
                <button type="button" class="hris-tab-btn active" data-tab="rekap">
                  <i class="fas fa-chart-bar"></i>  Produksi Karet
                </button>
                <button type="button" class="hris-tab-btn" data-tab="detail-teh">
                  <i class="fas fa-calendar-day"></i>  Produksi Teh
                </button>
                <button type="button" class="hris-tab-btn" data-tab="detail-kopi">
                  <i class="fas fa-calendar-day"></i>  Produksi Kopi
                </button>
                <button type="button" class="hris-tab-btn" data-tab="detail-pemeliharaan">
                  <i class="fas fa-calendar-day"></i> Prestasi Pemeliharaan
                </button>
              </div>

              <div id="error-banner" class="error-banner" style="display: none;"></div>

              <!-- Tab 1: Rekap -->
              <div id="tab-rekap" class="hris-tab-panel active">
                <!-- Filter Card in Tab -->
                <div class="filter-card" style="margin: 16px;">
                  <div class="filter-title">
                    <i class="fas fa-sliders-h"></i> Filter Parameter
                  </div>
                  <div class="filter-grid">
                    <div class="form-group">
                      <label class="form-label">Periode</label>
                      <div style="position: relative;">
                        <input type="text" id="dateRange" placeholder="Nov 5, 2024 - Nov 6, 2024" readonly class="form-input" style="cursor: pointer; width: 100%;">
                        <div id="datePickerPopup" class="hidden" style="position: absolute; top: 100%; left: 0; margin-top: 8px; background: white; border: 1px solid #d1d5db; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); padding: 16px; z-index: 50; min-width: 320px;">
                          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div>
                              <label class="form-label" style="color: #374151;">Dari Tanggal</label>
                              <input type="date" id="datePickerStart" class="form-input">
                            </div>
                            <div>
                              <label class="form-label" style="color: #374151;">Sampai Tanggal</label>
                              <input type="date" id="datePickerEnd" class="form-input">
                            </div>
                          </div>
                          <div style="display: flex; gap: 8px; margin-top: 12px;">
                            <button id="datePickerApply" class="flex-1 px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs rounded transition-colors font-medium" style="background-color: #166534; border: none; cursor: pointer; flex: 1; padding: 8px 12px;">Terapkan</button>
                            <button id="datePickerCancel" class="flex-1 px-3 py-2 bg-gray-400 hover:bg-gray-500 text-white text-xs rounded transition-colors font-medium" style="background-color: #9ca3af; border: none; cursor: pointer; flex: 1; padding: 8px 12px;">Batal</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="form-label">Regional</label>
                      <select id="selectRegional" class="form-select">
                        <option value="">Pilih</option>
                        <option value="2" <?php if ($selectedRegional == '2') echo 'selected'; ?>>REGIONAL 2</option>
                        <option value="3" <?php if ($selectedRegional == '3') echo 'selected'; ?>>REGIONAL 3</option>
                        <option value="5" <?php if ($selectedRegional == '5') echo 'selected'; ?>>REGIONAL 5</option>
                        <option value="7" <?php if ($selectedRegional == '7') echo 'selected'; ?>>REGIONAL 7</option>
                        <option value="8" <?php if ($selectedRegional == '8') echo 'selected'; ?>>REGIONAL 8</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label class="form-label">Nama Kebun</label>
                      <select id="selectKebun" class="form-select">
                        <option value="">Pilih</option>
                        <?php
                        foreach ($allDatakebun as $key) {
                          echo '<option value="' . $key->kebun_id . '"';
                          if ($selectedKebun == $key->kebun_id) echo ' selected';
                          echo '>' . $key->nama_kebun . '</option>';
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>

                <!-- Action Buttons in Tab -->
                <div style="margin: 0 16px 16px; display: flex; gap: 10px;">
                  <button id="btnFilter" class="inline-flex align-items-center justify-content-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-lg transition-all box-shadow" style="background-color: #16a34a; border: 1px solid #15803d; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); height: 36px;">
                    <i class="fas fa-filter"></i> Filter
                  </button>
                  <button id="btnReset" class="inline-flex align-items-center justify-content-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-lg transition-all box-shadow" style="background-color: #16a34a; border: 1px solid #15803d; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); height: 36px;">
                    <i class="fas fa-rotate-right"></i> Reset
                  </button>
                </div>

                <!-- KPI Cards Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                  <!-- Lateks Basah -->
                  <div style="background: #fff; border: 1px solid #d1fae5; border-top: 4px solid #166534; border-radius: 8px; padding: 18px; box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08); transition: transform 0.2s, box-shadow 0.2s;" class="hover:shadow-lg hover:scale-105">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                      <h3 style="color: #166534; font-size: 12px; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Lateks Basah</h3>
                      <i class="fas fa-tint" style="color: #16a34a; font-size: 18px;"></i>
                    </div>
                    <p style="color: #166534; font-size: 28px; font-weight: 800; margin: 0; line-height: 1;">{{ number_format($totalData['basah_latek'], 0, ',', '.') }}</p>
                    <p style="color: #6b7280; font-size: 11px; margin: 4px 0 0 0;">Kg</p>
                  </div>

                  <!-- Lump Basah -->
                  <div style="background: #fff; border: 1px solid #d1fae5; border-top: 4px solid #166534; border-radius: 8px; padding: 18px; box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08); transition: transform 0.2s, box-shadow 0.2s;" class="hover:shadow-lg hover:scale-105">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                      <h3 style="color: #166534; font-size: 12px; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Lump Basah</h3>
                      <i class="fas fa-cube" style="color: #16a34a; font-size: 18px;"></i>
                    </div>
                    <p style="color: #166534; font-size: 28px; font-weight: 800; margin: 0; line-height: 1;">{{ number_format($totalData['basah_lump'], 0, ',', '.') }}</p>
                    <p style="color: #6b7280; font-size: 11px; margin: 4px 0 0 0;">Kg</p>
                  </div>

                  <!-- Scrap Basah -->
                  <div style="background: #fff; border: 1px solid #d1fae5; border-top: 4px solid #166534; border-radius: 8px; padding: 18px; box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08); transition: transform 0.2s, box-shadow 0.2s;" class="hover:shadow-lg hover:scale-105">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                      <h3 style="color: #166534; font-size: 12px; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Scrap Basah</h3>
                      <i class="fas fa-droplets" style="color: #16a34a; font-size: 18px;"></i>
                    </div>
                    <p style="color: #166534; font-size: 28px; font-weight: 800; margin: 0; line-height: 1;">{{ number_format($totalData['basah_scrab'], 0, ',', '.') }}</p>
                    <p style="color: #6b7280; font-size: 11px; margin: 4px 0 0 0;">Kg</p>
                  </div>

                  <!-- Sheet -->
                  <div style="background: #fff; border: 1px solid #d1fae5; border-top: 4px solid #166534; border-radius: 8px; padding: 18px; box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08); transition: transform 0.2s, box-shadow 0.2s;" class="hover:shadow-lg hover:scale-105">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                      <h3 style="color: #166534; font-size: 12px; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Sheet</h3>
                      <i class="fas fa-layer-group" style="color: #16a34a; font-size: 18px;"></i>
                    </div>
                    <p style="color: #166534; font-size: 28px; font-weight: 800; margin: 0; line-height: 1;">{{ number_format($totalData['sheet'], 0, ',', '.') }}</p>
                    <p style="color: #6b7280; font-size: 11px; margin: 4px 0 0 0;">Kg</p>
                  </div>

                  <!-- Compo + Scrap -->
                  <div style="background: #fff; border: 1px solid #d1fae5; border-top: 4px solid #166534; border-radius: 8px; padding: 18px; box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08); transition: transform 0.2s, box-shadow 0.2s;" class="hover:shadow-lg hover:scale-105">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                      <h3 style="color: #166534; font-size: 12px; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Compo + Scrap</h3>
                      <i class="fas fa-boxes" style="color: #16a34a; font-size: 18px;"></i>
                    </div>
                    <p style="color: #166534; font-size: 28px; font-weight: 800; margin: 0; line-height: 1;">{{ number_format($totalData['compo'] + $totalData['scrap'], 0, ',', '.') }}</p>
                    <p style="color: #6b7280; font-size: 11px; margin: 4px 0 0 0;">Kg</p>
                  </div>

                  <!-- Total Kering -->
                  <div style="background: #fff; border: 1px solid #d1fae5; border-top: 4px solid #166534; border-radius: 8px; padding: 18px; box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08); transition: transform 0.2s, box-shadow 0.2s;" class="hover:shadow-lg hover:scale-105">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                      <h3 style="color: #166534; font-size: 12px; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Total Kering</h3>
                      <i class="fas fa-weight" style="color: #16a34a; font-size: 18px;"></i>
                    </div>
                    <p style="color: #166534; font-size: 28px; font-weight: 800; margin: 0; line-height: 1;">{{ number_format($totalData['total_kering'], 0, ',', '.') }}</p>
                    <p style="color: #6b7280; font-size: 11px; margin: 4px 0 0 0;">Kg</p>
                  </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                  <!-- Produksi Kebun Chart -->
                  <div class="chart-card">
                    <h2>Produksi Kebun</h2>
                    <div class="relative" style="height: 300px; position: relative;">
                      <canvas id="presentaseInputChartBasah"></canvas>
                    </div>
                  </div>
                

                  <!-- Produksi Kering Chart -->
                  <div class="chart-card">
                    <h2>Produksi Kering</h2>
                    <div class="relative" style="height: 300px; position: relative;">
                      <canvas id="presentaseInputChart"></canvas>
                    </div>
                  </div>

                  <!-- Perbandingan High Grade & Low Grade Bahan Baku -->
                  <div class="chart-card">
                    <h2>Perbandingan High Grade & Low Grade Bahan Baku</h2>
                    <div class="relative" style="height: 300px; position: relative;">
                      <canvas id="presensiChart"></canvas>
                    </div>
                  </div>

                  <!-- Perbandingan High Grade & Low Grade Kering -->
                  <div class="chart-card">
                    <h2>Perbandingan High Grade & Low Grade Kering</h2>
                    <div class="relative" style="height: 300px; position: relative;">
                      <canvas id="presentaseHadirChart"></canvas>
                    </div>
                  </div>
                </div>
                <!-- % Input Produksi Chart -->
                <div class="chart-card" style="margin-bottom: 24px;">
                  <h2>% Input Produksi</h2>
                  <div class="relative" style="height: 300px; position: relative;">
                    <canvas id="presentaseInputProduksiChart"></canvas>
                  </div>
                </div>
              </div>

            <!-- Tab 2: Detail Teh -->
            <div id="tab-detail-teh" class="hris-tab-panel">
              <div style="padding: 20px;">
                <!-- Filter Card in Tab -->
                <div class="filter-card" style="margin: 16px;">
                  <div class="filter-title">
                    <i class="fas fa-sliders-h"></i> Filter Parameter
                  </div>
                  <div class="filter-grid">
                    <div class="form-group">
                      <label class="form-label">Periode</label>
                      <div style="position: relative;">
                        <input type="text" id="dateRangeTeh" placeholder="Nov 5, 2024 - Nov 6, 2024" readonly class="form-input" style="cursor: pointer; width: 100%;">
                        <div id="datePickerPopupTeh" class="hidden" style="position: absolute; top: 100%; left: 0; margin-top: 8px; background: white; border: 1px solid #d1d5db; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); padding: 16px; z-index: 50; min-width: 320px;">
                          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div>
                              <label class="form-label" style="color: #374151;">Dari Tanggal</label>
                              <input type="date" id="datePickerStartTeh" class="form-input">
                            </div>
                            <div>
                              <label class="form-label" style="color: #374151;">Sampai Tanggal</label>
                              <input type="date" id="datePickerEndTeh" class="form-input">
                            </div>
                          </div>
                          <div style="display: flex; gap: 8px; margin-top: 12px;">
                            <button id="datePickerApplyTeh" class="flex-1 px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs rounded transition-colors font-medium" style="background-color: #166534; border: none; cursor: pointer; flex: 1; padding: 8px 12px;">Terapkan</button>
                            <button id="datePickerCancelTeh" class="flex-1 px-3 py-2 bg-gray-400 hover:bg-gray-500 text-white text-xs rounded transition-colors font-medium" style="background-color: #9ca3af; border: none; cursor: pointer; flex: 1; padding: 8px 12px;">Batal</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="form-label">Regional</label>
                      <select id="selectTehRegional" class="form-select">
                        <option value="">Pilih</option>
                        <option value="2">REGIONAL 2</option>
                        <option value="3">REGIONAL 3</option>
                        <option value="5">REGIONAL 5</option>
                        <option value="7">REGIONAL 7</option>
                        <option value="8">REGIONAL 8</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label class="form-label">Nama Kebun</label>
                      <select id="selectTehKebun" class="form-select">
                        <option value="">Pilih</option>
                      </select>
                    </div>
                  </div>
                </div>

                <!-- Action Buttons -->
                <div style="margin: 0 16px 16px; display: flex; gap: 10px;">
                  <button id="btnTehFilter" class="inline-flex align-items-center justify-content-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-lg transition-all box-shadow" style="background-color: #16a34a; border: 1px solid #15803d; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); height: 36px;">
                    <i class="fas fa-filter"></i> Filter
                  </button>
                  <button id="btnTehReset" class="inline-flex align-items-center justify-content-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-lg transition-all box-shadow" style="background-color: #16a34a; border: 1px solid #15803d; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); height: 36px;">
                    <i class="fas fa-rotate-right"></i> Reset
                  </button>
                </div>

                <!-- Loading Spinner -->
                <div id="tehLoadingSpinner" class="teh-loading-spinner">
                  <div class="spinner"></div>
                  <div class="spinner-text">Memuat data...</div>
                </div>

                <!-- KPI Cards Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                  <!-- Panen Manual -->
                  <div style="background: #fff; border: 1px solid #d1fae5; border-top: 4px solid #166534; border-radius: 8px; padding: 18px; box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08); transition: transform 0.2s, box-shadow 0.2s;" class="hover:shadow-lg hover:scale-105">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                      <h3 style="color: #166534; font-size: 12px; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Panen Manual</h3>
                      <i class="fas fa-hand-holding-leaves" style="color: #16a34a; font-size: 18px;"></i>
                    </div>
                    <p id="kpiTehPanenManual" style="color: #166534; font-size: 28px; font-weight: 800; margin: 0; line-height: 1;">0</p>
                    <p style="color: #6b7280; font-size: 11px; margin: 4px 0 0 0;">Kg</p>
                  </div>

                  <!-- Panen Gunting -->
                  <div style="background: #fff; border: 1px solid #d1fae5; border-top: 4px solid #166534; border-radius: 8px; padding: 18px; box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08); transition: transform 0.2s, box-shadow 0.2s;" class="hover:shadow-lg hover:scale-105">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                      <h3 style="color: #166534; font-size: 12px; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Panen Gunting</h3>
                      <i class="fas fa-scissors" style="color: #16a34a; font-size: 18px;"></i>
                    </div>
                    <p id="kpiTehPanenGunting" style="color: #166534; font-size: 28px; font-weight: 800; margin: 0; line-height: 1;">0</p>
                    <p style="color: #6b7280; font-size: 11px; margin: 4px 0 0 0;">Kg</p>
                  </div>

                  <!-- Panen Mesin -->
                  <div style="background: #fff; border: 1px solid #d1fae5; border-top: 4px solid #166534; border-radius: 8px; padding: 18px; box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08); transition: transform 0.2s, box-shadow 0.2s;" class="hover:shadow-lg hover:scale-105">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                      <h3 style="color: #166534; font-size: 12px; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Panen Mesin</h3>
                      <i class="fas fa-cogs" style="color: #16a34a; font-size: 18px;"></i>
                    </div>
                    <p id="kpiTehPanenMesin" style="color: #166534; font-size: 28px; font-weight: 800; margin: 0; line-height: 1;">0</p>
                    <p style="color: #6b7280; font-size: 11px; margin: 4px 0 0 0;">Kg</p>
                  </div>

                  <!-- Total -->
                  <div style="background: #fff; border: 1px solid #d1fae5; border-top: 4px solid #166534; border-radius: 8px; padding: 18px; box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08); transition: transform 0.2s, box-shadow 0.2s;" class="hover:shadow-lg hover:scale-105">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                      <h3 style="color: #166534; font-size: 12px; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Total Panen</h3>
                      <i class="fas fa-chart-line" style="color: #16a34a; font-size: 18px;"></i>
                    </div>
                    <p id="kpiTehTotal" style="color: #166534; font-size: 28px; font-weight: 800; margin: 0; line-height: 1;">0</p>
                    <p style="color: #6b7280; font-size: 11px; margin: 4px 0 0 0;">Kg</p>
                  </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                  <!-- Produksi Kebun Chart -->
                  <div class="chart-card">
                    <h2>Produksi Kebun (Panen Manual/Gunting/Mesin)</h2>
                    <div class="relative" style="height: 300px; position: relative;">
                      <canvas id="presentaseInputChartTehBasah"></canvas>
                    </div>
                  </div>

                  <!-- Produksi Kering Chart -->
                  <div class="chart-card">
                    <h2>Total Produksi</h2>
                    <div class="relative" style="height: 300px; position: relative;">
                      <canvas id="presentaseInputChartTeh"></canvas>
                    </div>
                  </div>
                </div>

                <!-- % Input Produksi Chart -->
                <div class="chart-card" style="margin-bottom: 24px;">
                  <h2>% Input Produksi</h2>
                  <div class="relative" style="height: 300px; position: relative;">
                    <canvas id="presentaseInputProduksiTehChart"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <!-- Tab 3: Detail Kopi -->
            <div id="tab-detail-kopi" class="hris-tab-panel">
              <div style="padding: 20px;">
                <!-- Filter Card in Tab -->
                <div class="filter-card" style="margin: 16px;">
                  <div class="filter-title">
                    <i class="fas fa-sliders-h"></i> Filter Parameter
                  </div>
                  <div class="filter-grid">
                    <div class="form-group">
                      <label class="form-label">Periode</label>
                      <div style="position: relative;">
                        <input type="text" id="dateRangeKopi" placeholder="Nov 5, 2024 - Nov 6, 2024" readonly class="form-input" style="cursor: pointer; width: 100%;">
                        <div id="datePickerPopupKopi" class="hidden" style="position: absolute; top: 100%; left: 0; margin-top: 8px; background: white; border: 1px solid #d1d5db; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); padding: 16px; z-index: 50; min-width: 320px;">
                          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div>
                              <label class="form-label" style="color: #374151;">Dari Tanggal</label>
                              <input type="date" id="datePickerStartKopi" class="form-input">
                            </div>
                            <div>
                              <label class="form-label" style="color: #374151;">Sampai Tanggal</label>
                              <input type="date" id="datePickerEndKopi" class="form-input">
                            </div>
                          </div>
                          <div style="display: flex; gap: 8px; margin-top: 12px;">
                            <button id="datePickerApplyKopi" class="flex-1 px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs rounded transition-colors font-medium" style="background-color: #166534; border: none; cursor: pointer; flex: 1; padding: 8px 12px;">Terapkan</button>
                            <button id="datePickerCancelKopi" class="flex-1 px-3 py-2 bg-gray-400 hover:bg-gray-500 text-white text-xs rounded transition-colors font-medium" style="background-color: #9ca3af; border: none; cursor: pointer; flex: 1; padding: 8px 12px;">Batal</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="form-label">Regional</label>
                      <select id="selectKopiRegional" class="form-select">
                        <option value="">Pilih</option>
                        <option value="2">REGIONAL 2</option>
                        <option value="3">REGIONAL 3</option>
                        <option value="5">REGIONAL 5</option>
                        <option value="7">REGIONAL 7</option>
                        <option value="8">REGIONAL 8</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label class="form-label">Nama Kebun</label>
                      <select id="selectKopiKebun" class="form-select">
                        <option value="">Pilih</option>
                      </select>
                    </div>
                  </div>
                </div>

                <!-- Action Buttons -->
                <div style="margin: 0 16px 16px; display: flex; gap: 10px;">
                  <button id="btnKopiFilter" class="inline-flex align-items-center justify-content-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-lg transition-all box-shadow" style="background-color: #16a34a; border: 1px solid #15803d; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); height: 36px;">
                    <i class="fas fa-filter"></i> Filter
                  </button>
                  <button id="btnKopiReset" class="inline-flex align-items-center justify-content-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-lg transition-all box-shadow" style="background-color: #16a34a; border: 1px solid #15803d; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); height: 36px;">
                    <i class="fas fa-rotate-right"></i> Reset
                  </button>
                </div>

                <!-- Loading Spinner -->
                <div id="kopiLoadingSpinner" class="teh-loading-spinner">
                  <div class="spinner"></div>
                  <div class="spinner-text">Memuat data...</div>
                </div>

                <!-- KPI Cards Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                  <!-- Total Basah -->
                  <div style="background: #fff; border: 1px solid #d1fae5; border-top: 4px solid #166534; border-radius: 8px; padding: 18px; box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08); transition: transform 0.2s, box-shadow 0.2s;" class="hover:shadow-lg hover:scale-105">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                      <h3 style="color: #166534; font-size: 12px; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Total Basah</h3>
                      <i class="fas fa-droplet" style="color: #16a34a; font-size: 18px;"></i>
                    </div>
                    <p id="kpiKopiTotalBasah" style="color: #166534; font-size: 28px; font-weight: 800; margin: 0; line-height: 1;">0</p>
                    <p style="color: #6b7280; font-size: 11px; margin: 4px 0 0 0;">Kg</p>
                  </div>

                  <!-- Total Kering -->
                  <div style="background: #fff; border: 1px solid #d1fae5; border-top: 4px solid #166534; border-radius: 8px; padding: 18px; box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08); transition: transform 0.2s, box-shadow 0.2s;" class="hover:shadow-lg hover:scale-105">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                      <h3 style="color: #166534; font-size: 12px; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Total Kering</h3>
                      <i class="fas fa-leaf" style="color: #16a34a; font-size: 18px;"></i>
                    </div>
                    <p id="kpiKopiTotalKering" style="color: #166534; font-size: 28px; font-weight: 800; margin: 0; line-height: 1;">0</p>
                    <p style="color: #6b7280; font-size: 11px; margin: 4px 0 0 0;">Kg</p>
                  </div>

                  <!-- % Input Produksi -->
                  <div style="background: #fff; border: 1px solid #d1fae5; border-top: 4px solid #166534; border-radius: 8px; padding: 18px; box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08); transition: transform 0.2s, box-shadow 0.2s;" class="hover:shadow-lg hover:scale-105">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                      <h3 style="color: #166534; font-size: 12px; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">% Input</h3>
                      <i class="fas fa-chart-pie" style="color: #16a34a; font-size: 18px;"></i>
                    </div>
                    <p id="kpiKopiInputPercent" style="color: #166534; font-size: 28px; font-weight: 800; margin: 0; line-height: 1;">0%</p>
                    <p style="color: #6b7280; font-size: 11px; margin: 4px 0 0 0;">Rata-rata</p>
                  </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                  <!-- Warna Basah Chart -->
                  <div class="chart-card">
                    <h2>Warna Basah (Merah/Kuning/Hijau/Hitam)</h2>
                    <div class="relative" style="height: 300px; position: relative;">
                      <canvas id="kopiWarnaBasahChart"></canvas>
                    </div>
                  </div>

                  <!-- Warna Kering Chart -->
                  <div class="chart-card">
                    <h2>Warna Kering (Merah/Kuning/Hijau/Hitam)</h2>
                    <div class="relative" style="height: 300px; position: relative;">
                      <canvas id="kopiWarnaKeringChart"></canvas>
                    </div>
                  </div>
                </div>

                <!-- % Input Produksi Chart -->
                <div class="chart-card" style="margin-bottom: 24px;">
                  <h2>% Input Produksi</h2>
                  <div class="relative" style="height: 300px; position: relative;">
                    <canvas id="kopiInputProduksiChart"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <!-- Tab 4: Detail Pemeliharaan -->
            <div id="tab-detail-pemeliharaan" class="hris-tab-panel">
              <div style="padding: 20px;">
                <!-- Filter Card with Date Picker -->
                <div class="filter-card" style="margin: 16px;">
                  <div class="filter-title">
                    <i class="fas fa-sliders-h"></i> Filter Parameter
                  </div>
                  <div class="filter-grid">
                    <!-- Komoditas Filter -->
                    <div class="form-group">
                      <label class="form-label">Komoditas</label>
                      <select id="selectPemeliharaanKomoditas" class="form-select">
                        <option value="">Pilih</option>
                        <option value="1">Teh</option>
                        <option value="2">Karet</option>
                        <option value="3">Kopi</option>
                      </select>
                    </div>

                    <!-- Aktivitas Filter -->
                    <div class="form-group">
                      <label class="form-label">Aktivitas</label>
                      <select id="selectPemeliharaanAktivitas" class="form-select">
                        <option value="">Pilih</option>
                      </select>
                    </div>

                    <!-- Date Range with Popup -->
                    <div class="form-group">
                      <label class="form-label">Periode</label>
                      <div style="position: relative;">
                        <input type="text" id="dateRangePemeliharaan" placeholder="Nov 5, 2024 - Nov 6, 2024" readonly class="form-input" style="cursor: pointer; width: 100%;">
                        <div id="datePickerPopupPemeliharaan" class="hidden" style="position: absolute; top: 100%; left: 0; background-color: white; border: 1px solid #ccc; border-radius: 8px; padding: 15px; width: 300px; z-index: 1000; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                          <div style="margin-bottom: 10px;">
                            <label style="display: block; font-size: 12px; color: #333; margin-bottom: 5px;">Tanggal Awal</label>
                            <input type="date" id="datePickerStartPemeliharaan" class="form-input" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                          </div>
                          <div style="margin-bottom: 10px;">
                            <label style="display: block; font-size: 12px; color: #333; margin-bottom: 5px;">Tanggal Akhir</label>
                            <input type="date" id="datePickerEndPemeliharaan" class="form-input" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                          </div>
                          <div style="display: flex; gap: 10px;">
                            <button id="datePickerApplyPemeliharaan" style="flex: 1; padding: 8px; background-color: #16a34a; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Terapkan</button>
                            <button id="datePickerCancelPemeliharaan" style="flex: 1; padding: 8px; background-color: #666; color: white; border: none; border-radius: 4px; cursor: pointer;">Batal</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Regional Select -->
                    <div class="form-group">
                      <label class="form-label">Regional</label>
                      <select id="selectPemeliharaanRegional" class="form-select">
                        <option value="">Pilih</option>
                      </select>
                    </div>

                    <!-- Kebun Select -->
                    <div class="form-group">
                      <label class="form-label">Nama Kebun</label>
                      <select id="selectPemeliharaanKebun" class="form-select">
                        <option value="">Pilih</option>
                      </select>
                    </div>
                  </div>
                </div>

                <!-- Action Buttons -->
                <div style="margin: 0 16px 16px; display: flex; gap: 10px;">
                  <button id="btnPemeliharaanFilter" class="inline-flex align-items-center justify-content-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-lg transition-all box-shadow" style="background-color: #16a34a; border: 1px solid #15803d; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); height: 36px;">
                    <i class="fas fa-filter"></i> Filter
                  </button>
                  <button id="btnPemeliharaanReset" class="inline-flex align-items-center justify-content-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-lg transition-all box-shadow" style="background-color: #16a34a; border: 1px solid #15803d; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); height: 36px;">
                    <i class="fas fa-rotate-right"></i> Reset
                  </button>
                </div>

                <!-- Loading Spinner -->
                <div id="pemeliharaanLoadingSpinner" class="teh-loading-spinner">
                  <div class="spinner"></div>
                  <div class="spinner-text">Memuat data...</div>
                </div>

                <!-- KPI Cards Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 mb-8">
                  <!-- Hasil Pemeliharaan -->
                  <div style="background: #fff; border: 1px solid #d1fae5; border-top: 4px solid #166534; border-radius: 8px; padding: 18px; box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08); transition: transform 0.2s, box-shadow 0.2s;" class="hover:shadow-lg hover:scale-105">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                      <h3 style="color: #166534; font-size: 12px; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Hasil Pemeliharaan</h3>
                      <i class="fas fa-hammer" style="color: #16a34a; font-size: 18px;"></i>
                    </div>
                    <p id="kpiPemeliharaanHasil" style="color: #166534; font-size: 28px; font-weight: 800; margin: 0; line-height: 1;">0</p>
                    <p style="color: #6b7280; font-size: 11px; margin: 4px 0 0 0;">Unit</p>
                  </div>

                  <!-- % Input Produksi -->
                  <div style="background: #fff; border: 1px solid #d1fae5; border-top: 4px solid #166534; border-radius: 8px; padding: 18px; box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08); transition: transform 0.2s, box-shadow 0.2s;" class="hover:shadow-lg hover:scale-105">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                      <h3 style="color: #166534; font-size: 12px; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">% Input</h3>
                      <i class="fas fa-chart-pie" style="color: #16a34a; font-size: 18px;"></i>
                    </div>
                    <p id="kpiPemeliharaanInputPercent" style="color: #166534; font-size: 28px; font-weight: 800; margin: 0; line-height: 1;">0%</p>
                    <p style="color: #6b7280; font-size: 11px; margin: 4px 0 0 0;">Rata-rata</p>
                  </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-1 gap-6 mb-6">
                  <!-- Hasil Aktivitas Chart -->
                  <div class="chart-card">
                    <h2>Hasil Aktivitas Pemeliharaan</h2>
                    <div class="relative" style="height: 300px; position: relative;">
                      <canvas id="pemeliharaanHasilChart"></canvas>
                    </div>
                  </div>
                </div>

                <!-- Input Produksi Chart -->
                <div class="chart-card" style="margin-bottom: 24px;">
                  <h2>% Input vs % Tidak Input Produksi</h2>
                  <div class="relative" style="height: 300px; position: relative;">
                    <canvas id="pemeliharaanInputProduksiChart"></canvas>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // ============================================
  // ERROR NOTIFICATION HANDLER
  // ============================================
  function showErrorPopup(message) {
    const errorPopup = document.getElementById('errorPopup');
    const errorMessage = document.getElementById('errorMessage');
    
    errorMessage.textContent = message;
    errorPopup.classList.remove('hidden', 'animate-slide-out');
    errorPopup.classList.add('animate-slide-in');
    
    // Auto-hide setelah 3 detik
    setTimeout(() => {
      errorPopup.classList.remove('animate-slide-in');
      errorPopup.classList.add('animate-slide-out');
      setTimeout(() => {
        errorPopup.classList.add('hidden');
      }, 300);
    }, 3000);
  }

  // Close button handler
  document.getElementById('closeErrorBtn').addEventListener('click', () => {
    const errorPopup = document.getElementById('errorPopup');
    errorPopup.classList.remove('animate-slide-in');
    errorPopup.classList.add('animate-slide-out');
    setTimeout(() => {
      errorPopup.classList.add('hidden');
    }, 300);
  });

  // Check untuk error dari session
  @if($errors->has('msg'))
    showErrorPopup('{{ $errors->first('msg') }}');
  @endif

  // ============================================
  // TAB SWITCHING FUNCTIONALITY
  // ============================================
  document.querySelectorAll('.hris-tab-btn').forEach(button => {
    button.addEventListener('click', async () => {
      const tabName = button.getAttribute('data-tab');
      
      // Remove active class from all buttons and panels
      document.querySelectorAll('.hris-tab-btn').forEach(btn => btn.classList.remove('active'));
      document.querySelectorAll('.hris-tab-panel').forEach(panel => panel.classList.remove('active'));
      
      // Add active class to clicked button and corresponding panel
      button.classList.add('active');
      const tabPanel = document.getElementById('tab-' + tabName);
      if (tabPanel) {
        tabPanel.classList.add('active');
        
        // Trigger chart resize for rekap tab
        if (tabName === 'rekap' && window.charts && window.charts.length > 0) {
          setTimeout(() => {
            window.charts.forEach(chart => chart.resize());
          }, 100);
        }

        // Auto-load data for detail-teh tab
        if (tabName === 'detail-teh') {
          // Load with default dates and no filter
          const today = new Date();
          const startDate = new Date(today);
          startDate.setDate(startDate.getDate() - 1);
          
          const formatDate = (date) => date.toISOString().split('T')[0];
          
          const tglAwal = formatDate(startDate);
          const tglAkhir = formatDate(today);

          // Update date inputs
          document.getElementById('datePickerStartTeh').value = tglAwal;
          document.getElementById('datePickerEndTeh').value = tglAkhir;
          
          function updateDateDisplayTeh() {
            if (document.getElementById('datePickerStartTeh').value && document.getElementById('datePickerEndTeh').value) {
              const start = new Date(document.getElementById('datePickerStartTeh').value);
              const end = new Date(document.getElementById('datePickerEndTeh').value);
              document.getElementById('dateRangeTeh').value = `${start.toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' })} - ${end.toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' })}`;
            }
          }
          updateDateDisplayTeh();

          // Show loading spinner
          const loadingSpinner = document.getElementById('tehLoadingSpinner');
          loadingSpinner.classList.add('active');

          // Auto-load AJAX data
          try {
            const response = await fetch('{{ route('ajax_dfarmtehproduksi') }}', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'X-Requested-With': 'XMLHttpRequest'
              },
              body: JSON.stringify({
                id_reg: '',
                tgl_awal: tglAwal,
                tgl_akhir: tglAkhir,
                kode_kebun: '',
                jobdesc: 'PEMETIK'
              })
            });

            const data = await response.json();
            loadingSpinner.classList.remove('active');

            if (!data.success) {
              showErrorPopup(data.error || 'Gagal load data');
              return;
            }

            // Update KPI Cards
            const panen_manual_total = data.prestasiData.reduce((sum, item) => sum + (parseFloat(item.panen_manual) || 0), 0);
            const panen_gunting_total = data.prestasiData.reduce((sum, item) => sum + (parseFloat(item.panen_gunting) || 0), 0);
            const panen_mesin_total = data.prestasiData.reduce((sum, item) => sum + (parseFloat(item.panen_mesin_individu) || 0), 0);
            const total = data.prestasiData.reduce((sum, item) => sum + (parseFloat(item.total) || 0), 0);

            document.getElementById('kpiTehPanenManual').textContent = new Intl.NumberFormat('id-ID').format(Math.round(panen_manual_total));
            document.getElementById('kpiTehPanenGunting').textContent = new Intl.NumberFormat('id-ID').format(Math.round(panen_gunting_total));
            document.getElementById('kpiTehPanenMesin').textContent = new Intl.NumberFormat('id-ID').format(Math.round(panen_mesin_total));
            document.getElementById('kpiTehTotal').textContent = new Intl.NumberFormat('id-ID').format(Math.round(total));

            // Destroy existing charts
            window.tehCharts.forEach(chart => chart.destroy());
            window.tehCharts = [];

            // Initialize Charts with AJAX data
            initTehCharts(data.prestasiData, data.prestasiDataLite);

          } catch (error) {
            console.error('Error loading teh data:', error);
            loadingSpinner.classList.remove('active');
            showErrorPopup('Terjadi error saat load data');
          }
        }

        // Auto-load data for detail-kopi tab
        if (tabName === 'detail-kopi') {
          // Load with default dates and no filter
          const today = new Date();
          const startDate = new Date(today);
          startDate.setDate(startDate.getDate() - 1);
          
          const formatDate = (date) => date.toISOString().split('T')[0];
          
          const tglAwal = formatDate(startDate);
          const tglAkhir = formatDate(today);

          // Update date inputs
          document.getElementById('datePickerStartKopi').value = tglAwal;
          document.getElementById('datePickerEndKopi').value = tglAkhir;
          
          function updateDateDisplayKopi() {
            if (document.getElementById('datePickerStartKopi').value && document.getElementById('datePickerEndKopi').value) {
              const start = new Date(document.getElementById('datePickerStartKopi').value);
              const end = new Date(document.getElementById('datePickerEndKopi').value);
              document.getElementById('dateRangeKopi').value = `${start.toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' })} - ${end.toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' })}`;
            }
          }
          updateDateDisplayKopi();

          // Show loading spinner
          const loadingSpinner = document.getElementById('kopiLoadingSpinner');
          loadingSpinner.classList.add('active');

          // Auto-load AJAX data
          try {
            const response = await fetch('{{ route('ajax_dfarmkopiproduksi') }}', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'X-Requested-With': 'XMLHttpRequest'
              },
              body: JSON.stringify({
                id_reg: '',
                tgl_awal: tglAwal,
                tgl_akhir: tglAkhir,
                kode_kebun: '',
                jobdesc: 'PANEN KOPI'
              })
            });

            const data = await response.json();
            loadingSpinner.classList.remove('active');

            if (!data.success) {
              showErrorPopup(data.error || 'Gagal load data');
              return;
            }

            // Update KPI Cards
            const totalBasah = data.prestasiData.reduce((sum, item) => sum + (parseFloat(item.total_basah) || 0), 0);
            const totalKering = data.prestasiData.reduce((sum, item) => sum + (parseFloat(item.total_kering) || 0), 0);
            const avgInputPercent = data.prestasiDataLite.length > 0 
              ? data.prestasiDataLite.reduce((sum, item) => sum + (parseFloat(item.persen_input_produksi) || 0), 0) / data.prestasiDataLite.length 
              : 0;

            document.getElementById('kpiKopiTotalBasah').textContent = new Intl.NumberFormat('id-ID').format(Math.round(totalBasah));
            document.getElementById('kpiKopiTotalKering').textContent = new Intl.NumberFormat('id-ID').format(Math.round(totalKering));
            document.getElementById('kpiKopiInputPercent').textContent = Math.round(avgInputPercent) + '%';

            // Destroy existing charts
            window.kopiCharts.forEach(chart => chart.destroy());
            window.kopiCharts = [];

            // Initialize Charts with AJAX data
            initKopiCharts(data.prestasiData, data.prestasiDataLite);

          } catch (error) {
            console.error('Error loading kopi data:', error);
            loadingSpinner.classList.remove('active');
            showErrorPopup('Terjadi error saat load data');
          }
        }

        // Auto-load data for detail-pemeliharaan tab
        if (tabName === 'detail-pemeliharaan') {
          // Load with default dates and no filter
          const today = new Date();
          const startDate = new Date(today);
          startDate.setDate(startDate.getDate() - 1);
          
          const formatDate = (date) => date.toISOString().split('T')[0];
          
          const tglAwal = formatDate(startDate);
          const tglAkhir = formatDate(today);

          // Update date inputs
          document.getElementById('datePickerStartPemeliharaan').value = tglAwal;
          document.getElementById('datePickerEndPemeliharaan').value = tglAkhir;
          
          function updateDateDisplayPemeliharaan() {
            if (document.getElementById('datePickerStartPemeliharaan').value && document.getElementById('datePickerEndPemeliharaan').value) {
              const start = new Date(document.getElementById('datePickerStartPemeliharaan').value);
              const end = new Date(document.getElementById('datePickerEndPemeliharaan').value);
              document.getElementById('dateRangePemeliharaan').value = `${start.toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' })} - ${end.toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' })}`;
            }
          }
          updateDateDisplayPemeliharaan();

          // Show loading spinner
          const loadingSpinner = document.getElementById('pemeliharaanLoadingSpinner');
          loadingSpinner.classList.add('active');

          // Auto-load AJAX data with default komoditas (Teh = 1)
          try {
            const response = await fetch('{{ route('ajax_dfarmpemeliharaan') }}', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'X-Requested-With': 'XMLHttpRequest'
              },
              body: JSON.stringify({
                id_reg: '',
                tgl_awal: tglAwal,
                tgl_akhir: tglAkhir,
                kode_kebun: '',
                komoditas: '1',
                jenis_aktivitas: '',
                jobdesc: 'PEMELIHARAAN'
              })
            });

            const data = await response.json();
            loadingSpinner.classList.remove('active');

            if (!data.success) {
              showErrorPopup(data.error || 'Gagal load data');
              return;
            }

            // Update KPI Cards
            const totalHasil = data.prestasiData.reduce((sum, item) => sum + (parseFloat(item.hasil_pemeliharaan) || 0), 0);
            const avgInputPercent = data.prestasiDataLite.length > 0 
              ? data.prestasiDataLite.reduce((sum, item) => sum + (parseFloat(item.persen_input_produksi) || 0), 0) / data.prestasiDataLite.length 
              : 0;

            document.getElementById('kpiPemeliharaanHasil').textContent = new Intl.NumberFormat('id-ID').format(Math.round(totalHasil));
            document.getElementById('kpiPemeliharaanInputPercent').textContent = Math.round(avgInputPercent) + '%';

            // Destroy existing charts
            window.pemeliharaanCharts.forEach(chart => chart.destroy());
            window.pemeliharaanCharts = [];

            // Initialize Charts with AJAX data
            initPemeliharaanCharts(data.prestasiData, data.prestasiDataLite);

          } catch (error) {
            console.error('Error loading pemeliharaan data:', error);
            loadingSpinner.classList.remove('active');
            showErrorPopup('Terjadi error saat load data');
          }
        }
      }
    });
  });

  // Chart Colors
  const chartColors = {
    blue: '#0ea5e9',
    cyan: '#06B6D4',
    red: '#dc2626',
    purple: '#8B5CF6',
    gridColor: 'rgba(0, 0, 0, 0.1)',
    textColor: '#1f2937',
  };

  // Chart Options Template
  const commonOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: true,
        labels: {
          color: chartColors.textColor,
          font: { size: 12, family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif" },
          padding: 15,
          usePointStyle: true,
        },
      },
    },
    scales: {
      x: {
        grid: { color: chartColors.gridColor, drawBorder: false },
        ticks: { color: chartColors.textColor, font: { size: 11 } },
      },
      y: {
        grid: { color: chartColors.gridColor, drawBorder: false },
        ticks: { color: chartColors.textColor, font: { size: 11 } },
      },
    },
  };

  // Initialize Teh Charts Function
  function initTehCharts(prestasiData, prestasiDataLite) {
    // Chart 1: Produksi Kebun (Panen Manual/Gunting/Mesin)
    const contextBasah = document.getElementById('presentaseInputChartTehBasah').getContext('2d');
    if (contextBasah) {
      const chartBasah = new Chart(contextBasah, {
        type: 'bar',
        data: {
          labels: prestasiData.map(item => item.nama),
          datasets: [
            {
              label: 'Panen Manual (Kg)',
              data: prestasiData.map(item => item.panen_manual || 0),
              backgroundColor: chartColors.blue,
              borderRadius: 6,
              borderSkipped: false,
            },
            {
              label: 'Panen Gunting (Kg)',
              data: prestasiData.map(item => item.panen_gunting || 0),
              backgroundColor: chartColors.cyan,
              borderRadius: 6,
              borderSkipped: false,
            },
            {
              label: 'Panen Mesin (Kg)',
              data: prestasiData.map(item => item.panen_mesin_individu || 0),
              backgroundColor: chartColors.purple,
              borderRadius: 6,
              borderSkipped: false,
            },
          ],
        },
        options: {
          ...commonOptions,
          scales: {
            ...commonOptions.scales,
            x: {
              ...commonOptions.scales.x,
              stacked: false,
            },
            y: {
              ...commonOptions.scales.y,
              stacked: false,
            },
          },
        },
      });
      window.tehCharts.push(chartBasah);
    }

    // Chart 2: Total Produksi
    const contextTotal = document.getElementById('presentaseInputChartTeh').getContext('2d');
    if (contextTotal) {
      const chartTotal = new Chart(contextTotal, {
        type: 'bar',
        data: {
          labels: prestasiData.map(item => item.nama),
          datasets: [
            {
              label: 'Total (Kg)',
              data: prestasiData.map(item => (item.panen_manual || 0) + (item.panen_gunting || 0) + (item.panen_mesin_individu || 0)),
              backgroundColor: chartColors.blue,
              borderRadius: 6,
              borderSkipped: false,
            },
          ],
        },
        options: {
          ...commonOptions,
          scales: {
            ...commonOptions.scales,
            x: {
              ...commonOptions.scales.x,
              stacked: false,
            },
            y: {
              ...commonOptions.scales.y,
              stacked: false,
            },
          },
        },
      });
      window.tehCharts.push(chartTotal);
    }

    // Chart 3: % Input Produksi
    const contextInputPercent = document.getElementById('presentaseInputProduksiTehChart').getContext('2d');
    if (contextInputPercent) {
      const chartInputPercent = new Chart(contextInputPercent, {
        type: 'bar',
        data: {
          labels: prestasiDataLite.map(item => item.nama),
          datasets: [
            {
              label: '% Input',
              data: prestasiDataLite.map(item => Math.min(100, item.persen_input_produksi || 0)),
              backgroundColor: chartColors.blue,
              borderRadius: 6,
              borderSkipped: false,
            },
            {
              label: '% Tidak Input',
              data: prestasiDataLite.map(item => Math.max(0, 100 - Math.min(100, item.persen_input_produksi || 0))),
              backgroundColor: chartColors.red,
              borderRadius: 6,
              borderSkipped: false,
            },
          ],
        },
        options: {
          ...commonOptions,
          scales: {
            ...commonOptions.scales,
            x: {
              ...commonOptions.scales.x,
              stacked: true,
            },
            y: {
              ...commonOptions.scales.y,
              stacked: true,
              max: 100,
            },
          },
        },
      });
      window.tehCharts.push(chartInputPercent);
    }
  }

    // 1. Presensi Chart (Grouped Bar)
    const presensiCtx = document.getElementById('presensiChart').getContext('2d');
    new Chart(presensiCtx, {
      type: 'bar',
      data: {
        labels: [
          @for ($i = 0; $i < count($prestasiData); $i++) 
            '{{ $prestasiData[$i]->nama }}',
          @endfor
        ],
        datasets: [
          {
            label: '% High Grade',
            data: [
              @for ($i = 0; $i < count($prestasiData); $i++)
                {{ ($prestasiData[$i]->basah_latek + $prestasiData[$i]->basah_lump + $prestasiData[$i]->basah_scrab) != 0 ? min(100, ($prestasiData[$i]->basah_latek)/($prestasiData[$i]->basah_latek + $prestasiData[$i]->basah_lump + $prestasiData[$i]->basah_scrab) * 100) : 0 }},
              @endfor
            ],
            backgroundColor: chartColors.blue,
            borderRadius: 6,
            borderSkipped: false,
          },
          {
            label: '% Low Grade',
            data: [
              @for ($i = 0; $i < count($prestasiData); $i++)
                {{ ($prestasiData[$i]->basah_latek + $prestasiData[$i]->basah_lump + $prestasiData[$i]->basah_scrab) != 0 ? max(0, 100 - min(100, ($prestasiData[$i]->basah_latek)/($prestasiData[$i]->basah_latek + $prestasiData[$i]->basah_lump + $prestasiData[$i]->basah_scrab) * 100)) : 0 }},
              @endfor
            ],
            backgroundColor: chartColors.red,
            borderRadius: 6,
            borderSkipped: false,
          },
        ],
      },
      options: {
        ...commonOptions,
        scales: {
          ...commonOptions.scales,
          x: {
            ...commonOptions.scales.x,
            stacked: true,
          },
          y: {
            ...commonOptions.scales.y,
            stacked: true,
          },
        },
      },
    });

    // 2. Presentase Hadir Chart (Stacked Bar)
    const presentaseHadirCtx = document.getElementById('presentaseHadirChart').getContext('2d');
    new Chart(presentaseHadirCtx, {
      type: 'bar',
      data: {
        labels: [
          @for ($i = 0; $i < count($prestasiData); $i++) 
            '{{ $prestasiData[$i]->nama }}',
          @endfor
        ],
        datasets: [
          {
            label: '% High Grade',
            data: [
              @for ($i = 0; $i < count($prestasiData); $i++)
                {{ $prestasiData[$i]->total_kering != 0 ? min(100, $prestasiData[$i]->sheet/($prestasiData[$i]->total_kering) * 100) : 0 }},
              @endfor
            ],
            backgroundColor: chartColors.blue,
            borderRadius: 6,
            borderSkipped: false,
          },
          {
            label: '% Low Grade',
            data: [
              @for ($i = 0; $i < count($prestasiData); $i++)
                {{ $prestasiData[$i]->total_kering != 0 ? max(0, 100 - min(100, $prestasiData[$i]->sheet/($prestasiData[$i]->total_kering) * 100)) : 0 }},
              @endfor
            ],
            backgroundColor: chartColors.red,
            borderRadius: 6,
            borderSkipped: false,
          },
        ],
      },
      options: {
        ...commonOptions,
        scales: {
          ...commonOptions.scales,
          x: {
            ...commonOptions.scales.x,
            stacked: true,
          },
          y: {
            ...commonOptions.scales.y,
            stacked: true,
            max: 100,
          },
        },
      },
    });

    // 3. Presentase Input Chart (Grouped Bar)
    const presentaseInputCtx = document.getElementById('presentaseInputChart').getContext('2d');
    new Chart(presentaseInputCtx, {
      type: 'bar',
      data: {
        labels: [
          @for ($i = 0; $i < count($prestasiData); $i++) 
            '{{ $prestasiData[$i]->nama }}',
          @endfor
        ],
        datasets: [
          {
            label: 'Kering Hg (Kg)',
            data: [
              @for ($i = 0; $i < count($prestasiData); $i++)
                {{ $prestasiData[$i]->sheet }},
              @endfor
            ],
            backgroundColor: chartColors.blue,
            borderRadius: 6,
            borderSkipped: false,
          },
          {
            label: 'Kering Lg (Kg)',
            data: [
              @for ($i = 0; $i < count($prestasiData); $i++)
                {{ $prestasiData[$i]->compo+$prestasiData[$i]->scrap }},
              @endfor
            ],
            backgroundColor: chartColors.red,
            borderRadius: 6,
            borderSkipped: false,
          },
        ],
      },
      options: {
        ...commonOptions,
        scales: {
          ...commonOptions.scales,
          x: {
            ...commonOptions.scales.x,
            stacked: false,
          },
          y: {
            ...commonOptions.scales.y,
            stacked: false,
          },
        },
      },
    });
    // 5. Presentase Input Chart (Grouped Bar)
    const presentaseInputBasahCtx = document.getElementById('presentaseInputChartBasah').getContext('2d');
    new Chart(presentaseInputBasahCtx, {
      type: 'bar',
      data: {
        labels: [
          @for ($i = 0; $i < count($prestasiData); $i++) 
            '{{ $prestasiData[$i]->nama }}',
          @endfor
        ],
        datasets: [
          {
            label: 'Basah Hg (Kg)',
            data: [
              @for ($i = 0; $i < count($prestasiData); $i++)
                {{ $prestasiData[$i]->basah_latek }},
              @endfor
            ],
            backgroundColor: chartColors.blue,
            borderRadius: 6,
            borderSkipped: false,
          },
          {
            label: 'Basah Lg (Kg)',
            data: [
              @for ($i = 0; $i < count($prestasiData); $i++)
                {{ $prestasiData[$i]->basah_lump+$prestasiData[$i]->basah_scrab }},
              @endfor
            ],
            backgroundColor: chartColors.red,
            borderRadius: 6,
            borderSkipped: false,
          },
        ],
      },
      options: {
        ...commonOptions,
        scales: {
          ...commonOptions.scales,
          x: {
            ...commonOptions.scales.x,
            stacked: false,
          },
          y: {
            ...commonOptions.scales.y,
            stacked: false,
          },
        },
      },
    });
    // 5. Presentase Input Chart (Grouped Bar)
    const presentaseInputProduksiCtx = document.getElementById('presentaseInputProduksiChart').getContext('2d');
    new Chart(presentaseInputProduksiCtx, {
      type: 'bar',
      data: {
        labels: [
          @for ($i = 0; $i < count($prestasiDataLite); $i++) 
            '{{ $prestasiDataLite[$i]->nama }}',
          @endfor
        ],
        datasets: [
          {
            label: '% Input',
            data: [
              @for ($i = 0; $i < count($prestasiDataLite); $i++)
                {{ min(100, $prestasiDataLite[$i]->persen_input_produksi) }},
              @endfor
            ],
            backgroundColor: chartColors.blue,
            borderRadius: 6,
            borderSkipped: false,
          },
          {
            label: '% Tidak Input',
            data: [
              @for ($i = 0; $i < count($prestasiDataLite); $i++)
                {{ max(0, 100 - min(100, $prestasiDataLite[$i]->persen_input_produksi)) }},
              @endfor
            ],
            backgroundColor: chartColors.red,
            borderRadius: 6,
            borderSkipped: false,
          },
        ],
      },
      options: {
        ...commonOptions,
        scales: {
          ...commonOptions.scales,
          x: {
            ...commonOptions.scales.x,
            stacked: true,
          },
          y: {
            ...commonOptions.scales.y,
            stacked: true,
          },
        },
      },
    });

    // NOTE: Teh tab charts are initialized dynamically by initTehCharts() when tab is clicked
    // This prevents null reference errors from trying to access hidden canvas elements on page load

</script>

<!-- Date Range Picker Script -->
<script>
  // Format tanggal ke "MMM D, YYYY" format
  function formatDate(date) {
    return new Date(date).toLocaleDateString('id-ID', { 
      year: 'numeric', 
      month: 'short', 
      day: 'numeric' 
    });
  }

  // Date Range Picker Elements
  const dateRangeInput = document.getElementById('dateRange');
  const datePickerPopup = document.getElementById('datePickerPopup');
  const datePickerStart = document.getElementById('datePickerStart');
  const datePickerEnd = document.getElementById('datePickerEnd');
  const datePickerApply = document.getElementById('datePickerApply');
  const datePickerCancel = document.getElementById('datePickerCancel');

  // Get default dates dari controller
  const tglAwalDefault = '{{ $tglAwal ?? '' }}';
  const tglAkhirDefault = '{{ $tglAkhir ?? '' }}';
  
  // Get URL parameters
  const urlParams = new URLSearchParams(window.location.search);
  const tglAwalParam = urlParams.get('tgl_awal');
  const tglAkhirParam = urlParams.get('tgl_akhir');
  const idRegParam = urlParams.get('id_reg');
  const kodeKebunParam = urlParams.get('kode_kebun');

  // Set date values dari parameter atau default dari controller
  datePickerStart.value = tglAwalParam || tglAwalDefault;
  datePickerEnd.value = tglAkhirParam || tglAkhirDefault;
  
  // Set select values dari parameter
  if (idRegParam) document.getElementById('selectRegional').value = idRegParam;
  if (kodeKebunParam) document.getElementById('selectKebun').value = kodeKebunParam;
  
  // Update display
  function updateDateDisplay() {
    if (datePickerStart.value && datePickerEnd.value) {
      dateRangeInput.value = `${formatDate(datePickerStart.value)} - ${formatDate(datePickerEnd.value)}`;
    }
  }
  updateDateDisplay();

  // Toggle popup
  dateRangeInput.addEventListener('click', () => {
    datePickerPopup.classList.toggle('hidden');
  });

  // Apply button
  datePickerApply.addEventListener('click', () => {
    if (datePickerStart.value && datePickerEnd.value) {
      if (new Date(datePickerStart.value) <= new Date(datePickerEnd.value)) {
        updateDateDisplay();
        datePickerPopup.classList.add('hidden');
        console.log('Range terpilih:', datePickerStart.value, 'hingga', datePickerEnd.value);
        // TODO: Trigger API call atau filter dengan tanggal terpilih
      } else {
        alert('Tanggal awal harus lebih kecil dari tanggal akhir');
      }
    }
  });

  // Cancel button
  datePickerCancel.addEventListener('click', () => {
    datePickerPopup.classList.add('hidden');
  });

  // Close popup when clicking outside
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.relative')) {
      datePickerPopup.classList.add('hidden');
    }
  });

  // Allow Enter key to apply
  document.addEventListener('keypress', (e) => {
    if (e.key === 'Enter' && !datePickerPopup.classList.contains('hidden')) {
      datePickerApply.click();
    }
  });

  // Regional Select Change - Load Kebun Data via AJAX
  document.getElementById('selectRegional').addEventListener('change', function() {
    const regionalId = this.value;
    const selectKebun = document.getElementById('selectKebun');

    if (!regionalId) {
      // Reset select kebun jika regional tidak dipilih
      selectKebun.innerHTML = '<option value="">Pilih</option>';
      return;
    }

    // Show loading state
    selectKebun.innerHTML = '<option value="">Loading...</option>';

    // AJAX call ke get_data_kebun
    fetch('{{ route('get_data_kebun') }}?id_reg=' + regionalId + '&komoditas=2', {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(response => response.json())
    .then(data => {
      // Clear options
      selectKebun.innerHTML = '<option value="">Pilih</option>';

      // Populate options dari response
      if (data.data && data.data.length > 0) {
        // Create a map to store unique kebun by ID
        const uniqueKebun = new Map();
        
        data.data.forEach(item => {
          if (!uniqueKebun.has(item.kebun_id)) {
            uniqueKebun.set(item.kebun_id, item.nama_kebun);
          }
        });

        // Add options to select
        uniqueKebun.forEach((nama, kebunId) => {
          const option = document.createElement('option');
          option.value = kebunId;
          option.textContent = nama;
          selectKebun.appendChild(option);
        });
      } else {
        selectKebun.innerHTML = '<option value="">Tidak ada data kebun</option>';
      }
    })
    .catch(error => {
      console.error('Error:', error);
      selectKebun.innerHTML = '<option value="">Error loading data</option>';
    });
  });

  // Filter Button Handler
  document.getElementById('btnFilter').addEventListener('click', () => {
    const tglAwal = datePickerStart.value;
    const tglAkhir = datePickerEnd.value;
    const idReg = document.getElementById('selectRegional').value;
    const kodeKebun = document.getElementById('selectKebun').value;

    // Validasi input
    if (!tglAwal || !tglAkhir) {
      alert('Silakan pilih periode terlebih dahulu');
      return;
    }

    // Build URL dengan parameter
    let url = window.location.pathname + '?';
    const params = [];
    
    if (tglAwal) params.push('tgl_awal=' + tglAwal);
    if (tglAkhir) params.push('tgl_akhir=' + tglAkhir);
    if (idReg) params.push('id_reg=' + idReg);
    if (kodeKebun) params.push('kode_kebun=' + kodeKebun);

    url += params.join('&');

    // Reload halaman dengan parameter baru
    window.location.href = url;
  });

  // Reset Button Handler
  document.getElementById('btnReset').addEventListener('click', () => {
    // Clear semua filter
    document.getElementById('selectRegional').value = '';
    document.getElementById('selectKebun').value = '';
    
    // Reset ke halaman tanpa parameter
    window.location.href = window.location.pathname;
  });

  // ============================================
  // TEH TAB - DATE PICKER & FILTER HANDLERS
  // ============================================
  
  const dateRangeInputTeh = document.getElementById('dateRangeTeh');
  const datePickerPopupTeh = document.getElementById('datePickerPopupTeh');
  const datePickerStartTeh = document.getElementById('datePickerStartTeh');
  const datePickerEndTeh = document.getElementById('datePickerEndTeh');
  const datePickerApplyTeh = document.getElementById('datePickerApplyTeh');
  const datePickerCancelTeh = document.getElementById('datePickerCancelTeh');

  // Set initial dates for Teh tab
  datePickerStartTeh.value = tglAwalDefault;
  datePickerEndTeh.value = tglAkhirDefault;
  
  // Update display for Teh
  function updateDateDisplayTeh() {
    if (datePickerStartTeh.value && datePickerEndTeh.value) {
      dateRangeInputTeh.value = `${formatDate(datePickerStartTeh.value)} - ${formatDate(datePickerEndTeh.value)}`;
    }
  }
  updateDateDisplayTeh();

  // Toggle popup for Teh
  dateRangeInputTeh.addEventListener('click', () => {
    datePickerPopupTeh.classList.toggle('hidden');
  });

  // Apply button for Teh
  datePickerApplyTeh.addEventListener('click', () => {
    if (datePickerStartTeh.value && datePickerEndTeh.value) {
      if (new Date(datePickerStartTeh.value) <= new Date(datePickerEndTeh.value)) {
        updateDateDisplayTeh();
        datePickerPopupTeh.classList.add('hidden');
      } else {
        alert('Tanggal awal harus lebih kecil dari tanggal akhir');
      }
    }
  });

  // Cancel button for Teh
  datePickerCancelTeh.addEventListener('click', () => {
    datePickerPopupTeh.classList.add('hidden');
  });

  // Regional Select Change for Teh - Load Kebun Data via AJAX
  document.getElementById('selectTehRegional').addEventListener('change', function() {
    const regionalId = this.value;
    const selectKebun = document.getElementById('selectTehKebun');

    if (!regionalId) {
      selectKebun.innerHTML = '<option value="">Pilih</option>';
      return;
    }

    selectKebun.innerHTML = '<option value="">Loading...</option>';

    fetch('{{ route('get_data_kebun') }}?id_reg=' + regionalId + '&komoditas=1', {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(response => response.json())
    .then(data => {
      selectKebun.innerHTML = '<option value="">Pilih</option>';

      if (data.data && data.data.length > 0) {
        const uniqueKebun = new Map();
        data.data.forEach(item => {
          if (!uniqueKebun.has(item.kebun_id)) {
            uniqueKebun.set(item.kebun_id, item.nama_kebun);
          }
        });

        uniqueKebun.forEach((nama, kebunId) => {
          const option = document.createElement('option');
          option.value = kebunId;
          option.textContent = nama;
          selectKebun.appendChild(option);
        });
      } else {
        selectKebun.innerHTML = '<option value="">Tidak ada data kebun</option>';
      }
    })
    .catch(error => {
      console.error('Error:', error);
      selectKebun.innerHTML = '<option value="">Error loading data</option>';
    });
  });

  // Store for Teh charts globally
  window.tehCharts = [];

  // Filter Button Handler for Teh Tab
  document.getElementById('btnTehFilter').addEventListener('click', async () => {
    const tglAwal = datePickerStartTeh.value;
    const tglAkhir = datePickerEndTeh.value;
    const idReg = document.getElementById('selectTehRegional').value;
    const kodeKebun = document.getElementById('selectTehKebun').value;

    if (!tglAwal || !tglAkhir) {
      showErrorPopup('Silakan pilih periode terlebih dahulu');
      return;
    }

    // Show loading spinner
    const loadingSpinner = document.getElementById('tehLoadingSpinner');
    loadingSpinner.classList.add('active');

    // Call AJAX endpoint
    try {
      const response = await fetch('{{ route('ajax_dfarmtehproduksi') }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
          id_reg: idReg,
          tgl_awal: tglAwal,
          tgl_akhir: tglAkhir,
          kode_kebun: kodeKebun,
          jobdesc: 'PEMETIK'
        })
      });

      const data = await response.json();
      loadingSpinner.classList.remove('active');

      if (!data.success) {
        showErrorPopup(data.error || 'Gagal load data');
        return;
      }

      // Update KPI Cards
      const panen_manual_total = data.prestasiData.reduce((sum, item) => sum + (parseFloat(item.panen_manual) || 0), 0);
      const panen_gunting_total = data.prestasiData.reduce((sum, item) => sum + (parseFloat(item.panen_gunting) || 0), 0);
      const panen_mesin_total = data.prestasiData.reduce((sum, item) => sum + (parseFloat(item.panen_mesin_individu) || 0), 0);
      const total = data.prestasiData.reduce((sum, item) => sum + (parseFloat(item.total) || 0), 0);

      document.getElementById('kpiTehPanenManual').textContent = new Intl.NumberFormat('id-ID').format(Math.round(panen_manual_total));
      document.getElementById('kpiTehPanenGunting').textContent = new Intl.NumberFormat('id-ID').format(Math.round(panen_gunting_total));
      document.getElementById('kpiTehPanenMesin').textContent = new Intl.NumberFormat('id-ID').format(Math.round(panen_mesin_total));
      document.getElementById('kpiTehTotal').textContent = new Intl.NumberFormat('id-ID').format(Math.round(total));

      // Destroy existing charts
      window.tehCharts.forEach(chart => chart.destroy());
      window.tehCharts = [];

      // Initialize Charts with AJAX data
      initTehCharts(data.prestasiData, data.prestasiDataLite);

    } catch (error) {
      console.error('Error:', error);
      loadingSpinner.classList.remove('active');
      showErrorPopup('Terjadi error saat load data');
    }
  });

  // Reset Button Handler for Teh Tab
  document.getElementById('btnTehReset').addEventListener('click', () => {
    document.getElementById('selectTehRegional').value = '';
    document.getElementById('selectTehKebun').value = '';
    
    // Hide loading spinner
    document.getElementById('tehLoadingSpinner').classList.remove('active');
    
    // Reset KPI cards
    document.getElementById('kpiTehPanenManual').textContent = '0';
    document.getElementById('kpiTehPanenGunting').textContent = '0';
    document.getElementById('kpiTehPanenMesin').textContent = '0';
    document.getElementById('kpiTehTotal').textContent = '0';

    // Destroy charts
    window.tehCharts.forEach(chart => chart.destroy());
    window.tehCharts = [];
  });

  // ============================================
  // KOPI TAB - DATE PICKER & FILTER HANDLERS
  // ============================================
  
  const dateRangeInputKopi = document.getElementById('dateRangeKopi');
  const datePickerPopupKopi = document.getElementById('datePickerPopupKopi');
  const datePickerStartKopi = document.getElementById('datePickerStartKopi');
  const datePickerEndKopi = document.getElementById('datePickerEndKopi');
  const datePickerApplyKopi = document.getElementById('datePickerApplyKopi');
  const datePickerCancelKopi = document.getElementById('datePickerCancelKopi');

  // Set initial dates for Kopi tab
  datePickerStartKopi.value = tglAwalDefault;
  datePickerEndKopi.value = tglAkhirDefault;
  
  // Update display for Kopi
  function updateDateDisplayKopi() {
    if (datePickerStartKopi.value && datePickerEndKopi.value) {
      dateRangeInputKopi.value = `${formatDate(datePickerStartKopi.value)} - ${formatDate(datePickerEndKopi.value)}`;
    }
  }
  updateDateDisplayKopi();

  // Toggle popup for Kopi
  dateRangeInputKopi.addEventListener('click', () => {
    datePickerPopupKopi.classList.toggle('hidden');
  });

  // Apply button for Kopi
  datePickerApplyKopi.addEventListener('click', () => {
    if (datePickerStartKopi.value && datePickerEndKopi.value) {
      if (new Date(datePickerStartKopi.value) <= new Date(datePickerEndKopi.value)) {
        updateDateDisplayKopi();
        datePickerPopupKopi.classList.add('hidden');
      } else {
        alert('Tanggal awal harus lebih kecil dari tanggal akhir');
      }
    }
  });

  // Cancel button for Kopi
  datePickerCancelKopi.addEventListener('click', () => {
    datePickerPopupKopi.classList.add('hidden');
  });

  // Regional Select Change for Kopi - Load Kebun Data via AJAX
  document.getElementById('selectKopiRegional').addEventListener('change', function() {
    const regionalId = this.value;
    const selectKebun = document.getElementById('selectKopiKebun');

    if (!regionalId) {
      selectKebun.innerHTML = '<option value="">Pilih</option>';
      return;
    }

    selectKebun.innerHTML = '<option value="">Loading...</option>';

    fetch('{{ route('get_data_kebun') }}?id_reg=' + regionalId + '&komoditas=3', {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(response => response.json())
    .then(data => {
      selectKebun.innerHTML = '<option value="">Pilih</option>';

      if (data.data && data.data.length > 0) {
        const uniqueKebun = new Map();
        data.data.forEach(item => {
          if (!uniqueKebun.has(item.kebun_id)) {
            uniqueKebun.set(item.kebun_id, item.nama_kebun);
          }
        });

        uniqueKebun.forEach((nama, kebunId) => {
          const option = document.createElement('option');
          option.value = kebunId;
          option.textContent = nama;
          selectKebun.appendChild(option);
        });
      } else {
        selectKebun.innerHTML = '<option value="">Tidak ada data kebun</option>';
      }
    })
    .catch(error => {
      console.error('Error:', error);
      selectKebun.innerHTML = '<option value="">Error loading data</option>';
    });
  });

  // Store for Kopi charts globally
  window.kopiCharts = [];

  // Initialize Kopi Charts Function
  function initKopiCharts(prestasiData, prestasiDataLite) {
    // Chart 1: Warna Basah (Merah/Kuning/Hijau/Hitam)
    const kopiBasahCtx = document.getElementById('kopiWarnaBasahChart').getContext('2d');
    if (kopiBasahCtx) {
      const kopiBasah = new Chart(kopiBasahCtx, {
        type: 'bar',
        data: {
          labels: prestasiData.map(item => item.nama),
          datasets: [
            {
              label: 'Basah Merah (Kg)',
              data: prestasiData.map(item => item.basah_merah || 0),
              backgroundColor: chartColors.red,
              borderRadius: 6,
              borderSkipped: false,
            },
            {
              label: 'Basah Kuning (Kg)',
              data: prestasiData.map(item => item.basah_kuning || 0),
              backgroundColor: '#f59e0b',
              borderRadius: 6,
              borderSkipped: false,
            },
            {
              label: 'Basah Hijau (Kg)',
              data: prestasiData.map(item => item.basah_hijau || 0),
              backgroundColor: chartColors.cyan,
              borderRadius: 6,
              borderSkipped: false,
            },
            {
              label: 'Basah Hitam (Kg)',
              data: prestasiData.map(item => item.basah_hitam || 0),
              backgroundColor: '#374151',
              borderRadius: 6,
              borderSkipped: false,
            },
          ],
        },
        options: {
          ...commonOptions,
          scales: {
            ...commonOptions.scales,
            x: {
              ...commonOptions.scales.x,
              stacked: false,
            },
            y: {
              ...commonOptions.scales.y,
              stacked: false,
            },
          },
        },
      });
      window.kopiCharts.push(kopiBasah);
    }

    // Chart 2: Warna Kering (Merah/Kuning/Hijau/Hitam)
    const kopiKeringCtx = document.getElementById('kopiWarnaKeringChart').getContext('2d');
    if (kopiKeringCtx) {
      const kopiKering = new Chart(kopiKeringCtx, {
        type: 'bar',
        data: {
          labels: prestasiData.map(item => item.nama),
          datasets: [
            {
              label: 'Kering Merah (Kg)',
              data: prestasiData.map(item => item.kering_merah || 0),
              backgroundColor: chartColors.red,
              borderRadius: 6,
              borderSkipped: false,
            },
            {
              label: 'Kering Kuning (Kg)',
              data: prestasiData.map(item => item.kering_kuning || 0),
              backgroundColor: '#f59e0b',
              borderRadius: 6,
              borderSkipped: false,
            },
            {
              label: 'Kering Hijau (Kg)',
              data: prestasiData.map(item => item.kering_hijau || 0),
              backgroundColor: chartColors.cyan,
              borderRadius: 6,
              borderSkipped: false,
            },
            {
              label: 'Kering Hitam (Kg)',
              data: prestasiData.map(item => item.kering_hitam || 0),
              backgroundColor: '#374151',
              borderRadius: 6,
              borderSkipped: false,
            },
          ],
        },
        options: {
          ...commonOptions,
          scales: {
            ...commonOptions.scales,
            x: {
              ...commonOptions.scales.x,
              stacked: false,
            },
            y: {
              ...commonOptions.scales.y,
              stacked: false,
            },
          },
        },
      });
      window.kopiCharts.push(kopiKering);
    }

    // Chart 3: % Input Produksi
    const kopiInputCtx = document.getElementById('kopiInputProduksiChart').getContext('2d');
    if (kopiInputCtx) {
      const kopiInput = new Chart(kopiInputCtx, {
        type: 'bar',
        data: {
          labels: prestasiDataLite.map(item => item.nama),
          datasets: [
            {
              label: '% Input',
              data: prestasiDataLite.map(item => Math.min(100, item.persen_input_produksi || 0)),
              backgroundColor: chartColors.blue,
              borderRadius: 6,
              borderSkipped: false,
            },
            {
              label: '% Tidak Input',
              data: prestasiDataLite.map(item => Math.max(0, 100 - Math.min(100, item.persen_input_produksi || 0))),
              backgroundColor: chartColors.red,
              borderRadius: 6,
              borderSkipped: false,
            },
          ],
        },
        options: {
          ...commonOptions,
          scales: {
            ...commonOptions.scales,
            x: {
              ...commonOptions.scales.x,
              stacked: true,
            },
            y: {
              ...commonOptions.scales.y,
              stacked: true,
              max: 100,
            },
          },
        },
      });
      window.kopiCharts.push(kopiInput);
    }
  }

  // Filter Button Handler for Kopi Tab
  document.getElementById('btnKopiFilter').addEventListener('click', async () => {
    const tglAwal = datePickerStartKopi.value;
    const tglAkhir = datePickerEndKopi.value;
    const idReg = document.getElementById('selectKopiRegional').value;
    const kodeKebun = document.getElementById('selectKopiKebun').value;

    if (!tglAwal || !tglAkhir) {
      showErrorPopup('Silakan pilih periode terlebih dahulu');
      return;
    }

    // Show loading spinner
    const loadingSpinner = document.getElementById('kopiLoadingSpinner');
    loadingSpinner.classList.add('active');

    // Call AJAX endpoint
    try {
      const response = await fetch('{{ route('ajax_dfarmkopiproduksi') }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
          id_reg: idReg,
          tgl_awal: tglAwal,
          tgl_akhir: tglAkhir,
          kode_kebun: kodeKebun,
          jobdesc: 'PANEN KOPI'
        })
      });

      const data = await response.json();
      loadingSpinner.classList.remove('active');

      if (!data.success) {
        showErrorPopup(data.error || 'Gagal load data');
        return;
      }

      // Update KPI Cards
      const totalBasah = data.prestasiData.reduce((sum, item) => sum + (parseFloat(item.total_basah) || 0), 0);
      const totalKering = data.prestasiData.reduce((sum, item) => sum + (parseFloat(item.total_kering) || 0), 0);
      const avgInputPercent = data.prestasiDataLite.length > 0 
        ? data.prestasiDataLite.reduce((sum, item) => sum + (parseFloat(item.persen_input_produksi) || 0), 0) / data.prestasiDataLite.length 
        : 0;

      document.getElementById('kpiKopiTotalBasah').textContent = new Intl.NumberFormat('id-ID').format(Math.round(totalBasah));
      document.getElementById('kpiKopiTotalKering').textContent = new Intl.NumberFormat('id-ID').format(Math.round(totalKering));
      document.getElementById('kpiKopiInputPercent').textContent = Math.round(avgInputPercent) + '%';

      // Destroy existing charts
      window.kopiCharts.forEach(chart => chart.destroy());
      window.kopiCharts = [];

      // Initialize Charts with AJAX data
      initKopiCharts(data.prestasiData, data.prestasiDataLite);

    } catch (error) {
      console.error('Error:', error);
      loadingSpinner.classList.remove('active');
      showErrorPopup('Terjadi error saat load data');
    }
  });

  // Reset Button Handler for Kopi Tab
  document.getElementById('btnKopiReset').addEventListener('click', () => {
    document.getElementById('selectKopiRegional').value = '';
    document.getElementById('selectKopiKebun').value = '';
    
    // Hide loading spinner
    document.getElementById('kopiLoadingSpinner').classList.remove('active');
    
    // Reset KPI cards
    document.getElementById('kpiKopiTotalBasah').textContent = '0';
    document.getElementById('kpiKopiTotalKering').textContent = '0';
    document.getElementById('kpiKopiInputPercent').textContent = '0%';

    // Destroy charts
    window.kopiCharts.forEach(chart => chart.destroy());
    window.kopiCharts = [];
  });

  // ============================================
  // PEMELIHARAAN TAB - DATE PICKER & FILTER HANDLERS
  // ============================================
  
  const dateRangeInputPemeliharaan = document.getElementById('dateRangePemeliharaan');
  const datePickerPopupPemeliharaan = document.getElementById('datePickerPopupPemeliharaan');
  const datePickerStartPemeliharaan = document.getElementById('datePickerStartPemeliharaan');
  const datePickerEndPemeliharaan = document.getElementById('datePickerEndPemeliharaan');
  const datePickerApplyPemeliharaan = document.getElementById('datePickerApplyPemeliharaan');
  const datePickerCancelPemeliharaan = document.getElementById('datePickerCancelPemeliharaan');

  // Set initial dates for Pemeliharaan tab
  datePickerStartPemeliharaan.value = tglAwalDefault;
  datePickerEndPemeliharaan.value = tglAkhirDefault;
  
  // Update display for Pemeliharaan
  function updateDateDisplayPemeliharaan() {
    if (datePickerStartPemeliharaan.value && datePickerEndPemeliharaan.value) {
      dateRangeInputPemeliharaan.value = `${formatDate(datePickerStartPemeliharaan.value)} - ${formatDate(datePickerEndPemeliharaan.value)}`;
    }
  }
  updateDateDisplayPemeliharaan();

  // Toggle popup for Pemeliharaan
  dateRangeInputPemeliharaan.addEventListener('click', () => {
    datePickerPopupPemeliharaan.classList.toggle('hidden');
  });

  // Apply button for Pemeliharaan
  datePickerApplyPemeliharaan.addEventListener('click', () => {
    if (datePickerStartPemeliharaan.value && datePickerEndPemeliharaan.value) {
      if (new Date(datePickerStartPemeliharaan.value) <= new Date(datePickerEndPemeliharaan.value)) {
        updateDateDisplayPemeliharaan();
        datePickerPopupPemeliharaan.classList.add('hidden');
      } else {
        alert('Tanggal awal harus lebih kecil dari tanggal akhir');
      }
    }
  });

  // Cancel button for Pemeliharaan
  datePickerCancelPemeliharaan.addEventListener('click', () => {
    datePickerPopupPemeliharaan.classList.add('hidden');
  });

  // Komoditas Select Change for Pemeliharaan - Load Aktivitas Data via AJAX
  document.getElementById('selectPemeliharaanKomoditas').addEventListener('change', function() {
    const komoditas = this.value;
    const selectAktivitas = document.getElementById('selectPemeliharaanAktivitas');
    const selectRegional = document.getElementById('selectPemeliharaanRegional');

    // Reset dependent selects
    selectAktivitas.innerHTML = '<option value="">Loading...</option>';
    selectRegional.innerHTML = '<option value="">Pilih</option>';

    if (!komoditas) {
      selectAktivitas.innerHTML = '<option value="">Pilih</option>';
      return;
    }

    // Load aktivitas data
    fetch('{{ route('get_data_aktivitas') }}?komoditas=' + komoditas, {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(response => response.json())
    .then(data => {
      selectAktivitas.innerHTML = '<option value="">Pilih</option>';

      if (data.data && data.data.length > 0) {
        data.data.forEach(item => {
          const option = document.createElement('option');
          option.value = item.id;
          option.textContent = item.nama;
          selectAktivitas.appendChild(option);
        });
      } else {
        selectAktivitas.innerHTML = '<option value="">Tidak ada data aktivitas</option>';
      }
    })
    .catch(error => {
      console.error('Error:', error);
      selectAktivitas.innerHTML = '<option value="">Error loading data</option>';
    });
  });

  // Regional Select Change for Pemeliharaan - Load Kebun Data via AJAX
  document.getElementById('selectPemeliharaanRegional').addEventListener('change', function() {
    const regionalId = this.value;
    const komoditas = document.getElementById('selectPemeliharaanKomoditas').value;
    const selectKebun = document.getElementById('selectPemeliharaanKebun');

    if (!regionalId) {
      selectKebun.innerHTML = '<option value="">Pilih</option>';
      return;
    }

    selectKebun.innerHTML = '<option value="">Loading...</option>';

    fetch('{{ route('get_data_kebun') }}?id_reg=' + regionalId + '&komoditas=' + komoditas, {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(response => response.json())
    .then(data => {
      selectKebun.innerHTML = '<option value="">Pilih</option>';

      if (data.data && data.data.length > 0) {
        const uniqueKebun = new Map();
        data.data.forEach(item => {
          if (!uniqueKebun.has(item.kebun_id)) {
            uniqueKebun.set(item.kebun_id, item.nama_kebun);
          }
        });

        uniqueKebun.forEach((nama, kebunId) => {
          const option = document.createElement('option');
          option.value = kebunId;
          option.textContent = nama;
          selectKebun.appendChild(option);
        });
      } else {
        selectKebun.innerHTML = '<option value="">Tidak ada data kebun</option>';
      }
    })
    .catch(error => {
      console.error('Error:', error);
      selectKebun.innerHTML = '<option value="">Error loading data</option>';
    });
  });

  // Store for Pemeliharaan charts globally
  window.pemeliharaanCharts = [];

  // Initialize Pemeliharaan Charts Function
  function initPemeliharaanCharts(prestasiData, prestasiDataLite) {
    // Chart 1: Hasil Aktivitas Pemeliharaan
    const pemeliharaanHasilCtx = document.getElementById('pemeliharaanHasilChart').getContext('2d');
    if (pemeliharaanHasilCtx) {
      const pemeliharaanHasil = new Chart(pemeliharaanHasilCtx, {
        type: 'bar',
        data: {
          labels: prestasiData.map(item => item.nama),
          datasets: [
            {
              label: 'Hasil Pemeliharaan',
              data: prestasiData.map(item => item.hasil_pemeliharaan || 0),
              backgroundColor: chartColors.blue,
              borderRadius: 6,
              borderSkipped: false,
            },
          ],
        },
        options: {
          ...commonOptions,
          scales: {
            ...commonOptions.scales,
            x: {
              ...commonOptions.scales.x,
              stacked: false,
            },
            y: {
              ...commonOptions.scales.y,
              stacked: false,
            },
          },
        },
      });
      window.pemeliharaanCharts.push(pemeliharaanHasil);
    }

    // Chart 2: % Input Produksi
    const pemeliharaanInputCtx = document.getElementById('pemeliharaanInputProduksiChart').getContext('2d');
    if (pemeliharaanInputCtx) {
      const pemeliharaanInput = new Chart(pemeliharaanInputCtx, {
        type: 'bar',
        data: {
          labels: prestasiDataLite.map(item => item.nama),
          datasets: [
            {
              label: '% Input',
              data: prestasiDataLite.map(item => Math.min(100, item.persen_input_produksi || 0)),
              backgroundColor: chartColors.blue,
              borderRadius: 6,
              borderSkipped: false,
            },
            {
              label: '% Tidak Input',
              data: prestasiDataLite.map(item => Math.max(0, 100 - Math.min(100, item.persen_input_produksi || 0))),
              backgroundColor: chartColors.red,
              borderRadius: 6,
              borderSkipped: false,
            },
          ],
        },
        options: {
          ...commonOptions,
          scales: {
            ...commonOptions.scales,
            x: {
              ...commonOptions.scales.x,
              stacked: true,
            },
            y: {
              ...commonOptions.scales.y,
              stacked: true,
              max: 100,
            },
          },
        },
      });
      window.pemeliharaanCharts.push(pemeliharaanInput);
    }
  }

  // Filter Button Handler for Pemeliharaan Tab
  document.getElementById('btnPemeliharaanFilter').addEventListener('click', async () => {
    const tglAwal = datePickerStartPemeliharaan.value;
    const tglAkhir = datePickerEndPemeliharaan.value;
    const idReg = document.getElementById('selectPemeliharaanRegional').value;
    const kodeKebun = document.getElementById('selectPemeliharaanKebun').value;
    const komoditas = document.getElementById('selectPemeliharaanKomoditas').value;
    const jenisAktivitas = document.getElementById('selectPemeliharaanAktivitas').value;

    if (!tglAwal || !tglAkhir) {
      showErrorPopup('Silakan pilih periode terlebih dahulu');
      return;
    }

    if (!komoditas) {
      showErrorPopup('Silakan pilih komoditas terlebih dahulu');
      return;
    }

    // Show loading spinner
    const loadingSpinner = document.getElementById('pemeliharaanLoadingSpinner');
    loadingSpinner.classList.add('active');

    // Call AJAX endpoint
    try {
      const response = await fetch('{{ route('ajax_dfarmpemeliharaan') }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
          id_reg: idReg,
          tgl_awal: tglAwal,
          tgl_akhir: tglAkhir,
          kode_kebun: kodeKebun,
          komoditas: komoditas,
          jenis_aktivitas: jenisAktivitas,
          jobdesc: 'PEMELIHARAAN'
        })
      });

      const data = await response.json();
      loadingSpinner.classList.remove('active');

      if (!data.success) {
        showErrorPopup(data.error || 'Gagal load data');
        return;
      }

      // Update KPI Cards
      const totalHasil = data.prestasiData.reduce((sum, item) => sum + (parseFloat(item.hasil_pemeliharaan) || 0), 0);
      const avgInputPercent = data.prestasiDataLite.length > 0 
        ? data.prestasiDataLite.reduce((sum, item) => sum + (parseFloat(item.persen_input_produksi) || 0), 0) / data.prestasiDataLite.length 
        : 0;

      document.getElementById('kpiPemeliharaanHasil').textContent = new Intl.NumberFormat('id-ID').format(Math.round(totalHasil));
      document.getElementById('kpiPemeliharaanInputPercent').textContent = Math.round(avgInputPercent) + '%';

      // Destroy existing charts
      window.pemeliharaanCharts.forEach(chart => chart.destroy());
      window.pemeliharaanCharts = [];

      // Initialize Charts with AJAX data
      initPemeliharaanCharts(data.prestasiData, data.prestasiDataLite);

    } catch (error) {
      console.error('Error:', error);
      loadingSpinner.classList.remove('active');
      showErrorPopup('Terjadi error saat load data');
    }
  });

  // Reset Button Handler for Pemeliharaan Tab
  document.getElementById('btnPemeliharaanReset').addEventListener('click', () => {
    document.getElementById('selectPemeliharaanKomoditas').value = '';
    document.getElementById('selectPemeliharaanAktivitas').value = '';
    document.getElementById('selectPemeliharaanRegional').value = '';
    document.getElementById('selectPemeliharaanKebun').value = '';
    
    // Hide loading spinner
    document.getElementById('pemeliharaanLoadingSpinner').classList.remove('active');
    
    // Reset KPI cards
    document.getElementById('kpiPemeliharaanHasil').textContent = '0';
    document.getElementById('kpiPemeliharaanInputPercent').textContent = '0%';

    // Destroy charts
    window.pemeliharaanCharts.forEach(chart => chart.destroy());
    window.pemeliharaanCharts = [];
  });
</script>

@include('pages.dfarm.menu.menu-script')

@endsection

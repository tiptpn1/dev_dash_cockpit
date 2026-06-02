
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
            @include('pages.dfarm.components.application-select', ['selected' => 'Digital Farming'])
          </div>

          <!-- Table Card -->
          <div class="table-card">
            <div class="table-header">
              <div class="table-title">
                <i class="fas fa-table"></i>
                <span id="table-title">Data Presensi DFARM</span>
                <span id="regional-badge" class="regional-badge" style="display:none;"></span>
              </div>
              <span id="data-count-badge" class="table-count">Dfarm PTPN I</span>
            </div>

            <div id="tabs-wrap" style="display: block;">
              <div class="hris-tabs">
                <button type="button" class="hris-tab-btn active" data-tab="rekap">
                <i class="fas fa-chart-bar"></i> Rekap Presensi
                </button>
                <button type="button" class="hris-tab-btn" data-tab="detail">
                <i class="fas fa-calendar-day"></i> Detail Presensi
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
                        <label class="form-label">Job Desc</label>
                        <select id="selectJobDesc" class="form-select">
                          <option value="PENYADAP" <?php if ($jobdesc == 'PENYADAP') echo 'selected'; ?>>PENYADAP</option>
                          <option value="PEMETIK" <?php if ($jobdesc == 'PEMETIK') echo 'selected'; ?>>PEMETIK</option>
                          <option value="PANEN KOPI" <?php if ($jobdesc == 'PANEN KOPI') echo 'selected'; ?>>PANEN KOPI</option>
                          <option value="PEMELIHARAAN" <?php if ($jobdesc == 'PEMELIHARAAN') echo 'selected'; ?>>PEMELIHARAAN</option>
                        </select>
                      </div>

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
                    <!-- Presensi Hadir -->
                    <div style="background: #fff; border: 1px solid #d1fae5; border-top: 4px solid #166534; border-radius: 8px; padding: 18px; box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08); transition: transform 0.2s, box-shadow 0.2s;" class="hover:shadow-lg hover:scale-105">
                      <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                        <h3 style="color: #166534; font-size: 12px; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Presensi Hadir</h3>
                        <i class="fas fa-check-circle" style="color: #16a34a; font-size: 18px;"></i>
                      </div>
                      <p style="color: #166534; font-size: 28px; font-weight: 800; margin: 0; line-height: 1;">{{ number_format($totalData['kehadiran'], 0, ',', '.') }}</p>
                      <p style="color: #6b7280; font-size: 11px; margin: 4px 0 0 0;">Orang</p>
                    </div>

                    <!-- Jumlah Input Presensi -->
                    <div style="background: #fff; border: 1px solid #d1fae5; border-top: 4px solid #166534; border-radius: 8px; padding: 18px; box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08); transition: transform 0.2s, box-shadow 0.2s;" class="hover:shadow-lg hover:scale-105">
                      <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                        <h3 style="color: #166534; font-size: 12px; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Input Presensi</h3>
                        <i class="fas fa-user-check" style="color: #16a34a; font-size: 18px;"></i>
                      </div>
                      <p style="color: #166534; font-size: 28px; font-weight: 800; margin: 0; line-height: 1;">{{ number_format($totalData['total_pegawai']-$totalData['belum_hadir'], 0, ',', '.') }}</p>
                      <p style="color: #6b7280; font-size: 11px; margin: 4px 0 0 0;">Orang</p>
                    </div>

                    <!-- Jumlah Karyawan -->
                    <div style="background: #fff; border: 1px solid #d1fae5; border-top: 4px solid #166534; border-radius: 8px; padding: 18px; box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08); transition: transform 0.2s, box-shadow 0.2s;" class="hover:shadow-lg hover:scale-105">
                      <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                        <h3 style="color: #166534; font-size: 12px; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Total Karyawan</h3>
                        <i class="fas fa-users" style="color: #16a34a; font-size: 18px;"></i>
                      </div>
                      <p style="color: #166534; font-size: 28px; font-weight: 800; margin: 0; line-height: 1;">{{ number_format($totalData['total_pegawai'], 0, ',', '.') }}</p>
                      <p style="color: #6b7280; font-size: 11px; margin: 4px 0 0 0;">Orang</p>
                    </div>

                    <!-- Persentase Kehadiran -->
                    <div style="background: #fff; border: 1px solid #d1fae5; border-top: 4px solid #166534; border-radius: 8px; padding: 18px; box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08); transition: transform 0.2s, box-shadow 0.2s;" class="hover:shadow-lg hover:scale-105">
                      <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                        <h3 style="color: #166534; font-size: 12px; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">% Kehadiran</h3>
                        <i class="fas fa-percent" style="color: #16a34a; font-size: 18px;"></i>
                      </div>
                      <p style="color: #166534; font-size: 28px; font-weight: 800; margin: 0; line-height: 1;">{{$totalData['prosentase_kehadiran']}}%</p>
                      <p style="color: #6b7280; font-size: 11px; margin: 4px 0 0 0;">Tingkat Kehadiran</p>
                    </div>

                    <!-- Presentase Input Presensi -->
                    <div style="background: #fff; border: 1px solid #d1fae5; border-top: 4px solid #166534; border-radius: 8px; padding: 18px; box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08); transition: transform 0.2s, box-shadow 0.2s;" class="hover:shadow-lg hover:scale-105">
                      <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                        <h3 style="color: #166534; font-size: 12px; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">% Input</h3>
                        <i class="fas fa-clipboard-check" style="color: #16a34a; font-size: 18px;"></i>
                      </div>
                      <p style="color: #166534; font-size: 28px; font-weight: 800; margin: 0; line-height: 1;">{{$totalData['prosentase']}}%</p>
                      <p style="color: #6b7280; font-size: 11px; margin: 4px 0 0 0;">Tingkat Input</p>
                    </div>

                    <!-- Presentase Tidak Input -->
                    <div style="background: #fff; border: 1px solid #fee2e2; border-top: 4px solid #dc2626; border-radius: 8px; padding: 18px; box-shadow: 0 2px 8px rgba(220, 38, 38, 0.08); transition: transform 0.2s, box-shadow 0.2s;" class="hover:shadow-lg hover:scale-105">
                      <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                        <h3 style="color: #991b1b; font-size: 12px; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">% Belum Input</h3>
                        <i class="fas fa-exclamation-circle" style="color: #dc2626; font-size: 18px;"></i>
                      </div>
                      <p style="color: #991b1b; font-size: 28px; font-weight: 800; margin: 0; line-height: 1;">{{100-$totalData['prosentase']}}%</p>
                      <p style="color: #6b7280; font-size: 11px; margin: 4px 0 0 0;">Belum Input Presensi</p>
                    </div>
                  </div>
                  @if($selectedRegional =="")
                    <!-- Charts Section - By Regional -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
                      <!-- Presensi Chart -->
                      <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
                        <h2 class="text-white text-xs md:text-sm font-bold mb-3 text-center">Presentase Input Presensi</h2>
                        <div class="relative h-56 md:h-64">
                          <canvas id="presensiChart"></canvas>
                        </div>
                      </div>

                      <!-- Presentase Hadir Chart -->
                      <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
                        <h2 class="text-white text-xs md:text-sm font-bold mb-3 text-center">Presentase Hadir</h2>
                        <div class="relative h-56 md:h-64">
                          <canvas id="presentaseHadirChart"></canvas>
                        </div>
                      </div>

                      <!-- Presentase Input Chart -->
                      <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm lg:col-span-2">
                        <h2 class="text-white text-xs md:text-sm font-bold mb-3 text-center">Perbandingan Input Presensi & Jumlah Pemanen</h2>
                        <div class="relative h-56 md:h-64">
                          <canvas id="presentaseInputChart"></canvas>
                        </div>
                      </div>
                    </div>
                  @endif
                  @if($selectedRegional !="" && $selectedKebun =="")
                    <!-- Detail Charts Section - By Kebun -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                      <!-- Presensi Detail Chart -->
                      <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
                        <h2 class="text-white text-xs md:text-sm font-bold mb-3 text-center">Presensi</h2>
                        <div class="relative h-56 md:h-64">
                          <canvas id="presensiDetailChart"></canvas>
                        </div>
                      </div>

                      <!-- Presentase Hadir Detail Chart -->
                      <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
                        <h2 class="text-white text-xs md:text-sm font-bold mb-3 text-center">Presentase Hadir</h2>
                        <div class="relative h-56 md:h-64">
                          <canvas id="presentaseHadirDetailChart"></canvas>
                        </div>
                      </div>

                      <!-- Presentase Input Detail Chart -->
                      <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm lg:col-span-2">
                        <h2 class="text-white text-xs md:text-sm font-bold mb-3 text-center">Presentase Input</h2>
                        <div class="relative h-56 md:h-64">
                          <canvas id="presentaseInputDetailChart"></canvas>
                        </div>
                      </div>
                    </div>
                  @endif
                  @if($selectedRegional !="" && $selectedKebun !="")
                    <!-- Detail Charts Section - By Kebun -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                      <!-- Presensi Detail Chart -->
                      <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
                        <h2 class="text-white text-xs md:text-sm font-bold mb-3 text-center">Presensi</h2>
                        <div class="relative h-56 md:h-64">
                          <canvas id="presensiDetailChart"></canvas>
                        </div>
                      </div>

                      <!-- Presentase Hadir Detail Chart -->
                      <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
                        <h2 class="text-white text-xs md:text-sm font-bold mb-3 text-center">Presentase Hadir</h2>
                        <div class="relative h-56 md:h-64">
                          <canvas id="presentaseHadirDetailChart"></canvas>
                        </div>
                      </div>

                      <!-- Presentase Input Detail Chart -->
                      <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm lg:col-span-2">
                        <h2 class="text-white text-xs md:text-sm font-bold mb-3 text-center">Presentase Input</h2>
                        <div class="relative h-56 md:h-64">
                          <canvas id="presentaseInputDetailChart"></canvas>
                        </div>
                      </div>
                    </div>
                  @endif


                </div>

                <!-- Tab 2: Detail -->
                <div id="tab-detail" class="hris-tab-panel">
                  <!-- Filter Card in Tab -->
                  <div class="filter-card" style="margin: 16px;">
                    <div class="filter-title">
                      <i class="fas fa-sliders-h"></i> Filter Parameter
                    </div>
                    <div class="filter-grid">
                      <div class="form-group">
                        <label class="form-label">Job Desc</label>
                        <select id="selectJobDesc" class="form-select">
                          <option value="PENYADAP" <?php if ($jobdesc == 'PENYADAP') echo 'selected'; ?>>PENYADAP</option>
                          <option value="PEMETIK" <?php if ($jobdesc == 'PEMETIK') echo 'selected'; ?>>PEMETIK</option>
                          <option value="PANEN KOPI" <?php if ($jobdesc == 'PANEN KOPI') echo 'selected'; ?>>PANEN KOPI</option>
                          <option value="PEMELIHARAAN" <?php if ($jobdesc == 'PEMELIHARAAN') echo 'selected'; ?>>PEMELIHARAAN</option>
                        </select>
                      </div>

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

                  <div class="table-wrapper">
                    @if($selectedRegional =="")
                      <!-- Table Section - By Regional -->
                      <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm mb-6">
                        <h2 class=" text-xs md:text-sm font-bold mb-4 text-center">Data Presensi Berdasarkan Regional</h2>
                        <div class="overflow-x-auto">
                          <table class="w-full text-xs md:text-sm">
                            <thead>
                              <tr class="bg-slate-600 sticky top-0">
                              <th class="px-3 py-2 text-left font-semibold">No</th>
                              <th class="px-3 py-2 text-left font-semibold">Regional</th>
                              <th class="px-3 py-2 text-center font-semibold">Kehadiran</th>
                              <th class="px-3 py-2 text-center font-semibold">Sakit</th>
                              <th class="px-3 py-2 text-center font-semibold">Cuti</th>
                              <th class="px-3 py-2 text-center font-semibold">Libur</th>
                              <th class="px-3 py-2 text-center font-semibold">Mangkir</th>
                              <th class="px-3 py-2 text-center font-semibold">DLL</th>
                              <th class="px-3 py-2 text-center font-semibold">Belum Hadir</th>
                              <th class="px-3 py-2 text-center font-semibold">% Input</th>
                              <th class="px-3 py-2 text-center font-semibold">% Kehadiran</th>
                              <th class="px-3 py-2 text-center font-semibold">Total Karyawan</th>
                              </tr>
                            </thead>
                            <tbody>
                              @forelse($presensiData as $data)
                                <tr class="border-b border-slate-600 hover:bg-slate-600 transition-colors">
                                <td class="px-3 py-2 ">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2  font-medium">{{ $data->regional }}</td>
                                <td class="px-3 py-2  text-right">{{ number_format($data->kehadiran, 0, ',', '.') }}</td>
                                <td class="px-3 py-2  text-right">{{ number_format($data->sakit, 0, ',', '.') }}</td>
                                <td class="px-3 py-2  text-right">{{ number_format($data->cuti, 0, ',', '.') }}</td>
                                <td class="px-3 py-2  text-right">{{ number_format($data->libur, 0, ',', '.') }}</td>
                                <td class="px-3 py-2  text-right">{{ number_format($data->mangkir, 0, ',', '.') }}</td>
                                <td class="px-3 py-2  text-right">{{ number_format($data->dll, 0, ',', '.') }}</td>
                                <td class="px-3 py-2  text-right">{{ number_format($data->belum_hadir, 0, ',', '.') }}</td>
                                <td class="px-3 py-2  text-right font-semibold text-blue-300">{{ $data->prosentase }}%</td>
                                <td class="px-3 py-2  text-right font-semibold text-green-300">{{ $data->prosentase_kehadiran }}%</td>
                                <td class="px-3 py-2  text-right font-semibold">{{ number_format($data->total_pegawai, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                <td colspan="11" class="px-3 py-4 text-center text-gray-400">
                                Tidak ada data untuk ditampilkan
                                </td>
                                </tr>
                              @endforelse
                              <tr class="border-b border-slate-600 hover:bg-slate-600 transition-colors">
                              <td class="px-3 py-2 "></td>
                              <td class="px-3 py-2  font-medium">Total</td>
                              <td class="px-3 py-2  text-right">{{ number_format($totalData['kehadiran'], 0, ',', '.') }}</td>
                              <td class="px-3 py-2  text-right">{{ number_format($totalData['sakit'], 0, ',', '.') }}</td>
                              <td class="px-3 py-2  text-right">{{ number_format($totalData['cuti'], 0, ',', '.') }}</td>
                              <td class="px-3 py-2  text-right">{{ number_format($totalData['libur'], 0, ',', '.') }}</td>
                              <td class="px-3 py-2  text-right">{{ number_format($totalData['mangkir'], 0, ',', '.') }}</td>
                              <td class="px-3 py-2  text-right">{{ number_format($totalData['dll'], 0, ',', '.') }}</td>
                              <td class="px-3 py-2  text-right">{{ number_format($totalData['belum_hadir'], 0, ',', '.') }}</td>
                              <td class="px-3 py-2  text-right font-semibold text-blue-300">{{ $totalData['prosentase'] }}%</td>
                              <td class="px-3 py-2  text-right font-semibold text-green-300">{{ $totalData['prosentase_kehadiran'] }}%</td>
                              <td class="px-3 py-2  text-right font-semibold">{{ number_format($totalData['total_pegawai'], 0, ',', '.') }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    @endif
                    @if($selectedRegional !="" && $selectedKebun =="")
                      <!-- Detail Charts Section - By Kebun -->
                      <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm mb-6">
                        <h2 class="text-xs md:text-sm font-bold mb-4 text-center">Data Presensi Berdasarkan Kebun</h2>
                        <div class="overflow-x-auto">
                          <table class="w-full text-xs md:text-sm">
                            <thead>
                              <tr class="bg-slate-600 sticky top-0">
                              <th class="px-3 py-2 text-left font-semibold">No</th>
                              <th class="px-3 py-2 text-left font-semibold">Kebun</th>
                              <th class="px-3 py-2 text-center font-semibold">Kehadiran</th>
                              <th class="px-3 py-2 text-center font-semibold">Sakit</th>
                              <th class="px-3 py-2 text-center font-semibold">Cuti</th>
                              <th class="px-3 py-2 text-center font-semibold">Libur</th>
                              <th class="px-3 py-2 text-center font-semibold">Mangkir</th>
                              <th class="px-3 py-2 text-center font-semibold">DLL</th>
                              <th class="px-3 py-2 text-center font-semibold">Belum Hadir</th>
                              <th class="px-3 py-2 text-center font-semibold">% Input</th>
                              <th class="px-3 py-2 text-center font-semibold">% Kehadiran</th>
                              <th class="px-3 py-2 text-center font-semibold">Total Karyawan</th>
                              </tr>
                            </thead>
                            <tbody>
                              @forelse($presensiData as $data)
                                <tr class="border-b border-slate-600 hover:bg-slate-600 transition-colors">
                                <td class="px-3 py-2 ">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 font-medium">{{ $data->kebun }}</td>
                                <td class="px-3 py-2 text-right">{{ number_format($data->kehadiran, 0, ',', '.') }}</td>
                                <td class="px-3 py-2 text-right">{{ number_format($data->sakit, 0, ',', '.') }}</td>
                                <td class="px-3 py-2 text-right">{{ number_format($data->cuti, 0, ',', '.') }}</td>
                                <td class="px-3 py-2 text-right">{{ number_format($data->libur, 0, ',', '.') }}</td>
                                <td class="px-3 py-2 text-right">{{ number_format($data->mangkir, 0, ',', '.') }}</td>
                                <td class="px-3 py-2 text-right">{{ number_format($data->dll, 0, ',', '.') }}</td>
                                <td class="px-3 py-2 text-right">{{ number_format($data->belum_hadir, 0, ',', '.') }}</td>
                                <td class="px-3 py-2 text-right font-semibold text-blue-300">{{ $data->prosentase }}%</td>
                                <td class="px-3 py-2 text-right font-semibold text-green-300">{{ $data->prosentase_kehadiran }}%</td>
                                <td class="px-3 py-2 text-right font-semibold">{{ number_format($data->total_pegawai, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                <td colspan="11" class="px-3 py-4 text-center text-gray-400">
                                Tidak ada data untuk ditampilkan
                                </td>
                                </tr>
                              @endforelse
                              <tr class="border-b border-slate-600 hover:bg-slate-600 transition-colors">
                              <td class="px-3 py-2 "></td>
                              <td class="px-3 py-2  font-medium">Total</td>
                              <td class="px-3 py-2  text-right">{{ number_format($totalData['kehadiran'], 0, ',', '.') }}</td>
                              <td class="px-3 py-2  text-right">{{ number_format($totalData['sakit'], 0, ',', '.') }}</td>
                              <td class="px-3 py-2  text-right">{{ number_format($totalData['cuti'], 0, ',', '.') }}</td>
                              <td class="px-3 py-2  text-right">{{ number_format($totalData['libur'], 0, ',', '.') }}</td>
                              <td class="px-3 py-2  text-right">{{ number_format($totalData['mangkir'], 0, ',', '.') }}</td>
                              <td class="px-3 py-2  text-right">{{ number_format($totalData['dll'], 0, ',', '.') }}</td>
                              <td class="px-3 py-2  text-right">{{ number_format($totalData['belum_hadir'], 0, ',', '.') }}</td>
                              <td class="px-3 py-2  text-right font-semibold text-blue-300">{{ $totalData['prosentase'] }}%</td>
                              <td class="px-3 py-2  text-right font-semibold text-green-300">{{ $totalData['prosentase_kehadiran'] }}%</td>
                              <td class="px-3 py-2  text-right font-semibold">{{ number_format($totalData['total_pegawai'], 0, ',', '.') }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    @endif
                    @if($selectedRegional !="" && $selectedKebun !="")
                      <!-- Detail Charts Section - By Kebun -->
                      <!-- Detail Charts Section - By Kebun -->
                      <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm mb-6">
                        <h2 class="text-xs md:text-sm font-bold mb-4 text-center">Data Presensi Berdasarkan Afdeling</h2>
                        <div class="overflow-x-auto">
                          <table class="w-full text-xs md:text-sm">
                            <thead>
                              <tr class="bg-slate-600 sticky top-0">
                              <th class="px-3 py-2 text-left font-semibold">No</th>
                              <th class="px-3 py-2 text-left font-semibold">Kebun</th>
                              <th class="px-3 py-2 text-center font-semibold">Kehadiran</th>
                              <th class="px-3 py-2 text-center font-semibold">Sakit</th>
                              <th class="px-3 py-2 text-center font-semibold">Cuti</th>
                              <th class="px-3 py-2 text-center font-semibold">Libur</th>
                              <th class="px-3 py-2 text-center font-semibold">Mangkir</th>
                              <th class="px-3 py-2 text-center font-semibold">DLL</th>
                              <th class="px-3 py-2 text-center font-semibold">Belum Hadir</th>
                              <th class="px-3 py-2 text-center font-semibold">% Input</th>
                              <th class="px-3 py-2 text-center font-semibold">% Kehadiran</th>
                              <th class="px-3 py-2 text-center font-semibold">Total Karyawan</th>
                              </tr>
                            </thead>
                            <tbody>
                              @forelse($presensiData as $data)
                                <tr class="border-b border-slate-600 hover:bg-slate-600 transition-colors">
                                <td class="px-3 py-2 ">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 font-medium">{{ $data->afdeling }}</td>
                                <td class="px-3 py-2 text-right">{{ number_format($data->kehadiran, 0, ',', '.') }}</td>
                                <td class="px-3 py-2 text-right">{{ number_format($data->sakit, 0, ',', '.') }}</td>
                                <td class="px-3 py-2 text-right">{{ number_format($data->cuti, 0, ',', '.') }}</td>
                                <td class="px-3 py-2 text-right">{{ number_format($data->libur, 0, ',', '.') }}</td>
                                <td class="px-3 py-2 text-right">{{ number_format($data->mangkir, 0, ',', '.') }}</td>
                                <td class="px-3 py-2 text-right">{{ number_format($data->dll, 0, ',', '.') }}</td>
                                <td class="px-3 py-2 text-right">{{ number_format($data->belum_hadir, 0, ',', '.') }}</td>
                                <td class="px-3 py-2 text-right font-semibold text-blue-300">{{ $data->prosentase }}%</td>
                                <td class="px-3 py-2 text-right font-semibold text-green-300">{{ $data->prosentase_kehadiran }}%</td>
                                <td class="px-3 py-2 text-right font-semibold">{{ number_format($data->total_pegawai, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                <td colspan="11" class="px-3 py-4 text-center text-gray-400">
                                Tidak ada data untuk ditampilkan
                                </td>
                                </tr>
                              @endforelse
                              <tr class="border-b border-slate-600 hover:bg-slate-600 transition-colors">
                              <td class="px-3 py-2"></td>
                              <td class="px-3 py-2 font-medium">Total</td>
                              <td class="px-3 py-2 text-right">{{ number_format($totalData['kehadiran'], 0, ',', '.') }}</td>
                              <td class="px-3 py-2 text-right">{{ number_format($totalData['sakit'], 0, ',', '.') }}</td>
                              <td class="px-3 py-2 text-right">{{ number_format($totalData['cuti'], 0, ',', '.') }}</td>
                              <td class="px-3 py-2 text-right">{{ number_format($totalData['libur'], 0, ',', '.') }}</td>
                              <td class="px-3 py-2 text-right">{{ number_format($totalData['mangkir'], 0, ',', '.') }}</td>
                              <td class="px-3 py-2 text-right">{{ number_format($totalData['dll'], 0, ',', '.') }}</td>
                              <td class="px-3 py-2 text-right">{{ number_format($totalData['belum_hadir'], 0, ',', '.') }}</td>
                              <td class="px-3 py-2 text-right font-semibold text-blue-300">{{ $totalData['prosentase'] }}%</td>
                              <td class="px-3 py-2 text-right font-semibold text-green-300">{{ $totalData['prosentase_kehadiran'] }}%</td>
                              <td class="px-3 py-2 text-right font-semibold">{{ number_format($totalData['total_pegawai'], 0, ',', '.') }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    @endif
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

        // Chart Colors
        const chartColors = {
        blue: '#0EA5E9',
        cyan: '#06B6D4',
        red: '#EF4444',
        purple: '#8B5CF6',
        primary: '#1E40AF',
        gridColor: 'rgba(22, 101, 52, 0.08)',
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
        font: { size: 11, family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif" },
        padding: 12,
        usePointStyle: true,
        },
        },
        },
        scales: {
        x: {
        grid: { color: chartColors.gridColor, drawBorder: false },
        ticks: { color: chartColors.textColor, font: { size: 10 } },
        },
        y: {
        grid: { color: chartColors.gridColor, drawBorder: false },
        ticks: { color: chartColors.textColor, font: { size: 10 } },
        },
        },
        };

        // ============================================
        // INITIALIZE CHARTS - CONDITIONAL BY FILTER STATE
        // ============================================

        @if($selectedRegional =="")
          // 1. Presensi Chart (Stacked Bar - By Regional)
          const presensiCtx = document.getElementById('presensiChart');
          if (presensiCtx) {
          new Chart(presensiCtx, {
          type: 'bar',
          data: {
          labels: [
          @for ($i = 0; $i < count($presensiData); $i++)
          '{{ $presensiData[$i]->regional }}',
          @endfor
          ],
          datasets: [
          {
          label: '% Input Presensi',
          data: [
          @for ($i = 0; $i < count($presensiData); $i++)
          {{ $presensiData[$i]->prosentase }},
          @endfor
          ],
          backgroundColor: chartColors.blue,
          borderRadius: 6,
          borderSkipped: false,
          },
          {
          label: '% Belum Input Presensi',
          data: [
          @for ($i = 0; $i < count($presensiData); $i++)
          {{ 100 - $presensiData[$i]->prosentase }},
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
          }

          // 2. Presentase Hadir Chart (Stacked Bar - By Regional)
          const presentaseHadirCtx = document.getElementById('presentaseHadirChart');
          if (presentaseHadirCtx) {
          new Chart(presentaseHadirCtx, {
          type: 'bar',
          data: {
          labels: [
          @for ($i = 0; $i < count($presensiData); $i++)
          '{{ $presensiData[$i]->regional }}',
          @endfor
          ],
          datasets: [
          {
          label: '% Hadir',
          data: [
          @for ($i = 0; $i < count($presensiData); $i++)
          {{ $presensiData[$i]->prosentase_kehadiran }},
          @endfor
          ],
          backgroundColor: chartColors.blue,
          borderRadius: 6,
          borderSkipped: false,
          },
          {
          label: '% Tidak Hadir',
          data: [
          @for ($i = 0; $i < count($presensiData); $i++)
          {{ 100 - $presensiData[$i]->prosentase_kehadiran }},
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
          }

          // 3. Presentase Input Chart (Grouped Bar - By Regional)
          const presentaseInputCtx = document.getElementById('presentaseInputChart');
          if (presentaseInputCtx) {
          new Chart(presentaseInputCtx, {
          type: 'bar',
          data: {
          labels: [
          @for ($i = 0; $i < count($presensiData); $i++)
          '{{ $presensiData[$i]->regional }}',
          @endfor
          ],
          datasets: [
          {
          label: 'Jumlah Input Presensi',
          data: [
          @for ($i = 0; $i < count($presensiData); $i++)
          {{ $presensiData[$i]->total_pegawai - $presensiData[$i]->belum_hadir }},
          @endfor
          ],
          backgroundColor: chartColors.blue,
          borderRadius: 6,
          borderSkipped: false,
          },
          {
          label: 'Jumlah Karyawan',
          data: [
          @for ($i = 0; $i < count($presensiData); $i++)
          {{ $presensiData[$i]->total_pegawai }},
          @endfor
          ],
          backgroundColor: chartColors.cyan,
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
          }
        @endif

        // ============================================
        // DETAIL CHARTS BY KEBUN
        // ============================================

        @if($selectedRegional != "" && $selectedKebun == "")
          // 4. Presensi Detail Chart (Stacked Bar - By Kebun)
          const presensiDetailCtx = document.getElementById('presensiDetailChart');
          if (presensiDetailCtx) {
          new Chart(presensiDetailCtx, {
          type: 'bar',
          data: {
          labels: [
          @for ($i = 0; $i < count($presensiData); $i++)
          '{{ str_replace('KEBUN ', '', $presensiData[$i]->kebun) }}',
          @endfor
          ],
          datasets: [
          {
          label: '% Input Presensi',
          data: [
          @for ($i = 0; $i < count($presensiData); $i++)
          {{ $presensiData[$i]->prosentase }},
          @endfor
          ],
          backgroundColor: chartColors.blue,
          borderRadius: 6,
          borderSkipped: false,
          },
          {
          label: '% Belum Input Presensi',
          data: [
          @for ($i = 0; $i < count($presensiData); $i++)
          {{ 100 - $presensiData[$i]->prosentase }},
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
          ticks: { ...commonOptions.scales.x.ticks, font: { size: 9 } },
          },
          y: {
          ...commonOptions.scales.y,
          stacked: true,
          },
          },
          },
          });
          }

          // 5. Presentase Hadir Detail Chart (Stacked Bar - By Kebun)
          const presentaseHadirDetailCtx = document.getElementById('presentaseHadirDetailChart');
          if (presentaseHadirDetailCtx) {
          new Chart(presentaseHadirDetailCtx, {
          type: 'bar',
          data: {
          labels: [
          @for ($i = 0; $i < count($presensiData); $i++)
          '{{ str_replace('KEBUN ', '', $presensiData[$i]->kebun) }}',
          @endfor
          ],
          datasets: [
          {
          label: '% Hadir',
          data: [
          @for ($i = 0; $i < count($presensiData); $i++)
          {{ $presensiData[$i]->prosentase_kehadiran }},
          @endfor
          ],
          backgroundColor: chartColors.blue,
          borderRadius: 6,
          borderSkipped: false,
          },
          {
          label: '% Tidak Hadir',
          data: [
          @for ($i = 0; $i < count($presensiData); $i++)
          {{ 100 - $presensiData[$i]->prosentase_kehadiran }},
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
          ticks: { ...commonOptions.scales.x.ticks, font: { size: 9 } },
          },
          y: {
          ...commonOptions.scales.y,
          stacked: true,
          max: 100,
          },
          },
          },
          });
          }

          // 6. Presentase Input Detail Chart (Grouped Bar - By Kebun)
          const presentaseInputDetailCtx = document.getElementById('presentaseInputDetailChart');
          if (presentaseInputDetailCtx) {
          new Chart(presentaseInputDetailCtx, {
          type: 'bar',
          data: {
          labels: [
          @for ($i = 0; $i < count($presensiData); $i++)
          '{{ str_replace('KEBUN ', '', $presensiData[$i]->kebun) }}',
          @endfor
          ],
          datasets: [
          {
          label: 'Jumlah Input Presensi',
          data: [
          @for ($i = 0; $i < count($presensiData); $i++)
          {{ $presensiData[$i]->total_pegawai - $presensiData[$i]->belum_hadir }},
          @endfor
          ],
          backgroundColor: chartColors.blue,
          borderRadius: 6,
          borderSkipped: false,
          },
          {
          label: 'Jumlah Pemanen',
          data: [
          @for ($i = 0; $i < count($presensiData); $i++)
          {{ $presensiData[$i]->total_pegawai }},
          @endfor
          ],
          backgroundColor: chartColors.cyan,
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
          ticks: { ...commonOptions.scales.x.ticks, font: { size: 9 } },
          },
          y: {
          ...commonOptions.scales.y,
          stacked: false,
          },
          },
          },
          });
          }
        @endif

        @if($selectedRegional != "" && $selectedKebun != "")
          // 4. Presensi Detail Chart (Stacked Bar - By Afdeling)
          const presensiDetailCtx = document.getElementById('presensiDetailChart');
          if (presensiDetailCtx) {
          new Chart(presensiDetailCtx, {
          type: 'bar',
          data: {
          labels: [
          @for ($i = 0; $i < count($presensiData); $i++)
          '{{ str_replace('KEBUN ', '', $presensiData[$i]->afdeling) }}',
          @endfor
          ],
          datasets: [
          {
          label: '% Input Presensi',
          data: [
          @for ($i = 0; $i < count($presensiData); $i++)
          {{ $presensiData[$i]->prosentase }},
          @endfor
          ],
          backgroundColor: chartColors.blue,
          borderRadius: 6,
          borderSkipped: false,
          },
          {
          label: '% Belum Input Presensi',
          data: [
          @for ($i = 0; $i < count($presensiData); $i++)
          {{ 100 - $presensiData[$i]->prosentase }},
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
          ticks: { ...commonOptions.scales.x.ticks, font: { size: 9 } },
          },
          y: {
          ...commonOptions.scales.y,
          stacked: true,
          },
          },
          },
          });
          }

          // 5. Presentase Hadir Detail Chart (Stacked Bar - By Afdeling)
          const presentaseHadirDetailCtx = document.getElementById('presentaseHadirDetailChart');
          if (presentaseHadirDetailCtx) {
          new Chart(presentaseHadirDetailCtx, {
          type: 'bar',
          data: {
          labels: [
          @for ($i = 0; $i < count($presensiData); $i++)
          '{{ str_replace('KEBUN ', '', $presensiData[$i]->afdeling) }}',
          @endfor
          ],
          datasets: [
          {
          label: '% Hadir',
          data: [
          @for ($i = 0; $i < count($presensiData); $i++)
          {{ $presensiData[$i]->prosentase_kehadiran }},
          @endfor
          ],
          backgroundColor: chartColors.blue,
          borderRadius: 6,
          borderSkipped: false,
          },
          {
          label: '% Tidak Hadir',
          data: [
          @for ($i = 0; $i < count($presensiData); $i++)
          {{ 100 - $presensiData[$i]->prosentase_kehadiran }},
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
          ticks: { ...commonOptions.scales.x.ticks, font: { size: 9 } },
          },
          y: {
          ...commonOptions.scales.y,
          stacked: true,
          max: 100,
          },
          },
          },
          });
          }

          // 6. Presentase Input Detail Chart (Grouped Bar - By Afdeling)
          const presentaseInputDetailCtx = document.getElementById('presentaseInputDetailChart');
          if (presentaseInputDetailCtx) {
          new Chart(presentaseInputDetailCtx, {
          type: 'bar',
          data: {
          labels: [
          @for ($i = 0; $i < count($presensiData); $i++)
          '{{ str_replace('KEBUN ', '', $presensiData[$i]->afdeling) }}',
          @endfor
          ],
          datasets: [
          {
          label: 'Jumlah Input Presensi',
          data: [
          @for ($i = 0; $i < count($presensiData); $i++)
          {{ $presensiData[$i]->total_pegawai - $presensiData[$i]->belum_hadir }},
          @endfor
          ],
          backgroundColor: chartColors.blue,
          borderRadius: 6,
          borderSkipped: false,
          },
          {
          label: 'Jumlah Pemanen',
          data: [
          @for ($i = 0; $i < count($presensiData); $i++)
          {{ $presensiData[$i]->total_pegawai }},
          @endfor
          ],
          backgroundColor: chartColors.cyan,
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
          ticks: { ...commonOptions.scales.x.ticks, font: { size: 9 } },
          },
          y: {
          ...commonOptions.scales.y,
          stacked: false,
          },
          },
          },
          });
          }
        @endif


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
        const jobDescParam = urlParams.get('jobdesc');

        // Set date values dari parameter atau default dari controller
        datePickerStart.value = tglAwalParam || tglAwalDefault;
        datePickerEnd.value = tglAkhirParam || tglAkhirDefault;

        // Set select values dari parameter
        if (jobDescParam) document.getElementById('selectJobDesc').value = jobDescParam;
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
        const isClickInsideDatePicker = dateRangeInput.contains(e.target) || datePickerPopup.contains(e.target);
        if (!isClickInsideDatePicker && !datePickerPopup.classList.contains('hidden')) {
        datePickerPopup.classList.add('hidden');
        }
        });

        // Allow Enter key to apply
        document.addEventListener('keypress', (e) => {
        if (e.key === 'Enter' && !datePickerPopup.classList.contains('hidden')) {
        datePickerApply.click();
        }
        });

        // Tab handling
        document.querySelectorAll('.hris-tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
        const tab = btn.dataset.tab;

        // Update active button
        document.querySelectorAll('.hris-tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        // Update active panel
        document.querySelectorAll('.hris-tab-panel').forEach(panel => panel.classList.remove('active'));
        document.getElementById(`tab-${tab}`).classList.add('active');
        });
        });

        // Initialize table with presensi data
        function initializeTable() {
        const presensiData = @json($presensiData ?? []);
        const jobdesc = '{{ $jobdesc }}';
        const selectedRegional = '{{ $selectedRegional }}';
        const selectedKebun = '{{ $selectedKebun }}';

        const dataTbody = document.getElementById('detail-tbody');
        const tableTitle = document.getElementById('table-title');
        const dataCountBadge = document.getElementById('data-count-badge');

        // Update title
        let titleText = 'Data Presensi DFARM';
        if (jobdesc) titleText += ` - ${jobdesc}`;
        if (selectedRegional) titleText += ` - Regional ${selectedRegional}`;
        if (selectedKebun) titleText += ` - Kebun ${selectedKebun}`;
        tableTitle.textContent = titleText;

        // Group data by job desc
        const groupedData = {};
        presensiData.forEach(item => {
        const key = item.jobdesc || 'Unknown';
        if (!groupedData[key]) {
        groupedData[key] = [];
        }
        groupedData[key].push(item);
        });

        // Render table rows
        dataTbody.innerHTML = '';
        let index = 1;
        let totalRows = 0;

        Object.entries(groupedData).forEach(([jobdesc, items]) => {
        const totalHadir = items.reduce((sum, item) => sum + (item.total_pegawai - item.belum_hadir), 0);
        const totalPegawai = items.reduce((sum, item) => sum + item.total_pegawai, 0);
        const percentage = totalPegawai > 0 ? ((totalHadir / totalPegawai) * 100).toFixed(1) : 0;

        const tr = document.createElement('tr');
        tr.innerHTML = `
        <td style="text-align: center; font-weight: 700; color: #94a3b8;">${index}</td>
        <td style="text-align: left; font-weight: 600; color: #1f2937;">${jobdesc}</td>
        <td style="text-align: center; color: #4b5563;">${totalPegawai}</td>
        <td style="text-align: center; color: #4b5563;">${totalHadir}</td>
        <td style="text-align: center; color: #4b5563;"><strong>${percentage}%</strong></td>
        `;
        dataTbody.appendChild(tr);
        index++;
        totalRows++;
        });

        if (totalRows === 0) {
        dataTbody.innerHTML = '<tr class="loading-row"><td colspan="5">Tidak ada data presensi.</td></tr>';
        }

        dataCountBadge.textContent = `${totalRows} Job Desc`;
        }

        // Initialize on load
        window.addEventListener('load', initializeTable);

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
        const jobDesc = document.getElementById('selectJobDesc').value;
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
        if (jobDesc) params.push('jobdesc=' + jobDesc);
        if (idReg) params.push('id_reg=' + idReg);
        if (kodeKebun) params.push('kode_kebun=' + kodeKebun);

        url += params.join('&');

        // Reload halaman dengan parameter baru
        window.location.href = url;
        });

        // Reset Button Handler
        document.getElementById('btnReset').addEventListener('click', () => {
        // Clear semua filter
        document.getElementById('selectJobDesc').value = '';
        document.getElementById('selectRegional').value = '';
        document.getElementById('selectKebun').value = '';

        // Reset ke halaman tanpa parameter
        window.location.href = window.location.pathname;
        });

        
      </script>
      <script src="{{ asset('js/components/application-select-handler.js') }}"></script>

      @include('pages.dfarm.menu.menu-script')

    @endsection

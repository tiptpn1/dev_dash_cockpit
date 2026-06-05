
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
            @include('pages.dfarm.components.application-select', ['selected' => 'BPD'])
          </div>

          <!-- Table Card -->
          <div class="table-card">
            <div class="table-header">
              <div class="table-title">
                <i class="fas fa-table"></i>
                <span id="table-title">Pantauan Aplikasi BPD</span>
                <span id="regional-badge" class="regional-badge" style="display:none;"></span>
              </div>
              <span id="data-count-badge" class="table-count">BPD PTPN I</span>
            </div>

            <div id="tabs-wrap" style="display: block;">

              <!-- Tab Navigation Buttons -->
              <div class="hris-tabs">
                <button class="hris-tab-btn active" data-tab="tab-pantauan-dinas">
                  <i class="fas fa-chart-pie" style="margin-right: 6px;"></i> Pantauan Dinas
                </button>
                <button class="hris-tab-btn" data-tab="tab-pantauan-biaya">
                  <i class="fas fa-dollar-sign" style="margin-right: 6px;"></i> Pantauan Biaya
                </button>
                <button class="hris-tab-btn" data-tab="tab-detail-dinas">
                  <i class="fas fa-info-circle" style="margin-right: 6px;"></i> Detail Dinas
                </button>
              </div>

              <div id="error-banner" class="error-banner" style="display: none;"></div>

              <!-- Tab 1: Pantauan Dinas -->
              <div id="tab-pantauan-dinas" class="hris-tab-panel active">
                  <!-- Filter Card in Tab -->
                  <div class="filter-card" style="margin: 16px;">
                    <div class="filter-title">
                      <i class="fas fa-sliders-h"></i> Filter Parameter
                    </div>
                    <div class="filter-grid">
                      <div class="form-group">
                        <label class="form-label">Periode</label>
                        <div style="position: relative;">
                          <input type="text" id="dateRange" placeholder="2026-05-01 s/d 2026-06-02" readonly class="form-input" style="cursor: pointer; width: 100%;">
                          <div id="datePickerPopup" class="hidden" style="position: absolute; top: 100%; left: 0; margin-top: 8px; background: white; border: 1px solid #d1d5db; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); padding: 16px; z-index: 50; min-width: 340px;">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                              <div>
                                <label class="form-label" style="color: #374151; display: block; margin-bottom: 6px;">Tanggal Awal</label>
                                <input type="date" id="datePickerStart" class="form-input" style="width: 100%;">
                              </div>
                              <div>
                                <label class="form-label" style="color: #374151; display: block; margin-bottom: 6px;">Tanggal Akhir</label>
                                <input type="date" id="datePickerEnd" class="form-input" style="width: 100%;">
                              </div>
                            </div>
                            <div style="display: flex; gap: 8px; margin-top: 12px;">
                              <button id="datePickerApply" class="flex-1 px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs rounded transition-colors font-medium" style="background-color: #166534; border: none; cursor: pointer; flex: 1; padding: 8px 12px;">Terapkan</button>
                              <button id="datePickerCancel" class="flex-1 px-3 py-2 bg-gray-400 hover:bg-gray-500 text-white text-xs rounded transition-colors font-medium" style="background-color: #9ca3af; border: none; cursor: pointer; flex: 1; padding: 8px 12px;">Batal</button>
                            </div>
                          </div>
                        </div>
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

                  <!-- Data Bidang Section -->
                  <div style="padding: 0 16px 16px;">
                    <h2 style="font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                      <i class="fas fa-table"></i> Data Laporan SPPD dan BPD per Bidang
                    </h2>
                      
                      <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                        <div class="table-wrapper">
                          <table class="report-table" style="width: 100%; border-collapse: collapse; font-size: 12.5px; color: #1f2937;">
                            <thead>
                              <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                                <th style="padding: 10px 16px; text-align: center; font-weight: 700; color: #e5e7eb; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; width: 50px;">No</th>
                                <th style="padding: 10px 16px; text-align: left; font-weight: 700; color: #e5e7eb; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Nama Bagian</th>
                                <th style="padding: 10px 16px; text-align: center; font-weight: 700; color: #e5e7eb; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">SPPD Draft</th>
                                <th style="padding: 10px 16px; text-align: center; font-weight: 700; color: #e5e7eb; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">SPPD Pengajuan</th>
                                <th style="padding: 10px 16px; text-align: center; font-weight: 700; color: #e5e7eb; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">SPPD Disetujui</th>
                                <th style="padding: 10px 16px; text-align: center; font-weight: 700; color: #e5e7eb; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">SPPD Revisi</th>
                                <th style="padding: 10px 16px; text-align: center; font-weight: 700; color: #e5e7eb; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">BPD Draft</th>
                                <th style="padding: 10px 16px; text-align: center; font-weight: 700; color: #e5e7eb; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">BPD Pengajuan</th>
                                <th style="padding: 10px 16px; text-align: center; font-weight: 700; color: #e5e7eb; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">BPD Disetujui</th>
                                <th style="padding: 10px 16px; text-align: center; font-weight: 700; color: #e5e7eb; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">BPD Revisi</th>
                              </tr>
                            </thead>
                            <tbody id="detailKebunTableBody">
                              @forelse($bidangData as $key => $item)
                                <tr style="border-bottom: 1px solid #e5e7eb; hover:background-color: #f9fafb;">
                                  <td style="padding: 10px 16px; text-align: center; color: #374151;">{{ $key + 1 }}</td>
                                  <td style="padding: 10px 16px; text-align: left; color: #374151;">{{ $item->nama_bidang }}</td>
                                  <td style="padding: 10px 16px; text-align: center; color: #374151;">{{ $item->sppd_draft }}</td>
                                  <td style="padding: 10px 16px; text-align: center; color: #374151;">{{ $item->sppd_pengajuan }}</td>
                                  <td style="padding: 10px 16px; text-align: center; color: #374151;">{{ $item->sppd_disetujui }}</td>
                                  <td style="padding: 10px 16px; text-align: center; color: #374151;">{{ $item->sppd_revisi }}</td>
                                  <td style="padding: 10px 16px; text-align: center; color: #374151;">{{ $item->bpd_draft }}</td>
                                  <td style="padding: 10px 16px; text-align: center; color: #374151;">{{ $item->bpd_pengajuan }}</td>
                                  <td style="padding: 10px 16px; text-align: center; color: #374151;">{{ $item->bpd_disetujui }}</td>
                                  <td style="padding: 10px 16px; text-align: center; color: #374151;">{{ $item->bpd_revisi }}</td>
                                </tr>
                              @empty
                                <tr>
                                  <td colspan="10" style="padding: 32px 16px; text-align: center; color: #9ca3af;">
                                    <i class="fas fa-database" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
                                    Tidak ada data bidang
                                  </td>
                                </tr>
                              @endforelse
                            </tbody>
                          </table>
                        </div>
                      </div>
                  </div>



                </div>

                <!-- Tab 2: Pantauan Biaya -->
                <div id="tab-pantauan-biaya" class="hris-tab-panel">
                  <!-- Filter Card in Tab -->
                  <div class="filter-card" style="margin: 16px;">
                    <div class="filter-title">
                      <i class="fas fa-sliders-h"></i> Filter Parameter
                    </div>
                    <div class="filter-grid">
                      <div class="form-group">
                        <label class="form-label">Periode</label>
                        <div style="position: relative;">
                          <input type="text" id="dateRangeBiaya" placeholder="2026-05-01 s/d 2026-06-02" readonly class="form-input" style="cursor: pointer; width: 100%;">
                          <div id="datePickerPopupBiaya" class="hidden" style="position: absolute; top: 100%; left: 0; background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; z-index: 1000; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); min-width: 300px; margin-top: 4px;">
                            <div style="display: flex; gap: 8px; margin-bottom: 12px;">
                              <input type="date" id="datePickerStartBiaya" style="flex: 1; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 14px;">
                              <span style="display: flex; align-items: center; color: #6b7280;">s/d</span>
                              <input type="date" id="datePickerEndBiaya" style="flex: 1; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 14px;">
                            </div>
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                              <button id="datePickerApplyBiaya" style="padding: 8px 16px; background: #10b981; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">Terapkan</button>
                              <button id="datePickerCancelBiaya" style="padding: 8px 16px; background: #6b7280; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">Batal</button>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="form-label">Bidang</label>
                        <select id="selectBidangBiaya" class="form-select">
                          <option value="" selected>Semua Bidang</option>
                          @foreach($db_bidang as $bidang)
                            <option value="{{ $bidang->id }}">{{ $bidang->nama_bidang }}</option>
                          @endforeach
                        </select>
                      </div>          
                    </div>
                  </div>

                  <!-- Action Buttons in Tab -->
                  <div style="margin: 0 16px 16px; display: flex; gap: 10px;">
                    <button id="btnFilterBiaya" class="inline-flex align-items-center justify-content-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-lg transition-all box-shadow" style="background-color: #16a34a; border: 1px solid #15803d; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); height: 36px;">
                    <i class="fas fa-filter"></i> Filter
                    </button>
                    <button id="btnResetBiaya" class="inline-flex align-items-center justify-content-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-lg transition-all box-shadow" style="background-color: #16a34a; border: 1px solid #15803d; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); height: 36px;">
                    <i class="fas fa-rotate-right"></i> Reset
                    </button>
                  </div>

                  <!-- Chart Container - Total Biaya Only -->
                  <div style="padding: 0 16px 16px;">
                    <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 24px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                      <h2 style="font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-chart-bar"></i> Chart Total Biaya per Bidang Periode <span id="chartTotalBiayaPeriode"></span>
                      </h2>
                      <div style="position: relative; height: 400px;">
                        <canvas id="chartTotalBiayaBidang"></canvas>
                      </div>
                    </div>
                  </div>

                  <!-- Chart Container - Anggaran & Total Biaya -->
                  <div style="padding: 0 16px 16px;">
                    <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 24px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                      <h2 style="font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-chart-bar"></i> Chart Anggaran & Biaya per Bidang Tahun {{ date('Y') }}
                      </h2>
                      <div style="position: relative; height: 400px;">
                        <canvas id="chartBiayaBidang"></canvas>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Tab 3: Detail Dinas -->
                <div id="tab-detail-dinas" class="hris-tab-panel">
                  <!-- Filter Card in Tab -->
                  <div class="filter-card" style="margin: 16px;">
                    <div class="filter-title">
                      <i class="fas fa-sliders-h"></i> Filter Parameter
                    </div>
                    <div class="filter-grid">
                      <div class="form-group">
                        <label class="form-label">Periode</label>
                        <div style="position: relative;">
                          <input type="text" id="dateRangeDetail" placeholder="2026-05-01 s/d 2026-06-02" readonly class="form-input" style="cursor: pointer; width: 100%;">
                          <div id="datePickerPopupDetail" class="hidden" style="position: absolute; top: 100%; left: 0; background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; z-index: 1000; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); min-width: 300px; margin-top: 4px;">
                            <div style="display: flex; gap: 8px; margin-bottom: 12px;">
                              <input type="date" id="datePickerStartDetail" style="flex: 1; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 14px;">
                              <span style="display: flex; align-items: center; color: #6b7280;">s/d</span>
                              <input type="date" id="datePickerEndDetail" style="flex: 1; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 14px;">
                            </div>
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                              <button id="datePickerApplyDetail" style="padding: 8px 16px; background: #10b981; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">Terapkan</button>
                              <button id="datePickerCancelDetail" style="padding: 8px 16px; background: #6b7280; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">Batal</button>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="form-label">Bidang</label>
                        <select id="selectBidangBiayaBPD" class="form-select">
                          <option value="" selected>Semua Bidang</option>
                          @foreach($db_bidang as $bidang)
                            <option value="{{ $bidang->id }}">{{ $bidang->nama_bidang }}</option>
                          @endforeach
                        </select>
                      </div> 
                      <div class="form-group">
                        <label class="form-label">Nama Pegawai / Nomor BPD</label>
                        <div style="position: relative;">
                          <input type="text" id="inputNama" placeholder="" class="form-input" style= width: 100%;">
                        </div>
                      </div>   
                      <div class="form-group">
                        <label class="form-label">Keperluan / Tujuan / Lokasi Kota</label>
                        <div style="position: relative;">
                          <input type="text" id="keperluan" placeholder="" class="form-input" style= width: 100%;">
                        </div>
                      </div> 
                    </div>
                  </div>

                  <!-- Action Buttons in Tab -->
                  <div style="margin: 0 16px 16px; display: flex; gap: 10px;">
                    <button id="btnFilterDetail" class="inline-flex align-items-center justify-content-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-lg transition-all box-shadow" style="background-color: #16a34a; border: 1px solid #15803d; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); height: 36px;">
                    <i class="fas fa-filter"></i> Filter
                    </button>
                    <button id="btnResetDetail" class="inline-flex align-items-center justify-content-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-lg transition-all box-shadow" style="background-color: #16a34a; border: 1px solid #15803d; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); height: 36px;">
                    <i class="fas fa-rotate-right"></i> Reset
                    </button>
                  </div>

                  <!-- Content for Detail Dinas -->
                  <div style="padding: 0 16px 16px;">
                    <h2 style="font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                      <i class="fas fa-list-ul"></i> Detail Data Dinas
                    </h2>
                    
                    <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                      <div class="table-wrapper">
                        <table class="report-table" style="width: 100%; border-collapse: collapse; font-size: 12.5px; color: #1f2937;">
                          <thead>
                            <tr style="background: #15803d; border-bottom: 1px solid #e5e7eb;">
                              <th style="padding: 10px 12px; text-align: center; font-weight: 700; color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">No</th>
                              <th style="padding: 10px 12px; text-align: left; font-weight: 700; color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Nama Pegawai</th>
                              <th style="padding: 10px 12px; text-align: left; font-weight: 700; color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Nama Bidang</th>
                              <th style="padding: 10px 12px; text-align: center; font-weight: 700; color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Tgl Berangkat</th>
                              <th style="padding: 10px 12px; text-align: center; font-weight: 700; color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Tgl Kembali</th>
                              <th style="padding: 10px 12px; text-align: left; font-weight: 700; color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Jenis Tujuan</th>
                              <th style="padding: 10px 12px; text-align: left; font-weight: 700; color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Keperluan</th>
                              <th style="padding: 10px 12px; text-align: left; font-weight: 700; color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Tujuan</th>
                              <th style="padding: 10px 12px; text-align: left; font-weight: 700; color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Lokasi Kota</th>
                              <th style="padding: 10px 12px; text-align: left; font-weight: 700; color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Nama Rombongan</th>
                              <th style="padding: 10px 12px; text-align: right; font-weight: 700; color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Biaya Dinas</th>
                              <th style="padding: 10px 12px; text-align: right; font-weight: 700; color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Biaya Reimbursement</th>
                              <th style="padding: 10px 12px; text-align: right; font-weight: 700; color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Biaya Akomodasi</th>
                            </tr>
                          </thead>
                          <tbody id="detailDinasTableBody">
                            <!-- Data will be populated by JavaScript -->
                          </tbody>
                        </table>
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
        // Initialize page - no API calls needed, data is from database

        // 1. Presensi Chart (Stacked Bar - By Regional)
        const presensiCtx = document.getElementById('presensiChart');
        if (presensiCtx) {
          new Chart(presensiCtx, {
            type: 'bar',
            data: {
              labels: ['Regional 2', 'Regional 3', 'Regional 5', 'Regional 7', 'Regional 8'],
              datasets: [
                {
                  label: '% Input Presensi',
                  data: [85, 90, 78, 88, 82],
                  backgroundColor: chartColors.blue,
                  borderRadius: 6,
                  borderSkipped: false,
                },
                {
                  label: '% Belum Input Presensi',
                  data: [15, 10, 22, 12, 18],
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
              labels: ['Regional 2', 'Regional 3', 'Regional 5', 'Regional 7', 'Regional 8'],
              datasets: [
                {
                  label: '% Hadir',
                  data: [87, 92, 80, 90, 85],
                  backgroundColor: chartColors.blue,
                  borderRadius: 6,
                  borderSkipped: false,
                },
                {
                  label: '% Tidak Hadir',
                  data: [13, 8, 20, 10, 15],
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
              labels: ['Regional 2', 'Regional 3', 'Regional 5', 'Regional 7', 'Regional 8'],
              datasets: [
                {
                  label: 'Jumlah Input Presensi',
                  data: [250, 180, 220, 195, 160],
                  backgroundColor: chartColors.blue,
                  borderRadius: 6,
                  borderSkipped: false,
                },
                {
                  label: 'Jumlah Karyawan',
                  data: [280, 200, 280, 220, 195],
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

        // ============================================
        // DETAIL CHARTS BY KEBUN
        // ============================================
        // Detail charts disabled - will be enabled when controller provides data
        // Charts: Presensi Detail, Presentase Hadir Detail, Presentase Input Detail
        // These require $presensiData array from the controller

        // ============================================
        // TAB SWITCHING FUNCTIONALITY
        // ============================================
        document.querySelectorAll('.hris-tab-btn').forEach(button => {
          button.addEventListener('click', () => {
            const tabName = button.getAttribute('data-tab');
            
            // Remove active class from all buttons
            document.querySelectorAll('.hris-tab-btn').forEach(btn => {
              btn.classList.remove('active');
            });
            
            // Remove active class from all panels
            document.querySelectorAll('.hris-tab-panel').forEach(panel => {
              panel.classList.remove('active');
            });
            
            // Add active class to clicked button
            button.classList.add('active');
            
            // Add active class to corresponding panel
            const panel = document.getElementById(tabName);
            if (panel) {
              panel.classList.add('active');
            }
          });
        });

      </script>

      <!-- Date Range Picker Script -->
      <script>
        // Format tanggal ke "YYYY-MM-DD" format
        function formatDate(dateStr) {
          if (!dateStr) return '';
          const date = new Date(dateStr);
          const year = date.getFullYear();
          const month = String(date.getMonth() + 1).padStart(2, '0');
          const day = String(date.getDate()).padStart(2, '0');
          return `${year}-${month}-${day}`;
        }

        // Wait for DOM to be ready
        document.addEventListener('DOMContentLoaded', () => {
          // Date Range Picker Elements (Tab 1 - Pantauan Dinas)
          const dateRangeInput = document.getElementById('dateRange');
          const datePickerPopup = document.getElementById('datePickerPopup');
          const datePickerStart = document.getElementById('datePickerStart');
          const datePickerEnd = document.getElementById('datePickerEnd');
          const datePickerApply = document.getElementById('datePickerApply');
          const datePickerCancel = document.getElementById('datePickerCancel');
          const selectRegional = document.getElementById('selectRegional');
          const btnFilter = document.getElementById('btnFilter');
          const btnReset = document.getElementById('btnReset');

          // Check if elements exist before proceeding
          if (!dateRangeInput || !datePickerStart || !datePickerEnd) {
            console.warn('Date picker elements not found');
            return;
          }

          // Set default dates (current date and 1 month earlier)
          const today = new Date();
          const oneMonthAgo = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
          
          datePickerStart.value = formatDate(oneMonthAgo.toISOString().split('T')[0]);
          datePickerEnd.value = formatDate(today.toISOString().split('T')[0]);
          
          // Set default regional to 2
          if (selectRegional) {
            selectRegional.value = '2';
          }

          // Update display
          function updateDateDisplay() {
            if (datePickerStart.value && datePickerEnd.value) {
              dateRangeInput.value = `${datePickerStart.value} s/d ${datePickerEnd.value}`;
            }
          }
          updateDateDisplay();

          // Toggle popup
          dateRangeInput.addEventListener('click', () => {
            datePickerPopup.classList.toggle('hidden');
          });

          // Apply button
          if (datePickerApply) {
            datePickerApply.addEventListener('click', () => {
              if (datePickerStart.value && datePickerEnd.value) {
                if (new Date(datePickerStart.value) <= new Date(datePickerEnd.value)) {
                  updateDateDisplay();
                  datePickerPopup.classList.add('hidden');
                  console.log('Periode terpilih:', datePickerStart.value, 's/d', datePickerEnd.value);
                } else {
                  alert('Tanggal awal harus lebih kecil dari tanggal akhir');
                }
              } else {
                alert('Silakan isi kedua tanggal');
              }
            });
          }

          // Cancel button
          if (datePickerCancel) {
            datePickerCancel.addEventListener('click', () => {
              datePickerPopup.classList.add('hidden');
            });
          }

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
              if (datePickerApply) datePickerApply.click();
            }
          });

          // Filter Button Handler - AJAX to /api/bpd/bidang-status
          if (btnFilter) {
            btnFilter.addEventListener('click', () => {
              const tglAwal = datePickerStart.value;
              const tglAkhir = datePickerEnd.value;

              // Validate dates
              if (!tglAwal || !tglAkhir) {
                const errorPopup = document.getElementById('errorPopup');
                const errorMessage = document.getElementById('errorMessage');
                if (errorPopup && errorMessage) {
                  errorMessage.textContent = 'Silakan pilih tanggal awal dan akhir terlebih dahulu';
                  errorPopup.classList.remove('hidden');
                }
                return;
              }

              // Show loading state
              btnFilter.disabled = true;
              btnFilter.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';

              // Make AJAX call
              fetch(`/api/bpd/bidang-status?tgl_awal=${tglAwal}&tgl_akhir=${tglAkhir}`)
                .then(response => response.json())
                .then(data => {
                  if (data.success) {
                    const tableBody = document.getElementById('detailKebunTableBody');
                    if (!tableBody) {
                      console.error('Table body not found');
                      return;
                    }

                    // Clear existing rows
                    tableBody.innerHTML = '';

                    // Populate table with new data
                    if (data.data && data.data.length > 0) {
                      data.data.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.style.borderBottom = '1px solid #e5e7eb';
                        row.innerHTML = `
                          <td style="padding: 10px 16px; text-align: center; color: #374151;">${index + 1}</td>
                          <td style="padding: 10px 16px; text-align: left; color: #374151;">${item.nama_bidang}</td>
                          <td style="padding: 10px 16px; text-align: center; color: #374151;">${item.sppd_draft}</td>
                          <td style="padding: 10px 16px; text-align: center; color: #374151;">${item.sppd_pengajuan}</td>
                          <td style="padding: 10px 16px; text-align: center; color: #374151;">${item.sppd_disetujui}</td>
                          <td style="padding: 10px 16px; text-align: center; color: #374151;">${item.sppd_revisi}</td>
                          <td style="padding: 10px 16px; text-align: center; color: #374151;">${item.bpd_draft}</td>
                          <td style="padding: 10px 16px; text-align: center; color: #374151;">${item.bpd_pengajuan}</td>
                          <td style="padding: 10px 16px; text-align: center; color: #374151;">${item.bpd_disetujui}</td>
                          <td style="padding: 10px 16px; text-align: center; color: #374151;">${item.bpd_revisi}</td>
                        `;
                        tableBody.appendChild(row);
                      });
                    } else {
                      const emptyRow = document.createElement('tr');
                      emptyRow.innerHTML = `
                        <td colspan="10" style="padding: 32px 16px; text-align: center; color: #9ca3af;">
                          <i class="fas fa-database" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
                          Tidak ada data bidang
                        </td>
                      `;
                      tableBody.appendChild(emptyRow);
                    }
                  } else {
                    const errorPopup = document.getElementById('errorPopup');
                    const errorMessage = document.getElementById('errorMessage');
                    if (errorPopup && errorMessage) {
                      errorMessage.textContent = data.message || 'Terjadi kesalahan saat mengambil data';
                      errorPopup.classList.remove('hidden');
                    }
                  }
                })
                .catch(error => {
                  console.error('Error:', error);
                  const errorPopup = document.getElementById('errorPopup');
                  const errorMessage = document.getElementById('errorMessage');
                  if (errorPopup && errorMessage) {
                    errorMessage.textContent = 'Terjadi kesalahan: ' + error.message;
                    errorPopup.classList.remove('hidden');
                  }
                })
                .finally(() => {
                  btnFilter.disabled = false;
                  btnFilter.innerHTML = '<i class="fas fa-filter"></i> Filter';
                });
            });
          }

          // Reset Button Handler
          if (btnReset) {
            btnReset.addEventListener('click', () => {
              const today = new Date();
              const oneMonthAgo = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
              datePickerStart.value = formatDate(oneMonthAgo.toISOString().split('T')[0]);
              datePickerEnd.value = formatDate(today.toISOString().split('T')[0]);
              updateDateDisplay();
            });
          }

          // ===== PANTAUAN BIAYA - Chart Initialization =====
          const dateRangeBiaya = document.getElementById('dateRangeBiaya');
          const datePickerPopupBiaya = document.getElementById('datePickerPopupBiaya');
          const datePickerStartBiaya = document.getElementById('datePickerStartBiaya');
          const datePickerEndBiaya = document.getElementById('datePickerEndBiaya');
          const datePickerApplyBiaya = document.getElementById('datePickerApplyBiaya');
          const datePickerCancelBiaya = document.getElementById('datePickerCancelBiaya');
          const selectBidangBiaya = document.getElementById('selectBidangBiaya');
          const btnFilterBiaya = document.getElementById('btnFilterBiaya');
          const btnResetBiaya = document.getElementById('btnResetBiaya');
          const chartCanvasTotalBiaya = document.getElementById('chartTotalBiayaBidang');
          const chartCanvas = document.getElementById('chartBiayaBidang');

          let totalBiayaChart = null;
          let biayaChart = null;
          const colors = ['#0EA5E9', '#06B6D4', '#8B5CF6', '#EC4899', '#F59E0B', '#10B981', '#EF4444', '#F97316', '#A855F7', '#06B6D4'];

          // Initialize date picker for Biaya tab
          if (dateRangeBiaya && datePickerStartBiaya && datePickerEndBiaya) {
            const today = new Date();
            const oneMonthAgo = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
            datePickerStartBiaya.value = formatDate(oneMonthAgo.toISOString().split('T')[0]);
            datePickerEndBiaya.value = formatDate(today.toISOString().split('T')[0]);
            dateRangeBiaya.value = `${datePickerStartBiaya.value} s/d ${datePickerEndBiaya.value}`;
          }

          // Format currency helper
          function formatCurrency(value) {
            return new Intl.NumberFormat('id-ID', {
              style: 'currency',
              currency: 'IDR',
              minimumFractionDigits: 0,
              maximumFractionDigits: 0
            }).format(value);
          }

          // Fetch and render total biaya chart (range tanggal dipilih)
          function loadBiayaTotalChart() {
            const tglAwal = datePickerStartBiaya.value;
            const tglAkhir = datePickerEndBiaya.value;
            const bidangId = selectBidangBiaya ? selectBidangBiaya.value : '';

            if (!tglAwal || !tglAkhir) {
              console.warn('Tanggal tidak lengkap');
              return;
            }

            // Update chart title with period
            const chartTotalBiayaPeriode = document.getElementById('chartTotalBiayaPeriode');
            if (chartTotalBiayaPeriode) {
              chartTotalBiayaPeriode.textContent = `${tglAwal} s/d ${tglAkhir}`;
            }

            let url = `/api/bpd/biaya-anggaran?tgl_awal=${tglAwal}&tgl_akhir=${tglAkhir}`;
            if (bidangId) {
              url += `&bidang_id=${bidangId}`;
            }

            fetch(url)
              .then(response => response.json())
              .then(data => {
                if (data.success && data.data && data.data.length > 0) {
                  const labels = data.data.map(item => item.bidang);
                  const biayaValues = data.data.map(item => parseFloat(item.total_biaya) || 0);

                  const ctx = chartCanvasTotalBiaya.getContext('2d');

                  if (totalBiayaChart) {
                    totalBiayaChart.destroy();
                  }

                  totalBiayaChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                      labels: labels,
                      datasets: [
                        {
                          label: 'Total Biaya',
                          data: biayaValues,
                          backgroundColor: '#0EA5E9',
                          borderColor: '#0EA5E9',
                          borderWidth: 1
                        }
                      ]
                    },
                    options: {
                      responsive: true,
                      maintainAspectRatio: false,
                      plugins: {
                        legend: {
                          display: true,
                          position: 'bottom',
                          labels: {
                            font: {
                              size: 12,
                              weight: 'bold'
                            },
                            padding: 15
                          }
                        },
                        tooltip: {
                          callbacks: {
                            label: function(context) {
                              return context.dataset.label + ': ' + formatCurrency(context.raw);
                            }
                          }
                        }
                      },
                      scales: {
                        x: {
                          beginAtZero: true,
                          title: {
                            display: true,
                            text: 'Bidang'
                          },
                          ticks: {
                            font: {
                              size: 11
                            }
                          }
                        },
                        y: {
                          beginAtZero: true,
                          title: {
                            display: true,
                            text: 'Nominal (IDR)'
                          },
                          ticks: {
                            callback: function(value) {
                              if (value >= 1000000000) {
                                return (value / 1000000000).toFixed(1) + 'M';
                              } else if (value >= 1000000) {
                                return (value / 1000000).toFixed(1) + 'K';
                              }
                              return value;
                            },
                            font: {
                              size: 10
                            }
                          }
                        }
                      }
                    }
                  });
                } else {
                  console.warn('Tidak ada data biaya');
                  if (totalBiayaChart) {
                    totalBiayaChart.destroy();
                    totalBiayaChart = null;
                  }
                }
              })
              .catch(error => {
                console.error('Error loading chart:', error);
              });
          }

          // Fetch and render biaya chart
          function loadBiayaChart() {
            const dateSelected = datePickerStartBiaya.value;
            const bidangId = selectBidangBiaya ? selectBidangBiaya.value : '';

            if (!dateSelected) {
              console.warn('Tanggal tidak lengkap');
              return;
            }

            // Extract year from selected date and set full year range (Jan 1 - Dec 31)
            const yearSelected = dateSelected.split('-')[0];
            const tglAwal = `${yearSelected}-01-01`;
            const tglAkhir = `${yearSelected}-12-31`;

            btnFilterBiaya.disabled = true;
            btnFilterBiaya.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';

            let url = `/api/bpd/biaya-anggaran?tgl_awal=${tglAwal}&tgl_akhir=${tglAkhir}`;
            if (bidangId) {
              url += `&bidang_id=${bidangId}`;
            }

            fetch(url)
              .then(response => response.json())
              .then(data => {
                if (data.success && data.data && data.data.length > 0) {
                  const labels = data.data.map(item => item.bidang);
                  const biayaValues = data.data.map(item => parseFloat(item.total_biaya) || 0);
                  const anggaranValues = data.data.map(item => parseFloat(item.anggaran) || 0);
                  const sisaAnggaranValues = data.data.map(item => parseFloat(item.sisa_anggaran) || 0);

                  const ctx = chartCanvas.getContext('2d');

                  if (biayaChart) {
                    biayaChart.destroy();
                  }

                  biayaChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                      labels: labels,
                      datasets: [
                        {
                          label: 'Total Biaya',
                          data: biayaValues,
                          backgroundColor: '#0EA5E9',
                          borderColor: '#0EA5E9',
                          borderWidth: 1
                        },
                        {
                          label: 'Anggaran',
                          data: anggaranValues,
                          backgroundColor: '#10B981',
                          borderColor: '#10B981',
                          borderWidth: 1
                        },
                        {
                          label: 'Sisa Anggaran',
                          data: sisaAnggaranValues,
                          backgroundColor: '#EC4899',
                          borderColor: '#EC4899',
                          borderWidth: 1
                        }
                      ]
                    },
                    options: {
                      responsive: true,
                      maintainAspectRatio: false,
                      plugins: {
                        legend: {
                          display: true,
                          position: 'bottom',
                          labels: {
                            font: {
                              size: 12,
                              weight: 'bold'
                            },
                            padding: 15
                          }
                        },
                        tooltip: {
                          callbacks: {
                            label: function(context) {
                              return context.dataset.label + ': ' + formatCurrency(context.raw);
                            }
                          }
                        },
                        title: {
                          display: true,
                          text: 'Chart Anggaran & Total Biaya',
                          font: {
                            size: 16,
                            weight: 'bold'
                          }
                        }
                      },
                      scales: {
                        x: {
                          stacked: false,
                          title: {
                            display: true,
                            text: 'Bidang'
                          },
                          ticks: {
                            font: {
                              size: 11
                            }
                          }
                        },
                        y: {
                          stacked: false,
                          beginAtZero: true,
                          title: {
                            display: true,
                            text: 'Nominal (IDR)'
                          },
                          ticks: {
                            callback: function(value) {
                              if (value >= 1000000000) {
                                return (value / 1000000000).toFixed(1) + 'M';
                              } else if (value >= 1000000) {
                                return (value / 1000000).toFixed(1) + 'K';
                              }
                              return value;
                            },
                            font: {
                              size: 10
                            }
                          }
                        }
                      }
                    }
                  });
                } else {
                  console.warn('Tidak ada data biaya');
                  if (biayaChart) {
                    biayaChart.destroy();
                    biayaChart = null;
                  }
                }
              })
              .catch(error => {
                console.error('Error loading chart:', error);
              })
              .finally(() => {
                btnFilterBiaya.disabled = false;
                btnFilterBiaya.innerHTML = '<i class="fas fa-filter"></i> Filter';
              });
          }

          // Date range picker handlers for Biaya tab
          if (dateRangeBiaya) {
            dateRangeBiaya.addEventListener('click', () => {
              datePickerPopupBiaya.classList.toggle('hidden');
            });
          }

          if (datePickerApplyBiaya) {
            datePickerApplyBiaya.addEventListener('click', () => {
              if (datePickerStartBiaya.value && datePickerEndBiaya.value) {
                if (datePickerStartBiaya.value <= datePickerEndBiaya.value) {
                  dateRangeBiaya.value = `${datePickerStartBiaya.value} s/d ${datePickerEndBiaya.value}`;
                  datePickerPopupBiaya.classList.add('hidden');
                  loadBiayaTotalChart();
                  loadBiayaChart();
                } else {
                  alert('Tanggal awal tidak boleh lebih besar dari tanggal akhir');
                }
              }
            });
          }

          if (datePickerCancelBiaya) {
            datePickerCancelBiaya.addEventListener('click', () => {
              datePickerPopupBiaya.classList.add('hidden');
            });
          }

          // Filter button handler for Biaya tab
          if (btnFilterBiaya) {
            btnFilterBiaya.addEventListener('click', () => {
              loadBiayaTotalChart();
              loadBiayaChart();
            });
          }

          // Bidang select change handler
          if (selectBidangBiaya) {
            selectBidangBiaya.addEventListener('change', () => {
              loadBiayaTotalChart();
              loadBiayaChart();
            });
          }

          // Reset button handler for Biaya tab
          if (btnResetBiaya) {
            btnResetBiaya.addEventListener('click', () => {
              const today = new Date();
              const oneMonthAgo = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
              datePickerStartBiaya.value = formatDate(oneMonthAgo.toISOString().split('T')[0]);
              datePickerEndBiaya.value = formatDate(today.toISOString().split('T')[0]);
              dateRangeBiaya.value = `${datePickerStartBiaya.value} s/d ${datePickerEndBiaya.value}`;
              selectBidangBiaya.value = '';
              loadBiayaTotalChart();
              loadBiayaChart();
            });
          }

          // Close date picker when clicking outside
          document.addEventListener('click', (e) => {
            if (datePickerPopupBiaya && dateRangeBiaya) {
              const isClickInsideDatePicker = dateRangeBiaya.contains(e.target) || datePickerPopupBiaya.contains(e.target);
              if (!isClickInsideDatePicker && !datePickerPopupBiaya.classList.contains('hidden')) {
                datePickerPopupBiaya.classList.add('hidden');
              }
            }
          });

          // Load chart on initial page load
          loadBiayaTotalChart();
          loadBiayaChart();

          // Regional Select Handler - Placeholder only
          if (selectRegional) {
            selectRegional.addEventListener('change', (e) => {
              const selectedRegional = e.target.value;
              console.log('Regional selected:', selectedRegional);
            });
          }

          // ===== DETAIL DINAS TAB - Filter Detail Handler =====
          const btnFilterDetail = document.getElementById('btnFilterDetail');
          const btnResetDetail = document.getElementById('btnResetDetail');
          const dateRangeDetail = document.getElementById('dateRangeDetail');
          const datePickerPopupDetail = document.getElementById('datePickerPopupDetail');
          const datePickerStartDetail = document.getElementById('datePickerStartDetail');
          const datePickerEndDetail = document.getElementById('datePickerEndDetail');
          const datePickerApplyDetail = document.getElementById('datePickerApplyDetail');
          const datePickerCancelDetail = document.getElementById('datePickerCancelDetail');
          const selectBidangDetail = document.getElementById('selectBidangBiayaBPD');
          const inputNamaDetail = document.getElementById('inputNama');
          const inputKeperluan = document.getElementById('keperluan');

          // Initialize date picker for Detail tab
          if (dateRangeDetail && datePickerStartDetail && datePickerEndDetail) {
            const today = new Date();
            const oneMonthAgo = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
            datePickerStartDetail.value = formatDate(oneMonthAgo.toISOString().split('T')[0]);
            datePickerEndDetail.value = formatDate(today.toISOString().split('T')[0]);
            dateRangeDetail.value = `${datePickerStartDetail.value} s/d ${datePickerEndDetail.value}`;
          }

          // Format currency helper
          function formatCurrencyIDR(value) {
            return new Intl.NumberFormat('id-ID', {
              style: 'currency',
              currency: 'IDR',
              minimumFractionDigits: 0,
              maximumFractionDigits: 0
            }).format(value || 0);
          }

          // Date range picker handlers for Detail tab
          if (dateRangeDetail) {
            dateRangeDetail.addEventListener('click', () => {
              datePickerPopupDetail.classList.toggle('hidden');
            });
          }

          if (datePickerApplyDetail) {
            datePickerApplyDetail.addEventListener('click', () => {
              if (datePickerStartDetail.value && datePickerEndDetail.value) {
                if (datePickerStartDetail.value <= datePickerEndDetail.value) {
                  dateRangeDetail.value = `${datePickerStartDetail.value} s/d ${datePickerEndDetail.value}`;
                  datePickerPopupDetail.classList.add('hidden');
                  console.log('Periode terpilih:', datePickerStartDetail.value, 's/d', datePickerEndDetail.value);
                } else {
                  alert('Tanggal awal tidak boleh lebih besar dari tanggal akhir');
                }
              } else {
                alert('Silakan isi kedua tanggal');
              }
            });
          }

          if (datePickerCancelDetail) {
            datePickerCancelDetail.addEventListener('click', () => {
              datePickerPopupDetail.classList.add('hidden');
            });
          }

          // Close popup when clicking outside (Detail tab)
          document.addEventListener('click', (e) => {
            if (datePickerPopupDetail && dateRangeDetail) {
              const isClickInsideDatePicker = dateRangeDetail.contains(e.target) || datePickerPopupDetail.contains(e.target);
              if (!isClickInsideDatePicker && !datePickerPopupDetail.classList.contains('hidden')) {
                datePickerPopupDetail.classList.add('hidden');
              }
            }
          });

          // Filter Detail Button Handler
          if (btnFilterDetail) {
            btnFilterDetail.addEventListener('click', () => {
              const dateRange = dateRangeDetail ? dateRangeDetail.value : '';
              const bidangId = selectBidangDetail ? selectBidangDetail.value : '';
              const namaPegawai = inputNamaDetail ? inputNamaDetail.value : '';
              const keterangan = inputKeperluan ? inputKeperluan.value : '';

              // Show loading state
              btnFilterDetail.disabled = true;
              btnFilterDetail.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';

              // Build query params
              let params = new URLSearchParams();
              if (dateRange) {
                const [tglAwal, tglAkhir] = dateRange.split(' s/d ');
                if (tglAwal) params.append('tgl_awal', tglAwal.trim());
                if (tglAkhir) params.append('tgl_akhir', tglAkhir.trim());
              }
              if (bidangId) params.append('bidang_id', bidangId);
              if (namaPegawai) params.append('nama_pegawai', namaPegawai);
              if (keterangan) params.append('keterangan', keterangan);

              // Make AJAX call
              fetch(`/api/bpd/detailbpd?${params.toString()}`)
                .then(response => {
                  if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                  }
                  return response.json();
                })
                .then(data => {
                  const tableBody = document.getElementById('detailDinasTableBody');
                  if (!tableBody) {
                    console.error('Table body not found');
                    return;
                  }

                  // Clear existing rows
                  tableBody.innerHTML = '';

                  // Handle different response structures
                  let dataArray = [];
                  
                  // Check if data is directly an array
                  if (Array.isArray(data)) {
                    dataArray = data;
                  }
                  // Check if data has .data property that is an array
                  else if (data.data && Array.isArray(data.data)) {
                    dataArray = data.data;
                  }
                  // Check if data has .data property that is a single object - wrap it in array
                  else if (data.data && typeof data.data === 'object') {
                    dataArray = [data.data];
                  }
                  // If data itself is an object (not array) - wrap it in array
                  else if (typeof data === 'object' && !Array.isArray(data) && data.id) {
                    dataArray = [data];
                  }

                  // Populate table with new data
                  if (dataArray && dataArray.length > 0) {
                    dataArray.forEach((item, index) => {
                      try {
                        // Calculate total biaya_dinas
                        const biayaDinas = (
                          (parseFloat(item.biaya_dinas_uang_perdiem) || 0) +
                          (parseFloat(item.biaya_dinas_transport_lokal) || 0) +
                          (parseFloat(item.biaya_dinas_transport_dari_bandara) || 0) +
                          (parseFloat(item.biaya_dinas_transport_ke_bandara) || 0)
                        );

                        // Calculate total biaya_reimbursement
                        const biayaReimbursement = (
                          (parseFloat(item.reimbursement_penginapan) || 0) +
                          (parseFloat(item.reimbursement_tiketberangkat) || 0) +
                          (parseFloat(item.reimbursement_tiketpulang) || 0) +
                          (parseFloat(item.reimbursement_uangcuci) || 0)
                        );

                        // Calculate total biaya_akomodasi
                        const biayaAkomodasi = (
                          (parseFloat(item.akomodasi_tiketberangkat) || 0) +
                          (parseFloat(item.akomodasi_tiketpulang) || 0) +
                          (parseFloat(item.akomodasi_penginapan) || 0)
                        );

                        const row = document.createElement('tr');
                        row.style.borderBottom = '1px solid #e5e7eb';
                        row.innerHTML = `
                          <td style="padding: 8px 12px; text-align: center; color: #374151;">${item.nomor}</td>
                          <td style="padding: 8px 12px; text-align: left; color: #374151;">${item.nama_pegawai || '-'}</td>
                          <td style="padding: 8px 12px; text-align: left; color: #374151;">${item.nama_bidang || '-'}</td>
                          <td style="padding: 8px 12px; text-align: center; color: #374151;">${item.tgl_berangkat || '-'}</td>
                          <td style="padding: 8px 12px; text-align: center; color: #374151;">${item.tgl_kembali || '-'}</td>
                          <td style="padding: 8px 12px; text-align: left; color: #374151;">${item.jenis_tujuan || '-'}</td>
                          <td style="padding: 8px 12px; text-align: left; color: #374151;">${item.keperluan || '-'}</td>
                          <td style="padding: 8px 12px; text-align: left; color: #374151;">${item.tujuan || '-'}</td>
                          <td style="padding: 8px 12px; text-align: left; color: #374151;">${item.lokasi_kota || '-'}</td>
                          <td style="padding: 8px 12px; text-align: left; color: #374151;">${item.nama_rombongan || '-'}</td>
                          <td style="padding: 8px 12px; text-align: right; color: #374151;">${formatCurrencyIDR(biayaDinas)}</td>
                          <td style="padding: 8px 12px; text-align: right; color: #374151;">${formatCurrencyIDR(biayaReimbursement)}</td>
                          <td style="padding: 8px 12px; text-align: right; color: #374151;">${formatCurrencyIDR(biayaAkomodasi)}</td>
                        `;
                        tableBody.appendChild(row);
                      } catch (err) {
                        console.error('Error processing row:', err, item);
                      }
                    });
                  } else {
                    const emptyRow = document.createElement('tr');
                    emptyRow.innerHTML = `
                      <td colspan="13" style="padding: 32px 16px; text-align: center; color: #9ca3af;">
                        <i class="fas fa-database" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
                        Tidak ada data detail dinas
                      </td>
                    `;
                    tableBody.appendChild(emptyRow);
                  }
                })
                .catch(error => {
                  console.error('Error fetching data:', error);
                  const tableBody = document.getElementById('detailDinasTableBody');
                  if (tableBody) {
                    tableBody.innerHTML = `
                      <tr>
                        <td colspan="13" style="padding: 32px 16px; text-align: center; color: #ef4444;">
                          <i class="fas fa-exclamation-circle" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
                          Terjadi kesalahan: ${error.message}
                        </td>
                      </tr>
                    `;
                  }
                  const errorPopup = document.getElementById('errorPopup');
                  const errorMessage = document.getElementById('errorMessage');
                  if (errorPopup && errorMessage) {
                    errorMessage.textContent = 'Terjadi kesalahan: ' + error.message;
                    errorPopup.classList.remove('hidden');
                  }
                })
                .finally(() => {
                  btnFilterDetail.disabled = false;
                  btnFilterDetail.innerHTML = '<i class="fas fa-filter"></i> Filter';
                });
            });
          }

          // Reset Button Handler for Detail Tab
          if (btnResetDetail) {
            btnResetDetail.addEventListener('click', () => {
              const today = new Date();
              const oneMonthAgo = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
              
              // Reset date range
              datePickerStartDetail.value = formatDate(oneMonthAgo.toISOString().split('T')[0]);
              datePickerEndDetail.value = formatDate(today.toISOString().split('T')[0]);
              dateRangeDetail.value = `${datePickerStartDetail.value} s/d ${datePickerEndDetail.value}`;
              
              // Reset form inputs
              if (selectBidangDetail) {
                selectBidangDetail.value = '';
              }
              if (inputNamaDetail) {
                inputNamaDetail.value = '';
              }
              if (inputKeperluan) {
                inputKeperluan.value = '';
              }
              
              // Clear table
              const tableBody = document.getElementById('detailDinasTableBody');
              if (tableBody) {
                tableBody.innerHTML = '';
              }
            });
          }
        });
      </script>
      <script src="{{ asset('js/components/application-select-handler.js') }}"></script>
      @include('pages.dfarm.menu.menu-script')
  </div>

@endsection


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
            @include('pages.dfarm.components.application-select', ['selected' => 'SAPA-Amanah'])
          </div>

          <!-- Table Card -->
          <div class="table-card">
            <div class="table-header">
              <div class="table-title">
                <i class="fas fa-table"></i>
                <span id="table-title">Pantauan SAPA-Amanah</span>
                <span id="regional-badge" class="regional-badge" style="display:none;"></span>
              </div>
              <span id="data-count-badge" class="table-count">Dfarm PTPN I</span>
            </div>

            <div id="tabs-wrap" style="display: block;">

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
                          <input type="text" id="dateRange" placeholder="Jun 2026" readonly class="form-input" style="cursor: pointer; width: 100%;">
                          <div id="datePickerPopup" class="hidden" style="position: absolute; top: 100%; left: 0; margin-top: 8px; background: white; border: 1px solid #d1d5db; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); padding: 16px; z-index: 50; min-width: 280px;">
                            <div>
                              <label class="form-label" style="color: #374151;">Pilih Bulan & Tahun</label>
                              <input type="month" id="datePickerStart" class="form-input">
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
                          <option value="" selected>Pilih</option>
                          <option value="2">REGIONAL 2</option>
                          <option value="3">REGIONAL 3</option>
                          <option value="5">REGIONAL 5</option>
                          <option value="7">REGIONAL 7</option>
                          <option value="8">REGIONAL 8</option>
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

                  <!-- Dashboard Section - Rata-rata Skor per Regional -->
                  <div style="padding: 0 16px 16px;">
                    <h2 style="font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                      <i class="fas fa-chart-line"></i> Dashboard bulan Juni 2026
                    </h2>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                      <!-- Chart Column -->
                      <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                        <h3 style="font-size: 14px; font-weight: 700; color: #1f2937; margin-bottom: 16px; text-align: center;">Rata-rata Skor per Regional</h3>
                        <div style="position: relative; height: 300px;">
                          <canvas id="rataRataSkorChart"></canvas>
                        </div>
                      </div>

                      <!-- Table Column -->
                      <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                        <div style="background: #f3f4f6; padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">
                          <h3 style="font-size: 14px; font-weight: 700; color: #1f2937; margin: 0;">Regional</h3>
                        </div>
                        <table style="width: 100%; border-collapse: collapse;">
                          <thead>
                            <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                              <th style="padding: 10px 16px; text-align: left; font-weight: 700; color: #374151; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Nama Regional</th>
                              <th style="padding: 10px 16px; text-align: right; font-weight: 700; color: #374151; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Rata-rata Skor</th>
                            </tr>
                          </thead>
                          <tbody id="rataRataSkorTableBody">
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                              <td style="padding: 10px 16px; color: #1f2937; font-size: 13px;"><a href="#" style="color: #3b82f6; text-decoration: none; cursor: pointer;">Regional 2</a></td>
                              <td style="padding: 10px 16px; color: #1f2937; font-size: 13px; text-align: right; font-weight: 600;">Loading...</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                              <td style="padding: 10px 16px; color: #1f2937; font-size: 13px;"><a href="#" style="color: #3b82f6; text-decoration: none; cursor: pointer;">Regional 3</a></td>
                              <td style="padding: 10px 16px; color: #1f2937; font-size: 13px; text-align: right; font-weight: 600;">Loading...</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                              <td style="padding: 10px 16px; color: #1f2937; font-size: 13px;"><a href="#" style="color: #3b82f6; text-decoration: none; cursor: pointer;">Regional 5</a></td>
                              <td style="padding: 10px 16px; color: #1f2937; font-size: 13px; text-align: right; font-weight: 600;">Loading...</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                              <td style="padding: 10px 16px; color: #1f2937; font-size: 13px;"><a href="#" style="color: #3b82f6; text-decoration: none; cursor: pointer;">Regional 7</a></td>
                              <td style="padding: 10px 16px; color: #1f2937; font-size: 13px; text-align: right; font-weight: 600;">Loading...</td>
                            </tr>
                            <tr>
                              <td style="padding: 10px 16px; color: #1f2937; font-size: 13px;"><a href="#" style="color: #3b82f6; text-decoration: none; cursor: pointer;">Regional 8</a></td>
                              <td style="padding: 10px 16px; color: #1f2937; font-size: 13px; text-align: right; font-weight: 600;">Loading...</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <!-- Detail Kebun Table - Shows when company/regional is selected -->
                    <div id="detailKebunSection" style="display: none; margin-top: 24px;">
                      <h2 style="font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-leaf"></i> Detail Data Kebun Berdasarkan <span id="selectedRegionalLabel" style="margin-left: 4px; color: #166534;">Regional</span>
                      </h2>
                      
                      <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                        <div class="table-wrapper">
                          <table class="report-table" style="width: 100%; border-collapse: collapse; font-size: 12.5px; color: #1f2937;">
                            <thead>
                              <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                                <th style="padding: 10px 16px; text-align: left; font-weight: 700; color: #374151; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">PSA</th>
                                <th style="padding: 10px 16px; text-align: left; font-weight: 700; color: #374151; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Nama Unit</th>
                                <th style="padding: 10px 16px; text-align: center; font-weight: 700; color: #374151; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Periode</th>
                                <th style="padding: 10px 16px; text-align: center; font-weight: 700; color: #374151; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Komoditas</th>
                                <th style="padding: 10px 16px; text-align: right; font-weight: 700; color: #374151; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Skor Rata-rata</th>
                              </tr>
                            </thead>
                            <tbody id="detailKebunTableBody">
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

        // ============================================
        // FETCH DATA FROM API - Rata-rata Skor per Regional
        // ============================================
        let rataRataSkorChart = null;
        let lastApiData = null; // Store API data for detail table
        
        // Helper function to format komoditas from COMPANY field
        function formatKomoditas(company) {
          if (!company) return '-';
          // Map COMPANY codes to komoditas
          const komoditasMap = {
            'N008': 'Teh.',
            'N009': 'Karet,',
            'N010': 'Kelapa Sawit',
            'N011': 'Cokelat',
            'N012': 'Kopi',
            'N013': 'Pinang',
            'N014': 'Tebu',
            'N015': 'Lada',
          };
          return komoditasMap[company] || company;
        }
        
        // Populate detail kebun table based on selected regional
        function populateDetailKebunTable(selectedRegional, apiData) {
          const detailSection = document.getElementById('detailKebunSection');
          const detailTableBody = document.getElementById('detailKebunTableBody');
          const selectedRegionalLabel = document.getElementById('selectedRegionalLabel');
          
          if (!selectedRegional || !apiData || !apiData.data_plant) {
            detailSection.style.display = 'none';
            return;
          }
          
          // Filter data for selected regional
          const kebunData = apiData.data_plant.filter(item => item.REGIONAL === selectedRegional);
          
          if (kebunData.length === 0) {
            detailSection.style.display = 'none';
            return;
          }
          
          // Show section
          detailSection.style.display = 'block';
          selectedRegionalLabel.textContent = `Regional ${selectedRegional}`;
          
          // Populate table
          detailTableBody.innerHTML = '';
          kebunData.forEach((item, index) => {
            const tr = document.createElement('tr');
            if (index < kebunData.length - 1) {
              tr.style.borderBottom = '1px solid #e5e7eb';
            }
            
            // Format periode
            let periode = '-';
            if (item.BULAN && item.TAHUN) {
              const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
              periode = monthNames[parseInt(item.BULAN) - 1] + ' ' + item.TAHUN;
            }
            
            // Format skor
            const skor = item.SKOR_RATA2 !== null && item.SKOR_RATA2 !== undefined 
              ? parseFloat(item.SKOR_RATA2).toFixed(2) + '%'
              : '-';
            
            tr.innerHTML = `
              <td style="padding: 10px 16px; color: #1f2937; font-size: 13px;">${item.PSA || '-'}</td>
              <td style="padding: 10px 16px; color: #1f2937; font-size: 13px;">${item.NAMA_UNIT || '-'}</td>
              <td style="padding: 10px 16px; color: #1f2937; font-size: 13px; text-align: center;">${periode}</td>
              <td style="padding: 10px 16px; color: #1f2937; font-size: 13px; text-align: center;">${formatKomoditas(item.COMPANY)}</td>
              <td style="padding: 10px 16px; color: #1f2937; font-size: 13px; text-align: right; font-weight: 600;">${skor}</td>
            `;
            detailTableBody.appendChild(tr);
          });
        }
        
        async function loadRataRataSkorData(date = null, company = 2) {
          try {
            // Validate and format date parameter
            let selectedDate = date;
            
            // Check if date is a valid string in YYYY-MM format
            if (selectedDate && typeof selectedDate === 'string') {
              const dateRegex = /^\d{4}-\d{2}$/;
              if (!dateRegex.test(selectedDate)) {
                console.warn('Invalid date format:', selectedDate, 'using current month instead');
                selectedDate = null;
              }
            } else if (selectedDate && typeof selectedDate !== 'string') {
              // If date is not a string (e.g., Event object), ignore it
              console.warn('Date is not a string:', selectedDate, 'using current month instead');
              selectedDate = null;
            }
            
            // Use provided date or default to current month
            if (!selectedDate) {
              const today = new Date();
              selectedDate = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0');
            }
            
            // Fetch data from API with date and company parameters
            const url = `https://amanah.ptpn1.co.id/api/get_pantauan?date=${selectedDate}&company=${company}`;
            console.log('Fetching from:', url);
            
            const response = await fetch(url, {
              method: 'GET',
              headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
              }
            });
            
            if (!response.ok) {
              const errorText = await response.text();
              console.error('API Error:', errorText);
              throw new Error(`API Error: ${response.status} - ${response.statusText}`);
            }
            
            let apiData;
            try {
              apiData = await response.json();
            } catch (parseError) {
              const responseText = await response.text();
              console.error('Failed to parse JSON. Response:', responseText);
              throw new Error('Invalid JSON response from API');
            }
            
            // Process data: Group by REGIONAL and calculate average
            const regionalData = {};
            const allRegionals = ['2', '3', '5', '7', '8'];
            
            // Initialize all regionals
            allRegionals.forEach(reg => {
              regionalData[reg] = { total: 0, count: 0, average: 0 };
            });
            
            // Process API response
            if (apiData.data_plant && Array.isArray(apiData.data_plant)) {
              apiData.data_plant.forEach(item => {
                const regional = item.REGIONAL;
                const skor = item.SKOR_RATA2 !== null ? parseFloat(item.SKOR_RATA2) : 0;
                
                if (regionalData[regional]) {
                  regionalData[regional].total += skor;
                  regionalData[regional].count += 1;
                }
              });
            }
            
            // Calculate averages and prepare chart data
            const labels = allRegionals.map(reg => 'Regional ' + reg);
            const chartData = allRegionals.map(reg => {
              if (regionalData[reg].count > 0) {
                return parseFloat((regionalData[reg].total / regionalData[reg].count).toFixed(2));
              }
              return 0;
            });
            
            // Store API data for detail table
            lastApiData = apiData;
            
            // Hide detail section initially (will show only when regional is selected from detail)
            document.getElementById('detailKebunSection').style.display = 'none';
            
            // Update table
            const tableBody = document.getElementById('rataRataSkorTableBody');
            tableBody.innerHTML = '';
            allRegionals.forEach((regional, index) => {
              const tr = document.createElement('tr');
              if (index < allRegionals.length - 1) {
                tr.style.borderBottom = '1px solid #e5e7eb';
              }
              const score = chartData[index];
              tr.innerHTML = `
                <td style="padding: 10px 16px; color: #1f2937; font-size: 13px;"><a href="#" style="color: #3b82f6; text-decoration: none; cursor: pointer;">Regional ${regional}</a></td>
                <td style="padding: 10px 16px; color: #1f2937; font-size: 13px; text-align: right; font-weight: 600;">${score.toFixed(2)}%</td>
              `;
              tableBody.appendChild(tr);
            });
            
            // Initialize or update chart
            const rataRataSkorCtx = document.getElementById('rataRataSkorChart');
            if (rataRataSkorCtx) {
              if (rataRataSkorChart) {
                rataRataSkorChart.data.labels = labels;
                rataRataSkorChart.data.datasets[0].data = chartData;
                rataRataSkorChart.update();
              } else {
                rataRataSkorChart = new Chart(rataRataSkorCtx, {
                  type: 'bar',
                  data: {
                    labels: labels,
                    datasets: [
                      {
                        label: 'Rata-rata Skor',
                        data: chartData,
                        backgroundColor: ['#0EA5E9', '#06B6D4', '#8B5CF6', '#EC4899', '#F59E0B'],
                        borderRadius: 6,
                        borderSkipped: false,
                      }
                    ]
                  },
                  options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    plugins: {
                      legend: {
                        display: true,
                        labels: {
                          color: chartColors.textColor,
                          font: { size: 11, family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif" },
                          padding: 12,
                        }
                      }
                    },
                    scales: {
                      x: {
                        grid: { color: chartColors.gridColor, drawBorder: false },
                        ticks: { color: chartColors.textColor, font: { size: 10 } },
                        max: 100,
                      },
                      y: {
                        grid: { color: chartColors.gridColor, drawBorder: false },
                        ticks: { color: chartColors.textColor, font: { size: 10 } },
                      }
                    }
                  }
                });
              }
            }
            
            // Auto-populate detail table if regional is selected
            const selectedRegional = document.getElementById('selectRegional').value;
            if (selectedRegional && lastApiData) {
              populateDetailKebunTable(selectedRegional, lastApiData);
            }
          } catch (error) {
            console.error('Error loading rata-rata skor data:', error);
            showErrorPopup(`Error: ${error.message}`);
          }
        }
        
        // Load data when page is ready
        document.addEventListener('DOMContentLoaded', () => loadRataRataSkorData());

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


      </script>

      <!-- Month Picker Script -->
      <script>
        // Format bulan-tahun ke "MMM YYYY" format
        function formatMonthYear(monthStr) {
          if (!monthStr) return '';
          const [year, month] = monthStr.split('-');
          const date = new Date(year, parseInt(month) - 1, 1);
          return date.toLocaleDateString('id-ID', {
            year: 'numeric',
            month: 'short'
          });
        }

        // Month Picker Elements
        const dateRangeInput = document.getElementById('dateRange');
        const datePickerPopup = document.getElementById('datePickerPopup');
        const datePickerStart = document.getElementById('datePickerStart');
        const datePickerApply = document.getElementById('datePickerApply');
        const datePickerCancel = document.getElementById('datePickerCancel');

        // Set default month (current month)
        const today = new Date();
        const currentMonth = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0');
        
        datePickerStart.value = currentMonth;
        
        // Set default regional to 2
        document.getElementById('selectRegional').value = '2';

        // Update display
        function updateDateDisplay() {
          if (datePickerStart.value) {
            dateRangeInput.value = formatMonthYear(datePickerStart.value);
          }
        }
        updateDateDisplay();

        // Toggle popup
        dateRangeInput.addEventListener('click', () => {
          datePickerPopup.classList.toggle('hidden');
        });

        // Apply button
        datePickerApply.addEventListener('click', () => {
          if (datePickerStart.value) {
            updateDateDisplay();
            datePickerPopup.classList.add('hidden');
            console.log('Period terpilih:', datePickerStart.value);
            // TODO: Trigger API call atau filter dengan periode terpilih
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

        // Filter Button Handler
        document.getElementById('btnFilter').addEventListener('click', () => {
          const selectedDate = document.getElementById('datePickerStart').value;
          const company = 2; // Default company value
          
          if (selectedDate) {
            console.log('Filter dengan date:', selectedDate, 'company:', company);
            loadRataRataSkorData(selectedDate, company);
          } else {
            alert('Silakan pilih periode terlebih dahulu');
          }
        });

        // Reset Button Handler
        document.getElementById('btnReset').addEventListener('click', () => {
          const today = new Date();
          const currentMonth = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0');
          document.getElementById('datePickerStart').value = currentMonth;
          document.getElementById('dateRange').value = formatMonthYear(currentMonth);
          loadRataRataSkorData(currentMonth, 2);
        });

        // Regional Select Handler - Show detail table when regional is selected
        document.getElementById('selectRegional').addEventListener('change', (e) => {
          const selectedRegional = e.target.value;
          if (selectedRegional && lastApiData) {
            populateDetailKebunTable(selectedRegional, lastApiData);
          } else {
            document.getElementById('detailKebunSection').style.display = 'none';
          }
        });

        // Regional Table Link Click Handler - Select in dropdown and show detail
        document.getElementById('rataRataSkorTableBody').addEventListener('click', (e) => {
          if (e.target.tagName === 'A') {
            e.preventDefault();
            const regionalText = e.target.textContent.trim();
            const regionalNum = regionalText.replace('Regional ', '');
            
            // Update select dropdown
            document.getElementById('selectRegional').value = regionalNum;
            
            // Show detail table
            if (lastApiData) {
              populateDetailKebunTable(regionalNum, lastApiData);
            }
          }
        });
      </script>
  </div>

@endsection

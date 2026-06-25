@extends('layouts.app')

@section('title', 'Monitoring Kehadiran')

@section('styles')
    <style>
        /* ===== SCROLL FIX — override Tailwind h-screen di body ===== */
        html,
        body {
            height: auto !important;
            min-height: 100vh;
            overflow-y: auto !important;
            background-color: #f8fafc !important;
            color: #1f2937;
            font-family: 'Google Sans', 'Inter', sans-serif;
        }

        /* Override padding dari layout .main-content agar tidak ada space aneh */
        .evaluasi-container.main-content {
            padding: 0 !important;
            margin-left: 0 !important;
            background-color: #f8fafc;
            min-height: 100vh;
        }

        /* ===== MAIN CONTAINER ===== */
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

        .content-section {
            max-width: 100%;
            margin: 0;
            padding: 18px 50px 32px;
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
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            align-items: flex-end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            min-width: 200px;
        }

        .form-group.checkbox-group {
            flex-direction: row;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .form-label {
            color: #374151;
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-select,
        .form-input {
            width: 100%;
            padding: 8px 10px;
            background-color: #fff;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            color: #1f2937;
            font-size: 13px;
            transition: border-color 0.2s;
        }

        .form-select:focus,
        .form-input:focus {
            outline: none;
            border-color: #166534;
            box-shadow: 0 0 0 2px rgba(22, 101, 52, 0.12);
        }

        .btn-filter {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 16px;
            background-color: #16a34a;
            color: #fff;
            border: 1px solid #15803d;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            height: 36px;
        }

        .btn-filter:hover {
            background-color: #15803d;
            border-color: #166534;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
            margin-top: 10px;
        }

        .breakdown-container {
            display: none;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px dashed #e5e7eb;
            animation: fadeIn 0.4s ease-out;
        }

        .employee-detail-container {
            display: none;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px dashed #e5e7eb;
            animation: fadeIn 0.4s ease-out;
        }

        .employee-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            text-align: left;
        }

        .employee-table th {
            background-color: #f0fdf4;
            /* Light green theme */
            color: #166534;
            padding: 8px 12px;
            font-weight: bold;
            border-bottom: 1px solid #bbf7d0;
            text-transform: uppercase;
        }

        .employee-table td {
            padding: 8px 12px;
            border-bottom: 1px solid #f1f5f9;
            color: #475569;
        }

        .employee-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .employee-table tr:hover {
            background-color: #f1f5f9;
        }

        /* Status & Badges */
        .badge-belum-absen {
            font-size: 9px;
            color: #ef4444;
            background-color: #fee2e2;
            border: 1px solid #fca5a5;
            padding: 2px 6px;
            border-radius: 4px;
            margin-left: 8px;
            font-weight: bold;
        }

        .pct-box-yellow {
            background-color: #fef08a;
            color: #854d0e;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 10px;
            min-width: 45px;
            text-align: center;
            display: inline-block;
        }

        /* Progress Bar */
        .progress-bar-container {
            width: 80px;
            height: 6px;
            background-color: #e2e8f0;
            border-radius: 3px;
            display: inline-block;
            margin-right: 8px;
            vertical-align: middle;
        }

        .progress-bar-fill {
            height: 100%;
            background-color: #16a34a;
            border-radius: 3px;
        }

        .detail-header-bar {
            display: flex;
            align-items: center;
            background-color: #dcfce3;
            border: 1px solid #bbf7d0;
            border-radius: 6px;
            padding: 8px 12px;
            margin-bottom: 15px;
            font-size: 12px;
        }

        .detail-header-title {
            font-weight: bold;
            color: #166534;
            margin-right: 15px;
        }

        .detail-header-badge {
            color: #166534;
            padding: 4px 10px;
            border-radius: 4px;
            font-weight: bold;
        }

        .breakdown-chart-wrapper {
            position: relative;
            height: 500px;
            width: 100%;
        }

        .loading-overlay {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            z-index: 10;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            border-radius: 8px;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(34, 197, 94, 0.1);
            border-top-color: #22c55e;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 10px;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection

@section('content')
    <div class="evaluasi-container main-content">

        <!-- Page Header -->
        <header class="lm-page-header">
            <div class="lm-header-logo">
                <img src="{{ asset('danantara.png') }}" alt="Danantara">
            </div>
            <div class="lm-header-center">
                <svg style="width:28px;height:28px;color:#22c55e;flex-shrink:0;" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" />
                </svg>
                <h1>Evaluasi Absensi AGHRIS</h1>
            </div>
            <div class="lm-header-right">
                <img src="{{ asset('ptpn1.png') }}" alt="PTPN 1">
            </div>
        </header>

        <!-- Main Content Section -->
        <div class="content-section">

            <!-- Filter Card -->
            <div class="filter-card">
                <div class="filter-title">
                    <i class="fas fa-sliders-h"></i> Filter Parameter
                </div>
                <div class="filter-grid" style="display: block;">
                    <div class="form-group" style="max-width: 300px;">
                        <label class="form-label" style="text-transform: uppercase;">Nama Aplikasi</label>
                        <select class="form-select" id="app_select" onchange="updateDashboard()">
                            <option value="HRIS">HRIS</option>
                            <option value="AGHRIS" selected>AGHRIS</option>

                        </select>
                    </div>
                </div>
            </div>

            <!-- Chart Card -->
            <div class="table-card" style="position: relative; min-height: 400px;">
                <div class="table-header">
                    <div class="table-title">
                        <i class="fas fa-chart-bar"></i> <span>Jumlah Karyawan Aktif per Regional</span>
                    </div>
                </div>

                <div style="padding: 20px;">
                    <div style="margin-bottom: 25px;">
                        <div
                            style="display: inline-flex; align-items: center; border: 1px solid #e2e8f0; border-radius: 6px; padding: 6px 12px; background: #fff;">
                            <i class="fas fa-calendar" style="color: #16a34a; margin-right: 8px;"></i>
                            <span
                                style="font-size: 12px; font-weight: bold; color: #475569; margin-right: 10px;">PERIODE:</span>
                            <input type="month" id="periodeFilter"
                                style="border: none; outline: none; font-size: 13px; color: #334155; font-family: inherit; cursor: pointer;"
                                value="{{ date('Y-m') }}">
                        </div>
                    </div>

                    <div id="loadingOverlay" class="loading-overlay">
                        <div class="spinner"></div>
                        <p style="color: #6b7280; font-weight: 500; font-size: 13px;">Mengambil Data...</p>
                    </div>

                    <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 20px;"><i class="fas fa-info-circle"
                            style="color: #3b82f6;"></i> Klik pada salah satu batang grafik untuk melihat detail per divisi.
                    </p>

                    <div class="chart-container">
                        <canvas id="mainChart"></canvas>
                    </div>

                    <div id="breakdownSection" class="breakdown-container">
                        <div class="filter-title" style="margin-bottom: 15px;">
                            <i class="fas fa-chart-pie"></i> <span id="breakdownTitle">Detail Karyawan Aktif</span>
                        </div>
                        <div class="breakdown-chart-wrapper">
                            <canvas id="breakdownChart"></canvas>
                        </div>
                    </div>

                    <div id="employeeDetailSection" class="employee-detail-container">
                        <div style="margin-bottom: 15px;">
                            <button id="btnBackToBreakdown" class="btn-filter"
                                style="background-color: #64748b; border-color: #475569;">
                                <i class="fas fa-arrow-left"></i> Kembali ke Grafik
                            </button>
                        </div>

                        <div class="detail-header-bar">
                            <div class="detail-header-title" id="empDetailTitle">DIVISI</div>
                            <div class="detail-header-badge" id="empDetailBadge">0% (0 Pegawai)</div>
                        </div>

                        <div style="overflow-x: auto;">
                            <table class="employee-table" id="empTable">
                                <thead>
                                    <tr>
                                        <th style="text-align: center; width: 40px;">NO</th>
                                        <th>NAMA KARYAWAN</th>
                                        <th>NIK</th>
                                        <th>JABATAN</th>
                                        <th style="text-align: center;">ABSENSI <i class="fas fa-info-circle text-blue-400"
                                                style="font-size: 10px;"></i></th>
                                        <th style="text-align: right;">PERSENTASE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamic rows -->
                                </tbody>
                            </table>
                        </div>

                        <div id="paginationContainer"
                            style="display: none; justify-content: space-between; align-items: center; margin-top: 15px; font-size: 12px; color: #475569;">
                            <div id="paginationInfo">Showing 0 to 0 of 0 entries</div>
                            <div style="display: flex; gap: 5px;">
                                <button id="btnPrevPage" class="btn-filter"
                                    style="padding: 4px 10px; height: auto; background-color: #e2e8f0; color: #334155; border: 1px solid #cbd5e1;">Prev</button>
                                <button id="btnNextPage" class="btn-filter"
                                    style="padding: 4px 10px; height: auto; background-color: #e2e8f0; color: #334155; border: 1px solid #cbd5e1;">Next</button>
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
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script>
        Chart.register(ChartDataLabels);

        let mainChartInstance = null;
        let breakdownChartInstance = null;
        let rawChartData = [];

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

        document.getElementById('periodeFilter').addEventListener('change', fetchData);

        function showLoading() {
            document.getElementById('loadingOverlay').style.display = 'flex';
        }

        function hideLoading() {
            document.getElementById('loadingOverlay').style.display = 'none';
        }

        function fetchData() {
            const periodeVal = document.getElementById('periodeFilter').value;
            if (!periodeVal) return;
            const [yearStr, monthStr] = periodeVal.split('-');
            const year = parseInt(yearStr, 10);
            const month = parseInt(monthStr, 10);

            showLoading();
            
            // Menutup detail (kembali ke chart utama) saat bulan dirubah
            document.getElementById('breakdownSection').style.display = 'none';
            document.getElementById('employeeDetailSection').style.display = 'none';
            document.querySelector('.breakdown-chart-wrapper').style.display = 'block';

            fetch("{{ route('aghris_dashboard') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ month, year })
            })
                .then(res => res.json())
                .then(res => {
                    hideLoading();

                    if (res.success) {
                        rawChartData = res.data;
                        renderMainChart(rawChartData);
                    } else {
                        alert('Gagal mengambil data: ' + (res.message || 'Unknown Error'));
                    }
                })
                .catch(err => {
                    hideLoading();
                    console.error(err);
                    alert('Terjadi kesalahan sistem saat mengambil data.');
                });
        }

        function renderMainChart(data) {
            const ctx = document.getElementById('mainChart').getContext('2d');

            if (mainChartInstance) {
                mainChartInstance.destroy();
            }

            const labels = data.map(d => d.regional);
            const activeCounts = data.map(d => d.active);
            const attendedCounts = data.map(d => d.attended);

            mainChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Karyawan Aktif',
                            data: activeCounts,
                            backgroundColor: '#166534',
                            hoverBackgroundColor: '#14532d',
                            borderRadius: 4,
                            barPercentage: 0.9,
                            categoryPercentage: 0.7,
                        },
                        {
                            label: 'Karyawan Hadir',
                            data: attendedCounts,
                            backgroundColor: '#3b82f6',
                            hoverBackgroundColor: '#2563eb',
                            borderRadius: 4,
                            barPercentage: 0.9,
                            categoryPercentage: 0.7,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    onClick: (event, elements) => {
                        if (elements.length > 0) {
                            const index = elements[0].index;
                            showBreakdown(data[index]);
                        }
                    },
                    onHover: (event, chartElement) => {
                        event.native.target.style.cursor = chartElement[0] ? 'pointer' : 'default';
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 8
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const idx = context.dataIndex;
                                    const item = data[idx];
                                    const datasetLabel = context.dataset.label || '';
                                    if (datasetLabel === 'Karyawan Hadir' && item.percentage !== undefined) {
                                        return ` ${datasetLabel}: ${context.raw} Pegawai (${item.percentage}%)`;
                                    }
                                    return ` ${datasetLabel}: ${context.raw} Pegawai`;
                                }
                            }
                        },
                        datalabels: {
                            labels: {
                                count: {
                                    anchor: 'end',
                                    align: 'top',
                                    offset: 4,
                                    color: '#4b5563', // Text gelap karena berada di luar batang putih
                                    font: { weight: 'bold', size: 11 },
                                    formatter: function (value) {
                                        return value > 0 ? value.toLocaleString('id-ID') : '';
                                    }
                                },
                                percentage: {
                                    anchor: 'end',
                                    align: 'top',
                                    offset: 28, // Didorong lebih tinggi agar tidak saling menumpuk
                                    backgroundColor: '#2563eb',
                                    color: 'white',
                                    borderRadius: 4,
                                    padding: { top: 2, bottom: 2, left: 4, right: 4 },
                                    font: { weight: 'bold', size: 10 },
                                    display: function (context) {
                                        const datasetLabel = context.dataset.label || '';
                                        const item = data[context.dataIndex];
                                        return datasetLabel === 'Karyawan Hadir' && item.percentage > 0;
                                    },
                                    formatter: function (value, context) {
                                        const item = data[context.dataIndex];
                                        return item.percentage + '%';
                                    }
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#e5e7eb',
                                drawBorder: false,
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        function showBreakdown(regionalData) {
            document.getElementById('breakdownSection').style.display = 'block';
            document.getElementById('employeeDetailSection').style.display = 'none';
            document.querySelector('.breakdown-chart-wrapper').style.display = 'block'; // Pastikan wrapper chart kembali tampil
            document.getElementById('breakdownTitle').innerText = `Detail Karyawan Aktif: ${regionalData.regional}`;

            const ctx = document.getElementById('breakdownChart').getContext('2d');

            if (breakdownChartInstance) {
                breakdownChartInstance.destroy();
            }

            const breakdown = regionalData.breakdown;
            const labels = breakdown.map(d => d.name);
            const activeCounts = breakdown.map(d => d.active);
            const attendedCounts = breakdown.map(d => d.attended);

            const newHeight = Math.max(300, breakdown.length * 60);
            document.querySelector('.breakdown-chart-wrapper').style.height = newHeight + 'px';

            breakdownChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Karyawan Aktif',
                            data: activeCounts,
                            backgroundColor: '#16a34a', // Slightly lighter green for breakdown
                            borderRadius: 4,
                            barPercentage: 0.9,
                            categoryPercentage: 0.8,
                        },
                        {
                            label: 'Karyawan Hadir',
                            data: attendedCounts,
                            backgroundColor: '#60a5fa', // Lighter blue for breakdown
                            borderRadius: 4,
                            barPercentage: 0.9,
                            categoryPercentage: 0.8,
                        }
                    ]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    onClick: (event, elements) => {
                        if (elements.length > 0) {
                            const index = elements[0].index;
                            const divisiData = breakdown[index];
                            showEmployeeDetails(divisiData, regionalData.regional);
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 8
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const idx = context.dataIndex;
                                    const item = breakdown[idx];
                                    const datasetLabel = context.dataset.label || '';
                                    if (datasetLabel === 'Karyawan Hadir' && item.percentage !== undefined) {
                                        return ` ${datasetLabel}: ${context.raw} Pegawai (${item.percentage}%)`;
                                    }
                                    return ` ${datasetLabel}: ${context.raw} Pegawai`;
                                }
                            }
                        },
                        datalabels: {
                            labels: {
                                count: {
                                    anchor: 'end',
                                    align: 'right',
                                    offset: 4,
                                    color: '#4b5563', // Text gelap
                                    font: { weight: 'bold', size: 12 },
                                    formatter: function (value) {
                                        return value > 0 ? value.toLocaleString('id-ID') + ' Pgw' : '';
                                    }
                                },
                                percentage: {
                                    anchor: 'end',
                                    align: 'right',
                                    offset: 65, // Diberi jarak yang lebih jauh agar tidak menumpuk
                                    backgroundColor: '#2563eb',
                                    color: 'white',
                                    borderRadius: 4,
                                    padding: { top: 3, bottom: 3, left: 5, right: 5 },
                                    font: { weight: 'bold', size: 11 },
                                    display: function (context) {
                                        const datasetLabel = context.dataset.label || '';
                                        const item = breakdown[context.dataIndex];
                                        return datasetLabel === 'Karyawan Hadir' && item.percentage > 0;
                                    },
                                    formatter: function (value, context) {
                                        const item = breakdown[context.dataIndex];
                                        return item.percentage + '%';
                                    }
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                color: '#e5e7eb',
                                drawBorder: false,
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 11,
                                    weight: '500'
                                }
                            }
                        }
                    }
                }
            });
        }

        let currentEmployeesData = [];
        let currentPage = 1;
        const rowsPerPage = 10;

        function showEmployeeDetails(divisiData, regionalName) {
            // Hide breakdown chart, show employee details
            document.querySelector('.breakdown-chart-wrapper').style.display = 'none';
            document.getElementById('employeeDetailSection').style.display = 'block';

            // Set Title & Badge
            document.getElementById('empDetailTitle').innerText = `${regionalName} - ${divisiData.name}`;
            document.getElementById('empDetailBadge').innerText = `${divisiData.percentage}% (${divisiData.active} Pegawai)`;

            currentEmployeesData = divisiData.employees || [];
            currentPage = 1;

            renderEmployeeTable();
        }

        function renderEmployeeTable() {
            const tbody = document.querySelector('#empTable tbody');
            tbody.innerHTML = '';

            const totalRows = currentEmployeesData.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;

            if (totalRows === 0) {
                tbody.innerHTML = `<tr><td colspan="6" style="text-align: center;">Tidak ada data karyawan</td></tr>`;
                document.getElementById('paginationContainer').style.display = 'none';
                return;
            }

            document.getElementById('paginationContainer').style.display = 'flex';

            const startIdx = (currentPage - 1) * rowsPerPage;
            const endIdx = Math.min(startIdx + rowsPerPage, totalRows);
            const pageData = currentEmployeesData.slice(startIdx, endIdx);

            pageData.forEach((emp, index) => {
                const no = startIdx + index + 1;
                const belumAbsenHtml = emp.hadir === 0 ? `<span class="badge-belum-absen">Belum absen</span>` : '';

                const pctFormatted = emp.persentase.toFixed(1) + '%';
                // Jika 0%, beri bg kuning spt gambar
                const boxClass = 'pct-box-yellow';

                const row = `
                                <tr>
                                    <td style="text-align: center;">${no}</td>
                                    <td style="font-weight: 500; color: #1e293b;">${emp.nama || '-'}${belumAbsenHtml}</td>
                                    <td>${emp.nik}</td>
                                    <td>${emp.jabatan || '-'}</td>
                                    <td style="text-align: center;">${emp.hadir} / ${emp.h_kerja} hari</td>
                                    <td style="text-align: right;">
                                        <div class="progress-bar-container"><div class="progress-bar-fill" style="width: ${emp.persentase}%"></div></div>
                                        <span class="${boxClass}">${pctFormatted}</span>
                                    </td>
                                </tr>
                            `;
                tbody.innerHTML += row;
            });

            document.getElementById('paginationInfo').innerText = `Menampilkan ${startIdx + 1} sampai ${endIdx} dari ${totalRows} pegawai`;
            document.getElementById('btnPrevPage').disabled = currentPage === 1;
            document.getElementById('btnNextPage').disabled = currentPage === totalPages;
            document.getElementById('btnPrevPage').style.opacity = currentPage === 1 ? '0.5' : '1';
            document.getElementById('btnNextPage').style.opacity = currentPage === totalPages ? '0.5' : '1';
        }

        document.getElementById('btnPrevPage').addEventListener('click', function () {
            if (currentPage > 1) {
                currentPage--;
                renderEmployeeTable();
            }
        });

        document.getElementById('btnNextPage').addEventListener('click', function () {
            const totalPages = Math.ceil(currentEmployeesData.length / rowsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                renderEmployeeTable();
            }
        });

        document.getElementById('btnBackToBreakdown').addEventListener('click', function () {
            document.getElementById('employeeDetailSection').style.display = 'none';
            document.querySelector('.breakdown-chart-wrapper').style.display = 'block';
        });

        // Auto load
        window.onload = () => {
            fetchData();
        };
    </script>

    <script src="{{ asset('js/components/application-select-handler.js') }}"></script>
@endsection
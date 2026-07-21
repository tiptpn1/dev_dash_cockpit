@extends('layouts.app')

@section('title', 'CRM Dashboard')

@section('styles')
<style>
    /* ===== SCROLL FIX ===== */
    html,
    body {
        height: auto !important;
        min-height: 100vh;
        overflow-y: auto !important;
        background-color: #f8fafc !important;
        color: #1f2937;
        font-family: 'Google Sans', 'Inter', sans-serif;
    }

    .crm-container.main-content {
        padding: 0 !important;
        margin-left: 0 !important;
        background-color: #f8fafc;
        min-height: 100vh;
    }

    .crm-container {
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
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        align-items: end;
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
    
    .btn-proses {
        background-color: #166534;
        color: white;
        font-weight: bold;
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        height: 37px;
        font-size: 13px;
        transition: background-color 0.2s;
    }
    .btn-proses:hover {
        background-color: #14532d;
    }

    /* ===== CHART CARD ===== */
    .chart-card {
        background: #fff;
        border: 2px solid #166534;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(22, 101, 52, 0.10);
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
    }

    .chart-header {
        background: #166534;
        padding: 10px 20px;
        border-bottom: 2px solid #14532d;
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
        letter-spacing: 0.02em;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .chart-header:hover {
        background: #15803d;
    }

    .chart-header::after {
        content: '\f0ce';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        margin-left: auto;
        opacity: 0.7;
    }

    .chart-body {
        padding: 15px;
        height: 320px;
        position: relative;
    }

    /* ===== DATA MODAL STYLES ===== */
    .data-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .data-modal-overlay.show {
        display: flex;
    }
    .data-modal-container {
        background: #fff;
        border-radius: 8px;
        width: 100%;
        max-width: 600px;
        max-height: 80vh;
        display: flex;
        flex-direction: column;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    .data-modal-header {
        background: #166534;
        color: #fff;
        padding: 15px 20px;
        border-radius: 8px 8px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: bold;
    }
    .data-modal-close {
        background: none;
        border: none;
        color: #fff;
        font-size: 20px;
        cursor: pointer;
    }
    .data-modal-body {
        padding: 20px;
        overflow-y: auto;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        color: #1f2937;
    }
    .data-table th {
        background: #f0fdf4;
        color: #166534;
        padding: 10px;
        text-align: left;
        border: 1px solid #d1fae5;
    }
    .data-table td {
        padding: 10px;
        border: 1px solid #e5e7eb;
    }
    .data-table tr:hover td {
        background: #f8fafc;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection

@section('content')
<div class="crm-container main-content">
    <!-- Page Header -->
    <header class="lm-page-header">
        <div class="lm-header-logo">
            <img src="{{ asset('danantara.png') }}" alt="Danantara" onerror="this.style.display='none'">
        </div>
        <div class="lm-header-center">
            <i class="fas fa-chart-bar" style="color:#22c55e; font-size:24px;"></i>
            <h1 style="font-size: 1.5rem; font-weight: 700; color: #166534; margin: 0;">CRM Dashboard - Approved Prices</h1>
        </div>
        <div class="lm-header-right">
            <img src="{{ asset('ptpn1.png') }}" alt="PTPN 1" onerror="this.style.display='none'">
        </div>
    </header>

    <div class="content-section">
        <!-- Filters -->
        <div class="filter-card">
            <div class="filter-title">
                <i class="fas fa-sliders-h"></i> Filter Parameter
            </div>
            <div class="filter-grid">
                <div class="form-group">
                    <label class="form-label">Bulan</label>
                    <input type="month" id="month" class="form-input text-black" style="color: black;" value="2026-06">
                </div>
                <div class="form-group">
                    <label class="form-label">Komoditi</label>
                    <select id="commodity" class="form-select text-black" style="color: black;">
                        <option value="semua">Semua Komoditi</option>
                        <option value="KARET">Karet</option>
                        <option value="SAWIT">Sawit</option>
                        <option value="TEBU">Tebu</option>
                        <option value="TEH">Teh</option>
                        <option value="KOPI">Kopi</option>
                        <option value="KAKAO">Kakao</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Incoterm</label>
                    <select id="incoterm" class="form-select text-black" style="color: black;">
                        <option value="semua">Semua Incoterm</option>
                        <option value="Franco">Franco</option>
                        <option value="Free On Board (Port)">Free On Board (Port)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Location (Inco Loc)</label>
                    <select id="inco_loc_filter" class="form-select text-black" style="color: black;">
                        <option value="semua">Semua Lokasi</option>
                        <option value="IPMG Panjang">IPMG Panjang</option>
                        <option value="Tanjung Perak Surabaya">Tanjung Perak Surabaya</option>
                        <option value="Tanjung Priok Jakarta">Tanjung Priok Jakarta</option>
                        <option value="Palembang">Palembang</option>
                        <option value="Bengkulu">Bengkulu</option>
                    </select>
                </div>
                <div class="form-group">
                    <button id="btn-proses" class="btn-proses w-full">
                        <i class="fas fa-sync-alt mr-2"></i> Proses Data
                    </button>
                </div>
            </div>
        </div>

        <!-- Loader -->
        <div id="loader" class="hidden text-center py-10">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-green-700 mb-2"></div>
            <p class="text-gray-600 font-semibold">Mengambil data dari API CRM...</p>
        </div>

        <!-- Charts -->
        <div id="dashboard-content" class="hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Chart 7 (Incoterm Type) -->
                <div class="chart-card">
                    <div class="chart-header" id="headerVolIncoTerm"><i class="fas fa-truck-loading"></i> Total Volume per Tipe Incoterm</div>
                    <div class="chart-body"><canvas id="chartVolIncoTerm"></canvas></div>
                </div>
                
                <!-- Chart 1 -->
                <div class="chart-card">
                    <div class="chart-header" id="headerVolRegional"><i class="fas fa-chart-column"></i> Total Volume per Symbol Code</div>
                    <div class="chart-body"><canvas id="chartVolRegional"></canvas></div>
                </div>
                
                <!-- Chart 2 -->
                <div class="chart-card">
                    <div class="chart-header" id="headerVolCommodity"><i class="fas fa-chart-pie"></i> Total Volume per Komoditi</div>
                    <div class="chart-body"><canvas id="chartVolCommodity"></canvas></div>
                </div>
                
                <!-- Chart 3 -->
                <div class="chart-card">
                    <div class="chart-header" id="headerPriceTrend"><i class="fas fa-chart-line"></i> Tren Rata-rata Harga Disetujui</div>
                    <div class="chart-body"><canvas id="chartPriceTrend"></canvas></div>
                </div>
                
                <!-- Chart 4 -->
                <div class="chart-card">
                    <div class="chart-header" id="headerVolGrade"><i class="fas fa-chart-bar"></i> Total Volume per Grade</div>
                    <div class="chart-body"><canvas id="chartVolGrade"></canvas></div>
                </div>
                
                <!-- Chart 5 -->
                <div class="chart-card">
                    <div class="chart-header" id="headerPriceRange"><i class="fas fa-balance-scale"></i> Rentang Harga per Komoditi</div>
                    <div class="chart-body"><canvas id="chartPriceRange"></canvas></div>
                </div>
                
                <!-- Chart 6 -->
                <div class="chart-card">
                    <div class="chart-header" id="headerVolIncoLoc"><i class="fas fa-map-marker-alt"></i> Volume per Lokasi/Incoterm</div>
                    <div class="chart-body" style="overflow-y: auto;">
                        <div id="chartVolIncoLocContainer" style="position: relative; width: 100%;">
                            <canvas id="chartVolIncoLoc"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Data Modal -->
    <div id="dataModal" class="data-modal-overlay">
        <div class="data-modal-container">
            <div class="data-modal-header">
                <span id="dataModalTitle">Data Detail</span>
                <button class="data-modal-close" onclick="$('#dataModal').removeClass('show')">&times;</button>
            </div>
            <div class="data-modal-body">
                <table class="data-table">
                    <thead id="dataModalHead"></thead>
                    <tbody id="dataModalBody"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let charts = {};

    $(document).ready(function() {
        $('#btn-proses').click(function() {
            fetchData();
        });
        
        // Fetch on load
        fetchData();
    });

    function showDataModal(title, headers, rows) {
        $('#dataModalTitle').text(title);
        
        let headHtml = '<tr>' + headers.map(h => `<th>${h}</th>`).join('') + '</tr>';
        $('#dataModalHead').html(headHtml);
        
        let bodyHtml = '';
        if(rows.length === 0) {
            bodyHtml = `<tr><td colspan="${headers.length}" style="text-align:center;">Tidak ada data</td></tr>`;
        } else {
            rows.forEach(row => {
                bodyHtml += '<tr>' + row.map(d => `<td>${d}</td>`).join('') + '</tr>';
            });
        }
        $('#dataModalBody').html(bodyHtml);
        $('#dataModal').addClass('show');
    }

    function fetchData() {
        $('#dashboard-content').addClass('hidden');
        $('#loader').removeClass('hidden');
        $('#btn-proses').prop('disabled', true).addClass('opacity-50');

        let selectedMonth = $('#month').val();
        let commodity = $('#commodity').val();
        let incoterm = $('#incoterm').val();
        let incoLoc = $('#inco_loc_filter').val();

        let startDate = '';
        let endDate = '';
        
        if (selectedMonth) {
            let parts = selectedMonth.split('-');
            let year = parts[0];
            let month = parts[1];
            startDate = `${year}-${month}-01`;
            let lastDay = new Date(year, month, 0).getDate();
            endDate = `${year}-${month}-${lastDay}`;
        }

        $.ajax({
            url: "{{ route('crm.approved_prices') }}",
            type: "GET",
            data: {
                start_date: startDate,
                end_date: endDate,
                commodity: commodity,
                incoterm: incoterm,
                inco_loc: incoLoc
            },
            success: function(res) {
                $('#loader').addClass('hidden');
                $('#btn-proses').prop('disabled', false).removeClass('opacity-50');
                
                if(res.success) {
                    $('#dashboard-content').removeClass('hidden');
                    processDataAndRenderCharts(res.data);
                } else {
                    alert('Gagal mengambil data');
                }
            },
            error: function() {
                $('#loader').addClass('hidden');
                $('#btn-proses').prop('disabled', false).removeClass('opacity-50');
                alert('Terjadi kesalahan koneksi ke server');
            }
        });
    }

    function processDataAndRenderCharts(data) {
        if(!data || data.length === 0) {
            alert('Tidak ada data pada periode ini.');
            // Destroy existing charts
            for(let key in charts) {
                if(charts[key]) charts[key].destroy();
            }
            return;
        }

        // Initialize groupings
        let byRegional = {};
        let byCommodity = {};
        let byDateAndCommodity = {};
        let allCommoditiesForTrend = new Set();
        let byGrade = {};
        let byIncoLoc = {};
        let byIncoTerm = {};

        data.forEach(item => {
            let reg = item.symbol_code || item.regional || 'Unknown';
            let com = item.commodity_name || 'Unknown';
            let date = item.allocation_date || 'Unknown';
            let gr = item.grade || 'Unknown';
            let loc = item.inco_loc || item.incoterm_description || 'Unknown';
            let incotermDesc = item.incoterm_description || 'Unknown';
            
            let vol = parseFloat(item.volume) || 0;
            let accPrice = parseFloat(item.accepted_price) || 0;
            let lowPrice = parseFloat(item.low_price) || 0;
            let highPrice = parseFloat(item.high_price) || 0;

            // 1. Regional
            byRegional[reg] = (byRegional[reg] || 0) + vol;
            
            // 2. Commodity
            byCommodity[com] = (byCommodity[com] || 0) + vol;
            
            // 3. Date trend (Avg Price per Commodity)
            if(!byDateAndCommodity[date]) byDateAndCommodity[date] = {};
            if(!byDateAndCommodity[date][com]) byDateAndCommodity[date][com] = { sum: 0, count: 0 };
            if(accPrice > 0) {
                byDateAndCommodity[date][com].sum += accPrice;
                byDateAndCommodity[date][com].count += 1;
                allCommoditiesForTrend.add(com);
            }
            
            // 4. Grade
            if(!byGrade[gr]) byGrade[gr] = { vol: 0, com: com };
            byGrade[gr].vol += vol;
            
            // 5. Price Range by Commodity
            if(!byCommodity[com + '_price']) byCommodity[com + '_price'] = { lowSum: 0, highSum: 0, count: 0 };
            if(lowPrice > 0 || highPrice > 0) {
                byCommodity[com + '_price'].lowSum += lowPrice;
                byCommodity[com + '_price'].highSum += highPrice;
                byCommodity[com + '_price'].count += 1;
            }
            
            // 6. Inco Location
            byIncoLoc[loc] = (byIncoLoc[loc] || 0) + vol;
            
            // 7. Incoterm Description
            byIncoTerm[incotermDesc] = (byIncoTerm[incotermDesc] || 0) + vol;
        });

        // Destroy previous charts if any
        for(let key in charts) {
            if(charts[key]) charts[key].destroy();
        }

        const fmtNum = (num) => new Intl.NumberFormat('id-ID').format(num);

        // Map Click Events
        $('#headerVolRegional').off('click').on('click', function() {
            let rows = Object.keys(byRegional).map(k => [k, fmtNum(byRegional[k])]);
            showDataModal('Total Volume per Symbol Code', ['Symbol Code', 'Volume'], rows);
        });
        
        $('#headerVolCommodity').off('click').on('click', function() {
            let comKeys = Object.keys(byCommodity).filter(k => !k.includes('_price'));
            let rows = comKeys.map(k => [k, fmtNum(byCommodity[k])]);
            showDataModal('Total Volume per Komoditi', ['Komoditi', 'Volume'], rows);
        });

        // Render Chart 1
        charts.chartVolRegional = new Chart(document.getElementById('chartVolRegional'), {
            type: 'bar',
            data: {
                labels: Object.keys(byRegional),
                datasets: [{
                    label: 'Total Volume',
                    data: Object.values(byRegional),
                    backgroundColor: 'rgba(22, 163, 74, 0.75)' // Green
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });

        // Render Chart 2
        let comKeys2 = Object.keys(byCommodity).filter(k => !k.includes('_price'));
        charts.chartVolCommodity = new Chart(document.getElementById('chartVolCommodity'), {
            type: 'doughnut',
            data: {
                labels: comKeys2,
                datasets: [{
                    data: comKeys2.map(k => byCommodity[k]),
                    backgroundColor: ['#16a34a', '#eab308', '#f97316', '#22c55e', '#facc15', '#fb923c'] // Green, Yellow, Orange palette
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'right' } }
            }
        });

        // Render Chart 3
        let dates = Object.keys(byDateAndCommodity).sort();
        let commoditiesTrendArray = Array.from(allCommoditiesForTrend);
        let palette = ['#16a34a', '#eab308', '#f97316', '#22c55e', '#facc15', '#fb923c'];

        $('#headerPriceTrend').off('click').on('click', function() {
            let rows = [];
            dates.forEach(d => {
                commoditiesTrendArray.forEach(c => {
                    let cell = byDateAndCommodity[d][c];
                    if(cell && cell.count > 0) {
                        rows.push([d, c, fmtNum(Math.round(cell.sum / cell.count))]);
                    }
                });
            });
            showDataModal('Tren Rata-rata Harga Disetujui', ['Tanggal', 'Komoditi', 'Avg Harga'], rows);
        });

        let datasetsTrend = commoditiesTrendArray.map((c, index) => {
            let dataPoints = dates.map(d => {
                let cell = byDateAndCommodity[d][c];
                return cell && cell.count > 0 ? (cell.sum / cell.count) : null; 
            });
            return {
                label: c,
                data: dataPoints,
                borderColor: palette[index % palette.length],
                backgroundColor: palette[index % palette.length] + '33',
                borderWidth: 2,
                tension: 0.2,
                fill: false,
                spanGaps: true
            };
        });

        charts.chartPriceTrend = new Chart(document.getElementById('chartPriceTrend'), {
            type: 'line',
            data: {
                labels: dates,
                datasets: datasetsTrend
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: true, position: 'bottom', labels: { boxWidth: 12 } } }
            }
        });

        // Render Chart 4
        let gradeArr = Object.keys(byGrade).map(k => ({grade: k, vol: byGrade[k].vol, com: byGrade[k].com})).sort((a,b) => b.vol - a.vol);
        
        $('#headerVolGrade').off('click').on('click', function() {
            let rows = gradeArr.map(x => [x.grade, x.com, fmtNum(x.vol)]);
            showDataModal('Total Volume per Grade', ['Grade', 'Komoditi', 'Volume'], rows);
        });

        let gradeDatasets = commoditiesTrendArray.map((c, index) => {
            let dataPoints = gradeArr.map(x => (x.com === c ? x.vol : 0));
            return {
                label: c,
                data: dataPoints,
                backgroundColor: palette[index % palette.length]
            };
        });

        charts.chartVolGrade = new Chart(document.getElementById('chartVolGrade'), {
            type: 'bar',
            data: {
                labels: gradeArr.map(x => x.grade),
                datasets: gradeDatasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: true, position: 'bottom', labels: { boxWidth: 12 } } },
                scales: {
                    x: { stacked: true },
                    y: { stacked: true }
                }
            }
        });

        // Render Chart 5
        let comKeys = Object.keys(byCommodity).filter(k => k.includes('_price')).map(k => k.replace('_price', ''));
        let lowData = comKeys.map(k => byCommodity[k+'_price'].count > 0 ? (byCommodity[k+'_price'].lowSum / byCommodity[k+'_price'].count) : 0);
        let highData = comKeys.map(k => byCommodity[k+'_price'].count > 0 ? (byCommodity[k+'_price'].highSum / byCommodity[k+'_price'].count) : 0);
        
        $('#headerPriceRange').off('click').on('click', function() {
            let rows = comKeys.map(k => {
                let cell = byCommodity[k+'_price'];
                let low = cell.count > 0 ? (cell.lowSum / cell.count) : 0;
                let high = cell.count > 0 ? (cell.highSum / cell.count) : 0;
                return [k, fmtNum(Math.round(low)), fmtNum(Math.round(high))];
            });
            showDataModal('Rentang Harga per Komoditi', ['Komoditi', 'Avg Low Price', 'Avg High Price'], rows);
        });

        charts.chartPriceRange = new Chart(document.getElementById('chartPriceRange'), {
            type: 'bar',
            data: {
                labels: comKeys,
                datasets: [
                    { label: 'Avg Low Price', data: lowData, backgroundColor: 'rgba(249, 115, 22, 0.75)' }, // Orange
                    { label: 'Avg High Price', data: highData, backgroundColor: 'rgba(22, 163, 74, 0.75)' } // Green
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: true } }
            }
        });

        // Render Chart 6
        let incoArr = Object.keys(byIncoLoc).map(k => ({loc: k, vol: byIncoLoc[k]})).sort((a,b) => b.vol - a.vol);
        
        $('#headerVolIncoLoc').off('click').on('click', function() {
            let rows = incoArr.map(x => [x.loc, fmtNum(x.vol)]);
            showDataModal('Volume per Lokasi / Incoterm', ['Lokasi / Incoterm', 'Volume'], rows);
        });

        $('#headerVolIncoTerm').off('click').on('click', function() {
            let rows = Object.keys(byIncoTerm).map(k => [k, fmtNum(byIncoTerm[k])]);
            showDataModal('Total Volume per Tipe Incoterm', ['Tipe Incoterm', 'Volume'], rows);
        });

        let incoHeight = incoArr.length * 35;
        if (incoHeight < 280) incoHeight = 280;
        $('#chartVolIncoLocContainer').css('height', incoHeight + 'px');

        charts.chartVolIncoLoc = new Chart(document.getElementById('chartVolIncoLoc'), {
            type: 'bar',
            data: {
                labels: incoArr.map(x => x.loc),
                datasets: [{
                    label: 'Volume',
                    data: incoArr.map(x => x.vol),
                    backgroundColor: 'rgba(132, 204, 22, 0.75)' // Yellowish green
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });

        // Render Chart 7
        let incoTermKeys = Object.keys(byIncoTerm);
        charts.chartVolIncoTerm = new Chart(document.getElementById('chartVolIncoTerm'), {
            type: 'doughnut',
            data: {
                labels: incoTermKeys,
                datasets: [{
                    data: incoTermKeys.map(k => byIncoTerm[k]),
                    backgroundColor: ['#f97316', '#22c55e', '#eab308', '#16a34a']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'right' } }
            }
        });
    }
</script>
@endsection

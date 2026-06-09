@extends('layouts.app')

@section('title', 'Evaluasi Aplikasi - MAIA')

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
</style>
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
                <path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.95-2.3A5 5 0 008 22c12 0 15-17 15-17-1 2-8 2-13 3-5 1-6 7-6 7s5.5-2 8.5-2 5 2 5 2-3-5-3-5 3 5 3 5-5 3-5 3 2 3 2 6-2 6-2 6 3-3 3-6-2-6-2-6z" />
            </svg>
            <h1 class="text-white" style="color: #166534 !important;">Evaluasi Kinerja Aplikasi</h1>
        </div>
        <div class="lm-header-right">
            <img src="{{ asset('ptpn1.png') }}" alt="PTPN 1">
        </div>
    </header>

    <!-- Main Content Section -->
    <div class="content-section">
        
        <!-- Filter Card -->
        <div class="filter-card">
            <div style="font-size: 14px; font-weight: 700; color: #166534; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-sliders-h"></i> Filter Parameter
            </div>
            <div class="flex items-center gap-4">
                <label class="text-sm font-medium text-gray-700">Nama Aplikasi:</label>
                <select id="appName" class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500" style="min-width: 200px;">
                    <option value="digital_farming">Digital Farming</option>
                    <option value="hris">HRIS</option>
                    <option value="maia" selected>MAIA</option>
                    <option value="monika">MONIKA</option>
                    <option value="sapa_amanah">SAPA-Amanah</option>
                </select>
            </div>
        </div>

        <!-- Status Card -->
        <div id="statusCard" class="bg-white rounded-lg shadow-md p-6 text-center border border-gray-100">
            <div id="loadingState" class="flex flex-col items-center justify-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-600 mb-4"></div>
                <p class="text-gray-600">Memuat data MAIA...</p>
            </div>
            <div id="errorState" class="hidden py-8">
                <div class="text-red-500 text-5xl mb-4">⚠️</div>
                <h3 class="text-xl font-semibold text-red-700 mb-2">Gagal Memuat Data</h3>
                <p id="errorMessage" class="text-gray-600 mb-4">Terjadi kesalahan saat mengambil data dari server MAIA.</p>
                <button onclick="retryLoad()" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-sm">Coba Lagi</button>
            </div>
            <div id="dataState" class="hidden">
                <!-- Content will be rendered here -->
                <div id="maiaContent"></div>
            </div>
        </div>
    </div>
</div>

<script>
const API_BASE = '/api/maia';

function initMaia() {
    loadMaiaData();

    const appNameSelect = document.getElementById('appName');
    if (appNameSelect) {
        appNameSelect.addEventListener('change', function() {
            const val = this.value;
            if (val === 'hris') {
                window.location.href = '/evaluasi-aplikasi';
            } else if (val === 'digital_farming') {
                window.location.href = '/dfarmkaret';
            } else if (val === 'monika') {
                window.location.href = '/evaluasi-aplikasi/monika';
            } else if (val === 'maia') {
                window.location.href = '/evaluasi-aplikasi/maia';
            }
        });
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initMaia);
} else {
    initMaia();
}

async function loadMaiaData() {
    showLoading();
    try {
        const response = await fetch(API_BASE + '/dashboard', {
            headers: {
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) throw new Error('HTTP ' + response.status);
        
        const data = await response.json();
        renderDashboard(data);
        showData();
    } catch (error) {
        showError(error.message);
    }
}

function showLoading() {
    document.getElementById('loadingState').classList.remove('hidden');
    document.getElementById('errorState').classList.add('hidden');
    document.getElementById('dataState').classList.add('hidden');
}

function showData() {
    document.getElementById('loadingState').classList.add('hidden');
    document.getElementById('errorState').classList.add('hidden');
    document.getElementById('dataState').classList.remove('hidden');
}

function showError(message) {
    document.getElementById('loadingState').classList.add('hidden');
    document.getElementById('errorState').classList.remove('hidden');
    document.getElementById('dataState').classList.add('hidden');
    document.getElementById('errorMessage').textContent = message;
}

function retryLoad() {
    loadMaiaData();
}

function renderDashboard(data) {
    const container = document.getElementById('maiaContent');
    const summary = data.summary || {};
    const formattedTotal = new Intl.NumberFormat('id-ID').format(summary.total_aset || 0);
    const formattedSelesai = new Intl.NumberFormat('id-ID').format(summary.sudah_teridentifikasi || 0);
    const formattedBelum = new Intl.NumberFormat('id-ID').format(summary.belum_teridentifikasi || 0);
    const formattedPct = (summary.persentase_teridentifikasi || 0) + '%';

    let rowsHtml = '';
    if (data.regions && data.regions.length > 0) {
        data.regions.forEach((r, idx) => {
            const total = new Intl.NumberFormat('id-ID').format(r.total_aset);
            const ident = new Intl.NumberFormat('id-ID').format(r.sudah_teridentifikasi);
            const belum = new Intl.NumberFormat('id-ID').format(r.belum_teridentifikasi);
            const pct = (r.persentase_teridentifikasi || 0) + '%';
            
            // Color coding progress bar
            let barColor = 'bg-yellow-500';
            if (r.persentase_teridentifikasi >= 60) {
                barColor = 'bg-green-600';
            } else if (r.persentase_teridentifikasi >= 20) {
                barColor = 'bg-blue-600';
            }
            
            rowsHtml += `
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <td style="padding: 10px 12px; text-align: center; border: 1px solid #e5e7eb;">${idx + 1}</td>
                    <td style="padding: 10px 12px; text-align: left; font-weight: 600; border: 1px solid #e5e7eb;">${r.master_region_nama} (${r.master_region_kode})</td>
                    <td style="padding: 10px 12px; text-align: right; border: 1px solid #e5e7eb;">${total}</td>
                    <td style="padding: 10px 12px; text-align: right; border: 1px solid #e5e7eb; color: #16a34a; font-weight: 600;">${ident}</td>
                    <td style="padding: 10px 12px; text-align: right; border: 1px solid #e5e7eb; color: #dc2626;">${belum}</td>
                    <td style="padding: 10px 12px; text-align: center; border: 1px solid #e5e7eb;">
                        <div class="flex items-center gap-2">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="${barColor} h-2.5 rounded-full" style="width: ${r.persentase_teridentifikasi}%"></div>
                            </div>
                            <span class="text-xs font-semibold" style="min-width: 45px; text-align: right;">${pct}</span>
                        </div>
                    </td>
                </tr>
            `;
        });
    } else {
        rowsHtml = '<tr><td colspan="6" style="text-align: center; padding: 20px; color: #6b7280;">Tidak ada data regional</td></tr>';
    }

    container.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6 text-left">
            <div class="bg-blue-50 rounded-lg p-5 border border-blue-100 shadow-sm">
                <h4 class="text-sm text-blue-600 font-semibold uppercase tracking-wider">Total Aset (PTPN I)</h4>
                <p class="text-3xl font-extrabold text-blue-800 mt-2">${formattedTotal}</p>
            </div>
            <div class="bg-green-50 rounded-lg p-5 border border-green-100 shadow-sm">
                <h4 class="text-sm text-green-600 font-semibold uppercase tracking-wider">Sudah Teridentifikasi</h4>
                <p class="text-3xl font-extrabold text-green-800 mt-2">${formattedSelesai}</p>
            </div>
            <div class="bg-red-50 rounded-lg p-5 border border-red-100 shadow-sm">
                <h4 class="text-sm text-red-600 font-semibold uppercase tracking-wider">Belum Teridentifikasi</h4>
                <p class="text-3xl font-extrabold text-red-800 mt-2">${formattedBelum}</p>
            </div>
            <div class="bg-yellow-50 rounded-lg p-5 border border-yellow-100 shadow-sm">
                <h4 class="text-sm text-yellow-600 font-semibold uppercase tracking-wider">Persentase Teridentifikasi</h4>
                <p class="text-3xl font-extrabold text-yellow-800 mt-2">${formattedPct}</p>
            </div>
        </div>

        <div class="table-card mt-8" style="background: #fff; border: 2px solid #166534; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(22, 101, 52, 0.10); text-align: left;">
            <div class="table-header" style="background: #166534; padding: 12px 20px; border-bottom: 2px solid #14532d; display: flex; align-items: center; justify-content: space-between;">
                <div class="table-title" style="color: #fff; font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-table"></i> Rekap Sinkronisasi Aset per Regional (MAIA)
                </div>
            </div>
            <div class="table-wrapper" style="overflow-x: auto; width: 100%;">
                <table class="report-table" style="width: 100%; border-collapse: collapse; font-size: 12.5px; color: #1f2937;">
                    <thead>
                        <tr style="background: #15803d; color: #fff;">
                            <th style="padding: 9px 12px; border: 1px solid #166534; text-align: center; width: 60px; text-transform: uppercase; font-weight: 700; font-size: 12px;">No</th>
                            <th style="padding: 9px 12px; border: 1px solid #166534; text-align: left; text-transform: uppercase; font-weight: 700; font-size: 12px;">Regional</th>
                            <th style="padding: 9px 12px; border: 1px solid #166534; text-align: right; width: 180px; text-transform: uppercase; font-weight: 700; font-size: 12px;">Total Aset</th>
                            <th style="padding: 9px 12px; border: 1px solid #166534; text-align: right; width: 180px; text-transform: uppercase; font-weight: 700; font-size: 12px;">Teridentifikasi</th>
                            <th style="padding: 9px 12px; border: 1px solid #166534; text-align: right; width: 180px; text-transform: uppercase; font-weight: 700; font-size: 12px;">Belum Teridentifikasi</th>
                            <th style="padding: 9px 12px; border: 1px solid #166534; text-align: center; width: 220px; text-transform: uppercase; font-weight: 700; font-size: 12px;">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${rowsHtml}
                    </tbody>
                </table>
            </div>
        </div>
    `;
}
</script>
@endsection


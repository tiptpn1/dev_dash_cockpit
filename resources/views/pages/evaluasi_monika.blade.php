@extends('layouts.app')

@section('title', 'Evaluasi Aplikasi - MONIKA')

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
                    <option value="maia">MAIA</option>
                    <option value="monika" selected>MONIKA</option>
                    <option value="sapa_amanah">SAPA-Amanah</option>
                </select>
            </div>
        </div>

        <!-- Status Card -->
        <div id="statusCard" class="bg-white rounded-lg shadow-md p-6 text-center border border-gray-100">
            <div id="loadingState" class="flex flex-col items-center justify-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-600 mb-4"></div>
                <p class="text-gray-600">Memuat data MONIKA...</p>
            </div>
            <div id="errorState" class="hidden py-8">
                <div class="text-red-500 text-5xl mb-4">⚠️</div>
                <h3 class="text-xl font-semibold text-red-700 mb-2">Gagal Memuat Data</h3>
                <p id="errorMessage" class="text-gray-600 mb-4">Terjadi kesalahan saat mengambil data dari server MONIKA.</p>
                <button onclick="retryLoad()" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-sm">Coba Lagi</button>
            </div>
            <div id="dataState" class="hidden">
                <!-- Content will be rendered here -->
                <div id="monikaContent"></div>
            </div>
        </div>
    </div>
</div>

<script>
const API_BASE = '/api/monika';

function initMonika() {
    loadMonikaData();

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
    document.addEventListener('DOMContentLoaded', initMonika);
} else {
    initMonika();
}

async function loadMonikaData() {
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
    loadMonikaData();
}

function renderDashboard(data) {
    const container = document.getElementById('monikaContent');
    const summary = data.summary || {};
    
    const formattedTotalKerjasama = new Intl.NumberFormat('id-ID').format(summary.total_kerjasama || 0);
    const formattedJalanTotal = new Intl.NumberFormat('id-ID').format((summary.jalan_lengkap || 0) + (summary.jalan_belum || 0));
    const formattedJalanLengkap = new Intl.NumberFormat('id-ID').format(summary.jalan_lengkap || 0);
    const formattedJalanBelum = new Intl.NumberFormat('id-ID').format(summary.jalan_belum || 0);
    
    const formattedAkhirTotal = new Intl.NumberFormat('id-ID').format((summary.akhir_lengkap || 0) + (summary.akhir_belum || 0));
    const formattedAkhirLengkap = new Intl.NumberFormat('id-ID').format(summary.akhir_lengkap || 0);
    const formattedAkhirBelum = new Intl.NumberFormat('id-ID').format(summary.akhir_belum || 0);
    
    const formattedPotensialPraTotal = new Intl.NumberFormat('id-ID').format((summary.potensial || 0) + (summary.pra_kerjasama || 0));
    const formattedPotensial = new Intl.NumberFormat('id-ID').format(summary.potensial || 0);
    const formattedPra = new Intl.NumberFormat('id-ID').format(summary.pra_kerjasama || 0);

    let rowsHtml = '';
    if (data.regions && data.regions.length > 0) {
        data.regions.forEach((r, idx) => {
            const pra = new Intl.NumberFormat('id-ID').format(r.pra_kerjasama || 0);
            const potensial = new Intl.NumberFormat('id-ID').format(r.potensial || 0);
            const jalanBelum = new Intl.NumberFormat('id-ID').format(r.jalan_belum || 0);
            const jalanLengkap = new Intl.NumberFormat('id-ID').format(r.jalan_lengkap || 0);
            const akhirBelum = new Intl.NumberFormat('id-ID').format(r.akhir_belum || 0);
            const akhirLengkap = new Intl.NumberFormat('id-ID').format(r.akhir_lengkap || 0);
            const belumDiisi = new Intl.NumberFormat('id-ID').format(r.belum_diisi || 0);
            const total = new Intl.NumberFormat('id-ID').format(r.total_kerjasama || 0);
            
            rowsHtml += `
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <td style="padding: 10px 12px; text-align: center; border: 1px solid #e5e7eb;">${idx + 1}</td>
                    <td style="padding: 10px 12px; text-align: left; font-weight: 600; border: 1px solid #e5e7eb;">${r.master_region_nama} (${r.master_region_kode})</td>
                    <td style="padding: 10px 12px; text-align: right; border: 1px solid #e5e7eb;">${pra}</td>
                    <td style="padding: 10px 12px; text-align: right; border: 1px solid #e5e7eb;">${potensial}</td>
                    <td style="padding: 10px 12px; text-align: right; border: 1px solid #e5e7eb; color: #dc2626; font-weight: 600;">${jalanBelum}</td>
                    <td style="padding: 10px 12px; text-align: right; border: 1px solid #e5e7eb; color: #16a34a; font-weight: 600;">${jalanLengkap}</td>
                    <td style="padding: 10px 12px; text-align: right; border: 1px solid #e5e7eb; color: #dc2626; font-weight: 600;">${akhirBelum}</td>
                    <td style="padding: 10px 12px; text-align: right; border: 1px solid #e5e7eb; color: #16a34a; font-weight: 600;">${akhirLengkap}</td>
                    <td style="padding: 10px 12px; text-align: right; border: 1px solid #e5e7eb; color: #4b5563;">${belumDiisi}</td>
                    <td style="padding: 10px 12px; text-align: right; border: 1px solid #e5e7eb; font-weight: 700; background-color: #f8fafc;">${total}</td>
                </tr>
            `;
        });
        
        // Add summary row at the bottom
        rowsHtml += `
            <tr style="background: #f1f5f9; border-top: 2px solid #cbd5e1; font-weight: 700;">
                <td colspan="2" style="padding: 12px; text-align: center; border: 1px solid #cbd5e1; text-transform: uppercase;">Total Keseluruhan</td>
                <td style="padding: 12px; text-align: right; border: 1px solid #cbd5e1;">${new Intl.NumberFormat('id-ID').format(summary.pra_kerjasama || 0)}</td>
                <td style="padding: 12px; text-align: right; border: 1px solid #cbd5e1;">${new Intl.NumberFormat('id-ID').format(summary.potensial || 0)}</td>
                <td style="padding: 12px; text-align: right; border: 1px solid #cbd5e1; color: #dc2626; font-weight: 700;">${new Intl.NumberFormat('id-ID').format(summary.jalan_belum || 0)}</td>
                <td style="padding: 12px; text-align: right; border: 1px solid #cbd5e1; color: #16a34a; font-weight: 700;">${new Intl.NumberFormat('id-ID').format(summary.jalan_lengkap || 0)}</td>
                <td style="padding: 12px; text-align: right; border: 1px solid #cbd5e1; color: #dc2626; font-weight: 700;">${new Intl.NumberFormat('id-ID').format(summary.akhir_belum || 0)}</td>
                <td style="padding: 12px; text-align: right; border: 1px solid #cbd5e1; color: #16a34a; font-weight: 700;">${new Intl.NumberFormat('id-ID').format(summary.akhir_lengkap || 0)}</td>
                <td style="padding: 12px; text-align: right; border: 1px solid #cbd5e1; color: #4b5563;">${new Intl.NumberFormat('id-ID').format(summary.belum_diisi || 0)}</td>
                <td style="padding: 12px; text-align: right; border: 1px solid #cbd5e1; background-color: #cbd5e1; font-weight: 900;">${formattedTotalKerjasama}</td>
            </tr>
        `;
    } else {
        rowsHtml = '<tr><td colspan="10" style="text-align: center; padding: 20px; color: #6b7280;">Tidak ada data regional</td></tr>';
    }

    container.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6 text-left">
            <div class="bg-blue-50 rounded-lg p-5 border border-blue-100 shadow-sm">
                <h4 class="text-xs text-blue-600 font-semibold uppercase tracking-wider">Total Kerjasama</h4>
                <p class="text-3xl font-extrabold text-blue-800 mt-2">${formattedTotalKerjasama}</p>
                <div class="text-xs text-blue-500 mt-1">Seluruh status data kerjasama</div>
            </div>
            <div class="bg-green-50 rounded-lg p-5 border border-green-100 shadow-sm">
                <h4 class="text-xs text-green-600 font-semibold uppercase tracking-wider">Kerjasama Berjalan</h4>
                <p class="text-3xl font-extrabold text-green-800 mt-2">${formattedJalanTotal}</p>
                <div class="text-xs text-green-600 mt-1">
                    Lengkap: <strong>${formattedJalanLengkap}</strong> | Belum Lengkap: <strong class="text-red-600">${formattedJalanBelum}</strong>
                </div>
            </div>
            <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 shadow-sm">
                <h4 class="text-xs text-gray-600 font-semibold uppercase tracking-wider">Kerjasama Berakhir</h4>
                <p class="text-3xl font-extrabold text-gray-800 mt-2">${formattedAkhirTotal}</p>
                <div class="text-xs text-gray-500 mt-1">
                    Lengkap: <strong>${formattedAkhirLengkap}</strong> | Belum Lengkap: <strong class="text-red-600">${formattedAkhirBelum}</strong>
                </div>
            </div>
            <div class="bg-indigo-50 rounded-lg p-5 border border-indigo-100 shadow-sm">
                <h4 class="text-xs text-indigo-600 font-semibold uppercase tracking-wider">Potensial & Pra Kerjasama</h4>
                <p class="text-3xl font-extrabold text-indigo-800 mt-2">${formattedPotensialPraTotal}</p>
                <div class="text-xs text-indigo-500 mt-1">
                    Potensial: <strong>${formattedPotensial}</strong> | Pra: <strong>${formattedPra}</strong>
                </div>
            </div>
        </div>

        <div class="table-card mt-8" style="background: #fff; border: 2px solid #166534; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(22, 101, 52, 0.10); text-align: left;">
            <div class="table-header" style="background: #166534; padding: 12px 20px; border-bottom: 2px solid #14532d; display: flex; align-items: center; justify-content: space-between;">
                <div class="table-title" style="color: #fff; font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-table"></i> Rekap Monitoring Kinerja per Regional (MONIKA)
                </div>
            </div>
            <div class="table-wrapper" style="overflow-x: auto; width: 100%;">
                <table class="report-table" style="width: 100%; border-collapse: collapse; font-size: 12px; color: #1f2937;">
                    <thead>
                        <tr style="background: #15803d; color: #fff;">
                            <th rowspan="2" style="padding: 12px; border: 1px solid #166534; text-align: center; vertical-align: middle; text-transform: uppercase; font-weight: 700; font-size: 11px; width: 50px;">No</th>
                            <th rowspan="2" style="padding: 12px; border: 1px solid #166534; text-align: left; vertical-align: middle; text-transform: uppercase; font-weight: 700; font-size: 11px; min-width: 150px;">Regional</th>
                            <th rowspan="2" style="padding: 12px; border: 1px solid #166534; text-align: right; vertical-align: middle; text-transform: uppercase; font-weight: 700; font-size: 11px; width: 100px;">Pra Kerjasama</th>
                            <th rowspan="2" style="padding: 12px; border: 1px solid #166534; text-align: right; vertical-align: middle; text-transform: uppercase; font-weight: 700; font-size: 11px; width: 100px;">Potensial</th>
                            <th colspan="2" style="padding: 9px 12px; border: 1px solid #166534; text-align: center; text-transform: uppercase; font-weight: 700; font-size: 11px;">Kerjasama Berjalan</th>
                            <th colspan="2" style="padding: 9px 12px; border: 1px solid #166534; text-align: center; text-transform: uppercase; font-weight: 700; font-size: 11px;">Kerjasama Berakhir</th>
                            <th rowspan="2" style="padding: 12px; border: 1px solid #166534; text-align: right; vertical-align: middle; text-transform: uppercase; font-weight: 700; font-size: 11px; width: 100px;">Belum Diisi</th>
                            <th rowspan="2" style="padding: 12px; border: 1px solid #166534; text-align: right; vertical-align: middle; text-transform: uppercase; font-weight: 700; font-size: 11px; width: 110px; background: #166534;">Total</th>
                        </tr>
                        <tr style="background: #166534; color: #fff;">
                            <th style="padding: 6px 12px; border: 1px solid #166534; text-align: right; text-transform: uppercase; font-weight: 700; font-size: 10px; width: 100px;">Belum Lengkap</th>
                            <th style="padding: 6px 12px; border: 1px solid #166534; text-align: right; text-transform: uppercase; font-weight: 700; font-size: 10px; width: 100px;">Lengkap</th>
                            <th style="padding: 6px 12px; border: 1px solid #166534; text-align: right; text-transform: uppercase; font-weight: 700; font-size: 10px; width: 100px;">Belum Lengkap</th>
                            <th style="padding: 6px 12px; border: 1px solid #166534; text-align: right; text-transform: uppercase; font-weight: 700; font-size: 10px; width: 100px;">Lengkap</th>
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


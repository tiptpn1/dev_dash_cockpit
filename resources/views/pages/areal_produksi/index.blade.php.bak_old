@extends('layouts.app')

@section('title', 'Executive Resume Areal & Produksi')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">

<!-- ApexCharts CDN -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<style>
    /* Global Reset & FluxCRM Theme Alignment */
    html, body {
        height: auto !important;
        min-height: 100vh;
        overflow-y: auto !important;
        background-color: #f3f4f6 !important;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        color: #1f2937;
    }

    .main-content {
        height: auto !important;
        overflow-y: auto !important;
        padding: 0 !important;
        margin-left: 0 !important;
    }

    .flux-wrapper {
        background-color: #f3f4f6;
        min-height: 100vh;
        padding: 28px 32px 60px 32px;
    }

    /* Card styling */
    .flux-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.03), 0 2px 6px -1px rgba(0, 0, 0, 0.02);
        border: 1px solid #f1f5f9;
        transition: all 0.25s ease;
    }

    .flux-card-lime {
        background: linear-gradient(135deg, #a3e635 0%, #84cc16 100%);
        border-radius: 20px;
        color: #1a2e05;
        box-shadow: 0 10px 25px -5px rgba(132, 204, 22, 0.3);
    }

    .flux-card-emerald {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 20px;
        color: #ffffff;
        box-shadow: 0 10px 25px -5px rgba(4, 120, 87, 0.3);
    }

    .num-mono {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-feature-settings: "tnum";
        font-variant-numeric: tabular-nums;
    }

    /* Custom Table Styling */
    .flux-table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }

    .flux-table th {
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .flux-table td {
        font-size: 0.825rem;
        padding: 10px 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .flux-table tr:last-child td {
        border-bottom: none;
    }

    /* Page Top Header Banner */
    .lm-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 32px;
        background: #ffffff;
        border-bottom: 1px solid #e5e7eb;
        min-height: 56px;
        position: relative;
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

    /* Custom Scrollbar */
    .custom-scroll::-webkit-scrollbar {
        height: 6px;
        width: 6px;
    }
    .custom-scroll::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }
    .custom-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .custom-scroll::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>

<!-- TOP BANNER HEADER (Danantara & PTPN 1) -->
<header class="lm-page-header">
    <div class="lm-header-logo">
        <img src="{{ asset('danantara.png') }}" alt="Danantara Indonesia">
    </div>
    <div class="lm-header-center">
        <!-- <svg style="width:28px;height:28px;color:#22c55e;flex-shrink:0;" viewBox="0 0 24 24" fill="currentColor">
            <path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.95-2.3A5 5 0 008 22c12 0 15-17 15-17-1 2-8 2-13 3-5 1-6 7-6 7s5.5-2 8.5-2 5 2 5 2-3-5-3-5 3 5 3 5-5 3-5 3 2 3 2 6-2 6-2 6 3-3 3-6-2-6-2-6z" />
        </svg> -->
        <h1>Dashboard Areal &amp; Produksi</h1>
    </div>
    <div class="lm-header-right">
        <img src="{{ asset('ptpn1.png') }}" alt="PTPN 1">
    </div>
</header>

<div class="flux-wrapper">
    
    <!-- TOP HEADER / NAV BAR -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Executive Resume</h1>
                <!-- <span class="px-3 py-1 bg-lime-100 text-lime-800 text-xs font-bold rounded-full border border-lime-200">Areal & Produksi</span> -->
            </div>
            <p class="text-sm text-gray-500 mt-1 font-medium">Analisis rekapitulasi realisasi areal, produksi, dan produktivitas komoditi PTPN I</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <!-- DYNAMIC MONTH & YEAR FILTER FORM -->
            <form method="GET" action="{{ route('areal_produksi') }}" class="flex items-center gap-2 bg-white px-3 py-1.5 rounded-xl shadow-sm border border-gray-200">
                <i class="fa-solid fa-filter text-emerald-600 text-xs ml-1"></i>
                
                <!-- SELECT BULAN -->
                <select name="bulan" onchange="this.form.submit()" class="bg-transparent py-1 px-1.5 text-xs font-bold text-gray-800 focus:outline-none cursor-pointer">
                    @foreach($listBulan as $mNum => $mName)
                        <option value="{{ $mNum }}" {{ $bulanSelected == $mNum ? 'selected' : '' }}>
                            {{ $mName }}
                        </option>
                    @endforeach
                </select>

                <span class="text-gray-300">/</span>

                <!-- SELECT TAHUN -->
                <select name="tahun" onchange="this.form.submit()" class="bg-transparent py-1 px-1.5 text-xs font-bold text-gray-800 focus:outline-none cursor-pointer">
                    @foreach($listTahun as $y)
                        <option value="{{ $y }}" {{ $tahunSelected == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endforeach
                </select>
            </form>

            <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-200 text-xs font-semibold text-gray-700">
                <i class="fa-regular fa-calendar-check text-lime-600 text-sm"></i>
                <span>Posisi s/d <strong class="text-gray-900">{{ \Carbon\Carbon::parse($data['tanggal_akhir'])->locale('id')->translatedFormat('d F Y') }}</strong></span>
            </div>

            <button onclick="window.print()" class="flex items-center gap-2 bg-[#064e3b] hover:bg-[#043e2f] text-white px-4 py-2 rounded-xl shadow-md transition-all text-xs font-bold">
                <i class="fa-solid fa-arrow-down-to-line"></i>
                <span>Export / Cetak</span>
            </button>
        </div>
    </div>


    <!-- NAV LINK KE HALAMAN REGIONAL -->
    <div class="flex items-center gap-2 mb-6 border-b border-gray-200 pb-3">
        <span class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-xs shadow-md"
              style="background-color: #065f46; color: #ffffff; border: 1px solid #064e3b;">
            <i class="fa-solid fa-chart-pie" style="color: #a3e635;"></i>
            <span>Resume Eksekutif &amp; Tabel</span>
        </span>
        <a href="{{ route('areal_produksi.regional', ['bulan' => $bulanSelected, 'tahun' => $tahunSelected]) }}"
           class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-xs transition-all bg-white text-gray-600 border border-gray-200 hover:bg-emerald-50 hover:text-emerald-700 shadow-sm">
            <i class="fa-solid fa-chart-column" style="color: #059669;"></i>
            <span>Perbandingan Antar Regional</span>
            <i class="fa-solid fa-arrow-right text-xs" style="opacity: 0.5;"></i>
        </a>
    </div>

    <!-- KONTEN UTAMA -->
    <div>
        <!-- SUMMARY KPI CARDS (2 CARDS: PRODUKTIVITAS KARET & PRODUKTIVITAS TEH) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        
        <!-- CARD 1: PRODUKTIVITAS KARET REAL -->
        <div class="flux-card-lime p-6 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute -right-4 -bottom-4 opacity-15 text-white">
                <i class="fa-solid fa-tree text-9xl"></i>
            </div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <span class="text-xs font-extrabold uppercase tracking-wider text-lime-950 opacity-80">Produktivitas Karet Real</span>
                    <h3 class="text-3xl font-black mt-1 text-lime-950 num-mono">
                        {{ number_format($data['karet_total']['produktivitas']['real'], 2, ',', '.') }} <span class="text-sm font-semibold">Kg/Ha</span>
                    </h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-black/10 flex items-center justify-center text-lime-950">
                    <i class="fa-solid fa-arrow-up-right text-lg"></i>
                </div>
            </div>
            <div class="flex items-center gap-2 text-xs font-bold text-lime-950 bg-white/30 backdrop-blur-md px-3 py-1.5 rounded-lg w-fit">
                <i class="fa-solid fa-chart-line"></i>
                <span>Ach. RKAP: {{ number_format($data['karet_total']['produktivitas']['pct_rkap'], 1, ',', '.') }}%</span>
                <span class="opacity-60">|</span>
                <span>YoY: {{ number_format($data['karet_total']['produktivitas']['pct_thn_lalu'], 1, ',', '.') }}%</span>
            </div>
        </div>

        <!-- CARD 2: PRODUKTIVITAS TEH REAL (EMERALD ACCENT) -->
        <div class="flux-card-emerald p-6 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute -right-4 -bottom-4 opacity-15 text-white">
                <i class="fa-solid fa-leaf text-9xl"></i>
            </div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <span class="text-xs font-extrabold uppercase tracking-wider text-emerald-100 opacity-90">Produktivitas Teh Real</span>
                    <h3 class="text-3xl font-black mt-1 text-white num-mono">
                        {{ number_format($data['teh_total']['produktivitas']['real'], 2, ',', '.') }} <span class="text-sm font-semibold opacity-90">Kg/Ha</span>
                    </h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-white">
                    <i class="fa-solid fa-arrow-up-right text-lg"></i>
                </div>
            </div>
            <div class="flex items-center gap-2 text-xs font-bold text-white bg-white/20 backdrop-blur-md px-3 py-1.5 rounded-lg w-fit">
                <i class="fa-solid fa-chart-line"></i>
                <span>Ach. RKAP: {{ number_format($data['teh_total']['produktivitas']['pct_rkap'], 1, ',', '.') }}%</span>
                <span class="opacity-60">|</span>
                <span>YoY: {{ number_format($data['teh_total']['produktivitas']['pct_thn_lalu'], 1, ',', '.') }}%</span>
            </div>
        </div>

    </div>

    <!-- EXECUTIVE VISUAL ANALYTICS SECTION (3 COMPARISON CHARTS) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- CHART 1: LUAS AREAL TM -->
        <div class="flux-card p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-2">
                <div>
                    <h3 class="text-sm font-extrabold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-map-location-dot text-teal-600"></i>
                        Luas Areal TM (Ha)
                    </h3>
                    <p class="text-[11px] text-gray-500">RKAP vs Thn Lalu vs Realisasi</p>
                </div>
                <span class="text-[11px] font-bold text-teal-700 bg-teal-50 px-2 py-0.5 rounded border border-teal-200">Hektar</span>
            </div>
            <div id="chart-luas-compare" class="w-full h-60"></div>
        </div>

        <!-- CHART 2: PRODUKSI REAL -->
        <div class="flux-card p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-2">
                <div>
                    <h3 class="text-sm font-extrabold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-boxes-stacked text-lime-600"></i>
                        Produksi Total (Ton)
                    </h3>
                    <p class="text-[11px] text-gray-500">RKAP vs Thn Lalu vs Realisasi</p>
                </div>
                <span class="text-[11px] font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded">Ton</span>
            </div>
            <div id="chart-produksi-compare" class="w-full h-60"></div>
        </div>

        <!-- CHART 3: PRODUKTIVITAS / PROTAS -->
        <div class="flux-card p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-2">
                <div>
                    <h3 class="text-sm font-extrabold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-chart-line text-emerald-600"></i>
                        Produktivitas / Protas (Kg/Ha)
                    </h3>
                    <p class="text-[11px] text-gray-500">RKAP vs Thn Lalu vs Realisasi</p>
                </div>
                <span class="text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">Kg/Ha</span>
            </div>
            <div id="chart-protas-compare" class="w-full h-60"></div>
        </div>

    </div>

    <!-- MAIN DATA TABLE CARD -->
    <div class="flux-card p-6">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-5 mb-5 border-b border-gray-100 gap-4">
            <div>
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <span class="w-2.5 h-6 bg-[#064e3b] rounded-full inline-block"></span>
                    Rekapitulasi Kinerja Komoditi per Regional
                </h2>
                <p class="text-xs text-gray-500 mt-0.5">Perbandingan RKAP, Tahun Lalu, dan Realisasi posisi bulan berjalan</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                    <!-- <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Data Terverifikasi -->
                </span>
            </div>
        </div>

        <div class="overflow-x-auto custom-scroll rounded-xl border border-gray-200">
            <table class="flux-table">
                <thead>
                    <!-- HEADER LEVEL 1 -->
                    <tr style="background-color: #047857; color: #ffffff;">
                        <th rowspan="3" class="p-3 align-middle text-center border-r border-b border-emerald-600/50 w-24" style="background-color: #047857; color: #ffffff;">Komoditi</th>
                        <th rowspan="3" class="p-3 align-middle text-center border-r border-b border-emerald-600/50 w-16" style="background-color: #047857; color: #ffffff;">Reg.</th>
                        <th colspan="5" class="p-2.5 text-center border-b border-r border-emerald-600/50" style="background-color: #047857; color: #ffffff;">Luas Areal TM (Ha)</th>
                        <th colspan="5" class="p-2.5 text-center border-b border-r border-emerald-600/50" style="background-color: #047857; color: #ffffff;">Produksi (Kg)</th>
                        <th colspan="5" class="p-2.5 text-center border-b border-emerald-600/50" style="background-color: #047857; color: #ffffff;">Produktivitas (Kg/Ha)</th>
                    </tr>

                    <!-- HEADER LEVEL 2 -->
                    <tr class="text-xs" style="background-color: #047857; color: #ffffff;">
                        <!-- Luas -->
                        <th colspan="3" class="p-2 text-center border-b border-r border-emerald-600/50" style="background-color: #047857; color: #ffffff;">Jumlah</th>
                        <th colspan="2" class="p-2 text-center border-b border-r border-emerald-600/50" style="background-color: #047857; color: #ffffff;">Persentase (%)</th>
                        
                        <!-- Produksi -->
                        <th colspan="3" class="p-2 text-center border-b border-r border-emerald-600/50" style="background-color: #047857; color: #ffffff;">Jumlah</th>
                        <th colspan="2" class="p-2 text-center border-b border-r border-emerald-600/50" style="background-color: #047857; color: #ffffff;">Persentase (%)</th>
                        
                        <!-- Produktivitas -->
                        <th colspan="3" class="p-2 text-center border-b border-r border-emerald-600/50" style="background-color: #047857; color: #ffffff;">Jumlah</th>
                        <th colspan="2" class="p-2 text-center border-b border-emerald-600/50" style="background-color: #047857; color: #ffffff;">Persentase (%)</th>
                    </tr>

                    <!-- HEADER LEVEL 3 -->
                    <tr class="text-white text-[11px]" style="background-color: #047857; color: #ffffff;">
                        <!-- Luas -->
                        <th class="p-2 text-center border-r border-emerald-600/50 font-bold" style="background-color: #047857; color: #ffffff;">RKAP</th>
                        <th class="p-2 text-center border-r border-emerald-600/50 font-bold" style="background-color: #047857; color: #ffffff;">Thn Lalu</th>
                        <th class="p-2 text-center border-r border-emerald-600/50 font-bold" style="background-color: #047857; color: #ffffff;">Real</th>
                        <th class="p-2 text-center border-r border-emerald-600/50 font-bold" style="background-color: #047857; color: #ffffff;">RKAP</th>
                        <th class="p-2 text-center border-r border-emerald-600/50 font-bold" style="background-color: #047857; color: #ffffff;">Thn Lalu</th>

                        <!-- Produksi -->
                        <th class="p-2 text-center border-r border-emerald-600/50 font-bold" style="background-color: #047857; color: #ffffff;">RKAP</th>
                        <th class="p-2 text-center border-r border-emerald-600/50 font-bold" style="background-color: #047857; color: #ffffff;">Thn Lalu</th>
                        <th class="p-2 text-center border-r border-emerald-600/50 font-bold" style="background-color: #047857; color: #ffffff;">Real</th>
                        <th class="p-2 text-center border-r border-emerald-600/50 font-bold" style="background-color: #047857; color: #ffffff;">RKAP</th>
                        <th class="p-2 text-center border-r border-emerald-600/50 font-bold" style="background-color: #047857; color: #ffffff;">Thn Lalu</th>

                        <!-- Produktivitas -->
                        <th class="p-2 text-center border-r border-emerald-600/50 font-bold" style="background-color: #047857; color: #ffffff;">RKAP</th>
                        <th class="p-2 text-center border-r border-emerald-600/50 font-bold" style="background-color: #047857; color: #ffffff;">Thn Lalu</th>
                        <th class="p-2 text-center border-r border-emerald-600/50 font-bold" style="background-color: #047857; color: #ffffff;">Real</th>
                        <th class="p-2 text-center border-r border-emerald-600/50 font-bold" style="background-color: #047857; color: #ffffff;">RKAP</th>
                        <th class="p-2 text-center font-bold" style="background-color: #047857; color: #ffffff;">Thn Lalu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    
                    <!-- ==================================================== -->
                    <!-- KARET SECTION -->
                    <!-- ==================================================== -->
                    @foreach($regionals as $index => $reg)
                        <tr class="hover:bg-lime-50/60 transition-colors">
                            @if($index == 0)
                                <td rowspan="{{ count($regionals) + 1 }}" class="p-3 text-center font-extrabold align-middle border-r border-lime-200" style="background-color: #ecfccb; color: #1a2e05;">
                                    <div class="flex flex-col items-center justify-center gap-1.5">
                                        <i class="fa-solid fa-tree text-lg" style="color: #4d7c0f;"></i>
                                        <span class="tracking-wider font-black">KARET</span>
                                    </div>
                                </td>
                            @endif
                            <td class="p-2 text-center font-bold text-gray-700 border-r border-gray-200 bg-gray-50/50">{{ $reg }}</td>
                            
                            <!-- Luas -->
                            <td class="p-2 text-right num-mono text-gray-600 border-r border-gray-100">{{ number_format($data['karet'][$reg]['luas']['rkap'], 2, ',', '.') }}</td>
                            <td class="p-2 text-right num-mono text-gray-600 border-r border-gray-100">{{ number_format($data['karet'][$reg]['luas']['thn_lalu'], 2, ',', '.') }}</td>
                            <td class="p-2 text-right num-mono font-bold text-gray-900 border-r border-gray-100" style="background-color: #f7fee7;">{{ number_format($data['karet'][$reg]['luas']['real'], 2, ',', '.') }}</td>
                            <td class="p-2 text-center num-mono border-r border-gray-100 font-medium" style="{{ $data['karet'][$reg]['luas']['pct_rkap'] < 100 ? 'color: #dc2626; font-weight: 700;' : 'color: #374151;' }}">{{ number_format($data['karet'][$reg]['luas']['pct_rkap'], 2, ',', '.') }}%</td>
                            <td class="p-2 text-center num-mono border-r border-gray-300 font-medium" style="{{ $data['karet'][$reg]['luas']['pct_thn_lalu'] < 100 ? 'color: #dc2626; font-weight: 700;' : 'color: #374151;' }}">{{ number_format($data['karet'][$reg]['luas']['pct_thn_lalu'], 2, ',', '.') }}%</td>
                            
                            <!-- Produksi -->
                            <td class="p-2 text-right num-mono text-gray-600 border-r border-gray-100">{{ number_format($data['karet'][$reg]['produksi']['rkap'], 2, ',', '.') }}</td>
                            <td class="p-2 text-right num-mono text-gray-600 border-r border-gray-100">{{ number_format($data['karet'][$reg]['produksi']['thn_lalu'], 2, ',', '.') }}</td>
                            <td class="p-2 text-right num-mono font-bold text-gray-900 border-r border-gray-100" style="background-color: #f7fee7;">{{ number_format($data['karet'][$reg]['produksi']['real'], 2, ',', '.') }}</td>
                            <td class="p-2 text-center num-mono border-r border-gray-100 font-medium" style="{{ $data['karet'][$reg]['produksi']['pct_rkap'] < 100 ? 'color: #dc2626; font-weight: 700;' : 'color: #374151;' }}">{{ number_format($data['karet'][$reg]['produksi']['pct_rkap'], 2, ',', '.') }}%</td>
                            <td class="p-2 text-center num-mono border-r border-gray-300 font-medium" style="{{ $data['karet'][$reg]['produksi']['pct_thn_lalu'] < 100 ? 'color: #dc2626; font-weight: 700;' : 'color: #374151;' }}">{{ number_format($data['karet'][$reg]['produksi']['pct_thn_lalu'], 2, ',', '.') }}%</td>
                            
                            <!-- Produktivitas -->
                            <td class="p-2 text-right num-mono text-gray-600 border-r border-gray-100">{{ number_format($data['karet'][$reg]['produktivitas']['rkap'], 2, ',', '.') }}</td>
                            <td class="p-2 text-right num-mono text-gray-600 border-r border-gray-100">{{ number_format($data['karet'][$reg]['produktivitas']['thn_lalu'], 2, ',', '.') }}</td>
                            <td class="p-2 text-right num-mono font-bold text-gray-900 border-r border-gray-100" style="background-color: #f7fee7;">{{ number_format($data['karet'][$reg]['produktivitas']['real'], 2, ',', '.') }}</td>
                            <td class="p-2 text-center num-mono border-r border-gray-100 font-medium" style="{{ $data['karet'][$reg]['produktivitas']['pct_rkap'] < 100 ? 'color: #dc2626; font-weight: 700;' : 'color: #374151;' }}">{{ number_format($data['karet'][$reg]['produktivitas']['pct_rkap'], 2, ',', '.') }}%</td>
                            <td class="p-2 text-center num-mono font-medium" style="{{ $data['karet'][$reg]['produktivitas']['pct_thn_lalu'] < 100 ? 'color: #dc2626; font-weight: 700;' : 'color: #374151;' }}">{{ number_format($data['karet'][$reg]['produktivitas']['pct_thn_lalu'], 2, ',', '.') }}%</td>
                        </tr>
                    @endforeach

                    <!-- TOTAL KARET -->
                    <tr class="font-bold text-gray-900 border-t-2 border-lime-400" style="background-color: #d9f99d; color: #1a2e05;">
                        <td class="p-2.5 text-center font-black border-r border-lime-400/50" style="background-color: #d9f99d; color: #1a2e05;">JUMLAH</td>
                        
                        <!-- Luas -->
                        <td class="p-2.5 text-right num-mono border-r border-lime-400/40">{{ number_format($data['karet_total']['luas']['rkap'], 2, ',', '.') }}</td>
                        <td class="p-2.5 text-right num-mono border-r border-lime-400/40">{{ number_format($data['karet_total']['luas']['thn_lalu'], 2, ',', '.') }}</td>
                        <td class="p-2.5 text-right num-mono font-black border-r border-lime-400/40">{{ number_format($data['karet_total']['luas']['real'], 2, ',', '.') }}</td>
                        <td class="p-2.5 text-center num-mono border-r border-lime-400/40" style="{{ $data['karet_total']['luas']['pct_rkap'] < 100 ? 'color: #b91c1c; font-weight: 800;' : '' }}">{{ number_format($data['karet_total']['luas']['pct_rkap'], 2, ',', '.') }}%</td>
                        <td class="p-2.5 text-center num-mono border-r border-lime-400/60" style="{{ $data['karet_total']['luas']['pct_thn_lalu'] < 100 ? 'color: #b91c1c; font-weight: 800;' : '' }}">{{ number_format($data['karet_total']['luas']['pct_thn_lalu'], 2, ',', '.') }}%</td>
                        
                        <!-- Produksi -->
                        <td class="p-2.5 text-right num-mono border-r border-lime-400/40">{{ number_format($data['karet_total']['produksi']['rkap'], 2, ',', '.') }}</td>
                        <td class="p-2.5 text-right num-mono border-r border-lime-400/40">{{ number_format($data['karet_total']['produksi']['thn_lalu'], 2, ',', '.') }}</td>
                        <td class="p-2.5 text-right num-mono font-black border-r border-lime-400/40">{{ number_format($data['karet_total']['produksi']['real'], 2, ',', '.') }}</td>
                        <td class="p-2.5 text-center num-mono border-r border-lime-400/40" style="{{ $data['karet_total']['produksi']['pct_rkap'] < 100 ? 'color: #b91c1c; font-weight: 800;' : '' }}">{{ number_format($data['karet_total']['produksi']['pct_rkap'], 2, ',', '.') }}%</td>
                        <td class="p-2.5 text-center num-mono border-r border-lime-400/60" style="{{ $data['karet_total']['produksi']['pct_thn_lalu'] < 100 ? 'color: #b91c1c; font-weight: 800;' : '' }}">{{ number_format($data['karet_total']['produksi']['pct_thn_lalu'], 2, ',', '.') }}%</td>
                        
                        <!-- Produktivitas -->
                        <td class="p-2.5 text-right num-mono border-r border-lime-400/40">{{ number_format($data['karet_total']['produktivitas']['rkap'], 2, ',', '.') }}</td>
                        <td class="p-2.5 text-right num-mono border-r border-lime-400/40">{{ number_format($data['karet_total']['produktivitas']['thn_lalu'], 2, ',', '.') }}</td>
                        <td class="p-2.5 text-right num-mono font-black border-r border-lime-400/40">{{ number_format($data['karet_total']['produktivitas']['real'], 2, ',', '.') }}</td>
                        <td class="p-2.5 text-center num-mono border-r border-lime-400/40" style="{{ $data['karet_total']['produktivitas']['pct_rkap'] < 100 ? 'color: #b91c1c; font-weight: 800;' : '' }}">{{ number_format($data['karet_total']['produktivitas']['pct_rkap'], 2, ',', '.') }}%</td>
                        <td class="p-2.5 text-center num-mono" style="{{ $data['karet_total']['produktivitas']['pct_thn_lalu'] < 100 ? 'color: #b91c1c; font-weight: 800;' : '' }}">{{ number_format($data['karet_total']['produktivitas']['pct_thn_lalu'], 2, ',', '.') }}%</td>
                    </tr>

                    <!-- SPACER ROW -->
                    <tr class="bg-gray-100/50"><td colspan="17" class="h-3 p-0"></td></tr>

                    <!-- ==================================================== -->
                    <!-- TEH SECTION -->
                    <!-- ==================================================== -->
                    @foreach($regionals as $index => $reg)
                        <tr class="hover:bg-emerald-50/60 transition-colors">
                            @if($index == 0)
                                <td rowspan="{{ count($regionals) + 1 }}" class="p-3 text-center font-extrabold align-middle border-r border-emerald-200" style="background-color: #d1fae5; color: #064e3b;">
                                    <div class="flex flex-col items-center justify-center gap-1.5">
                                        <i class="fa-solid fa-leaf text-lg" style="color: #047857;"></i>
                                        <span class="tracking-wider font-black">TEH</span>
                                    </div>
                                </td>
                            @endif
                            <td class="p-2 text-center font-bold text-gray-700 border-r border-gray-200 bg-gray-50/50">{{ $reg }}</td>
                            
                            <!-- Luas -->
                            <td class="p-2 text-right num-mono text-gray-600 border-r border-gray-100">{{ number_format($data['teh'][$reg]['luas']['rkap'], 2, ',', '.') }}</td>
                            <td class="p-2 text-right num-mono text-gray-600 border-r border-gray-100">{{ number_format($data['teh'][$reg]['luas']['thn_lalu'], 2, ',', '.') }}</td>
                            <td class="p-2 text-right num-mono font-bold text-gray-900 border-r border-gray-100" style="background-color: #ecfdf5;">{{ number_format($data['teh'][$reg]['luas']['real'], 2, ',', '.') }}</td>
                            <td class="p-2 text-center num-mono border-r border-gray-100 font-medium" style="{{ $data['teh'][$reg]['luas']['pct_rkap'] < 100 ? 'color: #dc2626; font-weight: 700;' : 'color: #374151;' }}">{{ number_format($data['teh'][$reg]['luas']['pct_rkap'], 2, ',', '.') }}%</td>
                            <td class="p-2 text-center num-mono border-r border-gray-300 font-medium" style="{{ $data['teh'][$reg]['luas']['pct_thn_lalu'] < 100 ? 'color: #dc2626; font-weight: 700;' : 'color: #374151;' }}">{{ number_format($data['teh'][$reg]['luas']['pct_thn_lalu'], 2, ',', '.') }}%</td>
                            
                            <!-- Produksi -->
                            <td class="p-2 text-right num-mono text-gray-600 border-r border-gray-100">{{ number_format($data['teh'][$reg]['produksi']['rkap'], 2, ',', '.') }}</td>
                            <td class="p-2 text-right num-mono text-gray-600 border-r border-gray-100">{{ number_format($data['teh'][$reg]['produksi']['thn_lalu'], 2, ',', '.') }}</td>
                            <td class="p-2 text-right num-mono font-bold text-gray-900 border-r border-gray-100" style="background-color: #ecfdf5;">{{ number_format($data['teh'][$reg]['produksi']['real'], 2, ',', '.') }}</td>
                            <td class="p-2 text-center num-mono border-r border-gray-100 font-medium" style="{{ $data['teh'][$reg]['produksi']['pct_rkap'] < 100 ? 'color: #dc2626; font-weight: 700;' : 'color: #374151;' }}">{{ number_format($data['teh'][$reg]['produksi']['pct_rkap'], 2, ',', '.') }}%</td>
                            <td class="p-2 text-center num-mono border-r border-gray-300 font-medium" style="{{ $data['teh'][$reg]['produksi']['pct_thn_lalu'] < 100 ? 'color: #dc2626; font-weight: 700;' : 'color: #374151;' }}">{{ number_format($data['teh'][$reg]['produksi']['pct_thn_lalu'], 2, ',', '.') }}%</td>
                            
                            <!-- Produktivitas -->
                            <td class="p-2 text-right num-mono text-gray-600 border-r border-gray-100">{{ number_format($data['teh'][$reg]['produktivitas']['rkap'], 2, ',', '.') }}</td>
                            <td class="p-2 text-right num-mono text-gray-600 border-r border-gray-100">{{ number_format($data['teh'][$reg]['produktivitas']['thn_lalu'], 2, ',', '.') }}</td>
                            <td class="p-2 text-right num-mono font-bold text-gray-900 border-r border-gray-100" style="background-color: #ecfdf5;">{{ number_format($data['teh'][$reg]['produktivitas']['real'], 2, ',', '.') }}</td>
                            <td class="p-2 text-center num-mono border-r border-gray-100 font-medium" style="{{ $data['teh'][$reg]['produktivitas']['pct_rkap'] < 100 ? 'color: #dc2626; font-weight: 700;' : 'color: #374151;' }}">{{ number_format($data['teh'][$reg]['produktivitas']['pct_rkap'], 2, ',', '.') }}%</td>
                            <td class="p-2 text-center num-mono font-medium" style="{{ $data['teh'][$reg]['produktivitas']['pct_thn_lalu'] < 100 ? 'color: #dc2626; font-weight: 700;' : 'color: #374151;' }}">{{ number_format($data['teh'][$reg]['produktivitas']['pct_thn_lalu'], 2, ',', '.') }}%</td>
                        </tr>
                    @endforeach

                    <!-- TOTAL TEH -->
                    <tr class="font-bold text-gray-900 border-t-2 border-emerald-400" style="background-color: #a7f3d0; color: #064e3b;">
                        <td class="p-2.5 text-center font-black border-r border-emerald-400/50" style="background-color: #a7f3d0; color: #064e3b;">JUMLAH</td>
                        
                        <!-- Luas -->
                        <td class="p-2.5 text-right num-mono border-r border-emerald-400/40">{{ number_format($data['teh_total']['luas']['rkap'], 2, ',', '.') }}</td>
                        <td class="p-2.5 text-right num-mono border-r border-emerald-400/40">{{ number_format($data['teh_total']['luas']['thn_lalu'], 2, ',', '.') }}</td>
                        <td class="p-2.5 text-right num-mono font-black border-r border-emerald-400/40">{{ number_format($data['teh_total']['luas']['real'], 2, ',', '.') }}</td>
                        <td class="p-2.5 text-center num-mono border-r border-emerald-400/40" style="{{ $data['teh_total']['luas']['pct_rkap'] < 100 ? 'color: #b91c1c; font-weight: 800;' : '' }}">{{ number_format($data['teh_total']['luas']['pct_rkap'], 2, ',', '.') }}%</td>
                        <td class="p-2.5 text-center num-mono border-r border-emerald-400/60" style="{{ $data['teh_total']['luas']['pct_thn_lalu'] < 100 ? 'color: #b91c1c; font-weight: 800;' : '' }}">{{ number_format($data['teh_total']['luas']['pct_thn_lalu'], 2, ',', '.') }}%</td>
                        
                        <!-- Produksi -->
                        <td class="p-2.5 text-right num-mono border-r border-emerald-400/40">{{ number_format($data['teh_total']['produksi']['rkap'], 2, ',', '.') }}</td>
                        <td class="p-2.5 text-right num-mono border-r border-emerald-400/40">{{ number_format($data['teh_total']['produksi']['thn_lalu'], 2, ',', '.') }}</td>
                        <td class="p-2.5 text-right num-mono font-black border-r border-emerald-400/40">{{ number_format($data['teh_total']['produksi']['real'], 2, ',', '.') }}</td>
                        <td class="p-2.5 text-center num-mono border-r border-emerald-400/40" style="{{ $data['teh_total']['produksi']['pct_rkap'] < 100 ? 'color: #b91c1c; font-weight: 800;' : '' }}">{{ number_format($data['teh_total']['produksi']['pct_rkap'], 2, ',', '.') }}%</td>
                        <td class="p-2.5 text-center num-mono border-r border-emerald-400/60" style="{{ $data['teh_total']['produksi']['pct_thn_lalu'] < 100 ? 'color: #b91c1c; font-weight: 800;' : '' }}">{{ number_format($data['teh_total']['produksi']['pct_thn_lalu'], 2, ',', '.') }}%</td>
                        
                        <!-- Produktivitas -->
                        <td class="p-2.5 text-right num-mono border-r border-emerald-400/40">{{ number_format($data['teh_total']['produktivitas']['rkap'], 2, ',', '.') }}</td>
                        <td class="p-2.5 text-right num-mono border-r border-emerald-400/40">{{ number_format($data['teh_total']['produktivitas']['thn_lalu'], 2, ',', '.') }}</td>
                        <td class="p-2.5 text-right num-mono font-black border-r border-emerald-400/40">{{ number_format($data['teh_total']['produktivitas']['real'], 2, ',', '.') }}</td>
                        <td class="p-2.5 text-center num-mono border-r border-emerald-400/40" style="{{ $data['teh_total']['produktivitas']['pct_rkap'] < 100 ? 'color: #b91c1c; font-weight: 800;' : '' }}">{{ number_format($data['teh_total']['produktivitas']['pct_rkap'], 2, ',', '.') }}%</td>
                        <td class="p-2.5 text-center num-mono" style="{{ $data['teh_total']['produktivitas']['pct_thn_lalu'] < 100 ? 'color: #b91c1c; font-weight: 800;' : '' }}">{{ number_format($data['teh_total']['produktivitas']['pct_thn_lalu'], 2, ',', '.') }}%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- END KONTEN UTAMA -->

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var kategoris = ['Karet', 'Teh'];
    var font = 'Plus Jakarta Sans, sans-serif';

    function makeBar(series, unit) {
        return {
            series: series,
            chart: { type: 'bar', height: 230, toolbar: { show: false }, fontFamily: font },
            colors: ['#0284c7', '#f59e0b', '#10b981'],
            plotOptions: { bar: { horizontal: false, columnWidth: '55%', borderRadius: 4 } },
            dataLabels: { enabled: false },
            stroke: { show: true, width: 2, colors: ['transparent'] },
            xaxis: { categories: kategoris, labels: { style: { fontSize: '11px', fontWeight: 700 } } },
            yaxis: { labels: { formatter: function(v) { return v.toLocaleString('id-ID'); } } },
            tooltip: { y: { formatter: function(v) { return v.toLocaleString('id-ID', { maximumFractionDigits: 2 }) + ' ' + unit; } } },
            legend: { position: 'top', fontSize: '11px', fontWeight: 600 }
        };
    }

    new ApexCharts(document.getElementById('chart-luas-compare'), makeBar([
        { name: 'RKAP (Target)',    data: [{{ round($data['karet_total']['luas']['rkap'], 1) }}, {{ round($data['teh_total']['luas']['rkap'], 1) }}] },
        { name: 'Tahun Lalu (YoY)', data: [{{ round($data['karet_total']['luas']['thn_lalu'], 1) }}, {{ round($data['teh_total']['luas']['thn_lalu'], 1) }}] },
        { name: 'Realisasi',        data: [{{ round($data['karet_total']['luas']['real'], 1) }}, {{ round($data['teh_total']['luas']['real'], 1) }}] }
    ], 'Ha')).render();

    new ApexCharts(document.getElementById('chart-produksi-compare'), makeBar([
        { name: 'RKAP (Target)',    data: [{{ round($data['karet_total']['produksi']['rkap'] / 1000, 1) }}, {{ round($data['teh_total']['produksi']['rkap'] / 1000, 1) }}] },
        { name: 'Tahun Lalu (YoY)', data: [{{ round($data['karet_total']['produksi']['thn_lalu'] / 1000, 1) }}, {{ round($data['teh_total']['produksi']['thn_lalu'] / 1000, 1) }}] },
        { name: 'Realisasi',        data: [{{ round($data['karet_total']['produksi']['real'] / 1000, 1) }}, {{ round($data['teh_total']['produksi']['real'] / 1000, 1) }}] }
    ], 'Ton')).render();

    new ApexCharts(document.getElementById('chart-protas-compare'), makeBar([
        { name: 'RKAP (Target)',    data: [{{ round($data['karet_total']['produktivitas']['rkap'], 1) }}, {{ round($data['teh_total']['produktivitas']['rkap'], 1) }}] },
        { name: 'Tahun Lalu (YoY)', data: [{{ round($data['karet_total']['produktivitas']['thn_lalu'], 1) }}, {{ round($data['teh_total']['produktivitas']['thn_lalu'], 1) }}] },
        { name: 'Realisasi',        data: [{{ round($data['karet_total']['produktivitas']['real'], 1) }}, {{ round($data['teh_total']['produktivitas']['real'], 1) }}] }
    ], 'Kg/Ha')).render();
});
</script>
@endsection
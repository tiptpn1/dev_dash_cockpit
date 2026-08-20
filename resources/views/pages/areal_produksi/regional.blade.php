@extends('layouts.app')

@section('title', 'Perbandingan Antar Regional - Areal & Produksi')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<style>
    html, body { height: auto !important; min-height: 100vh; overflow-y: auto !important; background-color: #f3f4f6 !important; font-family: 'Plus Jakarta Sans', sans-serif !important; }
    .main-content { height: auto !important; overflow-y: auto !important; padding: 0 !important; margin-left: 0 !important; }
    .flux-wrapper { background-color: #f3f4f6; min-height: 100vh; padding: 28px 32px 60px 32px; }
    .flux-card { background: #ffffff; border-radius: 20px; box-shadow: 0 4px 20px -2px rgba(0,0,0,0.04); border: 1px solid #f1f5f9; }
    .lm-page-header { display: flex; align-items: center; justify-content: space-between; padding: 8px 32px; background: #ffffff; border-bottom: 1px solid #e5e7eb; min-height: 56px; position: relative; }
    .lm-header-logo { width: 130px; height: 44px; display: flex; align-items: center; }
    .lm-header-logo img { width: 100%; height: 100%; object-fit: contain; }
    .lm-header-center { position: absolute; left: 50%; transform: translateX(-50%); display: flex; align-items: center; }
    .lm-header-center h1 { font-size: 1.5rem; font-weight: 700; color: #166534; margin: 0; }
    .lm-header-right img { height: 44px; width: auto; object-fit: contain; }
    .num-mono { font-variant-numeric: tabular-nums; }
    .custom-scroll::-webkit-scrollbar { height: 6px; width: 6px; }
    .custom-scroll::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
    .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
</style>

<!-- TOP BANNER -->
<header class="lm-page-header">
    <div class="lm-header-logo"><img src="{{ asset('danantara.png') }}" alt="Danantara"></div>
    <div class="lm-header-center"><h1>Dashboard Areal &amp; Produksi</h1></div>
    <div class="lm-header-right"><img src="{{ asset('ptpn1.png') }}" alt="PTPN 1"></div>
</header>

<div class="flux-wrapper">

    <!-- PAGE HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div class="flex flex-col gap-1.5">
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Perbandingan Antar Regional</h1>
            <p class="text-sm text-gray-500 font-medium">Benchmarking performa produksi dan produktivitas Karet &amp; Teh per Regional</p>
            <a href="{{ route('areal_produksi', ['bulan' => $bulanSelected, 'tahun' => $tahunSelected]) }}"
               class="inline-flex items-center gap-1.5 text-sm font-bold transition-colors w-max mt-1 px-3 py-1.5 rounded-lg"
               style="color: #047857; background-color: #ecfdf5; border: 1px solid #d1fae5;">
                <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Resume Eksekutif
            </a>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <!-- FILTER -->
            <form method="GET" action="{{ route('areal_produksi.regional') }}" class="flex items-center gap-2 bg-white px-3 py-1.5 rounded-xl shadow-sm border border-gray-200">
                <i class="fa-solid fa-filter text-emerald-600 text-xs ml-1"></i>
                <select name="bulan" onchange="this.form.submit()" class="bg-transparent py-1 px-1.5 text-xs font-bold text-gray-800 focus:outline-none cursor-pointer">
                    @foreach($listBulan as $mNum => $mName)
                        <option value="{{ $mNum }}" {{ $bulanSelected == $mNum ? 'selected' : '' }}>{{ $mName }}</option>
                    @endforeach
                </select>
                <span class="text-gray-300">/</span>
                <select name="tahun" onchange="this.form.submit()" class="bg-transparent py-1 px-1.5 text-xs font-bold text-gray-800 focus:outline-none cursor-pointer">
                    @foreach($listTahun as $y)
                        <option value="{{ $y }}" {{ $tahunSelected == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </form>
            <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-200 text-xs font-semibold text-gray-700">
                <i class="fa-regular fa-calendar-check text-lime-600 text-sm"></i>
                <span>Posisi s/d <strong class="text-gray-900">{{ \Carbon\Carbon::parse($data['tanggal_akhir'])->locale('id')->translatedFormat('d F Y') }}</strong></span>
            </div>
        </div>
    </div>


    <!-- ROW 1: CHART PRODUKSI KARET & TEH -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="flux-card p-6">
            <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-100">
                <div>
                    <h3 class="font-bold text-sm text-gray-900 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-lime-500 inline-block"></span>
                        Produksi Karet per Regional (Ton)
                    </h3>
                    <p class="text-xs text-gray-400 mt-0.5">Perbandingan RKAP, Thn Lalu, dan Realisasi</p>
                </div>
                <span class="px-2.5 py-1 bg-lime-50 text-lime-700 text-xs font-bold rounded-lg border border-lime-200">Karet</span>
            </div>
            <div id="chart-reg-karet-prod"></div>
        </div>

        <div class="flux-card p-6">
            <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-100">
                <div>
                    <h3 class="font-bold text-sm text-gray-900 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-600 inline-block"></span>
                        Produksi Teh per Regional (Ton)
                    </h3>
                    <p class="text-xs text-gray-400 mt-0.5">Perbandingan RKAP, Thn Lalu, dan Realisasi</p>
                </div>
                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-lg border border-emerald-200">Teh</span>
            </div>
            <div id="chart-reg-teh-prod"></div>
        </div>
    </div>

    <!-- ROW 2: CHART PRODUKTIVITAS KARET & TEH -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- CHART 3: PRODUKTIVITAS KARET PER REGIONAL -->
        <div class="flux-card p-6">
            <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-100">
                <div>
                    <h3 class="font-bold text-sm text-gray-900 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-lime-500 inline-block"></span>
                        Produktivitas Karet per Regional (Kg/Ha)
                    </h3>
                    <p class="text-xs text-gray-400 mt-0.5">Perbandingan RKAP, Thn Lalu, dan Realisasi</p>
                </div>
                <span class="px-2.5 py-1 bg-lime-50 text-lime-700 text-xs font-bold rounded-lg border border-lime-200">Karet</span>
            </div>
            <div id="chart-reg-karet-protas"></div>
        </div>

        <!-- CHART 4: PRODUKTIVITAS TEH PER REGIONAL -->
        <div class="flux-card p-6">
            <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-100">
                <div>
                    <h3 class="font-bold text-sm text-gray-900 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-600 inline-block"></span>
                        Produktivitas Teh per Regional (Kg/Ha)
                    </h3>
                    <p class="text-xs text-gray-400 mt-0.5">Perbandingan RKAP, Thn Lalu, dan Realisasi</p>
                </div>
                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-lg border border-emerald-200">Teh</span>
            </div>
            <div id="chart-reg-teh-protas"></div>
        </div>
    </div>

    <!-- ROW 3: PIE CHART KOMPOSISI PRODUKSI -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- PIE CHART KARET -->
        <div class="flux-card p-6">
            <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-100">
                <div>
                    <h3 class="font-bold text-sm text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-chart-pie text-lime-500"></i>
                        Komposisi Produksi Karet per Regional
                    </h3>
                    <p class="text-xs text-gray-400 mt-0.5">Proporsi kontribusi realisasi produksi</p>
                </div>
                <span class="px-2.5 py-1 bg-lime-50 text-lime-700 text-xs font-bold rounded-lg border border-lime-200">Karet</span>
            </div>
            <div id="chart-pie-karet" class="flex justify-center mt-4"></div>
        </div>

        <!-- PIE CHART TEH -->
        <div class="flux-card p-6">
            <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-100">
                <div>
                    <h3 class="font-bold text-sm text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-chart-pie text-emerald-600"></i>
                        Komposisi Produksi Teh per Regional
                    </h3>
                    <p class="text-xs text-gray-400 mt-0.5">Proporsi kontribusi realisasi produksi</p>
                </div>
                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-lg border border-emerald-200">Teh</span>
            </div>
            <div id="chart-pie-teh" class="flex justify-center mt-4"></div>
        </div>
    </div>

</div>

{{-- Data embed sebagai JSON --}}
<script id="ap-reg-data" type="application/json">
{!! json_encode([
    'labels'        => array_values(array_map(fn($r) => 'Reg. ' . $r, $regionals)),
    'karetProdRkap' => array_values(array_map(fn($r) => round($data['karet'][$r]['produksi']['rkap'] / 1000, 1), $regionals)),
    'karetProdLalu' => array_values(array_map(fn($r) => round($data['karet'][$r]['produksi']['thn_lalu'] / 1000, 1), $regionals)),
    'karetProdReal' => array_values(array_map(fn($r) => round($data['karet'][$r]['produksi']['real'] / 1000, 1), $regionals)),
    'tehProdRkap'   => array_values(array_map(fn($r) => round($data['teh'][$r]['produksi']['rkap'] / 1000, 1), $regionals)),
    'tehProdLalu'   => array_values(array_map(fn($r) => round($data['teh'][$r]['produksi']['thn_lalu'] / 1000, 1), $regionals)),
    'tehProdReal'   => array_values(array_map(fn($r) => round($data['teh'][$r]['produksi']['real'] / 1000, 1), $regionals)),
    'karetProtasRkap' => array_values(array_map(fn($r) => round($data['karet'][$r]['produktivitas']['rkap'], 1), $regionals)),
    'karetProtasLalu' => array_values(array_map(fn($r) => round($data['karet'][$r]['produktivitas']['thn_lalu'], 1), $regionals)),
    'karetProtasReal' => array_values(array_map(fn($r) => round($data['karet'][$r]['produktivitas']['real'], 1), $regionals)),
    'tehProtasRkap'   => array_values(array_map(fn($r) => round($data['teh'][$r]['produktivitas']['rkap'], 1), $regionals)),
    'tehProtasLalu'   => array_values(array_map(fn($r) => round($data['teh'][$r]['produktivitas']['thn_lalu'], 1), $regionals)),
    'tehProtasReal'   => array_values(array_map(fn($r) => round($data['teh'][$r]['produktivitas']['real'], 1), $regionals)),
]) !!}
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var D = JSON.parse(document.getElementById('ap-reg-data').textContent);
    var font = 'Plus Jakarta Sans, sans-serif';
    var labels = D.labels;

    // Chart 1: Produksi Karet
    new ApexCharts(document.getElementById('chart-reg-karet-prod'), {
        series: [
            { name: 'RKAP',      data: D.karetProdRkap },
            { name: 'Thn Lalu',  data: D.karetProdLalu },
            { name: 'Realisasi', data: D.karetProdReal }
        ],
        chart: { type: 'bar', height: 280, toolbar: { show: false }, fontFamily: font },
        colors: ['#0284c7', '#f59e0b', '#84cc16'],
        plotOptions: { bar: { horizontal: false, columnWidth: '60%', borderRadius: 4 } },
        dataLabels: { enabled: false },
        xaxis: { categories: labels, labels: { style: { fontSize: '11px', fontWeight: 700 } } },
        yaxis: { labels: { formatter: function(v) { return v.toLocaleString('id-ID'); } } },
        tooltip: { y: { formatter: function(v) { return v.toLocaleString('id-ID') + ' Ton'; } } },
        legend: { position: 'top', fontSize: '11px', fontWeight: 600 },
        grid: { borderColor: '#f0f0f0' }
    }).render();

    // Chart 2: Produksi Teh
    new ApexCharts(document.getElementById('chart-reg-teh-prod'), {
        series: [
            { name: 'RKAP',      data: D.tehProdRkap },
            { name: 'Thn Lalu',  data: D.tehProdLalu },
            { name: 'Realisasi', data: D.tehProdReal }
        ],
        chart: { type: 'bar', height: 280, toolbar: { show: false }, fontFamily: font },
        colors: ['#0284c7', '#f59e0b', '#10b981'],
        plotOptions: { bar: { horizontal: false, columnWidth: '60%', borderRadius: 4 } },
        dataLabels: { enabled: false },
        xaxis: { categories: labels, labels: { style: { fontSize: '11px', fontWeight: 700 } } },
        yaxis: { labels: { formatter: function(v) { return v.toLocaleString('id-ID'); } } },
        tooltip: { y: { formatter: function(v) { return v.toLocaleString('id-ID') + ' Ton'; } } },
        legend: { position: 'top', fontSize: '11px', fontWeight: 600 },
        grid: { borderColor: '#f0f0f0' }
    }).render();

    // Chart 3: Produktivitas Karet
    new ApexCharts(document.getElementById('chart-reg-karet-protas'), {
        series: [
            { name: 'RKAP',      data: D.karetProtasRkap },
            { name: 'Thn Lalu',  data: D.karetProtasLalu },
            { name: 'Realisasi', data: D.karetProtasReal }
        ],
        chart: { type: 'bar', height: 280, toolbar: { show: false }, fontFamily: font },
        colors: ['#0284c7', '#f59e0b', '#84cc16'],
        plotOptions: { bar: { horizontal: false, columnWidth: '60%', borderRadius: 4 } },
        dataLabels: { enabled: false },
        xaxis: { categories: labels, labels: { style: { fontSize: '11px', fontWeight: 700 } } },
        yaxis: { labels: { formatter: function(v) { return v.toLocaleString('id-ID'); } } },
        tooltip: { y: { formatter: function(v) { return v.toLocaleString('id-ID') + ' Kg/Ha'; } } },
        legend: { position: 'top', fontSize: '11px', fontWeight: 600 },
        grid: { borderColor: '#f0f0f0' }
    }).render();

    // Chart 4: Produktivitas Teh
    new ApexCharts(document.getElementById('chart-reg-teh-protas'), {
        series: [
            { name: 'RKAP',      data: D.tehProtasRkap },
            { name: 'Thn Lalu',  data: D.tehProtasLalu },
            { name: 'Realisasi', data: D.tehProtasReal }
        ],
        chart: { type: 'bar', height: 280, toolbar: { show: false }, fontFamily: font },
        colors: ['#0284c7', '#f59e0b', '#10b981'],
        plotOptions: { bar: { horizontal: false, columnWidth: '60%', borderRadius: 4 } },
        dataLabels: { enabled: false },
        xaxis: { categories: labels, labels: { style: { fontSize: '11px', fontWeight: 700 } } },
        yaxis: { labels: { formatter: function(v) { return v.toLocaleString('id-ID'); } } },
        tooltip: { y: { formatter: function(v) { return v.toLocaleString('id-ID') + ' Kg/Ha'; } } },
        legend: { position: 'top', fontSize: '11px', fontWeight: 600 },
        grid: { borderColor: '#f0f0f0' }
    }).render();

    // Chart 5: Pie Karet
    new ApexCharts(document.getElementById('chart-pie-karet'), {
        series: D.karetProdReal,
        labels: labels,
        chart: { type: 'donut', height: 320, fontFamily: font },
        colors: ['#0284c7', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444', '#14b8a6', '#f97316', '#6366f1'],
        plotOptions: {
            pie: { donut: { size: '65%', labels: { show: true, name: { show: true }, value: { formatter: function(v) { return v.toLocaleString('id-ID') + ' Ton'; } }, total: { show: true, label: 'Total', formatter: function(w) { return w.globals.seriesTotals.reduce((a, b) => a + b, 0).toLocaleString('id-ID') + ' Ton'; } } } } }
        },
        dataLabels: { enabled: true, formatter: function(val, opts) { return val.toFixed(1) + '%'; } },
        tooltip: { y: { formatter: function(v) { return v.toLocaleString('id-ID') + ' Ton'; } } },
        legend: { position: 'bottom', fontSize: '11px', fontWeight: 600 }
    }).render();

    // Chart 6: Pie Teh
    new ApexCharts(document.getElementById('chart-pie-teh'), {
        series: D.tehProdReal,
        labels: labels,
        chart: { type: 'donut', height: 320, fontFamily: font },
        colors: ['#0284c7', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444', '#14b8a6', '#f97316', '#6366f1'],
        plotOptions: {
            pie: { donut: { size: '65%', labels: { show: true, name: { show: true }, value: { formatter: function(v) { return v.toLocaleString('id-ID') + ' Ton'; } }, total: { show: true, label: 'Total', formatter: function(w) { return w.globals.seriesTotals.reduce((a, b) => a + b, 0).toLocaleString('id-ID') + ' Ton'; } } } } }
        },
        dataLabels: { enabled: true, formatter: function(val, opts) { return val.toFixed(1) + '%'; } },
        tooltip: { y: { formatter: function(v) { return v.toLocaleString('id-ID') + ' Ton'; } } },
        legend: { position: 'bottom', fontSize: '11px', fontWeight: 600 }
    }).render();

});
</script>
@endsection

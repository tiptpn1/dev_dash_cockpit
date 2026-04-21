@extends('layouts.app')

@section('styles')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* ===== Select2 — sesuaikan dengan tema hijau ===== */
        .select2-container--default .select2-selection--single {
            height: 36px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background-color: #fff;
            color: #1f2937;
            font-size: 13px;
            display: flex;
            align-items: center;
            padding: 0 10px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px;
            padding-left: 0;
            color: #111827 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #6b7280 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 34px;
        }

        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: #166534;
            box-shadow: 0 0 0 2px rgba(22, 101, 52, 0.12);
            outline: none;
        }

        .select2-container--default .select2-results__option {
            color: #111827 !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #166534;
            color: #fff !important;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #d1d5db;
            border-radius: 4px;
            padding: 4px 8px;
            font-size: 12px;
            color: #111827 !important;
        }

        .select2-dropdown {
            border: 1px solid #166534;
            border-radius: 6px;
            font-size: 13px;
        }

        .select2-container {
            width: 100% !important;
        }

        /* ===== SCROLL FIX — override Tailwind h-screen di body ===== */
        html,
        body {
            height: auto !important;
            min-height: 100vh;
            overflow-y: auto !important;
        }

        /* Override padding dari layout .main-content agar tidak ada space aneh */
        .lm13-container.main-content {
            padding: 0 !important;
            margin-left: 0 !important;
        }

        /* ===== MAIN CONTAINER ===== */
        .lm13-container {
            padding: 0;
            margin: 0;
            width: 100%;
            min-height: 100vh;
            background: #f8fafc;
            overflow-x: hidden;
            box-sizing: border-box;
            font-family: inherit;
        }

        /* ===== PAGE HEADER — mirip gudang_utilisasi ===== */
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
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
            margin-bottom: 12px;
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

        .form-select {
            width: 100%;
            padding: 8px 10px;
            background-color: #fff;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            color: #1f2937;
            font-size: 13px;
            transition: border-color 0.2s;
        }

        .form-select:focus {
            outline: none;
            border-color: #166534;
            box-shadow: 0 0 0 2px rgba(22, 101, 52, 0.12);
        }

        .button-group {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
            margin-top: 12px;
        }

        .btn-filter {
            padding: 8px 22px;
            background: #166534;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
        }

        .btn-filter:hover {
            background: #15803d;
        }

        .btn-reset {
            padding: 8px 22px;
            background: #fff;
            color: #374151;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
        }

        .btn-reset:hover {
            background: #f3f4f6;
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

        .table-wrapper {
            overflow-x: hidden;
            width: 100%;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11.5px;
            color: #1f2937;
        }

        .report-table thead th {
            background: #15803d;
            color: #fff;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 9px 12px;
            border: 1px solid #166534;
            text-align: center;
            white-space: nowrap;
        }

        .report-table thead th.col-group {
            background: #15803d;
            color: #dcfce7;
            font-size: 11.5px;
            border-bottom: 2px solid #166534;
        }

        .report-table thead th.col-label {
            text-align: left;
            white-space: normal;
            min-width: 180px;
        }

        .report-table thead th.col-norek {
            min-width: 55px;
            width: 55px;
        }

        .report-table tbody td {
            padding: 5px 8px;
            border: 1px solid #e5e7eb;
            vertical-align: middle;
            color: #1f2937;
        }

        .report-table tbody td.num {
            text-align: right;
            font-family: 'Courier New', Courier, monospace;
            white-space: nowrap;
            width: 100px;
        }

        .report-table tbody td.label-cell {
            text-align: left;
            padding-left: 10px;
            white-space: nowrap;
        }

        .report-table tbody td.label-cell.indent {
            padding-left: 22px;
        }

        .report-table tbody tr.row-subtotal td {
            background: #f0fdf4;
            font-weight: 700;
            color: #14532d;
            border-top: 1px solid #bbf7d0;
        }

        .report-table tbody tr.row-total td {
            background: #dcfce7;
            font-weight: 800;
            color: #14532d;
            border-top: 2px solid #166534;
            border-bottom: 2px solid #166534;
        }

        .report-table tbody tr.row-section-header td {
            background: #166534;
            color: #fff;
            font-weight: 700;
            font-size: 11.5px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding-top: 8px;
            padding-bottom: 8px;
        }

        .report-table tbody tr.row-info td {
            background: #f9fafb;
            color: #6b7280;
            font-style: italic;
        }

        .report-table tbody tr:hover td {
            background-color: #f0fdf4;
        }

        .report-table tbody tr.row-subtotal:hover td,
        .report-table tbody tr.row-total:hover td,
        .report-table tbody tr.row-section-header:hover td {
            filter: brightness(0.96);
        }

        .dash {
            color: #9ca3af;
        }

        .norek-cell {
            text-align: center;
            color: #9ca3af;
            font-size: 11px;
        }
    </style>
@endsection

@section('content')
    <div class="lm13-container main-content">
        <!-- Page Header — sama seperti gudang_utilisasi -->
        <header class="lm-page-header">
            <div class="lm-header-logo">
                <img src="{{ asset('danantara.png') }}" alt="Danantara">
            </div>
            <div class="lm-header-center">
                <svg style="width:28px;height:28px;color:#22c55e;flex-shrink:0;" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.95-2.3A5 5 0 008 22c12 0 15-17 15-17-1 2-8 2-13 3-5 1-6 7-6 7s5.5-2 8.5-2 5 2 5 2-3-5-3-5 3 5 3 5-5 3-5 3 2 3 2 6-2 6-2 6 3-3 3-6-2-6-2-6z" />
                </svg>
                <h1>LM 14 &mdash; Biaya Tanaman</h1>
            </div>
            <div class="lm-header-right">
                <img src="{{ asset('ptpn1.png') }}" alt="PTPN 1">
            </div>
        </header>

        <!-- Main Content -->
        <div class="content-section">

            <!-- Filter Section -->
            <div class="filter-card">
                <div class="filter-title">
                    <i class="fas fa-sliders-h"></i> Filter Data
                </div>
                <form id="filterForm">
                    <div class="filter-grid">
                        <div class="form-group">
                            <label class="form-label">Komoditas</label>
                            <select class="form-select" id="komoditasFilter">
                                <option value="">-- Pilih Komoditas --</option>
                                <option value="KR">Karet</option>
                                <option value="TH">Teh</option>
                                <option value="KP">Kopi</option>
                                <option value="TB">Tembakau</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Regional</label>
                            <select class="form-select" id="regionalFilter">
                                <option value="">-- Semua Regional --</option>
                                @foreach ($regionalList as $item)
                                    <option value="{{ $item->regional }}">{{ $item->regional }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Plant</label>
                            <select class="form-select select2-plant" id="plantFilter" style="width:100%;">
                                <option value="">-- Semua Kebun --</option>
                                @foreach ($plantList as $item)
                                    <option value="{{ $item->plant }}">{{ $item->plant }} - {{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tahun</label>
                            <select class="form-select" id="tahunFilter">
                                <option value="">-- Pilih Tahun --</option>
                                @foreach ($tahunList as $thn)
                                    <option value="{{ $thn }}">{{ $thn }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Bulan</label>
                            <select class="form-select" id="bulanFilter">
                                <option value="">-- Pilih Bulan --</option>
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                    </div>
                    <div class="button-group">
                        <button type="reset" class="btn-reset" id="btnReset">
                            <i class="fas fa-redo"></i> Reset
                        </button>
                        <button type="submit" class="btn-filter" id="btnFilter">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </form>
            </div>

            <!-- ====== LM14 REPORT TABLE ====== -->
            <div class="table-card" id="resultCard" style="display:none;">
                <div class="table-header">
                    <div class="table-title">
                        <i class="fas fa-seedling"></i> Hasil Data LM14
                    </div>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span id="resultInfo" style="color:#93c5fd; font-size:12px;"></span>
                        <button id="btnExportExcel" onclick="exportExcel()" style="
                                display:inline-flex; align-items:center; gap:5px;
                                padding:6px 14px; background:#16a34a; color:#fff;
                                border:none; border-radius:6px; font-size:12px;
                                font-weight:700; cursor:pointer;">
                            <i class="fas fa-file-excel"></i> Excel
                        </button>
                        <button id="btnExportPdf" onclick="exportPdf()" style="
                                display:inline-flex; align-items:center; gap:5px;
                                padding:6px 14px; background:#dc2626; color:#fff;
                                border:none; border-radius:6px; font-size:12px;
                                font-weight:700; cursor:pointer;">
                            <i class="fas fa-file-pdf"></i> PDF
                        </button>
                    </div>
                </div>
                <div class="table-wrapper">
                    <div id="tableLoading" style="display:none; text-align:center; padding:24px; color:#6b7280;">
                        <i class="fas fa-spinner fa-spin"></i> Memuat data...
                    </div>
                    <div id="tableError" style="display:none; padding:16px 20px; color:#dc2626; font-size:13px;"></div>
                    <div id="tableResult"></div>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Data mentah untuk export Excel (disimpan saat data diterima)
        let _exportData = null;

        document.addEventListener('DOMContentLoaded', function () {
            const tahunSel = document.getElementById('tahunFilter');
            const bulanSel = document.getElementById('bulanFilter');

            const bulanNames = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            function updateLabels() {
                const yr = parseInt(tahunSel.value) || new Date().getFullYear();
                const bln = parseInt(bulanSel.value) || 0;

                const lblYear = document.getElementById('tblYearLabel');
                const lblBulan = document.getElementById('tblBulanLabel');
                if (lblYear) lblYear.textContent = yr;
                if (lblBulan) lblBulan.textContent = bln ? bulanNames[bln] : '-';
            }

            // Init on page load
            updateLabels();

            // Update on change
            tahunSel.addEventListener('change', updateLabels);
            bulanSel.addEventListener('change', updateLabels);

            // ── Fetch + Render data dari route get_data_lm14 ─────────────────
            function get_data_lm14(plant, tahun, bulan, komoditi) {
                const card = document.getElementById('resultCard');
                const loading = document.getElementById('tableLoading');
                const errBox = document.getElementById('tableError');
                const result = document.getElementById('tableResult');
                const info = document.getElementById('resultInfo');

                // Tampilkan card + loading
                card.style.display = '';
                loading.style.display = '';
                errBox.style.display = 'none';
                result.innerHTML = '';
                info.textContent = '';

                const params = new URLSearchParams({ plant, tahun, bulan, komoditi });
                fetch(`{{ route('get_data_lm14') }}?${params}`)
                    .then(res => res.json())
                    .then(data => {
                        loading.style.display = 'none';
                        if (data.status !== 'success') {
                            errBox.style.display = '';
                            errBox.textContent = '⚠️ ' + (data.message || 'Terjadi kesalahan.');
                            return;
                        }
                        const rows = data.data;
                        info.textContent = `${data.total} baris ditemukan`;

                        if (!rows || rows.length === 0) {
                            result.innerHTML = '<p style="padding:16px 20px;color:#6b7280;font-size:13px;">Tidak ada data untuk filter yang dipilih.</p>';
                            return;
                        }

                        // Ambil semua key dari baris pertama sebagai header
                        const headers = Object.keys(rows[0]);

                        // ── Kolom yang disubtotal (partial match nama kolom) ──────────
                        const SUBTOTAL_COLS = ['barang_bahan', 'biaya_pemeliharaan', 'biaya_total'];
                        const isSubtotalCol = h => SUBTOTAL_COLS.some(k => h.toLowerCase().includes(k));

                        // ── Helper: format angka ID ───────────────────────────────────
                        const fmt = v => {
                            if (v === null || v === '' || v === undefined) return '-';
                            const n = parseFloat(v);
                            return isNaN(n) ? (v ?? '-') : n.toLocaleString('id-ID');
                        };
                        // Format 2 desimal — khusus biaya_per_ha
                        const fmt2 = v => {
                            if (v === null || v === '' || v === undefined) return '-';
                            const n = parseFloat(v);
                            return isNaN(n) ? (v ?? '-') : n.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                        };
                        const isNum = v => v !== null && v !== '' && v !== undefined && !isNaN(parseFloat(v));

                        // ── Judul dinamis dari nilai filter ──────────────────────────
                        const bulanNames = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei',
                            'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

                        const plantSel = document.getElementById('plantFilter');
                        const bulanSel2 = document.getElementById('bulanFilter');
                        const tahunSel2 = document.getElementById('tahunFilter');
                        const komoSel = document.getElementById('komoditasFilter');

                        const plantText = plantSel.selectedIndex >= 0 && plantSel.value
                            ? plantSel.options[plantSel.selectedIndex].text
                            : 'Semua Kebun';
                        const bulanText = bulanSel2.value ? bulanNames[parseInt(bulanSel2.value)] : 'Semua Bulan';
                        const tahunText = tahunSel2.value || 'Semua Tahun';
                        const komoText = komoSel.value ? komoSel.options[komoSel.selectedIndex].text : 'Semua Komoditas';

                        const judulLaporan = `LM14  ${plantText}  Komoditas: ${komoText}  ${bulanText}  ${tahunText}`;

                        // Simpan data mentah untuk export ─────────────────────────────
                        _exportData = {
                            rows,
                            headers: Object.keys(rows[0]),
                            judul: judulLaporan,
                            subtotalCols: SUBTOTAL_COLS,
                        };

                        // ── Identifikasi tipe kolom (teks vs angka) ─────────────────
                        const colTypes = {};
                        const sampleSize = Math.min(10, rows.length);
                        headers.forEach(h => {
                            colTypes[h] = rows.slice(0, sampleSize).some(r => isNum(r[h])) ? 'num' : 'text';
                        });
                        const textColsList = headers.filter(h => colTypes[h] === 'text');
                        const numColsList  = headers.filter(h => colTypes[h] === 'num');

                        // Distribusi lebar kolom proporsional (persentase)
                        const textPct = textColsList.length > 0
                            ? Math.min(22, Math.floor(50 / textColsList.length))
                            : 20;
                        const usedPct = textPct * textColsList.length;
                        const numPct  = numColsList.length > 0
                            ? Math.max(4, Math.floor((100 - usedPct) / numColsList.length))
                            : Math.floor(100 / headers.length);

                        // ── Header ───────────────────────────────────────────────────
                        let html = '<table class="report-table" style="font-size:10.5px; table-layout:fixed; width:100%;">';

                        // colgroup — atur lebar setiap kolom
                        html += '<colgroup>';
                        headers.forEach(h => {
                            html += `<col style="width:${colTypes[h] === 'text' ? textPct : numPct}%">`;
                        });
                        html += '</colgroup>';

                        html += '<thead>';
                        // Baris judul (full colspan)
                        html += `<tr>
                                    <th colspan="${headers.length}" style="
                                        background:#ffffff; color:#111827;
                                        text-align:center; font-size:12px;
                                        font-weight:800; padding:8px 12px;
                                        letter-spacing:0.04em; border-bottom:2px solid #16a34a;">
                                        ${judulLaporan}
                                    </th>
                                </tr>`;
                        // Baris kolom header
                        html += '<tr>';
                        headers.forEach(h => {
                            const isText = colTypes[h] === 'text';
                            html += `<th style="text-align:${isText ? 'left' : 'center'}; padding:5px 4px; background:#15803d; color:#fff; white-space:normal; overflow:hidden; word-break:break-word;">${h.replace(/_/g, ' ').toUpperCase()}</th>`;
                        });
                        html += '</tr></thead>';

                        // ── Body dengan subtotal ─────────────────────────────────────
                        html += '<tbody>';

                        // Akumulator subtotal
                        const initAcc = () => Object.fromEntries(headers.map(h => [h, 0]));
                        const addToAcc = (acc, row) => headers.forEach(h => { if (isSubtotalCol(h) && isNum(row[h])) acc[h] += parseFloat(row[h]); });

                        let acc2 = initAcc(), key2 = '', acc1 = initAcc(), key1 = '';
                        let accTotal = initAcc();

                        // ── Luas Areal: ambil dari baris kode='0'/'00', kolom qty ────────
                        // Kode bisa berupa integer 0, string '0', atau string '00'
                        const row00 = rows.find(r => {
                            const k = (r['kode'] ?? r['kdbe'] ?? r['KODE'] ?? r['Kode'] ?? '').toString().trim();
                            const u = (r['uraian'] ?? r['URAIAN'] ?? '').toString().toLowerCase();
                            return k === '00' || k === '0' || parseInt(k) === 0 || u.includes('luas areal');
                        });

                        // Semua kolom biaya_per_ha & biaya_total & qty (urutan dari headers)
                        const perHaCols    = headers.filter(h => h.toLowerCase().includes('biaya_per_ha'));
                        const biayaTotCols = headers.filter(h => h.toLowerCase().includes('biaya_total'));
                        const qtyCols      = headers.filter(h => h.toLowerCase().includes('qty'));

                        // Luas areal: nilai qty dari baris kode='00' per indeks kolom
                        // Index 0 = qty tahun ini, index 1 = qty tahun lalu (atau sebaliknya)
                        const luasArr = qtyCols.map(col => {
                            if (!row00) return 0;
                            const v = parseFloat(row00[col]);
                            return isNaN(v) ? 0 : v;
                        });

                        // Pairing by index: perHaCols[i] ↔ biayaTotCols[i] ↔ qtyCols[i]
                        const perHaMapping = {}; // { perHaCol: { totalCol, luas } }
                        perHaCols.forEach((perHaCol, i) => {
                            perHaMapping[perHaCol] = {
                                totalCol: biayaTotCols[i] ?? biayaTotCols[0],
                                luas:     luasArr[i]      ?? luasArr[0] ?? 0,
                            };
                        });

                        // Debug — hapus setelah confirmed working
                        console.log('[LM14] row00:', row00);
                        console.log('[LM14] qtyCols:', qtyCols, '→ luasArr:', luasArr);
                        console.log('[LM14] perHaMapping:', perHaMapping);

                        // Helper hitung biaya_per_ha dari akumulator
                        const calcPerHa = (acc, perHaCol) => {
                            const { totalCol, luas } = perHaMapping[perHaCol] || {};
                            if (!totalCol || !luas) return 0;
                            const total = acc[totalCol] || 0;
                            return luas > 0 ? total / luas : 0;
                        };

                        const subtotalRow = (label, acc, bgColor, fontWeight, borderTop) => {
                            let r = `<tr style="background:${bgColor}; font-weight:${fontWeight}; border-top:${borderTop};">`;
                            headers.forEach((h, idx) => {
                                if (idx === 0) {
                                    r += `<td colspan="2" style="padding:4px 6px; border:1px solid #d1fae5; text-align:right; font-style:italic; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">${label}</td>`;
                                } else if (idx === 1) {
                                    return; // sudah di-colspan
                                } else if (h.toLowerCase().includes('biaya_per_ha') && perHaMapping[h]) {
                                    // Hitung dari akumulasi biaya_total / luas_areal
                                    const perHaVal = calcPerHa(acc, h);
                                    r += `<td style="padding:4px 6px; border:1px solid #d1fae5; text-align:right; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${fmt2(perHaVal)}</td>`;
                                } else if (isSubtotalCol(h)) {
                                    r += `<td style="padding:4px 6px; border:1px solid #d1fae5; text-align:right; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${fmt(acc[h])}</td>`;
                                } else {
                                    r += `<td style="padding:4px 6px; border:1px solid #d1fae5;"></td>`;
                                }
                            });
                            r += '</tr>';
                            return r;
                        };

                        rows.forEach((row, i) => {
                            const kode = (row['kode'] || row['kdbe'] || row['KODE'] || '').toString();
                            const grp2 = kode.substring(0, 2).toUpperCase();
                            const grp1 = kode.substring(0, 1).toUpperCase();

                            // Deteksi pergantian grup 2-char
                            if (key2 && grp2 !== key2) {
                                html += subtotalRow(`Jumlah ${key2}`, acc2, '#f0fdf4', '700', '2px solid #bbf7d0');
                                acc2 = initAcc();
                                if (grp1 !== key1) {
                                    html += subtotalRow(`Jumlah ${key1}`, acc1, '#dcfce7', '800', '2px solid #16a34a');
                                    acc1 = initAcc();
                                }
                            } else if (!key2) {
                                acc2 = initAcc();
                                acc1 = initAcc();
                            }

                            key2 = grp2;
                            key1 = grp1;
                            addToAcc(acc2, row);
                            addToAcc(acc1, row);
                            addToAcc(accTotal, row);

                            // Baris data biasa
                            const bg = i % 2 === 0 ? '#fff' : '#f9fafb';
                            html += `<tr style="background:${bg};">`;
                            headers.forEach(h => {
                                const val = row[h];
                                const num = isNum(val);
                                const isTextCol = colTypes[h] === 'text';
                                const isPerHa = h.toLowerCase().includes('biaya_per_ha');
                                html += `<td style="padding:3px 5px; border:1px solid #e5e7eb; text-align:${num ? 'right' : 'left'}; ${isTextCol ? 'overflow:hidden; text-overflow:ellipsis; white-space:nowrap;' : 'white-space:nowrap; overflow:hidden; text-overflow:ellipsis;'}">${isPerHa ? fmt2(val) : fmt(val)}</td>`;
                            });
                            html += '</tr>';
                        });

                        // Subtotal terakhir (sisa grup yang belum di-flush)
                        if (key2) html += subtotalRow(`Jumlah ${key2}`, acc2, '#f0fdf4', '700', '2px solid #bbf7d0');
                        if (key1) html += subtotalRow(`Jumlah ${key1}`, acc1, '#dcfce7', '800', '2px solid #16a34a');

                        // ── Grand Total ───────────────────────────────────────────────
                        let gt = `<tr style="background:#14532d; color:#fff; font-weight:900; border-top:3px solid #052e16;">`;
                        headers.forEach((h, idx) => {
                            if (idx === 0) {
                                gt += `<td colspan="2" style="padding:6px 6px; border:1px solid #166534; text-align:right; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; color:#fff;">JUMLAH TOTAL</td>`;
                            } else if (idx === 1) {
                                return;
                            } else if (h.toLowerCase().includes('biaya_per_ha') && perHaMapping[h]) {
                                const perHaVal = calcPerHa(accTotal, h);
                                gt += `<td style="padding:6px 6px; border:1px solid #166534; text-align:right; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; color:#fff;">${fmt2(perHaVal)}</td>`;
                            } else if (isSubtotalCol(h)) {
                                gt += `<td style="padding:6px 6px; border:1px solid #166534; text-align:right; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; color:#fff;">${fmt(accTotal[h])}</td>`;
                            } else {
                                gt += `<td style="padding:6px 6px; border:1px solid #166534; color:#fff;"></td>`;
                            }
                        });
                        gt += '</tr>';
                        html += gt;

                        html += '</tbody></table>';

                        result.innerHTML = html;

                        // ── Auto-scale font jika tabel masih terlalu lebar ───────────
                        const tblEl = result.querySelector('table');
                        const wrapEl = document.getElementById('tableResult');
                        if (tblEl && tblEl.scrollWidth > wrapEl.offsetWidth) {
                            let fs = 10.5;
                            while (tblEl.scrollWidth > wrapEl.offsetWidth && fs > 7) {
                                fs -= 0.5;
                                tblEl.style.fontSize = fs + 'px';
                            }
                            if (fs <= 8) {
                                tblEl.querySelectorAll('td, th').forEach(el => {
                                    el.style.padding = '2px 3px';
                                });
                            }
                        }
                    })
                    .catch(err => {
                        loading.style.display = 'none';
                        errBox.style.display = '';
                        errBox.textContent = '⚠️ Gagal menghubungi server: ' + err.message;
                    });
            }

            // Filter form submit
            document.getElementById('filterForm').addEventListener('submit', function (e) {
                e.preventDefault();
                const plant = document.getElementById('plantFilter').value;
                const regional = document.getElementById('regionalFilter').value;
                const komoditas = document.getElementById('komoditasFilter').value;
                const tahun = document.getElementById('tahunFilter').value;
                const bulan = document.getElementById('bulanFilter').value;
                updateLabels();
                get_data_lm14(plant, tahun, bulan, komoditas);
            });

            // Reset — gunakan tahun berjalan dari server
            document.getElementById('btnReset').addEventListener('click', function () {
                setTimeout(function () {
                    tahunSel.value = '{{ $tahunSekarang }}';
                    bulanSel.value = '';
                    // Reset Select2
                    $('#plantFilter').val('').trigger('change');
                    resultCard.style.display = 'none';
                    updateLabels();
                }, 50);
            });
        });
    </script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#plantFilter').select2({
                placeholder: '-- Semua Kebun --',
                allowClear: true,
                width: '100%',
            });
        });
    </script>

    <!-- ExcelJS (Excel export dengan styling penuh) -->
    <script src="https://cdn.jsdelivr.net/npm/exceljs@4.4.0/dist/exceljs.min.js"></script>
    <!-- jsPDF + autoTable (PDF export) -->
    <script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspdf-autotable@3.8.2/dist/jspdf.plugin.autotable.min.js"></script>

    <script>
        // ── Ambil judul laporan dari tabel yang sudah dirender ────────────────
        function getJudulLaporan() {
            const th = document.querySelector('#tableResult table thead tr:first-child th');
            return th ? th.textContent.trim() : 'LM14';
        }

        // ── Export Excel (ExcelJS — angka asli + styling penuh) ───────────────
        async function exportExcel() {
            if (!_exportData) { alert('Belum ada data untuk diekspor.'); return; }

            const { rows, headers, judul, subtotalCols } = _exportData;
            const isSubCol = h => subtotalCols.some(k => h.toLowerCase().includes(k));
            const isNum = v => v !== null && v !== '' && v !== undefined && !isNaN(parseFloat(v));

            const workbook = new ExcelJS.Workbook();
            const ws = workbook.addWorksheet('LM14');

            // ── Lebar kolom otomatis ─────────────────────────────────────────────
            ws.columns = headers.map(h => ({
                key: h,
                width: h.toLowerCase().includes('uraian') ? 30
                    : isSubCol(h) ? 18 : 14,
            }));

            // ── Styling helpers ─────────────────────────────────────────────────
            const border = (style = 'thin') => ({
                top: { style }, left: { style }, bottom: { style }, right: { style }
            });
            const fillSolid = argb => ({ type: 'pattern', pattern: 'solid', fgColor: { argb } });

            // ── Baris 1: Judul ───────────────────────────────────────────────────
            ws.mergeCells(1, 1, 1, headers.length);
            const titleCell = ws.getCell(1, 1);
            titleCell.value = judul;
            titleCell.font = { bold: true, size: 12, color: { argb: 'FF111827' } };
            titleCell.alignment = { horizontal: 'center', vertical: 'middle', wrapText: true };
            titleCell.fill = fillSolid('FFFFFFFF');
            titleCell.border = border();
            ws.getRow(1).height = 22;

            // ── Baris 2: Header kolom ────────────────────────────────────────────
            const hRow = ws.addRow(headers.map(h => h.replace(/_/g, ' ').toUpperCase()));
            hRow.eachCell(cell => {
                cell.fill = fillSolid('FF15803D');
                cell.font = { bold: true, color: { argb: 'FFFFFFFF' }, size: 9 };
                cell.alignment = { horizontal: 'center', vertical: 'middle', wrapText: true };
                cell.border = border();
            });
            ws.getRow(2).height = 18;

            // ── Helper: tambah baris subtotal ────────────────────────────────────
            const addSubRow = (label, acc, bgArgb) => {
                const rowData = headers.map((h, idx) => {
                    if (idx === 0) return label;
                    if (idx === 1) return null;
                    return isSubCol(h) && isNum(acc[h]) ? parseFloat(acc[h]) : null;
                });
                const r = ws.addRow(rowData);
                const rNum = ws.rowCount;
                r.eachCell({ includeEmpty: true }, (cell, colNum) => {
                    cell.fill = fillSolid(bgArgb);
                    cell.font = { bold: true, italic: true, size: 9, color: { argb: 'FF111827' } };
                    cell.border = border();
                    const h = headers[colNum - 1];
                    if (colNum > 2 && isSubCol(h)) {
                        cell.numFmt = '#,##0';
                        cell.alignment = { horizontal: 'right' };
                    }
                });
                try { ws.mergeCells(rNum, 1, rNum, 2); } catch (e) { }
                ws.getCell(rNum, 1).alignment = { horizontal: 'right', vertical: 'middle', italic: true };
            };

            // ── Akumulator ───────────────────────────────────────────────────────
            const initAcc = () => Object.fromEntries(headers.map(h => [h, 0]));
            const addToAcc = (acc, row) => headers.forEach(h => {
                if (isSubCol(h) && isNum(row[h])) acc[h] += parseFloat(row[h]);
            });

            let acc2 = initAcc(), key2 = '', acc1 = initAcc(), key1 = '';
            let accTotal = initAcc();
            let rowIdx = 0;

            // ── Iterasi baris data ────────────────────────────────────────────────
            for (const row of rows) {
                const kode = (row['kode'] || row['kdbe'] || row['KODE'] || '').toString();
                const grp2 = kode.substring(0, 2).toUpperCase();
                const grp1 = kode.substring(0, 1).toUpperCase();

                if (key2 && grp2 !== key2) {
                    addSubRow(`Jumlah ${key2}`, acc2, 'FFF0FDF4');
                    acc2 = initAcc();
                    if (grp1 !== key1) {
                        addSubRow(`Jumlah ${key1}`, acc1, 'FFDCFCE7');
                        acc1 = initAcc();
                    }
                }
                key2 = grp2; key1 = grp1;
                addToAcc(acc2, row); addToAcc(acc1, row); addToAcc(accTotal, row);

                // Baris data
                const rowData = headers.map(h => {
                    const v = row[h];
                    return isNum(v) ? parseFloat(v) : (v ?? '');
                });
                const exRow = ws.addRow(rowData);
                const bg = rowIdx % 2 === 0 ? 'FFFFFFFF' : 'FFF9FAFB';
                exRow.eachCell({ includeEmpty: true }, (cell, colNum) => {
                    cell.fill = fillSolid(bg);
                    cell.font = { size: 9 };
                    cell.border = border();
                    const h = headers[colNum - 1];
                    if (h && isNum(row[h])) {
                        cell.numFmt = '#,##0';
                        cell.alignment = { horizontal: 'right' };
                    } else {
                        cell.alignment = { horizontal: 'left' };
                    }
                });
                rowIdx++;
            }

            // Subtotal terakhir
            if (key2) addSubRow(`Jumlah ${key2}`, acc2, 'FFF0FDF4');
            if (key1) addSubRow(`Jumlah ${key1}`, acc1, 'FFDCFCE7');

            // ── Grand Total ──────────────────────────────────────────────────────
            const gtData = headers.map((h, idx) => {
                if (idx === 0) return 'JUMLAH TOTAL';
                if (idx === 1) return null;
                return isSubCol(h) && isNum(accTotal[h]) ? parseFloat(accTotal[h]) : null;
            });
            const gtRow = ws.addRow(gtData);
            const gtNum = ws.rowCount;
            gtRow.eachCell({ includeEmpty: true }, (cell, colNum) => {
                cell.fill = fillSolid('FF14532D');
                cell.font = { bold: true, color: { argb: 'FFFFFFFF' }, size: 10 };
                cell.border = border('medium');
                if (colNum > 2 && isSubCol(headers[colNum - 1])) {
                    cell.numFmt = '#,##0';
                    cell.alignment = { horizontal: 'right' };
                }
            });
            try { ws.mergeCells(gtNum, 1, gtNum, 2); } catch (e) { }
            ws.getCell(gtNum, 1).alignment = { horizontal: 'right', vertical: 'middle' };

            // ── Simpan file ──────────────────────────────────────────────────────
            const buffer = await workbook.xlsx.writeBuffer();
            const blob = new Blob([buffer], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `${judul}.xlsx`;
            a.click();
            URL.revokeObjectURL(url);
        }

        // ── Export PDF ────────────────────────────────────────────────────────
        function exportPdf() {
            const tbl = document.querySelector('#tableResult table');
            if (!tbl) { alert('Belum ada data untuk diekspor.'); return; }

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({ orientation: 'landscape', unit: 'pt', format: 'a3' });

            const judul = getJudulLaporan();
            doc.setFontSize(11);
            doc.setFont('helvetica', 'bold');
            doc.text(judul, doc.internal.pageSize.getWidth() / 2, 30, { align: 'center' });

            doc.autoTable({
                html: tbl,
                startY: 45,
                styles: { fontSize: 7, cellPadding: 3 },
                headStyles: { fillColor: [21, 128, 61], textColor: 255, fontStyle: 'bold' },
                // Baris 0 = judul colspan → skip dari autoTable head
                didParseCell: (data) => {
                    if (data.row.index === 0 && data.section === 'head') {
                        data.cell.styles.fillColor = [255, 255, 255];
                        data.cell.styles.textColor = [17, 24, 39];
                        data.cell.styles.fontStyle = 'bold';
                        data.cell.styles.halign = 'center';
                    }
                },
                alternateRowStyles: { fillColor: [249, 250, 251] },
                margin: { top: 50, left: 20, right: 20 },
            });

            doc.save(`${judul}.pdf`);
        }
    </script>
@endsection
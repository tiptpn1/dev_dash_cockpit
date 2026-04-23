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
            overflow-x: auto;
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
                <h1>LM 13 &mdash; Biaya Produksi</h1>
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
                            <select class="form-select select2-plant" id="plantFilter" style="width:100%;" disabled>
                                <option value="">-- Pilih Regional dulu --</option>
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
                        <button type="submit" class="btn-filter" id="btnFilter" disabled
                            style="opacity:0.45; cursor:not-allowed;">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </form>
            </div>

            <!-- ====== LM14 REPORT TABLE ====== -->
            <div class="table-card" id="resultCard" style="display:none;">
                <div class="table-header">
                    <div class="table-title">
                        <i class="fas fa-seedling"></i> Hasil Data LM13
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

        // Semua plant dari server (untuk filter dinamis)
        const allPlants = @json($plantList->map(fn($p) => ['plant' => $p->plant, 'nama' => $p->nama, 'regional' => $p->regional]));

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

            // ── Filter plant by regional ──────────────────────────────────────
            function rebuildPlantFilter(selectedRegional) {
                const plantSel = document.getElementById('plantFilter');
                const currentVal = plantSel.value;
                const filtered = selectedRegional
                    ? allPlants.filter(p => p.regional === selectedRegional)
                    : [];

                if (selectedRegional) {
                    // Aktifkan select plant
                    plantSel.disabled = false;
                    plantSel.style.opacity = '1';
                    plantSel.style.cursor = 'pointer';
                    plantSel.innerHTML = '<option value="">-- Semua Kebun --</option>';
                    filtered.forEach(p => {
                        const opt = document.createElement('option');
                        opt.value = p.plant;
                        opt.textContent = `${p.plant} - ${p.nama}`;
                        if (p.plant === currentVal) opt.selected = true;
                        plantSel.appendChild(opt);
                    });
                } else {
                    // Disable dan reset select plant
                    plantSel.disabled = true;
                    plantSel.style.opacity = '0.5';
                    plantSel.style.cursor = 'not-allowed';
                    plantSel.innerHTML = '<option value="">-- Pilih Regional dulu --</option>';
                }

                $('#plantFilter').val('').trigger('change');
            }

            document.getElementById('regionalFilter').addEventListener('change', function () {
                rebuildPlantFilter(this.value);
            });

            // ── Enable tombol Cari hanya jika Tahun & Bulan sudah dipilih ────────
            const btnFilter = document.getElementById('btnFilter');
            function checkEnableSearch() {
                const tahunOk = !!document.getElementById('tahunFilter').value;
                const bulanOk = !!document.getElementById('bulanFilter').value;
                const ok = tahunOk && bulanOk;
                btnFilter.disabled = !ok;
                btnFilter.style.opacity = ok ? '1' : '0.45';
                btnFilter.style.cursor = ok ? 'pointer' : 'not-allowed';
            }
            document.getElementById('tahunFilter').addEventListener('change', checkEnableSearch);
            document.getElementById('bulanFilter').addEventListener('change', checkEnableSearch);
            checkEnableSearch(); // init

            // Init on page load
            updateLabels();

            // Update on change
            tahunSel.addEventListener('change', updateLabels);
            bulanSel.addEventListener('change', updateLabels);

            // ── Fetch + Render data dari route get_data_lm14 ─────────────────
            function get_data_lm13(komoditas, region, plant, tahun, bulan) {
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

                const params = new URLSearchParams({ komoditi: komoditas, region, plant, tahun, bulan });
                fetch(`{{ route('get_data_lm13') }}?${params}`)
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

                        // ── Kolom yang disubtotal: scan SEMUA baris agar kolom yg null di row[0] tetap terdeteksi ────
                        const NUMERIC_COLS = new Set(
                            headers.filter(h =>
                                rows.some(r => {
                                    const v = r[h];
                                    return v !== null && v !== '' && v !== undefined && !isNaN(parseFloat(v));
                                })
                            )
                        );
                        const isSubtotalCol = h => NUMERIC_COLS.has(h);

                        // ── Helper: format angka ID ───────────────────────────────────
                        const fmt = v => {
                            if (v === null || v === '' || v === undefined) return '-';
                            const n = parseFloat(v);
                            if (isNaN(n)) return v ?? '-';
                            // Jika nilai asli dari BigQuery punya desimal → paksa 2 digit di belakang koma
                            const hasDecimal = String(v).includes('.');
                            return n.toLocaleString('id-ID', {
                                minimumFractionDigits: hasDecimal ? 2 : 0,
                                maximumFractionDigits: 2,
                            });
                        };
                        const isNum = v => v !== null && v !== '' && v !== undefined && !isNaN(parseFloat(v));

                        // ── Judul dinamis dari nilai filter ──────────────────────────
                        const bulanNames = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei',
                            'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

                        const regionalSel = document.getElementById('regionalFilter');
                        const plantSel = document.getElementById('plantFilter');
                        const bulanSel2 = document.getElementById('bulanFilter');
                        const tahunSel2 = document.getElementById('tahunFilter');
                        const komoSel = document.getElementById('komoditasFilter');
                        const regionalText = regionalSel.selectedIndex >= 0 && regionalSel.value
                            ? 'Regional ' + regionalSel.options[regionalSel.selectedIndex].text
                            : 'Semua Regional';
                        const plantText = plantSel.selectedIndex >= 0 && plantSel.value
                            ? plantSel.options[plantSel.selectedIndex].text
                            : 'Semua Kebun';
                        const bulanText = bulanSel2.value ? 'Periode ' + bulanNames[parseInt(bulanSel2.value)] : 'Semua Bulan';
                        const tahunText = tahunSel2.value || 'Semua Tahun';
                        const komoText = komoSel.value ? komoSel.options[komoSel.selectedIndex].text : 'Semua Komoditas';

                        const judulLaporan = `LM13 - ${regionalText} - ${plantText} - Komoditas: ${komoText}  ${bulanText}  ${tahunText}`;

                        // Simpan data mentah untuk export ─────────────────────────────
                        _exportData = {
                            rows,
                            headers: Object.keys(rows[0]),
                            judul: judulLaporan,
                            numericCols: NUMERIC_COLS,
                        };

                        // ── Header ───────────────────────────────────────────────────
                        let html = '<table class="report-table" style="font-size:12.5px;">';
                        html += '<thead>';
                        // Baris judul (full colspan)
                        html += `<tr>
                                                                                                <th colspan="${headers.length}" style="
                                                                                                    background:#ffffff; color:#111827;
                                                                                                    text-align:center; font-size:13px;
                                                                                                    font-weight:800; padding:10px 16px;
                                                                                                    letter-spacing:0.05em; border-bottom:2px solid #16a34a;">
                                                                                                    ${judulLaporan}
                                                                                                </th>
                                                                                            </tr>`;
                        // Baris kolom header
                        html += '<tr>';
                        headers.forEach(h => {
                            html += `<th style="text-align:left; padding:8px 12px; background:#15803d; color:#fff; white-space:nowrap;">${h.replace(/_/g, ' ').toUpperCase()}</th>`;
                        });
                        html += '</tr></thead>';

                        // ── Body dengan subtotal ─────────────────────────────────────
                        html += '<tbody>';

                        // Akumulator subtotal
                        const initAcc = () => Object.fromEntries(headers.map(h => [h, 0]));
                        const addToAcc = (acc, row) => headers.forEach(h => { if (isSubtotalCol(h) && isNum(row[h])) acc[h] += parseFloat(row[h]); });

                        let acc2 = initAcc(), key2 = '', acc1 = initAcc(), key1 = '';
                        let accTotal = initAcc();  // ← Grand total

                        const subtotalRow = (label, acc, bgColor, fontWeight, borderTop) => {
                            let r = `<tr style="background:${bgColor}; font-weight:${fontWeight}; border-top:${borderTop};">`;
                            headers.forEach((h, idx) => {
                                if (idx === 0) {
                                    r += `<td colspan="2" style="padding:5px 12px; border:1px solid #d1fae5; text-align:right; font-style:italic; white-space:nowrap;">${label}</td>`;
                                } else if (idx === 1) {
                                    return; // sudah di-colspan
                                } else if (isSubtotalCol(h)) {
                                    r += `<td style="padding:5px 12px; border:1px solid #d1fae5; text-align:right; white-space:nowrap;">${fmt(acc[h])}</td>`;
                                } else {
                                    r += `<td style="padding:5px 12px; border:1px solid #d1fae5;"></td>`;
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
                                // Subtotal level-2
                                html += subtotalRow(`Jumlah ${key2}`, acc2, '#f0fdf4', '700', '2px solid #bbf7d0');
                                acc2 = initAcc();

                                // Deteksi pergantian grup 1-char
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
                            addToAcc(accTotal, row);  // ← akumulasi grand total

                            // Baris data biasa
                            const bg = i % 2 === 0 ? '#fff' : '#f9fafb';
                            html += `<tr style="background:${bg};">`;
                            headers.forEach(h => {
                                const val = row[h];
                                const num = isNum(val);
                                html += `<td style="padding:5px 12px; border:1px solid #e5e7eb; text-align:${num ? 'right' : 'left'}; white-space:nowrap;">${fmt(val)}</td>`;
                            });
                            html += '</tr>';
                        });

                        // Subtotal terakhir (sisa grup yang belum di-flush)
                        if (key2) html += subtotalRow(`Jumlah ${key2}`, acc2, '#f0fdf4', '700', '2px solid #bbf7d0');
                        if (key1) html += subtotalRow(`Jumlah ${key1}`, acc1, '#dcfce7', '800', '2px solid #166534');

                        // ── Grand Total ───────────────────────────────────────────────
                        // let gt = `<tr style="background:#14532d; color:#fff; font-weight:900; border-top:3px solid #052e16;">`;
                        // headers.forEach((h, idx) => {
                        //     if (idx === 0) {
                        //         gt += `<td colspan="2" style="padding:7px 12px; border:1px solid #166534; text-align:right; white-space:nowrap; color:#fff;">JUMLAH TOTAL</td>`;
                        //     } else if (idx === 1) {
                        //         return;
                        //     } else if (isSubtotalCol(h)) {
                        //         gt += `<td style="padding:7px 12px; border:1px solid #166534; text-align:right; white-space:nowrap; color:#fff;">${fmt(accTotal[h])}</td>`;
                        //     } else {
                        //         gt += `<td style="padding:7px 12px; border:1px solid #166534; color:#fff;"></td>`;
                        //     }
                        // });
                        // gt += '</tr>';
                        // html += gt;

                        html += '</tbody></table>';

                        result.innerHTML = html;
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
                get_data_lm13(komoditas, regional, plant, tahun, bulan);
            });

            // Reset — gunakan tahun berjalan dari server
            document.getElementById('btnReset').addEventListener('click', function () {
                setTimeout(function () {
                    tahunSel.value = '';
                    bulanSel.value = '';
                    document.getElementById('regionalFilter').value = '';
                    rebuildPlantFilter(''); // tampilkan semua plant
                    $('#plantFilter').val('').trigger('change');
                    resultCard.style.display = 'none';
                    updateLabels();
                    checkEnableSearch(); // disable tombol Cari kembali
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

            const { rows, headers, judul, numericCols } = _exportData;
            const isSubCol = h => numericCols && numericCols.has(h);
            const isNum = v => v !== null && v !== '' && v !== undefined && !isNaN(parseFloat(v));

            const workbook = new ExcelJS.Workbook();
            const ws = workbook.addWorksheet('LM13');

            // ── Pastikan worksheet TIDAK diproteksi ──────────────────────────────
            ws.properties = ws.properties || {};

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
            titleCell.protection = { locked: false };
            ws.getRow(1).height = 22;

            // ── Baris 2: Header kolom ────────────────────────────────────────────
            const hRow = ws.addRow(headers.map(h => h.replace(/_/g, ' ').toUpperCase()));
            hRow.eachCell(cell => {
                cell.fill = fillSolid('FF15803D');
                cell.font = { bold: true, color: { argb: 'FFFFFFFF' }, size: 9 };
                cell.alignment = { horizontal: 'center', vertical: 'middle', wrapText: true };
                cell.border = border();
                cell.protection = { locked: false };
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
                    cell.protection = { locked: false };
                    const h = headers[colNum - 1];
                    if (colNum > 2 && numericColsExport.has(h)) {
                        cell.numFmt = '#,##0';
                        cell.alignment = { horizontal: 'right' };
                    }
                });
                try { ws.mergeCells(rNum, 1, rNum, 2); } catch (e) { }
                ws.getCell(rNum, 1).alignment = { horizontal: 'right', vertical: 'middle', italic: true };
            };

            // ── Akumulator ───────────────────────────────────────────────────────
            const numericColsExport = numericCols || new Set(headers.filter(h => {
                const v = rows[0][h];
                return v !== null && v !== '' && v !== undefined && !isNaN(parseFloat(v));
            }));
            const initAcc = () => Object.fromEntries(headers.map(h => [h, 0]));
            const addToAcc = (acc, row) => headers.forEach(h => {
                if (numericColsExport.has(h) && isNum(row[h])) acc[h] += parseFloat(row[h]);
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
                    cell.protection = { locked: false };
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
                cell.protection = { locked: false };
                if (colNum > 2 && numericColsExport.has(headers[colNum - 1])) {
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
            if (!_exportData) { alert('Belum ada data untuk diekspor.'); return; }

            const { rows, headers, judul, numericCols } = _exportData;
            const isNum = v => v !== null && v !== '' && v !== undefined && !isNaN(parseFloat(v));

            // Rebuild numericCols jika perlu
            const numCols = numericCols instanceof Set ? numericCols : new Set(
                headers.filter(h => { const v = rows[0]?.[h]; return isNum(v); })
            );
            const isSubCol = h => numCols.has(h);

            // Format angka lokal ID
            const fmtNum = v => isNum(v) ? parseFloat(v).toLocaleString('id-ID') : (v ?? '');

            // ── Akumulasi + build body ───────────────────────────────────────
            const initAcc = () => Object.fromEntries(headers.map(h => [h, 0]));
            const addToAcc = (acc, row) => headers.forEach(h => {
                if (isSubCol(h) && isNum(row[h])) acc[h] += parseFloat(row[h]);
            });

            const body = [];
            let acc2 = initAcc(), key2 = '', acc1 = initAcc(), key1 = '';
            let accTotal = initAcc();

            const makeSubRow = (label, acc, fillRgb) => {
                const cells = headers.map((h, idx) => {
                    let val = '';
                    if (idx === 0) val = label;
                    else if (idx === 1) val = '';
                    else if (isSubCol(h)) val = fmtNum(acc[h]);
                    return {
                        content: val,
                        styles: {
                            halign: idx >= 2 && val !== '' ? 'right' : (idx === 0 ? 'right' : 'left'),
                            fontStyle: 'bold',
                            fillColor: fillRgb,
                            textColor: [20, 83, 45],
                            fontSize: 6.5,
                        },
                    };
                });
                body.push(cells);
            };

            for (const row of rows) {
                const kode = (row['kode'] || row['kdbe'] || row['KODE'] || '').toString();
                const grp2 = kode.substring(0, 2).toUpperCase();
                const grp1 = kode.substring(0, 1).toUpperCase();

                if (key2 && grp2 !== key2) {
                    makeSubRow(`Jumlah ${key2}`, acc2, [240, 253, 244]);
                    acc2 = initAcc();
                    if (grp1 !== key1) {
                        makeSubRow(`Jumlah ${key1}`, acc1, [220, 252, 231]);
                        acc1 = initAcc();
                    }
                }
                key2 = grp2; key1 = grp1;
                addToAcc(acc2, row); addToAcc(acc1, row); addToAcc(accTotal, row);

                // Baris data
                const cells = headers.map((h, idx) => {
                    const v = row[h];
                    const display = isNum(v) ? fmtNum(v) : (v ?? '');
                    return {
                        content: display,
                        styles: {
                            halign: isNum(v) && !h.toLowerCase().includes('kode') ? 'right' : 'left',
                            fontSize: 6.5,
                        },
                    };
                });
                body.push(cells);
            }

            // Subtotal terakhir
            if (key2) makeSubRow(`Jumlah ${key2}`, acc2, [240, 253, 244]);
            if (key1) makeSubRow(`Jumlah ${key1}`, acc1, [220, 252, 231]);

            // Grand Total
            const gtCells = headers.map((h, idx) => {
                let val = '';
                if (idx === 0) val = 'JUMLAH TOTAL';
                else if (idx === 1) val = '';
                else if (isSubCol(h)) val = fmtNum(accTotal[h]);
                return {
                    content: val,
                    styles: {
                        halign: idx >= 2 && val !== '' ? 'right' : (idx === 0 ? 'right' : 'left'),
                        fontStyle: 'bold',
                        fillColor: [20, 83, 45],
                        textColor: [255, 255, 255],
                        fontSize: 7,
                    },
                };
            });
            body.push(gtCells);

            // ── Buat PDF ─────────────────────────────────────────────────────
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({ orientation: 'landscape', unit: 'pt', format: 'a3' });

            const pageW = doc.internal.pageSize.getWidth();
            doc.setFontSize(10);
            doc.setFont('helvetica', 'bold');
            doc.text(judul, pageW / 2, 28, { align: 'center' });

            doc.autoTable({
                head: [headers.map(h => h.replace(/_/g, ' ').toUpperCase())],
                body,
                startY: 42,
                styles: {
                    fontSize: 6.5,
                    cellPadding: 2.5,
                    lineWidth: 0.3,
                    lineColor: [209, 250, 229],
                    overflow: 'ellipsize',
                },
                headStyles: {
                    fillColor: [21, 128, 61],
                    textColor: 255,
                    fontStyle: 'bold',
                    fontSize: 6.5,
                    halign: 'center',
                    cellPadding: 3,
                },
                alternateRowStyles: { fillColor: [249, 250, 251] },
                margin: { top: 42, left: 18, right: 18 },
                tableWidth: 'auto',
            });

            doc.save(`${judul}.pdf`);
        }
    </script>
@endsection
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
            box-shadow: 0 0 0 2px rgba(22,101,52,0.12);
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
                                <option value="">-- Pilih Regional --</option>
                                @foreach ($regionalList as $item)
                                    <option value="{{ $item->regional }}">{{ $item->regional }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Plant</label>
                            <select class="form-select select2-plant" id="plantFilter" style="width:100%;">
                                <option value="">-- Pilih Plant --</option>
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
                    <span id="resultInfo" style="color:#93c5fd; font-size:12px;"></span>
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
            function get_data_lm14(plant, tahun, bulan) {
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

                const params = new URLSearchParams({ plant, tahun, bulan });
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

                        let html = '<table class="report-table" style="font-size:12.5px;">';
                        // Header
                        html += '<thead><tr>';
                        headers.forEach(h => {
                            html += `<th style="text-align:left; padding:8px 12px; background:#15803d; color:#fff; white-space:nowrap;">${h.replace(/_/g, ' ').toUpperCase()}</th>`;
                        });
                        html += '</tr></thead>';
                        // Body
                        html += '<tbody>';
                        rows.forEach((row, i) => {
                            const bg = i % 2 === 0 ? '#fff' : '#f0fdf4';
                            html += `<tr style="background:${bg};">`;
                            headers.forEach(h => {
                                const val = row[h];
                                const isNum = val !== null && val !== '' && !isNaN(val) && typeof val !== 'boolean';
                                const formatted = isNum
                                    ? parseFloat(val).toLocaleString('id-ID')
                                    : (val ?? '-');
                                const align = isNum ? 'right' : 'left';
                                html += `<td style="padding:5px 12px; border:1px solid #e5e7eb; text-align:${align}; white-space:nowrap;">${formatted}</td>`;
                            });
                            html += '</tr>';
                        });
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
                get_data_lm14(plant, tahun, bulan);
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
                placeholder: '-- Pilih Plant --',
                allowClear: true,
                width: '100%',
            });
        });
    </script>
@endsection
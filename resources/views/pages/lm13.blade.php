@extends('layouts.app')

@section('styles')
    <style>
        /* ===== SCROLL FIX — override Tailwind h-screen di body ===== */
        html, body {
            height: auto !important;
            min-height: 100vh;
            overflow-y: auto !important;
        }

        /* Override padding dari layout .main-content */
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
            padding: 8px 50px 8px 50px;
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
        .lm-header-logo img { width: 100%; height: 100%; object-fit: contain; }
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
            line-height: 1.2;
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
            box-shadow: 0 1px 4px rgba(22,101,52,0.08);
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

        .form-group { display: flex; flex-direction: column; }

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
            box-shadow: 0 0 0 2px rgba(22,101,52,0.12);
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
        .btn-filter:hover { background: #15803d; }

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
        .btn-reset:hover { background: #f3f4f6; }

        /* ===== TABLE CARD ===== */
        .table-card {
            background: #fff;
            border: 2px solid #166534;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(22,101,52,0.10);
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
            background: #166534;
            color: #fff;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 9px 12px;
            border: 1px solid #14532d;
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
@endsection

@section('content')
    <div class="lm13-container main-content">
        <!-- Page Header — sama seperti gudang_utilisasi -->
        <header class="lm-page-header">
            <div class="lm-header-logo">
                <img src="{{ asset('danantara.png') }}" alt="Danantara">
            </div>
            <div class="lm-header-center">
                <svg style="width:28px;height:28px;color:#22c55e;flex-shrink:0;" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zm-7 14H7v-2h5v2zm5-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
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
                                <option value="karet">Karet</option>
                                <option value="teh">Teh</option>
                                <option value="kopi">Kopi</option>
                                <option value="tembakau">Tembakau</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Regional</label>
                            <select class="form-select" id="regionalFilter">
                                <option value="">-- Pilih Regional --</option>
                                <option value="regional-1">Regional 1</option>
                                <option value="regional-2">Regional 2</option>
                                <option value="regional-3">Regional 3</option>
                                <option value="regional-4">Regional 4</option>
                                <option value="regional-5">Regional 5</option>
                                <option value="regional-6">Regional 6</option>
                                <option value="regional-7">Regional 7</option>
                                <option value="regional-8">Regional 8</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tahun</label>
                            <select class="form-select" id="tahunFilter">
                                <option value="">-- Pilih Tahun --</option>
                                <option value="2024" selected>2024</option>
                                <option value="2023">2023</option>
                                <option value="2022">2022</option>
                                <option value="2021">2021</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Bulan</label>
                            <select class="form-select" id="bulanFilter">
                                <option value="">-- Pilih Bulan --</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
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
                        <button type="submit" class="btn-filter">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </form>
            </div>

            <!-- ====== PRODUCTION REPORT TABLE ====== -->
            <div class="table-card">
                <div class="table-header">
                    <div class="table-title">
                        <i class="fas fa-file-invoice-dollar"></i>
                        Laporan Biaya Produksi — LM 13
                    </div>
                    <span style="color:#dcfce7; font-size:12px;">
                        s/d Bulan ini &mdash; Tahun <strong id="tblYearLabel">2024</strong>
                    </span>
                </div>

                <div class="table-wrapper">
                    <table class="report-table" id="reportTable">
                        <thead>
                            <!-- Row 1: top group labels -->
                            <tr>
                                <th rowspan="3" class="col-norek" style="vertical-align:middle; width:70px;">
                                    Nomor<br>Rekening</th>
                                <th rowspan="3" class="col-label"
                                    style="text-align:left; vertical-align:middle; min-width:270px;">Uraian</th>
                                <th colspan="3" class="col-group">Jumlah Kilogram &mdash; s/d Bulan ini</th>
                                <th colspan="3" class="col-group">Kilogram per Hektar &mdash; s/d Bulan ini</th>
                            </tr>
                            <!-- Row 2: sub-year labels for first block -->
                            <tr>
                                <th class="col-group" style="font-size:10px; padding:5px 8px;">
                                    Real <span class="dyn-year-prev">2023</span>
                                </th>
                                <th class="col-group" style="font-size:10px; padding:5px 8px;">
                                    Real <span class="dyn-year">2024</span>
                                </th>
                                <th class="col-group" style="font-size:10px; padding:5px 8px;">
                                    RKAP <span class="dyn-year">2024</span>
                                </th>
                                <th class="col-group" style="font-size:10px; padding:5px 8px;">
                                    Real <span class="dyn-year-prev">2023</span>
                                </th>
                                <th class="col-group" style="font-size:10px; padding:5px 8px;">
                                    Real <span class="dyn-year">2024</span>
                                </th>
                                <th class="col-group" style="font-size:10px; padding:5px 8px;">
                                    RKAP <span class="dyn-year">2024</span>
                                </th>
                            </tr>

                        </thead>
                        <tbody>
                            <!-- ====== PRODUKSI ====== -->
                            <tr>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Produksi Kebun Sendiri yang Diolah (Kering)</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Di Pabrik Sendiri</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">6,163,857</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">324</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Kebun Sendiri</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Pihak Ke III</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr class="row-subtotal">
                                <td class="norek-cell"></td>
                                <td class="label-cell" style="text-align:right; padding-right:10px;">Jumlah Produksi Diolah
                                </td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">6,163,857</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="table-wrapper">
                    <table class="report-table" id="reportTable">
                        <thead>
                            <!-- Row 1: top group labels -->
                            <tr>
                                <th rowspan="3" class="col-norek" style="vertical-align:middle; width:70px;">
                                    Nomor<br>Rekening</th>
                                <th rowspan="3" class="col-label"
                                    style="text-align:left; vertical-align:middle; min-width:270px;">Uraian</th>
                                <th colspan="3" class="col-group">Jumlah Kilogram &mdash; s/d Bulan ini</th>
                                <th colspan="3" class="col-group">Kilogram per Hektar &mdash; s/d Bulan ini</th>
                            </tr>
                            <!-- Row 2: sub-year labels for first block -->
                            <tr>
                                <th class="col-group" style="font-size:10px; padding:5px 8px;">
                                    Real <span class="dyn-year-prev">2023</span>
                                </th>
                                <th class="col-group" style="font-size:10px; padding:5px 8px;">
                                    Real <span class="dyn-year">2024</span>
                                </th>
                                <th class="col-group" style="font-size:10px; padding:5px 8px;">
                                    RKAP <span class="dyn-year">2024</span>
                                </th>
                                <th class="col-group" style="font-size:10px; padding:5px 8px;">
                                    Real <span class="dyn-year-prev">2023</span>
                                </th>
                                <th class="col-group" style="font-size:10px; padding:5px 8px;">
                                    Real <span class="dyn-year">2024</span>
                                </th>
                                <th class="col-group" style="font-size:10px; padding:5px 8px;">
                                    RKAP <span class="dyn-year">2024</span>
                                </th>
                            </tr>

                        </thead>
                        <tbody>

                            <!-- ====== BEBAN PRODUKSI — section header ====== -->


                            <!-- ====== BEBAN TANAMAN ====== -->
                            <tr>
                                <td class="norek-cell">5.1.1</td>
                                <td class="label-cell indent">Gaji dan Tunjangan Kary. Pimpinan</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">7,843,792,621</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">1,273</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5.1.2</td>
                                <td class="label-cell indent">Gaji dan Tunjangan Kary. Pelaksana</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">6,973,083,197</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">1,131</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5.1.3</td>
                                <td class="label-cell indent">Pemeliharaan Tan. Menghasilkan</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">5,022,156,709</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">815</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5.1.4</td>
                                <td class="label-cell indent">Pemupukan</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5.1.5</td>
                                <td class="label-cell indent">Panen</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">96,434,855,359</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">15,645</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5.1.6</td>
                                <td class="label-cell indent">Pengangkutan ke Pabrik</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">9,188,052,848</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">1,491</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5.1.7</td>
                                <td class="label-cell indent">Beban Overhead</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">20,655,041,594</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">3,351</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr class="row-subtotal">
                                <td class="norek-cell"></td>
                                <td class="label-cell" style="text-align:right; padding-right:10px;">Jumlah Beban Tanaman :
                                </td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">146,116,982,328</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">23,705</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>

                            <!-- ====== BEBAN PENGOLAHAN ====== -->
                            <tr>
                                <td class="norek-cell">5.2.1</td>
                                <td class="label-cell indent">Beban Overhead Kebun</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">91,771,890</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">15</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5.2.2</td>
                                <td class="label-cell indent">Beban Langsung Pengolahan</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">18,942,119,584</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">3,073</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr class="row-subtotal">
                                <td class="norek-cell"></td>
                                <td class="label-cell" style="text-align:right; padding-right:10px;">Jumlah Beban Pengolahan
                                    :</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">19,033,891,474</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">3,088</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>

                            <!-- ====== EXCL. PENYUSUTAN ====== -->
                            <tr class="row-subtotal">
                                <td class="norek-cell"></td>
                                <td class="label-cell" style="text-align:right; padding-right:10px;">Jumlah Beban Produksi.
                                    Excl. Penyst :</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">165,150,873,802</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">26,793</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>

                            <!-- ====== BEBAN PENYUSUTAN ====== -->
                            <tr>
                                <td class="norek-cell">5.3.1</td>
                                <td class="label-cell indent">Beban Penyst. Overhead Kebun</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">23,080,584,130</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">3,745</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5.3.2</td>
                                <td class="label-cell indent">Beban Penyst. Pengolahan</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">1,257,131,309</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">204</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr class="row-subtotal">
                                <td class="norek-cell"></td>
                                <td class="label-cell" style="text-align:right; padding-right:10px;">Jumlah Beban Produksi
                                    Kebun Inti :</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">189,488,589,241</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">30,538</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr class="row-subtotal">
                                <td class="norek-cell"></td>
                                <td class="label-cell" style="text-align:right; padding-right:10px;">Jumlah Beban Produksi
                                    Excl.By Admin :</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">168,833,547,647</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">26,793</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>

                            <!-- ====== BEBAN PIHAK KE III ====== -->
                            <tr>
                                <td class="norek-cell">5.4</td>
                                <td class="label-cell indent">Beban Pihak Ke III</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>

                            <!-- ====== JUMLAH TOTAL ====== -->
                            <tr class="row-total">
                                <td class="norek-cell"></td>
                                <td class="label-cell" style="text-align:center; font-size:13px; padding-left:14px;">Jumlah
                                    Beban Produksi</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">189,488,589,241</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">30,742</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>

                            <!-- ====== INFO PER HEKTAR ====== -->
                            <tr class="row-info">
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Biaya Tanaman per Ha</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">7,687,163.16</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr class="row-info">
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Biaya Produksi excl. Penyust. per Ha</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">8,688,529.51</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr class="row-info">
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Biaya Produksi excl. By Admi. per Ha</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">8,882,273.69</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- ====== END TABLE ====== -->

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tahunSel = document.getElementById('tahunFilter');

            function updateYearLabels() {
                const yr = parseInt(tahunSel.value) || new Date().getFullYear();
                const yrP = yr - 1;

                document.querySelectorAll('.dyn-year').forEach(el => el.textContent = yr);
                document.querySelectorAll('.dyn-year-prev').forEach(el => el.textContent = yrP);
                document.getElementById('tblYearLabel').textContent = yr;
            }

            // Init on page load
            updateYearLabels();

            // Update on change
            tahunSel.addEventListener('change', updateYearLabels);

            // Filter form submit
            document.getElementById('filterForm').addEventListener('submit', function (e) {
                e.preventDefault();
                updateYearLabels();
            });

            // Reset
            document.getElementById('btnReset').addEventListener('click', function () {
                setTimeout(function () {
                    tahunSel.value = '2024';
                    updateYearLabels();
                }, 50);
            });
        });
    </script>

@endsection
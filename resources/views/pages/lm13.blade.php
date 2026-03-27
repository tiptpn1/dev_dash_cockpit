@extends('layouts.app')

@section('content')
    <style>
        /* ===== MAIN CONTAINER — width shrinks when sidebar opens ===== */
        .lm13-container {
            padding: 0;
            margin: 0;
            width: 100%;
            height: 100%;
            background: #0d1b2a;
            overflow-y: auto;
            overflow-x: hidden;
            transition: width 0.3s;
            box-sizing: border-box;
            position: relative;
        }

        /* When sidebar is open, subtract sidebar width so content doesn't overflow */
        .sidebar.open~.lm13-container {
            width: calc(100% - 230px);
        }

        /* ===== Animated background blobs ===== */
        .bg-blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.22;
            pointer-events: none;
            z-index: 0;
        }

        .bg-blob-1 {
            width: 520px;
            height: 520px;
            background: radial-gradient(circle, #1e3a5f, transparent);
            top: -120px;
            left: -120px;
            animation: bgBlob1 9s ease-in-out infinite alternate;
        }

        .bg-blob-2 {
            width: 420px;
            height: 420px;
            background: radial-gradient(circle, #3c6bb5, transparent);
            bottom: -80px;
            right: -80px;
            animation: bgBlob2 11s ease-in-out infinite alternate;
        }

        .bg-blob-3 {
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, #4a7bc8, transparent);
            top: 45%;
            left: 55%;
            animation: bgBlob1 13s ease-in-out infinite alternate;
        }

        @keyframes bgBlob1 {
            from {
                transform: translate(0, 0) scale(1);
            }

            to {
                transform: translate(45px, 30px) scale(1.12);
            }
        }

        @keyframes bgBlob2 {
            from {
                transform: translate(0, 0) scale(1);
            }

            to {
                transform: translate(-35px, -20px) scale(1.09);
            }
        }

        /* dot-grid overlay */
        .bg-grid {
            position: fixed;
            inset: 0;
            background-image: radial-gradient(circle, rgba(255, 255, 255, 0.06) 1px, transparent 1px);
            background-size: 32px 32px;
            pointer-events: none;
            z-index: 0;
        }

        /* ensure content sits above background layers */
        .gradient-header,
        .content-section {
            position: relative;
            z-index: 1;
        }

        .gradient-header {
            background: linear-gradient(to right, #1e40af 0%, #2563eb 100%);
            color: white;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .header-content {
            max-width: 100%;
            margin: 0;
            padding: 0 16px;
        }

        .header-title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .content-section {
            max-width: 100%;
            margin: 0;
            padding: 14px 16px 24px;
        }

        .filter-card {
            background: rgba(30, 64, 175, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
            backdrop-filter: blur(10px);
        }

        .filter-title {
            color: white;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .filter-title i {
            margin-right: 8px;
            color: #60a5fa;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            color: #e0e7ff;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-select {
            width: 100%;
            padding: 10px 12px;
            background-color: rgba(15, 23, 42, 0.5);
            border: 1px solid rgba(100, 116, 139, 0.5);
            border-radius: 8px;
            color: white;
            font-size: 13px;
            transition: all 0.3s ease;
        }

        .form-select:focus {
            outline: none;
            border-color: #60a5fa;
            background-color: rgba(15, 23, 42, 0.9);
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.1);
        }

        .form-select option {
            background-color: #0f172a;
            color: white;
        }

        .button-group {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 15px;
        }

        .btn-filter {
            padding: 10px 24px;
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
        }

        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        .btn-reset {
            padding: 10px 24px;
            background: rgba(100, 116, 139, 0.3);
            color: #cbd5e1;
            border: 1px solid rgba(148, 163, 184, 0.5);
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
        }

        .btn-reset:hover {
            background: rgba(100, 116, 139, 0.5);
        }

        /* ===== REPORT TABLE ===== */
        .table-card {
            background: rgba(8, 18, 60, 0.55);
            border: 1px solid rgba(96, 165, 250, 0.2);
            border-radius: 12px;
            overflow: hidden;
            backdrop-filter: blur(16px);
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.45),
                0 0 0 1px rgba(255, 255, 255, 0.04) inset;
        }

        .table-header {
            background: linear-gradient(135deg, rgba(15, 35, 120, 0.85) 0%, rgba(30, 64, 200, 0.75) 100%);
            padding: 16px 24px;
            border-bottom: 2px solid rgba(96, 165, 250, 0.45);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .table-title {
            color: white;
            font-size: 15px;
            font-weight: 700;
            display: flex;
            align-items: center;
            letter-spacing: 0.03em;
        }

        .table-title i {
            margin-right: 8px;
            color: #60a5fa;
        }

        .table-wrapper {
            overflow-x: auto;
            width: 100%;
            margin-bottom: 20px;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11.5px;
            color: #e2e8f0;
        }

        .report-table thead th {
            background: rgba(71, 85, 105, 0.55);
            color: #cbd5e1;
            font-weight: 700;
            font-size: 11.5px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 11px 14px;
            border: 1px solid rgba(148, 163, 184, 0.25);
            text-align: center;
            white-space: nowrap;
        }

        .report-table thead th.col-group {
            background: rgba(100, 116, 139, 0.45);
            color: #e2e8f0;
            font-size: 12.5px;
            letter-spacing: 0.04em;
            border-bottom: 2px solid rgba(148, 163, 184, 0.35);
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
            border: 1px solid rgba(100, 116, 139, 0.2);
            vertical-align: middle;
            color: #e2e8f0;
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
            background: rgba(30, 64, 175, 0.3);
            font-weight: 700;
            color: #bfdbfe;
        }

        .report-table tbody tr.row-total td {
            background: rgba(20, 50, 160, 0.6);
            font-weight: 700;
            color: #60a5fa;
            border-top: 2px solid rgba(96, 165, 250, 0.5);
            border-bottom: 2px solid rgba(96, 165, 250, 0.5);
        }

        .report-table tbody tr.row-section-header td {
            background: rgba(30, 60, 140, 0.5);
            font-weight: 700;
            color: #93c5fd;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding-top: 9px;
            padding-bottom: 9px;
        }

        .report-table tbody tr.row-info td {
            background: rgba(8, 20, 60, 0.25);
            color: #94a3b8;
            font-style: italic;
        }

        .report-table tbody tr:hover td {
            background-color: rgba(59, 130, 246, 0.08);
        }

        .report-table tbody tr.row-subtotal:hover td,
        .report-table tbody tr.row-total:hover td,
        .report-table tbody tr.row-section-header:hover td {
            filter: brightness(1.06);
        }

        .dash {
            color: #475569;
        }

        .norek-cell {
            text-align: center;
            color: #64748b;
            font-size: 11px;
        }
    </style>

    <div class="lm13-container main-content">
        <!-- Background layers -->
        <div class="bg-blob bg-blob-1"></div>
        <div class="bg-blob bg-blob-2"></div>
        <div class="bg-blob bg-blob-3"></div>
        <div class="bg-grid"></div>
        <!-- Header -->
        <div class="gradient-header">
            <div class="header-content">
                <div class="header-title">
                    <i class="fas fa-chart-bar" style="margin-right: 12px;"></i> LM 13 - Biaya Produksi
                </div>
                <p style="color: rgba(255,255,255,0.8); font-size: 14px; margin: 0;">
                    Manajemen Biaya Produksi per Komoditi per Regional dan Periode
                </p>
            </div>
        </div>

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
                    <span style="color:#93c5fd; font-size:12px;">
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
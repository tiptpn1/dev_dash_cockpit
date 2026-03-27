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
            width: 520px; height: 520px;
            background: radial-gradient(circle, #1e3a5f, transparent);
            top: -120px; left: -120px;
            animation: bgBlob1 9s ease-in-out infinite alternate;
        }
        .bg-blob-2 {
            width: 420px; height: 420px;
            background: radial-gradient(circle, #3c6bb5, transparent);
            bottom: -80px; right: -80px;
            animation: bgBlob2 11s ease-in-out infinite alternate;
        }
        .bg-blob-3 {
            width: 320px; height: 320px;
            background: radial-gradient(circle, #4a7bc8, transparent);
            top: 45%; left: 55%;
            animation: bgBlob1 13s ease-in-out infinite alternate;
        }
        @keyframes bgBlob1 {
            from { transform: translate(0,0) scale(1); }
            to   { transform: translate(45px,30px) scale(1.12); }
        }
        @keyframes bgBlob2 {
            from { transform: translate(0,0) scale(1); }
            to   { transform: translate(-35px,-20px) scale(1.09); }
        }
        /* dot-grid overlay */
        .bg-grid {
            position: fixed;
            inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,0.06) 1px, transparent 1px);
            background-size: 32px 32px;
            pointer-events: none;
            z-index: 0;
        }
        /* ensure content sits above background layers */
        .gradient-header, .content-section { position: relative; z-index: 1; }

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
                    <i class="fas fa-chart-bar" style="margin-right: 12px;"></i> LM 14 - Biaya Tanaman
                </div>
                <p style="color: rgba(255,255,255,0.8); font-size: 14px; margin: 0;">
                    Manajemen Biaya Tanaman per Komoditi per Regional dan Periode
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
                                <option value="2025" selected>2025</option>
                                <option value="2024">2024</option>
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

            <!-- ====== LM14 REPORT TABLE ====== -->
            <div class="table-card">
                <div class="table-header">
                    <div class="table-title">
                        <i class="fas fa-seedling"></i>
                        Laporan Biaya Tanaman &mdash; LM 14
                    </div>
                    <span style="color:#93c5fd; font-size:12px;">
                        s/d Bulan <strong id="tblBulanLabel">-</strong> &mdash; Tahun <strong id="tblYearLabel">2025</strong>
                    </span>
                </div>

                <div class="table-wrapper">
                    <table class="report-table" id="reportTable">
                        <thead>
                            <!-- Row 1: fixed cols + 2 group spans -->
                            <tr>
                                <th rowspan="2" style="vertical-align:middle; width:48px;">WBS</th>
                                <th rowspan="2" style="vertical-align:middle; width:48px;">GL</th>
                                <th rowspan="2" class="col-label" style="text-align:left; vertical-align:middle; min-width:220px;">Nama Rekening</th>
                                <th rowspan="2" style="vertical-align:middle; width:40px;">Stn</th>
                                <th colspan="5" class="col-group">BULAN INI</th>
                                <th colspan="5" class="col-group">S.D BULAN INI</th>
                            </tr>
                            <!-- Row 2: sub-columns -->
                            <tr>
                                <!-- Bulan Ini -->
                                <th style="font-size:10px; padding:5px 6px; background:rgba(71,85,105,0.55); color:#cbd5e1;">FISIK</th>
                                <th style="font-size:10px; padding:5px 6px; background:rgba(71,85,105,0.55); color:#cbd5e1;">BIAYA<br>BAHAN</th>
                                <th style="font-size:10px; padding:5px 6px; background:rgba(71,85,105,0.55); color:#cbd5e1;">BIAYA<br>PEMELIHARAAN</th>
                                <th style="font-size:10px; padding:5px 6px; background:rgba(71,85,105,0.55); color:#cbd5e1;">TOTAL BIAYA<br>(Rp.)</th>
                                <th style="font-size:10px; padding:5px 6px; background:rgba(71,85,105,0.55); color:#cbd5e1;">RP/Ha</th>
                                <!-- S.D Bulan Ini -->
                                <th style="font-size:10px; padding:5px 6px; background:rgba(100,116,139,0.45); color:#e2e8f0;">FISIK</th>
                                <th style="font-size:10px; padding:5px 6px; background:rgba(100,116,139,0.45); color:#e2e8f0;">BIAYA<br>BAHAN</th>
                                <th style="font-size:10px; padding:5px 6px; background:rgba(100,116,139,0.45); color:#e2e8f0;">BIAYA<br>PEMELIHARAAN</th>
                                <th style="font-size:10px; padding:5px 6px; background:rgba(100,116,139,0.45); color:#e2e8f0;">TOTAL BIAYA<br>(Rp.)</th>
                                <th style="font-size:10px; padding:5px 6px; background:rgba(100,116,139,0.45); color:#e2e8f0;">Rp/Ha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- ======================================================= -->
                            <!-- ====== A. BIAYA TANAMAN — Header Section ====== -->
                            <!-- ======================================================= -->
                            <tr class="row-section-header">
                                <td colspan="14" class="label-cell" style="font-size:12px; padding-left:10px; letter-spacing:0.08em;">
                                    BIAYA TANAMAN
                                </td>
                            </tr>

                            <!-- ====== JUMLAH GAJI ====== -->
                            <tr>
                                <td class="norek-cell">9501</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Gaji/Upah dan Biaya Kary. Staf dari WBS</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">42,098,903,106</td>
                                <td class="num">42,098,903,106</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">9001</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Gaji/Upah dan Biaya Kary. Pelaksana dari WRS</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">36,433,073,100</td>
                                <td class="num">36,433,073,100</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell"></td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Gaji/Upah dan Biaya Kary. Staf dari CC</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell"></td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Gaji/Upah dan Biaya Kary. Pelaksana dari CC</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr class="row-subtotal">
                                <td colspan="4" class="label-cell" style="text-align:right; padding-right:10px;">JUMLAH GAJI</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">78,531,976,206</td>
                                <td class="num">78,531,976,206</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>

                            <!-- ====== PEMELIHARAAN TANAH ====== -->
                            <tr>
                                <td class="norek-cell">5201</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Pemeliharaan Parit</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">8</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">154,987,227</td>
                                <td class="num">154,987,227</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5202</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Pemeliharaan Jalan</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">2,146</td>
                                <td class="num">73,085,735</td>
                                <td class="num">1,826,053,341</td>
                                <td class="num">1,899,139,076</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5203</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Grading &amp; Compact Jalan</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">493</td>
                                <td class="num">6,908,870</td>
                                <td class="num">66,978,000</td>
                                <td class="num">73,886,870</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5204</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Pemeliharaan Jalan dan Jembatan</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">868</td>
                                <td class="num">24,398,856</td>
                                <td class="num">409,274,715</td>
                                <td class="num">433,673,571</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5205</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Pengerasan Jalan dengan Situ dan Batu</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">420</td>
                                <td class="num">8,659,549</td>
                                <td class="num">88,274,000</td>
                                <td class="num">96,933,549</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5206</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Pengangkutan Tanah</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5207</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Pengangkutan Titi/Jembatan</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">2,728,000</td>
                                <td class="num">2,728,000</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5208</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Pengangkutan Material Lainnya</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5209</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">TM Pemel Teras</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">18,647,000</td>
                                <td class="num">18,647,000</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5210</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">TM Pembuatan Rorak</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5211</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Pemeliharaan Rorak</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5212</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Pemeliharaan Ereng-Ereng</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5213</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Pemeliharaan Saluran Air</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5214</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Jaga Api</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">20</td>
                                <td class="num">1,870,000</td>
                                <td class="num">480,885,640</td>
                                <td class="num">482,755,640</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">6209</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Pengawas/Mandor Pemeliharaan</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">403,132,055</td>
                                <td class="num">403,132,055</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">6211</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">TM - Pengawas / Mandor Pemeliharaan</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">6,461,218,595</td>
                                <td class="num">6,461,218,595</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">9601</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Alokasi GC Pemel</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">2,878,172,090</td>
                                <td class="num">2,878,172,090</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr class="row-subtotal">
                                <td colspan="4" class="label-cell" style="font-size:10px; text-align:right; padding-right:8px;">
                                    Jumlah Biaya Pemeliharaan pemeliharaan jalan, jembatan, dan saluran air
                                </td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">4,189</td>
                                <td class="num">115,527,035</td>
                                <td class="num">12,789,730,668</td>
                                <td class="num">12,905,257,703</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>

                            <!-- ====== PEMANGKASAN / TUNAS ====== -->
                            <tr>
                                <td class="norek-cell">5701</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Memotong Tajuk/Menunas Pohon</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr class="row-subtotal">
                                <td colspan="4" class="label-cell" style="text-align:right; padding-right:8px;">Jumlah Biaya Pemangkasan / Tunas</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>

                            <!-- ====== PENGENDALIAN GULMA ====== -->
                            <tr>
                                <td class="norek-cell">5301</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Penyiangan / Pengendalian Gulma Chemis</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">11,230</td>
                                <td class="num">601,759,897</td>
                                <td class="num">1,570,126,340</td>
                                <td class="num">2,227,886,237</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5302</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Dongkel Akar Kayu</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">440</td>
                                <td class="num">5,472,354</td>
                                <td class="num">152,317,254</td>
                                <td class="num">157,789,618</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5303</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Pengendalian Lalang Sheet</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">178</td>
                                <td class="num">12,581,036</td>
                                <td class="num">18,487,590</td>
                                <td class="num">31,165,198</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5304</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Pemeliharaan Gawangan Manual</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">159</td>
                                <td class="num">6,845,576</td>
                                <td class="num">5,416,408,899</td>
                                <td class="num">5,423,254,475</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5305</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Pemeliharaan Gawangan Chemis</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">9,212</td>
                                <td class="num">857,083,374</td>
                                <td class="num">2,188,004,215</td>
                                <td class="num">2,645,987,589</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5306</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Menyiang/Menupuk Manual</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">353</td>
                                <td class="num">38,653,087</td>
                                <td class="num">4,778,630,011</td>
                                <td class="num">4,817,283,098</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5307</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Strip Weeding Chemis</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">34,540</td>
                                <td class="num">2,342,050,059</td>
                                <td class="num">3,013,267,086</td>
                                <td class="num">5,355,317,145</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5302</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Perencek/Memotong Batang-Banting</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5308</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">TM - Transport Tenaga</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">242,100</td>
                                <td class="num">171,172,029</td>
                                <td class="num">171,415,029</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr class="row-subtotal">
                                <td colspan="4" class="label-cell" style="text-align:right; padding-right:8px;">Jumlah Biaya Pengendalian Gulma</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">56,110</td>
                                <td class="num">3,715,988,155</td>
                                <td class="num">17,314,124,234</td>
                                <td class="num">21,030,112,389</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>

                            <!-- ====== COLLECTION ====== -->
                            <tr>
                                <td class="norek-cell">5501</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Collectori/CHL</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5503</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Kekeringan Alur Sadap - Kerok &amp; Lumas</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">10</td>
                                <td class="num">1,489,971</td>
                                <td class="num">1,180,000</td>
                                <td class="num">2,658,971</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5504</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Jamur Upas</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5505</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Bark Nicrosis (BN)</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5506</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Moudrot</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <!-- ====== COLLECTION (lanjutan) ====== -->
                            <tr>
                                <td class="norek-cell">5507</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Stimulasi</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">21</td>
                                <td class="num">3,876,318</td>
                                <td class="num">87,862,883</td>
                                <td class="num">91,939,116</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5508</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">OC-3 Getah AFP</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">172,168</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">172,168</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5509</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Pengendalian Hama Lainnya</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">62,381</td>
                                <td class="num">27,956,848</td>
                                <td class="num">46,780,441</td>
                                <td class="num">74,738,441</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5509</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">TM Pengendalian Penyakit/HLDPV</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">112</td>
                                <td class="num">4,111,876</td>
                                <td class="num">1,763,852</td>
                                <td class="num">15,780,470</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5510</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">TM Pengendalian Penyakit Lainnya</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5511</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Pengendalian Hama dan Penyakit</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">9601</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Alokasi GC Pemel</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr class="row-subtotal">
                                <td colspan="4" class="label-cell" style="text-align:right; padding-right:8px;">Jumlah Biaya Pemberantasan Hama dan Penyakit</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">96,815</td>
                                <td class="num">1,324,479,560</td>
                                <td class="num">481,018,347</td>
                                <td class="num">1,554,496,939</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>

                            <!-- ======================================================= -->
                            <!-- ====== PEMUPUKAN ====== -->
                            <!-- ======================================================= -->
                            <tr>
                                <td class="norek-cell">5401</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Pembuatan Piringan/Tanaman Baru</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">159,263</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">20,471,558,232</td>
                                <td class="num">186,600,404,754</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5402</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Penyiangan DTS (DS)</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">2,276,108</td>
                                <td class="num">3,196,559,709</td>
                                <td class="num">285,463,477,019</td>
                                <td class="num">180,640,036,741</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5403</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Snap Dif</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">362,803</td>
                                <td class="num">1,990,000</td>
                                <td class="num">2,352,803</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5404</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Strip Topang</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">393</td>
                                <td class="num">1,304,592</td>
                                <td class="num">5,144,199,913</td>
                                <td class="num">3,109,227,486</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5405</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Penyemprotan Panel Sadap/Panen</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">1,097,262</td>
                                <td class="num">13,504,562</td>
                                <td class="num">3,565,469,913</td>
                                <td class="num">5,899,237,655</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5406</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Sadap D/S Tess IS TP/I</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">58,761</td>
                                <td class="num">3,542,782,003</td>
                                <td class="num">23,067,009,838</td>
                                <td class="num">23,647,469,388</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5407</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Sadap UTS Super Tapping (Sistem)</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell"></td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Bukan Sadap</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">110,427</td>
                                <td class="num">311,866,498</td>
                                <td class="num">110,779,803</td>
                                <td class="num">110,779,803</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell"></td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Sadap Panel</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">110,773,883</td>
                                <td class="num">110,773,883</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell"></td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Cap Basin</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell"></td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Kelengkapan Alat Sadap/Panen</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">3,008,056</td>
                                <td class="num">3,818,872,713</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">3,064,691,416</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell"></td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">TM - Pengawas/Mandor Panen</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">34,766,489,885</td>
                                <td class="num">34,786,489,985</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell"></td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Pengawas/Mandor Panen</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">1,046,209</td>
                                <td class="num">1,046,209</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">9601</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Alokasi GC Panen</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">3,067,140,082</td>
                                <td class="num">3,067,140,082</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr class="row-subtotal">
                                <td colspan="4" class="label-cell" style="text-align:right; padding-right:8px;">Jumlah Biaya Tanaman SADAP</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">8,151,863</td>
                                <td class="num">8,238,158,711</td>
                                <td class="num">283,830,462,473</td>
                                <td class="num">241,398,440,197</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>

                            <!-- ======================================================= -->
                            <!-- ====== STIMULASI GAS ====== -->
                            <!-- ======================================================= -->
                            <tr>
                                <td class="norek-cell">5801</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Stimulasi GAS - Bahan</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">4,199</td>
                                <td class="num">61,946,900</td>
                                <td class="num">662,832,300</td>
                                <td class="num">648,031,784</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5802</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Stimulasi GAS - Pasang Aplikator</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">17,300</td>
                                <td class="num">130,889,000</td>
                                <td class="num">851,719,850</td>
                                <td class="num">722,410,450</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5803</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Stimulasi GAS - RE GAS</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">1,787,750</td>
                                <td class="num">1,787,750</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5804</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Stimulasi GAS - Pasang BUTON</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5805</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Stimulasi GAS - Lepas Aplikator</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr class="row-subtotal">
                                <td colspan="4" class="label-cell" style="text-align:right; padding-right:8px;">Jumlah Biaya Stimulasi Gas</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">11,305</td>
                                <td class="num">192,835,900</td>
                                <td class="num">40,748,199,809</td>
                                <td class="num">738,319,658</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>

                            <!-- ======================================================= -->
                            <!-- ====== PUPUK DASAR / PEMUPUKAN ====== -->
                            <!-- ======================================================= -->
                            <tr>
                                <td class="norek-cell">5452</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Pemupukan Pokok Tugal</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">71,860</td>
                                <td class="num">779,348,726</td>
                                <td class="num">68,437,087</td>
                                <td class="num">652,440,636</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5453</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Pemupukan Daun Anorganik</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">7,285,469</td>
                                <td class="num">7,285,469</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5454</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Pemupukan Pupuk</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">9601</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Alokasi GC Pemel</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr class="row-subtotal">
                                <td colspan="4" class="label-cell" style="text-align:right; padding-right:8px;">Jumlah Biaya Pemupukan</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">71,860</td>
                                <td class="num">779,348,726</td>
                                <td class="num">75,722,556</td>
                                <td class="num">661,446,780</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>

                            <!-- ======================================================= -->
                            <!-- ====== PEMBERANTASAN PENYAKIT LAINNYA / PENGEMBANGAN ====== -->
                            <!-- ======================================================= -->
                            <tr>
                                <td class="norek-cell">5457</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Pemupukan Lanjut (Ross dan Tanah)</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">71,860</td>
                                <td class="num">779,348,726</td>
                                <td class="num">67,813,306</td>
                                <td class="num">847,443,768</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr class="row-subtotal">
                                <td colspan="4" class="label-cell" style="font-size:10px; text-align:right; padding-right:8px;">Jumlah Biaya Pemupukan Anorganik Lanjut dan Ross</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">71,860</td>
                                <td class="num">779,348,726</td>
                                <td class="num">67,813,306</td>
                                <td class="num">847,443,768</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>

                            <!-- ======================================================= -->
                            <!-- ====== BIAYA PEMELIHARAAN LAIN-LAIN ====== -->
                            <!-- ======================================================= -->
                            <tr>
                                <td class="norek-cell">5157</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Pemeliharaan Bangunan</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">4,278</td>
                                <td class="num">37,748,651</td>
                                <td class="num">14,767,004,251</td>
                                <td class="num">33,878,270,984</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5158</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Pengangkutan Sawit/Kopi/Teh dan Lain-Lain</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">5159</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">TM - Pengangkutan Sawit dan Lain-Lain</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">4,119,865,601</td>
                                <td class="num">4,119,865,601</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr>
                                <td class="norek-cell">9601</td>
                                <td class="norek-cell"></td>
                                <td class="label-cell indent">Alokasi GC Pemel</td>
                                <td class="norek-cell"></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">1,646,090</td>
                                <td class="num">1,646,090</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                            <tr class="row-subtotal">
                                <td colspan="4" class="label-cell" style="font-size:10px; text-align:right; padding-right:8px;">Jumlah Biaya Pemeliharaan Lainnya dan Lain-Lain</td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">4,278</td>
                                <td class="num">37,748,651</td>
                                <td class="num">38,254,321,251</td>
                                <td class="num">37,999,782,675</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>

                            <!-- ======================================================= -->
                            <!-- ====== GRAND TOTAL ====== -->
                            <!-- ======================================================= -->
                            <tr class="row-total">
                                <td colspan="4" class="label-cell" style="text-align:center; font-size:12px; font-weight:800; letter-spacing:0.08em;">
                                    JUMLAH BIAYA TANAMAN
                                </td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num"><span class="dash">-</span></td>
                                <td class="num">8,396,792</td>
                                <td class="num">36,234,214,217</td>
                                <td class="num">608,826,924,313</td>
                                <td class="num">488,529,476,068</td>
                                <td class="num"><span class="dash">-</span></td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tahunSel = document.getElementById('tahunFilter');
            const bulanSel = document.getElementById('bulanFilter');

            const bulanNames = ['','Januari','Februari','Maret','April','Mei','Juni',
                                'Juli','Agustus','September','Oktober','November','Desember'];

            function updateLabels() {
                const yr  = parseInt(tahunSel.value)  || new Date().getFullYear();
                const bln = parseInt(bulanSel.value)   || 0;

                document.getElementById('tblYearLabel').textContent  = yr;
                document.getElementById('tblBulanLabel').textContent = bln ? bulanNames[bln] : '-';
            }

            // Init on page load
            updateLabels();

            // Update on change
            tahunSel.addEventListener('change', updateLabels);
            bulanSel.addEventListener('change', updateLabels);

            // Filter form submit
            document.getElementById('filterForm').addEventListener('submit', function (e) {
                e.preventDefault();
                updateLabels();
            });

            // Reset
            document.getElementById('btnReset').addEventListener('click', function () {
                setTimeout(function () {
                    tahunSel.value = '2025';
                    bulanSel.value = '';
                    updateLabels();
                }, 50);
            });
        });
    </script>
@endsection

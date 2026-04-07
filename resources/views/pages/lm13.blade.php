@extends('layouts.app')

<<<<<<< HEAD
@section('content')
<style>
    .lm13-container {
        padding: 0;
        margin: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #1a2c5c 100%);
        overflow-y: auto;
    }

    .gradient-header {
        background: linear-gradient(to right, #1e40af 0%, #2563eb 100%);
        color: white;
        padding: 20px 0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .header-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .header-title {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .content-section {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    .filter-card {
        background: rgba(30, 64, 175, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
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

    .form-select, .form-input {
        width: 100%;
        padding: 10px 12px;
        background-color: rgba(15, 23, 42, 0.5);
        border: 1px solid rgba(100, 116, 139, 0.5);
        border-radius: 8px;
        color: white;
        font-size: 13px;
        transition: all 0.3s ease;
    }

    .form-select:hover, .form-input:hover {
        border-color: rgba(148, 163, 184, 0.7);
        background-color: rgba(15, 23, 42, 0.7);
    }

    .form-select:focus, .form-input:focus {
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
        border-color: rgba(148, 163, 184, 0.7);
    }

    .table-card {
        background: rgba(30, 64, 175, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        overflow: hidden;
        backdrop-filter: blur(10px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    }

    .table-header {
        background: linear-gradient(135deg, rgba(20, 40, 130, 0.6) 0%, rgba(30, 64, 175, 0.6) 100%);
        padding: 16px 20px;
        border-bottom: 2px solid rgba(96, 165, 250, 0.3);
    }

    .table-title {
        color: white;
        font-size: 16px;
        font-weight: 600;
        display: flex;
        align-items: center;
    }

    .table-title i {
        margin-right: 8px;
        color: #60a5fa;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        color: white;
    }

    .data-table thead tr {
        background: rgba(20, 50, 130, 0.4);
        border-bottom: 1px solid rgba(96, 165, 250, 0.3);
    }

    .data-table th {
        padding: 14px 16px;
        text-align: left;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #a5d6ff;
    }

    .data-table tbody tr {
        border-bottom: 1px solid rgba(100, 116, 139, 0.2);
        transition: background-color 0.2s ease;
    }

    .data-table tbody tr:hover {
        background-color: rgba(59, 130, 246, 0.1);
    }

    .data-table td {
        padding: 14px 16px;
        font-size: 13px;
        color: #e2e8f0;
    }

    .badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-success {
        background: rgba(34, 197, 94, 0.2);
        color: #86efac;
    }

    .badge-warning {
        background: rgba(234, 179, 8, 0.2);
        color: #fde047;
    }

    .badge-info {
        background: rgba(59, 130, 246, 0.2);
        color: #93c5fd;
    }

    .text-number {
        text-align: right;
        font-family: 'Courier New', monospace;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        padding: 20px;
        background: rgba(15, 23, 42, 0.3);
        border-top: 1px solid rgba(100, 116, 139, 0.2);
    }

    .pagination-btn {
        padding: 6px 12px;
        background: rgba(59, 130, 246, 0.2);
        color: #93c5fd;
        border: 1px solid rgba(59, 130, 246, 0.4);
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
        transition: all 0.2s ease;
    }

    .pagination-btn:hover {
        background: rgba(59, 130, 246, 0.3);
        border-color: #60a5fa;
    }

    .pagination-btn.active {
        background: rgba(59, 130, 246, 0.5);
        border-color: #60a5fa;
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 48px;
        opacity: 0.5;
        margin-bottom: 16px;
    }

    .summary-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .stat-card {
        background: linear-gradient(135deg, rgba(30, 64, 175, 0.3), rgba(59, 130, 246, 0.1));
        border: 1px solid rgba(96, 165, 250, 0.3);
        border-radius: 10px;
        padding: 16px;
        text-align: center;
        backdrop-filter: blur(10px);
    }

    .stat-label {
        color: #cbd5e1;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 8px;
        letter-spacing: 0.5px;
    }

    .stat-value {
        color: #60a5fa;
        font-size: 24px;
        font-weight: bold;
    }
</style>

<div class="lm13-container main-content">
    <!-- Header -->
    <div class="gradient-header">
        <div class="header-content">
            <div class="header-title">
                <i class="fas fa-chart-bar" style="margin-right: 12px;"></i> LM 13 - Biaya Produksi
            </div>
            <p style="color: rgba(255, 255, 255, 0.8); font-size: 14px; margin: 0;">
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
            <form id="filterForm" class="filter-form">
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
                    <button type="reset" class="btn-reset">
                        <i class="fas fa-redo"></i> Reset
                    </button>
                    <button type="submit" class="btn-filter">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>


        <!-- Table Section -->
        <div class="table-card">
            <div class="table-header">
                <div class="table-title">
                    <i class="fas fa-table"></i> Data Biaya Produksi
                </div>
            </div>

            <div class="table-wrapper">
                <table class="data-table" id="dataTable">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 12%;">Regional</th>
                            <th style="width: 15%;">Nama Kebun</th>
                            <th style="width: 12%;">Komoditas</th>
                            <th style="width: 12%;">Periode</th>
                            <th style="width: 15%; text-align: right;">Biaya Produksi</th>
                            <th style="width: 12%; text-align: right;">Output (Kg)</th>
                            <th style="width: 12%; text-align: right;">Biaya/Unit</th>
                            <th style="width: 10%;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><strong>Regional 1</strong></td>
                            <td>Kebun Ciater</td>
                            <td>Karet</td>
                            <td>Jan 2024</td>
                            <td class="text-number"><strong>Rp 150,000,000</strong></td>
                            <td class="text-number">550</td>
                            <td class="text-number">Rp 272,727</td>
                            <td><span class="badge badge-success">Aktif</span></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><strong>Regional 1</strong></td>
                            <td>Kebun Cikumpay</td>
                            <td>Karet</td>
                            <td>Jan 2024</td>
                            <td class="text-number"><strong>Rp 180,000,000</strong></td>
                            <td class="text-number">620</td>
                            <td class="text-number">Rp 290,323</td>
                            <td><span class="badge badge-success">Aktif</span></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><strong>Regional 2</strong></td>
                            <td>Kebun Cisaruni</td>
                            <td>Karet</td>
                            <td>Jan 2024</td>
                            <td class="text-number"><strong>Rp 165,000,000</strong></td>
                            <td class="text-number">580</td>
                            <td class="text-number">Rp 284,483</td>
                            <td><span class="badge badge-success">Aktif</span></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><strong>Regional 2</strong></td>
                            <td>Kebun Dayeuhmanggung</td>
                            <td>Karet</td>
                            <td>Jan 2024</td>
                            <td class="text-number"><strong>Rp 170,000,000</strong></td>
                            <td class="text-number">590</td>
                            <td class="text-number">Rp 288,136</td>
                            <td><span class="badge badge-success">Aktif</span></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td><strong>Regional 3</strong></td>
                            <td>Kebun Getas</td>
                            <td>Karet</td>
                            <td>Jan 2024</td>
                            <td class="text-number"><strong>Rp 145,000,000</strong></td>
                            <td class="text-number">510</td>
                            <td class="text-number">Rp 284,314</td>
                            <td><span class="badge badge-warning">Perpanjangan</span></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td><strong>Regional 3</strong></td>
                            <td>Kebun Jalupang</td>
                            <td>Karet</td>
                            <td>Jan 2024</td>
                            <td class="text-number"><strong>Rp 175,000,000</strong></td>
                            <td class="text-number">605</td>
                            <td class="text-number">Rp 289,256</td>
                            <td><span class="badge badge-success">Aktif</span></td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td><strong>Regional 4</strong></td>
                            <td>Kebun Jolotigo</td>
                            <td>Karet</td>
                            <td>Jan 2024</td>
                            <td class="text-number"><strong>Rp 158,000,000</strong></td>
                            <td class="text-number">545</td>
                            <td class="text-number">Rp 289,908</td>
                            <td><span class="badge badge-success">Aktif</span></td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td><strong>Regional 4</strong></td>
                            <td>Kebun Kaligua</td>
                            <td>Karet</td>
                            <td>Jan 2024</td>
                            <td class="text-number"><strong>Rp 162,000,000</strong></td>
                            <td class="text-number">560</td>
                            <td class="text-number">Rp 289,286</td>
                            <td><span class="badge badge-success">Aktif</span></td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td><strong>Regional 5</strong></td>
                            <td>Kebun Kertowono</td>
                            <td>Karet</td>
                            <td>Jan 2024</td>
                            <td class="text-number"><strong>Rp 172,000,000</strong></td>
                            <td class="text-number">595</td>
                            <td class="text-number">Rp 289,076</td>
                            <td><span class="badge badge-info">Verifikasi</span></td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td><strong>Regional 5</strong></td>
                            <td>Kebun Lampung</td>
                            <td>Karet</td>
                            <td>Jan 2024</td>
                            <td class="text-number"><strong>Rp 168,000,000</strong></td>
                            <td class="text-number">580</td>
                            <td class="text-number">Rp 289,655</td>
                            <td><span class="badge badge-success">Aktif</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <button class="pagination-btn"><i class="fas fa-chevron-left"></i> Prev</button>
                <button class="pagination-btn active">1</button>
                <button class="pagination-btn">2</button>
                <button class="pagination-btn">3</button>
                <button class="pagination-btn">4</button>
                <button class="pagination-btn">5</button>
                <button class="pagination-btn"><i class="fas fa-chevron-right"></i> Next</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form submission handler
        const filterForm = document.getElementById('filterForm');

        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const komoditas = document.getElementById('komoditasFilter').value;
            const regional = document.getElementById('regionalFilter').value;
            const tahun = document.getElementById('tahunFilter').value;
            const bulan = document.getElementById('bulanFilter').value;

            // Log filter values (in a real application, this would send to server)
            console.log('Filter applied:', {
                komoditas: komoditas || 'All',
                regional: regional || 'All',
                tahun: tahun || 'All',
                bulan: bulan || 'All'
            });

            // Simulate filtering (in a real application, you would make an AJAX request)
            alert(`Filter diterapkan:\nKomoditas: ${komoditas || 'Semua'}\nRegional: ${regional || 'Semua'}\nTahun: ${tahun || 'Semua'}\nBulan: ${bulan || 'Semua'}`);
        });

        // Reset button handler
        filterForm.addEventListener('reset', function() {
            console.log('Form reset');
            // In a real application, you might want to reload all data
        });

        // Pagination button handlers
        document.querySelectorAll('.pagination-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                if (this.classList.contains('active')) return;

                document.querySelectorAll('.pagination-btn').forEach(b => {
                    b.classList.remove('active');
                });

                if (!this.textContent.includes('Prev') && !this.textContent.includes('Next')) {
                    this.classList.add('active');
                }

                console.log('Page navigated to:', this.textContent);
            });
        });
    });
</script>

@endsection
=======
@section('styles')
    <style>
        /* ===== SCROLL FIX — override Tailwind h-screen di body ===== */
        html,
        body {
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
            background: #15803d;
            color: #dcfce7;
            font-size: 11.5px;
            border-bottom: 2px solid #166534;

            text-align: left;
            white-space: normal;
            min-width: 180px;
        }

        .report-table thead th.col-norek {
            background: #15803d;
            color: #dcfce7;
            font-size: 11.5px;
            border-bottom: 2px solid #166534;

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
        <div class="lm13-container main-content">< !-- Page Header — sama seperti gudang_utilisasi --><header class="lm-page-header"><div class="lm-header-logo"><img src="{{ asset('danantara.png') }}" alt="Danantara"></div><div class="lm-header-center"><svg style="width:28px;height:28px;color:#22c55e;flex-shrink:0;" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zm-7 14H7v-2h5v2zm5-4H7v-2h10v2zm0-4H7V7h10v2z" /></svg><h1>LM 13 &mdash;
        Biaya Produksi</h1></div><div class="lm-header-right"><img src="{{ asset('ptpn1.png') }}" alt="PTPN 1"></div></header>< !-- Main Content --><div class="content-section">< !-- Filter Section --><div class="filter-card"><div class="filter-title"><i class="fas fa-sliders-h"></i>Filter Data </div><form id="filterForm"><div class="filter-grid"><div class="form-group"><label class="form-label">Komoditas</label><select class="form-select" id="komoditasFilter"><option value="">-- Pilih Komoditas --</option><option value="karet">Karet</option><option value="teh">Teh</option><option value="kopi">Kopi</option><option value="tembakau">Tembakau</option></select></div><div class="form-group"><label class="form-label">Regional</label><select class="form-select" id="regionalFilter"><option value="">-- Pilih Regional --</option><option value="regional-1">Regional 1</option><option value="regional-2">Regional 2</option><option value="regional-3">Regional 3</option><option value="regional-4">Regional 4</option><option value="regional-5">Regional 5</option><option value="regional-6">Regional 6</option><option value="regional-7">Regional 7</option><option value="regional-8">Regional 8</option></select></div><div class="form-group"><label class="form-label">Tahun</label><select class="form-select" id="tahunFilter"><option value="">-- Pilih Tahun --</option><option value="2024" selected>2024</option><option value="2023">2023</option><option value="2022">2022</option><option value="2021">2021</option></select></div><div class="form-group"><label class="form-label">Bulan</label><select class="form-select" id="bulanFilter"><option value="">-- Pilih Bulan --</option><option value="01">Januari</option><option value="02">Februari</option><option value="03">Maret</option><option value="04">April</option><option value="05">Mei</option><option value="06">Juni</option><option value="07">Juli</option><option value="08">Agustus</option><option value="09">September</option><option value="10">Oktober</option><option value="11">November</option><option value="12">Desember</option></select></div></div><div class="button-group"><button type="reset" class="btn-reset" id="btnReset"><i class="fas fa-redo"></i>Reset </button><button type="submit" class="btn-filter"><i class="fas fa-search"></i>Cari </button></div></form></div>< !--======PRODUCTION REPORT TABLE======--><div class="table-card"><div class="table-header"><div class="table-title"><i class="fas fa-file-invoice-dollar"></i>Laporan Biaya Produksi — LM 13 </div><span style="color:#dcfce7; font-size:12px;">s/d Bulan ini &mdash;
        Tahun <strong id="tblYearLabel">2024</strong></span></div><div class="table-wrapper"><table class="report-table" id="reportTable"><thead>< !-- Row 1: top group labels --><tr><th rowspan="3" class="col-norek" style="vertical-align:middle; width:70px;">Nomor<br>Rekening</th><th rowspan="3" class="col-label"
        style="text-align:left; vertical-align:middle; min-width:270px;">Uraian</th><th colspan="3" class="col-group">Jumlah Kilogram &mdash;
        s/d Bulan ini</th><th colspan="3" class="col-group">Kilogram per Hektar &mdash;
        s/d Bulan ini</th></tr>< !-- Row 2: sub-year labels for first block --><tr><th class="col-group" style="font-size:10px; padding:5px 8px;">Real <span class="dyn-year-prev">2023</span></th><th class="col-group" style="font-size:10px; padding:5px 8px;">Real <span class="dyn-year">2024</span></th><th class="col-group" style="font-size:10px; padding:5px 8px;">RKAP <span class="dyn-year">2024</span></th><th class="col-group" style="font-size:10px; padding:5px 8px;">Real <span class="dyn-year-prev">2023</span></th><th class="col-group" style="font-size:10px; padding:5px 8px;">Real <span class="dyn-year">2024</span></th><th class="col-group" style="font-size:10px; padding:5px 8px;">RKAP <span class="dyn-year">2024</span></th></tr></thead><tbody>< !--======PRODUKSI======--><tr><td class="norek-cell"></td><td class="label-cell indent">Produksi Kebun Sendiri yang Diolah (Kering)</td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td></tr><tr><td class="norek-cell"></td><td class="label-cell indent">Di Pabrik Sendiri</td><td class="num"><span class="dash">-</span></td><td class="num">6,
        163,
        857</td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num">324</td><td class="num"><span class="dash">-</span></td></tr><tr><td class="norek-cell"></td><td class="label-cell indent">Kebun Sendiri</td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td></tr><tr><td class="norek-cell"></td><td class="label-cell indent">Pihak Ke III</td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td></tr><tr class="row-subtotal"><td class="norek-cell"></td><td class="label-cell" style="text-align:right; padding-right:10px;">Jumlah Produksi Diolah </td><td class="num"><span class="dash">-</span></td><td class="num">6,
        163,
        857</td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td></tr></tbody></table></div><div class="table-wrapper"><table class="report-table" id="reportTable"><thead>< !-- Row 1: top group labels --><tr><th rowspan="3" class="col-norek" style="vertical-align:middle; width:70px;">Nomor<br>Rekening</th><th rowspan="3" class="col-label"
        style="text-align:left; vertical-align:middle; min-width:270px;">Uraian</th><th colspan="3" class="col-group">Jumlah Kilogram &mdash;
        s/d Bulan ini</th><th colspan="3" class="col-group">Kilogram per Hektar &mdash;

        s/d Bulan ini</th></tr>< !-- Row 2: sub-year labels for first block --><tr><th class="col-group" style="font-size:10px; padding:5px 8px;">Real <span class="dyn-year-prev">2023</span></th><th class="col-group" style="font-size:10px; padding:5px 8px;">Real <span class="dyn-year">2024</span></th><th class="col-group" style="font-size:10px; padding:5px 8px;">RKAP <span class="dyn-year">2024</span></th><th class="col-group" style="font-size:10px; padding:5px 8px;">Real <span class="dyn-year-prev">2023</span></th><th class="col-group" style="font-size:10px; padding:5px 8px;">Real <span class="dyn-year">2024</span></th><th class="col-group" style="font-size:10px; padding:5px 8px;">RKAP <span class="dyn-year">2024</span></th></tr></thead><tbody>< !--======BEBAN PRODUKSI — section header======-->< !--======BEBAN TANAMAN======--><tr><td class="norek-cell">5.1.1</td><td class="label-cell indent">Gaji dan Tunjangan Kary. Pimpinan</td><td class="num"><span class="dash">-</span></td><td class="num">7,
        843,
        792,
        621</td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num">1,
        273</td><td class="num"><span class="dash">-</span></td></tr><tr><td class="norek-cell">5.1.2</td><td class="label-cell indent">Gaji dan Tunjangan Kary. Pelaksana</td><td class="num"><span class="dash">-</span></td><td class="num">6,
        973,
        083,
        197</td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num">1,
        131</td><td class="num"><span class="dash">-</span></td></tr><tr><td class="norek-cell">5.1.3</td><td class="label-cell indent">Pemeliharaan Tan. Menghasilkan</td><td class="num"><span class="dash">-</span></td><td class="num">5,
        022,
        156,
        709</td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num">815</td><td class="num"><span class="dash">-</span></td></tr><tr><td class="norek-cell">5.1.4</td><td class="label-cell indent">Pemupukan</td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td></tr><tr><td class="norek-cell">5.1.5</td><td class="label-cell indent">Panen</td><td class="num"><span class="dash">-</span></td><td class="num">96,
        434,
        855,
        359</td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num">15,
        645</td><td class="num"><span class="dash">-</span></td></tr><tr><td class="norek-cell">5.1.6</td><td class="label-cell indent">Pengangkutan ke Pabrik</td><td class="num"><span class="dash">-</span></td><td class="num">9,
        188,
        052,
        848</td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num">1,
        491</td><td class="num"><span class="dash">-</span></td></tr><tr><td class="norek-cell">5.1.7</td><td class="label-cell indent">Beban Overhead</td><td class="num"><span class="dash">-</span></td><td class="num">20,
        655,
        041,
        594</td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num">3,
        351</td><td class="num"><span class="dash">-</span></td></tr><tr class="row-subtotal"><td class="norek-cell"></td><td class="label-cell" style="text-align:right; padding-right:10px;">Jumlah Beban Tanaman : </td><td class="num"><span class="dash">-</span></td><td class="num">146,
        116,
        982,
        328</td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num">23,
        705</td><td class="num"><span class="dash">-</span></td></tr>< !--======BEBAN PENGOLAHAN======--><tr><td class="norek-cell">5.2.1</td><td class="label-cell indent">Beban Overhead Kebun</td><td class="num"><span class="dash">-</span></td><td class="num">91,
        771,
        890</td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num">15</td><td class="num"><span class="dash">-</span></td></tr><tr><td class="norek-cell">5.2.2</td><td class="label-cell indent">Beban Langsung Pengolahan</td><td class="num"><span class="dash">-</span></td><td class="num">18,
        942,
        119,
        584</td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num">3,
        073</td><td class="num"><span class="dash">-</span></td></tr><tr class="row-subtotal"><td class="norek-cell"></td><td class="label-cell" style="text-align:right; padding-right:10px;">Jumlah Beban Pengolahan :</td><td class="num"><span class="dash">-</span></td><td class="num">19,
        033,
        891,
        474</td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num">3,
        088</td><td class="num"><span class="dash">-</span></td></tr>< !--======EXCL. PENYUSUTAN======--><tr class="row-subtotal"><td class="norek-cell"></td><td class="label-cell" style="text-align:right; padding-right:10px;">Jumlah Beban Produksi. Excl. Penyst :</td><td class="num"><span class="dash">-</span></td><td class="num">165,
        150,
        873,
        802</td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num">26,
        793</td><td class="num"><span class="dash">-</span></td></tr>< !--======BEBAN PENYUSUTAN======--><tr><td class="norek-cell">5.3.1</td><td class="label-cell indent">Beban Penyst. Overhead Kebun</td><td class="num"><span class="dash">-</span></td><td class="num">23,
        080,
        584,
        130</td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num">3,
        745</td><td class="num"><span class="dash">-</span></td></tr><tr><td class="norek-cell">5.3.2</td><td class="label-cell indent">Beban Penyst. Pengolahan</td><td class="num"><span class="dash">-</span></td><td class="num">1,
        257,
        131,
        309</td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num">204</td><td class="num"><span class="dash">-</span></td></tr><tr class="row-subtotal"><td class="norek-cell"></td><td class="label-cell" style="text-align:right; padding-right:10px;">Jumlah Beban Produksi Kebun Inti :</td><td class="num"><span class="dash">-</span></td><td class="num">189,
        488,
        589,
        241</td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num">30,
        538</td><td class="num"><span class="dash">-</span></td></tr><tr class="row-subtotal"><td class="norek-cell"></td><td class="label-cell" style="text-align:right; padding-right:10px;">Jumlah Beban Produksi Excl.By Admin :</td><td class="num"><span class="dash">-</span></td><td class="num">168,
        833,
        547,
        647</td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num">26,
        793</td><td class="num"><span class="dash">-</span></td></tr>< !--======BEBAN PIHAK KE III======--><tr><td class="norek-cell">5.4</td><td class="label-cell indent">Beban Pihak Ke III</td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td></tr>< !--======JUMLAH TOTAL======--><tr class="row-total"><td class="norek-cell"></td><td class="label-cell" style="text-align:center; font-size:13px; padding-left:14px;">Jumlah Beban Produksi</td><td class="num"><span class="dash">-</span></td><td class="num">189,
        488,
        589,
        241</td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num">30,
        742</td><td class="num"><span class="dash">-</span></td></tr>< !--======INFO PER HEKTAR======--><tr class="row-info"><td class="norek-cell"></td><td class="label-cell indent">Biaya Tanaman per Ha</td><td class="num"><span class="dash">-</span></td><td class="num">7,
        687,
        163.16</td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td></tr><tr class="row-info"><td class="norek-cell"></td><td class="label-cell indent">Biaya Produksi excl. Penyust. per Ha</td><td class="num"><span class="dash">-</span></td><td class="num">8,
        688,
        529.51</td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td></tr><tr class="row-info"><td class="norek-cell"></td><td class="label-cell indent">Biaya Produksi excl. By Admi. per Ha</td><td class="num"><span class="dash">-</span></td><td class="num">8,
        882,
        273.69</td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td><td class="num"><span class="dash">-</span></td></tr></tbody></table></div></div>< !--======END TABLE======--></div></div><script>document.addEventListener('DOMContentLoaded', function () {
                const tahunSel=document.getElementById('tahunFilter');

                function updateYearLabels() {
                    const yr=parseInt(tahunSel.value) || new Date().getFullYear();
                    const yrP=yr - 1;

                    document.querySelectorAll('.dyn-year').forEach(el=> el.textContent=yr);
                    document.querySelectorAll('.dyn-year-prev').forEach(el=> el.textContent=yrP);
                    document.getElementById('tblYearLabel').textContent=yr;
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
                                tahunSel.value='2024';
                                updateYearLabels();
                            }

                            , 50);
                    });
            });
    </script>@endsection
>>>>>>> main

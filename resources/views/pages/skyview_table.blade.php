@extends('layouts.app')

@section('styles')
<style>
    html, body {
        height: auto !important;
        min-height: 100vh;
        overflow-y: auto !important;
    }

    .skyview-container.main-content {
        padding: 0 !important;
        margin-left: 0 !important;
    }

    .skyview-container {
        padding: 0;
        margin: 0;
        width: 100%;
        min-height: 100vh;
        background: #f0f4f8;
        overflow-x: hidden;
        box-sizing: border-box;
        font-family: 'Inter', 'Segoe UI', sans-serif;
    }

    /* ===== PAGE HEADER ===== */
    .sv-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 50px;
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
        min-height: 56px;
    }
    .sv-header-logo { width: 130px; height: 44px; display: flex; align-items: center; }
    .sv-header-logo img { width: 100%; height: 100%; object-fit: contain; }
    .sv-header-center {
        position: absolute; left: 50%; transform: translateX(-50%);
        display: flex; align-items: center; gap: 8px;
    }
    .sv-header-center h1 { font-size: 1.35rem; font-weight: 800; color: #1e3a5f; margin: 0; }
    .sv-header-right img { height: 44px; width: auto; object-fit: contain; }

    /* ===== CONTENT SECTION ===== */
    .sv-content { max-width: 100%; margin: 0; padding: 24px 50px 40px; }

    /* ===== ACTION BAR ===== */
    .sv-action-bar {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 20px;
    }
    .sv-section-title {
        font-size: 1rem; font-weight: 700; color: #1e3a5f;
        display: flex; align-items: center; gap: 8px;
    }
    .btn-tambah {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 22px;
        background: linear-gradient(135deg, #14532d 0%, #166534 100%);
        color: #fff; border: none; border-radius: 8px;
        font-size: 13px; font-weight: 700;
        cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 8px rgba(37,99,235,0.25);
    }
    .btn-tambah:hover { opacity: 0.9; transform: translateY(-1px); }

    /* ===== TABLE CARD ===== */
    .sv-table-card {
        background: #fff; border-radius: 12px; overflow: hidden;
        box-shadow: 0 2px 12px rgba(30,58,95,0.10);
        border: 1px solid #dbeafe;
    }
    .sv-table-header {
        background: linear-gradient(135deg, #14532d 0%, #166534 100%);
        padding: 14px 22px; display: flex; align-items: center; justify-content: space-between;
    }
    .sv-table-title {
        color: #fff; font-size: 14px; font-weight: 700;
        display: flex; align-items: center; gap: 8px;
    }
    .sv-table-count {
        background: rgba(255,255,255,0.15); color: #fff;
        padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;
    }
    .sv-table-wrapper { overflow-x: auto; width: 100%; }
    .sv-table {
        width: 100%; border-collapse: collapse;
        font-size: 13px; color: #1e293b;
    }
    .sv-table thead th {
        background: #f1f5f9; color: #1e3a5f;
        font-weight: 700; font-size: 12px; text-transform: uppercase;
        letter-spacing: 0.04em; padding: 11px 16px;
        border-bottom: 2px solid #dbeafe; white-space: nowrap; text-align: center;
    }
    .sv-table thead th.th-left { text-align: left; }
    .sv-table tbody td {
        padding: 10px 16px; border-bottom: 1px solid #f1f5f9;
        vertical-align: middle; text-align: center;
    }
    .sv-table tbody td.td-left { text-align: left; }
    .sv-table tbody tr:hover td { background: #eff6ff; }
    .sv-table tbody tr:last-child td { border-bottom: none; }
    .sv-no-num { font-weight: 700; color: #94a3b8; }

    /* ===== LINK BADGE ===== */
    .yt-link-badge {
        display: inline-flex; align-items: center; gap: 5px;
        background: #fee2e2; color: #dc2626;
        border-radius: 6px; padding: 4px 10px; font-size: 12px; font-weight: 600;
        text-decoration: none; transition: background 0.2s;
        max-width: 240px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    .yt-link-badge:hover { background: #fecaca; }

    /* ===== ACTION BUTTONS ===== */
    .action-btns { display: flex; gap: 6px; justify-content: center; }
    .btn-action {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 5px 12px; border: none; border-radius: 6px;
        font-size: 11.5px; font-weight: 600; cursor: pointer; transition: all 0.18s;
    }
    .btn-view  { background: #dbeafe; color: #1d4ed8; }
    .btn-view:hover  { background: #bfdbfe; }
    .btn-edit  { background: #dcfce7; color: #16a34a; }
    .btn-edit:hover  { background: #bbf7d0; }
    .btn-del   { background: #fee2e2; color: #dc2626; }
    .btn-del:hover   { background: #fecaca; }

    /* ===== VIDEO ACCORDION / TRAY ===== */
    .video-tray {
        display: none;
        background: #0f172a;
        border-bottom: 1px solid #16a34a;
    }
    .video-tray.open { display: table-row; }
    .video-tray td {
        padding: 0; border-bottom: 3px solid #16a34a !important;
    }
    .video-tray-inner {
        padding: 18px 24px;
        display: flex; flex-direction: column; align-items: center; gap: 12px;
    }
    .video-embed-wrap {
        position: relative; width: 80%;
        border-radius: 12px; overflow: hidden;
        box-shadow: 0 4px 28px rgba(37, 235, 113, 0.3);
        cursor: pointer;
        aspect-ratio: 16/9;
    }
    .video-embed-wrap img.thumb {
        width: 100%; display: block; border-radius: 12px;
    }
    .video-play-overlay {
        position: absolute; inset: 0;
        display: flex; align-items: center; justify-content: center;
        background: rgba(0,0,0,0.1); transition: background 0.2s;
    }
    .video-embed-wrap:hover .video-play-overlay { background: rgba(0,0,0,0.05); }
    .play-icon {
        width: 72px; height: 72px; background: rgba(220,38,38,0.92);
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 20px rgba(220,38,38,0.55);
        transition: transform 0.2s;
    }
    .video-embed-wrap:hover .play-icon { transform: scale(1.12); }
    .play-icon svg { color: #fff; }

    .video-tray-meta {
        display: flex; align-items: center; gap: 24px;
        color: #94a3b8; font-size: 13.5px;
    }
    .video-tray-meta span { display: flex; align-items: center; gap: 5px; }
    .video-tray-meta strong { color: #e2e8f0; font-weight: 700; }
    .video-tray-footer {
        display: flex; align-items: center; justify-content: space-between;
        gap: 16px; flex-wrap: wrap; width: 80%;
    }
    .video-tray-footer .video-tray-meta {
        flex: 1;
    }
    .btn-open-skyview {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 22px;
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #fff; border: none; border-radius: 8px;
        font-size: 13px; font-weight: 700; cursor: pointer;
        text-decoration: none; transition: all 0.2s;
        box-shadow: 0 2px 10px rgba(220,38,38,0.35);
    }
    .btn-open-skyview:hover { opacity: 0.9; transform: translateY(-1px); }

    /* ===== EMPTY STATE ===== */
    .sv-empty {
        text-align: center; padding: 60px 20px; color: #94a3b8;
    }
    .sv-empty svg { width: 64px; height: 64px; color: #cbd5e1; margin-bottom: 12px; }
    .sv-empty p { font-size: 14px; }

    /* ===== MODAL ===== */
    .modal-backdrop {
        display: none; position: fixed; inset: 0;
        background: rgba(15,23,42,0.6); backdrop-filter: blur(4px);
        z-index: 9998;
    }
    .modal-backdrop.show { display: flex; align-items: center; justify-content: center; }
    .modal-box {
        background: #fff; border-radius: 14px;
        width: 100%; max-width: 500px; padding: 30px;
        box-shadow: 0 8px 40px rgba(30,58,95,0.25);
        z-index: 9999; animation: slideIn 0.25s ease;
    }
    @keyframes slideIn { from { transform: translateY(-30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .modal-title {
        font-size: 1.1rem; font-weight: 800; color: #1e3a5f;
        margin-bottom: 20px; display: flex; align-items: center; gap: 8px;
    }
    .form-group { margin-bottom: 16px; }
    .form-label { display: block; font-size: 12px; font-weight: 700; color: #374151; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.04em; }
    .form-input {
        width: 100%; padding: 9px 12px;
        border: 1.5px solid #d1d5db; border-radius: 8px;
        font-size: 13px; color: #1f2937;
        transition: border-color 0.2s; box-sizing: border-box;
    }
    .form-input:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.12); }
    .form-error { color: #dc2626; font-size: 11px; margin-top: 4px; display: none; }
    .modal-actions { display: flex; gap: 10px; justify-content: flex-end; margin-top: 24px; }
    .btn-cancel { padding: 9px 20px; background: #f3f4f6; color: #374151; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 13px; }
    .btn-cancel:hover { background: #e5e7eb; }
    .btn-save {
        padding: 9px 22px;
        background: linear-gradient(135deg, #1e3a5f, #2563eb);
        color: #fff; border: none; border-radius: 8px;
        font-size: 13px; font-weight: 700; cursor: pointer;
        box-shadow: 0 2px 8px rgba(37,99,235,0.25); transition: opacity 0.2s;
    }
    .btn-save:hover { opacity: 0.9; }

    /* ===== TOAST ===== */
    .toast-wrap { position: fixed; top: 20px; right: 24px; z-index: 99999; display: flex; flex-direction: column; gap: 8px; }
    .toast {
        min-width: 260px; padding: 12px 18px; border-radius: 10px;
        font-size: 13px; font-weight: 600; color: #fff;
        display: flex; align-items: center; gap: 8px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.18);
        animation: toastIn 0.3s ease;
    }
    .toast.success { background: #16a34a; }
    .toast.error   { background: #dc2626; }
    @keyframes toastIn { from { transform: translateX(110%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

    /* ===== CONFIRM DIALOG ===== */
    .confirm-box { max-width: 380px; text-align: center; }
    .confirm-icon { font-size: 2.5rem; margin-bottom: 10px; }
    .confirm-box .modal-title { justify-content: center; }
    .confirm-box p { color: #64748b; font-size: 13.5px; margin-bottom: 20px; }
    .btn-danger { padding: 9px 22px; background: #dc2626; color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; }
    .btn-danger:hover { background: #b91c1c; }

    /* ===== SEARCH CARD ===== */
    .sv-search-card {
        background: #fff; border-radius: 10px;
        border: 1px solid #dbeafe; border-left: 4px solid #166534;
        padding: 16px 20px; margin-bottom: 16px;
        box-shadow: 0 1px 6px rgba(37,99,235,0.08);
    }
    .sv-search-form { display: flex; align-items: flex-end; gap: 10px; flex-wrap: wrap; }
    .sv-search-group { display: flex; flex-direction: column; gap: 4px; flex: 1; min-width: 160px; }
    .sv-search-group label { font-size: 11px; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: 0.04em; }
    .sv-search-input {
        padding: 8px 12px; border: 1.5px solid #d1d5db; border-radius: 7px;
        font-size: 13px; color: #1f2937; transition: border-color 0.2s;
    }
    .sv-search-input:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }
    .btn-search {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 18px; background: #166534; color: #fff;
        border: none; border-radius: 7px; font-size: 13px; font-weight: 700;
        cursor: pointer; transition: opacity 0.2s; white-space: nowrap;
    }
    .btn-search:hover { opacity: 0.88; }
    .btn-reset-search {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 16px; background: #f1f5f9; color: #475569;
        border: 1.5px solid #cbd5e1; border-radius: 7px; font-size: 13px; font-weight: 600;
        cursor: pointer; transition: background 0.2s; text-decoration: none; white-space: nowrap;
    }
    .btn-reset-search:hover { background: #e2e8f0; }
    .sv-search-info { font-size: 12px; color: #64748b; margin-top: 8px; display: flex; align-items: center; gap: 5px; }

    /* ===== PAGINATION ===== */
    .sv-pagination {
        display: flex; align-items: center; justify-content: space-between;
        padding: 14px 20px; border-top: 1px solid #f1f5f9; flex-wrap: wrap; gap: 10px;
    }
    .sv-pag-info { font-size: 12px; color: #64748b; }
    .sv-pag-links { display: flex; gap: 4px; align-items: center; }
    .sv-pag-links a, .sv-pag-links span {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 32px; height: 32px; padding: 0 8px;
        border-radius: 6px; font-size: 13px; font-weight: 600;
        text-decoration: none; transition: all 0.15s;
    }
    .sv-pag-links a { color: #1e3a5f; background: #f1f5f9; border: 1px solid #e2e8f0; }
    .sv-pag-links a:hover { background: #dbeafe; border-color: #93c5fd; color: #1d4ed8; }
    .sv-pag-links span.active { background: linear-gradient(135deg,#1e3a5f,#2563eb); color:#fff; border:1px solid #1e3a5f; }
    .sv-pag-links span.disabled { color: #cbd5e1; background: #f8fafc; border: 1px solid #f1f5f9; cursor: default; }
</style>
@endsection

@section('content')
<div class="skyview-container main-content">

    {{-- Page Header --}}
    <header class="sv-page-header">
        <div class="sv-header-logo">
            <img src="{{ asset('danantara.png') }}" alt="Danantara">
        </div>
        <div class="sv-header-center">
            <svg style="width:26px;height:26px;color:#2563eb;flex-shrink:0;" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 3a3 3 0 110 6 3 3 0 010-6zm0 14.2a7.2 7.2 0 01-6-3.22c.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08A7.2 7.2 0 0112 19.2z"/>
            </svg>
            <h1>Daftar Data Skyview</h1>
        </div>
        <div class="sv-header-right">
            <img src="{{ asset('ptpn1.png') }}" alt="PTPN 1">
        </div>
    </header>

    {{-- Main Content --}}
    <div class="sv-content">

        {{-- Action Bar --}}
        <div class="sv-action-bar">
            <div class="sv-section-title">
                <svg style="width:18px;height:18px;" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
                </svg>
                Data Skyview
            </div>
            <button class="btn-tambah" id="btn-tambah-data" onclick="openAddModal()">
                <svg viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;">
                    <path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"/>
                </svg>
                Tambah Data
            </button>
        </div>

        {{-- Search Form --}}
        <div class="sv-search-card">
            <form class="sv-search-form" method="GET" action="{{ route('skyview_table') }}" id="search-form">
                <div class="sv-search-group" style="flex:2;min-width:200px;">
                    <label for="search-q">🔍 Cari Kebun / Unit</label>
                    <input class="sv-search-input" type="text" id="search-q" name="q"
                        value="{{ $q }}" placeholder="Ketik nama kebun atau unit..." autocomplete="off">
                </div>
                <div class="sv-search-group">
                    <label for="search-tgl-awal">📅 Dari Tanggal</label>
                    <input class="sv-search-input" type="date" id="search-tgl-awal" name="tgl_awal" value="{{ $tglAwal }}">
                </div>
                <div class="sv-search-group">
                    <label for="search-tgl-akhir">📅 Sampai Tanggal</label>
                    <input class="sv-search-input" type="date" id="search-tgl-akhir" name="tgl_akhir" value="{{ $tglAkhir }}">
                </div>
                <button type="submit" class="btn-search">
                    <svg viewBox="0 0 24 24" fill="currentColor" style="width:14px;height:14px;">
                        <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                    </svg>
                    Cari
                </button>
                @if($q || $tglAwal || $tglAkhir)
                <a href="{{ route('skyview_table') }}" class="btn-reset-search">
                    <svg viewBox="0 0 24 24" fill="currentColor" style="width:13px;height:13px;">
                        <path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
                    </svg>
                    Reset
                </a>
                @endif
            </form>
            @if($q || $tglAwal || $tglAkhir)
            <div class="sv-search-info">
                <svg viewBox="0 0 24 24" fill="currentColor" style="width:13px;height:13px;color:#2563eb;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                Menampilkan <strong>{{ $skyviews->total() }}</strong> hasil
                @if($q) dengan kata kunci "<strong>{{ $q }}</strong>"@endif
                @if($tglAwal || $tglAkhir) periode <strong>{{ $tglAwal ?: '...' }}</strong> s/d <strong>{{ $tglAkhir ?: '...' }}</strong>@endif
            </div>
            @endif
        </div>

        {{-- Table --}}
        <div class="sv-table-card">
            <div class="sv-table-header">
                <div class="sv-table-title">
                    <svg viewBox="0 0 24 24" fill="currentColor" style="width:17px;height:17px;">
                        <path d="M21 3H3a2 2 0 00-2 2v14a2 2 0 002 2h18a2 2 0 002-2V5a2 2 0 00-2-2zm-10 3h8v2h-8V6zm-5-.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM3 18l3.5-4.5 2.5 3 3.5-4.5 4.5 6H3z"/>
                    </svg>
                    Tabel Data Skyview
                </div>
                <span class="sv-table-count" id="row-count">{{ $skyviews->total() }} data</span>
            </div>

            <div class="sv-table-wrapper">
                <table class="sv-table" id="sv-main-table">
                    <thead>
                        <tr>
                            <th style="width:50px;">#</th>
                            <th class="th-left">Kebun / Unit</th>
                            <th style="width:130px;">Tanggal</th>
                            <th>Link</th>
                            <th>Keterangan</th>
                            <th style="width:200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="sv-tbody">
                        @forelse($skyviews as $sv)
                        @php $rowNo = ($skyviews->currentPage() - 1) * $skyviews->perPage() + $loop->iteration; @endphp
                        <tr id="row-{{ $sv->id }}" data-id="{{ $sv->id }}">
                            <td class="sv-no-num">{{ $rowNo }}</td>
                            <td class="td-left">{{ $sv->kebun_unit }}</td>
                            <td>{{ \Carbon\Carbon::parse($sv->tanggal)->isoFormat('D MMM Y') }}</td>
                            <td class="td-left" style="max-width:260px;">
                                <a href="{{ $sv->link_youtube }}" target="_blank"
                                   style="color:#1e3a5f;font-size:12px;word-break:break-all;text-decoration:underline;text-underline-offset:2px;"
                                   title="{{ $sv->link_youtube }}">
                                    {{ $sv->link_youtube }}
                                </a>
                            </td>
                            <td>{{ $sv->keterangan }}</td>
                            <td>
                                <div class="action-btns">
                                    <button class="btn-action btn-view"
                                        onclick="toggleVideoTray({{ $sv->id }}, this)"
                                        title="Lihat Video">
                                        <svg viewBox="0 0 24 24" fill="currentColor" style="width:13px;height:13px;">
                                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                        </svg>
                                        View
                                    </button>
                                    <button class="btn-action btn-edit"
                                        onclick="openEditModal({{ $sv->id }}, this)"
                                        title="Edit">
                                        <svg viewBox="0 0 24 24" fill="currentColor" style="width:13px;height:13px;">
                                            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 000-1.41l-2.34-2.34a1 1 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                        </svg>
                                        Edit
                                    </button>
                                    <button class="btn-action btn-del"
                                        onclick="confirmDelete({{ $sv->id }}, this)"
                                        title="Hapus">
                                        <svg viewBox="0 0 24 24" fill="currentColor" style="width:13px;height:13px;">
                                            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        {{-- Video Tray Row --}}
                        <tr class="video-tray" id="tray-{{ $sv->id }}">
                            <td colspan="6">
                                <div class="video-tray-inner" id="tray-inner-{{ $sv->id }}">
                                    {{-- Filled dynamically --}}
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr id="empty-row">
                            <td colspan="6">
                                <div class="sv-empty">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18 3v2h-2V3H8v2H6V3H4v18h2v-2h2v2h8v-2h2v2h2V3h-2zM8 17H6v-2h2v2zm0-4H6v-2h2v2zm0-4H6V7h2v2zm10 8h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2V7h2v2z"/></svg>
                                    <p>Belum ada data skyview. Klik <strong>Tambah Data</strong> untuk mulai.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($skyviews->hasPages())
        <div class="sv-pagination">
            <div class="sv-pag-info">
                Menampilkan <strong>{{ $skyviews->firstItem() }}–{{ $skyviews->lastItem() }}</strong>
                dari <strong>{{ $skyviews->total() }}</strong> data
                (halaman <strong>{{ $skyviews->currentPage() }}</strong>/{{ $skyviews->lastPage() }})
            </div>
            <div class="sv-pag-links">
                @if($skyviews->onFirstPage())
                    <span class="disabled">‹</span>
                @else
                    <a href="{{ $skyviews->previousPageUrl() }}">‹</a>
                @endif

                @foreach($skyviews->getUrlRange(
                    max(1, $skyviews->currentPage()-2),
                    min($skyviews->lastPage(), $skyviews->currentPage()+2)
                ) as $page => $url)
                    @if($page == $skyviews->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($skyviews->hasMorePages())
                    <a href="{{ $skyviews->nextPageUrl() }}">›</a>
                @else
                    <span class="disabled">›</span>
                @endif
            </div>
        </div>
        @endif

    </div>
</div>

{{-- ===== MODAL TAMBAH / EDIT ===== --}}
<div class="modal-backdrop" id="modal-backdrop" onclick="closeModal(event)">
    <div class="modal-box">
        <div class="modal-title" id="modal-title">
            <svg viewBox="0 0 24 24" fill="currentColor" style="width:22px;height:22px;color:#2563eb;">
                <path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"/>
            </svg>
            <span id="modal-title-text">Tambah Data Skyview</span>
        </div>
        <form id="sv-form" onsubmit="submitForm(event)">
            <input type="hidden" id="form-mode" value="add">
            <input type="hidden" id="form-id" value="">

            <div class="form-group">
                <label class="form-label" for="input-kebun">Kebun / Unit</label>
                <input class="form-input" type="text" id="input-kebun" name="kebun_unit" placeholder="Contoh: Kebun Bangun Bandar" autocomplete="off">
                <div class="form-error" id="err-kebun"></div>
            </div>
            <div class="form-group">
                <label class="form-label" for="input-tanggal">Tanggal</label>
                <input class="form-input" type="date" id="input-tanggal" name="tanggal">
                <div class="form-error" id="err-tanggal"></div>
            </div>
            <div class="form-group">
                <label class="form-label" for="input-link">Link</label>
                <input class="form-input" type="url" id="input-link" name="link_youtube" placeholder="https://www.youtube.com/watch?v=...">
                <div class="form-error" id="err-link"></div>
            </div>
            <div class="form-group">
                <label class="form-label" for="input-keterangan">Keterangan</label>
                <textarea class="form-input" id="input-keterangan" name="keterangan" placeholder="Masukkan keterangan" rows="3"></textarea>
                <div class="form-error" id="err-keterangan"></div>
            </div>  
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-save" id="btn-save">
                    <span id="btn-save-text">Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ===== CONFIRM DELETE DIALOG ===== --}}
<div class="modal-backdrop" id="confirm-backdrop" onclick="closeConfirm(event)">
    <div class="modal-box confirm-box">
        <div class="confirm-icon">🗑️</div>
        <div class="modal-title">Hapus Data?</div>
        <p id="confirm-msg">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="modal-actions" style="justify-content:center;">
            <button class="btn-cancel" onclick="closeConfirm()">Batal</button>
            <button class="btn-danger" id="btn-confirm-del" onclick="executeDelete()">Ya, Hapus</button>
        </div>
    </div>
</div>

{{-- ===== TOAST CONTAINER ===== --}}
<div class="toast-wrap" id="toast-wrap"></div>

@endsection

@section('scripts')
<script>
const ROUTES = {
    store:   "{{ route('skyview.store') }}",
    show:    "{{ url('/skyview-table') }}/",
    update:  "{{ url('/skyview-table') }}/",
    destroy: "{{ url('/skyview-table') }}/",
    skyview: "{{ route('skyview') }}",
};
const CSRF = "{{ csrf_token() }}";

// Data semua skyview (inject dari server — 100% aman dari encoding issues)
@php
    $skyviewMap = [];
    foreach ($skyviews as $sv) {
        $skyviewMap[$sv->id] = [
            'kebun'      => $sv->kebun_unit,
            'tanggal'    => $sv->tanggal ? $sv->tanggal->format('Y-m-d') : '',
            'link'       => $sv->link_youtube,
            'keterangan' => (string) ($sv->keterangan ?? ''),
        ];
    }
@endphp
const SKYVIEW_DATA = {!! json_encode($skyviewMap) !!};

// ─── CSRF EXPIRY HANDLER ─────────────────────────────────────────────────────
function handleCsrfExpiry() {
    showToast('Sesi Anda telah habis. Halaman akan dimuat ulang…', 'error');
    setTimeout(() => location.reload(), 2000);
}

// ─── TOAST ───────────────────────────────────────────────────────────────────
function showToast(msg, type = 'success') {
    const wrap = document.getElementById('toast-wrap');
    const t = document.createElement('div');
    t.className = `toast ${type}`;
    t.innerHTML = (type === 'success'
        ? `<svg viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>`
        : `<svg viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>`)
        + msg;
    wrap.appendChild(t);
    setTimeout(() => { t.style.animation = 'none'; t.style.opacity = '0'; t.style.transition = 'opacity 0.4s'; setTimeout(() => t.remove(), 400); }, 3200);
}

// ─── MODAL ───────────────────────────────────────────────────────────────────
function openAddModal() {
    document.getElementById('modal-title-text').textContent = 'Tambah Data Skyview';
    document.getElementById('form-mode').value = 'add';
    document.getElementById('form-id').value = '';
    document.getElementById('input-kebun').value = '';
    document.getElementById('input-tanggal').value = '';
    document.getElementById('input-link').value = '';
    document.getElementById('input-keterangan').value = '';
    clearErrors();
    document.getElementById('modal-backdrop').classList.add('show');
    document.getElementById('input-kebun').focus();
}

function openEditModal(id, btn) {
    const sv = SKYVIEW_DATA[id];
    if (!sv) return;

    document.getElementById('modal-title-text').textContent = 'Edit Data Skyview';
    document.getElementById('form-mode').value = 'edit';
    document.getElementById('form-id').value = id;
    document.getElementById('input-kebun').value = sv.kebun;
    document.getElementById('input-tanggal').value = sv.tanggal;
    document.getElementById('input-link').value = sv.link;
    document.getElementById('input-keterangan').value = sv.keterangan;
    clearErrors();
    document.getElementById('modal-backdrop').classList.add('show');
    document.getElementById('input-kebun').focus();
}

function closeModal(event) {
    if (event && event.target !== document.getElementById('modal-backdrop')) return;
    document.getElementById('modal-backdrop').classList.remove('show');
}

function clearErrors() {
    ['err-kebun','err-tanggal','err-link'].forEach(id => {
        const el = document.getElementById(id);
        el.style.display = 'none'; el.textContent = '';
    });
    ['input-kebun','input-tanggal','input-link'].forEach(id => {
        document.getElementById(id).style.borderColor = '';
    });
}

// ─── FORM SUBMIT ─────────────────────────────────────────────────────────────
function submitForm(e) {
    e.preventDefault();
    clearErrors();

    const mode = document.getElementById('form-mode').value;
    const id   = document.getElementById('form-id').value;
    const body = new URLSearchParams({
        _token:       CSRF,
        kebun_unit:   document.getElementById('input-kebun').value,
        tanggal:      document.getElementById('input-tanggal').value,
        link_youtube: document.getElementById('input-link').value,
        keterangan:   document.getElementById('input-keterangan').value,
    });

    let url    = ROUTES.store;
    let method = 'POST';
    if (mode === 'edit') {
        url = ROUTES.update + id;
        body.append('_method', 'PUT');
    }

    document.getElementById('btn-save-text').textContent = 'Menyimpan…';

    fetch(url, { method, headers: {'Content-Type': 'application/x-www-form-urlencoded'}, body })
        .then(r => {
            if (r.status === 419) { handleCsrfExpiry(); throw new Error('csrf'); }
            return r.json();
        })
        .then(data => {
            document.getElementById('btn-save-text').textContent = 'Simpan';
            if (!data.success) {
                if (data.errors) {
                    const map = {kebun_unit:'err-kebun', tanggal:'err-tanggal', link_youtube:'err-link'};
                    Object.entries(data.errors).forEach(([key, msgs]) => {
                        const el = document.getElementById(map[key]);
                        if (el) { el.textContent = msgs[0]; el.style.display = 'block'; }
                    });
                }
                return;
            }
            document.getElementById('modal-backdrop').classList.remove('show');
            showToast(data.message);
            setTimeout(() => location.reload(), 800);
        })
        .catch(err => {
            if (err.message === 'csrf') return;
            document.getElementById('btn-save-text').textContent = 'Simpan';
            showToast('Terjadi kesalahan. Coba lagi.', 'error');
        });
}

// ─── DELETE ───────────────────────────────────────────────────────────────────
let _deleteId = null;
function confirmDelete(id, btn) {
    const sv = SKYVIEW_DATA[id];
    const kebun = sv ? sv.kebun : 'data ini';
    _deleteId = id;
    document.getElementById('confirm-msg').textContent =
        `Yakin ingin menghapus data "${kebun}"? Tindakan ini tidak dapat dibatalkan.`;
    document.getElementById('confirm-backdrop').classList.add('show');
}
function closeConfirm(event) {
    if (event && event.target !== document.getElementById('confirm-backdrop')) return;
    document.getElementById('confirm-backdrop').classList.remove('show');
    _deleteId = null;
}
function executeDelete() {
    if (!_deleteId) return;
    fetch(ROUTES.destroy + _deleteId, {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams({ _token: CSRF, _method: 'DELETE' }),
    })
    .then(r => {
        if (r.status === 419) { handleCsrfExpiry(); throw new Error('csrf'); }
        return r.json();
    })
    .then(data => {
        document.getElementById('confirm-backdrop').classList.remove('show');
        if (data.success) {
            // Remove both data row and tray row
            const row  = document.getElementById('row-' + _deleteId);
            const tray = document.getElementById('tray-' + _deleteId);
            if (row)  row.remove();
            if (tray) tray.remove();
            showToast(data.message);
            updateRowNumbers();
        } else {
            showToast('Gagal menghapus data.', 'error');
        }
        _deleteId = null;
    })
    .catch(err => { if (err.message !== 'csrf') showToast('Terjadi kesalahan.', 'error'); _deleteId = null; });
}

function updateRowNumbers() {
    const rows = document.querySelectorAll('#sv-tbody tr[id^="row-"]');
    rows.forEach((row, i) => row.querySelector('.sv-no-num').textContent = i + 1);
    document.getElementById('row-count').textContent = rows.length + ' data';
}

// ─── YOUTUBE HELPERS ─────────────────────────────────────────────────────────
function getYoutubeId(url) {
    if (!url) return null;
    // Coba semua format YouTube yang umum
    const patterns = [
        /[?&]v=([a-zA-Z0-9_-]{11})/,          // watch?v=ID
        /youtu\.be\/([a-zA-Z0-9_-]{11})/,       // youtu.be/ID
        /embed\/([a-zA-Z0-9_-]{11})/,            // /embed/ID
        /shorts\/([a-zA-Z0-9_-]{11})/,           // /shorts/ID
        /live\/([a-zA-Z0-9_-]{11})/,             // /live/ID
        /v\/([a-zA-Z0-9_-]{11})/,                // /v/ID
    ];
    for (const re of patterns) {
        const m = url.match(re);
        if (m) return m[1];
    }
    console.warn('[SkyView] Tidak bisa ekstrak YouTube ID dari:', url);
    return null;
}

// ─── VIDEO TRAY ───────────────────────────────────────────────────────────────
let _openTrayId = null;

function toggleVideoTray(id, btn) {
    const tray = document.getElementById('tray-' + id);
    const sv   = SKYVIEW_DATA[id];
    if (!sv) return;

    const kebun   = sv.kebun;
    const tanggal = sv.tanggal;
    const ytLink  = sv.link;

    // Extract YouTube ID dari link yang sebenarnya
    const ytId    = getYoutubeId(ytLink);
    const embedUrl = ytId ? `https://www.youtube.com/embed/${ytId}` : ytLink;
    const thumbUrl = ytId ? `https://img.youtube.com/vi/${ytId}/mqdefault.jpg` : null;

    // Close currently open tray
    if (_openTrayId && _openTrayId !== id) {
        const prev = document.getElementById('tray-' + _openTrayId);
        if (prev) prev.classList.remove('open');
    }

    if (tray.classList.contains('open')) {
        tray.classList.remove('open');
        _openTrayId = null;
        return;
    }

    // Build tray content
    const inner = document.getElementById('tray-inner-' + id);
    const skyviewUrl = ROUTES.skyview + '?link=' + encodeURIComponent(embedUrl);
    const formattedDate = tanggal ? new Date(tanggal).toLocaleDateString('id-ID', {day:'numeric',month:'long',year:'numeric'}) : '-';

    inner.innerHTML = `
        <div class="video-embed-wrap" id="embed-wrap-${id}" title="Klik untuk memutar video">
            ${thumbUrl
                ? `<img class="thumb" id="thumb-${id}" src="${thumbUrl}" alt="Thumbnail ${kebun}"
                     onerror="this.src='https://placehold.co/1280x720/166534/fff?text=No+Thumbnail'"
                     style="cursor:pointer;width:100%;height:100%;object-fit:cover;" onclick="playVideoInline(${id}, '${embedUrl}')"
                   >
                   <div class="video-play-overlay" onclick="playVideoInline(${id}, '${embedUrl}')" style="cursor:pointer;">
                       <div class="play-icon">
                           <svg viewBox="0 0 24 24" fill="currentColor" style="width:36px;height:36px;margin-left:5px;">
                               <path d="M8 5v14l11-7z"/>
                           </svg>
                       </div>
                   </div>`
                : `<div style="width:100%;height:100%;background:#1e293b;display:flex;align-items:center;justify-content:center;color:#64748b;font-size:15px;cursor:pointer;"
                        onclick="playVideoInline(${id}, '${embedUrl}')">▶ Klik untuk Putar Video</div>`
            }
        </div>
        <div class="video-tray-footer">

            <a class="btn-open-skyview" href="${skyviewUrl}" target="_blank">
                <svg viewBox="0 0 24 24" fill="currentColor" style="width:15px;height:15px;">
                    <path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                </svg>
                Tampilan Lebih Luas
            </a>
        </div>
    `;

    tray.classList.add('open');
    _openTrayId = id;
    tray.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

// ─── PLAY VIDEO INLINE ────────────────────────────────────────────────────────
function playVideoInline(id, embedUrl) {
    const wrap = document.getElementById('embed-wrap-' + id);
    if (!wrap) return;

    // Tambahkan autoplay=1 agar langsung putar
    const autoUrl = embedUrl.includes('?')
        ? embedUrl + '&autoplay=1'
        : embedUrl + '?autoplay=1';

    wrap.innerHTML = `
        <iframe
            src="${autoUrl}"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen
            style="display:block;width:100%;height:100%;border-radius:12px;"
        ></iframe>
    `;
}

// Keyboard: press Escape to close modal/confirm
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        document.getElementById('modal-backdrop').classList.remove('show');
        document.getElementById('confirm-backdrop').classList.remove('show');
    }
});
</script>
@endsection

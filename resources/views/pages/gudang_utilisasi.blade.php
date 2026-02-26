@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/libs/leaflet/leaflet.css') }}">
<style>
    /* Scroll di main-content: saat scroll ke bawah, peta bergeser ke atas, Looker terlihat */
    .gudang-utilisasi-wrapper.main-content {
        padding: 0 !important;
        margin: 0 !important;
        width: 100%;
        height: 100vh;
        max-height: 100vh;
        overflow-x: hidden;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
    }
    .gudang-utilisasi-wrapper {
        display: flex;
        flex-direction: column;
        min-height: min-content;
    }
    /* Peta 3/4 halaman; Looker di bawah; scroll = peta bergeser ke atas */
    .gudang-map-section {
        flex: 0 0 75vh;
        min-height: 75vh;
        border: 3px solid #166534;
        border-radius: 8px;
        background: #f8fafc;
        overflow: hidden;
        margin: 0 12px 12px 50px;
        box-shadow: 0 2px 8px rgba(22, 101, 52, 0.15);
    }
    #indonesia-map {
        width: 100%;
        height: 100%;
        min-height: 200px;
        border-radius: 6px;
    }
    /* Tombol zoom peta di kanan, di bawah tombol Hide peta agar tidak tertutup */
    #indonesia-map .leaflet-top.leaflet-right {
        margin-top: 140px;
        margin-right: 10px;
    }
    /* Tanpa scroll; panjang sampai menembus bawah layar */
    .gudang-iframe-section {
        flex: 0 0 150vh;
        min-height: 150vh;
        position: relative;
        overflow: hidden;
        border: 3px solid #166534;
        border-radius: 8px;
        margin: 0 12px 12px 50px;
        box-shadow: 0 2px 8px rgba(22, 101, 52, 0.15);
    }
    .gudang-iframe-section .iframe-container {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }
    /* Dashboard Looker full tanpa scroll di iframe: scale agar seluruh konten terlihat, scroll hanya layar penuh */
    .gudang-iframe-section .iframe-scaled {
        position: absolute;
        top: 0;
        left: 0;
        width: 400%;
        height: 400%;
        transform: scale(0.25);
        transform-origin: top left;
        overflow: hidden;
    }
    .gudang-iframe-section .iframe-scaled iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
        display: block;
        pointer-events: auto;
    }
    .gudang-popup { min-width: 180px; max-width: 320px; line-height: 1.5; }
    .gudang-popup-address { display: inline-block; max-width: 100%; word-break: break-word; }
    .gudang-popup img.gudang-popup-photo {
        max-width: 100%;
        width: 100%;
        height: 160px;
        object-fit: cover;
        margin-top: 8px;
        border-radius: 6px;
        display: block;
        cursor: pointer;
    }
    .gudang-popup-cctv {
        display: block;
        margin-top: 8px;
        text-align: right;
        font-size: 0.85rem;
    }
    .gudang-popup-cctv a {
        color: #166534;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .gudang-popup-cctv a:hover { text-decoration: underline; }
    .gudang-popup-cctv svg { width: 18px; height: 18px; flex-shrink: 0; }
    /* Warna utilisasi: >100% merah, 80-100% oranye, <80% hijau */
    .gudang-popup .utilisasi-red { font-weight: bold; color: #c62828; }
    .gudang-popup .utilisasi-orange { font-weight: bold; color: #e65100; }
    .gudang-popup .utilisasi-green { font-weight: bold; color: #2e7d32; }
    /* Pin peta bentuk tetes (seperti marker default), warna sesuai utilisasi */
    .gudang-pin { display: block; line-height: 0; }
    .gudang-pin svg { display: block; filter: drop-shadow(0 2px 2px rgba(0,0,0,0.35)); }
    .gudang-pin-red svg path { fill: #c62828; }
    /* Pin merah: sinar/glow berkedip seperti alert (utilisasi > 100%) */
    .gudang-pin-red {
        animation: gudang-pin-glow 1.5s ease-in-out infinite;
    }
    @keyframes gudang-pin-glow {
        0%, 100% {
            filter: drop-shadow(0 0 4px rgba(198, 40, 40, 0.9)) drop-shadow(0 0 12px rgba(198, 40, 40, 0.6));
        }
        50% {
            filter: drop-shadow(0 0 12px rgba(198, 40, 40, 1)) drop-shadow(0 0 24px rgba(198, 40, 40, 0.8)) drop-shadow(0 0 36px rgba(198, 40, 40, 0.4));
        }
    }
    .gudang-pin-orange svg path { fill: #ffc107; }
    .gudang-pin-green svg path { fill: #2e7d32; }
    .gudang-pin-default svg path { fill: #78909c; }
    /* Animasi pin berjatuhan ke lokasi saat filter dipilih */
    .gudang-pin-drop {
        display: block;
        animation: gudang-pin-fall 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        transform: translateY(-100px);
        opacity: 0;
    }
    @keyframes gudang-pin-fall {
        0% {
            transform: translateY(-100px);
            opacity: 0;
        }
        70% {
            transform: translateY(6px);
            opacity: 1;
        }
        85% {
            transform: translateY(-3px);
        }
        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }
    /* Modal foto hampir full screen saat foto di popup diklik */
    .gudang-photo-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 9999;
        background: rgba(0,0,0,0.9);
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
    }
    .gudang-photo-modal.is-open { display: flex; }
    .gudang-photo-modal img {
        max-width: 95vw;
        max-height: 95vh;
        width: auto;
        height: auto;
        object-fit: contain;
        border-radius: 8px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.5);
    }
    .gudang-photo-modal-close {
        position: absolute;
        top: 16px;
        right: 24px;
        font-size: 2.5rem;
        color: #fff;
        cursor: pointer;
        line-height: 1;
        z-index: 10000;
        opacity: 0.9;
    }
    .gudang-photo-modal-close:hover { opacity: 1; }

    /* Tombol hide/show peta: floating di atas peta kanan atas */
    .btn-toggle-peta {
        position: fixed;
        top: 85px;
        right: 20px;
        z-index: 1001;
        padding: 6px 14px;
        font-size: 0.95rem;
        font-weight: 500;
        color: #1f2937;
        background: #fff;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        transition: background 0.2s, border-color 0.2s;
    }
    .btn-toggle-peta:hover {
        background: #f3f4f6;
        border-color: #9ca3af;
    }
    /* Saat peta disembunyikan: Looker full page; tombol pindah ke kanan atas */
    .gudang-utilisasi-wrapper.peta-hidden .gudang-map-section {
        display: none;
    }
    .gudang-utilisasi-wrapper.peta-hidden .gudang-iframe-section {
        flex: 0 0 100vh;
        min-height: 100vh;
    }
    .gudang-utilisasi-wrapper.peta-hidden .btn-toggle-peta {
        top: 12px;
    }
    .gudang-utilisasi-wrapper.peta-hidden .gudang-map-filter {
        display: none;
    }
    .gudang-utilisasi-wrapper.peta-hidden .btn-toggle-filter {
        top: 12px;
    }

    /* Tombol toggle filter: di sebelah kiri tombol Hide peta */
    .btn-toggle-filter {
        position: fixed;
        top: 85px;
        right: 120px;
        z-index: 1001;
        padding: 6px 14px;
        font-size: 0.95rem;
        font-weight: 500;
        color: #1f2937;
        background: #fff;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        transition: background 0.2s, border-color 0.2s;
    }
    .btn-toggle-filter:hover {
        background: #f3f4f6;
        border-color: #9ca3af;
    }
    /* Filter disembunyikan saat class filter-hidden ada di wrapper */
    .gudang-utilisasi-wrapper.filter-hidden .gudang-map-filter {
        display: none !important;
    }

    /* Filter pin: Regional, Unit Kebun, tombol Search */
    .gudang-map-filter {
        position: fixed;
        top: 130px;
        right: 20px;
        z-index: 1001;
        width: 220px;
        padding: 12px;
        background: #fff;
        color: #1f2937;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
    .gudang-map-filter label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 4px;
    }
    .gudang-map-filter select {
        width: 100%;
        padding: 6px 8px;
        margin-bottom: 10px;
        font-size: 0.85rem;
        color: #1f2937;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        background: #fff;
    }
    .gudang-map-filter .btn-search-pin {
        width: 100%;
        padding: 8px 12px;
        font-size: 0.9rem;
        font-weight: 500;
        color: #fff;
        background: #166534;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        margin-top: 4px;
    }
    .gudang-map-filter .btn-search-pin:hover {
        background: #15803d;
    }

    /* Header di atas peta: tinggi setengah dari sebelumnya */
    .gudang-header {
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 25px;
        margin: 0;
        padding: 0 50px 6px;
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
        flex-shrink: 0;
    }
    .gudang-header-left {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    /* Logo Danantara: setengah ukuran */
    .gudang-header-logo-danantara {
        width: 150px;
        height: 50px;
        background: transparent;
        border-radius: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .gudang-header-logo-danantara img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .gudang-header-brand {
        font-weight: 700;
        font-size: 1.1rem;
        color: #000;
        line-height: 1.2;
        font-family: inherit;
    }
    .gudang-header-brand span { display: block; }
    .gudang-header-center {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .gudang-header-title-icon {
        width: 28px;
        height: 28px;
        color: #22c55e;
        flex-shrink: 0;
    }
    .gudang-header-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #166534;
        font-family: inherit;
    }
    .gudang-header-right {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .gudang-header-ptpn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 2px;
    }
    .gudang-header-ptpn img {
        height: 50px;
        width: auto;
        object-fit: contain;
    }
    .gudang-header-ptpn span {
        font-size: 0.75rem;
        color: #9ca3af;
        font-weight: 500;
    }
</style>
@endsection

@section('content')
<div class="gudang-utilisasi-wrapper main-content filter-hidden" id="gudangUtilisasiWrapper">
    {{-- Header di atas peta: Danantara | Dashboard Utilisasi Gudang | ptpn1 + Hide peta --}}
    <header class="gudang-header">
        <div class="gudang-header-left">
            <div class="gudang-header-logo-danantara">
                <img src="{{ asset('danantara.png') }}" alt="Danantara">
            </div>
        </div>
        <div class="gudang-header-center">
            <svg class="gudang-header-title-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.95-2.3c.48.17.98.3 1.34.3C19 20 22 3 22 3c-1 2-8 2.09-13 3.08S3 12 3 12s5.5-1.5 8.5-1.5 5 1.5 5 1.5-2.5-4.5-2.5-4.5 2.5 4.5 2.5 4.5-4.5 2.5-4.5c0 0 1.5 2.5 1.5 5.5s-1.5 5.5-1.5 5.5c0 0 2.5-2.5 2.5-5.5S17 8 17 8z"/>
            </svg>
            <h1 class="gudang-header-title" style="font-size: 2.7rem;">Dashboard Utilisasi Gudang Teh</h1>
        </div>
        <div class="gudang-header-right">
            <div class="gudang-header-ptpn">
                <img src="{{ asset('ptpn1.png') }}" alt="PTPN 1">
            </div>
        </div>
    </header>
    <button type="button" class="btn-toggle-filter" id="btnToggleFilter" aria-label="Tampilkan filter">Tampilkan filter</button>
    <button type="button" class="btn-toggle-peta" id="btnTogglePeta" aria-label="Hide peta">Hide peta</button>
    {{-- Filter pin: Regional, Unit Kebun, Search — bisa di-toggle dengan tombol --}}
    <div class="gudang-map-filter" id="gudangMapFilter">
        <label for="filterRegional">Regional</label>
        <select id="filterRegional">
            <option value="">Semua</option>
        </select>
        <label for="filterUnitKebun">Unit Kebun</label>
        <select id="filterUnitKebun">
            <option value="">Semua</option>
        </select>
        <label for="filterJenisGudang">Jenis Gudang</label>
        <select id="filterJenisGudang">
            <option value="">Semua</option>
        </select>
        <button type="button" class="btn-search-pin" id="btnSearchPin">Search</button>
    </div>
    {{-- 3/4 layar atas: Peta Indonesia --}}
    <div class="gudang-map-section">
        <div id="indonesia-map"></div>
    </div>
    {{-- 1/4 layar bawah: Dashboard Looker Studio --}}
    <div class="gudang-iframe-section">
        <div class="iframe-container">
            <div class="iframe-scaled">
                <iframe src="{{ $linkiframe }}" frameborder="0" style="border:0" allowfullscreen scrolling="no" sandbox="allow-forms allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox"></iframe>
            </div>
        </div>
    </div>
</div>
{{-- Modal foto hampir full screen saat foto di popup diklik --}}
<div id="gudangPhotoModal" class="gudang-photo-modal" aria-hidden="true">
    <span class="gudang-photo-modal-close" id="gudangPhotoModalClose" aria-label="Tutup">&times;</span>
    <img id="gudangPhotoModalImg" src="" alt="Foto gudang">
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/libs/leaflet/leaflet.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Peta Indonesia: center sekitar Indonesia, zoom 5 (zoom control dipindah ke kanan agar tidak tumpang tindih dengan sidebar)
    var map = L.map('indonesia-map', { zoomControl: false }).setView([-2.5, 118], 5);
    L.control.zoom({ position: 'topright' }).addTo(map);

    // OpenStreetMap tile (gratis, tidak perlu API key)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 19
    }).addTo(map);

    // Pin lokasi gudang dari spreadsheet (regional, unit kebun, jenis gudang, lat, lng)
    var pinLocations = @json($pinLocations ?? []);
    var pinsLayer = L.layerGroup().addTo(map);
    var imagePasirmalangBakuPelengkap = "{{ asset('pasirmalang_gudangbahanbakupelengkap.jpeg') }}";
    var imagePasirmalangGudangProduksi = "{{ asset('pasirmalang_gudangproduksi.jpg') }}";
    var imagePasirmalangGudangPupuk = "{{ asset('pasirmalang_gudangpupuk.jpg') }}";
    var imagePurbasariGudangProduksi = "{{ asset('purbasari_gudangproduksi.jpg') }}";

    function addPinsToMap(pins, animate) {
        pinsLayer.clearLayers();
        pins.forEach(function(pin, index) {
            var uk = (pin.unit_kebun || '').toString().trim().toLowerCase();
            var jg = (pin.jenis_gudang || '').toString().trim().toLowerCase();
            var isPasirmalangBakuPelengkap = (uk === 'pasirmalang' && jg.indexOf('gudang bahan baku pelengkap') !== -1);
            var isPasirmalangGudangProduksi = (uk === 'pasirmalang' && jg.indexOf('gudang produksi') !== -1);
            var isPasirmalangGudangPupuk = (uk === 'pasirmalang' && jg.indexOf('gudang pupuk') !== -1);
            var isPurbasariGudangProduksi = (uk === 'purbasari' && jg.indexOf('gudang produksi') !== -1);
            var jgContainsProduksi = (pin.jenis_gudang || '').toString().toLowerCase().indexOf('produksi') !== -1;
            var kapasitasTxt = jgContainsProduksi && pin.kapasitas !== undefined && pin.kapasitas !== null && String(pin.kapasitas).trim() !== '' ? (String(pin.kapasitas).trim() + ' Kg') : '-';
            var rawStock = jgContainsProduksi && pin.real_stock !== undefined && pin.real_stock !== null && String(pin.real_stock).trim() !== '' ? String(pin.real_stock).trim() : '';
            var numStock = rawStock ? parseFloat(String(rawStock).replace(',', '.').replace(/\s/g, '')) : NaN;
            var realStockTxt = !rawStock || isNaN(numStock) ? '-' : numStock.toLocaleString('id-ID', {minimumFractionDigits: 0, maximumFractionDigits: 2}) + ' Kg';
            var utilisasiTxt = jgContainsProduksi && pin.utilisasi !== undefined && pin.utilisasi !== null && String(pin.utilisasi).trim() !== '' ? String(pin.utilisasi).trim() : '-';
            function formatUtilisasi(txt) {
                if (txt === '-' || !txt) return txt;
                var num = parseFloat(String(txt).replace(',', '.').replace(/[^\d.-]/g, ''));
                if (isNaN(num)) return txt;
                var cls = num > 100 ? 'utilisasi-red' : (num >= 80 ? 'utilisasi-orange' : 'utilisasi-green');
                return '<span class="' + cls + '">' + txt + '</span>';
            }
            function getUtilisasiPinClass() {
                if (!jgContainsProduksi || !utilisasiTxt || utilisasiTxt === '-') return 'gudang-pin-default';
                var num = parseFloat(String(utilisasiTxt).replace(',', '.').replace(/[^\d.-]/g, ''));
                if (isNaN(num)) return 'gudang-pin-default';
                return num > 100 ? 'gudang-pin-red' : (num >= 80 ? 'gudang-pin-orange' : 'gudang-pin-green');
            }
            var pinSvg = '<svg viewBox="0 0 25 41" xmlns="http://www.w3.org/2000/svg"><path d="M12.5 0C5.6 0 0 5.6 0 12.5c0 9.4 12.5 28.5 12.5 28.5S25 21.9 25 12.5C25 5.6 19.4 0 12.5 0z"/><circle cx="12.5" cy="14" r="6" fill="#fff"/></svg>';
            var pinHtml = animate
                ? '<span class="gudang-pin-drop" style="animation-delay: ' + (index * 0.07) + 's">' + pinSvg + '</span>'
                : pinSvg;
            var pinIcon = L.divIcon({
                className: 'gudang-pin ' + getUtilisasiPinClass(),
                html: pinHtml,
                iconSize: [25, 41],
                iconAnchor: [12.5, 41]
            });
            var jenisGudangRaw = (pin.jenis_gudang || '').toString().trim();
            var jenisGudangDisplay = jenisGudangRaw ? jenisGudangRaw.replace(/\bgudang\b/gi, '').replace(/\s+/g, ' ').trim() || '-' : '-';
            var popupContent = '<div class="gudang-popup">' +
                '<strong>Regional:</strong> ' + (pin.regional || '-') + '<br>' +
                '<strong>Unit Kebun:</strong> ' + (pin.unit_kebun || '-') + '<br>' +
                '<strong>Jenis Gudang:</strong> ' + jenisGudangDisplay + '<br>' +
                '<strong>Alamat:</strong> <span class="gudang-popup-address" data-lat="' + pin.lat + '" data-lng="' + pin.lng + '">Memuat...</span><br>' +
                '<strong>Kapasitas:</strong> ' + kapasitasTxt;
            if (jgContainsProduksi) {
                popupContent += '<br><strong>Real Stock:</strong> ' + realStockTxt + '<br><strong>Utilisasi:</strong> ' + formatUtilisasi(utilisasiTxt);
            }
            if (isPasirmalangBakuPelengkap) {
                popupContent += '<img src="' + imagePasirmalangBakuPelengkap + '" alt="Gudang Pasirmalang Bahan Baku Pelengkap" class="gudang-popup-photo" data-photo-src="' + imagePasirmalangBakuPelengkap + '">';
            }
            if (isPasirmalangGudangProduksi) {
                popupContent += '<img src="' + imagePasirmalangGudangProduksi + '" alt="Gudang Pasirmalang Produksi" class="gudang-popup-photo" data-photo-src="' + imagePasirmalangGudangProduksi + '">';
            }
            if (isPasirmalangGudangPupuk) {
                popupContent += '<img src="' + imagePasirmalangGudangPupuk + '" alt="Gudang Pasirmalang Pupuk" class="gudang-popup-photo" data-photo-src="' + imagePasirmalangGudangPupuk + '">';
            }
            if (isPurbasariGudangProduksi) {
                popupContent += '<img src="' + imagePurbasariGudangProduksi + '" alt="Gudang Purbasari Produksi" class="gudang-popup-photo" data-photo-src="' + imagePurbasariGudangProduksi + '">';
            }
            var linkCctv = (pin.link_cctv || '').toString().trim();
            if (linkCctv) {
                var cctvHref = linkCctv.replace(/&/g, '&amp;').replace(/"/g, '&quot;');
                popupContent += '<div class="gudang-popup-cctv"><a href="' + cctvHref + '" target="_blank" rel="noopener noreferrer">' +
                    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M18 10.5V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v4.5c0 .83.67 1.5 1.5 1.5h1.5l2 2.5h3l2-2.5h1.5c.83 0 1.5-.67 1.5-1.5zm-7 7.5c2.76 0 5-2.24 5-5H6c0 2.76 2.24 5 5 5zm0-8c1.65 0 3 1.35 3 3H9c0-1.65 1.35-3 3-3z"/></svg> CCTV</a></div>';
            }
            popupContent += '</div>';
            L.marker([pin.lat, pin.lng], { icon: pinIcon })
                .addTo(pinsLayer)
                .bindPopup(popupContent);
        });
        if (pins.length > 0) {
            if (animate) {
                var zoomDuration = 1.8;
                if (pins.length === 1) {
                    map.flyTo([pins[0].lat, pins[0].lng], 14, { duration: zoomDuration });
                } else {
                    var bounds = L.latLngBounds(pins.map(function(p) { return [p.lat, p.lng]; }));
                    map.fitBounds(bounds, { padding: [40, 40], maxZoom: 12, animate: true, duration: zoomDuration });
                }
            } else {
                var bounds = L.latLngBounds(pins.map(function(p) { return [p.lat, p.lng]; }));
                map.fitBounds(bounds, { padding: [30, 30], maxZoom: 6 });
            }
        }
    }

    // Pin awal akan di-render setelah dropdown siap dengan filter default "Gudang Produksi" (lihat di bawah)

    // Reverse geocoding: isi alamat dari Nominatim saat popup dibuka
    var addressCache = {};
    map.on('popupopen', function(e) {
        var span = e.popup.getElement().querySelector('.gudang-popup-address');
        if (!span) return;
        var lat = span.getAttribute('data-lat');
        var lng = span.getAttribute('data-lng');
        var key = lat + ',' + lng;
        if (addressCache[key]) {
            span.textContent = addressCache[key];
            return;
        }
        fetch('https://nominatim.openstreetmap.org/reverse?lat=' + lat + '&lon=' + lng + '&format=json', {
            headers: { 'Accept': 'application/json', 'User-Agent': 'DevDashCockpit/1.0 (Laravel dashboard)' }
        }).then(function(r) { return r.json(); }).then(function(data) {
            var addr = (data && data.display_name) ? data.display_name : 'Alamat tidak ditemukan';
            addressCache[key] = addr;
            span.textContent = addr;
        }).catch(function() {
            span.textContent = 'Gagal memuat alamat';
        });
    });

    // Dropdown Regional, Unit Kebun, Jenis Gudang dari spreadsheet (sudah di-merge yang kembar di backend)
    var regionals = @json($regionals ?? []);
    var unitKebuns = @json($unitKebuns ?? []);
    var jenisGudangs = @json($jenisGudangs ?? []);
    var selRegional = document.getElementById('filterRegional');
    var selUnitKebun = document.getElementById('filterUnitKebun');
    var selJenisGudang = document.getElementById('filterJenisGudang');
    regionals.forEach(function(r) {
        var opt = document.createElement('option');
        opt.value = r;
        opt.textContent = r;
        selRegional.appendChild(opt);
    });
    jenisGudangs.forEach(function(j) {
        var opt = document.createElement('option');
        opt.value = j;
        opt.textContent = j;
        selJenisGudang.appendChild(opt);
    });

    // Default filter: Jenis Gudang = Gudang Produksi (saat halaman pertama tampil)
    var defaultJenisProduksi = '';
    for (var i = 0; i < jenisGudangs.length; i++) {
        if ((jenisGudangs[i] || '').toString().trim().toLowerCase().indexOf('gudang produksi') !== -1) {
            defaultJenisProduksi = jenisGudangs[i];
            break;
        }
    }
    if (defaultJenisProduksi) {
        selJenisGudang.value = defaultJenisProduksi;
    }
    var initialFiltered = pinLocations.filter(function(p) {
        var jg = (p.jenis_gudang || '').toString().trim().toLowerCase();
        return jg.indexOf('gudang produksi') !== -1;
    });
    addPinsToMap(initialFiltered.length > 0 ? initialFiltered : pinLocations, initialFiltered.length > 0);

    // Isi Unit Kebun berdasarkan Regional yang dipilih: hanya unit kebun di regional tersebut
    function isiUnitKebunByRegional() {
        var regional = selRegional.value;
        var list = [];
        if (!regional) {
            list = unitKebuns.slice();
        } else {
            var seen = {};
            pinLocations.forEach(function(p) {
                if (p.regional === regional && p.unit_kebun && !seen[p.unit_kebun]) {
                    seen[p.unit_kebun] = true;
                    list.push(p.unit_kebun);
                }
            });
            list.sort();
        }
        selUnitKebun.innerHTML = '<option value="">Semua</option>';
        list.forEach(function(u) {
            var opt = document.createElement('option');
            opt.value = u;
            opt.textContent = u;
            selUnitKebun.appendChild(opt);
        });
    }
    isiUnitKebunByRegional();
    selRegional.addEventListener('change', function() {
        isiUnitKebunByRegional();
    });

    // Tombol Search: filter pin berdasarkan Regional, Unit Kebun, dan Jenis Gudang
    document.getElementById('btnSearchPin').addEventListener('click', function() {
        var regional = selRegional.value;
        var unitKebun = selUnitKebun.value;
        var jenisGudang = (selJenisGudang.value || '').trim();
        var filtered = pinLocations.filter(function(p) {
            var matchR = !regional || (p.regional === regional);
            var matchU = !unitKebun || (p.unit_kebun === unitKebun);
            var pJenis = (p.jenis_gudang || '').toString().trim().toLowerCase();
            var matchJ = !jenisGudang || (pJenis === jenisGudang.toLowerCase());
            return matchR && matchU && matchJ;
        });
        addPinsToMap(filtered, true);
    });

    // Modal foto hampir full screen: buka saat foto di popup diklik, tutup dengan tombol atau klik backdrop
    var photoModal = document.getElementById('gudangPhotoModal');
    var photoModalImg = document.getElementById('gudangPhotoModalImg');
    var photoModalClose = document.getElementById('gudangPhotoModalClose');
    function openPhotoModal(src) {
        if (!src) return;
        photoModalImg.src = src;
        photoModal.classList.add('is-open');
        photoModal.setAttribute('aria-hidden', 'false');
    }
    function closePhotoModal() {
        photoModal.classList.remove('is-open');
        photoModal.setAttribute('aria-hidden', 'true');
        photoModalImg.src = '';
    }
    document.addEventListener('click', function(e) {
        if (e.target.classList && e.target.classList.contains('gudang-popup-photo')) {
            e.preventDefault();
            openPhotoModal(e.target.getAttribute('data-photo-src') || e.target.src);
        }
    });
    if (photoModalClose) photoModalClose.addEventListener('click', closePhotoModal);
    photoModal.addEventListener('click', function(e) {
        if (e.target === photoModal) closePhotoModal();
    });

    // GeoJSON batas wilayah Indonesia
    fetch('https://raw.githubusercontent.com/superpikar/indonesia-geojson/master/indonesia.geojson')
        .then(function(response) { return response.json(); })
        .then(function(geojson) {
            var layer = L.geoJSON(geojson, {
                style: {
                    color: '#2563eb',
                    weight: 1.5,
                    fillColor: '#3b82f6',
                    fillOpacity: 0.2
                }
            }).addTo(map);
            var layerBounds = pinsLayer.getBounds();
            if (layerBounds.isValid()) {
                map.fitBounds(layerBounds, { padding: [30, 30], maxZoom: 12 });
            } else if (pinLocations.length > 0) {
                var bounds = L.latLngBounds(pinLocations.map(function(p) { return [p.lat, p.lng]; }));
                map.fitBounds(bounds, { padding: [30, 30], maxZoom: 6 });
            } else {
                map.fitBounds(layer.getBounds(), { padding: [20, 20] });
            }
        })
        .catch(function() {
            var layerBounds = pinsLayer.getBounds();
            if (layerBounds.isValid()) {
                map.fitBounds(layerBounds, { padding: [30, 30] });
            } else if (pinLocations.length > 0) {
                var bounds = L.latLngBounds(pinLocations.map(function(p) { return [p.lat, p.lng]; }));
                map.fitBounds(bounds, { padding: [30, 30] });
            } else {
                L.marker([-6.2088, 106.8456]).addTo(map)
                    .bindPopup('Indonesia').openPopup();
            }
        });

    // Saat kursor di seksi peta: scroll hanya untuk peta (zoom/pan), halaman tidak scroll
    // Saat kursor di seksi Looker: scroll berlaku untuk seluruh display (peta ikut terscroll)
    var mapSection = document.querySelector('.gudang-map-section');
    if (mapSection) {
        mapSection.addEventListener('wheel', function(e) {
            e.preventDefault();
        }, { passive: false });
    }

    // Tombol hide/show peta: Looker full page saat peta disembunyikan
    var wrapper = document.getElementById('gudangUtilisasiWrapper');
    var btnTogglePeta = document.getElementById('btnTogglePeta');
    if (wrapper && btnTogglePeta) {
        btnTogglePeta.addEventListener('click', function() {
            wrapper.classList.toggle('peta-hidden');
            btnTogglePeta.textContent = wrapper.classList.contains('peta-hidden') ? 'Show peta' : 'Hide peta';
            btnTogglePeta.setAttribute('aria-label', wrapper.classList.contains('peta-hidden') ? 'Show peta' : 'Hide peta');
        });
    }

    // Tombol toggle filter: tampilkan/sembunyikan panel filter (Regional, Unit Kebun, Jenis Gudang)
    var btnToggleFilter = document.getElementById('btnToggleFilter');
    if (wrapper && btnToggleFilter) {
        function updateFilterButtonText() {
            var isHidden = wrapper.classList.contains('filter-hidden');
            btnToggleFilter.textContent = isHidden ? 'Tampilkan filter' : 'Sembunyikan filter';
            btnToggleFilter.setAttribute('aria-label', isHidden ? 'Tampilkan filter' : 'Sembunyikan filter');
        }
        updateFilterButtonText();
        btnToggleFilter.addEventListener('click', function() {
            wrapper.classList.toggle('filter-hidden');
            updateFilterButtonText();
        });
    }
});
</script>
@endsection

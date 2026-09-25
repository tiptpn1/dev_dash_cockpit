<!-- Visual Icon Picker Modal (Self-Contained & Tailwind v2 Compatible) -->
<style>
    /* Scoped styling to ensure perfect visibility over global styles.css */
    #iconPickerModal {
        color: #1f2937 !important;
    }
    #iconPickerModal * {
        box-sizing: border-box;
    }
    .ip-modal-header {
        background-color: #111827 !important;
        color: #ffffff !important;
    }
    .ip-modal-header h3 {
        color: #ffffff !important;
    }
    .ip-modal-header p {
        color: #9ca3af !important;
    }
    .ip-card {
        background-color: #ffffff !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 12px !important;
        padding: 12px 8px !important;
        display: flex;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: space-between !important;
        text-align: center !important;
        cursor: pointer !important;
        transition: all 0.15s ease-in-out !important;
        min-height: 120px !important;
    }
    .ip-card.is-hidden {
        display: none !important;
    }
    .ip-card:hover {
        border-color: #10b981 !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08) !important;
    }
    .ip-card.selected {
        border-color: #059669 !important;
        background-color: #ecfdf5 !important;
        box-shadow: 0 0 0 2px #059669 !important;
    }
    .ip-icon-preview {
        width: 46px !important;
        height: 46px !important;
        background-color: #f3f4f6 !important;
        border-radius: 10px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 22px !important;
        color: #111827 !important;
        margin-bottom: 8px !important;
        transition: background 0.15s !important;
    }
    .ip-card:hover .ip-icon-preview {
        background-color: #d1fae5 !important;
        color: #047857 !important;
    }
    .ip-card.selected .ip-icon-preview {
        background-color: #a7f3d0 !important;
        color: #065f46 !important;
    }
    .ip-name {
        font-size: 12px !important;
        font-weight: 700 !important;
        color: #111827 !important;
        line-height: 1.2 !important;
        width: 100% !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
    }
    .ip-class {
        font-size: 10px !important;
        font-family: monospace !important;
        color: #6b7280 !important;
        margin-top: 2px !important;
        width: 100% !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
    }
    .ip-desc {
        font-size: 10px !important;
        color: #4b5563 !important;
        margin-top: 4px !important;
        line-height: 1.25 !important;
        display: -webkit-box !important;
        -webkit-line-clamp: 2 !important;
        -webkit-box-orient: vertical !important;
        overflow: hidden !important;
    }
    .ip-tab-btn {
        padding: 6px 12px !important;
        border-radius: 8px !important;
        font-size: 12px !important;
        font-weight: 700 !important;
        cursor: pointer !important;
        transition: all 0.15s !important;
        border: none !important;
        white-space: nowrap !important;
        background-color: #f3f4f6 !important;
        color: #4b5563 !important;
    }
    .ip-tab-btn:hover {
        background-color: #e5e7eb !important;
        color: #111827 !important;
    }
    .ip-tab-btn.active {
        background-color: #111827 !important;
        color: #ffffff !important;
    }
    .ip-search-input {
        background-color: #f9fafb !important;
        border: 1px solid #d1d5db !important;
        color: #111827 !important;
        border-radius: 10px !important;
        padding: 8px 12px 8px 32px !important;
        font-size: 12px !important;
        width: 100% !important;
    }
    .ip-search-input:focus {
        background-color: #ffffff !important;
        outline: none !important;
        border-color: #10b981 !important;
        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2) !important;
    }
</style>

<div id="iconPickerModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-900 bg-opacity-60 transition-opacity" style="backdrop-filter: blur(4px);" onclick="closeIconPickerModal()"></div>

    <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl border border-gray-200">
            
            <!-- Modal Header -->
            <div class="ip-modal-header px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="w-9 h-9 rounded-lg bg-emerald-600 flex items-center justify-center text-white text-base shadow-sm">
                        <i class="fas fa-shapes"></i>
                    </span>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-base font-bold leading-none">Pilih Icon Secara Visual</h3>
                            <span class="text-xs bg-emerald-700 text-white font-mono px-2 py-0.5 rounded-full font-bold">125+ Icons</span>
                        </div>
                        <p class="text-xs mt-1">Klik salah satu kotak icon untuk langsung memasukkan class ke form</p>
                    </div>
                </div>
                <button type="button" onclick="closeIconPickerModal()" class="text-gray-400 hover:text-white transition p-2 rounded-lg hover:bg-gray-800">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-4" style="background-color: #ffffff;">
                
                <!-- Search and Filter Tabs -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div class="relative w-full sm:w-72">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="text" id="modalIconSearch" placeholder="Cari icon (areal, panen, truk, uang, chart)..." class="ip-search-input">
                    </div>
                    <div class="flex flex-wrap items-center gap-1.5 w-full sm:w-auto" id="modalCatTabs">
                        <button type="button" onclick="filterModalCategory('all', this)" class="ip-tab-btn active">Semua</button>
                        <button type="button" onclick="filterModalCategory('areal', this)" class="ip-tab-btn">Areal & Lahan</button>
                        <button type="button" onclick="filterModalCategory('produksi', this)" class="ip-tab-btn">Produksi & Panen</button>
                        <button type="button" onclick="filterModalCategory('operasional', this)" class="ip-tab-btn">Operasional & Logistik</button>
                        <button type="button" onclick="filterModalCategory('bisnis', this)" class="ip-tab-btn">Bisnis & Finansial</button>
                        <button type="button" onclick="filterModalCategory('analitik', this)" class="ip-tab-btn">Grafik & Laporan</button>
                        <button type="button" onclick="filterModalCategory('umum', this)" class="ip-tab-btn">Admin & Umum</button>
                    </div>
                </div>

                <!-- Icons Grid Container (Scrollable) -->
                <div class="overflow-y-auto pr-1" style="max-height: 420px;" id="modalIconGrid">
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2.5" id="modalIconCardsList">
                        <!-- Populated dynamically via JS -->
                    </div>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-3.5 border-t border-gray-200 flex items-center justify-between" style="background-color: #f9fafb;">
                <div class="flex items-center gap-2 text-xs" style="color: #4b5563;">
                    <span>Sedang aktif:</span>
                    <span id="modalCurrentSelection" class="font-mono font-bold text-emerald-800 bg-emerald-100 px-2 py-0.5 rounded border border-emerald-300">
                        Belum dipilih
                    </span>
                </div>
                <button type="button" onclick="closeIconPickerModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs font-bold rounded-lg transition">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>

<script>
const availableIcons = [
    // 1. Areal, Lahan & Geospasial
    { class: 'fa-solid fa-draw-polygon', name: 'Draw Polygon', cat: 'areal', desc: 'Polygon / Batas Blok Kebun' },
    { class: 'fa-solid fa-map-location-dot', name: 'Map Location Dot', cat: 'areal', desc: 'Sebaran Wilayah / Titik GPS' },
    { class: 'fa-solid fa-map', name: 'Map', cat: 'areal', desc: 'Peta Hamparan Kebun' },
    { class: 'fa-solid fa-map-pin', name: 'Map Pin', cat: 'areal', desc: 'Titik Lokasi Afdeling' },
    { class: 'fa-solid fa-location-dot', name: 'Location Dot', cat: 'areal', desc: 'Koordinat Kebun / Pos' },
    { class: 'fa-solid fa-vector-square', name: 'Vector Square', cat: 'areal', desc: 'Luas Hektar (Ha) / Plotting' },
    { class: 'fa-solid fa-earth-asia', name: 'Earth Asia', cat: 'areal', desc: 'Regional / Geospasial' },
    { class: 'fa-solid fa-globe', name: 'Globe', cat: 'areal', desc: 'Peta Global GIS' },
    { class: 'fa-solid fa-tree', name: 'Tree', cat: 'areal', desc: 'Areal Tegakan Pohon (TM)' },
    { class: 'fa-solid fa-seedling', name: 'Seedling', cat: 'areal', desc: 'Bibitan / TBM (Muda)' },
    { class: 'fa-solid fa-plant-wilt', name: 'Plant Wilt', cat: 'areal', desc: 'Tanaman Rusak / Sisipan' },
    { class: 'fa-solid fa-layer-group', name: 'Layer Group', cat: 'areal', desc: 'Klasifikasi Strata Areal' },
    { class: 'fa-solid fa-mountain-sun', name: 'Mountain Sun', cat: 'areal', desc: 'Kontur Lahan Berbukit' },
    { class: 'fa-solid fa-mountain', name: 'Mountain', cat: 'areal', desc: 'Elevasi Dataran Tinggi' },
    { class: 'fa-solid fa-water', name: 'Water', cat: 'areal', desc: 'Kanal / Saluran Air / Rawa' },
    { class: 'fa-solid fa-droplet', name: 'Droplet', cat: 'areal', desc: 'Curah Hujan / Irigasi' },
    { class: 'fa-solid fa-cloud-sun-rain', name: 'Cloud Sun Rain', cat: 'areal', desc: 'Cuaca / Agroklimat' },
    { class: 'fa-solid fa-temperature-high', name: 'Temperature High', cat: 'areal', desc: 'Suhu & Kelembaban Iklim' },
    { class: 'fa-solid fa-compass', name: 'Compass', cat: 'areal', desc: 'Arah Mata Angin / Survei' },
    { class: 'fa-solid fa-route', name: 'Route', cat: 'areal', desc: 'Jalan Poros & Transport Kebun' },
    { class: 'fa-solid fa-border-all', name: 'Border All', cat: 'areal', desc: 'Batas Konsesi & Alas Hak' },

    // 2. Produksi, Panen & Komoditas
    { class: 'fa-solid fa-boxes-stacked', name: 'Boxes Stacked', cat: 'produksi', desc: 'Tonase Hasil Panen' },
    { class: 'fa-solid fa-box', name: 'Box', cat: 'produksi', desc: 'Kemasan / Kardus Produk' },
    { class: 'fa-solid fa-box-open', name: 'Box Open', cat: 'produksi', desc: 'Stok Terbuka / Siap Kirim' },
    { class: 'fa-solid fa-cubes', name: 'Cubes', cat: 'produksi', desc: 'Kuantum Output Komoditi' },
    { class: 'fa-solid fa-weight-hanging', name: 'Weight Hanging', cat: 'produksi', desc: 'Bobot Timbangan (Kg/Ton)' },
    { class: 'fa-solid fa-scale-unbalanced', name: 'Scale Unbalanced', cat: 'produksi', desc: 'Timbangan Jembatan / Bruto' },
    { class: 'fa-solid fa-industry', name: 'Industry / Factory', cat: 'produksi', desc: 'Pabrik Pengolahan Off-farm' },
    { class: 'fa-solid fa-leaf', name: 'Leaf', cat: 'produksi', desc: 'Pucuk Teh / Getah Karet' },
    { class: 'fa-solid fa-wheat-awn', name: 'Wheat Awn', cat: 'produksi', desc: 'Hasil Panen / Tuaian' },
    { class: 'fa-solid fa-mug-hot', name: 'Mug Hot', cat: 'produksi', desc: 'Komoditas Teh & Kopi' },
    { class: 'fa-solid fa-apple-whole', name: 'Apple Whole', cat: 'produksi', desc: 'Komoditas Buah / Holtikultura' },
    { class: 'fa-solid fa-cookie', name: 'Cookie', cat: 'produksi', desc: 'Komoditas Tebu & Gula' },
    { class: 'fa-solid fa-jar', name: 'Jar', cat: 'produksi', desc: 'Produk Olahan Sawit / Minyak' },
    { class: 'fa-solid fa-flask', name: 'Flask', cat: 'produksi', desc: 'Uji Rendemen & Laboratorium' },
    { class: 'fa-solid fa-vial', name: 'Vial', cat: 'produksi', desc: 'Sampel Kadar Karet Kering (KKK)' },
    { class: 'fa-solid fa-recycle', name: 'Recycle', cat: 'produksi', desc: 'Pemanfaatan Limbah / Biomassa' },
    { class: 'fa-solid fa-oil-well', name: 'Oil Well', cat: 'produksi', desc: 'Tangki Timbun CPO' },
    { class: 'fa-solid fa-award', name: 'Award', cat: 'produksi', desc: 'Sertifikasi Mutu (RSPO/ISPO)' },
    { class: 'fa-solid fa-certificate', name: 'Certificate', cat: 'produksi', desc: 'Sertifikat Mutu / Standar' },
    { class: 'fa-solid fa-circle-check', name: 'Circle Check', cat: 'produksi', desc: 'Lolos Quality Control (QC)' },

    // 3. Operasional, Lapangan & Logistik
    { class: 'fa-solid fa-truck', name: 'Truck', cat: 'operasional', desc: 'Armada Truk Kebun' },
    { class: 'fa-solid fa-truck-moving', name: 'Truck Moving', cat: 'operasional', desc: 'Pengiriman / Ritase Jalan' },
    { class: 'fa-solid fa-truck-ramp-box', name: 'Truck Ramp Box', cat: 'operasional', desc: 'Loading Ramp Pabrik / Bongkar' },
    { class: 'fa-solid fa-tractor', name: 'Tractor', cat: 'operasional', desc: 'Traktor & Alat Berat' },
    { class: 'fa-solid fa-trailer', name: 'Trailer', cat: 'operasional', desc: 'Trailer Angkut Tandan/Kayu' },
    { class: 'fa-solid fa-gas-pump', name: 'Gas Pump', cat: 'operasional', desc: 'Bahan Bakar Solar / Genset' },
    { class: 'fa-solid fa-warehouse', name: 'Warehouse', cat: 'operasional', desc: 'Gudang Pupuk & Logistik' },
    { class: 'fa-solid fa-gears', name: 'Gears', cat: 'operasional', desc: 'Mekanisasi / Mesin Pabrik' },
    { class: 'fa-solid fa-gear', name: 'Gear', cat: 'operasional', desc: 'Pengaturan Mesin Operasional' },
    { class: 'fa-solid fa-wrench', name: 'Wrench', cat: 'operasional', desc: 'Pemeliharaan & Bengkel' },
    { class: 'fa-solid fa-screwdriver-wrench', name: 'Screwdriver Wrench', cat: 'operasional', desc: 'Perbaikan Sparepart Pabrik' },
    { class: 'fa-solid fa-clipboard-check', name: 'Clipboard Check', cat: 'operasional', desc: 'SOP & Verifikasi Lapangan' },
    { class: 'fa-solid fa-clipboard-list', name: 'Clipboard List', cat: 'operasional', desc: 'PICA & Daftar Temuan' },
    { class: 'fa-solid fa-list-check', name: 'List Check', cat: 'operasional', desc: 'Checklist Tindak Lanjut' },
    { class: 'fa-solid fa-triangle-exclamation', name: 'Triangle Exclamation', cat: 'operasional', desc: 'Peringatan Masalah / Losis' },
    { class: 'fa-solid fa-circle-exclamation', name: 'Circle Exclamation', cat: 'operasional', desc: 'Laporan Insiden Operasional' },
    { class: 'fa-solid fa-video', name: 'Video CCTV', cat: 'operasional', desc: 'Monitoring CCTV Pabrik & PKS' },
    { class: 'fa-solid fa-walkie-talkie', name: 'Walkie Talkie', cat: 'operasional', desc: 'Radio Komunikasi Lapangan' },
    { class: 'fa-solid fa-helmet-safety', name: 'Helmet Safety', cat: 'operasional', desc: 'K3 & Keselamatan Kerja' },
    { class: 'fa-solid fa-fire-extinguisher', name: 'Fire Extinguisher', cat: 'operasional', desc: 'Damkar Kebun & Tanggap Darurat' },
    { class: 'fa-solid fa-shield-halved', name: 'Shield Halved', cat: 'operasional', desc: 'Pengamanan Aset Kebun' },
    { class: 'fa-solid fa-tower-broadcast', name: 'Tower Broadcast', cat: 'operasional', desc: 'Tower Sinyal / Repeater' },
    { class: 'fa-solid fa-barcode', name: 'Barcode', cat: 'operasional', desc: 'Barcode / QR Tiket Timbang' },

    // 4. Bisnis & Finansial
    { class: 'fa-solid fa-coins', name: 'Coins', cat: 'bisnis', desc: 'Keuangan & Finansial' },
    { class: 'fa-solid fa-money-bill-wave', name: 'Money Bill Wave', cat: 'bisnis', desc: 'Arus Kas / Cash Flow' },
    { class: 'fa-solid fa-wallet', name: 'Wallet', cat: 'bisnis', desc: 'Dompet Anggaran / Budget' },
    { class: 'fa-solid fa-credit-card', name: 'Credit Card', cat: 'bisnis', desc: 'Pembayaran Non-Tunai' },
    { class: 'fa-solid fa-calculator', name: 'Calculator', cat: 'bisnis', desc: 'Hitung HPP / Biaya Jalan' },
    { class: 'fa-solid fa-scale-balanced', name: 'Scale Balanced', cat: 'bisnis', desc: 'Legalitas & Alas Hak' },
    { class: 'fa-solid fa-file-contract', name: 'File Contract', cat: 'bisnis', desc: 'Kontrak Kerja Sama / SPK' },
    { class: 'fa-solid fa-file-invoice-dollar', name: 'File Invoice Dollar', cat: 'bisnis', desc: 'Invoice Penjualan / Faktur' },
    { class: 'fa-solid fa-file-invoice', name: 'File Invoice', cat: 'bisnis', desc: 'Dokumen Tagihan & Kwitansi' },
    { class: 'fa-solid fa-cart-shopping', name: 'Cart Shopping', cat: 'bisnis', desc: 'Pengadaan / Procurement' },
    { class: 'fa-solid fa-bag-shopping', name: 'Bag Shopping', cat: 'bisnis', desc: 'Penjualan Komoditi / Ritel' },
    { class: 'fa-solid fa-store', name: 'Store', cat: 'bisnis', desc: 'Koperasi & Unit Usaha' },
    { class: 'fa-solid fa-handshake', name: 'Handshake', cat: 'bisnis', desc: 'Kemitraan Petani Plasma' },
    { class: 'fa-solid fa-landmark', name: 'Landmark', cat: 'bisnis', desc: 'Perbankan / BUMN Holding' },
    { class: 'fa-solid fa-building', name: 'Building', cat: 'bisnis', desc: 'Kantor Direksi / Head Office' },
    { class: 'fa-solid fa-building-wheat', name: 'Building Wheat', cat: 'bisnis', desc: 'Sentra Kantor Kebun' },
    { class: 'fa-solid fa-stamp', name: 'Stamp', cat: 'bisnis', desc: 'Approval & Tanda Pengesahan' },

    // 5. Grafik & Laporan (Analitik)
    { class: 'fa-solid fa-chart-line', name: 'Chart Line', cat: 'analitik', desc: 'Grafik Tren Produksi / Kinerja' },
    { class: 'fa-solid fa-chart-column', name: 'Chart Column', cat: 'analitik', desc: 'Diagram Batang Realisasi' },
    { class: 'fa-solid fa-chart-pie', name: 'Chart Pie', cat: 'analitik', desc: 'Diagram Komposisi & Rasio' },
    { class: 'fa-solid fa-chart-area', name: 'Chart Area', cat: 'analitik', desc: 'Akumulasi Produksi Bulanan' },
    { class: 'fa-solid fa-arrow-trend-up', name: 'Trend Up', cat: 'analitik', desc: 'Pertumbuhan Kinerja Positif' },
    { class: 'fa-solid fa-arrow-trend-down', name: 'Trend Down', cat: 'analitik', desc: 'Penurunan / Defisit Target' },
    { class: 'fa-solid fa-gauge-high', name: 'Gauge High', cat: 'analitik', desc: 'Speedometer KPI Dashboard' },
    { class: 'fa-solid fa-gauge', name: 'Gauge', cat: 'analitik', desc: 'Indikator Tekanan Operasional' },
    { class: 'fa-solid fa-bullseye', name: 'Bullseye', cat: 'analitik', desc: 'Target RKAP & Sasaran Mutu' },
    { class: 'fa-solid fa-crosshairs', name: 'Crosshairs', cat: 'analitik', desc: 'Fokus Monitoring Strategis' },
    { class: 'fa-solid fa-table-list', name: 'Table List', cat: 'analitik', desc: 'Rekapitulasi Tabel Data' },
    { class: 'fa-solid fa-table-cells', name: 'Table Cells', cat: 'analitik', desc: 'Matriks Kuadran PICA' },
    { class: 'fa-solid fa-magnifying-glass-chart', name: 'Magnifying Chart', cat: 'analitik', desc: 'Evaluasi Kinerja Analitik' },
    { class: 'fa-solid fa-file-excel', name: 'File Excel', cat: 'analitik', desc: 'Export Format Spreadsheet' },
    { class: 'fa-solid fa-file-pdf', name: 'File PDF', cat: 'analitik', desc: 'Laporan Dokumen Resmi PDF' },
    { class: 'fa-solid fa-square-poll-vertical', name: 'Square Poll', cat: 'analitik', desc: 'Hasil Survei & Audit' },
    { class: 'fa-solid fa-ranking-star', name: 'Ranking Star', cat: 'analitik', desc: 'Peringkat Kinerja Regional' },

    // 6. Admin, SDM & Umum
    { class: 'fa-solid fa-house', name: 'House', cat: 'umum', desc: 'Home / Dashboard Utama' },
    { class: 'fa-solid fa-users', name: 'Users', cat: 'umum', desc: 'Karyawan / Regu Panen' },
    { class: 'fa-solid fa-user-tie', name: 'User Tie', cat: 'umum', desc: 'Pimpinan & Manajer Kebun' },
    { class: 'fa-solid fa-user-gear', name: 'User Gear', cat: 'umum', desc: 'Administrator Sistem IT' },
    { class: 'fa-solid fa-id-card', name: 'ID Card', cat: 'umum', desc: 'Identitas Mandor / Karyawan' },
    { class: 'fa-solid fa-user-check', name: 'User Check', cat: 'umum', desc: 'Presensi & Absensi Karyawan' },
    { class: 'fa-solid fa-key', name: 'Key', cat: 'umum', desc: 'Akses User & Ganti Password' },
    { class: 'fa-solid fa-lock', name: 'Lock', cat: 'umum', desc: 'Hak Akses Dibatasi' },
    { class: 'fa-solid fa-shield', name: 'Shield', cat: 'umum', desc: 'Keamanan Sistem Data' },
    { class: 'fa-solid fa-sliders', name: 'Sliders', cat: 'umum', desc: 'Konfigurasi Parameter Sistem' },
    { class: 'fa-solid fa-cube', name: 'Cube', cat: 'umum', desc: 'Modul Fitur Aplikasi' },
    { class: 'fa-solid fa-cubes-stacked', name: 'Cubes Stacked', cat: 'umum', desc: 'Kumpulan Modul Terintegrasi' },
    { class: 'fa-solid fa-shapes', name: 'Shapes', cat: 'umum', desc: 'Master Data & Taksonomi' },
    { class: 'fa-solid fa-folder-open', name: 'Folder Open', cat: 'umum', desc: 'Berkas Dokumen Terbuka' },
    { class: 'fa-solid fa-folder', name: 'Folder', cat: 'umum', desc: 'Arsip / Direktori File' },
    { class: 'fa-solid fa-file-lines', name: 'File Lines', cat: 'umum', desc: 'Lembar Catatan / Formulir' },
    { class: 'fa-solid fa-envelope', name: 'Envelope', cat: 'umum', desc: 'Surat Menyurat Resmi' },
    { class: 'fa-solid fa-bell', name: 'Bell', cat: 'umum', desc: 'Notifikasi & Pengumuman' },
    { class: 'fa-solid fa-calendar-days', name: 'Calendar Days', cat: 'umum', desc: 'Kalender & Jadwal Rencana' },
    { class: 'fa-solid fa-clock', name: 'Clock', cat: 'umum', desc: 'Jam Kerja & Waktu Operasi' },
    { class: 'fa-solid fa-cloud-arrow-up', name: 'Cloud Arrow Up', cat: 'umum', desc: 'Unggah Berkas ke Cloud' },
    { class: 'fa-solid fa-database', name: 'Database', cat: 'umum', desc: 'Server Basis Data Terpusat' },
    { class: 'fa-solid fa-network-wired', name: 'Network Wired', cat: 'umum', desc: 'Jaringan & Integrasi API' },
    { class: 'fa-solid fa-mobile-screen', name: 'Mobile Screen', cat: 'umum', desc: 'Aplikasi Mobile DFARM' },
    { class: 'fa-solid fa-laptop', name: 'Laptop', cat: 'umum', desc: 'Aplikasi Web Desktop' },
    { class: 'fa-solid fa-right-from-bracket', name: 'Right From Bracket', cat: 'umum', desc: 'Keluar Akun / Logout' },
    { class: 'fa-solid fa-circle-question', name: 'Circle Question', cat: 'umum', desc: 'Bantuan & Dokumentasi' }
];

let targetInputId = 'icon';

function openIconPickerModal(inputId = 'icon') {
    targetInputId = inputId;
    const modal = document.getElementById('iconPickerModal');
    const inputElem = document.getElementById(inputId);
    const inputVal = inputElem ? inputElem.value.trim() : '';
    
    document.getElementById('modalCurrentSelection').textContent = inputVal || 'Belum dipilih';
    
    // Reset search
    const searchInput = document.getElementById('modalIconSearch');
    if (searchInput) searchInput.value = '';

    // Reset tabs
    currentModalCat = 'all';
    const tabs = document.querySelectorAll('#modalCatTabs button');
    tabs.forEach((t, idx) => {
        if (idx === 0) t.classList.add('active');
        else t.classList.remove('active');
    });

    renderModalIcons(availableIcons, inputVal);
    applyModalFilters();
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeIconPickerModal() {
    const modal = document.getElementById('iconPickerModal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

function renderModalIcons(list, selectedClass = '') {
    const container = document.getElementById('modalIconCardsList');
    if (!container) return;
    container.innerHTML = '';

    list.forEach(item => {
        const isSelected = (item.class === selectedClass);
        const card = document.createElement('div');
        card.className = `ip-card ${isSelected ? 'selected' : ''}`;
        card.setAttribute('data-name', item.name.toLowerCase());
        card.setAttribute('data-cat', item.cat);
        card.setAttribute('data-class', item.class);
        card.setAttribute('data-desc', item.desc.toLowerCase());
        card.onclick = () => selectIconFromModal(item.class);

        card.innerHTML = `
            <div class="ip-icon-preview">
                <i class="${item.class}"></i>
            </div>
            <div style="width: 100%;">
                <div class="ip-name" title="${item.name}">${item.name}</div>
                <div class="ip-class" title="${item.class}">${item.class}</div>
                <div class="ip-desc" title="${item.desc}">${item.desc}</div>
            </div>
        `;
        container.appendChild(card);
    });
}

function selectIconFromModal(iconClass) {
    const targetInput = document.getElementById(targetInputId);
    if (targetInput) {
        targetInput.value = iconClass;
        targetInput.dispatchEvent(new Event('input'));
    }
    closeIconPickerModal();
}

let currentModalCat = 'all';

function filterModalCategory(cat, btnElem) {
    currentModalCat = cat;
    const tabs = document.querySelectorAll('#modalCatTabs button');
    tabs.forEach(t => t.classList.remove('active'));
    if (btnElem) {
        btnElem.classList.add('active');
    }
    applyModalFilters();
}

function applyModalFilters() {
    const searchInput = document.getElementById('modalIconSearch');
    const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
    const cards = document.querySelectorAll('#modalIconCardsList > .ip-card');

    cards.forEach(card => {
        const itemCat = card.getAttribute('data-cat') || '';
        const name = card.getAttribute('data-name') || '';
        const cls = card.getAttribute('data-class') || '';
        const desc = card.getAttribute('data-desc') || '';

        const matchesCat = (currentModalCat === 'all' || itemCat === currentModalCat);
        const matchesSearch = (!query || name.includes(query) || cls.includes(query) || desc.includes(query));

        if (matchesCat && matchesSearch) {
            card.classList.remove('is-hidden');
        } else {
            card.classList.add('is-hidden');
        }
    });
}

document.getElementById('modalIconSearch')?.addEventListener('input', applyModalFilters);

// Setup Live Preview for Target Input
function setupIconInputPreview(inputId = 'icon', previewBoxId = 'iconLivePreviewBox') {
    const input = document.getElementById(inputId);
    const box = document.getElementById(previewBoxId);
    if (!input || !box) return;

    function updatePreview() {
        const val = input.value.trim();
        if (val) {
            box.className = `${val} text-lg text-emerald-600`;
            box.style.color = '#059669';
        } else {
            box.className = 'fas fa-icons text-lg text-gray-400';
            box.style.color = '#9ca3af';
        }
    }

    input.addEventListener('input', updatePreview);
    updatePreview();
}
</script>

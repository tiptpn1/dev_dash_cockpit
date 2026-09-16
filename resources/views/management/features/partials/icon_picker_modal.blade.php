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
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-3xl border border-gray-200">
            
            <!-- Modal Header -->
            <div class="ip-modal-header px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="w-9 h-9 rounded-lg bg-emerald-600 flex items-center justify-center text-white text-base shadow-sm">
                        <i class="fas fa-shapes"></i>
                    </span>
                    <div>
                        <h3 class="text-base font-bold leading-none">Pilih Icon Secara Visual</h3>
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
                        <input type="text" id="modalIconSearch" placeholder="Cari icon (areal, panen, box, map)..." class="ip-search-input">
                    </div>
                    <div class="flex flex-wrap items-center gap-1.5 w-full sm:w-auto" id="modalCatTabs">
                        <button type="button" onclick="filterModalCategory('all', this)" class="ip-tab-btn active">Semua</button>
                        <button type="button" onclick="filterModalCategory('areal', this)" class="ip-tab-btn">Areal & Lahan</button>
                        <button type="button" onclick="filterModalCategory('produksi', this)" class="ip-tab-btn">Produksi & Panen</button>
                        <button type="button" onclick="filterModalCategory('operasional', this)" class="ip-tab-btn">Operasional</button>
                        <button type="button" onclick="filterModalCategory('bisnis', this)" class="ip-tab-btn">Bisnis & Finansial</button>
                    </div>
                </div>

                <!-- Icons Grid Container (Scrollable) -->
                <div class="overflow-y-auto pr-1" style="max-height: 380px;" id="modalIconGrid">
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3" id="modalIconCardsList">
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
    // Areal & Lahan
    { class: 'fa-solid fa-draw-polygon', name: 'Draw Polygon', cat: 'areal', desc: 'Polygon / Batas Blok Kebun' },
    { class: 'fa-solid fa-map-location-dot', name: 'Map Location Dot', cat: 'areal', desc: 'Sebaran Wilayah Kebun' },
    { class: 'fa-solid fa-vector-square', name: 'Vector Square', cat: 'areal', desc: 'Luas Hektar (Ha)' },
    { class: 'fa-solid fa-tree', name: 'Tree', cat: 'areal', desc: 'Areal Tegakan Pohon (TM)' },
    { class: 'fa-solid fa-seedling', name: 'Seedling', cat: 'areal', desc: 'Tanaman Muda / TBM' },
    { class: 'fa-solid fa-layer-group', name: 'Layer Group', cat: 'areal', desc: 'Klasifikasi Strata Areal' },
    { class: 'fa-solid fa-map', name: 'Map', cat: 'areal', desc: 'Peta Hamparan Kebun' },
    { class: 'fa-solid fa-earth-asia', name: 'Earth Asia', cat: 'areal', desc: 'Regional / Geospasial' },

    // Produksi & Panen
    { class: 'fa-solid fa-boxes-stacked', name: 'Boxes Stacked', cat: 'produksi', desc: 'Tumpukan Tonase Panen' },
    { class: 'fa-solid fa-weight-hanging', name: 'Weight Hanging', cat: 'produksi', desc: 'Bobot Timbangan (Kg/Ton)' },
    { class: 'fa-solid fa-industry', name: 'Industry / Factory', cat: 'produksi', desc: 'Pabrik Pengolahan Off-farm' },
    { class: 'fa-solid fa-leaf', name: 'Leaf', cat: 'produksi', desc: 'Pucuk Teh / Getah Karet' },
    { class: 'fa-solid fa-wheat-awn', name: 'Wheat Awn', cat: 'produksi', desc: 'Hasil Tuaian / Panen' },
    { class: 'fa-solid fa-arrow-trend-up', name: 'Trend Up', cat: 'produksi', desc: 'Tren Kenaikan Produksi' },
    { class: 'fa-solid fa-truck-ramp-box', name: 'Truck Ramp Box', cat: 'produksi', desc: 'Logistik & Pengiriman Panen' },
    { class: 'fa-solid fa-cubes', name: 'Cubes', cat: 'produksi', desc: 'Kuantum Output Komoditi' },

    // Operasional
    { class: 'fa-solid fa-gears', name: 'Gears', cat: 'operasional', desc: 'Sistem Operasional / Mekanisasi' },
    { class: 'fa-solid fa-clipboard-check', name: 'Clipboard Check', cat: 'operasional', desc: 'Verifikasi & SOP Kebun' },
    { class: 'fa-solid fa-clipboard-list', name: 'Clipboard List', cat: 'operasional', desc: 'PICA / Daftar Temuan' },
    { class: 'fa-solid fa-warehouse', name: 'Warehouse', cat: 'operasional', desc: 'Gudang & Inventori' },
    { class: 'fa-solid fa-mug-hot', name: 'Mug Hot', cat: 'operasional', desc: 'Komoditas Teh & Kopi' },
    { class: 'fa-solid fa-video', name: 'CCTV Video', cat: 'operasional', desc: 'Monitoring CCTV Kebun' },

    // Bisnis & Finansial
    { class: 'fa-solid fa-coins', name: 'Coins', cat: 'bisnis', desc: 'Finansial & Keuangan' },
    { class: 'fa-solid fa-chart-line', name: 'Chart Line', cat: 'bisnis', desc: 'Tren Progres & Penjualan' },
    { class: 'fa-solid fa-chart-pie', name: 'Chart Pie', cat: 'bisnis', desc: 'Distribusi & Rasio' },
    { class: 'fa-solid fa-building', name: 'Building', cat: 'bisnis', desc: 'Executive & Kantor Direksi' },
    { class: 'fa-solid fa-scale-balanced', name: 'Scale Balanced', cat: 'bisnis', desc: 'Legal & Agraria' },
    { class: 'fa-solid fa-users', name: 'Users', cat: 'bisnis', desc: 'SDM / Human Resource' },
    { class: 'fa-solid fa-cube', name: 'Cube', cat: 'bisnis', desc: 'Fitur Sistem / Modul' }
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
        card.onclick = () => selectIconFromModal(item.class);

        card.innerHTML = `
            <div class="ip-icon-preview">
                <i class="${item.class}"></i>
            </div>
            <div style="width: 100%;">
                <div class="ip-name">${item.name}</div>
                <div class="ip-class">${item.class}</div>
                <div class="ip-desc">${item.desc}</div>
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

        const matchesCat = (currentModalCat === 'all' || itemCat === currentModalCat);
        const matchesSearch = (!query || name.includes(query) || cls.includes(query));

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

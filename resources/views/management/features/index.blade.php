@extends('layouts.app')

@section('title', 'Management Fitur')

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    .feature-mgmt-scope {
        font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        letter-spacing: -0.011em;
    }
    .feature-mgmt-scope i,
    .feature-mgmt-scope .fas,
    .feature-mgmt-scope .far,
    .feature-mgmt-scope .fab,
    .feature-mgmt-scope .fa,
    .feature-mgmt-scope [class*="fa-"] {
        font-family: "Font Awesome 6 Free", "Font Awesome 5 Free", "FontAwesome" !important;
    }
    .sortable-ghost {
        opacity: 0.35;
    }
    .sortable-chosen {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
    }
</style>
@endsection

@section('content')
<div class="main-content feature-mgmt-scope overflow-y-auto" style="height: 100vh;">
    <div class="container mx-auto px-4 py-6" style="max-width: 1280px;">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 gap-3">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2" style="letter-spacing: -0.02em;">
                    <i class="fas fa-folder-tree text-green-600"></i> Management Fitur
                </h1>
                <p class="text-gray-500 text-xs mt-0.5 font-normal">Pengelolaan hirarki menu, slug akses, dan urutan tampilan (Drag & Drop).</p>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <button id="btnSaveOrder" onclick="saveNewOrder()" disabled
                    class="font-semibold py-1.5 px-3.5 rounded-lg shadow-sm transition duration-200 flex items-center gap-1.5 text-xs cursor-not-allowed opacity-75"
                    style="background-color: #e5e7eb; color: #9ca3af; border: 1px solid #d1d5db;">
                    <i class="fas fa-save"></i> <span>Simpan Perubahan Urutan</span>
                </button>
                <a href="{{ route('management.features.export') }}"
                    class="font-semibold py-1.5 px-3.5 rounded-lg shadow-sm transition flex items-center gap-1.5 text-xs"
                    style="background-color: #059669; color: #ffffff;">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
                <a href="{{ route('management.features.create') }}"
                    class="font-semibold py-1.5 px-3.5 rounded-lg shadow-sm transition flex items-center gap-1.5 text-xs"
                    style="background-color: #166534; color: #ffffff;">
                    <i class="fas fa-plus"></i> Tambah Fitur
                </a>
            </div>
        </div>

        <!-- Alert Notification -->
        @if ($errors->any())
            <div class="p-3 mb-4 rounded-lg shadow-sm text-xs" style="background-color: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b;">
                <p class="font-semibold mb-1">Terjadi Kesalahan:</p>
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="p-3 mb-4 rounded-lg shadow-sm flex items-center justify-between text-xs" style="background-color: #f0fdf4; border-left: 4px solid #22c55e; color: #166534;">
                <div class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-sm" style="color: #16a34a;"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Floating Unsaved Changes Notification -->
        <div id="unsavedBanner" class="hidden p-3 rounded-lg mb-4 shadow-sm flex items-center justify-between animate-fade-in text-xs"
             style="background-color: #fffbeb; border: 1px solid #fde68a; color: #92400e;">
            <div class="flex items-center gap-2 font-medium">
                <i class="fas fa-exclamation-triangle text-sm" style="color: #d97706;"></i>
                <span>Ada perubahan posisi menu yang belum disimpan. Klik <strong>"Simpan Perubahan Urutan"</strong> untuk menerapkan ke database.</span>
            </div>
            <button onclick="saveNewOrder()" class="text-[11px] font-semibold px-3 py-1 rounded transition shadow" style="background-color: #d97706; color: #ffffff;">
                Simpan Sekarang
            </button>
        </div>

        <!-- Filter & Search Controls Bar -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3 mb-4">
            <div class="flex flex-col md:flex-row gap-3 items-center justify-between">
                <div class="relative w-full md:w-80">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-search text-gray-400 text-xs"></i>
                    </span>
                    <input type="text" id="featureSearch" placeholder="Cari nama fitur, slug, rute..."
                        class="w-full pl-9 pr-3 py-1.5 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500 text-gray-800 text-xs">
                </div>
                <div class="flex items-center gap-2 w-full md:w-auto">
                    <button onclick="expandAll()" class="text-xs font-medium py-1.5 px-3 rounded-md border transition flex items-center gap-1.5"
                            style="background-color: #f9fafb; color: #374151; border-color: #d1d5db;">
                        <i class="fas fa-folder-open text-gray-400 text-xs"></i> Expand All
                    </button>
                    <button onclick="collapseAll()" class="text-xs font-medium py-1.5 px-3 rounded-md border transition flex items-center gap-1.5"
                            style="background-color: #f9fafb; color: #374151; border-color: #d1d5db;">
                        <i class="fas fa-folder text-gray-400 text-xs"></i> Collapse All
                    </button>
                </div>
            </div>
        </div>

        <!-- Accordion Tree View Container -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 min-h-[350px]">
            <div id="parentSortableList" class="space-y-2">
                @forelse($features as $feature)
                    <div class="parent-card bg-white border border-gray-200 rounded-lg shadow-2xs hover:border-green-400 transition overflow-hidden"
                         data-id="{{ $feature->id }}"
                         data-search-text="{{ strtolower($feature->name . ' ' . $feature->slug . ' ' . ($feature->url ?? '')) }}">
                        
                        <!-- Parent Item Row Header -->
                        <div class="py-2 px-3 bg-gray-50/80 hover:bg-green-50/30 transition flex flex-col md:flex-row md:items-center justify-between gap-2 border-b border-gray-100">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <!-- Drag Handle -->
                                <span class="drag-handle-parent cursor-grab px-0.5 text-gray-300 hover:text-gray-600 transition flex-shrink-0" title="Geser urutan menu">
                                    <i class="fas fa-grip-vertical text-xs"></i>
                                </span>

                                <!-- Expand Toggle Arrow -->
                                @if($feature->allChildren->isNotEmpty())
                                    <button type="button" onclick="toggleParentBranch({{ $feature->id }}, event)" 
                                            class="focus:outline-none p-0.5 text-gray-400 hover:text-green-700 transition flex-shrink-0" id="arrow-btn-{{ $feature->id }}">
                                        <i class="fas fa-chevron-down text-xs transition-transform duration-150" id="arrow-icon-{{ $feature->id }}"></i>
                                    </button>
                                @else
                                    <span class="w-4 text-center text-gray-300 text-[10px] flex-shrink-0">•</span>
                                @endif

                                <!-- Icon Badge -->
                                <div class="w-7 h-7 rounded-md flex items-center justify-center flex-shrink-0 shadow-2xs"
                                     style="background-color: #dcfce7; color: #15803d;">
                                    <i class="{{ $feature->icon ?? 'fa-solid fa-folder' }} text-xs"></i>
                                </div>

                                <!-- Feature Details -->
                                <div class="min-w-0 flex-1">
                                    <div class="font-semibold text-gray-800 text-xs truncate" style="letter-spacing: -0.01em;">
                                        {{ $feature->name }}
                                    </div>
                                    <div class="flex items-center gap-1.5 mt-0.5 flex-wrap">
                                        <span class="text-[8.5px] font-normal px-1 py-[1px] rounded border flex-shrink-0 leading-none"
                                              style="background-color: #f3f4f6; color: #6b7280; border-color: #e5e7eb;">
                                            {{ $feature->slug }}
                                        </span>
                                        @if($feature->url)
                                            <span class="text-[8.5px] text-gray-400 truncate max-w-[220px] leading-none" title="{{ $feature->url }}">
                                                <i class="fas fa-link text-[7.5px] text-gray-300 mr-0.5"></i>{{ $feature->url }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Right Controls & Badges (Compact Non-wrapping) -->
                            <div class="flex items-center gap-2 shrink-0 self-end md:self-auto flex-nowrap">
                                <!-- Status Badges -->
                                <div class="flex items-center gap-1 flex-nowrap">
                                    <span class="text-[10px] font-medium px-1.5 py-0.5 rounded border"
                                          style="background-color: #f3f4f6; color: #4b5563; border-color: #e5e7eb;" title="Urutan Posisi">
                                        #<span class="order-badge-parent">{{ $feature->sort_order }}</span>
                                    </span>
                                    <span class="text-[10px] font-medium px-1.5 py-0.5 rounded border"
                                          style="background-color: #faf5ff; color: #7e22ce; border-color: #f3e8ff;" title="Jumlah Sub-Menu">
                                        {{ $feature->allChildren->count() }} sub
                                    </span>
                                    @if($feature->is_sidebar)
                                        <span class="text-[10px] font-medium px-1.5 py-0.5 rounded border"
                                              style="background-color: #f0fdf4; color: #166534; border-color: #bbf7d0;" title="Tampil di Sidebar">
                                            Sidebar
                                        </span>
                                    @else
                                        <span class="text-[10px] font-medium px-1.5 py-0.5 rounded border"
                                              style="background-color: #f9fafb; color: #6b7280; border-color: #e5e7eb;" title="Hidden dari Sidebar">
                                            Hidden
                                        </span>
                                    @endif
                                    @if($feature->is_active)
                                        <span class="text-[10px] font-medium px-1.5 py-0.5 rounded"
                                              style="background-color: #d1fae5; color: #065f46;">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="text-[10px] font-medium px-1.5 py-0.5 rounded"
                                              style="background-color: #fee2e2; color: #991b1b;">
                                            Nonaktif
                                        </span>
                                    @endif
                                </div>

                                <!-- Action Buttons (Sleek Icon Buttons) -->
                                <div class="flex items-center gap-1 flex-nowrap ml-1">
                                    <a href="{{ route('management.features.create', ['parent_id' => $feature->id]) }}"
                                       title="Tambah Sub-Menu"
                                       class="w-6 h-6 rounded border transition flex items-center justify-center"
                                       style="background-color: #f0fdf4; color: #15803d; border-color: #bbf7d0;">
                                        <i class="fas fa-plus text-[10px]"></i>
                                    </a>
                                    <a href="{{ route('management.features.edit', $feature) }}"
                                       title="Edit Fitur"
                                       class="w-6 h-6 rounded border transition flex items-center justify-center"
                                       style="background-color: #eff6ff; color: #1d4ed8; border-color: #bfdbfe;">
                                        <i class="fas fa-edit text-[10px]"></i>
                                    </a>
                                    <form method="POST" action="{{ route('management.features.destroy', $feature) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                title="Hapus Fitur"
                                                class="w-6 h-6 rounded border transition flex items-center justify-center"
                                                style="background-color: #fef2f2; color: #b91c1c; border-color: #fecaca;"
                                                onclick="return confirm('Hapus fitur {{ $feature->name }}? Sub-menu yang berada di bawahnya juga perlu diperhatikan.')">
                                            <i class="fas fa-trash-alt text-[10px]"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Sub-menu / Child Container -->
                        <div id="child-container-{{ $feature->id }}" class="child-sortable-list py-2 px-3 bg-gray-50/40 space-y-1.5 border-t border-gray-100 min-h-[30px]">
                            @forelse($feature->allChildren as $child)
                                <div class="child-card bg-white border border-gray-200 rounded-md py-1.5 px-2.5 hover:border-blue-300 transition flex flex-col md:flex-row md:items-center justify-between gap-2 ml-4 md:ml-6"
                                     data-id="{{ $child->id }}"
                                     data-search-text="{{ strtolower($child->name . ' ' . $child->slug . ' ' . ($child->url ?? '')) }}">
                                    
                                    <div class="flex items-center gap-2 min-w-0">
                                        <!-- Child Drag Handle -->
                                        <span class="drag-handle-child cursor-grab px-0.5 text-gray-300 hover:text-gray-600 transition flex-shrink-0" title="Geser sub-menu">
                                            <i class="fas fa-grip-vertical text-[11px]"></i>
                                        </span>

                                        <!-- Child Icon -->
                                        <div class="w-5 h-5 rounded flex items-center justify-center flex-shrink-0"
                                             style="background-color: #eff6ff; color: #2563eb;">
                                            <i class="{{ $child->icon ?? 'fa-solid fa-cube' }} text-[9px]"></i>
                                        </div>

                                        <!-- Child Details -->
                                        <div class="min-w-0 flex-1">
                                            <div class="font-medium text-gray-800 text-[11.5px] truncate">
                                                {{ $child->name }}
                                            </div>
                                            <div class="flex items-center gap-1.5 mt-0.5 flex-wrap">
                                                <span class="text-[8px] font-normal px-1 py-[1px] rounded border flex-shrink-0 leading-none"
                                                      style="background-color: #f9fafb; color: #6b7280; border-color: #e5e7eb;">
                                                    {{ $child->slug }}
                                                </span>
                                                @if($child->url)
                                                    <span class="text-[8px] text-gray-400 truncate max-w-[180px] leading-none" title="{{ $child->url }}">
                                                        <i class="fas fa-link text-[7.5px] text-gray-300 mr-0.5"></i>{{ $child->url }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Child Controls & Badges -->
                                    <div class="flex items-center gap-1.5 shrink-0 self-end md:self-auto flex-nowrap">
                                        <div class="flex items-center gap-1 flex-nowrap">
                                            <span class="text-[9px] font-medium px-1.5 py-0.2 rounded"
                                                  style="background-color: #f3f4f6; color: #4b5563;" title="Urutan Sub-Menu">
                                                #<span class="order-badge-child">{{ $child->sort_order }}</span>
                                            </span>
                                            @if($child->is_sidebar)
                                                <span class="text-[9px] font-medium px-1.5 py-0.2 rounded"
                                                      style="background-color: #f0fdf4; color: #166534;">
                                                    Sidebar
                                                </span>
                                            @endif
                                            @if(!$child->is_active)
                                                <span class="text-[9px] font-medium px-1.5 py-0.2 rounded"
                                                      style="background-color: #fee2e2; color: #991b1b;">
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </div>

                                        <div class="flex items-center gap-1 flex-nowrap ml-1">
                                            <a href="{{ route('management.features.edit', $child) }}"
                                               title="Edit Sub-Menu"
                                               class="w-5 h-5 rounded border transition flex items-center justify-center"
                                               style="background-color: #eff6ff; color: #1d4ed8; border-color: #bfdbfe;">
                                                <i class="fas fa-edit text-[9px]"></i>
                                            </a>
                                            <form method="POST" action="{{ route('management.features.destroy', $child) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        title="Hapus Sub-Menu"
                                                        class="w-5 h-5 rounded border transition flex items-center justify-center"
                                                        style="background-color: #fef2f2; color: #b91c1c; border-color: #fecaca;"
                                                        onclick="return confirm('Hapus sub-menu {{ $child->name }}?')">
                                                    <i class="fas fa-trash-alt text-[9px]"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-[11px] text-gray-400 italic py-1 ml-4 empty-child-notice font-normal">
                                    Belum ada sub-menu di bawah fitur ini.
                                </div>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-2 text-gray-300"></i>
                        <p class="font-medium text-sm">Belum ada fitur yang terdaftar.</p>
                        <a href="{{ route('management.features.create') }}" class="mt-2 inline-block text-xs font-semibold hover:underline" style="color: #16a34a;">
                            + Tambah Fitur Pertama
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- SortableJS Library -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
    let hasUnsavedChanges = false;

    document.addEventListener('DOMContentLoaded', function () {
        initDragAndDrop();
        initSearchFilter();
    });

    function initDragAndDrop() {
        const parentListEl = document.getElementById('parentSortableList');
        if (!parentListEl) return;

        // Sortable for Parent items
        new Sortable(parentListEl, {
            animation: 150,
            handle: '.drag-handle-parent',
            ghostClass: 'bg-green-50',
            chosenClass: 'border-green-400',
            onEnd: function () {
                markAsUnsaved();
                updateOrderBadges();
            }
        });

        // Sortable for Child items (supports drag between parents)
        const childLists = document.querySelectorAll('.child-sortable-list');
        childLists.forEach(childListEl => {
            new Sortable(childListEl, {
                group: 'feature-children',
                animation: 150,
                handle: '.drag-handle-child',
                ghostClass: 'bg-blue-50',
                chosenClass: 'border-blue-400',
                onEnd: function () {
                    markAsUnsaved();
                    updateOrderBadges();
                }
            });
        });
    }

    function markAsUnsaved() {
        hasUnsavedChanges = true;
        const btn = document.getElementById('btnSaveOrder');
        const banner = document.getElementById('unsavedBanner');

        if (btn) {
            btn.disabled = false;
            btn.classList.remove('cursor-not-allowed', 'opacity-75');
            btn.style.backgroundColor = '#d97706';
            btn.style.color = '#ffffff';
            btn.style.borderColor = '#b45309';
            btn.classList.add('shadow-sm');
        }
        if (banner) {
            banner.classList.remove('hidden');
        }
    }

    function markAsSaved() {
        hasUnsavedChanges = false;
        const btn = document.getElementById('btnSaveOrder');
        const banner = document.getElementById('unsavedBanner');

        if (btn) {
            btn.disabled = true;
            btn.classList.add('cursor-not-allowed', 'opacity-75');
            btn.style.backgroundColor = '#e5e7eb';
            btn.style.color = '#9ca3af';
            btn.style.borderColor = '#d1d5db';
        }
        if (banner) {
            banner.classList.add('hidden');
        }
    }

    function updateOrderBadges() {
        const parents = document.querySelectorAll('.parent-card');
        parents.forEach((parent, pIndex) => {
            const pBadge = parent.querySelector('.order-badge-parent');
            if (pBadge) pBadge.textContent = pIndex + 1;

            const children = parent.querySelectorAll('.child-card');
            children.forEach((child, cIndex) => {
                const cBadge = child.querySelector('.order-badge-child');
                if (cBadge) cBadge.textContent = cIndex + 1;
            });
        });
    }

    async function saveNewOrder() {
        if (!hasUnsavedChanges) return;

        const parentCards = document.querySelectorAll('#parentSortableList > .parent-card');
        const treeData = [];

        parentCards.forEach((parentEl, pIndex) => {
            const parentId = parseInt(parentEl.getAttribute('data-id'));
            const childCards = parentEl.querySelectorAll('.child-card');
            const children = [];

            childCards.forEach((childEl, cIndex) => {
                children.push({
                    id: parseInt(childEl.getAttribute('data-id')),
                    sort_order: cIndex + 1
                });
            });

            treeData.push({
                id: parentId,
                sort_order: pIndex + 1,
                children: children
            });
        });

        const btn = document.getElementById('btnSaveOrder');
        const originalBtnText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...';
        btn.disabled = true;

        try {
            const response = await fetch('{{ route("management.features.reorder") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ tree: treeData })
            });

            const data = await response.json();

            if (response.ok && data.status === 'success') {
                markAsSaved();
                alert(data.message || 'Urutan fitur berhasil disimpan!');
            } else {
                throw new Error(data.message || 'Terjadi kesalahan saat menyimpan urutan.');
            }
        } catch (error) {
            alert('Gagal menyimpan: ' + error.message);
        } finally {
            btn.innerHTML = originalBtnText;
        }
    }

    function toggleParentBranch(parentId, event) {
        if (event) event.stopPropagation();

        const container = document.getElementById('child-container-' + parentId);
        const icon = document.getElementById('arrow-icon-' + parentId);

        if (!container) return;

        const isHidden = (container.style.display === 'none' || container.classList.contains('hidden'));

        if (isHidden) {
            container.style.display = 'block';
            container.classList.remove('hidden');
            if (icon) icon.style.transform = 'rotate(0deg)';
        } else {
            container.style.display = 'none';
            container.classList.add('hidden');
            if (icon) icon.style.transform = 'rotate(-90deg)';
        }
    }

    function expandAll() {
        document.querySelectorAll('.child-sortable-list').forEach(c => {
            c.style.display = 'block';
            c.classList.remove('hidden');
        });
        document.querySelectorAll('[id^="arrow-icon-"]').forEach(icon => {
            icon.style.transform = 'rotate(0deg)';
        });
    }

    function collapseAll() {
        document.querySelectorAll('.child-sortable-list').forEach(c => {
            c.style.display = 'none';
            c.classList.add('hidden');
        });
        document.querySelectorAll('[id^="arrow-icon-"]').forEach(icon => {
            icon.style.transform = 'rotate(-90deg)';
        });
    }

    function initSearchFilter() {
        const searchInput = document.getElementById('featureSearch');
        if (!searchInput) return;

        searchInput.addEventListener('input', function () {
            const query = this.value.toLowerCase().trim();

            document.querySelectorAll('.parent-card').forEach(parentCard => {
                const parentSearchText = parentCard.getAttribute('data-search-text') || '';
                let hasMatchingChild = false;

                const childCards = parentCard.querySelectorAll('.child-card');
                childCards.forEach(childCard => {
                    const childSearchText = childCard.getAttribute('data-search-text') || '';
                    if (query === '' || childSearchText.includes(query)) {
                        childCard.classList.remove('hidden');
                        childCard.style.display = '';
                        hasMatchingChild = true;
                    } else {
                        childCard.classList.add('hidden');
                        childCard.style.display = 'none';
                    }
                });

                if (query === '' || parentSearchText.includes(query) || hasMatchingChild) {
                    parentCard.style.display = '';
                    parentCard.classList.remove('hidden');
                    if (hasMatchingChild && query !== '') {
                        const parentId = parentCard.getAttribute('data-id');
                        const container = document.getElementById('child-container-' + parentId);
                        if (container) {
                            container.style.display = 'block';
                            container.classList.remove('hidden');
                        }
                    }
                } else {
                    parentCard.style.display = 'none';
                    parentCard.classList.add('hidden');
                }
            });
        });
    }

    // Alert user if navigating away with unsaved changes
    window.addEventListener('beforeunload', function (e) {
        if (hasUnsavedChanges) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
</script>
@endsection
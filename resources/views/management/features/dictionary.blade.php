@extends('layouts.app')

@section('title', 'Kamus Fitur')

@section('content')
    <div class="main-content overflow-y-auto" style="height: 100vh;">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-folder-tree text-green-600"></i> Kamus Fitur (Struktur Menu)
                    </h1>
                    <p class="text-gray-600 mt-2">Daftar hirarki menu, sub-menu, sort order, dan slug hak akses untuk rujukan konfigurasi.</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('management.features.index') }}"
                        class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2.5 px-5 rounded-lg shadow-md transition flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i> Kembali ke Manajemen Fitur
                    </a>
                </div>
            </div>

            <!-- Main Layout Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Left Panel: Tree Structure (7 Cols) -->
                <div class="lg:col-span-7 bg-white rounded-xl shadow-md border border-gray-100 p-6 flex flex-col">
                    <!-- Search & Controls -->
                    <div class="mb-6 flex flex-col md:flex-row gap-4 items-center justify-between">
                        <div class="relative w-full md:w-80">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </span>
                            <input type="text" id="treeSearch" placeholder="Cari fitur, slug, url..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-gray-900 text-sm">
                        </div>
                        <div class="flex gap-2 w-full md:w-auto">
                            <button onclick="expandAll()" class="flex-1 md:flex-initial text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-3 rounded transition border border-gray-300">
                                Expand All
                            </button>
                            <button onclick="collapseAll()" class="flex-1 md:flex-initial text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-3 rounded transition border border-gray-300">
                                Collapse All
                            </button>
                        </div>
                    </div>

                    <!-- Tree Container -->
                    <div class="overflow-y-auto max-h-[600px] pr-2 tree-scroll">
                        <ul class="tree-root space-y-3">
                            @forelse($features as $feature)
                                <li class="parent-node" data-search-text="{{ strtolower($feature->name . ' ' . $feature->slug . ' ' . $feature->url) }}">
                                    <!-- Parent Item Row -->
                                    <div class="flex items-center justify-between p-3 rounded-lg hover:bg-green-50/50 transition cursor-pointer border border-gray-100 hover:border-green-200 shadow-sm relative node-item"
                                         data-id="{{ $feature->id }}"
                                         data-slug="{{ $feature->slug }}"
                                         data-name="{{ $feature->name }}"
                                         data-parent-name="None (Menu Utama)"
                                         data-icon="{{ $feature->icon ?? 'fa-solid fa-cube' }}"
                                         data-url="{{ $feature->url ?? '-' }}"
                                         data-sort-order="{{ $feature->sort_order }}"
                                         data-is-sidebar="{{ $feature->is_sidebar ? 'Tampil' : 'Tersembunyi' }}"
                                         data-is-active="{{ $feature->is_active ? 'Aktif' : 'Nonaktif' }}"
                                         data-description="{{ $feature->description ?? 'Tidak ada deskripsi.' }}"
                                         onclick="viewDetails(this, event)">
                                        <div class="flex items-center gap-3">
                                            @if($feature->children->isNotEmpty())
                                                <button onclick="toggleBranch('{{ $feature->slug }}Sub', event)" class="focus:outline-none p-1 text-gray-400 hover:text-green-600 transition" id="arrow-{{ $feature->slug }}">
                                                    <i class="fas fa-chevron-down text-sm transition-transform duration-200" id="icon-arrow-{{ $feature->slug }}"></i>
                                                </button>
                                            @else
                                                <span class="w-7 h-7"></span>
                                            @endif
                                            <div class="w-8 h-8 rounded-lg bg-green-100 text-green-700 flex items-center justify-center">
                                                <i class="{{ $feature->icon ?? 'fa-solid fa-folder' }} text-sm"></i>
                                            </div>
                                            <div>
                                                <span class="font-bold text-gray-800 text-sm block">{{ $feature->name }}</span>
                                                <span class="text-xs font-mono text-gray-500">{{ $feature->slug }}</span>
                                            </div>
                                        </div>

                                        <!-- Badges/Sort Order -->
                                        <div class="flex items-center gap-2">
                                            <span class="bg-gray-100 text-gray-700 text-[10px] font-bold px-2 py-0.5 rounded-full border border-gray-200">
                                                Order: {{ $feature->sort_order }}
                                            </span>
                                            @if(!$feature->is_active)
                                                <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Submenu / Children -->
                                    @if($feature->children->isNotEmpty())
                                        <ul class="pl-8 mt-2 space-y-2 border-l border-dashed border-gray-200 ml-4 branch-list" id="{{ $feature->slug }}Sub">
                                            @foreach($feature->children as $child)
                                                <li class="child-node" data-search-text="{{ strtolower($child->name . ' ' . $child->slug . ' ' . $child->url) }}">
                                                    <div class="flex items-center justify-between p-2.5 rounded-lg hover:bg-blue-50/50 transition cursor-pointer border border-transparent hover:border-blue-200 node-item"
                                                         data-id="{{ $child->id }}"
                                                         data-slug="{{ $child->slug }}"
                                                         data-name="{{ $child->name }}"
                                                         data-parent-name="{{ $feature->name }}"
                                                         data-icon="{{ $child->icon ?? 'fa-solid fa-cube' }}"
                                                         data-url="{{ $child->url ?? '-' }}"
                                                         data-sort-order="{{ $child->sort_order }}"
                                                         data-is-sidebar="{{ $child->is_sidebar ? 'Tampil' : 'Tersembunyi' }}"
                                                         data-is-active="{{ $child->is_active ? 'Aktif' : 'Nonaktif' }}"
                                                         data-description="{{ $child->description ?? 'Tidak ada deskripsi.' }}"
                                                         onclick="viewDetails(this, event)">
                                                        <div class="flex items-center gap-3">
                                                            <div class="w-7 h-7 rounded bg-blue-50 text-blue-600 flex items-center justify-center">
                                                                <i class="{{ $child->icon ?? 'fa-solid fa-link' }} text-xs"></i>
                                                            </div>
                                                            <div>
                                                                <span class="font-semibold text-gray-700 text-sm block">{{ $child->name }}</span>
                                                                <span class="text-xs font-mono text-gray-400">{{ $child->slug }}</span>
                                                            </div>
                                                        </div>

                                                        <!-- Badges/Sort Order -->
                                                        <div class="flex items-center gap-2">
                                                            <span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-2 py-0.5 rounded-full border border-gray-200">
                                                                Order: {{ $child->sort_order }}
                                                            </span>
                                                            @if(!$child->is_active)
                                                                <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                                                    Nonaktif
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @empty
                                <div class="text-center py-12 text-gray-400">
                                    <i class="fa-solid fa-ban text-4xl mb-3"></i>
                                    <p>Tidak ada fitur terdaftar.</p>
                                </div>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Right Panel: Detailed View (5 Cols) -->
                <div class="lg:col-span-5">
                    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 sticky top-8" id="detailCard">
                        <!-- Placeholder State -->
                        <div id="detailPlaceholder" class="text-center py-16">
                            <div class="w-16 h-16 rounded-full bg-green-50 text-green-600 flex items-center justify-center mx-auto mb-4 border border-green-100">
                                <i class="fa-solid fa-hand-pointer text-2xl animate-bounce"></i>
                            </div>
                            <h3 class="font-bold text-gray-700 text-lg">Pilih Item Fitur</h3>
                            <p class="text-gray-400 text-sm mt-1 max-w-xs mx-auto">Klik salah satu menu atau sub-menu di sebelah kiri untuk melihat rincian informasi teknis lengkap.</p>
                        </div>

                        <!-- Content State (Hidden Initially) -->
                        <div id="detailContent" class="hidden space-y-6">
                            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                                <div class="flex items-center gap-3">
                                    <div id="detailHeaderIcon" class="w-12 h-12 rounded-xl flex items-center justify-center text-lg shadow-sm">
                                        <!-- Dynamic Icon -->
                                    </div>
                                    <div>
                                        <h3 id="detailName" class="font-extrabold text-gray-800 text-lg"></h3>
                                        <span id="detailParentName" class="text-xs text-gray-500 font-semibold"></span>
                                    </div>
                                </div>
                                <span id="detailIsActive" class="text-xs font-bold px-3 py-1 rounded-full shadow-xs">
                                    <!-- Active/Nonactive -->
                                </span>
                            </div>

                            <!-- Copyable Slug block -->
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Slug Akses</label>
                                <div class="flex items-center gap-2 bg-gray-50 p-2.5 rounded-lg border border-gray-200">
                                    <code id="detailSlug" class="text-sm font-mono text-blue-700 font-semibold select-all break-all flex-1"></code>
                                    <button onclick="copySlugToClipboard()" class="text-gray-500 hover:text-green-600 p-1.5 rounded-md hover:bg-gray-100 transition" title="Salin Slug">
                                        <i class="fa-regular fa-copy"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Details Table -->
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-gray-50/70 p-3 rounded-lg border border-gray-100">
                                        <span class="block text-[11px] font-bold text-gray-400 uppercase">Sort Order</span>
                                        <span id="detailSortOrder" class="text-sm font-extrabold text-gray-700"></span>
                                    </div>
                                    <div class="bg-gray-50/70 p-3 rounded-lg border border-gray-100">
                                        <span class="block text-[11px] font-bold text-gray-400 uppercase">Tampil Sidebar</span>
                                        <span id="detailIsSidebar" class="text-sm font-extrabold text-gray-700"></span>
                                    </div>
                                </div>

                                <div class="bg-gray-50/70 p-3.5 rounded-lg border border-gray-100">
                                    <span class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Rute URL / Tautan</span>
                                    <div class="flex items-center gap-2 overflow-hidden">
                                        <i class="fa-solid fa-link text-xs text-gray-400"></i>
                                        <span id="detailUrl" class="text-sm font-semibold text-gray-700 font-mono truncate flex-1"></span>
                                    </div>
                                </div>

                                <div class="bg-gray-50/70 p-3.5 rounded-lg border border-gray-100">
                                    <span class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Ikon (FontAwesome)</span>
                                    <div class="flex items-center gap-2">
                                        <i id="detailIconPreview" class="text-gray-600 text-sm"></i>
                                        <span id="detailIconName" class="text-sm font-medium text-gray-700 font-mono"></span>
                                    </div>
                                </div>

                                <div class="bg-gray-50/70 p-3.5 rounded-lg border border-gray-100">
                                    <span class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Deskripsi</span>
                                    <p id="detailDescription" class="text-sm text-gray-600 leading-relaxed"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Clipboard alert container -->
    <div id="copyToast" class="fixed bottom-5 right-5 bg-gray-900 text-white text-sm px-4 py-2.5 rounded-lg shadow-xl flex items-center gap-2 transform translate-y-20 opacity-0 transition-all duration-300 z-50">
        <i class="fas fa-check-circle text-green-400"></i>
        <span>Slug berhasil disalin ke clipboard!</span>
    </div>

    <style>
        .tree-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .tree-scroll::-webkit-scrollbar-track {
            background: #F9FAFB;
        }
        .tree-scroll::-webkit-scrollbar-thumb {
            background: #E5E7EB;
            border-radius: 4px;
        }
        .tree-scroll::-webkit-scrollbar-thumb:hover {
            background: #D1D5DB;
        }
        .branch-list {
            transition: max-height 0.3s ease-out;
            overflow: hidden;
        }
        .node-item.selected {
            background-color: #ECFDF5;
            border-color: #34D399;
        }
    </style>

    <script>
        // Track the current selected element for highlight styling
        let currentSelectedNode = null;

        // Toggle sub branches collapse/expand
        function toggleBranch(subId, event) {
            event.stopPropagation();
            const branch = document.getElementById(subId);
            const arrowIcon = document.getElementById('icon-arrow-' + subId.replace('Sub', ''));
            
            if (branch.classList.contains('hidden')) {
                branch.classList.remove('hidden');
                if (arrowIcon) arrowIcon.classList.remove('-rotate-90');
            } else {
                branch.classList.add('hidden');
                if (arrowIcon) arrowIcon.classList.add('-rotate-90');
            }
        }

        // Expand all branches
        function expandAll() {
            document.querySelectorAll('.branch-list').forEach(branch => {
                branch.classList.remove('hidden');
            });
            document.querySelectorAll('.fa-chevron-down').forEach(arrow => {
                arrow.classList.remove('-rotate-90');
            });
        }

        // Collapse all branches
        function collapseAll() {
            document.querySelectorAll('.branch-list').forEach(branch => {
                branch.classList.add('hidden');
            });
            document.querySelectorAll('.fa-chevron-down').forEach(arrow => {
                arrow.classList.add('-rotate-90');
            });
        }

        // Display node metadata details on the right panel
        function viewDetails(element, event) {
            event.stopPropagation();

            // Clear previous highlight
            if (currentSelectedNode) {
                currentSelectedNode.classList.remove('selected');
            }

            // Apply new highlight
            currentSelectedNode = element;
            element.classList.add('selected');

            // Retrieve data attributes
            const name = element.getAttribute('data-name');
            const slug = element.getAttribute('data-slug');
            const parentName = element.getAttribute('data-parent-name');
            const icon = element.getAttribute('data-icon');
            const url = element.getAttribute('data-url');
            const sortOrder = element.getAttribute('data-sort-order');
            const isSidebar = element.getAttribute('data-is-sidebar');
            const isActive = element.getAttribute('data-is-active');
            const description = element.getAttribute('data-description');

            // Hide placeholder & show details content
            document.getElementById('detailPlaceholder').classList.add('hidden');
            document.getElementById('detailContent').classList.remove('hidden');

            // Set detail info
            document.getElementById('detailName').innerText = name;
            document.getElementById('detailParentName').innerText = parentName === 'None (Menu Utama)' ? parentName : 'Induk: ' + parentName;
            document.getElementById('detailSlug').innerText = slug;
            document.getElementById('detailSortOrder').innerText = sortOrder;
            document.getElementById('detailIsSidebar').innerText = isSidebar;
            document.getElementById('detailUrl').innerText = url;
            document.getElementById('detailIconName').innerText = icon;
            
            // Icon preview
            const iconPreview = document.getElementById('detailIconPreview');
            iconPreview.className = icon;
            
            // Icon backdrop color based on parenting
            const headerIconDiv = document.getElementById('detailHeaderIcon');
            headerIconDiv.innerHTML = `<i class="${icon}"></i>`;
            if (parentName === 'None (Menu Utama)') {
                headerIconDiv.className = 'w-12 h-12 rounded-xl flex items-center justify-center text-lg shadow-sm bg-green-100 text-green-700';
            } else {
                headerIconDiv.className = 'w-12 h-12 rounded-xl flex items-center justify-center text-lg shadow-sm bg-blue-100 text-blue-700';
            }

            // Description
            document.getElementById('detailDescription').innerText = description;

            // Status Badge
            const statusBadge = document.getElementById('detailIsActive');
            statusBadge.innerText = isActive;
            if (isActive === 'Aktif') {
                statusBadge.className = 'text-xs font-bold px-3 py-1 rounded-full shadow-xs bg-green-100 text-green-700 border border-green-200';
            } else {
                statusBadge.className = 'text-xs font-bold px-3 py-1 rounded-full shadow-xs bg-red-100 text-red-700 border border-red-200';
            }
        }

        // Copy Slug to clipboard
        function copySlugToClipboard() {
            const slugText = document.getElementById('detailSlug').innerText;
            if (!slugText) return;

            navigator.clipboard.writeText(slugText).then(() => {
                const toast = document.getElementById('copyToast');
                toast.classList.remove('translate-y-20', 'opacity-0');
                
                setTimeout(() => {
                    toast.classList.add('translate-y-20', 'opacity-0');
                }, 2000);
            });
        }

        // Tree Search functionality
        document.getElementById('treeSearch').addEventListener('input', function(e) {
            const keyword = e.target.value.toLowerCase().trim();
            
            if (keyword === '') {
                // Show everything and restore collapse states
                document.querySelectorAll('.parent-node').forEach(node => {
                    node.classList.remove('hidden');
                });
                document.querySelectorAll('.child-node').forEach(node => {
                    node.classList.remove('hidden');
                });
                return;
            }

            // Iterate parents
            document.querySelectorAll('.parent-node').forEach(parentNode => {
                const parentSearchText = parentNode.getAttribute('data-search-text');
                const isParentMatch = parentSearchText.includes(keyword);
                
                // Track if any of its children match
                let anyChildMatch = false;
                parentNode.querySelectorAll('.child-node').forEach(childNode => {
                    const childSearchText = childNode.getAttribute('data-search-text');
                    const isChildMatch = childSearchText.includes(keyword);
                    
                    if (isChildMatch) {
                        childNode.classList.remove('hidden');
                        anyChildMatch = true;
                    } else {
                        childNode.classList.add('hidden');
                    }
                });

                // Parent is shown if it matches OR any of its children match
                if (isParentMatch || anyChildMatch) {
                    parentNode.classList.remove('hidden');
                    // Automatically expand parent if search matches children
                    const submenu = parentNode.querySelector('.branch-list');
                    if (submenu) {
                        submenu.classList.remove('hidden');
                        const arrow = parentNode.querySelector('.fa-chevron-down');
                        if (arrow) arrow.classList.remove('-rotate-90');
                    }
                } else {
                    parentNode.classList.add('hidden');
                }
            });
        });
    </script>
@endsection

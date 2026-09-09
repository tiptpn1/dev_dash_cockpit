@extends('layouts.app')

@section('title', 'Manage User Access')

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    .access-edit-scope {
        font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        letter-spacing: -0.011em;
    }
    .access-edit-scope i,
    .access-edit-scope .fas,
    .access-edit-scope .far,
    .access-edit-scope .fab,
    .access-edit-scope .fa,
    .access-edit-scope [class*="fa-"] {
        font-family: "Font Awesome 6 Free", "Font Awesome 5 Free", "FontAwesome" !important;
    }
    .custom-scrollbar::-webkit-scrollbar {
        width: 5px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(209, 250, 229, 0.4);
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(16, 185, 129, 0.4);
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(5, 150, 105, 0.7);
    }
</style>
@endsection

@section('content')
<div class="main-content access-edit-scope overflow-y-auto" style="height: 100vh;">
    <div class="container mx-auto px-4 py-6" style="max-width: 1280px;">
        <!-- Header -->
        <div class="mb-4">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2" style="letter-spacing: -0.02em;">
                <i class="fas fa-key text-green-600"></i> Kelola Akses: <span class="text-green-700 font-semibold">{{ $user->username }}</span>
            </h1>
            <p class="text-gray-500 text-xs mt-0.5 font-normal">Tetapkan hak akses fitur untuk akun ini.</p>
        </div>

        <!-- Alert Messages -->
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

        <!-- Main Form Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Feature Selection -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-600 to-green-800"></div>
                    
                    <h2 class="text-sm font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2.5 flex items-center justify-between">
                        <span class="flex items-center gap-1.5">
                            <i class="fas fa-list-check text-green-600 text-xs"></i> Daftar Fitur Sistem
                        </span>
                        <span class="text-[11px] font-normal text-gray-400">Centang grup untuk memilih semua sub-menu</span>
                    </h2>

                    <form method="POST" action="{{ route('management.access.update', $user) }}">
                        @csrf
                        @method('PUT')

                        @php
                            $getGroupName = function($prefix) {
                                $specialNames = [
                                    'lm' => 'Laporan Manajemen (LM)',
                                    'gis' => 'Geographic Information System (GIS)',
                                    'mrc' => 'Management Review Committee (MRC)',
                                    'aigr1' => 'AIGR1',
                                    'hr' => 'Human Resource (HR)',
                                    'pica' => 'PICA (Problem Identification & Corrective Action)',
                                    'management' => 'System Management',
                                    'pemasaran' => 'Pemasaran Karet',
                                    'carbon' => 'Carbon Monitoring',
                                    'warehouse' => 'Warehouse Management',
                                    'skyview' => 'AGRO Skyview',
                                    'progress' => 'Capaian Progres',
                                ];
                                return $specialNames[strtolower($prefix)] ?? ucfirst(str_replace('_', ' ', $prefix));
                            };
                        @endphp

                        <div class="space-y-3">
                            @forelse($groupedFeatures as $prefix => $group)
                                <div class="bg-gray-50/60 border border-gray-200 rounded-lg overflow-hidden shadow-2xs hover:border-gray-300 transition">
                                    <!-- Group Header -->
                                    <div class="px-3.5 py-2 flex items-center justify-between text-white"
                                         style="background-color: #14532d;">
                                        <div class="flex items-center gap-2">
                                            <input
                                                type="checkbox"
                                                id="parent_{{ $prefix }}"
                                                data-prefix="{{ $prefix }}"
                                                class="parent-checkbox w-4 h-4 text-green-600 rounded border-gray-300 cursor-pointer focus:ring-green-500"
                                            >
                                            <label for="parent_{{ $prefix }}" class="font-bold text-xs cursor-pointer flex items-center gap-1.5 select-none">
                                                <i class="fa-solid fa-folder-open text-yellow-400 text-xs"></i>
                                                {{ $getGroupName($prefix) }}
                                            </label>
                                        </div>
                                        <span class="text-[8.5px] font-normal px-1.5 py-[1px] rounded border leading-none"
                                              style="background-color: rgba(255, 255, 255, 0.12); color: #dcfce7; border-color: rgba(255, 255, 255, 0.2);">
                                            @if($group['parent'])
                                                Menu Induk
                                            @else
                                                Grup Virtual
                                            @endif
                                        </span>
                                    </div>

                                    <!-- Group Children (Sub-Menus) -->
                                    <div class="p-2 bg-white divide-y divide-gray-50">
                                        @foreach($group['children'] as $child)
                                            <div class="flex items-center py-1.5 px-2 hover:bg-green-50/40 rounded transition">
                                                <span class="text-gray-300 font-mono text-[10px] mr-2 select-none">└─</span>
                                                
                                                <input
                                                    type="checkbox"
                                                    name="features[]"
                                                    value="{{ $child->id }}"
                                                    id="feature_{{ $child->id }}"
                                                    data-parent="{{ $prefix }}"
                                                    {{ $user->hasFeature($child->slug) ? 'checked' : '' }}
                                                    class="child-checkbox w-3.5 h-3.5 text-green-600 rounded border-gray-300 cursor-pointer focus:ring-green-500"
                                                >
                                                <label for="feature_{{ $child->id }}" class="flex-1 ml-2.5 cursor-pointer flex items-center justify-between gap-2 min-w-0">
                                                    <div class="min-w-0 flex-1">
                                                        @php
                                                            $childName = $child->name;
                                                            if (strpos($childName, ' - ') !== false) {
                                                                $childName = explode(' - ', $childName)[1];
                                                            }
                                                        @endphp
                                                        <div class="font-medium text-gray-800 text-xs truncate">{{ $childName }}</div>
                                                        <div class="text-[9.5px] font-normal text-gray-400 mt-0.2 truncate">{{ $child->slug }}</div>
                                                    </div>
                                                    <span class="text-[8px] font-normal px-1 py-[1px] rounded border flex-shrink-0 leading-none"
                                                          style="background-color: #f3f4f6; color: #6b7280; border-color: #e5e7eb;">
                                                        Sub Menu
                                                    </span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @empty
                                <div class="text-gray-500 text-center py-6 bg-gray-50 rounded-lg border border-dashed border-gray-200 text-xs">
                                    <i class="fas fa-inbox text-2xl mb-1 block opacity-50"></i>
                                    Belum ada fitur sistem.
                                </div>
                            @endforelse

                            <!-- Standalone Features Card -->
                            @if(!empty($standaloneFeatures))
                                <div class="bg-gray-50/60 border border-gray-200 rounded-lg overflow-hidden shadow-2xs">
                                    <div class="px-3.5 py-2 flex items-center justify-between text-white" style="background-color: #374151;">
                                        <label class="font-bold text-xs flex items-center gap-1.5 select-none">
                                            <i class="fa-solid fa-link text-blue-400 text-xs"></i>
                                            Fitur Mandiri & Eksternal (Direct Menus)
                                        </label>
                                        <span class="text-[8.5px] font-normal px-1.5 py-[1px] rounded border leading-none"
                                              style="background-color: rgba(255, 255, 255, 0.15); color: #f3f4f6; border-color: rgba(255, 255, 255, 0.25);">
                                            Mandiri
                                        </span>
                                    </div>
                                    <div class="p-3 bg-white grid grid-cols-1 md:grid-cols-2 gap-2">
                                        @foreach($standaloneFeatures as $feat)
                                            <div class="flex items-center p-2 border border-gray-200 rounded-md hover:bg-gray-50 transition">
                                                <input
                                                    type="checkbox"
                                                    name="features[]"
                                                    value="{{ $feat->id }}"
                                                    id="feature_{{ $feat->id }}"
                                                    {{ $user->hasFeature($feat->slug) ? 'checked' : '' }}
                                                    class="w-3.5 h-3.5 text-green-600 rounded border-gray-300 cursor-pointer focus:ring-green-500"
                                                >
                                                <label for="feature_{{ $feat->id }}" class="flex-1 ml-2.5 cursor-pointer min-w-0">
                                                    <div class="font-medium text-gray-800 text-xs truncate">{{ $feat->name }}</div>
                                                    <div class="text-[9.5px] font-normal text-gray-400 mt-0.2 truncate">{{ $feat->slug }}</div>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Buttons -->
                        <div class="mt-4 pt-3 border-t border-gray-100 flex gap-2">
                            <button type="submit" class="font-semibold py-1.5 px-4 rounded-lg shadow-sm transition flex items-center gap-1.5 text-xs" style="background-color: #166534; color: #ffffff;">
                                <i class="fas fa-save"></i> <span>Simpan Akses</span>
                            </button>
                            <a href="{{ route('management.access.index') }}" class="font-semibold py-1.5 px-4 rounded-lg border transition flex items-center gap-1.5 text-xs" style="background-color: #f3f4f6; color: #4b5563; border-color: #d1d5db;">
                                <i class="fas fa-times"></i> <span>Batal</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- User Info Sidebar -->
            <div class="lg:col-span-1 space-y-4">
                <!-- User Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <h3 class="text-xs font-bold text-gray-800 mb-3 border-b border-gray-100 pb-2 flex items-center gap-1.5">
                        <i class="fas fa-user-circle text-green-600 text-xs"></i> Informasi User
                    </h3>
                    <div class="space-y-2 text-xs">
                        <div class="bg-gray-50 p-2 rounded border border-gray-100">
                            <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Username</p>
                            <p class="font-semibold text-gray-800">{{ $user->username }}</p>
                        </div>
                        <div class="bg-gray-50 p-2 rounded border border-gray-100">
                            <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">NIK</p>
                            <p class="font-semibold text-gray-800">{{ $user->nik ?? '-' }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="bg-gray-50 p-2 rounded border border-gray-100">
                                <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Role</p>
                                <p class="font-semibold text-gray-800">{{ strtoupper($user->role ?? '-') }}</p>
                            </div>
                            <div class="bg-gray-50 p-2 rounded border border-gray-100">
                                <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Plant</p>
                                <p class="font-semibold text-gray-800">{{ $user->plant ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Current Access Summary -->
                <div class="bg-green-50/50 rounded-lg border border-green-200 p-4 shadow-2xs">
                    <h3 class="text-xs font-bold text-green-900 mb-3 border-b border-green-200/60 pb-2 flex items-center justify-between">
                        <span class="flex items-center gap-1.5">
                            <i class="fas fa-shield-alt text-green-600 text-xs"></i> Akses Aktif Saat Ini
                        </span>
                        <span class="text-[10px] font-bold text-green-900 bg-green-200/70 px-2 py-0.5 rounded border border-green-300/50">
                            {{ $user->features->count() }} fitur
                        </span>
                    </h3>
                    <div class="space-y-1.5 max-h-64 overflow-y-auto pr-1 custom-scrollbar text-xs">
                        @if($user->features->count() > 0)
                            @foreach($user->features as $feature)
                                <div class="flex justify-between items-center bg-white py-1 px-2 rounded border border-green-100 shadow-2xs">
                                    <span class="font-medium text-gray-800 truncate pr-2 text-xs">{{ $feature->name }}</span>
                                    <span class="text-[9.5px] font-normal text-gray-500 bg-gray-50 px-1.5 py-0.2 rounded border border-gray-200 flex-shrink-0">
                                        {{ $feature->slug }}
                                    </span>
                                </div>
                            @endforeach
                        @else
                            <p class="text-green-700 text-xs font-normal italic py-1"><i class="fas fa-info-circle mr-1"></i> Belum ada fitur yang ditetapkan.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // 1. When a parent checkbox changes
        $('.parent-checkbox').change(function() {
            var prefix = $(this).data('prefix');
            var isChecked = $(this).prop('checked');
            $('.child-checkbox[data-parent="' + prefix + '"]').prop('checked', isChecked);
        });

        // 2. When a child checkbox changes
        $('.child-checkbox').change(function() {
            var parentPrefix = $(this).data('parent');
            var siblingCheckedCount = $('.child-checkbox[data-parent="' + parentPrefix + '"]:checked').length;
            
            if (siblingCheckedCount > 0) {
                $('#parent_' + parentPrefix).prop('checked', true);
            } else {
                $('#parent_' + parentPrefix).prop('checked', false);
            }
        });

        // 3. Initialize: check parent if at least one child is checked
        $('.parent-checkbox').each(function() {
            var prefix = $(this).data('prefix');
            var checkedChildren = $('.child-checkbox[data-parent="' + prefix + '"]:checked').length;
            
            if (checkedChildren > 0) {
                $(this).prop('checked', true);
            }
        });
    });
</script>
@endsection

@extends('layouts.app')

@section('title', 'Manage User Access')

@section('content')
<div class="main-content overflow-y-auto" style="height: 100vh;">
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Manage Access: <span class="text-green-700">{{ $user->username }}</span></h1>
        <p class="text-gray-600">Assign features to this user</p>
    </div>

    <!-- Alert Messages -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li><i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Main Form -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Feature Selection -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-green-500 to-green-700"></div>
                
                <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b border-gray-100 pb-4">
                    <i class="fas fa-list-check text-green-600 mr-2"></i> Available Features
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

                    <div class="space-y-6">
                        @forelse($groupedFeatures as $prefix => $group)
                            <div class="bg-gray-50 border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition">
                                <!-- Group Header (Parent Feature or Virtual Group Header) -->
                                <div class="bg-gradient-to-r from-green-800 to-green-950 px-6 py-4 flex items-center justify-between text-white">
                                    <div class="flex items-center gap-3">
                                        @if($group['parent'])
                                            <input
                                                type="checkbox"
                                                name="features[]"
                                                value="{{ $group['parent']->id }}"
                                                id="parent_{{ $prefix }}"
                                                data-prefix="{{ $prefix }}"
                                                {{ in_array($group['parent']->id, $userFeatures) ? 'checked' : '' }}
                                                class="parent-checkbox w-5 h-5 text-green-600 rounded focus:ring-green-500 border-gray-300 cursor-pointer"
                                            >
                                        @else
                                            <input
                                                type="checkbox"
                                                id="parent_{{ $prefix }}"
                                                data-prefix="{{ $prefix }}"
                                                class="parent-checkbox w-5 h-5 text-green-600 rounded focus:ring-green-500 border-gray-300 cursor-pointer"
                                            >
                                        @endif
                                        <label for="parent_{{ $prefix }}" class="font-bold text-lg cursor-pointer flex items-center gap-2 select-none">
                                            <i class="fa-solid fa-folder-open text-yellow-400"></i>
                                            {{ $getGroupName($prefix) }}
                                        </label>
                                    </div>
                                    <span class="text-xs font-semibold bg-green-700/50 text-green-100 px-3 py-1 rounded-full border border-green-600/30">
                                        @if($group['parent'])
                                            MENU INDUK
                                        @else
                                            VIRTUAL GROUP
                                        @endif
                                    </span>
                                </div>

                                <!-- Group Children (Sub-Menus) -->
                                <div class="p-4 bg-white divide-y divide-gray-100">
                                    @foreach($group['children'] as $child)
                                        <div class="flex items-center py-3 pl-6 hover:bg-green-50/50 rounded-lg transition group">
                                            <!-- Tree structure line helper -->
                                            <span class="text-gray-300 font-mono mr-3 select-none">└─</span>
                                            
                                            <input
                                                type="checkbox"
                                                name="features[]"
                                                value="{{ $child->id }}"
                                                id="feature_{{ $child->id }}"
                                                data-parent="{{ $prefix }}"
                                                {{ in_array($child->id, $userFeatures) ? 'checked' : '' }}
                                                class="child-checkbox w-4 h-4 text-green-600 rounded focus:ring-green-500 border-gray-300 cursor-pointer"
                                            >
                                            <label for="feature_{{ $child->id }}" class="flex-1 ml-4 cursor-pointer flex flex-col md:flex-row justify-between md:items-center gap-2">
                                                <div>
                                                    @php
                                                        $childName = $child->name;
                                                        $groupName = $getGroupName($prefix);
                                                        if (strpos($childName, ' - ') !== false) {
                                                            $childName = explode(' - ', $childName)[1];
                                                        }
                                                    @endphp
                                                    <div class="font-bold text-gray-800 group-hover:text-green-900 transition">{{ $childName }}</div>
                                                    <div class="text-xs font-mono text-gray-400 mt-0.5">{{ $child->slug }}</div>
                                                </div>
                                                <span class="self-start md:self-center inline-flex items-center gap-1 px-2.5 py-1 rounded bg-blue-50 text-blue-700 border border-blue-100 text-[10px] font-bold">
                                                    SUB MENU
                                                </span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <div class="text-gray-500 text-center py-8 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                <i class="fas fa-inbox text-3xl mb-2 block opacity-50"></i>
                                No features available
                            </div>
                        @endforelse

                        <!-- Standalone Features Card -->
                        @if(!empty($standaloneFeatures))
                            <div class="bg-gray-50 border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                                <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4 flex items-center justify-between text-white">
                                    <label class="font-bold text-lg flex items-center gap-2 select-none">
                                        <i class="fa-solid fa-link text-blue-400"></i>
                                        Fitur Mandiri & Eksternal (Direct Menus)
                                    </label>
                                    <span class="text-xs font-semibold bg-gray-600 text-gray-200 px-3 py-1 rounded-full border border-gray-500/30">
                                        STANDALONE
                                    </span>
                                </div>
                                <div class="p-6 bg-white grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($standaloneFeatures as $feat)
                                        <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-gray-300 transition duration-200">
                                            <input
                                                type="checkbox"
                                                name="features[]"
                                                value="{{ $feat->id }}"
                                                id="feature_{{ $feat->id }}"
                                                {{ in_array($feat->id, $userFeatures) ? 'checked' : '' }}
                                                class="w-5 h-5 text-green-600 rounded focus:ring-green-500 border-gray-300 cursor-pointer"
                                            >
                                            <label for="feature_{{ $feat->id }}" class="flex-1 ml-4 cursor-pointer">
                                                <div class="font-bold text-gray-800">{{ $feat->name }}</div>
                                                <div class="text-xs font-mono text-gray-400 mt-0.5">{{ $feat->slug }}</div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Buttons -->
                    <div class="mt-8 pt-6 border-t border-gray-100 flex gap-4">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow-md transition duration-200 flex items-center">
                            <i class="fas fa-save mr-2"></i> Save Changes
                        </button>
                        <a href="{{ route('management.access.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-8 rounded-lg transition duration-200 flex items-center">
                            <i class="fas fa-times mr-2"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- User Info Sidebar -->
        <div class="lg:col-span-1">
            <!-- User Card -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 border-b border-gray-100 pb-3">
                    <i class="fas fa-user-circle text-green-600 mr-2"></i> User Info
                </h3>
                <div class="space-y-4">
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Username</p>
                        <p class="font-bold text-gray-800">{{ $user->username }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">NIK</p>
                        <p class="font-bold text-gray-800">{{ $user->nik ?? '-' }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Role</p>
                            <p class="font-bold text-gray-800">{{ $user->role ?? '-' }}</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Plant</p>
                            <p class="font-bold text-gray-800">{{ $user->plant ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Access Summary -->
            <div class="bg-green-50 rounded-xl border border-green-200 p-6 shadow-sm">
                <h3 class="text-xl font-bold text-green-900 mb-4 border-b border-green-200 pb-3">
                    <i class="fas fa-shield-alt text-green-600 mr-2"></i> Current Access
                </h3>
                <div class="space-y-3 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                    @if($user->features->count() > 0)
                        @foreach($user->features as $feature)
                            <div class="flex justify-between items-center bg-white p-2 rounded-lg border border-green-100 shadow-sm">
                                <span class="font-semibold text-green-900 truncate pr-2">{{ $feature->name }}</span>
                                <span class="text-xs font-bold bg-green-100 text-green-800 px-2 py-1 rounded">
                                    {{ $feature->slug }}
                                </span>
                            </div>
                        @endforeach
                    @else
                        <p class="text-green-700 text-sm font-medium italic p-2"><i class="fas fa-info-circle mr-1"></i> No features assigned yet.</p>
                    @endif
                </div>
                <div class="mt-4 pt-4 border-t border-green-200 flex justify-between items-center">
                    <span class="text-sm font-semibold text-green-800">Total Features:</span>
                    <span class="text-lg font-bold text-green-900 bg-green-200 px-3 py-1 rounded-lg">{{ $user->features->count() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<style>
    html, body {
        height: auto !important;
        overflow-y: auto !important;
    }
    .container {
        max-width: 1400px;
    }
    
    /* Custom Scrollbar for the access list */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(209, 250, 229, 0.5); /* green-100 */
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(16, 185, 129, 0.5); /* green-500 */
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(5, 150, 105, 0.8); /* green-600 */
    }
</style>

@section('scripts')
<script>
    $(document).ready(function() {
        // 1. When a parent checkbox changes
        $('.parent-checkbox').change(function() {
            var prefix = $(this).data('prefix');
            var isChecked = $(this).prop('checked');
            // Find all child checkboxes under this prefix and sync them
            $('.child-checkbox[data-parent="' + prefix + '"]').prop('checked', isChecked);
        });

        // 2. When a child checkbox changes
        $('.child-checkbox').change(function() {
            var parentPrefix = $(this).data('parent');
            var siblingCheckedCount = $('.child-checkbox[data-parent="' + parentPrefix + '"]:checked').length;
            
            // If at least one child is checked, the parent should be checked
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

@endsection

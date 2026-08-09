@extends('layouts.app')
@php
    $equipmentTypes = [
        ['id' => 'heavy', 'name' => 'Heavy Equipment', 'icon' => 'fa-tractor', 'color' => '#f59e0b', 'count' => 24, 'critical' => 4],
        ['id' => 'production', 'name' => 'Production Machine', 'icon' => 'fa-industry', 'color' => '#3b82f6', 'count' => 38, 'critical' => 2],
        ['id' => 'vehicle', 'name' => 'Vehicle', 'icon' => 'fa-truck', 'color' => '#8b5cf6', 'count' => 56, 'critical' => 1],
        ['id' => 'tooling', 'name' => 'Tooling & Instrument', 'icon' => 'fa-screwdriver-wrench', 'color' => '#10b981', 'count' => 112, 'critical' => 0],
    ];

    $forecastData = [
        ['bulan' => 'Mei 2026', 'heavy' => 3, 'production' => 2, 'vehicle' => 5, 'tooling' => 8, 'total' => 18],
        ['bulan' => 'Jun 2026', 'heavy' => 5, 'production' => 4, 'vehicle' => 3, 'tooling' => 6, 'total' => 18],
        ['bulan' => 'Jul 2026', 'heavy' => 2, 'production' => 6, 'vehicle' => 4, 'tooling' => 10, 'total' => 22],
        ['bulan' => 'Agu 2026', 'heavy' => 7, 'production' => 3, 'vehicle' => 6, 'tooling' => 5, 'total' => 21],
        ['bulan' => 'Sep 2026', 'heavy' => 4, 'production' => 5, 'vehicle' => 2, 'tooling' => 7, 'total' => 18],
        ['bulan' => 'Okt 2026', 'heavy' => 6, 'production' => 8, 'vehicle' => 5, 'tooling' => 12, 'total' => 31],
    ];

    $inventoryForecast = [
        ['name' => 'Hydraulic Filter', 'category' => 'heavy', 'current_stock' => 45, 'avg_usage' => 8, 'lead_time' => 14, 'reorder_point' => 60, 'forecast_usage' => 96, 'recommended_order' => 100, 'urgency' => 'critical', 'last_order' => '2026-03-15'],
        ['name' => 'V-Belt Set', 'category' => 'production', 'current_stock' => 120, 'avg_usage' => 15, 'lead_time' => 7, 'reorder_point' => 80, 'forecast_usage' => 180, 'recommended_order' => 150, 'urgency' => 'warning', 'last_order' => '2026-04-01'],
        ['name' => 'Engine Oil SAE 40', 'category' => 'vehicle', 'current_stock' => 200, 'avg_usage' => 25, 'lead_time' => 5, 'reorder_point' => 100, 'forecast_usage' => 300, 'recommended_order' => 250, 'urgency' => 'warning', 'last_order' => '2026-03-28'],
        ['name' => 'Spark Plug Set', 'category' => 'vehicle', 'current_stock' => 80, 'avg_usage' => 10, 'lead_time' => 10, 'reorder_point' => 50, 'forecast_usage' => 120, 'recommended_order' => 100, 'urgency' => 'normal', 'last_order' => '2026-04-10'],
        ['name' => 'Conveyor Belt 120cm', 'category' => 'production', 'current_stock' => 15, 'avg_usage' => 3, 'lead_time' => 21, 'reorder_point' => 20, 'forecast_usage' => 36, 'recommended_order' => 40, 'urgency' => 'critical', 'last_order' => '2026-02-20'],
        ['name' => 'Bearing 6205', 'category' => 'heavy', 'current_stock' => 200, 'avg_usage' => 20, 'lead_time' => 12, 'reorder_point' => 100, 'forecast_usage' => 240, 'recommended_order' => 200, 'urgency' => 'normal', 'last_order' => '2026-04-05'],
        ['name' => 'Grease Cartridge', 'category' => 'tooling', 'current_stock' => 85, 'avg_usage' => 12, 'lead_time' => 7, 'reorder_point' => 60, 'forecast_usage' => 144, 'recommended_order' => 120, 'urgency' => 'warning', 'last_order' => '2026-03-22'],
        ['name' => 'Fuel Filter', 'category' => 'vehicle', 'current_stock' => 55, 'avg_usage' => 9, 'lead_time' => 8, 'reorder_point' => 50, 'forecast_usage' => 108, 'recommended_order' => 100, 'urgency' => 'warning', 'last_order' => '2026-04-08'],
    ];

    $damagePrediction = [
        ['equipment' => 'Mesin Penggiling Tebu A', 'category' => 'Production', 'probability' => 87, 'eta_failure' => '3 hari', 'root_cause' => 'Worn bearing + misalignment', 'recommended_action' => 'Schedule immediate inspection', 'cost_estimate' => 'Rp 15.000.000'],
        ['equipment' => 'Excavator PC-200', 'category' => 'Heavy', 'probability' => 72, 'eta_failure' => '12 hari', 'root_cause' => 'Hydraulic leak developing', 'recommended_action' => 'Replace seals before dry-season', 'cost_estimate' => 'Rp 8.500.000'],
        ['equipment' => 'Dump Truck Fuso 01', 'category' => 'Vehicle', 'probability' => 65, 'eta_failure' => '21 hari', 'root_cause' => 'Clutch wear approaching limit', 'recommended_action' => 'Schedule clutch inspection', 'cost_estimate' => 'Rp 5.000.000'],
        ['equipment' => 'Conveyor Line B', 'category' => 'Production', 'probability' => 58, 'eta_failure' => '30 hari', 'root_cause' => 'Belt tension decreasing', 'recommended_action' => 'Adjust tensioner & monitor', 'cost_estimate' => 'Rp 3.200.000'],
        ['equipment' => 'Generator Set 500kVA', 'category' => 'Heavy', 'probability' => 45, 'eta_failure' => '45 hari', 'root_cause' => 'Oil consumption increasing', 'recommended_action' => 'Monitor oil level weekly', 'cost_estimate' => 'Rp 2.500.000'],
    ];

    $summaryStats = [
        ['label' => 'Total Equipment', 'value' => '230', 'icon' => 'fa-gears', 'color' => '#3b82f6', 'sub' => 'unit aktif'],
        ['label' => 'Critical Prediction', 'value' => '7', 'icon' => 'fa-triangle-exclamation', 'color' => '#ef4444', 'sub' => 'butuh perhatian'],
        ['label' => 'Prediksi Kerusakan', 'value' => '23', 'icon' => 'fa-wrench', 'color' => '#f59e0b', 'sub' => 'unit bulan ini'],
        ['label' => 'Budget Forecast', 'value' => 'Rp 842jt', 'icon' => 'fa-coins', 'color' => '#10b981', 'sub' => 'Q3 2026'],
    ];
@endphp

@section('styles')
<style>
    :root {
        --bg-primary: #0a0e1a;
        --bg-card: #111827;
        --border: rgba(255,255,255,0.07);
        --text-primary: #f1f5f9;
        --text-secondary: #94a3b8;
        --text-muted: #64748b;
        --accent-blue: #3b82f6;
        --accent-cyan: #06b6d4;
        --accent-purple: #8b5cf6;
        --accent-green: #10b981;
        --accent-red: #ef4444;
        --accent-yellow: #f59e0b;
    }
    body { background: var(--bg-primary) !important; }

    .glass-card {
        background: rgba(17,24,39,0.75);
        backdrop-filter: blur(20px);
        border: 1px solid var(--border);
        border-radius: 16px;
    }

    .stat-card {
        background: linear-gradient(135deg, #111827 0%, rgba(20,28,46,0.6) 100%);
        border: 1px solid var(--border);
        border-radius: 16px;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        border-color: rgba(255,255,255,0.12);
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; height: 2px;
        background: linear-gradient(90deg, transparent, var(--accent), transparent);
        opacity: 0;
        transition: opacity 0.3s;
    }
    .stat-card:hover::before { opacity: 1; }

    .equipment-type-card {
        background: linear-gradient(145deg, #111827 0%, rgba(17,24,39,0.8) 100%);
        border: 1px solid var(--border);
        border-radius: 16px;
        transition: all 0.3s;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .equipment-type-card::after {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 80px; height: 80px;
        border-radius: 50%;
        opacity: 0.05;
        background: var(--type-color);
    }
    .equipment-type-card:hover {
        transform: translateY(-3px) scale(1.02);
        border-color: var(--type-color);
        box-shadow: 0 8px 32px rgba(0,0,0,0.3), 0 0 20px var(--type-glow);
    }

    .prediction-row {
        border-radius: 14px;
        border: 1px solid transparent;
        transition: all 0.25s;
        position: relative;
        overflow: hidden;
    }
    .prediction-row::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 4px;
        background: var(--p-color);
    }
    .prediction-row:hover {
        background: rgba(255,255,255,0.04);
        border-color: var(--p-color);
        transform: translateX(4px);
    }

    .probability-bar {
        height: 8px;
        border-radius: 4px;
        background: rgba(255,255,255,0.06);
        overflow: hidden;
    }
    .probability-fill {
        height: 100%;
        border-radius: 4px;
        transition: width 1.5s ease-out;
    }

    .urgency-badge {
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .stock-indicator {
        width: 100%;
        height: 6px;
        border-radius: 3px;
        background: rgba(255,255,255,0.06);
        overflow: hidden;
        position: relative;
    }
    .stock-bar {
        height: 100%;
        border-radius: 3px;
        position: relative;
    }
    .stock-bar::after {
        content: '';
        position: absolute;
        right: 0; top: 50%;
        transform: translateY(-50%);
        width: 2px; height: 10px;
        border-radius: 1px;
        background: white;
    }
    .stock-danger { background: linear-gradient(90deg, #ef4444, #dc2626); }
    .stock-warning { background: linear-gradient(90deg, #f59e0b, #d97706); }
    .stock-normal { background: linear-gradient(90deg, #10b981, #059669); }

    .forecast-row {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        border-radius: 12px;
        border: 1px solid transparent;
        transition: all 0.2s;
    }
    .forecast-row:hover {
        background: rgba(255,255,255,0.04);
        border-color: var(--border);
    }

    .tab-btn {
        padding: 8px 20px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        border: 1px solid var(--border);
        background: transparent;
        color: var(--text-muted);
    }
    .tab-btn.active {
        background: var(--accent-blue);
        color: white;
        border-color: var(--accent-blue);
    }

    .btn-primary {
        padding: 10px 20px;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-primary:hover { transform: translateY(-2px); filter: brightness(1.1); }

    .mini-chart { height: 80px; }

    .modal-overlay {
        position: fixed; inset: 0;
        background: rgba(0,0,0,0.75);
        backdrop-filter: blur(10px);
        z-index: 999;
        display: none;
        align-items: center;
        justify-content: center;
    }
    .modal-overlay.active { display: flex; }
    .modal-box {
        background: #1a2235;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 24px;
        padding: 32px;
        width: 100%;
        max-width: 700px;
        max-height: 90vh;
        overflow-y: auto;
        animation: modalFade 0.3s ease-out;
    }
    @keyframes modalFade {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .form-input {
        width: 100%;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 10px;
        padding: 10px 14px;
        color: #f1f5f9;
        font-size: 14px;
        transition: border-color 0.2s;
    }
    .form-input:focus {
        outline: none;
        border-color: var(--accent-blue);
        box-shadow: 0 0 0 3px rgba(59,130,246,0.2);
    }

    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 3px; }

    .pulse-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.4); }
    }

    .forecast-table th {
        padding: 10px 12px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
        border-bottom: 1px solid var(--border);
    }
    .forecast-table td {
        padding: 10px 12px;
        font-size: 13px;
        color: var(--text-secondary);
        border-bottom: 1px solid rgba(255,255,255,0.03);
    }
    .forecast-table tr:hover td { background: rgba(255,255,255,0.02); }
</style>
@endsection

@section('content')
<div class="h-screen overflow-y-auto" style="background: var(--bg-primary);">
    <!-- HEADER -->
    <div class="px-8 pt-6 pb-4" style="background: linear-gradient(180deg, rgba(59,130,246,0.06) 0%, transparent 100%);">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('forecaster.machine_equipment.dashboard') }}" class="w-9 h-9 rounded-lg flex items-center justify-center transition hover:opacity-80" style="background: rgba(255,255,255,0.08);">
                    <i class="fa-solid fa-arrow-left text-sm" style="color: var(--text-secondary);"></i>
                </a>
                <div>
                    <p class="text-xs font-semibold tracking-widest uppercase" style="color: var(--accent-cyan);">AgriNav Intelligence</p>
                    <h1 class="text-2xl font-bold" style="color: var(--text-primary);">
                        <i class="fa-solid fa-chart-line mr-2" style="color: var(--accent-blue);"></i>Equipment Forecaster
                    </h1>
                    <p class="text-xs mt-0.5" style="color: var(--text-muted);">Prediksi kebutuhan persediaan & estimasi kerusakan alat</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex gap-2">
                    <button class="tab-btn active" onclick="switchTab('inventory', this)">
                        <i class="fa-solid fa-boxes-stacked mr-1"></i>Inventory Forecast
                    </button>
                    <button class="tab-btn" onclick="switchTab('damage', this)">
                        <i class="fa-solid fa-wrench mr-1"></i>Damage Prediction
                    </button>
                    <button class="tab-btn" onclick="switchTab('demand', this)">
                        <i class="fa-solid fa-calendar mr-1"></i>Demand Planning
                    </button>
                </div>
                <button onclick="openModal('exportModal')" class="btn-primary" style="background: rgba(59,130,246,0.15); color: var(--accent-blue);">
                    <i class="fa-solid fa-download"></i>Export
                </button>
            </div>
        </div>
    </div>

    <div class="px-8 py-6 space-y-6">
        <!-- SUMMARY STATS -->
        <div class="grid grid-cols-4 gap-4">
            @foreach($summaryStats as $i => $stat)
            <div class="stat-card p-5" style="animation-delay: {{ $i * 0.1 }}s;">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(255,255,255,0.04);">
                        <i class="fa-solid {{ $stat['icon'] }} text-lg" style="color: {{ $stat['color'] }};"></i>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full" style="background: rgba(255,255,255,0.04); color: var(--text-muted);">{{ $stat['sub'] }}</span>
                </div>
                <div class="text-3xl font-bold mb-1" style="color: {{ $stat['color'] }};">{{ $stat['value'] }}</div>
                <div class="text-sm font-medium" style="color: var(--text-secondary);">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>

        <!-- EQUIPMENT TYPE CARDS -->
        <div class="grid grid-cols-4 gap-4">
            @foreach($equipmentTypes as $et)
            <div class="equipment-type-card p-5" style="--type-color: {{ $et['color'] }}; --type-glow: {{ $et['color'] }}20;">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: {{ $et['color'] }}15; color: {{ $et['color'] }};">
                        <i class="fa-solid {{ $et['icon'] }} text-lg"></i>
                    </div>
                    @if($et['critical'] > 0)
                    <span class="text-xs px-2 py-1 rounded-full font-bold" style="background: rgba(239,68,68,0.15); color: #ef4444;">{{ $et['critical'] }} critical</span>
                    @endif
                </div>
                <div class="text-lg font-bold mb-1" style="color: var(--text-primary);">{{ $et['count'] }}</div>
                <div class="text-sm" style="color: var(--text-secondary);">{{ $et['name'] }}</div>
                <div class="mt-3" style="height: 60px;" id="chart-{{ $et['id'] }}"></div>
            </div>
            @endforeach
        </div>

        <!-- MAIN CONTENT: TWO TABS -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- LEFT: FORECAST TABLE / PREDICTION LIST -->
            <div class="lg:col-span-2">
                <!-- INVENTORY TAB -->
                <div id="tab-inventory">
                    <div class="glass-card p-6">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="font-bold text-lg" style="color: var(--text-primary);">
                                <i class="fa-solid fa-table mr-2" style="color: var(--accent-blue);"></i>Prediksi Kebutuhan Persediaan
                            </h3>
                            <div class="flex gap-2">
                                <button onclick="openModal('addItemModal')" class="btn-primary text-xs" style="background: rgba(59,130,246,0.15); color: var(--accent-blue);">
                                    <i class="fa-solid fa-plus"></i>Tambah Item
                                </button>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="forecast-table w-full">
                                <thead>
                                    <tr>
                                        <th>Item / Sparepart</th>
                                        <th>Kategori</th>
                                        <th>Stock</th>
                                        <th>Avg Usage</th>
                                        <th>Lead Time</th>
                                        <th>Forecast (90hr)</th>
                                        <th>Rekomendasi Order</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inventoryForecast as $item)
                                    @php
                                        $urgency = $item['urgency'];
                                        $urgencyCfg = [
                                            'critical' => ['color' => '#ef4444', 'bg' => 'rgba(239,68,68,0.12)', 'label' => 'CRITICAL'],
                                            'warning'  => ['color' => '#f59e0b', 'bg' => 'rgba(245,158,11,0.12)', 'label' => 'WARNING'],
                                            'normal'   => ['color' => '#10b981', 'bg' => 'rgba(16,185,129,0.12)', 'label' => 'NORMAL'],
                                        ];
                                        $uc = $urgencyCfg[$urgency];
                                        $stockPct = min(100, $item['current_stock'] / $item['reorder_point'] * 100);
                                        $stockClass = $stockPct < 50 ? 'stock-danger' : ($stockPct < 80 ? 'stock-warning' : 'stock-normal');
                                        $categoryColors = ['heavy' => '#f59e0b', 'production' => '#3b82f6', 'vehicle' => '#8b5cf6', 'tooling' => '#10b981'];
                                        $catColor = $categoryColors[$item['category']];
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="font-semibold" style="color: var(--text-primary);">{{ $item['name'] }}</div>
                                            <div class="text-xs" style="color: var(--text-muted);">Last order: {{ $item['last_order'] }}</div>
                                        </td>
                                        <td>
                                            <span class="text-xs font-semibold px-2 py-1 rounded" style="background: {{ $catColor }}15; color: {{ $catColor }};">{{ ucfirst($item['category']) }}</span>
                                        </td>
                                        <td>
                                            <span class="font-bold" style="color: {{ $uc['color'] }};">{{ $item['current_stock'] }}</span>
                                            <div class="stock-indicator mt-1 w-16">
                                                <div class="stock-bar {{ $stockClass }}" style="width: {{ min(100, $stockPct) }}%;"></div>
                                            </div>
                                        </td>
                                        <td class="font-semibold" style="color: var(--text-primary);">{{ $item['avg_usage'] }}/bln</td>
                                        <td class="text-xs" style="color: var(--text-muted);">{{ $item['lead_time'] }} hari</td>
                                        <td class="font-bold" style="color: var(--accent-cyan);">{{ $item['forecast_usage'] }} unit</td>
                                        <td class="font-bold" style="color: var(--accent-yellow);">{{ $item['recommended_order'] }} unit</td>
                                        <td>
                                            <span class="urgency-badge" style="background: {{ $uc['bg'] }}; color: {{ $uc['color'] }};">{{ $uc['label'] }}</span>
                                        </td>
                                        <td>
                                            <button onclick="openOrderModal('{{ $item['name'] }}', {{ $item['recommended_order'] }})" class="text-xs px-3 py-1.5 rounded-lg font-semibold transition" style="background: {{ $uc['bg'] }}; color: {{ $uc['color'] }};">
                                                <i class="fa-solid fa-cart-shopping mr-1"></i>Order
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- DAMAGE PREDICTION TAB -->
                <div id="tab-damage" style="display:none;">
                    <div class="glass-card p-6">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="font-bold text-lg" style="color: var(--text-primary);">
                                <i class="fa-solid fa-warning mr-2" style="color: var(--accent-red);"></i>Prediksi Kerusakan Equipment
                            </h3>
                            <div class="flex items-center gap-2 text-xs" style="color: var(--text-muted);">
                                <span class="pulse-dot" style="background: var(--accent-red);"></span>
                                Real-time monitoring aktif
                            </div>
                        </div>

                        <div class="space-y-3">
                            @foreach($damagePrediction as $dp)
                            @php
                                $probColor = $dp['probability'] >= 70 ? '#ef4444' : ($dp['probability'] >= 50 ? '#f59e0b' : '#10b981');
                            @endphp
                            <div class="prediction-row p-5 flex gap-4" style="--p-color: {{ $probColor }}; background: rgba(255,255,255,0.02);">
                                <div class="flex-shrink-0 text-center">
                                    <div class="text-2xl font-bold" style="color: {{ $probColor }};">{{ $dp['probability'] }}%</div>
                                    <div class="text-xs" style="color: var(--text-muted);">Probability</div>
                                    <div class="probability-bar mt-2 w-20">
                                        <div class="probability-fill" style="width: {{ $dp['probability'] }}%; background: {{ $probColor }};"></div>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <div class="font-bold" style="color: var(--text-primary);">{{ $dp['equipment'] }}</div>
                                        <span class="text-xs font-semibold px-2 py-0.5 rounded" style="background: rgba(255,255,255,0.06); color: var(--text-muted);">{{ $dp['category'] }}</span>
                                    </div>
                                    <div class="text-sm mb-2" style="color: var(--text-secondary);">
                                        <i class="fa-solid fa-bullseye mr-1" style="color: {{ $probColor }};"></i>{{ $dp['root_cause'] }}
                                    </div>
                                    <div class="flex items-center gap-3 text-xs" style="color: var(--text-muted);">
                                        <span><i class="fa-solid fa-clock mr-1"></i>ETA: {{ $dp['eta_failure'] }}</span>
                                        <span><i class="fa-solid fa-wrench mr-1"></i>{{ $dp['recommended_action'] }}</span>
                                    </div>
                                </div>
                                <div class="flex-shrink-0 text-right">
                                    <div class="text-xs" style="color: var(--text-muted);">Est. Cost</div>
                                    <div class="font-bold" style="color: var(--accent-yellow);">{{ $dp['cost_estimate'] }}</div>
                                    <button class="mt-2 text-xs px-3 py-1.5 rounded-lg font-semibold transition" style="background: rgba(245,158,11,0.12); color: var(--accent-yellow);">
                                        <i class="fa-solid fa-clipboard-list mr-1"></i>Action Plan
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- DEMAND PLANNING TAB -->
                <div id="tab-demand" style="display:none;">
                    <div class="glass-card p-6">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="font-bold text-lg" style="color: var(--text-primary);">
                                <i class="fa-solid fa-calendar mr-2" style="color: var(--accent-purple);"></i>Demand Planning 6 Bulan
                            </h3>
                            <div class="flex items-center gap-2">
                                <span class="text-xs px-2 py-1 rounded" style="background: rgba(59,130,246,0.12); color: var(--accent-blue);">Actual</span>
                                <span class="text-xs px-2 py-1 rounded" style="background: rgba(139,92,246,0.12); color: var(--accent-purple);">Forecast</span>
                            </div>
                        </div>
                        <div id="demandChart" style="height: 280px;"></div>

                        <div class="mt-5 grid grid-cols-4 gap-4 pt-4" style="border-top: 1px solid var(--border);">
                            @foreach($equipmentTypes as $et)
                            <div class="text-center">
                                <div class="text-xl font-bold" style="color: {{ $et['color'] }};">{{ array_sum(array_column($forecastData, $et['id'])) }}</div>
                                <div class="text-xs" style="color: var(--text-muted);">{{ $et['name'] }}</div>
                                <div class="text-xs mt-1" style="color: var(--text-secondary);">total 6 bulan</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: QUICK STATS + ACTIONS -->
            <div class="space-y-4">
                <!-- CRITICAL ITEMS -->
                <div class="glass-card p-5">
                    <h3 class="font-bold mb-4" style="color: var(--text-primary);">
                        <i class="fa-solid fa-fire mr-2" style="color: var(--accent-red);"></i>Critical Items
                    </h3>
                    <div class="space-y-2">
                        @foreach($inventoryForecast as $item)
                        @if($item['urgency'] === 'critical')
                        <div class="p-3 rounded-xl" style="background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.15);">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-semibold" style="color: var(--text-primary);">{{ $item['name'] }}</span>
                                <span class="text-xs font-bold" style="color: var(--accent-red);">STOK HAMPA</span>
                            </div>
                            <div class="flex items-center justify-between mt-1 text-xs" style="color: var(--text-muted);">
                                <span>Stock: {{ $item['current_stock'] }}</span>
                                <span>Reorder: {{ $item['reorder_point'] }}</span>
                            </div>
                            <button onclick="openOrderModal('{{ $item['name'] }}', {{ $item['recommended_order'] }})" class="mt-2 w-full text-xs py-2 rounded-lg font-semibold" style="background: var(--accent-red); color: white;">
                                <i class="fa-solid fa-cart-shopping mr-1"></i>Order Sekarang
                            </button>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>

                <!-- BUDGET FORECAST -->
                <div class="glass-card p-5">
                    <h3 class="font-bold mb-4" style="color: var(--text-primary);">
                        <i class="fa-solid fa-coins mr-2" style="color: var(--accent-yellow);"></i>Budget Forecast Q3
                    </h3>
                    <div class="space-y-3">
                        @php
                            $budgetItems = [
                                ['label' => 'Heavy Equipment', 'value' => 320, 'color' => '#f59e0b'],
                                ['label' => 'Production Machine', 'value' => 245, 'color' => '#3b82f6'],
                                ['label' => 'Vehicle Parts', 'value' => 185, 'color' => '#8b5cf6'],
                                ['label' => 'Tooling', 'value' => 92, 'color' => '#10b981'],
                            ];
                            $totalBudget = array_sum(array_column($budgetItems, 'value'));
                        @endphp
                        @foreach($budgetItems as $bi)
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span style="color: var(--text-secondary);">{{ $bi['label'] }}</span>
                                <span style="color: {{ $bi['color'] }};">Rp {{ number_format($bi['value']) }}jt</span>
                            </div>
                            <div class="h-2 rounded" style="background: rgba(255,255,255,0.04);">
                                <div class="h-full rounded" style="width: {{ $bi['value'] / $totalBudget * 100 }}%; background: {{ $bi['color'] }};"></div>
                            </div>
                        </div>
                        @endforeach
                        <div class="pt-3 mt-3 flex justify-between items-center" style="border-top: 1px solid var(--border);">
                            <span class="text-sm font-bold" style="color: var(--text-primary);">Total Budget</span>
                            <span class="text-lg font-bold" style="color: var(--accent-yellow);">Rp {{ number_format($totalBudget) }}jt</span>
                        </div>
                    </div>
                </div>

                <!-- RECENT ORDERS -->
                <div class="glass-card p-5">
                    <h3 class="font-bold mb-4" style="color: var(--text-primary);">
                        <i class="fa-solid fa-clock-rotate-left mr-2" style="color: var(--accent-cyan);"></i>Recent Orders
                    </h3>
                    <div class="space-y-2">
                        @php
                            $recentOrders = [
                                ['item' => 'Hydraulic Filter', 'qty' => 50, 'date' => '2026-04-25', 'status' => 'delivered'],
                                ['item' => 'V-Belt Set', 'qty' => 100, 'date' => '2026-04-20', 'status' => 'in_transit'],
                                ['item' => 'Engine Oil SAE 40', 'qty' => 200, 'date' => '2026-04-18', 'status' => 'delivered'],
                            ];
                        @endphp
                        @foreach($recentOrders as $order)
                        @php
                            $statusBadge = $order['status'] === 'delivered' ? ['color' => '#10b981', 'bg' => 'rgba(16,185,129,0.12)', 'label' => 'Delivered'] : ['color' => '#f59e0b', 'bg' => 'rgba(245,158,11,0.12)', 'label' => 'In Transit'];
                        @endphp
                        <div class="flex items-center gap-3 p-3 rounded-xl" style="background: rgba(255,255,255,0.03);">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: {{ $statusBadge['bg'] }};">
                                <i class="fa-solid fa-box text-xs" style="color: {{ $statusBadge['color'] }};"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-semibold truncate" style="color: var(--text-primary);">{{ $order['item'] }}</div>
                                <div class="text-xs" style="color: var(--text-muted);">{{ $order['qty'] }} unit · {{ $order['date'] }}</div>
                            </div>
                            <span class="text-xs font-bold px-2 py-0.5 rounded" style="background: {{ $statusBadge['bg'] }}; color: {{ $statusBadge['color'] }};">{{ $statusBadge['label'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ORDER MODAL -->
<div id="orderModal" class="modal-overlay" onclick="closeModalOnOverlay(event, 'orderModal')">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold" style="color: var(--text-primary);">
                <i class="fa-solid fa-cart-shopping mr-2" style="color: var(--accent-yellow);"></i>Buat Purchase Order
            </h2>
            <button onclick="closeModal('orderModal')" class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(255,255,255,0.08);">
                <i class="fa-solid fa-xmark text-sm" style="color: var(--text-secondary);"></i>
            </button>
        </div>
        <form id="orderForm" onsubmit="submitOrder(event)">
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold mb-2 uppercase tracking-wider" style="color: var(--text-muted);">Nama Item</label>
                    <input type="text" class="form-input" id="orderItemName" readonly>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold mb-2 uppercase tracking-wider" style="color: var(--text-muted);">Jumlah Order</label>
                        <input type="number" class="form-input" id="orderQty" value="100" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold mb-2 uppercase tracking-wider" style="color: var(--text-muted);">Estimasi Harga/Unit</label>
                        <input type="text" class="form-input" id="orderPrice" placeholder="Rp 0" value="Rp 0">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold mb-2 uppercase tracking-wider" style="color: var(--text-muted);">Tanggal Order</label>
                        <input type="date" class="form-input" value="2026-05-04" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold mb-2 uppercase tracking-wider" style="color: var(--text-muted);">Tanggal Kirim</label>
                        <input type="date" class="form-input" value="2026-05-18">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold mb-2 uppercase tracking-wider" style="color: var(--text-muted);">Supplier</label>
                    <select class="form-input">
                        <option>PT.Supplier Indonesia - Lead time 14 hari</option>
                        <option>CV.Mitra Teknik - Lead time 10 hari</option>
                        <option>Toko Sparepart Nusantara - Lead time 7 hari</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold mb-2 uppercase tracking-wider" style="color: var(--text-muted);">Catatan</label>
                    <textarea class="form-input" rows="2" placeholder="Catatan khusus untuk order ini..."></textarea>
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="button" onclick="closeModal('orderModal')" class="flex-1 py-3 rounded-xl font-semibold" style="background: rgba(255,255,255,0.05); color: var(--text-secondary);">Batal</button>
                <button type="submit" class="flex-1 py-3 rounded-xl font-semibold transition" style="background: var(--accent-yellow); color: #0a0e1a;">
                    <i class="fa-solid fa-paper-plane mr-1"></i>Submit PO
                </button>
            </div>
        </form>
    </div>
</div>

<!-- EXPORT MODAL -->
<div id="exportModal" class="modal-overlay" onclick="closeModalOnOverlay(event, 'exportModal')">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold" style="color: var(--text-primary);">
                <i class="fa-solid fa-download mr-2" style="color: var(--accent-blue);"></i>Export Laporan
            </h2>
            <button onclick="closeModal('exportModal')" class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(255,255,255,0.08);">
                <i class="fa-solid fa-xmark text-sm" style="color: var(--text-secondary);"></i>
            </button>
        </div>
        <div class="grid grid-cols-2 gap-4">
            @php
                $exportOptions = [
                    ['label' => 'Inventory Forecast', 'icon' => 'fa-boxes-stacked', 'color' => 'var(--accent-blue)', 'desc' => 'Tabel prediksi kebutuhan persediaan'],
                    ['label' => 'Damage Prediction', 'icon' => 'fa-wrench', 'color' => 'var(--accent-red)', 'desc' => 'Laporan prediksi kerusakan equipment'],
                    ['label' => 'Demand Planning', 'icon' => 'fa-calendar', 'color' => 'var(--accent-purple)', 'desc' => 'Rencana demand 6 bulan'],
                    ['label' => 'Full Report', 'icon' => 'fa-file-pdf', 'color' => 'var(--accent-yellow)', 'desc' => 'Semua laporan dalam satu file'],
                ];
            @endphp
            @foreach($exportOptions as $ex)
            <button onclick="exportReport('{{ $ex['label'] }}')" class="p-5 rounded-xl text-left transition" style="background: rgba(255,255,255,0.04); border: 1px solid var(--border);">
                <i class="fa-solid {{ $ex['icon'] }} text-2xl mb-3" style="color: {{ $ex['color'] }};"></i>
                <div class="font-semibold mb-1" style="color: var(--text-primary);">{{ $ex['label'] }}</div>
                <div class="text-xs" style="color: var(--text-muted);">{{ $ex['desc'] }}</div>
            </button>
            @endforeach
        </div>
        <div class="mt-4">
            <label class="block text-xs font-bold mb-2 uppercase tracking-wider" style="color: var(--text-muted);">Format</label>
            <div class="flex gap-2">
                <button class="flex-1 py-2 rounded-lg text-sm font-semibold" id="fmtPdf" style="background: rgba(239,68,68,0.12); color: var(--accent-red); border: 1px solid rgba(239,68,68,0.2);" onclick="selectFormat('pdf', this)">PDF</button>
                <button class="flex-1 py-2 rounded-lg text-sm font-semibold" id="fmtExcel" style="background: rgba(16,185,129,0.12); color: var(--accent-green); border: 1px solid rgba(16,185,129,0.2);" onclick="selectFormat('excel', this)">Excel</button>
                <button class="flex-1 py-2 rounded-lg text-sm font-semibold" id="fmtCsv" style="background: rgba(59,130,246,0.12); color: var(--accent-blue); border: 1px solid rgba(59,130,246,0.2);" onclick="selectFormat('csv', this)">CSV</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/highcharts/highcharts.js"></script>
<script>
// Tab switching
function switchTab(tab, btn) {
    document.querySelectorAll('.tab-btn').forEach(function(b) { b.classList.remove('active'); });
    btn.classList.add('active');
    document.getElementById('tab-inventory').style.display = tab === 'inventory' ? 'block' : 'none';
    document.getElementById('tab-damage').style.display = tab === 'damage' ? 'block' : 'none';
    document.getElementById('tab-demand').style.display = tab === 'demand' ? 'block' : 'none';
    if (tab === 'demand') {
        setTimeout(drawDemandChart, 100);
    }
}

// Modal
function openModal(id) { document.getElementById(id).classList.add('active'); document.body.style.overflow = 'hidden'; }
function closeModal(id) { document.getElementById(id).classList.remove('active'); document.body.style.overflow = ''; }
function closeModalOnOverlay(e, id) { if (e.target === e.currentTarget) closeModal(id); }

// Order modal
function openOrderModal(name, qty) {
    document.getElementById('orderItemName').value = name;
    document.getElementById('orderQty').value = qty;
    openModal('orderModal');
}

function submitOrder(e) {
    e.preventDefault();
    var btn = e.target.querySelector('button[type="submit"]');
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i>Memproses...';
    btn.disabled = true;
    setTimeout(function() {
        closeModal('orderModal');
        btn.innerHTML = '<i class="fa-solid fa-paper-plane mr-1"></i>Submit PO';
        btn.disabled = false;
        showToast('Purchase Order berhasil dibuat!', 'success');
    }, 1500);
}

function showToast(msg, type) {
    var colors = { success: '#10b981', error: '#ef4444', warning: '#f59e0b' };
    var toast = document.createElement('div');
    toast.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:9999;background:#1a2235;border:1px solid rgba(255,255,255,0.1);border-left:4px solid ' + colors[type] + ';border-radius:12px;padding:14px 20px;color:#f1f5f9;font-size:14px;font-weight:500;box-shadow:0 8px 32px rgba(0,0,0,0.4);animation:slideInToast 0.3s ease-out;';
    toast.innerHTML = '<i class="fa-solid fa-check-circle mr-2" style="color:' + colors[type] + ';"></i>' + msg;
    document.body.appendChild(toast);
    setTimeout(function() { toast.style.opacity = '0'; setTimeout(function() { toast.remove(); }, 300); }, 3500);
}

// Format selection
function selectFormat(fmt, btn) {
    document.querySelectorAll('[id^="fmt"]').forEach(function(b) {
        b.style.background = 'rgba(255,255,255,0.04)';
        b.style.color = 'var(--text-muted)';
        b.style.borderColor = 'var(--border)';
    });
    btn.style.background = 'rgba(16,185,129,0.2)';
    btn.style.color = '#10b981';
    btn.style.borderColor = 'rgba(16,185,129,0.3)';
}

function exportReport(label) {
    showToast('Export ' + label + ' sedang diproses...', 'success');
}

// Type chart mini
Highcharts.chart('chart-heavy', {
    chart: { type: 'column', backgroundColor: 'transparent', height: 60, margin: [0,0,0,0] },
    title: { text: '' },
    credits: { enabled: false },
    legend: { enabled: false },
    xAxis: { categories: ['Mei','Jun','Jul'], labels: { style: { color: '#64748b', fontSize: '9px' } }, tickLength: 0 },
    yAxis: { visible: false },
    series: [{ data: [3,5,2], color: '#f59e0b' }],
});

Highcharts.chart('chart-production', {
    chart: { type: 'column', backgroundColor: 'transparent', height: 60, margin: [0,0,0,0] },
    title: { text: '' },
    credits: { enabled: false },
    legend: { enabled: false },
    xAxis: { categories: ['Mei','Jun','Jul'], labels: { style: { color: '#64748b', fontSize: '9px' } }, tickLength: 0 },
    yAxis: { visible: false },
    series: [{ data: [2,4,6], color: '#3b82f6' }],
});

Highcharts.chart('chart-vehicle', {
    chart: { type: 'column', backgroundColor: 'transparent', height: 60, margin: [0,0,0,0] },
    title: { text: '' },
    credits: { enabled: false },
    legend: { enabled: false },
    xAxis: { categories: ['Mei','Jun','Jul'], labels: { style: { color: '#64748b', fontSize: '9px' } }, tickLength: 0 },
    yAxis: { visible: false },
    series: [{ data: [5,3,4], color: '#8b5cf6' }],
});

Highcharts.chart('chart-tooling', {
    chart: { type: 'column', backgroundColor: 'transparent', height: 60, margin: [0,0,0,0] },
    title: { text: '' },
    credits: { enabled: false },
    legend: { enabled: false },
    xAxis: { categories: ['Mei','Jun','Jul'], labels: { style: { color: '#64748b', fontSize: '9px' } }, tickLength: 0 },
    yAxis: { visible: false },
    series: [{ data: [8,6,10], color: '#10b981' }],
});

// Demand planning chart
function drawDemandChart() {
    var categories = {!! json_encode(array_column($forecastData, 'bulan')) !!};
    var heavyData = {!! json_encode(array_column($forecastData, 'heavy')) !!};
    var productionData = {!! json_encode(array_column($forecastData, 'production')) !!};
    var vehicleData = {!! json_encode(array_column($forecastData, 'vehicle')) !!};
    var toolingData = {!! json_encode(array_column($forecastData, 'tooling')) !!};

    Highcharts.chart('demandChart', {
        chart: { type: 'column', backgroundColor: 'transparent', height: 260 },
        title: { text: '' },
        credits: { enabled: false },
        xAxis: { categories: categories, labels: { style: { color: '#64748b', fontSize: '11px' } }, tickLength: 0 },
        yAxis: { title: { text: 'Unit', style: { color: '#64748b', fontSize: '11px' } }, labels: { style: { color: '#64748b' } }, gridLineColor: 'rgba(255,255,255,0.04)' },
        tooltip: { shared: true, backgroundColor: '#1a2235', borderColor: 'rgba(255,255,255,0.1)', style: { color: '#f1f5f9' } },
        legend: { itemStyle: { color: '#94a3b8', fontSize: '11px' } },
        plotOptions: { column: { borderRadius: 4, groupPadding: 0.1 } },
        series: [
            { name: 'Heavy', data: heavyData, color: '#f59e0b' },
            { name: 'Production', data: productionData, color: '#3b82f6' },
            { name: 'Vehicle', data: vehicleData, color: '#8b5cf6' },
            { name: 'Tooling', data: toolingData, color: '#10b981' },
        ],
    });
}

// Toast animation
var style = document.createElement('style');
style.textContent = '@keyframes slideInToast { from { opacity:0;transform:translateX(20px); } to { opacity:1;transform:translateX(0); } }';
document.head.appendChild(style);
</script>
@endsection
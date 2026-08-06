@extends('layouts.app')

@section('title', 'Sales Dashboard - Context Example')

@section('content')
<div class="main-content">
    <!-- Page Context Metadata (Optional - untuk custom metadata) -->
    <div data-page-context='{
        "module": "Sales Dashboard",
        "description": "Dashboard penjualan dengan analisis real-time",
        "features": ["sales-table", "revenue-chart", "filters"],
        "dataSource": "BigQuery Sales DB"
    }' style="display: none;"></div>

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Sales Dashboard</h1>

        <!-- Statistics Cards (akan terdeteksi otomatis) -->
        <div class="grid grid-cols-4 gap-4 mb-6">
            <div class="stat-card bg-white p-4 rounded shadow">
                <div class="stat-label text-gray-600 text-sm">Total Revenue</div>
                <div class="stat-value text-2xl font-bold text-blue-600">Rp 125.5M</div>
            </div>
            
            <div class="stat-card bg-white p-4 rounded shadow">
                <div class="stat-label text-gray-600 text-sm">Total Transactions</div>
                <div class="stat-value text-2xl font-bold text-green-600">1,234</div>
            </div>
            
            <div class="stat-card bg-white p-4 rounded shadow" data-stat data-stat-label="Average Order" data-stat-value="Rp 101,625">
                <div class="stat-label text-gray-600 text-sm">Average Order</div>
                <div class="stat-value text-2xl font-bold text-purple-600">Rp 101,625</div>
            </div>
            
            <div class="stat-card bg-white p-4 rounded shadow">
                <div class="stat-label text-gray-600 text-sm">Growth</div>
                <div class="stat-value text-2xl font-bold text-orange-600">+15.3%</div>
            </div>
        </div>

        <!-- Filters (akan terdeteksi otomatis) -->
        <div class="bg-white p-4 rounded shadow mb-6">
            <h2 class="text-lg font-semibold mb-4">Filter Data</h2>
            <div class="grid grid-cols-4 gap-4">
                <div>
                    <label for="date-from" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                    <input type="date" id="date-from" class="w-full border rounded px-3 py-2" value="2024-01-01">
                </div>
                
                <div>
                    <label for="date-to" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                    <input type="date" id="date-to" class="w-full border rounded px-3 py-2" value="2024-01-31">
                </div>
                
                <div>
                    <label for="plant-filter" class="block text-sm font-medium text-gray-700 mb-1">Pilih Pabrik</label>
                    <select id="plant-filter" class="w-full border rounded px-3 py-2">
                        <option value="">Semua Pabrik</option>
                        <option value="1" selected>Pabrik Tanjung Morawa</option>
                        <option value="2">Pabrik Sei Semayang</option>
                        <option value="3">Pabrik Adolina</option>
                    </select>
                </div>
                
                <div>
                    <label for="product-search" class="block text-sm font-medium text-gray-700 mb-1">Cari Produk</label>
                    <input type="text" id="product-search" class="w-full border rounded px-3 py-2" placeholder="Ketik nama produk...">
                </div>
            </div>
            
            <div class="mt-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" id="show-only-active" class="form-checkbox h-4 w-4 text-blue-600" checked>
                    <span class="ml-2 text-sm text-gray-700">Tampilkan hanya produk aktif</span>
                </label>
            </div>
        </div>

        <!-- Chart (akan terdeteksi otomatis jika Chart.js) -->
        <div class="bg-white p-4 rounded shadow mb-6">
            <h2 class="text-lg font-semibold mb-4">Revenue Trend</h2>
            <canvas id="revenue-chart" width="400" height="150"></canvas>
        </div>

        <!-- Data Table (akan terdeteksi otomatis) -->
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-lg font-semibold mb-4">Sales Transactions</h2>
            <table id="sales-table" class="w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Tanggal</th>
                        <th class="px-4 py-2 text-left">Produk</th>
                        <th class="px-4 py-2 text-right">Qty</th>
                        <th class="px-4 py-2 text-right">Harga Satuan</th>
                        <th class="px-4 py-2 text-right">Total</th>
                        <th class="px-4 py-2 text-left">Pabrik</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="px-4 py-2">2024-01-15</td>
                        <td class="px-4 py-2">Kopi Arabica Premium</td>
                        <td class="px-4 py-2 text-right">150</td>
                        <td class="px-4 py-2 text-right">Rp 50,000</td>
                        <td class="px-4 py-2 text-right font-semibold">Rp 7,500,000</td>
                        <td class="px-4 py-2">Tanjung Morawa</td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-4 py-2">2024-01-15</td>
                        <td class="px-4 py-2">Teh Hitam Grade A</td>
                        <td class="px-4 py-2 text-right">200</td>
                        <td class="px-4 py-2 text-right">Rp 35,000</td>
                        <td class="px-4 py-2 text-right font-semibold">Rp 7,000,000</td>
                        <td class="px-4 py-2">Tanjung Morawa</td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-4 py-2">2024-01-14</td>
                        <td class="px-4 py-2">Kopi Robusta</td>
                        <td class="px-4 py-2 text-right">180</td>
                        <td class="px-4 py-2 text-right">Rp 40,000</td>
                        <td class="px-4 py-2 text-right font-semibold">Rp 7,200,000</td>
                        <td class="px-4 py-2">Sei Semayang</td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-4 py-2">2024-01-14</td>
                        <td class="px-4 py-2">Kakao Bubuk</td>
                        <td class="px-4 py-2 text-right">120</td>
                        <td class="px-4 py-2 text-right">Rp 60,000</td>
                        <td class="px-4 py-2 text-right font-semibold">Rp 7,200,000</td>
                        <td class="px-4 py-2">Adolina</td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-4 py-2">2024-01-13</td>
                        <td class="px-4 py-2">Gula Tebu Organik</td>
                        <td class="px-4 py-2 text-right">300</td>
                        <td class="px-4 py-2 text-right">Rp 25,000</td>
                        <td class="px-4 py-2 text-right font-semibold">Rp 7,500,000</td>
                        <td class="px-4 py-2">Tanjung Morawa</td>
                    </tr>
                </tbody>
            </table>
            
            <div class="mt-4 text-sm text-gray-600">
                Menampilkan 5 dari 1,234 transaksi
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Setup Chart
    const ctx = document.getElementById('revenue-chart');
    if (ctx) {
        const revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Revenue (Juta Rupiah)',
                    data: [50, 55, 52, 60, 65, 70, 75, 80, 85, 90, 95, 100],
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
    
    // Simulate filter change (untuk demo reactive update)
    const filters = document.querySelectorAll('input, select');
    filters.forEach(filter => {
        filter.addEventListener('change', function() {
            console.log('🔄 Filter changed:', this.id, '=', this.value);
            // Context akan otomatis terupdate via ChatPageContext observers
            
            // Simulate table refresh (in real app, you'd fetch new data)
            console.log('📊 Fetching new data based on filters...');
        });
    });
    
    // Debug: Log context setelah 2 detik
    setTimeout(() => {
        if (window.chatPageContext) {
            console.log('📋 Current Page Context:', window.chatPageContext.getContextSummary());
        }
    }, 2000);
});

// Example: Manual AJAX update yang trigger context refresh
function refreshTableData() {
    fetch('/api/sales-data')
        .then(response => response.json())
        .then(data => {
            // Update table
            const tbody = document.querySelector('#sales-table tbody');
            tbody.innerHTML = data.rows.map(row => `
                <tr class="border-b">
                    <td class="px-4 py-2">${row.date}</td>
                    <td class="px-4 py-2">${row.product}</td>
                    <td class="px-4 py-2 text-right">${row.qty}</td>
                    <td class="px-4 py-2 text-right">${row.price}</td>
                    <td class="px-4 py-2 text-right font-semibold">${row.total}</td>
                    <td class="px-4 py-2">${row.plant}</td>
                </tr>
            `).join('');
            
            // Context otomatis terupdate via MutationObserver!
            console.log('✅ Table updated, context auto-refreshed');
        });
}
</script>
@endsection

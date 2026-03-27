
@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dfarm.css') }}">

<div class="gradient-container">
  @include('pages.dfarm.menu.headerkaret')

  <!-- Header Banner -->
  <div class="bg-gradient-to-r from-blue-700 to-blue-500 text-white py-4 px-6 shadow-lg flex-shrink-0">
    <div class="max-w-7xl mx-auto">
      <h1 class="text-2xl md:text-3xl font-bold">
        <span class="font-light">Produksi</span> <span class="italic">Regional</span>
      </h1>
    </div>
  </div>

  <!-- Main Content -->
  <div class="flex-1 overflow-y-auto">
    <div class="max-w-7xl mx-auto px-4 py-6">
      
      <!-- Filters Section -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-6">
        <!-- Date Range Filter -->
        <div>
          <label class="block text-white text-xs md:text-sm font-medium mb-1">Periode</label>
          <div class="relative">
            <input 
              type="text" 
              id="dateRange"
              placeholder="Nov 5, 2024 - Nov 6, 2024" 
              class="w-full px-3 py-2 text-sm rounded-lg bg-slate-700 bg-opacity-50 text-white placeholder-gray-400 border border-slate-600 focus:outline-none focus:border-blue-400"
            />
          </div>
        </div>

        <!-- Regional Filter -->
        <div>
          <label class="block text-white text-xs md:text-sm font-medium mb-1">Regional</label>
          <select class="w-full px-3 py-2 text-sm rounded-lg bg-slate-700 bg-opacity-50 text-white border border-slate-600 focus:outline-none focus:border-blue-400">
            <option value="">REGIONAL</option>
            <option value="regional-1">REGIONAL 1</option>
            <option value="regional-2">REGIONAL 2</option>
            <option value="regional-3">REGIONAL 3</option>
            <option value="regional-7">REGIONAL 7</option>
            <option value="regional-8">REGIONAL 8</option>
          </select>
        </div>

        <!-- Nama Kebun Filter -->
        <div>
          <label class="block text-white text-xs md:text-sm font-medium mb-1">Nama Kebun</label>
          <select class="w-full px-3 py-2 text-sm rounded-lg bg-slate-700 bg-opacity-50 text-white border border-slate-600 focus:outline-none focus:border-blue-400">
            <option value="">NAMA KEBUN</option>
            <option value="kebun-1">Kebun A</option>
            <option value="kebun-2">Kebun B</option>
            <option value="kebun-3">Kebun C</option>
          </select>
        </div>
      </div>

      <!-- KPI Cards Section -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mb-6">
        <!-- Total Produksi -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h3 class="text-gray-300 text-xs font-medium mb-1">Total Produksi</h3>
          <p class="text-2xl md:text-3xl font-bold text-white">55.0K</p>
        </div>

        <!-- Jumlah Input Produksi -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h3 class="text-gray-300 text-xs font-medium mb-1">Jumlah Input Produksi</h3>
          <p class="text-2xl md:text-3xl font-bold text-white">4.9K</p>
        </div>

        <!-- KG/HK -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h3 class="text-gray-300 text-xs font-medium mb-1">KG/HK</h3>
          <p class="text-2xl md:text-3xl font-bold text-white">11.2</p>
        </div>

        <!-- Jumlah Karyawan -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h3 class="text-gray-300 text-xs font-medium mb-1">Jumlah Karyawan</h3>
          <p class="text-2xl md:text-3xl font-bold text-white">9.4K</p>
        </div>

        <!-- Presentase Produksi -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h3 class="text-gray-300 text-xs font-medium mb-1">Presentase Produksi</h3>
          <p class="text-2xl md:text-3xl font-bold text-white">585.76%</p>
        </div>

        <!-- Presentase Input Produksi -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h3 class="text-gray-300 text-xs font-medium mb-1">Presentase Input Produksi</h3>
          <p class="text-2xl md:text-3xl font-bold text-white">52.44%</p>
        </div>
      </div>

      <!-- Charts Section - By Regional -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
        <!-- Produksi Karet Chart -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h2 class="text-white text-xs md:text-sm font-bold mb-3 text-center">Produksi Karet</h2>
          <div class="relative h-56 md:h-64">
            <canvas id="produksiKaretChart"></canvas>
          </div>
        </div>

        <!-- Kapasitas Chart -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h2 class="text-white text-xs md:text-sm font-bold mb-3 text-center">Kapasitas</h2>
          <div class="relative h-56 md:h-64">
            <canvas id="kapasitasChart"></canvas>
          </div>
        </div>

        <!-- Produksi Karet sd Hari Ini Chart -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm lg:col-span-2">
          <h2 class="text-white text-xs md:text-sm font-bold mb-3 text-center">Produksi Karet sd Hari Ini</h2>
          <div class="relative h-56 md:h-64">
            <canvas id="produksiHariIniChart"></canvas>
          </div>
        </div>
      </div>

      <!-- Detail Charts Section - By Kebun -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Produksi Karet Detail Chart -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h2 class="text-white text-xs md:text-sm font-bold mb-3 text-center">Produksi Karet</h2>
          <div class="relative h-56 md:h-64">
            <canvas id="produksiKaretDetailChart"></canvas>
          </div>
        </div>

        <!-- Kapasitas Detail Chart -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h2 class="text-white text-xs md:text-sm font-bold mb-3 text-center">Kapasitas</h2>
          <div class="relative h-56 md:h-64">
            <canvas id="kapasitasDetailChart"></canvas>
          </div>
        </div>

        <!-- Produksi Karet sd Hari Ini Detail Chart -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm lg:col-span-2">
          <h2 class="text-white text-xs md:text-sm font-bold mb-3 text-center">Produksi Karet sd Hari Ini</h2>
          <div class="relative h-56 md:h-64">
            <canvas id="produksiHariIniDetailChart"></canvas>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // Chart Colors
  const chartColors = {
    blue: '#0EA5E9',
    cyan: '#06B6D4',
    purple: '#8B5CF6',
    primary: '#1E40AF',
    gridColor: 'rgba(148, 163, 184, 0.1)',
    textColor: '#E2E8F0',
  };

  // Chart Options Template
  const commonOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: true,
        labels: {
          color: chartColors.textColor,
          font: { size: 12, family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif" },
          padding: 15,
          usePointStyle: true,
        },
      },
    },
    scales: {
      x: {
        grid: { color: chartColors.gridColor, drawBorder: false },
        ticks: { color: chartColors.textColor, font: { size: 11 } },
      },
      y: {
        grid: { color: chartColors.gridColor, drawBorder: false },
        ticks: { color: chartColors.textColor, font: { size: 11 } },
      },
    },
  };

  // 1. Produksi Karet Chart
  const produksiKaretCtx = document.getElementById('produksiKaretChart').getContext('2d');
  new Chart(produksiKaretCtx, {
    type: 'bar',
    data: {
      labels: ['REGIONAL 2', 'REGIONAL 3', 'REGIONAL 7', 'REGIONAL 8'],
      datasets: [{
        label: 'Jumlah Produksi',
        data: [21798.02, 33199.29, 0, 0],
        backgroundColor: chartColors.blue,
        borderRadius: 6,
        borderSkipped: false,
      }],
    },
    options: {
      ...commonOptions,
      plugins: {
        ...commonOptions.plugins,
        legend: {
          ...commonOptions.plugins.legend,
          display: true,
        },
      },
    },
  });

  // 2. Kapasitas Chart
  const kapasitasCtx = document.getElementById('kapasitasChart').getContext('2d');
  new Chart(kapasitasCtx, {
    type: 'bar',
    data: {
      labels: ['REGIONAL 2', 'REGIONAL 3', 'REGIONAL 7', 'REGIONAL 8'],
      datasets: [{
        label: 'KG/HK',
        data: [9.07, 13.17, 0, 0],
        backgroundColor: chartColors.blue,
        borderRadius: 6,
        borderSkipped: false,
      }],
    },
    options: commonOptions,
  });

  // 3. Produksi Karet sd Hari Ini Chart (Grouped Bar)
  const produksiHariIniCtx = document.getElementById('produksiHariIniChart').getContext('2d');
  new Chart(produksiHariIniCtx, {
    type: 'bar',
    data: {
      labels: ['REGIONAL 2', 'REGIONAL 3', 'REGIONAL 7', 'REGIONAL 8'],
      datasets: [
        {
          label: 'Jumlah Input Produksi',
          data: [2404, 2520, 0, 0],
          backgroundColor: chartColors.blue,
          borderRadius: 6,
          borderSkipped: false,
        },
        {
          label: 'Jumlah Karyawan',
          data: [3417, 5096, 837, 39],
          backgroundColor: chartColors.cyan,
          borderRadius: 6,
          borderSkipped: false,
        },
      ],
    },
    options: {
      ...commonOptions,
      scales: {
        ...commonOptions.scales,
        x: {
          ...commonOptions.scales.x,
          stacked: false,
        },
        y: {
          ...commonOptions.scales.y,
          stacked: false,
        },
      },
    },
  });

  // ============================================
  // DETAIL CHARTS BY KEBUN
  // ============================================

  // 4. Produksi Karet Detail Chart (By Kebun)
  const produksiKaretDetailCtx = document.getElementById('produksiKaretDetailChart').getContext('2d');
  new Chart(produksiKaretDetailCtx, {
    type: 'bar',
    data: {
      labels: ['KEBUN GE...', 'KEBUN KA...', 'KEBUN SU...', 'KEBUN KR...', 'KEBUN MI...', 'KEBUN BE...', 'KEBUN CL...', 'KEBUN TE...', 'KEBUN AL...', 'KEBUN W.', 'KEBUN PA...', 'KEBUN CL...', 'KEBUN BE...', 'KEBUN BA...', 'KEBUN N...'],
      datasets: [{
        label: 'Jumlah Produksi',
        data: [4128, 8456, 3124, 5892, 1547, 3284, 2941, 3156, 2847, 1892, 2634, 2156, 1834, 1456, 3925],
        backgroundColor: chartColors.blue,
        borderRadius: 6,
        borderSkipped: false,
      }],
    },
    options: {
      ...commonOptions,
      scales: {
        ...commonOptions.scales,
        x: {
          ...commonOptions.scales.x,
          ticks: { ...commonOptions.scales.x.ticks, font: { size: 9 } },
        },
      },
    },
  });

  // 5. Kapasitas Detail Chart (By Kebun)
  const kapasitasDetailCtx = document.getElementById('kapasitasDetailChart').getContext('2d');
  new Chart(kapasitasDetailCtx, {
    type: 'bar',
    data: {
      labels: ['KEBUN GE...', 'KEBUN KA...', 'KEBUN SU...', 'KEBUN KR...', 'KEBUN MI...', 'KEBUN BE...', 'KEBUN CL...', 'KEBUN TE...', 'KEBUN AL...', 'KEBUN W.', 'KEBUN PA...', 'KEBUN CL...', 'KEBUN BE...', 'KEBUN BA...', 'KEBUN N...'],
      datasets: [{
        label: 'KG/HK',
        data: [8.24, 12.56, 9.84, 11.47, 7.92, 10.34, 9.68, 10.92, 9.24, 8.56, 9.12, 8.48, 7.64, 6.92, 10.56],
        backgroundColor: chartColors.blue,
        borderRadius: 6,
        borderSkipped: false,
      }],
    },
    options: {
      ...commonOptions,
      scales: {
        ...commonOptions.scales,
        x: {
          ...commonOptions.scales.x,
          ticks: { ...commonOptions.scales.x.ticks, font: { size: 9 } },
        },
      },
    },
  });

  // 6. Produksi Karet sd Hari Ini Detail Chart (Grouped Bar - By Kebun)
  const produksiHariIniDetailCtx = document.getElementById('produksiHariIniDetailChart').getContext('2d');
  new Chart(produksiHariIniDetailCtx, {
    type: 'bar',
    data: {
      labels: ['KEBUN GE...', 'KEBUN KA...', 'KEBUN SU...', 'KEBUN KR...', 'KEBUN MI...', 'KEBUN BE...', 'KEBUN CL...', 'KEBUN TE...', 'KEBUN AL...', 'KEBUN W.', 'KEBUN PA...', 'KEBUN CL...', 'KEBUN BE...', 'KEBUN BA...', 'KEBUN N...'],
      datasets: [
        {
          label: 'Jumlah Input Produksi',
          data: [2276, 2104, 940, 1040, 628, 1506, 487, 480, 1376, 373, 375, 160, 1642, 244, 3309],
          backgroundColor: chartColors.blue,
          borderRadius: 6,
          borderSkipped: false,
        },
        {
          label: 'Jumlah Karyawan',
          data: [3304, 3264, 2244, 1229, 512, 1513, 411, 1125, 390, 1078, 746, 703, 684, 513, 6125],
          backgroundColor: chartColors.cyan,
          borderRadius: 6,
          borderSkipped: false,
        },
      ],
    },
    options: {
      ...commonOptions,
      scales: {
        ...commonOptions.scales,
        x: {
          ...commonOptions.scales.x,
          stacked: false,
          ticks: { ...commonOptions.scales.x.ticks, font: { size: 9 } },
        },
        y: {
          ...commonOptions.scales.y,
          stacked: false,
        },
      },
    },
  });
</script>

<!-- Header Menu Dropdown Script -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const menuBtns = document.querySelectorAll('.menu-item-btn');
    
    menuBtns.forEach(btn => {
      btn.addEventListener('click', function(e) {
        e.stopPropagation();
        
        const menuId = this.getAttribute('data-menu');
        const dropdown = document.getElementById(menuId + '-dropdown');
        
        // Close all other dropdowns
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
          if (menu !== dropdown) {
            menu.classList.remove('show');
          }
        });
        
        document.querySelectorAll('.menu-item-btn').forEach(button => {
          if (button !== this) {
            button.classList.remove('show');
          }
        });
        
        // Toggle current dropdown
        dropdown.classList.toggle('show');
        this.classList.toggle('show');
      });
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
      if (!e.target.closest('.menu-item-dropdown')) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
          menu.classList.remove('show');
        });
        document.querySelectorAll('.menu-item-btn').forEach(btn => {
          btn.classList.remove('show');
        });
      }
    });
  });
</script>

@endsection

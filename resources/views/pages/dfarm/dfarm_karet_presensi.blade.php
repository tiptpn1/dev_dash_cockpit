
@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dfarm.css') }}">

<div class="gradient-container">
  @include('pages.dfarm.menu.header')

  <!-- Header Banner -->
  <div class="bg-gradient-to-r from-blue-700 to-blue-500 text-white py-4 px-6 shadow-lg flex-shrink-0">
    <div class="max-w-7xl mx-auto">
      <h1 class="text-2xl md:text-3xl font-bold">
        <span class="font-light">Presensi</span> <span class="italic">Regional</span>
      </h1>
    </div>
  </div>

  <!-- Main Content -->
  <div class="flex-1 overflow-y-auto">
    <div class="max-w-7xl mx-auto px-4 py-6">
      
      <!-- Filters Section -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
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
        <!-- Presensi Hadir -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h3 class="text-gray-300 text-xs font-medium mb-1">Presensi Hadir</h3>
          <p class="text-2xl md:text-3xl font-bold text-white">9.4K</p>
        </div>

        <!-- Jumlah Input Presensi -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h3 class="text-gray-300 text-xs font-medium mb-1">Jumlah Input Presensi</h3>
          <p class="text-2xl md:text-3xl font-bold text-white">10.4K</p>
        </div>

        <!-- Jumlah Karyawan (1) -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h3 class="text-gray-300 text-xs font-medium mb-1">Jumlah Karyawan</h3>
          <p class="text-2xl md:text-3xl font-bold text-white">14.0K</p>
        </div>

        <!-- Jumlah Karyawan (2) -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h3 class="text-gray-300 text-xs font-medium mb-1">Jumlah Karyawan</h3>
          <p class="text-2xl md:text-3xl font-bold text-white">14.0K</p>
        </div>

        <!-- Presentase Presensi -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h3 class="text-gray-300 text-xs font-medium mb-1">Presentase Presensi</h3>
          <p class="text-2xl md:text-3xl font-bold text-white">67.00%</p>
        </div>

        <!-- Presentase Input Presensi -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h3 class="text-gray-300 text-xs font-medium mb-1">Presentase Input Presensi</h3>
          <p class="text-2xl md:text-3xl font-bold text-white">74.28%</p>
        </div>
      </div>

      <!-- Charts Section - By Regional -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
        <!-- Presensi Chart -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h2 class="text-white text-xs md:text-sm font-bold mb-3 text-center">Presensi</h2>
          <div class="relative h-56 md:h-64">
            <canvas id="presensiChart"></canvas>
          </div>
        </div>

        <!-- Presentase Hadir Chart -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h2 class="text-white text-xs md:text-sm font-bold mb-3 text-center">Presentase Hadir</h2>
          <div class="relative h-56 md:h-64">
            <canvas id="presentaseHadirChart"></canvas>
          </div>
        </div>

        <!-- Presentase Input Chart -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm lg:col-span-2">
          <h2 class="text-white text-xs md:text-sm font-bold mb-3 text-center">Presentase Input</h2>
          <div class="relative h-56 md:h-64">
            <canvas id="presentaseInputChart"></canvas>
          </div>
        </div>
      </div>

      <!-- Detail Charts Section - By Kebun -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Presensi Detail Chart -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h2 class="text-white text-xs md:text-sm font-bold mb-3 text-center">Presensi</h2>
          <div class="relative h-56 md:h-64">
            <canvas id="presensiDetailChart"></canvas>
          </div>
        </div>

        <!-- Presentase Hadir Detail Chart -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h2 class="text-white text-xs md:text-sm font-bold mb-3 text-center">Presentase Hadir</h2>
          <div class="relative h-56 md:h-64">
            <canvas id="presentaseHadirDetailChart"></canvas>
          </div>
        </div>

        <!-- Presentase Input Detail Chart -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm lg:col-span-2">
          <h2 class="text-white text-xs md:text-sm font-bold mb-3 text-center">Presentase Input</h2>
          <div class="relative h-56 md:h-64">
            <canvas id="presentaseInputDetailChart"></canvas>
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

  // 1. Presensi Chart (Grouped Bar)
  const presensiCtx = document.getElementById('presensiChart').getContext('2d');
  new Chart(presensiCtx, {
    type: 'bar',
    data: {
      labels: ['REGIONAL 2', 'REGIONAL 3', 'REGIONAL 7', 'REGIONAL 8'],
      datasets: [
        {
          label: 'Jumlah Presensi Hadir',
          data: [3417, 5096, 837, 39],
          backgroundColor: chartColors.blue,
          borderRadius: 6,
          borderSkipped: false,
        },
        {
          label: 'Jumlah Karyawan',
          data: [3417, 5096, 837, 142],
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

  // 2. Presentase Hadir Chart (Stacked Bar)
  const presentaseHadirCtx = document.getElementById('presentaseHadirChart').getContext('2d');
  new Chart(presentaseHadirCtx, {
    type: 'bar',
    data: {
      labels: ['REGIONAL 7', 'REGIONAL 2', 'REGIONAL 3', 'REGIONAL 8'],
      datasets: [
        {
          label: 'Presentase Hadir',
          data: [47, 58, 78, 29],
          backgroundColor: chartColors.blue,
          borderRadius: 6,
          borderSkipped: false,
        },
        {
          label: 'Presentase Tidak Hadir',
          data: [53, 42, 22, 71],
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
          stacked: true,
        },
        y: {
          ...commonOptions.scales.y,
          stacked: true,
          max: 100,
        },
      },
    },
  });

  // 3. Presentase Input Chart (Grouped Bar)
  const presentaseInputCtx = document.getElementById('presentaseInputChart').getContext('2d');
  new Chart(presentaseInputCtx, {
    type: 'bar',
    data: {
      labels: ['REGIONAL 2', 'REGIONAL 3', 'REGIONAL 7', 'REGIONAL 8'],
      datasets: [
        {
          label: 'Jumlah Input Presensi',
          data: [3599, 5893, 866, 922],
          backgroundColor: chartColors.blue,
          borderRadius: 6,
          borderSkipped: false,
        },
        {
          label: 'Jumlah Karyawan',
          data: [4184, 8766, 142, 142],
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

  // 4. Presensi Detail Chart (Grouped Bar - By Kebun)
  const presensiDetailCtx = document.getElementById('presensiDetailChart').getContext('2d');
  new Chart(presensiDetailCtx, {
    type: 'bar',
    data: {
      labels: ['KEBUN GE...', 'KEBUN KA...', 'KEBUN SU...', 'KEBUN KR...', 'KEBUN MI...', 'KEBUN BE...', 'KEBUN CL...', 'KEBUN TE...', 'KEBUN AL...', 'KEBUN W.', 'KEBUN PA...', 'KEBUN CL...', 'KEBUN BE...', 'KEBUN BA...', 'KEBUN N...'],
      datasets: [
        {
          label: 'Jumlah Presensi Hadir',
          data: [641, 2278, 1241, 1292, 131, 506, 488, 427, 473, 464, 451, 429, 374, 361, 955],
          backgroundColor: chartColors.blue,
          borderRadius: 6,
          borderSkipped: false,
        },
        {
          label: 'Jumlah Karyawan',
          data: [707, 2104, 1348, 1225, 142, 480, 488, 474, 479, 413, 412, 425, 328, 304, 1025],
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

  // 5. Presentase Hadir Detail Chart (Stacked Bar - By Kebun)
  const presentaseHadirDetailCtx = document.getElementById('presentaseHadirDetailChart').getContext('2d');
  new Chart(presentaseHadirDetailCtx, {
    type: 'bar',
    data: {
      labels: ['KEBUN GE...', 'KEBUN KA...', 'KEBUN SU...', 'KEBUN KR...', 'KEBUN MI...', 'KEBUN BE...', 'KEBUN CL...', 'KEBUN TE...', 'KEBUN AL...', 'KEBUN W.', 'KEBUN PA...', 'KEBUN CL...', 'KEBUN BE...', 'KEBUN BA...', 'KEBUN N...'],
      datasets: [
        {
          label: 'Presentase Hadir',
          data: [91, 99, 92, 95, 92, 95, 100, 90, 99, 82, 86, 87, 73, 48, 93],
          backgroundColor: chartColors.blue,
          borderRadius: 6,
          borderSkipped: false,
        },
        {
          label: 'Presentase Tidak Hadir',
          data: [9, 1, 8, 5, 8, 5, 0, 10, 1, 18, 14, 13, 27, 52, 7],
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
          stacked: true,
          ticks: { ...commonOptions.scales.x.ticks, font: { size: 9 } },
        },
        y: {
          ...commonOptions.scales.y,
          stacked: true,
          max: 100,
        },
      },
    },
  });

  // 6. Presentase Input Detail Chart (Grouped Bar - By Kebun)
  const presentaseInputDetailCtx = document.getElementById('presentaseInputDetailChart').getContext('2d');
  new Chart(presentaseInputDetailCtx, {
    type: 'bar',
    data: {
      labels: ['KEBUN GE...', 'KEBUN KA...', 'KEBUN SU...', 'KEBUN KR...', 'KEBUN MI...', 'KEBUN BE...', 'KEBUN CL...', 'KEBUN TE...', 'KEBUN AL...', 'KEBUN W.', 'KEBUN PA...', 'KEBUN CL...', 'KEBUN BE...', 'KEBUN BA...', 'KEBUN N...'],
      datasets: [
        {
          label: 'Jumlah Input Presensi',
          data: [2276, 2104, 940, 1040, 628, 1506, 487, 480, 1376, 373, 375, 160, 1642, 244, 3309],
          backgroundColor: chartColors.blue,
          borderRadius: 6,
          borderSkipped: false,
        },
        {
          label: 'Jumlah Karyawan',
          data: [3304, 264, 244, 1229, 512, 513, 411, 125, 390, 78, 746, 703, 684, 513, 6125],
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

@include('pages.dfarm.menu.menu-script')

@endsection

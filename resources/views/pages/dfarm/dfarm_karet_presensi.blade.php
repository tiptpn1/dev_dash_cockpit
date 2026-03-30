
@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dfarm.css') }}">

<div class="gradient-container">
  @include('pages.dfarm.menu.headerkaret')

  <!-- Header Banner -->
  <div class="bg-gradient-to-r from-blue-700 to-blue-500 text-white py-4 px-6 shadow-lg flex-shrink-0">
    <div class="max-w-7xl mx-auto">
      <h1 class="text-2xl md:text-3xl font-bold">
        <span class="font-light">Presensi</span> <span class="italic">DFARM PTPN I</span>
      </h1>
    </div>
  </div>

  <!-- Main Content -->
  <div class="flex-1 overflow-y-auto">
    <div class="max-w-7xl mx-auto px-4 py-6">
      
      <!-- Filters Section -->
      <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-3 mb-4">
        <!-- Date Range Filter -->
        <div>
          <label class="block text-white text-xs md:text-sm font-medium mb-1">Periode</label>
          <div class="relative">
            <input 
              type="text" 
              id="dateRange"
              placeholder="Nov 5, 2024 - Nov 6, 2024" 
              readonly
              class="w-full px-3 py-2 text-sm rounded-lg bg-slate-700 bg-opacity-50 text-black placeholder-gray-400 border border-slate-600 focus:outline-none focus:border-blue-400 cursor-pointer font-medium"
            />
            <div id="datePickerPopup" class="hidden absolute top-full left-0 mt-2 bg-gray-900 rounded-lg border border-slate-600 shadow-lg p-4 z-50 min-w-max">
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="text-white text-xs mb-2 block">Dari Tanggal</label>
                  <input type="date" id="datePickerStart" class="w-full px-2 py-1 text-sm rounded bg-slate-700 text-black border border-slate-600 font-medium">
                </div>
                <div>
                  <label class="text-white text-xs mb-2 block">Sampai Tanggal</label>
                  <input type="date" id="datePickerEnd" class="w-full px-2 py-1 text-sm rounded bg-slate-700 text-black border border-slate-600 font-medium">
                </div>
              </div>
              <div class="flex gap-2 mt-3">
                <button id="datePickerApply" class="flex-1 px-3 py-1 bg-blue-600 hover:bg-blue-700 text-black text-xs rounded transition-colors">Terapkan</button>
                <button id="datePickerCancel" class="flex-1 px-3 py-1 bg-slate-600 hover:bg-slate-700 text-black text-xs rounded transition-colors">Batal</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Regional Filter -->
        <div>
          <label class="block text-white text-xs md:text-sm font-medium mb-1">Regional</label>
          <select id="selectRegional" class="w-full px-3 py-2 text-sm rounded-lg bg-slate-700 bg-opacity-50 text-black border border-slate-600 focus:outline-none focus:border-blue-400 font-medium">
            <option value="">Pilih</option>
            <option value="2" <?php if ($selectedRegional == '2') echo 'selected'; ?>>REGIONAL 2</option>
            <option value="3" <?php if ($selectedRegional == '3') echo 'selected'; ?>>REGIONAL 3</option>
            <option value="5" <?php if ($selectedRegional == '5') echo 'selected'; ?>>REGIONAL 5</option>
            <option value="7" <?php if ($selectedRegional == '7') echo 'selected'; ?>>REGIONAL 7</option>
            <option value="8" <?php if ($selectedRegional == '8') echo 'selected'; ?>>REGIONAL 8</option>
          </select>
        </div>

        <!-- Nama Kebun Filter -->
        <div class="flex flex-col">
          <label class="block text-white text-xs md:text-sm font-medium mb-1">Nama Kebun</label>
          <div class="flex gap-2 h-full">
            <select id="selectKebun" class="flex-1 px-3 py-2 text-sm rounded-lg bg-slate-700 bg-opacity-50 text-black border border-slate-600 focus:outline-none focus:border-blue-400 font-medium">
              <option value="">Pilih</option>
              <?php
                foreach ($allDatakebun as $key) {
                  echo '<option value="' . $key->kebun_id . '"';
                  if ($selectedKebun == $key->kebun_id) echo ' selected';
                  echo '>' . $key->nama_kebun . '</option>';
                } 
              ?>
            </select>
            <!-- Filter Button -->
            <button id="btnFilter" class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors whitespace-nowrap">
              <i class="fa-solid fa-filter" style="margin-right: 6px;"></i>Filter
            </button>
            <button id="btnReset" class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors whitespace-nowrap">
              <i class="fa-solid fa-rotate-right" style="margin-right: 6px;"></i>Reset
            </button>
          </div>
        </div>
      </div>

      <!-- KPI Cards Section -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mb-6">
        <!-- Presensi Hadir -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h3 class="text-gray-300 text-xs font-medium mb-1">Presensi Hadir</h3>
          <p class="text-2xl md:text-3xl font-bold text-white">{{$totalData['kehadiran']}} Org</p>
        </div>

        <!-- Jumlah Input Presensi -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h3 class="text-gray-300 text-xs font-medium mb-1">Jumlah Input Presensi</h3>
          <p class="text-2xl md:text-3xl font-bold text-white">{{$totalData['total_pegawai']-$totalData['belum_hadir']}} Org</p>
        </div>

        <!-- Jumlah Pemanen -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h3 class="text-gray-300 text-xs font-medium mb-1">Jumlah Pemanen</h3>
          <p class="text-2xl md:text-3xl font-bold text-white">{{$totalData['total_pegawai']}} Org</p>
        </div>

        <!-- Persentase Kehadiran -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h3 class="text-gray-300 text-xs font-medium mb-1">Persentase Kehadiran</h3>
          <p class="text-2xl md:text-3xl font-bold text-white">{{$totalData['prosentase_kehadiran']}}%</p>
        </div>

        <!-- Presentase Presensi -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h3 class="text-gray-300 text-xs font-medium mb-1">Presentase Input Presensi</h3>
          <p class="text-2xl md:text-3xl font-bold text-white">{{$totalData['prosentase']}}%</p>
        </div>

        <!-- Presentase Input Presensi -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h3 class="text-gray-300 text-xs font-medium mb-1">Presentase Tidak Input</h3>
          <p class="text-2xl md:text-3xl font-bold text-white">{{100-$totalData['prosentase']}}%</p>
        </div>
      </div>
      @if($selectedRegional =="")
      <!-- Charts Section - By Regional -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
        <!-- Presensi Chart -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h2 class="text-white text-xs md:text-sm font-bold mb-3 text-center">Presentase Input Presensi</h2>
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
          <h2 class="text-white text-xs md:text-sm font-bold mb-3 text-center">Perbandingan Input Presensi & Jumlah Pemanen</h2>
          <div class="relative h-56 md:h-64">
            <canvas id="presentaseInputChart"></canvas>
          </div>
        </div>
      </div>
      @endif
      @if($selectedRegional !="" && $selectedKebun =="")  
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
      @endif
      @if($selectedRegional !="" && $selectedKebun !="")
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
      @endif
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
    red: '#EF4444',
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

  @if($selectedRegional == "")
    // 1. Presensi Chart (Grouped Bar)
    const presensiCtx = document.getElementById('presensiChart').getContext('2d');
    new Chart(presensiCtx, {
      type: 'bar',
      data: {
        labels: [
          @for ($i = 0; $i < count($presensiData); $i++) 
            '{{ $presensiData[$i]->regional }}',
          @endfor
        ],
        datasets: [
          {
            label: '% Input Presensi',
            data: [
              @for ($i = 0; $i < count($presensiData); $i++)
                {{ $presensiData[$i]->prosentase }},
              @endfor
            ],
            backgroundColor: chartColors.blue,
            borderRadius: 6,
            borderSkipped: false,
          },
          {
            label: '% Belum Input Presensi',
            data: [
              @for ($i = 0; $i < count($presensiData); $i++)
                {{ 100 - $presensiData[$i]->prosentase }},
              @endfor
            ],
            backgroundColor: chartColors.red,
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
          },
        },
      },
    });

    // 2. Presentase Hadir Chart (Stacked Bar)
    const presentaseHadirCtx = document.getElementById('presentaseHadirChart').getContext('2d');
    new Chart(presentaseHadirCtx, {
      type: 'bar',
      data: {
        labels: [
          @for ($i = 0; $i < count($presensiData); $i++) 
            '{{ $presensiData[$i]->regional }}',
          @endfor
        ],
        datasets: [
          {
            label: '% Hadir',
            data: [
              @for ($i = 0; $i < count($presensiData); $i++)
                {{ $presensiData[$i]->prosentase_kehadiran }},
              @endfor
            ],
            backgroundColor: chartColors.blue,
            borderRadius: 6,
            borderSkipped: false,
          },
          {
            label: '% Tidak Hadir',
            data: [
              @for ($i = 0; $i < count($presensiData); $i++)
                {{ 100 - $presensiData[$i]->prosentase_kehadiran }},
              @endfor
            ],
            backgroundColor: chartColors.red,
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
        labels: [
          @for ($i = 0; $i < count($presensiData); $i++) 
            '{{ $presensiData[$i]->regional }}',
          @endfor
        ],
        datasets: [
          {
            label: 'Jumlah Input Presensi',
            data: [
              @for ($i = 0; $i < count($presensiData); $i++)
                {{ $presensiData[$i]->total_pegawai - $presensiData[$i]->belum_hadir }},
              @endfor
            ],
            backgroundColor: chartColors.blue,
            borderRadius: 6,
            borderSkipped: false,
          },
          {
            label: 'Jumlah Karyawan',
            data: [
              @for ($i = 0; $i < count($presensiData); $i++)
                {{ $presensiData[$i]->total_pegawai }},
              @endfor
            ],
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
  @endif

  // ============================================
  // DETAIL CHARTS BY KEBUN
  // ============================================

  @if($selectedRegional != "" && $selectedKebun == "")
    // 4. Presensi Detail Chart (Grouped Bar - By Kebun)
    const presensiDetailCtx = document.getElementById('presensiDetailChart').getContext('2d');
    new Chart(presensiDetailCtx, {
      type: 'bar',
      data: {
        labels: [
          @for ($i = 0; $i < count($presensiData); $i++) 
            '{{ str_replace('KEBUN ', '', $presensiData[$i]->kebun) }}',
          @endfor
        ],
        datasets: [
          {
            label: '% Input Presensi',
            data: [
              @for ($i = 0; $i < count($presensiData); $i++)
                {{ $presensiData[$i]->prosentase }},
              @endfor
            ],
            backgroundColor: chartColors.blue,
            borderRadius: 6,
            borderSkipped: false,
          },
          {
            label: '% Tidak Input Presensi',
            data: [
              @for ($i = 0; $i < count($presensiData); $i++)
                {{ 100 - $presensiData[$i]->prosentase }},
              @endfor
            ],
            backgroundColor: chartColors.red,
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
          },
        },
      },
    });

    // 5. Presentase Hadir Detail Chart (Stacked Bar - By Kebun)
    const presentaseHadirDetailCtx = document.getElementById('presentaseHadirDetailChart').getContext('2d');
    new Chart(presentaseHadirDetailCtx, {
      type: 'bar',
      data: {
        labels: [
          @for ($i = 0; $i < count($presensiData); $i++) 
            '{{ str_replace('KEBUN ', '', $presensiData[$i]->kebun) }}',
          @endfor
        ],
        datasets: [
          {
            label: '% Hadir',
            data: [
              @for ($i = 0; $i < count($presensiData); $i++)
                {{ $presensiData[$i]->prosentase_kehadiran }},
              @endfor
            ],
            backgroundColor: chartColors.blue,
            borderRadius: 6,
            borderSkipped: false,
          },
          {
            label: '% Tidak Hadir',
            data: [
              @for ($i = 0; $i < count($presensiData); $i++)
                {{ 100 - $presensiData[$i]->prosentase_kehadiran }},
              @endfor
            ],
            backgroundColor: chartColors.red,
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
        labels: [
          @for ($i = 0; $i < count($presensiData); $i++) 
            '{{ str_replace('KEBUN ', '', $presensiData[$i]->kebun) }}',
          @endfor
        ],
        datasets: [
          {
            label: 'Jumlah Input Presensi',
            data: [
              @for ($i = 0; $i < count($presensiData); $i++)
                {{ $presensiData[$i]->total_pegawai - $presensiData[$i]->belum_hadir }},
              @endfor
            ],
            backgroundColor: chartColors.blue,
            borderRadius: 6,
            borderSkipped: false,
          },
          {
            label: 'Jumlah Pemanen',
            data: [
              @for ($i = 0; $i < count($presensiData); $i++)
                {{ $presensiData[$i]->total_pegawai }},
              @endfor
            ],
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
  @endif

  @if($selectedRegional != "" && $selectedKebun != "")
    // 4. Presensi Detail Chart (Grouped Bar - By Kebun)
    const presensiDetailCtx = document.getElementById('presensiDetailChart').getContext('2d');
    new Chart(presensiDetailCtx, {
      type: 'bar',
      data: {
        labels: [
          @for ($i = 0; $i < count($presensiData); $i++) 
            '{{ str_replace('KEBUN ', '', $presensiData[$i]->afdeling) }}',
          @endfor
        ],
        datasets: [
          {
            label: '% Input Presensi',
            data: [
              @for ($i = 0; $i < count($presensiData); $i++)
                {{ $presensiData[$i]->prosentase }},
              @endfor
            ],
            backgroundColor: chartColors.blue,
            borderRadius: 6,
            borderSkipped: false,
          },
          {
            label: '% Tidak Input Presensi',
            data: [
              @for ($i = 0; $i < count($presensiData); $i++)
                {{ 100 - $presensiData[$i]->prosentase }},
              @endfor
            ],
            backgroundColor: chartColors.red,
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
          },
        },
      },
    });

    // 5. Presentase Hadir Detail Chart (Stacked Bar - By Kebun)
    const presentaseHadirDetailCtx = document.getElementById('presentaseHadirDetailChart').getContext('2d');
    new Chart(presentaseHadirDetailCtx, {
      type: 'bar',
      data: {
        labels: [
          @for ($i = 0; $i < count($presensiData); $i++) 
            '{{ str_replace('KEBUN ', '', $presensiData[$i]->afdeling) }}',
          @endfor
        ],
        datasets: [
          {
            label: '% Hadir',
            data: [
              @for ($i = 0; $i < count($presensiData); $i++)
                {{ $presensiData[$i]->prosentase_kehadiran }},
              @endfor
            ],
            backgroundColor: chartColors.blue,
            borderRadius: 6,
            borderSkipped: false,
          },
          {
            label: '% Tidak Hadir',
            data: [
              @for ($i = 0; $i < count($presensiData); $i++)
                {{ 100 - $presensiData[$i]->prosentase_kehadiran }},
              @endfor
            ],
            backgroundColor: chartColors.red,
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
        labels: [
          @for ($i = 0; $i < count($presensiData); $i++) 
            '{{ str_replace('KEBUN ', '', $presensiData[$i]->afdeling) }}',
          @endfor
        ],
        datasets: [
          {
            label: 'Jumlah Input Presensi',
            data: [
              @for ($i = 0; $i < count($presensiData); $i++)
                {{ $presensiData[$i]->total_pegawai - $presensiData[$i]->belum_hadir }},
              @endfor
            ],
            backgroundColor: chartColors.blue,
            borderRadius: 6,
            borderSkipped: false,
          },
          {
            label: 'Jumlah Pemanen',
            data: [
              @for ($i = 0; $i < count($presensiData); $i++)
                {{ $presensiData[$i]->total_pegawai }},
              @endfor
            ],
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
  @endif
</script>

<!-- Date Range Picker Script -->
<script>
  // Format tanggal ke "MMM D, YYYY" format
  function formatDate(date) {
    return new Date(date).toLocaleDateString('id-ID', { 
      year: 'numeric', 
      month: 'short', 
      day: 'numeric' 
    });
  }

  // Date Range Picker Elements
  const dateRangeInput = document.getElementById('dateRange');
  const datePickerPopup = document.getElementById('datePickerPopup');
  const datePickerStart = document.getElementById('datePickerStart');
  const datePickerEnd = document.getElementById('datePickerEnd');
  const datePickerApply = document.getElementById('datePickerApply');
  const datePickerCancel = document.getElementById('datePickerCancel');

  // Set default dates (today dan 7 hari lalu)
  const today = new Date();
  const sevenDaysAgo = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);
  
  // Get URL parameters
  const urlParams = new URLSearchParams(window.location.search);
  const tglAwalParam = urlParams.get('tgl_awal');
  const tglAkhirParam = urlParams.get('tgl_akhir');
  const idRegParam = urlParams.get('id_reg');
  const kodeKebunParam = urlParams.get('kode_kebun');

  // Set date values dari parameter atau default
  datePickerStart.value = tglAwalParam || sevenDaysAgo.toISOString().split('T')[0];
  datePickerEnd.value = tglAkhirParam || today.toISOString().split('T')[0];
  
  // Set select values dari parameter
  if (idRegParam) document.getElementById('selectRegional').value = idRegParam;
  if (kodeKebunParam) document.getElementById('selectKebun').value = kodeKebunParam;
  
  // Update display
  function updateDateDisplay() {
    if (datePickerStart.value && datePickerEnd.value) {
      dateRangeInput.value = `${formatDate(datePickerStart.value)} - ${formatDate(datePickerEnd.value)}`;
    }
  }
  updateDateDisplay();

  // Toggle popup
  dateRangeInput.addEventListener('click', () => {
    datePickerPopup.classList.toggle('hidden');
  });

  // Apply button
  datePickerApply.addEventListener('click', () => {
    if (datePickerStart.value && datePickerEnd.value) {
      if (new Date(datePickerStart.value) <= new Date(datePickerEnd.value)) {
        updateDateDisplay();
        datePickerPopup.classList.add('hidden');
        console.log('Range terpilih:', datePickerStart.value, 'hingga', datePickerEnd.value);
        // TODO: Trigger API call atau filter dengan tanggal terpilih
      } else {
        alert('Tanggal awal harus lebih kecil dari tanggal akhir');
      }
    }
  });

  // Cancel button
  datePickerCancel.addEventListener('click', () => {
    datePickerPopup.classList.add('hidden');
  });

  // Close popup when clicking outside
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.relative')) {
      datePickerPopup.classList.add('hidden');
    }
  });

  // Allow Enter key to apply
  document.addEventListener('keypress', (e) => {
    if (e.key === 'Enter' && !datePickerPopup.classList.contains('hidden')) {
      datePickerApply.click();
    }
  });

  // Regional Select Change - Load Kebun Data via AJAX
  document.getElementById('selectRegional').addEventListener('change', function() {
    const regionalId = this.value;
    const selectKebun = document.getElementById('selectKebun');

    if (!regionalId) {
      // Reset select kebun jika regional tidak dipilih
      selectKebun.innerHTML = '<option value="">Pilih</option>';
      return;
    }

    // Show loading state
    selectKebun.innerHTML = '<option value="">Loading...</option>';

    // AJAX call ke get_data_kebun
    fetch('{{ route('get_data_kebun') }}?id_reg=' + regionalId + '&komoditas=2', {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(response => response.json())
    .then(data => {
      // Clear options
      selectKebun.innerHTML = '<option value="">Pilih</option>';

      // Populate options dari response
      if (data.data && data.data.length > 0) {
        // Create a map to store unique kebun by ID
        const uniqueKebun = new Map();
        
        data.data.forEach(item => {
          if (!uniqueKebun.has(item.kebun_id)) {
            uniqueKebun.set(item.kebun_id, item.nama_kebun);
          }
        });

        // Add options to select
        uniqueKebun.forEach((nama, kebunId) => {
          const option = document.createElement('option');
          option.value = kebunId;
          option.textContent = nama;
          selectKebun.appendChild(option);
        });
      } else {
        selectKebun.innerHTML = '<option value="">Tidak ada data kebun</option>';
      }
    })
    .catch(error => {
      console.error('Error:', error);
      selectKebun.innerHTML = '<option value="">Error loading data</option>';
    });
  });

  // Filter Button Handler
  document.getElementById('btnFilter').addEventListener('click', () => {
    const tglAwal = datePickerStart.value;
    const tglAkhir = datePickerEnd.value;
    const idReg = document.getElementById('selectRegional').value;
    const kodeKebun = document.getElementById('selectKebun').value;

    // Validasi input
    if (!tglAwal || !tglAkhir) {
      alert('Silakan pilih periode terlebih dahulu');
      return;
    }

    // Build URL dengan parameter
    let url = window.location.pathname + '?';
    const params = [];
    
    if (tglAwal) params.push('tgl_awal=' + tglAwal);
    if (tglAkhir) params.push('tgl_akhir=' + tglAkhir);
    if (idReg) params.push('id_reg=' + idReg);
    if (kodeKebun) params.push('kode_kebun=' + kodeKebun);

    url += params.join('&');

    // Reload halaman dengan parameter baru
    window.location.href = url;
  });

  // Reset Button Handler
  document.getElementById('btnReset').addEventListener('click', () => {
    // Clear semua filter
    document.getElementById('selectRegional').value = '';
    document.getElementById('selectKebun').value = '';
    
    // Reset ke halaman tanpa parameter
    window.location.href = window.location.pathname;
  });
</script>

@include('pages.dfarm.menu.menu-script')

@endsection

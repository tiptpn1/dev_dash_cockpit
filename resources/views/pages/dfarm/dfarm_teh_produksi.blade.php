
@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dfarm.css') }}">

<div class="gradient-container">
  @include('pages.dfarm.menu.headerkaret')

  <!-- Header Banner -->
  <div class="bg-gradient-to-r from-blue-700 to-blue-500 text-white py-4 px-6 shadow-lg flex-shrink-0">
    <div class="max-w-7xl mx-auto">
      <h1 class="text-2xl md:text-3xl font-bold">
        <span class="font-light">Produksi Teh</span> <span class="italic">DFARM PTPN I</span>
      </h1>
    </div>
  </div>

  <!-- Main Content -->
  <div class="flex-1 overflow-y-auto">
    <div class="max-w-7xl mx-auto px-4 py-6">
      
      <!-- Error Notification Popup -->
      <div id="errorPopup" class="hidden fixed top-20 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3 z-50 animate-slide-in">
        <div class="flex-1">
          <p id="errorMessage" class="text-sm font-medium"></p>
        </div>
        <button id="closeErrorBtn" class="text-white hover:text-gray-200 transition-colors">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <style>
        @keyframes slide-in {
          from {
            transform: translateX(400px);
            opacity: 0;
          }
          to {
            transform: translateX(0);
            opacity: 1;
          }
        }
        
        @keyframes slide-out {
          from {
            transform: translateX(0);
            opacity: 1;
          }
          to {
            transform: translateX(400px);
            opacity: 0;
          }
        }
        
        .animate-slide-in {
          animation: slide-in 0.3s ease-out;
        }
        
        .animate-slide-out {
          animation: slide-out 0.3s ease-out;
        }
      </style>
      
      <!-- Filters Section -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3 mb-4">

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
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
        <!-- Presensi Hadir -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h3 class="text-gray-300 text-xs font-medium mb-1">Panen Manual</h3>
          <p class="text-2xl md:text-3xl font-bold text-white">{{number_format($totalData['panen_manual'], 0, ',', '.') }} Kg</p>
        </div>

        <!-- Jumlah Input Presensi -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h3 class="text-gray-300 text-xs font-medium mb-1">Panen Gunting</h3>
          <p class="text-2xl md:text-3xl font-bold text-white">{{number_format($totalData['panen_gunting'], 0, ',', '.') }} Kg</p>
        </div>

        <!-- Jumlah Karyawan -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h3 class="text-gray-300 text-xs font-medium mb-1">Panen Mesin</h3>
          <p class="text-2xl md:text-3xl font-bold text-white">{{number_format($totalData['panen_mesin_individu'], 0, ',', '.') }} Kg</p>
        </div>

        <!-- Persentase Kehadiran -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h3 class="text-gray-300 text-xs font-medium mb-1">Total</h3>
          <p class="text-2xl md:text-3xl font-bold text-white">{{number_format($totalData['total'], 0, ',', '.') }} Kg</p>
        </div>

        </div>
      <!-- Charts Section - By Regional -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
        <!-- Presentase Input Chart -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h2 class="text-white text-xs md:text-sm font-bold mb-3 text-center">Produksi Kebun</h2>
          <div class="relative h-56 md:h-64">
            <canvas id="presentaseInputChartBasah"></canvas>
          </div>
        </div>

        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h2 class="text-white text-xs md:text-sm font-bold mb-3 text-center">Produksi Kering</h2>
          <div class="relative h-56 md:h-64">
            <canvas id="presentaseInputChart"></canvas>
          </div>
        </div>
        
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-1 gap-4 mb-6">
        <!-- Presentase Input Chart -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 border border-slate-600 shadow-lg backdrop-blur-sm">
          <h2 class="text-white text-xs md:text-sm font-bold mb-3 text-center">% Input Produksi</h2>
          <div class="relative h-56 md:h-64">
            <canvas id="presentaseInputProduksiChart"></canvas>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // ============================================
  // ERROR NOTIFICATION HANDLER
  // ============================================
  function showErrorPopup(message) {
    const errorPopup = document.getElementById('errorPopup');
    const errorMessage = document.getElementById('errorMessage');
    
    errorMessage.textContent = message;
    errorPopup.classList.remove('hidden', 'animate-slide-out');
    errorPopup.classList.add('animate-slide-in');
    
    // Auto-hide setelah 3 detik
    setTimeout(() => {
      errorPopup.classList.remove('animate-slide-in');
      errorPopup.classList.add('animate-slide-out');
      setTimeout(() => {
        errorPopup.classList.add('hidden');
      }, 300);
    }, 3000);
  }

  // Close button handler
  document.getElementById('closeErrorBtn').addEventListener('click', () => {
    const errorPopup = document.getElementById('errorPopup');
    errorPopup.classList.remove('animate-slide-in');
    errorPopup.classList.add('animate-slide-out');
    setTimeout(() => {
      errorPopup.classList.add('hidden');
    }, 300);
  });

  // Check untuk error dari session
  @if($errors->has('msg'))
    showErrorPopup('{{ $errors->first('msg') }}');
  @endif

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

    // 3. Presentase Input Chart (Grouped Bar)
    const presentaseInputCtx = document.getElementById('presentaseInputChart').getContext('2d');
    new Chart(presentaseInputCtx, {
      type: 'bar',
      data: {
        labels: [
          @for ($i = 0; $i < count($prestasiData); $i++) 
            '{{ $prestasiData[$i]->nama }}',
          @endfor
        ],
        datasets: [
          {
            label: 'Total (Kg)',
            data: [
              @for ($i = 0; $i < count($prestasiData); $i++)
                {{ $prestasiData[$i]->total }},
              @endfor
            ],
            backgroundColor: chartColors.blue,
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
    // 5. Presentase Input Chart (Grouped Bar)
    const presentaseInputBasahCtx = document.getElementById('presentaseInputChartBasah').getContext('2d');
    new Chart(presentaseInputBasahCtx, {
      type: 'bar',
      data: {
        labels: [
          @for ($i = 0; $i < count($prestasiData); $i++) 
            '{{ $prestasiData[$i]->nama }}',
          @endfor
        ],
        datasets: [
          {
            label: 'Panen Manual (Kg)',
            data: [
              @for ($i = 0; $i < count($prestasiData); $i++)
                {{ $prestasiData[$i]->panen_manual }},
              @endfor
            ],
            backgroundColor: chartColors.blue,
            borderRadius: 6,
            borderSkipped: false,
          },
          {
            label: 'Panen Gunting (Kg)',
            data: [
              @for ($i = 0; $i < count($prestasiData); $i++)
                {{ $prestasiData[$i]->panen_gunting }},
              @endfor
            ],
            backgroundColor: chartColors.cyan,
            borderRadius: 6,
            borderSkipped: false,
          },
          {
            label: 'Panen Mesin (Kg)',
            data: [
              @for ($i = 0; $i < count($prestasiData); $i++)
                {{ $prestasiData[$i]->panen_mesin_individu }},
              @endfor
            ],
            backgroundColor: chartColors.purple,
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

    // 5. Presentase Input Chart (Grouped Bar)
    const presentaseInputProduksiCtx = document.getElementById('presentaseInputProduksiChart').getContext('2d');
    new Chart(presentaseInputProduksiCtx, {
      type: 'bar',
      data: {
        labels: [
          @for ($i = 0; $i < count($prestasiDataLite); $i++) 
            '{{ $prestasiDataLite[$i]->nama }}',
          @endfor
        ],
        datasets: [
          {
            label: '% Input',
            data: [
              @for ($i = 0; $i < count($prestasiDataLite); $i++)
                {{ min(100, $prestasiDataLite[$i]->persen_input_produksi) }},
              @endfor
            ],
            backgroundColor: chartColors.blue,
            borderRadius: 6,
            borderSkipped: false,
          },
          {
            label: '% Tidak Input',
            data: [
              @for ($i = 0; $i < count($prestasiDataLite); $i++)
                {{ max(0, 100 - min(100, $prestasiDataLite[$i]->persen_input_produksi)) }},
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

  // Get default dates dari controller
  const tglAwalDefault = '{{ $tglAwal ?? '' }}';
  const tglAkhirDefault = '{{ $tglAkhir ?? '' }}';
  
  // Get URL parameters
  const urlParams = new URLSearchParams(window.location.search);
  const tglAwalParam = urlParams.get('tgl_awal');
  const tglAkhirParam = urlParams.get('tgl_akhir');
  const idRegParam = urlParams.get('id_reg');
  const kodeKebunParam = urlParams.get('kode_kebun');

  // Set date values dari parameter atau default dari controller
  datePickerStart.value = tglAwalParam || tglAwalDefault;
  datePickerEnd.value = tglAkhirParam || tglAkhirDefault;
  
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
    fetch('{{ route('get_data_kebun') }}?id_reg=' + regionalId + '&komoditas=1', {
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

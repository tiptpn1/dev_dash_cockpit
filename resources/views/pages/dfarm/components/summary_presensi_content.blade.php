<!-- KPI Cards Section (Summary Gabungan) -->
@php
  $latestMonth = $monthlySummary['endMonth'] ?? (int)date('n');
  $latestCorp = $monthlySummary['corporateByMonth'][$latestMonth] ?? null;
  $totalTenagaKerja = 0;
  if (!empty($monthlySummary['dataByRegional'])) {
    foreach($monthlySummary['dataByRegional'] as $r) {
      $totalTenagaKerja += $r['total_karyawan'] ?? 0;
    }
  }
  
  $bestRegName = '-';
  $bestRegPercent = -1;
  if (!empty($monthlySummary['dataByRegional'])) {
    foreach($monthlySummary['dataByRegional'] as $r) {
      $pct = $r['months'][$latestMonth]['prosentase_kehadiran'] ?? 0;
      if ($pct > $bestRegPercent) {
        $bestRegPercent = $pct;
        $bestRegName = $r['name'];
      }
    }
  }
@endphp
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6" style="margin: 0 16px 20px;">
  <!-- Card 1: Rata-rata % Kehadiran Bulan Berjalan -->
  <div style="background: #fff; border: 1px solid #d1fae5; border-top: 4px solid #166534; border-radius: 8px; padding: 18px; box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08);">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
      <h3 style="color: #166534; font-size: 11px; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">% Kehadiran Gabungan</h3>
      <i class="fas fa-percent" style="color: #16a34a; font-size: 18px;"></i>
    </div>
    <p style="color: #166534; font-size: 26px; font-weight: 800; margin: 0; line-height: 1;">{{ $latestCorp['prosentase_kehadiran'] ?? 0 }}%</p>
    <p style="color: #6b7280; font-size: 11px; margin: 4px 0 0 0;">Bulan {{ $monthlySummary['months'][$latestMonth] ?? '' }} {{ $monthlySummary['tahun'] ?? date('Y') }} (Akumulasi)</p>
  </div>

  <!-- Card 2: Rata-rata % Input Presensi Bulan Berjalan -->
  <div style="background: #fff; border: 1px solid #d1fae5; border-top: 4px solid #166534; border-radius: 8px; padding: 18px; box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08);">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
      <h3 style="color: #166534; font-size: 11px; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">% Input Presensi Gabungan</h3>
      <i class="fas fa-clipboard-check" style="color: #16a34a; font-size: 18px;"></i>
    </div>
    <p style="color: #166534; font-size: 26px; font-weight: 800; margin: 0; line-height: 1;">{{ $latestCorp['prosentase_input'] ?? 0 }}%</p>
    <p style="color: #6b7280; font-size: 11px; margin: 4px 0 0 0;">Kepatuhan Input Presensi</p>
  </div>

  <!-- Card 3: Total Tenaga Kerja Terdaftar -->
  <div style="background: #fff; border: 1px solid #d1fae5; border-top: 4px solid #166534; border-radius: 8px; padding: 18px; box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08);">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
      <h3 style="color: #166534; font-size: 11px; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Total Tenaga Kerja</h3>
      <i class="fas fa-users" style="color: #16a34a; font-size: 18px;"></i>
    </div>
    <p style="color: #166534; font-size: 26px; font-weight: 800; margin: 0; line-height: 1;">{{ number_format($totalTenagaKerja, 0, ',', '.') }}</p>
    <p style="color: #6b7280; font-size: 11px; margin: 4px 0 0 0;">Orang Terdaftar di Gabungan</p>
  </div>

  <!-- Card 4: Top Regional Performer -->
  <div style="background: #fff; border: 1px solid #d1fae5; border-top: 4px solid #166534; border-radius: 8px; padding: 18px; box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08);">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
      <h3 style="color: #166534; font-size: 11px; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Best Performer Bulan Ini</h3>
      <i class="fas fa-trophy" style="color: #eab308; font-size: 18px;"></i>
    </div>
    <p style="color: #166534; font-size: 20px; font-weight: 800; margin: 0; line-height: 1.2;">{{ $bestRegName }}</p>
    <p style="color: #16a34a; font-size: 12px; font-weight: 700; margin: 4px 0 0 0;">{{ $bestRegPercent >= 0 ? $bestRegPercent . '% Kehadiran' : '-' }}</p>
  </div>
</div>

<!-- Line Chart Card -->
<div style="margin: 0 16px 24px; background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
  <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid #f3f4f6;">
    <div>
      <h2 style="font-size: 15px; font-weight: 700; color: #166534; margin: 0;">
        <i class="fas fa-chart-line" style="margin-right: 6px;"></i> Tren Perbandingan Persentase Presensi Tiap Regional (Jan - {{ !empty($monthlySummary['months']) ? end($monthlySummary['months']) : '' }} {{ $monthlySummary['tahun'] ?? date('Y') }})
      </h2>
      <p style="font-size: 12px; color: #6b7280; margin: 4px 0 0 0;">
        Menampilkan perbandingan akumulasi bulanan persentase presensi tiap regional di tahun berjalan.
      </p>
    </div>
    <!-- Metric Selector Buttons -->
    <div style="display: flex; background: #f3f4f6; border-radius: 8px; padding: 3px; gap: 4px;">
      <button id="btnMetricKehadiran" type="button" class="px-3 py-1.5 text-xs font-semibold rounded-md transition-all" style="background: #166534; color: #fff; border: none; cursor: pointer;">
        % Kehadiran
      </button>
      <button id="btnMetricInput" type="button" class="px-3 py-1.5 text-xs font-semibold rounded-md transition-all" style="background: transparent; color: #4b5563; border: none; cursor: pointer;">
        % Input Presensi
      </button>
    </div>
  </div>

  <!-- Canvas for Chart.js -->
  <div id="summaryLineChartWrap" style="position: relative; height: 380px; width: 100%;">
    <canvas id="summaryLineChart" height="380" style="display: block; width: 100%; height: 380px; max-height: 380px;"></canvas>
  </div>
</div>

<!-- Table Card: Matriks Bulanan Per Regional -->
<div style="margin: 0 16px 24px; background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
  <h3 style="font-size: 14px; font-weight: 700; color: #1f2937; margin: 0 0 14px 0; display: flex; align-items: center; gap: 6px;">
    <i class="fas fa-table" style="color: #166534;"></i> Matriks Akumulasi Bulanan % Kehadiran per Regional
  </h3>
  <div style="overflow-x: auto;">
    <table class="report-table" style="width: 100%; border-collapse: collapse; font-size: 12px;">
      <thead>
        <tr>
          <th style="padding: 10px 14px; text-align: left; background: #166534; color: #fff;">Regional</th>
          <th style="padding: 10px 14px; text-align: right; background: #166534; color: #fff;">Total SDM</th>
          @if(!empty($monthlySummary['months']))
            @foreach($monthlySummary['months'] as $mNo => $mName)
              <th style="padding: 10px 12px; text-align: center; background: #166534; color: #fff;">{{ $mName }}</th>
            @endforeach
          @endif
        </tr>
      </thead>
      <tbody>
        @if(!empty($monthlySummary['dataByRegional']))
          @foreach($monthlySummary['dataByRegional'] as $regId => $regData)
            <tr style="border-bottom: 1px solid #e5e7eb;">
              <td style="padding: 9px 14px; font-weight: 600; color: #111827;">{{ $regData['name'] }}</td>
              <td style="padding: 9px 14px; text-align: right; color: #4b5563;">{{ number_format($regData['total_karyawan'], 0, ',', '.') }}</td>
              @if(!empty($monthlySummary['months']))
                @foreach($monthlySummary['months'] as $mNo => $mName)
                  @php
                    $val = $regData['months'][$mNo]['prosentase_kehadiran'] ?? 0;
                    $colorBg = $val >= 75 ? '#dcfce7' : ($val >= 50 ? '#fef9c3' : '#fee2e2');
                    $colorText = $val >= 75 ? '#15803d' : ($val >= 50 ? '#854d0e' : '#b91c1c');
                  @endphp
                  <td style="padding: 9px 12px; text-align: center;">
                    <span style="background: {{ $colorBg }}; color: {{ $colorText }}; font-weight: 700; padding: 2px 8px; border-radius: 4px; font-size: 11px;">
                      {{ $val }}%
                    </span>
                  </td>
                @endforeach
              @endif
            </tr>
          @endforeach
        @endif
        <!-- Gabungan Average Row -->
        <tr style="background: #f8fafc; font-weight: 700; border-top: 2px solid #cbd5e1;">
          <td style="padding: 10px 14px; color: #166534;">Gabungan (Rata-rata)</td>
          <td style="padding: 10px 14px; text-align: right; color: #166534;">{{ number_format($totalTenagaKerja, 0, ',', '.') }}</td>
          @if(!empty($monthlySummary['months']))
            @foreach($monthlySummary['months'] as $mNo => $mName)
              @php
                $valCorp = $monthlySummary['corporateByMonth'][$mNo]['prosentase_kehadiran'] ?? 0;
              @endphp
              <td style="padding: 10px 12px; text-align: center; color: #166534;">
                {{ $valCorp }}%
              </td>
            @endforeach
          @endif
        </tr>
      </tbody>
    </table>
  </div>
</div>

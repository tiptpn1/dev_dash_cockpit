
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
        
        // Chart Colors
        const chartColors = {
        blue: '#0EA5E9',
        cyan: '#06B6D4',
        red: '#EF4444',
        purple: '#8B5CF6',
        primary: '#1E40AF',
        gridColor: 'rgba(22, 101, 52, 0.08)',
        textColor: '#1f2937',
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
        font: { size: 11, family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif" },
        padding: 12,
        usePointStyle: true,
        },
        },
        },
        scales: {
        x: {
        grid: { color: chartColors.gridColor, drawBorder: false },
        ticks: { color: chartColors.textColor, font: { size: 10 } },
        },
        y: {
        grid: { color: chartColors.gridColor, drawBorder: false },
        ticks: { color: chartColors.textColor, font: { size: 10 } },
        },
        },
        };

        // ============================================
        // INITIALIZE SUMMARY LINE CHART & ASYNC LOADER
        // ============================================
        let chartRetryCount = 0;
        function initSummaryLineChart(monthlySummaryData) {
          const summaryChartCanvas = document.getElementById('summaryLineChart');
          if (!summaryChartCanvas) {
            console.warn('[initSummaryLineChart] Canvas #summaryLineChart belum tersedia di DOM.');
            return;
          }
          if (!monthlySummaryData) return;

          // Jika Chart library CDN belum ter-load, retry hingga 10x
          if (typeof Chart === 'undefined') {
            if (chartRetryCount < 10) {
              chartRetryCount++;
              setTimeout(() => initSummaryLineChart(monthlySummaryData), 200);
            } else {
              console.error('[initSummaryLineChart] Chart.js library tidak tersedia.');
            }
            return;
          }
          chartRetryCount = 0;

          // Hancurkan instance chart lama jika terdaftar di canvas ini
          const oldChart = (typeof Chart.getChart === 'function') ? Chart.getChart(summaryChartCanvas) : window.summaryLineChart;
          if (oldChart) {
            try { oldChart.destroy(); } catch (e) {}
          }
          if (window.summaryLineChart && window.summaryLineChart !== oldChart) {
            try { window.summaryLineChart.destroy(); } catch (e) {}
            window.summaryLineChart = null;
          }

          const monthLabels = Object.values(monthlySummaryData.months || {});
          const monthKeys = Object.keys(monthlySummaryData.months || {});

          const regColorMap = {
            2: { border: '#10b981', bg: 'rgba(16, 185, 129, 0.15)' }, // Emerald
            3: { border: '#3b82f6', bg: 'rgba(59, 130, 246, 0.15)' }, // Blue
            5: { border: '#8b5cf6', bg: 'rgba(139, 92, 246, 0.15)' }, // Purple
            7: { border: '#f97316', bg: 'rgba(249, 115, 22, 0.15)' }, // Orange
            8: { border: '#eab308', bg: 'rgba(234, 179, 8, 0.15)' },  // Yellow
            default: { border: '#06b6d4', bg: 'rgba(6, 182, 212, 0.15)' }
          };

          function buildSummaryDatasets(metric) {
            const datasets = [];
            const dataByReg = monthlySummaryData.dataByRegional || {};

            Object.values(dataByReg).forEach(reg => {
              const regId = reg.id;
              const colors = regColorMap[regId] || regColorMap.default;
              const points = monthKeys.map(m => {
                return (reg.months && reg.months[m]) ? reg.months[m][metric] : 0;
              });

              datasets.push({
                label: reg.name,
                data: points,
                borderColor: colors.border,
                backgroundColor: colors.bg,
                borderWidth: 2.5,
                tension: 0.3,
                pointRadius: 4,
                pointHoverRadius: 7,
                pointBackgroundColor: colors.border,
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                fill: false
              });
            });

            // Gabungan (Rata-rata)
            const corpPoints = monthKeys.map(m => {
              return (monthlySummaryData.corporateByMonth && monthlySummaryData.corporateByMonth[m]) 
                ? monthlySummaryData.corporateByMonth[m][metric] 
                : 0;
            });

            datasets.push({
              label: 'Gabungan (Rata-rata)',
              data: corpPoints,
              borderColor: '#e11d48',
              backgroundColor: 'rgba(225, 29, 72, 0.1)',
              borderWidth: 3,
              borderDash: [6, 4],
              tension: 0.3,
              pointRadius: 5,
              pointHoverRadius: 8,
              pointBackgroundColor: '#e11d48',
              pointBorderColor: '#ffffff',
              pointBorderWidth: 2,
              fill: false
            });

            return datasets;
          }

          let currentMetric = 'prosentase_kehadiran';

          try {
            window.summaryLineChart = new Chart(summaryChartCanvas, {
              type: 'line',
              data: {
                labels: monthLabels,
                datasets: buildSummaryDatasets(currentMetric)
              },
              options: {
                responsive: true,
                maintainAspectRatio: false,
                resizeDelay: 50,
                interaction: {
                  mode: 'index',
                  intersect: false
                },
                plugins: {
                  legend: {
                    display: true,
                    position: 'top',
                    labels: {
                      boxWidth: 14,
                      usePointStyle: true,
                      padding: 16,
                      font: { size: 12, weight: '600' },
                      color: '#374151'
                    }
                  },
                  tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleFont: { size: 13, weight: 'bold' },
                    bodyFont: { size: 12 },
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                      label: function(context) {
                        const label = context.dataset.label || '';
                        const val = context.parsed ? context.parsed.y : (context.yLabel !== undefined ? context.yLabel : context.raw);
                        const safeVal = val !== null && val !== undefined ? val : 0;
                        return `${label}: ${safeVal}%`;
                      }
                    }
                  }
                },
                scales: {
                  x: {
                    grid: { display: false },
                    ticks: { font: { size: 12, weight: '600' }, color: '#4b5563' }
                  },
                  y: {
                    min: 0,
                    max: 100,
                    grid: { color: 'rgba(229, 231, 235, 0.8)', drawBorder: false },
                    ticks: {
                      font: { size: 11 },
                      color: '#6b7280',
                      callback: function(val) { return val + '%'; }
                    }
                  }
                }
              }
            });

            // Trigger resize setelah render pertama untuk memastikan ukuran 100% pas
            setTimeout(() => {
              if (window.summaryLineChart) {
                window.summaryLineChart.resize();
              }
            }, 100);

          } catch (chartErr) {
            console.error('Error in initSummaryLineChart instansiasi:', chartErr);
            const chartWrap = document.getElementById('summaryLineChartWrap');
            if (chartWrap) {
              chartWrap.innerHTML = `
                <div style="padding: 24px; text-align: center; color: #dc2626; background: #fee2e2; border-radius: 8px;">
                  <i class="fas fa-exclamation-triangle" style="font-size: 24px; margin-bottom: 8px;"></i>
                  <p style="font-weight: 700; margin: 0;">Gagal Merender Grafik Tren</p>
                  <p style="font-size: 12px; margin: 4px 0 0; font-family: monospace;">${chartErr.message || chartErr}</p>
                </div>
              `;
            }
          }

          // Metric Toggle Buttons
          const btnMetricKehadiran = document.getElementById('btnMetricKehadiran');
          const btnMetricInput = document.getElementById('btnMetricInput');

          if (btnMetricKehadiran && btnMetricInput) {
            btnMetricKehadiran.onclick = () => {
              if (currentMetric === 'prosentase_kehadiran') return;
              currentMetric = 'prosentase_kehadiran';
              btnMetricKehadiran.style.background = '#166534';
              btnMetricKehadiran.style.color = '#fff';
              btnMetricInput.style.background = 'transparent';
              btnMetricInput.style.color = '#4b5563';

              if (window.summaryLineChart) {
                window.summaryLineChart.data.datasets = buildSummaryDatasets('prosentase_kehadiran');
                window.summaryLineChart.update();
              }
            };

            btnMetricInput.onclick = () => {
              if (currentMetric === 'prosentase_input') return;
              currentMetric = 'prosentase_input';
              btnMetricInput.style.background = '#166534';
              btnMetricInput.style.color = '#fff';
              btnMetricKehadiran.style.background = 'transparent';
              btnMetricKehadiran.style.color = '#4b5563';

              if (window.summaryLineChart) {
                window.summaryLineChart.data.datasets = buildSummaryDatasets('prosentase_input');
                window.summaryLineChart.update();
              }
            };
          }
        }

        /**
         * Load ringkasan bulanan via AJAX asinkron
         */
        function loadMonthlySummaryPresensi(jobdesc, tahun) {
          const wrapper = document.getElementById('summaryContentWrapper');
          if (!wrapper) return;

          const currentJobDesc = jobdesc || (document.getElementById('selectJobDescSummary') ? document.getElementById('selectJobDescSummary').value : 'PENYADAP');
          const currentTahun = tahun || (document.getElementById('selectTahunSummary') ? document.getElementById('selectTahunSummary').value : '2026');

          // Tampilkan spinner loading
          wrapper.innerHTML = `
            <div style="padding: 60px 20px; text-align: center; background: #fff; border-radius: 12px; margin: 0 16px 24px; border: 1px solid #e5e7eb; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
              <div style="width: 44px; height: 44px; border: 4px solid #d1fae5; border-top-color: #166534; border-radius: 50%; display: inline-block; animation: spinSummary 0.8s linear infinite;"></div>
              <h4 style="margin-top: 18px; font-size: 16px; font-weight: 700; color: #166534;">Memuat Ringkasan Tren Presensi Gabungan...</h4>
              <p style="margin-top: 4px; font-size: 13px; color: #6b7280;">Mengambil data akumulasi multi-bulan dari server di latar belakang.</p>
            </div>
          `;

          // Generate URL aman (mendukung reverse proxy HTTPS dan relative path)
          const baseRoute = 'http://localhost/ajax/dfarmkaret/monthly-summary';
          const secureBase = baseRoute.replace(/^http:\/\//i, window.location.protocol === 'https:' ? 'https://' : 'http://');
          const url = `${secureBase}?jobdesc=${encodeURIComponent(currentJobDesc)}&tahun=${encodeURIComponent(currentTahun)}`;

          fetch(url, {
            headers: {
              'Accept': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            }
          })
          .then(async res => {
            const json = await res.json().catch(() => null);
            if (!res.ok) {
              const errMsg = (json && json.error) ? json.error : `HTTP ${res.status} ${res.statusText}`;
              throw new Error(errMsg);
            }
            if (!json || !json.success || !json.html) {
              throw new Error((json && json.error) || 'Format data respon tidak valid');
            }
            return json;
          })
          .then(json => {
            wrapper.innerHTML = json.html;
            // Berikan jeda sejenak (reflow delay) agar canvas ter-mount sempurna dengan dimensi yang benar
            setTimeout(() => {
              initSummaryLineChart(json.data);
            }, 60);
          })
          .catch(err => {
            console.error('Error loadMonthlySummaryPresensi:', err);
            wrapper.innerHTML = `
              <div style="padding: 40px 20px; text-align: center; background: #fff; border-radius: 12px; margin: 0 16px 24px; border: 1px solid #fecaca; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                <i class="fas fa-triangle-exclamation" style="font-size: 32px; color: #dc2626;"></i>
                <h4 style="margin-top: 14px; font-size: 15px; font-weight: 700; color: #991b1b;">Gagal Memuat Ringkasan Bulanan</h4>
                <p style="margin-top: 4px; font-size: 13px; color: #6b7280;">Terjadi kendala saat mengambil data agregasi presensi dari server.</p>
                <div style="margin-top: 8px;">
                  <span style="font-size: 11px; color: #b91c1c; background: #fee2e2; border: 1px solid #fca5a5; padding: 4px 10px; border-radius: 6px; font-family: monospace; display: inline-block;">
                    Detail: ${err.message || err}
                  </span>
                </div>
                <div style="margin-top: 14px;">
                  <button type="button" onclick="loadMonthlySummaryPresensi('${currentJobDesc}', '${currentTahun}')" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-lg" style="background: #166534; color: #fff; border: none; cursor: pointer; padding: 8px 16px; border-radius: 6px;">
                    <i class="fas fa-rotate-right" style="margin-right: 6px;"></i> Coba Lagi
                  </button>
                </div>
              </div>
            `;
          });
        }

        // Panggil saat pertama kali halaman terbuka
        loadMonthlySummaryPresensi();

        // ============================================
        // INITIALIZE CHARTS - CONDITIONAL BY FILTER STATE
        // ============================================

                  // 1. Presensi Chart (Stacked Bar - By Regional)
          const presensiCtx = document.getElementById('presensiChart');
          if (presensiCtx) {
          new Chart(presensiCtx, {
          type: 'bar',
          data: {
          labels: [
                    'Regional 2',
                    'Regional 3',
                    'Regional 5',
                    'Regional 7',
                    'Regional 8',
                    ],
          datasets: [
          {
          label: '% Input Presensi',
          data: [
                    86.37,
                    41.8,
                    86.17,
                    44.08,
                    29.69,
                    ],
          backgroundColor: chartColors.blue,
          borderRadius: 6,
          borderSkipped: false,
          },
          {
          label: '% Belum Input Presensi',
          data: [
                    13.63,
                    58.2,
                    13.83,
                    55.92,
                    70.31,
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
          }

          // 2. Presentase Hadir Chart (Stacked Bar - By Regional)
          const presentaseHadirCtx = document.getElementById('presentaseHadirChart');
          if (presentaseHadirCtx) {
          new Chart(presentaseHadirCtx, {
          type: 'bar',
          data: {
          labels: [
                    'Regional 2',
                    'Regional 3',
                    'Regional 5',
                    'Regional 7',
                    'Regional 8',
                    ],
          datasets: [
          {
          label: '% Hadir',
          data: [
                    68.81,
                    31.33,
                    64.68,
                    32.54,
                    22.19,
                    ],
          backgroundColor: chartColors.blue,
          borderRadius: 6,
          borderSkipped: false,
          },
          {
          label: '% Tidak Hadir',
          data: [
                    31.19,
                    68.67,
                    35.32,
                    67.46,
                    77.81,
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
          }

          // 3. Presentase Input Chart (Grouped Bar - By Regional)
          const presentaseInputCtx = document.getElementById('presentaseInputChart');
          if (presentaseInputCtx) {
          new Chart(presentaseInputCtx, {
          type: 'bar',
          data: {
          labels: [
                    'Regional 2',
                    'Regional 3',
                    'Regional 5',
                    'Regional 7',
                    'Regional 8',
                    ],
          datasets: [
          {
          label: 'Jumlah Input Presensi',
          data: [
                    2085,
                    2196,
                    3608,
                    1929,
                    95,
                    ],
          backgroundColor: chartColors.blue,
          borderRadius: 6,
          borderSkipped: false,
          },
          {
          label: 'Jumlah Karyawan',
          data: [
                    2414,
                    5253,
                    4187,
                    4376,
                    320,
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
          }
        
        // ============================================
        // DETAIL CHARTS BY KEBUN
        // ============================================

        
        

      
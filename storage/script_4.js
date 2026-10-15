
        // Format tanggal ke "MMM D, YYYY" format
        function formatDate(date) {
          return new Date(date).toLocaleDateString('id-ID', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
          });
        }

        // Elements for Tab Rekap
        const dateRangeInput = document.getElementById('dateRange');
        const datePickerPopup = document.getElementById('datePickerPopup');
        const datePickerStart = document.getElementById('datePickerStart');
        const datePickerEnd = document.getElementById('datePickerEnd');
        const datePickerApply = document.getElementById('datePickerApply');
        const datePickerCancel = document.getElementById('datePickerCancel');

        // Elements for Tab Detail
        const dateRangeInputDetail = document.getElementById('dateRangeDetail');
        const datePickerPopupDetail = document.getElementById('datePickerPopupDetail');
        const datePickerStartDetail = document.getElementById('datePickerStartDetail');
        const datePickerEndDetail = document.getElementById('datePickerEndDetail');
        const datePickerApplyDetail = document.getElementById('datePickerApplyDetail');
        const datePickerCancelDetail = document.getElementById('datePickerCancelDetail');

        // Get default dates dari controller
        const tglAwalDefault = '2026-10-15';
        const tglAkhirDefault = '2026-10-15';

        // Get URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const tglAwalParam = urlParams.get('tgl_awal');
        const tglAkhirParam = urlParams.get('tgl_akhir');
        const idRegParam = urlParams.get('id_reg');
        const kodeKebunParam = urlParams.get('kode_kebun');
        const jobDescParam = urlParams.get('jobdesc');
        const tabParam = urlParams.get('tab');

        const activeTglAwal = tglAwalParam || tglAwalDefault;
        const activeTglAkhir = tglAkhirParam || tglAkhirDefault;

        // Set date values Rekap
        if (datePickerStart) datePickerStart.value = activeTglAwal;
        if (datePickerEnd) datePickerEnd.value = activeTglAkhir;

        // Set date values Detail
        if (datePickerStartDetail) datePickerStartDetail.value = activeTglAwal;
        if (datePickerEndDetail) datePickerEndDetail.value = activeTglAkhir;

        // Set select values dari parameter
        if (jobDescParam) {
          const sJob = document.getElementById('selectJobDesc');
          const sJobDetail = document.getElementById('selectJobDescDetail');
          if (sJob) sJob.value = jobDescParam;
          if (sJobDetail) sJobDetail.value = jobDescParam;
        }
        if (idRegParam) {
          const sReg = document.getElementById('selectRegional');
          const sRegDetail = document.getElementById('selectRegionalDetail');
          if (sReg) sReg.value = idRegParam;
          if (sRegDetail) sRegDetail.value = idRegParam;
        }
        if (kodeKebunParam) {
          const sKebun = document.getElementById('selectKebun');
          const sKebunDetail = document.getElementById('selectKebunDetail');
          if (sKebun) sKebun.value = kodeKebunParam;
          if (sKebunDetail) sKebunDetail.value = kodeKebunParam;
        }

        // Update display functions
        function updateDateDisplay() {
          if (dateRangeInput && datePickerStart && datePickerEnd && datePickerStart.value && datePickerEnd.value) {
            dateRangeInput.value = `${formatDate(datePickerStart.value)} - ${formatDate(datePickerEnd.value)}`;
          }
        }
        function updateDateDisplayDetail() {
          if (dateRangeInputDetail && datePickerStartDetail && datePickerEndDetail && datePickerStartDetail.value && datePickerEndDetail.value) {
            dateRangeInputDetail.value = `${formatDate(datePickerStartDetail.value)} - ${formatDate(datePickerEndDetail.value)}`;
          }
        }
        updateDateDisplay();
        updateDateDisplayDetail();

        // Toggle popup Rekap
        if (dateRangeInput && datePickerPopup) {
          dateRangeInput.addEventListener('click', (e) => {
            e.stopPropagation();
            datePickerPopup.classList.toggle('hidden');
            if (datePickerPopupDetail) datePickerPopupDetail.classList.add('hidden');
          });
          datePickerPopup.addEventListener('click', (e) => {
            e.stopPropagation();
          });
        }

        // Toggle popup Detail
        if (dateRangeInputDetail && datePickerPopupDetail) {
          dateRangeInputDetail.addEventListener('click', (e) => {
            e.stopPropagation();
            datePickerPopupDetail.classList.toggle('hidden');
            if (datePickerPopup) datePickerPopup.classList.add('hidden');
          });
          datePickerPopupDetail.addEventListener('click', (e) => {
            e.stopPropagation();
          });
        }

        // Apply button Rekap
        if (datePickerApply) {
          datePickerApply.addEventListener('click', () => {
            if (datePickerStart && datePickerEnd && datePickerStart.value && datePickerEnd.value) {
              if (new Date(datePickerStart.value) <= new Date(datePickerEnd.value)) {
                updateDateDisplay();
                if (datePickerPopup) datePickerPopup.classList.add('hidden');
                // Sync to Detail picker
                if (datePickerStartDetail) datePickerStartDetail.value = datePickerStart.value;
                if (datePickerEndDetail) datePickerEndDetail.value = datePickerEnd.value;
                updateDateDisplayDetail();
              } else {
                alert('Tanggal awal harus lebih kecil dari tanggal akhir');
              }
            }
          });
        }

        // Apply button Detail
        if (datePickerApplyDetail) {
          datePickerApplyDetail.addEventListener('click', () => {
            if (datePickerStartDetail && datePickerEndDetail && datePickerStartDetail.value && datePickerEndDetail.value) {
              if (new Date(datePickerStartDetail.value) <= new Date(datePickerEndDetail.value)) {
                updateDateDisplayDetail();
                if (datePickerPopupDetail) datePickerPopupDetail.classList.add('hidden');
                // Sync to Rekap picker
                if (datePickerStart) datePickerStart.value = datePickerStartDetail.value;
                if (datePickerEnd) datePickerEnd.value = datePickerEndDetail.value;
                updateDateDisplay();
              } else {
                alert('Tanggal awal harus lebih kecil dari tanggal akhir');
              }
            }
          });
        }

        // Cancel button Rekap
        if (datePickerCancel && datePickerPopup) {
          datePickerCancel.addEventListener('click', () => {
            datePickerPopup.classList.add('hidden');
          });
        }

        // Cancel button Detail
        if (datePickerCancelDetail && datePickerPopupDetail) {
          datePickerCancelDetail.addEventListener('click', () => {
            datePickerPopupDetail.classList.add('hidden');
          });
        }

        // Close popup when clicking outside
        document.addEventListener('click', (e) => {
          if (datePickerPopup && !datePickerPopup.classList.contains('hidden')) {
            datePickerPopup.classList.add('hidden');
          }
          if (datePickerPopupDetail && !datePickerPopupDetail.classList.contains('hidden')) {
            datePickerPopupDetail.classList.add('hidden');
          }
        });

        // Allow Enter key to apply
        document.addEventListener('keypress', (e) => {
          if (e.key === 'Enter') {
            if (datePickerPopup && !datePickerPopup.classList.contains('hidden')) {
              datePickerApply.click();
            }
            if (datePickerPopupDetail && !datePickerPopupDetail.classList.contains('hidden')) {
              datePickerApplyDetail.click();
            }
          }
        });

        // Tab handling
        document.querySelectorAll('.hris-tab-btn').forEach(btn => {
          btn.addEventListener('click', () => {
            const tab = btn.dataset.tab;

            // Update active button
            document.querySelectorAll('.hris-tab-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            // Update active panel
            document.querySelectorAll('.hris-tab-panel').forEach(panel => panel.classList.remove('active'));
            const activePanel = document.getElementById(`tab-${tab}`);
            if (activePanel) activePanel.classList.add('active');

            // Update URL search param 'tab' without reloading
            const url = new URL(window.location);
            url.searchParams.set('tab', tab);
            window.history.replaceState({}, '', url);

            // Trigger chart resize if summary tab is opened
            if (tab === 'summary' && window.summaryLineChart) {
              window.summaryLineChart.resize();
            }
          });
        });

        // Activate tab from URL param if present, default to summary
        const currentTab = tabParam || 'summary';
        const targetTabBtn = document.querySelector(`.hris-tab-btn[data-tab="${currentTab}"]`);
        if (targetTabBtn) {
          targetTabBtn.click();
        }

        // Initialize table with presensi data
        function initializeTable() {
          const presensiData = [{"regional_id":2,"regional":"Regional 2","kehadiran":1661,"sakit":46,"cuti":33,"libur":248,"mangkir":97,"dll":0,"belum_hadir":329,"prosentase":"86.37","prosentase_kehadiran":"68.81","total_pegawai":2414},{"regional_id":3,"regional":"Regional 3","kehadiran":1646,"sakit":36,"cuti":13,"libur":416,"mangkir":55,"dll":30,"belum_hadir":3057,"prosentase":"41.8","prosentase_kehadiran":"31.33","total_pegawai":5253},{"regional_id":5,"regional":"Regional 5","kehadiran":2708,"sakit":132,"cuti":0,"libur":755,"mangkir":0,"dll":13,"belum_hadir":579,"prosentase":"86.17","prosentase_kehadiran":"64.68","total_pegawai":4187},{"regional_id":7,"regional":"Regional 7","kehadiran":1424,"sakit":50,"cuti":23,"libur":142,"mangkir":153,"dll":137,"belum_hadir":2447,"prosentase":"44.08","prosentase_kehadiran":"32.54","total_pegawai":4376},{"regional_id":8,"regional":"Regional 8","kehadiran":71,"sakit":3,"cuti":0,"libur":0,"mangkir":19,"dll":2,"belum_hadir":225,"prosentase":"29.69","prosentase_kehadiran":"22.19","total_pegawai":320}];
          const jobdesc = 'PENYADAP';
          const selectedRegional = '';
          const selectedKebun = '';

          const dataTbody = document.getElementById('detail-tbody');
          const tableTitle = document.getElementById('table-title');
          const dataCountBadge = document.getElementById('data-count-badge');

          // Update title
          let titleText = 'Data Presensi DFARM';
          if (jobdesc) titleText += ` - ${jobdesc}`;
          if (selectedRegional) titleText += ` - Regional ${selectedRegional}`;
          if (selectedKebun) titleText += ` - Kebun ${selectedKebun}`;
          if (tableTitle) tableTitle.textContent = titleText;

          // Group data by job desc
          if (dataTbody) {
            const groupedData = {};
            presensiData.forEach(item => {
              const key = item.jobdesc || 'Unknown';
              if (!groupedData[key]) {
                groupedData[key] = [];
              }
              groupedData[key].push(item);
            });

            // Render table rows
            dataTbody.innerHTML = '';
            let index = 1;
            let totalRows = 0;

            Object.entries(groupedData).forEach(([jobdesc, items]) => {
              const totalHadir = items.reduce((sum, item) => sum + (item.total_pegawai - item.belum_hadir), 0);
              const totalPegawai = items.reduce((sum, item) => sum + item.total_pegawai, 0);
              const percentage = totalPegawai > 0 ? ((totalHadir / totalPegawai) * 100).toFixed(1) : 0;

              const tr = document.createElement('tr');
              tr.innerHTML = `
                <td style="text-align: center; font-weight: 700; color: #94a3b8;">${index}</td>
                <td style="text-align: left; font-weight: 600; color: #1f2937;">${jobdesc}</td>
                <td style="text-align: center; color: #4b5563;">${totalPegawai}</td>
                <td style="text-align: center; color: #4b5563;">${totalHadir}</td>
                <td style="text-align: center; color: #4b5563;"><strong>${percentage}%</strong></td>
              `;
              dataTbody.appendChild(tr);
              index++;
              totalRows++;
            });

            if (totalRows === 0) {
              dataTbody.innerHTML = '<tr class="loading-row"><td colspan="5">Tidak ada data presensi.</td></tr>';
            }

            if (dataCountBadge) dataCountBadge.textContent = `${totalRows} Job Desc`;
          }
        }

        // Initialize on load
        window.addEventListener('load', initializeTable);

        // Regional Select Change - Load Kebun Data via AJAX helper
        function setupRegionalHandler(regSelectId, kebunSelectId) {
          const regSelect = document.getElementById(regSelectId);
          const kebunSelect = document.getElementById(kebunSelectId);
          if (!regSelect || !kebunSelect) return;

          regSelect.addEventListener('change', function() {
            const regionalId = this.value;
            if (!regionalId) {
              kebunSelect.innerHTML = '<option value="">Pilih</option>';
              return;
            }

            kebunSelect.innerHTML = '<option value="">Loading...</option>';

            fetch('http://localhost/get_data_kebun?id_reg=' + regionalId + '&komoditas=2', {
              method: 'GET',
              headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
              }
            })
            .then(response => response.json())
            .then(data => {
              kebunSelect.innerHTML = '<option value="">Pilih</option>';
              if (data.data && data.data.length > 0) {
                const uniqueKebun = new Map();
                data.data.forEach(item => {
                  if (!uniqueKebun.has(item.kebun_id)) {
                    uniqueKebun.set(item.kebun_id, item.nama_kebun);
                  }
                });
                uniqueKebun.forEach((nama, kebunId) => {
                  const option = document.createElement('option');
                  option.value = kebunId;
                  option.textContent = nama;
                  kebunSelect.appendChild(option);
                });
              } else {
                kebunSelect.innerHTML = '<option value="">Tidak ada data kebun</option>';
              }
            })
            .catch(error => {
              console.error('Error:', error);
              kebunSelect.innerHTML = '<option value="">Error loading data</option>';
            });
          });
        }
        setupRegionalHandler('selectRegional', 'selectKebun');
        setupRegionalHandler('selectRegionalDetail', 'selectKebunDetail');

        // Filter Function
        function executeFilter(tglAwal, tglAkhir, jobDesc, idReg, kodeKebun, activeTab) {
          if (!tglAwal || !tglAkhir) {
            alert('Silakan pilih periode terlebih dahulu');
            return;
          }

          let url = window.location.pathname + '?';
          const params = [];

          if (tglAwal) params.push('tgl_awal=' + tglAwal);
          if (tglAkhir) params.push('tgl_akhir=' + tglAkhir);
          if (jobDesc) params.push('jobdesc=' + jobDesc);
          if (idReg) params.push('id_reg=' + idReg);
          if (kodeKebun) params.push('kode_kebun=' + kodeKebun);
          if (activeTab) params.push('tab=' + activeTab);

          url += params.join('&');
          window.location.href = url;
        }

        // Filter Button Handler Summary (AJAX Lazy Loading)
        const btnFilterSummary = document.getElementById('btnFilterSummary');
        if (btnFilterSummary) {
          btnFilterSummary.addEventListener('click', () => {
            const jobDesc = document.getElementById('selectJobDescSummary') ? document.getElementById('selectJobDescSummary').value : 'PENYADAP';
            const tahun = document.getElementById('selectTahunSummary') ? document.getElementById('selectTahunSummary').value : '2026';
            
            // Update URL query string tanpa reload halaman penuh
            const url = new URL(window.location.href);
            url.searchParams.set('jobdesc', jobDesc);
            url.searchParams.set('tahun', tahun);
            url.searchParams.set('tab', 'summary');
            window.history.replaceState({}, '', url);

            loadMonthlySummaryPresensi(jobDesc, tahun);
          });
        }

        // Reset Button Handler Summary (AJAX Lazy Loading)
        const btnResetSummary = document.getElementById('btnResetSummary');
        if (btnResetSummary) {
          btnResetSummary.addEventListener('click', () => {
            if (document.getElementById('selectJobDescSummary')) document.getElementById('selectJobDescSummary').value = 'PENYADAP';
            if (document.getElementById('selectTahunSummary')) document.getElementById('selectTahunSummary').value = '2026';
            
            const url = new URL(window.location.href);
            url.searchParams.delete('jobdesc');
            url.searchParams.delete('tahun');
            url.searchParams.set('tab', 'summary');
            window.history.replaceState({}, '', url);

            loadMonthlySummaryPresensi('PENYADAP', '2026');
          });
        }

        // Filter Button Handler Rekap
        const btnFilter = document.getElementById('btnFilter');
        if (btnFilter) {
          btnFilter.addEventListener('click', () => {
            const tglAwal = datePickerStart ? datePickerStart.value : '';
            const tglAkhir = datePickerEnd ? datePickerEnd.value : '';
            const jobDesc = document.getElementById('selectJobDesc') ? document.getElementById('selectJobDesc').value : '';
            const idReg = document.getElementById('selectRegional') ? document.getElementById('selectRegional').value : '';
            const kodeKebun = document.getElementById('selectKebun') ? document.getElementById('selectKebun').value : '';
            executeFilter(tglAwal, tglAkhir, jobDesc, idReg, kodeKebun, 'rekap');
          });
        }

        // Filter Button Handler Detail
        const btnFilterDetail = document.getElementById('btnFilterDetail');
        if (btnFilterDetail) {
          btnFilterDetail.addEventListener('click', () => {
            const tglAwal = datePickerStartDetail ? datePickerStartDetail.value : '';
            const tglAkhir = datePickerEndDetail ? datePickerEndDetail.value : '';
            const jobDesc = document.getElementById('selectJobDescDetail') ? document.getElementById('selectJobDescDetail').value : '';
            const idReg = document.getElementById('selectRegionalDetail') ? document.getElementById('selectRegionalDetail').value : '';
            const kodeKebun = document.getElementById('selectKebunDetail') ? document.getElementById('selectKebunDetail').value : '';
            executeFilter(tglAwal, tglAkhir, jobDesc, idReg, kodeKebun, 'detail');
          });
        }

        // Reset Button Handler Rekap
        const btnReset = document.getElementById('btnReset');
        if (btnReset) {
          btnReset.addEventListener('click', () => {
            if (document.getElementById('selectJobDesc')) document.getElementById('selectJobDesc').value = '';
            if (document.getElementById('selectRegional')) document.getElementById('selectRegional').value = '';
            if (document.getElementById('selectKebun')) document.getElementById('selectKebun').value = '';
            window.location.href = window.location.pathname + '?tab=rekap';
          });
        }

        // Reset Button Handler Detail
        const btnResetDetail = document.getElementById('btnResetDetail');
        if (btnResetDetail) {
          btnResetDetail.addEventListener('click', () => {
            if (document.getElementById('selectJobDescDetail')) document.getElementById('selectJobDescDetail').value = '';
            if (document.getElementById('selectRegionalDetail')) document.getElementById('selectRegionalDetail').value = '';
            if (document.getElementById('selectKebunDetail')) document.getElementById('selectKebunDetail').value = '';
            window.location.href = window.location.pathname + '?tab=detail';
          });
        }
      
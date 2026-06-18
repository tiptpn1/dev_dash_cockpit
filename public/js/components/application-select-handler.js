// ============================================
// APPLICATION SELECT REDIRECT HANDLER
// ============================================

function initializeApplicationSelect() {
  // Handler for selectedApp (application-select.blade.php component)
  const appSelectElement = document.getElementById('selectedApp');
  
  if (appSelectElement) {
    appSelectElement.addEventListener('change', function() {
      const selectedApp = this.value;

      // Redirect to Digital Farming if selected
      if (selectedApp === 'Digital Farming') {
        window.location.href = '/dfarmkaret';
        return;
      }

      // Redirect to Digital Farming Produksi if selected
      if (selectedApp === 'Digital Farming Produksi') {
        window.location.href = '/dfarmkaretproduksi';
        return;
      }

      // Redirect to Digital Farming Produksi if selected
      if (selectedApp === 'Digital Farming BKM') {
        window.location.href = '/dfarmkaretbkmsap';
        return;
      }

      // Redirect to HRIS if selected
      if (selectedApp === 'HRIS') {
        window.location.href = '/evaluasi-aplikasi';
        return;
      }

      // Redirect to SAPA-Amanah if selected
      if (selectedApp === 'SAPA-Amanah') {
        window.location.href = '/sapa-evaluasi';
        return;
      }

      // Redirect to BPD if selected
      if (selectedApp === 'BPD') {
        window.location.href = '/bpd-evaluasi';
        return;
      }

      // Redirect to MAIA if selected
      if (selectedApp === 'MAIA') {
        window.location.href = '/evaluasi-aplikasi/maia';
        return;
      }

      // Redirect to MONIKA if selected
      if (selectedApp === 'MONIKA') {
        window.location.href = '/evaluasi-aplikasi/monika';
        return;
      }
    });
  }

  // Handler for app_select (evaluasi.blade.php dropdown)
  const appSelectDropdown = document.getElementById('app_select');
  
  if (appSelectDropdown) {
    appSelectDropdown.addEventListener('change', function() {
      const selectedApp = this.value;

      // Redirect to Digital Farming if selected
      if (selectedApp === 'Digital Farming') {
        window.location.href = '/dfarmkaret';
        return;
      }

      // Redirect to Digital Farming Produksi if selected
      if (selectedApp === 'Digital Farming Produksi') {
        window.location.href = '/dfarmkaretproduksi';
        return;
      }

      // Redirect to HRIS if selected (stay on current page)
      if (selectedApp === 'HRIS') {
        // Already on evaluasi page, no redirect needed
        return;
      }

      // Redirect to SAPA-Amanah if selected
      if (selectedApp === 'SAPA-Amanah') {
        window.location.href = '/sapa-evaluasi';
        return;
      }

      // Redirect to MAIA if selected
      if (selectedApp === 'MAIA') {
        window.location.href = '/evaluasi-aplikasi/maia';
        return;
      }

      // Redirect to MONIKA if selected
      if (selectedApp === 'MONIKA') {
        window.location.href = '/evaluasi-aplikasi/monika';
        return;
      }

      // Redirect to BPD if selected
      if (selectedApp === 'BPD') {
        window.location.href = '/bpd-evaluasi';
        return;
      }
    });
  }
}

// Initialize on DOMContentLoaded or immediately if DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initializeApplicationSelect);
} else {
  // DOM is already loaded, call immediately
  initializeApplicationSelect();
}

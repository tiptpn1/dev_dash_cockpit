// ============================================
// APPLICATION SELECT REDIRECT HANDLER
// ============================================
document.addEventListener('DOMContentLoaded', function() {
  const appSelectElement = document.getElementById('selectedApp');
  
  if (appSelectElement) {
    appSelectElement.addEventListener('change', function() {
      const selectedApp = this.value;
      const currentUrlParams = new URLSearchParams(window.location.search);
      const currentIdReg = currentUrlParams.get('id_reg');
      const regQuery = currentIdReg ? ('?id_reg=' + encodeURIComponent(currentIdReg)) : '';

      // Redirect to Digital Farming if selected
      if (selectedApp === 'Digital Farming') {
        window.location.href = '/dfarmkaret' + regQuery;
        return;
      }

      // Redirect to Digital Farming Produksi if selected
      if (selectedApp === 'Digital Farming Produksi') {
        window.location.href = '/dfarmkaretproduksi' + regQuery;
        return;
      }
      console.log(selectedApp);
      // Redirect to Digital Farming BKM if selected
      if (selectedApp === 'Digital Farming BKM') {
        console.log('TEST data');
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
      if (selectedApp === 'BPD') {
        window.location.href = '/bpd-evaluasi';
        return;
      }
      if (selectedApp === 'MAIA') {
        window.location.href = '/evaluasi-aplikasi/maia';
        return;
      }
      if (selectedApp === 'MONIKA') {
        window.location.href = '/evaluasi-aplikasi/monika';
        return;
      }
    });
  }
});

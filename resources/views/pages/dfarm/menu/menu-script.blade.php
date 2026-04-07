<!-- Header Menu Dropdown Script -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Get current route/page
    const currentRoute = window.location.pathname;
    
<<<<<<< HEAD
    // Define menu routes mapping
    const menuRoutesMap = {
      prensensi: ['/dfarmkaret', '/dfarmteh', '/presensi'],
      produksi: ['/produksi', '/produksikaret', '/produksiteh', '/analisis']
=======
    // Define menu routes mapping (order matters - check more specific routes first!)
    const menuRoutesMap = {
      // produksi: ['/dfarmkaretproduksi', '/dfarmtehproduksi'],
      // prensensi: ['/dfarmkaret', '/dfarmteh']
>>>>>>> main
    };
    
    // Determine which menu should be active
    let activeMenu = null;
    for (const [menu, routes] of Object.entries(menuRoutesMap)) {
      if (routes.some(route => currentRoute.includes(route))) {
        activeMenu = menu;
        break;
      }
    }
    
    // Set active menu
    if (activeMenu) {
      const activeBtn = document.querySelector(`[data-menu="${activeMenu}"]`);
      const activeDropdown = document.getElementById(`${activeMenu}-dropdown`);
      
      if (activeBtn && activeDropdown) {
        // Remove active from all buttons
        document.querySelectorAll('.menu-item-btn').forEach(btn => {
          btn.classList.remove('active');
        });
        
        // Hide all dropdowns
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
          menu.classList.remove('show');
        });
        
        // Set current menu as active
        activeBtn.classList.add('active');
        activeDropdown.classList.add('show');
      }
    }
    
    // Menu button click handler
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
            button.classList.remove('active');
          }
        });
        
        // Toggle current dropdown
        dropdown.classList.toggle('show');
        this.classList.toggle('active');
      });
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
      if (!e.target.closest('.menu-item-dropdown')) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
          menu.classList.remove('show');
        });
        document.querySelectorAll('.menu-item-btn').forEach(btn => {
          btn.classList.remove('active');
        });
      }
    });
  });
</script>

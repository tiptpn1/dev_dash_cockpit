<!-- Header Menu -->
<div class="header-menu">
  <div class="menu-items">
    <!-- Prensensi Menu -->
    <div class="menu-item-dropdown">
      <button class="menu-item-btn" data-menu="prensensi">
        <span>PRENSENSI</span>
        <div class="dropdown-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="6 9 12 15 18 9"></polyline>
          </svg>
        </div>
      </button>
      <div class="dropdown-menu" id="prensensi-dropdown">
        <a class="dropdown-menu-item" href="{{ route('dfarmkaretpresensi') }}">
          <i class="fa-solid fa-clipboard-check" style="width: 14px;"></i>
          Dashboard
        </a>
        <a class="dropdown-menu-item" href="{{ route('dfarmkaretpresensitabular') }}">
          <i class="fa-solid fa-chart-bar" style="width: 14px;"></i>
          Tabular Data
        </a>
      </div>
    </div>

    <!-- Produksi Menu -->
    <div class="menu-item-dropdown">
      <button class="menu-item-btn" data-menu="produksi">
        <span>PRODUKSI</span>
        <div class="dropdown-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="6 9 12 15 18 9"></polyline>
          </svg>
        </div>
      </button>
      <div class="dropdown-menu" id="produksi-dropdown">
        <a class="dropdown-menu-item" href="{{ route('dfarmkaretproduksi') }}">
          <i class="fa-solid fa-leaf" style="width: 14px;"></i>
          Produksi Karet
        </a>
        <a class="dropdown-menu-item" href="{{ route('dfarmtehproduksi') }}">
          <i class="fa-solid fa-leaf" style="width: 14px;"></i>
          Produksi Teh
        </a>
        <a class="dropdown-menu-item" href="{{ route('dfarmkopiproduksi') }}">
          <i class="fa-solid fa-leaf" style="width: 14px;"></i>
          Produksi Kopi
        </a>
        <a class="dropdown-menu-item" href="#">
          <i class="fa-solid fa-chart-line" style="width: 14px;"></i>
          Prestasi Pemeliharaan
        </a>
      </div>
    </div>
  </div>

  <div class="menu-icons">
    <button class="icon-btn">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="1"></circle>
        <circle cx="19" cy="12" r="1"></circle>
        <circle cx="5" cy="12" r="1"></circle>
      </svg>
    </button>
    <button class="icon-btn">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="10"></circle>
        <path d="M12 6v6l4 2"></path>
      </svg>
    </button>
  </div>
</div>

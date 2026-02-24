<div class="icon" id="menuIcon">
    <img src="{{url('')}}/asset/images/menu.png" alt="Menu Icon">
</div>
<div class="sidebar" id="sidebar">
        <?php
            $user = Auth::guard('custom')->user();
            $username="";
            if(isset($user)){
                $username = $user->username;
            }
        ?>
        <div class="sidebar-header">
            <img src="{{ asset('ptpn1.png') }}" alt="PTPN 1" class="sidebar-logo">
            <span class="sidebar-title">AGRINAV</span>
        </div>
        <div class="menu">
        <!-- <a href="#home">Home</a> -->
        
        <a href="{{url('')}}" class="menu-item" id="overview"><i class="fa-solid fa-house menu-icon"></i>Overview</a>
        <a href="{{url('')}}/mrc" class="menu-item" id="mrc"><i class="fa-solid fa-calendar-days menu-icon"></i>MRC</a>
        @if($username!='mrc')
        <a href="#operasional" id="operasional" class="parent"><i class="fa-solid fa-gears menu-icon"></i>Operasional <span class="toggle-icon">&#9654;</span></a>
        <div class="submenu" id="operasionalSubmenu">
            <a href="#" id="karetSubmenu" class="parents"><i class="fa-solid fa-leaf menu-icon"></i>Karet<span class="toggle-icon">&#9654;</span></a>
            <div class="submenu subsub">
                <a href="{{url('')}}/onfarmkaret"><i class="fa-solid fa-tree menu-icon"></i>On Farm</a>
                <a href="{{url('')}}/offfarmkaret"><i class="fa-solid fa-truck menu-icon"></i>Off Farm</a>
            </div>
            <a href="#" id="tehSubmenu" class="parents"><i class="fa-solid fa-mug-hot menu-icon"></i>Teh<span class="toggle-icon">&#9654;</span></a>
            <div class="submenu subsub">
                <a href="{{url('')}}/onfarmteh"><i class="fa-solid fa-tree menu-icon"></i>On Farm</a>
                <a href="{{url('')}}/offfarmteh"><i class="fa-solid fa-truck menu-icon"></i>Off Farm</a>
            </div>
            <a href="{{url('')}}/onfarmkopi"><i class="fa-solid fa-mug-hot menu-icon"></i>Kopi</a>
            <a href="{{url('')}}/iot"><i class="fa-solid fa-microchip menu-icon"></i>IOT</a>
            <a href="{{url('')}}/amanah"><i class="fa-solid fa-building menu-icon"></i>AMANAH</a>
            <a href="{{url('')}}/picaonfarm"><i class="fa-solid fa-clipboard-list menu-icon"></i>PICA On Farm</a>
            <a href="{{url('')}}/picaofffarm"><i class="fa-solid fa-clipboard-list menu-icon"></i>PICA Off Farm</a>
            <a href="{{url('')}}/dfarmkaret"><i class="fa-solid fa-seedling menu-icon"></i>DFarm Karet</a>
            <a href="{{url('')}}/dfarmteh"><i class="fa-solid fa-seedling menu-icon"></i>DFarm Teh</a>
            <!-- <a href="{{url('')}}/gudangutilisasi">Dashboard Utilisasi Gudang</a> -->
        </div>
        <a href="{{url('')}}/gudangutilisasi" class="menu-item"><i class="fa-solid fa-warehouse menu-icon"></i>Warehouse</a>
        <a href="#sales" id="sales" class="parent"><i class="fa-solid fa-chart-line menu-icon"></i>Sales<span class="toggle-icon">&#9654;</span></a>
        <div class="submenu" id="salesSubmenu">
            <a href="{{url('')}}/sales_comodities"><i class="fa-solid fa-boxes-stacked menu-icon"></i>Comodities Sales</a>
            <a href="{{url('')}}/soptea"><i class="fa-solid fa-mug-hot menu-icon"></i>S&OP Tea</a>
        </div>
        <a href="#aset" id="aset" class="parent"><i class="fa-solid fa-building menu-icon"></i>Asset <span class="toggle-icon">&#9654;</span></a>
        <div class="submenu" id="asetSubmenu">
            <a href="{{url('')}}/asset_peta"><i class="fa-solid fa-map menu-icon"></i>Peta</a>
            <a href="{{url('')}}/asset_recovery"><i class="fa-solid fa-rotate menu-icon"></i>Recovery</a>
            <a href="{{url('')}}/asset_optimalisasi"><i class="fa-solid fa-chart-pie menu-icon"></i>Optimalisasi</a>
            <a href="{{url('')}}/asset_divestasi"><i class="fa-solid fa-hand-holding-dollar menu-icon"></i>Divestasi</a>
        </div>
        <a href="#finansial" id="finansial" class="parent"><i class="fa-solid fa-coins menu-icon"></i>Finansial <span class="toggle-icon">&#9654;</span></a>
        <div class="submenu" id="finansialSubmenu">
            <a href="{{url('')}}/fin_console"><i class="fa-solid fa-layer-group menu-icon"></i>Consolidate</a>
            <a href="{{url('')}}/fin_parent"><i class="fa-solid fa-building menu-icon"></i>Parent Only</a>
            <a href="{{url('')}}/fin_sub"><i class="fa-solid fa-sitemap menu-icon"></i>Subsidiary</a>
        </div>
        <a href="#hrsdm" id="hrsdm" class="parent"><i class="fa-solid fa-users menu-icon"></i>Human Resource<span class="toggle-icon">&#9654;</span></a>
        <div class="submenu" id="hrSubmenu">
            <a href="{{url('')}}/hr_demographics"><i class="fa-solid fa-user-group menu-icon"></i>HR Demographics</a>
            <a href="{{url('')}}/hr_dev"><i class="fa-solid fa-graduation-cap menu-icon"></i>HR Learning & Development</a>
            <a href="{{url('')}}/hr_revenue"><i class="fa-solid fa-money-bill-trend-up menu-icon"></i>HR Revenue & Cost</a>
        </div>
        <a href="#agraria" id="aset" class="parent"><i class="fa-solid fa-scale-balanced menu-icon"></i>Legal & Agraria <span class="toggle-icon">&#9654;</span></a>
        <div class="submenu" id="asetSubmenu">
            <a href="{{url('')}}/agraria_tax"><i class="fa-solid fa-percent menu-icon"></i>Tax Relaxation BPHTP 0%</a>
            <a href="{{url('')}}/agraria"><i class="fa-solid fa-file-contract menu-icon"></i>Agraria</a>
        </div>
        <!-- <a href="{{url('')}}/pengadaan" class="menu-item" id="pengadaan">Pengadaan</a> -->
        <a href="#capaian" id="capaian" class="parent"><i class="fa-solid fa-chart-line menu-icon"></i>Capaian Progres <span class="toggle-icon">&#9654;</span></a>
        <div class="submenu" id="asetSubmenu">
            <a href="{{url('')}}/sla"><i class="fa-solid fa-clock menu-icon"></i>SLA</a>
        </div>
        <a href="#pengadaan" id="pengadaan" class="parent"><i class="fa-solid fa-cart-shopping menu-icon"></i>Pengadaan<span class="toggle-icon">&#9654;</span></a>
        <div class="submenu" id="asetSubmenu">
            <a href="{{url('')}}/prapengadaan"><i class="fa-solid fa-clipboard-check menu-icon"></i>Pra Pengadaan</a>
            <a href="{{url('')}}/prosespengadaan"><i class="fa-solid fa-spinner menu-icon"></i>Proses Pengadaan</a>
            <a href="{{url('')}}/kontrakpengadaan"><i class="fa-solid fa-file-signature menu-icon"></i>Kontrak Pengadaan</a>
            <a href="{{url('')}}/stokpengadaan"><i class="fa-solid fa-boxes-stacked menu-icon"></i>Stok Pengadaan</a>
        </div>
        <div class="submenu" id="asetSubmenu">
            <a href="{{url('')}}/dashemisi"><i class="fa-solid fa-smog menu-icon"></i>Dashboard Emisi</a>
        </div>
        <a href="#gis" id="gis" class="parent"><i class="fa-solid fa-map-location-dot menu-icon"></i>GIS <span class="toggle-icon">&#9654;</span></a>
        <div class="submenu" id="gisSubmenu">
            <a href="http://gis.ptpn1.co.id/mbtiles/tree4.php?id=0&token=eofkp4456432oewkf465oew" target='_blank' class="menu-item" id="gis"><i class="fa-solid fa-map menu-icon"></i>AREAL</a>
            <a href="http://gis.ptpn1.co.id/mbtiles/tree5.php?id=0&token=eofkp4456432oewkf465oew" target='_blank' class="menu-item" id="gis"><i class="fa-solid fa-satellite-dish menu-icon"></i>NDVI</a>
            <a href="http://aset-dives-dev.ptpn1.co.id/weather?token=234kjjlksflk8y98ksafdklj23" target='_blank' class="menu-item" id="gis"><i class="fa-solid fa-cloud-sun menu-icon"></i>CUACA</a>
        </div>
        @endif

        
        @if($username!='mrc')
        <a href="{{url('')}}/aigri" class="menu-item" id="aigr1"><i class="fa-solid fa-robot menu-icon"></i>AIGR1</a>
        <a href="{{url('')}}/gardai" class="menu-item" id="gardai"><i class="fa-solid fa-fire-flame-curved menu-icon"></i>Garda AI</a>
        <a href="{{url('')}}/portalaplikasi" class="menu-item" id="portalaplikasi"><i class="fa-solid fa-th-large menu-icon"></i>Portal Aplikasi</a>

        @endif
        <a href="{{url('')}}/logout" class="menu-item" id="logout"><i class="fa-solid fa-right-from-bracket menu-icon"></i>Logout</a>
    </div>
</div>

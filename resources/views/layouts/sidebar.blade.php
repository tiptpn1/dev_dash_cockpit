<div class="icon" id="menuIcon">
    <img src="{{url('')}}/asset/images/menu.png" alt="Menu Icon">
</div>
<div class="sidebar" id="sidebar">
    <?php
$user = Auth::guard('custom')->user();
$username = "";
if (isset($user)) {
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
        @if($user && $user->hasFeature('mrc'))
            <a href="{{url('')}}/mrc" class="menu-item" id="mrc"><i class="fa-solid fa-calendar-days menu-icon"></i>MRC</a>
        @endif
        @if($user && $user->hasFeature('operasional'))
            <a href="#operasional" id="operasional" class="parent"><i class="fa-solid fa-gears menu-icon"></i>Operasional
                <span class="toggle-icon">&#9654;</span></a>
            <div class="submenu" id="operasionalSubmenu">
                <a href="{{url('')}}/amanah"><i class="fa-solid fa-building menu-icon"></i>AMANAH</a>
                <a href="{{url('')}}/dfarmkaret"><i class="fa-solid fa-seedling menu-icon"></i>DFarm PTPN I</a>
            </div>
        @endif
        @if($user && $user->hasFeature('pica'))
            <a href="#pica" id="pica" class="parent"><i class="fa-solid fa-clipboard-list menu-icon"></i>PICA
                <span class="toggle-icon">&#9654;</span></a>
            <div class="submenu" id="picaSubmenu">
                <a href="{{ route('pica.kuadran_problem_identifications') }}"><i
                        class="fa-solid fa-table-cells-large menu-icon"></i>Kuadran Problem Identifications</a>
                <a href="{{ route('pica.list_corrective_actions') }}"><i class="fa-solid fa-list-check menu-icon"></i>List
                    Corrective Actions</a>
            </div>
        @endif
        @if($user && $user->hasFeature('warehouse'))
            <a href="{{url('')}}/gudangutilisasi" class="menu-item" id='warehouse'><i
                    class="fa-solid fa-warehouse menu-icon"></i>Warehouse</a>
        @endif
        @if($user && $user->hasFeature('sales'))
            <a href="#sales" id="sales" class="parent"><i class="fa-solid fa-chart-line menu-icon"></i>Sales<span
                    class="toggle-icon">&#9654;</span></a>
            <div class="submenu" id="salesSubmenu">
                <a href="{{url('')}}/sales_comodities"><i class="fa-solid fa-boxes-stacked menu-icon"></i>Comodities
                    Sales</a>
                <a href="{{url('')}}/soptea"><i class="fa-solid fa-mug-hot menu-icon"></i>S&OP Tea</a>
            </div>
        @endif
        @if($user && $user->hasFeature('aset'))
            <a href="#aset" id="aset" class="parent"><i class="fa-solid fa-building menu-icon"></i>Asset <span
                    class="toggle-icon">&#9654;</span></a>
            <div class="submenu" id="asetSubmenu">
                <a href="{{url('')}}/asset_peta"><i class="fa-solid fa-map menu-icon"></i>Peta</a>
                <a href="{{url('')}}/asset_recovery"><i class="fa-solid fa-rotate menu-icon"></i>Recovery</a>
                <a href="{{url('')}}/asset_optimalisasi"><i class="fa-solid fa-chart-pie menu-icon"></i>Optimalisasi</a>
                <a href="{{url('')}}/asset_divestasi"><i class="fa-solid fa-hand-holding-dollar menu-icon"></i>Divestasi</a>
            </div>
        @endif
        @if($user && $user->hasFeature('finansial'))
            <a href="#finansial" id="finansial" class="parent"><i class="fa-solid fa-coins menu-icon"></i>Finansial <span
                    class="toggle-icon">&#9654;</span></a>
            <div class="submenu" id="finansialSubmenu">
                <a href="{{url('')}}/fin_console"><i class="fa-solid fa-layer-group menu-icon"></i>Consolidate</a>
                <a href="{{url('')}}/fin_parent"><i class="fa-solid fa-building menu-icon"></i>Parent Only</a>
                <a href="{{url('')}}/fin_sub"><i class="fa-solid fa-sitemap menu-icon"></i>Subsidiary</a>
            </div>
        @endif
        @if($user && $user->hasFeature('hr'))
            <a href="#hrsdm" id="hrsdm" class="parent"><i class="fa-solid fa-users menu-icon"></i>Human Resource<span
                    class="toggle-icon">&#9654;</span></a>
            <div class="submenu" id="hrSubmenu">
                <a href="{{url('')}}/hr_demographics"><i class="fa-solid fa-user-group menu-icon"></i>HR Demographics</a>
                <a href="{{url('')}}/hr_dev"><i class="fa-solid fa-graduation-cap menu-icon"></i>HR Learning &
                    Development</a>
                <a href="{{url('')}}/hr_revenue"><i class="fa-solid fa-money-bill-trend-up menu-icon"></i>HR Revenue &
                    Cost</a>
            </div>
        @endif
        @if($user && $user->hasFeature('legal'))
            <a href="#agraria" id="legal" class="parent"><i class="fa-solid fa-scale-balanced menu-icon"></i>Legal & Agraria
                <span class="toggle-icon">&#9654;</span></a>
            <div class="submenu" id="legalSubmenu">
                <a href="{{url('')}}/agraria_tax"><i class="fa-solid fa-percent menu-icon"></i>Tax Relaxation BPHTP 0%</a>
                <a href="{{url('')}}/agraria"><i class="fa-solid fa-file-contract menu-icon"></i>Agraria</a>
            </div>
        @endif
        @if($user && $user->hasFeature('progress'))
            <a href="#capaian" id="capaian" class="parent"><i class="fa-solid fa-chart-line menu-icon"></i>Capaian Progres
                <span class="toggle-icon">&#9654;</span></a>
            <div class="submenu" id="capaianSubmenu">
                <a href="{{url('')}}/sla"><i class="fa-solid fa-clock menu-icon"></i>SLA</a>
            </div>
        @endif
        @if($user && $user->hasFeature('pengadaan'))
            <a href="#pengadaan" id="pengadaan" class="parent"><i
                    class="fa-solid fa-cart-shopping menu-icon"></i>Pengadaan<span class="toggle-icon">&#9654;</span></a>
            <div class="submenu" id="pengadaanSubmenu">
                <a href="{{url('')}}/prapengadaan"><i class="fa-solid fa-clipboard-check menu-icon"></i>Pra Pengadaan</a>
                <a href="{{url('')}}/prosespengadaan"><i class="fa-solid fa-spinner menu-icon"></i>Proses Pengadaan</a>
                <a href="{{url('')}}/kontrakpengadaan"><i class="fa-solid fa-file-signature menu-icon"></i>Kontrak
                    Pengadaan</a>
                <a href="{{url('')}}/stokpengadaan"><i class="fa-solid fa-boxes-stacked menu-icon"></i>Stok Pengadaan</a>
            </div>
        @endif
        @if($user && $user->hasFeature('carbon'))
            <a href="#carbon" id="carbon" class="parent"><i class="fa-solid fa-smog menu-icon"></i>Carbon
                <span class="toggle-icon">&#9654;</span></a>
            <div class="submenu" id="carbonSubmenu">
                <a href="{{url('')}}/dashboardemisi"><i class="fa-solid fa-smog menu-icon"></i>Dashboard Emisi</a>
            </div>
        @endif
        @if($user && $user->hasFeature('gis'))
            <a href="#gis" id="gis" class="parent"><i class="fa-solid fa-map-location-dot menu-icon"></i>GIS <span
                    class="toggle-icon">&#9654;</span></a>
            <div class="submenu" id="gisSubmenu">
                <a href="https://gis.ptpn1.co.id/tree.php?id=0&token=eofkp4456432oewkf465oew#" target="_blank"
                    rel="noopener noreferrer" class="menu-item" id="gis-areal"><i class="fa-solid fa-map menu-icon"></i></a>
                <a href="http://gis.ptpn1.co.id/mbtiles/tree5.php?id=0&token=eofkp4456432oewkf465oew" target='_blank'
                    class="menu-item" id="gis-ndvi"><i class="fa-solid fa-satellite-dish menu-icon"></i>NDVI</a>
                <a href="http://aset-dives-dev.ptpn1.co.id/weather?token=234kjjlksflk8y98ksafdklj23" target='_blank'
                    class="menu-item" id="gis-cuaca"><i class="fa-solid fa-cloud-sun menu-icon"></i>CUACA</a>
            </div>
        @endif
        @if($user && $user->hasFeature('skyview'))
            <a href="{{url('')}}/skyview-table" class="menu-item" id='skyview'><i
                    class="fa-solid fa-map-location-dot menu-icon"></i>AGRO Skyview</a>
            <a href="{{url('')}}/exec_summary" class="menu-item" id='exec_summary'><i
                    class="fa-solid fa-map-location-dot menu-icon"></i>Exec Summary</a>

        @endif
        @if($user && $user->hasFeature('lm'))
            <a href="#lm" id="lm" class="parent"><i class="fa-solid fa-book menu-icon"></i>LM <span
                    class="toggle-icon">&#9654;</span></a>
            <div class="submenu" id="lmSubmenu">
                <a href="{{url('')}}/lm13"><i class="fa-solid fa-book-open menu-icon"></i>LM13</a>
                <a href="{{url('')}}/lm14"><i class="fa-solid fa-book-open menu-icon"></i>LM14</a>
                <a href="{{url('')}}/lm16"><i class="fa-solid fa-book-open menu-icon"></i>LM16</a>
                <a href="{{url('')}}/lm34_tab"><i class="fa-solid fa-book-open menu-icon"></i>LM34</a>
                <a href="{{url('')}}/lm62"><i class="fa-solid fa-book-open menu-icon"></i>LM62</a>
            </div>
        @endif
    </div>

    @if($user && $user->hasFeature('aigr1'))
        <a href="{{url('')}}/aigri" class="menu-item" id="aigr1"><i class="fa-solid fa-robot menu-icon"></i>AIGR1</a>
    @endif
    @if($user && $user->hasFeature('garda'))
        <a href="{{url('')}}/gardai" class="menu-item" id="gardai"><i
                class="fa-solid fa-fire-flame-curved menu-icon"></i>Garda AI</a>
    @endif
    @if($user && $user->hasFeature('portalaplikasi'))
        <a href="{{url('')}}/portalaplikasi" class="menu-item" id="portalaplikasi"><i
                class="fa-solid fa-th-large menu-icon"></i>Portal Aplikasi</a>
    @endif

    @if($user && $user->hasFeature('evaluasi_aplikasi'))
        <a href="{{url('')}}/evaluasi-aplikasi" class="menu-item" id="evaluasiaplikasi"><i
                class="fa-solid fa-clipboard-check menu-icon"></i>Evaluasi Aplikasi</a>
    @endif

    @if($user && ($user->hasFeature('management_users') || $user->hasFeature('management_features') || $user->hasFeature('management_access')))
        <a href="#management" id="management" class="parent"><i class="fa-solid fa-cogs menu-icon"></i>System Management
            <span class="toggle-icon">&#9654;</span></a>
        <div class="submenu" id="managementSubmenu">
            @if($user->hasFeature('management_users'))
                <a href="{{ route('management.users.index') }}"><i class="fa-solid fa-users menu-icon"></i>User</a>
            @endif
            @if($user->hasFeature('management_features'))
                <a href="{{ route('management.features.index') }}"><i class="fa-solid fa-cube menu-icon"></i>Fitur</a>
            @endif
            @if($user->hasFeature('management_access'))
                <a href="{{ route('management.access.index') }}"><i class="fa-solid fa-shield-halved menu-icon"></i>Hak
                    Akses</a>
            @endif
        </div>
    @endif

    <a href="{{url('')}}/logout" class="menu-item" id="logout"><i
            class="fa-solid fa-right-from-bracket menu-icon"></i>Logout</a>
</div>
</div>
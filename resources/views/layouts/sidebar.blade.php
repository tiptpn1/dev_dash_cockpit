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
        <div class="menu">
        <!-- <a href="#home">Home</a> -->
        @if($username!='mrc')
        <a href="{{url('')}}" class="menu-item" id="overview">Overview</a>
        @endif
        <a href="{{url('')}}/mrc" class="menu-item" id="overview">MRC</a>
        @if($username!='mrc')
        <a href="#operasional" id="operasional" class="parent">Operasional <span class="toggle-icon">&#9654;</span></a>
        <div class="submenu" id="operasionalSubmenu">
            <a href="#" id="karetSubmenu" class="parents">Karet<span class="toggle-icon">&#9654;</span></a>
            <div class="submenu subsub">
                <a href="{{url('')}}/onfarmkaret">On Farm</a>
                <a href="{{url('')}}/offfarmkaret">Off Farm</a>
            </div>
            <a href="#" id="tehSubmenu" class="parents">Teh<span class="toggle-icon">&#9654;</span></a>
            <div class="submenu subsub">
                <a href="{{url('')}}/onfarmteh">On Farm</a>
                <a href="{{url('')}}/offfarmteh">Off Farm</a>
            </div>
            <a href="{{url('')}}/onfarmkopi">Kopi</a>
            <a href="{{url('')}}/iot">IOT</a>
            <a href="{{url('')}}/amanah">AMANAH</a>
            <a href="{{url('')}}/picaonfarm">PICA On Farm</a>
            <a href="{{url('')}}/picaofffarm">PICA Off Farm</a>
            <a href="{{url('')}}/dfarmkaret">DFarm Karet</a>
            <a href="{{url('')}}/dfarmteh">DFarm Teh</a>
        </div>
        <a href="#aset" id="aset" class="parent">Asset <span class="toggle-icon">&#9654;</span></a>
        <div class="submenu" id="asetSubmenu">
            <a href="{{url('')}}/asset_peta">Peta</a>
            <a href="{{url('')}}/asset_recovery">Recovery</a>
            <a href="{{url('')}}/asset_optimalisasi">Optimalisasi</a>
            <a href="{{url('')}}/asset_divestasi">Divestasi</a>
        </div>
        <a href="#finansial" id="finansial" class="parent">Finansial <span class="toggle-icon">&#9654;</span></a>
        <div class="submenu" id="finansialSubmenu">
            <a href="{{url('')}}/fin_console">Consolidate</a>
            <a href="{{url('')}}/fin_parent">Parent Only</a>
            <a href="{{url('')}}/fin_sub">Subsidiary</a>
        </div>
        <a href="#hrsdm" id="hrsdm" class="parent">Human Resource<span class="toggle-icon">&#9654;</span></a>
        <div class="submenu" id="hrSubmenu">
            <a href="{{url('')}}/hr_demographics">HR Demographics</a>
            <a href="{{url('')}}/hr_dev">HR Learning & Development</a>
            <a href="{{url('')}}/hr_revenue">HR Revenue & Cost</a>
        </div>
        <a href="#sales" id="sales" class="parent">Sales<span class="toggle-icon">&#9654;</span></a>
        <div class="submenu" id="salesSubmenu">
            <a href="{{url('')}}/sales_comodities">Comodities Sales</a>
            <a href="{{url('')}}/soptea">S&OP Tea</a>
        </div>
        <a href="#agraria" id="aset" class="parent">Legal & Agraria <span class="toggle-icon">&#9654;</span></a>
        <div class="submenu" id="asetSubmenu">
            <a href="{{url('')}}/agraria_tax">Tax Relaxation BPHTP 0%</a>
            <a href="{{url('')}}/agraria">Agraria</a>
        </div>
        <!-- <a href="{{url('')}}/pengadaan" class="menu-item" id="pengadaan">Pengadaan</a> -->
        <a href="#capaian" id="capaian" class="parent">Capaian Progres <span class="toggle-icon">&#9654;</span></a>
        <div class="submenu" id="asetSubmenu">
            <a href="{{url('')}}/sla">SLA</a>
        </div>
        <a href="#pengadaan" id="pengadaan" class="parent">Pengadaan<span class="toggle-icon">&#9654;</span></a>
        <div class="submenu" id="asetSubmenu">
            <a href="{{url('')}}/prapengadaan">Pra Pengadaan</a>
            <a href="{{url('')}}/prosespengadaan">Proses Pengadaan</a>
            <a href="{{url('')}}/kontrakpengadaan">Kontrak Pengadaan</a>
        </div>
        <a href="#carbontrading" id="carbontrading" class="parent">Carbon Trading<span class="toggle-icon">&#9654;</span></a>
        <div class="submenu" id="asetSubmenu">
            <a href="{{url('')}}/dashemisi">Dashboard Emisi</a>
        </div>
        <a href="{{url('')}}/portalaplikasi" class="menu-item" id="portalaplikasi">Portal Aplikasi</a>
        @endif
        <a href="{{url('')}}/logout" class="menu-item" id="logout">Logout</a>
    </div>
</div>
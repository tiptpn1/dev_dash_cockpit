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
        @if(isset($sidebarMenus))
            @foreach($sidebarMenus as $menu)
                @if($menu->children->isNotEmpty())
                    @php
                        $submenuId = $menu->slug . 'Submenu';
                    @endphp
                    <a href="#{{ $menu->slug }}" id="{{ $menu->slug }}" class="parent">
                        <i class="{{ $menu->icon }} menu-icon"></i>{{ $menu->name }}
                        <span class="toggle-icon">&#9654;</span>
                    </a>
                    <div class="submenu" id="{{ $submenuId }}">
                        @foreach($menu->children as $child)
                            @if($user && $user->hasFeature($child->slug))
                                @php
                                    $url = $child->url;
                                    if ($child->slug === 'sales_sonia') {
                                        $url = rtrim(config('services.sonia.url'), '/') . '/auth/agrinav?token=' . urlencode(config('services.sonia.sso_token'));
                                    } elseif ($child->slug === 'operasional_cctv') {
                                        $url = 'https://cctv.ptpn1.co.id/index.php?token=QMekBGJyEv4kFk8tscWzEV2xXFxUWfqvQ2poIDqb1z2LaDJiJzJrGwveJ7DLxz76';
                                    } elseif ($child->slug === 'gis_areal') {
                                        $url = 'https://gis.ptpn1.co.id/tree.php?id=0&token=eofkp4456432oewkf465oew#';
                                    } elseif ($child->slug === 'gis_ndvi') {
                                        $url = 'http://gis.ptpn1.co.id/mbtiles/tree5.php?id=0&token=eofkp4456432oewkf465oew';
                                    } elseif ($child->slug === 'gis_cuaca') {
                                        $url = 'http://aset-dives-dev.ptpn1.co.id/weather?token=234kjjlksflk8y98ksafdklj23';
                                    } else {
                                        if (empty($url)) {
                                            $url = '#';
                                        } else {
                                            $url = (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) ? $url : url($url);
                                        }
                                    }
                                @endphp
                                <a href="{{ $url }}" 
                                   @if(str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) target="_blank" rel="noopener noreferrer" @endif
                                   id="{{ $child->slug }}">
                                    <i class="{{ $child->icon }} menu-icon"></i>{{ $child->name }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                @else
                    @php
                        $url = $menu->url;
                        if (empty($url)) {
                            $url = '#';
                        } else {
                            $url = (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) ? $url : url($url);
                        }
                    @endphp
                    <a href="{{ $url }}" 
                       @if(str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) target="_blank" rel="noopener noreferrer" @endif
                       class="menu-item" 
                       id="{{ $menu->slug }}">
                        <i class="{{ $menu->icon }} menu-icon"></i>{{ $menu->name }}
                    </a>
                @endif
            @endforeach
        @endif

    <a href="{{ route('password.change') }}" class="menu-item" id="change-password"><i
            class="fa-solid fa-key menu-icon"></i>Ubah Password</a>
    <a href="{{url('')}}/logout" class="menu-item" id="logout"><i
            class="fa-solid fa-right-from-bracket menu-icon"></i>Logout</a>
    </div>
</div>
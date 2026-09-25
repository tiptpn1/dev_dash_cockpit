<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('ptpn1.png') }}" type="image/png">
    <title>@yield('title', 'AGRINAV')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Droid+Sans:wght@400;700&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">    
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    @yield('styles')
    <style>
        /* Step 2: CSS to Style the Sidebar and Main Content */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
            /* font-family: Arial, sans-serif; */
            font-family: 'Droid Sans', sans-serif;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            height: 100vh;
            height: 100dvh;
            background-color: #202124;
            overflow-x: hidden;
            overflow-y: auto;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.3s;
            z-index: 99999;
            visibility: hidden;
            box-sizing: border-box;
            box-shadow: none;
        }

        .sidebar.open {
            width: 250px;
            padding: 1rem;
            visibility: visible;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.4);
        }

        .sidebar-header {
            display: none;
            align-items: center;
            justify-content: space-between;
            padding: 12px 10px;
            margin-bottom: 8px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            background: rgba(0, 0, 0, 0.15);
            border-radius: 6px;
        }
        .sidebar.open .sidebar-header {
            display: flex;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-close-btn {
            background: none;
            border: none;
            color: #9aa0a6;
            font-size: 1.75rem;
            line-height: 1;
            cursor: pointer;
            padding: 2px 6px;
            border-radius: 4px;
            transition: color 0.2s, background-color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-close-btn:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar-title {
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            color: #e8eaed;
        }
        .sidebar-logo {
            height: 32px;
            width: auto;
            object-fit: contain;
        }

        .sidebar .menu {
            display: none;
            padding-top: 12px;
        }

        .sidebar.open .menu {
            display: block;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 10px 12px;
            text-decoration: none;
            color: #e8e8e8;
            text-align: left;
            transition: background-color 0.3s;
            font-size: 1em;
            min-height: 40px;
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        .sidebar .menu-icon {
            flex-shrink: 0;
            width: 1.15em;
            margin-right: 10px;
            text-align: center;
            color: #e8e8e8;
        }

        .sidebar a .toggle-icon {
            margin-left: auto;
            flex-shrink: 0;
            font-size: 0.78em;
        }

        .sidebar .menu-item-desc {
            font-size: 0.85em;
            color: #9aa0a6;
            margin-left: 4px;
        }

        .main-content {
            margin-left: 0;
            padding: 20px 0 20px 20px;
            transition: margin-left 0.3s;
            width: 100%;
            box-sizing: border-box;
        }

        .iframe-container {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .iframe-container.main-content {
            padding: 0;
        }

        .iframe-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        .sidebar.open ~ .main-content {
            margin-left: 250px;
        }

        .icon {
            position: fixed;
            top: 10px;
            left: 10px;
            cursor: pointer;
            z-index: 10002;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.35);
            border-radius: 8px;
            backdrop-filter: blur(4px);
            transition: background-color 0.2s;
        }

        .icon:hover {
            background: rgba(0, 0, 0, 0.55);
        }

        .icon img {
            width: 26px;
            height: 26px;
        }

        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            height: 100dvh;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(2px);
            z-index: 99998;
            transition: opacity 0.3s;
        }

        .sidebar-backdrop.active {
            display: block;
        }

        /* Custom scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: #1e1f22;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: #4e5058;
            border-radius: 3px;
        }
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #6d6f78;
        }

        /* Responsive Mobile Rules */
        @media (max-width: 768px) {
            .sidebar {
                display: block !important;
                z-index: 99999 !important;
            }

            .sidebar.open {
                display: block !important;
                width: 280px !important;
                max-width: 82vw !important;
                box-shadow: 6px 0 25px rgba(0, 0, 0, 0.6) !important;
            }

            /* Di HP, jangan pernah dorong .main-content agar dashboard/iframe tidak terpotong */
            .sidebar.open ~ .main-content {
                margin-left: 0 !important;
            }

            .sidebar a {
                padding: 12px 14px;
                font-size: 0.95rem;
            }
        }
        .submenu {
            display: none;
            background-color: #3c4043;
        }

        .submenu a {
            padding-left: 36px;
        }

        .sidebar a.active + .submenu {
            display: block!important;
        }
        .sidebar .parents.a.active + .submenu {
            display: block!important;
        }
        .toggle-icon {
            float: right;
            transition: transform 0.3s;
        }

        .toggle-icon.open {
            transform: rotate(90deg);
        }
        .subsub {
            padding-left:10px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="h-screen bg-gray-100">
    <!-- Step 3: Icon Outside Sidebar -->
    <div class="icon" id="menuIcon" title="Toggle Menu">
        <img src="{{url('')}}/asset/images/menu.png" alt="Menu Icon">
    </div>

    <!-- Backdrop Overlay for Mobile -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- Step 4: Sidebar Menu -->
    @include('layouts.sidebar')
    <!-- Step 5: Main Content -->
    @yield('content')
    <!-- Step 6: JavaScript to Toggle Sidebar -->
    <script>
        $(document).ready(function() {
            function toggleSidebar(forceState) {
                var $sidebar = $('.sidebar');
                var $backdrop = $('#sidebarBackdrop');
                var willOpen = forceState !== undefined ? forceState : !$sidebar.hasClass('open');

                if (willOpen) {
                    $sidebar.addClass('open');
                    $backdrop.addClass('active');
                } else {
                    $sidebar.removeClass('open');
                    $backdrop.removeClass('active');
                }
            }

            // Click menu icon
            $(document).on('click', '#menuIcon', function(e) {
                e.stopPropagation();
                toggleSidebar();
            });

            // Click close button inside sidebar header
            $(document).on('click', '#sidebarCloseBtn', function(e) {
                e.stopPropagation();
                toggleSidebar(false);
            });

            // Click backdrop overlay to close sidebar on mobile
            $(document).on('click', '#sidebarBackdrop', function() {
                toggleSidebar(false);
            });
        });
        $('.sidebar .parent').click(function(event) {
            event.preventDefault();
            var $this = $(this);
            var $submenu = $this.next('.submenu');
            var $icon = $this.find('.toggle-icon');

            // Close all other submenus
            $('.submenu').not($submenu).slideUp();
            $('.sidebar .parent').not($this).removeClass('active');
            $('.toggle-icon').not($icon).removeClass('open');
            $('.parents').removeClass('active');
            $('.parents .toggle-icon').removeClass('open');

            // Toggle the clicked submenu and icon
            $submenu.slideToggle();
            $this.toggleClass('active');
            $icon.toggleClass('open');
        });
        $('.sidebar .parents').click(function(event) {
            event.preventDefault();
            var $this = $(this);
            var $submenu = $this.next('.parents .submenu');
            var $icon = $this.find('.toggle-icon');

            // Close all other submenus
            $('.parents .submenu').not($submenu).slideUp();
            $('.sidebar .parents').not($this).removeClass('active');
            $('.toggle-icon').not($icon).removeClass('open');

            // Toggle the clicked submenu and icon
            $submenu.slideToggle();
            $this.toggleClass('active');
            $icon.toggleClass('open');
        });
    </script>
    @include('components.chat-icon')
    @include('components.log-viewer-button')
    @yield('scripts')
</body>
</html>
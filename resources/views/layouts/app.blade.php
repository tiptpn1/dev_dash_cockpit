<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <link rel="shortcut icon" href="https://nadine.ptpn1.co.id/assets/logosupco.png">
    <title>Dashboard PTPN I</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Droid+Sans:wght@400;700&display=swap">
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
            background-color: #202124;
            overflow-x: hidden;
            transition: width 0.3s;
            z-index: 998;
        }

        .sidebar.open {
            width: 200px;
        }

        .sidebar .menu {
            display: none;
            padding-top: 30%;
        }

        .sidebar.open .menu {
            display: block;
        }

        .sidebar a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #e8e8e8;
            text-align: left;
            transition: background-color 0.3s;
            font-size: 0.9em;
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        .main-content {
            margin-left: 0;
            padding: 20px;
            transition: margin-left 0.3s;
        }

        .iframe-container {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .iframe-container iframe {
            position: absolute;
            top: 0;
            left: -1%;
            width: 99%;
            height: 100%;
            border: none; /* Optional: Remove the border */
        }

        .sidebar.open ~ .main-content {
            margin-left: 200px;
        }

        .icon {
            position: fixed;
            top: 5px;
            left: 5px;
            cursor: pointer;
            z-index: 1000;
        }

        .icon img {
            width: 30px;
            height: 30px;
        }
        .submenu {
            display: none;
            background-color: #3c4043;
        }

        .submenu a {
            padding-left: 30px;
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
<body>
    <!-- Step 3: Icon Outside Sidebar -->
    <div class="icon" id="menuIcon">
        <img src="{{url('')}}/asset/images/menu.png" alt="Menu Icon">
    </div>

    <!-- Step 4: Sidebar Menu -->
    @include('layouts.sidebar')
    <!-- Step 5: Main Content -->
    @yield('content')
    <!-- Step 6: JavaScript to Toggle Sidebar -->
    <script>
        $(document).ready(function() {
            console.log('lalalala');
            $('#menuIcon img').click(function() {
                console.log('lalalala');
                $('.sidebar').toggleClass('open');
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
</body>
</html>
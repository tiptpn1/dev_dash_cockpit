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
    <link rel="stylesheet" href="{{url('')}}/assets/css/app.css">
    <title>Dashboard PTPN I</title>
        
</head>
<body>
    <!-- Step 4: Sidebar Menu -->
    @include('layouts.sidebar')
    <!-- Step 5: Main Content -->
    @yield('content')
    <!-- Step 6: JavaScript to Toggle Sidebar -->
    <script>
        document.getElementById('menuIcon').addEventListener('click', function() {
            var sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        });
        document.getElementById('homeMenu').addEventListener('click', function(event) {
            event.preventDefault();
            this.classList.toggle('active');
        });
    </script>
</body>
</html>
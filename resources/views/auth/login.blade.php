<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard PTPN I</title>
    <style>
        /* Step 2: CSS to Style the Page */
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #081028;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background-color: #374C88;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 95%;
            position: relative;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 95%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-container button {
            /* width: 100%; */
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 30%;
            float:left;
            
        }
        .login-container button:hover {
            background-color: #45a049;
        }
        h2{
            color:#f7f7f7;
        }
        .g-recaptcha {
            width: 100% !important;
        }

        .g-recaptcha div {
            width: 100% !important;
            margin: 0 auto;
        }
        .logo{
            position: absolute;
            text-align: center;
            top: -36%;
            color: white;
            /* width: 90%; */
            left:0;
            font-size:5em;
            
        }
    </style>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <!-- Step 3: Login Form Container -->
    
    <div class="login-container">
        <!-- <h1 class="logo">Dashboard</h1> -->
        <h2>Welcome Back!</h2>
        <p></p>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <!-- <div class="g-recaptcha" data-sitekey="6LdawH8qAAAAACX4jhCLAN8Tqq6yfBiy2ZVLBnuc"></div> -->
            <br>
            <button type="submit">Login</button>
            @foreach ($errors->all() as $error)
               <span style="color:red; float:right;">{{ $error }}</span>
               <br>
           @endforeach
        </form>
    </div>
</body>
</html>
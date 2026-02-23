<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dashboard PTPN I</title>
    <link rel="shortcut icon" href="{{ asset('ptpn1.png') }}" type="image/png">
    <style>
        * {
            box-sizing: border-box;
        }
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            overflow: hidden;
        }
        .login-page {
            display: flex;
            width: 100%;
            height: 100vh;
            min-height: 100vh;
        }
        /* Foto kiri: 3/4 lebar */
        .login-photo {
            width: 75%;
            flex: 0 0 75%;
            position: relative;
            overflow: hidden;
            background: #0f172a;
        }
        .login-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .login-photo::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(0,0,0,0.4) 0%, transparent 50%);
            pointer-events: none;
        }
        /* Form kanan: 1/4 lebar — tema biru seperti home */
        .login-form-wrap {
            width: 25%;
            flex: 0 0 25%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: linear-gradient(180deg, #1e3a5f 0%, #152942 100%);
        }
        .login-form-box {
            width: 100%;
            max-width: 340px;
            text-align: center;
            background: rgba(255, 255, 255, 0.06);
            padding: 32px 28px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }
        .login-form-box h1 {
            margin: 0 0 8px;
            font-size: 1.75rem;
            font-weight: 700;
            color: #e8eaed;
        }
        .login-form-box .subtitle {
            margin: 0 0 28px;
            font-size: 0.9rem;
            color: #9aa0a6;
        }
        .login-form-box form {
            display: flex;
            flex-direction: column;
            gap: 16px;
            text-align: left;
        }
        .login-form-box label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #bdc1c6;
        }
        .login-form-box input[type="text"],
        .login-form-box input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            font-size: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.08);
            color: #e8eaed;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .login-form-box input::placeholder {
            color: #80868b;
        }
        .login-form-box input:focus {
            outline: none;
            border-color: #5b8def;
            box-shadow: 0 0 0 3px rgba(91, 141, 239, 0.25);
            background: rgba(255, 255, 255, 0.1);
        }
        .login-password-wrap {
            position: relative;
        }
        .login-password-wrap input {
            padding-right: 44px;
        }
        .login-toggle-pwd {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            width: 36px;
            height: 36px;
            padding: 0;
            background: none;
            border: none;
            cursor: pointer;
            color: #9aa0a6;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s, background 0.2s;
        }
        .login-toggle-pwd:hover {
            color: #e8eaed;
            background: rgba(255, 255, 255, 0.08);
        }
        .login-toggle-pwd svg {
            width: 20px;
            height: 20px;
        }
        .login-form-box button[type="submit"] {
            width: 100%;
            padding: 12px 20px;
            font-size: 1rem;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(180deg, #4a7bc8 0%, #3c6bb5 100%);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 8px;
            transition: background 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(60, 107, 181, 0.4);
        }
        .login-form-box button[type="submit"]:hover {
            background: linear-gradient(180deg, #5b8def 0%, #4a7bc8 100%);
            box-shadow: 0 4px 12px rgba(91, 141, 239, 0.35);
        }
        .login-errors {
            font-size: 0.85rem;
            color: #f28b82;
        }
        .login-logo {
            margin-bottom: 24px;
            display: flex;
            justify-content: center;
        }
        .login-logo img {
            height: 44px;
            width: auto;
        }
        .login-app-title {
            margin: 0 0 6px;
            font-size: 1.35rem;
            font-weight: 600;
            color: #8ab4f8;
            line-height: 1.4;
        }
        .login-ptpn-title {
            margin: 0 0 16px;
            font-size: 1.2rem;
            font-weight: 600;
            color: #8ab4f8;
        }
        @media (max-width: 900px) {
            .login-page {
                flex-direction: column;
            }
            .login-photo {
                width: 100%;
                flex: 0 0 45%;
                min-height: 40vh;
            }
            .login-form-wrap {
                width: 100%;
                flex: 1;
            }
        }
    </style>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <div class="login-page">
        <div class="login-photo">
            <img src="{{ asset('5.jpg') }}" alt="">
        </div>
        <div class="login-form-wrap">
            <div class="login-form-box">
                <div class="login-logo">
                    <img src="{{ asset('ptpn1.png') }}" alt="PTPN 1">
                </div>
                <p class="login-app-title">Asset and Agribusiness Navigation Dashboard</p>
                <p class="login-ptpn-title">PTPN I</p>
                <h1>Welcome Back</h1>
                <p class="subtitle">Masuk ke dashboard</p>
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan username" required autofocus>
                    <label for="password">Password</label>
                    <div class="login-password-wrap">
                        <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                        <button type="button" class="login-toggle-pwd" id="btnTogglePassword" aria-label="Tampilkan password" title="Tampilkan password">
                            <svg class="icon-eye" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                            <svg class="icon-eye-off" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="display:none"><path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/></svg>
                        </button>
                    </div>
                    <button type="submit">Login</button>
                    @if ($errors->any())
                        <div class="login-errors">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('btnTogglePassword').addEventListener('click', function() {
            var input = document.getElementById('password');
            var eye = this.querySelector('.icon-eye');
            var eyeOff = this.querySelector('.icon-eye-off');
            if (input.type === 'password') {
                input.type = 'text';
                eye.style.display = 'none';
                eyeOff.style.display = 'block';
                this.setAttribute('aria-label', 'Sembunyikan password');
                this.setAttribute('title', 'Sembunyikan password');
            } else {
                input.type = 'password';
                eye.style.display = 'block';
                eyeOff.style.display = 'none';
                this.setAttribute('aria-label', 'Tampilkan password');
                this.setAttribute('title', 'Tampilkan password');
            }
        });
    </script>
</body>
</html>

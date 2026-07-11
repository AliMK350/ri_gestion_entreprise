<!DOCTYPE html>
<html lang="fr">
<head>
    <script>(function(){var t=localStorage.getItem("ri_theme");if(t)document.documentElement.setAttribute("data-theme",t);})();</script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ri Communication — Connexion</title>

    <!-- Google Font: Montserrat -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Ri Brand Theme -->
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">

    <style>
        body.login-page {
            font-family: 'Montserrat', sans-serif;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .login-bg-overlay {
            position: fixed;
            bottom: 0; left: 0;
            width: 100%; height: 52%;
            background: url('{{ asset('dist/img/ri-bg.png') }}') center bottom / cover no-repeat;
            opacity: 0.30;
            z-index: 0;
            pointer-events: none;
        }
        .login-box {
            width: 380px;
            z-index: 2;
            position: relative;
            margin: 0 auto;
        }
        .login-card {
            border-radius: 16px !important;
            box-shadow: 0 8px 48px rgba(0, 173, 239, 0.14) !important;
            border: none !important;
            overflow: hidden;
        }
        .login-card-header {
            background: #fff;
            border-bottom: 2px solid #E8F7FD;
            padding: 2rem 1.5rem 1.25rem;
            text-align: center;
        }
        .login-card-header img {
            max-height: 80px;
            width: auto;
        }
        .login-card-header .tagline {
            font-size: 0.70rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            color: #00ADEF;
            text-transform: uppercase;
            margin-top: 0.5rem;
        }
        .login-box-msg {
            font-size: 0.83rem;
            color: #4A4A4A;
            font-weight: 500;
            margin-bottom: 1.25rem;
            margin-top: 0.25rem;
        }
        .form-control {
            font-family: 'Montserrat', sans-serif !important;
            font-size: 0.85rem !important;
        }
        .btn-ri {
            background: #00ADEF;
            color: #fff;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 0.04em;
            border: none;
            border-radius: 6px;
            padding: 0.55rem 1.2rem;
            transition: background 0.2s, box-shadow 0.2s;
        }
        .btn-ri:hover {
            background: #0090CC;
            color: #fff;
            box-shadow: 0 4px 14px rgba(0,173,239,0.35);
        }
        .login-card-body {
            padding: 1.5rem;
        }
        a { color: #00ADEF !important; }
        a:hover { color: #0090CC !important; }
            /* Login dark mode logo swap handled by theme.css */
        [data-theme="dark"] .login-page { background: #13151A !important; }
        [data-theme="dark"] .login-card { background: #1A1D23 !important; border: 1px solid #2A3040 !important; }
        [data-theme="dark"] .login-card-header { background: #1A1D23 !important; border-bottom-color: #2A3040 !important; }
        [data-theme="dark"] .login-box-msg { color: #9AA3B2 !important; }
        [data-theme="dark"] .form-control { background: #252830 !important; border-color: #2A3040 !important; color: #E8EAF0 !important; }
        [data-theme="dark"] .input-group-text { background: #0D2030 !important; border-color: #2A3040 !important; }
        [data-theme="dark"] .tagline { color: #33C5F5 !important; }
    </style>
</head>

<body class="hold-transition login-page">
    <!-- Background overlay with Ri wave image -->
    <div class="login-bg-overlay"></div>

    <div class="login-box">
        <div class="card login-card">
            <!-- Header with Logo -->
            <div class="login-card-header">
                <img src="{{ asset('dist/img/ri-logo-transparent.png') }}" alt="Ri Communication" class="ri-logo-light">
                <img src="{{ asset('dist/img/ri-logo-dark.png') }}" alt="Ri Communication" class="ri-logo-dark" style="display:none;">
                <div class="tagline">Impact &bull; Visibilité &bull; Performance</div>
            </div>

            <div class="login-card-body card-body">
                @yield('auth_name')
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>
</html>

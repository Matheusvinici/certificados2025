<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'EGESP - Inscrições e Certificados') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app-theme.css') }}">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 50%, #f0f9ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }
        .login-box {
            width: 420px;
            max-width: 100%;
            padding: 1rem;
        }
        .login-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px -12px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .login-card .card-body {
            padding: 2.5rem 2rem;
        }
        .login-logo img {
            max-width: 200px;
            height: auto;
        }
        .login-title {
            font-size: 1.05rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .form-control {
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            padding: 0.65rem 0.9rem;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        .form-control:focus {
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
        }
        .input-group-text {
            border-radius: 0 10px 10px 0;
            border: 1.5px solid #e2e8f0;
            background: #f8fafc;
            color: #64748b;
        }
        .btn-login {
            background: #4f46e5;
            border: none;
            border-radius: 10px;
            padding: 0.65rem 1.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            color: #fff;
            width: 100%;
        }
        .btn-login:hover {
            background: #3730a3;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79,70,229,0.3);
            color: #fff;
        }
        .btn-register {
            border-radius: 10px;
            padding: 0.65rem 1.5rem;
            font-weight: 500;
            font-size: 0.9rem;
            border: 1.5px solid #e2e8f0;
            background: #fff;
            color: #1e293b;
            width: 100%;
            transition: all 0.2s ease;
        }
        .btn-register:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            transform: translateY(-1px);
        }
        .form-check-input:checked {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }
        a {
            color: #4f46e5;
            text-decoration: none;
            font-size: 0.85rem;
        }
        a:hover {
            color: #3730a3;
            text-decoration: underline;
        }
        .divider {
            border-top: 1px solid #e2e8f0;
            margin: 1.25rem 0;
        }
        @media (max-width: 480px) {
            .login-box { padding: 0.75rem; }
            .login-card .card-body { padding: 1.5rem 1.25rem; }
            .login-logo img { max-width: 150px; }
            .login-title { font-size: 0.95rem; }
            .btn-login, .btn-register { padding: 0.6rem 1rem; font-size: 0.85rem; }
        }
    </style>
</head>
<body>
<div class="login-box">
    <div class="login-logo text-center mb-4">
        <img src="{{ asset('images/egesp.png') }}"
             alt="Logo EGESP">
    </div>

    <div class="card login-card">
        <div class="card-body">
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

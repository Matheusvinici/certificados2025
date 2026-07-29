<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistema de Inscrições e Certificados">
    <title>Secretaria de Administração - Inscrições e Certificados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f8fafc; }
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 50%, #f0f9ff 100%);
        }
        .hero-content { padding: 4rem 0; }
        .badge-soft {
            display: inline-block;
            padding: 0.35rem 1rem;
            font-size: 0.8rem;
            font-weight: 500;
            color: #4f46e5;
            background: rgba(79,70,229,0.08);
            border-radius: 50px;
            margin-bottom: 1rem;
            letter-spacing: 0.02em;
        }
        .hero-title {
            font-size: 2.8rem;
            font-weight: 700;
            line-height: 1.15;
            color: #0f172a;
            margin-bottom: 1.2rem;
        }
        .hero-title span { color: #4f46e5; }
        .hero-sub {
            font-size: 1.1rem;
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 2rem;
            max-width: 520px;
        }
        .btn-hero {
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.25s;
        }
        .btn-hero-primary {
            background: #4f46e5;
            color: #fff;
            border: none;
            box-shadow: 0 4px 14px rgba(79,70,229,0.3);
        }
        .btn-hero-primary:hover {
            background: #4338ca;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79,70,229,0.35);
            color: #fff;
        }
        .btn-hero-secondary {
            background: #fff;
            color: #1e293b;
            border: 1.5px solid #e2e8f0;
        }
        .btn-hero-secondary:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            transform: translateY(-2px);
        }
        .hero-image {
            max-width: 100%;
            max-height: 300px;
            object-fit: contain;
        }
        .logo-card {
            background: #fff;
            border-radius: 24px;
            padding: 2.5rem 3rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.06);
            display: inline-block;
        }
        .features {
            padding: 4rem 0;
            background: #fff;
        }
        .feature-card {
            padding: 2rem;
            border-radius: 20px;
            border: 1px solid #f1f5f9;
            transition: all 0.25s;
            height: 100%;
        }
        .feature-card:hover {
            border-color: #e2e8f0;
            box-shadow: 0 8px 24px rgba(0,0,0,0.04);
            transform: translateY(-2px);
        }
        .feature-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 1rem;
        }
        .feature-icon.purple { background: rgba(79,70,229,0.1); color: #4f46e5; }
        .feature-icon.green { background: rgba(16,185,129,0.1); color: #10b981; }
        .feature-icon.blue { background: rgba(59,130,246,0.1); color: #3b82f6; }
        .feature-card h5 { font-weight: 600; font-size: 1.05rem; color: #0f172a; margin-bottom: 0.5rem; }
        .feature-card p { font-size: 0.9rem; color: #64748b; margin-bottom: 0; }
        .footer-welcome {
            padding: 2rem 0;
            text-align: center;
            color: #94a3b8;
            font-size: 0.85rem;
            border-top: 1px solid #f1f5f9;
        }
        @media (max-width: 768px) {
            .hero-title { font-size: 2rem; }
            .hero-content { text-align: center; }
            .hero-sub { margin-left: auto; margin-right: auto; }
        }
    </style>
</head>
<body>

<div class="hero">
    <div class="container hero-content">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="badge-soft">Secretaria de Administração</div>
                <h1 class="hero-title">Escola de Gestão Pública<br><span>(EGESP)</span></h1>
                <p class="hero-sub">
                    Gestão de eventos, formações continuadas e certificados da Prefeitura Municipal de Juazeiro-BA.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('login') }}" class="btn btn-hero btn-hero-primary">Entrar</a>
                    <a href="{{ route('register') }}" class="btn btn-hero btn-hero-secondary">Cadastre-se</a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                    <img src="{{ asset('images/logo.png') }}"
                         alt="Logo"
                         class="hero-image">
            </div>
        </div>
    </div>
</div>

<div class="features">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon purple">📋</div>
                    <h5>Inscrições Online</h5>
                    <p>Inscreva-se em cursos e formações continuadas de forma simples e rápida.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon green">✅</div>
                    <h5>Registro de Frequência</h5>
                    <p>Acompanhamento da presença e avaliação dos encontros formativos.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon blue">🎓</div>
                    <h5>Certificados Automáticos</h5>
                    <p>Geração de certificados com validação e link para verificação online.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer-welcome">
    <div class="container">
        <p class="mb-0">© {{ date('Y') }} Prefeitura Municipal de Juazeiro-BA — Secretaria de Administração</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
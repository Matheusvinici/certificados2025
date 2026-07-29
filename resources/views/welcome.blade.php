<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EGESP — Escola de Gestão Pública | Juazeiro - BA</title>

  <!-- Bootstrap 5.3 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Iconsax (via Unicons by Iconscout) -->
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

  <!-- Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    :root {
      --bs-body-font-family: 'Plus Jakarta Sans', sans-serif;
      --brand: #15467a;
      --brand-soft: #1a5694;
      --accent: #00946d;
      --accent-soft: #00a878;
      --surface-border: rgba(15, 23, 42, 0.08);
      --surface-shadow: 0 10px 40px -12px rgba(15, 23, 42, 0.12);
      --hero-bg: linear-gradient(180deg, rgba(21, 70, 122, 0.04), transparent 60%);
    }

    [data-bs-theme="dark"] {
      --brand: #5ea9ff;
      --brand-soft: #4dabf7;
      --accent: #2dd4a8;
      --accent-soft: #00c896;
      --surface-border: rgba(255, 255, 255, 0.08);
      --surface-shadow: 0 10px 40px -12px rgba(0, 0, 0, 0.5);
      --hero-bg: linear-gradient(180deg, rgba(94, 169, 255, 0.06), transparent 60%);
    }

    * { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 400;
      letter-spacing: -0.01em;
      background-color: var(--bs-body-bg);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      color: var(--bs-body-color);
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    /* ===== Header ===== */
    .site-header {
      background: rgba(var(--bs-body-bg-rgb, 255, 255, 255), 0.85);
      backdrop-filter: saturate(180%) blur(16px);
      -webkit-backdrop-filter: saturate(180%) blur(16px);
      border-bottom: 1px solid var(--surface-border);
      position: sticky;
      top: 0;
      z-index: 1020;
    }
    [data-bs-theme="dark"] .site-header {
      background: rgba(13, 17, 23, 0.85);
    }

    .brand-mark {
      width: 50px;
      height: 50px;
      border-radius: 14px;
      background: linear-gradient(135deg, var(--brand-soft), var(--accent-soft));
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 1.5rem;
      box-shadow: 0 4px 12px -2px rgba(21, 70, 122, 0.35);
    }

    .brand-title { font-weight: 700; font-size: 1.25rem; letter-spacing: -0.02em; line-height: 1.1; }
    .brand-sub { font-size: 0.9rem; color: rgba(var(--bs-body-color-rgb), 0.6); font-weight: 500; }

    .logo-juazeiro-nav {
      width: 52px; height: 52px;
      object-fit: contain;
    }

    /* Brasão */
    .coat-frame {
      width: 54px; height: 54px;
      border-radius: 14px;
      background: linear-gradient(180deg, rgba(21,70,122,0.06), rgba(0,148,109,0.04));
      border: 1px solid var(--surface-border);
      display: inline-flex; align-items: center; justify-content: center;
      color: var(--brand);
    }
    [data-bs-theme="dark"] .coat-frame { color: var(--brand); background: rgba(94,169,255,0.06); }

    /* Theme toggle */
    .theme-toggle {
      width: 42px; height: 42px;
      border-radius: 11px;
      border: 1px solid var(--surface-border);
      background: transparent;
      color: var(--bs-body-color);
      display: inline-flex; align-items: center; justify-content: center;
      cursor: pointer;
      transition: all 0.2s ease;
      font-size: 1.05rem;
    }
    .theme-toggle:hover { background: rgba(var(--bs-body-color-rgb), 0.05); transform: translateY(-1px); }

    /* ===== Hero ===== */
    .hero {
      padding: 4.5rem 0 3.5rem;
      background: var(--hero-bg);
      position: relative;
      overflow: hidden;
    }
    .hero::before {
      content: '';
      position: absolute;
      top: -120px; right: -120px;
      width: 420px; height: 420px;
      background: radial-gradient(circle, rgba(0, 168, 120, 0.10), transparent 65%);
      border-radius: 50%;
      pointer-events: none;
    }
    .hero::after {
      content: '';
      position: absolute;
      bottom: -180px; left: -80px;
      width: 380px; height: 380px;
      background: radial-gradient(circle, rgba(26, 86, 148, 0.08), transparent 65%);
      border-radius: 50%;
      pointer-events: none;
    }

    .eyebrow {
      display: inline-flex; align-items: center; gap: 0.5rem;
      padding: 0.4rem 0.85rem;
      background: rgba(var(--bs-body-color-rgb), 0.05);
      border: 1px solid var(--surface-border);
      border-radius: 100px;
      font-size: 0.8rem; font-weight: 600;
      color: var(--accent);
      margin-bottom: 1.5rem;
    }
    [data-bs-theme="dark"] .eyebrow { color: var(--accent-soft); }

    .hero-title {
      font-weight: 800;
      letter-spacing: -0.035em;
      line-height: 1.05;
      font-size: clamp(2.1rem, 4vw, 3.1rem);
      margin-bottom: 1rem;
    }
    .hero-title .accent { color: var(--brand); }
    [data-bs-theme="dark"] .hero-title .accent { color: var(--brand); }

    .hero-lead {
      font-size: 1.1rem;
      color: rgba(var(--bs-body-color-rgb), 0.65);
      max-width: 560px;
      line-height: 1.6;
      margin-bottom: 2rem;
    }

    /* Botões */
    .btn-brand {
      background: var(--brand-soft);
      border: 1px solid var(--brand-soft);
      color: #fff;
      font-weight: 600;
      padding: 0.7rem 1.4rem;
      border-radius: 11px;
      display: inline-flex; align-items: center; gap: 0.5rem;
      transition: all 0.2s ease;
    }
    .btn-brand:hover {
      background: var(--brand);
      border-color: var(--brand);
      color: #fff;
      transform: translateY(-1px);
      box-shadow: 0 8px 20px -6px rgba(21, 70, 122, 0.45);
    }
    .btn-ghost {
      background: transparent;
      border: 1px solid var(--surface-border);
      color: var(--bs-body-color);
      font-weight: 600;
      padding: 0.7rem 1.4rem;
      border-radius: 11px;
      display: inline-flex; align-items: center; gap: 0.5rem;
      transition: all 0.2s ease;
    }
    .btn-ghost:hover {
      background: rgba(var(--bs-body-color-rgb), 0.05);
      color: var(--bs-body-color);
      transform: translateY(-1px);
    }

    /* Bloco institucional hero */
    .institutional-card {
      background: var(--bs-body-bg);
      border: 1px solid var(--surface-border);
      border-radius: 22px;
      padding: 1.75rem;
      box-shadow: var(--surface-shadow);
      position: relative;
      overflow: hidden;
    }
    .institutional-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0; height: 4px;
      background: linear-gradient(90deg, var(--brand-soft), var(--accent-soft));
    }
    .coat-large {
      width: 86px; height: 86px;
      border-radius: 18px;
      background: linear-gradient(180deg, rgba(21,70,122,0.08), rgba(0,148,109,0.05));
      border: 1px solid var(--surface-border);
      display: inline-flex; align-items: center; justify-content: center;
      color: var(--brand);
      font-size: 2.4rem;
    }
    [data-bs-theme="dark"] .coat-large { background: rgba(94,169,255,0.08); }

    /* ===== Services ===== */
    .services { padding: 3rem 0 5rem; }

    .section-eyebrow {
      color: var(--accent);
      font-weight: 700;
      font-size: 0.75rem;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      margin-bottom: 0.6rem;
    }
    [data-bs-theme="dark"] .section-eyebrow { color: var(--accent-soft); }

    .section-title {
      font-weight: 800;
      letter-spacing: -0.025em;
      font-size: clamp(1.6rem, 2.5vw, 2rem);
    }

    .feature-card {
      background: var(--bs-body-bg);
      border: 1px solid var(--surface-border);
      border-radius: 20px;
      padding: 2rem;
      height: 100%;
      transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
    }
    .feature-card::after {
      content: '';
      position: absolute;
      inset: 0;
      border-radius: 20px;
      padding: 1px;
      background: linear-gradient(135deg, transparent, transparent);
      -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
      -webkit-mask-composite: xor;
      mask-composite: exclude;
      opacity: 0;
      transition: opacity 0.3s ease;
      pointer-events: none;
    }
    .feature-card:hover {
      transform: translateY(-6px);
      box-shadow: var(--surface-shadow);
      border-color: transparent;
    }
    .feature-card:hover::after { opacity: 1; }

    .card-1:hover::after { background: linear-gradient(135deg, rgba(26,86,148,0.4), rgba(26,86,148,0)); }
    .card-2:hover::after { background: linear-gradient(135deg, rgba(0,168,120,0.4), rgba(0,168,120,0)); }
    .card-3:hover::after { background: linear-gradient(135deg, rgba(224,107,42,0.4), rgba(224,107,42,0)); }

    .feature-icon {
      width: 58px; height: 58px;
      border-radius: 16px;
      display: inline-flex; align-items: center; justify-content: center;
      font-size: 1.7rem;
      margin-bottom: 1.5rem;
      transition: transform 0.3s ease;
    }
    .feature-card:hover .feature-icon { transform: scale(1.06) rotate(-3deg); }

    .icon-blue   { background: rgba(26, 86, 148, 0.1);  color: #1a5694; }
    .icon-green  { background: rgba(0, 168, 120, 0.1);  color: #00a878; }
    .icon-orange { background: rgba(224, 107, 42, 0.1); color: #e06b2a; }
    [data-bs-theme="dark"] .icon-blue   { background: rgba(94,169,247,0.14); color: #5ea9ff; }
    [data-bs-theme="dark"] .icon-green  { background: rgba(45,212,168,0.14); color: #2dd4a8; }
    [data-bs-theme="dark"] .icon-orange { background: rgba(255,159,67,0.14); color: #ff9f43; }

    .feature-step {
      position: absolute;
      top: 1.6rem; right: 1.6rem;
      font-size: 0.75rem; font-weight: 700;
      color: rgba(var(--bs-body-color-rgb), 0.25);
      letter-spacing: 0.1em;
    }

    .feature-title {
      font-size: 1.25rem;
      font-weight: 700;
      letter-spacing: -0.02em;
      margin-bottom: 0.6rem;
    }
    .feature-desc {
      color: rgba(var(--bs-body-color-rgb), 0.65);
      line-height: 1.65;
      margin-bottom: 1.5rem;
      font-size: 0.95rem;
    }
    .feature-meta {
      display: flex; align-items: center; gap: 0.5rem;
      font-size: 0.8rem;
      color: rgba(var(--bs-body-color-rgb), 0.5);
      padding-top: 1rem;
      margin-bottom: 1rem;
    }
    .feature-link {
      display: inline-flex; align-items: center; gap: 0.45rem;
      color: var(--brand);
      font-weight: 600;
      text-decoration: none;
      font-size: 0.95rem;
      transition: gap 0.2s ease;
    }
    [data-bs-theme="dark"] .feature-link { color: var(--brand); }
    .feature-link:hover { gap: 0.75rem; color: var(--brand); }

    /* ===== Footer ===== */
    .site-footer {
      margin-top: auto;
      padding: 2.25rem 0;
      border-top: 1px solid var(--surface-border);
      background: rgba(var(--bs-body-color-rgb), 0.015);
    }
    .footer-link {
      color: rgba(var(--bs-body-color-rgb), 0.65);
      text-decoration: none;
      font-size: 0.9rem;
      font-weight: 500;
      transition: color 0.2s ease;
    }
    .footer-link:hover { color: var(--brand); }
    .social-btn {
      width: 36px; height: 36px;
      border-radius: 10px;
      border: 1px solid var(--surface-border);
      display: inline-flex; align-items: center; justify-content: center;
      color: rgba(var(--bs-body-color-rgb), 0.7);
      text-decoration: none;
      transition: all 0.2s ease;
    }
    .social-btn:hover {
      color: var(--brand);
      border-color: var(--brand);
      transform: translateY(-2px);
    }

    /* ===== Animações ===== */
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .reveal { opacity: 0; }
    .reveal.in { animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    .delay-1 { animation-delay: 0.08s; }
    .delay-2 { animation-delay: 0.16s; }
    .delay-3 { animation-delay: 0.24s; }

    /* ===== Responsive ===== */
    @media (max-width: 991px) {
      .hero { padding: 3rem 0 2.5rem; }
      .institutional-card { margin-top: 2.5rem; }
    }
    @media (max-width: 576px) {
      .feature-card { padding: 1.5rem; }
      .hero-lead { font-size: 1rem; }
    }

    /* Acessibilidade */
    :focus-visible {
      outline: 2px solid var(--brand);
      outline-offset: 2px;
      border-radius: 6px;
    }
    @media (prefers-reduced-motion: reduce) {
      *, *::before, *::after {
        animation-duration: 0.01ms !important;
        transition-duration: 0.01ms !important;
      }
    }
  </style>
</head>
<body>

  <!-- ============ HEADER ============ -->
  <header class="site-header">
    <div class="container">
      <div class="d-flex align-items-center justify-content-between py-3">
        <!-- Marca EGESP -->
        <a href="#" class="text-decoration-none text-reset d-flex align-items-center gap-3">
          <img src="{{ asset('images/logo.png') }}" alt="Logo Juazeiro" class="logo-juazeiro-nav">
          <span class="d-none d-sm-block">
            <span class="brand-title d-block">EGESP</span>
            <span class="brand-sub d-block">Escola de Gestão Pública</span>
          </span>
        </a>

        <!-- Lado direito -->
        <div class="d-flex align-items-center gap-2 gap-md-3">
          <div class="d-none d-md-flex align-items-center gap-2">
            <span class="coat-frame">
              <i class="uil uil-university"></i>
            </span>
            <div class="text-end">
              <div class="fw-semibold" style="font-size: 1rem;">Prefeitura Municipal</div>
              <div class="brand-sub" style="font-size: 0.95rem;">Juazeiro · Bahia</div>
            </div>
          </div>
          <button class="theme-toggle" id="themeToggle" aria-label="Alternar tema claro/escuro" title="Alternar tema">
            <i class="uil uil-moon" id="themeIcon"></i>
          </button>
        </div>
      </div>
    </div>
  </header>

  <!-- ============ HERO ============ -->
  <section class="hero">
    <div class="container position-relative">
      <div class="row align-items-center g-5">
        <div class="col-lg-7">
          <span class="eyebrow reveal in">
            <i class="uil uil-calendar-alt"></i>
            Gestão de Eventos &amp; Capacitação
          </span>
          <h1 class="hero-title reveal in delay-1">
            Plataforma oficial da<br>
            <span class="accent">Escola de Gestão Pública</span>
          </h1>
          <p class="hero-lead reveal in delay-2">
            Inscrições simplificadas, registro de frequência e emissão automática
            de certificados para os eventos de capacitação da Prefeitura Municipal
            de Juazeiro — Bahia.
          </p>
          <div class="d-flex flex-wrap gap-2 reveal in delay-3">
            <a href="{{ route('login') }}" class="btn-brand">
              Entrar
              <i class="uil uil-arrow-right"></i>
            </a>
          </div>
        </div>

        <div class="col-lg-5">
          <div class="institutional-card reveal in delay-2">
            <div class="d-flex align-items-center gap-3 mb-3">
              <span class="coat-large">
                <i class="uil uil-building"></i>
              </span>
              <div>
                <div class="fw-bold" style="font-size: 1.05rem;">Município de Juazeiro</div>
                <div class="brand-sub">Bahia · Brasil</div>
              </div>
            </div>
            <p class="mb-0" style="font-size: 0.92rem; color: rgba(var(--bs-body-color-rgb), 0.7); line-height: 1.6;">
              <i class="uil uil-quote-left me-1" style="color: var(--accent);"></i>
              Governo comprometido com a formação contínua dos servidores públicos
              e a modernização da gestão municipal.
            </p>
            <div class="d-flex align-items-center gap-4 mt-3 pt-3" style="border-top: 1px solid var(--surface-border);">
              <div>
                <div class="fw-bold" style="font-size: 1.1rem; color: var(--brand);">+50</div>
                <div class="brand-sub">Eventos/ano</div>
              </div>
              <div>
                <div class="fw-bold" style="font-size: 1.1rem; color: var(--brand);">+2.500</div>
                <div class="brand-sub">Servidores</div>
              </div>
              <div>
                <div class="fw-bold" style="font-size: 1.1rem; color: var(--brand);">+8 mil</div>
                <div class="brand-sub">Certificados</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ SERVICES ============ -->
  <section id="servicos" class="services">
    <div class="container">
      <div class="text-center mb-5 reveal">
        <div class="section-eyebrow">Serviços</div>
        <h2 class="section-title mb-2">Tudo para sua capacitação</h2>
        <p class="text-secondary mx-auto" style="max-width: 540px; font-size: 0.98rem;">
          Três soluções integradas que conectam sua jornada de aprendizado
          da inscrição ao certificado final.
        </p>
      </div>

      <div class="row g-4">
        <!-- Card 1 -->
        <div class="col-md-4 reveal">
          <article class="feature-card card-1">
            <span class="feature-step">01</span>
            <div class="feature-icon icon-blue">
              <i class="uil uil-user-plus"></i>
            </div>
            <h3 class="feature-title">Inscrições Online</h3>
            <p class="feature-desc">
              Realize sua inscrição nos eventos disponíveis de forma simples
              e rápida — preencha seus dados e confirme a participação em poucos cliques.
            </p>
            <div class="feature-meta">
              <i class="uil uil-clock"></i> Inscrição em até 2 minutos
            </div>
            <a href="#" class="feature-link">
              Fazer inscrição
              <i class="uil uil-arrow-right"></i>
            </a>
          </article>
        </div>

        <!-- Card 2 -->
        <div class="col-md-4 reveal delay-1">
          <article class="feature-card card-2">
            <span class="feature-step">02</span>
            <div class="feature-icon icon-green">
              <i class="uil uil-clipboard-check"></i>
            </div>
            <h3 class="feature-title">Registro de Frequência</h3>
            <p class="feature-desc">
              Acompanhe sua presença e avalie as reuniões e formações.
              Controle completo da sua jornada de capacitação em um só lugar.
            </p>
            <div class="feature-meta">
              <i class="uil uil-check-circle"></i> Presença em tempo real
            </div>
            <a href="#" class="feature-link">
              Registrar frequência
              <i class="uil uil-arrow-right"></i>
            </a>
          </article>
        </div>

        <!-- Card 3 -->
        <div class="col-md-4 reveal delay-2">
          <article class="feature-card card-3">
            <span class="feature-step">03</span>
            <div class="feature-icon icon-orange">
              <i class="uil uil-award"></i>
            </div>
            <h3 class="feature-title">Certificados Automáticos</h3>
            <p class="feature-desc">
              Gere seu certificado automaticamente após a conclusão do evento,
              com link único de verificação de autenticidade para consulta pública.
            </p>
            <div class="feature-meta">
              <i class="uil uil-shield-check"></i> Verificação segura
            </div>
            <a href="#" class="feature-link">
              Emitir certificado
              <i class="uil uil-arrow-right"></i>
            </a>
          </article>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ FOOTER ============ -->
  <footer class="site-footer">
    <div class="container">
      <div class="row align-items-center g-3">
        <div class="col-md-6 text-center text-md-start">
          <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-2 mb-1">
            <span class="brand-mark" style="width: 32px; height: 32px; border-radius: 9px; font-size: 1rem;">
              <i class="uil uil-graduation-cap"></i>
            </span>
            <span class="fw-bold">EGESP</span>
          </div>
          <div class="brand-sub">
            © 2026 Escola de Gestão Pública · Prefeitura Municipal de Juazeiro - BA
          </div>
        </div>
        <div class="col-md-6">
          <div class="d-flex align-items-center justify-content-center justify-content-md-end gap-4 flex-wrap">
            <a href="#" class="footer-link">Política de Privacidade</a>
            <a href="#" class="footer-link">Termos de Uso</a>
            <a href="#" class="footer-link">Suporte</a>
            <div class="d-flex gap-2">
              <a href="#" class="social-btn" aria-label="Site oficial"><i class="uil uil-globe"></i></a>
              <a href="#" class="social-btn" aria-label="E-mail"><i class="uil uil-envelope"></i></a>
              <a href="#" class="social-btn" aria-label="Telefone"><i class="uil uil-phone"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // ===== Theme toggle =====
    const html = document.documentElement;
    const toggle = document.getElementById('themeToggle');
    const icon = document.getElementById('themeIcon');

    const saved = localStorage.getItem('egesp-theme') || 'light';
    html.setAttribute('data-bs-theme', saved);
    icon.className = saved === 'light' ? 'uil uil-moon' : 'uil uil-sun';

    toggle.addEventListener('click', () => {
      const current = html.getAttribute('data-bs-theme');
      const next = current === 'light' ? 'dark' : 'light';
      html.setAttribute('data-bs-theme', next);
      localStorage.setItem('egesp-theme', next);
      icon.className = next === 'light' ? 'uil uil-moon' : 'uil uil-sun';
    });

    // ===== Reveal on scroll =====
    const reveals = document.querySelectorAll('.reveal');
    reveals.forEach(el => el.classList.add('in')); // ativa na carga

    // Alternativa: ativar conforme scroll (mais eficiente para páginas longas)
    if ('IntersectionObserver' in window) {
      const io = new IntersectionObserver((entries) => {
        entries.forEach(e => {
          if (e.isIntersecting) {
            e.target.classList.add('in');
            io.unobserve(e.target);
          }
        });
      }, { threshold: 0.12 });
      // Descomente para usar observer em vez de carga imediata:
      // reveals.forEach(el => { el.classList.remove('in'); io.observe(el); });
    }
  </script>
</body>
</html>
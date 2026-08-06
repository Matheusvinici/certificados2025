<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EGESP — Escola de Gestão Pública | Juazeiro - BA</title>
    <meta name="description" content="Escola de Gestão Pública de Juazeiro-BA - Formação e qualificação dos servidores municipais">
    <meta name="keywords" content="EGESP, Gestão Pública, Juazeiro, Bahia, Qualificação, Servidores">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        html, body {
            overflow-x: hidden;
            max-width: 100%;
        }

        body {
            font-family: 'Source Sans Pro', sans-serif;
            background-color: #f4f6f9;
            color: #1d1d1d;
        }

        /* ===== Navbar ===== */
        .site-nav {
            background: #ffffff;
            border-bottom: 3px solid #e9ecef;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .site-nav .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 1.1rem;
            color: #1d1d1d;
        }

        .site-nav .navbar-brand .brand-sub {
            display: block;
            font-weight: 400;
            font-size: 0.72rem;
            color: #777;
            line-height: 1.1;
        }

        .site-nav .nav-link {
            color: #333;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 1rem 1rem !important;
            transition: color 0.2s ease;
        }

        .site-nav .nav-link:hover {
            color: #0B4D91;
        }

        .site-nav .nav-link.btn-nav {
            background: linear-gradient(135deg, #0B4D91, #0F6EDB);
            color: #fff !important;
            border-radius: 40px;
            padding: 9px 22px !important;
            margin: 8px 0 8px 8px;
            font-weight: 600;
            transition: 0.25s ease;
            box-shadow: 0 3px 8px rgba(11, 77, 145, 0.3);
        }

        .site-nav .nav-link.btn-nav:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(11, 77, 145, 0.4);
        }

        @media (max-width: 991px) {
            .site-nav .nav-link {
                padding: 0.7rem 1rem !important;
            }
            .site-nav .nav-link.btn-nav {
                margin: 8px 0 12px 0;
                display: inline-block;
            }
        }

        /* ===== Capa (imagem de fundo) ===== */
        .cover {
            position: relative;
            width: 100%;
            line-height: 0;
        }

        .cover .cover-img {
            width: 100%;
            height: auto;
            display: block;
        }

        .cover-buttons {
            position: absolute;
            bottom: 8%;
            left: 0;
            right: 0;
            text-align: center;
            z-index: 2;
            line-height: 1.5;
            padding: 0 1rem;
        }

        @media (max-width: 480px) {
            .cover-buttons {
                bottom: 4%;
            }
            .cover-buttons .btn-prematricula,
            .cover-buttons .btn-ghost-capa {
                display: block;
                width: 90%;
                max-width: 90%;
                margin: 0 auto 10px auto;
                text-align: center;
            }
        }

        /* ===== Botão estilo pré-matrícula ===== */
        .btn-prematricula {
            background: linear-gradient(135deg, #FFD76A, #e3a323);
            color: #1d1d1d;
            padding: 12px 20px 10px 20px;
            border-radius: 1.5em;
            font-weight: 600;
            font-size: 14px;
            transition: 0.25s ease;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25);
            border: none;
            display: inline-block;
            text-transform: uppercase;
        }

        .btn-prematricula:hover {
            filter: brightness(1.12);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.35);
            color: #1d1d1d;
            text-decoration: none;
        }

        .btn-ghost-capa {
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid rgba(13, 20, 34, 0.15);
            color: #1d1d1d;
            padding: 12px 20px 10px 20px;
            border-radius: 1.5em;
            font-weight: 600;
            font-size: 14px;
            transition: 0.25s ease;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.2);
            display: inline-block;
            text-transform: uppercase;
        }

        .btn-ghost-capa:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-3px);
            color: #1d1d1d;
            text-decoration: none;
        }

        /* ===== Cards estilo portal ===== */
        .row-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            align-items: stretch;
        }

        .card_iniciativas {
            border: none;
            border-radius: 1em !important;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #f7f7f7, #ececec);
            transition: all 0.3s ease-in-out;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .card_iniciativas .card-wrap {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .card_iniciativas * {
            text-decoration: none !important;
        }

        .card_iniciativas:hover {
            background: linear-gradient(135deg, #ffffff, #f0f0f0);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
            transform: scale(1.02);
        }

        .icone-cinza {
            filter: grayscale(1);
            opacity: 0.75;
        }

        /* ===== Botões áreas ===== */
        .btn_area_servidor {
            background: linear-gradient(135deg, #0B4D91, #0F6EDB);
            color: #fff !important;
            padding: 10px 24px;
            border-radius: 40px;
            font-weight: 500;
            border: none;
            transition: 0.25s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
        }

        .btn_area_servidor:hover {
            background: linear-gradient(135deg, #0F6EDB, #0B4D91);
            transform: translateY(-3px);
            box-shadow: 0 7px 16px rgba(0, 0, 0, 0.35);
        }

        .btn_area_professor {
            background: linear-gradient(135deg, #6A0DAD, #C084FC);
            color: #fff !important;
            padding: 10px 24px;
            border-radius: 40px;
            font-weight: 500;
            border: none;
            transition: 0.25s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
        }

        .btn_area_professor:hover {
            background: linear-gradient(135deg, #C084FC, #6A0DAD);
            transform: translateY(-3px);
            box-shadow: 0 7px 16px rgba(0, 0, 0, 0.35);
        }

        /* ===== Contato ===== */
        .contact-card {
            background: linear-gradient(135deg, #f7f7f7, #ececec);
            border: none;
            border-radius: 1em !important;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            height: 100%;
            transition: all 0.3s ease-in-out;
        }

        .contact-card:hover {
            background: linear-gradient(135deg, #ffffff, #f0f0f0);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
            transform: scale(1.02);
        }

        .contact-icon {
            width: 52px;
            height: 52px;
            border-radius: 1em;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #0B4D91;
            background: rgba(11, 77, 145, 0.1);
        }

        .map-wrap {
            border-radius: 1em;
            overflow: hidden;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .map-wrap iframe {
            display: block;
            width: 100%;
            height: 100%;
            min-height: 460px;
            border: 0;
        }

        /* ===== Rodapé ===== */
        .footer {
            background-color: #1d2430;
            color: #aab2bf;
            font-size: 13px;
        }

        .footer strong {
            color: #f8f9fa;
            font-weight: 600;
            margin-bottom: 12px !important;
            display: block;
        }

        .footer a {
            color: #aab2bf;
        }

        .footer a:hover {
            color: #fff;
            text-decoration: none;
        }

        .footer .footer-logo {
            max-width: 160px;
        }
    </style>
</head>

<body>

<!-- ============ NAVBAR ============ -->
<nav class="navbar navbar-expand-lg site-nav">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('images/logo.png') }}" width="42" height="42" alt="Prefeitura de Juazeiro">
            <span>
                EGESP
                <span class="brand-sub">Escola de Gestão Pública · Juazeiro - BA</span>
            </span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navPrincipal"
                aria-controls="navPrincipal" aria-expanded="false" aria-label="Alternar navegação">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navPrincipal">
            <ul class="navbar-nav ml-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link" href="#sobre">Quem Somos</a></li>
                <li class="nav-item"><a class="nav-link" href="#cursos">Cursos</a></li>
                <li class="nav-item"><a class="nav-link" href="#servicos">Serviços</a></li>
                <li class="nav-item"><a class="nav-link" href="#validar"><i class="fas fa-shield-alt"></i>&nbsp; Validar Certificado</a></li>
                <li class="nav-item"><a class="nav-link" href="#contato">Contato</a></li>
                <li class="nav-item">
                    <a class="nav-link btn-nav" href="{{ route('login') }}">
                        <i class="fas fa-user-lock"></i>&nbsp; Acesso ao Sistema
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- ============ CAPA (imagem de fundo) ============ -->
<div class="cover">
    <img src="{{ asset('images/capaSistema.png') }}" alt="Escola de Gestão Pública - Juazeiro" class="cover-img">
    <div class="cover-buttons">
        <a href="#sobre" class="btn-prematricula mr-2 mb-2">
            <i class="fas fa-graduation-cap"></i>&nbsp; Conheça a EGESP
        </a>
        <a href="{{ route('login') }}" class="btn-ghost-capa mb-2">
            <i class="fas fa-user-lock"></i>&nbsp; Acesso ao Sistema
        </a>
    </div>
</div>

<!-- ============ O QUE É A EGESP ============ -->
<div id="sobre" class="text-center py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-muted text-uppercase" style="margin-bottom: 0px !important; font-size: 14px!important;"><b>Quem Somos</b></h3>
                <h2 style="font-weight: 700; margin-top: 8px;">O que é a EGESP?</h2>
                <p class="mx-auto" style="max-width: 720px; font-size: 1.05rem; color: #555; line-height: 1.7; margin-top: 1rem;">
                    A EGESP Juazeiro é a Escola de Gestão Pública de Juazeiro, na Bahia. Trata-se de uma
                    instituição vinculada à <strong>Secretaria de Administração (SEAD)</strong> da Prefeitura
                    Municipal de Juazeiro, voltada para a formação, qualificação profissional e valorização
                    dos servidores públicos municipais.
                    <br><br>
                    Tem como principal objetivo promover a <strong>formação continuada dos servidores</strong>,
                    contribuindo para uma atuação mais eficiente, ética e humanizada. Funciona como um espaço
                    permanente de aprendizado, ofertando cursos, oficinas e treinamentos alinhados às demandas
                    da administração pública, com foco na modernização dos processos e na excelência no
                    atendimento ao cidadão.
                </p>
            </div>
        </div>

        <div class="body table-responsive">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-md-4" style="margin-top: 25px!important;">
                        <div class="card card-sm card_iniciativas">
                            <div class="card-icon text-primary text-center" style="padding-top: 20px!important;">
                                <i class="fas fa-chalkboard-teacher" style="font-size: 40px; color: #0B4D91;"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-body">
                                    <h5><strong>Cursos de Qualificação</strong></h5>
                                    <p>Oferta constante de treinamentos em áreas como Excel Básico, Organização de Documentos, Atendimento Humanizado, Gestão de Conflitos e Combate ao Assédio Moral.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4" style="margin-top: 25px!important;">
                        <div class="card card-sm card_iniciativas">
                            <div class="card-icon text-primary text-center" style="padding-top: 20px!important;">
                                <i class="fas fa-chart-line" style="font-size: 40px; color: #00946d;"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-body">
                                    <h5><strong>Plano de Carreira</strong></h5>
                                    <p>As certificações emitidas servem como pontuação para o avanço no Plano de Cargos, Carreiras e Remuneração (PCCR) do servidor.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4" style="margin-top: 25px!important;">
                        <div class="card card-sm card_iniciativas">
                            <div class="card-icon text-primary text-center" style="padding-top: 20px!important;">
                                <i class="fas fa-heartbeat" style="font-size: 40px; color: #e06b2a;"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-body">
                                    <h5><strong>Ações de Bem-Estar</strong></h5>
                                    <p>Promoção de palestras e oficinas voltadas à saúde mental e gerenciamento de estresse no trabalho.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============ CURSOS OFERTADOS ============ -->
<div id="cursos" class="text-center py-5" style="background-color: #f6f6f6;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-muted text-uppercase" style="margin-bottom: 0px !important; font-size: 14px!important;"><b>Formação Continuada</b></h3>
                <h2 style="font-weight: 700; margin-top: 8px;">O que a EGESP oferece</h2>
                <p class="mx-auto" style="max-width: 680px; color: #777; margin-top: 1rem;">
                    Cursos, oficinas e treinamentos em modalidades presencial, híbrida e remota,
                    com certificação válida para progressão no Plano de Cargos, Carreiras e
                    Remuneração (PCCR) dos servidores.
                </p>
            </div>
        </div>

        <div class="body table-responsive">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-md-3" style="margin-top: 25px!important;">
                        <div class="card card-sm card_iniciativas">
                            <div class="card-icon text-primary text-center" style="padding-top: 20px!important;">
                                <i class="fas fa-folder-open" style="font-size: 40px; color: #0B4D91;"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-body">
                                    <h5><strong>Cursos de Gestão e Organização</strong></h5>
                                    <p>Formações voltadas para a organização documental, eficiência e modernização dos processos da administração pública.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3" style="margin-top: 25px!important;">
                        <div class="card card-sm card_iniciativas">
                            <div class="card-icon text-primary text-center" style="padding-top: 20px!important;">
                                <i class="fas fa-handshake" style="font-size: 40px; color: #00946d;"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-body">
                                    <h5><strong>Cursos de Atendimento ao Cidadão</strong></h5>
                                    <p>Treinamentos sobre atendimento humanizado, relações interpessoais e gestão de conflitos no serviço público.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3" style="margin-top: 25px!important;">
                        <div class="card card-sm card_iniciativas">
                            <div class="card-icon text-primary text-center" style="padding-top: 20px!important;">
                                <i class="fas fa-laptop" style="font-size: 40px; color: #e06b2a;"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-body">
                                    <h5><strong>Cursos de Informática</strong></h5>
                                    <p>Aulas práticas de ferramentas digitais e tecnologia aplicadas ao dia a dia do trabalho, em modalidade presencial e remota.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3" style="margin-top: 25px!important;">
                        <div class="card card-sm card_iniciativas">
                            <div class="card-icon text-primary text-center" style="padding-top: 20px!important;">
                                <i class="fas fa-heartbeat" style="font-size: 40px; color: #6A0DAD;"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-body">
                                    <h5><strong>Palestras e Oficinas</strong></h5>
                                    <p>Encontros sobre saúde mental, bem-estar, motivação e qualidade de vida no ambiente de trabalho.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============ CURSOS ABERTOS ============ -->
@if($cursosAbertos->count())
<div id="cursos-abertos" class="text-center py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-muted text-uppercase" style="margin-bottom: 0px !important; font-size: 14px!important;"><b>Abertos para Inscrição</b></h3>
                <h2 style="font-weight: 700; margin-top: 8px;">Cursos Disponíveis</h2>
                <p style="color: #777;">Inscreva-se agora nos cursos com vagas abertas.</p>
            </div>
        </div>

        <div class="body table-responsive">
            <div class="col-12">
                <div class="row">
                    @foreach($cursosAbertos as $curso)
                        <div class="col-12 col-md-4" style="margin-top: 25px!important;">
                            <div class="card card-sm card_iniciativas">
                                <div class="card-icon text-primary text-center" style="padding-top: 20px!important;">
                                    <i class="fas fa-book-open" style="font-size: 40px; color: #00946d;"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-body">
                                        <h5><strong>{{ $curso->nome }}</strong></h5>
                                        @if($curso->carga_horaria)
                                            <span class="badge badge-success mb-2">{{ $curso->carga_horaria }}h</span>
                                        @endif
                                        @if($curso->data_inicio || $curso->data_fim)
                                            <p class="mb-1" style="font-size: 0.9rem; color: #555;">
                                                <i class="fas fa-calendar-alt text-info"></i>&nbsp;
                                                @if($curso->data_inicio && $curso->data_fim)
                                                    {{ \Carbon\Carbon::parse($curso->data_inicio)->format('d/m/Y') }} — {{ \Carbon\Carbon::parse($curso->data_fim)->format('d/m/Y') }}
                                                @elseif($curso->data_inicio)
                                                    A partir de {{ \Carbon\Carbon::parse($curso->data_inicio)->format('d/m/Y') }}
                                                @else
                                                    Até {{ \Carbon\Carbon::parse($curso->data_fim)->format('d/m/Y') }}
                                                @endif
                                            </p>
                                        @endif
                                        @if($curso->data_inicio_inscricao || $curso->data_fim_inscricao)
                                            <p class="mb-1" style="font-size: 0.9rem; color: #555;">
                                                <i class="fas fa-edit text-info"></i>&nbsp;
                                                Inscrições:
                                                {{ $curso->data_inicio_inscricao ? \Carbon\Carbon::parse($curso->data_inicio_inscricao)->format('d/m/Y') : '—' }}
                                                a
                                                {{ $curso->data_fim_inscricao ? \Carbon\Carbon::parse($curso->data_fim_inscricao)->format('d/m/Y') : '—' }}
                                            </p>
                                        @endif
                                        <a href="{{ route('login') }}" class="btn-prematricula mt-2" style="font-size: 13px; padding: 8px 16px;">
                                            <i class="fas fa-user-plus"></i>&nbsp; Inscreva-se agora
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- ============ SERVIÇOS ============ -->
<div class="text-center py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-muted text-uppercase" style="margin-bottom: 0px !important; font-size: 14px!important;"><b>Serviços</b></h3>
                <h2 style="font-weight: 700; margin-top: 8px;">Tudo para sua qualificação</h2>
                <p style="color: #777;">Da inscrição ao certificado final, em um só lugar.</p>
            </div>
        </div>

        <div class="body table-responsive">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-md-4" style="margin-top: 25px!important;">
                        <div class="card card-sm card_iniciativas">
                            <div class="card-icon text-primary text-center" style="padding-top: 20px!important;">
                                <span class="badge badge-primary badge-pill" style="font-size: 14px;">01</span>
                                <br><i class="fas fa-user-plus mt-2" style="font-size: 40px; color: #0B4D91;"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-body">
                                    <h5><strong>Inscrições Online</strong></h5>
                                    <p>Realize sua inscrição nos cursos disponíveis de forma simples e rápida — em poucos cliques.</p>
                                    <a href="{{ route('login') }}" class="btn_area_servidor d-inline-block" style="font-size: 13px;">
                                        Fazer inscrição
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4" style="margin-top: 25px!important;">
                        <div class="card card-sm card_iniciativas">
                            <div class="card-icon text-primary text-center" style="padding-top: 20px!important;">
                                <span class="badge badge-success badge-pill" style="font-size: 14px;">02</span>
                                <br><i class="fas fa-clipboard-check mt-2" style="font-size: 40px; color: #00946d;"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-body">
                                    <h5><strong>Registro de Frequência</strong></h5>
                                    <p>Acompanhe sua presença e avalie as reuniões e formações. Controle completo da sua jornada.</p>
                                    <a href="{{ route('login') }}" class="btn_area_professor d-inline-block" style="font-size: 13px;">
                                        Registrar frequência
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4" style="margin-top: 25px!important;">
                        <div class="card card-sm card_iniciativas">
                            <div class="card-icon text-primary text-center" style="padding-top: 20px!important;">
                                <span class="badge badge-warning badge-pill" style="font-size: 14px;">03</span>
                                <br><i class="fas fa-award mt-2" style="font-size: 40px; color: #e06b2a;"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-body">
                                    <h5><strong>Certificados Automáticos</strong></h5>
                                    <p>Gere seu certificado automaticamente após a conclusão, com link único de verificação de autenticidade.</p>
                                    <a href="{{ route('login') }}" class="btn-prematricula d-inline-block" style="font-size: 13px; padding: 8px 16px;">
                                        Emitir certificado
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============ VALIDAÇÃO DE CERTIFICADO ============ -->
<div id="validar" class="text-center py-5" style="background-color: #f6f6f6;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-muted text-uppercase" style="margin-bottom: 0px !important; font-size: 14px!important;"><b>Verificação</b></h3>
                <h2 style="font-weight: 700; margin-top: 8px;">Validar Certificado</h2>
                <p style="color: #777;">Insira o código de validação impresso no certificado para confirmar sua autenticidade.</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6" style="margin-top: 25px!important;">
                <div class="card card-sm card_iniciativas p-4">
                    <div class="card-body">
                        <i class="fas fa-shield-alt mb-3" style="font-size: 48px; color: #0B4D91;"></i>
                        <form id="formValidar">
                            <div class="form-group">
                                <input type="text" id="hashInput" class="form-control form-control-lg text-center"
                                    placeholder="Cole o código de validação aqui"
                                    style="border-radius: 3em; font-family: monospace; letter-spacing: 0.05em;">
                            </div>
                            <button type="submit" class="btn-prematricula w-100">
                                <i class="fas fa-search"></i>&nbsp; Validar
                            </button>
                        </form>
                        <div id="resultadoValidacao" class="mt-4" style="display: none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============ CONTATO E LOCALIZAÇÃO ============ -->
<div class="text-center py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-muted text-uppercase" style="margin-bottom: 0px !important; font-size: 14px!important;"><b>Atendimento</b></h3>
                <h2 style="font-weight: 700; margin-top: 8px;">Contato e Localização</h2>
                <p style="color: #777;">Visite a EGESP ou entre em contato com nossa equipe de atendimento.</p>
            </div>
        </div>

        <div class="row" style="margin-top: 25px!important;">
            <div class="col-12 col-lg-4">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12" style="margin-bottom: 20px!important;">
                        <div class="contact-card text-left">
                            <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <h5><strong>Endereço</strong></h5>
                            <p style="color: #555; margin-bottom: 0;">Praça Barão do Rio Branco, nº 01 - Centro, Juazeiro - BA</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-12" style="margin-bottom: 20px!important;">
                        <div class="contact-card text-left">
                            <div class="contact-icon"><i class="fas fa-clock"></i></div>
                            <h5><strong>Horário de Atendimento</strong></h5>
                            <p style="color: #555; margin-bottom: 0;">Segunda a sexta-feira, das 08h às 14h</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-12" style="margin-bottom: 20px!important;">
                        <div class="contact-card text-left">
                            <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                            <h5><strong>Telefone</strong></h5>
                            <p style="color: #555; margin-bottom: 0;">(74) 98846-0016</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-12" style="margin-bottom: 20px!important;">
                        <div class="contact-card text-left">
                            <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                            <h5><strong>E-mail</strong></h5>
                            <p style="color: #555; margin-bottom: 0;">ouvidoria@juazeiro.ba.gov.br</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-8">
                <div class="map-wrap h-100">
                    <iframe
                        src="https://www.google.com/maps?q=Pra%C3%A7a+Bar%C3%A3o+do+Rio+Branco,+1,+Centro,+Juazeiro+-+BA&output=embed"
                        loading="lazy"
                        allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Localização da EGESP - Praça Barão do Rio Branco, nº 01 - Centro, Juazeiro - BA">
                    </iframe>
                </div>
                <a href="https://www.google.com/maps/search/?api=1&query=Pra%C3%A7a+Bar%C3%A3o+do+Rio+Branco,+1,+Centro,+Juazeiro+-+BA"
                   target="_blank" rel="noopener" class="btn-prematricula mt-3">
                    <i class="fas fa-directions"></i>&nbsp; Traçar rota até a EGESP
                </a>
            </div>
        </div>
    </div>
</div>

<!-- ============ RODAPÉ ============ -->
<footer class="footer pt-4 mt-4 pb-2">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div>
                    <img src="{{ asset('images/logo.png') }}" class="mb-3 footer-logo" alt="Logo Juazeiro">
                    <h6 class="font-weight-bold" style="font-size: 11px !important; color: #f8f9fa;">
                        Prefeitura Municipal de Juazeiro<br>
                        Secretaria de Administração — SEAD<br>
                        Escola de Gestão Pública — EGESP<br>
                        Praça Barão do Rio Branco, 01, Centro, Juazeiro-BA<br>
                        CEP: 48.903-660
                    </h6>
                </div>
            </div>
            <div class="col-md-4" style="font-size: 12px !important; color: #aab2bf !important;">
                <div>
                    <strong>Links Rápidos</strong>
                    <a href="#sobre" class="d-block mb-1">O que é a EGESP</a>
                    <a href="{{ route('login') }}" class="d-block mb-1">Área Restrita</a>
                    <a href="#contato" class="d-block mb-1">Contato e Localização</a>
                    <a href="{{ route('login') }}" class="d-block mb-1">Inscrições e Certificados</a>
                </div>
            </div>
            <div class="col-md-4" style="font-size: 12px !important; color: #aab2bf !important;">
                <div>
                    <strong>Horário de Atendimento</strong>
                    <span class="d-block mb-1">Segunda a sexta-feira</span>
                    <span class="d-block mb-1">das 08h às 14h</span>
                    <span class="d-block mb-3"><i class="fas fa-phone-alt"></i> (74) 98846-0016</span>
                    <strong>Inscrições e Certificados</strong>
                    <span class="d-block mb-1">Realizadas pelo portal de serviços</span>
                    <span class="d-block">no site oficial da Prefeitura de Juazeiro.</span>
                </div>
            </div>
        </div>

        <div class="col-12" style="font-size: 11px !important; margin-top: 20px;">
            <div class="align-items-center align-middle text-center" style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 15px;">
                © 2026 Escola de Gestão Pública · Prefeitura Municipal de Juazeiro - BA
            </div>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // ===== Validação de certificado =====
    document.getElementById('formValidar').addEventListener('submit', function (e) {
        e.preventDefault();
        const hash = document.getElementById('hashInput').value.trim();
        const resultado = document.getElementById('resultadoValidacao');

        if (!hash) {
            resultado.style.display = 'block';
            resultado.innerHTML = '<div class="alert alert-warning" style="border-radius: 1.5em;">Insira um código de validação.</div>';
            return;
        }

        resultado.style.display = 'block';
        resultado.innerHTML = '<div class="text-secondary"><i class="fas fa-spinner fa-spin"></i> Verificando...</div>';

        fetch('/validar-certificado', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ hash: hash })
        })
        .then(r => r.json())
        .then(data => {
            if (data.valido) {
                resultado.innerHTML = `
                    <div class="alert alert-success text-left" style="border-radius: 1.5em;">
                        <strong><i class="fas fa-check-circle"></i> Certificado válido!</strong><br>
                        <span>Participante: <strong>${data.dados.participante}</strong></span><br>
                        <span>Curso: <strong>${data.dados.curso}</strong></span><br>
                        <span>Carga horária: <strong>${data.dados.carga_horaria}h</strong></span><br>
                        <span>Emitido em: <strong>${data.dados.emitido_em}</strong></span>
                    </div>`;
            } else {
                resultado.innerHTML = `
                    <div class="alert alert-danger" style="border-radius: 1.5em;">
                        <i class="fas fa-times-circle"></i> Certificado não encontrado. Verifique o código e tente novamente.
                    </div>`;
            }
        })
        .catch(() => {
            resultado.innerHTML = `
                <div class="alert alert-danger" style="border-radius: 1.5em;">
                    Erro ao validar. Tente novamente.
                </div>`;
        });
    });

    // ===== Smooth scroll =====
    $(document).ready(function () {
        $('a[href^="#"]').on('click', function (e) {
            e.preventDefault();
            var target = $(this.hash);
            if (target.length) {
                $('html, body').animate({ scrollTop: target.offset().top - 70 }, 800);
            }
        });
    });
</script>

</body>
</html>

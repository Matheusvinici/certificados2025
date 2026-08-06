<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado</title>
    <style>
        @page { margin: 0; }

        /* Estilo geral */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('{{ public_path('images/certificados.png') }}');
            background-size: 100% 100%;
            background-repeat: no-repeat;
        }

        .logos-topo {
            width: 55%;
            margin: 25px auto 0;
            border-collapse: collapse;
        }

        .logos-topo td {
            text-align: center;
            vertical-align: middle;
            padding: 0 15px;
        }

        .logo-egesp {
            width: 160px;
        }

        .logo-sec {
            width: 65px;
        }

        /* Conteúdo do certificado */
        .certificate {
            width: 80%;
            max-width: 900px;
            height: 100vh;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        /* Título */
        .title {
            font-size: 48px;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 80px;
        }

        /* Texto principal */
        .content {
            font-size: 20px;
            line-height: 1.6;
            margin-bottom: 30px;
            margin-top: 170px;
        }

        /* Divisor */
        .divider {
            height: 2px;
            background-color: #333;
            width: 60%;
            margin: 20px 0;
        }

        /* Rodapé */
        .footer {
            font-size: 16px;
            margin-top: 15px;
            text-align: center;
            width: 100%;
        }

        .signature {
            font-size: 16px;
            font-style: italic;
            margin-top: 30px;
        }

        .assinatura-area {
            margin-top: 10px;
            width: 100%;
            text-align: center;
        }

        .assinatura-area table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .assinatura-area td {
            text-align: center;
            vertical-align: top;
            padding: 0 20px;
        }

        .assinatura-item {
            text-align: center;
        }

        .assinatura-foto img {
            max-height: 70px;
            max-width: 200px;
        }

        .assinatura-nome {
            font-size: 16px;
            font-weight: bold;
        }

        .assinatura-cargo {
            font-size: 13px;
            color: #555;
        }

        .hash-validacao {
            margin-top: 50px;
            font-size: 16px;
            font-weight: bold;
            color: #333;
            word-break: break-all;
            letter-spacing: 0.1em;
        }

        .qr-validacao {
            position: fixed;
            bottom: 55px;
            left: 40px;
            z-index: 2;
            text-align: center;
        }

        .qr-validacao img {
            width: 90px;
            height: 90px;
        }

        .qr-validacao span {
            display: block;
            font-size: 11px;
            color: #333;
            margin-top: 4px;
        }

        /* Página 2 — Temas dos encontros */
        .temas-page {
            width: 84%;
            margin: 0 auto;
            padding: 50px 0;
            font-family: Arial, sans-serif;
            page-break-before: always;
        }

        .temas-page h1 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 6px;
        }

        .temas-page .curso-nome {
            text-align: center;
            font-size: 14px;
            color: #555;
            margin-bottom: 30px;
        }

        .temas-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .temas-table th {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            padding: 10px 12px;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .temas-table td {
            border: 1px solid #cbd5e1;
            padding: 10px 12px;
        }

        .temas-table .total td {
            font-weight: bold;
            background: #f8fafc;
        }

        .assinatura-foto {
            display: inline-block;
            background: #fff;
            border: 1px dashed #cbd5e1;
            border-radius: 6px;
            padding: 6px 10px;
            margin-bottom: 4px;
        }

        .assinatura-foto img {
            max-height: 70px;
            max-width: 200px;
        }
    </style>
</head>
<body>
    <!-- Conteúdo do certificado -->
    <div class="certificate">
        <table class="logos-topo">
            <tr>
                <td><img class="logo-egesp" src="{{ public_path('images/egesp.png') }}" alt="EGESP"></td>
                <td><img class="logo-sec" src="{{ public_path('images/logo.png') }}" alt="Logo"></td>
            </tr>
        </table>
        <div class="title">Certificado</div>
        <div class="content">
        Certifico que o(a) participante <strong>{{ $certificado->user->name }}</strong> 
        concluiu com êxito o curso <strong>{{ $certificado->curso->nome }}</strong>, 
        com uma carga horária de <strong>{{ $certificado->curso->carga_horaria }} horas</strong>, 
        realizado no âmbito da Escola de Gestão Pública (EGESP) — Prefeitura Municipal de Juazeiro-BA.


        </div>

        <div class="assinatura-area">
            @if($assinaturas->isNotEmpty())
                <table>
                    <tr>
                        @foreach($assinaturas as $assinatura)
                            <td>
                                @if($assinatura->foto)
                                    <div class="assinatura-foto">
                                        <img src="{{ storage_path('app/public/' . $assinatura->foto) }}" alt="Assinatura">
                                    </div>
                                @endif
                                <div class="assinatura-nome">{{ $assinatura->nome }}</div>
                                @php
                                    $rotuloAssinatura = $assinatura->facilitador ? 'Facilitador(a)' : $assinatura->secretaria;
                                @endphp
                                @if($rotuloAssinatura)
                                    <div class="assinatura-cargo">{{ $rotuloAssinatura }}</div>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                </table>
            @else
                <div class="assinatura-nome">Responsável pela Assinatura</div>
            @endif
        </div>

        @if($certificado->hash_unico)
            <div class="hash-validacao">
                Código de validação: {{ $certificado->hash_unico }}
            </div>
        @endif

        <br>
        <div class="footer">
            Juazeiro, {{ now()->format('d/m/Y') }}
        </div>
    </div>

    <div class="qr-validacao">
        <img src="{{ $qrFile }}" alt="QR Code">
        <span>Valide este certificado</span>
    </div>

    <!-- Página 2 — Temas dos encontros -->
    <div class="temas-page">
        <h1>Conteúdo Programático</h1>
        <div class="curso-nome">
            Curso: <strong>{{ $certificado->curso->nome }}</strong>
            &nbsp;·&nbsp; Carga horária total: <strong>{{ $certificado->curso->carga_horaria }} horas</strong>
        </div>
        <table class="temas-table">
            <thead>
                <tr>
                    <th style="width: 18%;">Data</th>
                    <th>Tema / Conteúdo</th>
                    <th style="width: 20%;">Carga Horária</th>
                </tr>
            </thead>
            <tbody>
                @foreach($certificado->curso->encontros as $encontro)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($encontro->data)->format('d/m/Y') }}</td>
                        <td>{{ $encontro->conteudo }}</td>
                        <td>{{ $encontro->carga_horaria_encontro }} horas</td>
                    </tr>
                @endforeach
                <tr class="total">
                    <td colspan="2">Total</td>
                    <td>{{ $certificado->curso->carga_horaria }} horas</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>

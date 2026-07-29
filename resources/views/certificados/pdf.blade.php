<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado</title>
    <style>
        /* Estilo geral */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* Fundo da imagem */
        .background-image img {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        /* Conteúdo do certificado */
        .certificate {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
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
            margin-bottom: 30px;
        }

        /* Texto principal */
        .content {
            font-size: 20px;
            line-height: 1.6;
            margin-bottom: 30px;
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
            margin-top: 20px;
            text-align: right;
            width: 100%;
        }

        .signature {
            font-size: 16px;
            font-style: italic;
            margin-top: 30px;
        }

        .assinatura-area {
            margin-top: 50px;
            text-align: center;
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
            margin-top: 15px;
            font-size: 16px;
            font-weight: bold;
            color: #333;
            word-break: break-all;
            letter-spacing: 0.1em;
        }
    </style>
</head>
<body>
    <!-- Fundo da imagem -->
    <div class="background-image">
        <img src="{{ public_path('images/certificados.png') }}" alt="Certificado">
    </div>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <!-- Conteúdo do certificado -->
    <div class="certificate">
        <div class="content">
        Certifico que o(a) participante <strong>{{ $certificado->user->name }}</strong> 
        concluiu com êxito o curso <strong>{{ $certificado->curso->nome }}</strong>, 
        com uma carga horária de <strong>{{ $certificado->curso->carga_horaria }} horas</strong>, 
        realizado no âmbito da Escola de Gestão Pública (EGESP) — Prefeitura Municipal de Juazeiro-BA.


        </div>
        <div class="divider"></div>

        <div class="assinatura-area">
            @if($certificado->curso->responsavelAssinatura)
                <div class="assinatura-nome">{{ $certificado->curso->responsavelAssinatura->name }}</div>
                <div class="assinatura-cargo">Responsável pela Assinatura</div>
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
</body>
</html>

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
        }

        .signature {
            font-size: 16px;
            font-style: italic;
            margin-top: 30px;
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
        realizado no âmbito da Secretaria de Educação e Juventude de Juazeiro-BA.


        </div>
        <div class="divider"></div>
        <br><br>
        <div class="footer">
            Juazeiro, {{ now()->format('d/m/Y') }}
        </div>
        <div class="signature">Assinado digitalmente por</div>
    </div>
</body>
</html>

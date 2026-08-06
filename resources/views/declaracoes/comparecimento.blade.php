<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Declaração de Comparecimento</title>
    <style>
        body {
            margin: 0;
            padding: 40px;
            font-family: Arial, sans-serif;
            color: #333;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #4f46e5;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header img {
            max-height: 100px;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 22px;
            margin: 0;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 13px;
            color: #555;
        }

        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 30px;
        }

        .body p {
            font-size: 15px;
            line-height: 2;
            text-align: justify;
        }

        .assinatura-area {
            margin-top: 60px;
            text-align: center;
        }

        .assinatura-linha {
            border-top: 1px solid #333;
            width: 45%;
            margin: 25px auto 10px;
        }

        .assinatura-nome {
            font-size: 15px;
            font-weight: bold;
        }

        .assinatura-cargo {
            font-size: 13px;
            color: #555;
        }

        .footer {
            margin-top: 50px;
            font-size: 13px;
            color: #555;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/egesp.png') }}" alt="EGESP">
        <h1>Prefeitura Municipal de Juazeiro-BA</h1>
        <p>Escola de Gestão Pública — EGESP</p>
    </div>

    <div class="title">DECLARAÇÃO DE COMPARECIMENTO</div>

    <div class="body">
        <p>
            Declaramos, para os devidos fins, que o(a) servidor(a)
            <strong>{{ $frequencia->user->name }}</strong>,
            participou do curso
            <strong>{{ $frequencia->encontro->curso->nome }}</strong>,
            no dia
            <strong>{{ \Carbon\Carbon::parse($frequencia->encontro->data)->format('d/m/Y') }}</strong>,
            com entrada às
            <strong>{{ $frequencia->hora_inicio }}h</strong> e saída às
            <strong>{{ $frequencia->hora_saida }}h</strong>.
        </p>
    </div>

    <div class="assinatura-area">
        @forelse($frequencia->encontro->curso->responsaveisAssinatura as $responsavel)
            @php
                $assinaturaResponsavel = \App\Models\Assinatura::where('user_id', $responsavel->id)->latest()->first();
            @endphp
            <div class="assinatura-linha"></div>
            <div class="assinatura-nome">{{ $responsavel->name }}</div>
            @if($assinaturaResponsavel && $assinaturaResponsavel->facilitador)
                <div class="assinatura-cargo">Facilitador(a)</div>
            @endif
        @empty
            <div class="assinatura-nome">Responsável pelo Curso</div>
        @endforelse
    </div>

    <div class="footer">
        Juazeiro, {{ now()->format('d/m/Y') }}
    </div>
</body>
</html>
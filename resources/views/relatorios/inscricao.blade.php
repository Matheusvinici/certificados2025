<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Inscrições</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }
        tbody tr:nth-child(even) {
            background-color: #fff;
        }
    </style>
</head>
<body>

<header>
    <div class="image-container">
    <img src="{{ public_path('images/logoprefeitura.png') }}" alt="Certificado" style="max-width: 250px; height: auto;">

    </div>
    <h3>Relatório de Inscrições</h3>
</header>

<main>
    @if(!empty($inscricoes) && count($inscricoes) > 0)
        <table>
            <thead>
                <tr>
                    <th>Servidor</th>
                    <th>Curso</th>
                    <th>Data de Inscrição</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inscricoes as $inscricao)
                    <tr>
                        <td>{{ $inscricao->user->name }}</td>
                        <td>{{ $inscricao->curso->nome }}</td>
                        <td>{{ $inscricao->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Nenhuma inscrição encontrada.</p>
    @endif
</main>

</body>
</html>

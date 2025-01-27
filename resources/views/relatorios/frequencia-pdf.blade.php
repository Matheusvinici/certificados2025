<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Frequências</title>
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
        h1, h2 {
            margin: 0;
        }
        h2 {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<header>
    <div class="image-container">
        <img src="{{ public_path('images/logoprefeitura.png') }}" alt="Logo da Prefeitura" style="max-width: 250px; height: auto;">
    </div>
    <br>
    <h3>Relatório de Frequências</h3>
</header>

<main>
    @foreach($encontros as $encontro)
        <h2>{{ $encontro->conteudo }} - {{ \Carbon\Carbon::parse($encontro->data)->format('d/m/Y') }}</h2>
        <table>
            <thead>
                <tr>
                    <th>Servidor</th>
                    <th>Escola</th>
                </tr>
            </thead>
            <tbody>
                @foreach($encontro->frequencias as $frequencia)
                    <tr>
                        <td>{{ $frequencia->user->name }}</td>
                        <td>{{ $frequencia->user->escola }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</main>

</body>
</html>

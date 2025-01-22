<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Inscrições</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Relatório de Inscrições</h1>

    @if(count($inscricoes) > 0)
        <table>
            <thead>
                <tr>
                    <th>Nome do Aluno</th>
                    <th>Curso</th>
                    <th>Email</th>
                    <th>Data de Inscrição</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inscricoes as $inscricao)
                    <tr>
                        <td>{{ $inscricao->user->name }}</td>
                        <td>{{ $inscricao->curso->nome }}</td>
                        <td>{{ $inscricao->user->email }}</td>
                        <td>{{ $inscricao->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Nenhuma inscrição encontrada.</p>
    @endif
</body>
</html>

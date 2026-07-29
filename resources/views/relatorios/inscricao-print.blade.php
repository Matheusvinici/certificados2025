<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Inscrições{{ $cursoFiltro ? ' - ' . $cursoFiltro->nome : '' }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            color: #1e293b;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding-bottom: 15px;
            border-bottom: 2px solid #4f46e5;
            margin-bottom: 20px;
        }
        .header img {
            max-height: 60px;
            margin-bottom: 8px;
        }
        .header h2 {
            font-size: 18px;
            color: #4f46e5;
            margin-bottom: 4px;
        }
        .header p {
            font-size: 14px;
            color: #64748b;
        }
        .resumo {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        .resumo-item {
            background: #f1f5f9;
            border-radius: 8px;
            padding: 8px 14px;
            border-left: 3px solid #4f46e5;
            font-size: 12px;
        }
        .resumo-item strong {
            display: block;
            font-size: 14px;
            color: #4f46e5;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #4f46e5;
            color: #fff;
            padding: 8px 10px;
            text-align: left;
            font-size: 12px;
        }
        td {
            padding: 6px 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        tr:nth-child(even) { background: #f8fafc; }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
            font-size: 11px;
            color: #94a3b8;
        }
        .no-print { margin-bottom: 16px; }
        @media print {
            body { padding: 0; }
            .no-print { display: none !important; }
            @page { margin: 12mm; size: portrait; }
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Juazeiro" onerror="this.style.display='none'">
        <h2>Relatório de Inscrições</h2>
        <p>{{ $cursoFiltro ? $cursoFiltro->nome . ' — ' . $cursoFiltro->carga_horaria . 'h' : 'Todos os cursos' }}</p>
    </div>

    <button class="no-print" onclick="window.print()" style="padding:8px 20px;background:#4f46e5;color:#fff;border:none;border-radius:6px;cursor:pointer;margin-bottom:16px;">
        Imprimir / Salvar PDF (Ctrl+P)
    </button>

    @php
        $porSecretaria = $inscricoes->groupBy(fn($i) => $i->user->secretaria ?: 'Sem secretaria');
    @endphp

    <div class="resumo">
        @foreach($porSecretaria as $secretaria => $lista)
            <div class="resumo-item">
                <strong>{{ $lista->count() }}</strong>
                {{ $secretaria }}
            </div>
        @endforeach
        <div class="resumo-item" style="border-left-color:#0ea5e9;">
            <strong>{{ $inscricoes->count() }}</strong>
            Total
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Servidor</th>
                <th>Secretaria</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inscricoes as $inscricao)
                <tr>
                    <td>{{ $inscricao->user->name }}</td>
                    <td>{{ $inscricao->user->secretaria ?: '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="2" style="text-align:center;padding:20px;color:#94a3b8;">Nenhuma inscrição encontrada.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Total de inscrições: {{ $inscricoes->count() }} &mdash; Gerado em {{ now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>

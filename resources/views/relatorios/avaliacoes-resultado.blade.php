<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Avaliações - {{ $curso->nome }}</title>
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
        .info-curso {
            display: flex;
            justify-content: space-between;
            padding: 8px 12px;
            background: #f1f5f9;
            border-radius: 6px;
            margin-bottom: 16px;
            font-size: 13px;
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
        .media { text-align: center; font-weight: 700; }
        .media-alta { color: #16a34a; }
        .media-media { color: #ca8a04; }
        .media-baixa { color: #dc2626; }
        .estrelas { color: #eab308; font-size: 14px; }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
            font-size: 11px;
            color: #94a3b8;
        }
        .resumo {
            display: flex;
            gap: 16px;
            justify-content: center;
            margin-bottom: 16px;
        }
        .resumo-item {
            text-align: center;
            background: #f1f5f9;
            border-radius: 8px;
            padding: 10px 20px;
            min-width: 100px;
        }
        .resumo-item .valor { font-size: 22px; font-weight: 700; color: #4f46e5; }
        .resumo-item .rotulo { font-size: 11px; color: #64748b; }
        .no-print { margin-bottom: 16px; }
        @media print {
            body { padding: 0; }
            .no-print { display: none !important; }
            @page { margin: 15mm; size: portrait; }
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Juazeiro" onerror="this.style.display='none'">
        <h2>Relatório de Avaliações</h2>
        <p>{{ $curso->nome }}</p>
    </div>

    <div class="info-curso">
        <span>Carga horária: {{ $curso->carga_horaria }}h</span>
        <span>Percentual mínimo: {{ $curso->percentual }}%</span>
        <span>Total de inscritos: {{ $dados->count() }}</span>
    </div>

    @php
        $comAvaliacao = $dados->filter(fn($d) => $d->media_geral > 0);
        $mediaConteudo = $comAvaliacao->isNotEmpty()
            ? round($comAvaliacao->avg('media_conteudo'), 1)
            : 0;
        $mediaMetodologia = $comAvaliacao->isNotEmpty()
            ? round($comAvaliacao->avg('media_metodologia'), 1)
            : 0;
    @endphp

    <div class="resumo no-print">
        <div class="resumo-item">
            <div class="valor">{{ $dados->count() }}</div>
            <div class="rotulo">Inscritos</div>
        </div>
        <div class="resumo-item">
            <div class="valor">{{ $comAvaliacao->count() }}</div>
            <div class="rotulo">Avaliaram</div>
        </div>
        <div class="resumo-item">
            <div class="valor">{{ $mediaConteudo }}</div>
            <div class="rotulo">Média Conteúdo</div>
        </div>
        <div class="resumo-item">
            <div class="valor">{{ $mediaMetodologia }}</div>
            <div class="rotulo">Média Metodologia</div>
        </div>
    </div>

    <button class="no-print btn-print" onclick="window.print()" style="padding:8px 20px;background:#4f46e5;color:#fff;border:none;border-radius:6px;cursor:pointer;margin-bottom:16px;">
        <i class="fas fa-print"></i> Imprimir / Salvar PDF (Ctrl+P)
    </button>

    <table>
        <thead>
            <tr>
                <th>Servidor</th>
                <th>Secretaria</th>
                <th>Presenças</th>
                <th class="media">Conteúdo</th>
                <th class="media">Metodologia</th>
                <th class="media">Média</th>
                <th>Comentários</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dados as $d)
                <tr>
                    <td>{{ $d->nome }}</td>
                    <td>{{ $d->secretaria ?? '-' }}</td>
                    <td class="media">{{ $d->presencas }}</td>
                    <td class="media">
                        @if(is_numeric($d->media_conteudo))
                            <span class="estrelas">
                                @for($s = 1; $s <= 5; $s++){{ $s <= round($d->media_conteudo) ? '★' : '☆' }}@endfor
                            </span>
                            <br><small>{{ $d->media_conteudo }}</small>
                        @else
                            -
                        @endif
                    </td>
                    <td class="media">
                        @if(is_numeric($d->media_metodologia))
                            <span class="estrelas">
                                @for($s = 1; $s <= 5; $s++){{ $s <= round($d->media_metodologia) ? '★' : '☆' }}@endfor
                            </span>
                            <br><small>{{ $d->media_metodologia }}</small>
                        @else
                            -
                        @endif
                    </td>
                    <td class="media">
                        @if($d->media_geral > 0)
                            <span class="{{ $d->media_geral >= 4 ? 'media-alta' : ($d->media_geral >= 3 ? 'media-media' : 'media-baixa') }}">
                                {{ $d->media_geral }}
                            </span>
                        @else
                            -
                        @endif
                    </td>
                    <td style="max-width: 200px;">{{ $d->comentarios ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center;padding:20px;color:#94a3b8;">Nenhum inscrito encontrado.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Relatório gerado em {{ now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>

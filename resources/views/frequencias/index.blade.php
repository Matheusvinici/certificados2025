@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Relatório de Frequências</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('frequencias.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-6">
                <label for="escola" class="form-label">Filtrar por Escola</label>
                <select class="form-control" id="escola" name="escola">
                    <option value="" selected>Todas as Escolas</option>
                    @foreach($escolas as $escola)
                        <option value="{{ $escola }}" {{ request('escola') == $escola ? 'selected' : '' }}>
                            {{ $escola }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>

    @if($encontros->isEmpty())
        <div class="alert alert-info">Nenhum registro encontrado.</div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Encontro</th>
                    <th>Usuário</th>
                    <th>Escola</th>
                    <th>Avaliação do Conteúdo</th>
                    <th>Avaliação da Metodologia</th>
                    <th>Comentários</th>
                </tr>
            </thead>
            <tbody>
                @foreach($encontros as $encontro)
                    @foreach($encontro->frequencias as $frequencia)
                        <tr>
                            <td>{{ $encontro->nome ?? 'Encontro Não Identificado' }}</td>
                            <td>{{ $frequencia->user->name }}</td>
                            <td>{{ $frequencia->user->escola }}</td>
                            <td>{{ $frequencia->avaliacao_conteudo }}</td>
                            <td>{{ $frequencia->avaliacao_metodologia }}</td>
                            <td>{{ $frequencia->comentarios ?? 'Sem Comentários' }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="mt-4">
        <a href="{{ route('frequencias.gerar-pdf', ['escola' => request('escola')]) }}" class="btn btn-secondary">
            Gerar PDF
        </a>
    </div>
</div>
@endsection

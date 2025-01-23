@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Resultado da Frequência</h1>

    <!-- Filtro por escola -->
    <form method="GET" action="{{ route('frequencias.index') }}">
        <div class="form-group">
            <label for="escola">Filtrar por Escola:</label>
            <select name="escola" id="escola" class="form-control">
                <option value="">Selecione uma escola</option>
                @if(isset($escolas) && $escolas->count() > 0)
                    @foreach($escolas as $escola)
                        <option value="{{ $escola }}" {{ request()->input('escola') == $escola ? 'selected' : '' }}>
                            {{ $escola }}
                        </option>
                    @endforeach
                @else
                    <option disabled>Nenhuma escola encontrada</option>
                @endif
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>

    <!-- Tabela de Encontros e Frequências -->
    @foreach($encontros as $encontro)
        <h2>{{ $encontro->conteudo }} - {{ $encontro->data }}</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Participante</th>
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

    <!-- Botão para gerar PDF -->
    <!-- Botão para gerar PDF -->
<form method="GET" action="{{ route('frequencias.gerarPdf') }}">
    <input type="hidden" name="escola" value="{{ request()->input('escola') }}">
    <button type="submit" class="btn btn-danger">Gerar PDF</button>
</form>

</div>
@endsection

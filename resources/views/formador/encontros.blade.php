@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Encontros do Curso: {{ $curso->nome }}</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Data</th>
                <th>Nome do Encontro</th>
                <th>Hash (Código de Frequência)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($encontros as $encontro)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($encontro->data)->format('d/m/Y') }}</td>
                    <td>{{ $encontro->conteudo }}</td>
                    <td>{{ $encontro->hash }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

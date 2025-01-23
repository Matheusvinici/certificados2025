@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Resultado da Frequência</h1>
    

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

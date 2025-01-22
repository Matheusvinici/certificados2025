@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Resultado da Frequência</h1>
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
</div>
@endsection

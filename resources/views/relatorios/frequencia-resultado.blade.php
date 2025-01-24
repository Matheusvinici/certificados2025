@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Resultado da Frequência</h1>

    <form method="GET" action="{{ route('frequencias.index') }}">
        <div class="input-group mb-3">
            <select name="escola" class="form-control @error('escola') is-invalid @enderror" required>
                <option value="" disabled selected>Selecione uma escola</option>
                <option value="Escola Municipal Crenildes" {{ request('escola') == 'Escola Municipal Crenildes' ? 'selected' : '' }}>
                    Escola Municipal Crenildes
                </option>
                <option value="Escola Municipal Paulo Vl" {{ request('escola') == 'Escola Municipal Paulo Vl' ? 'selected' : '' }}>
                    Escola Municipal Paulo Vl
                </option>
                <option value="Escola Municipal Iracema" {{ request('escola') == 'Escola Municipal Iracema' ? 'selected' : '' }}>
                    Escola Municipal Iracema
                </option>
            </select>
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
    </form>

    <!-- Tabela de Encontros e Frequências -->
    @if($encontros->isEmpty())
        <p>Nenhum encontro encontrado para a escola selecionada.</p>
    @else
        @foreach($encontros as $encontro)
        <h2>{{ $encontro->conteudo }} - {{ \Carbon\Carbon::parse($encontro->data)->format('d/m/Y') }}</h2>
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
    @endif

    <!-- Botão para gerar PDF -->
    <form method="GET" action="{{ route('frequencias.gerarPdf') }}">
        <input type="hidden" name="escola" value="{{ request()->input('escola') }}">
        <button type="submit" class="btn btn-danger">Gerar PDF</button>
    </form>

</div>
@endsection

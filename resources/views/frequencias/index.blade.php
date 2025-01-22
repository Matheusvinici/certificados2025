@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Frequências Registradas') }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Frequências do Curso: {{ $inscricao->curso->nome }}</h3>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Encontro</th>
                                        <th>Data</th>
                                        <th>Frequência Registrada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($frequencias as $frequencia)
                                        <tr>
                                            <td>{{ $frequencia->encontro->conteudo }}</td>
                                            <td>{{ $frequencia->encontro->data }}</td>
                                            <td>Registrada</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">Nenhuma frequência registrada.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detalhes do Curso Inscrito</h1>
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
                        <h3 class="card-title">Informações do Curso</h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-md-4">Nome do Curso:</dt>
                            <dd class="col-md-8">{{ $curso->nome }}</dd>

                            <dt class="col-md-4">Data de Início:</dt>
                            <dd class="col-md-8">{{ \Carbon\Carbon::parse($curso->data_inicio)->format('d/m/Y') }}</dd>

                            <dt class="col-md-4">Data de Conclusão:</dt>
                            <dd class="col-md-8">{{ \Carbon\Carbon::parse($curso->data_fim)->format('d/m/Y') }}</dd>

                            <dt class="col-md-4">Carga Horária:</dt>
                            <dd class="col-md-8">{{ $curso->carga_horaria }} horas</dd>

                            <dt class="col-md-4">Percentual de Conclusão:</dt>
                            <dd class="col-md-8">{{ $inscricao->percentual_conclusao }}%</dd>

                            <dt class="col-md-4">Status da Inscrição:</dt>
                            <dd class="col-md-8">{{ $inscricao->status }}</dd>
                        </dl>
                    </div>
                </div>

                <!-- Encontros -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Encontros</h3>
                    </div>
                    <div class="card-body">
                        @if ($curso->encontros->count() > 0)
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Encontro</th>
                                        <th>Data</th>
                                        <th>Carga Horária</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($curso->encontros as $index => $encontro)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $encontro->conteudo }}</td>
                                            <td>{{ \Carbon\Carbon::parse($encontro->data)->format('d/m/Y') }}</td>
                                            <td>{{ $encontro->carga_horaria_encontro }} horas</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>Este curso não possui encontros cadastrados.</p>
                        @endif
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('inscricoes.index') }}" class="btn btn-secondary">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

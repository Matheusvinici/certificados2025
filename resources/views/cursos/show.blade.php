@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detalhes do Curso</h1>
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

                            <dt class="col-md-4">Percentual:</dt>
                            <dd class="col-md-8">{{ $curso->percentual }}%</dd>

                            <dt class="col-md-4">Formador:</dt>
                            <dd class="col-md-8">
                                @forelse($curso->formadores as $f)
                                    <span class="badge badge-info mr-1">{{ $f->name }}</span>
                                @empty
                                    Não vinculado
                                @endforelse
                            </dd>

                            <dt class="col-md-4">Vagas:</dt>
                            <dd class="col-md-8">{{ $curso->vagas ? $curso->vagas . ' inscrições' : 'Ilimitadas' }}</dd>

                            <dt class="col-md-4">Validação:</dt>
                            <dd class="col-md-8">
                                @if($curso->status == 'validado')
                                    <span class="badge badge-success">Validado</span>
                                @else
                                    <span class="badge badge-warning">Pendente de Validação</span>
                                @endif
                            </dd>

                            <dt class="col-md-4">Status:</dt>
                            <dd class="col-md-8">{{ $curso->ativo ? 'Ativo' : 'Inativo' }}</dd>
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
                                        <th>Horário</th>
                                        <th>Carga Horária</th>
                                        <th>Código de Frequência</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($curso->encontros as $index => $encontro)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $encontro->conteudo }}</td>
                                            <td>{{ \Carbon\Carbon::parse($encontro->data)->format('d/m/Y') }}</td>
                                            <td>
                                                {{ $encontro->hora_inicio ? \Carbon\Carbon::parse($encontro->hora_inicio)->format('H:i') . ' às ' . \Carbon\Carbon::parse($encontro->hora_fim)->format('H:i') : '—' }}
                                            </td>
                                            <td>{{ $encontro->carga_horaria_encontro }} horas</td>
                                            <td><code>{{ $encontro->hash }}</code></td>
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
                    <a href="{{ route('cursos.index') }}" class="btn btn-secondary">Voltar</a>
                    <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-primary">Editar Curso</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

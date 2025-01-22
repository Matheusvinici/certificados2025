@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Minhas Inscrições') }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-3">
                        <a href="{{ route('inscricoes.create') }}" class="btn btn-dark">
                            <i class="fas fa-plus"></i> Criar Nova Inscrição
                        </a>
                    </div>
                                    <div class="mb-3">
                                    @if(auth()->user()->role == 'admin')

                                    <a href="{{ route('inscricoes.relatorio', ['curso_id' => request('curso_id')]) }}" class="btn btn-primary">
                            Baixar Relatório em PDF
                        </a>
                        @endif

                </div>

                @if(auth()->user()->role == 'admin')

                    <!-- Filtro de Cursos -->
                    <form method="GET" action="{{ route('inscricoes.index') }}">
                        <div class="form-group">
                            <label for="curso_id">Filtrar por Curso</label>
                            <select name="curso_id" id="curso_id" class="form-control">
                                <option value="">Selecione um curso</option>
                                @foreach($cursos as $curso)
                                    <option value="{{ $curso->id }}" {{ request('curso_id') == $curso->id ? 'selected' : '' }}>
                                        {{ $curso->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                    </form>
                    @endif

                    <!-- Main content -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Inscrições Ativas</h3>
                        </div>
                        <div class="card-body">
                            @if($inscricoes->isEmpty())
                                <p>Você não está inscrito em nenhum curso.</p>
                            @else
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nome do Usuário</th>
                                            <th>Curso</th>
                                            <th>Carga Horária</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($inscricoes as $inscricao)
                                            <tr>
                                                <td>{{ $inscricao->user->name }}</td>
                                                <td>{{ $inscricao->curso->nome }}</td>
                                                <td>{{ $inscricao->curso->carga_horaria }} horas</td>
                                                <td>
                                                    <a href="{{ route('frequencias.create', $inscricao->curso_id) }}" class="btn btn-primary">Frequência</a>
                                                    <a href="{{ route('inscricoes.show', $inscricao->id) }}" class="btn btn-info">Ver Mais</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

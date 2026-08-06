@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('Meus Cursos') }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($cursos->isEmpty())
            <div class="alert alert-info">
                Nenhum curso vinculado a você ainda. Procure o administrador para vincular um curso.
            </div>
        @else
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-hover m-0 align-middle">
                    <thead>
                        <tr>
                            <th>Curso</th>
                            <th>Período</th>
                            <th>Encontros</th>
                            <th>Vagas</th>
                            <th>Status</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cursos as $curso)
                        <tr>
                            <td><strong>{{ $curso->nome }}</strong></td>
                            <td>
                                {{ \Carbon\Carbon::parse($curso->data_inicio)->format('d/m/Y') }} a
                                {{ \Carbon\Carbon::parse($curso->data_fim)->format('d/m/Y') }}
                            </td>
                            <td>{{ $curso->encontros()->count() }}</td>
                            <td>{{ $curso->vagas ?? 'Não definida' }}</td>
                            <td>
                                @if($curso->status == 'validado')
                                    <span class="badge badge-success">Validado</span>
                                @else
                                    <span class="badge badge-warning">Aguardando validação</span>
                                @endif
                            </td>
                            <td class="text-right">
                                @if($curso->status != 'validado')
                                    <a href="{{ route('formador.horarios.edit', $curso) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-calendar-alt"></i> Cadastrar Horários
                                    </a>
                                @else
                                    <a href="{{ route('formador.horarios.edit', $curso) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye"></i> Ver Horários
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

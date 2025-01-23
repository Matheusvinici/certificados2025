@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Minhas Inscrições') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.content-header -->

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-3">
                        <a href="{{ route('inscricoes.create') }}" class="btn btn-dark">
                            <i class="fas fa-plus"></i> Criar Nova Inscrição
                        </a>
                    </div>

                    <!-- Mensagem de Sucesso ou Erro -->
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @elseif(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

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

                    <!-- Tabela de Inscrições -->
                    <div class="card">
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
                                                    <a href="{{ route('frequencias.create', $inscricao->curso_id) }}" class="btn btn-primary btn-sm">Frequência</a>
                                                    <a href="{{ route('inscricoes.show', $inscricao->id) }}" class="btn btn-info btn-sm">Ver Mais</a>

                                                    <!-- Botão de Exclusão com Confirmação -->
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $inscricao->id }})">
                                                        Excluir
                                                    </button>
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

@section('scripts')
<script type="text/javascript">
    function confirmDelete(id) {
        // Mostrar o modal de confirmação
        $('#deleteModal').modal('show');
        
        // Definir o ID da inscrição para o formulário de exclusão
        $('#delete-form').attr('action', '/inscricoes/' + id);
    }
</script>
@endsection

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Você tem certeza que deseja excluir esta inscrição? Esta ação não pode ser desfeita.
            </div>
            <div class="modal-footer">
                <form id="delete-form" action="" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

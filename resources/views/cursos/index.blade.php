@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Cursos') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <div class="alert alert-info">
                        Lista de Cursos
                    </div>

                    <!-- Botão Criar Novo Curso -->
                    <div class="mb-3">
                        <a href="{{ route('cursos.create') }}" class="btn btn-dark">
                            <i class="fas fa-plus"></i> Criar Novo Curso
                        </a>
                    </div>

                    <!-- Tabela de Cursos -->
                    <div class="card">
                        <div class="card-body p-0">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nome do Curso</th>
                                        <th>Data de Início</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($cursos as $curso)
                                    <tr>
                                        <td>{{ $curso->nome }}</td>
                                        <td>{{ \Carbon\Carbon::parse($curso->data_inicio)->format('d/m/Y') }}</td>
                                        <td>{{ $curso->ativo ? 'Ativo' : 'Inativo' }}</td>
                                        <td>
                                            <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-primary btn-sm">Editar</a>
                                            <a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-primary btn-sm">Ver mais</a>

                                            <!-- Botão de Exclusão com Confirmação -->
                                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $curso->id }})">
                                                Deletar
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer clearfix">
                            {{ $cursos->links() }}
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.content -->
@endsection

@section('scripts')
<script type="text/javascript">
    function confirmDelete(id) {
        // Mostrar o modal de confirmação
        $('#deleteModal').modal('show');
        
        // Definir o ID do curso para o formulário de exclusão
        $('#delete-form').attr('action', '/cursos/' + id);
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
                Você tem certeza que deseja excluir este curso? Esta ação não pode ser desfeita.
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

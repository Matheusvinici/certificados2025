@extends('layouts.app')

@section('content')
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Certificados Gerados</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Botão de Criação -->
                    @if(auth()->user()->role == 'admin')
                        <div class="mb-3">
                            <a href="{{ route('certificados.create') }}" class="btn btn-dark">
                                <i class="fas fa-plus"></i> Gerar Novo Certificado
                            </a>
                        </div>
                    @endif

                    <!-- Mensagens de Feedback -->
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @elseif(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Filtros -->
                    <form method="GET" action="{{ route('certificados.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <input 
                                    type="text" 
                                    name="user" 
                                    class="form-control" 
                                    placeholder="Pesquisar Servidor" 
                                    value="{{ request('user') }}">
                            </div>
                            <div class="col-md-4">
                                <select name="curso" class="form-control">
                                    <option value="">Filtrar por Curso</option>
                                    @foreach($cursos as $curso)
                                        <option value="{{ $curso->id }}" 
                                            {{ request('curso') == $curso->id ? 'selected' : '' }}>
                                            {{ $curso->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Filtrar</button>
                            </div>
                        </div>
                    </form>

                    <!-- Tabela de Certificados -->
                    <div class="card">
                        <div class="card-body">
                            @if($certificados->isEmpty())
                                <p>Nenhum certificado encontrado.</p>
                            @else
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Curso</th>
                                            <th>Servidor</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($certificados as $certificado)
                                            <tr>
                                                <td>{{ $certificado->id }}</td>
                                                <td>{{ $certificado->curso->nome }}</td>
                                                <td>{{ $certificado->user->name }}</td>
                                                <td>
                                                    <!-- Botão de Imprimir -->
                                                    <a href="{{ route('certificados.gerarPdf', $certificado->id) }}" class="btn btn-primary btn-sm">
                                                        Imprimir
                                                    </a>

                                                    <!-- Botão de Exclusão -->
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $certificado->id }})">
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

                    <!-- Paginação -->
                    <div class="d-flex justify-content-center">
                        {{ $certificados->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
    function confirmDelete(id) {
        // Mostrar o modal de exclusão
        $('#deleteModal').modal('show');

        // Atualizar a ação do formulário de exclusão
        $('#delete-form').attr('action', '/certificados/' + id);
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
                Você tem certeza que deseja excluir este certificado? Esta ação não pode ser desfeita.
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

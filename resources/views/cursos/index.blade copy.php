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
<div class="container">
                    <div class="alert alert-info">
                        Lista de Cursos
                    </div>

    <!-- Mensagem de Sucesso -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
     
                    <!-- Botão Criar Novo Curso -->
                    <div class="mb-3">
                        <a href="{{ route('cursos.create') }}" class="btn btn-dark">
                            <i class="fas fa-plus"></i> Criar Novo Curso
                        </a>
                    </div>

    <table class="table">
        <thead>
            <tr>
            <th scope="col">Nome do Curso</th>
            <th scope="col">Data de Início</th>
            <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cursos as $curso)
            <tr>
                <td>{{ $curso->id }}</td>
                <td>{{ $curso->nome }}</td>
                <td>
                            <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-primary btn-sm">Editar</a>
                            <a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-info btn-sm">Ver mais</a>
                    <!-- Botão de Exclusão com Modal de Confirmação -->
                    <button class="btn btn-danger" onclick="confirmDelete({{ $curso->id }})">Excluir</button>

                    <!-- Formulário de Exclusão (oculto) -->
                    <form id="delete-form-{{ $curso->id }}" action="{{ route('cursos.destroy', $curso->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal de Confirmação de Exclusão -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(cursoId) {
        Swal.fire({
            title: 'Você tem certeza?',
            text: "Esta ação não poderá ser desfeita!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Envia o formulário de exclusão
                document.getElementById('delete-form-' + cursoId).submit();
            }
        });
    }
</script>
@endsection

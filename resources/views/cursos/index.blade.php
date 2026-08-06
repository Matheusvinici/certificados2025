@extends('layouts.app')

@section('content')

  <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Cursos') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6 text-right">
                    <a href="{{ route('cursos.create') }}" class="btn btn-dark">
                        <i class="fas fa-plus"></i> Criar Novo Curso
                    </a>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.content-header -->
    
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nome do Curso</th>
                <th scope="col">Formador</th>
                <th scope="col">Vagas</th>
                <th scope="col">Status</th>
                <th scope="col">Data de Início</th>
                <th scope="col" class="text-right">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cursos as $curso)
            <tr>
                <td>{{ $curso->nome }}</td>
                <td>
                    @forelse($curso->formadores as $f)
                        <span class="badge badge-info mr-1">{{ $f->name }}</span>
                    @empty
                        <span class="text-muted">Não vinculado</span>
                    @endforelse
                </td>
                <td>{{ $curso->vagas ?? 'Ilimitadas' }}</td>
                <td>
                    @if($curso->status == 'validado')
                        <span class="badge badge-success">Validado</span>
                    @else
                        <span class="badge badge-warning">Pendente</span>
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($curso->data_inicio)->format('d/m/Y') }}</td>
                <td class="text-right">
                    <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-primary btn-sm">Editar</a>
                    <a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-info btn-sm">Ver mais</a>
                    <form action="{{ route('cursos.duplicar', $curso) }}" method="POST" class="d-inline" onsubmit="return confirm('Duplicar este curso com todos os temas?')">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm" title="Duplicar com os temas">
                            <i class="fas fa-copy"></i> Duplicar
                        </button>
                    </form>
                    @if($curso->status != 'validado')
                        <form action="{{ route('cursos.validar', $curso) }}" method="POST" class="d-inline" onsubmit="return confirm('Validar este curso? Ele ficará disponível para inscrições.')">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-check-circle"></i> Validar
                            </button>
                        </form>
                    @else
                        <form action="{{ route('cursos.reabrir', $curso) }}" method="POST" class="d-inline" onsubmit="return confirm('Desfazer a validação? O curso sairá das inscrições.')">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm">
                                <i class="fas fa-undo"></i> Desfazer
                            </button>
                        </form>
                    @endif
                    <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $curso->id }})">Excluir</button>

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
                document.getElementById('delete-form-' + cursoId).submit();
            }
        });
    }
</script>
@endsection

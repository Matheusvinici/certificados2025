@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Inscrição no Curso') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <!-- Informações da Inscrição -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Detalhes da Inscrição</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('inscricoes.store') }}" method="POST" class="space-y-6">
                                @csrf

                                <div class="row">
                                    <!-- Curso -->
                                    <div class="col-md-6 form-group">
                                        <label for="curso_id">Curso</label>
                                        <select name="curso_id" id="curso_id" class="form-control @error('curso_id') is-invalid @enderror" required>
                                            <option value="">Selecione um curso</option>
                                            @foreach($cursos as $curso)
                                                <option value="{{ $curso->id }}">{{ $curso->nome }} - Início: {{ \Carbon\Carbon::parse($curso->data_inicio)->format('d/m/Y') }} - Fim: {{ \Carbon\Carbon::parse($curso->data_fim)->format('d/m/Y') }}</option>

                                                @endforeach
                                        </select>
                                        @error('curso_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Usuário (Usa o usuário logado) -->
                                    <div class="col-md-6 form-group">
                                        <label for="user_id">Usuário</label>
                                        <input type="text" value="{{ auth()->user()->name }}" class="form-control" disabled>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-dark">
                                        Confirmar Inscrição
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
@endsection

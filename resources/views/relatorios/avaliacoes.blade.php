@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Relatório de Avaliações</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('relatorios.avaliacoes.gerar') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="form-label">Selecione o curso</label>
                        <select name="curso_id" class="form-control" required>
                            <option value="">Selecione...</option>
                            @foreach($cursos as $curso)
                                <option value="{{ $curso->id }}">{{ $curso->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-chart-bar"></i> Gerar Relatório
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

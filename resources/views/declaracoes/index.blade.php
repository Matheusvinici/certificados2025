@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('Declarações de Comparecimento') }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @forelse($inscricoes as $inscricao)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-book text-primary me-2"></i>{{ $inscricao->curso->nome }}
                    </h5>
                </div>
                <div class="card-body p-0">
                    @php
                        $frequenciasCurso = $inscricao->curso->encontros
                            ->map(fn ($encontro) => $frequencias->get($encontro->id))
                            ->filter();
                    @endphp
                    @if($frequenciasCurso->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0" style="font-size: 0.9rem;">
                                <thead>
                                    <tr>
                                        <th>Dia</th>
                                        <th>Tema</th>
                                        <th>Hora de Início</th>
                                        <th>Hora de Saída</th>
                                        <th style="width: 340px;">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($frequenciasCurso as $frequencia)
                                        <tr>
                                            <td>{{ $frequencia->encontro ? \Carbon\Carbon::parse($frequencia->encontro->data)->format('d/m/Y') : '-' }}</td>
                                            <td>{{ $frequencia->encontro->conteudo ?? '-' }}</td>
                                            <td>
                                                <form method="POST" action="{{ route('declaracoes.update', $frequencia->id) }}" class="d-flex align-items-center gap-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="time" name="hora_inicio" value="{{ $frequencia->hora_inicio }}" class="form-control form-control-sm" style="width: 110px;">
                                            </td>
                                            <td>
                                                    <input type="time" name="hora_saida" value="{{ $frequencia->hora_saida }}" class="form-control form-control-sm" style="width: 110px;">
                                            </td>
                                            <td>
                                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-save"></i> Salvar
                                                    </button>
                                                </form>
                                                <a href="{{ route('declaracoes.gerarPdf', $frequencia->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-download"></i> Baixar Declaração
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-secondary" style="font-size: 0.9rem;">
                            Nenhuma presença registrada neste curso.
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-file-signature" style="font-size: 2rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
                    <p class="text-secondary mb-0">Você ainda não possui inscrições em cursos.</p>
                </div>
            </div>
        @endforelse

    </div>
</div>
@endsection

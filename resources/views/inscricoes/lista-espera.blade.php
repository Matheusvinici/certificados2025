@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Lista de Espera') }}</h1>
                    <p class="text-secondary small mb-0">
                        Quando uma inscrição é removida, o primeiro da fila é inscrito automaticamente.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @php $cursosComLista = $cursos->filter(fn($c) => $c->lista_espera->isNotEmpty()); @endphp

            @if($cursosComLista->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Nenhuma lista de espera no momento.
                    Quando as vagas de um curso forem preenchidas, novos inscritos entram automaticamente na lista de espera.
                </div>
            @else
                @foreach($cursosComLista as $curso)
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                <div>
                                    <h3 class="card-title mb-0">{{ $curso->nome }}</h3>
                                    <small class="text-muted d-block">
                                        Formadores:
                                        @forelse($curso->formadores as $f)
                                            {{ $f->name }}@if(!$loop->last), @endif
                                        @empty
                                            Não vinculado
                                        @endforelse
                                    </small>
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge badge-pill" style="background: #e2e8f0; color: #334155;">
                                        Vagas: {{ $curso->vagas ?? 'Ilimitadas' }}
                                    </span>
                                    <span class="badge badge-pill" style="background: #dbeafe; color: #1d4ed8;">
                                        Inscritos: {{ $curso->inscritos_count }}
                                    </span>
                                    <span class="badge badge-pill" style="background: #fef3c7; color: #92400e;">
                                        Lista de espera: {{ $curso->lista_espera->count() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 60px;">Posição</th>
                                            <th>Nome</th>
                                            <th>Secretaria</th>
                                            <th>Data da Inscrição</th>
                                            <th style="width: 1%;">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($curso->lista_espera as $i => $inscricao)
                                            <tr>
                                                <td class="align-middle">
                                                    <span class="badge badge-pill {{ $i == 0 ? 'bg-warning' : 'bg-secondary' }}" style="color: #fff;">
                                                        {{ $i + 1 }}º
                                                    </span>
                                                </td>
                                                <td class="align-middle">{{ $inscricao->user->name }}</td>
                                                <td class="align-middle">{{ $inscricao->user->secretaria ?: '-' }}</td>
                                                <td class="align-middle">{{ $inscricao->created_at->format('d/m/Y H:i') }}</td>
                                                <td class="align-middle">
                                                    <div class="d-flex flex-nowrap gap-1">
                                                        <form action="{{ route('lista-espera.promover', $inscricao) }}" method="POST"
                                                              onsubmit="return confirm('Promover {{ $inscricao->user->name }} para inscrito?')">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm" title="Inscrição confirmada (também ocorre automaticamente ao remover um inscrito)">
                                                                <i class="fas fa-user-check"></i> Promover
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('inscricoes.destroy', $inscricao) }}" method="POST"
                                                              onsubmit="return confirm('Remover {{ $inscricao->user->name }} da lista de espera?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Remover da lista">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Painel Inicial') }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row g-4">

                @if($cursosAbertos->count())
                    <div class="col-lg-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="feature-icon icon-blue" style="width: 48px; height: 48px; border-radius: 14px; display: inline-flex; align-items: center; justify-content: center; font-size: 1.3rem; background: rgba(79,70,229,0.1); color: #4f46e5;">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 fw-semibold">Inscrições Abertas</h5>
                                        <small class="text-secondary">{{ $cursosAbertos->count() }} curso(s) disponível(is)</small>
                                    </div>
                                </div>
                                <ul class="list-unstyled mb-0">
                                    @foreach($cursosAbertos as $curso)
                                        <li class="d-flex align-items-center justify-content-between py-2 border-bottom border-light">
                                            <span>{{ $curso->nome }}</span>
                                            @php
                                                $jaInscrito = $minhasInscricoes->where('curso_id', $curso->id)->count();
                                            @endphp
                                            @if($jaInscrito)
                                                <span class="badge bg-success" style="font-weight: 500;">Inscrito</span>
                                            @else
                                                <a href="{{ route('inscricoes.create', ['curso_id' => $curso->id]) }}" class="btn btn-sm btn-primary">Inscrever</a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="feature-icon icon-green" style="width: 48px; height: 48px; border-radius: 14px; display: inline-flex; align-items: center; justify-content: center; font-size: 1.3rem; background: rgba(16,185,129,0.1); color: #10b981;">
                                    <i class="fas fa-award"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-semibold">Meus Certificados</h5>
                                    <small class="text-secondary">{{ $certificados->count() }} certificado(s) emitido(s)</small>
                                </div>
                            </div>

                            @if($certificados->count())
                                <ul class="list-unstyled mb-0">
                                    @foreach($certificados as $cert)
                                        <li class="d-flex align-items-center justify-content-between py-2 border-bottom border-light">
                                            <span>{{ $cert->curso->nome }}</span>
                                            <a href="{{ route('certificados.gerarPdf', $cert->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download"></i> Baixar
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-secondary mb-0" style="font-size: 0.9rem;">
                                    Nenhum certificado emitido ainda. Participe de cursos e conclua para gerar seus certificados.
                                </p>
                            @endif

                            @if($certificados->count())
                                <div class="mt-3 pt-3 border-top border-light">
                                    <a href="{{ route('certificados.index') }}" class="btn btn-sm btn-outline-secondary">Ver todos</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            @if(!$cursosAbertos->count())
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <i class="fas fa-calendar-alt" style="font-size: 2rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
                                <p class="text-secondary mb-0">Nenhum curso com inscrições abertas no momento.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="fw-semibold mb-3">
                                <i class="fas fa-book-open text-primary me-2"></i>Todos os Cursos
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0" style="font-size: 0.9rem;">
                                    <thead>
                                        <tr>
                                            <th>Curso</th>
                                            <th>Início</th>
                                            <th>Término</th>
                                            <th>Período de Inscrição</th>
                                            <th>Carga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($cursos as $curso)
                                            <tr>
                                                <td>{{ $curso->nome }}</td>
                                                <td>{{ $curso->data_inicio ? \Carbon\Carbon::parse($curso->data_inicio)->format('d/m/Y') : '-' }}</td>
                                                <td>{{ $curso->data_fim ? \Carbon\Carbon::parse($curso->data_fim)->format('d/m/Y') : '-' }}</td>
                                                <td>
                                                    @if($curso->data_inicio_inscricao || $curso->data_fim_inscricao)
                                                        {{ $curso->data_inicio_inscricao ? \Carbon\Carbon::parse($curso->data_inicio_inscricao)->format('d/m/Y') : '—' }}
                                                        a
                                                        {{ $curso->data_fim_inscricao ? \Carbon\Carbon::parse($curso->data_fim_inscricao)->format('d/m/Y') : '—' }}
                                                    @else
                                                        Sem período definido
                                                    @endif
                                                </td>
                                                <td>{{ $curso->carga_horaria }}h</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-secondary py-3">Nenhum curso cadastrado.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

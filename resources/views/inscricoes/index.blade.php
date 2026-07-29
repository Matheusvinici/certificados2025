@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Minhas Inscrições') }}</h1>
                    <p class="text-secondary small mb-0">Mostre o QR Code ao leitor de frequência para registrar sua presença.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <a href="{{ route('inscricoes.create') }}" class="btn btn-dark">
                            <i class="fas fa-plus"></i> Criar Nova Inscrição
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @elseif(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @php
                        $isAdmin = auth()->user()->role == 'admin' || auth()->user()->hasAnyRole(['leitor-frequencia', 'super-admin']);
                    @endphp
                    @if($isAdmin)
                        <form method="GET" action="{{ route('inscricoes.index') }}" class="row g-2 mb-3">
                            <div class="col-md-5">
                                <select name="curso_id" id="curso_id" class="form-control">
                                    <option value="">Todos os cursos</option>
                                    @foreach($cursos as $curso)
                                        <option value="{{ $curso->id }}" {{ request('curso_id') == $curso->id ? 'selected' : '' }}>
                                            {{ $curso->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4 col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                            </div>
                            @if(auth()->user()->role == 'admin' && request('curso_id'))
                            <div class="col-4 col-md-2">
                                <a href="{{ route('inscricoes.relatorio', ['curso_id' => request('curso_id')]) }}" target="_blank" class="btn btn-success w-100">
                                    <i class="fas fa-print"></i> Baixar
                                </a>
                            </div>
                            @endif
                        </form>
                    @endif

                    <div class="card">
                        <div class="card-body p-0 p-md-3">
                            @if($inscricoes->isEmpty())
                                <p class="p-3 mb-0">Você não está inscrito em nenhum curso.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>QR Code</th>
                                                <th>Nome</th>
                                                <th>Curso</th>
                                                <th class="d-none d-sm-table-cell">Carga Horária</th>
                                                <th>Frequência</th>
                                                <th style="width: 1%;">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($inscricoes as $inscricao)
                                                @php
                                                    $totalEnc = $inscricao->curso->encontros->count();
                                                    $freqCount = \App\Models\Frequencia::where('user_id', $inscricao->user_id)
                                                        ->whereIn('encontro_id', $inscricao->curso->encontros->pluck('id'))
                                                        ->count();
                                                    $percFreq = $totalEnc > 0 ? round(($freqCount / $totalEnc) * 100) : 0;
                                                @endphp
                                                <tr>
                                                    <td class="align-middle text-center">
                                                        <div class="qr-inscricao" data-id="{{ $inscricao->id }}"
                                                             onclick="ampliarQR({{ $inscricao->id }})"
                                                             style="cursor: pointer;" title="Clique para ampliar"></div>
                                                    </td>
                                                    <td class="align-middle">{{ $inscricao->user->name }}</td>
                                                    <td class="align-middle">{{ $inscricao->curso->nome }}</td>
                                                    <td class="align-middle d-none d-sm-table-cell">{{ $inscricao->curso->carga_horaria }}h</td>
                                                    <td class="align-middle" style="min-width: 120px;">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div class="progress flex-grow-1" style="height: 8px;">
                                                                <div class="progress-bar {{ $percFreq >= 100 ? 'bg-success' : ($percFreq >= 50 ? 'bg-warning' : 'bg-secondary') }}"
                                                                     style="width: {{ $percFreq }}%"></div>
                                                            </div>
                                                            <small class="fw-medium {{ $percFreq >= 100 ? 'text-success' : 'text-secondary' }}">
                                                                {{ $percFreq }}%
                                                            </small>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="d-flex flex-wrap gap-1">
                                                            <a href="{{ route('inscricoes.frequencias', $inscricao->id) }}" class="btn btn-primary btn-sm">
                                                                <i class="fas fa-star"></i> Avaliação
                                                            </a>
                                                            @if($isAdmin)
                                                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $inscricao->id }})">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script>
    let modalQR = null;

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.qr-inscricao').forEach(function (el) {
            const id = el.dataset.id;
            new QRCode(el, {
                text: String(id),
                width: 80,
                height: 80,
                colorDark: '#1e293b',
                colorLight: '#ffffff',
                correctLevel: QRCode.CorrectLevel.H
            });
            el.title = 'Clique para ampliar';
        });
    });

    function ampliarQR(id) {
        const modalEl = document.getElementById('qrModal');
        const container = document.getElementById('qrGrande');
        container.innerHTML = '';

        new QRCode(container, {
            text: String(id),
            width: 250,
            height: 250,
            colorDark: '#1e293b',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.H
        });

        modalQR = new bootstrap.Modal(modalEl);
        modalQR.show();
    }

    function confirmDelete(id) {
        $('#deleteModal').modal('show');
        $('#delete-form').attr('action', '/inscricoes/' + id);
    }
</script>
<style>
    .qr-inscricao img, .qr-inscricao canvas {
        border-radius: 6px;
        transition: transform 0.2s;
    }
    .qr-inscricao:hover img, .qr-inscricao:hover canvas {
        transform: scale(1.05);
    }
    #qrGrande canvas, #qrGrande img {
        border-radius: 12px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.12);
    }
</style>
@endsection

<div class="modal fade" id="qrModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 20px;">
            <div class="modal-body text-center py-4">
                <div id="qrGrande" class="d-inline-block mb-2"></div>
                <p class="text-secondary small mb-0">Mostre este QR Code ao leitor de frequência</p>
            </div>
            <div class="modal-footer border-0 pt-0 justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

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

@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $curso->nome }}</h1>
                <p class="text-secondary small mb-0">Frequência de {{ $inscricao->user->name }}</p>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('inscricoes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
                <a href="{{ route('frequencias.create', $inscricao->id) }}" class="btn btn-primary">
                    <i class="fas fa-qrcode"></i> QR Code
                </a>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-calendar-check me-1"></i>
                            Encontros ({{ $presentes }}/{{ $totalEncontros }})
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Data</th>
                                    <th>Horário</th>
                                    <th>Conteúdo</th>
                                    <th class="text-center">Presença</th>
                                    <th class="text-center">Avaliação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($curso->encontros as $i => $encontro)
                                    @php
                                        $freq = $frequencias->get($encontro->id);
                                    @endphp
                                    <tr class="{{ $freq ? 'table-success' : '' }}">
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($encontro->data)->format('d/m/Y') }}</td>
                                        <td>{{ $freq ? $freq->created_at->format('H:i:s') : '-' }}</td>
                                        <td>{{ $encontro->conteudo ?? '-' }}</td>
                                        <td class="text-center">
                                            @if($freq)
                                                <span class="badge bg-success"><i class="fas fa-check"></i> Presente</span>
                                            @else
                                                <span class="badge bg-secondary"><i class="fas fa-clock"></i> Pendente</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($freq)
                                                <button type="button" class="btn btn-sm {{ $freq->avaliacao_conteudo > 0 ? 'btn-outline-warning' : 'btn-warning' }}" data-bs-toggle="modal" data-bs-target="#avaliarModal{{ $freq->id }}">
                                                    <i class="fas fa-edit"></i> {{ $freq->avaliacao_conteudo > 0 ? 'Reavaliar' : 'Avaliar' }}
                                                </button>
                                                    @if($freq->avaliacao_conteudo > 0 && $freq->avaliacao_metodologia > 0)
                                                    @php $media = round(($freq->avaliacao_conteudo + $freq->avaliacao_metodologia) / 2); @endphp
                                                    <br><small class="fw-medium" style="font-size: 1.1rem;">
                                                        @for($s = 1; $s <= 5; $s++)<span class="{{ $s <= $media ? 'text-warning' : 'text-secondary' }}">★</span>@endfor
                                                        <span class="text-secondary ms-1 small">({{ $media }}/5)</span>
                                                    </small>
                                                @endif
                                            @else
                                                <span class="text-secondary small">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="fas fa-chart-pie me-1"></i> Progresso</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="display-4 fw-bold text-primary mb-2">{{ $percentual }}%</div>
                        <div class="progress mb-3" style="height: 12px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentual }}%"
                                 aria-valuenow="{{ $percentual }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <p class="text-secondary small mb-0">
                            {{ $presentes }} de {{ $totalEncontros }} encontros
                        </p>
                        <p class="text-secondary small">
                            Carga horária: {{ $curso->carga_horaria }}h
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($curso->encontros as $encontro)
    @php $freq = $frequencias->get($encontro->id); @endphp
    @if($freq)
    <div class="modal fade" id="avaliarModal{{ $freq->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('frequencias.avaliar', $freq->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Avaliar Formação</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Conteúdo <span class="text-danger">*</span></label>
                            <select name="avaliacao_conteudo" class="form-control" required>
                                <option value="">Selecione...</option>
                                @for($n = 1; $n <= 5; $n++)
                                    <option value="{{ $n }}" {{ $freq->avaliacao_conteudo == $n ? 'selected' : '' }}>
                                        @for($s = 1; $s <= $n; $s++)★@endfor
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Metodologia <span class="text-danger">*</span></label>
                            <select name="avaliacao_metodologia" class="form-control" required>
                                <option value="">Selecione...</option>
                                @for($n = 1; $n <= 5; $n++)
                                    <option value="{{ $n }}" {{ $freq->avaliacao_metodologia == $n ? 'selected' : '' }}>
                                        @for($s = 1; $s <= $n; $s++)★@endfor
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Comentários</label>
                            <textarea name="comentarios" class="form-control" rows="3">{{ $freq->comentarios }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar Avaliação</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endforeach
@endsection

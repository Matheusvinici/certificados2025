<div>
    <form method="GET" action="{{ route('inscricoes.index') }}" class="row g-2 mb-3" wire:submit.prevent>
        <div class="col-md-4">
            <input
                type="text"
                wire:model.live.debounce.300ms="busca"
                class="form-control"
                placeholder="Pesquise o nome do servidor..."
            >
        </div>
        <div class="col-md-4">
            <select wire:model.live="cursoId" class="form-control">
                <option value="">Todos os cursos</option>
                @foreach($cursos as $curso)
                    <option value="{{ $curso->id }}">{{ $curso->nome }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-4 col-md-2">
            <button type="button" wire:click="limpar" class="btn btn-outline-secondary w-100">Limpar</button>
        </div>
    </form>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-users text-primary me-2"></i>Inscrições
                @if(strlen($busca) >= 2)
                    <small class="text-muted">— resultados para "{{ $busca }}"</small>
                @endif
            </h5>
        </div>
        <div class="card-body p-0 p-md-3">
            @if($inscricoes->isEmpty())
                <p class="p-3 mb-0">Nenhuma inscrição encontrada.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>QR Code</th>
                                <th>Servidor</th>
                                <th>Curso</th>
                                <th class="text-center">Frequência</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inscricoes as $inscricao)
                                @php
                                    $emListaEspera = $inscricao->status === 'lista_espera';
                                    $totalEnc = $inscricao->curso->encontros->count();
                                    $freqCount = \App\Models\Frequencia::where('user_id', $inscricao->user_id)
                                        ->whereIn('encontro_id', $inscricao->curso->encontros->pluck('id'))
                                        ->count();
                                    $percFreq = $totalEnc > 0 ? round(($freqCount / $totalEnc) * 100) : 0;
                                @endphp
                                <tr wire:key="insc-{{ $inscricao->id }}">
                                    <td class="align-middle text-center">
                                        @if($emListaEspera)
                                            <span class="text-muted">—</span>
                                        @else
                                            <div class="qr-inscricao" data-id="{{ $inscricao->id }}"
                                                 onclick="ampliarQR({{ $inscricao->id }})"
                                                 style="cursor: pointer;" title="Clique para ampliar"></div>
                                        @endif
                                    </td>
                                    <td class="align-middle">{{ $inscricao->user->name }}</td>
                                    <td class="align-middle">
                                        {{ $inscricao->curso->nome }}
                                        @if($emListaEspera)
                                            <span class="badge bg-warning d-inline-block mt-1" style="color: #000; font-weight: 600;">
                                                Lista de espera
                                            </span>
                                        @endif
                                    </td>
                                    <td class="align-middle" style="min-width: 120px;">
                                        @if($emListaEspera)
                                            <span class="text-muted small">Aguarde vaga</span>
                                        @else
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress flex-grow-1" style="height: 8px;">
                                                    <div class="progress-bar {{ $percFreq >= 100 ? 'bg-success' : ($percFreq >= 50 ? 'bg-warning' : 'bg-secondary') }}"
                                                         style="width: {{ $percFreq }}%"></div>
                                                </div>
                                                <small class="fw-medium {{ $percFreq >= 100 ? 'text-success' : 'text-secondary' }}">
                                                    {{ $percFreq }}%
                                                </small>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex flex-wrap gap-1 justify-content-center">
                                            @if(!$emListaEspera)
                                            <a href="{{ route('inscricoes.frequencias', $inscricao->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-star"></i> Avaliação
                                            </a>
                                            @endif
                                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleteInscricao({{ $inscricao->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($inscricoes->hasPages())
                    <div class="p-3">
                        {{ $inscricoes->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

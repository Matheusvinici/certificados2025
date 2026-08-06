<div>
    <form method="GET" action="{{ route('cursos.index') }}" class="row g-2 mb-3" wire:submit.prevent>
        <div class="col-md-5">
            <input
                type="text"
                wire:model.live.debounce.300ms="busca"
                class="form-control"
                placeholder="Pesquise por nome do curso ou formador..."
            >
        </div>
        <div class="col-4 col-md-2">
            <button type="submit" class="btn btn-primary w-100" disabled style="display: none;"></button>
        </div>
        @if(strlen($busca) >= 2)
            <div class="col-4 col-md-2">
                <button type="button" wire:click="limpar" class="btn btn-outline-secondary w-100">Limpar</button>
            </div>
        @endif
    </form>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-graduation-cap text-primary me-2"></i>Lista de Cursos
                @if(strlen($busca) >= 2)
                    <small class="text-muted">— resultados para "{{ $busca }}"</small>
                @endif
            </h5>
        </div>
        <div class="card-body p-0 p-md-3">
            @if($cursos->isEmpty())
                <p class="p-3 mb-0">Nenhum curso encontrado.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nome do Curso</th>
                                <th>Formador</th>
                                <th class="text-center">Vagas</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Data de Início</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cursos as $curso)
                                <tr wire:key="curso-{{ $curso->id }}">
                                    <td>{{ $curso->nome }}</td>
                                    <td>
                                        @forelse($curso->formadores as $f)
                                            <span class="badge bg-info text-dark mr-1">{{ $f->name }}</span>
                                        @empty
                                            <span class="text-muted">Não vinculado</span>
                                        @endforelse
                                    </td>
                                    <td class="text-center">{{ $curso->vagas ?? 'Ilimitadas' }}</td>
                                    <td class="text-center">
                                        @if($curso->status == 'validado')
                                            <span class="badge bg-success">Validado</span>
                                        @else
                                            <span class="badge bg-warning" style="color: #000;">Pendente</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($curso->data_inicio)->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <div class="d-flex flex-wrap gap-1 justify-content-center">
                                            <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('cursos.duplicar', $curso) }}" method="POST" class="d-inline" onsubmit="return confirm('Duplicar este curso com todos os temas?')">
                                                @csrf
                                                <button type="submit" class="btn btn-secondary btn-sm" title="Duplicar com os temas">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </form>
                                            @if($curso->status != 'validado')
                                                <form action="{{ route('cursos.validar', $curso) }}" method="POST" class="d-inline" onsubmit="return confirm('Validar este curso? Ele ficará disponível para inscrições.')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm" title="Validar">
                                                        <i class="fas fa-check-circle"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('cursos.reabrir', $curso) }}" method="POST" class="d-inline" onsubmit="return confirm('Desfazer a validação? O curso sairá das inscrições.')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning btn-sm" title="Desfazer">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $curso->id }})" title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                            <form id="delete-form-{{ $curso->id }}" action="{{ route('cursos.destroy', $curso->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($cursos->hasPages())
                    <div class="p-3">
                        {{ $cursos->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

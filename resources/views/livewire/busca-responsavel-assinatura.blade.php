<div>
    @foreach($detalhes as $d)
        <input type="hidden" name="responsaveis_assinatura[]" value="{{ $d['id'] }}" wire:key="hr-{{ $d['id'] }}">
    @endforeach

    <div class="d-flex flex-wrap gap-1 mb-2">
        @forelse($detalhes as $d)
            <span class="badge rounded-pill" wire:key="chipr-{{ $d['id'] }}"
                  style="background: #dcfce7; color: #166534; font-size: .85rem; padding: .5em .8em; display: inline-flex; align-items: center; gap: .4rem;">
                <i class="fas fa-pen-nib"></i> {{ $d['name'] }}
                @if(in_array((int) $d['id'], array_map('intval', $facilitadoresIds)))
                    <span class="badge badge-success">Facilitador(a)</span>
                @endif
                <button type="button" class="btn btn-sm btn-link p-0" wire:click="remover({{ $d['id'] }})"
                        style="color: #15803d;" title="Remover responsável">
                    <i class="fas fa-times"></i>
                </button>
            </span>
        @empty
            <span class="text-muted small">Nenhum responsável pela assinatura selecionado.</span>
        @endforelse
    </div>

    <div class="input-group">
        <input type="text" wire:model.live.debounce.300ms="busca"
            class="form-control"
            placeholder="Buscar por nome ou CPF (somente quem já tem assinatura cadastrada)..."
            autocomplete="off">
        @if($busca)
            <button type="button" class="btn btn-outline-secondary" wire:click="$set('busca', '')">
                <i class="fas fa-times"></i>
            </button>
        @endif
    </div>

    @if($mostrarResultados && count($resultados) > 0)
        <ul class="list-group mt-1" style="max-height: 220px; overflow-y: auto; position: relative; z-index: 10;">
            @foreach($resultados as $u)
                <li class="list-group-item list-group-item-action" style="cursor: pointer;"
                    wire:click="adicionar({{ $u['id'] }})">
                    <div class="fw-semibold">
                        {{ $u['name'] }}
                        @if($u['facilitador'])
                            <span class="badge badge-success">Facilitador(a)</span>
                        @endif
                    </div>
                    <small class="text-secondary">CPF: {{ $u['cpf'] }} · Tem assinatura</small>
                </li>
            @endforeach
        </ul>
    @endif
</div>

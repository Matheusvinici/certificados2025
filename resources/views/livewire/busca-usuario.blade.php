<div>
    <input type="hidden" name="user_assinatura_id" value="{{ $usuarioSelecionadoId }}">
    <div class="input-group">
        <input type="text" wire:model.live.debounce.300ms="busca"
            class="form-control"
            placeholder="Buscar por nome ou CPF..."
            autocomplete="off">
        @if($busca)
            <button type="button" class="btn btn-outline-secondary" wire:click="limpar">
                <i class="fas fa-times"></i>
            </button>
        @endif
    </div>

    @if($mostrarResultados && count($resultados) > 0)
        <ul class="list-group mt-1" style="max-height:220px; overflow-y:auto; position:relative; z-index:10;">
            @foreach($resultados as $u)
                <li class="list-group-item list-group-item-action" style="cursor:pointer;"
                    wire:click="selecionar({{ $u['id'] }})">
                    <div class="fw-semibold">{{ $u['name'] }}</div>
                    <small class="text-secondary">CPF: {{ $u['cpf'] }} · Cargo: {{ $u['role'] }}</small>
                </li>
            @endforeach
        </ul>
    @endif

    @if($resultado && !$mostrarResultados)
        <div class="mt-2 p-2 rounded" style="background: rgba(79,70,229,0.06); border: 1px solid rgba(79,70,229,0.15);">
            <div class="fw-semibold">{{ $resultado['name'] }}</div>
            <small class="text-secondary">CPF: {{ $resultado['cpf'] }} · Cargo: {{ $resultado['role'] }}</small>
        </div>
    @endif
</div>

@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Horários do Curso</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('formador.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="card {{ $curso->status == 'validado' ? 'border-success' : 'border-primary' }}" style="border-width: 2px;">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-calendar-alt"></i> {{ $curso->nome }}
                        </h3>
                        <div class="card-tools">
                            @if($curso->status == 'validado')
                                <span class="badge badge-success"><i class="fas fa-check-circle"></i> Validado — horários somente leitura</span>
                            @else
                                <span class="badge badge-warning"><i class="fas fa-hourglass-half"></i> Aguardando validação do administrador</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        @if($curso->status == 'validado')
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Data</th>
                                        <th>Tema</th>
                                        <th>Horário</th>
                                        <th>Carga Horária</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($encontros as $index => $encontro)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($encontro->data)->format('d/m/Y') }}</td>
                                            <td>{{ $encontro->conteudo }}</td>
                                            <td>
                                                {{ $encontro->hora_inicio ? \Carbon\Carbon::parse($encontro->hora_inicio)->format('H:i') . ' às ' . \Carbon\Carbon::parse($encontro->hora_fim)->format('H:i') : '—' }}
                                            </td>
                                            <td>{{ $encontro->carga_horaria_encontro }} hora(s)</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-center">Nenhum encontro cadastrado.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <p class="mb-0"><strong>Vagas:</strong> {{ $curso->vagas ? $curso->vagas . ' inscrições' : 'Não definida' }}</p>
                        @else
                            <form action="{{ route('formador.horarios.store', $curso) }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="vagas">Quantidade de Inscritos (vagas) para este curso</label>
                                    <input type="number" name="vagas" id="vagas" min="1" value="{{ $curso->vagas }}"
                                        class="form-control" style="max-width: 250px;"
                                        placeholder="Deixe vazio para o administrador definir">
                                </div>

                                <h4 class="mt-4">Dias, Temas e Horários dos Encontros</h4>
                                <div id="encontros-container">
                                    @forelse($encontros as $index => $encontro)
                                        <div class="row encontro-item mt-3">
                                            <div class="col-md-3 form-group">
                                                <label>Data</label>
                                                <input type="date" name="encontros[{{ $index }}][data]" class="form-control" value="{{ $encontro->data }}" required>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label>Tema do Encontro</label>
                                                <input type="text" name="encontros[{{ $index }}][conteudo]" class="form-control" value="{{ $encontro->conteudo }}" required placeholder="Ex: Abertura e apresentação do curso">
                                            </div>
                                            <div class="col-md-2 form-group">
                                                <label>Hora Início</label>
                                                <input type="time" name="encontros[{{ $index }}][hora_inicio]" class="form-control" value="{{ $encontro->hora_inicio ? substr($encontro->hora_inicio, 0, 5) : '' }}" required>
                                            </div>
                                            <div class="col-md-2 form-group">
                                                <label>Hora Término</label>
                                                <input type="time" name="encontros[{{ $index }}][hora_fim]" class="form-control" value="{{ $encontro->hora_fim ? substr($encontro->hora_fim, 0, 5) : '' }}" required>
                                            </div>
                                            <div class="col-md-1 form-group">
                                                <label>Carga Horária</label>
                                                <select name="encontros[{{ $index }}][carga_horaria_encontro]" class="form-control" required>
                                                    @for ($i = 1; $i <= 16; $i++)
                                                        <option value="{{ $i }}" {{ $encontro->carga_horaria_encontro == $i ? 'selected' : '' }}>
                                                            {{ $i }}h
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="row encontro-item mt-3">
                                            <div class="col-md-3 form-group">
                                                <label>Data</label>
                                                <input type="date" name="encontros[0][data]" class="form-control" required>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label>Tema do Encontro</label>
                                                <input type="text" name="encontros[0][conteudo]" class="form-control" required placeholder="Ex: Abertura e apresentação do curso">
                                            </div>
                                            <div class="col-md-2 form-group">
                                                <label>Hora Início</label>
                                                <input type="time" name="encontros[0][hora_inicio]" class="form-control" required>
                                            </div>
                                            <div class="col-md-2 form-group">
                                                <label>Hora Término</label>
                                                <input type="time" name="encontros[0][hora_fim]" class="form-control" required>
                                            </div>
                                            <div class="col-md-1 form-group">
                                                <label>Carga Horária</label>
                                                <select name="encontros[0][carga_horaria_encontro]" class="form-control" required>
                                                    @for ($i = 1; $i <= 16; $i++)
                                                        <option value="{{ $i }}" {{ $i == 4 ? 'selected' : '' }}>{{ $i }}h</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>

                                <button type="button" id="add-encontro" class="btn btn-info mt-3">
                                    <i class="fas fa-plus"></i> Adicionar Novo Encontro
                                </button>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Salvar Horários
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($curso->status != 'validado')
<script>
    let encontroCount = {{ $encontros->count() ?: 1 }};

    document.getElementById('add-encontro').addEventListener('click', function() {
        const container = document.getElementById('encontros-container');
        const newEncontro = document.createElement('div');
        newEncontro.classList.add('row', 'encontro-item', 'mt-3');
        newEncontro.innerHTML = `
            <div class="col-md-3 form-group">
                <label>Data</label>
                <input type="date" name="encontros[${encontroCount}][data]" class="form-control" required>
            </div>
            <div class="col-md-4 form-group">
                <label>Tema do Encontro</label>
                <input type="text" name="encontros[${encontroCount}][conteudo]" class="form-control" required placeholder="Ex: Abertura e apresentação do curso">
            </div>
            <div class="col-md-2 form-group">
                <label>Hora Início</label>
                <input type="time" name="encontros[${encontroCount}][hora_inicio]" class="form-control" required>
            </div>
            <div class="col-md-2 form-group">
                <label>Hora Término</label>
                <input type="time" name="encontros[${encontroCount}][hora_fim]" class="form-control" required>
            </div>
            <div class="col-md-1 form-group">
                <label>Carga Horária</label>
                <select name="encontros[${encontroCount}][carga_horaria_encontro]" class="form-control" required>
                    @for ($i = 1; $i <= 16; $i++)
                        <option value="{{ $i }}">{{ $i }}h</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-1 form-group">
                <label>&nbsp;</label>
                <button type="button" class="btn btn-danger btn-block remove-encontro">Remover</button>
            </div>
        `;
        container.appendChild(newEncontro);
        encontroCount++;
    });
    document.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('remove-encontro')) {
            event.target.closest('.encontro-item').remove();
        }
    });
</script>
@endif
@endsection

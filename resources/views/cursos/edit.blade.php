@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Editar Curso</h1>
                </div>
                <div class="col-sm-6 text-right">
                    @if($curso->status == 'validado')
                        <span class="badge badge-success badge-pill" style="font-size: 14px;">
                            <i class="fas fa-check-circle"></i> Validado
                        </span>
                    @else
                        <span class="badge badge-warning badge-pill" style="font-size: 14px;">
                            <i class="fas fa-hourglass-half"></i> Pendente de Validação
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                <div class="col-lg-12">

                    <!-- Validação -->
                    <div class="card {{ $curso->status == 'validado' ? 'border-success' : 'border-warning' }}" style="border-width: 2px;">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-clipboard-check"></i> Validação do Curso
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Formadores:</strong>
                                    <p class="mb-0">
                                        @forelse($curso->formadores as $f)
                                            <span class="badge badge-info mr-1">{{ $f->name }}</span>
                                        @empty
                                            Nenhum formador vinculado
                                        @endforelse
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <strong>Encontros cadastrados:</strong>
                                    <p class="mb-0">{{ $curso->encontros()->count() }}</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>Vagas:</strong>
                                    <p class="mb-0">{{ $curso->vagas ? $curso->vagas . ' inscrições' : 'Ilimitadas' }}</p>
                                </div>
                            </div>
                            <div class="mt-3">
                                @if($curso->status != 'validado')
                                    <form action="{{ route('cursos.validar', $curso) }}" method="POST" class="d-inline" onsubmit="return confirm('Validar este curso? Ele ficará disponível para inscrições.')">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check-circle"></i> Validar Curso
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('cursos.reabrir', $curso) }}" method="POST" class="d-inline" onsubmit="return confirm('Reabrir este curso para ajustes? Ele sairá das inscrições.')">
                                        @csrf
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fas fa-undo"></i> Reabrir para Ajustes
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Informações do Curso -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Informações do Curso</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('cursos.update', $curso->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="nome">Nome do Curso</label>
                                        <input placeholder="Digite o nome do curso" type="text" name="nome" id="nome" value="{{ $curso->nome }}" required
                                            class="form-control @error('nome') is-invalid @enderror">
                                        @error('nome')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="percentual">Percentual</label>
                                        <select name="percentual" id="percentual" class="form-control">
                                            @foreach([50, 60, 70, 75, 80, 90, 100] as $pct)
                                                <option value="{{ $pct }}" {{ $curso->percentual == $pct ? 'selected' : '' }}>{{ $pct }}%</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="data_inicio">Data de Início</label>
                                        <input type="date" name="data_inicio" id="data_inicio" value="{{ $curso->data_inicio }}" required
                                            class="form-control @error('data_inicio') is-invalid @enderror">
                                        @error('data_inicio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="data_fim">Data de Conclusão</label>
                                        <input type="date" name="data_fim" id="data_fim" value="{{ $curso->data_fim }}" required
                                            class="form-control @error('data_fim') is-invalid @enderror">
                                        @error('data_fim')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="data_inicio_inscricao">Início das Inscrições</label>
                                        <input type="date" name="data_inicio_inscricao" id="data_inicio_inscricao" value="{{ $curso->data_inicio_inscricao }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="data_fim_inscricao">Fim das Inscrições</label>
                                        <input type="date" name="data_fim_inscricao" id="data_fim_inscricao" value="{{ $curso->data_fim_inscricao }}"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="carga_horaria">Carga Horária</label>
                                        <select name="carga_horaria" id="carga_horaria" required class="form-control">
                                            @for ($i = 1; $i <= 100; $i++)
                                                <option value="{{ $i }}" {{ $curso->carga_horaria == $i ? 'selected' : '' }}>
                                                    {{ $i }} hora{{ $i > 1 ? 's' : '' }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="ativo">Status</label>
                                        <select name="ativo" id="ativo" class="form-control">
                                            <option value="1" {{ $curso->ativo == 1 ? 'selected' : '' }}>Ativo</option>
                                            <option value="0" {{ $curso->ativo == 0 ? 'selected' : '' }}>Inativo</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="vagas">Quantidade de Inscritos (vagas)</label>
                                        <input type="number" name="vagas" id="vagas" min="1" value="{{ $curso->vagas }}"
                                            class="form-control" placeholder="Deixe vazio para vagas ilimitadas">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Responsáveis pela Assinatura</label>
                                        <livewire:busca-responsavel-assinatura :selecionados="$curso->responsaveisAssinatura->pluck('id')" />
                                        <small class="text-muted">Somente servidores com assinatura cadastrada. Quem for marcado como Facilitador(a) nas Assinaturas vira formador(a) deste curso automaticamente.</small>
                                    </div>
                                </div>

                                <!-- Encontros -->
                                <div id="encontros-container">
                                    <h3 class="mt-4">Informações sobre Encontros</h3>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> Os encontros abaixo podem ter sido preenchidos pelo formador.
                                        Você, como administrador, pode ajustá-los ou cadastrá-los caso o formador ainda não tenha feito.
                                    </div>
                                    @foreach($curso->encontros as $index => $encontro)
                                        <div class="row encontro-item mt-4" id="encontro-{{ $index }}">
                                            <div class="col-md-3 form-group">
                                                <label>Data</label>
                                                <input type="date" name="encontros[{{ $index }}][data]" class="form-control" value="{{ $encontro->data }}">
                                            </div>
                                            <div class="col-md-5 form-group">
                                                <label>Tema do Encontro</label>
                                                <input type="text" name="encontros[{{ $index }}][conteudo]" class="form-control" value="{{ $encontro->conteudo }}">
                                            </div>
                                            <div class="col-md-2 form-group">
                                                <label>Hora Início</label>
                                                <input type="time" name="encontros[{{ $index }}][hora_inicio]" class="form-control" value="{{ $encontro->hora_inicio ? substr($encontro->hora_inicio, 0, 5) : '' }}">
                                            </div>
                                            <div class="col-md-2 form-group">
                                                <label>Hora Término</label>
                                                <input type="time" name="encontros[{{ $index }}][hora_fim]" class="form-control" value="{{ $encontro->hora_fim ? substr($encontro->hora_fim, 0, 5) : '' }}">
                                            </div>
                                            <div class="col-md-2 form-group">
                                                <label>Carga Horária</label>
                                                <select name="encontros[{{ $index }}][carga_horaria_encontro]" class="form-control">
                                                    @for ($i = 1; $i <= 16; $i++)
                                                        <option value="{{ $i }}" {{ $encontro->carga_horaria_encontro == $i ? 'selected' : '' }}>
                                                            {{ $i }} hora{{ $i > 1 ? 's' : '' }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-1 form-group">
                                                <label>&nbsp;</label>
                                                <button type="button" class="btn btn-danger btn-block remove-encontro" data-index="{{ $index }}">Remover</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <button type="button" id="add-encontro" class="btn btn-info mt-4">
                                    <i class="fas fa-plus"></i> Adicionar Novo Encontro
                                </button>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Atualizar Curso
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let encontroCount = {{ count($curso->encontros) }};

        document.getElementById('add-encontro').addEventListener('click', function() {
            const container = document.getElementById('encontros-container');
            const newEncontro = document.createElement('div');
            newEncontro.classList.add('row', 'encontro-item', 'mt-4');
            newEncontro.innerHTML = `
                <div class="col-md-3 form-group">
                    <label>Data</label>
                    <input type="date" name="encontros[${encontroCount}][data]" class="form-control">
                </div>
                <div class="col-md-5 form-group">
                    <label>Tema do Encontro</label>
                    <input type="text" name="encontros[${encontroCount}][conteudo]" class="form-control" placeholder="Digite o tema do Encontro">
                </div>
                <div class="col-md-2 form-group">
                    <label>Hora Início</label>
                    <input type="time" name="encontros[${encontroCount}][hora_inicio]" class="form-control">
                </div>
                <div class="col-md-2 form-group">
                    <label>Hora Término</label>
                    <input type="time" name="encontros[${encontroCount}][hora_fim]" class="form-control">
                </div>
                <div class="col-md-2 form-group">
                    <label>Carga Horária</label>
                    <select name="encontros[${encontroCount}][carga_horaria_encontro]" class="form-control">
                        @for ($i = 1; $i <= 16; $i++)
                            <option value="{{ $i }}">
                                {{ $i }} hora{{ $i > 1 ? 's' : '' }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-1 form-group">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-block remove-encontro" data-index="${encontroCount}">Remover</button>
                </div>
            `;
            container.appendChild(newEncontro);
            encontroCount++;
        });

        document.addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('remove-encontro')) {
                const index = event.target.getAttribute('data-index');
                const encontroItem = document.getElementById('encontro-' + index);
                if (encontroItem) {
                    encontroItem.remove();
                }
            }
        });
    </script>
@endsection

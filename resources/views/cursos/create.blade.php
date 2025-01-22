@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Cadastrar Curso') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <!-- Informações do Curso -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Informações do Curso</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('cursos.store') }}" method="POST" class="space-y-6">
                                @csrf

                                <div class="row">
                                    <!-- Nome do Curso -->
                                    <div class="col-md-6 form-group">
                                        <label for="nome">Nome do Curso</label>
                                        <input placeholder="Digite o nome do curso" type="text" name="nome" id="nome" required 
                                            class="form-control @error('nome') is-invalid @enderror">
                                        @error('nome')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Percentual -->
                                    <div class="col-md-6 form-group">
                                        <label for="percentual">Percentual</label>
                                        <select name="percentual" id="percentual" class="form-control">
                                            <option value="50">50%</option>
                                            <option value="60">60%</option>
                                            <option value="70" selected>70%</option>
                                            <option value="75">75%</option>
                                            <option value="80">80%</option>
                                            <option value="90">90%</option>
                                            <option value="100">100%</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Data de Início -->
                                    <div class="col-md-6 form-group">
                                        <label for="data_inicio">Data de Início</label>
                                        <input type="date" name="data_inicio" id="data_inicio" required 
                                            class="form-control @error('data_inicio') is-invalid @enderror">
                                        @error('data_inicio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Data de Conclusão -->
                                    <div class="col-md-6 form-group">
                                        <label for="data_fim">Data de Conclusão</label>
                                        <input type="date" name="data_fim" id="data_fim" required 
                                            class="form-control @error('data_fim') is-invalid @enderror">
                                        @error('data_fim')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Carga Horária -->
                                    <div class="col-md-6 form-group">
                                    <label for="carga_horaria">Carga Horária</label>
                                    <select name="carga_horaria" id="carga_horaria" required 
                                        class="form-control @error('carga_horaria') is-invalid @enderror">
                                        @for ($i = 1; $i <= 100; $i++)
                                            <option value="{{ $i }}" {{ $i == 40 ? 'selected' : '' }}>
                                                {{ $i }} hora{{ $i > 1 ? 's' : '' }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('carga_horaria')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>



                                    <!-- Status -->
                                    <div class="col-md-6 form-group">
                                        <label for="ativo">Status</label>
                                        <select name="ativo" id="ativo" class="form-control">
                                            <option value="1">Ativo</option>
                                            <option value="0">Inativo</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Encontros -->
                                <div id="encontros-container">
                                    <h3 class="mt-4">Informações sobre Encontros</h3>
                                    <div class="row encontro-item mt-4">
                                        <div class="col-md-4 form-group">
                                            <label for="encontros[0][conteudo]">Tema do Encontro</label>
                                            <input placeholder="Digite o tema do Encontro" type="text" name="encontros[0][conteudo]" class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="encontros[0][data]">Data</label>
                                            <input type="date" name="encontros[0][data]" class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                    <label for="encontros[0][carga_horaria_encontro]">Carga Horária</label>
                                    <select name="encontros[0][carga_horaria_encontro]" class="form-control">
                                        @for ($i = 1; $i <= 16; $i++)
                                            <option value="{{ $i }}" {{ $i == 4 ? 'selected' : '' }}>
                                                {{ $i }} hora{{ $i > 1 ? 's' : '' }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                    </div>
                                </div>

                                <button type="button" id="add-encontro" class="btn btn-info mt-4">
                                    Adicionar Novo Encontro
                                </button>

                                <!-- Botão de Enviar -->
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        Salvar Curso
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->

    <script>
        let encontroCount = 1;
        document.getElementById('add-encontro').addEventListener('click', function() {
            const container = document.getElementById('encontros-container');
            const newEncontro = document.createElement('div');
            newEncontro.classList.add('row', 'encontro-item', 'mt-4');
            newEncontro.innerHTML = `
          <div class="col-md-4 form-group">
                <label for="encontros[${encontroCount}][conteudo]">Tema do Encontro</label>
                <input type="text" 
                    name="encontros[${encontroCount}][conteudo]" 
                    class="form-control" 
                    placeholder="Digite o tema do Encontro">
            </div>
            <div class="col-md-4 form-group">
                <label for="encontros[${encontroCount}][data]">Data</label>
                <input type="date" 
                    name="encontros[${encontroCount}][data]" 
                    class="form-control">
            </div>
            <div class="col-md-4 form-group">
                <label for="encontros[${encontroCount}][carga_horaria_encontro]">Carga Horária</label>
                <select name="encontros[${encontroCount}][carga_horaria_encontro]" 
                        class="form-control">
                    @for ($i = 1; $i <= 16; $i++)
                        <option value="{{ $i }}" {{ $i == 4 ? 'selected' : '' }}>
                            {{ $i }} hora{{ $i > 1 ? 's' : '' }}
                        </option>
                    @endfor
                </select>
            </div>

            `;
            container.appendChild(newEncontro);
            encontroCount++;
        });
    </script>

@endsection

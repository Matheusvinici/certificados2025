@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Certificados Gerados</h1>

    <!-- Filtros -->
    <form method="GET" action="{{ route('certificados.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input 
                    type="text" 
                    name="user" 
                    class="form-control" 
                    placeholder="Pesquise o nome do Servidor" 
                    value="{{ request('user') }}"
                >
            </div>
            <div class="col-md-4">
                <select name="curso" class="form-control">
                    <option value="">Filtrar Certificados por Curso</option>
                    @foreach ($cursos as $curso)
                        <option value="{{ $curso->id }}" 
                            {{ request('curso') == $curso->id ? 'selected' : '' }}>
                            {{ $curso->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>

    <!-- Mensagem de Quantitativo de Certificados -->
    @if(request('curso') && isset($certificadosCount))
        <div class="alert alert-info">
            O curso selecionado possui <strong>{{ $certificadosCount }}</strong> certificados gerados.
        </div>
    @endif

    <!-- Exibir o botão para gerar novos certificados apenas para o admin -->
    @if(auth()->user()->role == 'admin')
        <a href="{{ route('certificados.create') }}" class="btn btn-primary mb-3">Gerar Novos Certificados</a>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Curso</th>
                <th>Servidor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($certificados as $certificado)
                <tr>
                    <td>{{ $certificado->id }}</td>
                    <td>{{ $certificado->curso->nome }}</td>
                    <td>{{ $certificado->user->name }}</td>
                    <td>
                        <!-- Botão para imprimir o certificado -->
                        <a href="{{ route('certificados.gerarPdf', $certificado->id) }}" class="btn btn-primary">
                            Imprimir Certificado
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

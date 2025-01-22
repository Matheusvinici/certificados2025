@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Certificados Gerados</h1>

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
                <th>Usuário</th>
                <th>Status de Emissão</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($certificados as $certificado)
                <tr>
                    <td>{{ $certificado->id }}</td>
                    <td>{{ $certificado->curso->nome }}</td>
                    <td>{{ $certificado->user->name }}</td>
                    <td>{{ $certificado->emitido ? 'Emitido' : 'Não Emitido' }}</td>
                    <td>
                        <!-- Botão para imprimir o certificado -->
                        <a href="{{ route('certificados.gerarPdf', $certificado->id) }}" class="btn btn-success">
                            Imprimir Certificado
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

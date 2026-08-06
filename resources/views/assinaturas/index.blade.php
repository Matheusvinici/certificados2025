@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('Assinaturas') }}</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('assinaturas.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nova Assinatura
                </a>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card mb-3">
            <div class="card-body py-2">
                <form method="GET" action="{{ route('assinaturas.index') }}" class="row g-2 align-items-center">
                    <div class="col-md-6 col-lg-4">
                        <input type="text" name="busca" value="{{ request('busca') }}" class="form-control"
                               placeholder="Buscar por nome, cargo ou secretaria...">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                        @if(request('busca'))
                            <a href="{{ route('assinaturas.index') }}" class="btn btn-secondary">Limpar</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        @if($assinaturas->isEmpty())
            <div class="alert alert-info text-center py-4">
                Nenhuma assinatura cadastrada ainda.
                <a href="{{ route('assinaturas.create') }}">Cadastrar a primeira</a>.
            </div>
        @else
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-hover m-0 align-middle">
                    <thead>
                        <tr>
                            <th style="width: 90px;">Foto</th>
                            <th>Nome</th>
                            <th>Cargo</th>
                            <th>Secretaria</th>
                            <th>Cadastrado em</th>
                            <th class="text-right" style="width: 120px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assinaturas as $assinatura)
                        <tr>
                            <td>
                                <img src="{{ asset('storage/' . $assinatura->foto) }}"
                                     alt="{{ $assinatura->nome }}"
                                     class="img-thumbnail"
                                     style="width: 70px; height: 45px; object-fit: contain; background: #fff;">
                            </td>
                            <td class="fw-medium">
                                {{ $assinatura->nome }}
                                @if($assinatura->facilitador)
                                    <span class="badge badge-success">Facilitador(a)</span>
                                @endif
                            </td>
                            <td>{{ $assinatura->cargo ?: '-' }}</td>
                            <td>{{ $assinatura->secretaria ?: '-' }}</td>
                            <td>{{ $assinatura->created_at->format('d/m/Y') }}</td>
                            <td class="text-right">
                                <a href="{{ route('assinaturas.edit', $assinatura) }}" class="btn btn-sm btn-primary" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('assinaturas.destroy', $assinatura) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir esta assinatura?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

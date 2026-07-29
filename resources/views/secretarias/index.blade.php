@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('Secretarias') }}</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('secretarias.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nova Secretaria
                </a>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-hover m-0">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th class="text-right" style="width: 120px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($secretarias as $secretaria)
                        <tr>
                            <td class="fw-medium">{{ $secretaria->nome }}</td>
                            <td>{{ $secretaria->descricao ?? '-' }}</td>
                            <td class="text-right">
                                <a href="{{ route('secretarias.edit', $secretaria) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('secretarias.destroy', $secretaria) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir esta secretaria?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-secondary py-4">Nenhuma secretaria cadastrada.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($secretarias->hasPages())
            <div class="card-footer clearfix">
                {{ $secretarias->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('Editar Secretaria') }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('secretarias.update', $secretaria) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Nome <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome', $secretaria->nome) }}" required>
                                @error('nome')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label class="form-label">Descrição</label>
                                <textarea class="form-control @error('descricao') is-invalid @enderror" name="descricao" rows="3">{{ old('descricao', $secretaria->descricao) }}</textarea>
                                @error('descricao')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Salvar alterações</button>
                        <a href="{{ route('secretarias.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

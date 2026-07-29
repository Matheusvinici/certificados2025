@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('Criar Permissão') }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('permissions.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nome da Permissão</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required placeholder="ex: cursos.create">
                                @error('name')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                            <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
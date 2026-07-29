@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('Novo Servidor') }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Nome <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                                @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                                @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">CPF <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" id="cpf" value="{{ old('cpf') }}" required maxlength="14" oninput="mascaraCPF(this)" placeholder="000.000.000-00">
                                @error('cpf')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Matrícula <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('matricula') is-invalid @enderror" name="matricula" value="{{ old('matricula') }}" required placeholder="Número da matrícula">
                                @error('matricula')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Senha <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Secretaria</label>
                                <select class="form-control @error('secretaria') is-invalid @enderror" name="secretaria">
                                    <option value="">Selecione...</option>
                                    @foreach($secretarias as $s)
                                    <option value="{{ $s->nome }}" {{ old('secretaria') == $s->nome ? 'selected' : '' }}>{{ $s->nome }}</option>
                                    @endforeach
                                </select>
                                @error('secretaria')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <h5 class="mt-4 mb-3">Papéis de Acesso</h5>
                    <p class="text-secondary small mb-3">Selecione um ou mais papéis que definem as permissões do usuário.</p>
                    <div class="row">
                        @foreach($roles as $role)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->id }}">
                                <label class="form-check-label fw-medium" for="role_{{ $role->id }}">{{ $role->name }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
function mascaraCPF(input) {
    let v = input.value.replace(/\D/g, '');
    v = v.replace(/^(\d{3})(\d)/, '$1.$2');
    v = v.replace(/^(\d{3}\.\d{3})(\d)/, '$1.$2');
    v = v.replace(/^(\d{3}\.\d{3}\.\d{3})(\d)/, '$1-$2');
    input.value = v;
}
</script>
@endsection

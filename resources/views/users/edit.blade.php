@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('Editar Servidor') }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Nome <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">CPF <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" id="cpf" value="{{ old('cpf', $user->cpf ? substr($user->cpf, 0, 3) . '.' . substr($user->cpf, 3, 3) . '.' . substr($user->cpf, 6, 3) . '-' . substr($user->cpf, 9, 2) : '') }}" required maxlength="14" oninput="mascaraCPF(this)" placeholder="000.000.000-00">
                                @error('cpf')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Matrícula <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('matricula') is-invalid @enderror" name="matricula" value="{{ old('matricula', $user->matricula) }}" required placeholder="Número da matrícula">
                                @error('matricula')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Nova Senha (deixe em branco para manter)</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Cargo</label>
                                <input type="text" class="form-control @error('cargo') is-invalid @enderror" name="cargo" value="{{ old('cargo', $user->cargo) }}" placeholder="Ex.: Secretário(a), Coordenador(a)...">
                                @error('cargo')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Secretaria</label>
                                <select class="form-control @error('secretaria') is-invalid @enderror" name="secretaria">
                                    <option value="">Selecione...</option>
                                    @foreach($secretarias as $s)
                                    <option value="{{ $s->nome }}" {{ old('secretaria', $user->secretaria) == $s->nome ? 'selected' : '' }}>{{ $s->nome }}</option>
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
                                <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->id }}" {{ in_array($role->name, $userRoles) ? 'checked' : '' }}>
                                <label class="form-check-label fw-medium" for="role_{{ $role->id }}">{{ $role->name }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Salvar alterações</button>
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

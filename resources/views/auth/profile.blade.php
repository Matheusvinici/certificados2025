@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Meu Perfil</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Dados Cadastrais -->
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="fas fa-id-card mr-2"></i>Dados Cadastrais</h5>
                        </div>

                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nome Completo</label>
                                        <div class="input-group">
                                            <input type="text" name="name"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   value="{{ old('name', auth()->user()->name) }}" required>
                                            <div class="input-group-append">
                                                <div class="input-group-text"><span class="fas fa-user"></span></div>
                                            </div>
                                        </div>
                                        @error('name')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">E-mail</label>
                                        <div class="input-group">
                                            <input type="email" name="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   value="{{ old('email', auth()->user()->email) }}" required>
                                            <div class="input-group-append">
                                                <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                                            </div>
                                        </div>
                                        @error('email')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">CPF</label>
                                        <div class="input-group">
                                            <input type="text" name="cpf"
                                                   class="form-control @error('cpf') is-invalid @enderror"
                                                   value="{{ old('cpf', auth()->user()->cpf) }}"
                                                   placeholder="Apenas números" maxlength="11">
                                            <div class="input-group-append">
                                                <div class="input-group-text"><span class="fas fa-id-badge"></span></div>
                                            </div>
                                        </div>
                                        @error('cpf')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Matrícula</label>
                                        <div class="input-group">
                                            <input type="text" name="matricula"
                                                   class="form-control @error('matricula') is-invalid @enderror"
                                                   value="{{ old('matricula', auth()->user()->matricula) }}"
                                                   placeholder="Sua matrícula">
                                            <div class="input-group-append">
                                                <div class="input-group-text"><span class="fas fa-hashtag"></span></div>
                                            </div>
                                        </div>
                                        @error('matricula')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Secretaria</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control"
                                                   value="{{ auth()->user()->secretaria ?? '—' }}" disabled>
                                            <div class="input-group-append">
                                                <div class="input-group-text"><span class="fas fa-building"></span></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Perfil de Acesso</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control"
                                                   value="{{ ucfirst(auth()->user()->role) }}" disabled>
                                            <div class="input-group-append">
                                                <div class="input-group-text"><span class="fas fa-user-tag"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <h6 class="mb-3" style="font-weight: 600;"><i class="fas fa-lock mr-1"></i> Alterar Senha</h6>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nova Senha</label>
                                        <div class="input-group">
                                            <input type="password" name="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   placeholder="Deixe vazio para manter">
                                            <div class="input-group-append">
                                                <div class="input-group-text"><span class="fas fa-lock"></span></div>
                                            </div>
                                        </div>
                                        @error('password')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Confirmar Nova Senha</label>
                                        <div class="input-group">
                                            <input type="password" name="password_confirmation"
                                                   class="form-control"
                                                   placeholder="Confirme a nova senha"
                                                   autocomplete="new-password">
                                            <div class="input-group-append">
                                                <div class="input-group-text"><span class="fas fa-lock"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i> Salvar Alterações
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Resumo -->
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-user-circle" style="font-size: 4rem; color: var(--primary);"></i>
                            </div>
                            <h5>{{ auth()->user()->name }}</h5>
                            <p class="text-muted mb-1">{{ auth()->user()->email }}</p>
                            <span class="badge" style="background: var(--primary); color: #fff; font-size: 0.8rem;">
                                {{ ucfirst(auth()->user()->role) }}
                            </span>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-id-badge mr-2 text-muted"></i>CPF</span>
                                <span class="fw-semibold">{{ auth()->user()->cpf ?? '—' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-hashtag mr-2 text-muted"></i>Matrícula</span>
                                <span class="fw-semibold">{{ auth()->user()->matricula ?? '—' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-building mr-2 text-muted"></i>Secretaria</span>
                                <span class="fw-semibold">{{ auth()->user()->secretaria ?? '—' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@endsection

@section('scripts')
    @session('success')
        <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script>
            Toastify({
                text: "{{ $value }}",
                duration: 3000,
                close: true,
            }).showToast();
        </script>
    @endsession
@endsection

@extends('layouts.guest')

@section('content')
    <div class="card-body login-card-body">
        <p class="login-box-msg">{{ __('Realize o seu cadastro e tenha acesso aos encontros formativos e certificados') }}</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="input-group mb-3">
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       placeholder="{{ __('Digite seu nome completo') }}" required autocomplete="name" autofocus>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
                @error('name')
                <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group mb-3">
                <input type="text" name="cpf" id="cpf" class="form-control @error('cpf') is-invalid @enderror"
                       placeholder="{{ __('CPF') }}" required maxlength="14" oninput="mascaraCPF(this)">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-id-card"></span>
                    </div>
                </div>
                @error('cpf')
                <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group mb-3">
                <input type="text" name="matricula" class="form-control @error('matricula') is-invalid @enderror"
                       placeholder="{{ __('Matrícula') }}" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-hashtag"></span>
                    </div>
                </div>
                @error('matricula')
                <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group mb-3">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       placeholder="{{ __('Informe um e-mail válido') }}" required autocomplete="email">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                @error('email')
                <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <select name="secretaria" class="form-control @error('secretaria') is-invalid @enderror" required style="height: calc(2.25rem + 2px);">
                    <option value="" disabled selected>Selecione uma secretaria</option>
                    @foreach($secretarias as $s)
                    <option value="{{ $s->nome }}" {{ old('secretaria') == $s->nome ? 'selected' : '' }}>{{ $s->nome }}</option>
                    @endforeach
                </select>
                @error('secretaria')
                <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group mb-3">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                       placeholder="{{ __('Crie a sua senha') }}" required autocomplete="new-password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                @error('password')
                <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group mb-3">
                <input type="password" name="password_confirmation"
                       class="form-control @error('password_confirmation') is-invalid @enderror"
                       placeholder="{{ __('Confirme a senha') }}" required autocomplete="new-password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <button type="submit"
                            class="btn btn-primary btn-block">{{ __('Cadastre-se') }}</button>
                </div>
            </div>
        </form>
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

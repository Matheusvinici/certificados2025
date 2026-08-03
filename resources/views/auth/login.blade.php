@extends('layouts.guest')

@section('content')
    <div class="login-title">Inscrições e Certificados — EGESP</div>

    <form action="{{ route('login') }}" method="post">
        @csrf

        <div class="mb-3">
            <div class="input-group">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       placeholder="Email" required autofocus>
                <span class="input-group-text">
                    <i class="fas fa-envelope"></i>
                </span>
                @error('email')
                <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <div class="input-group">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                       placeholder="Senha" required>
                <span class="input-group-text">
                    <i class="fas fa-lock"></i>
                </span>
                @error('password')
                <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input type="checkbox" id="remember" name="remember" class="form-check-input">
                <label class="form-check-label" for="remember" style="font-size: 0.85rem;">Lembre-me</label>
            </div>
            <button type="submit" class="btn-login" style="width: auto; padding: 0.5rem 1.5rem;">Entrar</button>
        </div>
    </form>

    @if (Route::has('password.request'))
        <div class="text-center mb-3">
            <a href="{{ route('password.request') }}">Esqueceu sua senha?</a>
        </div>
    @endif

    <div class="divider"></div>

    <p class="text-center mb-3" style="font-size: 0.85rem; color: #64748b;">
        Se ainda não tem cadastro no sistema de certificados, cadastre-se clicando no botão abaixo.
    </p>
    <div class="text-center">
        <a href="{{ route('register') }}" class="btn-register">Cadastre-se</a>
    </div>
@endsection

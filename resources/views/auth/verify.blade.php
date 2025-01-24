@extends('layouts.app')

@section('content')
    <div class="card-body login-card-body">
        <p class="login-box-msg">{{ __('Verifique o seu endereço de e-mail') }}</p>

        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('Um novo link de verificação foi enviado para seu endereço de e-mail') }}
            </div>
        @endif

        {{ __('Antes de prosseguir, verifique seu e-mail para obter um link de verificação.') }}
        {{ __('Se você não recebeu o e-mail') }},
        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <div class="row">
                <div class="col-12">
                    <button type="submit"
                            class="btn btn-primary btn-block">{{ __('clique aqui para solicitar outro') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection

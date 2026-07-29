@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Sobre') }}</h1>
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
                            <h5 class="card-title">{{ __('Secretaria de Administração') }}</h5>
                            <br><br>
                            <p class="card-text" style="text-align: justify;">
                                {{ __('Sistema de inscrições em cursos, registro de frequência e emissão de certificados da Secretaria de Administração do Município de Juazeiro-BA.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
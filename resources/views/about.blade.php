@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Sobre nós') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Núcleo de Tecnologia Municipal (NTM)') }}</h5>
                            <br><br>
                            <p class="card-text" style="text-align: justify;">
                                {{ __('O Núcleo de Tecnologia Municipal (NTM) é um órgão vinculado à Secretaria Municipal de Educação e Juventude (SEDUC), com a missão de oferecer formação contínua em tecnologias educacionais à comunidade escolar. O NTM apoia o uso pedagógico de ferramentas digitais, visando potencializar a aprendizagem de conceitos em diversas áreas do conhecimento, além de fornecer suporte técnico em hardware e software. Sua atuação também envolve parcerias com instituições de ensino e universidades, expandindo o uso de tecnologias em comunidades e ampliando o acesso e a qualidade do ensino tecnológico.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection
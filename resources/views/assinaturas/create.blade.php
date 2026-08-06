@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('Cadastrar Assinatura') }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Dados da Assinatura</h3>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $erro)
                                        <li>{{ $erro }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('assinaturas.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="user_id">Servidor (de quem é a assinatura)</label>
                                <livewire:busca-usuario name="user_id" />
                                <small class="text-muted">Busque pelo nome ou CPF. O cargo e a secretaria são preenchidos automaticamente com os dados do servidor.</small>
                            </div>

                            <div class="form-group">
                                <label for="foto">Foto da Assinatura</label>
                                <input type="file" name="foto" id="foto" required accept="image/*"
                                    class="form-control-file">
                            </div>

                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" name="facilitador" id="facilitador" value="1"
                                    {{ old('facilitador') ? 'checked' : '' }}>
                                <label class="form-check-label" for="facilitador">
                                    É Facilitador(a) do curso?
                                </label>
                                <small class="d-block text-muted">Se marcado, o certificado/declaração mostrará "Facilitador(a)" abaixo da assinatura e a pessoa vira formador(a) automaticamente nos cursos em que for selecionada.</small>
                            </div>

                            <div class="mt-3">
                                <img id="preview" src="" alt="Pré-visualização"
                                     class="img-thumbnail" style="display: none; max-height: 160px; background: #fff;">
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">
                                <i class="fas fa-save"></i> Salvar Assinatura
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card" style="border: 2px solid #ffc107;">
                    <div class="card-header bg-warning">
                        <h3 class="card-title text-dark"><i class="fas fa-camera"></i> Orientações para a foto</h3>
                    </div>
                    <div class="card-body">
                        <ul class="mb-0" style="font-size: 0.95rem; line-height: 1.8;">
                            <li>Tire a foto da assinatura em uma <strong>folha de ofício branca</strong>.</li>
                            <li>Assine com <strong>caneta preta</strong>.</li>
                            <li>A assinatura deve ser feita <strong>sem traço/linha embaixo</strong>.</li>
                            <li>Capture <strong>apenas a parte branca da folha</strong>, sem outros objetos ou mãos na foto.</li>
                            <li>Prefira um ambiente com <strong>boa iluminação</strong> e foto nítida.</li>
                            <li>Formatos aceitos: <strong>JPG ou PNG</strong>, até 5MB.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('foto').addEventListener('change', function(e) {
        const preview = document.getElementById('preview');
        const file = e.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'inline-block';
        }
    });
</script>
@endsection

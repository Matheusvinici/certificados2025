@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar Frequência</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('frequencias.store', ['inscricaoId' => $inscricaoId]) }}">
        @csrf
        <div class="mb-3">
            <label for="hash" class="form-label">Código de Frequência</label>
            <input type="text" class="form-control" id="hash" name="hash" required>
        </div>

        <div class="mb-3">
            <label for="avaliacao_conteudo" class="form-label">Avaliação do Conteúdo</label>
            <select class="form-control" id="avaliacao_conteudo" name="avaliacao_conteudo" required>
                <option value="" selected disabled>Selecione uma nota</option>
                <option value="1">1 - Muito Ruim</option>
                <option value="2">2 - Ruim</option>
                <option value="3">3 - Regular</option>
                <option value="4">4 - Bom</option>
                <option value="5">5 - Excelente</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="avaliacao_metodologia" class="form-label">Avaliação da Metodologia</label>
            <select class="form-control" id="avaliacao_metodologia" name="avaliacao_metodologia" required>
                <option value="" selected disabled>Selecione uma nota</option>
                <option value="1">1 - Muito Ruim</option>
                <option value="2">2 - Ruim</option>
                <option value="3">3 - Regular</option>
                <option value="4">4 - Bom</option>
                <option value="5">5 - Excelente</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="comentarios" class="form-label">Comentários (opcional)</label>
            <textarea class="form-control" id="comentarios" name="comentarios" rows="4" placeholder="Deixe aqui seus comentários ou sugestões"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</div>
@endsection

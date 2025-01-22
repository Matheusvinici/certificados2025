@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gerar Certificados em Lote</h1>

    <form action="{{ route('certificados.gerar') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="curso_id">Selecione o Curso</label>
            <select name="curso_id" id="curso_id" class="form-control" required>
                <option value="">Selecione um curso</option>
                @foreach ($cursos as $curso)
                    <option value="{{ $curso->id }}">{{ $curso->nome }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Gerar Certificados</button>
    </form>
</div>
@endsection

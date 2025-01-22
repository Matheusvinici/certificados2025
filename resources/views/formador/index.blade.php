@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Selecione um Curso</h1>

    <form action="{{ route('formador.encontros') }}" method="GET">
        @csrf
        <div class="form-group">
            <label for="curso_id">Curso:</label>
            <select class="form-control" id="curso_id" name="curso_id" required>
                <option value="">Selecione um curso</option>
                @foreach($cursos as $curso)
                    <option value="{{ $curso->id }}">{{ $curso->nome }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Ver Encontros</button>
    </form>
</div>
@endsection

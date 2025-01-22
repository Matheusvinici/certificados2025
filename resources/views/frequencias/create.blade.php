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

        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Filtrar Frequência</h3>
    <form action="{{ route('relatorios.frequencia.gerar') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="curso_id">Curso:</label>
            <select id="curso_id" name="curso_id" class="form-control" onchange="atualizarEncontros()">
                <option value="">Selecione um curso</option>
                @foreach($cursos as $curso)
                    <option value="{{ $curso->id }}">{{ $curso->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="encontros">Encontros:</label>
            <select id="encontros" name="encontros[]" class="form-control" multiple>
                <!-- Encontros serão carregados via JavaScript -->
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>
</div>

<script>
    const cursos = @json($cursos);

    function atualizarEncontros() {
        const cursoId = document.getElementById('curso_id').value;
        const encontrosSelect = document.getElementById('encontros');
        encontrosSelect.innerHTML = '';

        if (cursoId) {
            const curso = cursos.find(c => c.id == cursoId);
            curso.encontros.forEach(encontro => {
                const option = document.createElement('option');
                option.value = encontro.id;
                option.textContent = `${encontro.conteudo} - ${encontro.data}`;
                encontrosSelect.appendChild(option);
            });
        }
    }
</script>
@endsection

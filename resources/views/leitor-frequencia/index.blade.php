@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Leitor de Frequência</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($cursos->isEmpty())
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-calendar-day" style="font-size: 2.5rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
                    <p class="text-secondary mb-0">Nenhum curso com encontro hoje.</p>
                </div>
            </div>
        @else
            <div class="row g-3">
                @foreach($cursos as $curso)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title fw-semibold">{{ $curso->nome }}</h5>
                                @foreach($curso->encontros as $encontro)
                                    <p class="text-secondary small mb-2">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ \Carbon\Carbon::parse($encontro->data)->format('d/m/Y') }}
                                        — {{ $encontro->conteudo }}
                                    </p>
                                @endforeach
                                <a href="{{ route('leitor-frequencia.scan', $curso->id) }}"
                                   class="btn btn-primary w-100 mt-2">
                                    <i class="fas fa-qrcode"></i> Iniciar Leitura
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Certificados') }}</h1>
                    <p class="text-secondary small mb-0">Acompanhe a emissão dos certificados por curso.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    @php
                        $isAdmin = auth()->user()->role == 'admin' || auth()->user()->hasAnyRole(['leitor-frequencia', 'super-admin']);
                    @endphp

                    @if($isAdmin)
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <a href="{{ route('certificados.create') }}" class="btn btn-dark">
                                <i class="fas fa-plus"></i> Gerar Novos Certificados
                            </a>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @elseif(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if($isAdmin)
                        <form method="GET" action="{{ route('certificados.index') }}" class="row g-2 mb-3">
                            <div class="col-md-4">
                                <input
                                    type="text"
                                    name="user"
                                    class="form-control"
                                    placeholder="Pesquise o nome do Servidor"
                                    value="{{ request('user') }}"
                                >
                            </div>
                            <div class="col-md-4">
                                <select name="curso" class="form-control">
                                    <option value="">Todos os cursos</option>
                                    @foreach ($cursos as $curso)
                                        <option value="{{ $curso->id }}"
                                            {{ request('curso') == $curso->id ? 'selected' : '' }}>
                                            {{ $curso->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4 col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                            </div>
                        </form>
                    @endif

                    @isset($dashboard)
                        <div class="row g-3 mb-3">
                            <div class="col-6 col-md-3">
                                <div class="card border-0 shadow-sm" style="border-left: 4px solid #4f46e5;">
                                    <div class="card-body py-3">
                                        <p class="text-muted small mb-1">Certificados Gerados</p>
                                        <p class="h4 mb-0 fw-bold">{{ $dashboard['totais']['gerados'] }}</p>
                                        <small class="text-success">disponíveis para imprimir</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="card border-0 shadow-sm" style="border-left: 4px solid #0ea5e9;">
                                    <div class="card-body py-3">
                                        <p class="text-muted small mb-1">Inscritos</p>
                                        <p class="h4 mb-0 fw-bold">{{ $dashboard['totais']['inscritos'] }}</p>
                                        <small class="text-muted">no(s) curso(s) filtrado(s)</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="card border-0 shadow-sm" style="border-left: 4px solid #22c55e;">
                                    <div class="card-body py-3">
                                        <p class="text-muted small mb-1">Fizeram Jus</p>
                                        <p class="h4 mb-0 fw-bold">{{ $dashboard['totais']['fizeramJus'] }}</p>
                                        <small class="text-muted">atingiram o mínimo de presença</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="card border-0 shadow-sm" style="border-left: 4px solid #f59e0b;">
                                    <div class="card-body py-3">
                                        <p class="text-muted small mb-1">Não Gerados</p>
                                        <p class="h4 mb-0 fw-bold">{{ $dashboard['naoGerados'] }}</p>
                                        <small class="text-muted">fizeram jus, sem certificado</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(!$dashboard['comFiltro'])
                            <div class="card shadow-sm mb-4">
                                <div class="card-header bg-white">
                                    <h5 class="mb-0"><i class="fas fa-award text-primary me-2"></i>Certificados por Curso</h5>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0 align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Curso</th>
                                                    <th class="text-center">Inscritos</th>
                                                    <th class="text-center">Fizeram Jus</th>
                                                    <th class="text-center">Gerados</th>
                                                    <th class="text-center">Não Gerados</th>
                                                    <th class="text-center">Emissão</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($dashboard['porCurso'] as $linha)
                                                    <tr>
                                                        <td>{{ $linha['curso'] }}</td>
                                                        <td class="text-center">{{ $linha['inscritos'] }}</td>
                                                        <td class="text-center">{{ $linha['fizeramJus'] }}</td>
                                                        <td class="text-center fw-semibold">{{ $linha['gerados'] }}</td>
                                                        <td class="text-center">
                                                            @if($linha['naoGerados'] > 0)
                                                                <span class="badge bg-warning" style="color: #000;">{{ $linha['naoGerados'] }}</span>
                                                            @else
                                                                <span class="text-muted">0</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center" style="min-width: 140px;">
                                                            @php
                                                                $perc = $linha['fizeramJus'] > 0 ? min(100, round(($linha['gerados'] / $linha['fizeramJus']) * 100)) : 0;
                                                                $barClass = $perc >= 100 ? 'bg-success' : ($perc >= 50 ? 'bg-warning' : 'bg-danger');
                                                            @endphp
                                                            <div class="d-flex align-items-center gap-2">
                                                                <div class="progress flex-grow-1" style="height: 8px;">
                                                                    <div class="progress-bar {{ $barClass }}" style="width: {{ $perc }}%"></div>
                                                                </div>
                                                                <small class="text-muted">{{ $perc }}%</small>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center text-muted py-3">Nenhum curso cadastrado.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endisset

                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="fas fa-list text-primary me-2"></i>Certificados Emitidos</h5>
                        </div>
                        <div class="card-body p-0 p-md-3">
                            @if($certificados->isEmpty() && !$isAdmin)
                                <div class="alert alert-info mb-0 m-3">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Seu certificado aparecerá automaticamente aqui assim que você atingir a carga horária mínima do curso.
                                </div>
                            @elseif($certificados->isEmpty())
                                <p class="p-3 mb-0">Nenhum certificado encontrado.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0 align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Curso</th>
                                                <th>Servidor</th>
                                                <th class="text-center">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($certificados as $certificado)
                                                <tr>
                                                    <td>{{ $certificado->id }}</td>
                                                    <td>{{ $certificado->curso->nome }}</td>
                                                    <td>{{ $certificado->user->name }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('certificados.gerarPdf', $certificado->id) }}" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-print"></i> Imprimir Certificado
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if($certificados->hasPages())
                                    <div class="p-3">
                                        {{ $certificados->links() }}
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

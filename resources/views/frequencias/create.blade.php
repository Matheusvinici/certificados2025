@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Registrar Frequência</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if($encontros->isEmpty())
                            <div class="text-center py-5">
                                <i class="fas fa-calendar-day" style="font-size: 2.5rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
                                <p class="text-secondary mb-1 fw-semibold">Nenhum encontro hoje</p>
                                <p class="text-secondary small mb-0">A frequência só pode ser registrada no dia do encontro.</p>
                            </div>
                        @else
                            @foreach($encontros as $encontro)
                                @php
                                    $frequenciaRegistrada = $frequencias->where('encontro_id', $encontro->id)->first();
                                @endphp

                                @if($frequenciaRegistrada)
                                    <div class="alert alert-success text-center mb-4">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Presença registrada em {{ \Carbon\Carbon::parse($encontro->data)->format('d/m/Y') }}
                                    </div>

                                    <form method="POST" action="{{ route('frequencias.avaliar', $frequenciaRegistrada->id) }}">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-3">
                                            <label for="avaliacao_conteudo" class="form-label fw-semibold">Conteúdo</label>
                                            <select class="form-control" id="avaliacao_conteudo" name="avaliacao_conteudo" required>
                                                <option value="" disabled>Selecione...</option>
                                                @for($n = 1; $n <= 5; $n++)
                                                <option value="{{ $n }}" {{ $frequenciaRegistrada->avaliacao_conteudo == $n ? 'selected' : '' }}>
                                                    @for($s = 1; $s <= $n; $s++)★@endfor
                                                </option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="avaliacao_metodologia" class="form-label fw-semibold">Metodologia</label>
                                            <select class="form-control" id="avaliacao_metodologia" name="avaliacao_metodologia" required>
                                                <option value="" disabled>Selecione...</option>
                                                @for($n = 1; $n <= 5; $n++)
                                                <option value="{{ $n }}" {{ $frequenciaRegistrada->avaliacao_metodologia == $n ? 'selected' : '' }}>
                                                    @for($s = 1; $s <= $n; $s++)★@endfor
                                                </option>
                                                @endfor
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="comentarios" class="form-label fw-semibold">Comentários (opcional)</label>
                                            <textarea class="form-control" id="comentarios" name="comentarios" rows="2"
                                                placeholder="Deixe aqui seus comentários ou sugestões">{{ $frequenciaRegistrada->comentarios }}</textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Salvar Avaliação
                                        </button>
                                    </form>
                                @else
                                    <div class="text-center py-4">
                                        <h5 class="fw-semibold mb-2">{{ $encontro->conteudo }}</h5>
                                        <p class="text-secondary mb-3">{{ \Carbon\Carbon::parse($encontro->data)->format('d/m/Y') }}</p>
                                        <div id="qr-exibir" class="d-inline-block mb-3"></div>
                                        <p class="text-secondary small">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Mostre este QR Code ao leitor de frequência para registrar sua presença.
                                        </p>
                                        <div id="statusAguardando" class="text-center">
                                            <span class="badge bg-warning text-dark px-3 py-2">
                                                <i class="fas fa-spinner fa-spin me-1"></i>
                                                Aguardando leitura...
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            @if(!$frequencias->count())
                                <div id="avaliacaoForm" style="display: none;">
                                    <hr>
                                    <form method="POST" action="#" id="formAvaliacao">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="avaliacao_conteudo" class="form-label fw-semibold">Conteúdo</label>
                                            <select class="form-control" id="avaliacao_conteudo" name="avaliacao_conteudo" required>
                                                <option value="" selected disabled>Selecione...</option>
                                                @for($n = 1; $n <= 5; $n++)
                                                <option value="{{ $n }}">
                                                    @for($s = 1; $s <= $n; $s++)★@endfor
                                                </option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="avaliacao_metodologia" class="form-label fw-semibold">Metodologia</label>
                                            <select class="form-control" id="avaliacao_metodologia" name="avaliacao_metodologia" required>
                                                <option value="" selected disabled>Selecione...</option>
                                                @for($n = 1; $n <= 5; $n++)
                                                <option value="{{ $n }}">
                                                    @for($s = 1; $s <= $n; $s++)★@endfor
                                                </option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="comentarios" class="form-label fw-semibold">Comentários (opcional)</label>
                                            <textarea class="form-control" id="comentarios" name="comentarios" rows="2"
                                                placeholder="Deixe aqui seus comentários ou sugestões"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Salvar Avaliação
                                        </button>
                                    </form>
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

@section('styles')
<style>
    #qr-exibir canvas, #qr-exibir img {
        border: 4px solid #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    @media print {
        .site-header, .main-header, .main-sidebar, .content-header, .btn, footer, nav {
            display: none !important;
        }
        .card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
        body { background: #fff !important; }
        #qr-exibir canvas, #qr-exibir img {
            width: 200px !important;
            height: 200px !important;
        }
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if($encontros->isNotEmpty() && !$frequencias->count())
            const qr = document.getElementById('qr-exibir');
            if (qr) {
                new QRCode(qr, {
                    text: '{{ $encontros->first()->hash }}',
                    width: 160,
                    height: 160,
                    colorDark: '#1e293b',
                    colorLight: '#ffffff',
                    correctLevel: QRCode.CorrectLevel.H
                });
            }

            const inscricaoId = {{ $inscricaoId }};
            const poll = setInterval(function () {
                fetch('/frequencias/verificar/' + inscricaoId)
                    .then(r => r.json())
                    .then(data => {
                        if (data.registrada) {
                            clearInterval(poll);
                            document.getElementById('statusAguardando').innerHTML =
                                '<span class="badge bg-success px-3 py-2">' +
                                '<i class="fas fa-check-circle me-1"></i> Presença registrada!</span>';
                            document.getElementById('avaliacaoForm').style.display = 'block';
                            document.getElementById('formAvaliacao').action = '/frequencias/avaliar/' + data.frequencia_id;
                        }
                    })
                    .catch(() => {});
            }, 3000);
        @endif
    });
</script>
@endsection

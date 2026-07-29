@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <a href="{{ route('leitor-frequencia.index') }}" class="text-decoration-none text-reset">
                        <i class="fas fa-arrow-left me-2"></i>
                    </a>
                    Leitor — {{ $curso->nome }}
                </h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row g-4">
            <div class="col-lg-5 d-flex flex-column gap-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-camera me-1"></i>
                            Câmera
                        </h5>
                        <span class="badge bg-success" id="scanStatus">Aguardando...</span>
                    </div>
                    <div class="card-body p-2">
                        <div id="qr-reader" style="width: 100%;"></div>
                        <p class="text-secondary text-center small mb-0 mt-2">
                            Aponte a câmera para o QR Code da inscrição do aluno
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-keyboard me-1"></i>
                            Digitar CPF
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="cpfForm" onsubmit="return marcarPorCpf(event)">
                            @csrf
                            <div class="input-group">
                                <input type="text" id="cpfInput" class="form-control" placeholder="000.000.000-00" maxlength="14" oninput="mascaraCPF(this)" required>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check"></i> Validar
                                </button>
                            </div>
                            <div id="cpfFeedback" class="mt-2 small"></div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-users me-1"></i>
                            Inscritos ({{ $inscricoes->count() }})
                        </h5>
                        <span class="badge bg-primary">{{ count($presentes) }} presentes</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th class="text-center">Presença</th>
                                    </tr>
                                </thead>
                                <tbody id="inscritosList">
                                    @foreach($inscricoes as $inscricao)
                                        <tr id="inscrito-{{ $inscricao->id }}"
                                            data-inscricao-id="{{ $inscricao->id }}"
                                            class="{{ in_array($inscricao->user_id, $presentes) ? 'table-success' : '' }}">
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="fas fa-user-circle text-secondary"></i>
                                                    <span>{{ $inscricao->user->name }}</span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if(in_array($inscricao->user_id, $presentes))
                                                    <span class="badge bg-success status-badge">
                                                        <i class="fas fa-check"></i> Presente
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary status-badge">
                                                        <i class="fas fa-clock"></i> Pendente
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    function mascaraCPF(input) {
        let v = input.value.replace(/\D/g, '');
        v = v.replace(/^(\d{3})(\d)/, '$1.$2');
        v = v.replace(/^(\d{3}\.\d{3})(\d)/, '$1.$2');
        v = v.replace(/^(\d{3}\.\d{3}\.\d{3})(\d)/, '$1-$2');
        input.value = v;
    }

    function marcarPorCpf(event) {
        event.preventDefault();
        const input = document.getElementById('cpfInput');
        const feedback = document.getElementById('cpfFeedback');
        const cpf = input.value.replace(/\D/g, '');

        if (cpf.length !== 11) {
            feedback.innerHTML = '<span class="text-danger">CPF deve ter 11 dígitos.</span>';
            return false;
        }

        feedback.innerHTML = '<span class="text-secondary">Registrando...</span>';

        fetch('{{ route("leitor-frequencia.marcar") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ cpf: cpf, curso_id: {{ $curso->id }} })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                feedback.innerHTML = '<span class="text-success fw-medium">✓ Presença registrada!</span>';
                const row = document.querySelector(`#inscrito-${data.inscricao_id}`);
                if (row) {
                    row.className = 'table-success';
                    const badge = row.querySelector('.status-badge');
                    if (badge) {
                        badge.className = 'badge bg-success status-badge';
                        badge.innerHTML = '<i class="fas fa-check"></i> Presente';
                    }
                }
                input.value = '';
                setTimeout(() => { feedback.innerHTML = ''; }, 3000);
            } else {
                feedback.innerHTML = '<span class="text-danger">' + (data.error || 'Erro') + '</span>';
            }
        })
        .catch(() => {
            feedback.innerHTML = '<span class="text-danger">Erro na requisição.</span>';
        });

        return false;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const statusBadge = document.getElementById('scanStatus');
        let lastScanned = '';

        function onScanSuccess(decodedText) {
            if (decodedText === lastScanned) return;
            lastScanned = decodedText;

            statusBadge.textContent = 'Processando...';
            statusBadge.className = 'badge bg-warning';

            fetch('{{ route("leitor-frequencia.marcar") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ inscricao_id: decodedText })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const row = document.querySelector(`#inscrito-${decodedText}`);
                    if (row) {
                        row.className = 'table-success';
                        const badge = row.querySelector('.status-badge');
                        if (badge) {
                            badge.className = 'badge bg-success status-badge';
                            badge.innerHTML = '<i class="fas fa-check"></i> Presente';
                        }
                    }
                    statusBadge.textContent = '✓ Registrado!';
                    statusBadge.className = 'badge bg-success';
                    setTimeout(() => {
                        statusBadge.textContent = 'Aguardando...';
                        statusBadge.className = 'badge bg-success';
                    }, 2000);
                } else {
                    statusBadge.textContent = data.error || 'Erro';
                    statusBadge.className = 'badge bg-danger';
                    setTimeout(() => {
                        statusBadge.textContent = 'Aguardando...';
                        statusBadge.className = 'badge bg-success';
                    }, 2000);
                }
            })
            .catch(() => {
                statusBadge.textContent = 'Erro na requisição';
                statusBadge.className = 'badge bg-danger';
            });
        }

        function onScanFailure() {}

        const html5QrCode = new Html5Qrcode("qr-reader");
        html5QrCode.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: { width: 250, height: 250 } },
            onScanSuccess,
            onScanFailure
        ).catch(function (err) {
            statusBadge.textContent = 'Erro câmera';
            statusBadge.className = 'badge bg-danger';
            console.error(err);
        });
    });
</script>
<style>
    #qr-reader {
        border: none !important;
    }
    #qr-reader video {
        border-radius: 10px;
        width: 100% !important;
    }
    #qr-reader__dashboard_section_swaplink {
        display: none !important;
    }
    #qr-reader__dashboard_section_csr span {
        font-size: 0.85rem;
        color: #4f46e5;
    }
    #qr-reader__dashboard_section_csr button {
        background: #4f46e5 !important;
        border: none !important;
        border-radius: 8px !important;
        color: #fff !important;
        padding: 0.3rem 1rem !important;
        font-size: 0.85rem !important;
    }
    #qr-reader__dashboard_section_csr button:hover {
        background: #3730a3 !important;
    }
    .table-success .status-badge {
        font-size: 0.8rem;
    }
</style>
@endsection

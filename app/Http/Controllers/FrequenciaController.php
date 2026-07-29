<?php

namespace App\Http\Controllers;

use App\Models\Encontro;
use App\Models\Frequencia;
use App\Models\Inscricao;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class FrequenciaController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function index(Request $request)
    {
        // Lista fixa de escolas
        $escolasFixas = collect(['Escola Municipal Crenildes', 'Escola Municipal Paulo Vl', 'Escola Municipal Iracema']);

        // Pega as escolas distintas da tabela User
        $escolasUsuario = User::distinct()->pluck('secretaria');

        // Junta as duas listas de escolas (fixas e dos usuários) e remove duplicatas
        $escolas = $escolasFixas->merge($escolasUsuario)->unique();

        // Pega a escola selecionada do filtro, removendo espaços extras
        $escola = trim($request->input('escola'));

        // Recupera os encontros filtrados com base na escola
        $encontros = Encontro::with(['frequencias' => function ($query) use ($escola) {
            if ($escola) {
                // Filtra os encontros pelos usuários com a escola selecionada
                $query->whereHas('user', function ($query) use ($escola) {
                    $query->where('secretaria', $escola); // Filtra pela escola dos usuários diretamente
                });
            }
        }])->get(); // Recupera todos os encontros

        return view('relatorios.frequencia-resultado', compact('encontros', 'escolas'));
    }

    public function create($inscricaoId)
    {
        $inscricao = Inscricao::with('curso.encontros')->findOrFail($inscricaoId);
        $encontros = $inscricao->curso->encontros->where('data', now()->toDateString());
        $hoje = now()->toDateString();

        $encontroHoje = Encontro::where('curso_id', $inscricao->curso_id)
            ->whereDate('data', $hoje)
            ->first();

        $frequencias = collect();
        if ($encontroHoje) {
            $frequencias = Frequencia::where('encontro_id', $encontroHoje->id)
                ->where('user_id', auth()->id())
                ->get();
        }

        return view('frequencias.create', compact('inscricaoId', 'inscricao', 'encontros', 'frequencias'));
    }

    public function verificar($inscricaoId)
    {
        $inscricao = Inscricao::findOrFail($inscricaoId);
        $encontro = Encontro::where('curso_id', $inscricao->curso_id)
            ->whereDate('data', now()->toDateString())
            ->first();

        if (! $encontro) {
            return response()->json(['registrada' => false]);
        }

        $frequencia = Frequencia::where('encontro_id', $encontro->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($frequencia) {
            return response()->json(['registrada' => true, 'frequencia_id' => $frequencia->id]);
        }

        return response()->json(['registrada' => false]);
    }

    public function avaliar(Request $request, $frequenciaId)
    {
        $frequencia = Frequencia::findOrFail($frequenciaId);

        if ($frequencia->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Acesso não autorizado.');
        }

        $request->validate([
            'avaliacao_conteudo' => 'required|integer|min:1|max:5',
            'avaliacao_metodologia' => 'required|integer|min:1|max:5',
            'comentarios' => 'nullable|string|max:1000',
        ]);

        $frequencia->update([
            'avaliacao_conteudo' => $request->avaliacao_conteudo,
            'avaliacao_metodologia' => $request->avaliacao_metodologia,
            'comentarios' => $request->comentarios,
        ]);

        return redirect()->back()->with('success', 'Avaliação salva com sucesso!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hash' => 'required|string',
            'avaliacao_conteudo' => 'required|integer|min:1|max:5',
            'avaliacao_metodologia' => 'required|integer|min:1|max:5',
            'comentarios' => 'nullable|string|max:1000',
        ]);

        // Verificar se o hash é válido
        $encontro = Encontro::where('hash', $request->hash)->first();

        if (! $encontro) {
            return redirect()->back()->with('error', 'Código de frequência inválido.');
        }

        // Verificar se o usuário já registrou frequência
        $userId = auth()->id();
        $frequenciaExistente = Frequencia::where('encontro_id', $encontro->id)
            ->where('user_id', $userId)
            ->first();

        if ($frequenciaExistente) {
            return redirect()->back()->with('error', 'Você já registrou presença para este encontro.');
        }

        // Registrar frequência
        Frequencia::create([
            'encontro_id' => $encontro->id,
            'user_id' => $userId,
            'avaliacao_conteudo' => $request->avaliacao_conteudo,
            'avaliacao_metodologia' => $request->avaliacao_metodologia,
            'comentarios' => $request->comentarios,
        ]);

        app(CertificadoController::class)->gerarCertificadosPendentes(auth()->user());

        app(CertificadoController::class)->gerarCertificadosPendentes(auth()->user());

        return redirect()->back()->with('success', 'Frequência registrada com sucesso!');
    }

    public function detalhes(Inscricao $inscricao)
    {
        $curso = $inscricao->curso->load('encontros');
        $userId = $inscricao->user_id;

        $frequencias = Frequencia::where('user_id', $userId)
            ->whereIn('encontro_id', $curso->encontros->pluck('id'))
            ->get()
            ->keyBy('encontro_id');

        $totalEncontros = $curso->encontros->count();
        $presentes = $frequencias->count();
        $percentual = $totalEncontros > 0 ? round(($presentes / $totalEncontros) * 100) : 0;

        $todasAvaliadas = $frequencias->isNotEmpty() && $frequencias->every(fn ($f) => $f->avaliacao_conteudo > 0 && $f->avaliacao_metodologia > 0);

        return view('inscricoes.frequencias', compact(
            'inscricao', 'curso', 'frequencias', 'totalEncontros', 'presentes', 'percentual', 'todasAvaliadas'
        ));
    }

    public function gerarPdf(Request $request)
    {
        // Recupera a escola selecionada no filtro
        $escola = trim($request->input('escola'));

        // Filtra as frequências pela escola selecionada
        $encontros = Encontro::with(['frequencias' => function ($query) use ($escola) {
            if ($escola) {
                $query->whereHas('user', function ($query) use ($escola) {
                    // Ajuste: comparando a escola com o valor do filtro
                    $query->whereRaw('TRIM(secretaria) = ?', [$escola]);
                });
            }
        }])->get();

        // Gera o PDF com os dados dos encontros filtrados
        $pdf = Pdf::loadView('relatorios.frequencia-pdf', compact('encontros', 'escola'));

        // Retorna o PDF para download
        return $pdf->download('relatorio_frequencias.pdf');
    }
}

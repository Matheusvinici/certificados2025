<?php

namespace App\Http\Controllers;

use App\Models\Curso; // Certifique-se que a model existe
// Verifique se está no namespace correto
// Verifique o caminho correto
use App\Models\Inscricao; // Importante para lidar com requisições
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InscricaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userRole = auth()->user()->role;
        $cursos = Curso::all();
        $isAdmin = $userRole == 'admin' || auth()->user()->hasAnyRole(['super-admin', 'leitor-frequencia']);

        if ($isAdmin) {
            $inscricoes = $this->filtrarInscricoesAdmin($request);
            $dashboard = $this->dashboardAdmin();
        } elseif ($userRole == 'formador') {
            $inscricoes = [];
            $dashboard = null;
        } else {
            $inscricoes = Inscricao::with('curso.encontros', 'user')
                ->where('user_id', auth()->id())
                ->get();
            $dashboard = null;
        }

        return view('inscricoes.index', compact('inscricoes', 'cursos', 'dashboard'));
    }

    /**
     * Dados do dashboard: inscritos, vagas e lista de espera por curso.
     */
    private function dashboardAdmin()
    {
        $inscritosPorCurso = Inscricao::where('status', 'inscrito')
            ->selectRaw('curso_id, count(*) as total')
            ->groupBy('curso_id')
            ->pluck('total', 'curso_id');

        $esperaPorCurso = Inscricao::where('status', 'lista_espera')
            ->selectRaw('curso_id, count(*) as total')
            ->groupBy('curso_id')
            ->pluck('total', 'curso_id');

        $cursos = Curso::orderBy('nome')->get()->map(function ($curso) use ($inscritosPorCurso, $esperaPorCurso) {
            $curso->inscritos = $inscritosPorCurso->get($curso->id, 0);
            $curso->lista_espera = $esperaPorCurso->get($curso->id, 0);
            $curso->vagas_restantes = $curso->vagas !== null
                ? max(0, $curso->vagas - $curso->inscritos)
                : null;

            return $curso;
        });

        $totais = [
            'cursos' => $cursos->count(),
            'cursos_validados' => $cursos->where('status', 'validado')->count(),
            'vagas' => $cursos->sum('vagas'),
            'inscritos' => $inscritosPorCurso->sum(),
            'lista_espera' => $esperaPorCurso->sum(),
        ];

        return compact('cursos', 'totais');
    }

    private function filtrarInscricoesAdmin(Request $request)
    {
        $query = Inscricao::with('curso.encontros', 'user');

        if ($request->has('curso_id')) {
            $query->where('curso_id', $request->curso_id);
        }

        return $query->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $hoje = now()->toDateString();
        $cursos = Curso::where('ativo', true)
            ->where('status', 'validado')
            ->where(function ($q) use ($hoje) {
                $q->whereNull('data_inicio_inscricao')
                    ->orWhere('data_inicio_inscricao', '<=', $hoje);
            })
            ->where(function ($q) use ($hoje) {
                $q->whereNull('data_fim_inscricao')
                    ->orWhere('data_fim_inscricao', '>=', $hoje);
            })
            ->get();
        $cursoId = $request->curso_id;

        return view('inscricoes.create', compact('cursos', 'cursoId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userId = auth()->id();
        $cursoId = $request->curso_id;

        $inscricaoExistente = Inscricao::where('curso_id', $cursoId)
            ->where('user_id', $userId)
            ->first();

        if ($inscricaoExistente) {
            return redirect()->route('inscricoes.index')->with('error', 'Você já está inscrito neste curso.');
        }

        $curso = Curso::find($cursoId);

        if (! $curso || ! $curso->ativo || $curso->status != 'validado') {
            return redirect()->route('inscricoes.index')->with('error', 'As inscrições para este curso ainda não estão abertas.');
        }

        $status = 'inscrito';

        if ($curso->vagas) {
            $quantidadeInscritos = Inscricao::where('curso_id', $cursoId)
                ->where('status', 'inscrito')
                ->count();

            if ($quantidadeInscritos >= $curso->vagas) {
                $status = 'lista_espera';
            }
        }

        $inscricao = Inscricao::create([
            'curso_id' => $cursoId,
            'user_id' => $userId,
            'status' => $status,
        ]);

        if ($status === 'lista_espera') {
            $posicao = $inscricao->posicaoListaEspera();

            return redirect()->route('inscricoes.index')->with('success', "As vagas deste curso já foram preenchidas. Você entrou na lista de espera na posição {$posicao}. Quando uma vaga abrir, você será inscrito automaticamente.");
        }

        return redirect()->route('inscricoes.index')->with('success', 'Inscrição realizada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inscricao $inscricao)
    {
        // Certifique-se de carregar o curso associado
        $curso = $inscricao->curso;

        // Verifique se o curso está disponível
        if (! $curso) {
            abort(404, 'Curso não encontrado para esta inscrição.');
        }

        return view('inscricoes.show', compact('inscricao', 'curso'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inscricao $inscricao)
    {
        return view('inscricoes.edit', compact('inscricao'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inscricao $inscricao)
    {
        // Atualiza a inscrição (se necessário)
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inscricao $inscricao)
    {
        $cursoId = $inscricao->curso_id;
        $eraInscrito = $inscricao->status === 'inscrito';

        $inscricao->delete();

        if ($eraInscrito) {
            $proximo = Inscricao::where('curso_id', $cursoId)
                ->where('status', 'lista_espera')
                ->orderBy('id')
                ->first();

            if ($proximo) {
                $proximo->update(['status' => 'inscrito']);

                return redirect()->back()->with('success', 'Inscrição removida. O próximo da lista de espera foi inscrito automaticamente.');
            }
        }

        return redirect()->back()->with('success', 'Inscrição removida com sucesso!');
    }

    /**
     * Área do administrador: listas de espera de todos os cursos.
     */
    public function listaEspera()
    {
        $this->autorizarAdmin();

        $cursos = Curso::with(['encontros', 'formadores'])->latest()->get();

        foreach ($cursos as $curso) {
            $curso->inscritos_count = Inscricao::where('curso_id', $curso->id)
                ->where('status', 'inscrito')
                ->count();
            $curso->lista_espera = Inscricao::with('user')
                ->where('curso_id', $curso->id)
                ->where('status', 'lista_espera')
                ->orderBy('id')
                ->get();
            $curso->posicao_anterior = $curso->inscritos_count;
        }

        return view('inscricoes.lista-espera', compact('cursos'));
    }

    /**
     * Promover manualmente um participante da lista de espera para inscrito.
     */
    public function promoverListaEspera(Inscricao $inscricao)
    {
        $this->autorizarAdmin();

        if ($inscricao->status !== 'lista_espera') {
            return redirect()->back()->with('error', 'Este participante não está na lista de espera.');
        }

        $inscricao->update(['status' => 'inscrito']);

        return redirect()->back()->with('success', "{$inscricao->user->name} foi promovido para inscrito no curso.");
    }

    private function autorizarAdmin()
    {
        abort_unless(auth()->user()->role == 'admin' || auth()->user()->hasAnyRole(['super-admin', 'leitor-frequencia']), 403, 'Acesso restrito ao administrador.');
    }

    /**
     * Gera um PDF com a lista de inscrições.
     */
    public function gerarRelatorioPDF(Request $request)
    {
        $userRole = auth()->user()->role;

        if ($userRole == 'admin') {
            $inscricoes = $this->filtrarInscricoesAdmin($request);
        } else {
            $inscricoes = [];
        }

        $cursos = Curso::all();
        $cursoFiltro = $request->curso_id ? Curso::find($request->curso_id) : null;

        return view('relatorios.inscricao-print', compact('inscricoes', 'cursos', 'cursoFiltro'));
    }
}

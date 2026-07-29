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

        if ($userRole == 'admin' || auth()->user()->hasAnyRole(['super-admin', 'leitor-frequencia'])) {
            $inscricoes = $this->filtrarInscricoesAdmin($request);
        } elseif ($userRole == 'formador') {
            $inscricoes = [];
        } else {
            $inscricoes = Inscricao::with('curso.encontros', 'user')
                ->where('user_id', auth()->id())
                ->get();
        }

        return view('inscricoes.index', compact('inscricoes', 'cursos'));
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

        Inscricao::create([
            'curso_id' => $cursoId,
            'user_id' => $userId,
        ]);

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
        // Exclui a inscrição do banco de dados
        $inscricao->delete();

        // Redireciona de volta para a lista de inscrições com sucesso
        return redirect()->route('inscricoes.index')->with('success', 'Inscrição removida com sucesso!');
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

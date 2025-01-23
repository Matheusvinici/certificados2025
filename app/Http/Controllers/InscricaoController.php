<?php

namespace App\Http\Controllers;

use App\Models\Curso; // Certifique-se que a model existe
use App\Models\Encontro; // Verifique se está no namespace correto
use App\Models\Frequencia; // Verifique o caminho correto
use Illuminate\Http\Request; // Importante para lidar com requisições
use App\Models\Inscricao;
use Barryvdh\DomPDF\Facade\Pdf;

class InscricaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Verifica o papel do usuário
        $userRole = auth()->user()->role;

        // Obter todos os cursos para exibir no filtro
        $cursos = Curso::all();

        // Filtra as inscrições dependendo do papel do usuário
        if ($userRole == 'admin') {
            $inscricoes = $this->filtrarInscricoesAdmin($request);
        } elseif ($userRole == 'formador') {
            $inscricoes = [];
        } else {
            $inscricoes = Inscricao::with('curso', 'user')
                ->where('user_id', auth()->id())
                ->get();
        }

        return view('inscricoes.index', compact('inscricoes', 'cursos'));
    }

    /**
     * Função para filtrar inscrições para o administrador.
     */
    private function filtrarInscricoesAdmin(Request $request)
    {
        if ($request->has('curso_id')) {
            return Inscricao::with('curso', 'user')
                ->where('curso_id', $request->curso_id)
                ->get();
        } else {
            return Inscricao::with('curso', 'user')->get();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cursos = Curso::all();
        return view('inscricoes.create', compact('cursos'));
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
        return view('inscricoes.show', compact('inscricao'));
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
        // Verifica o papel do usuário
        $userRole = auth()->user()->role;

        // Se o usuário for admin, pode ver todas as inscrições
        if ($userRole == 'admin') {
            $inscricoes = $this->filtrarInscricoesAdmin($request);
        } else {
            $inscricoes = [];
        }

        // Carrega o PDF com as inscrições
        $pdf = Pdf::loadView('relatorios.inscricao', compact('inscricoes'));

        // Retorna o PDF gerado para download
        return $pdf->download('relatorio_inscricoes.pdf');
    }
}

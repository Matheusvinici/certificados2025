<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Encontro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;  // Importação necessária


class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cursos = Curso::paginate(10); // Paginação de 10 cursos por página
        return view('cursos.index', compact('cursos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cursos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar os dados
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'data_inicio' => 'required|date',
            'carga_horaria' => 'required|string',
            'data_fim' => 'required|date',
            'percentual' => 'required|integer',
            'ativo' => 'required|boolean',
            'encontros' => 'array', // Validar que é um array de encontros
            'encontros.*.conteudo' => 'required|string|max:255',
            'encontros.*.data' => 'required|date',
            'encontros.*.carga_horaria_encontro' => 'required|string|max:255',
        ]);

        // Criar o curso
        $curso = Curso::create([
            'nome' => $validated['nome'],
            'data_inicio' => $validated['data_inicio'],
            'carga_horaria' => $validated['carga_horaria'],
            'data_fim' => $validated['data_fim'],
            'percentual' => $validated['percentual'],
            'ativo' => $validated['ativo'],
        ]);

        // Salvar os encontros
        if (isset($validated['encontros']) && count($validated['encontros']) > 0) {
            foreach ($validated['encontros'] as $encontroData) {
                $curso->encontros()->create([
                    'conteudo' => $encontroData['conteudo'],
                    'data' => $encontroData['data'],
                    'carga_horaria_encontro' => $encontroData['carga_horaria_encontro'],
                    'hash' => Str::random(5), // Gerar um hash aleatório para o encontro
                ]);
            }
        }

        // Retornar para a página com uma mensagem de sucesso
        return redirect()->route('cursos.index')->with('success', 'Curso e encontros salvos com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function edit($id)
{
    $curso = Curso::findOrFail($id);
    return view('cursos.edit', compact('curso'));
}

// Método Update
public function update(Request $request, $id)
{
    // Validar os dados
    $validated = $request->validate([
        'nome' => 'required|string|max:255',
        'data_inicio' => 'required|date',
        'carga_horaria' => 'required|string',
        'data_fim' => 'required|date',
        'percentual' => 'required|integer',
        'ativo' => 'required|boolean',
        'encontros' => 'array', // Validar que é um array de encontros
        'encontros.*.conteudo' => 'required|string|max:255',
        'encontros.*.data' => 'required|date',
        'encontros.*.carga_horaria_encontro' => 'required|string|max:255',
    ]);

    // Atualizar o curso
    $curso = Curso::findOrFail($id);
    $curso->update([
        'nome' => $validated['nome'],
        'data_inicio' => $validated['data_inicio'],
        'carga_horaria' => $validated['carga_horaria'],
        'data_fim' => $validated['data_fim'],
        'percentual' => $validated['percentual'],
        'ativo' => $validated['ativo'],
    ]);

    // Atualizar os encontros
    if (isset($validated['encontros']) && count($validated['encontros']) > 0) {
        // Remover encontros existentes
        $curso->encontros()->delete();

        // Adicionar os novos encontros
        foreach ($validated['encontros'] as $encontroData) {
            $curso->encontros()->create([
                'conteudo' => $encontroData['conteudo'],
                'data' => $encontroData['data'],
                'carga_horaria_encontro' => $encontroData['carga_horaria_encontro'],
                'hash' => Str::random(5), // Gerar um hash aleatório para o encontro
            ]);
        }
    }

    // Retornar para a página com uma mensagem de sucesso
    return redirect()->route('cursos.index')->with('success', 'Curso atualizado com sucesso!');
}
            public function show($id)
            {
                // Buscar o curso pelo ID e carregar os encontros relacionados
                $curso = Curso::with('encontros')->findOrFail($id);

                // Retornar a view com os dados do curso
                return view('cursos.show', compact('curso'));
            }

            public function destroy($id)
            {
                // Localiza o curso pelo ID
                $curso = Curso::findOrFail($id);
                
                // Deleta o curso
                $curso->delete();
        
                // Redireciona para a lista de cursos com uma mensagem de sucesso
                return redirect()->route('cursos.index')->with('success', 'Curso deletado com sucesso!');
            }


}

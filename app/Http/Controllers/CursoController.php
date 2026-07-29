<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Encontro;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        $usuarios = User::all();

        return view('cursos.create', compact('usuarios'));
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
            'data_inicio_inscricao' => 'nullable|date',
            'data_fim_inscricao' => 'nullable|date|after_or_equal:data_inicio_inscricao',
            'user_assinatura_id' => 'nullable|exists:users,id',
            'encontros' => 'array',
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
            'data_inicio_inscricao' => $validated['data_inicio_inscricao'],
            'data_fim_inscricao' => $validated['data_fim_inscricao'],
            'user_assinatura_id' => $validated['user_assinatura_id'] ?? null,
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
        $usuarios = User::all();

        return view('cursos.edit', compact('curso', 'usuarios'));
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
            'data_inicio_inscricao' => 'nullable|date',
            'data_fim_inscricao' => 'nullable|date|after_or_equal:data_inicio_inscricao',
            'user_assinatura_id' => 'nullable|exists:users,id',
            'encontros' => 'array',
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
            'data_inicio_inscricao' => $validated['data_inicio_inscricao'],
            'data_fim_inscricao' => $validated['data_fim_inscricao'],
            'user_assinatura_id' => $validated['user_assinatura_id'] ?? null,
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

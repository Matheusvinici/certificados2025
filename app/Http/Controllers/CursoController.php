<?php

namespace App\Http\Controllers;

use App\Models\Assinatura;
use App\Models\Curso;
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
        return view('cursos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = User::all();
        $formadores = User::where('role', 'formador')->orWhere('role', 'admin')->get();

        return view('cursos.create', compact('usuarios', 'formadores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge(['encontros' => $this->filtrarEncontrosVazios($request->input('encontros', []))]);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'data_inicio' => 'required|date',
            'carga_horaria' => 'required|string',
            'data_fim' => 'required|date',
            'percentual' => 'required|integer',
            'ativo' => 'required|boolean',
            'data_inicio_inscricao' => 'nullable|date',
            'data_fim_inscricao' => 'nullable|date|after_or_equal:data_inicio_inscricao',
            'vagas' => 'nullable|integer|min:1',
            'responsaveis_assinatura' => 'nullable|array',
            'responsaveis_assinatura.*' => 'integer|exists:users,id',
            'encontros' => 'array',
            'encontros.*.conteudo' => 'required|string|max:255',
            'encontros.*.data' => 'required|date',
            'encontros.*.hora_inicio' => 'required|date_format:H:i',
            'encontros.*.hora_fim' => 'required|date_format:H:i',
            'encontros.*.carga_horaria_encontro' => 'required|string|max:255',
        ]);

        foreach (($validated['encontros'] ?? []) as $encontroData) {
            if (strtotime($encontroData['hora_fim']) <= strtotime($encontroData['hora_inicio'])) {
                return redirect()->back()->with('error', 'A hora de término deve ser maior que a hora de início em todos os encontros.')->withInput();
            }
        }

        $curso = Curso::create([
            'nome' => $validated['nome'],
            'data_inicio' => $validated['data_inicio'],
            'carga_horaria' => $validated['carga_horaria'],
            'data_fim' => $validated['data_fim'],
            'percentual' => $validated['percentual'],
            'ativo' => $validated['ativo'],
            'data_inicio_inscricao' => $validated['data_inicio_inscricao'],
            'data_fim_inscricao' => $validated['data_fim_inscricao'],
            'vagas' => $validated['vagas'] ?? null,
            'status' => 'pendente',
        ]);

        $curso->responsaveisAssinatura()->sync($validated['responsaveis_assinatura'] ?? []);
        $this->sincronizarFormadores($curso, $validated['responsaveis_assinatura'] ?? []);

        $this->salvarEncontros($curso, $validated['encontros'] ?? []);

        return redirect()->route('cursos.index')->with('success', 'Curso criado com sucesso! Agora vincule o formador e aguarde os horários ou preencha você mesmo.');
    }

    /**
     * Display the specified resource.
     */
    public function edit($id)
    {
        $curso = Curso::with('encontros', 'formadores', 'responsaveisAssinatura')->findOrFail($id);
        $usuarios = User::all();
        $formadores = User::where('role', 'formador')->orWhere('role', 'admin')->get();

        return view('cursos.edit', compact('curso', 'usuarios', 'formadores'));
    }

    public function update(Request $request, $id)
    {
        $encontros = $this->filtrarEncontrosVazios($request->input('encontros', []));
        $encontros = $this->normalizarHorasEncontros($encontros);
        $request->merge(['encontros' => $encontros]);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'data_inicio' => 'required|date',
            'carga_horaria' => 'required|string',
            'data_fim' => 'required|date',
            'percentual' => 'required|integer',
            'ativo' => 'required|boolean',
            'data_inicio_inscricao' => 'nullable|date',
            'data_fim_inscricao' => 'nullable|date|after_or_equal:data_inicio_inscricao',
            'vagas' => 'nullable|integer|min:1',
            'responsaveis_assinatura' => 'nullable|array',
            'responsaveis_assinatura.*' => 'integer|exists:users,id',
            'encontros' => 'array',
            'encontros.*.conteudo' => 'required|string|max:255',
            'encontros.*.data' => 'required|date',
            'encontros.*.hora_inicio' => 'required|date_format:H:i',
            'encontros.*.hora_fim' => 'required|date_format:H:i',
            'encontros.*.carga_horaria_encontro' => 'required|string|max:255',
        ]);

        foreach (($validated['encontros'] ?? []) as $encontroData) {
            if (strtotime($encontroData['hora_fim']) <= strtotime($encontroData['hora_inicio'])) {
                return redirect()->back()->with('error', 'A hora de término deve ser maior que a hora de início em todos os encontros.')->withInput();
            }
        }

        $curso = Curso::findOrFail($id);

        // Quando o curso é editado pelo admin, os encontros já preenchidos
        // são substituídos pelos enviados no formulário (admin pode cadastrar
        // os dias/horários mesmo que o formador não tenha preenchido).
        if (isset($validated['encontros']) && count($validated['encontros']) > 0) {
            $curso->encontros()->delete();
            $this->salvarEncontros($curso, $validated['encontros']);
        }

        $curso->update([
            'nome' => $validated['nome'],
            'data_inicio' => $validated['data_inicio'],
            'carga_horaria' => $validated['carga_horaria'],
            'data_fim' => $validated['data_fim'],
            'percentual' => $validated['percentual'],
            'ativo' => $validated['ativo'],
            'data_inicio_inscricao' => $validated['data_inicio_inscricao'],
            'data_fim_inscricao' => $validated['data_fim_inscricao'],
            'vagas' => $validated['vagas'] ?? null,
        ]);

        $curso->responsaveisAssinatura()->sync($validated['responsaveis_assinatura'] ?? []);
        $this->sincronizarFormadores($curso, $validated['responsaveis_assinatura'] ?? []);

        return redirect()->route('cursos.index')->with('success', 'Curso atualizado com sucesso!');
    }

    /**
     * Formadores do curso = responsáveis pela assinatura que são Facilitador(a).
     */
    private function sincronizarFormadores(Curso $curso, array $responsaveisIds)
    {
        $formadores = Assinatura::whereIn('user_id', $responsaveisIds)
            ->where('facilitador', true)
            ->pluck('user_id');

        $curso->formadores()->sync($formadores);
    }

    /**
     * Remove encontros totalmente vazios do array, permitindo criar o curso
     * sem encontros (o formador cadastra depois; validação exige pelo menos 1).
     */
    private function filtrarEncontrosVazios(array $encontros): array
    {
        return collect($encontros)
            ->filter(function ($encontro) {
                return ! empty($encontro['conteudo']) || ! empty($encontro['data'])
                    || ! empty($encontro['hora_inicio']) || ! empty($encontro['hora_fim']);
            })
            ->values()
            ->all();
    }

    /**
     * Normaliza horas "H:i:s" (formato do banco) para "H:i" (formato do input time).
     */
    private function normalizarHorasEncontros(array $encontros): array
    {
        return collect($encontros)
            ->map(function ($encontro) {
                foreach (['hora_inicio', 'hora_fim'] as $campo) {
                    if (isset($encontro[$campo]) && strlen($encontro[$campo]) > 5) {
                        $encontro[$campo] = substr($encontro[$campo], 0, 5);
                    }
                }
                if (isset($encontro['carga_horaria_encontro'])) {
                    $encontro['carga_horaria_encontro'] = (string) $encontro['carga_horaria_encontro'];
                }

                return $encontro;
            })
            ->values()
            ->all();
    }

    /**
     * Validar o curso: confirma os encontros/horários e libera para inscrições.
     */
    public function validar(Curso $curso)
    {
        if ($curso->encontros()->count() == 0) {
            return redirect()->route('cursos.edit', $curso)->with('error', 'O curso precisa ter pelo menos um encontro (dia/horário) cadastrado antes de ser validado.');
        }

        $curso->update([
            'status' => 'validado',
            'ativo' => true,
        ]);

        return redirect()->route('cursos.index')->with('success', 'Curso validado com sucesso! Já está disponível para inscrições.');
    }

    /**
     * Reabrir o curso para ajustes (volta para pendente).
     */
    public function reabrir(Curso $curso)
    {
        $curso->update([
            'status' => 'pendente',
            'ativo' => false,
        ]);

        return redirect()->route('cursos.index')->with('success', 'Curso reaberto para ajustes.');
    }

    /**
     * Duplicar o curso com todos os encontros (temas) e responsáveis,
     * para servir de base a um novo curso.
     */
    public function duplicar(Curso $curso)
    {
        $novo = Curso::create([
            'nome' => $curso->nome.' (cópia)',
            'data_inicio' => $curso->data_inicio,
            'carga_horaria' => $curso->carga_horaria,
            'data_fim' => $curso->data_fim,
            'percentual' => $curso->percentual,
            'ativo' => false,
            'data_inicio_inscricao' => $curso->data_inicio_inscricao,
            'data_fim_inscricao' => $curso->data_fim_inscricao,
            'vagas' => $curso->vagas,
            'status' => 'pendente',
        ]);

        $responsaveisIds = $curso->responsaveisAssinatura->pluck('id')->toArray();
        $novo->responsaveisAssinatura()->sync($responsaveisIds);
        $this->sincronizarFormadores($novo, $responsaveisIds);

        foreach ($curso->encontros as $encontro) {
            $novo->encontros()->create([
                'conteudo' => $encontro->conteudo,
                'data' => $encontro->data,
                'hora_inicio' => $encontro->hora_inicio,
                'hora_fim' => $encontro->hora_fim,
                'carga_horaria_encontro' => $encontro->carga_horaria_encontro,
                'hash' => Str::random(5),
            ]);
        }

        return redirect()->route('cursos.edit', $novo)
            ->with('success', 'Curso duplicado com todos os temas! Atualize as informações, adicione ou edite os encontros e valide quando quiser.');
    }

    public function show($id)
    {
        $curso = Curso::with('encontros', 'formadores')->findOrFail($id);

        return view('cursos.show', compact('curso'));
    }

    public function destroy($id)
    {
        $curso = Curso::findOrFail($id);
        $curso->delete();

        return redirect()->route('cursos.index')->with('success', 'Curso deletado com sucesso!');
    }

    /**
     * Criar os encontros de um curso a partir dos dados do formulário.
     */
    private function salvarEncontros(Curso $curso, array $encontros)
    {
        foreach ($encontros as $encontroData) {
            $curso->encontros()->create([
                'conteudo' => $encontroData['conteudo'],
                'data' => $encontroData['data'],
                'hora_inicio' => $encontroData['hora_inicio'] ?? null,
                'hora_fim' => $encontroData['hora_fim'] ?? null,
                'carga_horaria_encontro' => $encontroData['carga_horaria_encontro'],
                'hash' => Str::random(5),
            ]);
        }
    }
}

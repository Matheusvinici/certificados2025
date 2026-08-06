<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Encontro;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormadorController extends Controller
{
    /**
     * Exibir os cursos vinculados ao formador.
     */
    public function index()
    {
        $cursos = Curso::with('encontros', 'formadores')
            ->whereHas('formadores', fn ($q) => $q->where('users.id', auth()->id()))
            ->latest()
            ->get();

        return view('formador.index', compact('cursos'));
    }

    /**
     * Formulário para o formador cadastrar os horários do curso.
     */
    public function editarHorarios(Curso $curso)
    {
        $this->autorizarFormador($curso);

        $encontros = $curso->encontros()->orderBy('data')->get();

        return view('formador.horarios', compact('curso', 'encontros'));
    }

    /**
     * Salvar os horários (encontros) e vagas cadastrados pelo formador.
     */
    public function salvarHorarios(Request $request, Curso $curso)
    {
        $this->autorizarFormador($curso);

        if ($curso->status == 'validado') {
            return redirect()->back()->with('error', 'Este curso já foi validado. Procure o administrador para ajustes.');
        }

        $encontros = $request->input('encontros', []);
        $encontros = collect($encontros)
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
        $request->merge(['encontros' => $encontros]);

        $validated = $request->validate([
            'vagas' => 'nullable|integer|min:1',
            'encontros' => 'array',
            'encontros.*.conteudo' => 'required|string|max:255',
            'encontros.*.data' => 'required|date',
            'encontros.*.hora_inicio' => 'required|date_format:H:i',
            'encontros.*.hora_fim' => 'required|date_format:H:i',
            'encontros.*.carga_horaria_encontro' => 'required|string|max:255',
        ]);
        foreach ($validated['encontros'] as $encontroData) {
            if (strtotime($encontroData['hora_fim']) <= strtotime($encontroData['hora_inicio'])) {
                return redirect()->back()->with('error', 'A hora de término deve ser maior que a hora de início em todos os encontros.')->withInput();
            }
        }

        $curso->update([
            'vagas' => $validated['vagas'] ?? null,
        ]);

        $curso->encontros()->delete();

        foreach ($validated['encontros'] as $encontroData) {
            $curso->encontros()->create([
                'conteudo' => $encontroData['conteudo'],
                'data' => $encontroData['data'],
                'hora_inicio' => $encontroData['hora_inicio'],
                'hora_fim' => $encontroData['hora_fim'],
                'carga_horaria_encontro' => $encontroData['carga_horaria_encontro'],
                'hash' => Str::random(5),
            ]);
        }

        return redirect()->route('formador.index')->with('success', 'Horários do curso salvos com sucesso!');
    }

    /**
     * Garantir que apenas o formador vinculado acesse o curso.
     */
    private function autorizarFormador(Curso $curso)
    {
        abort_unless($curso->formadores->contains('id', auth()->id()), 403, 'Você não é formador deste curso.');
    }

    /**
     * Exibir os encontros do curso selecionado.
     */
    public function encontros(Request $request)
    {
        $cursoId = $request->input('curso_id');
        $curso = Curso::findOrFail($cursoId);

        $encontros = Encontro::where('curso_id', $cursoId)->get();

        return view('formador.encontros', compact('curso', 'encontros'));
    }
}

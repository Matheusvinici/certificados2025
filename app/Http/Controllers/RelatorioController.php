<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Encontro;
use App\Models\Frequencia;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function filtroFrequencia()
    {
        $cursos = Curso::with('encontros')->get();
        return view('relatorios.frequencia', compact('cursos'));
    }

    public function gerarRelatorio(Request $request)
    {
        $validated = $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'encontros' => 'required|array',
            'encontros.*' => 'exists:encontros,id',
        ]);

        $encontros = Encontro::whereIn('id', $validated['encontros'])->with('frequencias')->get();

        return view('relatorios.frequencia-resultado', compact('encontros'));
    }
}

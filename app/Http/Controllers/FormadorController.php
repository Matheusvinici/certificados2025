<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Encontro;
use Illuminate\Http\Request;

class FormadorController extends Controller
{
    /**
     * Exibir os cursos disponíveis.
     */
    public function index()
    {
        // Pega todos os cursos disponíveis
        $cursos = Curso::all();
    
        // Passa os cursos para a view
        return view('formador.index', compact('cursos'));
    }
    

    /**
     * Exibir os encontros do curso selecionado.
     */
    public function encontros(Request $request)
    {
        // Pega o curso selecionado
        $cursoId = $request->input('curso_id');
        $curso = Curso::findOrFail($cursoId);
    
        // Pega os encontros daquele curso
        $encontros = Encontro::where('curso_id', $cursoId)->get();
    
        // Passa o curso e os encontros para a view
        return view('formador.encontros', compact('curso', 'encontros'));
    }
    
}

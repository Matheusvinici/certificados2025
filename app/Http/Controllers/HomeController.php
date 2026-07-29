<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Curso;
use App\Models\Inscricao;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = auth()->id();

        $hoje = now()->toDateString();

        $cursosAbertos = Curso::where('ativo', true)
            ->where(function ($q) use ($hoje) {
                $q->whereNull('data_inicio_inscricao')
                    ->orWhere('data_inicio_inscricao', '<=', $hoje);
            })
            ->where(function ($q) use ($hoje) {
                $q->whereNull('data_fim_inscricao')
                    ->orWhere('data_fim_inscricao', '>=', $hoje);
            })
            ->get();

        $cursos = Curso::where('ativo', true)->get();

        $minhasInscricoes = Inscricao::with('curso')
            ->where('user_id', $userId)
            ->get();

        $certificados = Certificado::with('curso')
            ->where('user_id', $userId)
            ->get();

        return view('home', compact('cursosAbertos', 'minhasInscricoes', 'certificados', 'cursos'));
    }
}

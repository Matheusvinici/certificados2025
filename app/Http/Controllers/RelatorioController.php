<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Frequencia;
use App\Models\Inscricao;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function filtroAvaliacoes()
    {
        $cursos = Curso::all();

        return view('relatorios.avaliacoes', compact('cursos'));
    }

    public function gerarRelatorio(Request $request)
    {
        $request->validate(['curso_id' => 'required|exists:cursos,id']);

        $curso = Curso::findOrFail($request->curso_id);

        $dados = Inscricao::with('user')
            ->where('curso_id', $curso->id)
            ->where('status', 'inscrito')
            ->get()
            ->map(function ($inscricao) use ($curso) {
                $frequencias = Frequencia::where('user_id', $inscricao->user_id)
                    ->whereIn('encontro_id', $curso->encontros->pluck('id'))
                    ->get();

                $total = $frequencias->count();
                $avaliadas = $frequencias->filter(fn ($f) => $f->avaliacao_conteudo > 0 && $f->avaliacao_metodologia > 0);

                $mediaConteudo = $avaliadas->avg('avaliacao_conteudo');
                $mediaMetodologia = $avaliadas->avg('avaliacao_metodologia');
                $mediaGeral = $avaliadas->isNotEmpty()
                    ? round(($avaliadas->avg('avaliacao_conteudo') + $avaliadas->avg('avaliacao_metodologia')) / 2, 1)
                    : 0;

                $ultimoComentario = $frequencias->filter(fn ($f) => $f->comentarios)->last();

                return (object) [
                    'nome' => $inscricao->user->name,
                    'secretaria' => $inscricao->user->secretaria,
                    'presencas' => $total,
                    'avaliacoes' => $avaliadas->count(),
                    'media_conteudo' => $mediaConteudo ? round($mediaConteudo, 1) : '-',
                    'media_metodologia' => $mediaMetodologia ? round($mediaMetodologia, 1) : '-',
                    'media_geral' => $mediaGeral,
                    'comentarios' => $ultimoComentario?->comentarios,
                ];
            });

        return view('relatorios.avaliacoes-resultado', compact('curso', 'dados'));
    }
}

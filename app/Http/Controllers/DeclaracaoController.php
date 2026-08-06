<?php

namespace App\Http\Controllers;

use App\Models\Frequencia;
use App\Models\Inscricao;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DeclaracaoController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $inscricoes = Inscricao::with(['curso.encontros', 'curso.responsaveisAssinatura'])
            ->where('user_id', $userId)
            ->get();

        $encontroIds = $inscricoes->flatMap(fn ($i) => $i->curso->encontros->pluck('id'))->unique();

        $frequencias = Frequencia::with('encontro.curso.responsaveisAssinatura')
            ->where('user_id', $userId)
            ->whereIn('encontro_id', $encontroIds)
            ->get()
            ->keyBy('encontro_id');

        return view('declaracoes.index', compact('inscricoes', 'frequencias'));
    }

    public function update(Request $request, Frequencia $frequencia)
    {
        abort_unless($frequencia->user_id === auth()->id() || auth()->user()->role === 'admin', 403);

        $request->validate([
            'hora_inicio' => 'required|date_format:H:i',
            'hora_saida' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        $frequencia->update([
            'hora_inicio' => $request->hora_inicio,
            'hora_saida' => $request->hora_saida,
        ]);

        return redirect()->route('declaracoes.index')->with('success', 'Horários atualizados com sucesso!');
    }

    public function gerarPdf(Frequencia $frequencia)
    {
        abort_unless($frequencia->user_id === auth()->id() || auth()->user()->role === 'admin', 403);

        $frequencia->load('encontro.curso.responsaveisAssinatura', 'user');

        $pdf = Pdf::loadView('declaracoes.comparecimento', compact('frequencia'));

        return $pdf->download('declaracao_comparecimento.pdf');
    }
}

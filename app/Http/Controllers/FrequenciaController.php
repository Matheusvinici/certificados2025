<?php

namespace App\Http\Controllers;

use App\Models\Encontro;
use App\Models\Frequencia;
use Illuminate\Http\Request;

class FrequenciaController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create($inscricaoId)
    {
        return view('frequencias.create', compact('inscricaoId'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hash' => 'required|string',
        ]);

        // Verificar se o hash é válido
        $encontro = Encontro::where('hash', $request->hash)->first();

        if (!$encontro) {
            return redirect()->back()->with('error', 'Código de frequência inválido.');
        }

        // Verificar se o usuário já registrou frequência
        $userId = auth()->id();
        $frequenciaExistente = Frequencia::where('encontro_id', $encontro->id)
            ->where('user_id', $userId)
            ->first();

        if ($frequenciaExistente) {
            return redirect()->back()->with('error', 'Você já registrou presença para este encontro.');
        }

        // Registrar frequência
        Frequencia::create([
            'encontro_id' => $encontro->id,
            'user_id' => $userId,
        ]);

        return redirect()->back()->with('success', 'Frequência registrada com sucesso!');
    }
}

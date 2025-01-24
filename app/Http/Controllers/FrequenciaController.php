<?php

namespace App\Http\Controllers;

use App\Models\Encontro;
use App\Models\Frequencia;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FrequenciaController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    
     public function index(Request $request)
{
    // Captura a escola selecionada
    $escola = $request->input('escola');

    // Filtra os encontros e frequências pela escola selecionada
    $encontros = Encontro::with(['frequencias' => function ($query) use ($escola) {
        if ($escola) {
            // Filtra a frequência pela escola do usuário
            $query->whereHas('user', function ($query) use ($escola) {
                $query->where('escola', $escola);
            });
        }
    }])->get();
    
    // Passa as variáveis para a view
    return view('frequencias.index', compact('encontros', 'escola'));
}

     
    
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

    public function gerarPdf(Request $request)
    {
        // Recupera a escola selecionada no filtro
        $escola = trim($request->input('escola'));

        // Filtra as frequências pela escola selecionada
        $encontros = Encontro::with(['frequencias' => function ($query) use ($escola) {
            if ($escola) {
                $query->whereHas('user', function ($query) use ($escola) {
                    // Ajuste: comparando a escola com o valor do filtro
                    $query->whereRaw('TRIM(escola) = ?', [$escola]);
                });
            }
        }])->get();

        // Gera o PDF com os dados dos encontros filtrados
        $pdf = Pdf::loadView('relatorios.frequencia-pdf', compact('encontros', 'escola'));

        // Retorna o PDF para download
        return $pdf->download('relatorio_frequencias.pdf');
    }
}

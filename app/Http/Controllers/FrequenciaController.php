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
         // Lista fixa de escolas
         $escolasFixas = collect(['Escola Municipal Crenildes', 'Escola Municipal Paulo Vl', 'Escola Municipal Iracema']);
     
         // Pega as escolas distintas da tabela User
         $escolasUsuario = User::distinct()->pluck('escola');
     
         // Junta as duas listas de escolas (fixas e dos usuários) e remove duplicatas
         $escolas = $escolasFixas->merge($escolasUsuario)->unique();
     
         // Pega a escola selecionada do filtro, removendo espaços extras
         $escola = trim($request->input('escola'));
     
         // Recupera os encontros filtrados com base na escola
         $encontros = Encontro::with(['frequencias' => function ($query) use ($escola) {
             if ($escola) {
                 // Filtra os encontros pelos usuários com a escola selecionada
                 $query->whereHas('user', function ($query) use ($escola) {
                     $query->where('escola', $escola); // Filtra pela escola dos usuários diretamente
                 });
             }
         }])->get(); // Recupera todos os encontros
         
         return view('relatorios.frequencia-resultado', compact('encontros', 'escolas'));
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
            'avaliacao_conteudo' => 'required|integer|min:1|max:5',
            'avaliacao_metodologia' => 'required|integer|min:1|max:5',
            'comentarios' => 'nullable|string|max:1000',
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
            'avaliacao_conteudo' => $request->avaliacao_conteudo,
            'avaliacao_metodologia' => $request->avaliacao_metodologia,
            'comentarios' => $request->comentarios,
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

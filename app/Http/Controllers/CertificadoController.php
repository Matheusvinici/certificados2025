<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Curso;
use App\Models\Inscricao;
use App\Models\Frequencia;
use App\Models\Encontro;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificadoController extends Controller
{
    public function index()
    {
        // Verifica o papel do usuário
        $userRole = auth()->user()->role;
    
        // Se o usuário for admin, pode ver todos os certificados
        if ($userRole == 'admin') {
            $certificados = Certificado::with('curso', 'user')->paginate(10);
        }
        // Se o usuário for comum, ele só pode ver seus próprios certificados
        else {
            $certificados = Certificado::with('curso', 'user')
                ->where('user_id', auth()->id()) // Apenas certificados do próprio usuário
                ->paginate(10);
        }
    
        return view('certificados.index', compact('certificados'));
    }
    

    public function create()
    {
        $cursos = Curso::all();
        return view('certificados.create', compact('cursos'));
    }

    public function gerarCertificados(Request $request)
    {
        $cursoId = $request->input('curso_id');
        $curso = Curso::with('encontros')->findOrFail($cursoId);
        $percentualAprovacao = $curso->percentual;
        $totalEncontros = $curso->encontros->count();
        $totalCargaHorariaPorEncontro = $curso->encontros->first()->carga_horaria; // Supondo que todos os encontros têm a mesma carga horária
        $totalCargaHoraria = $totalEncontros * $totalCargaHorariaPorEncontro;
    
        // Calcular o número mínimo de encontros necessários para o certificado
        $minimoEncontrosValidos = ceil(($percentualAprovacao / 100) * $totalEncontros);
    
        // Busca as inscrições para o curso selecionado
        $inscricoes = Inscricao::where('curso_id', $cursoId)->get();
        $certificadosGerados = 0;
    
        foreach ($inscricoes as $inscricao) {
            // Obter os encontros frequentados pelo aluno, validando a hash
            $validHashesCount = 0;
    
            // Pega as frequências de encontro válidas (agora usando user_id em vez de inscricao_id)
            $frequenciasValidas = Frequencia::where('user_id', $inscricao->user_id) // Mudado de 'inscricao_id' para 'user_id'
                ->whereIn('encontro_id', $curso->encontros->pluck('id'))
                ->get();
    
            // Agora, vamos contar quantos encontros o aluno validou com sucesso, ou seja, quantas frequências são válidas
            foreach ($frequenciasValidas as $frequencia) {
                // Verificar se o encontro correspondente tem a hash registrada
                $encontro = Encontro::find($frequencia->encontro_id);
                
                if ($encontro && $encontro->hash) {
                    $validHashesCount++; // Contabiliza se a hash existe para o encontro
                }
            }
    
            // Se o aluno validou o número mínimo de encontros, gera o certificado
            if ($validHashesCount >= $minimoEncontrosValidos) {
                Certificado::firstOrCreate(
                    ['curso_id' => $cursoId, 'user_id' => $inscricao->user_id],
                    ['emitido' => false]
                );
                $certificadosGerados++;
            }
        }
    
        return redirect()->route('certificados.index')->with('success', "{$certificadosGerados} certificados gerados!");
    }
    
    

    public function gerarPdf($id)
    {
        $certificado = Certificado::with('curso', 'user')->findOrFail($id);
        $pdf = Pdf::loadView('certificados.pdf', compact('certificado'))
            ->setPaper('A4', 'landscape');

        return $pdf->download("certificado_{$certificado->user->name}.pdf");
    }
}

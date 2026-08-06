<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Curso;
use App\Models\Encontro;
use App\Models\Frequencia;
use App\Models\Inscricao;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CertificadoController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $userRole = $user->role;

        $this->revogarCertificadosInvalidos();

        if ($userRole !== 'admin') {
            $this->gerarCertificadosPendentes($user);
        }

        $userName = $request->input('user');
        $cursoId = $request->input('curso');

        $query = Certificado::with('curso', 'user');

        if ($userName) {
            $query->whereHas('user', function ($q) use ($userName) {
                $q->where('name', 'like', '%'.$userName.'%');
            });
        }

        if ($cursoId) {
            $query->where('curso_id', $cursoId);
        }

        if ($userRole !== 'admin') {
            $query->where('user_id', $user->id);
        }

        $certificados = $query->paginate(10);

        $cursos = Curso::all();

        $certificadosCount = $cursoId
            ? Certificado::where('curso_id', $cursoId)->count()
            : null;

        return view('certificados.index', compact('certificados', 'cursos', 'certificadosCount'));
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

        $minimoEncontrosValidos = ceil(($percentualAprovacao / 100) * $totalEncontros);

        $inscricoes = Inscricao::where('curso_id', $cursoId)
            ->where('status', 'inscrito')
            ->get();
        $certificadosGerados = 0;

        foreach ($inscricoes as $inscricao) {
            $validHashesCount = 0;

            $frequenciasValidas = Frequencia::where('user_id', $inscricao->user_id)
                ->whereIn('encontro_id', $curso->encontros->pluck('id'))
                ->get();

            foreach ($frequenciasValidas as $frequencia) {
                $encontro = Encontro::find($frequencia->encontro_id);
                if ($encontro && $encontro->hash) {
                    $validHashesCount++;
                }
            }

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

    public function gerarCertificadosPendentes(User $user)
    {
        $inscricoes = Inscricao::with('curso.encontros')
            ->where('user_id', $user->id)
            ->where('status', 'inscrito')
            ->whereNotIn('curso_id', function ($q) use ($user) {
                $q->select('curso_id')->from('certificados')->where('user_id', $user->id);
            })
            ->get();

        $gerados = 0;

        foreach ($inscricoes as $inscricao) {
            $curso = $inscricao->curso;
            $encontros = $curso->encontros;

            if ($encontros->isEmpty()) {
                continue;
            }

            $cargaHorariaTotal = $curso->carga_horaria;
            $percentualMinimo = $curso->percentual;
            $cargaHorariaMinima = ($cargaHorariaTotal * $percentualMinimo) / 100;

            $cargaHorariaCursada = Frequencia::where('user_id', $user->id)
                ->whereIn('encontro_id', $encontros->pluck('id'))
                ->join('encontros', 'frequencias.encontro_id', '=', 'encontros.id')
                ->sum('encontros.carga_horaria_encontro');

            if ($cargaHorariaCursada >= $cargaHorariaMinima) {
                Certificado::firstOrCreate(
                    ['curso_id' => $curso->id, 'user_id' => $user->id],
                    ['emitido' => false]
                );
                $gerados++;
            }
        }

        return $gerados;
    }

    public function gerarPdf($id)
    {
        $certificado = Certificado::with('curso.responsaveisAssinatura', 'user')->findOrFail($id);

        if (! $certificado->emitido) {
            $certificado->update(['emitido' => true]);
        }

        $pdf = Pdf::loadView('certificados.pdf', compact('certificado'))
            ->setPaper('A4', 'landscape');

        return $pdf->download("certificado_{$certificado->user->name}.pdf");
    }

    private function revogarCertificadosInvalidos()
    {
        $certificados = Certificado::with('curso.encontros')->get();

        foreach ($certificados as $certificado) {
            $curso = $certificado->curso;

            if ($curso->encontros->isEmpty()) {
                $certificado->delete();

                continue;
            }

            $percentualMinimo = $curso->percentual;
            $totalEncontros = $curso->encontros->count();
            $minimoEncontrosValidos = ceil(($percentualMinimo / 100) * $totalEncontros);

            $validHashesCount = Frequencia::where('user_id', $certificado->user_id)
                ->whereIn('encontro_id', $curso->encontros->pluck('id'))
                ->get()
                ->filter(function ($frequencia) {
                    $encontro = Encontro::find($frequencia->encontro_id);

                    return $encontro && $encontro->hash;
                })
                ->count();

            if ($validHashesCount < $minimoEncontrosValidos) {
                $certificado->delete();
            }
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Encontro;
use App\Models\Frequencia;
use App\Models\Inscricao;
use App\Models\User;
use Illuminate\Http\Request;

class LeitorFrequenciaController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = auth()->user();
            if (! $user->hasAnyRole(['leitor-frequencia', 'super-admin']) && $user->role != 'admin') {
                abort(403, 'Acesso não autorizado.');
            }

            return $next($request);
        });
    }

    public function index()
    {
        $cursos = Curso::whereHas('encontros', function ($q) {
            $q->whereDate('data', now()->toDateString());
        })->with(['encontros' => function ($q) {
            $q->whereDate('data', now()->toDateString());
        }])->get();

        return view('leitor-frequencia.index', compact('cursos'));
    }

    public function scan($cursoId)
    {
        $curso = Curso::findOrFail($cursoId);
        $encontro = Encontro::where('curso_id', $cursoId)
            ->whereDate('data', now()->toDateString())
            ->first();

        if (! $encontro) {
            return redirect()->route('leitor-frequencia.index')
                ->with('error', 'Nenhum encontro hoje para este curso.');
        }

        $inscricoes = Inscricao::with('user')
            ->where('curso_id', $cursoId)
            ->where('status', 'inscrito')
            ->get();

        $presentes = Frequencia::where('encontro_id', $encontro->id)
            ->pluck('user_id')
            ->toArray();

        return view('leitor-frequencia.scan', compact('curso', 'encontro', 'inscricoes', 'presentes'));
    }

    public function marcarPresenca(Request $request)
    {
        if ($request->inscricao_id) {
            $request->validate(['inscricao_id' => 'required|integer|exists:inscricoes,id']);
            $inscricao = Inscricao::findOrFail($request->inscricao_id);
        } elseif ($request->cpf) {
            $request->validate([
                'cpf' => 'required|string',
                'curso_id' => 'required|integer|exists:cursos,id',
            ]);
            $cpf = preg_replace('/\D/', '', $request->cpf);
            $inscricao = Inscricao::whereHas('user', fn ($q) => $q->where('cpf', $cpf))
                ->where('curso_id', $request->curso_id)
                ->where('status', 'inscrito')
                ->first();
            if (! $inscricao) {
                return response()->json(['error' => 'CPF não encontrado neste curso.'], 400);
            }
        } else {
            return response()->json(['error' => 'Informe o QR Code ou o CPF.'], 400);
        }

        $encontro = Encontro::where('curso_id', $inscricao->curso_id)
            ->whereDate('data', now()->toDateString())
            ->first();

        if (! $encontro) {
            return response()->json(['error' => 'Nenhum encontro hoje para este curso.'], 400);
        }

        $exists = Frequencia::where('encontro_id', $encontro->id)
            ->where('user_id', $inscricao->user_id)
            ->exists();

        if ($exists) {
            return response()->json(['error' => 'Presença já registrada.'], 400);
        }

        Frequencia::create([
            'encontro_id' => $encontro->id,
            'user_id' => $inscricao->user_id,
            'avaliacao_conteudo' => 0,
            'avaliacao_metodologia' => 0,
        ]);

        $user = User::find($inscricao->user_id);
        if ($user) {
            app(CertificadoController::class)->gerarCertificadosPendentes($user);
        }

        return response()->json(['success' => true, 'user_id' => $inscricao->user_id, 'inscricao_id' => $inscricao->id]);
    }
}

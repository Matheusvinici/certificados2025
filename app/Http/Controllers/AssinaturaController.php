<?php

namespace App\Http\Controllers;

use App\Models\Assinatura;
use App\Models\User;
use Illuminate\Http\Request;

class AssinaturaController extends Controller
{
    public function index(Request $request)
    {
        $query = Assinatura::with('user');

        if ($busca = $request->query('busca')) {
            $query->where(function ($q) use ($busca) {
                $q->where('nome', 'like', '%'.$busca.'%')
                    ->orWhere('cargo', 'like', '%'.$busca.'%')
                    ->orWhere('secretaria', 'like', '%'.$busca.'%')
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', '%'.$busca.'%'));
            });
        }

        $assinaturas = $query->latest()->get();

        return view('assinaturas.index', compact('assinaturas'));
    }

    public function create()
    {
        return view('assinaturas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'facilitador' => 'nullable|boolean',
        ]);

        $usuario = User::findOrFail($validated['user_id']);

        $caminho = $request->file('foto')->store('assinaturas', 'public');

        Assinatura::create([
            'user_id' => $usuario->id,
            'nome' => $usuario->name,
            'cargo' => $usuario->cargo,
            'secretaria' => $usuario->secretaria,
            'facilitador' => $request->boolean('facilitador'),
            'foto' => $caminho,
        ]);

        return redirect()->route('assinaturas.index')->with('success', "Assinatura de {$usuario->name} cadastrada com sucesso!");
    }

    public function destroy(Assinatura $assinatura)
    {
        $assinatura->delete();

        return redirect()->route('assinaturas.index')->with('success', 'Assinatura removida com sucesso!');
    }
}

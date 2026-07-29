<?php

namespace App\Http\Controllers;

use App\Models\Secretaria;
use Illuminate\Http\Request;

class SecretariaController extends Controller
{
    public function index()
    {
        $secretarias = Secretaria::orderBy('nome')->paginate(20);

        return view('secretarias.index', compact('secretarias'));
    }

    public function create()
    {
        return view('secretarias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:secretarias,nome',
            'descricao' => 'nullable|string|max:500',
        ]);

        Secretaria::create($request->only('nome', 'descricao'));

        return redirect()->route('secretarias.index')->with('success', 'Secretaria cadastrada com sucesso.');
    }

    public function edit(Secretaria $secretaria)
    {
        return view('secretarias.edit', compact('secretaria'));
    }

    public function update(Request $request, Secretaria $secretaria)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:secretarias,nome,'.$secretaria->id,
            'descricao' => 'nullable|string|max:500',
        ]);

        $secretaria->update($request->only('nome', 'descricao'));

        return redirect()->route('secretarias.index')->with('success', 'Secretaria atualizada com sucesso.');
    }

    public function destroy(Secretaria $secretaria)
    {
        $secretaria->delete();

        return redirect()->route('secretarias.index')->with('success', 'Secretaria excluída com sucesso.');
    }
}

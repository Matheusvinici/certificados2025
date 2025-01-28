<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{

    public function index(Request $request)
    {
        $users = User::paginate();

        $search = $request->query('search'); // Captura o valor da pesquisa

        // Se houver uma pesquisa, filtra os usuários pelo nome
        if ($search) {
            $users = User::where('name', 'like', '%' . $search . '%')->paginate(10);
        } else {
            $users = User::paginate(10); // Caso contrário, exibe todos os usuários
        }
    
        return view('users.index', compact('users'));
    }
    public function edit($id)
    {
        // Encontrar o usuário pelo ID ou gerar um erro 404 caso não encontrado
        $user = User::findOrFail($id);
        // Retornar a view com o usuário para editar
        return view('users.edit', compact('user'));
    }

    // Atualizar os dados do usuário
    public function update(Request $request, $id)
    {
        // Encontrar o usuário pelo ID ou gerar um erro 404 caso não encontrado
        $user = User::findOrFail($id);

        // Validação dos dados recebidos
        $request->validate([
            'name' => 'required|string|max:255', // Valida o nome
            'email' => 'required|email|max:255|unique:users,email,' . $user->id, // Valida o email, permitindo o valor atual
        ]);

        // Atualizando os dados do usuário
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save(); // Salva as alterações no banco de dados

        // Redireciona o administrador de volta à lista de usuários com uma mensagem de sucesso
        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso');
    }
}

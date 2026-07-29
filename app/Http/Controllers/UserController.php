<?php

namespace App\Http\Controllers;

use App\Models\Secretaria;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        if ($search) {
            $users = User::where('name', 'like', '%'.$search.'%')->paginate(10);
        } else {
            $users = User::paginate(10);
        }

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $secretarias = Secretaria::orderBy('nome')->get();

        return view('users.create', compact('roles', 'secretarias'));
    }

    public function store(Request $request)
    {
        $request->merge(['cpf' => preg_replace('/\D/', '', $request->cpf)]);

        $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|size:11|unique:users,cpf',
            'matricula' => 'required|string|max:30|unique:users,matricula',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'roles' => 'nullable|array',
        ]);

        $roles = $request->roles ?? [];
        $legacyRole = $this->resolveLegacyRole($roles);

        $user = User::create([
            'name' => $request->name,
            'cpf' => $request->cpf,
            'matricula' => $request->matricula,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $legacyRole,
        ]);

        if ($roles) {
            $user->syncRoles($roles);
        }

        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso.');
    }

    private function resolveLegacyRole(array $roles): string
    {
        if (in_array('super-admin', $roles)) {
            return 'admin';
        }
        if (in_array('formador', $roles)) {
            return 'formador';
        }

        return 'user';
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $userRoles = $user->roles->pluck('name')->toArray();
        $secretarias = Secretaria::orderBy('nome')->get();

        return view('users.edit', compact('user', 'roles', 'userRoles', 'secretarias'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->merge(['cpf' => preg_replace('/\D/', '', $request->cpf)]);

        $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|size:11|unique:users,cpf,'.$user->id,
            'matricula' => 'required|string|max:30|unique:users,matricula,'.$user->id,
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'roles' => 'nullable|array',
        ]);

        $roles = $request->roles ?? [];
        $legacyRole = $this->resolveLegacyRole($roles);

        $user->name = $request->name;
        $user->cpf = $request->cpf;
        $user->matricula = $request->matricula;
        $user->email = $request->email;
        $user->role = $legacyRole;

        if ($request->password) {
            $request->validate(['password' => 'min:6']);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $user->syncRoles($roles);

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso.');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso.');
    }
}

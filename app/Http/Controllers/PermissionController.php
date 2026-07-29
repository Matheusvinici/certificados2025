<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::with('roles')->paginate(15);

        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:permissions,name']);

        Permission::create(['name' => $request->name]);

        Role::findByName('super-admin')->givePermissionTo($request->name);

        return redirect()->route('permissions.index')->with('success', 'Permissão criada com sucesso.');
    }

    public function edit(Permission $permission)
    {
        $roles = Role::all();

        return view('permissions.edit', compact('permission', 'roles'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate(['name' => 'required|string|unique:permissions,name,'.$permission->id]);

        $permission->name = $request->name;
        $permission->save();

        return redirect()->route('permissions.index')->with('success', 'Permissão atualizada com sucesso.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('permissions.index')->with('success', 'Permissão excluída com sucesso.');
    }

    public function assignToRole(Request $request, Permission $permission)
    {
        $request->validate(['roles' => 'required|array']);

        $permission->syncRoles($request->roles);

        return redirect()->route('permissions.index')->with('success', 'Papéis atualizados para a permissão.');
    }
}

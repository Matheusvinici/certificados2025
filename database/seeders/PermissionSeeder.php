<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        $routes = Route::getRoutes();
        $permissions = [];

        foreach ($routes as $route) {
            $name = $route->getName();
            if ($name && ! str_starts_with($name, 'generated::') && ! str_starts_with($name, 'ignition.')
                && ! str_starts_with($name, 'debugbar') && ! str_starts_with($name, 'login')
                && ! str_starts_with($name, 'logout') && ! str_starts_with($name, 'password')
                && ! str_starts_with($name, 'register') && ! str_starts_with($name, 'verification')
                && ! in_array($name, ['home', 'about', 'profile.show', 'profile.update'])) {
                $permissions[] = $name;
            }
        }

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdmin->syncPermissions(Permission::all());

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $formador = Role::firstOrCreate(['name' => 'formador']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        $admin->syncPermissions($permissions);
    }
}

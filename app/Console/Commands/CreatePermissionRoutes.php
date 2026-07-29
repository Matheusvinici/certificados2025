<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreatePermissionRoutes extends Command
{
    protected $signature = 'permission:create-permission-routes';
    protected $description = 'Scan all named routes and create permissions for them';

    public function handle()
    {
        $this->info('Scanning routes...');

        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        $routes = Route::getRoutes();
        $created = 0;

        $exclude = [
            'generated', 'ignition', 'debugbar', 'login', 'logout',
            'password', 'register', 'verification', 'home', 'about',
            'profile.show', 'profile.update',
        ];

        foreach ($routes as $route) {
            $name = $route->getName();
            if (!$name) continue;

            $skip = false;
            foreach ($exclude as $prefix) {
                if (str_starts_with($name, $prefix)) { $skip = true; break; }
            }
            if ($skip) continue;

            Permission::firstOrCreate(['name' => $name]);
            $created++;
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdmin->syncPermissions(Permission::all());

        $this->info("$created permissions created/updated.");
        $this->info('super-admin now has all permissions.');
    }
}
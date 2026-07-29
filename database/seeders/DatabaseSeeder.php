<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(SecretariaSeeder::class);
        $this->call(AdminUserSeeder::class);
        $this->call(FormadorUserSeeder::class);
        $this->call(PermissionSeeder::class);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1️⃣ Crear roles primero
        $this->call(RoleSeeder::class);

        // 2️⃣ Crear usuario administrador
        $admin = User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@tavocell.com',
            'password' => bcrypt('admin123'),
        ]);

        // 3️⃣ Asignar rol admin
        $admin->assignRole('admin');

    }
}

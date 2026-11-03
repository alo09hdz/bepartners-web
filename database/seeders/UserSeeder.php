<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create(['name' => 'Administrador', 'email' => 'admin@bepartners.mx', 'password' => 'password', 'role' => 'admin']);
        User::create(['name' => 'Líder de Proyecto', 'email' => 'lider@bepartners.mx', 'password' => 'password', 'role' => 'lider']);
        User::create(['name' => 'Integrante Demo', 'email' => 'integrante@bepartners.mx', 'password' => 'password', 'role' => 'integrante']);
    }
}
<?php

namespace Database\Seeders;

use App\Enum\ValidRoles;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            "description" => "Administrador",
            "slug" => ValidRoles::ADMIN,
        ]);

        Role::create([
            "description" => "Cliente",
            "slug" => ValidRoles::CLIENT,
        ]);


        Role::create([
            "description" => "Comercial",
            "slug" => ValidRoles::COMMERCIAL,
        ]);


        Role::create([
            "description" => "Contato",
            "slug" => ValidRoles::CONTACT,
        ]);

        Role::create([
            "description" => "Empresa",
            "slug" => ValidRoles::COMPANY,
        ]);

        Role::create([
            "description" => "Suporte",
            "slug" => ValidRoles::SUPPORT,
        ]);
    }
}

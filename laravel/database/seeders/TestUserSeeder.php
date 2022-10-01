<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enum\ValidRoles;
use App\Services\RoleService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = RoleService::findSlug(ValidRoles::ADMIN);

        $user = User::create([
            "name" => "Test User",
            "email" => "test@7cliques.com.br",
            "password" => Hash::make("cli007"),
        ]);

        $userData = [
            'user_id' => 1,
            'image_id' => null,
            'birthday' => '2000-04-04',
            'telephone' => '0909340192',
            'phone' => '0909340192',
            'marital_status' => 'Casado',
            'schooling' => 'middle school',
            'rg' => '000000',
            'issuer' => null,
            'cpf' => '00000000000'
        ];


        $user->roles()->sync([$role]);

        $user->userData()->create($userData);
    }
}
<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enum\ValidRoles;
use App\Models\Company;
use App\Services\RoleService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RootSeeder extends Seeder
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
            "name" => "Super User",
            "email" => "ruiz@7cliques.com.br",
            "password" => Hash::make("cli#2027"),
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

        $user->userData()->create($userData);

        $user->companies()->sync([1]);
        $user->roles()->sync([$role]);


        $domain = "adminpanelv3.com.br";
        $prefix_pass = substr($domain, 0, 4);
        $user = User::create([
            "name" => "Super User",
            "email" => "admin@$domain",
            "password" => Hash::make("$prefix_pass#9840"),
        ]);

        $user->userData()->create($userData);

        $user->roles()->sync([$role]);
        $user->companies()->sync([1]);
    }
}

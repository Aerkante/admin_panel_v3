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
            "email" => "adminpanelv3@admin.com",
            "password" => Hash::make("secret"),
        ]);

        $userData = [
            'user_id' => 1,
            'image_id' => null,
            'birthday' => '2000-04-04',
            'telephone' => '0909340192',
            'phone' => '0909340192',
            'rg' => '000000',
            'cpf' => '00000000000'
        ];

        $user->userData()->create($userData);

        $user->companies()->sync([1]);
        $user->roles()->sync([$role]);
    }
}

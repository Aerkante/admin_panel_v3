<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            "company" => [
                "trade_name" => "Tudo em Dobro",
                "category_id" => 1,
                "operating_hours" => "Todos os dias das 10:00h às 23:00h ",
                "instagram" => "@7cliques",
                "phone" => "4630552217",
                "status" => 1,
                "image_id" => 1
            ],
            "user" => [
                "name" =>  "Marcos",
                "password" => "cli007",
                "email" => "teste@msn.com",
            ],
            "address" => [
                "street" => "Haroldo Hamilton",
                "neighborhood" => "Centro",
                "number" => 471,
                "city_id" => 200,
                "zip" => 85635000,
                "complement" => "Shopping Panambi"
            ],
        ];

        $companyData = $data["company"];
        $userData = $data["user"];
        $addressData = $data["address"];

        $user = new User();
        $user->fill($userData);
        $user->save();

        $companyData['user_id'] = $user->id;
        $company = new Company();
        $company->fill($companyData);
        $company->save();
        $company->address()->create($addressData);
    }
}

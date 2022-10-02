<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
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
                "trade_name" => "Company Master",
                "instagram" => "@adminpanelv3",
                "phone" => "4630552217",
                "status" => 1,
            ],
            "user" => [
                "name" =>  "Master",
                "password" => "secret",
                "email" => "master@admin.com",
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

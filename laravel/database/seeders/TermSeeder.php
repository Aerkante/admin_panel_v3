<?php

namespace Database\Seeders;

use App\Models\Terms;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "terms" => "Text example",
                "status" => 1,
                "company_id" => 1
            ],
        ];
        $insert = Terms::create($data[0]);
    }
}

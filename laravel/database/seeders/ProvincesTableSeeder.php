<?php

namespace Database\Seeders;

require 'data/provinces.php';

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provinces')->insert(getProvinces());
    }
}
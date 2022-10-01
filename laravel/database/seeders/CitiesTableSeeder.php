<?php

namespace Database\Seeders;

require 'data/cities.php';

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert(getCities());
    }
}
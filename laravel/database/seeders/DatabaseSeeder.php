<?php

namespace Database\Seeders;

use App\Models\Block;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            [
                ProvincesTableSeeder::class,
                CitiesTableSeeder::class,
                RolesTableSeeder::class,
                ImageSeeder::class,
                CompanySeeder::class,
                RootSeeder::class,
                TestUserSeeder::class,
                TermSeeder::class,
            ]
        );
    }
}

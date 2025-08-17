<?php

use Database\Seeders\CountriesSeeder;
use Database\Seeders\MonthSeeder;
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
        $this->call(CountriesSeeder::class);
        $this->call(MonthSeeder::class);
    }
}

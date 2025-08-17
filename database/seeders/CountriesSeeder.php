<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->delete();

        $countries = array(
            array('iso' => 'IN', 'name' => 'India', 'iso3' => 'IND', 'numcode' => '356', 'phonecode' => '91'),
        );

        DB::table('countries')->insert($countries);
    }
}

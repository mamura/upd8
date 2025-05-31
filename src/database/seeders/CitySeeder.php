<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        City::insert([
            ['name' => 'Fortaleza'],
            ['name' => 'João Pessoa'],
            ['name' => 'Mossoró'],
            ['name' => 'Sobral'],
            ['name' => 'Recife']
        ]);
    }
}

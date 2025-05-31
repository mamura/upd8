<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Client::insert([
            ['name' => 'Osborn Corp', 'city_id' => 1],
            ['name' => 'Google', 'city_id' => 2],
            ['name' => 'Upd8', 'city_id' => 3],
            ['name' => 'Mercantil Dois Irmões', 'city_id' => 4],
            ['name' => 'Dragon Bar', 'city_id' => 5]
        ]);
    }
}

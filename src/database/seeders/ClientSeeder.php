<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Client;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('pt_BR');
        $cities = City::all();

        for ($i = 0; $i < 10; $i++) {
            Client::create([
                'name'      => $faker->name,
                'cpf'       => $faker->numerify('###.###.###-##'),
                'birthdate' => $faker->date('Y-m-d'),
                'gender'    => $faker->randomElement(['Masculino', 'Feminino']),
                'address'   => $faker->streetAddress(),
                'state'     => $faker->state(),
                'city_id'   => $cities->random()->id,
            ]);
        }
    }
}

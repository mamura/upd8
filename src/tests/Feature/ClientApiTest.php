<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\City;
use App\Models\Client;

uses(RefreshDatabase::class);

test('filtra clientes por múltiplos campos', function () {
    $city = City::create(['name' => 'São Paulo']);

    Client::create([
        'name' => 'Maria da Silva',
        'cpf' => '123.456.789-00',
        'birthdate' => '1990-01-01',
        'gender' => 'Feminino',
        'address' => 'Rua A',
        'state' => 'SP',
        'city_id' => $city->id,
    ]);

    Client::create([
        'name' => 'João Pereira',
        'cpf' => '987.654.321-00',
        'birthdate' => '1985-05-10',
        'gender' => 'Masculino',
        'address' => 'Rua B',
        'state' => 'RJ',
        'city_id' => $city->id,
    ]);

    $response = $this->getJson('/api/clients?' . http_build_query([
        'name' => 'Maria',
        'cpf' => '123.456.789-00',
        'birthdate' => '1990-01-01',
        'gender' => 'Feminino',
        'state' => 'SP',
        'city_id' => $city->id,
    ]));

    $response->assertOk();
    $response->assertJsonCount(1);
    $response->assertJsonFragment(['name' => 'Maria da Silva']);
});

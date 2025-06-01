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

test('cria um novo cliente com sucesso', function () {
    $city = City::create(['name' => 'Campinas']);

    $data = [
        'name' => 'Ana Souza',
        'cpf' => '111.222.333-44',
        'birthdate' => '1995-07-20',
        'gender' => 'Feminino',
        'address' => 'Rua das Flores, 123',
        'state' => 'SP',
        'city_id' => $city->id,
    ];

    $response = $this->postJson('/api/clients', $data);

    $response->assertCreated(); // status 201
    $response->assertJsonFragment([
        'name' => 'Ana Souza',
        'cpf' => '111.222.333-44',
    ]);

    $this->assertDatabaseHas('clients', [
        'name' => 'Ana Souza',
        'cpf' => '111.222.333-44',
    ]);
});

test('retorna um cliente específico com seus dados completos', function () {
    $city = City::create(['name' => 'Curitiba']);

    $client = \App\Models\Client::create([
        'name' => 'Carlos Eduardo',
        'cpf' => '222.333.444-55',
        'birthdate' => '1988-03-15',
        'gender' => 'Masculino',
        'address' => 'Av. Brasil, 456',
        'state' => 'PR',
        'city_id' => $city->id,
    ]);

    $response = $this->getJson("/api/clients/{$client->id}");

    $response->assertOk();
    $response->assertJsonFragment([
        'name' => 'Carlos Eduardo',
        'cpf' => '222.333.444-55',
        'gender' => 'Masculino',
        'address' => 'Av. Brasil, 456',
        'state' => 'PR',
        'city_id' => $city->id,
    ]);
});

test('atualiza um cliente com sucesso', function () {
    $city = City::create(['name' => 'Recife']);

    $client = \App\Models\Client::create([
        'name' => 'Juliana Lopes',
        'cpf' => '555.666.777-88',
        'birthdate' => '1992-11-30',
        'gender' => 'Feminino',
        'address' => 'Rua Verde, 999',
        'state' => 'PE',
        'city_id' => $city->id,
    ]);

    $updateData = [
        'name' => 'Juliana Oliveira',
        'cpf' => '555.666.777-88',
        'birthdate' => '1992-11-30',
        'gender' => 'Feminino',
        'address' => 'Rua Azul, 1000',
        'state' => 'PE',
        'city_id' => $city->id,
    ];

    $response = $this->putJson("/api/clients/{$client->id}", $updateData);

    $response->assertOk();
    $response->assertJsonFragment([
        'name' => 'Juliana Oliveira',
        'address' => 'Rua Azul, 1000',
    ]);

    $this->assertDatabaseHas('clients', [
        'id' => $client->id,
        'name' => 'Juliana Oliveira',
        'address' => 'Rua Azul, 1000',
    ]);
});

test('exclui um cliente com sucesso', function () {
    $city = City::create(['name' => 'Natal']);

    $client = \App\Models\Client::create([
        'name' => 'Pedro Martins',
        'cpf' => '999.888.777-66',
        'birthdate' => '1980-09-15',
        'gender' => 'Masculino',
        'address' => 'Rua do Sol, 222',
        'state' => 'RN',
        'city_id' => $city->id,
    ]);

    $response = $this->deleteJson("/api/clients/{$client->id}");

    $response->assertNoContent(); // 204

    $this->assertDatabaseMissing('clients', [
        'id' => $client->id,
    ]);
});

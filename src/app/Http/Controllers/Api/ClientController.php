<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::with('city');

        if ($request->filled('cpf')) {
            $query->where('cpf', 'like', '%' . $request->cpf . '%');
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('birthdate')) {
            $query->whereDate('birthdate', $request->birthdate);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('state')) {
            $query->where('state', 'like', '%' . $request->state . '%');
        }

        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        return $query->get();

    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'cpf'       => 'required|string|max:20',
            'birthdate' => 'nullable|date',
            'gender'    => 'nullable|in:Masculino,Feminino',
            'address'   => 'nullable|string|max:255',
            'state'     => 'nullable|string|max:255',
            'city_id'   => 'required|exists:cities,id'
        ]);

        return Client::create($data);
    }

    public function show(Client $client)
    {
        return $client->load('city');
    }

    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'cpf'       => 'required|string|max:20',
            'birthdate' => 'nullable|date',
            'gender'    => 'nullable|in:Masculino,Feminino',
            'address'   => 'nullable|string|max:255',
            'state'     => 'nullable|string|max:255',
            'city_id'   => 'required|exists:cities,id'
        ]);

        $client->update($data);

        return $client;
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return response()->noContent();
    }
}

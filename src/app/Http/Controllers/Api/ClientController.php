<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return Client::with('city')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string',
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
            'name'      => 'required|string',
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

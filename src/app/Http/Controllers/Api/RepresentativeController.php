<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Client;
use App\Models\Representative;
use Illuminate\Http\Request;

class RepresentativeController extends Controller
{
    public function index()
    {
        return Representative::with('cities')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'requided|string'
        ]);
        $rep = Representative::create($data);

        if($request->has('cities')) {
            $rep->cities()->sync($request->cities);
        }

        return $rep->load('cities');
    }

    public function show(Representative $representative)
    {
        return $representative->load('cities');
    }

    public function update(Request $request, Representative $representative)
    {
        $data = $request->validate([
            'name' => 'requided|string'
        ]);
        $representative->update($data);

        if($request->has('cities')) {
            $representative->cities()->sync($request->cities);
        }

        return $representative->load('cities');
    }

    public function destroy(Representative $representative)
    {
        $representative->delete();

        return response()->noContent();
    }

    public function byClient(Client $client)
    {
        return $client->city->representatives;
    }

    public function byCity(City $city)
    {
        return $city->representatives;
    }

}

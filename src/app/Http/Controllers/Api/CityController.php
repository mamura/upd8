<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        return City::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string'
        ]);

        return City::create($data);
    }

    public function show(City $city)
    {
        return $city;
    }

    public function update(Request $request, City $city)
    {
        $data = $request->validate([
            'name' => 'required|string'
        ]);

        $city->update($data);

        return $city;
    }

    public function destroy(City $city)
    {
        $city->delete();

        return response()->noContent();
    }
}

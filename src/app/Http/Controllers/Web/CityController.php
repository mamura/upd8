<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class CityController extends Controller
{
    public function index()
    {
        return view('cities.index');
    }

    public function create()
    {
        return view('cities.create');
    }
    
    public function edit($id)
    {
        return view('cities.edit')->with('cityId', $id);
    }
}

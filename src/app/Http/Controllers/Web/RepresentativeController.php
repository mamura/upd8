<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class RepresentativeController extends Controller
{
    public function index()
    {
        return view('representatives.index');
    }

    public function create()
    {
        return view('representatives.create');
    }

    public function edit($id)
    {
        return view('representatives.edit')->with('representativeId', $id);
    }
}

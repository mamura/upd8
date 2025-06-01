<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    public function index()
    {
        return view('clients.index');
    }

    public function create()
    {
        return view('clients.create');
    }

    public function edit($id)
    {
        return view('clients.edit')->with('clientId', $id);
    }
}

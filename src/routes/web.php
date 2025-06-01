<?php

use App\Http\Controllers\Web\ClientController;
use App\Http\Controllers\Web\RepresentativeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});


Route::get('/clientes', [ClientController::class, 'index'])->name('clientes.index');
Route::get('/clientes/novo', [ClientController::class, 'create'])->name('clientes.create');
Route::get('/clientes/{id}/editar', [ClientController::class, 'edit'])->name('clientes.edit');

Route::get('/representantes', [RepresentativeController::class, 'index'])->name('representantes.index');
Route::get('/representantes/novo', [RepresentativeController::class, 'create'])->name('representantes.create');
Route::get('/representantes/{id}/editar', [RepresentativeController::class, 'edit'])->name('representantes.edit');

Route::get('/cidades', [\App\Http\Controllers\Web\CityController::class, 'index'])->name('cidades.index');
Route::get('/cidades/novo', [\App\Http\Controllers\Web\CityController::class, 'create'])->name('cidades.create');
Route::get('/cidades/{id}/editar', [\App\Http\Controllers\Web\CityController::class, 'edit'])->name('cidades.edit');

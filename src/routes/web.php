<?php

use App\Http\Controllers\Web\ClientWebController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/clientes', [ClientWebController::class, 'index'])->name('clientes.index');
Route::get('/clientes/novo', [ClientWebController::class, 'create'])->name('clientes.create');
Route::get('/clientes/{id}/editar', [ClientWebController::class, 'edit'])->name('clientes.edit');

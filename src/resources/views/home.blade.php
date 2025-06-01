@extends('layouts.app')

@section('content')
<main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-3xl font-semibold text-gray-800 mb-8">Sistema de Cadastro</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="/clientes" class="block bg-white border border-gray-200 shadow hover:shadow-md rounded-lg p-6 text-center transition">
            <h2 class="text-xl font-bold text-teal-600 mb-2">Clientes</h2>
            <p class="text-sm text-gray-600">Gerencie os clientes cadastrados.</p>
        </a>

        <a href="/representantes" class="block bg-white border border-gray-200 shadow hover:shadow-md rounded-lg p-6 text-center transition">
            <h2 class="text-xl font-bold text-teal-600 mb-2">Representantes</h2>
            <p class="text-sm text-gray-600">Visualize e edite representantes.</p>
        </a>

        <a href="/cidades" class="block bg-white border border-gray-200 shadow hover:shadow-md rounded-lg p-6 text-center transition">
            <h2 class="text-xl font-bold text-teal-600 mb-2">Cidades</h2>
            <p class="text-sm text-gray-600">Cadastre e atualize cidades.</p>
        </a>
    </div>
</main>
@endsection

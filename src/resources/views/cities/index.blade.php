@extends('layouts.app')

@section('content')
<main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-gray-800">Cidades</h2>
        <a href="/cidades/novo" class="inline-block bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium px-4 py-[10px] rounded">+ Nova Cidade</a>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2 border-b">ID</th>
                    <th class="px-4 py-2 border-b">Nome</th>
                    <th class="px-4 py-2 border-b">Ações</th>
                </tr>
            </thead>
            <tbody id="city-list">
                <!-- Conteúdo carregado via JS -->
            </tbody>
        </table>
    </div>
</main>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const res = await fetch('/api/cities');
        const cities = await res.json();

        const tbody = document.getElementById('city-list');
        cities.forEach(city => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="px-4 py-2 border-b text-sm text-gray-700">${city.id}</td>
                <td class="px-4 py-2 border-b text-sm text-gray-700">${city.name}</td>
                <td class="px-4 py-2 border-b text-sm text-gray-700 space-x-2">
                    <a href="/cidades/${city.id}/editar" class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded hover:bg-blue-200 text-xs">Editar</a>
                    <button onclick="deleteCity(${city.id})" class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded hover:bg-red-200 text-xs">Excluir</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    });

    async function deleteCity(id) {
        if (!confirm('Tem certeza que deseja excluir esta cidade?')) return;

        const response = await fetch(`/api/cities/${id}`, {
            method: 'DELETE'
        });

        if (response.ok) {
            location.reload();
        } else {
            alert('Erro ao excluir cidade.');
        }
    }
</script>
@endsection

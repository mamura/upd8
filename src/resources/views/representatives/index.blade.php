<!-- resources/views/representatives/index.blade.php -->

@extends('layouts.app')

@section('content')
<main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Representantes</h2>
        <a href="/representantes/novo" class="inline-block bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium px-4 py-[10px] rounded">+ Novo Representante</a>
    </div>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="flex flex-wrap gap-4 items-end">
            <div class="flex flex-col">
                <label class="block text-sm text-gray-700 mb-1">Filtrar por Cidade</label>
                <select id="filter-city" class="text-sm border border-gray-300 rounded px-3 py-2 min-w-[200px] bg-white">
                    <option value="">Todas</option>
                </select>
            </div>
            <div class="flex flex-col">
                <label class="block text-sm text-gray-700 mb-1">Filtrar por Cliente</label>
                <select id="filter-client" class="text-sm border border-gray-300 rounded px-3 py-2 min-w-[200px] bg-white">
                    <option value="">Todos</option>
                </select>
            </div>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2 border-b">ID</th>
                    <th class="px-4 py-2 border-b">Nome</th>
                    <th class="px-4 py-2 border-b">Cidades</th>
                    <th class="px-4 py-2 border-b">Clientes</th>
                    <th class="px-4 py-2 border-b">Ações</th>
                </tr>
            </thead>
            <tbody id="rep-list">
                <!-- Conteúdo carregado via JS -->
            </tbody>
        </table>
    </div>
</main>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        await loadFilters();
        await loadReps();

        // Adiciona escuta para mudar os filtros automaticamente
        document.getElementById('filter-city').addEventListener('change', loadReps);
        document.getElementById('filter-client').addEventListener('change', loadReps);
    });

    async function loadFilters() {
        const [cities, clients] = await Promise.all([
            fetch('/api/cities').then(r => r.json()),
            fetch('/api/clients').then(r => r.json())
        ]);

        cities.forEach(c => {
            const opt = new Option(c.name, c.id);
            document.getElementById('filter-city').appendChild(opt);
        });

        clients.forEach(c => {
            const opt = new Option(c.name, c.id);
            document.getElementById('filter-client').appendChild(opt);
        });
    }

    async function loadReps() {
        const cityId = document.getElementById('filter-city').value;
        const clientId = document.getElementById('filter-client').value;

        const params = new URLSearchParams();
        if (cityId) params.append('city_id', cityId);
        if (clientId) params.append('client_id', clientId);

        const res = await fetch(`/api/representatives?${params.toString()}`);
        const reps = await res.json();

        const tbody = document.getElementById('rep-list');
        if (!tbody) return;

        tbody.innerHTML = '';

        reps.forEach(rep => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="px-4 py-2 border-b text-sm text-gray-700">${rep.id}</td>
                <td class="px-4 py-2 border-b text-sm text-gray-700">${rep.name}</td>
                <td class="px-4 py-2 border-b text-sm text-gray-700">${(rep.cities || []).map(c => c.name).join(', ')}</td>
                <td class="px-4 py-2 border-b text-sm text-gray-700">${(rep.clients || []).map(c => c.name).join(', ')}</td>
                <td class="px-4 py-2 border-b text-sm text-gray-700 space-x-2">
                    <a href="/representantes/${rep.id}/editar" class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded hover:bg-blue-200 text-xs">Editar</a>
                    <button onclick="deleteRepresentative(${rep.id})" class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded hover:bg-red-200 text-xs">Excluir</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    async function deleteRepresentative(id) {
        if (!confirm('Tem certeza que deseja excluir este representante?')) return;

        const response = await fetch(`/api/representatives/${id}`, {
            method: 'DELETE'
        });

        if (response.ok) {
            await loadReps();
        } else {
            alert('Erro ao excluir representante.');
        }
    }
</script>
@endsection

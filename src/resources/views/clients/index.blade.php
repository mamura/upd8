@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div id="form-feedback" class="mb-4 hidden text-sm font-medium"></div>
    
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-gray-800 leading-none">Clientes</h2>
        <a href="/clientes/novo" class="inline-block bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium px-4 py-[10px] rounded">+ Novo Cliente</a>
    </div>

    <div class="bg-white border border-gray-300 shadow rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end">
            <div class="md:col-span-2">
                <label class="block text-sm text-gray-700">CPF</label>
                <input type="text" id="filter-cpf" class="mt-1 w-full h-10 border border-gray-300 rounded px-3 text-sm" placeholder="000.000.000-00">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm text-gray-700">Nome</label>
                <input type="text" id="filter-name" class="mt-1 w-full h-10 border border-gray-300 rounded px-3 text-sm">
            </div>
            <div>
                <label class="block text-sm text-gray-700">Data Nasc.</label>
                <input type="date" id="filter-birthdate" class="mt-1 w-full h-10 border border-gray-300 rounded px-3 text-sm">
            </div>
            <div>
                <label class="block text-sm text-gray-700">Sexo</label>
                <select id="filter-gender" class="mt-1 w-full h-10 border border-gray-300 rounded px-3 text-sm">
                    <option value="">Todos</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Feminino">Feminino</option>
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-700">Estado</label>
                <input type="text" id="filter-state" class="mt-1 w-full h-10 border border-gray-300 rounded px-3 text-sm">
            </div>
            <div>
                <label class="block text-sm text-gray-700">Cidade</label>
                <select id="filter-city" class="mt-1 w-full h-10 border border-gray-300 rounded px-3 text-sm">
                    <option value="">Todos</option>
                </select>
            </div>
            <div class="md:col-span-2 flex gap-2">
                <button id="filter-btn" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded">Pesquisar</button>
                <button id="clear-btn" class="bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm font-medium px-4 py-2 rounded">Limpar</button>
            </div>
        </div>
    </div>


    <div class="bg-white border border-gray-300 shadow rounded-lg p-6">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-3 py-2">Cliente</th>
                    <th class="px-3 py-2">CPF</th>
                    <th class="px-3 py-2">Data Nasc.</th>
                    <th class="px-3 py-2">Estado</th>
                    <th class="px-3 py-2">Cidade</th>
                    <th class="px-3 py-2">Sexo</th>
                    <th class="px-3 py-2 text-right">Ações</th>
                </tr>
            </thead>
            <tbody id="client-list">
                <!-- Preenchido via JS -->
            </tbody>
        </table>
    </div>
</main>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const citySelect = document.getElementById('filter-city');
        const res = await fetch('/api/cities');
        const cities = await res.json();
        cities.forEach(c => {
            const opt = document.createElement('option');
            opt.value = c.id;
            opt.textContent = c.name;
            citySelect.appendChild(opt);
        });

        document.getElementById('filter-btn').addEventListener('click', loadClients);
        document.getElementById('clear-btn').addEventListener('click', () => {
            document.querySelectorAll('#filter-cpf, #filter-name, #filter-birthdate, #filter-state').forEach(el => el.value = '');
            document.getElementById('filter-gender').value = '';
            document.getElementById('filter-city').value = '';
            loadClients();
        });

        loadClients();
    });

    async function loadClients() {
        const params = new URLSearchParams({
            cpf: document.getElementById('filter-cpf').value,
            name: document.getElementById('filter-name').value,
            birthdate: document.getElementById('filter-birthdate').value,
            gender: document.getElementById('filter-gender').value,
            state: document.getElementById('filter-state').value,
            city_id: document.getElementById('filter-city').value
        });

        const res = await fetch('/api/clients?' + params.toString());
        const clients = await res.json();

        const tbody = document.getElementById('client-list');
        tbody.innerHTML = '';

        clients.forEach(client => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="px-3 py-2">${client.name}</td>
                <td class="px-3 py-2">${client.cpf}</td>
                <td class="px-3 py-2">${client.birthdate || ''}</td>
                <td class="px-3 py-2">${client.state || ''}</td>
                <td class="px-3 py-2">${client.city?.name || ''}</td>
                <td class="px-3 py-2">${client.gender?.[0] || ''}</td>
                <td class="px-3 py-2 text-right space-x-2">
                    <a href="/clientes/${client.id}/editar" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs">Editar</a>
                    <button onclick="deleteClient(${client.id})" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">Excluir</button>
                </td>`;
            tbody.appendChild(tr);
        });
    }

    async function deleteClient(id) {
        if (!confirm('Tem certeza que deseja excluir este cliente?')) return;

        const res = await fetch(`/api/clients/${id}`, {
            method: 'DELETE'
        });

        if (res.ok) {
            loadClients();
        } else {
            alert('Erro ao excluir cliente.');
        }
    }
</script>
@endsection
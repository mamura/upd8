@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div id="form-feedback" class="mb-4 hidden text-sm font-medium"></div>
    
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-gray-800 leading-none">Clientes</h2>
        <a href="/clientes/novo" class="inline-block bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium px-4 py-[10px] rounded">+ Novo Cliente</a>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2 border-b">ID</th>
                    <th class="px-4 py-2 border-b">Nome</th>
                    <th class="px-4 py-2 border-b">Cidade</th>
                    <th class="px-4 py-2 border-b">Ações</th>
                </tr>
            </thead>
            <tbody id="client-list">
                <!-- Conteúdo carregado via JS -->
            </tbody>
        </table>
    </div>
</main>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const res       = await fetch('/api/clients');
        const clients   = await res.json();

        const list      = document.getElementById('client-list');

        clients.forEach(client => {
            const row       = document.createElement('tr');
            row.innerHTML = `
                <td class="px-4 py-2 border-b">${client.id}</td>
                <td class="px-4 py-2 border-b">${client.name}</td>
                <td class="px-4 py-2 border-b">${client.city.name}</td>
                <td class="px-4 py-2 border-b text-sm text-gray-700 space-x-2">
                    <a href="/clientes/${client.id}/editar" class="inline-block px-3 py-1 bg-blue-400 text-white rounded hover:bg-blue-500 text-xs">Editar</a>
                    <button onclick=\"deleteClient(${client.id})\" class="inline-block px-3 py-1 bg-red-400 text-white rounded hover:bg-red-500 text-xs">Excluir</button>
                </td>
            `;
            list.appendChild(row);
        });
    });

    async function deleteClient(id) {
        if (!confirm('Tem certeaza que deseja excluir este cliente?')) {
            return;
        }

        const response = await fetch(`/api/clients/${id}`, {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' }
        });

        if (response.ok) {
            const feedback = document.getElementById('form-feedback');
            feedback.className = 'mb-4 text-green-700 bg-green-100 border border-green-300 px-4 py-2 rounded';
            feedback.textContent = 'Cliente cadastrado com sucesso! Redirecionando...';
            setTimeout(() => window.location.reload(), 1500);
        } else {
            const error = await response.json();
            alert(`Erro ao excluir cliente: ${error.message}`);
        }
    }
</script>
@endsection
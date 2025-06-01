@extends('layouts.app')

@section('content')
<main class="flex justify-center px-4 py-10">
    <div class="w-full max-w-lg">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Editar Cliente</h2>

        <div id="form-feedback" class="mb-4 hidden text-sm font-medium"></div>
        <form id="client-form" class="space-y-6 bg-white shadow rounded-lg p-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                <input type="text" id="name" name="name" required
                       class="mt-1 block w-full rounded-md border border-gray-300 bg-white shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm h-11 px-3">
            </div>

            <div>
                <label for="city_id" class="block text-sm font-medium text-gray-700">Cidade</label>
                <select id="city_id" name="city_id" required
                        class="mt-1 block w-full rounded-md border border-gray-300 bg-white shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm h-11 px-3">
                    <option value="">Carregando...</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="bg-teal-600 hover:bg-teal-700 text-white font-medium px-6 py-2 rounded text-sm">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</main>
@endsection

@section('scripts')
<script>
    const clientId = {{ $clientId }};

    document.addEventListener('DOMContentLoaded', async () => {
        const citySelect = document.getElementById('city_id');
        const nameInput = document.getElementById('name');

        const [cityRes, clientRes] = await Promise.all([
            fetch('/api/cities'),
            fetch(`/api/clients/${clientId}`)
        ]);

        const cities = await cityRes.json();
        const client = await clientRes.json();

        nameInput.value = client.name;

        citySelect.innerHTML = '<option value="">Selecione uma cidade</option>';
        cities.forEach(city => {
            const option = document.createElement('option');
            option.value = city.id;
            option.textContent = city.name;
            if (city.id === client.city_id) {
                option.selected = true;
            }
            citySelect.appendChild(option);
        });

        document.getElementById('client-form').addEventListener('submit', async (e) => {
            e.preventDefault();

            const data = {
                name: nameInput.value,
                city_id: citySelect.value
            };

            const response = await fetch(`/api/clients/${clientId}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            const feedback = document.getElementById('form-feedback');
            if (response.ok) {
                feedback.className = 'mb-4 text-green-700 bg-green-100 border border-green-300 px-4 py-2 rounded';
                feedback.textContent = 'Cliente atualizado com sucesso!';
                setTimeout(() => window.location.href = '/clientes', 1500);
            } else {
                feedback.className = 'mb-4 text-red-700 bg-red-100 border border-red-300 px-4 py-2 rounded';
                feedback.textContent = 'Erro ao atualizar cliente. Verifique os dados e tente novamente.';
            }
        });
    });
</script>
@endsection
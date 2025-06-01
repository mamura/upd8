@extends('layouts.app')

@section('content')
<main class="flex justify-center px-4 py-10">
    <div class="w-full max-w-lg">
        <div id="form-feedback" class="mb-4 hidden text-sm font-medium"></div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Novo Cliente</h2>

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
                    Salvar
                </button>
            </div>
        </form>
    </div>
</main>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', async () => {
    const citySelect = document.getElementById('city_id');
    const res        = await fetch('/api/cities');
    const cities     = await res.json();

    citySelect.innerHTML = '<option value="">Selecione uma cidade</option>';
    cities.forEach(city => {
        const option        = document.createElement('option');
        option.value        = city.id;
        option.textContent  = city.name;
        citySelect.appendChild(option);
    });

    document.getElementById('client-form').addEventListener('submit', async (e) => {
        e.preventDefault();

        const data = {
            name: document.getElementById('name').value,
            city_id: document.getElementById('city_id').value
        };

        const response = await fetch('/api/clients', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        if (response.ok) {
            const feedback = document.getElementById('form-feedback');
            feedback.className = 'mb-4 text-green-700 bg-green-100 border border-green-300 px-4 py-2 rounded';
            feedback.textContent = 'Cliente cadastrado com sucesso! Redirecionando...';
            setTimeout(() => window.location.href = '/clientes', 1500);
        } else {
            const feedback = document.getElementById('form-feedback');
            feedback.className = 'mb-4 text-red-700 bg-red-100 border border-red-300 px-4 py-2 rounded';
            feedback.textContent = 'Erro ao salvar cliente. Verifique os dados e tente novamente.';
        }
    });
});
</script>
@endsection
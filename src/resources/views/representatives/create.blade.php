<!-- resources/views/representatives/create.blade.php -->

@extends('layouts.app')

@section('content')
<main class="flex justify-center px-4 py-10">
    <div class="w-full max-w-lg">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Novo Representante</h2>

        <div id="form-feedback" class="mb-4 hidden text-sm font-medium"></div>
        <form id="rep-form" class="space-y-6 bg-white shadow rounded-lg p-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                <input type="text" id="name" name="name" required
                       class="mt-1 block w-full rounded-md border border-gray-300 bg-white shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm h-11 px-3">
            </div>

            <div>
                <label for="cities" class="block text-sm font-medium text-gray-700">Cidades Atendidas</label>
                <select id="cities" name="cities[]" multiple required
                        class="mt-1 block w-full rounded-md border border-gray-300 bg-white shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm h-40 px-3">
                    <!-- opções via JS -->
                </select>
                <p class="text-xs text-gray-500 mt-1">Segure Ctrl (Windows) ou Cmd (Mac) para selecionar múltiplas cidades.</p>
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
        const citySelect = document.getElementById('cities');
        const res = await fetch('/api/cities');
        const cities = await res.json();

        cities.forEach(city => {
            const option = document.createElement('option');
            option.value = city.id;
            option.textContent = city.name;
            citySelect.appendChild(option);
        });

        document.getElementById('rep-form').addEventListener('submit', async (e) => {
            e.preventDefault();

            const selected = [...citySelect.selectedOptions].map(opt => opt.value);
            const data = {
                name: document.getElementById('name').value,
                cities: selected
            };

            const response = await fetch('/api/representatives', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            const feedback = document.getElementById('form-feedback');
            if (response.ok) {
                feedback.className = 'mb-4 text-green-700 bg-green-100 border border-green-300 px-4 py-2 rounded';
                feedback.textContent = 'Representante cadastrado com sucesso! Redirecionando...';
                setTimeout(() => window.location.href = '/representantes', 1500);
            } else {
                feedback.className = 'mb-4 text-red-700 bg-red-100 border border-red-300 px-4 py-2 rounded';
                feedback.textContent = 'Erro ao salvar representante. Verifique os dados.';
            }
        });
    });
</script>
@endsection

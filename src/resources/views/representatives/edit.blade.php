@extends('layouts.app')

@section('content')
<main class="flex justify-center px-4 py-10">
    <div class="w-full max-w-lg">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Editar Representante</h2>

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
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</main>
@endsection

@section('scripts')
<script>
    const repId = {{ $representativeId }};

    document.addEventListener('DOMContentLoaded', async () => {
        const nameInput = document.getElementById('name');
        const citySelect = document.getElementById('cities');

        const [repRes, citiesRes] = await Promise.all([
            fetch(`/api/representatives/${repId}`),
            fetch('/api/cities')
        ]);

        const rep = await repRes.json();
        const cities = await citiesRes.json();

        nameInput.value = rep.name;

        cities.forEach(city => {
            const option = document.createElement('option');
            option.value = city.id;
            option.textContent = city.name;
            if (rep.cities.some(c => c.id === city.id)) {
                option.selected = true;
            }
            citySelect.appendChild(option);
        });

        document.getElementById('rep-form').addEventListener('submit', async (e) => {
            e.preventDefault();

            const selected = [...citySelect.selectedOptions].map(opt => opt.value);
            const data = {
                name: nameInput.value,
                cities: selected
            };

            const response = await fetch(`/api/representatives/${repId}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            const feedback = document.getElementById('form-feedback');
            if (response.ok) {
                feedback.className = 'mb-4 text-green-700 bg-green-100 border border-green-300 px-4 py-2 rounded';
                feedback.textContent = 'Alterações salvas com sucesso!';
                setTimeout(() => window.location.href = '/representantes', 1500);
            } else {
                feedback.className = 'mb-4 text-red-700 bg-red-100 border border-red-300 px-4 py-2 rounded';
                feedback.textContent = 'Erro ao salvar alterações.';
            }
        });

        async function deleteRepresentative(id) {
            if (!confirm('Tem certeza que deseja excluir este representante?')) return;

            const response = await fetch(`/api/representatives/${id}`, {
                method: 'DELETE'
            });

            if (response.ok) {
                location.reload();
            } else {
                alert('Erro ao excluir representante.');
            }
        }
    });
</script>
@endsection

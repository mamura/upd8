@extends('layouts.app')

@section('content')
<main class="flex justify-center px-4 py-10">
    <div class="w-full max-w-lg">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Nova Cidade</h2>

        <div id="form-feedback" class="mb-4 hidden text-sm font-medium"></div>
        <form id="city-form" class="space-y-6 bg-white shadow rounded-lg p-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                <input type="text" id="name" name="name" required
                       class="mt-1 block w-full rounded-md border border-gray-300 bg-white shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm h-11 px-3">
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
    document.getElementById('city-form').addEventListener('submit', async (e) => {
        e.preventDefault();

        const name = document.getElementById('name').value;
        const feedback = document.getElementById('form-feedback');

        const response = await fetch('/api/cities', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name })
        });

        if (response.ok) {
            feedback.className = 'mb-4 text-green-700 bg-green-100 border border-green-300 px-4 py-2 rounded';
            feedback.textContent = 'Cidade cadastrada com sucesso! Redirecionando...';
            setTimeout(() => window.location.href = '/cidades', 1500);
        } else {
            feedback.className = 'mb-4 text-red-700 bg-red-100 border border-red-300 px-4 py-2 rounded';
            feedback.textContent = 'Erro ao cadastrar cidade.';
        }
    });
</script>
@endsection

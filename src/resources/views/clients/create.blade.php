@extends('layouts.app')

@section('content')
<main class="flex justify-center px-4 py-10">
    <div class="w-full max-w-lg">
        <div id="form-feedback" class="mb-4 hidden text-sm font-medium"></div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Novo Cliente</h2>

        <form id="client-form" class="space-y-6 bg-white shadow rounded-lg p-6">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                <input type="text" id="name" name="name" required
                    class="mt-1 block w-full rounded-md border border-gray-300 bg-white shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm h-11 px-3">
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">               
                <div>
                    <label class="block text-sm text-gray-700">CPF</label>
                    <input type="text" id="cpf" name="cpf" class="mt-1 block w-full rounded-md border border-gray-300 bg-white shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm h-11 px-3" placeholder="000.000.000-00">
                </div>

                <div>
                    <label class="block text-sm text-gray-700">Data de Nascimento</label>
                    <input type="date" id="birthdate" name="birthdate" class="mt-1 block w-full rounded-md border border-gray-300 bg-white shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm h-11 px-3">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                    <label class="block text-sm text-gray-700">Sexo</label>
                    <div class="mt-1 flex flex-col gap-2">
                        <label><input type="radio" name="gender" value="Masculino" class="mr-1">Masculino</label>
                        <label><input type="radio" name="gender" value="Feminino" class="mr-1">Feminino</label>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm text-gray-700">Endereço</label>
                    <input type="text" id="address" name="address" class="mt-1 block w-full rounded-md border border-gray-300 bg-white shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm h-11 px-3">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-700">Estado</label>
                    <input type="text" id="state" name="state" class="mt-1 block w-full rounded-md border border-gray-300 bg-white shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm h-11 px-3">
                </div>
                <div>
                    <label class="block text-sm text-gray-700">Cidade</label>
                    <select id="city_id" name="city_id" class="mt-1 w-full h-10 border border-gray-300 rounded px-3 text-sm">
                        <option value="">Selecione</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-2">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-medium px-6 py-2 rounded text-sm">Salvar</button>
                <button type="reset" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium px-6 py-2 rounded text-sm">Limpar</button>
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
        const form = e.target;

        const data = {
        cpf: form.cpf.value,
        name: form.name.value,
        birthdate: form.birthdate.value,
        gender: form.gender.value,
        address: form.address.value,
        state: form.state.value,
        city_id: form.city_id.value
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
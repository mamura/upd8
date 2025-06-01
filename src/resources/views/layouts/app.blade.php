<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col">
        <header class="bg-white border-b border-sky-100 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 py-4 flex items-center gap-4">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="h-[40px] w-auto shrink-0">
            </div>
        </header>
        
        <main class="flex-1 py-8">
        @yield('content')
        </main>

        <footer class="bg-gray-900 text-white py-4 text-center text-sm">
            <p>&copy; {{ date('Y') }} Cadastro de Clientes. Todos os direitos reservados.</p>
        </footer>

        @yield('scripts')
    </body>
</html>
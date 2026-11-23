<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Prácticas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <nav class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center">

        <h1 class="text-xl font-bold">
            Sistema de Prácticas
        </h1>

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit"
                class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg">
                Cerrar sesión
            </button>
        </form>

    </nav>

    <main class="max-w-7xl mx-auto p-6">

        @yield('content')

    </main>

</body>
</html>

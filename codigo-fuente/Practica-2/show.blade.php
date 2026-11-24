<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar usuario</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-gray-800 text-white px-6 py-4">
        <h1 class="text-xl font-bold">Sistema de Prácticas</h1>
    </nav>

    <main class="max-w-3xl mx-auto p-6">

        <div class="bg-white rounded-xl shadow-lg p-8">

            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                Información del usuario
            </h2>

            <div class="space-y-5">

                <div>
                    <p class="text-sm text-gray-500">ID</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $usuario->id }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Nombre completo</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $usuario->name }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Correo electrónico</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $usuario->email }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Rol</p>
                    <p class="text-lg font-semibold text-gray-800">
                        {{ $usuario->role->nombre ?? 'Sin rol' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Fecha de registro</p>
                    <p class="text-lg font-semibold text-gray-800">
                        {{ $usuario->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>

            </div>

            <div class="mt-8 flex justify-between">

                <a href="{{ route('usuarios.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-3 rounded-lg">
                    Volver
                </a>

                <a href="{{ route('usuarios.edit', $usuario->id) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg">
                    Editar usuario
                </a>

            </div>

        </div>

    </main>

</body>
</html>

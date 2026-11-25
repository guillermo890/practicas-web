<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios eliminados</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-gray-800 text-white px-6 py-4">
        <h1 class="text-xl font-bold">Sistema de Prácticas</h1>
    </nav>

    <main class="max-w-6xl mx-auto p-6">

        <div class="bg-white rounded-xl shadow-lg p-8">

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">
                        Usuarios eliminados
                    </h2>
                    <p class="text-gray-500">
                        Administra los usuarios que fueron eliminados temporalmente.
                    </p>
                </div>

                <a href="{{ route('usuarios.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                    Volver
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">

                <table class="w-full text-left border-collapse">

                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="p-3">ID</th>
                            <th class="p-3">Nombre</th>
                            <th class="p-3">Correo</th>
                            <th class="p-3">Rol</th>
                            <th class="p-3">Eliminado</th>
                            <th class="p-3">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($usuarios as $usuario)

                            <tr class="border-b hover:bg-gray-50">

                                <td class="p-3">{{ $usuario->id }}</td>
                                <td class="p-3">{{ $usuario->name }}</td>
                                <td class="p-3">{{ $usuario->email }}</td>
                                <td class="p-3">
                                    {{ $usuario->role->nombre ?? 'Sin rol' }}
                                </td>
                                <td class="p-3">
                                    {{ $usuario->deleted_at->format('d/m/Y H:i') }}
                                </td>

                                <td class="p-3">
                                    <div class="flex gap-2">

                                        <!-- Envía la solicitud para recuperar al usuario -->
                                        <form action="{{ route('usuarios.restaurar', $usuario->id) }}"
                                            method="POST">
                                            @csrf

                                            <button type="submit"
                                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg">
                                                Recuperar
                                            </button>
                                        </form>

                                        <!-- Envía la solicitud para eliminarlo definitivamente -->
                                        <form action="{{ route('usuarios.eliminarPermanente', $usuario->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('¿Eliminar permanentemente este usuario? Esta acción no se puede deshacer.')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg">
                                                Eliminar definitivamente
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="p-6 text-center text-gray-500">
                                    No hay usuarios eliminados.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-6">
                {{ $usuarios->links() }}
            </div>

        </div>

    </main>

</body>
</html>

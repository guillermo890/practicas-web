<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar usuarios</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-gray-800 text-white px-6 py-4 flex justify-between">
        <h1 class="text-xl font-bold">Sistema de Prácticas</h1>

        <a href="{{ route('inicio') }}" class="hover:text-gray-300">
            Volver al inicio
        </a>
    </nav>

    <main class="max-w-7xl mx-auto p-6">

        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Administración de usuarios
                </h2>
                <p class="text-gray-500">
                    Consulta y administra los usuarios registrados.
                </p>
            </div>

            <a href="{{ route('usuarios.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                Nuevo usuario
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow overflow-x-auto">

            <table class="w-full text-left">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="p-4">ID</th>
                        <th class="p-4">Nombre</th>
                        <th class="p-4">Correo</th>
                        <th class="p-4">Rol</th>
                        <th class="p-4">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <!-- Recorre los usuarios recibidos desde el controlador -->
                    @forelse($usuarios as $usuario)
                        <tr class="border-b hover:bg-gray-50">

                            <td class="p-4">{{ $usuario->id }}</td>
                            <td class="p-4">{{ $usuario->name }}</td>
                            <td class="p-4">{{ $usuario->email }}</td>
                            <td class="p-4">
                                {{ $usuario->role->nombre ?? 'Sin rol' }}
                            </td>

                            <td class="p-4">
                                <div class="flex gap-2">

                                    <a href="{{ route('usuarios.show', $usuario->id) }}"
                                        class="bg-gray-600 text-white px-3 py-1 rounded">
                                        Ver
                                    </a>

                                    <a href="{{ route('usuarios.edit', $usuario->id) }}"
                                        class="bg-blue-600 text-white px-3 py-1 rounded">
                                        Editar
                                    </a>

                                    <!-- Solo el administrador puede eliminar usuarios -->
                                    @if(auth()->user()->role->nombre == 'Administrador')
                                        <form action="{{ route('usuarios.destroy', $usuario->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('¿Eliminar este usuario?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="bg-red-600 text-white px-3 py-1 rounded">
                                                Eliminar
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">
                                No hay usuarios registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        <div class="mt-4">
            {{ $usuarios->links() }}
        </div>

        <!-- El administrador puede consultar los usuarios eliminados -->
        @if(auth()->user()->role->nombre == 'Administrador')
            <div class="mt-6">
                <a href="{{ route('usuarios.eliminados') }}"
                    class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded-lg">
                    Ver usuarios eliminados
                </a>
            </div>
        @endif

    </main>

</body>
</html>

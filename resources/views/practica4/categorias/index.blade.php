<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <nav class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">Administración de categorías</h1>

        <a href="{{ route('inicio') }}"
           class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded-lg">
            Regresar
        </a>
    </nav>

    <main class="max-w-6xl mx-auto p-6">

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

        <div class="bg-white p-6 rounded-xl shadow mb-6">
            <h2 class="text-lg font-bold mb-4">Registrar categoría</h2>

            <form action="{{ route('categorias.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block mb-2 font-medium">Nombre</label>
                    <input type="text" name="nombre"
                           value="{{ old('nombre') }}"
                           class="w-full border rounded-lg p-2"
                           required>

                    @error('nombre')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-2 font-medium">Descripción</label>
                    <textarea name="descripcion"
                              class="w-full border rounded-lg p-2"
                              rows="3">{{ old('descripcion') }}</textarea>

                    @error('descripcion')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                    Guardar categoría
                </button>
            </form>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-lg font-bold mb-4">Categorías registradas</h2>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3">ID</th>
                            <th class="p-3">Nombre</th>
                            <th class="p-3">Descripción</th>
                            <th class="p-3">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($categorias as $categoria)
                            <tr class="border-b">
                                <td class="p-3">{{ $categoria->id }}</td>
                                <td class="p-3">{{ $categoria->nombre }}</td>
                                <td class="p-3">{{ $categoria->descripcion ?? 'Sin descripción' }}</td>
                                <td class="p-3">
                                    <form action="{{ route('categorias.destroy', $categoria->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('¿Eliminar esta categoría?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center text-gray-500">
                                    No hay categorías registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</body>
</html>

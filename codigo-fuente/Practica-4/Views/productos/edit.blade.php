<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar producto</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <nav class="bg-gray-800 text-white px-6 py-4">
        <h1 class="text-xl font-bold">Editar producto</h1>
    </nav>

    <main class="max-w-3xl mx-auto p-6">

        <div class="bg-white p-6 rounded-xl shadow">

            <h2 class="text-xl font-bold mb-6">Modificar información del producto</h2>

            @if($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('productos.update', $producto->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-medium mb-2">Nombre</label>
                    <input type="text" name="nombre"
                           value="{{ old('nombre', $producto->nombre) }}"
                           class="w-full border rounded-lg p-2"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-2">Descripción</label>
                    <textarea name="descripcion"
                              class="w-full border rounded-lg p-2"
                              rows="3" required>{{ old('descripcion', $producto->descripcion) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-2">Categoría</label>
                    <select name="categoria_id"
                            class="w-full border rounded-lg p-2" required>
                        <option value="">Selecciona una categoría</option>

                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}"
                                {{ old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-2">Precio</label>
                    <input type="number" name="precio"
                           step="0.01" min="0.01"
                           value="{{ old('precio', $producto->precio) }}"
                           class="w-full border rounded-lg p-2"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-2">Stock</label>
                    <input type="number" name="stock"
                           min="0"
                           value="{{ old('stock', $producto->stock) }}"
                           class="w-full border rounded-lg p-2"
                           required>
                </div>

                <div class="mb-6">
                    <label class="block font-medium mb-2">Estado</label>
                    <select name="estado"
                            class="w-full border rounded-lg p-2" required>
                        <option value="Disponible"
                            {{ old('estado', $producto->estado) == 'Disponible' ? 'selected' : '' }}>
                            Disponible
                        </option>

                        <option value="Agotado"
                            {{ old('estado', $producto->estado) == 'Agotado' ? 'selected' : '' }}>
                            Agotado
                        </option>
                    </select>
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                        Actualizar producto
                    </button>

                    <a href="{{ route('productos.index') }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">
                        Cancelar
                    </a>
                </div>

            </form>

        </div>

    </main>

</body>
</html>

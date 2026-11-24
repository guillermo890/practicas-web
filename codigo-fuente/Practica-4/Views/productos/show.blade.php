<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del producto</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <nav class="bg-gray-800 text-white px-6 py-4">
        <h1 class="text-xl font-bold">Detalles del producto</h1>
    </nav>

    <main class="max-w-3xl mx-auto p-6">

        <div class="bg-white p-6 rounded-xl shadow">

            <h2 class="text-2xl font-bold mb-6">
                {{ $producto->nombre }}
            </h2>

            <div class="space-y-4">

                <div class="border-b pb-3">
                    <p class="text-gray-500">ID del producto</p>
                    <p class="font-semibold">{{ $producto->id }}</p>
                </div>

                <div class="border-b pb-3">
                    <p class="text-gray-500">Descripción</p>
                    <p class="font-semibold">{{ $producto->descripcion }}</p>
                </div>

                <div class="border-b pb-3">
                    <p class="text-gray-500">Categoría</p>
                    <p class="font-semibold">{{ $producto->categoria->nombre }}</p>
                </div>

                <div class="border-b pb-3">
                    <p class="text-gray-500">Precio</p>
                    <p class="font-semibold">
                        ${{ number_format($producto->precio, 2) }}
                    </p>
                </div>

                <div class="border-b pb-3">
                    <p class="text-gray-500">Stock disponible</p>
                    <p class="font-semibold">{{ $producto->stock }}</p>
                </div>

                <div class="border-b pb-3">
                    <p class="text-gray-500">Estado</p>

                    @if($producto->estado == 'Disponible')
                        <p class="text-green-600 font-semibold">Disponible</p>
                    @else
                        <p class="text-red-600 font-semibold">Agotado</p>
                    @endif
                </div>

                <div class="border-b pb-3">
                    <p class="text-gray-500">Fecha de registro</p>
                    <p class="font-semibold">{{ $producto->fecha_registro }}</p>
                </div>

            </div>

            <div class="flex gap-3 mt-6">

                <a href="{{ route('productos.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">
                    Regresar
                </a>

                @if(auth()->user()->role->nombre == 'Administrador')
                    <a href="{{ route('productos.edit', $producto->id) }}"
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg">
                        Editar producto
                    </a>
                @endif

            </div>

        </div>

    </main>

</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de productos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <nav class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">Administración de productos</h1>

        <a href="{{ route('inicio') }}"
           class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded-lg">
            Regresar
        </a>
    </nav>

    <main class="max-w-7xl mx-auto p-6">

       @if(session('success'))
      <x-alerta tipo="success">
        {{ session('success') }}
         </x-alerta>
          @endif

       @if(session('error'))
          <x-alerta tipo="error">
             {{ session('error') }}
           </x-alerta>
            @endif

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Lista de productos</h2>

            @if(auth()->user()->role->nombre == 'Administrador')
                <a href="{{ route('productos.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Nuevo producto
                </a>
            @endif
        </div>

        <!-- FILTROS -->
        <div class="bg-white p-6 rounded-xl shadow mb-6">

            <h3 class="font-bold text-lg mb-4">Buscar y filtrar productos</h3>

            <form action="{{ route('productos.index') }}" method="GET">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <div>
                        <label class="block mb-2">Nombre</label>
                        <input type="text" name="nombre"
                               value="{{ request('nombre') }}"
                               class="w-full border rounded-lg p-2"
                               placeholder="Buscar producto">
                    </div>

                    <div>
                        <label class="block mb-2">Categoría</label>
                        <select name="categoria_id" class="w-full border rounded-lg p-2">
                            <option value="">Todas</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}"
                                    {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2">Estado</label>
                        <select name="estado" class="w-full border rounded-lg p-2">
                            <option value="">Todos</option>
                            <option value="Disponible" {{ request('estado') == 'Disponible' ? 'selected' : '' }}>
                                Disponible
                            </option>
                            <option value="Agotado" {{ request('estado') == 'Agotado' ? 'selected' : '' }}>
                                Agotado
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2">Precio mínimo</label>
                        <input type="number" step="0.01" name="precio_min"
                               value="{{ request('precio_min') }}"
                               class="w-full border rounded-lg p-2">
                    </div>

                    <div>
                        <label class="block mb-2">Precio máximo</label>
                        <input type="number" step="0.01" name="precio_max"
                               value="{{ request('precio_max') }}"
                               class="w-full border rounded-lg p-2">
                    </div>

                    <div>
                        <label class="block mb-2">Ordenar por</label>
                        <select name="orden" class="w-full border rounded-lg p-2">
                            <option value="">Más recientes</option>
                            <option value="nombre_asc" {{ request('orden') == 'nombre_asc' ? 'selected' : '' }}>Nombre A-Z</option>
                            <option value="nombre_desc" {{ request('orden') == 'nombre_desc' ? 'selected' : '' }}>Nombre Z-A</option>
                            <option value="precio_asc" {{ request('orden') == 'precio_asc' ? 'selected' : '' }}>Precio menor a mayor</option>
                            <option value="precio_desc" {{ request('orden') == 'precio_desc' ? 'selected' : '' }}>Precio mayor a menor</option>
                            <option value="stock_asc" {{ request('orden') == 'stock_asc' ? 'selected' : '' }}>Stock menor a mayor</option>
                            <option value="stock_desc" {{ request('orden') == 'stock_desc' ? 'selected' : '' }}>Stock mayor a menor</option>
                            <option value="fecha_asc" {{ request('orden') == 'fecha_asc' ? 'selected' : '' }}>Más antiguos</option>
                        </select>
                    </div>

                </div>

                <div class="flex gap-3 mt-5">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                        Aplicar filtros
                    </button>

                    <a href="{{ route('productos.index') }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">
                        Limpiar
                    </a>
                </div>

            </form>
        </div>

        <!-- TABLA -->
        <div class="bg-white p-6 rounded-xl shadow">

            <div class="flex justify-between items-center mb-4">
                <p class="text-gray-600">
                    Total de productos: <strong>{{ $productos->total() }}</strong>
                </p>

                <form action="{{ route('productos.index') }}" method="GET">
                    @foreach(request()->except('por_pagina', 'page') as $clave => $valor)
                        <input type="hidden" name="{{ $clave }}" value="{{ $valor }}">
                    @endforeach

                    <label>Mostrar:</label>
                    <select name="por_pagina" onchange="this.form.submit()"
                            class="border rounded-lg p-2">
                        @foreach([10, 15, 25, 50] as $cantidad)
                            <option value="{{ $cantidad }}"
                                {{ $porPagina == $cantidad ? 'selected' : '' }}>
                                {{ $cantidad }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">

                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3">ID</th>
                            <th class="p-3">Nombre</th>
                            <th class="p-3">Categoría</th>
                            <th class="p-3">Precio</th>
                            <th class="p-3">Stock</th>
                            <th class="p-3">Estado</th>
                            <th class="p-3">Fecha</th>
                            <th class="p-3">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($productos as $producto)
                            <tr class="border-b">
                                <td class="p-3">{{ $producto->id }}</td>
                                <td class="p-3">{{ $producto->nombre }}</td>
                                <td class="p-3">{{ $producto->categoria->nombre }}</td>
                                <td class="p-3">${{ number_format($producto->precio, 2) }}</td>
                                <td class="p-3">{{ $producto->stock }}</td>
                                <td class="p-3">
                                    @if($producto->estado == 'Disponible')
                                        <span class="text-green-600 font-semibold">Disponible</span>
                                    @else
                                        <span class="text-red-600 font-semibold">Agotado</span>
                                    @endif
                                </td>
                                <td class="p-3">{{ $producto->fecha_registro }}</td>

                                <td class="p-3">
                                    <div class="flex gap-2">

                                        <a href="{{ route('productos.show', $producto->id) }}"
                                           class="bg-gray-600 text-white px-3 py-1 rounded-lg">
                                            Ver
                                        </a>

                                        @if(auth()->user()->role->nombre == 'Administrador')
                                            <a href="{{ route('productos.edit', $producto->id) }}"
                                               class="bg-yellow-500 text-white px-3 py-1 rounded-lg">
                                                Editar
                                            </a>

                                            <form action="{{ route('productos.destroy', $producto->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('¿Eliminar este producto?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="bg-red-600 text-white px-3 py-1 rounded-lg">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-4 text-center text-gray-500">
                                    No hay productos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <div class="mt-6">
                <p class="text-gray-600 mb-3">
                    Mostrando {{ $productos->firstItem() ?? 0 }}
                    al {{ $productos->lastItem() ?? 0 }}
                    de {{ $productos->total() }} productos.
                </p>

                {{ $productos->links() }}
            </div>

        </div>

    </main>

</body>
</html>

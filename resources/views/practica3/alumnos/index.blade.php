<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema académico</title>
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

        <div class="bg-white rounded-xl shadow-lg p-8">

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">
                        Sistema académico
                    </h2>
                    <p class="text-gray-500">
                        Administración de alumnos y calificaciones.
                    </p>
                </div>

                @if(auth()->user()->role->nombre == 'Profesor')
                    <a href="{{ route('alumnos.create') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg">
                        Registrar alumno
                    </a>
                @endif
            </div>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form method="GET" action="{{ route('alumnos.index') }}"
                class="flex flex-wrap gap-3 mb-6">

                <select name="orden"
                    class="border border-gray-300 rounded-lg p-3">

                    <option value="">Ordenar por...</option>

                    <option value="nombre" {{ request('orden') == 'nombre' ? 'selected' : '' }}>
                        Nombre A-Z
                    </option>

                    <option value="calificacion_asc" {{ request('orden') == 'calificacion_asc' ? 'selected' : '' }}>
                        Calificación menor a mayor
                    </option>

                    <option value="calificacion_desc" {{ request('orden') == 'calificacion_desc' ? 'selected' : '' }}>
                        Calificación mayor a menor
                    </option>

                    <option value="faltas_asc" {{ request('orden') == 'faltas_asc' ? 'selected' : '' }}>
                        Menos faltas
                    </option>

                    <option value="faltas_desc" {{ request('orden') == 'faltas_desc' ? 'selected' : '' }}>
                        Más faltas
                    </option>

                </select>

                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg">
                    Aplicar orden
                </button>

                <a href="{{ route('alumnos.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-3 rounded-lg">
                    Limpiar
                </a>

            </form>

            <div class="overflow-x-auto">

                <table class="w-full text-left border-collapse">

                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="p-3">ID</th>
                            <th class="p-3">Alumno</th>
                            <th class="p-3">Faltas</th>
                            <th class="p-3">Calificación</th>
                            <th class="p-3">Equivalencia</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($alumnos as $alumno)

                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">{{ $alumno->id }}</td>
                                <td class="p-3">{{ $alumno->nombre }}</td>
                                <td class="p-3">{{ $alumno->faltas }}</td>
                                <td class="p-3">{{ $alumno->calificacion }}</td>
                                <td class="p-3">
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
                                        {{ $alumno->equivalencia }}
                                    </span>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="p-6 text-center text-gray-500">
                                    No hay registros académicos todavía.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-6">
                {{ $alumnos->links() }}
            </div>

        </div>

    </main>

</body>
</html>

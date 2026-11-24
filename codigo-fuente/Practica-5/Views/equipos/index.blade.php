@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-md p-6">

    <div class="flex justify-between items-center mb-6">

        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Equipos de cómputo
            </h2>

            <p class="text-gray-500">
                Administración de equipos disponibles.
            </p>
        </div>

        <div class="flex gap-2">

            <a href="{{ route('inicio') }}"
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                Regresar al menú
            </a>

            <a href="{{ route('equipos.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                Registrar equipo
            </a>

        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto">

        <table class="w-full text-left border-collapse">

            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="p-3">ID</th>
                    <th class="p-3">Equipo</th>
                    <th class="p-3">Número de serie</th>
                    <th class="p-3">Ubicación</th>
                    <th class="p-3">Estado</th>
                    <th class="p-3">Acciones</th>
                </tr>
            </thead>

            <tbody>

                @forelse($equipos as $equipo)

                    <tr class="border-b hover:bg-gray-50">

                        <td class="p-3">
                            {{ $equipo->id }}
                        </td>

                        <td class="p-3">
                            {{ $equipo->nombre }}
                        </td>

                        <td class="p-3">
                            {{ $equipo->numero_serie }}
                        </td>

                        <td class="p-3">
                            {{ $equipo->ubicacion }}
                        </td>

                        <td class="p-3">

                            @if($equipo->estado == 'Disponible')

                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                    Disponible
                                </span>

                            @else

                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm">
                                    No disponible
                                </span>

                            @endif

                        </td>

                        <td class="p-3">

                            <div class="flex gap-2">

                                <a href="{{ route('equipos.edit', $equipo->id) }}"
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg">
                                    Editar
                                </a>

                                <form action="{{ route('equipos.destroy', $equipo->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Estás seguro de eliminar este equipo?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg">
                                        Eliminar
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="p-6 text-center text-gray-500">
                            Todavía no hay equipos registrados.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>
@endsection

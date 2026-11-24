@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-md p-6">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Administración de reservaciones
            </h2>

            <p class="text-gray-500">
                Consulta y administra las reservaciones realizadas por todos los estudiantes.
            </p>
        </div>

        <a href="{{ route('inicio') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
            Regresar al menú
        </a>
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
                    <th class="p-3">Estudiante</th>
                    <th class="p-3">Equipo</th>
                    <th class="p-3">Inicio</th>
                    <th class="p-3">Finalización</th>
                    <th class="p-3">Estado</th>
                    <th class="p-3">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($reservaciones as $reservacion)

                    <tr class="border-b hover:bg-gray-50">

                        <td class="p-3">
                            {{ $reservacion->id }}
                        </td>

                        <td class="p-3">
                            {{ $reservacion->usuario->name }}
                        </td>

                        <td class="p-3">
                            {{ $reservacion->equipo->nombre }}
                        </td>

                        <td class="p-3">
                            {{ $reservacion->fecha_inicio->format('d/m/Y H:i') }}
                        </td>

                        <td class="p-3">
                            {{ $reservacion->fecha_fin->format('d/m/Y H:i') }}
                        </td>

                        <td class="p-3">
                            @if($reservacion->estado == 'Activa')
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                    Activa
                                </span>
                            @else
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm">
                                    {{ $reservacion->estado }}
                                </span>
                            @endif
                        </td>

                        <td class="p-3">
                            @if($reservacion->estado == 'Activa')

                                <form action="{{ route('reservaciones.cancelarAdmin', $reservacion->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Cancelar esta reservación?')">

                                    @csrf
                                    @method('PUT')

                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg">
                                        Cancelar
                                    </button>

                                </form>

                            @else
                                <span class="text-gray-400">Sin acciones</span>
                            @endif
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="p-6 text-center text-gray-500">
                            No hay reservaciones registradas.
                        </td>
                    </tr>

                @endforelse
            </tbody>

        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('equipos.index') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            Administrar equipos
        </a>
    </div>

</div>
@endsection

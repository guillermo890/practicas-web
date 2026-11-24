@extends('layouts.app')
@section('content')
<div class="bg-white rounded-xl shadow-md p-6">

    <div class="flex justify-between items-center mb-2">

        <h2 class="text-2xl font-bold text-gray-800">
            Mis reservaciones
        </h2>

        <a href="{{ route('inicio') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
            Regresar al menú
        </a>

    </div>

    <p class="text-gray-500 mb-6">
        Consulta el historial de tus reservaciones.
    </p>

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
                    <th class="p-3">Equipo</th>
                    <th class="p-3">Fecha de inicio</th>
                    <th class="p-3">Fecha de finalización</th>
                    <th class="p-3">Estado</th>
                    <th class="p-3">Observaciones</th>
                    <th class="p-3">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($reservaciones as $reservacion)

                    <tr class="border-b hover:bg-gray-50">

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
                            {{ $reservacion->observaciones ?? 'Sin observaciones' }}
                        </td>

                        <td class="p-3">
                            @if($reservacion->estado == 'Activa')

                                <form action="{{ route('reservaciones.cancelar', $reservacion->id) }}"
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
                        <td colspan="6" class="p-6 text-center text-gray-500">
                            Todavía no tienes reservaciones registradas.
                        </td>
                    </tr>

                @endforelse
            </tbody>

        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('reservaciones.disponibles') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            Ver equipos disponibles
        </a>
    </div>

</div>
@endsection

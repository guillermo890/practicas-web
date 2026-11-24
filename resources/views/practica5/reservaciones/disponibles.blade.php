@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-md p-6">

    <div class="flex justify-between items-center mb-2">

        <h2 class="text-2xl font-bold text-gray-800">
            Equipos disponibles
        </h2>

        <a href="{{ route('inicio') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
            Regresar al menú
        </a>

    </div>

    <p class="text-gray-500 mb-6">
        Consulta los equipos y selecciona el que deseas reservar.
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

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

        @forelse($equipos as $equipo)

            <div class="border border-gray-200 rounded-xl p-5 shadow-sm">

                <h3 class="text-xl font-bold text-gray-800 mb-2">
                    {{ $equipo->nombre }}
                </h3>

                <p class="text-gray-600 mb-3">
                    {{ $equipo->descripcion }}
                </p>

                <p class="text-sm text-gray-600 mb-2">
                    <strong>Número de serie:</strong>
                    {{ $equipo->numero_serie }}
                </p>

                <p class="text-sm text-gray-600 mb-4">
                    <strong>Ubicación:</strong>
                    {{ $equipo->ubicacion }}
                </p>

                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                    Disponible
                </span>

                <div class="mt-5">
                    <a href="{{ route('reservaciones.create', $equipo->id) }}"
                       class="block text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        Reservar equipo
                    </a>
                </div>

            </div>

        @empty

            <div class="col-span-full text-center text-gray-500 p-8">
                No hay equipos disponibles actualmente.
            </div>

        @endforelse

    </div>

    <div class="mt-6">
        <a href="{{ route('reservaciones.mis') }}"
           class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded-lg">
            Mis reservaciones
        </a>
    </div>

</div>
@endsection

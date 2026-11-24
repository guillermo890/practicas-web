@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-md p-6">

    <div class="flex justify-between items-center mb-2">
        <h2 class="text-2xl font-bold text-gray-800">
            Reservar equipo
        </h2>

        <a href="{{ route('inicio') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
            Regresar al menú
        </a>
    </div>

    <p class="text-gray-500 mb-6">
        Completa los datos para realizar tu reservación.
    </p>

    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-4 rounded-lg mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-gray-100 rounded-lg p-4 mb-6">
        <h3 class="text-lg font-bold text-gray-800">
            {{ $equipo->nombre }}
        </h3>

        <p class="text-gray-600">
            {{ $equipo->descripcion }}
        </p>

        <p class="text-sm text-gray-600 mt-2">
            <strong>Número de serie:</strong>
            {{ $equipo->numero_serie }}
        </p>

        <p class="text-sm text-gray-600">
            <strong>Ubicación:</strong>
            {{ $equipo->ubicacion }}
        </p>
    </div>

    <form action="{{ route('reservaciones.store') }}" method="POST">
        @csrf

        <input type="hidden" name="equipo_id" value="{{ $equipo->id }}">

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">
                Fecha y hora de inicio
            </label>

            <input type="datetime-local"
                   name="fecha_inicio"
                   value="{{ old('fecha_inicio') }}"
                   class="w-full border border-gray-300 rounded-lg p-3"
                   required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">
                Fecha y hora de finalización
            </label>

            <input type="datetime-local"
                   name="fecha_fin"
                   value="{{ old('fecha_fin') }}"
                   class="w-full border border-gray-300 rounded-lg p-3"
                   required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">
                Observaciones
            </label>

            <textarea name="observaciones"
                      rows="3"
                      class="w-full border border-gray-300 rounded-lg p-3"
                      placeholder="Escribe alguna observación (opcional)">{{ old('observaciones') }}</textarea>
        </div>

        <div class="flex gap-3">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                Confirmar reservación
            </button>

            <a href="{{ route('reservaciones.disponibles') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">
                Cancelar
            </a>
        </div>

    </form>

</div>
@endsection

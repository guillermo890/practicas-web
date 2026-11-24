@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-md p-6">

    <h2 class="text-2xl font-bold text-gray-800 mb-2">
        Editar equipo
    </h2>

    <p class="text-gray-500 mb-6">
        Modifica la información del equipo seleccionado.
    </p>

    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-4 rounded-lg mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('equipos.update', $equipo->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">
                Nombre del equipo
            </label>
            <input type="text" name="nombre"
                   value="{{ old('nombre', $equipo->nombre) }}"
                   class="w-full border border-gray-300 rounded-lg p-3"
                   required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">
                Descripción
            </label>
            <textarea name="descripcion"
                      class="w-full border border-gray-300 rounded-lg p-3">{{ old('descripcion', $equipo->descripcion) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">
                Número de serie
            </label>
            <input type="text" name="numero_serie"
                   value="{{ old('numero_serie', $equipo->numero_serie) }}"
                   class="w-full border border-gray-300 rounded-lg p-3"
                   required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">
                Ubicación
            </label>
            <input type="text" name="ubicacion"
                   value="{{ old('ubicacion', $equipo->ubicacion) }}"
                   class="w-full border border-gray-300 rounded-lg p-3"
                   required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">
                Estado
            </label>
            <select name="estado"
                    class="w-full border border-gray-300 rounded-lg p-3"
                    required>
                <option value="Disponible"
                    {{ old('estado', $equipo->estado) == 'Disponible' ? 'selected' : '' }}>
                    Disponible
                </option>

                <option value="No disponible"
                    {{ old('estado', $equipo->estado) == 'No disponible' ? 'selected' : '' }}>
                    No disponible
                </option>
            </select>
        </div>

        <div class="flex gap-3">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                Actualizar equipo
            </button>

            <a href="{{ route('equipos.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">
                Cancelar
            </a>
        </div>
    </form>

</div>
@endsection

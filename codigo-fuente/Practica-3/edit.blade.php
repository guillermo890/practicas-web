@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto p-6">

    <div class="bg-white rounded-xl shadow-lg p-6">

        <h1 class="text-2xl font-bold text-gray-800 mb-2">
            Editar información académica
        </h1>

        <p class="text-gray-500 mb-6">
            Modifica las faltas y la calificación del alumno.
        </p>

        <form action="{{ route('alumnos.update', $alumno->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">
                    Nombre del alumno
                </label>

                <input
                    type="text"
                    name="nombre"
                    value="{{ old('nombre', $alumno->nombre) }}"
                    class="w-full border rounded-lg p-3"
                    required
                >

                @error('nombre')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">
                    Número de faltas
                </label>

                <input
                    type="number"
                    name="faltas"
                    value="{{ old('faltas', $alumno->faltas) }}"
                    min="0"
                    class="w-full border rounded-lg p-3"
                    required
                >

                @error('faltas')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    Calificación (0 a 100)
                </label>

                <input
                    type="number"
                    name="calificacion"
                    value="{{ old('calificacion', $alumno->calificacion) }}"
                    min="0"
                    max="100"
                    step="0.01"
                    class="w-full border rounded-lg p-3"
                    required
                >

                @error('calificacion')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">

                <button
                    type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">
                    Actualizar
                </button>

                <a href="{{ route('alumnos.index') }}"
                    class="bg-gray-500 text-white px-5 py-2 rounded-lg hover:bg-gray-600">
                    Cancelar
                </a>

            </div>

        </form>

    </div>

</div>

@endsection

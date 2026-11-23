@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">

    <div class="bg-white rounded-xl shadow-lg p-6">

        <h1 class="text-2xl font-bold text-gray-800 mb-2">
            Mi información académica
        </h1>

        <p class="text-gray-500 mb-6">
            Consulta tus calificaciones y faltas registradas.
        </p>

        @if($alumno)

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div class="bg-gray-100 rounded-lg p-4">
                    <p class="text-gray-500">Nombre</p>
                    <p class="text-lg font-semibold">
                        {{ $alumno->nombre }}
                    </p>
                </div>

                <div class="bg-gray-100 rounded-lg p-4">
                    <p class="text-gray-500">Número de faltas</p>
                    <p class="text-lg font-semibold">
                        {{ $alumno->faltas }}
                    </p>
                </div>

                <div class="bg-gray-100 rounded-lg p-4">
                    <p class="text-gray-500">Calificación numérica</p>
                    <p class="text-lg font-semibold">
                        {{ $alumno->calificacion }}
                    </p>
                </div>

                <div class="bg-gray-100 rounded-lg p-4">
                    <p class="text-gray-500">Equivalencia</p>
                    <p class="text-lg font-semibold">
                        {{ $alumno->equivalencia }}
                    </p>
                </div>

            </div>

        @else

            <div class="bg-yellow-100 text-yellow-800 rounded-lg p-4">
                Todavía no tienes información académica registrada.
            </div>

        @endif

        <a href="{{ route('inicio') }}"
           class="inline-block mt-6 bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">
            Regresar al inicio
        </a>

    </div>

</div>
@endsection

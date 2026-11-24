@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    <div class="bg-white rounded-xl shadow-md p-6 mb-6">

        <div class="flex justify-between items-center flex-wrap gap-4">

            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Juego del gato
                </h2>

                <p class="text-gray-600 mt-1">
                    Bienvenido, {{ auth()->user()->name }}
                </p>
            </div>

            <a href="{{ route('inicio') }}"
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                Regresar al menú
            </a>

        </div>

    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Crear partida -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">

        <h3 class="text-xl font-bold text-gray-800 mb-2">
            Crear una partida
        </h3>

        <p class="text-gray-600 mb-4">
            Crea una partida y espera a que otro jugador se una.
        </p>

        <form action="{{ route('partidas.crear') }}" method="POST">
            @csrf

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                Crear nueva partida
            </button>
        </form>

    </div>

    <!-- Jugadores disponibles -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">

        <h3 class="text-xl font-bold text-gray-800 mb-4">
            Jugadores disponibles
        </h3>

        @if($jugadores->count() > 0)

            <div class="overflow-x-auto">

                <table class="w-full text-left">

                    <thead>
                        <tr class="border-b bg-gray-100">
                            <th class="p-3">Jugador</th>
                            <th class="p-3">Correo</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($jugadores as $jugador)

                            <tr class="border-b">
                                <td class="p-3">
                                    {{ $jugador->name }}
                                </td>

                                <td class="p-3">
                                    {{ $jugador->email }}
                                </td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <p class="text-gray-500">
                No hay otros jugadores registrados.
            </p>

        @endif

    </div>

    <!-- Partidas disponibles -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">

        <h3 class="text-xl font-bold text-gray-800 mb-4">
            Partidas disponibles
        </h3>

        @if($partidas->count() > 0)

            <div class="overflow-x-auto">

                <table class="w-full text-left">

                    <thead>
                        <tr class="border-b bg-gray-100">
                            <th class="p-3">ID</th>
                            <th class="p-3">Jugador creador</th>
                            <th class="p-3">Fecha</th>
                            <th class="p-3">Acción</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($partidas as $partida)

                            <tr class="border-b">

                                <td class="p-3">
                                    {{ $partida->id }}
                                </td>

                                <td class="p-3">
                                    {{ $partida->jugador1->name }}
                                </td>

                                <td class="p-3">
                                    {{ $partida->created_at->format('d/m/Y H:i') }}
                                </td>

                                <td class="p-3">

                                    @if($partida->jugador1_id == auth()->id())

                                        <a href="{{ route('partidas.jugar', $partida->id) }}"
                                           class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                                            Entrar a mi partida
                                        </a>

                                    @else

                                        <form action="{{ route('partidas.unirse', $partida->id) }}"
                                              method="POST">
                                            @csrf

                                            <button type="submit"
                                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                                                Unirse
                                            </button>
                                        </form>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <p class="text-gray-500">
                No hay partidas disponibles actualmente.
            </p>

        @endif

    </div>

    <!-- Historial -->
    <div class="bg-white rounded-xl shadow-md p-6">

        <h3 class="text-xl font-bold text-gray-800 mb-2">
            Mi historial
        </h3>

        <p class="text-gray-600 mb-4">
            Consulta las partidas en las que has participado.
        </p>

        <a href="{{ route('partidas.historial') }}"
           class="inline-block bg-gray-700 hover:bg-gray-800 text-white px-5 py-2 rounded-lg">
            Ver historial
        </a>

    </div>

</div>

@endsection
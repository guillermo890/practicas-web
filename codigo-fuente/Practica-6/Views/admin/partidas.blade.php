@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-3xl font-bold text-gray-800">
            Administración de partidas
        </h2>
        <p class="text-gray-600">
            Historial general de partidas del sistema.
        </p>
    </div>

    <a href="{{ route('inicio') }}"
       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
        Regresar al menú
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
        {{ session('error') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow-md p-6">

    @if($partidas->isEmpty())

        <p class="text-gray-500">
            Todavía no hay partidas registradas.
        </p>

    @else

        <div class="overflow-x-auto">
            <table class="w-full text-left">

                <thead>
                    <tr class="border-b bg-gray-50">
                        <th class="p-3">ID</th>
                        <th class="p-3">Jugador X</th>
                        <th class="p-3">Jugador O</th>
                        <th class="p-3">Ganador</th>
                        <th class="p-3">Estado</th>
                        <th class="p-3">Fecha</th>
                        <th class="p-3">Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($partidas as $partida)

                        <tr class="border-b">

                            <td class="p-3">
                                #{{ $partida->id }}
                            </td>

                            <td class="p-3">
                                {{ $partida->jugador1->name ?? 'Usuario eliminado' }}
                            </td>

                            <td class="p-3">
                                {{ $partida->jugador2->name ?? 'Sin jugador' }}
                            </td>

                            <td class="p-3">
                                {{ $partida->ganador->name ?? 'Sin ganador' }}
                            </td>

                            <td class="p-3">
                                {{ $partida->estado }}
                            </td>

                            <td class="p-3">
                                {{ $partida->created_at->format('d/m/Y H:i') }}
                            </td>

                            <td class="p-3">

                                @if($partida->estado == 'En curso')

                                    <form action="{{ route('partidas.admin.cancelar', $partida->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('¿Deseas cancelar esta partida?')">

                                        @csrf
                                        @method('PUT')

                                        <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg">
                                            Cancelar
                                        </button>

                                    </form>

                                @else

                                    <span class="text-gray-500">
                                        Sin acciones
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>
        </div>

    @endif

</div>

@endsection

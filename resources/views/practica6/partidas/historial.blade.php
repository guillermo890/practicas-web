@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-3xl font-bold text-gray-800">
            Mi historial de partidas
        </h2>
        <p class="text-gray-600">
            Partidas en las que has participado.
        </p>
    </div>

    <a href="{{ route('partidas.index') }}"
       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
        Regresar
    </a>
</div>

<div class="bg-white rounded-xl shadow-md p-6">

    @if($partidas->isEmpty())

        <p class="text-gray-500">
            Todavía no tienes partidas registradas.
        </p>

    @else

        <div class="overflow-x-auto">
            <table class="w-full text-left">

                <thead>
                    <tr class="border-b bg-gray-50">
                        <th class="p-3">Partida</th>
                        <th class="p-3">Jugador X</th>
                        <th class="p-3">Jugador O</th>
                        <th class="p-3">Resultado</th>
                        <th class="p-3">Fecha</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($partidas as $partida)

                        <tr class="border-b">

                            <td class="p-3">
                                #{{ $partida->id }}
                            </td>

                            <td class="p-3">
                                {{ $partida->jugador1->name }}
                            </td>

                            <td class="p-3">
                                {{ $partida->jugador2 ? $partida->jugador2->name : 'Sin jugador' }}
                            </td>

                            <td class="p-3">

                                @if($partida->estado == 'Finalizada')
                                    Ganó: {{ $partida->ganador->name }}
                                @elseif($partida->estado == 'Empate')
                                    Empate
                                @else
                                    {{ $partida->estado }}
                                @endif

                            </td>

                            <td class="p-3">
                                {{ $partida->created_at->format('d/m/Y H:i') }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>
            </table>
        </div>

    @endif

</div>

@endsection

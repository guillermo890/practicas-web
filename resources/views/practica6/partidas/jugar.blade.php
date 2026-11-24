
@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">
                Juego del gato
            </h2>
            <p class="text-gray-600">
                Partida #{{ $partida->id }}
            </p>
        </div>

        <a href="{{ route('partidas.index') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
            Regresar
        </a>
    </div>

    <div id="mensaje" class="mb-4"></div>

    <div class="bg-white rounded-xl shadow-md p-6 mb-6">

        <div class="grid grid-cols-2 gap-4 mb-6 text-center">

            <div class="bg-blue-100 rounded-lg p-4">
                <p class="font-bold">Jugador X</p>
                <p id="jugador1">{{ $partida->jugador1->name }}</p>
            </div>

            <div class="bg-green-100 rounded-lg p-4">
                <p class="font-bold">Jugador O</p>
                <p id="jugador2">
                    {{ $partida->jugador2 ? $partida->jugador2->name : 'Esperando jugador' }}
                </p>
            </div>

        </div>

        <div class="text-center mb-5">
            <p id="estado" class="text-lg font-bold text-gray-800">
                @if($partida->estado == 'En curso')
                    Turno de: {{ $partida->turno }}
                @elseif($partida->estado == 'Finalizada')
                    ¡Partida finalizada!
                @elseif($partida->estado == 'Empate')
                    ¡Empate!
                @else
                    Estado: {{ $partida->estado }}
                @endif
            </p>
        </div>

        <div id="tablero" class="grid grid-cols-3 gap-2 max-w-md mx-auto">

            @foreach($partida->tablero as $indice => $casilla)

                @if($partida->estado == 'En curso' &&
                    (($partida->turno == 'X' && $partida->jugador1_id == auth()->id()) ||
                    ($partida->turno == 'O' && $partida->jugador2_id == auth()->id())) &&
                    $casilla == '')

                    <form action="{{ route('partidas.movimiento', $partida->id) }}"
                          method="POST">
                        @csrf

                        <input type="hidden" name="casilla" value="{{ $indice }}">

                        <button type="submit"
                                class="w-full aspect-square bg-gray-100 hover:bg-blue-100 border-2 border-gray-300 rounded-xl text-4xl font-bold">
                            {{ $casilla }}
                        </button>
                    </form>

                @else

                    <div class="aspect-square flex items-center justify-center bg-gray-100 border-2 border-gray-300 rounded-xl text-4xl font-bold">
                        {{ $casilla }}
                    </div>

                @endif

            @endforeach

        </div>

        @if($partida->estado == 'En curso')
            <form action="{{ route('partidas.abandonar', $partida->id) }}"
                  method="POST"
                  class="mt-6 text-center"
                  onsubmit="return confirm('¿Seguro que deseas abandonar la partida?')">
                @csrf

                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg">
                    Abandonar partida
                </button>
            </form>
        @endif

    </div>

</div>

<script>

    const urlActualizar = "{{ route('partidas.actualizar', $partida->id) }}";
    const urlMovimiento = "{{ route('partidas.movimiento', $partida->id) }}";
    const token = "{{ csrf_token() }}";
    const miUsuario = {{ auth()->id() }};

async function actualizarTablero() {
    try {
        const respuesta = await fetch(urlActualizar);

        if (!respuesta.ok) {
            return;
        }

        const datos = await respuesta.json();
        let contenido = '';

        datos.tablero.forEach((casilla, indice) => {

            let esMiTurno =
                (datos.turno == 'X' && datos.jugador1_id == miUsuario) ||
                (datos.turno == 'O' && datos.jugador2_id == miUsuario);

            if (
                datos.estado == 'En curso' &&
                esMiTurno &&
                casilla == ''
            ) {
                contenido += `
                    <button
                        onclick="realizarMovimiento(${indice})"
                        class="bg-white border-2 border-gray-300 rounded-xl
                        text-4xl font-bold h-24 hover:bg-blue-100">
                        ${casilla}
                    </button>
                `;
            } else {
                contenido += `
                    <div class="bg-white border-2 border-gray-300 rounded-xl
                    text-4xl font-bold h-24 flex items-center justify-center">
                        ${casilla}
                    </div>
                `;
            }
        });

        document.getElementById('tablero').innerHTML = contenido;

        document.getElementById('jugador1').textContent = datos.jugador1;
        document.getElementById('jugador2').textContent =
            datos.jugador2 ?? 'Esperando jugador';

        let mensaje = '';

        if (datos.estado == 'Disponible') {
            mensaje = 'Esperando a que otro jugador se una.';
        } else if (datos.estado == 'En curso') {
            mensaje = 'Turno de: ' + datos.turno;
        } else if (datos.estado == 'Finalizada') {
            mensaje = '¡Partida finalizada! Ganador: ' + datos.ganador;
        } else if (datos.estado == 'Empate') {
            mensaje = '¡La partida terminó en empate!';
        } else if (datos.estado == 'Cancelada') {
            mensaje = 'La partida fue cancelada.';
        }

        document.getElementById('mensaje').textContent = mensaje;

    } catch (error) {
        console.log('Error al actualizar el tablero:', error);
    }
}



async function realizarMovimiento(casilla) {
    const datos = new FormData();

    datos.append('_token', token);
    datos.append('casilla', casilla);

    try {
        const respuesta = await fetch(urlMovimiento, {
            method: 'POST',
            body: datos,
            headers: {
                'Accept': 'application/json'
            }
        });

        const resultado = await respuesta.json();

        document.getElementById('mensaje').textContent =
            resultado.mensaje;

        await actualizarTablero();

    } catch (error) {
        document.getElementById('mensaje').textContent =
            'Ocurrió un error al realizar el movimiento.';
    }
}


    setInterval(actualizarTablero, 2000);

</script>

@endsection
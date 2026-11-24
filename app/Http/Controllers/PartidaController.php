<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Partida;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PartidaController extends Controller
{
    //index
    public function index()
    {
        $partidas = Partida::with(['jugador1', 'jugador2'])
            ->where('estado', 'Disponible')
            ->orderBy('created_at', 'desc')
            ->get();

        $jugadores = User::whereHas('role', function ($query) {
            $query->where('nombre', 'Jugador');
        })
        ->where('id', '!=', Auth::id())
        ->get();

        return view('practica6.partidas.index', compact('partidas', 'jugadores'));
    }
//Crear
    public function crear()
    {
        Partida::create([
            'jugador1_id' => Auth::id(),
            'tablero' => [
                '', '', '',
                '', '', '',
                '', '', ''
            ],
            'turno' => 'X',
            'estado' => 'Disponible'
        ]);

        return redirect()->route('partidas.index')
            ->with('success', 'Partida creada correctamente.');
    }
    //unirse
    public function unirse($id)
{
    $partida = Partida::findOrFail($id);

    if ($partida->estado != 'Disponible') {
        return back()->with('error', 'Esta partida ya no está disponible.');
    }

    if ($partida->jugador1_id == Auth::id()) {
        return back()->with('error', 'No puedes unirte a tu propia partida.');
    }

    $partida->update([
        'jugador2_id' => Auth::id(),
        'estado' => 'En curso'
    ]);

    return redirect()->route('partidas.jugar', $partida->id)
        ->with('success', 'Te has unido a la partida.');
}
//jugar
public function jugar($id)
{
    $partida = Partida::with(['jugador1', 'jugador2'])
        ->findOrFail($id);

    if (
        $partida->jugador1_id != Auth::id() &&
        $partida->jugador2_id != Auth::id()
    ) {
        abort(403, 'No tienes permiso para acceder a esta partida.');
    }

    return view('practica6.partidas.jugar', compact('partida'));
}

//actualizar

public function actualizar($id)
{
    $partida = Partida::with(['jugador1', 'jugador2', 'ganador'])
        ->findOrFail($id);

    if (
        $partida->jugador1_id != Auth::id() &&
        $partida->jugador2_id != Auth::id()
    ) {
        abort(403, 'No tienes permiso para consultar esta partida.');
    }

    return response()->json([
        'id' => $partida->id,
        'jugador1_id' => $partida->jugador1_id,
        'jugador2_id' => $partida->jugador2_id,
        'tablero' => $partida->tablero,
        'turno' => $partida->turno,
        'estado' => $partida->estado,
        'version' => $partida->version,
        'ganador' => $partida->ganador
            ? $partida->ganador->name
            : null,
        'jugador1' => $partida->jugador1->name,
        'jugador2' => $partida->jugador2
            ? $partida->jugador2->name
            : null
    ]);
}



//movimientos

public function movimiento(Request $request, $id)
{
    $request->validate([
        'casilla' => 'required|integer|min:0|max:8'
    ]);

    $resultado = DB::transaction(function () use ($request, $id) {

        $partida = Partida::where('id', $id)
            ->lockForUpdate()
            ->firstOrFail();

        if ($partida->estado != 'En curso') {
            return 'La partida no está en curso.';
        }

        if (
            $partida->jugador1_id != Auth::id() &&
            $partida->jugador2_id != Auth::id()
        ) {
            abort(403, 'No perteneces a esta partida.');
        }

        if ($partida->turno == 'X') {
            $jugadorTurno = $partida->jugador1_id;
        } else {
            $jugadorTurno = $partida->jugador2_id;
        }

        if ($jugadorTurno != Auth::id()) {
            return 'No es tu turno.';
        }

        $tablero = $partida->tablero;
        $casilla = $request->casilla;

        if ($tablero[$casilla] != '') {
            return 'Esta casilla ya está ocupada.';
        }

        $tablero[$casilla] = $partida->turno;

        $combinaciones = [
            [0, 1, 2],
            [3, 4, 5],
            [6, 7, 8],
            [0, 3, 6],
            [1, 4, 7],
            [2, 5, 8],
            [0, 4, 8],
            [2, 4, 6]
        ];

        $ganador = false;

        foreach ($combinaciones as $combinacion) {
            if (
                $tablero[$combinacion[0]] != '' &&
                $tablero[$combinacion[0]] == $tablero[$combinacion[1]] &&
                $tablero[$combinacion[1]] == $tablero[$combinacion[2]]
            ) {
                $ganador = true;
                break;
            }
        }

        $datos = [
            'tablero' => $tablero,
            'version' => $partida->version + 1
        ];

        if ($ganador) {
            $datos['estado'] = 'Finalizada';
            $datos['ganador_id'] = $partida->turno == 'X'
                ? $partida->jugador1_id
                : $partida->jugador2_id;
        } elseif (!in_array('', $tablero)) {
            $datos['estado'] = 'Empate';
        } else {
            $datos['turno'] = $partida->turno == 'X' ? 'O' : 'X';
        }

        $actualizado = Partida::where('id', $id)
            ->where('version', $partida->version)
            ->where('turno', $partida->turno)
            ->where('estado', 'En curso')
            ->update($datos);

        if ($actualizado == 0) {
            return 'La partida cambió. Actualiza el tablero e intenta nuevamente.';
        }

        return 'Movimiento realizado correctamente.';
    });

    if ($request->expectsJson()) {
        if ($resultado != 'Movimiento realizado correctamente.') {
            return response()->json([
                'mensaje' => $resultado
            ], 422);
        }

        return response()->json([
            'mensaje' => $resultado
        ]);
    }

    if ($resultado != 'Movimiento realizado correctamente.') {
        return back()->with('error', $resultado);
    }

    return back();
}
//abandonar
public function abandonar($id)
{
    $partida = Partida::findOrFail($id);

    if (
        $partida->jugador1_id != Auth::id() &&
        $partida->jugador2_id != Auth::id()
    ) {
        abort(403, 'No perteneces a esta partida.');
    }

    if ($partida->estado != 'En curso') {
        return back()->with('error', 'Esta partida ya terminó.');
    }

    $partida->update([
        'estado' => 'Cancelada'
    ]);

    return redirect()->route('partidas.index')
        ->with('success', 'Has abandonado la partida.');
}
//Historial
public function historial()
{
    $partidas = Partida::with(['jugador1', 'jugador2', 'ganador'])
        ->where(function ($query) {
            $query->where('jugador1_id', Auth::id())
                ->orWhere('jugador2_id', Auth::id());
        })
        ->orderBy('created_at', 'desc')
        ->get();

    return view('practica6.partidas.historial', compact('partidas'));
}

//Usuarios
public function usuarios()
{
    $usuarios = User::with('role')
        ->orderBy('name', 'asc')
        ->get();

    return view('practica6.admin.usuarios', compact('usuarios'));
}
//Cola de partidas
public function todasLasPartidas()
{
    $partidas = Partida::with(['jugador1', 'jugador2', 'ganador'])
        ->orderBy('created_at', 'desc')
        ->get();

    return view('practica6.admin.partidas', compact('partidas'));
}
//Cancelar-Admin
public function cancelarAdmin($id)
{
    $partida = Partida::findOrFail($id);

    if ($partida->estado != 'En curso') {
        return back()->with('error', 'La partida no está en curso.');
    }

    $partida->update([
        'estado' => 'Cancelada'
    ]);

    return back()->with('success', 'Partida cancelada correctamente.');
}

}

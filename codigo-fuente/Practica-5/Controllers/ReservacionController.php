<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Equipo;
use App\Models\Reservacion;

class ReservacionController extends Controller
{
    // Mostrar todos los equipos disponibles
    public function disponibles()
    {
        $equipos = Equipo::where('estado', 'Disponible')
            ->orderBy('nombre', 'asc')
            ->get();

        return view('practica5.reservaciones.disponibles', compact('equipos'));
    }

    // Mostrar formulario para reservar
    public function create($id)
    {
        $equipo = Equipo::findOrFail($id);

        if ($equipo->estado != 'Disponible') {
            return back()->with('error', 'Este equipo no está disponible.');
        }

        return view('practica5.reservaciones.create', compact('equipo'));
    }

    // Registrar reservación
    public function store(Request $request)
    {
        $request->validate([
            'equipo_id' => 'required|exists:equipos,id',
            'fecha_inicio' => 'required|date|after:now',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'observaciones' => 'nullable|string'
        ]);

        // Convertir las fechas al mismo formato
        $fechaInicio = Carbon::parse($request->fecha_inicio)
            ->format('Y-m-d H:i:s');

        $fechaFin = Carbon::parse($request->fecha_fin)
            ->format('Y-m-d H:i:s');

        $reservacion = DB::transaction(function () use ($request, $fechaInicio, $fechaFin) {

            $equipo = Equipo::where('id', $request->equipo_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($equipo->estado != 'Disponible') {
                return false;
            }

            // Comprobar si el equipo ya está reservado
            $ocupado = Reservacion::where('equipo_id', $equipo->id)
                ->where('estado', 'Activa')
                ->where('fecha_inicio', '<', $fechaFin)
                ->where('fecha_fin', '>', $fechaInicio)
                ->exists();

            if ($ocupado) {
                return false;
            }

            return Reservacion::create([
                'user_id' => Auth::id(),
                'equipo_id' => $equipo->id,
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'estado' => 'Activa',
                'observaciones' => $request->observaciones
            ]);
        });

        if (!$reservacion) {
            return back()->with('error', 'El equipo ya está reservado en ese horario.');
        }

        return redirect()->route('reservaciones.mis')
            ->with('success', 'Reservación realizada correctamente.');
    }

    // Mostrar reservaciones del usuario
    public function misReservaciones()
    {
        $reservaciones = Reservacion::with('equipo')
            ->where('user_id', Auth::id())
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        return view('practica5.reservaciones.mis', compact('reservaciones'));
    }

    // Cancelar una reservación propia
    public function cancelar($id)
    {
        $reservacion = Reservacion::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($reservacion->estado != 'Activa') {
            return back()->with('error', 'Esta reservación ya no está activa.');
        }

        $reservacion->update([
            'estado' => 'Cancelada'
        ]);

        return back()->with('success', 'Reservación cancelada correctamente.');
    }

    // Mostrar todas las reservaciones (Administrador)
    public function index()
    {
        $reservaciones = Reservacion::with(['usuario', 'equipo'])
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        return view('practica5.reservaciones.index', compact('reservaciones'));
    }

    // Cancelar reservación (Administrador)
    public function cancelarAdmin($id)
    {
        $reservacion = Reservacion::findOrFail($id);

        if ($reservacion->estado != 'Activa') {
            return back()->with('error', 'Esta reservación ya no está activa.');
        }

        $reservacion->update([
            'estado' => 'Cancelada'
        ]);

        return back()->with('success', 'Reservación cancelada por el administrador.');
    }
}

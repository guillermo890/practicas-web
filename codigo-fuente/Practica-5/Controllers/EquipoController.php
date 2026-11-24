<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipo;
use App\Models\Reservacion;

class EquipoController extends Controller
{
    // Mostrar todos los equipos
    public function index()
    {
        $equipos = Equipo::orderBy('nombre', 'asc')->get();

        return view('practica5.equipos.index', compact('equipos'));
    }

    // Mostrar formulario para registrar equipo
    public function create()
    {
        return view('practica5.equipos.create');
    }

    // Guardar equipo
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'numero_serie' => 'required|string|unique:equipos,numero_serie',
            'ubicacion' => 'required|string|max:255',
            'estado' => 'required|in:Disponible,No disponible'
        ]);

        Equipo::create($request->all());

        return redirect()->route('equipos.index')
            ->with('success', 'Equipo registrado correctamente.');
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $equipo = Equipo::findOrFail($id);

        return view('practica5.equipos.edit', compact('equipo'));
    }

    // Actualizar equipo
    public function update(Request $request, $id)
    {
        $equipo = Equipo::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'numero_serie' => 'required|string|unique:equipos,numero_serie,' . $id,
            'ubicacion' => 'required|string|max:255',
            'estado' => 'required|in:Disponible,No disponible'
        ]);

        $equipo->update($request->all());

        return redirect()->route('equipos.index')
            ->with('success', 'Equipo actualizado correctamente.');
    }

    // Eliminar equipo
    public function destroy($id)
    {
        $equipo = Equipo::findOrFail($id);

        if ($equipo->reservaciones()->where('estado', 'Activa')->exists()) {
            return back()->with('error', 'No puedes eliminar un equipo con reservaciones activas.');
        }

        $equipo->delete();

        return redirect()->route('equipos.index')
            ->with('success', 'Equipo eliminado correctamente.');
    }
}
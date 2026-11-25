<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
//Obtener equivalencias de calificacion
class AlumnoController extends Controller
{
    private function obtenerEquivalencia($calificacion)
    {
        if ($calificacion < 70) {
            return 'NA';
        } elseif ($calificacion < 80) {
            return 'SA';
        } elseif ($calificacion < 90) {
            return 'DE';
        } else {
            return 'AU';
        }
    }

    public function index(Request $request)
    {
        $alumnos = Alumno::with('usuario')
            ->when($request->orden == 'nombre', function ($consulta) {
                $consulta->orderBy('nombre', 'asc');
            })
            ->when($request->orden == 'calificacion_asc', function ($consulta) {
                $consulta->orderBy('calificacion', 'asc');
            })
            ->when($request->orden == 'calificacion_desc', function ($consulta) {
                $consulta->orderBy('calificacion', 'desc');
            })
            ->when($request->orden == 'faltas_asc', function ($consulta) {
                $consulta->orderBy('faltas', 'asc');
            })
            ->when($request->orden == 'faltas_desc', function ($consulta) {
                $consulta->orderBy('faltas', 'desc');
            })
            ->paginate(10)
            ->withQueryString();

        return view('practica3.alumnos.index', compact('alumnos'));
    }

public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'faltas' => 'required|integer|min:0',
        'calificacion' => 'required|numeric|min:0|max:100',
        'user_id' => 'required|exists:users,id|unique:alumnos,user_id'
    ]);

    $usuario = \App\Models\User::where('id', $request->user_id)
        ->whereHas('role', function ($consulta) {
            $consulta->where('nombre', 'Alumno');
        })
        ->first();

    if (!$usuario) {
        return back()
            ->withErrors(['user_id' => 'La cuenta seleccionada no pertenece a un alumno.'])
            ->withInput();
    }

    Alumno::create([
        'nombre' => $request->nombre,
        'faltas' => $request->faltas,
        'calificacion' => $request->calificacion,
        'equivalencia' => $this->obtenerEquivalencia($request->calificacion),
        'user_id' => $request->user_id
    ]);

    return redirect()->route('alumnos.index')
        ->with('success', 'Registro académico creado correctamente.');
}

  public function create()
{
    $usuarios = \App\Models\User::whereHas('role', function ($consulta) {
        $consulta->where('nombre', 'Alumno');
    })->whereDoesntHave('alumno')->get();

    return view('practica3.alumnos.create', compact('usuarios'));
}
      public function miInformacion()
{
    $alumno = auth()->user()->alumno;

    return view('practica3.alumnos.mi-informacion', compact('alumno'));
}
public function edit($id)
{
    $alumno = Alumno::findOrFail($id);

    return view('practica3.alumnos.edit', compact('alumno'));
}

public function update(Request $request, $id)
{
    $alumno = Alumno::findOrFail($id);

    $request->validate([
        'nombre' => 'required|string|max:255',
        'faltas' => 'required|integer|min:0',
        'calificacion' => 'required|numeric|min:0|max:100'
    ]);

    $alumno->update([
        'nombre' => $request->nombre,
        'faltas' => $request->faltas,
        'calificacion' => $request->calificacion,
        'equivalencia' => $this->obtenerEquivalencia($request->calificacion)
    ]);

    return redirect()->route('alumnos.index')
        ->with('success', 'Información académica actualizada correctamente.');
}

public function destroy($id)
{
    $alumno = Alumno::findOrFail($id);

    $alumno->delete();

    return redirect()->route('alumnos.index')
        ->with('success', 'Registro académico eliminado correctamente.');
}

}


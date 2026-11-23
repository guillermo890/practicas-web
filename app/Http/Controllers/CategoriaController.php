<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::orderBy('nombre', 'asc')->get();

        return view('practica4.categorias.index', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre',
            'descripcion' => 'nullable|string'
        ]);

        Categoria::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría registrada correctamente.');
    }

    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);

        if ($categoria->productos()->exists()) {
            return back()->with('error', 'No puedes eliminar una categoría que tiene productos.');
        }

        $categoria->delete();

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría eliminada correctamente.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Http\Requests\ProductoRequest;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // Consulta los productos aplicando filtros, ordenamiento y paginación.
    public function index(Request $request)
    {
        $productos = Producto::with('categoria');

        if ($request->nombre) {
            $productos->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->categoria_id) {
            $productos->where('categoria_id', $request->categoria_id);
        }

        if ($request->precio_min !== null && $request->precio_min !== '') {
            $productos->where('precio', '>=', $request->precio_min);
        }

        if ($request->precio_max !== null && $request->precio_max !== '') {
            $productos->where('precio', '<=', $request->precio_max);
        }

        if ($request->estado) {
            $productos->where('estado', $request->estado);
        }

        // Selecciona el orden solicitado.
        switch ($request->orden) {
            case 'nombre_asc':
                $productos->orderBy('nombre', 'asc');
                break;

            case 'nombre_desc':
                $productos->orderBy('nombre', 'desc');
                break;

            case 'precio_asc':
                $productos->orderBy('precio', 'asc');
                break;

            case 'precio_desc':
                $productos->orderBy('precio', 'desc');
                break;

            case 'stock_asc':
                $productos->orderBy('stock', 'asc');
                break;

            case 'stock_desc':
                $productos->orderBy('stock', 'desc');
                break;

            case 'fecha_asc':
                $productos->orderBy('fecha_registro', 'asc');
                break;

            default:
                $productos->orderBy('fecha_registro', 'desc');
                break;
        }

        // Limita las opciones de registros por página.
        $porPagina = $request->get('por_pagina', 10);

        if (!in_array((int) $porPagina, [10, 15, 25, 50])) {
            $porPagina = 10;
        }

        $productos = $productos->paginate($porPagina)->withQueryString();

        $categorias = Categoria::orderBy('nombre')->get();

        return view('practica4.productos.index', compact(
            'productos',
            'categorias',
            'porPagina'
        ));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('practica4.productos.create', compact('categorias'));
    }

    // Guarda el producto después de validar los datos.
    public function store(ProductoRequest $request)
    {
        $datos = $request->validated();

        $datos['fecha_registro'] = now()->toDateString();

        Producto::create($datos);

        return redirect()->route('productos.index')
            ->with('success', 'Producto registrado correctamente.');
    }

    public function show($id)
    {
        $producto = Producto::with('categoria')->findOrFail($id);

        return view('practica4.productos.show', compact('producto'));
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::orderBy('nombre')->get();

        return view('practica4.productos.edit', compact(
            'producto',
            'categorias'
        ));
    }

    public function update(ProductoRequest $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $producto->update($request->validated());

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255|unique:productos,nombre,' . $this->route('id'),
            'descripcion' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'precio' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
            'estado' => 'required|in:Disponible,Agotado',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.unique' => 'Ya existe un producto con ese nombre.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'categoria_id.required' => 'Debes seleccionar una categoría.',
            'categoria_id.exists' => 'La categoría seleccionada no existe.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser numérico.',
            'precio.min' => 'El precio debe ser mayor que cero.',
            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser negativo.',
            'estado.required' => 'Debes seleccionar un estado.',
            'estado.in' => 'El estado seleccionado no es válido.',
        ];
    }
}

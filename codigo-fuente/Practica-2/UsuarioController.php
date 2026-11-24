<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UsuarioController extends Controller
{
    // Comprobar si el usuario es administrador
    private function esAdministrador()
    {
        return auth()->user()->role->nombre == 'Administrador';
    }

    // Mostrar usuarios
    public function index()
    {
        $usuarios = User::with('role')->latest()->paginate(10);

        return view('practica2.usuarios.index', compact('usuarios'));
    }

    // Mostrar formulario de registro
    public function create()
    {
        $roles = Role::all();

        return view('practica2.usuarios.create', compact('roles'));
    }

    // Guardar usuario
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role_id' => 'required|exists:roles,id'
        ]);

        $rol = Role::findOrFail($request->role_id);

        // El empleado solamente puede crear usuarios empleados
        if (!$this->esAdministrador() && $rol->nombre != 'Empleado') {
            abort(403, 'No puedes asignar ese rol.');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $rol->id
        ]);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario registrado correctamente.');
    }

    // Mostrar información del usuario
    public function show(User $usuario)
    {
        return view('practica2.usuarios.show', compact('usuario'));
    }

    // Mostrar formulario de edición
    public function edit(User $usuario)
    {
        $roles = Role::all();

        return view('practica2.usuarios.edit', compact('usuario', 'roles'));
    }

    // Actualizar usuario
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'password' => 'nullable|min:8',
            'role_id' => 'required|exists:roles,id'
        ]);

        $rol = Role::findOrFail($request->role_id);

        // El empleado no puede asignar otros roles
        if (!$this->esAdministrador() && $rol->nombre != 'Empleado') {
            abort(403, 'No puedes asignar ese rol.');
        }

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->role_id = $rol->id;

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    // Eliminar temporalmente
    public function destroy(User $usuario)
    {
        abort_unless($this->esAdministrador(), 403);

        if ($usuario->id == auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado temporalmente.');
    }

    // Mostrar usuarios eliminados
    public function eliminados()
    {
        abort_unless($this->esAdministrador(), 403);

        $usuarios = User::onlyTrashed()->with('role')->paginate(10);

        return view('practica2.usuarios.eliminados', compact('usuarios'));
    }

    // Recuperar usuario
    public function restaurar($id)
    {
        abort_unless($this->esAdministrador(), 403);

        $usuario = User::onlyTrashed()->findOrFail($id);

        $usuario->restore();

        return redirect()->route('usuarios.eliminados')
            ->with('success', 'Usuario recuperado correctamente.');
    }

    // Eliminar permanentemente
    public function eliminarPermanente($id)
    {
        abort_unless($this->esAdministrador(), 403);

        $usuario = User::onlyTrashed()->findOrFail($id);

        if ($usuario->id == auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $usuario->forceDelete();

        return redirect()->route('usuarios.eliminados')
            ->with('success', 'Usuario eliminado permanentemente.');
    }
}

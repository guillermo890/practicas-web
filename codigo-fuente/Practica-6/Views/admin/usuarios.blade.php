@extends('layouts.app')
@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-3xl font-bold text-gray-800">
            Administración de usuarios
        </h2>
        <p class="text-gray-600">
            Usuarios registrados en el sistema.
        </p>
    </div>

    <a href="{{ route('inicio') }}"
       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
        Regresar al menú
    </a>
</div>

<div class="bg-white rounded-xl shadow-md p-6">

    <div class="overflow-x-auto">
        <table class="w-full text-left">

            <thead>
                <tr class="border-b bg-gray-50">
                    <th class="p-3">ID</th>
                    <th class="p-3">Nombre</th>
                    <th class="p-3">Correo electrónico</th>
                    <th class="p-3">Rol</th>
                    <th class="p-3">Fecha de registro</th>
                </tr>
            </thead>

            <tbody>

                @foreach($usuarios as $usuario)

                    <tr class="border-b">

                        <td class="p-3">
                            {{ $usuario->id }}
                        </td>

                        <td class="p-3">
                            {{ $usuario->name }}
                        </td>

                        <td class="p-3">
                            {{ $usuario->email }}
                        </td>

                        <td class="p-3">
                            {{ $usuario->role->nombre ?? 'Sin rol' }}
                        </td>

                        <td class="p-3">
                            {{ $usuario->created_at->format('d/m/Y') }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>
    </div>

</div>

@endsection

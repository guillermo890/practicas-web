<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel principal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <nav class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">
            Sistema de Prácticas
        </h1>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg">
                Cerrar sesión
            </button>
        </form>
    </nav>

    <main class="max-w-7xl mx-auto p-6">

        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800">
                Bienvenido, {{ Auth::user()->name }}
            </h2>

            <p class="text-gray-500 mt-2">
                Selecciona la práctica que deseas consultar.
            </p>

            <p class="text-sm text-gray-600 mt-1">
                Rol: {{ Auth::user()->role->nombre }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-lg font-bold text-gray-800 mb-2">
                    Práctica 1
                </h3>
                <p class="text-gray-600 mb-4">
                    Autenticación basada en roles.
                </p>
                <a href="#"
                    class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Entrar
                </a>
            </div>

            
            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition">
              <h3 class="text-xl font-bold text-gray-800 mb-2">
                Práctica 2
                </h3>
             <p class="text-gray-600 mb-4">
              CRUD de usuarios con permisos según el rol.
              </p>
              <a href="{{ route('usuarios.index') }}"
              class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
             Administrar usuarios
            </a>
            </div>

            
<div class="bg-white p-6 rounded-xl shadow hover:shadow-xl transition">
    <h3 class="text-lg font-bold text-gray-800 mb-2">
        Práctica 3
    </h3>

    <p class="text-gray-600 mb-4">
        Sistema de información académica.
    </p>

    @if(Auth::user()->role->nombre == 'Profesor')

        <a href="{{ route('alumnos.index') }}"
            class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            Administrar alumnos
        </a>

    @elseif(Auth::user()->role->nombre == 'Alumno')

        <a href="{{ route('alumnos.mi-informacion') }}"
            class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            Mi información académica
        </a>

    @else

        <p class="text-gray-500 text-sm">
            No tienes acceso a esta práctica.
        </p>

    @endif
</div>

            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-lg font-bold text-gray-800 mb-2">
                    Práctica 4
                </h3>
                <p class="text-gray-600 mb-4">
                    Administración de productos.
                </p>
                <a href="#"
                    class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Entrar
                </a>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-lg font-bold text-gray-800 mb-2">
                    Práctica 5
                </h3>
                <p class="text-gray-600 mb-4">
                    Reservaciones de equipo de cómputo.
                </p>
                <a href="#"
                    class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Entrar
                </a>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-lg font-bold text-gray-800 mb-2">
                    Práctica 6
                </h3>
                <p class="text-gray-600 mb-4">
                    Juego de tres en raya.
                </p>
                <a href="#"
                    class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Entrar
                </a>
            </div>

        </div>

    </main>

</body>
</html>

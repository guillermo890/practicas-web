<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar usuario</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-gray-800 text-white px-6 py-4">
        <h1 class="text-xl font-bold">Sistema de Prácticas</h1>
    </nav>

    <main class="max-w-3xl mx-auto p-6">

        <div class="bg-white rounded-xl shadow-lg p-8">

            <h2 class="text-2xl font-bold text-gray-800 mb-2">
                Registrar usuario
            </h2>

            <p class="text-gray-500 mb-6">
                Completa los datos del nuevo usuario.
            </p>

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('usuarios.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">
                        Nombre completo
                    </label>

                    <input type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">
                        Correo electrónico
                    </label>

                    <input type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">
                        Contraseña
                    </label>

                    <input type="password"
                        name="password"
                        required
                        minlength="8"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 mb-2">
                        Rol
                    </label>

                    <select name="role_id"
                        required
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500">

                        <option value="">Selecciona un rol</option>

                        @foreach($roles as $rol)
                            @if(auth()->user()->role->nombre == 'Administrador' || $rol->nombre == 'Empleado')
                                <option value="{{ $rol->id }}"
                                    {{ old('role_id') == $rol->id ? 'selected' : '' }}>
                                    {{ $rol->nombre }}
                                </option>
                            @endif
                        @endforeach

                    </select>
                </div>

                <div class="flex justify-between">

                    <a href="{{ route('usuarios.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-3 rounded-lg">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg">
                        Guardar usuario
                    </button>

                </div>

            </form>

        </div>

    </main>

</body>
</html>

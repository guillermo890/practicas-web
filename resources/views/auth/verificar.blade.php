<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar administrador</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">

        <h1 class="text-2xl font-bold text-gray-800 text-center mb-2">
            Verificación de administrador
        </h1>

        <p class="text-gray-500 text-center mb-6">
            Ingresa el código de seis dígitos enviado a tu correo.
        </p>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('verificar.codigo.post') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label class="block text-gray-700 mb-2">
                    Código de verificación
                </label>

                <input
                    type="text"
                    name="codigo"
                    maxlength="6"
                    inputmode="numeric"
                    pattern="[0-9]{6}"
                    required
                    class="w-full border border-gray-300 rounded-lg p-3 text-center text-xl tracking-widest focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="000000">
            </div>

            <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg">
                Verificar código
            </button>
        </form>

    </div>

</body>
</html>

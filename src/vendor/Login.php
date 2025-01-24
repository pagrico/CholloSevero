<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Importación de Tailwind CSS desde el CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="flex h-screen w-full items-center justify-center bg-gray-900 bg-cover bg-no-repeat"
        style="background-image:url('../imagenes/chollos.png')">
        <div class="rounded-xl bg-gray-800 bg-opacity-50 px-16 py-10 shadow-lg backdrop-blur-md max-sm:px-8">
            <div class="text-white">
                <div class="mb-8 flex flex-col items-center">
                    <img src="https://www.chollometro.com/assets/images/schema.org/organisation/chollometro.png"
                        width="150" alt="LOGO" />
                    <h1 class="mb-2 text-2xl">Chollosevero</h1>
                    <span class="text-gray-300">Inicia Sesion</span>
                </div>
                <form action="validar.php" method="POST">
                    <!-- Input para email -->
                    <div class="mb-4 text-lg">
                        <input
                            class="rounded-3xl border-none bg-yellow-400 bg-opacity-50 px-6 py-2 text-center text-black placeholder-slate-700 shadow-lg outline-none backdrop-blur-md"
                            type="text" name="user" placeholder="ejemplo" required />

                    </div>

                    <!-- Input para contraseña -->
                    <div class="mb-4 text-lg">
                        <input
                            class="rounded-3xl border-none bg-yellow-400 bg-opacity-50 px-6 py-2 text-center text-black placeholder-slate-700 shadow-lg outline-none backdrop-blur-md"
                            type="password" name="password" placeholder="*********" required />
                    </div>
                    <div class="mt-8 flex justify-center text-lg text-black">
                        <button type="submit"
                            class="rounded-3xl bg-yellow-400 bg-opacity-50 px-10 py-2 text-white shadow-xl backdrop-blur-md transition-colors duration-300 hover:bg-yellow-600">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
<?php
session_start();
include "../conexion/conexion.php";

// Cerrar sesión si se hace clic en el botón de cerrar sesión
if (isset($_POST['logout'])) {
    session_unset(); // Elimina todas las variables de sesión
    session_destroy(); // Destruye la sesión
    header('Location: Login.php'); // Redirige al login
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos los Chollos</title>
    <!-- Importación de Tailwind CSS desde el CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>


<nav class="fixed top-0 left-0 z-20 w-full border-b border-gray-200 bg-white py-2.5 px-6 sm:px-4">
    <div class="container mx-auto flex max-w-6xl flex-wrap items-center justify-between">
        <a href="index.php" class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="mr-3 h-6 text-blue-500 sm:h-9">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
            </svg>
            <span class="self-center whitespace-nowrap text-xl font-semibold">Chollosevero</span>
        </a>
        <div class="mt-2 sm:mt-0 sm:flex md:order-2 flex items-center gap-5 p-1">
            <?php if (isset($_SESSION['usuario'])): ?>
                <!-- Mostrar nombre de usuario si está logueado -->
                <span class="text-sm font-medium text-blue-700">
                    Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>
                </span>
                <!-- Botón de cerrar sesión con el icono de cerrar -->
                <form action="" method="POST">
                    <button type="submit" name="logout"
                        class="flex items-center justify-center gap-2 text-sm text-red-500 hover:text-red-700 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 512 512"
                            class="text-red-500">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="32"
                                d="M320 176v-40a40 40 0 0 0-40-40H88a40 40 0 0 0-40 40v240a40 40 0 0 0 40 40h192a40 40 0 0 0 40-40v-40m64-160l80 80l-80 80m-193-80h273" />
                        </svg>
                        <span class="text-sm font-semibold">Cerrar sesión</span>
                    </button>
                </form>

            </div>


            </form>
        <?php else: ?>
            <!-- Si no está logueado, mostrar el botón de login -->
            <a href="Login.php"
                class="mr-3 hidden border border-blue-700 py-1.5 px-6 text-center text-sm font-medium text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 md:inline-block rounded-lg">
                Login
            </a>
        <?php endif; ?>
    </div>
    </div>
</nav>
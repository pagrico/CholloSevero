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

// Obtener todos los chollos de la base de datos
$sql = "SELECT id_chollo, id_usuario, titulo_chollo, descripcion_chollo, precio_chollo, imagen_chollo, fecha_creacion FROM chollos";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$chollos = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtener todos los registros como un array asociativo
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos los Chollos</title>
    <!-- Importación de Tailwind CSS desde el CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white">
    <!-- Header Navbar -->
    <nav class="fixed top-0 left-0 z-20 w-full border-b border-gray-200 bg-white py-2.5 px-6 sm:px-4">
        <div class="container mx-auto flex max-w-6xl flex-wrap items-center justify-between">
            <a href="#" class="flex items-center">
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
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" 
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

    <!-- Title -->
    <div class="pt-32 bg-white text-center mb-10">
        <h1 class="text-2xl font-bold text-gray-800">Todos los Chollos</h1>
        <?php if (isset($_SESSION['usuario'])): ?>
            <button
                class="mt-6 px-8 py-4 bg-blue-500 text-white text-lg font-semibold rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 transform hover:scale-105">
                Añadir Chollo
            </button>
        <?php endif; ?>
    </div>

    <!-- Product List -->
    <section class="py-10 bg-gray-100">
    <div class="mx-auto grid max-w-6xl grid-cols-1 gap-6 p-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <?php foreach ($chollos as $chollo): ?>
            <article
                class="relative rounded-xl bg-white p-3 shadow-lg hover:shadow-xl hover:transform hover:scale-105 duration-300">
                <a href="#">
                    <!-- Contenedor de la imagen -->
                    <div class="relative flex items-end overflow-hidden rounded-xl">
                        <img src="<?php echo htmlspecialchars($chollo['imagen_chollo']); ?>" 
                            alt="<?php echo htmlspecialchars($chollo['titulo_chollo']); ?>" 
                            class="w-full h-48 object-cover rounded-xl" />
                    </div>

                    <!-- Información del chollo -->
                    <div class="mt-1 p-2 mb-10">
                        <h2 class="text-slate-700 font-semibold"><?php echo htmlspecialchars($chollo['titulo_chollo']); ?></h2>
                        <p class="mt-1 text-sm text-slate-400">
                            <?php echo htmlspecialchars($chollo['descripcion_chollo']); ?>
                        </p>
                    </div>

                    <!-- Precio y botón -->
                    <div class="absolute bottom-3 left-3 right-3 flex justify-between items-center">
                        <!-- Precio -->
                        <p class="text-lg font-bold text-blue-500">
                            $<?php echo htmlspecialchars($chollo['precio_chollo']); ?>
                        </p>
                        <!-- Botón Añadir al carrito -->
                        <div
                            class="flex items-center space-x-1.5 rounded-lg bg-blue-500 px-4 py-1.5 text-white duration-100 hover:bg-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                            <button class="text-sm">Añadir</button>
                        </div>
                    </div>
                </a>
            </article>
        <?php endforeach; ?>
    </div>
</section>


    <!-- Footer -->
    <footer class="py-6 bg-gray-200 text-gray-900">
        <div class="container px-6 mx-auto space-y-6 divide-y divide-gray-400 md:space-y-12 divide-opacity-50">
            <div class="grid justify-center lg:justify-between">
                <div class="flex flex-col self-center text-sm text-center md:block lg:col-start-1 md:space-x-6">
                    <span>Copyright © 2023 by codemix team </span>
                    <a rel="noopener noreferrer" href="#">
                        <span>Privacy policy</span>
                    </a>
                    <a rel="noopener noreferrer" href="#">
                        <span>Terms of service</span>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
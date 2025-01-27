<?php
session_start();
include "../conexion/conexion.php";

// Verifica si se recibió el ID de la oferta
if (!isset($_GET['id'])) {
    die("Error: ID de la oferta no especificado.");
}

$id_chollo = $_GET['id'];

// Obtén los detalles de la oferta
$sql = "SELECT titulo_chollo, descripcion_chollo, precio_chollo, imagen_chollo FROM chollos WHERE id_chollo = ?";
$stmt = $conexion->prepare($sql);
$stmt->execute([$id_chollo]);
$chollo = $stmt->fetch(PDO::FETCH_ASSOC);

// Si no se encuentra la oferta
if (!$chollo) {
    die("Error: Oferta no encontrada.");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Chollo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white">
    <!-- Header Navbar -->
    <?php include "header.php"; ?>

    <!-- Contenido de la oferta -->
    <div class="container mx-auto px-4 py-16">
        <div class="flex flex-col lg:flex-row lg:space-x-8">
            <!-- Imagen -->
            <div class="lg:w-1/2">
            <img src="<?php echo htmlspecialchars($chollo['imagen_chollo']); ?>" 
     alt="<?php echo htmlspecialchars($chollo['titulo_chollo']); ?>" 
     class="rounded-lg shadow-md"
     style="width: 643px; height: 643px; object-fit: contain;">

            </div>
            <!-- Detalles -->
            <div class="lg:w-1/2 mt-8 lg:mt-0">
    <h1 class="text-2xl font-bold text-gray-800">
        <?php echo htmlspecialchars($chollo['titulo_chollo']); ?>
    </h1>
    <p class="mt-4 text-gray-600">
        <?php echo htmlspecialchars($chollo['descripcion_chollo']); ?>
    </p>
    <p class="mt-6 text-3xl font-semibold text-blue-500">
        $<?php echo htmlspecialchars($chollo['precio_chollo']); ?>
    </p>
    
    <!-- Botón añadir al carrito -->
    <div class="mt-6">
        <button class="flex items-center justify-center px-8 py-3 bg-blue-500 text-white text-lg font-semibold rounded-lg shadow-lg transform transition-all hover:scale-105 hover:bg-blue-600 focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M2.237 2.288a.75.75 0 1 0-.474 1.423l.265.089c.676.225 1.124.376 1.453.529c.312.145.447.262.533.382s.155.284.194.626c.041.361.042.833.042 1.546v2.672c0 1.367 0 2.47.117 3.337c.12.9.38 1.658.982 2.26c.601.602 1.36.86 2.26.981c.866.117 1.969.117 3.336.117H18a.75.75 0 0 0 0-1.5h-7c-1.435 0-2.436-.002-3.192-.103c-.733-.099-1.122-.28-1.399-.556c-.235-.235-.4-.551-.506-1.091h10.12c.959 0 1.438 0 1.814-.248s.565-.688.943-1.57l.428-1c.81-1.89 1.215-2.834.77-3.508S18.506 6 16.45 6H5.745a9 9 0 0 0-.047-.833c-.055-.485-.176-.93-.467-1.333c-.291-.404-.675-.66-1.117-.865c-.417-.194-.946-.37-1.572-.58zM7.5 18a1.5 1.5 0 1 1 0 3a1.5 1.5 0 0 1 0-3m9 0a1.5 1.5 0 1 1 0 3a1.5 1.5 0 0 1 0-3"/></svg>                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h18M5 10h14l-1.5 6h-11L5 10z"></path>
            </svg>
            Añadir al carrito
        </button>
    </div>
</div>
        </div>
    </div>

    <!-- Footer -->
    <?php include "footer.php"; ?>
</body>

</html>

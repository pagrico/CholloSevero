<?php
session_start();
include "../conexion/conexion.php";

// Verifica si se recibió el ID de la oferta
if (!isset($_GET['id'])) {
    die("Error: ID de la oferta no especificado.");
}

$id_chollo = $_GET['id'];
$usuario_actual = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : null;

// Obtén los detalles de la oferta y el usuario creador desde la base de datos
$sql = "SELECT id_usuario, titulo_chollo, descripcion_chollo, precio_chollo, imagen_chollo FROM chollos WHERE id_chollo = ?";
$stmt = $conexion->prepare($sql);
$stmt->execute([$id_chollo]);
$chollo = $stmt->fetch(PDO::FETCH_ASSOC);

// Si no se encuentra la oferta
if (!$chollo) {
    die("Error: Oferta no encontrada.");
}

// Verificación de permisos desde la base de datos
$es_creador = false;
$es_admin = false;

if ($usuario_actual) {
    $sql_permiso = "SELECT id_usuario FROM chollos WHERE id_chollo = ?";
    $stmt_permiso = $conexion->prepare($sql_permiso);
    $stmt_permiso->execute([$id_chollo]);
    $resultado = $stmt_permiso->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        $es_creador = ($usuario_actual == $resultado['id_usuario']); // Usuario creó el chollo
        $es_admin = ($usuario_actual == 1); // Usuario es administrador
    }
}
?>

<!-- Header Navbar -->
<?php include "header.php"; ?>

<body class="bg-white">
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
                        Añadir al carrito
                    </button>
                </div>

                <!-- Botón eliminar (solo para creador o administrador) -->
                <?php if ($es_creador || $es_admin): ?>
                <div class="mt-4">
                    <form action="eliminar_chollo.php" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta oferta?');">
                        <input type="hidden" name="id_chollo" value="<?php echo $id_chollo; ?>">
                        <button type="submit" class="px-6 py-2 bg-red-500 text-white font-semibold rounded-lg shadow-md hover:bg-red-600">
                            Eliminar Oferta
                        </button>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include "footer.php"; ?>
</body>

</html>

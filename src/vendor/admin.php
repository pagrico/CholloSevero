<?php
include "../conexion/conexion.php";

// Obtener todos los usuarios y chollos
$usuarios = $conexion->query("SELECT * FROM usuarios")->fetchAll(PDO::FETCH_ASSOC);
$chollos = $conexion->query("SELECT * FROM chollos")->fetchAll(PDO::FETCH_ASSOC);

$alerta = "";

// Eliminar usuario
if (isset($_GET['delete_user'])) {
    $id_usuario = $_GET['delete_user'];
    
    // Verificar si el usuario tiene chollos asociados
    $check = $conexion->query("SELECT COUNT(*) FROM chollos WHERE id_usuario = $id_usuario")->fetchColumn();
    
    if ($check > 0) {
        $alerta = "<div class='bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4' role='alert'>
        <p class='font-bold'>No se puede eliminar</p>
        <p>El usuario tiene chollos creados y no puede ser eliminado.</p>
        </div>";
    } else {
        $conexion->query("DELETE FROM usuarios WHERE id_usuario = $id_usuario");
        header("Location: admin.php");
        exit();
    }
}

// Eliminar chollo
if (isset($_GET['delete_chollo'])) {
    $id_chollo = $_GET['delete_chollo'];
    $conexion->query("DELETE FROM chollos WHERE id_chollo = $id_chollo");
    header("Location: admin.php");
    exit();
}
include "header.php";
?>

<div class="pt-20 px-10">
    <h1 class="text-3xl font-bold text-gray-800 text-center mb-6">Panel de Administración</h1>
    
    <?php echo $alerta; ?>
    
    <!-- Tabla de Usuarios -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-10">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Usuarios</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2">ID</th>
                    <th class="border p-2">Nombre</th>
                    <th class="border p-2">Correo</th>
                    <th class="border p-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr class="text-center">
                        <td class="border p-2"><?php echo $usuario['id_usuario']; ?></td>
                        <td class="border p-2"><?php echo htmlspecialchars($usuario['nombre_usuario']); ?></td>
                        <td class="border p-2"><?php echo htmlspecialchars($usuario['correo_usuario']); ?></td>
                        <td class="border p-2">
                            <a href="admin.php?delete_user=<?php echo $usuario['id_usuario']; ?>" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Tabla de Chollos -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Chollos</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2">ID</th>
                    <th class="border p-2">Título</th>
                    <th class="border p-2">Descripción</th>
                    <th class="border p-2">Precio</th>
                    <th class="border p-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($chollos as $chollo): ?>
                    <tr class="text-center">
                        <td class="border p-2"><?php echo $chollo['id_chollo']; ?></td>
                        <td class="border p-2"><?php echo htmlspecialchars($chollo['titulo_chollo']); ?></td>
                        <td class="border p-2"><?php echo htmlspecialchars($chollo['descripcion_chollo']); ?></td>
                        <td class="border p-2">$<?php echo htmlspecialchars($chollo['precio_chollo']); ?></td>
                        <td class="border p-2">
                            <a href="admin.php?delete_chollo=<?php echo $chollo['id_chollo']; ?>" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include "footer.php"; ?>

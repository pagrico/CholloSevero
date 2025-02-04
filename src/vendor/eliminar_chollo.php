<?php
session_start();
include "../conexion/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['id_chollo']) || !isset($_SESSION['usuario'])) {
        die("Error: Datos incompletos.");
    }

    $id_chollo = $_POST['id_chollo'];
    $usuario_actual = $_SESSION['usuario_id'];

    // Obtener el creador del chollo
    $sql = "SELECT id_usuario FROM chollos WHERE id_chollo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$id_chollo]);
    $chollo = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$chollo) {
        die("Error: Oferta no encontrada.");
    }

    // Verificar que el usuario sea el creador o un administrador
    if ($usuario_actual != 1 && $usuario_actual != $chollo['id_usuario']) {
        die("Error: No tienes permiso para eliminar esta oferta.");
    }

    // Eliminar el chollo
    $sql = "DELETE FROM chollos WHERE id_chollo = ?";
    $stmt = $conexion->prepare($sql);
    if ($stmt->execute([$id_chollo])) {
        header("Location: index.php");
        exit();
    } else {
        die("Error al eliminar la oferta.");
    }
}
?>

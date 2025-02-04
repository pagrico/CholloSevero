<?php
session_start();  // Iniciar la sesión al inicio del archivo

include "../conexion/conexion.php";

// Obtener datos de entrada del formulario
$usuarioIngresado = $_POST["user"];
$PASSWORD = $_POST["password"];

// Preparar la consulta SQL
$sql = "SELECT * FROM `usuarios` WHERE nombre_usuario = :usuario";
$stmt = $conexion->prepare($sql);
$stmt->bindParam(':usuario', $usuarioIngresado);
$stmt->execute();

// Verificar si el usuario existe en la base de datos
if ($stmt->rowCount() > 0) {
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);  // Obtener los datos del usuario
    $contrasenaIngresada = $PASSWORD;
    $hashAlmacenado = $usuario["contrasena_usuario"];

    // Verificar la contraseña usando password_verify
    if (password_verify($contrasenaIngresada, $hashAlmacenado)) {
        // Si la contraseña es correcta, almacenar el id y nombre del usuario en la sesión
        $_SESSION['usuario'] = $usuario["nombre_usuario"]; // Guardar el nombre del usuario en la sesión
        $_SESSION['usuario_id'] = $usuario["id_usuario"]; // Guardar el ID del usuario en la sesión
        header("Location: index.php");  // Redirigir a index.php
        exit();  // Asegurarse de que no se ejecute más código
    } else {
        // Si la contraseña es incorrecta, redirigir a login.php con un mensaje de error
        echo "<script>alert('Contraseña incorrecta.'); window.location.href='login.php';</script>";
        exit();
    }
} else {
    // Si el usuario no es encontrado, redirigir a login.php con un mensaje de error
    echo "<script>alert('Usuario no encontrado.'); window.location.href='login.php';</script>";
    exit();
}
?>

<?php
include "../conexion/conexion.php";

// Lista de usuarios ficticios con contraseñas diferentes
$usuarios = [
    ["nombre" => "admin", "contrasena" => "admin123", "correo" => "admin@example.com", "rol" => 1],
    ["nombre" => "usuario1", "contrasena" => "secreto123", "correo" => "usuario1@example.com", "rol" => 2],
    ["nombre" => "usuario2", "contrasena" => "miPassword2", "correo" => "usuario2@example.com", "rol" => 2],
    ["nombre" => "usuario3", "contrasena" => "clave1234", "correo" => "usuario3@example.com", "rol" => 2],
    ["nombre" => "usuario4", "contrasena" => "passwordABC", "correo" => "usuario4@example.com", "rol" => 2],
    ["nombre" => "usuario5", "contrasena" => "contraseña2025", "correo" => "usuario5@example.com", "rol" => 2],
];

// Iterar sobre la lista de usuarios y generar las consultas de inserción
foreach ($usuarios as $usuario) {
    $contrasenaCifrada = password_hash($usuario["contrasena"], PASSWORD_BCRYPT);

    $sql = "INSERT INTO usuarios (nombre_usuario, contrasena_usuario, correo_usuario, id_rol) VALUES (
        '{$usuario["nombre"]}', 
        '{$contrasenaCifrada}', 
        '{$usuario["correo"]}', 
        {$usuario["rol"]}
    )";
    $conexion->query($sql);
}
?>
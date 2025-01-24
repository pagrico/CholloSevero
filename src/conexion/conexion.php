<?php

// ▒▒▒▒▒▒▒▒ pruebas.php ▒▒▒▒▒▒▒▒

// Configuración de la base de datos
$DSN = "mysql:host=db;dbname=chollosevero;charset=utf8mb4";
$USUARIO = "root";
$PASSWORD = "1234";

try {
    // Opciones adicionales para PDO
    $opciones = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Manejo de errores mediante excepciones
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_BOTH, // Devuelve resultados como arrays asociativos
        PDO::ATTR_EMULATE_PREPARES => false, // Desactiva la emulación de consultas preparadas
    ];

    // Intentar la conexión
    $conexion = new PDO($DSN, $USUARIO, $PASSWORD, $opciones);

} catch (PDOException $e) {
    // Manejo de errores
    error_log("Error al conectar a la base de datos: " . $e->getMessage(), 3, __DIR__ . "/error.log"); // Registro en archivo
    echo "Error al conectar a la base de datos. Por favor, revisa el archivo de log para más detalles.";
    exit; // Detener ejecución en caso de error fatal
}

?>
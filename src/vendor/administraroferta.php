<?php
include "../conexion/conexion.php";
session_start(); // Iniciar sesión para obtener el ID del usuario

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['usuario'])) {
        echo "Error: User not logged in.";
        exit();
    }

    $user_id = $_SESSION['usuario']; // Obtener el ID del usuario de la sesión
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $fecha_creacion = date("Y-m-d H:i:s"); // Obtener la fecha y hora actual

    // Manejo seguro de la imagen
    $imagePath = null;
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image'];
        $targetDir = "uploads/";
        $imageName = time() . "_" . basename($image["name"]); // Evitar nombres duplicados
        $imagePath = $targetDir . $imageName;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($image['type'], $allowedTypes)) {
            move_uploaded_file($image["tmp_name"], $imagePath);
        } else {
            echo "Error: Invalid image format.";
            exit();
        }
    }

    // Usar consulta preparada con PDO
    $sql = "INSERT INTO chollos (id_usuario, titulo_chollo, descripcion_chollo, precio_chollo, imagen_chollo, fecha_creacion) 
            VALUES (:user_id, :title, :description, :price, :imagePath, :fecha_creacion)";

    try {
        // Preparar y ejecutar la consulta
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':imagePath', $imagePath, PDO::PARAM_STR);
        $stmt->bindParam(':fecha_creacion', $fecha_creacion, PDO::PARAM_STR);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error: Unable to execute the query.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
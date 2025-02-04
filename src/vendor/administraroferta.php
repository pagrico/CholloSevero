<?php
include "../conexion/conexion.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['usuario'])) {
        die("Error: Usuario no ha iniciado sesión.");
    }

    // Asignar ID según el tipo de usuario
    if ($_SESSION['usuario'] === 'admin') {
        $user_id = 1; // ID del administrador
    } elseif ($_SESSION['usuario'] === 'usuario') {
        $user_id = 2; // ID del usuario normal
    } else {
        die("Error: Tipo de usuario no válido.");
    }

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
    $fecha_creacion = date("Y-m-d H:i:s");

    // Validación básica
    if (empty($title) || empty($description) || empty($price)) {
        die("Error: Todos los campos son obligatorios.");
    }

    if (!is_numeric($price) || $price < 0) {
        die("Error: El precio debe ser un número válido.");
    }

    // Manejo de imagen
    $imagePath = null;
    $copyPath = null;
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image'];
        $targetDir = "uploads/";
        $copyDir = "src/imagenes/";

        // Crear carpetas si no existen
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        if (!is_dir($copyDir)) {
            mkdir($copyDir, 0755, true);
        }

        $imageExtension = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));
        $imageName = time() . "_" . uniqid() . "." . $imageExtension;
        $imagePath = $targetDir . $imageName;
        $copyPath = $copyDir . $imageName;

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageExtension, $allowedTypes) && $image['size'] <= 2 * 1024 * 1024) { // Máx. 2MB
            if (move_uploaded_file($image["tmp_name"], $imagePath)) {
                // Copiar la imagen a src/imagenes/
                if (!copy($imagePath, $copyPath)) {
                    die("Error: No se pudo copiar la imagen a src/imagenes/");
                }
            } else {
                die("Error: No se pudo subir la imagen.");
            }
        } else {
            die("Error: Formato de imagen no válido o tamaño excesivo.");
        }
    }

    // Consulta preparada con PDO
    $sql = "INSERT INTO chollos (id_usuario, titulo_chollo, descripcion_chollo, precio_chollo, imagen_chollo, fecha_creacion) 
            VALUES (:user_id, :title, :description, :price, :imagePath, :fecha_creacion)";

    try {
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
            die("Error: No se pudo insertar el registro.");
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

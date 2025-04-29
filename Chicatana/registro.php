<?php
include 'conexion.php'; // Incluir archivo de conexión a la base de datos

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $correo = $_POST['correo'];

    // Validar si el usuario ya existe en la base de datos
    $sql = "SELECT * FROM usuarios WHERE usuario = :usuario OR correo = :correo LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $error = "El usuario o correo ya está registrado.";
    } else {
        // Hashear la contraseña antes de guardarla en la base de datos
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insertar el nuevo usuario en la base de datos
        $sql = "INSERT INTO usuarios (nombre, usuario, password, correo) VALUES (:nombre, :usuario, :password, :correo)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':correo', $correo);

        if ($stmt->execute()) {
            // Si la inserción es exitosa, redirigir al login o mostrar un mensaje
            header("Location: login.html");
            exit;
        } else {
            $error = "Hubo un error al registrar el usuario. Intenta nuevamente.";
        }
    }
}
?>

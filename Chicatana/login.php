<?php
session_start(); // Inicia la sesión para almacenar el usuario si se logea correctamente
include 'conexion.php'; // Incluir el archivo de conexión a la base de datos

// Verificamos si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturamos los datos enviados
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Preparamos la consulta SQL para buscar al usuario en la base de datos
    $sql = "SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->execute();

    // Comprobamos si el usuario existe
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // Verificamos si la contraseña es correcta
        if (password_verify($password, $user['password'])) {
            // Si las credenciales son correctas, iniciamos la sesión
            $_SESSION['usuario'] = $user['usuario'];
            header("Location: inicio.html"); // Redirigimos a la página de inicio
            exit;
        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "Usuario no encontrado";
    }
}
?>

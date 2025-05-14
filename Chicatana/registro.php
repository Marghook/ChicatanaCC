<?php
// Mostrar errores para depuración (quitar en producción)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluir archivo de conexión
require_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recoger datos del formulario
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Verificar si ya existe un usuario o correo igual
    $verificar = $conn->prepare("SELECT idusuario FROM usuario WHERE user = ? OR correo = ?");
    $verificar->bind_param("ss", $usuario, $correo);
    $verificar->execute();
    $verificar->store_result();

    if ($verificar->num_rows > 0) {
        // Mostrar alerta en HTML si ya existe
        echo "<script>
            alert('❌ El nombre de usuario o el correo ya están registrados.');
            window.history.back(); // Regresar al formulario
        </script>";
        $verificar->close();
        $conn->close();
        exit();
    }
    $verificar->close();

    // Insertar nuevo usuario
    $sql = "INSERT INTO usuario (nombre, user, correo, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssss", $nombre, $usuario, $correo, $password);
        if ($stmt->execute()) {
            // Redirigir a login.html si el registro fue exitoso
            header("Location: login.html");
            exit();
        } else {
            echo "<script>alert('❌ Error al registrar usuario: " . addslashes($stmt->error) . "'); window.history.back();</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('❌ Error al preparar la consulta.'); window.history.back();</script>";
    }

    $conn->close();
} else {
    echo "<script>alert('Acceso no válido.'); window.history.back();</script>";
}

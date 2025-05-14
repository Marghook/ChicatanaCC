<?php
// Mostrar errores para depuración (quitar en producción)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluir archivo de conexión
require_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    session_start();
    // Recoger datos del formulario
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    // Verificar si los campos están vacíos
    if (empty($usuario) || empty($password)) {
        echo "<script>alert('❌ Por favor, completa todos los campos.'); window.history.back();</script>";
        exit();
    }

    // Buscar usuario por nombre
    $verificar = $conn->prepare("SELECT idusuario, nombre, password FROM usuario WHERE user = ?");
    $verificar->bind_param("s", $usuario);
    $verificar->execute();
    $verificar->store_result();

    // Verificar si existe
    if ($verificar->num_rows === 1) {
        $verificar->bind_result($idusuario, $nombre, $hash);
        $verificar->fetch();
    }

    // Verificar la contraseña
    if (password_verify($password, $hash)) {
        // Guardar datos en la sesión
        $_SESSION['idusuario'] = $idusuario;
        $_SESSION['nombre'] = $nombre;  // Ahora se guarda correctamente
        $_SESSION['user'] = $usuario;
        header("Location: inicio.html");
        exit();
    }

    // Si la contraseña no es correcta
    echo "<script>
        alert('❌ El nombre de usuario o la contraseña son incorrectos.');
        window.history.back();
    </script>"; // Regresar al formulario

    $verificar->close();
    $conn->close();
} else {
    echo "<script>alert('Acceso no válido.'); window.history.back();</script>";
}
?>

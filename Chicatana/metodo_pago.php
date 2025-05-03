<?php
    include 'conexion.php'; // Incluir el archivo de conexión a la base de datos
    // Iniciar sesión
session_start();

// Validación al enviar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Aquí puedes conectar con base de datos y hacer validaciones reales
    // Este ejemplo usa credenciales fijas para ilustrar
    $usuario_valido = "admin";
    $password_valido = "12345";

    if ($usuario === $usuario_valido && $password === $password_valido) {
        $_SESSION['usuario'] = $usuario;
        header("Location: inicio.html"); // Redirige al usuario a la página principal
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>
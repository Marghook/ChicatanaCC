<?php
$host = "localhost";      // Dirección del servidor (localhost si es local)
$usuario = "root";        // Usuario de la base de datos
$contrasena = "";     // Contraseña del usuario
$base_datos = "chicatana_prueba"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($host, $usuario, $contrasena, $base_datos);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
    // echo "Conexión exitosa a la base de datos.";
}
?>

<?php
$host = "localhost";      // Dirección del servidor (localhost si es local)
$usuario = "root";        // Usuario de la base de datos
$contrasena = "mysql";     // Contraseña del usuario
$base_datos = "mi_base_datos"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Puedes usar esto para verificar que la conexión fue exitosa
// echo "Conexión exitosa a la base de datos.";
?>

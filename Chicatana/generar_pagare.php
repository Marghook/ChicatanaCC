<?php
// Incluir la conexión a la base de datos
include('conexion.php');

// Comprobar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar los datos del formulario
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $monto = $_POST['monto'];
    $fecha = $_POST['fecha'];

    // Consultar a la base de datos para insertar los datos del pagaré
    $sql = "INSERT INTO pagarés (nombre, direccion, telefono, monto, fecha)
            VALUES (:nombre, :direccion, :telefono, :monto, :fecha)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':monto', $monto);
    $stmt->bindParam(':fecha', $fecha);

    if ($stmt->execute()) {
        // Mostrar mensaje si se guardó correctamente
        echo "<p>Pagaré guardado exitosamente.</p>";
    } else {
        // Mostrar mensaje si ocurrió un error
        echo "<p>Hubo un error al guardar el pagaré.</p>";
    }
}
?>
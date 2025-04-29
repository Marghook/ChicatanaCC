<?php
// Incluir el archivo de conexión a la base de datos
include('conexion.php');

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $fecha = $_POST['fecha'];

    try {
        // Insertar los datos en la tabla 'invitado'
        $sql = "INSERT INTO invitado (nombre, apellido, telefono, correo, fecha)
                VALUES (:nombre, :apellido, :telefono, :correo, :fecha)";

        $stmt = $pdo->prepare($sql);

        // Vincular los parámetros a las variables
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':fecha', $fecha);

        // Ejecutar la consulta
        $stmt->execute();

        echo "Invitado agregado exitosamente.";

    } catch (PDOException $e) {
        echo "Error al agregar invitado: " . $e->getMessage();
    }
}
?>


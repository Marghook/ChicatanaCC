<?php
require_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $numero_tarjeta = $_POST['numero_tarjeta'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];
    $codigo_seguridad = $_POST['codigo_seguridad'];

    // Reemplaza esto con el ID de socio real, por ejemplo desde $_SESSION
    $id_socio = 1;

    try {
        $sql = "INSERT INTO historial_pagos (id_socio, nombre, numero_tarjeta, fecha_vencimiento, codigo_seguridad, fecha_pago)
                VALUES (:id_socio, :nombre, :numero_tarjeta, :fecha_vencimiento, :codigo_seguridad, NOW())";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_socio', $id_socio);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':numero_tarjeta', $numero_tarjeta);
        $stmt->bindParam(':fecha_vencimiento', $fecha_vencimiento);
        $stmt->bindParam(':codigo_seguridad', $codigo_seguridad);

        $stmt->execute();

        // Redirigir con mensaje de éxito
        header("Location: metodo_pago.html?exito=1");
        exit;
    } catch (PDOException $e) {
        // Puedes loguear el error y redirigir a una página de error si lo deseas
        echo "Error al procesar el pago: " . $e->getMessage();
    }
}
?>

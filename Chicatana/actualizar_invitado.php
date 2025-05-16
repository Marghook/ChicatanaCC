<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'conexion.php';

if (!isset($_SESSION['idusuario'])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idsocio  = $_POST['idsocio'];
    $nombre   = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $correo   = $_POST['correo'];
    $fecha       = $_POST['fecha'];

    // Iniciar transacción
    $conn->begin_transaction();

    try {
        // 1. Actualizar tabla familiar
        $sql_usuario = "UPDATE invitado SET nombre = ?, apellido = ?, telefono = ?, correo = ?, fecha = ?
        WHERE idsocio = ?";
        $stmt = $conn->prepare($sql_usuario);
        $stmt->bind_param("sssssi",$nombre,$apellido,$telefono,$correo,$fecha,$idsocio);
        $stmt->execute();

        // Confirmar la transacción
        $conn->commit();

        echo "<script>
            alert('✅ Datos actualizados correctamente.');
            window.location.href = 'invitados_socios.php';
        </script>";
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>alert('❌ Error al actualizar los datos: " . $e->getMessage() . "'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
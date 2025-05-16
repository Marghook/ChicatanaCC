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
    $idfam  = $_POST['idfamiliar'];
    $nombre   = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $ciudad   = $_POST['ciudad'];
    $cp       = $_POST['cp'];
    $colonia       = $_POST['colonia'];
    $num_casa = $_POST['num_casa'];
    $correo   = $_POST['correo'];
    $rfc      = $_POST['rfc'];

    // Iniciar transacción
    $conn->begin_transaction();

    try {
        // 1. Actualizar tabla familiar
        $sql_usuario = "UPDATE familiar SET nombre = ?, apellido = ?, telefono = ?, ciudad = ?, codigo_postal = ?,
        colonia = ?, num_casa = ?, correo = ?, rfc = ?  WHERE idfamiliar = ?";
        $stmt = $conn->prepare($sql_usuario);
        $stmt->bind_param("sssssssssi",$nombre,$apellido,$telefono,$ciudad,$cp,$colonia,$num_casa,$correo,$rfc,$idfam);
        $stmt->execute();

        // Confirmar la transacción
        $conn->commit();

        echo "<script>
            alert('✅ Datos actualizados correctamente.');
            window.location.href = 'familiares_socios.php';
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
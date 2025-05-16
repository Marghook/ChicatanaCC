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
    $usuario  = $_POST['idusuario'];
    $socio    = $_POST['idsocio'];
    $nombre   = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $ciudad   = $_POST['ciudad'];
    $cp       = $_POST['cp'];
    $colonia  = $_POST['colonia'];
    $num_casa = $_POST['numero_casa'];
    $correo   = $_POST['correo'];
    $rfc      = $_POST['rfc'];
    $password = $_POST['password'];

    // Iniciar transacción
    $conn->begin_transaction();

    // Hashear la nueva contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    try {
        // 1. Actualizar tabla usuario
        $sql_usuario = "UPDATE usuario SET nombre = ?, correo = ?, password = ? WHERE idusuario = ?";
        $stmt1 = $conn->prepare($sql_usuario);
        $stmt1->bind_param("sssi", $nombre, $correo, $password, $usuario);
        $stmt1->execute();

        // 2. actualizar socio
        $sql_socio = "UPDATE socio SET apellido = ?, telefono = ?, ciudad = ?, codigo_postal = ?, colonia = ?, num_casa = ?, rfc = ? WHERE iduser = ?";
        $stmt2 = $conn->prepare($sql_socio);
        $stmt2->bind_param("sssisssi", $apellido, $telefono, $ciudad, $cp, $colonia, $num_casa, $rfc, $usuario);
        $stmt2->execute();

        // Confirmar la transacción
        $conn->commit();

        echo "<script>
            alert('✅ Datos actualizados correctamente.');
            window.location.href = 'inicio_admin.html';
        </script>";
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>alert('❌ Error al actualizar los datos: " . $e->getMessage() . "'); window.history.back();</script>";
    }

    $stmt1->close();
    $stmt2->close();
    $conn->close();
}
?>
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
    $idpagare  = $_POST['idpagare'];
    $fecha = $_POST['fecha'];
    $cantidad   = $_POST['cantidad'];
    $pagos       = $_POST['pagos'];

    // Iniciar transacción
    $conn->begin_transaction();

    try {
        // 1. Actualizar tabla familiar
        $sql_pago = "UPDATE pago SET fecha_deuda = ?, cantidad = ?, pagos = ? WHERE idpagare = ?";
        $stmt = $conn->prepare($sql_pago);
        $stmt->bind_param("ssii",$fecha,$cantidad,$pagos,$idpagare);
        $stmt->execute();

        // Confirmar la transacción
        $conn->commit();

        echo "<script>
            alert('✅ Datos actualizados correctamente.');
            window.location.href = 'pagares_generados.php';
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
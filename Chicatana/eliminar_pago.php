<?php
session_start();
require_once 'conexion.php';

if(!isset($_SESSION['idusuario'])){
    hedader("Location:login.html");
    exit();
}

$idpago = $_GET['idpago'];

try{
$sql_eliminar = "DELETE FROM pago WHERE idpago = ?";
$stmt = $conn->prepare($sql_eliminar);
$stmt->bind_param("i",$idpago);
$stmt->execute();

echo "<script>
alert('✅ Datos actualizados correctamente.');
window.location.href = 'pagos_cuotas.php';
</script>";
exit();
} catch (Exception $e) {
    $conn->rollback();
    echo "<script>alert('❌ Error al actualizar los datos: " . $e->getMessage() . "'); window.history.back();</script>";
}
$stmt->close();
$conn->close();
?>
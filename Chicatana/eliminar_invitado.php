<?php
session_start();
require_once 'conexion.php';

if(!isset($_SESSION['idusuario'])){
    hedader("Location:login.html");
    exit();
}

$idinvitado = $_GET['idinvitado'];

try{
$sql_eliminar = "DELETE FROM invitado WHERE idinvitado = ?";
$stmt = $conn->prepare($sql_eliminar);
$stmt->bind_param("i",$idinvitado);
$stmt->execute();

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
?>
<?php
session_start();
require_once 'conexion.php';

if(!isset($_SESSION['idusuario'])){
    hedader("Location:login.html");
    exit();
}

$usuario = $_GET['idusuario'];

try{
$sql_eliminar = "DELETE FROM usuario WHERE idusuario = ?";
$stmt = $conn->prepare($sql_eliminar);
$stmt->bind_param("i",$usuario);
$stmt->execute();

echo "<script>
alert('✅ Datos actualizados correctamente.');
window.location.href = 'socios.php';
</script>";
exit();
} catch (Exception $e) {
    $conn->rollback();
    echo "<script>alert('❌ Error al actualizar los datos: " . $e->getMessage() . "'); window.history.back();</script>";
}
$stmt->close();
$conn->close();
?>
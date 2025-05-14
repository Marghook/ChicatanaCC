<?php
session_start();
require_once 'conexion.php';

if(!isset($_SESSION['idusuario'])){
    hedader("Location:login.html");
    exit();
}

$idfam = $_GET['idfamiliar'];

try{
$sql_eliminar = "DELETE FROM familiar WHERE idfamiliar = ?";
$stmt = $conn->prepare($sql_eliminar);
$stmt->bind_param("i",$idfam);
$stmt->execute();

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
?>
<?php
session_start();
require_once 'conexion.php';

if(!isset($_SESSION['idusuario'])){
    hedader("Location:login.html");
    exit();
}

$idpagare = $_GET['idpagare'];

try{
$sql_eliminar = "DELETE FROM pagare WHERE idpagare = ?";
$stmt = $conn->prepare($sql_eliminar);
$stmt->bind_param("i",$idpagare);
$stmt->execute();

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
?>
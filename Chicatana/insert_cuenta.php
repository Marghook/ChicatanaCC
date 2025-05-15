<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['idusuario'])){
    header("Location: login.html");
    exit();
}

//obtiene los datos del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $idsocio = $_POST['idsocio'];
    $tipo_consumidor = $_POST['tipo_consumidor'];
    $idconsumidor = $_POST['idconsumidor'];
    $desc = $_POST['desc'];
    $cantidad = $_POST['cantidad'];
    $pagado = $_POST['pagado'];
}

$sql_cuenta = "INSERT INTO familiar(idsocio,tipo_consumidor,idconsumidor,
descripcion, cantidad, fecha, pagado)
VALUES(?,?,?,?,?,?,?,?,?,?)";
$stmt = $conn->prepare($sql_cuenta);
$stmt->bind_param("isisisi",$idsocio,$consumidor,$nom_consume,$desc,$cantidad,$pagado);

if($stmt->execute()){

echo "<script>alert('✅ Datos añadidos correctamente.');
window.location.href = 'inicio.html';</script>";
} else{
    echo "Error al guardar: ".
    $stmt->error;
}

$stmt->close();
$conn->close();
?>
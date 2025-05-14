<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['idusuario'])){
    header("Location: login.html");
    exit();
}

$idusuario = $_SESSION['idusuario'];

//obtiene los datos del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $nombre     = $_POST['nombre'];
    $apellido   = $_POST['apellido'];
    $telefono   = $_POST['telefono'];
    $correo     = $_POST['correo'];
    $fecha      = $_POST['fecha'];
}

//consulta idsocio
$stmt = $conn->prepare("SELECT idsocio FROM socio WHERE iduser = ?");
$stmt->bind_param("i",$idusuario);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($idsocio);
$stmt->fetch();

$sql_invitado = "INSERT INTO invitado(idsocio,nombre,apellido,telefono,correo,fecha) 
VALUES(?,?,?,?,?,?)";
$stmt2 = $conn->prepare($sql_invitado);
$stmt2->bind_param("isssss",$idsocio,$nombre,$apellido,$telefono,$correo,$fecha);

if($stmt2->execute()){

echo "<script>alert('✅ Datos añadidos correctamente.');
window.location.href = 'inicio.html';</script>";
} else{
    echo "Error al guardar: ".
    $stmt2->error;
}

$stmt->close();
$stmt2->close();
$conn->close();

?>
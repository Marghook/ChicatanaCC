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
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $ciudad = $_POST['ciudad'];
    $cp = $_POST['cp'];
    $colonia = $_POST['colonia'];
    $numero_casa = $_POST['numero_casa'];
    $correo = $_POST['correo'];
    $rfc = $_POST['rfc'];
}

//consulta idsocio
$stmt = $conn->prepare("SELECT idsocio FROM socio WHERE iduser = ?");
$stmt->bind_param("i",$idusuario);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($idsocio);
$stmt->fetch();

$sql_familiar = "INSERT INTO familiar(idsocio,nombre,apellido,telefono,ciudad,codigo_postal,colonia,num_casa,correo,rfc) 
VALUES(?,?,?,?,?,?,?,?,?,?)";
$stmt2 = $conn->prepare($sql_familiar);
$stmt2->bind_param("isssssssss",$idsocio,$nombre,$apellido,$telefono,$ciudad,$cp,$colonia,$numero_casa,$correo,$rfc);

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
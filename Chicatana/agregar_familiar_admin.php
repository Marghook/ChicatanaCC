<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['idusuario'])){
    header("Location: login.html");
    exit();
}


//obtiene los datos del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $correo_socio = $_POST['correo_socio'];
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
$stmt = $conn->prepare("SELECT idusuario FROM usuario WHERE correo = ?");
$stmt->bind_param("s",$correo_socio);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($idusuario);
$stmt->fetch();

//consulta idsocio
$stmt2 = $conn->prepare("SELECT idsocio FROM socio WHERE iduser = ?");
$stmt2->bind_param("i",$idusuario);
$stmt2->execute();
$stmt2->store_result();
$stmt2->bind_result($idsocio);
$stmt2->fetch();

$sql_familiar = "INSERT INTO familiar(idsocio,nombre,apellido,telefono,ciudad,codigo_postal,colonia,num_casa,correo,rfc) 
VALUES(?,?,?,?,?,?,?,?,?,?)";
$stmt3 = $conn->prepare($sql_familiar);
$stmt3->bind_param("isssssssss",$idsocio,$nombre,$apellido,$telefono,$ciudad,$cp,$colonia,$numero_casa,$correo,$rfc);

if($stmt3->execute()){

echo "<script>alert('✅ Datos añadidos correctamente.');
window.location.href = 'inicio.html';</script>";
} else{
    echo "Error al guardar: ".
    $stmt3->error;
}

$stmt->close();
$stmt2->close();
$stmt3->close();
$conn->close();

?>